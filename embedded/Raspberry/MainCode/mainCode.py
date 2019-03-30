# import numpy as np
# import cv2
# import tensorflow
# import argparse
# import glob
# import math
# import threading
# from collections import Counter
# import multiprocessing as mp
import cv2
import base64
from class_CNN import NeuralNetwork
from class_PlateDetection import PlateDetector
import serial
from RFID import PyRfid
import stringdist  # thư viện so sánh dựa theo %
import requests
import json
import random
import string
from time import sleep
from playsound import playsound
import LicenseDetector
import math
# _________________________________________init camera plate detector
plateDetector = PlateDetector(type_of_plate='RECT_PLATE', minPlateArea=3000, maxPlateArea=30000) # Initialize the plate detector
myNetwork = NeuralNetwork(modelFile="model/v3.pb", labelFile="model/v2.txt") # Initialize the Neural Network
coordinates = (0, 0)
plates_value = []
plates_length = []
processes = []
input_segmments = []
i = 0 
#____________________________________________________________________
baseUrl = "http://vwms.gourl.pro/api/"
arduinoPort = "COM3"
rfidPort = "COM6"

weight = "0"
maxLoad = "0"

transactionId = ""
botId = "TRAMCAN_01"
cameraPlate = ""
rfidPlate = ""
plate = ""
imagePath = "captured.jpg"
ser = serial.Serial(port=arduinoPort, baudrate=9600, parity=serial.PARITY_NONE,stopbits=serial.STOPBITS_ONE, bytesize=serial.EIGHTBITS, timeout=1)
# define command
SendWeight = 1
Notification = 2
SendPlateMaxweight = 3
status = 4
# end define command

# def recieveWeight(weight):
#     return float(weight)

def sendCommand(command, body):
    # return True #simulation result
    # ser = serial.Serial(port=arduinoPort, baudrate=9600, parity=serial.PARITY_NONE,stopbits=serial.STOPBITS_ONE, bytesize=serial.EIGHTBITS, timeout=1)
    data = str(command)+'|'+body
    print("Raspberry's sended : ",data)
    sleep(1)

    ser.write(data.encode())
    sleep(1)
    ser.flush()
    # ser.close()
    return True
    
def readWeight():
    # return "10" #simulation data
    # ser = serial.Serial(port=arduinoPort, baudrate=9600, parity=serial.PARITY_NONE,stopbits=serial.STOPBITS_ONE, bytesize=serial.EIGHTBITS, timeout=1)
    # print("connect to: ",ser.portstr)
    value = '0'
    while True:
        received = ser.readline().decode().rstrip()
        # print(received)
        if (len(received) != 0 and (received[0] in '1')):
            value = received[2:]
            break
    # ser.close()
    return float(value)


def readCard():
    # return "12345"  # virtual return

    try:
        rfid = PyRfid(rfidPort, 9600)
        print('Waiting for tag...\n')
        rfid.readTag()
        print('Tag Id:' + rfid.tagIdFloat)
        return rfid.tagIdFloat
    except Exception as e:
        print('[Exception] ' + str(e))
        return 'Null'


def getCameraPlate():
    cameraPlate = LicenseDetector.imageDetector()
    if cameraPlate != None:
        return cameraPlate
    else:
        return None
def waitingforNextTransaction():
    while True:
        received = ser.readline().decode().rstrip()

        if (len(received) >1 and received in 'next'):
            print("next Value: ",received)
            break

def comparePlateInfo(RfidPlate, CameraPlate):
    # return True #simulation result
    # kiem tra % giong nhau giua 2 bien so, neu >80% thi return true, neu k duoc return false
    # print("So sanh:",RfidPlate,CameraPlate)
    result = stringdist.levenshtein(RfidPlate, str(CameraPlate))
    print("Ket qua so sanh bien so:",result)
    if int(result) < 3:
        return True
    else:
        return False


def getTransactionInfo(transactionId):
    # print("TransactionID:"+transactionId)
    query = {'transactionId': str(transactionId)}
    res = requests.get(baseUrl+'transaction/get-transaction', params=query)
    result = json.loads(res.text)
    # print("transaction status:"+str(result["status"]))
    if ("3" in str(result["status"])):
        print(".",end=' ')
        return False
    else:
        getInfoFromServer(str(result["vehicle_id"]))
        return True


def getInfoFromServer(cardId):
    # return False #simulation result
    query = {'tagId': str(cardId)}
    try:
        res = requests.get(baseUrl+'vehicle/get-plate-by-tag-id', params=query)
        print(res.url)
        result = json.loads(res.text)
        global rfidPlate
        global maxLoad
        rfidPlate = result["license_plates"]
        if len(rfidPlate) >0:
            rfidPlate = str(rfidPlate).replace('-','')

        print("Bien so: "+ rfidPlate)
        maxLoad = str(result["vehicle_maxload"])
        print("Max load: "+str(maxLoad))
        return True
    except Exception:
        print("Can not get information from server")
        return False





def SendTransactionToServer(tagId, transactionId, status, weight, botId):
    image = cv2.imread("captured.jpg",(-1))
    # cv2.imshow('f',image)
    # cv2.waitKey(0)
    # cv2.destroyAllWindows()
    retval, buffer = cv2.imencode('.jpg', image)
    imageAsTest = base64.b64encode(buffer)
    data = {"id":transactionId,"vehicle_weight":str(weight),"img":imageAsTest,"vehicle_id":tagId,"station_id":botId,"status":str(status),"unit":"tấn"}
    try:
        res = requests.post(baseUrl+'transaction/submit-transaction',data)
        # print("url: "+res.url)
        print("return: "+res.text)
        print("Send transaction done!")
        # print("response code: "+ str(res.status_code))
        return True
    except Exception:
        print("Can not send transaction info to server")
        return False
def processUndefinedInfo():
    print("Start processing anonymous transaction:")
    sendCommand(Notification, "errorIdentify") #can not detect tag
    playsound('audio/moidoitronggiaylat.mp3')

    SendTransactionToServer("Null",transactionId,3,weight,botId)
    print("Get transaction info:",end='')
    while(True):
        # global transactionId
        if(getTransactionInfo(transactionId)) == True:
            plate=rfidPlate
            break
        else:
            # print('.', end=" ")
            sleep(3)  # sleep 3 second
    print("Finish transaction: "+transactionId)
    sendCommand(SendPlateMaxweight, plate+'|'+maxLoad)
    # sleep(5)
def createTransactionID():
    size=14
    chars=string.ascii_uppercase + string.digits
    return ''.join(random.choice(chars) for _ in range(size))

if __name__=="__main__":
    while (True):
        transactionId =  createTransactionID()
        print("Start transaction:",transactionId)
        playsound('audio/moixevaotram.mp3')
        if(float(weight) < 1):
            weight = readWeight()
            print("Trong tai cua xe:",weight)
            playsound('audio/moiquetthe.mp3')
            tagId = readCard()
            print("tagID: "+tagId)

            # weight = '40' #simulation code
        cameraPlate = getCameraPlate()
        print("bien so tu camera:",cameraPlate)
        # if(tagId != 'Null'):
        i = 1
        while(True):
            getInfoFromServer(tagId)
            if(getInfoFromServer(tagId)):  # kiểm tra xem có tagId có trong db không
                # So sanh bien so tu server va bien so tu camera
                # if(True):
                if(comparePlateInfo(rfidPlate, cameraPlate)):
                    plate = rfidPlate  # su dung bien so tu rfid lam bien so chinh thuc
                    print("Hoàn thành cân!")
                    sendCommand(SendPlateMaxweight, plate+'|'+maxLoad)
                    if (float(weight) <= float(maxLoad)):
                        # playsound('audio/moiditiep.mp3')
                        SendTransactionToServer(tagId, transactionId, "1",weight, botId)
                    else:
                        # playsound('audio/moihatai.mp3')
                        SendTransactionToServer(tagId, transactionId, "2",weight, botId)
                else:
                    processUndefinedInfo()
                    print("done!")
                if(float(weight) <= float(maxLoad)):
                    sendCommand(status, 'done')
                    playsound('audio/moiditiep.mp3')

                else:
                    print("Xe qua tai")
                    sendCommand(status, 'overLoad')
                    playsound('audio/moihatai.mp3')

                weight = "0"
                break
            else:  # không có tagId trong db
                # cho thử lại 3 lần
                print("Can not found tagID: "+tagId+" in server")
                sendCommand(Notification, "canNotIdentify")
                
                if(i > 2):
                    processUndefinedInfo()
                    if(float(weight) <= float(maxLoad)):
                        sendCommand(status, 'done')
                        playsound('audio/moiditiep.mp3')
                    else:
                        playsound('audio/moihatai.mp3')
                        sendCommand(status, 'overLoad')
                        # weight = "0"
                    break
                else:
                    playsound('audio/moithulai.mp3')
                # sleep(5)
                tagId = readCard()
                i = i+1
        tagId=""
        weight="0"
        waitingforNextTransaction()
        # print("done")



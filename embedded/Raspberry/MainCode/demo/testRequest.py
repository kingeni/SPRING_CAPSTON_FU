import requests
import json

baseUrl ="http://vwms.gourl.pro/api/"
def getInfoFromServer(cardId):
    query= {'tagId':str(cardId)}
    try:
        res = requests.get(baseUrl+'vehicle/get-plate-by-tag-id',params=query)
        # print(res.url)
        a= json.loads(res.text)
        rfidPlate = a["license_plates"]
        maxLoad = a["vehicle_maxload"]
        print(rfidPlate)
        print(maxLoad)
        return True
    except Exception:
        print("Can not get information from server")
        return False
    

def SendTransactionToServer(tagId, transactionId, status, weight, image, botId,unit):
    # query= {'tagId':str(cardId)}
    data = {"id":transactionId,"vehicle_weight":weight,"img":image,"vehicle_id":tagId,"station_id":botId,"status":status,"unit":unit}
    try:
        res = requests.post(baseUrl+'transaction/submit-transaction',data)
        print("url: "+res.url)
        print("return: "+res.text)
        print("response code: "+ str(res.status_code))
        return True
    except Exception:
        # print(exec)
        print("Can not get information from server")
        return False    

# getInfoFromServer("1231233112")
SendTransactionToServer("1234567890",'testtrans',"3","20","image","TRAMCAN_01","tấn")
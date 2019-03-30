import serial
import time


ser = serial.Serial(port='COM5',baudrate=9600,parity=serial.PARITY_NONE,stopbits=serial.STOPBITS_ONE,bytesize=serial.EIGHTBITS,timeout=1)
print("connect to: ", ser.portstr)
value = ''
# time.sleep( 5 )
while True:
    recieved = ser.readline().decode().rstrip()
    print(recieved)

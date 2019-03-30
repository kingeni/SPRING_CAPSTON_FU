rfidPort = "COM9"
from RFID import PyRfid
def readCard():
    # return "123123311233"  # virtual return

    try:
        rfid = PyRfid(rfidPort, 9600)
        print('Waiting for tag...\n')
        rfid.readTag()
        print('Tag Id:', rfid.tagId)
        return rfid.tagIdFloat
    except Exception as e:
        print('[Exception] ' + str(e))
        return 'Null'

i=0
while i<10:
    if(readCard()):
        i+=1
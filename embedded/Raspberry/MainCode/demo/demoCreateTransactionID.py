import string
import random
def createTransactionID():
    size=14
    chars=string.ascii_uppercase + string.digits
    return ''.join(random.choice(chars) for _ in range(size))


print(createTransactionID())
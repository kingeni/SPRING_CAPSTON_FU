import os, random
import cv2, argparse
import numpy as np

def image_augmentation(img, type2=False):
    # perspective
    w, h, _ = img.shape
    pts1 = np.float32([[0, 0], [0, w], [h, 0], [h, w]])
    # 좌표의 이동점
    begin, end = 30, 90
    pts2 = np.float32([[random.randint(begin, end), random.randint(begin, end)],
                       [random.randint(begin, end), w - random.randint(begin, end)],
                       [h - random.randint(begin, end), random.randint(begin, end)],
                       [h - random.randint(begin, end), w - random.randint(begin, end)]])
    M = cv2.getPerspectiveTransform(pts1, pts2)

    img = cv2.warpPerspective(img, M, (h, w))

    # Brightness
    img = cv2.cvtColor(img, cv2.COLOR_RGB2HSV)
    img = np.array(img, dtype=np.float64)
    random_bright = .4 + np.random.uniform()
    img[:, :, 2] = img[:, :, 2] * random_bright
    img[:, :, 2][img[:, :, 2] > 255] = 255
    img = np.array(img, dtype=np.uint8)
    img = cv2.cvtColor(img, cv2.COLOR_HSV2RGB)

    # Blur
    blur_value = random.randint(0,4) * 2 + 1
    img = cv2.blur(img,(blur_value, blur_value))
    if type2:
        return img[130:280, 180:600, :]
    return img[130:280, 120:660, :]


class ImageGenerator:
    def __init__(self, save_path):
        self.save_path = save_path
        # Plate
        self.plate = cv2.imread("plate.jpg")
        self.plate2 = cv2.imread("plate_y.jpg")
        self.plate3 = cv2.imread("plate_g.jpg")

        # loading Number ====================  white-one-line  ==========================
        file_path = ".\\num\\"
        file_list = os.listdir(file_path)
        self.Number = list()
        self.number_list = list()
        for file in file_list:
            img_path = os.path.join(file_path, file)
            img = cv2.imread(img_path)
            self.Number.append(img)
            self.number_list.append(file[0:-4])

        # loading Char
        file_path = ".\\char1\\"
        file_list = os.listdir(file_path)
        self.char_list = list()
        self.Char1 = list()
        for file in file_list:
            img_path = os.path.join(file_path, file)
            img = cv2.imread(img_path)
            self.Char1.append(img)
            self.char_list.append(file[0:-4])

    def GeneratePlate(self, num, save=False):
        number1 = [cv2.resize(number, (60, 65)) for number in self.Number]
        number2 = [cv2.resize(number, (60, 65)) for number in self.Number]
        char = [cv2.resize(char1, (60, 65)) for char1 in self.Char1]

        for i, Iter in enumerate(range(num)):
            Plate = cv2.resize(self.plate, (336, 170))
            random_width, random_height =  400, 800
            random_R, random_G, random_B = random.randint(0, 255), random.randint(0, 255), random.randint(0, 255)
            background = np.zeros((random_width, random_height, 3), np.uint8)
            cv2.rectangle(background, (0, 0), (random_height, random_width), (random_R, random_G, random_B), -1)
            label = ""

            # row -> y , col -> x
            row, col = 15, 78

            # number 1
            rand_int = random.randint(0, 9)
            label += self.number_list[rand_int]
            Plate[row:row + 65, col:col + 60, :] = number1[rand_int]
            col += 60

            # number 2
            rand_int = random.randint(0, 9)
            label += self.number_list[rand_int]
            Plate[row:row + 65, col:col + 60, :] = number1[rand_int]
            col += 60

            # character 3
            label += self.char_list[i%18] #tong cong 18 ky tu dang ky
            Plate[row:row + 65, col:col + 60, :] = char[i%18]
            row, col = 82, 48

            # number 4
            rand_int = random.randint(0, 9)
            label += self.number_list[rand_int]
            Plate[row:row + 65, col:col + 60, :] = number2[rand_int]
            col += 60


            # number 5
            rand_int = random.randint(0, 9)
            label += self.number_list[rand_int]
            Plate[row:row + 65, col:col + 60, :] = number2[rand_int]
            col += 60

            # number 6
            rand_int = random.randint(0, 9)
            label += self.number_list[rand_int]
            Plate[row:row + 65, col:col + 60, :] = number2[rand_int]
            col += 60

            # number 7
            rand_int = random.randint(0, 9)
            label += self.number_list[rand_int]
            Plate[row:row + 65, col:col + 60, :] = number2[rand_int]

            s_width, s_height = int((400 - 170) / 2), int((800 - 336) / 2)
            background[s_width:170 + s_width, s_height:336 + s_height, :] = Plate

            background = image_augmentation(background, type2=True)

            if save:
                print("save: ",self.save_path + label + ".jpg")
                cv2.imwrite(self.save_path + label + ".jpg", background)
            else:
                cv2.imshow(label, background)
                cv2.waitKey(0)
                cv2.destroyAllWindows()


parser = argparse.ArgumentParser()
parser.add_argument("-i", "--img_dir", help="save image directory",
                    type=str, default="D:\\Google Drive\\job\\Do an\\Raspberry\\bienSo\\generate plate\\data\\")
parser.add_argument("-n", "--num", help="number of image",
                    type=int,default=20)
parser.add_argument("-s", "--save", help="save or imshow",
                    type=bool, default=True)
args = parser.parse_args()


img_dir = args.img_dir
A = ImageGenerator(img_dir)

num_img = args.num
Save = args.save

A.GeneratePlate(num_img, save=Save)
print("Finish!")

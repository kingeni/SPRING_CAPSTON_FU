import cv2
import numpy as np 
import os
from sklearn.neighbors import KNeighborsClassifier
from sklearn.externals import joblib
train_folder = 'Train'
train_data = [] #data for training
labels = []    #LABELS OF DATA

real_label = {}
# training model
for class_ in os.listdir(train_folder):
    [this_class,this_label] = class_.split('.')
    class_folder = os.path.join(train_folder,class_)
    real_label[int(this_class)]=this_label
    for img_name in os.listdir(class_folder):
        img_path = os.path.join(class_folder,img_name)
        img = cv2.imread(img_path,0)
        img = np.reshape(np.array(img),-1)
        # cv2.imwrite('name.jpg',img)
        # break
        train_data.append(img) 
        labels.append(int(this_class))
print('loading Data Done !!!')

neigh = KNeighborsClassifier(n_neighbors = 1)
neigh.fit(train_data,labels)
joblib.dump(neigh, 'Model.pkl') 
print("trainning done!")
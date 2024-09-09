import pandas as pd
import sys
import json
import tensorflow as tf
from tensorflow import keras
from keras.preprocessing.image import ImageDataGenerator
from keras.applications import DenseNet169
from keras import layers, models, optimizers
from sklearn.metrics import confusion_matrix, classification_report
import numpy as np
from keras.models import load_model
from keras.preprocessing import image
import matplotlib.pyplot as plt
import os
from PIL import Image
import numpy as np
import base64
import io

def get_label_text(index): #memilih label teks yang sesuai dengan nomor indeks yang diberikan
    class_labels = ['cardboard', 'glass', 'metal', 'paper', 'plastic', 'trash']
    return class_labels[index]

def load_and_process_image(img_path): #preprocessing
    try:
        img = image.load_img(img_path, target_size=(224, 224))
        return img
    except Exception as e:
        print("Error:", e)
        return None
    
def predict_answer(gambar): #modelnya
    sys.stdout = open(os.devnull, 'w')
    os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'
    model_path = 'AI/densenet169bg.h5'
    model = load_model(model_path)
    folder_path  = 'AI/testing2/' 

    array_result = []
    # Loop through each image file
    # for file_name in image_files:
    # Construct the full path to the image
    img_path = os.path.join(folder_path, gambar.strip("'"))
    # Memproses gambar
    img = load_and_process_image(img_path)
    img_array = np.array(img)  # Mengonversi gambar menjadi array
    img_array = np.expand_dims(img_array, axis=0)  # Menambahkan dimensi batch
    img_array = img_array.astype('float32') / 255.0  # Normalisasi nilai pixel  
    # Melakukan prediksi menggunakan model
    prediction = model.predict(img_array)
    predicted_class = np.argmax(prediction)
    predicted_label = get_label_text(predicted_class)
    class_probabilities = prediction[0]
    prediction_label = []
    prediction_result = []
    for i, prob in enumerate(class_probabilities):
        prediction_label.append(get_label_text(i))
        prediction_result.append(prob.tolist())
    result = {"result": predicted_label,"prediction_labels":prediction_label,"prediction_results":prediction_result}
    array_result.append(result)
    # Menampilkan hasil prediksi
    sys.stdout = sys.__stdout__

    return json.dumps(array_result[0]) #mengubah ke json
gambar = sys.argv[1]
result = predict_answer(gambar)
print(result)
sys.stdout.flush()

from flask import Flask, jsonify
import random
import tensorflow as tf
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dense
from tensorflow.keras.optimizers import Adam, SGD
app = Flask(__name__)
import pandas as pd


@app.route('/')
def index():
    new_model = Sequential()
    new_model.add(Dense(1, input_dim=1))
    new_model.compile(Adam(lr=0.8), 'mean_squared_error')
    new_model.load_weights('C:/Users/Mazen/Desktop/ThikaHackathon2020/Model/weights.h5')
    data = pd.read_csv("C:/Users/Mazen/Desktop/ThikaHackathon2020/Model/test-data.csv")

    X = data[['test1']].values[0]
    Y_predict = new_model.predict(X)
    
    result = Y_predict[0]
    print(result)
    return jsonify({'score':str(result[0])})

app.run(host='0.0.0.0')

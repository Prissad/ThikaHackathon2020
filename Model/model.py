from keras.models import Sequential
from keras.layers import Dense
from keras.optimizers import Adam, SGD
import numpy as np
import pandas as pd
import matplotlib.pyplot as plt

data = pd.read_csv("C:/Users/Mazen/Desktop/ThikaHackathon2020/Model/test-data.csv")

X = data[['test1']].values
Y = data[['test2']].values

model = Sequential()
model.add(Dense(1, input_dim=1))

model.compile(Adam(lr=0.8), 'mean_squared_error')
model.fit(X, Y, epochs=50)

model.save_weights('C:/Users/Mazen/Desktop/ThikaHackathon2020/Model/weights.h5')
from flask import Flask, app, render_template, request, flash
from wtforms import Form, FloatField, SubmitField, validators, ValidationError
import numpy as np
import joblib
from sklearn.metrics import mean_absolute_error
import pandas as pd
    
def predict(parameters):
    model = joblib.load('koloke.pkl')
    # params = parameters.reshape(1,-1)
    pred = model.predict(parameters)
    return pred

# def getName(label):
#     # print(label)
#     if label == 'Iris-setosa':
#         return "Iris Setosa"
#     elif label == 'Iris-versicolor': 
#         return "Iris Versicolor"
#     elif label == 'Iris-virginica': 
#         return "Iris Virginica"
#     else: 
#         return "成功"
    
app = Flask(__name__)
app.config.from_object(__name__)
app.config['SECRET_KEY'] = 'zJe09C5c3tMf5FnNL09C5d6SAzZoY'
    
class IrisForm(Form):
    SepalLength = FloatField("日にち(1月3日 = 103)",
                     [validators.InputRequired("この項目は入力必須です"),
                     validators.NumberRange(min=0, max=1231)])

    SepalWidth  = FloatField("天候(0 =曇り 1 = 晴れ 2 = 雨)",
                     [validators.InputRequired("この項目は入力必須です"),
                     validators.NumberRange(min=0, max=50)])

    PetalLength = FloatField("最高気温",
                     [validators.InputRequired("この項目は入力必須です"),
                     validators.NumberRange(min=0, max=50)])

    PetalWidth  = FloatField("最低気温",
                     [validators.InputRequired("この項目は入力必須です"),
                     validators.NumberRange(min=0, max=50)])
    
    syouhinbangou  = FloatField("商品番号",
                     [validators.InputRequired("この項目は入力必須です"),
                     validators.NumberRange(min=0, max=50)])
    # html側で表示するsubmitボタンの表示
    submit = SubmitField("判定")

@app.route('/', methods = ['GET', 'POST'])
def predicts():
    form = IrisForm(request.form)
    if request.method == 'POST':
        if form.validate() == False:
            flash("全て入力する必要があります。")
            return render_template('index.php', form=form)
        else:            
            SepalLength = float(request.form["SepalLength"])            
            SepalWidth  = float(request.form["SepalWidth"])            
            PetalLength = float(request.form["PetalLength"])            
            PetalWidth  = float(request.form["PetalWidth"])
            syouhinbangou  = float(request.form["syouhinbangou"])
            
            x = [[SepalLength, SepalWidth, PetalLength, PetalWidth,syouhinbangou]]
            pred = predict(x)
            irisName = pred
            return render_template('result.html', irisName=irisName)
    elif request.method == 'GET':
        return render_template('index.php', form=form)

if __name__ == "__main__":
    app.run()
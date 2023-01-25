<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <title>商品番号記入</title>
</head>
<body>
    <!-- ここにコンテンツを記述する -->
      <style>
        #wrapper {
           text-align: center;
        }
        #fle{
         display:none;
        }
      </style>
              <div id="wrapper">
                 <div id="fle">
                  {% for message in form.SepalLength.errors %}
                     <div>{{ message }}</div>
                  {% endfor %}
         
                  {% for message in form.SepalWidth.errors %}
                     <div>{{ message }}</div>
                  {% endfor %}
         
                  {% for message in form.PetalLength.errors %}
                     <div>{{ message }}</div>
                  {% endfor %}
         
                  {% for message in form.PetalWidth.errors %}
                     <div>{{ message }}</div>
                  {% endfor %}

                  {% for message in form.syouhinbangou.errors %}
                     <div>{{ message }}</div>
                  {% endfor %}
                 </div>
        
                 <form method="post">
                    {{ form.SepalLength.label }}<br>
                    {{ form.SepalLength }}
                    <br>
                    {{ form.SepalWidth.label }}<br>
                    {{ form.SepalWidth }}
                    <br>
                    {{ form.PetalLength.label }}<br>
                    {{ form.PetalLength }}
                    <br>
                    {{ form.PetalWidth.label }}<br>
                    {{ form.PetalWidth }}
                    <br>
                    {{ form.syouhinbangou.label }}<br>
                    {{ form.syouhinbangou }}
                    <br>
                    {{ form.submit }}
                 </form>
              </div>

   <a href="http://localhost/SK1A有村優希/home.html">戻る</a>
</body>
</html>

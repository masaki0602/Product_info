# Product_info
商品情報をデータベースを使って管理するサイトです。

もう一つの機能として.pklを使用し商品がその日売れる数を予想してくれます。

## 特徴
・誰でも簡単に商品情報を管理することができる。

・予想することで廃棄する商品の量を軽減できる。

## 使用方法

### ステップ１開発環境使用するデータベースで下記を使用しテーブル名[FLAY]を作成してください。

```mysql
CREATE TABLE FLAY(
  PRODUCT_NO CHAR(4),
  PNAME VARCHAR(100),
  PRICE INT(4),
  UNIQUE(PRODUCT_NO),
  UNIQUE(PNAME)
);

INSERT INTO FLAY VALUES(1,'コロッケ','298');

```

### ステップ２

add1.php , dele.php , hen.php , hensyu.php , kakikae.php , kousin.php

上記のファイルのコードを変えてください。

```php
define( "DB_HOST", "localhost" );
define( "DB_USER", "" );
define( "DB_PASS", "" );
define( "DB_NAME", "" );
define( "DB_CHARSET", "utf8mb4" );
```
""の場所を使用するデータベースの情報に書き換えてください

DB_USER = ユーザー名

DB_PASS = パスワード

DB_NAME = データベース名

### ステップ３
Pythonを使用する時にFlaskを使用するのでインストールしてください。

```
pip install flask
```

## 開発環境

使用言語：python、javascript、php

IDE：Visual Studio Code

DB：MySQL

### バージョン
Python 3.8.6

Javascript v16.14.2

Flask 2.0.2

PHP 7.4.23











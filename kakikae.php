<?php

/**
* @author 有村優希
* @package SK1A
*/

/*****定数定義*****/
define( "DB_HOST", "localhost" );
define( "DB_USER", "masaki" );
define( "DB_PASS", "2003" );
define( "DB_NAME", "kozin" );
define( "DB_CHARSET", "utf8mb4" );

/*結果格納用配列 */
$result = [
  "status" => false,
  "message" => "現在システムを利用することができません",
  "result" => []
];

$getdata = filter_input_array(INPUT_GET);
$instance = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
if( ! $instance -> connect_error ) {
  //正常に接続できた場合の処理
  $instance->set_charset(DB_CHARSET);
  $where = ""; //wher句を格納するための変数
  if( isset($getdata["name"])&& $getdata["name"] != "") {
    $getdata["name"] = $instance -> escape_string( $getdata["name"] );
    $where = " WHERE PRODUCT_NO = '{$getdata["name"]}'";
  }
  $sql = "SELECT * FROM FLAY{$where} ORDER BY PRODUCT_NO ASC";
  if($kekka = $instance -> query($sql)){
    $result["status"] = true;
    while( $row = $kekka -> fetch_array( MYSQLI_ASSOC ) ) {
      $result[ "result" ][]= $row;
    }
    //var_dump($result);
    $kekka -> close();
  }
  $instance -> close();
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- link -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link href="css/sen.css" rel="stylesheet">
  <title>商品表</title>
</head>
<body class="bg-gray-50">
<div class="wrapper box-border">

<main>
  <div class="container mx-auto py-20">
    <div class="flex justify-between items-end border-b-2 border-green-400 pb-3 mb-10">
      <h1 class="dai">登録商品一覧</h1>
      <a href="add.php" class="ab">新規登録</a>
      <a href="home.html" class="ab">戻る</a>
      <a href="kakikae.php" class="ab">全表示</a>
    </div>

    <div class="flex justify-between items-start">

      <div class="w-3/12 h-80 p-5 shadow-md">
        <form action="kakikae.php" method="GET" class="h-full">

        <div class="flex flex-col justify-between h-full">
          <div>
            <div class="border-b border-gray-300 border-dashed mb-4 pb-6">
              <label for="name" class="textS">商品番号</label>
              <input type="text" name="name" id="name" class="inText" value="" placeholder="商品番号(入力したらEnter)">
            </div>
          </div>

          <div class="flex justify-center">
            <button type="submit" class="button">検索</button>
          </div>
        </div>

        </form>
      </div>

    <!-- 成功した時のHTML -->
    <?php if($result["status"]): ?>
      <div class="w-8/12">  

        <table class="w-full table-fixed">
          <thead>
            <tr class="ss">
              <th class="w-2/12 h-6 font-medium px-6 py-3">商品番号</th>
              <th class="w-6/12 h-6 font-medium px-6 py-3">商品名</th>
              <th class="w-2/12 h-6 font-medium px-6 py-3">値段</th>
              <th class="w-2/12 h-6 text-center font-medium px-6 py-3">
                詳細
              </th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($result["result"] as $product): ?>
            <tr class="kk">
              <td class="icon bird" id="mae"><?= $product["PRODUCT_NO"]?></td>
              <td id="mae"><?= $product["PNAME"]?></td>
              <td id="mae"><?= $product["PRICE"]?></td>
              <td id="mae1">
                <a href="hen.php?product_no=<?=$product["PRODUCT_NO"]?>" id="block">詳細</a>
              </td>
            </tr>
          <?php endforeach ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
    <!-- 失敗した時のHTML -->
      <div>
        <p class="text-xl"><?= $result["message"] ?></p>
      </div>
    <?php endif ?>
    </div>

  </div><!--/.container-->
</main>

</div><!--/.wrapper-->
<script src="javascript/home.js"></script>
<div id="page_top"><a href="#">TOP</a></div>
</body>
</html>
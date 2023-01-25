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

$result = [
  "status" => false,
  "message" => "現在システムを利用することができません",
  "result" => []
];

$getdata = filter_input_array(INPUT_GET);

if(empty($getdata)){
  header('location:kakikae.php');
}
$instance = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
if(!$instance -> connect_error) {
    //正常に接続できた場合の処理
    $instance->set_charset(DB_CHARSET);
    $sql = "SELECT * FROM FLAY WHERE PRODUCT_NO = ?";
    if($stmt = $instance -> prepare($sql)){
      $stmt -> bind_param("i",$getdata["product_no"]);
      $stmt -> execute();
      $kekka = $stmt->get_result();
    }
    if($kekka -> num_rows){
      $result["status"] = true;
      while($row = $kekka -> fetch_array(MYSQLI_ASSOC)){
        $result["result"] = $row;
      }
      $kekka -> close();
    }else{
      $result["status"] = false;
      $result["message"] = "該当する商品はありません";
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
  <link href="css/sen.css" rel="stylesheet">
  
  <title>詳細</title>
</head>
<body class="bg-gray-50">
<div class="wrapper box-border">


<main>
  <div class="container mx-auto py-20">

    <h1>商品の詳細</h1>
  
    <!-- 成功した時のHTML -->
    <?php if($result["status"]): ?>
    <div class="product-wrap px-5 py-10 shadow-md">
      <h4 class="media">商品情報</h4>
            <table>
                <tr class="ss">
                    <th>商品番号</th>
                    <th>値段</th>
                    <th>商品名</th>
                </tr>

                <tr class="kk">
                    <td class="icon bird"><?=$result["result"]["PRODUCT_NO"]?></td>
                    <td><?=$result["result"]["PRICE"]?></td>
                    <td><?=$result["result"]["PNAME"]?></td>
                </tr>
            </table>
    <!-- 失敗した時のHTML -->
    <?php else: ?>
      <p class="text-xl"><?=$result["message"]?></p>
    <!--/.container-->
  <?php endif ?>
  <div class="maa">
  </div>
  <a href="kakikae.php" class="ab">戻る</a>
  <a href="hensyu.php?product_no=<?= $getdata["product_no"]?>" class="ab">編集する</a>
  <form action="dele.php" method="POST">
    <div class="migi">
      <input type="hidden" name="product_no" value="<?= $getdata['product_no'] ?>">
      <button type="submit" class="ab1">削除する</button>
    </div>
  </form>
</main>
    <!--/.wrapper-->
</body>
</html>
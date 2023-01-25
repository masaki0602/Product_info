<?php
/*
 * 
 * @author 有村優希
 * @package SK1A
 */

 //セッションデータ保存用変数
 $errmessage = "";
 if(isset($_SESSION["errmessage"])){
   $errmessage = $_SESSION["errmessage"];
 }

 $_SESSION = [];
//  $category = array("ピザ","ドリンク");

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

if(in_array(NULL,$getdata,true)){
  header('location:kakikae.php');
}

$instance = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );

if(!$instance -> connect_error){
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
  }else{
    $result["status"] = false;
    $result["message"] = "該当する商品はありません";
  }
  $kekka -> close();
  $stmt -> close();
}
$instance -> close();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- link -->
  <link href="css/sen.css" rel="stylesheet">
  
  <title>php1 - kadai09_1</title>
</head>
<body class="bg-gray-50">
<div class="wrapper box-border">

<header class="bg-green-500">
<h1 class="text-xl border-b-2 border-green-400 pb-2 mb-5">登録商品の編集</h1>
</header>

<main>
  <div class="container mx-auto py-20">

    <div class="mb-10">
      <!--検索に失敗した時のHTML-->
      <?php if(!$result["status"]): ?>
        <p class="text-red-600"><?= $result["message"] ?></p>
      <?php else: ?>
        <!--更新に失敗した時のHTML-->
        <p class="text-red-600"><?= $errmessage ?></p>
      <?php endif?>
      
    </div>

    <div class="product-wrap px-5 py-10 shadow-md">
      <h4 class="media" id="error">商品情報</h4>

        <form action="kousin.php" method="POST">
        <p class="ptg">※商品番号は変更できません</p>
        <?php if($result["status"]): ?>
                <table>
                    <tr class="ss">
                      <th>商品番号</th>
                      <th>値段</th>
                      <th>商品名</th>
                    </tr>

                    <tr>
                        <td class="icon bird">
                          <input class="ttt"
                            type="text"
                            name="product_no" 
                            id="product_no" 
                            class="px-2 py-2 border rounded-md outline-none focus:border-green-200" 
                            value="<?= $result["result"]["PRODUCT_NO"] ?>"
                            readonly
                          >
                        </td>

                        <td class="tet1">
                          <input class="ttt"
                            type="text" 
                            name="price" 
                            id="product_no" 
                            class="px-2 py-2 border rounded-md outline-none focus:border-green-200" 
                            value="<?= $result[ "result" ]["PRICE"] ?>"
                          >
                        </td>

                        <td class="tet2">
                          <input  class="ttt"
                            type="text" 
                            name="pname" 
                            id="product_no" 
                            class="px-2 py-2 border rounded-md outline-none focus:border-green-200" 
                            value="<?= $result[ "result" ]["PNAME"] ?>" 
                          >
                        </td>
                    </tr>
                </table>
                <a href="hen.php" class="ab">戻る</a>
                <button type="submit" class="ab">更新する</button>
        </form>
      <!-- 失敗したとき-->
      <?php else: ?>
        <style>
          #error{
            display: none;
          }
        </style>
        <h4 class="media">更新に失敗しました</h4>
        <table class="w-full table-fixed">
          <thead>
            <tr class="ss">
              <th>商品番号</th>
              <th>商品名</th>
              <th>値段</th>
              <th>詳細</th>
            </tr>
          </thead>

          <tbody>
            <tr class="kk">
              <td class="icon bird"></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
        <a href="hen.php" class="ab">戻る</a>
    </div><!--/.product-wrap-->
    <?php endif ?>
  </div><!--/.container-->
</main>

</div><!--/.wrapper-->
</body>
</html>
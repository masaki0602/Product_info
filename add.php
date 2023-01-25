<?php
/**
 * @author 有村優希
 * @package SK1A
 */

session_start();

$errmessage = "";
$old["product_no"] = "";
$old["price"] = "";
$old["pname"] = "";
/*********** セッションデータがあれば、上記変数に保存する  */
if(isset($_SESSION["old"])){
  $old = $_SESSION["old"];
}
if(isset($_SESSION["errmessage"])){
  $errmessage = $_SESSION["errmessage"];
}
//セッションデータのクリア
$_SESSION = [];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- link -->
  <link href="css/sen.css" rel="stylesheet">
  
  <title>新規登録</title>
</head>
<body class="bg-gray-50">
<div class="wrapper box-border">

<header class="bg-green-500">
  <div class="container mx-auto py-5">
    <h1 class="">新規登録</h1>
  </div><!--/.container-->
</header>

<main>
  <div class="container mx-auto py-20">

    <div class="mb-10">

      <!--商品登録に失敗した時のHTML-->
      <p class="text-red-600"><?= $errmessage?></p>

    </div>

    <div class="product-wrap px-5 py-10 shadow-md">
      <div class="sub">
        <h4 class="media">商品情報</h4>
      </div>

      <form action="add1.php" method="POST">
              <table>
                <tr class="ss">
                    <th>商品番号</th>
                    <th>値段</th>
                    <th>商品名</th>
                </tr>

                <tr>
                    <td class="icon bird">
                        <input class = "ttt" 
                        type="text" 
                        name="product_no" 
                        id="product_no" 
                        value="<?= $old["product_no"]?>"
                        >
                    </td>
                    <td class = "tet1">
                        <input class = "ttt"
                        type="text" 
                        name="price" 
                        id="price" 
                        class="px-2 py-2 border rounded-md outline-none focus:border-green-200" 
                        value="<?=$old["price"]?>"
                        >
                    </td>
                    <td class = "tet2">
                        <input class = "ttt"
                            type="text" 
                            name="pname" 
                            id="name" 
                            class="px-2 py-2 border rounded-md outline-none focus:border-green-200" 
                            value="<?=$old["pname"]?>"
                        >
                    </td>
                </tr>
            </table>

        <div class="flex justify-end">
          <a href="kakikae.php" class="ab">一覧へ戻る</a>
          <button type="submit" class="ab">登録する</button>
          <a href = "add.php" class="ab">空にする</a>
        </div>
      </form>

    </div><!--/.product-wrap-->

  </div><!--/.container-->
</main>

</div><!--/.wrapper-->
</body>
</html>
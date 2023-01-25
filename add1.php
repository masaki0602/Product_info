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

if($_SERVER["REQUEST_METHOD"] != "POST"){
    header("location:add.php");
    exit();
}

require_once "./resou.php";

$postdata = filter_input_array(INPUT_POST,$filter_array);

if(in_array(NULL,$postdata,true)){
    exit("不正データが検出されました。");
}

session_start();
$_SESSION["old"] = $postdata;

//商品名未入力処理
if($postdata["pname"] == ""){
    $_SESSION["errmessage"] = "商品名が入力されていません。";
    header(' Location: add.php');
    exit();// 忘れずに
}
$instance = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
if(!$instance -> connect_error) {
    //正常に接続できた場合の処理
    $instance->set_charset(DB_CHARSET);

    $sql = "INSERT INTO FLAY( PRODUCT_NO, PNAME, PRICE ) VALUES ( ?, ?, ? )";

    if($stmt = $instance -> prepare($sql)){
        $stmt -> bind_param("isi",$postdata["product_no"],$postdata["pname"],$postdata["price"]);
        $stmt -> execute();
        if($stmt -> affected_rows == 1){
            $instance -> commit();
            header("location:hen.php?product_no={$postdata["product_no"]}");
        }else{
            $instance -> rollback();
            $_SESSION["errmessage"] = "商品情報新規登録ができませんでした。(商品番号または商品名に間違いがあります)";
            header('location:add.php');
        }
        $stmt -> close();
    }
    $instance -> close();
}
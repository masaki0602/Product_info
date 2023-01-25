<?php

/**
* @author 有村優希
* @package SK1A
*/

define( "DB_HOST", "localhost" );
define( "DB_USER", "masaki" );
define( "DB_PASS", "2003" );
define( "DB_NAME", "kozin" );
define( "DB_CHARSET", "utf8mb4" );

if($_SERVER["REQUEST_METHOD"] != "POST"){
    header("Location:kakikae.php");
    exit();
}

require_once "./resou.php";

$postdata = filter_input_array(INPUT_POST,$filter_array);

if(in_array(NULL,$postdata,true)){
    exit("不正データが検出されました。");
}

session_start();
$_SESSION["old"] = $postdata;

if(in_array(false,$postdata,true)){
    if(!$postdata["product_no"]){
    //商品番号不正
    $_SESSION["errmessage"] = "商品コードが入力がされていないか不正な入力です。";
    }else{
        //値段不正
        $_SESSION["errmessage"] = "値段の入力が不正です。";
    }
    header('Location: hensyu.php');
    exit();// 忘れずに
}
if($postdata["pname"] == ""){
    $_SESSION["errmessage"] = "商品名が入力されていません。";
    header(' Location: hensyu.php');
    exit();// 忘れずに
}
$instance = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
if(!$instance -> connect_error) {
    //正常に接続できた場合の処理
    $instance->set_charset(DB_CHARSET);
    //print "ecc";
    $sql = "UPDATE FLAY SET PNAME = ?,PRICE = ? WHERE PRODUCT_NO = ?";
    if($stmt = $instance -> prepare($sql)){
        $stmt -> bind_param("sis",$postdata["pname"],$postdata["price"],$postdata["product_no"]);
        $stmt -> execute();
        if($stmt -> affected_rows == 1){
            $instance -> commit();
            header("location:hen.php?product_no={$postdata["product_no"]}");
        }else{
            $instance -> rollback();
            // $_SESSION["errmessage"] = "商品情報新規登録ができませんでした。";
            header('location:hensyu.php?product_no={$postdata["product_no"]}');
        }
        $stmt -> close();
    }
    $instance -> close();
}
?>
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
    header("location:kakikae.php");
    exit();
}

$postdata = filter_input_array(INPUT_POST);

if(in_array(NULL,$postdata,true)){
    exit("不正データが検出されました。");
}

$instance = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );

if(!$instance -> connect_error){
  $instance->set_charset(DB_CHARSET);
  $sql = "DELETE FROM FLAY WHERE PRODUCT_NO = ?";

  if($stmt = $instance -> prepare($sql)){
    $stmt -> bind_param("i",$postdata["product_no"]);
    $stmt -> execute();
    if($stmt -> affected_rows == 1){
        $instance -> commit();
        // header("location:kadai07_1.php?product_no={$postdata["product_no"]}");
    }else{
        $instance -> rollback();
    }
    header('location:kakikae.php');
    $stmt -> close();
  }
  $instance -> close();
}

?>
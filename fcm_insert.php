<?php
/**
 * Created by PhpStorm.
 * User: zainraza
 * Date: 12/4/17
 * Time: 9:58 PM
 */

require 'init.php';
$fcm_token= $_POST["fcm_token"];
$sql ="insert into fcm_info values ('".$fcm_token."');";
mysqli_query($con,$sql);
mysqli_close($con);

?>
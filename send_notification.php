<?php
/**
 * Created by PhpStorm.
 * User: zainraza
 * Date: 12/4/17
 * Time: 10:05 PM
 */
require 'init.php';
$message = $_POST['message'];
$title= $_POST['title'];
$path_to_fcm ='https://fcm.googleapis.com/fcm/send';
$server_key = "AAAAGx20Ohk:APA91bFAq6rv3KO7Kk1C_40cSdoznfpGX_AD-kH41MeM9Tu6P5fdjjFm0pvTZUl_tQiYsSTx3sXYX5ByVdQS8_pnIJntW6rhRZpfjQGEn8E7hs8dQQgysLx2oKJD46KqXDB2PU7xP9J-";
$sql = "select fcm_token from fcm_info";
$result = mysqli_query($con,sql);
$row = mysqli_fetch_row($result);
$key=$row[0];

$headers = array(
    'Authorization:key='.$server_key,
    'content-Type :application/json'
                );

$fields = array ('to'=>$key,
                    'notification'=> array ('tittle'=> $tittle, 'body'=> $message ));

$payload = json_encode($feilds);

$curl_session= curl_init();
$curl_setopt($curl_session,CURLOPT_URL,$path_to_fcm);
$curl_setopt($curl_session,CURLOPT_POST,true);
$curl_setopt($curl_session,CURLOPT_HTTPHEADER,$headers);
$curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);
$curl_setopt($curl_session,CURLOPT_SSL_VERIFYPEER,false);
$curl_setopt($curl_session,CURLOPT_IPRESOLVE,CURL_IPRESOLVE_V4);
$curl_setopt($curl_session,CURLOPT_POSTFIELDS,$payload);

$result = curl_exec($curl_session);
$curl_close ($curl_session);
my_sqli_close($con);

?>
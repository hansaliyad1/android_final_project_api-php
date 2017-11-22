<?php
/**
 * Created by PhpStorm.
 * User: hansa
 * Date: 11/22/2017
 * Time: 1:14 PM
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $err_msg = [];
    $json = file_get_contents('php://input');
    $array = json_decode($json);

    var_dump($array);


}
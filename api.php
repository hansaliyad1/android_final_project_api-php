<?php
/**
 * Created by PhpStorm.
 * User: hansa
 * Date: 11/22/2017
 * Time: 1:14 PM
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$m = new MongoDB\Driver\Manager('mongodb://admin:admin@ds115396.mlab.com:15396/csc');
$db = $m->csc;
$collection = $db->users;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $err_msg = [];
    $json = file_get_contents('php://input');
    $arrays = json_decode($json);

    for ($i = 0, $len = count($arrays); $i < $len; $i++) {
        if (empty($array[$i]["imei"])) {
            $err_msg[] = 'IMEI number not provided. '.$i;
        } elseif (empty($array[$i]["packageName"])) {
            $err_msg[] = 'Package Name not provided. '.$i;
        } elseif (empty($array[$i]["appName"])) {
            $err_msg[] = 'App Name not provided. '.$i;
        }
    }

    if (count($err_msg) != 0) {
        var_dump($err_msg);
    } else {
        foreach ($arrays as $array) {
            $collection->insert($array);
        }

        var_dump('All data saved');
    }


}

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

header('Content-Type: application/json');

$servername = "localhost";
$username = "admin";
$password = "admin";

try {
    $conn = new PDO("mysql:host=$servername;dbname=android_final_project_api", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $err_msg = [];
    $json = file_get_contents("php://input");

    $arrays = json_decode($json, true);

    for ($i = 0, $len = count($arrays); $i < $len; $i++) {
        if (empty($arrays[$i]["imei"])) {
            $err_msg[] = 'IMEI number not provided. '.$i;
        } elseif (empty($arrays[$i]["packageName"])) {
            $err_msg[] = 'Package Name not provided. '.$i;
        } elseif (empty($arrays[$i]["appName"])) {
            $err_msg[] = 'App Name not provided. '.$i;
        }
    }

    if (count($err_msg) != 0) {
        echo json_encode($err_msg);
    } else {

        $stmt = $conn->prepare("SELECT * FROM users WHERE imei = :imei");
        $stmt->bindParam(':imei', $arrays[0]["imei"]);
        $stmt->execute();
        $db_data = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        var_dump(count($db_data));

        if (count($db_data) == 0) {
            $stmt = $conn->prepare("INSERT INTO users (imei, packageName, appName) VALUES (:imei, :packageName, :appName)");
            $stmt->bindParam(':imei', $imei);
            $stmt->bindParam(':packageName', $packageName);
            $stmt->bindParam(':appName', $appName);


            foreach ($arrays as $array) {
                $imei = $array["imei"];
                $packageName = $array["packageName"];
                $appName = $array["appName"];
                $stmt->execute();
            }

            $conn = null;

            $data_saved = array("success" => "0", "message" => "All Data Saved");
            echo json_encode($data_saved);
        } else {

            $insertDataArray = array();
            $deleteDataArray = array();

            foreach ($arrays as $array) {
                if (!in_array($array, $db_data)) {
                    array_push($insertDataArray, $array);
                }
            }



        }
    }


}

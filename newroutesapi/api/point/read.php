<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json");

include_once('../../config/Database.php');
include_once('../../models/User.php');
include_once('../../config/ClientAuthencation.php');
include_once('../../models/Point.php');
include_once('../../lib/Helper.php');

$database = new Database;
$db = $database->connect();

$point = new Point($db);

$result = $point->read();
$num = $result->rowCount();

if($num){
    $point_arr = array();
    $point_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $point_arr_item = array(
            'id' => $id,
            'name' => $name,
        );
        array_push($point_arr['data'],$point_arr_item);
    }
    echo json_encode($point_arr);
}else{
    echo json_encode(array('message'=>'No Points Found'));
}
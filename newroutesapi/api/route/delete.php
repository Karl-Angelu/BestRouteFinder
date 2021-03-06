<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json");
header("Access-Control-Allow-Methods:DELETE");
header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Authorization,X-Requested-With");

include_once('../../config/Database.php');
include_once('../../models/User.php');
include_once('../../config/Authencation.php');
include_once('../../models/Route.php');
include_once('../../lib/Helper.php');

$database = new Database;
$db = $database->connect();

$route = New Route($db);

$data = json_decode(file_get_contents('php://input'));
if($data->from_point == null){
    echo "'from_point' key must not be empty";
    die();
}
if($data->to_point == null){
    echo "'to_point' key must not be empty";
    die();
}
$route->from_point = $data->from_point;
$route->to_point = $data->to_point;


if($route->delete()){
    echo json_encode(array(
        'message' => 'Route Deleted'
    ));
}else{
    echo json_encode(array(
        'message' => 'Route Not Deleted'
    ));
}
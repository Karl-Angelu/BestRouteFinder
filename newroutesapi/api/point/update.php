<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json");
header("Access-Control-Allow-Methods:PUT");
header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Authorization,X-Requested-With");

include_once('../../config/Database.php');
include_once('../../models/User.php');
include_once('../../config/Authencation.php');
include_once('../../models/Point.php');
include_once('../../lib/Helper.php');

$database = new Database;
$db = $database->connect();

$point = New Point($db);

$data = json_decode(file_get_contents('php://input'));
if($data->id == null){
    echo "'id' key must not be empty";
    die();
}
if($data->name == null){
    echo "'name' key must not be empty";
    die();
}
$point->id = $data->id;
$point->name = $data->name;


if($point->update()){
    echo json_encode(array(
        'message' => 'Point Updated'
    ));
}else{
    echo json_encode(array(
        'message' => 'Point Not Updated'
    ));
}

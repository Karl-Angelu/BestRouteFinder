<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json");

include_once('../../config/Database.php');
include_once('../../models/User.php');
include_once('../../config/Authencation.php');

$database = new Database;
$db = $database->connect();

$user = new User($db);

$result = $user->read();
$num = $result->rowCount();

if($num){
    $user_arr = array();
    $user_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $user_arr_item = array(
            'id' => $id,
            'name' => $name,
            'role' => $role,
            'created_at' => $created_at,
            'updated_at' => $updated_at
        );
        array_push($user_arr['data'],$user_arr_item);
    }
    echo json_encode($user_arr);
}else{
    echo json_encode(array('message'=>'No Record Found'));
}
<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json");

include_once('../../config/Database.php');
include_once('../../models/User.php');
include_once('../../config/ClientAuthencation.php');
include_once('../../models/Route.php');
include_once('../../lib/Helper.php');


$database = new Database;
$db = $database->connect();
$helper = new Helper($db);

$route = new Route($db);


$result = $route->read_all();
$num = $result->rowCount();

if($num){
    $route_arr = array();
    $route_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $helper->find = $row['from_point_id'];
        $helper->table = "points";
        $helper->where_field="id";
        $helper->find_field="name";
        $helper->find();
        $from_point_name = $helper->found;

        $helper->find = $row['to_point_id'];
        $helper->table = "points";
        $helper->where_field="id";
        $helper->find_field="name";
        $helper->find();
        $to_point_name = $helper->found;

        $route_arr_item = array(
            'id' => $id,
            'from_point'=>$from_point_name,
            'to_point'=>$to_point_name,
            'time'=>$time,
            'cost'=>$cost
        );
        array_push($route_arr['data'],$route_arr_item);
    }
    echo json_encode($route_arr);
}else{
    echo json_encode(array('message'=>'No Record Found'));
}
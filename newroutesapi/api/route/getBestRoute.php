<?php

header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json");

include_once('../../config/Database.php');
include_once('../../models/User.php');
include_once('../../config/ClientAuthencation.php');
include_once('../../lib/BestRoute.php');
include_once('../../models/Route.php');
include_once('../../models/Point.php');
include_once('../../lib/Helper.php');


$database = new Database;
$db = $database->connect();

$bestRoute = new BestRoute();
$point = new Point($db);
$route = new Route($db);


$origin = $_GET['origin'];
$destination = $_GET['destination'];
if($origin == null){
    echo "'origin' key must not be empty";
    die();
}
if($destination == null){
    echo "'destination' key must not be empty";
    die();
}
$point_query = $point->read();
$data = array();

while($row = $point_query->fetch(PDO::FETCH_ASSOC)){
    
    array_push($data[$row['name']]);

    $route->id = $row['id'];
    $res2=$route->read();

        while($row2=$res2->fetch(PDO::FETCH_ASSOC)){
            array_push($data[$row['name']][$row2['name']]);
            $data[$row['name']][$row2['name']]=array("time"=>$row2['time'],"cost"=>$row2['cost']);
        }
}

$bestRoute->data=$data;
$bestRoute->origin=$origin;
$bestRoute->destination=$destination;
if($bestRoute->findBestRoute()){

$response_arr['data'] = array(
    "origin" => $bestRoute->origin,
    "destination" => $bestRoute->destination,
    "best_route" => $bestRoute->bestRoute,
    "time" => $bestRoute->time,
    "cost"=>$bestRoute->cost
);
echo json_encode($response_arr);
}else{
    echo "There is no possible route from ".$origin." to ".$destination;
}
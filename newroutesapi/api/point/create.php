<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json");
header("Access-Control-Allow-Methods:POST");
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

        if($data->name == null){
            echo "'name' key must not be empty";
            die();
        }
        
        $point->name = $data->name;
      

        if($point->create()){
            echo json_encode(array(
                'message' => 'Point Created'
            ));
        }else{
            echo json_encode(array(
                'message' => 'Point Not Created'
            ));
        }

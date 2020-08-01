<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Authorization,X-Requested-With");

include_once('../../config/Database.php');
include_once('../../models/User.php');
include_once('../../config/Authencation.php');
        $database = new Database;
        $db = $database->connect();

        $user = New User($db);

        $data = json_decode(file_get_contents('php://input'));
        if($data->name== null){
            echo "'name' key must not be empty";
            die();
        }
        if($data->password== null){
            echo "'password' key must not be empty";
            die();
        }
        if($data->role== null){
            echo "'role' key must not be empty";
            die();
        }
        $user->name = $data->name;
        $user->password = $data->password;
        $user->role = $data->role;


        if($user->create()){
            echo json_encode(array(
                'message' => 'User Created'
            ));
        }else{
            echo json_encode(array(
                'message' => 'User Not Created'
            ));
        }

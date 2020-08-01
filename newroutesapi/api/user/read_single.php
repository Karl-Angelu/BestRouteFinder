<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json");

include_once('../../config/Database.php');
include_once('../../models/User.php');
include_once('../../config/Authencation.php');

$database = new Database;
$db = $database->connect();

$user = new User($db);

$user->id = isset($_GET['id']) ? $_GET['id']:die();

$user->read_single();
$user_arr = array(
    'id' => $user->id,
    'name' => $user->name,
    'role' => $user->role,
    'created_at' => $user->created_at,
    'updated_at' => $user->updated_at
);
echo json_encode($user_arr);


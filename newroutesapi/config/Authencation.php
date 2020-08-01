<?php

if(!isset($_SERVER['PHP_AUTH_USER'])){
    header('WWW-Authencate:Basic realm="Admin Area"');
    header("HTTP/1.0 401 Unauthorized");
    print "For authorized users only";
    exit;
}
$db = new Database();
$dbconn = $db->connect();

$user = new User($dbconn);
$user->name = $_SERVER['PHP_AUTH_USER'];
$user->password = $_SERVER['PHP_AUTH_PW'];

$role = $user->checkuser();
if($role){
    switch($role){
        case 'admin':
            return true;
            break;
        case 'client':
            print "For admin access only.";
            exit;
            break;
    }
 }else{
     print "No such authorized user.";
     exit;
 }
<?php
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once 'config/Database.php';
include_once 'objects/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new user($db);


$data = json_decode(file_get_contents("php://input"));

$user->setFirstname($data->krstneMeno) ;
$user->setLastname($data->priezvisko) ;
$user->setEmail($data->email);
$user->setPassword($data->heslo) ;


if(
   ! empty($user->getFirstname()) &&
!empty($user->getEmail()) &&
!empty($user->getPassword()) &&
$user->create()
){

    http_response_code(200);

    echo json_encode(array("message" => "User was created."));
}

else{

    http_response_code(400);

    echo json_encode(array("message" => "Unable to create user."));
}
?>
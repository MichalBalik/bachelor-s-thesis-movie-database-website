<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once 'config/Core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;


include_once 'config/Database.php';
include_once 'objects/User.php';


$database = new Database();
$db = $database->getConnection();


$user = new user($db);
$data = json_decode(file_get_contents("php://input"));


$jwt=isset($data->jwt) ? $data->jwt : "";


if($jwt){
    try {

        $decoded = JWT::decode($jwt, $key, array('HS256'));

        $user->setFirstname($data->firstname);
        $user->setLastname($data->lastname);
        $user->setEmail($data->email);
        $user->setPassword($data->password);

        if($data->idPouzivatela == $decoded->data->idPouzivatela){
        $user->setIdPouzivatela($decoded->data->idPouzivatela);
        }


        if($decoded->data->funkcia == "admin"){
            $user->setIdPouzivatela($data->idPouzivatela);
            $user->setFunkcia($data->funkcia);

        }


        if($user->update()){
            $token = array(
                "iss" => $iss,
                "aud" => $aud,
                "iat" => $iat,
                "nbf" => $nbf,
                "data" => array(
                    "idPouzivatela" => $user->getIdPouzivatela(),
                    "firstname" => $user->getFirstname(),
                    "lastname" => $user->getLastname(),
                    "email" => $user->getEmail(),
                    "funkcia"=>$user->getFunkcia()
                )
            );
            $jwt = JWT::encode($token, $key);


            http_response_code(200);

            echo json_encode(
                array("message" => "Update pouzivatela prebehol uspesne",
                    "jwt" => $jwt
                )
            );
        }


        else{

            http_response_code(401);

            echo json_encode(array("message" => "Unable to update user."));
        }
  }

    catch (Exception $e){

        http_response_code(401);

        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }}

else{

    http_response_code(401);

    echo json_encode(array("message" => "Access denied."));
}
?>
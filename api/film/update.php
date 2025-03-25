<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/Database.php';
include_once '../objects/Film.php';
include_once '../objects/Obsadenie.php';
include_once '../objects/Poziadavka.php';
include_once '../config/Core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));
$jwt=isset($data->jwt) ? $data->jwt : "";

if(empty($data->idObsadenia)&&empty($data->idPoziadavky)){

    $film = new Film($db);
    $film->setId($data->id);
    $film->setNazovFilmu($data->nazovFilmu);
    $film->setPopisFilmu($data->popisFilmu);
    $film->setKategoria($data->kategoria);
    $film->setDatumPremierySR($data->datumPremierySR);
    $film->setUrl($data->url);
    $film->setStav($data->stav);
}
elseif(!empty($data->idPoziadavky)){
    $film = new Poziadavka($db);
    $film->setIdPoziadavky($data->idPoziadavky);
    $film->setNazovPozadovanehoFilmu($data->nazovPozadovanehoFilmu);
    $film->setPopis($data->popis);
    $film->setOdpovedAdmina($data->odpovedAdmina);
    $film->setIdAdmina($data->idAdmina);
    $film->setEmailPozadovatela($data->emailPozadovatela);
}
else{
    $film = new Obsadenie($db);
    $film->setIdObsadenia($data->idObsadenia);
    $film->setPozicia($data->pozicia);
    $film->setMeno($data->meno);
    $film->setPriezvisko($data->priezvisko);
    $film->setIdFilmu($data->idFilmu);
    $film->setStavObsadenia($data->stavObsadenia);
}


if($jwt) {
    try {
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        if ($decoded->data->funkcia =="admin" && $film->update()) {
            http_response_code(200);
            echo json_encode(array("message" => "Update prebehol uspesne"));
        }
    }catch (Exception $e){

        http_response_code(503);
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }


    }
else{

    http_response_code(503);
    echo json_encode(array("message" => "UPDATE neuspesny"));
}
?>
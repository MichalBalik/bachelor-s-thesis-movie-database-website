<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../objects/Film.php';


$database = new Database();
$db = $database->getConnection();

$film = new Film($db);

$film->setId(isset($_GET['id']) ? $_GET['id'] : die());


$film->readOne();

if($film->getNazovFilmu()!=null){

    $film_arr = array(
        "id" =>  $film->getId(),
        "nazovFilmu" => $film->getNazovFilmu(),
        "popisFilmu" => $film->getPopisFilmu(),
        "kategoria" => $film->getKategoria(),
        "datumPremierySR" => $film->getDatumPremierySR(),
        "url" => $film->getUrl(),
        "Obsadenie" =>$film->getZoznamObsadenia()
    );

    http_response_code(200);


    echo(json_encode($film_arr));



}

else{
    http_response_code(404);
    echo json_encode(array("message" => "Film sa v databaze nenachadza"));
}

?>
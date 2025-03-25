<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';


include_once '../objects/Film.php';
include_once '../objects/Poziadavka.php';

$database = new Database();
$db = $database->getConnection();


$data = json_decode(file_get_contents("php://input"));
if(!empty($data->akcia) && $data->akcia== "poziadavka"){
    $poziadavka = new Poziadavka($db);
}
else{
    $film = new Film($db);

}

if(!empty($data->idAutora) &&!empty($data->nazovFilmu) && !empty($data->popisFilmu)&& !empty($data->kategoria)&& !empty($data->datumPremierySR)&& !empty($data->url)){


    $film->setIdAutora($data->idAutora);
    $film->setNazovFilmu($data->nazovFilmu);
    $film->setPopisFilmu($data->popisFilmu);
    $film->setKategoria($data->kategoria);
    $film->setDatumPremierySR($data->datumPremierySR);
    $film->setUrl($data->url);


    if($film->create()){

        http_response_code(201);
        echo json_encode(array("message" => "Film uspesne pridany"));
    }


    else{

        http_response_code(503);
        echo json_encode(array("message" => "Nepodarilo sa pridat film."));
    }
}
elseif (!empty($data->pozicia) && !empty($data->meno)&& !empty($data->priezvisko)&& !empty($data->idFilmu)){

    $film_item = array(
        "pozicia" => $data->pozicia,
        "meno" => $data->meno,
        "priezvisko" => $data->priezvisko,
        "idFilmu" => $data->idFilmu

    );
    $film->pridajObsadenie($film_item);

    if($film->vlozObsadenie()){

        http_response_code(201);
        echo json_encode(array("message" => "Obsadenie uspesne pridane"));
    }

    else{

        http_response_code(503);
        echo json_encode(array("message" => "Nepodarilo sa pridat obsadenie."));
    }

}
elseif($data->akcia == "poziadavka" && !empty($data->akcia) &&!empty($data->nazovPozadovanehoFilmu) &&!empty($data->popis) &&!empty($data->emailPozadovatela )){



    $poziadavka->setNazovPozadovanehoFilmu($data->nazovPozadovanehoFilmu);
    $poziadavka->setPopis($data->popis);
    $poziadavka->setEmailPozadovatela($data->emailPozadovatela);



    if($poziadavka->create()){

        http_response_code(201);
        echo json_encode(array("message" => "Poziadavka uspesne pridany"));
    }

    else{

        http_response_code(503);
        echo json_encode(array("message" => "Nepodarilo sa pridat poziadavku."));
    }
}

else{
    http_response_code(400);
    echo json_encode(array("message" => "Pridavanie prebehlo neuspesne. Udaje su nekompletne"));
}
?>


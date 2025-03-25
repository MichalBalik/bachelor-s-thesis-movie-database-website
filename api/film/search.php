<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


include_once '../config/Database.php';
include_once '../objects/Film.php';
include_once '../objects/Poziadavka.php';


$database = new Database();
$db = $database->getConnection();

$film = new Film($db);
$pozidadavka = new Poziadavka($db);


if(isset($_GET["o"])){
    $druh = "o";
    $keywords=isset($_GET["o"]) ? $_GET["o"] : "";
    $stmt = $film->getAllObsadenie($keywords);


}elseif(isset($_GET["p"])){
    $druh = "p";
    $keywords=isset($_GET["p"]) ? $_GET["p"] : "";

        $stmt = $pozidadavka->getZoznamPoziadavok($keywords);



}elseif (isset($_GET["sp"])){
    $druh = "sp";
    $keywords=isset($_GET["sp"]) ? $_GET["sp"] : "";
    $stmt = $film->searchPopis($keywords);
}

else{
    $druh = "s";
    $keywords=isset($_GET["s"]) ? $_GET["s"] : "";
    $stmt = $film->search($keywords);

}

$num = $stmt->rowCount();


if($num>0){
    $film_arr=array();
    $film_arr["records"]=array();

    if($druh == "s" ||$druh =="sp"){

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $film_item=array(
                "id" => $id,
                "nazovFilmu" => $nazovFilmu,
                "popisFilmu" => html_entity_decode($popisFilmu),
                "kategoria" => $kategoria,
                "datumPremierySR" => $datumPremierySR,
                "url" => $url,
                "stav" => $stav,
                "datumPridania" => $datumPridania

            );

            array_push($film_arr["records"], $film_item);
        }

    }
    elseif($druh == "o"){

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            extract($row);

            $obsadenie=array(
                "idObsadenia" => $idObsadenia,
                "pozicia" => $pozicia,
                "meno" => html_entity_decode($meno),
                "priezvisko" => $priezvisko,
                "idFilmu" => $idFilmu,
                "stavObsadenia" => $stavObsadenia
            );

            array_push($film_arr["records"], $obsadenie);
        }

    }
    elseif($druh == "p"){

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            extract($row);

            $poziadavky=array(
                "idPoziadavky" => $idPoziadavky,
                "nazovPozadovanehoFilmu" => $nazovPozadovanehoFilmu,
                "popis" => $popis,
                "odpovedAdmina" => $odpovedAdmina,
                "idAdmina" => $idAdmina,
                "emailPozadovatela" => $emailPozadovatela,

            );

            array_push($film_arr["records"], $poziadavky);
        }

    }

    http_response_code(200);
    echo json_encode($film_arr);
}

else{

    http_response_code(404);


    echo json_encode(
        array("message" => "Zadanemu slovu nezodpoveda ziaden zaznam v databaze.")
    );
}
?>
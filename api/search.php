<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "config/Database.php";
include_once "objects/User.php";

$database = new Database();
$db = $database->getConnection();

$user = new user($db);


$stmt = $user->getAllUsers();

$num = $stmt->rowCount();


if($num>0){
    $products_arr=array();
    $products_arr["records"]=array();


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            extract($row);

            $user_item=array(
                "idPouzivatela" => $idPouzivatela,
                "firstname" => $firstname,
                "lastname" => $lastname,
                "email" => $email,
                "funkcia"=> $funkcia
            );

            array_push($products_arr["records"], $user_item);


    }

    http_response_code(200);

    echo json_encode($products_arr);
}

else{

    http_response_code(404);

    echo json_encode(
        array("message" => "Zadanemu slovu nezodpoveda ziaden zaznam v databaze.")
    );
}
?>
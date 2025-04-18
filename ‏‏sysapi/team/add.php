<?php

include "../connect.php" ;

$name_t      = filterRequest("name_t");
$pass_t       = filterRequest("pass_t");



$stmt = $con->prepare("INSERT INTO `teams`( `name_t`, `pass_t`) VALUES (?,?)");

$stmt -> execute(array($name_t,$pass_t));

//
$stmt = $con->prepare("SELECT * FROM `teams` WHERE `name_t` = ?");

$stmt -> execute(array($name_t));

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$count = $stmt->rowCount();

if (count($data) == 0) {
    die(json_encode(["status" => "error2", "message" => "F"]));
}

$id_t = $data[0]['id_t'];
//

$stmt = $con->prepare("INSERT INTO `rank`( `name_t`,`id_team`) VALUES (?,?)");

$stmt -> execute(array($name_t,$id_t));


$count = $stmt->rowCount();

if($count > 0){
echo json_encode(array("status" => "success"));
}else{
    echo json_encode(array("status" => "fail"));
}





?>
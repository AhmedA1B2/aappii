<?php

include "../connect.php" ;

$id      = filterRequest("id_t");



$stmt = $con->prepare("DELETE FROM `teams` WHERE `id_t` = ?");

$stmt -> execute(array($id));


$count = $stmt->rowCount();

if($count > 0){
echo json_encode(array("status" => "success"));
}else{
    echo json_encode(array("status" => "fail"));
}









?>
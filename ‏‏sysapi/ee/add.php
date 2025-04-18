<?php

include "../connect.php" ;

$name_t      = filterRequest("name_t");
$pass_t       = filterRequest("pass_t");



$stmt = $con->prepare("INSERT INTO `teams`( `name_t`, `pass_t`) VALUES (?,?)");

$stmt -> execute(array($name_t,$pass_t));


$count = $stmt->rowCount();

if($count > 0){
echo json_encode(array("status" => "success"));
}else{
    echo json_encode(array("status" => "fail"));
}





?>
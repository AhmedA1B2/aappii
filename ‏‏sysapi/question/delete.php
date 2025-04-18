<?php

include "../connect.php" ;

$id      = filterRequest("id_q");



$stmt = $con->prepare("DELETE FROM questions WHERE id_q = ?");

$stmt -> execute(array($id));


$count = $stmt->rowCount();

if($count > 0){
echo json_encode(array("status" => "success"));
}else{
    echo json_encode(array("status" => "fail"));
}









?>
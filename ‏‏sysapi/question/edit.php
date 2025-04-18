<?php

include "../connect.php" ;

$id        = filterRequest("id_q");
$num_q    = filterRequest("num_q");
$input_q  = filterRequest("input_q");
$output_q = filterRequest("output_q");
$point_q  = filterRequest("point_q");

$stmt = $con->prepare("UPDATE `questions` SET `num_q`= ?,`input_q`= ?,`output_q`= ?,`point_q`=? WHERE `id_q` = ?");


$stmt -> execute(array($num_q,$input_q,$output_q,$point_q,$id));

$count = $stmt->rowCount();

if($count > 0){
    echo json_encode(array("status" => "success"));
}else{
    echo json_encode(array("status" => "fail"));
}

?>

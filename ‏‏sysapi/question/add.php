<?php

include "../connect.php" ;

$num_q    = filterRequest("num_q");
$input_q  = filterRequest("input_q");
$output_q = filterRequest("output_q");
$point_q  = filterRequest("point_q");

$rank_point_q = 30;



$stmt = $con->prepare("INSERT INTO `questions`( `num_q`, `input_q`, `output_q`,`point_q`,`rank_point_q`) VALUES (?,?,?,?,?)");

$stmt -> execute(array($num_q,$input_q,$output_q,$point_q,$rank_point_q));

$count = $stmt->rowCount();

if($count > 0){
echo json_encode(array("status" => "success"));
}else{
    echo json_encode(array("status" => "fail"));
}









?>
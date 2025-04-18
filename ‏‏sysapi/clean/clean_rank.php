<?php

include "../connect.php" ;

$point_t = 0;

$stmt = $con->prepare("UPDATE `rank` SET `point_t`= ?");


$stmt -> execute(array($point_t,));

$count = $stmt->rowCount();

if($count > 0){
    echo json_encode(array("status" => "success"));
}else{
    echo json_encode(array("status" => "fail"));
}

?>

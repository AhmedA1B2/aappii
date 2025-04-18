<?php

include "../connect.php" ;

$search = filterRequest("search");
$id = filterRequest("id");

$stmt = $con->prepare("SELECT * FROM `student` WHERE `num` = ? And `who_added` = ? OR `name` = ? And `who_added` = ?");


$stmt -> execute(array($search,$id,$search,$id));

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$count = $stmt->rowCount();

if($count > 0){
echo json_encode(array("status" => "success", "data" => $data ));
}else{
    echo json_encode(array("status" => "fail"));
}



?>
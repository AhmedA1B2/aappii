<?php

include "../connect.php" ;

$id        = filterRequest("id_t");
$name_t      = filterRequest("name_t");
$pass_t       = filterRequest("pass_t");

$stmt = $con->prepare("UPDATE `teams` SET `name_t`= ?,`pass_t`= ? WHERE `id_t` = ?");


$stmt -> execute(array($name_t, $pass_t,$id));

$count = $stmt->rowCount();

if($count > 0){
    echo json_encode(array("status" => "success"));
}else{
    echo json_encode(array("status" => "fail"));
}

?>

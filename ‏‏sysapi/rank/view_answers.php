<?php

include "../connect.php";

$stmt = $con->prepare("SELECT * FROM `answers`");

$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$count = $stmt->rowCount();

if ($count > 0) {
    echo json_encode(array("status" => "success", "data" => $data));
} else {
    echo json_encode(array("status" => "fail"));
}

?>

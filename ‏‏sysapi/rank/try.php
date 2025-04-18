<?php

header("Access-Control-Allow-Origin: *"); // السماح لجميع النطاقات بالوصول
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // السماح بهذه الطرق
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // السماح بهذه الرؤوس


include "../connectcopy.php";

$num_q = filter_input(INPUT_POST, "num_q", FILTER_VALIDATE_INT);

if ($num_q === false || $num_q === null) {
    echo json_encode(["status" => "error", "message" => "رقم السؤال غير صحيح"]);
    exit;
}

$stmt = $con->prepare("SELECT input_q, output_q FROM `questions` WHERE `num_q` = ?");
$stmt->execute([$num_q]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($data) {
    echo json_encode(["status" => "success", "data" => [$data]]);
} else {
    echo json_encode(["status" => "fail", "message" => "لا توجد بيانات"]);
}

?>

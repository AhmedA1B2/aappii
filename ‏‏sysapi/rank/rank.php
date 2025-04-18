<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "../connectcopy.php";

// استرجاع جميع الأسماء الفريدة من جدول answers
$stmt = $con->prepare("SELECT DISTINCT name_t FROM answers");
$stmt->execute();
$names = $stmt->fetchAll(PDO::FETCH_COLUMN);

foreach ($names as $name_t) {
    // حساب مجموع النقاط لكل اسم
    $stmt = $con->prepare("SELECT SUM(point_q) AS total_points FROM answers WHERE name_t = ?");
    $stmt->execute(array($name_t));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_points = $data['total_points'] ?? 0;

    // تحديث الجدول rank لكل اسم
    $stmt = $con->prepare("UPDATE rank SET point_t = ? WHERE name_t = ?");
    $stmt->execute(array($total_points, $name_t));
}

echo json_encode(["status" => "success", "message" => "تم تحديث جميع البيانات"]);
?>

<?php 

header("Content-Type: application/json; charset=UTF-8"); // تأكيد نوع الاستجابة JSON
header("Access-Control-Allow-Origin: *"); // السماح لجميع النطاقات بالوصول
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "../connectcopy.php"; 

$name_t = isset($_POST['name_t']) ? $_POST['name_t'] : null;
$pass_t = isset($_POST['pass_t']) ? $_POST['pass_t'] : null;

$stmt = $con->prepare("SELECT * FROM `teams` WHERE `name_t` = ? AND `pass_t` = ?"); 
$stmt->execute([$name_t, $pass_t]);

$data = $stmt->fetchAll(PDO::FETCH_ASSOC); // جلب كل النتائج كمصفوفة

if (count($data) > 0) {
    echo json_encode(["status" => "success", "data" => $data]);
} else {
    echo json_encode(["status" => "fail", "message" => "بيانات غير صحيحة"]);
}

?>

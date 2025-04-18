<?php

include "../connect.php";

// تحضير الاستعلام
$stmt = $con->prepare("DELETE FROM `answers`"); 

// تنفيذ الاستعلام
$success = $stmt->execute();

// التحقق من نجاح العملية
if ($success) {
    $count = $stmt->rowCount();
    if ($count > 0) {
        echo json_encode(array("status" => "success", "message" => "تم حذف $count سجل(ات) بنجاح."));
    } else {
        echo json_encode(array("status" => "success", "message" => "لم يتم العثور على سجلات لحذفها."));
    }
} else {
    echo json_encode(array("status" => "fail", "message" => "فشل في حذف السجلات."));
}

?>
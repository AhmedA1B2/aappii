<?php
header("Access-Control-Allow-Origin: *"); // السماح لجميع النطاقات بالوصول
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // السماح بهذه الطرق
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // السماح بهذه الرؤوس

error_reporting(E_ALL);
ini_set('display_errors', 1);


include "../connectcopy.php";

$num_q = isset($_POST['num_q']) ? $_POST['num_q'] : null;
$name_t = isset($_POST['name_t']) ? $_POST['name_t'] : null;

if ($num_q === null) {
    die(json_encode(["status" => "error0", "message" => "null Data"]));
}

if ($name_t === null) {
    die(json_encode(["status" => "error1", "message" => "null Data"]));
}

$time = date("h:i:s A");

$stmt = $con->prepare("SELECT * FROM `questions` WHERE `num_q` = ?");

$stmt -> execute(array($num_q));

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$count = $stmt->rowCount();

if (count($data) == 0) {
    die(json_encode(["status" => "error2", "message" => "F"]));
}

$rank_point_q = $data[0]['rank_point_q'];
$point_q = $data[0]['point_q']+$rank_point_q;
$rank_point_q =0;

$stmt = $con->prepare("UPDATE `questions` SET `rank_point_q`= ? WHERE `num_q` = ?");

$stmt -> execute(array($rank_point_q,$num_q));


/////////////////////////التحقق من اجبات سابقه ///////////////////

///////////////////////////////////////////////////////////////////

$stmt = $con->prepare("SELECT * FROM `answers` WHERE `num_q` = ? AND `name_t` = ?");

$stmt -> execute(array($num_q,$name_t));

$ath_an = $stmt->fetchAll(PDO::FETCH_ASSOC);

$count = $stmt->rowCount();

if (count($ath_an) == 0) {
    $stmt = $con->prepare("INSERT INTO `answers`( `name_t`, `num_q`,`point_q`,`time`) VALUES (?,?,?,?)");

    $stmt -> execute(array($name_t,$num_q,$point_q,$time));
    
    echo json_encode(["status" => "success", "message" => "A"]);
}
///////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////






?>








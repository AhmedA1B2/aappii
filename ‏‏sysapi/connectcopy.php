<?php
$dsn = "mysql:host=sql206.infinityfree.com;dbname=if0_38685421_q_sys_db";
$user = "if0_38685421";
$pass = "N9tzqTEbvXfqy";
$option = array(
   PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
);
$countrowinpage = 9 ;  
try {
   $con = new PDO($dsn, $user, $pass, $option);
   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
   
   header("Access-Control-Allow-Origin: *");
   header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Access-Control-Allow-Origin");
   header("Access-Control-Allow-Methods: POST, OPTIONS , GET");

    
} catch (PDOException $e) {
   echo $e->getMessage();
}

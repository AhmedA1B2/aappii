<?php

define("MB", 1048576);

function filterRequest($requestname)
{
  return  htmlspecialchars(strip_tags($_POST[$requestname]));
}

function imageUpload($imageRequest)
{
  global $msgError;
  $imagename  = rand(10, 1000000) . $_FILES[$imageRequest]['name'];
  $imagetmp   = $_FILES[$imageRequest]['tmp_name'];
  $imagesize  = $_FILES[$imageRequest]['size'];
  $allowExt   = array("jpg", "png", "gif","mp4","pdf");
  $strToArray = explode(".", $imagename);
  $ext        = end($strToArray);
  $ext        = strtolower($ext);

  if (!empty($imagename) && !in_array($ext, $allowExt)) {
    $msgError = "EXT";
  }
 //if ($imagesize > 2 * MB) {
 //  $msgError = "size";
 //}
  if (empty($msgError)) {
    move_uploaded_file($imagetmp,  "../../upload/" . $imagename);
    return $imagename;
  } else {
    return "fail";
  }
}


function deleteFile($dir, $imagename)
{
  if (file_exists($dir . "/" . $imagename)) {
    unlink($dir . "/" . $imagename);
  }
}

function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != "sued" ||  $_SERVER['PHP_AUTH_PW'] != "suady"){
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }
}

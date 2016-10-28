<?php
/**
 * Created by PhpStorm.
 * User: PLLARENA
 * Date: 28/10/2016
 * Time: 11:47 AM
 */
session_start();
$sErr="";
if(isset($_SESSION["sUser"])){
    session_destroy();
}
else
    $sErr="Faltan datos de sesión, es posible que no realizara el login";
if($sErr == "")
    header("Location: index.html");
else
    header("Location: error.php?sError=".$sErr);

?>
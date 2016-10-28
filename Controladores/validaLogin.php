<?php
/**
 * Created by PhpStorm.
 * User: PLLARENA
 * Date: 28/10/2016
 * Time: 10:17 AM
 */
require_once ("../Class/Usuarios.php");
session_start();
$oUser = new Usuarios();
$sErr = "";

    if(isset($_POST['txtUser']) && !empty($_POST['txtUser']) &&
        isset($_POST['txtPass']) && !empty($_POST['txtPass'])){
            $oUser->setUsuario($_POST['txtUser']);
            $oUser->setClave($_POST['txtPass']);
        try{
            if($oUser->buscarCvePassUser()){
                $_SESSION['sUser'] = $oUser;
                header("Location: ../panelAdmin.php?sNombre=".$oUser->getUsuario());
            }
        }catch (Exception $e){
            error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
            $sErr = "Error en base de datos, comunicarse con el administrador";
        }

    }else{
        $sErr = "Faltan datos";
    }

?>
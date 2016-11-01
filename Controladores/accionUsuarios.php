<?php
/**
 * Created by PhpStorm.
 * User: PLLARENA
 * Date: 31/10/2016
 * Time: 05:14 PM
 */
include_once ("../Class/Usuarios.php");
session_start();
$oUser = new Usuarios();
$sErr = "";
$sErr2 = "";
$sRuta = "";
$sOp = "";
$nAfec = -1;
$nFlag = 0;
$sMsj = "";
$sRuta = "controlUsuarios.php";
$sPass = "";
    if(isset($_SESSION['sUser']) && !empty($_SESSION['sUser'])){
        if(isset($_POST['txtOp']) && !empty($_POST['txtOp'])){
            $sOp = $_POST['txtOp'];
            $sPass = $_POST['txtPass1'];

            if($sOp == 'm' or $sOp == 'e'){
                $oUser->setIdUsuario($_POST['txtUser']);
            }

            if($sOp == 'a'){
                $oUser->setUsuario($_POST['txtNombre']);
                $oUser->setClave($_POST['txtPass']);
            }else if($sOp == 'm' and $sPass != ""){
                $oUser->setUsuario($_POST['txtNombre']);
                $oUser->setClave($sPass);
            }else if($sOp == 'm' and $sPass == ""){
                $oUser->setUsuario($_POST['txtNombre']);
            }

            try{
                if($sOp == 'a'){
                    $nAfec = $oUser->insertar();
                }else if($sOp == 'm' && $sPass != ""){
                    $nAfec = $oUser->updatePass();
                }else if($sOp == 'm' && $sPass == ""){
                    $nAfec = $oUser->update();
                }else if($sOp == 'e'){
                    $nAfec = $oUser->eliminar();
                }

                if($nAfec != 1){
                    $sErr2 = "Error en la base de datos";
                }
            }catch (Exception $e){
                error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
                $sErr2 = "Error en base de datos, comunicarse con el administrador";
            }
        }else{
            $sErr2 = "Faltan datos de la operación";
        }
    }else{
        $sErr = "Error, faltan datos de sesión";
    }

    if($sErr == ""){
        header("Location: ../controlUsuarios.php");
    }else if($sErr2 != ""){
        header("Location: ../errorProceso.php?sError=".$sErr2."&sRuta=".$sRuta);
    }else if($sErr != ""){
        header("Location: ../error.php?sError=".$sErr);
    }


?>
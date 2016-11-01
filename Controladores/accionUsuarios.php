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
$sRuta = "../controlUsuarios.php";

    if(isset($_SESSION['sUser']) && !empty($_SESSION['sUser'])){
        if(isset($_POST['txtOp']) && !empty($_POST['txtOp'])){
            $sOp = $_POST['txtOp'];

            if($sOp == 'm' or $sOp == 'e'){
                $oUser->setIdUsuario($_POST['txtUser']);
            }

            if($sOp == 'a'){
                $oUser->setUsuario($_POST['txtNombre']);
                $oUser->setClave($_POST['txtPass']);
            }else if($sOp == 'm' and !empty($_POST['txtPass1'])){
                $oUser->setUsuario($_POST['txtNombre']);
                $oUser->setClave($_POST['txtPass1']);
            }else if($sOp == 'm' and empty($_POST['txtPass1'])){
                $oUser->setUsuario($_POST['txtNombre']);
            }

            try{
                if($sOp == 'a'){
                    $nAfec = $oUser->insertar();
                }else if($sOp == 'm' && !empty($_POST['txtPass1'])){
                    $nAfec = $oUser->updatePass();
                }else if($sOp == 'm' && empty($_POST['txtPass1'])){
                    $nAfec = $oUser->update();
                }else if($sOp == 'e'){
                    $nAfec = $oUser->eliminar();
                }

                if($nAfec != 1){
                    $sErr2 = "Error en la base de datos";
                }
            }catch (Exception $e){
                error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
                $sErr = "Error en base de datos, comunicarse con el administrador";
            }
        }else{
            $sErr = "Faltan datos de la operación";
        }
    }else{
        $sErr = "Error, faltan datos de sesión";
    }

    if($sErr == ""){
        header("Location: ../controlUsuarios.php");
    }else{
        header("Location: ../errorProceso.php?sError=".$sErr2."&sRuta=".$sRuta);
    }


?>
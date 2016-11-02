<?php
/**
 * Created by PhpStorm.
 * User: PLLARENA
 * Date: 02/11/2016
 * Time: 10:51 AM
 */
include_once ("../Class/Departamento.php");
session_start();
$oDepto = new Departamento();
$nClave = 0;
$sOp = "";
$sErr = "";
$sErr2 = "";
$nAfec = -1;
$sRuta = "abcDepto.php";

    if(isset($_SESSION['sUser']) && !empty($_SESSION['sUser'])){
        if(isset($_POST['txtOp']) && !empty($_POST['txtOp'])){
            $nClave = $_POST['txtDepto'];
            $sOp = $_POST['txtOp'];


            if($sOp == 'm' or $sOp == 'e'){
                $oDepto->setIdDepto($nClave);
            }

            if($sOp == 'a'){
                $oDepto->setDepto($_POST['txtNombre']);
            }else if($sOp == 'm'){
                $oDepto->setDepto($_POST['txtNombre']);
            }

            try{
                if($sOp == 'a'){
                    $nAfec = $oDepto->insertar();
                }else if($sOp == 'm'){
                    $nAfec = $oDepto->modificar();
                }else if($sOp == 'e'){
                    $nAfec = $oDepto->eliminar();
                }

                if($nAfec != 1){
                    $sErr2 = "Error en la base de datos";
                }

            }catch(Exception $e){
                error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(),0);
                $sErr2 = "Error en base de datos, comunicarse con el administrador";
            }

        }else{
            $sErr2 = "No se indicó una operación";
        }
    }else{
        $sErr = "Faltan datos de sesión, acceso denegado";
    }

    if($sErr == ""){
        header("Location: ../controlDepto.php");
    }else if($sErr != ""){
        header("Location: ../error.php?sError=".$sErr);
    }else if($sErr2 != ""){
        header("Location: ../errorProceso?sError=".$sErr."&sRuta=".$sRuta);
    }
?>
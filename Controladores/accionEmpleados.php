<?php
/**
 * Created by PhpStorm.
 * User: PLLARENA
 * Date: 03/11/2016
 * Time: 09:37 AM
 */
include_once ("../Class/Empleadas.php");
session_start();
$oEmp = new Empleadas();
$sErr = "";
$sErr2 = "";
$nAfec = -1;
$sOp = "";
$nClave = 0;

    if(isset($_SESSION['sUser']) && !empty($_SESSION['sUser'])){
        if(isset($_POST['txtOp']) && !empty($_POST['txtOp'])){
            $nClave = $_POST['txtEmp'];
            $sOp = $_POST['txtOp'];

            if($sOp == 'm' or $sOp == 'e'){
                $oEmp->setIdEmpleada($nClave);
            }

            if($sOp == 'a'){
                $oEmp->setDepto(new Departamento());
                $oEmp->setNombre($_POST['txtNomEmp']);
                $oEmp->getDepto()->setIdDepto($_POST['depto']);
            }else if($sOp == 'm' && !empty($_POST['depto2'])){
                $oEmp->setDepto(new Departamento());
                $oEmp->setNombre($_POST['txtNomEmp']);
                $oEmp->getDepto()->setIdDepto($_POST['depto2']);
            }else if($sOp == 'm' && empty($_POST['depto2'])){
                $oEmp->setNombre($_POST['txtNomEmp']);
            }

            try{
                if($sOp == 'a'){

                }
            }catch (Exception $e){
                error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(),0);
                $sErr2 = "Error en base de datos, comunicarse con el administrador";
            }
        }else{
            $sErr2 = "No se seleccionó una operación a realizar";
        }
    }else{
        $sErr = "Faltan indicar datos de sesión, acceso denegado";
    }
?>
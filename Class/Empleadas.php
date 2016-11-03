<?php

/**
 * Created by PhpStorm.
 * User: PLLARENA
 * Date: 29/10/2016
 * Time: 09:51 AM
 */
require_once ("AccesoDatos.php");
include_once ("Departamento.php");
class Empleadas
{
    private $oAD = null;
    private $nIdEmpleada = 0;
    private $sNombre = "";
    private $oDepto = null;

    public function getAD()
    {
        return $this->oAD;
    }

    public function setAD($oAD)
    {
        $this->oAD = $oAD;
    }

    public function getIdEmpleada()
    {
        return $this->nIdEmpleada;
    }

    public function setIdEmpleada($nIdEmpleada)
    {
        $this->nIdEmpleada = $nIdEmpleada;
    }

    public function getNombre()
    {
        return $this->sNombre;
    }

    public function setNombre($sNombre)
    {
        $this->sNombre = $sNombre;
    }

    public function getDepto()
    {
        return $this->oDepto;
    }

    public function setDepto($oDepto)
    {
        $this->oDepto = $oDepto;
    }

    function buscarTodos(){
        $oAD = new AccesoDatos();
        $vObj = null;
        $rst = null;
        $sQuery = "";
        $i = 0;
        $oEmp = null;
        if($oAD->Conecta()){
            $sQuery = "call buscarTodosEmpleados()";
            $rst = $oAD->ejecutaQuery($sQuery);
            $oAD->Desconecta();
        }
        if($rst){
            foreach ($rst as $vRow){
                $oEmp = new Empleadas();
                $oEmp->setDepto(new Departamento());
                $oEmp->setIdEmpleada($vRow[0]);
                $oEmp->setNombre($vRow[1]);
                $oEmp->getDepto()->setDepto($vRow[2]);
                $vObj[$i] = $oEmp;
                $i = $i + 1;
            }
        }else{
            $vObj = false;
        }
        return $vObj;
    }

    function buscarDatosEmpleados(){
        $oAD = new AccesoDatos();
        $sQuery = "";
        $bRet = false;
        $rst = null;
        if($this->getIdEmpleada() == 0){
            throw new Exception("Empleadas->buscarDatosEmpleados(): error, faltan datos");
        }else{
            if($oAD->Conecta()){
                $sQuery = "call buscarDatosEmpleado(".$this->getIdEmpleada().");";
                $rst = $oAD->ejecutaQuery($sQuery);
                $oAD->Desconecta();
                if($rst){
                    $this->setDepto(new Departamento());
                    $this->setIdEmpleada($rst[0][0]);
                    $this->setNombre($rst[0][1]);
                    $this->getDepto()->setDepto($rst[0][2]);
                    $bRet = true;
                }
            }
        }
        return $bRet;
    }

}
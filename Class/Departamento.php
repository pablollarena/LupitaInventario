<?php

/**
 * Created by PhpStorm.
 * User: PLLARENA
 * Date: 27/10/2016
 * Time: 12:44 PM
 */
require_once ("AccesoDatos.php");
class Departamento
{
    private $oAD = null;
    private $nIdDepto = 0;
    private $sDepto = "";


    public function getAD()
    {
        return $this->oAD;
    }

    public function setAD($oAD)
    {
        $this->oAD = $oAD;
    }

    public function getIdDepto()
    {
        return $this->nIdDepto;
    }

    public function setIdDepto($nIdDepto)
    {
        $this->nIdDepto = $nIdDepto;
    }

    public function getDepto()
    {
        return $this->sDepto;
    }

    public function setDepto($sDepto)
    {
        $this->sDepto = $sDepto;
    }

    function buscarTodos(){
        $oAD = new AccesoDatos();
        $vObj = null;
        $rst = null;
        $sQuery = "";
        $oDepto = null;
        $i = 0;
        if($oAD->Conecta()){
            $sQuery = "call buscarTodosDepto();";
            $rst = $oAD->ejecutaQuery($sQuery);
            $oAD->Desconecta();
        }
        if($rst){
            foreach ($rst as $vRow){
                $oDepto = new Departamento();
                $oDepto->setIdDepto($vRow[0]);
                $oDepto->setDepto($vRow[1]);
                $vObj[$i] = $oDepto;
                $i = $i + 1;
            }
        }else{
            $vObj = false;
        }
        return $vObj;
    }

    function buscarDatosDepto(){
        $oAD = new AccesoDatos();
        $sQuery = "";
        $rst = null;
        $bRet = false;
        if($this->getIdDepto() == 0){
            throw new Exception("Departamento->buscarDatosDepto: error, faltan datos");
        }else{
            if($oAD->Conecta()){
                $sQuery = "call buscarDatosDepto(".$this->getIdDepto().");";
                $rst = $oAD->ejecutaQuery($sQuery);
                $oAD->Desconecta();
                if($rst){
                    $this->setIdDepto($rst[0][0]);
                    $this->setDepto($rst[0][1]);
                    $bRet = true;
                }
            }
        }
        return $bRet;
    }

    function insertar(){
        $oAD = new AccesoDatos();
        $sQuery = "";
        $i = -1;
        if($oAD->Conecta()){
            $sQuery = "call insertarDepartamento('".$this->getDepto()."');";
            $i = $oAD->ejecutaComando($sQuery);
            //var_dump($sQuery);
            $oAD->Desconecta();
        }
        return $i;
    }

    function modificar(){
        $oAD = new AccesoDatos();
        $sQuery = "";
        $i = -1;
        if($this->getIdDepto() == 0){
            throw new Exception("Departamento->modificar(): error, faltan datos");
        }else{
            if($oAD->Conecta()){
                $sQuery = "call updateDepartamento(".$this->getIdDepto().",'".$this->getDepto()."');";
                $i = $oAD->ejecutaComando($sQuery);
                $oAD->Desconecta();
            }
        }
        return $i;
    }

    function eliminar(){
        $oAD = new AccesoDatos();
        $sQuery = "";
        $i = 0;
        if($this->getIdDepto() == 0){
            throw new Exception("Departamento->eliminar(): error, faltan datos");
        }else{
            if($oAD->Conecta()){
                $sQuery = "call eliminarDepartamento(".$this->getIdDepto().");";
                $i = $oAD->ejecutaComando($sQuery);
                $oAD->Desconecta();
            }
        }
        return $i;
    }


}
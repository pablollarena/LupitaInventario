<?php

/**
 * Created by PhpStorm.
 * User: PLLARENA
 * Date: 03/11/2016
 * Time: 12:15 PM
 */
require_once ("AccesoDatos.php");
class Sucursales
{
    private $oAD = null;
    private $nIdSucursal = 0;
    private $sNombre = "";


    public function getAD()
    {
        return $this->oAD;
    }

    public function setAD($oAD)
    {
        $this->oAD = $oAD;
    }

    public function getIdSucursal()
    {
        return $this->nIdSucursal;
    }

    public function setIdSucursal($nIdSucursal)
    {
        $this->nIdSucursal = $nIdSucursal;
    }

    public function getNombre()
    {
        return $this->sNombre;
    }

    public function setNombre($sNombre)
    {
        $this->sNombre = $sNombre;
    }

    function buscarTodos(){
        $oAD = new AccesoDatos();
        $sQuery = "";
        $vObj = null;
        $rst = null;
        $i = 0;
        $oSuc = null;
        if($oAD->Conecta()){
            $sQuery = "call buscarTodosSucursales();";
            $rst = $oAD->ejecutaQuery($sQuery);
            $oAD->Desconecta();
        }
        if($rst){
            foreach ($rst as $vRow){
                $oSuc = new Sucursales();
                $oSuc->setIdSucursal($vRow[0]);
                $oSuc->setNombre($vRow[1]);
                $vObj[$i] = $oSuc;
                $i = $i + 1;
            }
        }else{
            $vObj = false;
        }
        return $vObj;
    }

    function buscarDatosSucursal(){
        $oAD = new AccesoDatos();
        $sQuery = "";
        $rst = null;
        $bRet = false;
        if($this->getIdSucursal() == 0){
            throw new Exception("Sucursales->buscarDatosPersonales(): error, faltan datos");
        }else{
            if($oAD->Conecta()){
                $sQuery = "call buscarDatosSucursal(".$this->getIdSucursal().");";
                $rst = $oAD->ejecutaQuery($sQuery);
                $oAD->Desconecta();
                if($rst){
                    $this->setIdSucursal($rst[0][0]);
                    $this->setNombre($rst[0][1]);
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
            $sQuery = "call insertarSucursal('".$this->getNombre()."');";
            $i = $oAD->ejecutaComando($sQuery);
            $oAD->Desconecta();
        }
        return $i;
    }

    function modificar(){
        $oAD = new AccesoDatos();
        $sQuery = "";
        $i = -1;
        if($this->getIdSucursal() == 0){
            throw new Exception("Sucursales->modificar(): error, faltan datos");
        }else{
            if($oAD->Conecta()){
                $sQuery = "call updateSucursal(".$this->getIdSucursal().",'".$this->getNombre()."');";
                $i = $oAD->ejecutaComando($sQuery);
                $oAD->Desconecta();
            }
        }
        return $i;
    }

    function eliminar(){
        $oAD = new AccesoDatos();
        $sQuery = "";
        $i =  -1;
        if($this->getIdSucursal() == 0){
            throw new Exception("Sucusales->eliminar(): error, faltan datos");
        }else{
            if($oAD->Conecta()){
                $sQuery = "call eliminarSucursal(".$this->getIdSucursal().");";
                $i = $oAD->ejecutaComando($sQuery);
                $oAD->Desconecta();
            }
        }
        return $i;
    }

}
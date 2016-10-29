<?php

/**
 * Created by PhpStorm.
 * User: PLLARENA
 * Date: 27/10/2016
 * Time: 12:43 PM
 */
require_once ("AccesoDatos.php");
class Software
{
    private $oAD = null;
    private $nIdSoftware = 0;
    private $sDescripcion = "";


    public function getAD()
    {
        return $this->oAD;
    }

    public function setAD($oAD)
    {
        $this->oAD = $oAD;
    }

    public function getIdSoftware()
    {
        return $this->nIdSoftware;
    }

    public function setIdSoftware($nIdSoftware)
    {
        $this->nIdSoftware = $nIdSoftware;
    }

    public function getDescripcion()
    {
        return $this->sDescripcion;
    }

    public function setDescripcion($sDescripcion)
    {
        $this->sDescripcion = $sDescripcion;
    }

    function buscarTodos(){
        $oAD = new AccesoDatos();
        $vObj = null;
        $rst = null;
        $sQuery = "";
        $i = 0;
        $oSoftware = null;
        if($oAD->Conecta()){
            $sQuery = "call buscarTodosSoftware();";
            $rst = $oAD->ejecutaQuery($sQuery);
            $oAD->Desconecta();
        }
        if($rst){
            foreach ($rst as $vRow){
                $oSoftware = new Software();
                $oSoftware->setIdSoftware($vRow[0]);
                $oSoftware->setDescripcion($vRow[1]);
                $vObj[$i] = $oSoftware;
                $i = $i + 1;
            }
        }else{
            $vObj = false;
        }
        return $vObj;
    }

    function insertar(){
        $oAD = new AccesoDatos();
        $sQuery = "";
        $i = 0;
        if($this->getDescripcion() == ""){
            throw new Exception("Software->insertar(): error, faltan datos");
        }else{
            if($oAD->Conecta()){
                $sQuery = "call insertarSoftware('".$this->getDescripcion()."');";
                $i = $oAD->ejecutaComando($sQuery);
                $oAD->Desconecta();
            }
        }
        return $i;
    }

}
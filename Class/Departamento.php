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
                $vOb[$i] = $oDepto;
                $i = $i + 1;
            }
        }else{
            $vObj = false;
        }
        return $vObj;
    }


}
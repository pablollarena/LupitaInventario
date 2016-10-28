<?php

/**
 * Created by PhpStorm.
 * User: PLLARENA
 * Date: 27/10/2016
 * Time: 12:43 PM
 */
require_once ("AccesoDatos.php");
class Usuarios
{
    private $oAD = null;
    private $nIdUsuario = 0;
    private $sUsuario = "";
    private $sClave = "";

    public function getAD()
    {
        return $this->oAD;
    }

    public function setAD($oAD)
    {
        $this->oAD = $oAD;
    }

    public function getIdUsuario()
    {
        return $this->nIdUsuario;
    }

    public function setIdUsuario($nIdUsuario)
    {
        $this->nIdUsuario = $nIdUsuario;
    }

    public function getUsuario()
    {
        return $this->sUsuario;
    }

    public function setUsuario($sUsuario)
    {
        $this->sUsuario = $sUsuario;
    }

    public function getClave()
    {
        return $this->sClave;
    }

    public function setClave($sClave)
    {
        $this->sClave = $sClave;
    }

    function buscarTodos(){
        $oAD = new AccesoDatos();
        $vObj = null;
        $rst = null;
        $i = 0;
        $sQuery = "";
        $oUser = null;
        if($oAD->Conecta()){
            $sQuery = "call buscarTodosUsuarios()";
            $rst = $oAD->ejecutaQuery($sQuery);
            $oAD->Desconecta();
        }
        if($rst){
            foreach ($rst as $vRow){
                $oUser = new Usuarios();
                $oUser->setIdUsuario($vRow[0]);
                $oUser->setUsuario($vRow[1]);
                $vObj[$i] = $oUser;
                $i = $i + 1;
            }
        }else{
            $vObj = false;
        }
        return $vObj;
    }

    function buscarCvePassUser(){
        $oAD = new AccesoDatos();
        $sQuery = "";
        $rst = null;
        $bRet = false;
        if($this->getUsuario() == "" AND $this->getClave() == ""){
            throw new Exception("Usuarios->buscarCvePassUser(): error, faltan datos");
        } else{
            if($oAD->Conecta()){
                $sQuery = "call buscarCvePass('".$this->getUsuario()."','".$this->getClave()."');";
                $rst = $oAD->ejecutaQuery($sQuery);
                $oAD->Desconecta();
                if($rst){
                    $this->setUsuario($rst[0][0]);
                    $bRet = true;
                }
            }
        }
        return $bRet;
    }

}
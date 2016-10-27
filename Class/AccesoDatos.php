<?php

/**
 * Created by PhpStorm.
 * User: PLLARENA
 * Date: 27/10/2016
 * Time: 11:01 AM
 */
class AccesoDatos
{
    private $oConexion=null;
    function Conecta(){
        $bRet=false;
        try{
            $this->oConexion=new mysqli("localhost","adminiventario","sisadmin0303","cinventario");
            $this->oConexion->set_charset("utf8");
        }catch(Exception $ex){
            throw $ex;
        }
        if(mysqli_connect_error())
            throw new Exception(mysqli_connect_error());
        else
            $bRet=true;
        return $bRet;
    }
    function Desconecta(){
        $bRet=true;
        if($this->oConexion !=null){
            $bRet=$this->oConexion->close();
        }
        return $bRet;
    }
    function ejecutaQuery($psQuery){
        $arrRS=null;
        $rst=null;
        $oLinea=null;
        $sValCol="";
        $i=0;
        $j=0;
        if($psQuery == ""){
            throw new Exception("AccesoDatos->ejecutaQuery(): Falta indicar el query");
        }
        try{
            $rst=$this->oConexion->query($psQuery);
        }catch(Exception $ex){
            throw $ex;
        }
        if($this->oConexion->error==""){
            while($oLinea = $rst->fetch_object()){
                foreach($oLinea as $sValCol){
                    $arrRS[$i][$j]=$sValCol;
                    $j++;
                }
                $j=0;
                $i++;
            }
            $rst->close();
        }
        else{
            throw new Exception($this->oConexion->error);
        }
        return $arrRS;
    }
    function ejecutaComando($psCommand){
        $nAfectados=-1;
        if($psCommand==""){
            throw new Exception("AccesoDatos->ejecutaComando: falta indicar el comando");
        }
        if($this->oConexion==null){
            throw new Exception("AccesoDatos->ejecutaComando: Falta conectar a la base de datos");
        }
        try{
            $this->oConexion->query($psCommand);
            $nAfectados=$this->oConexion->affected_rows;
        }catch(Exception $ex){
            throw $ex;
        }
        return $nAfectados;
    }
}
<?php

class usuarioModel extends MySql{

  private $Idusuario;
  private $Idmacceso;
  private $Cod_usuario;
  private $Desc_usuario;
  private $Direccion;
  private $Telefono;
  private $Email;
  private $Clave;
  private $Imagen;
  private $Fechareg;
  private $Estatus;

  public function __construct(){
    parent::__construct();
  }

  public function SelectDt(){
    try {
      $sql = "SELECT 
      u.idusuario,u.idmacceso,u.cod_usuario,u.desc_usuario,u.direccion,u.telefono,u.email,u.clave,
      u.imagen,u.fechareg,u.estatus,u.idempresa,ma.cod_macceso,ma.desc_macceso,ma.departamento
      FROM tbusuario u INNER JOIN tbmacceso ma ON ma.idmacceso=u.idmacceso";
      $req = $this->SelectAll($sql);
      return $req;
    } catch (PDOException $e){
      return PDOError($e,'');
    }
  }

  public function ListDt(){
    try {
      $sql = "SELECT * FROM tbusuario WHERE estatus='1' ORDER BY cod_usuario";
      $req = $this->SelectAll($sql);
      return $req;
    } catch (PDOException $e){
      return PDOError($e,'');
    }
  }

  public function ShowDt($id){
    $this->Idusuario = $id;
    try {
      $sql = "SELECT 
      u.idusuario,u.idmacceso,u.cod_usuario,u.desc_usuario,u.direccion,u.telefono,u.email,u.clave,
      u.imagen, DATE_FORMAT(u.fechareg,'%d/%m/%Y') AS fechareg,u.estatus,u.idempresa,ma.cod_macceso,ma.desc_macceso,ma.departamento
      FROM tbusuario u INNER JOIN tbmacceso ma ON ma.idmacceso=u.idmacceso
      WHERE u.idusuario='$this->Idusuario'";
      $req = $this->Select($sql);
      return $req;
    } catch (PDOException $e){
      return PDOError($e,'');
    }
  }

  public function InsertDt($idmacceso,$cod_usuario,$desc_usuario,$direccion,
    $telefono,$email,$clave,$imagen,$fechareg){
    $this->Idmacceso=$idmacceso;
    $this->Cod_usuario=$cod_usuario;
    $this->Desc_usuario=$desc_usuario;
    $this->Direccion=$direccion;
    $this->Telefono=$telefono;
    $this->Email=$email;
    $this->Clave=$clave;
    $this->Imagen=$imagen;
    $this->Fechareg=$fechareg;
    $this->Estatus='1';
    try {
      $queryInsert = "INSERT INTO tbusuario(idmacceso,cod_usuario,desc_usuario,direccion,
        telefono,email,clave,imagen,fechareg,estatus)VALUES(?,?,?,?,?,?,?,?,?,?)";
      $arrData = array(
        $this->Idmacceso, $this->Cod_usuario, $this->Desc_usuario, $this->Direccion,
        $this->Telefono, $this->Email, $this->Clave, $this->Imagen, $this->Fechareg, $this->Estatus);
        $request=$this->Insert($queryInsert, $arrData);
        return $request;
    } catch (PDOException $e) {
      return PDOError($e,'insert');
    }
  }

  public function EditarDt($idusuario,$idmacceso,$cod_usuario,$desc_usuario,$direccion,
    $telefono,$email,$clave,$imagen,$fechareg){
    $this->Idusuario=$idusuario;
    $this->Idmacceso=$idmacceso;
    $this->Cod_usuario=$cod_usuario;
    $this->Desc_usuario=$desc_usuario;
    $this->Direccion=$direccion;
    $this->Telefono=$telefono;
    $this->Email=$email;
    $this->Clave=$clave;
    $this->Imagen=$imagen;
    $this->Fechareg=$fechareg;
    try {
      $sql = "UPDATE tbusuario SET 
      idmacceso=?,cod_usuario=?,desc_usuario=?,direccion=?,telefono=?,email=?,clave=?,imagen=?,fechareg = ? 
      WHERE idusuario = '$this->Idusuario'";
      $arrData = array(
        $this->Idmacceso, $this->Cod_usuario, $this->Desc_usuario, $this->Direccion,
        $this->Telefono, $this->Email, $this->Clave, $this->Imagen, $this->Fechareg);
        return $this->Update($sql, $arrData);
    } catch (PDOException $e) {
      return PDOError($e,'update');
    }
  }

  public function EstatusDt($id,$st){
    $this->Idusuario = $id;
    $this->Estatus = $st;
    try {
      $sql = "UPDATE tbusuario SET estatus=? WHERE idusuario= $this->Idusuario";
      $arrData = array($this->Estatus);
      $request = $this->Update($sql, $arrData);
      return $request;
    } catch (PDOException $e){
      return PDOError($e,'');
    }
  }

  public function EliminarDt($id){
    $returnData = "";
    $this->Idusuario=$id;

    try {
      $sql="DELETE FROM tbusuario WHERE idusuario = '$this->Idusuario'";
      $arrData=array($this->Idusuario);
      $returnData =$this->Delete($sql,$arrData);
      return $returnData;
    } catch (PDOException $e) {
      return PDOError($e,'delete');
    }
  }

  public function ListarMarcados($id){
    $this->Idmacceso=$id;
    try {
      $sql="SELECT 
      uc.idacceso,
      uc.idmacceso,
      uc.idusuarioac
      FROM tbusuarioac uc
      WHERE uc.idmacceso='$this->Idmacceso'";
      $request=$this->SelectAll($sql);     
      return $request;
    } catch (PDOException $e){
      return PDOError($e,'');
    }
  }

  public function Verificar($cod_usuario){
    $returnData = "";
    $this->Cod_usuario=$cod_usuario;

    $sql = "SELECT idusuario FROM tbusuario WHERE cod_usuario='$this->Cod_usuario'";
    $request = $this->SelectAll($sql);
  
    if ($request) {
      $sql1="SELECT u.idusuario,u.cod_usuario,u.desc_usuario,u.direccion,u.telefono,u.email,u.imagen,
      u.clave,u.idmacceso,ma.cod_macceso,ma.desc_macceso,ma.departamento,u.estatus
      FROM tbusuario u 
      INNER JOIN tbmacceso ma ON ma.idmacceso=u.idmacceso
      WHERE cod_usuario='$this->Cod_usuario'";
      $returnData = $this->SelectAll($sql1);
    } else {
      $returnData='false';
    }
      return $returnData;
  }
}


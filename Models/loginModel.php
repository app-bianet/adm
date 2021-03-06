<?php 
class loginModel extends MySql{
  private $Cod_usuario;
  private $Idmacceso;
  
  public function __construct(){
    parent::__construct();
  }

  public function Verificar(string $cod_usuario){
    $returnData = "";
    $this->Cod_usuario=$cod_usuario;

    $sql = "SELECT idusuario FROM tbusuario WHERE cod_usuario='$this->Cod_usuario'";
    $request = $this->SelectAll($sql);

    try {
      if ($request) {
        $sql="SELECT u.idusuario,u.cod_usuario,u.desc_usuario,u.direccion,u.telefono,u.email,u.imagen,
        u.clave,u.idmacceso,ma.cod_macceso,ma.desc_macceso,ma.departamento,u.estatus
        FROM tbusuario u 
        INNER JOIN tbmacceso ma ON ma.idmacceso=u.idmacceso
        WHERE cod_usuario='$this->Cod_usuario'";
        $returnData = $this->SelectAll($sql);
      } else {
        $returnData='false';
      }
      return $returnData;
    } catch (PDOException $e){
      return PDOError($e,'');
    }
  }

  public function ListarMarcados(int $id){
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

  public function EditarClave($id, $clave){
    $this->Idusuario = $id;
    $this->Clave = $clave;
    try {
      $sql = "UPDATE tbusuario SET clave =? WHERE idusuario = '$this->Idusuario'";
      $arrData = array($this->Clave);
      $request = $this->Update($sql, $arrData);
      return $request;
    } catch (PDOException $e){
      return PDOError($e,'');
    }
  }
}
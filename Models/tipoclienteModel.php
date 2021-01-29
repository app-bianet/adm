<?php
  class tipoclienteModel extends MySql{

    private $Idtipocliente;
    private $Idtipoprecio;
    private $Cod_tipocliente;
    private $Desc_tipocliente;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      $sql="SELECT tc.idtipocliente,tc.idtipoprecio, tc.cod_tipocliente,tc.desc_tipocliente,tp.cod_tipoprecio,tp.desc_tipoprecio,tc.estatus
      FROM tbtipocliente tc
      INNER JOIN tbtipoprecio tp on tp.idtipoprecio=tc.idtipoprecio";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ListDt(){
      $sql="SELECT * FROM tbtipocliente 
      WHERE estatus='1' ORDER BY cod_tipocliente ASC";
      $req=$this->SelectAll($sql);
      return $req;
    }
 
    public function ShowDt($id){
      $this->Idtipocliente=$id;
      $sql="SELECT tc.idtipocliente,tc.idtipoprecio, tc.cod_tipocliente,tc.desc_tipocliente,tp.cod_tipoprecio,tp.desc_tipoprecio,tc.estatus
      FROM tbtipocliente tc
      INNER JOIN tbtipoprecio tp on tp.idtipoprecio=tc.idtipoprecio
      WHERE tc.idtipocliente='$this->Idtipocliente'";
      $req=$this->Select($sql);
      return $req;
    }

    // public function ShowDtC($id){
    //   $this->Idtipocliente=$id;
    //   $sql="SELECT * FROM tbtipocliente
    //   WHERE idtipocliente='$this->Idtipoprecio'";
    //   $req=$this->Select($sql);
    //   return $req;
    // }
  
    public function EstatusDt($id,$st){
      $this->Idtipocliente=$id;
      $this->Estatus=$st;

      $sql="UPDATE tbtipocliente SET estatus=? WHERE idtipocliente='$this->Idtipocliente'";
      $arrData=array($this->Estatus);
      $request=$this->Update($sql,$arrData);
      return $request;
    }

    public function InsertDt($idtipoprecio,$cod_tipocliente,$desc_tipocliente){
      $this->Idtipoprecio=$idtipoprecio;
      $this->Cod_tipocliente=$cod_tipocliente;
      $this->Desc_tipocliente=$desc_tipocliente;
      $this->Estatus='1';

      try {
        $queryInsert="INSERT INTO tbtipocliente(idtipoprecio,cod_tipocliente, desc_tipocliente,estatus) VALUES(?,?,?,?)";
        $arrData=array($this->Idtipoprecio,$this->Cod_tipocliente,$this->Desc_tipocliente,$this->Estatus);
        $this->Insert($queryInsert,$arrData);
        return true;
      } catch(PDOException $e){
        if($e->getCode()=='23000'){
          return 'duplicado';
        } else {
          return 'error_insert';
        }
      }
    }

    public function EditarDt($id,$idtipoprecio,$cod_tipocliente,$desc_tipocliente){
      $this->Idtipocliente=$id;
      $this->Idtipoprecio=$idtipoprecio;
      $this->Cod_tipocliente=$cod_tipocliente;
      $this->Desc_tipocliente=$desc_tipocliente;

      try {
        $sql="UPDATE tbtipocliente SET cod_tipocliente=?,desc_tipocliente=?,idtipoprecio=? WHERE idtipocliente='$this->Idtipocliente'";
        $arrData=array($this->Cod_tipocliente,$this->Desc_tipocliente,$this->Idtipoprecio);
        $this->Update($sql,$arrData);
        return true;
      } catch(PDOException $e){
        if($e->getCode()=='23000'){
          return 'duplicado';
        } else {
          return 'error_update';
        }
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idtipocliente=$id;

      try {
        $sql="DELETE FROM tbtipocliente WHERE idtipocliente = '$this->Idtipocliente'";
        $arrData=array($this->Idtipocliente);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        if($e->getCode()=='23000'){
          return 'duplicado';
        } else {
          return 'error_delete';
        }
      }
    }

  }
<?php
  class tipoproveedorModel extends MySql{

    private $Idtipoproveedor;
    private $Cod_tipoproveedor;
    private $Desc_tipoproveedor;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      $sql="SELECT * FROM tbtipoproveedor";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ListDt(){
      $sql="SELECT * FROM tbtipoproveedor WHERE estatus='1'  ORDER BY cod_tipoproveedor ASC";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ShowDt($id){
      $this->Idtipoproveedor=$id;
      $sql="SELECT * 
      FROM tbtipoproveedor
      WHERE idtipoproveedor='$this->Idtipoproveedor'";
      $req=$this->Select($sql);
      return $req;
    }
   
    public function EstatusDt($id,$st){
      $this->Idtipoproveedor=$id;
      $this->Estatus=$st;

      $sql="UPDATE tbtipoproveedor SET estatus=? WHERE idtipoproveedor='$this->Idtipoproveedor'";
      $arrData=array($this->Estatus);
      $request=$this->Update($sql,$arrData);
      return $request;
    }

    public function InsertDt($cod_tipoproveedor,$desc_tipoproveedor){
      $this->Cod_tipoproveedor=$cod_tipoproveedor;
      $this->Desc_tipoproveedor=$desc_tipoproveedor;
      $this->Estatus='1';

      try{  
        $queryInsert="INSERT INTO tbtipoproveedor(cod_tipoproveedor, desc_tipoproveedor,estatus) VALUES(?,?,?)";
        $arrData=array($this->Cod_tipoproveedor,$this->Desc_tipoproveedor,$this->Estatus);
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

    public function EditarDt($id, $cod_tipoproveedor, $desc_tipoproveedor){
      $this->Idtipoproveedor=$id;
      $this->Cod_tipoproveedor=$cod_tipoproveedor;
      $this->Desc_tipoproveedor=$desc_tipoproveedor;
      try{  
        $sql="UPDATE tbtipoproveedor SET cod_tipoproveedor=?,desc_tipoproveedor=? WHERE idtipoproveedor='$this->Idtipoproveedor'";
        $arrData=array($this->Cod_tipoproveedor,$this->Desc_tipoproveedor);
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
      $this->Idtipoproveedor=$id;

      try {
        $sql="DELETE FROM tbtipoproveedor WHERE idtipoproveedor = '$this->Idtipoproveedor'";
        $arrData=array($this->Idtipoproveedor);
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
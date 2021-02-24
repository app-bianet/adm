<?php
  class tipoprecioModel extends MySql{

    private $Idtipoprecio;
    private $Cod_tipoprecio;
    private $Desc_tipoprecio;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      try {
        $sql="SELECT idtipoprecio, cod_tipoprecio, desc_tipoprecio, estatus FROM tbtipoprecio";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDt(){
      try{
        $sql="SELECT idtipoprecio, cod_tipoprecio, desc_tipoprecio, estatus 
        FROM tbtipoprecio WHERE estatus='1'  ORDER BY cod_tipoprecio ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      $this->Idtipoprecio=$id;
      try {
        $sql="SELECT idtipoprecio, cod_tipoprecio, desc_tipoprecio, estatus 
        FROM tbtipoprecio
        WHERE idtipoprecio='$this->Idtipoprecio'";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function EstatusDt($id,$st){
      $this->Idtipoprecio=$id;
      $this->Estatus=$st;
      try {
        $sql="UPDATE tbtipoprecio SET estatus=? WHERE idtipoprecio='$this->Idtipoprecio'";
        $arrData=array($this->Estatus);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($cod_tipoprecio,$desc_tipoprecio){
      $this->Cod_tipoprecio=$cod_tipoprecio;
      $this->Desc_tipoprecio=$desc_tipoprecio;
      $this->Estatus='1';
      try{  
        $queryInsert="INSERT INTO tbtipoprecio(cod_tipoprecio, desc_tipoprecio,estatus) VALUES(?,?,?)";
        $arrData=array($this->Cod_tipoprecio,$this->Desc_tipoprecio,$this->Estatus);
        $request=$this->Insert($queryInsert,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id, $cod_tipoprecio, $desc_tipoprecio){
      $this->Idtipoprecio=$id;
      $this->Cod_tipoprecio=$cod_tipoprecio;
      $this->Desc_tipoprecio=$desc_tipoprecio;
      try{  
        $sql="UPDATE tbtipoprecio SET cod_tipoprecio=?,desc_tipoprecio=? WHERE idtipoprecio='$this->Idtipoprecio'";
        $arrData=array($this->Cod_tipoprecio,$this->Desc_tipoprecio);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idtipoprecio=$id;
      try {
        $sql="DELETE FROM tbtipoprecio WHERE idtipoprecio = '$this->Idtipoprecio'";
        $arrData=array($this->Idtipoprecio);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }
    }

  }
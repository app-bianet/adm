<?php
  class lineaModel extends MySql{

    private $Idlinea;
    private $Idcategoria;
    private $Cod_linea;
    private $Desc_linea;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      try {
        $sql="SELECT l.idlinea,l.idcategoria, l.cod_linea,l.desc_linea,c.cod_categoria,c.desc_categoria,l.estatus
        FROM tblinea l
        INNER JOIN tbcategoria c on c.idcategoria=l.idcategoria";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDt(){
      try {
        $sql="SELECT idlinea,idcategoria,cod_linea, desc_linea,estatus FROM tblinea
        WHERE estatus='1' ORDER BY cod_linea ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }
 
    public function ShowDt($id){
      $this->Idlinea=$id;
      try {
        $sql="SELECT l.idlinea,l.idcategoria, l.cod_linea,l.desc_linea,c.cod_categoria,c.desc_categoria,l.estatus
        FROM tblinea l
        INNER JOIN tbcategoria c on c.idcategoria=l.idcategoria
        WHERE l.idlinea='$this->Idlinea'";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDtc($id){
      try {
        $this->Idcategoria=$id;
        $sql="SELECT * FROM tblinea WHERE idcategoria='$this->Idcategoria'";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }
  
    public function EstatusDt($id,$st){
      $this->Idlinea=$id;
      $this->Estatus=$st;
      try {
        $sql="UPDATE tblinea SET estatus=? WHERE idlinea='$this->Idlinea'";
        $arrData=array($this->Estatus);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($idcategoria,$cod_linea,$desc_linea){
      $this->Idcategoria=$idcategoria;
      $this->Cod_linea=$cod_linea;
      $this->Desc_linea=$desc_linea;
      $this->Estatus='1';
      try {
        $queryInsert="INSERT INTO tblinea(idcategoria,cod_linea, desc_linea,estatus) VALUES(?,?,?,?)";
        $arrData=array($this->Idcategoria,$this->Cod_linea,$this->Desc_linea,$this->Estatus);
        $request=$this->Insert($queryInsert,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id,$idcategoria,$cod_linea,$desc_linea){
      $this->Idlinea=$id;
      $this->Idcategoria=$idcategoria;
      $this->Cod_linea=$cod_linea;
      $this->Desc_linea=$desc_linea;
      try {
        $sql="UPDATE tblinea SET cod_linea=?,desc_linea=?,idcategoria=? WHERE idlinea='$this->Idlinea'";
        $arrData=array($this->Cod_linea,$this->Desc_linea,$this->Idcategoria);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idlinea=$id;
      try {
        $sql="DELETE FROM tblinea WHERE idlinea = '$this->Idlinea'";
        $arrData=array($this->Idlinea);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }
    }

  }
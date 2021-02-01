<?php
  class impuestozModel extends MySql{

    private $Idimpuestoz;
    private $Cod_impuestoz;
    private $Desc_impuestoz;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      $sql="SELECT * FROM tbimpuestoz";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ListDt(){
      $sql="SELECT idimpuestoz,cod_impuestoz,desc_impuestoz FROM tbimpuestoz ORDER BY idimpuestoz";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ListRengDt($id){
      $this->Idimpuestoz=$id;
      $sql="SELECT
      idimpuestozd, 
      idimpuestoz, 
      cod_concepto, 
      desc_concepto,
      base,
      retencion,
      sustraendo
      FROM tbimpuestozd WHERE idimpuestoz='$this->Idimpuestoz'
      ORDER BY cod_concepto ASC";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ShowDt($id){
      $this->Idimpuestoz=$id;
      $sql="SELECT * 
      FROM tbimpuestoz
      WHERE idimpuestoz='$this->Idimpuestoz'";
      $req=$this->Select($sql);
      return $req;
    }
   
    public function EstatusDt($id,$st){
      $this->Idimpuestoz=$id;
      $this->Estatus=$st;
      $sql="UPDATE tbimpuestoz SET estatus=? WHERE idimpuestoz='$this->Idimpuestoz'";
      $arrData=array($this->Estatus);
      $request=$this->Update($sql,$arrData);
      return $request;
    }

    public function InsertDt($cod_impuestoz,$desc_impuestoz){
      $this->Cod_impuestoz=$cod_impuestoz;
      $this->Desc_impuestoz=$desc_impuestoz;
      $this->Estatus='1';

      try{  
        $queryInsert="INSERT INTO tbimpuestoz(cod_impuestoz, desc_impuestoz,estatus) VALUES(?,?,?)";
        $arrData=array($this->Cod_impuestoz,$this->Desc_impuestoz,$this->Estatus);
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

    public function EditarDt($id, $cod_impuestoz, $desc_impuestoz){
      $this->Idimpuestoz=$id;
      $this->Cod_impuestoz=$cod_impuestoz;
      $this->Desc_impuestoz=$desc_impuestoz;
      try{  
        $sql="UPDATE tbimpuestoz SET cod_impuestoz=?,desc_impuestoz=? WHERE idimpuestoz='$this->Idimpuestoz'";
        $arrData=array($this->Cod_impuestoz,$this->Desc_impuestoz);
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
      $this->Idimpuestoz=$id;
      try {
        $sql="DELETE FROM tbimpuestoz WHERE idimpuestoz = '$this->Idimpuestoz'";
        $arrData=array($this->Idimpuestoz);
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
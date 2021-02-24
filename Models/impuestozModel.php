<?php
  class impuestozModel extends MySql{

    private $Idimpuestoz;
    private $Idimpuestozd;
    private $Cod_impuestoz;
    private $Desc_impuestoz;
    private $Estatus;
    private $Cod_concepto;
    private $Desc_concepto;
    private $Base;
    private $Retencion;
    private $Sustraendo;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      try {
        $sql="SELECT * FROM tbimpuestoz";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDt(){
      try {
        $sql="SELECT idimpuestoz,cod_impuestoz,desc_impuestoz FROM tbimpuestoz ORDER BY idimpuestoz";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListRengDt($id){
      $this->Idimpuestoz=$id;
      try {
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
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowRengDt($id){
      $this->Idimpuestozd=$id;
      try {
        $sql="SELECT 
        id.idimpuestozd,
        id.idimpuestoz,
        i.cod_impuestoz,
        i.desc_impuestoz,
        id.cod_concepto,
        id.desc_concepto,
        id.base,
        id.retencion,
        id.sustraendo 
        FROM
        tbimpuestozd id
        INNER JOIN tbimpuestoz i ON i.idimpuestoz=id.idimpuestoz
        WHERE id.idimpuestozd='$this->Idimpuestozd'";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      $this->Idimpuestoz=$id;
      try {
        $sql="SELECT * 
        FROM tbimpuestoz
        WHERE idimpuestoz='$this->Idimpuestoz'";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }
   
    public function EstatusDt($id,$st){
      $this->Idimpuestoz=$id;
      $this->Estatus=$st;
      try {
        $sql="UPDATE tbimpuestoz SET estatus=? WHERE idimpuestoz='$this->Idimpuestoz'";
        $arrData=array($this->Estatus);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($idimpuestoz,$cod_concepto,$desc_concepto,$base,$retencion,$sustraendo){
      $this->Idimpuestoz=$idimpuestoz;
      $this->Cod_concepto=$cod_concepto;
      $this->Desc_concepto=$desc_concepto;
      $this->Base=$base;
      $this->Retencion=$retencion;
      $this->Sustraendo=$sustraendo;
      try{  
        $sql="INSERT INTO tbimpuestozd(idimpuestoz,cod_concepto,desc_concepto,base,retencion,sustraendo) 
        VALUES(?,?,?,?,?,?)";
        $arrData=array($this->Idimpuestoz,$this->Cod_concepto,$this->Desc_concepto,$this->Base,
        $this->Retencion,$this->Sustraendo);
        $request=$this->Insert($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        $e->getCode();
      }
    }

    public function EditarDt($id,$cod_concepto,$desc_concepto,$base,$retencion,$sustraendo){
      $this->Idimpuestozd=$id;
      $this->Cod_concepto=$cod_concepto;
      $this->Desc_concepto=$desc_concepto;
      $this->Base=$base;
      $this->Retencion=$retencion;
      $this->Sustraendo=$sustraendo;

      try{  
        $sql="UPDATE tbimpuestozd 
        SET cod_concepto=?, desc_concepto=? ,base=? ,retencion=?, sustraendo=?  
        WHERE idimpuestozd = '$this->Idimpuestozd'";
        $arrData=array($this->Cod_concepto,$this->Desc_concepto,$this->Base,$this->Retencion, $this->Sustraendo);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        $e->getCode();
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
        return PDOError($e,'delete');
      }
    }

  }
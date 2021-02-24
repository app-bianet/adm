<?php
  class paisModel extends MySql{

    private $Idpais;
    private $Idmoneda;
    private $Cod_pais;
    private $Desc_pais;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      $sql="SELECT p.idpais,p.idmoneda, p.cod_pais,p.desc_pais,m.cod_moneda,m.desc_moneda,p.estatus
      FROM tbpais p
      INNER JOIN tbmoneda m on m.idmoneda=p.idmoneda";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ListDt(){
      $sql="SELECT * FROM tbpais 
      WHERE estatus='1' ORDER BY cod_pais ASC";
      $req=$this->SelectAll($sql);
      return $req;
    }
 
    public function ShowDt($id){
      $this->Idpais=$id;
      try {
        $sql="SELECT p.idpais,p.idmoneda, p.cod_pais,p.desc_pais,m.cod_moneda,m.desc_moneda,p.estatus
        FROM tbpais p
        INNER JOIN tbmoneda m on m.idmoneda=p.idmoneda
        WHERE p.idpais='$this->Idpais'";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }
  
    public function EstatusDt($id,$st){
      $this->Idpais=$id;
      $this->Estatus=$st;
      try {
        $sql="UPDATE tbpais SET estatus=? WHERE idpais='$this->Idpais'";
        $arrData=array($this->Estatus);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($idmoneda,$cod_pais,$desc_pais){
      $this->Idmoneda=$idmoneda;
      $this->Cod_pais=$cod_pais;
      $this->Desc_pais=$desc_pais;
      $this->Estatus='1';
      try {
        $queryInsert="INSERT INTO tbpais(idmoneda,cod_pais, desc_pais,estatus) VALUES(?,?,?,?)";
        $arrData=array($this->Idmoneda,$this->Cod_pais,$this->Desc_pais,$this->Estatus);
        $request=$this->Insert($queryInsert,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id,$idmoneda,$cod_pais,$desc_pais){
      $this->Idpais=$id;
      $this->Idmoneda=$idmoneda;
      $this->Cod_pais=$cod_pais;
      $this->Desc_pais=$desc_pais;
      try {
        $sql="UPDATE tbpais SET cod_pais=?,desc_pais=?,idmoneda=? WHERE idpais='$this->Idpais'";
        $arrData=array($this->Cod_pais,$this->Desc_pais,$this->Idmoneda);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idpais=$id;
      try {
        $sql="DELETE FROM tbpais WHERE idpais = '$this->Idpais'";
        $arrData=array($this->Idpais);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }
    }

  }
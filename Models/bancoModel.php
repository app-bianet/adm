<?php
  class bancoModel extends MySql{

    private $Idbanco;
    private $Idmoneda;
    private $Cod_banco;
    private $Desc_banco;
    private $Telefono;
    private $Plazo1;
    private $Plazo2;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      try {
        $sql="SELECT 
        b.idbanco,
        b.idmoneda,
        b.cod_banco,
        b.desc_banco,
        m.cod_moneda,
        m.desc_moneda,
        m.simbolo,
        b.telefono,
        b.plazo1,
        b.plazo2,
        b.estatus 
        FROM 
        tbbanco b
        INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDt(){
      try {
        $sql="SELECT 
        b.idbanco,
        b.idmoneda,
        b.cod_banco,
        b.desc_banco,
        m.cod_moneda,
        m.desc_moneda,
        m.simbolo,
        b.telefono,
        b.plazo1,
        b.plazo2,
        b.estatus
        FROM 
        tbbanco b
        INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda 
        WHERE b.estatus='1' ORDER BY cod_banco ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      $this->Idbanco=$id;
      try {
        $sql="SELECT 
        b.idbanco,
        b.idmoneda,
        b.cod_banco,
        b.desc_banco,
        m.cod_moneda,
        m.desc_moneda,
        m.simbolo,
        b.telefono,
        b.plazo1,
        b.plazo2,
        b.estatus
        FROM 
        tbbanco b
        INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda
        WHERE b.idbanco='$this->Idbanco'";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }
   
    public function EstatusDt($id,$st){
      $this->Idbanco=$id;
      $this->Estatus=$st;
      try {
        $sql="UPDATE tbbanco SET estatus=? WHERE idbanco='$this->Idbanco'";
        $arrData=array($this->Estatus);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($idmoneda,$cod_banco,$desc_banco,$telefono,$plazo1,$plazo2){
      $this->Idmoneda=$idmoneda;
      $this->Cod_banco=$cod_banco;
      $this->Desc_banco=$desc_banco;
      $this->Telefono=$telefono;
      $this->Plazo1=$plazo1;
      $this->Plazo2=$plazo2;
      $this->Estatus='1';
      try{  
        $queryInsert="INSERT INTO tbbanco(idmoneda,cod_banco,desc_banco,telefono,plazo1,plazo2,estatus) 
        VALUES(?,?,?,?,?,?)";
        $arrData=array($this->Idmoneda,$this->Cod_banco,$this->Desc_banco,$this->Telefono,$this->Plazo1,$this->Plazo2,$this->Estatus);
        $request=$this->Insert($queryInsert,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id,$idmoneda,$cod_banco,$desc_banco,$telefono,$plazo1,$plazo2){
      $this->Idbanco=$id;
      $this->Idmoneda=$idmoneda;
      $this->Cod_banco=$cod_banco;
      $this->Desc_banco=$desc_banco;
      $this->Telefono=$telefono;
      $this->Plazo1=$plazo1;
      $this->Plazo2=$plazo2;
      try{  
        $sql="UPDATE tbbanco SET idmoneda=?, cod_banco=?, desc_banco=?, telefono=?, plazo1=?, plazo2=? 
        WHERE idbanco='$this->Idbanco'";
        $arrData=array($this->Idmoneda,$this->Cod_banco,$this->Desc_banco,$this->Telefono,$this->Plazo1,$this->Plazo2);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idbanco=$id;
      try {
        $sql="DELETE FROM tbbanco WHERE idbanco = '$this->Idbanco'";
        $arrData=array($this->Idbanco);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }      
    }
  }
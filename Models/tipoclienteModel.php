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
      try {
        $sql="SELECT 
        tc.idtipocliente,tc.idtipoprecio, tc.cod_tipocliente,
        tc.desc_tipocliente,tp.cod_tipoprecio,tp.desc_tipoprecio,tc.estatus
        FROM tbtipocliente tc
        INNER JOIN tbtipoprecio tp on tp.idtipoprecio=tc.idtipoprecio";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDt(){
      try {
        $sql="SELECT tc.idtipocliente,tc.idtipoprecio, tc.cod_tipocliente,
        tc.desc_tipocliente,tp.cod_tipoprecio,tp.desc_tipoprecio,tc.estatus FROM tbtipocliente 
        WHERE estatus='1' ORDER BY cod_tipocliente ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }
 
    public function ShowDt($id){
      $this->Idtipocliente=$id;
      try {
        $sql="SELECT tc.idtipocliente,tc.idtipoprecio, tc.cod_tipocliente,
        tc.desc_tipocliente,tp.cod_tipoprecio,tp.desc_tipoprecio,tc.estatus
        FROM tbtipocliente tc
        INNER JOIN tbtipoprecio tp on tp.idtipoprecio=tc.idtipoprecio
        WHERE tc.idtipocliente='$this->Idtipocliente'";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }
  
    public function EstatusDt($id,$st){
      $this->Idtipocliente=$id;
      $this->Estatus=$st;
      try {
        $sql="UPDATE tbtipocliente SET estatus=? WHERE idtipocliente='$this->Idtipocliente'";
        $arrData=array($this->Estatus);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($idtipoprecio,$cod_tipocliente,$desc_tipocliente){
      $this->Idtipoprecio=$idtipoprecio;
      $this->Cod_tipocliente=$cod_tipocliente;
      $this->Desc_tipocliente=$desc_tipocliente;
      $this->Estatus='1';
      try {
        $queryInsert="INSERT INTO tbtipocliente(idtipoprecio,cod_tipocliente, desc_tipocliente,estatus) VALUES(?,?,?,?)";
        $arrData=array($this->Idtipoprecio,$this->Cod_tipocliente,$this->Desc_tipocliente,$this->Estatus);
        $request=$this->Insert($queryInsert,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'insert');
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
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'update');
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
        return PDOError($e,'delete');
      }
    }
  }
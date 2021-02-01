<?php

  class maccesoModel extends MySql{

    private $Idmacceso;
    private $Cod_macceso;
    private $Desc_macceso;
    private $Departamento;
    private $Estatus;
    private $Modulo;
    private $Accesos;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      $sql="SELECT * FROM tbmacceso";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ListDt(){
      $sql="SELECT * FROM tbmacceso WHERE estatus='1' ORDER BY cod_macceso ASC";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function EstatusDt($id,$st){
      $this->Idmacceso=$id;
      $this->Estatus=$st;

      $sql="UPDATE tbmacceso SET estatus=? WHERE idmacceso= $this->Idmacceso";
      $arrData=array($this->Estatus);
      $request=$this->Update($sql,$arrData);
      return $request;
    }

    public function ShowDt($id){
      $this->Idmacceso=$id;
      $sql="SELECT * 
      FROM tbmacceso WHERE idmacceso= $this->Idmacceso";
      $req=$this->Select($sql);
      return $req;
    }

    public function ListarModulo($modulo){
      $this->Modulo=$modulo;

      if ($this->Modulo) {
        $sql="SELECT * FROM tbacceso 
        WHERE modulo='$this->Modulo' ORDER BY idacceso ASC";
       $request=$this->SelectAll($sql);
      } else {
        $sql="SELECT * FROM tbacceso ORDER BY idacceso ASC";
        $request=$this->SelectAll($sql);
      }
      return $request;
    }

    public function ListarMarcados($id,$modulo){
      $this->Idmacceso=$id;
      $this->Modulo=$modulo;
      if ($this->Idmacceso!='' && $this->Modulo!='') {
        $sql="SELECT 
        uc.idacceso,
        ac.modulo,
        ac.desc_acceso,
        uc.idmacceso,
        uc.idusuarioac,
        CASE WHEN 
        ac.eliminar=1 THEN ac.eliminar ELSE '' END AS eliminar,
        CASE WHEN ac.editar=1 THEN ac.editar ELSE '' END AS editar
        FROM tbusuarioac uc
        INNER JOIN tbacceso ac ON ac.idacceso=uc.idacceso
        WHERE uc.idmacceso='$this->Idmacceso' AND ac.modulo='$this->Modulo'";
        $request=$this->SelectAll($sql);
      } else {
        $sql="SELECT uc.idacceso,ac.modulo,ac.desc_acceso,uc.idmacceso,uc.idusuarioac 
        FROM tbusuarioac uc
        INNER JOIN tbacceso ac ON ac.idacceso=uc.idacceso";
        $request=$this->SelectAll($sql);
      }
      return $request;
    }

    public function InsertDt($cod_macceso,$desc_macceso,$departamento,$accesos ){
      $this->Cod_macceso=$cod_macceso;
      $this->Desc_macceso=$desc_macceso;
      $this->Departamento=$departamento;
      $this->Accesos=$accesos;

      try {
        $queryInsert="INSERT INTO tbmacceso(cod_macceso, desc_macceso,departamento,estatus) VALUES(?,?,?,'1')";
        $arrData=array($this->Cod_macceso,$this->Desc_macceso,$this->Departamento);
        $requestInsert=$this->Insert($queryInsert,$arrData);
        $num_item=0;
        $contador=0;

      while ($num_item < count($this->Accesos)) {
        $sql_row = "INSERT INTO tbusuarioac(idusuarioac,idmacceso,idacceso) VALUES(?,?,?)";
        $arrData = array(('0' . $requestInsert . '01') + $contador, $requestInsert, $this->Accesos[$num_item]);
        $this->Insert($sql_row, $arrData);
        $num_item = $num_item + 1;
        $contador = $contador + 1;
      }
        return true;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id, $cod_macceso,$desc_macceso,$departamento,$accesos){
      $this->Idmacceso=$id;
      $this->Cod_macceso=$cod_macceso;
      $this->Desc_macceso=$desc_macceso;
      $this->Departamento=$departamento;
      $this->Accesos=$accesos;

      try {
        $sql="UPDATE tbmacceso SET cod_macceso=?,desc_macceso=?,departamento=? WHERE idmacceso='$this->Idmacceso'";
        $arrData=array($this->Cod_macceso,$this->Desc_macceso,$this->Departamento);
        $this->Update($sql,$arrData);

        $sql="DELETE FROM tbusuarioac WHERE idmacceso='$this->Idmacceso'";
        $arrData=array($this->Idmacceso);
        $this->Delete($sql,$arrData);
        $num_item=0;
        $contador=0;

        while ($num_item<count($this->Accesos)) {
        $sql_row = "INSERT INTO tbusuarioac(idusuarioac,idmacceso,idacceso) VALUES(?,?,?)";
        $arrData = array(($this->Idmacceso . '01') + $contador, $this->Idmacceso, $this->Accesos[$num_item]);
        $this->Insert($sql_row, $arrData);
        $num_item = $num_item + 1;
        $contador = $contador + 1;
        }
        return true;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idmacceso=$id;

      try {
        $sql="DELETE FROM tbmacceso WHERE idmacceso = '$this->Idmacceso'";
        $arrData=array($this->Idmacceso);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }
    }


  }
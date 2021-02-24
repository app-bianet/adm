<?php
  class correlativoModel extends MySql{

    private $Idcorrelativo;
    private $Cod_correlativo;
    private $Desc_correlativo;
    private $Grupo;
    private $Tabla;
    private $Cadena;
    private $Precadena;
    private $Cod_num;
    private $Largo;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      try {
        $sql="SELECT idcorrelativo,cod_correlativo,desc_correlativo,grupo,tabla,precadena as prefijo,
        REPEAT(cadena,largo) AS cadena,
        CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codigo,
        largo,estatus
        FROM tbcorrelativo";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDt(){
      try {
        $sql="SELECT idcorrelativo, cod_correlativo, desc_correlativo, grupo, tabla, precadena as prefijo,
        REPEAT(cadena,largo) AS cadena,
        CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codigo,
        largo, estatus 
        FROM tbcorrelativo 
        WHERE estatus='1'
        ORDER BY cod_correlativo ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      $this->Idcorrelativo=$id;
      try {
        $sql="SELECT 
        idcorrelativo, 
        cod_correlativo,
        desc_correlativo,
        grupo,
        tabla,
        precadena,
        cadena,
        largo,
        cod_num,
        estatus 
        FROM tbcorrelativo
        WHERE idcorrelativo ='$this->Idcorrelativo'";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function GenerarCod($tabla){
      $this->Tabla=$tabla;
      try {
        $sql="SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum,estatus
        FROM tbcorrelativo WHERE tabla='$this->Tabla'";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }
  
    public function ActCod($tabla){
      $this->Tabla=$tabla;
      try {
        $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='$this->Tabla'";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function EstatusDt($id,$st){
      $this->Idcorrelativo=$id;
      $this->Estatus=$st;
      try {
        $sql="UPDATE tbcorrelativo SET estatus=? WHERE idcorrelativo='$this->Idcorrelativo'";
        $arrData=array($this->Estatus);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($cod_correlativo,$desc_correlativo,$grupo,$tabla,$cadena,$precadena,$cod_num,$largo){
      $this->Cod_correlativo=$cod_correlativo;
      $this->Desc_correlativo=$desc_correlativo;
      $this->Grupo = $grupo;
      $this->Tabla = $tabla;
      $this->Cadena = $cadena;
      $this->Precadena = $precadena;
      $this->Cod_num = $cod_num;
      $this->Largo = $largo;
      $this->Estatus='1';
      try{  
        $queryInsert="INSERT INTO tbcorrelativo(cod_correlativo,desc_correlativo,grupo,tabla,cadena,
        precadena,cod_num,largo,estatus) VALUES(?,?,?,?,?,?,?,?,?)";
        $arrData=array($this->Cod_correlativo,$this->Desc_correlativo,$this->Grupo,$this->Tabla,$this->Cadena,
        $this->Precadena,$this->Cod_num,$this->Largo,$this->Estatus);
        $request = $this->Insert($queryInsert,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id,$cod_correlativo,$desc_correlativo,$grupo,$tabla,$cadena,$precadena,$cod_num,$largo){
      $this->Idcorrelativo=$id;
      $this->Cod_correlativo=$cod_correlativo;
      $this->Desc_correlativo=$desc_correlativo;
      $this->Grupo = $grupo;
      $this->Tabla = $tabla;
      $this->Cadena = $cadena;
      $this->Precadena = $precadena;
      $this->Cod_num = $cod_num;
      $this->Largo = $largo;
      try{  
        $sql="UPDATE tbcorrelativo SET 
        cod_correlativo=?,
        desc_correlativo=?,
        grupo=?,
        tabla=?,
        cadena=?,
        precadena=?,
        cod_num=?,
        largo=? 
        WHERE idcorrelativo='$this->Idcorrelativo'";
        $arrData=array($this->Cod_correlativo,$this->Desc_correlativo,$this->Grupo,$this->Tabla,$this->Cadena,
        $this->Precadena,$this->Cod_num,$this->Largo);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idcorrelativo=$id;
      try {
        $sql="DELETE FROM tbcorrelativo WHERE idcorrelativo = '$this->Idcorrelativo'";
        $arrData=array($this->Idcorrelativo);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }
    }
  }
<?php
  class movcajaModel extends MySql{

    private $Idmovcaja;
    private $Idcaja;
    private $Idbanco;
    private $Idoperacion;
    private $Idusuario;
    private $Cod_movcaja;
    private $Desc_movcaja;
    private $Tipo;
    private $Forma;
    private $Numerod;
    private $Numeroc;
    private $Origen;
    private $Montod;
    private $Montoh;
    private $Saldoinicial;
    private $Fechareg;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function ActCod(){
      try {
        $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbmovcaja'";
        $require=$this->UpdateSet($sql);
        return $require;
      } catch (PDOException $e) {
        return PDOError($e,'');
      }
    }

    public function GenerarCod($id){
      $this->Idmovcaja=$id;
      try {
        $sqlcod="UPDATE tbmovcaja 
        SET cod_movcaja=(SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum 
        FROM tbcorrelativo WHERE tabla='tbmovcaja' AND estatus='1')
        WHERE idmovcaja='$this->Idmovcaja'";
        $request=$this->UpdateSet($sqlcod);
        return $request;
      } catch (PDOException $e) {
        return PDOError($e,'');
      }
    }

    public function SelectDt(){
      try {
        $sql="SELECT
        mc.cod_movcaja,
        mc.desc_movcaja,
        c.cod_caja,
        c.desc_caja,
        c.saldototal,
        op.cod_operacion,
        op.desc_operacion,
        b.cod_banco,
        b.desc_banco,
        u.cod_usuario,
        u.desc_usuario,
        mc.estatus,
        mc.tipo,
        mc.forma,
        mc.numerod,
        mc.numeroc,
        mc.origen,
        mc.montod,
        mc.montoh,
        mc.saldoinicial,
        mc.idcaja,
        mc.idmovcaja,
        mc.idbanco,
        mc.idoperacion,
        mc.idusuario,
        DATE_FORMAT(mc.fechareg,'%d/%m/%Y') AS fechareg
        FROM
        tbmovcaja AS mc
        LEFT JOIN tbbanco AS b ON (b.idbanco = mc.idbanco)
        INNER JOIN tbcaja AS c ON (mc.idcaja = c.idcaja)
        INNER JOIN tboperacion AS op ON (mc.idoperacion = op.idoperacion)
        INNER JOIN tbusuario AS u ON (u.idusuario = mc.idusuario)";
        $req=$this->SelectAll($sql);
        return $req;
      } catch(PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDt(){
      try {
        $sql="SELECT * FROM tbmovcaja WHERE estatus='1' ORDER BY cod_movcaja ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch(PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      try {
        $this->Idmovcaja=$id;
        $sql="SELECT
        mc.cod_movcaja,
        mc.desc_movcaja,
        c.cod_caja,
        c.desc_caja,
        c.saldototal,
        op.cod_operacion,
        op.desc_operacion,
        b.cod_banco,
        b.desc_banco,
        u.cod_usuario,
        u.desc_usuario,
        mc.estatus,
        mc.tipo,
        mc.forma,
        mc.numerod,
        mc.numeroc,
        mc.origen,
        mc.montod,
        mc.montoh,
        mc.saldoinicial,
        mc.idcaja,
        mc.idmovcaja,
        mc.idbanco,
        mc.idoperacion,
        mc.idusuario,
        DATE_FORMAT(mc.fechareg,'%d/%m/%Y') AS fechareg
        FROM
        tbmovcaja AS mc
        LEFT JOIN tbbanco AS b ON (b.idbanco = mc.idbanco)
        INNER JOIN tbcaja AS c ON (mc.idcaja = c.idcaja)
        INNER JOIN tboperacion AS op ON (mc.idoperacion = op.idoperacion)
        INNER JOIN tbusuario AS u ON (u.idusuario = mc.idusuario) 
        WHERE mc.idmovcaja='$this->Idmovcaja'";
        $request=$this->Select($sql);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'');
      }
    }

    //
    public function InsertDt($idcaja,$idbanco,$idoperacion,$idusuario,$cod_movcaja,$desc_movcaja,
      $tipo,$estatus,$forma,$numerod,$numeroc,$origen,$montod,$montoh,$saldoinicial,$fechareg){
      $this->Idcaja=$idcaja;
      $this->Idbanco=$idbanco;
      $this->Idoperacion=$idoperacion;
      $this->Idusuario=$idusuario;
      $this->Cod_movcaja=$cod_movcaja;
      $this->Desc_movcaja=$desc_movcaja==''?'Movimiento de '.$tipo.' en Caja de Fecha '.$fechareg:$desc_movcaja;
      $this->Tipo=$tipo;
      $this->Estatus=$estatus;
      $this->Forma=$forma;
      $this->Numerod=$numerod;
      $this->Numeroc=$numeroc;
      $this->Origen=$origen;
      $this->Montod=$montod;
      $this->Montoh=$montoh;
      $this->Saldoinicial=$saldoinicial;
      $this->Fechareg=formatDate($fechareg);
      try{  
        $queryInsert="INSERT INTO tbmovcaja (idcaja,idbanco,idoperacion,idusuario,cod_movcaja,desc_movcaja,
        estatus,tipo,forma,numerod,numeroc,origen,montod,montoh,saldoinicial,fechareg,fechadb) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())";
        $arrData=array($this->Idcaja,$this->Idbanco,$this->Idoperacion,$this->Idusuario,$this->Cod_movcaja,$this->Desc_movcaja,
        $this->Estatus,$this->Tipo,$this->Forma,$this->Numerod,$this->Numeroc,$this->Origen,$this->Montod,$this->Montoh,
        $this->Saldoinicial,$this->Fechareg);
        $lastInsert=$this->Insert($queryInsert,$arrData);
        $this->GenerarCod($lastInsert);
        $this->ActSaldoCaja($this->Idcaja);
        return $lastInsert;
      } catch(PDOException $e){
        //return PDOError($e,'insert');
      }
    }

    //
    public function EditarDt($id,$idcaja,$idbanco,$idoperacion,$idusuario,$cod_movcaja,$desc_movcaja,$estatus,
      $tipo,$forma,$numerod,$numeroc,$origen,$montod,$montoh,$saldoinicial,$fechareg){
      $this->Idmovcaja=$id;
      $this->Idcaja=$idcaja;
      $this->Idbanco=$idbanco;
      $this->Idoperacion=$idoperacion;
      $this->Idusuario=$idusuario;
      $this->Cod_movcaja=$cod_movcaja;
      $this->Desc_movcaja=$desc_movcaja==''?'Movimiento de '.$tipo.' en Caja de Fecha '.$fechareg:$desc_movcaja;
      $this->Tipo=$tipo;
      $this->Estatus=$estatus;
      $this->Forma=$forma;
      $this->Numerod=$numerod;
      $this->Numeroc=$numeroc;
      $this->Origen=$origen;
      $this->Montod=$montod;
      $this->Montoh=$montoh;
      $this->Saldoinicial=$saldoinicial;
      $this->Fechareg=formatDate($fechareg);
      try{  
        $sql="UPDATE 
        tbmovcaja 
        SET idcaja =?, idbanco =?, idoperacion =?,idusuario =?,cod_movcaja =?,desc_movcaja =?,estatus =?,tipo =?,
        forma = ?,numerod =?,numeroc =?,origen =?,montod =?,montoh = ?,saldoinicial = ?,fechareg = ? WHERE idmovcaja ='$this->Idmovcaja'";
        $arrData=array($this->Idcaja,$this->Idbanco,$this->Idoperacion,$this->Idusuario,$this->Cod_movcaja,$this->Desc_movcaja,
        $this->Estatus,$this->Tipo,$this->Forma,$this->Numerod,$this->Numeroc,$this->Origen,$this->Montod,$this->Montoh,
        $this->Saldoinicial,$this->Fechareg);
        $request=$this->Update($sql,$arrData);
        $this->ActSaldoCaja($this->Idcaja);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    //
    public function EliminarDt($id,$idcaja){
      $returnData = "";
      $this->Idmovcaja=$id;
      try {
        $this->ActSaldoCaja($idcaja);
        $sql="DELETE FROM tbmovcaja WHERE idmovcaja ='$this->Idmovcaja'";
        $arrData=array($this->Idmovcaja);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }   
    }

    //Implementamos Anular el Documentos
    public function AnularDt($idmovcaja,$idcaja){
      $this->Idmovcaja=$idmovcaja;
      try{
        $this->ActSaldoCaja($idcaja);
        $sql="UPDATE tbmovcaja 
        SET estatus='Anulado' 
        WHERE idmovcaja='$this->Idmovcaja'";
        $request=$this->UpdateSet($sql);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'update');
      }
    }

    //Actualizar saldo de Caja
    public function ActSaldoCaja($idcaja){
      $this->Idcaja=$idcaja;
      try {
        $sql="UPDATE 
        tbcaja 
        SET 
        saldoefectivo =(SELECT IFNULL(SUM(montod),0)-IFNULL(SUM(montoh),0) 
        FROM tbmovcaja WHERE idcaja='$this->Idcaja' AND forma='Efectivo' AND estatus<>'Anulado'),
        saldodocumento =(SELECT IFNULL(SUM(montod),0)-IFNULL(SUM(montoh),0) 
        FROM tbmovcaja WHERE idcaja='$this->Idcaja' AND forma<>'Efectivo' AND estatus<>'Anulado'),
        saldototal=saldoefectivo+saldodocumento
        WHERE idcaja ='$this->Idcaja'";
        $request=$this->UpdateSet($sql);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'update');
      }		
    }
  }
<?php
  class compracModel extends MySql{

    private $Idcompra;
    private $Idproveedor;
    private $Idcondpago;
    private $Idusuario;
    private $Cod_compra;
    private $Desc_compra;
    private $Numerod;
    private $Numeroc;
    private $Tipo;
    private $Origend;
    private $Origenc;
    private $Estatus;
    private $Subtotalh;
    private $Desch;
    private $Impuestoh;
    private $Totalh;
    private $Saldoh;
    private $Fechareg;
    private $Fechaven;

    public function __construct(){
      parent::__construct();
    }

    public function ActCod(){
      try {
        $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbccompra'";
        $require=$this->UpdateSet($sql);
        return $require;
      } catch (PDOException $e) {
        return PDOError($e,'');
      }
    }

    public function GenerarCod($id){
      $request="";
      $this->Idcompra=$id;
      try {
        $sqlcod="UPDATE tbcompra 
        SET cod_compra=(SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum 
        FROM tbcorrelativo WHERE tabla='tbccompra' AND estatus='1')
        WHERE idcompra='$this->Idcompra'";
        $arrData=array($this->Idcompra);
        $request=$this->Update($sqlcod,$arrData);
        return $request;
      } catch (PDOException $e) {
        return PDOError($e, '');
      }
    }

    public function ShowProveedor(){
      try {
        $sql="SELECT p.idproveedor, p.idcondpago, p.cod_proveedor, p.desc_proveedor, p.rif,p.limite,
        cp.cod_condpago, cp.desc_condpago,cp.dias
        FROM tbproveedor p 
        INNER JOIN tbcondpago cp ON cp.idcondpago = p.idcondpago
        WHERE p.estatus='1'";
        $request=$this->SelectAll($sql);
        return $request;
      } catch (PDOException $e) {
        return PDOError($e, '');
      }
    }

    public function SelectDt($tipo){
      $this->Tipo=$tipo;
      try {
        $sql="SELECT 
        c.idcompra,
        c.idproveedor,
        c.idcondpago,
        c.idusuario,
        c.cod_compra,
        c.desc_compra,
        pv.cod_proveedor,
        pv.desc_proveedor,
        pv.rif,
        pv.limite,
        cp.cod_condpago,
        cp.desc_condpago,
        cp.dias,
        u.cod_usuario,
        u.desc_usuario,
        c.numerod,
        c.numeroc,
        c.tipo,
        c.origend,
        c.origenc,
        c.estatus,
        c.subtotalh,
        c.impuestoh,
        c.totalh,
        c.saldoh,
        DATE_FORMAT(c.fechareg, '%d/%m/%Y') AS fechareg,
        DATE_FORMAT(c.fechaven, '%d/%m/%Y') AS fechaven
        FROM
        tbcompra AS c 
        INNER JOIN tbproveedor AS pv ON (c.idproveedor = pv.idproveedor) 
        INNER JOIN tbcondpago AS cp ON (c.idcondpago = cp.idcondpago) 
        INNER JOIN tbusuario AS u ON (c.idusuario = u.idusuario)
        WHERE c.tipo='$this->Tipo'";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e) {
        return PDOError($e,'');
      } 
    }

    //Implementar un método para listar los registros y mostrar en el select
    public function SelectArticulo($iddeposito){
      $this->Iddeposito=$iddeposito;
      try {
        $sql="SELECT
        a.cod_articulo,
        a.desc_articulo,
        a.ref,
        a.tipo,
        a.costo,
        i.tasa,
        a.estatus,
        au.idarticulo,
        a.idcategoria,
        a.idimpuesto,
        (SELECT iddeposito FROM tbdeposito WHERE iddeposito='$this->Iddeposito') AS iddeposito,
        (SELECT cod_deposito FROM tbdeposito WHERE iddeposito='$this->Iddeposito') AS cod_deposito,
        (SELECT desc_deposito FROM tbdeposito WHERE iddeposito='$this->Iddeposito') AS desc_deposito,
        IFNULL((SELECT cantidad FROM tbstock WHERE iddeposito='$this->Iddeposito' AND idarticulo=a.idarticulo),0) AS stock
        FROM tbarticulo a
        INNER JOIN tbartunidad au ON au.idarticulo=a.idarticulo
        INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto
        WHERE a.estatus='1'
        GROUP BY a.idarticulo";
        $request=$this->SelectAll($sql);
        return $request;
      } catch (PDOException $e) {
        return PDOError($e,'');
      }       
    }

    public function ListDt(){
      try{
        $sql="SELECT * FROM tbcompra WHERE estatus='1' ORDER BY cod_compra ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch(PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      $this->Idcompra=$id;
      try{
        $sql="SELECT 
        c.idcompra,
        c.idproveedor,
        c.idcondpago,
        c.idusuario,
        c.cod_compra,
        c.desc_compra,
        c.numerod,
        c.numeroc,
        c.tipo,
        c.origend,
        c.origenc,
        c.estatus,
        c.subtotalh,
        c.desch,
        c.impuestoh,
        c.totalh,
        c.saldoh,
        c.retenciona,
        DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fechareg,
        DATE_FORMAT(c.fechaven,'%d/%m/%Y') AS fechaven,
        pv.cod_proveedor,
        pv.desc_proveedor,
        pv.rif,
        cp.cod_condpago,
        cp.desc_condpago
        FROM
        tbcompra c
        INNER JOIN tbproveedor pv ON pv.idproveedor=c.idproveedor
        INNER JOIN tbcondpago cp ON cp.idcondpago=c.idcondpago
        WHERE idcompra='$this->Idcompra'
        LIMIT 0,100";
        $req=$this->Select($sql);
        return $req;
      } catch(PDOException $e){
        return PDOError($e,'');
      }
    }

    //Funcion Mostrar Detalle de Documentos
    public function MostrarDetalle($idcompra){
      $this->Idcompra=$idcompra;
      try {
        $sql="SELECT
        dc.idcomprad,
        dc.idarticulo,
        dc.iddeposito,
        dc.idartunidad,
        a.cod_articulo,
        a.desc_articulo,
        u.desc_unidad,
        a.tipo,
        dc.cantidad,
        dc.costo,
        dc.tasa,
        dc.pdesc,
        au.valor
        FROM tbcomprad dc 
        INNER JOIN tbarticulo a ON a.idarticulo=dc.idarticulo
        INNER JOIN tbartunidad au ON au.idartunidad=dc.idartunidad
        INNER JOIN tbunidad u ON u.idunidad=au.idunidad
        WHERE dc.idcompra='$this->Idcompra'";
        $request=$this->SelectAll($sql);
        return $request;
      } catch (PDOException $e) {
        return PDOError($e,'');
      }
  
    }
   
    public function InsertDt($idproveedor,$idcondpago,$idusuario,$cod_compra,$desc_compra,$numerod,$numeroc, $tipo,
      $origend,$origenc,$estatus,$subtotalh,$desch,$impuestoh,$totalh,$saldoh,$fechareg,$fechaven,
      $idarticulo,$iddeposito,$idartunidad,$cantidad,$costo,$pdesc,$tasa){
      $this->Idproveedor=$idproveedor;
      $this->Idcondpago=$idcondpago;
      $this->Idusuario=$idusuario;
      $this->Cod_compra=$cod_compra;
      $this->Desc_compra=$desc_compra==''? ''.$tipo.' de Compra de Fecha '.$fechareg:$desc_compra;
      $this->Numerod=$numerod;
      $this->Numeroc=$numeroc;
      $this->Tipo=$tipo;
      $this->Origend=$origend;
      $this->Origenc=$origenc;
      $this->Estatus=$estatus;
      $this->Subtotalh=$subtotalh;
      $this->Desch=$desch;
      $this->Impuestoh=$impuestoh;
      $this->Totalh=$totalh;
      $this->Saldoh=$saldoh;
      $this->Fechareg=$fechareg;
      $this->Fechaven=$fechaven;
      $this->Idarticulo=$idarticulo;
      $this->Iddeposito=$iddeposito;
      $this->Idartunidad=$idartunidad;
      $this->Cantidad=$cantidad;
      $this->Costo=$costo;
      $this->Pdesc=$pdesc;
      $this->Tasa=$tasa;
      try{  
        $queryInsert="INSERT INTO tbcompra(idproveedor,idcondpago,idusuario,cod_compra,desc_compra,numerod,
        numeroc,tipo,origend,origenc,estatus,subtotalh,desch,impuestoh,totalh,saldoh,fechareg,fechaven,fechadb)
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())";
        $arrData=array($this->Idproveedor,$this->Idcondpago,$this->Idusuario,$this->Cod_compra,$this->Desc_compra,
        $this->Numerod,$this->Numeroc,$this->Tipo,$this->Origend,$this->Origenc,$this->Estatus,$this->Subtotalh,$this->Desch,
        $this->Impuestoh,$this->Totalh,$this->Saldoh,$this->Fechareg,$this->Fechaven);
        $lastId=$this->Insert($queryInsert,$arrData);

        $num_elementos=0;

        while ($num_elementos < count($this->Idarticulo)){
          $sql_detalle ="INSERT INTO tbcomprad(idcompra,idarticulo,iddeposito,idartunidad,cantidad,costo,pdesc,tasa) 
          VALUES(?,?,?,?,?,?,?,?)"; 
          $arrayDt=array($lastId,$this->Idarticulo[$num_elementos],$this->Iddeposito[$num_elementos],
           $this->Idartunidad[$num_elementos],$this->Cantidad[$num_elementos],$this->Costo[$num_elementos],
           $this->Pdesc[$num_elementos],$this->Tasa[$num_elementos]);
           $this->Insert($sql_detalle,$arrayDt);
           $num_elementos=$num_elementos + 1;
        }
        $this->GenerarCod($lastId);
        $this->ActCod();
        return $lastId;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idcompra=$id;
      try {
        $sql="DELETE FROM tbcompra WHERE idcompra = '$this->Idcompra'";
        $arrData=array($this->Idcompra);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }   
    }

    //Funcion Anular / Eliminar Compra
    public function AnularDt($id){
      $returnData = "";
      $this->Idcompra=$id;
      try {
        $sql="UPDATE tbcompra set estatus='Anulado' WHERE idcompra = '$this->Idcompra'";
        $arrData=array($this->Idcompra);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }  
    }
  }
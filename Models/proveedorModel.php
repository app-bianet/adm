<?php
  class proveedorModel extends MySql{

    private $Idproveedor;
    private $Idtipoproveedor;
    private $Idoperacion;
    private $Idcondpago;
    private $Idzona;
    private $Idimpuestoz;
    private $Cod_proveedor;
    private $Desc_proveedor;
    private $Rif;
    private $Direccion;
    private $Ciudad;
    private $Codpostal;
    private $Contacto;
    private $Telefono;
    private $Movil;
    private $Email;
    private $Web;
    private $Limite;
    private $Montofiscal;
    private $Fechareg;
    private $Aplicareten;
    private $Estatus;
    private $Idcompra;
    private $Tipo;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      $sql="SELECT 
      pv.idproveedor,
      pv.idtipoproveedor,
      pv.idoperacion,
      pv.idcondpago,
      pv.idzona,
      pv.idimpuestoz,
      pv.cod_proveedor,
      pv.desc_proveedor,
      pv.rif,
      pv.direccion,
      pv.ciudad,
      pv.codpostal,
      pv.contacto,
      pv.telefono,
      pv.movil,
      pv.email,
      pv.web,
      pv.limite,
      pv.montofiscal,
      DATE_FORMAT(pv.fechareg, '%d/%m/%Y') AS fechareg,
      pv.aplicareten,
      pv.estatus,
      tc.cod_tipoproveedor,
      tc.desc_tipoproveedor,
      t.cod_operacion,
      t.desc_operacion,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      z.cod_zona,
      z.desc_zona,
      IFNULL((SELECT SUM(saldoh) FROM tbcompra 
      WHERE idproveedor = pv.idproveedor AND tipo <> 'Cotizacion' AND estatus <> 'Anulado'),0) AS saldo 
      FROM
      tbproveedor AS pv 
      INNER JOIN tbtipoproveedor AS tc ON (pv.idtipoproveedor = tc.idtipoproveedor) 
      INNER JOIN tboperacion AS t ON (pv.idoperacion = t.idoperacion) 
      INNER JOIN tbcondpago AS cp ON (pv.idcondpago = cp.idcondpago) 
      INNER JOIN tbzona AS z ON (pv.idzona = z.idzona) 
      INNER JOIN tbimpuestoz AS iz ON (iz.idimpuestoz = pv.idimpuestoz)";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ListDt(){
      $sql="SELECT * FROM tbproveedor WHERE estatus='1' ORDER BY cod_proveedor ASC";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ShowDt($id){
      $this->Idproveedor=$id;
      $sql="SELECT 
      pv.idproveedor,
      pv.idtipoproveedor,
      pv.idoperacion,
      pv.idcondpago,
      pv.idzona,
      pv.idimpuestoz,
      pv.cod_proveedor,
      pv.desc_proveedor,
      pv.rif,
      pv.direccion,
      pv.ciudad,
      pv.codpostal,
      pv.contacto,
      pv.telefono,
      pv.movil,
      pv.email,
      pv.web,
      pv.limite,
      pv.montofiscal,
      DATE_FORMAT(pv.fechareg, '%d/%m/%Y') AS fechareg,
      pv.aplicareten,
      pv.estatus,
      tc.cod_tipoproveedor,
      tc.desc_tipoproveedor,
      t.cod_operacion,
      t.desc_operacion,
      cp.cod_condpago,
      cp.desc_condpago,
      cp.dias,
      z.cod_zona,
      z.desc_zona,
      IFNULL((SELECT SUM(saldoh) FROM tbcompra 
      WHERE idproveedor = pv.idproveedor AND tipo <> 'Cotizacion' AND estatus <> 'Anulado'),0) AS saldo 
      FROM
      tbproveedor AS pv 
      INNER JOIN tbtipoproveedor AS tc ON (pv.idtipoproveedor = tc.idtipoproveedor) 
      INNER JOIN tboperacion AS t ON (pv.idoperacion = t.idoperacion) 
      INNER JOIN tbcondpago AS cp ON (pv.idcondpago = cp.idcondpago) 
      INNER JOIN tbzona AS z ON (pv.idzona = z.idzona) 
      INNER JOIN tbimpuestoz AS iz ON (iz.idimpuestoz = pv.idimpuestoz) 
      WHERE pv.idproveedor='$this->Idproveedor'";
      $req=$this->Select($sql);
      return $req;
    }
   
    public function EstatusDt($id,$st){
      $this->Idproveedor=$id;
      $this->Estatus=$st;
      $sql="UPDATE tbproveedor SET estatus=? WHERE idproveedor='$this->Idproveedor'";
      $arrData=array($this->Estatus);
      $request=$this->Update($sql,$arrData);
      return $request;
    }

    public function InsertDt($idtipoproveedor,$idoperacion,$idcondpago,$idzona,$idimpuestoz,$cod_proveedor,$desc_proveedor,
      $rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,$limite,$montofiscal,$fechareg,$aplicareten){
      $this->Idtipoproveedor =$idtipoproveedor;
      $this->Idoperacion =$idoperacion;
      $this->Idcondpago=$idcondpago;
      $this->Idzona =$idzona;
      $this->Idimpuestoz=$idimpuestoz;
      $this->Cod_proveedor=$cod_proveedor;
      $this->Desc_proveedor=$desc_proveedor;
      $this->Rif=$rif;
      $this->Direccion=$direccion;
      $this->Ciudad=$ciudad;
      $this->Codpostal=$codpostal;
      $this->Contacto=$contacto;
      $this->Telefono=$telefono;
      $this->Movil=$movil;
      $this->Email=$email;
      $this->Web=$web;
      $this->Limite=$limite;
      $this->Montofiscal=$montofiscal;
      $this->Fechareg=$fechareg;
      $this->Aplicareten=$aplicareten;
      $this->Estatus='1';
      try{  
        $queryInsert="INSERT INTO tbproveedor(idtipoproveedor,idoperacion,idcondpago,idzona,idimpuestoz,
        cod_proveedor,desc_proveedor,rif,direccion,ciudad,codpostal,contacto,telefono,movil,email,web,limite,
        montofiscal,fechareg,aplicareten,estatus) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrData=array($this->Idtipoproveedor,$this->Idoperacion,$this->Idcondpago,$this->Idzona,$this->Idimpuestoz,
        $this->Cod_proveedor,$this->Desc_proveedor,$this->Rif,$this->Direccion,$this->Ciudad,$this->Codpostal,
        $this->Contacto,$this->Telefono,$this->Movil,$this->Email,$this->Web,$this->Limite,$this->Montofiscal,
        $this->Fechareg,$this->Aplicareten,$this->Estatus);
        $this->Insert($queryInsert,$arrData);
        return true;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function InsertDirect($cod_proveedor,$desc_proveedor,$rif,$direccion){
      $this->Cod_proveedor=$cod_proveedor;
      $this->Desc_proveedor=$desc_proveedor;
      $this->Rif=$rif;
      $this->Direccion=$direccion;
      $this->Estatus='1';
      try{
        $sql="INSERT INTO tbproveedor(cod_proveedor,desc_proveedor,rif,direccion,estatus,idtipoproveedor,idoperacion,idcondpago,idzona,
        idimpuestoz,fechareg)
        VALUES(?,?,?,?,?,
        (SELECT MAX(idtipoproveedor) FROM tbtipoproveedor),(SELECT MAX(idoperacion) FROM tboperacion WHERE escompra='1'),
        (SELECT MIN(idcondpago) FROM tbcondpago),(SELECT MIN(idzona) FROM tbzona),
        (SELECT idimpuestoz FROM tbimpuestoz WHERE idimpuestoz='3'),NOW())";
        $arrData=array($this->Cod_proveedor,$this->Desc_proveedor,$this->Rif,$this->Direccion,$this->Estatus);
        $request=$this->Insert($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id,$idtipoproveedor,$idoperacion,$idcondpago,$idzona,$idimpuestoz,$cod_proveedor,$desc_proveedor,
    $rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,$limite,$montofiscal,$fechareg,$aplicareten){
      $this->Idproveedor=$id;
      $this->Idtipoproveedor =$idtipoproveedor;
      $this->Idoperacion =$idoperacion;
      $this->Idcondpago=$idcondpago;
      $this->Idzona =$idzona;
      $this->Idimpuestoz=$idimpuestoz;
      $this->Cod_proveedor=$cod_proveedor;
      $this->Desc_proveedor=$desc_proveedor;
      $this->Rif=$rif;
      $this->Direccion=$direccion;
      $this->Ciudad=$ciudad;
      $this->Codpostal=$codpostal;
      $this->Contacto=$contacto;
      $this->Telefono=$telefono;
      $this->Movil=$movil;
      $this->Email=$email;
      $this->Web=$web;
      $this->Limite=$limite;
      $this->Montofiscal=$montofiscal;
      $this->Fechareg=$fechareg;
      $this->Aplicareten=$aplicareten;
      try{  
        $sql="UPDATE tbproveedor 
        SET idtipoproveedor=?,idoperacion=?,idcondpago=?,idzona=?,idimpuestoz=?,cod_proveedor=?,desc_proveedor=?,
        rif=?,direccion=?,ciudad=?,codpostal=?,contacto=?,telefono=?,movil=?,email=?,web=?,limite=?,montofiscal=?,
        fechareg=?,aplicareten=? WHERE idproveedor='$this->Idproveedor'";
        $arrData=array($this->Idtipoproveedor,$this->Idoperacion,$this->Idcondpago,$this->Idzona,$this->Idimpuestoz,
        $this->Cod_proveedor,$this->Desc_proveedor,$this->Rif,$this->Direccion,$this->Ciudad,$this->Codpostal,
        $this->Contacto,$this->Telefono,$this->Movil,$this->Email,$this->Web,$this->Limite,$this->Montofiscal,
        $this->Fechareg,$this->Aplicareten);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idproveedor=$id;
      try {
        $sql="DELETE FROM tbproveedor WHERE idproveedor = '$this->Idproveedor'";
        $arrData=array($this->Idproveedor);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }
    }

    //Funcion  Mostrar Documentos a Importar
    public function ImportarDocumento($idproveedor='',$estatus,$tipo){
      $this->Idproveedor=$idproveedor;
      $this->Estatus=$estatus;
      $this->Tipo=$tipo;
      try {
        $sql="SELECT c.idcompra AS idcompraop ,c.idproveedor,c.cod_compra AS origenc ,c.estatus,pv.cod_proveedor,
        pv.desc_proveedor, pv.rif,c.idcondpago,pv.limite,cp.cod_condpago,cp.desc_condpago,cp.dias,c.tipo,c.numerod,c.totalh,
        DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fechareg, DATE_FORMAT(c.fechaven,'%d/%m/%Y') AS fechaven
        FROM tbcompra c
        INNER JOIN tbproveedor pv ON pv.idproveedor=c.idproveedor
        INNER JOIN tbcondpago cp ON cp.idcondpago =c.idcondpago
        WHERE ((('$this->Estatus'='todos' AND c.estatus<>'Anulado')) OR (c.estatus='Registrado' AND '$this->Estatus'='sinp'))
        AND (c.tipo='$this->Tipo') AND ('$idproveedor'='' OR c.idproveedor='$this->Idproveedor')";
        $request=$this->SelectAll($sql);
        return $request;
      } catch (PDOException $e) {
        return PDOError($e,'');
      }
    }

    public function ImportarDetalle($id){
      $this->Idcompra=$id;
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
  }
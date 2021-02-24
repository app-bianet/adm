<?php

  class clienteModel extends MySql{

    private $Idcliente;
    private $Idvendedor;
    private $Idtipocliente;
    private $Idoperacion;
    private $Idcondpago;
    private $Idzona;
    private $Idimpuestoz;
    private $Cod_cliente;
    private $Desc_cliente;
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

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      try {
        $sql="SELECT 
        cl.idcliente,
        cl.idvendedor,
        cl.idtipocliente,
        cl.idoperacion,
        cl.idcondpago,
        cl.idzona,
        cl.idimpuestoz,
        cl.cod_cliente,
        cl.desc_cliente,
        cl.rif,
        cl.direccion,
        cl.ciudad,
        cl.codpostal,
        cl.contacto,
        cl.telefono,
        cl.movil,
        cl.email,
        cl.web,
        cl.limite,
        cl.montofiscal,
        DATE_FORMAT(cl.fechareg, '%d/%m/%Y') AS fechareg,
        cl.aplicareten,
        cl.estatus,
        vd.cod_vendedor,
        vd.desc_vendedor,
        tc.cod_tipocliente,
        tc.desc_tipocliente,
        t.cod_operacion,
        t.desc_operacion,
        cp.cod_condpago,
        cp.desc_condpago,
        cp.dias,
        z.cod_zona,
        z.desc_zona,
        IFNULL((SELECT SUM(saldoh) FROM tbventa 
        WHERE idcliente = cl.idcliente AND tipo <> 'Cotizacion' AND estatus <> 'Anulado'),0) AS saldo 
        FROM
        tbcliente AS cl
        INNER JOIN tbvendedor AS vd ON (vd.idvendedor=cl.idvendedor)
        INNER JOIN tbtipocliente AS tc ON (cl.idtipocliente = tc.idtipocliente) 
        INNER JOIN tboperacion AS t ON (cl.idoperacion = t.idoperacion) 
        INNER JOIN tbcondpago AS cp ON (cl.idcondpago = cp.idcondpago) 
        INNER JOIN tbzona AS z ON (cl.idzona = z.idzona) 
        INNER JOIN tbimpuestoz AS iz ON (iz.idimpuestoz = cl.idimpuestoz)";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDt(){
      try {
        $sql="SELECT * FROM tbcliente WHERE estatus='1' ORDER BY cod_cliente ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      $this->Idcliente=$id;
      try {
        $sql="SELECT 
        cl.idcliente,
        cl.idvendedor,
        cl.idtipocliente,
        cl.idoperacion,
        cl.idcondpago,
        cl.idzona,
        cl.idimpuestoz,
        cl.cod_cliente,
        cl.desc_cliente,
        cl.rif,
        cl.direccion,
        cl.ciudad,
        cl.codpostal,
        cl.contacto,
        cl.telefono,
        cl.movil,
        cl.email,
        cl.web,
        cl.limite,
        cl.montofiscal,
        DATE_FORMAT(cl.fechareg, '%d/%m/%Y') AS fechareg,
        cl.aplicareten,
        cl.estatus,
        vd.cod_vendedor,
        vd.desc_vendedor,
        tc.cod_tipocliente,
        tc.desc_tipocliente,
        t.cod_operacion,
        t.desc_operacion,
        cp.cod_condpago,
        cp.desc_condpago,
        cp.dias,
        z.cod_zona,
        z.desc_zona,
        IFNULL((SELECT SUM(saldoh) FROM tbventa 
        WHERE idcliente = cl.idcliente AND tipo <> 'Cotizacion' AND estatus <> 'Anulado'),0) AS saldo 
        FROM
        tbcliente AS cl 
        INNER JOIN tbvendedor AS vd ON (vd.idvendedor=cl.idvendedor)
        INNER JOIN tbtipocliente AS tc ON (cl.idtipocliente = tc.idtipocliente) 
        INNER JOIN tboperacion AS t ON (cl.idoperacion = t.idoperacion) 
        INNER JOIN tbcondpago AS cp ON (cl.idcondpago = cp.idcondpago) 
        INNER JOIN tbzona AS z ON (cl.idzona = z.idzona) 
        INNER JOIN tbimpuestoz AS iz ON (iz.idimpuestoz = cl.idimpuestoz) 
        WHERE cl.idcliente='$this->Idcliente'";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }
   
    public function EstatusDt($id,$st){
      $this->Idcliente=$id;
      $this->Estatus=$st;
      try {
        $sql="UPDATE tbcliente SET estatus=? WHERE idcliente='$this->Idcliente'";
        $arrData=array($this->Estatus);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($idvendedor,$idtipocliente,$idoperacion,$idcondpago,$idzona,$idimpuestoz,$cod_cliente,$desc_cliente,
      $rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,$limite,$montofiscal,$fechareg,$aplicareten){
      $this->Idvendedor=$idvendedor;
      $this->Idtipocliente =$idtipocliente;
      $this->Idoperacion =$idoperacion;
      $this->Idcondpago=$idcondpago;
      $this->Idzona =$idzona;
      $this->Idimpuestoz=$idimpuestoz;
      $this->Cod_cliente=$cod_cliente;
      $this->Desc_cliente=$desc_cliente;
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
        $queryInsert="INSERT INTO tbcliente(idvendedor,idtipocliente,idoperacion,idcondpago,idzona,idimpuestoz,
        cod_cliente,desc_cliente,rif,direccion,ciudad,codpostal,contacto,telefono,movil,email,web,limite,
        montofiscal,fechareg,aplicareten,estatus) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrData=array($this->Idvendedor,$this->Idtipocliente,$this->Idoperacion,$this->Idcondpago,$this->Idzona,$this->Idimpuestoz,
        $this->Cod_cliente,$this->Desc_cliente,$this->Rif,$this->Direccion,$this->Ciudad,$this->Codpostal,
        $this->Contacto,$this->Telefono,$this->Movil,$this->Email,$this->Web,$this->Limite,$this->Montofiscal,
        $this->Fechareg,$this->Aplicareten,$this->Estatus);
        $request=$this->Insert($queryInsert,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function InsertDirect($cod_cliente,$desc_cliente,$rif){
      $this->Cod_cliente=$cod_cliente;
      $this->Desc_cliente=$desc_cliente;
      $this->Rif=$rif;
      $this->Estatus='1';
      try{
        $sql="INSERT INTO tbcliente(cod_cliente,rif,desc_cliente,idvendedor,idtipocliente,idoperacion,idcondpago,idzona,
        idimpuestoz,fechareg,estatus)
        VALUES(?,?,?,?,(SELECT MAX(idvendedor)FROM tbvendedor),
        (SELECT MAX(idtipocliente) FROM tbtipocliente),
        (SELECT MAX(idoperacion) FROM tboperacion WHERE esventa='1'),
        (SELECT MIN(idcondpago) FROM tbcondpago),
        (SELECT MIN(idzona) FROM tbzona),
        (SELECT idimpuestoz FROM tbimpuestoz WHERE idimpuestoz='3'),NOW())";
        $arrData=array($this->Cod_cliente,$this->Desc_cliente,$this->Rif,$this->Estatus);
        $request=$this->Insert($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id,$idvendedor,$idtipocliente,$idoperacion,$idcondpago,$idzona,$idimpuestoz,$cod_cliente,$desc_cliente,
    $rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,$limite,$montofiscal,$fechareg,$aplicareten){
      $this->Idcliente=$id;
      $this->Idvendedor=$idvendedor;
      $this->Idtipocliente =$idtipocliente;
      $this->Idoperacion =$idoperacion;
      $this->Idcondpago=$idcondpago;
      $this->Idzona =$idzona;
      $this->Idimpuestoz=$idimpuestoz;
      $this->Cod_cliente=$cod_cliente;
      $this->Desc_cliente=$desc_cliente;
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
        $sql="UPDATE tbcliente 
        SET idvendedor=?,idtipocliente=?,idoperacion=?,idcondpago=?,idzona=?,idimpuestoz=?,cod_cliente=?,desc_cliente=?,
        rif=?,direccion=?,ciudad=?,codpostal=?,contacto=?,telefono=?,movil=?,email=?,web=?,limite=?,montofiscal=?,
        fechareg=?,aplicareten=? WHERE idcliente='$this->Idcliente'";
        $arrData=array($this->Idvendedor,$this->Idtipocliente,$this->Idoperacion,$this->Idcondpago,$this->Idzona,$this->Idimpuestoz,
        $this->Cod_cliente,$this->Desc_cliente,$this->Rif,$this->Direccion,$this->Ciudad,$this->Codpostal,
        $this->Contacto,$this->Telefono,$this->Movil,$this->Email,$this->Web,$this->Limite,$this->Montofiscal,
        $this->Fechareg,$this->Aplicareten);
        $request = $this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idcliente=$id;
      try {
        $sql="DELETE FROM tbcliente WHERE idcliente = '$this->Idcliente'";
        $arrData=array($this->Idcliente);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }
    }

  }
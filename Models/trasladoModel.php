<?php
  class trasladoModel extends MySql{

    private $Idtraslado;
    private $Idusuario;
    private $Cod_traslado;
    private $Desc_traslado;
    private $Totalh;
    private $Fechareg;
    private $Estatus;

    private $Idarticulo;
    private $Iddepositoi;
    private $Iddepositod;
    private $Cantidad;
    private $Costo;
    private $Idartunidad;

    public function __construct(){
      parent::__construct();
    }

    public function ActCod(){                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
      try {
        $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbtraslado' AND estatus='1'";
        $request=$this->UpdateSet($sql);
        return $request;   
      } catch (PDOException $e) {
        return PDOError($e,'');
      }
    }

    public function SelectDt(){
      try{
        $sql="SELECT 
        tl.idtraslado,tl.cod_traslado,tl.desc_traslado,tl.estatus,tld.iddeposito,
        tld.iddepositoi,d.cod_deposito,d.desc_deposito,di.cod_deposito AS cod_depositoi,
        di.desc_deposito AS desc_depositoi,tl.totalh,DATE_FORMAT(tl.fechareg,'%d-%m-%Y') AS fechareg
        FROM tbtraslado tl
        INNER JOIN tbtrasladod tld ON tld.idtraslado=tl.idtraslado
        INNER JOIN tbdeposito d ON d.iddeposito=tld.iddeposito
        INNER JOIN tbdeposito di ON di.iddeposito=tld.iddepositoi
        GROUP BY tl.idtraslado";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e) {
        return PDOError($e,'');
      }
    }

    public function ListDt(){
      try{
        $sql="SELECT * FROM tbtraslado WHERE estatus='1' ORDER BY cod_traslado ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e) {
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      try{
        $this->Idtraslado=$id;
        $sql="SELECT 
        tl.idtraslado,
        tl.cod_traslado,
        tl.desc_traslado,
        tl.estatus,
        tld.iddepositoi,
        tld.iddeposito,
        tl.idusuario,
        (SELECT cod_deposito FROM tbdeposito WHERE iddeposito=tld.iddepositoi) AS cod_depositoi,
        (SELECT desc_deposito FROM tbdeposito WHERE iddeposito=tld.iddepositoi) AS desc_depositoi,
        (SELECT cod_deposito FROM tbdeposito WHERE iddeposito=tld.iddeposito) AS cod_deposito,
        (SELECT desc_deposito FROM tbdeposito WHERE iddeposito=tld.iddeposito) AS desc_deposito,
        tl.totalh,
        DATE_FORMAT(tl.fechareg, '%d-%m-%Y') AS fechareg 
        FROM
        tbtraslado tl 
        INNER JOIN tbtrasladod tld ON tld.idtraslado = tl.idtraslado
        WHERE tl.idtraslado='$this->Idtraslado' GROUP BY tl.idtraslado";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e) {
        return PDOError($e,'');
      }
    }

    public function MostrarDetalle($id){
      try{
        $this->Idtraslado=$id;
        $sql="SELECT
        a.cod_articulo,
        a.desc_articulo,
        u.cod_unidad,
        u.desc_unidad,
        td.cantidad,
        td.costo,
        (td.cantidad*td.costo) AS totald,
        td.idtrasladod,
        td.idtraslado,
        td.idarticulo,
        td.iddepositoi,
        td.iddeposito
        FROM tbtrasladod td
        INNER JOIN tbarticulo a ON a.idarticulo=td.idarticulo
        INNER JOIN tbartunidad au ON au.idarticulo=a.idarticulo
        INNER JOIN tbunidad u ON u.idunidad =au.idunidad
        WHERE td.idtraslado='$this->Idtraslado' GROUP BY td.idarticulo";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e) {
        return PDOError($e,'');
      }
    }

    public function SelectTraslado($iddepositoi,$iddepositod){
      $this->Iddepositoi=$iddepositoi;

      try {
        $sql="SELECT
        a.idarticulo, 
        s.iddeposito,
        a.cod_articulo, 
        a.desc_articulo,
        a.ref, 
        a.costo,
        s.cantidad AS stock
        FROM
        tbstock AS s 
        INNER JOIN tbarticulo a ON s.idarticulo = a.idarticulo
        INNER JOIN tbdeposito d ON d.iddeposito = s.iddeposito
        WHERE s.iddeposito='$this->Iddepositoi' AND s.cantidad<>0 AND a.tipo<>'Servicio'";
        $request=$this->SelectAll($sql);
        return $request;
      } catch (PDOException $e) {
        return PDOError($e,'');
      }
    }
  

    public function InsertDt($idusuario,$cod_traslado,$desc_traslado,$estatus,$totalh,$fechareg,$idarticulo,
      $iddepositoi,$iddepositod,$cantidad,$costo,$idartunidad){
      $this->Idusuario=$idusuario;
      $this->Cod_traslado=$cod_traslado;
      $this->Desc_traslado=$desc_traslado==''?'Traslado de Alamcen de fecha '.formatDateRt($fechareg):$desc_traslado;
      $this->Estatus=$estatus;
      $this->Totalh=$totalh;
      $this->Fechareg=$fechareg;
      $this->Idarticulo=$idarticulo;
      $this->Iddepositoi=$iddepositoi;
      $this->Iddepositod=$iddepositod;
      $this->Cantidad=$cantidad;
      $this->Costo=$costo;
      $this->Idartunidad=$idartunidad;

      $this->Estatus='1';
      try{  
        $queryInsert="INSERT INTO tbtraslado(idusuario,cod_traslado,desc_traslado,estatus,totalh,fechareg,fechadb)
        VALUES (?,?,?,?,?,?,NOW())";
        $arrData=array($this->Idusuario,$this->Cod_traslado,$this->Desc_traslado,
        $this->Estatus,$this->Totalh,$this->Fechareg);
        $lastId=$this->Insert($queryInsert,$arrData);

        $qrCod="UPDATE tbtraslado 
        SET cod_traslado=(SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum 
        FROM tbcorrelativo WHERE tabla='tbtraslado' AND estatus='1')
        WHERE idtraslado='$lastId'";
        $this->Update($qrCod,array($lastId));

        $num_elementos=0;

        while ($num_elementos < count($idarticulo)){
          $sql_detalle ="INSERT INTO tbtrasladod (idtraslado,idarticulo,iddepositoi,iddeposito,
          cantidad,costo,idartunidad) VALUES(?,?,?,?,?,?,?)";
          $arrData=array($lastId,$this->Idarticulo[$num_elementos],$this->Iddepositoi[$num_elementos],
          $this->Iddepositod[$num_elementos],$this->Cantidad[$num_elementos],$this->Costo[$num_elementos],
          $this->Idartunidad[$num_elementos]);
          $this->Update($sql_detalle,$arrData);
          $num_elementos=$num_elementos + 1;
        }
        $this->ActCod();
        return $lastId;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function RemoveStockArt($idarticulo,$iddepositoi,$cantidad,$valor){
      $this->Idarticulo=$idarticulo;
      $this->Iddepositoi=$iddepositoi;
      $this->Cantidad=$cantidad;
      $this->Valor=$valor;
      $num_elementos=0;
      try {
        while ($num_elementos < count($idarticulo)) {

            $sql_detalle ="INSERT INTO tbstock(idarticulo,iddeposito,cantidad) 
            VALUES(?,?,?)
            ON DUPLICATE KEY 
            UPDATE cantidad=cantidad-(?)";
            $arrDataDt=array($this->Idarticulo[$num_elementos],$this->Iddepositoi[$num_elementos],
            ($this->Cantidad[$num_elementos]*$this->Valor[$num_elementos]),
            ($this->Cantidad[$num_elementos]*$this->Valor[$num_elementos]));
            $returnData=$this->Insert($sql_detalle, $arrDataDt);
            $num_elementos=$num_elementos + 1;
        }
        return $returnData;
      } catch(PDOException $e){
        return PDOError($e,'');
      }
    }

    public function AddStockArt($idarticulo,$iddepositod,$cantidad,$valor){
      $this->Idarticulo=$idarticulo;
      $this->Iddepositod=$iddepositod;
      $this->Cantidad=$cantidad;
      $this->Valor=$valor;
      $num_elementos=0;
      try {
        while ($num_elementos < count($idarticulo)) {

            $sql_detalle ="INSERT INTO tbstock(idarticulo,iddeposito,cantidad) 
            VALUES(?,?,?)
            ON DUPLICATE KEY 
            UPDATE cantidad=cantidad+(?)";
            $arrDataDt=array($this->Idarticulo[$num_elementos],$this->Iddepositod[$num_elementos],
            ($this->Cantidad[$num_elementos]*$this->Valor[$num_elementos]),
            ($this->Cantidad[$num_elementos]*$this->Valor[$num_elementos]));
            $returnData=$this->Insert($sql_detalle, $arrDataDt);
            $num_elementos=$num_elementos + 1;
        }
        return $returnData;
      } catch(PDOException $e){
        return PDOError($e,'');
      }
    }

    public function AnularDt($id){
      $queryUpdate="";
      $this->Idtraslado=$id;
      try{  
        $sql="UPDATE tbtraslado SET estatus='Anulado' WHERE idtraslado ='$this->Idtraslado'";
        $arrData=array($this->Idtraslado);
        $queryUpdate=$this->Update($sql,$arrData);
        return $queryUpdate;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function AnularStock($id){
      $this->Idtraslado=$id;
      try {
        $sql="UPDATE tbtrasladod
        SET anular='1' WHERE idtraslado='$this->Idtraslado'";
        $arrData=array($this->Idtraslado);
        $queryUpdate=$this->Update($sql,$arrData);
        return $queryUpdate;
      } catch (PDOException $e) {
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idtraslado=$id;
      try {
        $sql="DELETE FROM tbtraslado WHERE idtraslado = '$this->Idtraslado'";
        $arrData=array($this->Idtraslado);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }   
    }
  }
<?php
class artprecioModel extends MySql{

    private $Idartprecio;
    private $Idarticulo;
    private $Idtipoprecio;
    private $Idmoneda;
    private $Fechareg;
    private $Fechaven;
    private $Vencprecio;
    private $Montoprecio;
    private $Margen;

    public function __construct(){
      parent::__construct();
    }

    public function ListDt($id){
      $this->Idarticulo=$id;
      try {
        $sql="SELECT 
        ap.idartprecio,
        ap.idarticulo,
        ap.idtipoprecio,
        ap.idmoneda,
        tp.cod_tipoprecio,
        tp.desc_tipoprecio,
        ap.montoprecio,
        ap.margen,
        (((ap.montoprecio*margen/100)+ap.montoprecio)) AS preciom,
        ((((ap.montoprecio*margen/100)+ap.montoprecio)*i.tasa)/100) AS imp,
        ((ap.montoprecio*margen/100)+ap.montoprecio)+((((ap.montoprecio*margen/100)+ap.montoprecio)*i.tasa)/100) AS preciot,
        i.tasa,
        m.cod_moneda,
        m.desc_moneda,
        m.simbolo,m.factor,
        DATE_FORMAT(ap.fechareg,'%d/%m/%Y') AS fechareg,
        DATE_FORMAT(ap.fechaven,'%d/%m/%Y') AS fechaven,
        ap.vence
        FROM tbartprecio ap
        INNER JOIN tbtipoprecio tp ON tp.idtipoprecio=ap.idtipoprecio
        INNER JOIN tbmoneda m ON m.idmoneda=ap.idmoneda
        INNER JOIN tbarticulo a ON a.idarticulo=ap.idarticulo
        INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto
        WHERE ap.idarticulo='$this->Idarticulo' ORDER BY tp.cod_tipoprecio ASC";
        $request=$this->SelectAll($sql);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      $this->Idartprecio=$id;
      try {
        $sql="SELECT 
        ap.idartprecio,
        ap.idarticulo,
        ap.idtipoprecio,
        ap.idmoneda,
        tp.cod_tipoprecio,
        tp.desc_tipoprecio,
        ap.montoprecio,
        ap.margen,
        ((ap.montoprecio*margen/100)+ap.montoprecio) AS preciom,
        ((((ap.montoprecio*margen/100)+ap.montoprecio)*i.tasa)/100) AS imp,
        ((ap.montoprecio*margen/100)+ap.montoprecio)+((((ap.montoprecio*margen/100)+ap.montoprecio)*i.tasa)/100) AS preciot,
        i.tasa,
        m.cod_moneda,
        m.desc_moneda,
        m.simbolo,m.factor,
        DATE_FORMAT(ap.fechareg,'%d/%m/%Y') AS fechareg,
        DATE_FORMAT(ap.fechaven,'%d/%m/%Y') AS fechaven,
        ap.vence
        FROM tbartprecio ap
        INNER JOIN tbtipoprecio tp ON tp.idtipoprecio=ap.idtipoprecio
        INNER JOIN tbmoneda m ON m.idmoneda=ap.idmoneda
        INNER JOIN tbarticulo a ON a.idarticulo=ap.idarticulo
        INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto
        WHERE ap.idartprecio='$this->Idartprecio'";
        $request=$this->Select($sql);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($idarticulo,$idtipoprecio,$idmoneda,$fecharegp,$preciom,$fechavenp,$margenm,$venc){
      $this->Idarticulo=$idarticulo;
      $this->Idtipoprecio=$idtipoprecio;
      $this->Idmoneda=$idmoneda;
      $this->Fechareg=$fecharegp;
      $this->Fechaven=$fechavenp;
      $this->Montoprecio=$preciom;
      $this->Margen=$margenm;
      $this->Vencprecio=$venc;
      try {
        $sql="INSERT INTO tbartprecio(idarticulo,idtipoprecio,idmoneda,fechareg,fechaven,vence,montoprecio,margen)
        VALUES(?,?,?,?,?,?,?,?)";
        $arrData=array(
          $this->Idarticulo,
          $this->Idtipoprecio,
          $this->Idmoneda,
          $this->Fechareg,
          $this->Fechaven,
          $this->Vencprecio,
          $this->Montoprecio,
          $this->Margen);
        $this->Insert($sql,$arrData);
        return true;
      } catch (PDOException $e) {
        return PDOError($e,'insert');
      }
    }

    public function UpdateDt($idartprecio,$idtipoprecio,$idmoneda,$fecharegp,$preciom,$fechavenp,$margenm,$venc){
      $this->Idartprecio=$idartprecio;
      $this->Idtipoprecio=$idtipoprecio;
      $this->Idmoneda=$idmoneda;
      $this->Fechareg=$fecharegp;
      $this->Fechaven=$fechavenp;
      $this->Vencprecio=$venc;
      $this->Montoprecio=$preciom;
      $this->Margen=$margenm;
      try{  
        $sql="UPDATE tbartprecio SET idtipoprecio=?, idmoneda=?, montoprecio=?, 
        margen=?, fechareg=?, fechaven=?, vence=? WHERE idartprecio ='$this->Idartprecio'";
        $arrData=array($this->Idtipoprecio,$this->Idmoneda,$this->Montoprecio,$this->Margen,
        $this->Fechareg,$this->Fechaven,$this->Vencprecio);
        $this->Update($sql,$arrData);
        return true;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idartprecio=$id;
      try {
        $sql="DELETE FROM tbartprecio WHERE idartprecio = '$this->Idartprecio'";
        $arrData=array($this->Idartprecio);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }
    }

}
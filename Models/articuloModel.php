<?php
  class articuloModel extends MySql{

    private $Idarticulo;
    private $Idcategoria;
    private $Idlinea;
    private $Idimpuesto;
    private $Cod_articulo;
    private $Desc_articulo;
    private $Tipo;
    private $Origen;
    private $Ref;
    private $Stockmin;
    private $Stockmax;
    private $Stockped;
    private $Ancho;
    private $Alto;
    private $Peso;
    private $Comision;
    private $Costo;
    private $Costoprecio;
    private $Lotes;
    private $Lotesv;
    private $Seriales;
    private $Imagen;
    private $Fechareg;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      try {
        $sql="SELECT 
        a.idarticulo,
        a.idcategoria,
        a.idlinea,
        a.idimpuesto,
        a.cod_articulo,
        a.desc_articulo,
        c.cod_categoria,
        c.desc_categoria,
        l.cod_linea,
        l.desc_linea,
        a.ref,
        a.origen,
        a.tipo,
        a.stockmin AS stockmin,
        a.stockmax AS stockmax,
        a.stockped AS stockped,
        a.alto AS alto,
        a.ancho AS ancho,
        a.peso AS peso,
        a.comision AS comision,
        a.imagen,
        a.estatus,     
        IFNULL((SELECT SUM(cantidad) FROM tbstock WHERE idarticulo=a.idarticulo),0) AS stock,
        a.costo AS costo,
        i.tasa AS tasa,
        DATE_FORMAT(a.fechareg,'%d/%m/%Y') AS fechareg,
        a.costoprecio,
        a.estatus
        FROM tbarticulo a 
        INNER JOIN tbcategoria c ON a.idcategoria=c.idcategoria
        INNER JOIN tblinea l ON l.idlinea=a.idlinea
        INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto";
        $request=$this->SelectAll($sql);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowStock($id){
      $this->Idarticulo=$id;
      try {
        $sql="SELECT 
        s.iddeposito,
        d.cod_deposito,
        d.desc_deposito,
        IFNULL(s.cantidad,0) AS stock
        FROM tbstock s
        INNER JOIN tbdeposito d ON d.iddeposito=s.iddeposito
        WHERE s.idarticulo='$this->Idarticulo'";
        $request=$this->SelectAll($sql);		
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDt(){
      try {
        $sql="SELECT * FROM tbarticulo WHERE estatus='1' ORDER BY cod_articulo ASC";
        $request=$this->SelectAll($sql);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      $this->Idarticulo=$id;
      try {
        $sql="SELECT 
        a.idarticulo,
        a.idcategoria,
        a.idlinea,
        a.idimpuesto,
        a.cod_articulo,
        a.desc_articulo,
        c.cod_categoria,
        c.desc_categoria,
        l.cod_linea,
        l.desc_linea,
        a.ref,
        a.origen,
        a.tipo,
        a.stockmin AS stockmin,
        a.stockmax AS stockmax,
        a.stockped AS stockped,
        a.alto AS alto,
        a.ancho AS ancho,
        a.peso AS peso,
        a.comision AS comision,
        a.imagen,
        a.estatus,     
        IFNULL((SELECT SUM(cantidad) FROM tbstock WHERE idarticulo=a.idarticulo),0) AS stock,
        a.costo AS costo,
        i.tasa AS tasa,
        DATE_FORMAT(a.fechareg,'%d/%m/%Y') AS fechareg,
        a.costoprecio,
        a.estatus
        FROM tbarticulo a 
        INNER JOIN tbcategoria c ON a.idcategoria=c.idcategoria
        INNER JOIN tblinea l ON l.idlinea=a.idlinea
        INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto 
        WHERE a.idarticulo='$this->Idarticulo'";
        $request=$this->Select($sql);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }
   
    public function EstatusDt($id,$st){
      $this->Idarticulo=$id;
      $this->Estatus=$st;
      try {
        $sql="UPDATE tbarticulo SET estatus=? WHERE idarticulo='$this->Idarticulo'";
        $arrData=array($this->Estatus);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($idcategoria,$idlinea,$idimpuesto,$cod_articulo,$desc_articulo,$tipo,$origen,$ref,
      $stockmin,$stockmax,$stockped,$alto,$ancho,$peso,$comision,$costo,$lotes,$lotesv,$seriales,$costoprecio,
      $imagen,$fechareg){

      $this->Idcategoria=$idcategoria;
      $this->Idlinea=$idlinea;
      $this->Idimpuesto=$idimpuesto;
      $this->Cod_articulo=$cod_articulo;
      $this->Desc_articulo=$desc_articulo;
      $this->Tipo=$tipo;
      $this->Origen=$origen;
      $this->Ref=$ref;
      $this->Stockmin=$stockmin;
      $this->Stockmax=$stockmax;
      $this->Stockped=$stockped;
      $this->Alto=$alto;
      $this->Ancho=$ancho;
      $this->Peso=$peso;
      $this->Comision=$comision;
      $this->Costo=$costo;
      $this->Lotes=$lotes;
      $this->Lotesv=$lotesv;
      $this->Seriales=$seriales;
      $this->Costoprecio=$costoprecio;
      $this->Imagen=$imagen;
      $this->Fechareg=formatDate($fechareg);
      $this->Estatus='1';
      try{
        $sql = "INSERT INTO tbarticulo(idcategoria,idlinea,idimpuesto,cod_articulo,desc_articulo,
          tipo,origen,ref,stockmin,stockmax,stockped,alto,ancho,peso,comision,costo,
          lotes,lotesv,seriales,costoprecio,imagen,fechareg,estatus) 
          VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrData = array(
          $this->Idcategoria, $this->Idlinea, $this->Idimpuesto, $this->Cod_articulo, $this->Desc_articulo,
          $this->Tipo, $this->Origen, $this->Ref, $this->Stockmin, $this->Stockmax, $this->Stockped, $this->Alto, $this->Ancho,
          $this->Peso, $this->Comision, $this->Costo, $this->Lotes, $this->Lotesv, $this->Seriales, $this->Costoprecio,
          $this->Imagen, $this->Fechareg, $this->Estatus
        );
        $lastId = $this->Insert($sql, $arrData);
        return $lastId;
      } catch (PDOException $e) {
        return PDOError($e,'insert');
      }
    }

    public function UpdateDt($id,$idcategoria,$idlinea,$idimpuesto,$cod_articulo,$desc_articulo,
      $tipo,$origen,$ref,$stockmin,$stockmax,$stockped,$alto,$ancho,$peso,$comision,$costo,
      $lotes,$lotesv,$seriales,$costoprecio,$imagen,$fechareg){
      $this->Idarticulo=$id;
      $this->Idcategoria=$idcategoria;
      $this->Idlinea=$idlinea;
      $this->Idimpuesto=$idimpuesto;
      $this->Cod_articulo=$cod_articulo;
      $this->Desc_articulo=$desc_articulo;
      $this->Tipo=$tipo;
      $this->Origen=$origen;
      $this->Ref=$ref;
      $this->Stockmin=$stockmin;
      $this->Stockmax=$stockmax;
      $this->Stockped=$stockped;
      $this->Alto=$ancho;
      $this->Ancho=$alto;
      $this->Peso=$peso;
      $this->Comision=$comision;
      $this->Costo=$costo;
      $this->Costoprecio=$costoprecio;
      $this->Lotes=$lotes;
      $this->Lotesv=$lotesv;
      $this->Seriales=$seriales;
      $this->Imagen=$imagen;
      $this->Fechareg=$fechareg;
      try{  
       $sql="UPDATE tbarticulo SET idcategoria=?,idlinea=?,idimpuesto=?,cod_articulo=?,desc_articulo=?,
        tipo=?,origen=?,ref=?,stockmin=?,stockmax=?,stockped=?,alto=?,ancho=?,peso=?,comision=?,
        costo=?,costoprecio=?,lotes=?,lotesv=?,seriales=?,imagen=?,fechareg=? WHERE idarticulo='$this->Idarticulo'";
        $arrData=array($this->Idcategoria,$this->Idlinea,$this->Idimpuesto,$this->Cod_articulo,$this->Desc_articulo,
        $this->Tipo,$this->Origen,$this->Ref,$this->Stockmin,$this->Stockmax,$this->Stockped,$this->Alto,$this->Ancho,
        $this->Peso,$this->Comision,$this->Costo,$this->Costoprecio,$this->Lotes,$this->Lotesv,$this->Seriales,
        $this->Imagen,$this->Fechareg);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idarticulo=$id;
      try {
        $sql="DELETE FROM tbarticulo WHERE idarticulo = '$this->Idarticulo'";
        $arrData=array($this->Idarticulo);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }
    }
  }
<?php
  class ajusteModel extends MySql{

    private $Idusuario;
    private $Idajuste;
    private $Cod_ajuste;
    private $Desc_ajuste;
    private $Estatus;
    private $Tipo;
    private $Tipoa;
    private $Totalstock;
    private $Totalh;
    private $Fechareg;
    private $Idarticulo;
    private $Iddeposito;
    private $Disp;
    private $Valor;
    private $Cantidad;
    private $Costo;
    private $Idartunidad;


    public function __construct(){
      parent::__construct();
    }

    public function ActCod(){                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
      try {
        $sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbajuste' AND estatus='1'";
        $request=$this->UpdateSet($sql);
        return $request;   
      } catch (PDOException $e) {
        return PDOError($e,'');
      }
    }

    public function ListarDt(){
      try{
        $sql="SELECT 
        aj.idajuste,
        aj.cod_ajuste,
        aj.desc_ajuste,
        aj.tipo,
        aj.estatus,
        aj.totalstock,
        CASE
        WHEN aj.tipo ='Entrada' THEN aj.totalh
        WHEN aj.tipo ='Salida' THEN aj.totalh
        ELSE aj.totalh END AS totalh,
        DATE_FORMAT(aj.fechareg,'%d/%m/%Y') AS fechareg
        FROM tbajuste aj";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e ) {
        return PDOError($e,'');
      }
    }

    public function Mostrar($id){
      $this->Idajuste=$id;
      try {
        $sql="SELECT
        aj.idajuste,
        aj.cod_ajuste,
        aj.desc_ajuste,
        aj.tipo,
        aj.estatus,
        CASE 
        WHEN aj.tipo='Entrada' THEN aje.iddeposito
        WHEN aj.tipo='Salida' THEN ajs.iddeposito
        WHEN aj.tipo='Inventario' THEN aji.iddeposito
        END AS iddeposito,
        aj.totalstock,
        aj.totalh,
        DATE_FORMAT(aj.fechareg,'%d-%m-%Y') AS fechareg
        FROM tbajuste aj 
        LEFT JOIN tbajustee aje ON aje.idajuste=aj.idajuste
        LEFT JOIN tbajustes ajs ON ajs.idajuste=aj.idajuste
        LEFT JOIN tbajustei aji ON aji.idajuste=aj.idajuste
        WHERE aj.idajuste='$this->Idajuste'
        GROUP BY aj.idajuste";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e ) {
        return PDOError($e,'');
      }
    }

    //Metodo Detalle de Ajuste
    public function MostrarDetalle($id){
      $this->Idajuste=$id;
      try {
        $sql="SELECT 
        ajd.idajusted, 
        ajd.idajuste,
        ajd.iddeposito,
        ajd.idartunidad,
        a.cod_articulo,
        a.desc_articulo,
        u.cod_unidad,
        u.desc_unidad,
        ajd.cantidad,
        ajd.costo,
        ajd.cantidad*ajd.costo AS totald
        FROM tbajustee ajd
        INNER JOIN tbarticulo a ON a.idarticulo=ajd.idarticulo
        LEFT JOIN tbartunidad au ON au.idartunidad=ajd.idartunidad
        INNER JOIN tbunidad u ON u.idunidad=au.idunidad
        WHERE ajd.idajuste='$this->Idajuste'

        UNION

        SELECT 
        ajd.idajusted, 
        ajd.idajuste,
        ajd.iddeposito,
        ajd.idartunidad,
        a.cod_articulo,
        a.desc_articulo,
        u.cod_unidad,
        u.desc_unidad,
        ajd.cantidad,
        ajd.costo,
        ajd.cantidad*ajd.costo AS totald
        FROM tbajustes ajd
        INNER JOIN tbarticulo a ON a.idarticulo=ajd.idarticulo
        LEFT JOIN tbartunidad au ON au.idartunidad=ajd.idartunidad
        INNER JOIN tbunidad u ON u.idunidad=au.idunidad
        WHERE ajd.idajuste='$this->Idajuste'

        UNION

        SELECT 
        ajd.idajusted, 
        ajd.idajuste,
        ajd.iddeposito,
        ajd.idartunidad,
        a.cod_articulo,
        a.desc_articulo,
        u.cod_unidad,
        u.desc_unidad,
        ajd.cantidad,
        ajd.costo,
        ajd.cantidad*ajd.costo AS totald
        FROM tbajustei ajd
        INNER JOIN tbarticulo a ON a.idarticulo=ajd.idarticulo
        LEFT JOIN tbartunidad au ON au.idartunidad=ajd.idartunidad
        INNER JOIN tbunidad u ON u.idunidad=au.idunidad
        WHERE ajd.idajuste='$this->Idajuste'";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e ) {
        return PDOError($e,'');
      }
    }

    //Implementar un método para listar los registros y mostrar en el select
    public function SelectAjuste($iddeposito,$tipo){
      $this->Iddeposito=$iddeposito;
      $this->Tipo=$tipo;
      if($this->Tipo=='Entrada'||$this->Tipo=='Salida'){
        try {
          $sql="SELECT
          (SELECT cod_deposito FROM tbdeposito WHERE iddeposito='$this->Iddeposito') AS cod_deposito,
          (SELECT desc_deposito FROM tbdeposito WHERE iddeposito='$this->Iddeposito') AS desc_deposito,
          a.cod_articulo,
          a.desc_articulo,
          a.ref,
          a.tipo,
          IFNULL((SELECT cantidad FROM tbstock WHERE iddeposito='$this->Iddeposito' AND idarticulo=a.idarticulo),'null') AS disp,
          IFNULL((SELECT cantidad FROM tbstock WHERE iddeposito='$this->Iddeposito' AND idarticulo=a.idarticulo),0) AS stock,
          a.costo,
          i.tasa,
          a.estatus,
          au.idarticulo,
          a.idcategoria,
          a.idimpuesto,
          (SELECT iddeposito FROM tbdeposito WHERE iddeposito='$this->Iddeposito') AS iddeposito 
          FROM tbarticulo a
          INNER JOIN tbartunidad au ON au.idarticulo=a.idarticulo
          INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto
          LEFT JOIN tbstock s ON s.idarticulo=a.idarticulo
          LEFT JOIN tbdeposito d ON d.iddeposito=s.iddeposito
          WHERE a.estatus='1' AND a.tipo<>'Servicio'
          GROUP BY a.idarticulo";
          $request=$this->SelectAll($sql);
          return $request;
        } catch (PDOException $e) {
          return PDOError($e,'');
        }
      } else {
        try {
          $sql="SELECT 
          d.cod_deposito,
          d.desc_deposito,
          a.cod_articulo,
          a.desc_articulo,
          a.ref,
          a.tipo,
          s.cantidad AS stock,
          s.cantidad AS disp,
          a.costo,
          i.tasa,
          a.estatus,
          au.idarticulo,
          a.idimpuesto,
          d.iddeposito
          FROM tbarticulo a
          INNER JOIN tbartunidad au ON au.idarticulo=a.idarticulo
          INNER JOIN tbcategoria c ON a.idcategoria=c.idcategoria
          INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto
          INNER JOIN tbstock s ON s.idarticulo=a.idarticulo
          INNER JOIN tbdeposito d ON d.iddeposito=s.iddeposito
          WHERE a.estatus='1' AND s.iddeposito='$this->Iddeposito' AND s.cantidad<>0
          GROUP BY a.idarticulo";
          $request=$this->SelectAll($sql);
          return $request;
        } catch (PDOException $e) {
          return PDOError($e,'');
        }
      }
   }

    public function ListDt(){
      try {
        $sql="SELECT * FROM tbajuste WHERE estatus='1' ORDER BY cod_ajuste ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e ) {
        return PDOError($e,'');
      }
    }
    
    public function InsertDt($idusuario,$cod_ajuste,$desc_ajuste,$estatus,$tipo,$totalstock,$totalh,
      $fechareg,$idarticulo,$iddeposito,$cantidad,$costo,$idartunidad){
      $this->Idusuario=$idusuario;
      $this->Cod_ajuste=$cod_ajuste;
      $this->Desc_ajuste=$desc_ajuste==''?'Ajuste de '.$tipo.' de fecha '.formatDateRt($fechareg):$desc_ajuste;
      $this->Estatus=$estatus;
      $this->Tipo=$tipo;
      $this->Totalstock=$totalstock;
      $this->Totalh=$totalh;
      $this->Fechareg=$fechareg;
      $this->Idarticulo=$idarticulo;
      $this->Iddeposito=$iddeposito;
      $this->Cantidad=$cantidad;
      $this->Costo=$costo;
      $this->Idartunidad=$idartunidad;
      try{  
        $queryInsert="INSERT INTO tbajuste(idusuario,cod_ajuste,desc_ajuste,tipo,estatus,
        totalstock,totalh,fechareg,fechadb) VALUES(?,?,?,?,?,?,?,?,NOW())";
        $arrData=array($this->Idusuario,$this->Cod_ajuste,$this->Desc_ajuste,$this->Tipo,$this->Estatus,
        $this->Totalstock,$this->Totalh,$this->Fechareg);
        $lastId = $this->Insert($queryInsert, $arrData);

        $qrCod="UPDATE tbajuste 
        SET cod_ajuste=(SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum 
        FROM tbcorrelativo WHERE tabla='tbajuste' AND estatus='1')
        WHERE idajuste='$lastId'";
        $this->Update($qrCod,array($lastId));
  
        $num_elementos=0;

        if ($this->Tipo=='Entrada') {
          while ($num_elementos < count($idarticulo)){
            $sql_detalle ="INSERT INTO tbajustee (idajuste,tipo,idarticulo,iddeposito,cantidad,costo,idartunidad) 
            VALUES (?,?,?,?,?,?,?)";
            $arrDataDt=array($lastId,$this->Tipo,$this->Idarticulo[$num_elementos],$this->Iddeposito[$num_elementos],
            $this->Cantidad[$num_elementos],$this->Costo[$num_elementos],$this->Idartunidad[$num_elementos]);
            $this->Insert($sql_detalle, $arrDataDt);
				    $num_elementos=$num_elementos + 1;
          }
        } else if($this->Tipo=='Salida') {
          while ($num_elementos < count($idarticulo))
          {
            $sql_detalle ="INSERT INTO tbajustes (idajuste,tipo,idarticulo,iddeposito,cantidad,costo,idartunidad) 
            VALUES (?,?,?,?,?,?,?)";
            $arrDataDt=array($lastId,$this->Tipo,$this->Idarticulo[$num_elementos],$this->Iddeposito[$num_elementos],
            $this->Cantidad[$num_elementos],$this->Costo[$num_elementos],$this->Idartunidad[$num_elementos]);
            $this->Insert($sql_detalle, $arrDataDt);
            $num_elementos=$num_elementos + 1;
          }
        } else if($this->Tipo=='Inventario'){
          while ($num_elementos < count($idarticulo))
          {
            $sql_detalle ="INSERT INTO tbajustei (idajuste,tipo,idarticulo,iddeposito,cantidad,costo,idartunidad) 
            VALUES (?,?,?,?,?,?,?)";
            $arrDataDt=array($lastId,$this->Tipo,$this->Idarticulo[$num_elementos],$this->Iddeposito[$num_elementos],
            $this->Cantidad[$num_elementos],$this->Costo[$num_elementos],$this->Idartunidad[$num_elementos]);
            $this->Insert($sql_detalle, $arrDataDt);
            $num_elementos=$num_elementos + 1;
          }
        }
        //Actualizamos el Codigo
        $this->ActCod();
        return true;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function AddStockArt($idarticulo,$iddeposito,$cantidad,$valor,$tipoa,$tipo){
      $this->Idarticulo=$idarticulo;
      $this->Iddeposito=$iddeposito;
      $this->Cantidad=$cantidad;
      $this->Valor=$valor;
      $this->Tipo=$tipo;
      $this->Tipoa=$tipoa;
   
      try {
        $num_elementos=0;
        while ($num_elementos < count($this->Idarticulo)){
          if ($this->Tipoa[$num_elementos]!='Servicio') {
            switch ($this->Tipo) {
              case 'Entrada':
                $sql_detalle ="INSERT INTO tbstock(idarticulo,iddeposito,cantidad) 
                VALUES(?,?,?)
                ON DUPLICATE KEY 
                UPDATE cantidad=cantidad+(?)";
                $arrDataDt=array($this->Idarticulo[$num_elementos],$this->Iddeposito[$num_elementos],
                ($this->Cantidad[$num_elementos]*$this->Valor[$num_elementos]),
                ($this->Cantidad[$num_elementos]*$this->Valor[$num_elementos]));
                $returnData=$this->Insert($sql_detalle, $arrDataDt);
                $num_elementos=$num_elementos + 1;
              break;
              
              case 'Salida':
                $sql_detalle ="INSERT INTO tbstock(idarticulo,iddeposito,cantidad) 
                VALUES(?,?,?)
                ON DUPLICATE KEY 
                UPDATE cantidad=cantidad-(?)";
                $arrDataDt=array($this->Idarticulo[$num_elementos],$this->Iddeposito[$num_elementos],
                ($this->Cantidad[$num_elementos]*$this->Valor[$num_elementos]),
                ($this->Cantidad[$num_elementos]*$this->Valor[$num_elementos]));
                $returnData=$this->Insert($sql_detalle, $arrDataDt);
                $num_elementos=$num_elementos + 1;
              break;

              case 'Inventario':
                $sql_detalle ="UPDATE tbstock SET
                cantidad=? WHERE idarticulo='$this->Idarticulo[$num_elementos]' 
                AND iddeposito=' $this->Iddeposito[$num_elementos]')";
                $arrDataDt=array(($this->Cantidad[$num_elementos]*$this->Valor[$num_elementos]));
                $returnData=$this->Update($sql_detalle,$arrDataDt);
                $num_elementos=$num_elementos + 1;
              break;
            }
          }
        }
        return $returnData;
      } catch (PDOException $e ) {
        dep(PDOError($e,''));
      }

    }

    public function AnularDt($id){
      $queryUpdate="";
      $this->Idajuste=$id;
      try{  
        $sql="UPDATE tbajuste SET estatus='Anulado' WHERE idajuste='$this->Idajuste'";
        $arrData=array($this->Idajuste);
        $queryUpdate=$this->Update($sql,$arrData);
        return $queryUpdate;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function AnularStock($id,$tipo){
      $this->Idajuste=$id;
      $this->Tipo=$tipo;
      try {
        if ($this->Tipo=='Entrada') {
          $sql="UPDATE tbajustee
          SET anular='1',tipo='Anular' WHERE idajuste='$this->Idajuste'";
          $arrData=array($this->Idajuste);
          $queryUpdate=$this->Update($sql,$arrData);
          return $queryUpdate;
        } else {
          $sql="UPDATE tbajustes
          SET anular='1',tipo='Anular' WHERE idajuste='$this->Idajuste'";
          $arrData=array($this->Idajuste);
          $queryUpdate=$this->Update($sql,$arrData);
          return $queryUpdate;
        }
      } catch (PDOException $e) {
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idajuste=$id;
      try {
        $sql="DELETE FROM tbajuste WHERE idajuste = '$this->Idajuste'";
        $arrData=array($this->Idajuste);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }   
    }

    public function AjustarCosto($idarticulo,$costo,$valor){
      $this->Idarticulo=$idarticulo;
      $this->Costo=$costo;
      $this->Valor=$valor;
      $returnData="";
      try {
          $num_elementos=0;
          while ($num_elementos < count($this->Idarticulo)){
            $sql="UPDATE tbarticulo 
            SET costo=? 
            WHERE idarticulo=?";
            $arrData=array(($this->Costo[$num_elementos]/$this->Valor[$num_elementos]),$this->Idarticulo[$num_elementos]);
            $returnData=$this->Update($sql,$arrData);
            $num_elementos=$num_elementos + 1;
          }
          return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'');
      }
    }
  }
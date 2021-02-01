<?php
class artunidadModel extends MySql{

  private $Idartunidad;
  private $Idarticulo;
  private $Idunidad;
  private $Valor;
  private $Principal;

  public function __construct(){
    parent::__construct();
    
  }

  public function ShowListUnidad($id){
    $this->Idarticulo=$id;
    $sql="SELECT
    au.idartunidad,
    au.idarticulo,
    au.idunidad,
    u.cod_unidad,
    u.desc_unidad,
    CONVERT(au.valor,DEC(18,0)) AS valor,
    au.principal
    FROM tbartunidad au 
    INNER JOIN tbunidad u ON u.idunidad=au.idunidad
    WHERE au.idarticulo='$this->Idarticulo'
    ORDER BY au.valor ASC";
    $request=$this->SelectAll($sql);
    return $request;
  }

  public function SelectDt($id){
    $this->Idartunidad=$id;
    $sql="SELECT
    au.idartunidad,
    au.idarticulo,
    au.idunidad,
    u.cod_unidad,
    u.desc_unidad,
    CONVERT(au.valor,DEC(18,0)) AS valor,
    au.principal
    FROM tbartunidad au 
    INNER JOIN tbunidad u ON u.idunidad=au.idunidad
    WHERE  au.idartunidad='$this->Idartunidad'";
    $request=$this->Select($sql);
    return $request;
  }


  public function InsertDt($idarticulo,$idunidad,$valor,$principal){
    $this->Idarticulo=$idarticulo;
    $this->Idunidad=$idunidad;
    $this->Valor=$valor;
    $this->Principal=$principal;

    $sqlDT="SELECT principal FROM tbartunidad WHERE idarticulo='$this->Idarticulo' AND principal='1'";
    $require=$this->Select($sqlDT);

    if ($require &&  $this->Principal=='1') {
      return 'principaldt';
    } else {
      try {
        $sql="INSERT INTO tbartunidad(idarticulo,idunidad,valor,principal)
        VALUES(?,?,?,?)";
        $arrData=array($this->Idarticulo,$this->Idunidad,$this->Valor,$this->Principal);
        $this->Insert($sql,$arrData);
        return true;
      } catch (PDOException $e) {
        return PDOError($e,'insert');
      }
    }
  }

  public function UpdateDt($idartunidad,$idarticulo,$idunidad,$valor,$principal){
    $this->Idartunidad=$idartunidad;
    $this->Idarticulo=$idarticulo;
    $this->Idunidad=$idunidad;
    $this->Valor=$valor;
    $this->Principal=$principal;

    $sqlDT="SELECT principal FROM tbartunidad WHERE idarticulo='$this->Idarticulo' AND principal='1'";
    $require=$this->Select($sqlDT);

    if ($require &&  $this->Principal=='1') {
      return 'principaldt';
    } else {
      try {
        $sql="UPDATE tbartunidad SET idunidad=?, valor=?, principal=? WHERE idartunidad='$this->Idartunidad'";
        $arrData=array($this->Idunidad,$this->Valor,$this->Principal);
        $this->Insert($sql,$arrData);
        return true;
      } catch (PDOException $e) {
        return PDOError($e,'insert');
      }
    }
  }

  public function EliminarDt($id,$principal){
    $returnData = "";
    $this->Idartunidad=$id;
    $this->Principal=$principal;
    if ($this->Principal=='1') {
      return 'principaldt';
    } else {
      try {
        $sql="DELETE FROM tbartunidad WHERE idartunidad = '$this->Idartunidad'";
        $arrData=array($this->Idartunidad);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }
    }
  }
}
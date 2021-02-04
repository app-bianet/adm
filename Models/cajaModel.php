<?php
class cajaModel extends MySql
{

  private $Idcaja;
  private $Idmoneda;
  private $Cod_caja;
  private $Desc_caja;
  private $Saldoefectivo;
  private $Saldodocumento;
  private $Saldototal;
  private $Fechareg;
  private $Estatus;

  public function __construct()
  {
    parent::__construct();
  }

  public function SelectDt()
  {
    $sql = "SELECT 
    c.idcaja,
    c.idmoneda,
    c.cod_caja,
    c.desc_caja,
    m.cod_moneda,
    m.desc_moneda,
    m.simbolo,
    c.saldoefectivo,
    c.saldodocumento,
    c.saldototal,
    DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fechareg,
    c.estatus 
    FROM tbcaja c
    INNER JOIN tbmoneda AS m ON m.idmoneda=c.idmoneda";
    $req = $this->SelectAll($sql);
    return $req;
  }

  public function ListDt()
  {
    $sql = "SELECT 
    c.idcaja,
    c.idmoneda,
    c.cod_caja,
    c.desc_caja,
    m.cod_moneda,
    m.desc_moneda,
    m.simbolo,
    c.saldoefectivo,
    c.saldodocumento,
    c.saldototal,
    DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fechareg,
    c.estatus 
    FROM tbcaja c
    INNER JOIN tbmoneda AS m ON m.idmoneda=c.idmoneda 
    WHERE c.estatus='1'
    ORDER BY c.cod_caja ASC";
    $req = $this->SelectAll($sql);
    return $req;
  }

  public function ShowDt($id)
  {
    $this->Idcaja = $id;
    $sql = "SELECT 
    c.idcaja,
    c.idmoneda,
    c.cod_caja,
    c.desc_caja,
    m.cod_moneda,
    m.desc_moneda,
    m.simbolo,
    c.saldoefectivo,
    c.saldodocumento,
    c.saldototal,
    DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fechareg,
    c.estatus 
    FROM tbcaja c
    INNER JOIN tbmoneda AS m ON m.idmoneda=c.idmoneda 
    WHERE c.idcaja='$this->Idcaja'";
    $req = $this->Select($sql);
    return $req;
  }

  public function EstatusDt($id, $st)
  {
    $this->Idcaja = $id;
    $this->Estatus = $st;
    $sql = "UPDATE tbcaja SET estatus=? WHERE idcaja='$this->Idcaja'";
    $arrData = array($this->Estatus);
    $request = $this->Update($sql, $arrData);
    return $request;
  }

  public function InsertDt($idmoneda, $cod_caja, $desc_caja, $fechareg)
  {
    $this->Idmoneda = $idmoneda;
    $this->Cod_caja = $cod_caja;
    $this->Desc_caja = $desc_caja;
    $this->Fechareg = $fechareg;
    $this->Saldoefectivo = 0;
    $this->Saldodocumento = 0;
    $this->Saldototal = 0;
    $this->Estatus = '1';
    try {
      $queryInsert = "INSERT INTO tbcaja(idmoneda,cod_caja,desc_caja,fechareg,
        saldoefectivo,saldodocumento,saldototal,estatus)
        VALUES(?,?,?,?,?,?,?,?)";
      $arrData = array(
        $this->Idmoneda, $this->Cod_caja, $this->Desc_caja, $this->Fechareg, $this->Saldoefectivo,
        $this->Saldodocumento, $this->Saldototal, $this->Estatus
      );
      $this->Insert($queryInsert, $arrData);
      return true;
    } catch (PDOException $e) {
      return PDOError($e, 'insert');
    }
  }

  public function EditarDt($id, $idmoneda, $cod_caja, $desc_caja, $fechareg)
  {
    $this->Idcaja = $id;
    $this->Idmoneda = $idmoneda;
    $this->Cod_caja = $cod_caja;
    $this->Desc_caja = $desc_caja;
    $this->Fechareg = $fechareg;
    try {
      $queryInsert = "UPDATE tbcaja SET idmoneda=?,cod_caja=?,desc_caja=?,fechareg=? WHERE idcaja='$this->Idcaja'";
      $arrData = array($this->Idmoneda, $this->Cod_caja, $this->Desc_caja, $this->Fechareg);
      $this->Update($queryInsert, $arrData);
      return true;
    } catch (PDOException $e) {
      return PDOError($e, 'update');
    }
  }

  public function EliminarDt($id)
  {
    $returnData = "";
    $this->Idcaja = $id;
    try {
      $sql = "DELETE FROM tbcaja WHERE idcaja = '$this->Idcaja'";
      $arrData = array($this->Idcaja);
      $returnData = $this->Delete($sql, $arrData);
      return $returnData;
    } catch (PDOException $e) {
      return PDOError($e, 'delete');
    }
  }
}

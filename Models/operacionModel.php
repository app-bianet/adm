<?php
  class operacionModel extends MySql{

    private $Idoperacion;
    private $Cod_operacion;
    private $Desc_operacion;
    private $Escompra;
    private $Esventa;
    private $Esinventario;
    private $Esconfig;
    private $Esbanco;
    private $Estatus;
    private $Op;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      try {
        $sql="SELECT idoperacion,cod_operacion,desc_operacion,escompra,esventa,esinventario,esconfig,esbanco,estatus
        FROM tboperacion";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDt($op){
      $this->Op=$op; 
      try {
        switch ($this->Op) {
          case 'Inventario':
            $sql="SELECT * FROM tboperacion WHERE estatus='1' AND esinventario='1'
            ORDER BY cod_operacion ASC";
            $req=$this->SelectAll($sql);
          break;
  
          case 'Compra':
            $sql="SELECT * FROM tboperacion WHERE estatus='1' AND escompra='1'
            ORDER BY cod_operacion ASC";
            $req=$this->SelectAll($sql);
          break;
  
          case 'Venta':
            $sql="SELECT * FROM tboperacion WHERE estatus='1' AND esventa='1'
            ORDER BY cod_operacion ASC";
            $req=$this->SelectAll($sql);
          break;
  
          case 'Banco':
            $sql="SELECT * FROM tboperacion WHERE estatus='1' AND esbanco='1'
            ORDER BY cod_operacion ASC";
            $req=$this->SelectAll($sql);
          break;
  
          case 'Config':
            $sql="SELECT * FROM tboperacion WHERE estatus='1' AND esconfig='1'
            ORDER BY cod_operacion ASC";
            $req=$this->SelectAll($sql);
          break;
  
          case '':
            $sql="SELECT * FROM tboperacion WHERE estatus='1' ORDER BY cod_operacion ASC";
            $req=$this->SelectAll($sql);
          break;
        }
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      $this->Idoperacion=$id;
      try {
        $sql="SELECT idoperacion,cod_operacion,desc_operacion,escompra,esventa,esinventario,esconfig,esbanco,estatus
        FROM tboperacion WHERE idoperacion= '$this->Idoperacion'";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function EstatusDt($id,$st){
      $this->Idoperacion=$id;
      $this->Estatus=$st;
      try {
        $sql="UPDATE tboperacion SET estatus=? WHERE idoperacion='$this->Idoperacion'";
        $arrData=array($this->Estatus);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($cod_operacion,$desc_operacion,$escompra,$esventa,$esinventario,$esconfig,$esbanco){
      $this->Cod_operacion=$cod_operacion;
      $this->Desc_operacion=$desc_operacion;
      $this->Escompra=$escompra;
      $this->Esventa=$esventa;
      $this->Esinventario=$esinventario;
      $this->Esbanco=$esbanco;
      $this->Esconfig=$esconfig;
      $this->Estatus='1';
      try{  
        $queryInsert="INSERT INTO tboperacion(cod_operacion,desc_operacion,escompra,esventa,esinventario,esconfig,esbanco,estatus)
         VALUES(?,?,?,?,?,?,?,?)";
        $arrData=array($this->Cod_operacion,$this->Desc_operacion,$this->Escompra,$this->Esventa,
        $this->Esinventario,$this->Esconfig,$this->Esbanco,$this->Estatus);
        $request=$this->Insert($queryInsert,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id,$cod_operacion,$desc_operacion,$escompra,$esventa,$esinventario,$esconfig,$esbanco){
      $this->Idoperacion=$id;
      $this->Cod_operacion=$cod_operacion;
      $this->Desc_operacion=$desc_operacion;
      $this->Escompra=$escompra;
      $this->Esventa=$esventa;
      $this->Esinventario=$esinventario;
      $this->Esbanco=$esbanco;
      $this->Esconfig=$esconfig;
      try{  
        $sql="UPDATE tboperacion SET cod_operacion=?,desc_operacion=?,esconpra=?,esventa=?,esinventario=?,
        esconfig=?,esbanco=? WHERE idoperacion='$this->Idoperacion'";
        $arrData=array($this->Cod_operacion,$this->Desc_operacion,$this->Escompra,$this->Esventa,
        $this->Esinventario,$this->Esconfig,$this->Esbanco);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idoperacion=$id;
      try {
        $sql="DELETE FROM tboperacion WHERE idoperacion = '$this->Idoperacion'";
        $arrData=array($this->Idoperacion);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }
    }

  }
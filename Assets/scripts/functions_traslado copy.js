let tabla,iddep,iddepi;
let proceso;

document.addEventListener("DOMContentLoaded", function () {
  proceso = "listar";
  Operacion(proceso);
  InsertarEditar();
  Nuevo();
  SelccionDeposito();
  MostrarModal();
  SelectOp();

  $("input.filtro_buscar").on("keyup click", function () {
    filterGlobal();
  });

  $("input.column_filter").on("keyup click", function () {
    filterColumn($(this).parents("tr").attr("data-column"));
  });

  $("#idartunidad").on('change',function(){
    DataSetUnidad($(this).val())
  })

  $("#idarticulom").on('change',function () { 
    DataSetArtUnidad($(this).val());
  });

  $.post(url_baseL+'Moneda/MostrarBase',{'security':'Moneda'},function(data){	
    data = JSON.parse(data);		
		$('#lbcod_moneda').html(data.simbolo);
	});
});

function filterGlobal() {
  $("#tbdetalle").DataTable().search($("#filtro_buscar").val()).draw();
}

function ListarTabla() {
  //#region
  tabla = $("#tbdetalle").dataTable({
      language: language_dt(),
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true, //Paginación y filtrado realizados por el servidor
      dom: "Bfrtilp", //Definimos los elementos del control de tabla
      columnDefs: [{
        targets: 0, // Tu primera columna
        width: "100px",
        className: "text-center",
        orderable: false,
      },
      {
        targets: 1,
        width: "100px",
        className: "text-center",
      },
      {
        targets: 2,
        width: "120px",
        className: "text-center",
      },
      {
        targets: [3,4],
        width: "280px",
      },
      {
        targets: 5,
        width: "160px",
        className:"text-right"
      },
      {
        targets: [6],
        width: "80px",
        className: "text-center",
        orderable: false,
      },
      ],
      buttons: [{
        extend: "excelHtml5",
        text: '<i class="fa fa-file-excel"></i> Excel ',
        titleAttr: "Exportar a Excel",
        className: "btn btnx btn-sm btn-success",
        exportOptions: { columns: [1,2,3,4,5,6] },
      },
      {
        extend: "csvHtml5",
        text: '<i class="fa fa-file-archive"></i> CSV ',
        titleAttr: "Exportar a Texto",
        className: "btn btnx btn-sm btn-info",
        exportOptions: { columns: [1,2,3,4,5,6] },
      },
      {
        extend: "pdf",
        text: '<i class="fa fa-file-pdf"></i> PDF ',
        titleAttr: "Exportar a PDF",
        className: "btn btnx btn-sm btn-danger",
        exportOptions: { columns: [1,2,3,4,5,6] },
      },
      ],
      ajax: {
        url: url_base + "/Listar",
        method: 'POST', //usamos el metodo POST
        data: {'security':'listar' },
        dataSrc: "",
        error: function (e) {
          console.log(e);
        }
      },
      columns: [
        { data: "opciones" },
        { data: "fechareg" },
        { data: "cod_traslado" },
        { data: "depositoi" },
        { data: "depositod" },
        { data: "totalh" },
        { data: "estatus" },
      ],
      scrollY: "44.5vh",
      responsive: true,
      scrollCollapse: true,
      paging: false,
      resonsieve: true,
      select: true,
      bSort: true,
      bFilter: true,
      bInfo: true,
      bDestroy: true,
      order: [[1, "asc"]], //Ordenar (columna,orden)
    })
  $("div.dataTables_filter").css("display", "none");
  $("div.dt-buttons").prependTo("div.input-group.search");
  //#endregion
}

function filterGlobal() {
  $("#tbdetalle").DataTable().search($("#filtro_buscar").val()).draw();
}

function Nuevo() {
  document.querySelector("#btnAgregar").addEventListener('click', function () {
    proceso = "nuevo";
    Operacion(proceso);
    Cancelar();
  });
}

function Cancelar() {
  document.querySelector("#btnCancelar").addEventListener('click', function () {
    proceso = "cancelar";
    Operacion(proceso);
  });
}



function InsertarEditar() {
  document.addEventListener('submit', function (e) {
    e.preventDefault();
    form = document.querySelector("#dataForm");
    let strCampo = document.querySelectorAll("#fechareg");

      msgOpcion('¿Está Seguro de Guardar el Registro?',"warning").
        then((result) => {
        if (result.isConfirmed) {

            if (empty(strCampo[0].value)) {
              Swal.fire({
                icon: "info",title: 'Atención!',
                html: 'Debe Llenar los Campos Obligatorios <i class="fa fa-exclamation-circle text-red"></i>',
                showConfirmButton: false,timer: 1500});
              for (let x = 0; x < strCampo.length; x++) {
                strCampo[x].classList.add("is-invalid");
              }
            } else {
              ProgressShow('Procesando...');
              let formData = new FormData(form);
              formData.append('security', 'datos');
              let urlAjax = url_base + "/Insertar";
              fetch(urlAjax, {
                method: 'POST',
                body: formData
              })
                .then(response => response.json())
                .catch(error => console.error('Error:', error))
                .then(objData => {
                    if (objData.status) {
                      proceso = "listar";
                      Operacion(proceso);
                        Swal.fire({icon: "success",title: 'Exito!',
                          html: objData.msg,showConfirmButton: false,timer: 1800,
                        });
                    } else {
                      Swal.fire({icon: "error",title: 'Error!',
                        html: objData.msg,customClass: 
                        {confirmButton: "btn btn-sm btnsw btn-primary",icon: "color:red",},
                        buttonsStyling: false,
                      });
                    }
                });
            }
        };
      })
  });
}

//Función para Mostrar registros
function mostrar(idtraslado) {
  const form = document.querySelector("#dataForm");
  let dataset = new FormData(form);
  dataset.append('idtraslado', idtraslado);
  let urlAjax = url_base + "/Mostrar";
  fetch(urlAjax, {
    method: 'POST',
    body: dataset
  })
    .then(response => response.json())
    .then(response => {
      $.each(response, function (label, valor) {
        $("#" + label).val(valor);
      })
      Cancelar();
      $.post(url_base+'/ListarDetalle',{'id':idtraslado},function(r){
        $("#tbdetalles").html(r);
				$("#totalv").html($("#totalt").val());
		});
      proceso = "mostrar";
      Operacion(proceso);
    }); 
}

function eliminar(idtraslado,tipo){

  if(tipo=='Inventario'){
    Swal.fire({
      icon: "error",
      title: "Error!",
      html: 'Los Ajustes de Tipo Inventario no permiten se Eliminados!',
      customClass: "swal-wide",
      customClass: {
        confirmButton: "btn btn-sm btnsw btn-info",
        icon: "color:red",
      },
      buttonsStyling: false,
  });
  }else{
    msgOpcion('Seguro que desea Eliminar el Registro?',"warning").
    then((result) => {
      if (result.isConfirmed) {
        ProgressShow("Eliminado Registros...");
        let form = new FormData()
          form.append('id',idtraslado);
          form.append('tipo',tipo) 
          fetch(url_base+"/Eliminar",({
          body:form,
          method:'POST',//Method
          }))
          .then(res => res.json())
          .catch(data => console.log(data))
          .then(objData =>{
            if (objData.status) {
              Swal.fire({
                icon: "success",
                title: "Exito!",
                html: objData.msg,
                showConfirmButton: false,
                timer: 1800,
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Error!",
                html: objData.msg,
                customClass: "swal-wide",
                customClass: {
                  confirmButton: "btn btn-sm btnsw btn-info",
                  icon: "color:red",
                },
                buttonsStyling: false,
            });
            }
            proceso = "listar";
            Operacion(proceso);
          });
      } else{
        Swal.fire({
          icon: "info",
          title: "Eliminación Cancelada!",
          showConfirmButton: false,
          timer: 1500,
        });
        proceso = "listar";
        Operacion(proceso);
      }
    });
  }
}

function anular(idtraslado,tipo){
  if(tipo=='Inventario'){
    Swal.fire({
      icon: "error",
      title: "Error!",
      html: 'Los Ajustes de Tipo Inventario no permiten se Anulados!',
      customClass: "swal-wide",
      customClass: {
        confirmButton: "btn btn-sm btnsw btn-info",
        icon: "color:red",
      },
      buttonsStyling: false,
  });
  }else{
    msgOpcion('Seguro que desea Anular el Registro?',"warning").
    then((result) => {
      if (result.isConfirmed) {
        ProgressShow("Anulando Registros...");
        let form = new FormData()
          form.append('id',idtraslado);
          form.append('tipo',tipo) 
          fetch(url_base+"/Anular",({
          body:form,
          method:'POST',//Method
          }))
          .then(res => res.json())
          .catch(data => console.log(data))
          .then(objData =>{
            if (objData.status) {
              Swal.fire({
                icon: "success",
                title: "Exito!",
                html: objData.msg,
                showConfirmButton: false,
                timer: 1500,
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Error!",
                html: objData.msg,
                customClass: "swal-wide",
                customClass: {
                    confirmButton: "btn btn-sm btnsw btn-info",
                    icon: "color:red",
                },
                buttonsStyling: false,
            });
            }
            proceso = "listar";
            Operacion(proceso);
          });
      } else{
        Swal.fire({
          icon: "info",
          title: "Anulación Cancelada!",
          showConfirmButton: false,
          timer: 1500,
        });
        proceso = "listar";
        Operacion(proceso);
      }
    });
  }
}

function SelectOp() {
  let formData = new FormData();
  formData.append("security", "listar");

    fetch(url_baseL + "Deposito/Selectpicker", {
        method: "POST",
        body: formData,
      })
      .then((response) => response.text())
      .catch((error) => {
      console.error("Error:", error);
      })
      .then((resp) => {
      $("#iddeposito,#iddepositoi").html(resp);
    });

  fetch(url_baseL + "Unidad/Selectpicker", {
      method: "POST",
      body: formData,
    })
    .then((response) => response.text())
    .catch((error) => {
      console.error("Error:", error);
    })
    .then((resp) => {
    $("#idunidad").html(resp);
  });
}


function SelectDep(){

	$("#iddeposito").change(function () { 
		if($("#iddepositoi option:selected").val()==$(this).val()){
			$("#iddeposito").val("")
			$("#iddepositoi").val("")
      Swal.fire({
        icon: "info",title: 'Atención!',
        html: 'El Deposito de <b>Origen</b> No puede ser Igual al Deposito de <b>Destino!</b>',
        customClass: {
          confirmButton: "btn btn-sm btnsw",
        },
      });
		} else{
			iddepi=$("#iddepositoi").val();
			iddep=$("#iddeposito").val();
			$("#btnAgregarArt").prop('disabled',false);	
		}
	});

	$("#iddepositoi").change(function () { 
		if($("#iddeposito option:selected").val()==$(this).val()){
			$("#iddepositoi").val("")
			$("#iddeposito").val("")
      Swal.fire({
        icon: "info",title: 'Atención!',
        html: 'El Deposito de <b>Origen</b> No puede ser Igual al Deposito de <b>Destino!</b>',
        customClass: {
          confirmButton: "btn btn-sm btnsw",
        },});
		} else{
			iddepi=$("#iddepositoi").val();
			iddep=$("#iddeposito").val();
			$("#btnAgregarArt").prop('disabled',false);	
		}
	});
}

function DataSetArtUnidad(idart) {

  let form = new FormData()
    form.append('security','listarUnidad');
    form.append('id',idart);
  fetch(url_baseL + 'ArtUnidad/SelectpickerOp',({
    body:form,
    method:'POST',//Method
    }))
    .then(res => res.text())
    .catch(data => console.log(data))
    .then(res =>{

      $("#idartunidad").html(res);
      DataSetUnidad($("#idartunidad").val());
      $("#cantidadm,#idartunidad,#idarticulom").change(function () {
        cantidadr = $("#cantidadm").val();
        stockval = $("#stockm").val();
        valorund = $('#valorund').val();
      });   
    });
}

function DataSetUnidad(id) {
  let form = new FormData();
  form.append('id',id);
  fetch(url_baseL+'ArtUnidad/MostrarUnidad',{
    method:'POST',
    body:form
  })
    .then(res => res.json())
    .catch(err=>console.log(err))
    .then(res=>{
      $('#valorund').val(res.valor);
      $('#desc_unidad').val(res.desc_unidad);	
      valorund=parseInt($('#valorund').val());
    });
}

$("#tbdetalle").dataTable();

//Función Listar Articulos
function listarArticulos(){
	tabla=$('#tbarticulos').dataTable({
		aProcessing: true,//Activamos el procesamiento del datatables
		aServerSide: true,//Paginación y filtrado realizados por el servidor
	  dom: 'frtip',//Definimos los elementos del control de tabla
		columnDefs:[{
			"targets":'nd',
			"orderable":false,
			"searchable":false,		
    }],	
		ajax:{
			url: '../controller/traslado.php',
      type : "POST",
      data:{'opcion':'listarArticulos','deporigen':iddepi,'depdestino':iddep},
			dataType : "json",						
			  error: function(e){console.log(e.responseText);}
    },
		bDestroy: true,
		iDisplayLength:8,//Paginación
		order: [[ 1, "asc" ]],//Ordenar (columna,orden)
		bSort: true,
		bFilter:true,
		bInfo:true,
	});
}

let cont=0;
let detalles=0;
function agregarDetalle(idarticulo,iddeposito,cod_articulo,desc_articulo,tipor,costo,stock){
  
	$("#idarticulom").val(idarticulo);
	$("#iddepositom").val(iddeposito);
	$("#cod_articulom").val(cod_articulo);
	$("#desc_articulom").val(desc_articulo);
	$("#tipom").val(tipor);
	$("#costom").val(costo);
	$("#stockm").val(stock);

	if ($("#tipo").val()=='Inventario') {
	 	$("#cantidadm").val(stock);
	}

	$("#ModalArticulo").modal('hide');

  DataSetArtUnidad($("#idarticulom").val());
}
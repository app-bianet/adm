let tabla, tablaart, tablapv, iddep;
let proceso;
var permitir = 0;
var cont = 0;
var detalles = 0;

document.addEventListener("DOMContentLoaded", function () {
  proceso = "listar";
  Operacion(proceso);
  InsertarEditar();
  MostrarModal();
  SelectDeposito();
  SelectCondPago();
  Nuevo();

  $("input.filtro_buscar").on("keyup click", function () {
    filterGlobal();
  });

  $("input.column_filter").on("keyup click", function () {
    filterColumn($(this).parents("tr").attr("data-column"));
  });

  $("#idartunidad").on('change', function () {
    DataSetUnidad($(this).val())
  })

  $("#idarticulom").on('change', function () {
    DataSetArtUnidad($(this).val());
  });

  $.post(url_baseL + 'Moneda/MostrarBase', { 'security': 'Moneda' }, function (data) {
    data = JSON.parse(data);
    $('.lbcod_moneda').html(data.simbolo);
  });

  $("#idcondpago").on('change', function () {
    SelectDias($(this).val());
  });

  $('.nformat').number(true, 2).addClass('text-right');
  $('.nformatn').number(true, 0).addClass('text-right');

});

function filterGlobal() {
  $("#tbdetalle").DataTable().search($("#filtro_buscar").val()).draw();
}

function SelectDeposito() {
  let formData = new FormData();
  formData.append("security", "listar");
  let ajaxUrl = url_baseL + "Deposito/Selectpicker";
  fetch(ajaxUrl, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .catch((error) => {
      console.error("Error:", error);
    })
    .then((resp) => {
      $("#iddepositoh").html(resp);
    });
}

function SelectCondPago() {
  let formData = new FormData();
  formData.append("security", "listar");
  let ajaxUrl = url_baseL + "CondPago/Selectpicker";
  fetch(ajaxUrl, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .catch((error) => {
      console.error("Error:", error);
    })
    .then((resp) => {
      $("#idcondpago").html(resp);
      SelectDias($("#idcondpago").val())
    }
    );
}

function SelectDias(id) {
  let formData = new FormData();
  formData.append('idcondpago', id);
  formData.append('security', 'listar');
  let ajaxUrl = url_baseL + 'CondPago/Mostrar';
  fetch(ajaxUrl, {
    method: 'POST',
    body: formData,
  })
    .then(response => response.json())
    .catch(error => {
      console.error('Error:', error);
    })
    .then(resp => {
      $("#dias").val(resp.dias);
      AddDias(resp.dias);
    });
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
      width: "150px",
      className: "text-center",
      orderable: false,
    },
    {
      targets: [1, 2, 4, 5],
      className: "text-center",
    },
    {
      targets: 3,
    },
    {
      targets: 6,
      className: "text-right"
    },
    {
      targets: 7,
      width: "50px",
      className: "text-center",
      orderable: false,
    },
    ],
    buttons: [{
      extend: "excelHtml5",
      text: '<i class="fa fa-file-excel"></i> Excel ',
      titleAttr: "Exportar a Excel",
      className: "btn btnx btn-sm btn-success",
      exportOptions: { columns: [1, 2, 4, 5, 6, 7] },
    },
    {
      extend: "csvHtml5",
      text: '<i class="fa fa-file-archive"></i> CSV ',
      titleAttr: "Exportar a Texto",
      className: "btn btnx btn-sm btn-info",
      exportOptions: { columns: [1, 2, 4, 5, 6, 7] },
    },
    {
      extend: "pdf",
      text: '<i class="fa fa-file-pdf"></i> PDF ',
      titleAttr: "Exportar a PDF",
      className: "btn btnx btn-sm btn-danger",
      exportOptions: { columns: [1, 2, 4, 5, 6, 7] },
    },
    ],
    ajax: {
      url: url_base + "/Listar",
      method: 'POST', //usamos el metodo POST
      data: { 'security': 'listar' },
      dataSrc: "",
      error: function (e) {
        console.log(e);
      }
    },
    columns: [
      { data: "opciones" },
      { data: "fechareg" },
      { data: "cod_compra" },
      { data: "desc_proveedor" },
      { data: "rif" },
      { data: "numerod" },
      { data: "total" },
      { data: "estatus" },
    ],
    order: [[2, "asc"]], //Ordenar (columna,orden)
    bDestroy: true,
    scrollX: true,
    scrollY: "44.5vh",
    scrollCollapse: true,
    paging: false,
    bSort: true,
    bFilter: true,
    bInfo: true,
  }).css("width", "100% !important");
  $("div.dataTables_filter").css("display", "none");
  $("div.dt-buttons").prependTo("div.input-group.search");
  //#endregion
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

function Operacion(operacion) {
  switch (operacion) {
    case "listar":
      ListarTabla();
      MostrarForm(false);
      break;

    case "nuevo":
      $("#btnGuardar,#btnCancelar").attr("disabled", false);
      $("#btnEditar,select").attr("disabled", true);
      $("input[type=text],input[type=textc],select").val("").attr("readonly", false);
      $("input[type=textx],input[type=control],input[type=controln]").val("");
      $("#subtotalt,#desct,#impuestot,#totalt").html("0.00");
      $("input[type=controln]").val("0");
      $("input[type=control]").val("");
      $(".ffecha").datepicker({
        changeMonth: true,
        changeYear: true,
        showWeek: true,
        autoclose: "false",
        format: "dd/mm/yyyy"
      }).datepicker("setDate", new Date());
      $(".filas").remove();
      detalles = 0;
      $("#estatus").val("Sin Procesar").attr("readonly", true);
      $("#origend").val($("#tipo").val()).attr("readonly", true);
      Evaluar(true);
      MostrarForm(true);
      break;

    case "mostrar":
      $('[data-toggle="tooltip"]').tooltip();
      $("input[type=text],input[type=textc]").attr("readonly", true);
      $("#btnEditar,#btnCancelar").attr("disabled", false);
      $("#btnGuardar,select").attr("disabled", true);
      MostrarForm(true);
      break;

    case "cancelar":
      $("input[type=text],input[type=textc]").attr("readonly", true);
      MostrarForm(false);
      break;
  }
  $("input[type=text],input[type=textc]").removeClass("is-invalid");
}

function MostrarForm(flag) {
  let Formulario = document.querySelector("#formulario");
  let Listado = document.querySelector("#listado");

  if (flag) {
    Formulario.classList.remove("hidden");
    Listado.classList.add("hidden");
    $(".btnhead").addClass("hidden");
  } else {
    Formulario.classList.add("hidden");
    Listado.classList.remove("hidden");
    $(".btnhead").removeClass("hidden");
  }
}

function InsertarEditar() {
  document.addEventListener('submit', function (e) {
    e.preventDefault();
    form = document.querySelector("#dataForm");
    let strCampo = document.querySelectorAll("#numerod,#desc_proveedor");

    if (empty(strCampo[0].value && strCampo[1].value)) {
      Swal.fire({
        icon: "info",
        title: 'Atención!',
        html: 'Debe Llenar los Campos Obligatorios <i class="fa fa-exclamation-circle text-red"></i>',
        showConfirmButton: false,
        timer: 1500,
      });
      for (let x = 0; x < strCampo.length; x++) {
        strCampo[x].classList.add("is-invalid");
      }
    } else {
      msgOpcion(
        "¿Esta Seguro de Guardar el Registro?", "info"
      ).then((result) => {
        if (result.isConfirmed) {
          ProgressShow('Procesando Registros...');
          $("*").attr("disabled", false);
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
                Swal.fire({
                  icon: "success", title: 'Exito!',
                  html: objData.msg, showConfirmButton: false, timer: 1500,
                });
              } else {
                Swal.fire({
                  icon: "error", title: 'Error!', html: objData.msg,
                  customClass: { confirmButton: "btn btn-sm btnsw btn-primary", icon: "color:red", },
                  buttonsStyling: false,
                });
              }
            });
        }
      })
    }
  });
}

//Función para Mostrar registros
function mostrar(idcompra) {
  const form = document.querySelector("#dataForm");
  let dataset = new FormData(form);
  dataset.append('idcompra', idcompra);
  let urlAjax = url_base + "/Mostrar";
  fetch(urlAjax, {
    method: 'POST',
    body: dataset
  })
    .then(response => response.json())
    .then(resp => {
      $.each(resp, function (label, valor) {
        $("#" + label).val(valor);
      })

      $.post(url_base + '/MostrarDetalle', { 'id': idcompra }, function (data) {
        $("#tbdetalles").html(data);
        $("#iddepositoh").val($("#iddeposito").val());
        modificarSubtotales();
        calcularTotales();
        calcularTDescuento();
        $('.nformat').number(true, 2).addClass('text-right');
        $('.nformatn').number(true, 0).addClass('text-right');
        Evaluar(false);
      });
      detalles = 0;

      Cancelar();
      proceso = "mostrar";
      Operacion(proceso);
    });
}

//Función para Activar registros
function activar(idcompra) {
  msgOpcion("¿Desea <b>Activar</b> el Registro?", "warning").then((result) => {
    if (result.isConfirmed) {
      const form = document.querySelector("#dataForm");
      let dataset = new FormData(form);
      dataset.append('idcompra', idcompra);
      let urlAjax = url_base + "/Activar";
      fetch(urlAjax, {
        method: 'POST',
        body: dataset
      })
        .then(response => response.json())
        .catch(error => console.error('Error:', error))
        .then(objData => {
          if (objData.status) {
            Swal.fire({
              icon: "success",
              title: 'Exito!',
              html: objData.msg,
              showConfirmButton: false,
              timer: 1500,
            });
          } else {
            Swal.fire({
              icon: "error",
              title: 'Error!',
              html: objData.msg,
              customClass: {
                confirmButton: "btn btn-sm btnsw btn-primary",
                icon: "color:red",
              },
              buttonsStyling: false,
            });
          }
          proceso = "listar";
          Operacion(proceso);
        });
    } else {
      Swal.fire({
        icon: "info",
        title: "Activación Cancelada!",
        showConfirmButton: false,
        timer: 1000,
      });
    }
  });
}

//Función para Desactivar registros
function desactivar(idcompra) {
  msgOpcion("¿Desea <b>Desactivar</b> el Registro?", "warning").then((result) => {
    if (result.isConfirmed) {
      const form = document.querySelector("#dataForm");
      let dataset = new FormData(form);
      dataset.append('idcompra', idcompra);
      let urlAjax = url_base + "/Desactivar";
      fetch(urlAjax, {
        method: 'POST',
        body: dataset
      })
        .then(response => response.json())
        .catch(error => console.error('Error:', error))
        .then(objData => {
          if (objData.status) {
            Swal.fire({
              icon: "success",
              title: 'Exito!',
              html: objData.msg,
              showConfirmButton: false,
              timer: 1500,
            });
          } else {
            Swal.fire({
              icon: "error",
              title: 'Error!',
              html: objData.msg,
              customClass: {
                confirmButton: "btn btn-sm btnsw btn-primary",
                icon: "color:red",
              },
              buttonsStyling: false,
            });
          }
          proceso = "listar";
          Operacion(proceso);
        });
    } else {
      Swal.fire({
        icon: "info",
        title: "Desactivación Cancelada!",
        showConfirmButton: false,
        timer: 1000,
      });
    }
  });
}

//Función para Eliminar registros
function eliminar() {
  document.querySelector(".btnEliminar").addEventListener('click', function () {
    msgOpcion(
      "¿Esta Seguro de <b>Eliminar</b> los Registros Seleccionados?", "warning"
    ).then((result) => {
      if (result.isConfirmed) {
        ProgressShow('Eliminando Registros...');
        const form = document.querySelector("#tableForm");
        let dataset = new FormData(form);
        dataset.append('security', 'eliminar')
        let urlAjax = url_base + "/Eliminar";
        fetch(urlAjax, {
          method: 'POST',
          body: dataset
        })
          .then(response => response.json())
          .catch(error => console.error('Error:', error))
          .then(objData => {
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
      } else {
        Swal.fire({
          icon: "info",
          title: "Eliminacion Cancelada!",
          showConfirmButton: false,
          timer: 1500,
        });
        proceso = "listar";
        Operacion(proceso);
      }
    });
  });
}

$("#tbdetalle").dataTable();

//Agregar Dias de Vencimiento
function AddDias(toAdd) {

  if (!toAdd || toAdd == '' || isNaN(toAdd)) return;

  var d = new Date();
  d.setDate(d.getDate() + parseInt(toAdd));

  var yesterDAY = (d.getDate() < 10 ? "0" + d.getDate() : d.getDate()) + "/" +
    ((d.getMonth() + 1) < 10 ? "0" + (d.getMonth() + 1) : (d.getMonth() + 1)) + "/" + d.getFullYear();

  $("#fechaven").val(yesterDAY);

}

//Mostrar Ventanas Modal
function MostrarModal() {
  $('#desc_proveedor').on('click', (e) => {
    e.preventDefault();
    listarProveedor()
    SelectCondPago();
    $("#cod_proveedor,#desc_proveedor,#rif,select").val("")
    $("#modalProveedor").modal('show')
  });

  $('#btnCerrarModalp').on('click', (e) => {
    e.preventDefault();
    $("#cod_proveedor,#desc_proveedor,#rif,select").val("");
    $("#idcondpago,#iddepositoh,#btnAgregarItem").attr("disabled", true);
    $("#modalProveedor").modal('toggle')
  });

  $('#btnNuevoProveedor').on('click', (e) => {
    e.preventDefault();
    $("#cod_proveedor,#desc_proveedor,#rif,select").val("");
    $("#idcondpago,#iddepositoh,#btnAgregarItem").attr("disabled", true);
    $("#modalProveedorNuevo").modal('show');
    RegistrarProveedor();
  });

  $("#btnCerrarP").on('click',(e)=> { 
    e.preventDefault();
		$("#modalProveedorNuevo").modal('toggle');
    $("#cod_proveedor,#desc_proveedor,#rif,select").val("");
    $("#idcondpago,#iddepositoh,#btnAgregarItem").attr("disabled", true);
	});

  $("#btnImportar").on('click',(e)=>{ 
    e.preventDefault();
    $("#modalImportar").modal('show');
    $('#iddeposito').val("");
    $("#estatusdoc,#tipodoc").attr("disabled",false);
      if ($("#tipo").val()=='Cotizacion') {
          $('option[value=Cotizacion]').removeClass('hidden')
          $('option[value=Pedido]').addClass('hidden')
          $('option[value=Factura]').addClass('hidden')
      } else if ($("#tipo").val()=='Pedido') {
          $('option[value=Cotizacion]').removeClass('hidden')
          $('option[value=Pedido]').addClass('hidden')
          $('option[value=Factura]').addClass('hidden')
      } else if ($("#tipo").val()=='Factura') {
          $('option[value=Cotizacion]').removeClass('hidden')
          $('option[value=Pedido]').removeClass('hidden')
          $('option[value=Factura]').addClass('hidden')
      }
    //Tipo de Documento(FACTURA/PEDIDO/COTIZACION)
    $("#tipodoc").change(function(){
      $("#estatusdoc").val("sinp");
      listarTipoDoc($("#idproveedor").val(),$("#estatusdoc").val(),$("#tipodoc").val());
    });

  //Estado del Documento(PROCESADO/SIN PROCESAR)
    $("#estatusdoc").change(function(){
      listarTipoDoc($("#idproveedor").val(),$("#estatusdoc").val(),$("#tipodoc").val());
    });		
	});
}

//Listar Documentos Pendientes
function listarTipoDoc(id,sts,tipo){
	tabladoc=$('#tbdocumento').dataTable({
    language: language_dt(),
		aProcessing: true,//Activamos el procesamiento del datatables
		aServerSide: true,//Paginación y filtrado realizados por el servidor
		dom: 'frtip',//Definimos los elementos del control de tabla
		ajax:{
			url: url_baseL+'Proveedor/ImportarDoc',
			type : "POST",
			dataType : "json",
			data:{'opcion':'importarDoc','id':id,'estatus':sts,'tipo':tipo},			
			error: function(e){
				console.log(e.responseText);
			}
		},
    bDestroy: true,
    iDisplayLength: 8,//Paginación
    order: [[3, "asc"]],//Ordenar (columna,orden)
    bFilter: true,
    bInfo: true,
	});
}

function RegistrarProveedor() {
  document.querySelector("#btnGuardarProveedor")
  .addEventListener("click", (e) => {
    e.preventDefault();

      form = document.querySelector("#dataProveeedor");
      let strCampo = document.querySelectorAll("#cod_proveedori,#rifi,#desc_proveedori,#direccion");

      if (empty(strCampo[0].value && strCampo[1].value && strCampo[2].value && strCampo[3].value)) {
        Swal.fire({
          icon: "info",
          title: "Atención!",
          html:
            'Debe Llenar los Campos Obligatorios <i class="fa fa-exclamation-circle text-red"></i>',
          showConfirmButton: false,
          timer: 1500,
        });
        for (let x = 0; x < strCampo.length; x++) {
          strCampo[x].classList.add("is-invalid");
        }
      } else {
        msgOpcion("¿Esta Seguro de Guardar el Registro?", "info").then(
          (result) => {
            if (result.isConfirmed) {
              ProgressShow("Procesando Registros...");
              let formData = new FormData(form);
              formData.append("security", "post");
              let urlAjax = url_baseL + "Proveedor/InsertarProveedorRapido";
              fetch(urlAjax, {
                method: "POST",
                body: formData,
              })
                .then((response) => response.json())
                .catch((error) => console.error("Error:", error))
                .then((objData) => {
                  if (objData.status) {
                    $("#modalProveedorNuevo").modal("toggle");
                    listarProveedor();
                    SelectCondPago();
                    $("#cod_proveedor,#desc_proveedor,#rif,select").val("");
                    $("#modalProveedor").modal("show");
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
                      customClass: {
                        confirmButton: "btn btn-sm btnsw btn-primary",
                        icon: "color:red",
                      },
                      buttonsStyling: false,
                    });
                  }
              });
            }
          }
        );
      }
  });
}

//Listar Proveedor a Procesar
function listarProveedor() {
  tablapv = $('#tbproveedor').dataTable({
    language: language_dt(),
    aProcessing: true,//Activamos el procesamiento del datatables
    aServerSide: true,//Paginación y filtrado realizados por el servidor
    dom: 'frtip',//Definimos los elementos del control de tabla	
    columnDefs: [{
      targets: 0, // Tu primera columna
      className: "text-center",
      orderable: false,
    }],
    ajax:
    {
      url: url_base + '/ListarProveedor',
      type: "POST",
      dataType: "json",
      data: { 'opcion': 'listarProveedor' },
      error: function (e) { console.log(e.responseText); }
    },
    bDestroy: true,
    iDisplayLength: 8,//Paginación
    order: [[1, "asc"]],//Ordenar (columna,orden)
    bFilter: true,
    bInfo: true,
  });
}

function agregarProveedor(idproveedor, idcondpago, cod_proveedor, cod_proveedor, desc_proveedor, rif, dias, limite) {
  $("#idproveedor").val(idproveedor);
  $("#desc_proveedor").val(desc_proveedor);
  $("#cod_proveedor").val(cod_proveedor);
  $("#rif").val(rif);
  $("#idcondpago").val(idcondpago);
  $("#dias").val(dias);
  $("#limite").val(limite);
  $("#idcondpago,#iddepositoh").attr("disabled", false);
  $("#desc_proveedor").attr("readonly",true);
  AddDias(dias);
  SelccionDeposito()
  $("#modalProveedor").modal('toggle');

  $("#btnAgregarItem").click(function () {
    $("#modalCrearArticulo").modal('show');
    $("#iddepositoh").attr("disabled", true);
  });

  $("#cod_articulom").click(function () {
    $("#modalArticulo").modal('show');
  });

  agregarRengon();
}

//Agrgar Documento a Importar
function agregarImportarDoc(idcompraop,idproveedor,idcondpago,cod_proveedor,desc_proveedor,rif,dias,limite,tipo,origenc){
  $("#idcompraop").val(idcompraop);
  $("#idproveedor").val(idproveedor);
  $("#cod_proveedor").val(cod_proveedor);
  $("#desc_proveedor").val(desc_proveedor);
  $("#rif").val(rif);
  $("#idcondpago").val(idcondpago);
  $("#dias").val(dias);	
  $("#limite").val(limite);
  $("#origend").val(tipo);
  $("#origenc").val(origenc);
  
  $('#idcondpago').prop('disabled', false);
  AddDias(dias);

  $("#modalImportar").modal('toggle');	
  ImportarDetalle($("#idcompraop").val());	
}

//Agregar Detalle de Documento Importado
function ImportarDetalle(id){
	$.post(url_baseL+'Proveedor/DetalleImportar',{'id':id},function(r){
		$('#tbdetalles').html(r)
		$("span.nformat").number(true,2);
		$("input.nformat").number(true,2);
		$('#iddepositoh,#btnAgregarItem').prop('disabled', true);
    $("#iddepositoh").val($(".depp").val());
		modificarSubtotales();
		calcularTotales();
		detalles=$("#detalles").val();
		Evaluar(true);
	});
}

//Seleccionar Deposito para Proceso
function SelccionDeposito() {
  $("#iddepositoh").change(function () {
    $("#btnAgregarItem").prop("disabled", false);
    iddep = $("#iddepositoh").val();
    listarArticulos(iddep);
  });
}

//Listar Articulos a Procesar
function listarArticulos(id) {
  tablaart = $('#tbarticulos').dataTable({
    language: language_dt(),
    aProcessing: true,//Activamos el procesamiento del datatables
    aServerSide: true,//Paginación y filtrado realizados por el servidor
    dom: 'frtip',//Definimos los elementos del control de tabla
    columnDefs: [{
      targets: 0, // Tu primera columna
      className: "text-center",
      orderable: false,
    }],
    ajax:
    {
      url: url_base + '/ListarArticulos',
      type: "POST",
      dataType: "json",
      data: { 'id': id },
      error: function (e) {
        console.log(e.responseText);
      }
    },
    bDestroy: true,
    iDisplayLength: 8,//Paginación
    order: [[1, "asc"]],//Ordenar (columna,orden)
    bFilter: true,
    bInfo: true,
  });
}

function agregarArticulo(idarticulo, iddeposito, cod_articulo, desc_articulo, tipoa, costo, tasa, stock) {
  $("#idarticulom").val(idarticulo);
  $("#iddepositom").val(iddeposito);
  $("#cod_articulom").val(cod_articulo);
  $("#desc_articulom").val(desc_articulo);
  $("#tipom").val(tipoa);
  $("#costom").val(costo);
  $("#tasam").val(tasa);
  $("#stockm").val(stock);

  $("#modalArticulo").modal('hide');
  $("#idartunidad").attr("disabled", false);
  DataSetArtUnidad(idarticulo);
}

function DataSetArtUnidad(idart) {
  let form = new FormData()
  form.append('security', 'listarUnidad');
  form.append('id', idart);
  fetch(url_baseL + 'ArtUnidad/SelectpickerOp', ({
    body: form,
    method: 'POST',//Method
  }))
    .then(res => res.text())
    .catch(data => console.log(data))
    .then(res => {

      $("#idartunidad").html(res);
      DataSetUnidad($("#idartunidad").val());
      $("#cantidadm,#idartunidad,#idarticulom").change(function () {
        cantidadr = $("#cantidadm").val();
        stockval = $("#stockm").val();
        valorund = $("#valorund").val();
      });
    });
}

function DataSetUnidad(id) {
  let form = new FormData();
  form.append('id', id);
  fetch(url_baseL + 'ArtUnidad/MostrarUnidad', {
    method: 'POST',
    body: form
  })
    .then(res => res.json())
    .catch(err => console.log(err))
    .then(res => {
      $("#valorund").val(res.valor);
      $("#desc_unidad").val(res.desc_unidad);
      valorund = parseInt($("#valorund").val());
    });
}

function agregarRengon() {
  $('#btnAceptarM').on('click', (e) => {
    e.preventDefault();
      DataSetAgregarRenglon();
      $("#iddepositoh").attr("disabled", true);
      $("#modalCrearArticulo").modal('toggle');
      $("input.control,select.control").val("");
      validar = 0;
      stockval = 0;
      cantidadr = 0;
      valorund = 0;
  });
}

function DataSetAgregarRenglon() {

  var idarticulov, idartunidadv, iddepositov, cantidadv, tipov, valorv, costov;
  var cod_articulov, desc_articulov, desc_unidadv, tasav;
  var totalt = 0;
  var pdescv = 0;

  idarticulov = $.trim($("#idarticulom").val());
  iddepositov = $.trim($("#iddepositoh").val());
  idartunidadv = $.trim($("#idartunidad").val());
  cod_articulov = $.trim($("#cod_articulom").val());
  desc_articulov = $.trim($("#desc_articulom").val());
  desc_unidadv = $.trim($("#desc_unidad").val());
  cantidadv = $.trim($("#cantidadm").val());
  costov = $.trim($("#costom").val());
  tasav = $.trim($("#tasam").val());
  tipov = $.trim($("#tipom").val());
  valorv = $.trim($("#valorund").val());
  if($("#cantidadm").val() == 0) {
    Swal.fire({
      icon: "error", title: "Error!",
      html: "Debe ingresar una Cantidad para poder agregar el Artículo!",
      customClass: "swal-wide",
      customClass: { confirmButton: "btn btn-sm btnsw btn-info", icon: "color:red", },
      buttonsStyling: false,
    });
  }else if ($("#idarticulom").val() == $("#idarticulo").val()) {
    Swal.fire({
      icon: "error", title: 'Renglon Duplicado!',
      html: 'El Articulo ya Fue Seleccionado<br>\
      Para hacer Cambios debe Eliminar el Renglon',
      customClass: "swal-wide",
      customClass: { confirmButton: "btn btn-sm btnsw btn-info", icon: "color:red", },
      buttonsStyling: false,
    });
  } else {

    var subtotal = cantidadv * (costov * valorv);
    var subimp = (((costov * valorv) * tasav) / 100) * cantidadv;
    totalt = subtotal + subimp;
    var fila =
      '<tr class="filas" id="fila' + cont + '">' +
      '<td style="width:30px; text-align:center;">\
        <button type="button" class="btn btn-danger btn-xs" onclick="eliminarDetalle(' + cont + ')">\
        <span class="fa fa-times-circle"></span></button>\
      </td>'+
      '<td class="hidden">\
      <input name="idarticulo[]" id="idarticulo" value="' + idarticulov + '" type="text">' +
      '<input name="iddeposito[]" id="iddeposito[]" value="' + iddepositov + '" type="text">' +
      '<input name="idartunidad[]" id="idartunidad[]" value="' + idartunidadv + '" type="text">' +
      '<input name="tipoa[]" id="tipoa[]" value="' + tipov + '" type="text">' +
      '<input name="tasa[]" id="tasa[]" value="' + tasav + '" type="text">' +
      '<input name="valor[]" id="valor[]" value="' + valorv + '" type="text">' +
      '<input type="text" onchange="modificarSubtotales()" name="cantidad[]" id="cantidad" value="' + cantidadv + '"></td>\
      </td>'+
      '<td style="min-width:150px;"><h6>' + cod_articulov + '</h6></td>' +
      '<td style="min-width:400px;">\
        <input type="text" class="form-control form-control-sm" \
        style="height: calc(1.650rem); border:none;" value="'+ desc_articulov + '">\
      </td>' +
      '<td style="min-width:90px;"><h6>' + desc_unidadv + '</h6></td>' +
      '<td style="min-width:80px;"><h6 class="text-right">' + cantidadv + '</h6></td>' +
      '<td style="min-width:150px;">\
        <input type="text" class="form-control form-control-sm text-right" \
        style="height: calc(1.650rem); border:none;" \
        value="'+ ($.number(costov * valorv, 2, '.', '')) + '" name="costo[]" id="costo[]" onchange="modificarSubtotales()">\
       </td>' +
      '<td style="min-width:80px">\
        <input type="text" onchange="modificarSubtotales()" class="form-control form-control-sm text-right" \
        style="height: calc(1.650rem); border:none;" name="pdesc[]" id="pdesc[]"  value="'+ pdescv + '" >\
      </td>'+
      '<td style="min-width:150px;"><h6 name="mdesc" id="mdesc" class="nformat text-right">0.00</h6></td>' +
      '<td style="min-width:150px;"><h6 class="nformat text-right" id="subtotal" name="subtotal" >' + subtotal + '</h6></td>' +
      '<td style="min-width:150px;"><h6 class="nformat text-right" "id="subimp" name="subimp">' + subimp + '</h6></td>' +
      '<td style="min-width:150px;"><h6 id="total' + cont + '" name="total" class="nformat text-right">' + totalt + '</h6></td>'
    '<td class="hidden"><h6>' + tasav + '</h6></td>' +
      '</tr>';
    cont++;
    detalles = detalles + 1;
    $('#tbdetalles').append(fila);
    modificarSubtotales();
    calcularTotales();
    calcularTDescuento();
  }
}

//Calculos
function modificarSubtotales() {
  var prec = document.getElementsByName("costo[]");
  var cant = document.getElementsByName("cantidad[]");
  var sub = document.getElementsByName("subtotal");
  var subi = document.getElementsByName("subimp");
  var tasa = document.getElementsByName("tasa[]");
  var pdes = document.getElementsByName("pdesc[]");
  var mdes = document.getElementsByName("mdesc");

  for (var i = 0; i < cant.length; i++) {
    var inpC = cant[i];
    var inpP = prec[i];
    var inpS = sub[i];
    var Tax = tasa[i];
    var inpI = subi[i];
    var inpPD = pdes[i];
    var inpMD = mdes[i];

    inpS.value = inpC.value * inpP.value;
    inpMD.value = (inpS.value * inpPD.value) / 100
    inpI.value = (((inpS.value - inpMD.value) * Tax.value) / 100)
    //inpPD= (inpMD.value*100)/inpS.value;

    //document.getElementsByName("pdesc[]")[i].innerHTML = inpPD.value;
    document.getElementsByName("mdesc")[i].innerHTML = inpMD.value;
    document.getElementsByName("subtotal")[i].innerHTML = inpS.value - inpMD.value;
    document.getElementsByName("subimp")[i].innerHTML = inpI.value;
    document.getElementsByName("total")[i].innerHTML = inpI.value + (inpS.value - inpMD.value);
  }

  calcularSubTotales();
  calcularTotalesIVA();
  calcularTotales();
  calcularTDescuento();
  $('.nformat').number(true, 2).addClass('text-right');
  $('.nformatn').number(true, 0).addClass('text-right');
}

function calcularSubTotales() {
  var subt = document.getElementsByName("subtotal");
  var stotal = 0.0;

  for (var i = 0; i < subt.length; i++) {
    stotal += document.getElementsByName("subtotal")[i].value;
  }

  $("#subtotalt").html(stotal);
  $("#subtotalh").val(stotal);
  Evaluar(true);
  $('.nformat').number(true, 2).addClass('text-right');
  $('.nformatn').number(true, 0).addClass('text-right');
}

function calcularTotales() {
  var sub = document.getElementsByName("subtotal");
  var total = 0.0;

  for (var i = 0; i < sub.length; i++) {
    total += ((document.getElementsByName("subtotal")[i].value) - (document.getElementsByName("mdesc")[i].value)) + document.getElementsByName("subimp")[i].value;
  }

  $("#totalt").html(total);
  $("#totalh").val(total);

  if ($("#tipo").val() != 'Cotizacion') {
    $("#saldoh").val(total);
  }
  Evaluar(true);
  $('.nformat').number(true, 2).addClass('text-right');
  $('.nformatn').number(true, 0).addClass('text-right');
}

function calcularTDescuento() {
  var sub = document.getElementsByName("mdesc");
  var mtotal = 0.0;

  for (var i = 0; i < sub.length; i++) {
    mtotal += document.getElementsByName("mdesc")[i].value;
  }

  $("#desct").html(mtotal);
  $("#desch").val(mtotal);

  Evaluar(true);
  $('.nformat').number(true, 2).addClass('text-right');
  $('.nformatn').number(true, 0).addClass('text-right');
}

function calcularTotalesIVA() {
  var subi = document.getElementsByName("subtotal");
  var totali = 0.0;

  for (var i = 0; i < subi.length; i++) {
    totali += document.getElementsByName("subimp")[i].value;
  }

  $("#impuestot").html(totali);
  $("#impuestoh").val(totali);
  $('.nformat').number(true, 2).addClass('text-right');
  $('.nformatn').number(true, 0).addClass('text-right');
  Evaluar(true);
}

function anular(idcompra, tipo, origenc, origend, totalh) {
  msgOpcion(
    "¿Desea <b>Anular</b> el Registro?<br>\
    Este Proceso es Irreversible",
    "warning"
  ).then((result) => {
    if (result.isConfirmed) {
      let dataset = new FormData();
      dataset.append("id", idcompra);
      dataset.append("tipo", tipo);
      dataset.append("origenc", origenc);
      dataset.append("origend", origend);
      dataset.append("totalh", totalh);
      let urlAjax = url_base + "/Anular";
      fetch(urlAjax, {
        method: "POST",
        body: dataset,
      })
        .then((response) => response.json())
        .catch((error) => console.error("Error:", error))
        .then((objData) => {
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
              customClass: {
                confirmButton: "btn btn-sm btnsw btn-primary",
                icon: "color:red",
              },
              buttonsStyling: false,
            });
          }
          proceso = "listar";
          Operacion(proceso);
        });
    } else {
      Swal.fire({
        icon: "info",
        title: "Anulación Cancelada!",
        showConfirmButton: false,
        timer: 1000,
      });
    }
  });
}

function eliminar(idcompra, tipo, origenc, origend, totalh) {
  msgOpcion(
    "¿Desea <b>Eliminar</b> el Registro?<br>\
    Este Proceso es Irreversible",
    "warning"
  ).then((result) => {
    if (result.isConfirmed) {
      let dataset = new FormData();
      dataset.append("id", idcompra);
      dataset.append("tipo", tipo);
      dataset.append("origenc", origenc);
      dataset.append("origend", origend);
      dataset.append("totalh", totalh);
      let urlAjax = url_base + "/Eliminar";
      fetch(urlAjax, {
        method: "POST",
        body: dataset,
      })
        .then((response) => response.json())
        .catch((error) => console.error("Error:", error))
        .then((objData) => {
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
              customClass: {
                confirmButton: "btn btn-sm btnsw btn-primary",
                icon: "color:red",
              },
              buttonsStyling: false,
            });
          }
          proceso = "listar";
          Operacion(proceso);
        });
    } else {
      Swal.fire({
        icon: "info",
        title: "Eliminación Cancelada!",
        showConfirmButton: false,
        timer: 1000,
      });
    }
  });
}

//Eliminar Renglon
function eliminarDetalle(indice) {

  $("#fila" + indice).remove();
  detalles = --detalles;
  calcularTotales();
  calcularTotalesIVA();
  calcularSubTotales();
  calcularTDescuento();
  Evaluar(true);
  if ($("#idcompraop").val() != '') {
    $("#iddepositoh").prop('disabled', true);
  }
}

//Eliminar Detalle Documento Importado
function eliminarImp() {
  $(".filas").remove();
  detalles = --detalles;
  calcularTotales();
  calcularTotalesIVA();
  calcularSubTotales();
  calcularTDescuento();
  Evaluar(true);
}

//Evaluar Cantidad de Renglones
function Evaluar(validar) {
  if (validar) {
    if (detalles > 0) {
      $("#btnGuardar").prop('disabled', false);
      $("#desc_proveedor,#iddepositoh").prop('disabled', true);
    } else {
      $("#btnGuardar").prop('disabled', true);
      $("#desc_proveedor,#iddepositoh").prop('disabled', false);
      cont = 0;
    }
  } else {
    $("#btnImportar").prop('disabled', false);
    $("#iddepositoh").prop('disabled', true);
  }
}
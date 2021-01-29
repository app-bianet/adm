let tabla;
let proceso;

document.addEventListener("DOMContentLoaded", function () {
  proceso = "listar";
  Operacion(proceso);
  InsertarEditar();
  eliminar();
  Nuevo();

  $("input.filtro_buscar").on("keyup click", function () {
    filterGlobal();
  });

  $("input.column_filter").on("keyup click", function () {
    filterColumn($(this).parents("tr").attr("data-column"));
  });

  SeleccionarGrupo();
});


function ListarTabla() {
  //#region
  tabla = $("#tbdetalle")
    .dataTable({
      "language": language_dt(),
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true, //Paginación y filtrado realizados por el servidor
      dom: "Bfrti", //Definimos los elementos del control de tabla
      columnDefs: [
        {
          targets: "nd", //clase para definir las columnas a tratar
          orderable: false, //Definimos no ordenar por esta columna
          searchable: false, //Definimos no buscar por esta columna
        },
      ],
      columnDefs: [
        {
          targets: 0, // Tu primera columna
          width: "10%",
          className: "text-center",
          orderable: false,
        },
        {
          targets: 1,
          width: "12%",
          className: "text-center",
        },
        {
          targets: 3,
          width: "15%",
          orderable: false,
        },
        {
          targets: [4,5],
          width: "5%",
          className: "text-center",
          orderable: false,
        }
      ],
      buttons: [
        {
          extend: "excelHtml5",
          text: '<i class="fa fa-file-excel"></i> Excel ',
          titleAttr: "Exportar a Excel",
          className: "btn btnx btn-sm btn-success",
          exportOptions: { columns: [1, 2, 3, 5] },
        },
        {
          extend: "csvHtml5",
          text: '<i class="fa fa-file-archive"></i> CSV ',
          titleAttr: "Exportar a Texto",
          className: "btn btnx btn-sm btn-info",
          exportOptions: { columns: [1, 2, 3, 5] },
        },
        {
          extend: "pdf",
          text: '<i class="fa fa-file-pdf"></i> PDF ',
          titleAttr: "Exportar a PDF",
          className: "btn btnx btn-sm btn-danger",
          exportOptions: { columns: [1, 2, 3, 5] },
        },
      ],
      ajax: {
        url: " " + url_base + "/Listar",
        method: 'POST', //usamos el metodo POST
        data:{'security':'listar'},
        dataSrc: "",
      },
      columns: [
        { data: "opciones" },
        { data: "cod_macceso" },
        { data: "desc_macceso" },
        { data: "departamento" },
        { data: "eliminar" },
        { data: "estatus" },
      ],
      scrollY: "44.5vh",
      scrollCollapse: true,
      paging: false,
      bSort: true,
      bFilter: true,
      bInfo: true,
      bDestroy: true,
      order: [[1, "asc"]], //Ordenar (columna,orden)
    }).DataTable();
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
    ActivarCheck('.chk')
  });
}

function Cancelar() {
  document.querySelector("#btnCancelar").addEventListener('click', function () {
    proceso = "cancelar";
    Operacion(proceso);
  });
}

function Editar() {
  document.querySelector("#btnEditar").addEventListener('click', function () {
    proceso = "editar";
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
      $("#btnGuardar,#btnCancelar,select,.btnmarcar").attr("disabled", false);
      $("#btnEditar").attr("disabled", true);
      $("input[type=text],input[type=textc]").val("").attr("readonly", false);
      Accesos('','')
      MostrarForm(true);
    break;

    case "mostrar":
      $('[data-toggle="tooltip"]').tooltip();
      $("input[type=text],input[type=textc]").attr("readonly", true);
      $("#btnGuardar,select,.btnmarcar").attr("disabled", true);
      $("#btnEditar,#btnCancelar").attr("disabled", false);
      MostrarForm(true);
    break;

    case "editar":
      $("input[type=text],input[type=textc]").attr("readonly", false);
      $("#btnEditar").attr("disabled", true);
      $("#btnGuardar,#btnCancelar,select,input[type=checkbox].chk,.btnmarcar").attr("disabled", false);

    break;

    case "cancelar":
      $("input[type=text],input[type=textc]").attr("readonly", true);
      ListarTabla();
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
    msgOpcion("¿Está Seguro de Guardar el Registro?, Recuerde que debe Salir e Ingresar Nuevamente\
    para hacer Efectivo los cambios en el Perfil de Acceso!","info")
    .then((result) => {
      if (result.isConfirmed) {  
        ProgressShow('Procesando...');
      form = document.querySelector("#dataForm");
      let strCampo = document.querySelectorAll("#cod_macceso,#desc_macceso");

      if (empty(strCampo[0].value) && empty(strCampo[1].value)) {
        Swal.fire({
          icon: "info",title: 'Atención!',
          html: 'Debe Llenar los Campos Obligatorios <i class="fa fa-exclamation-circle text-red"></i>',
          showConfirmButton: false,timer: 1500,
        });
        strCod.classList.add("is-invalid");
        strDesc.classList.add("is-invalid");
      } 
      else {
        let formData = new FormData(form);
        formData.append('security','datos');
        let urlAjax = url_base + "/Insertar";
        fetch(urlAjax, {
          method:'POST',
          body: formData
          })
          .then(response => response.json())
          .catch(error => console.error('Error:', error))
          .then(objData => {
          if (objData.status) {
            proceso = "listar";
            Operacion(proceso);
            Swal.fire({
              icon: "success",title: 'Exito!',
              html: objData.msg,showConfirmButton: false,
              timer: 1500,
            });
          } else {
            Swal.fire({ 
              icon: "error",title: 'Error!',html: objData.msg,
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
  });
});
}

//Función para Mostrar registros
function mostrar(idmacceso) {
    const form = document.querySelector("#dataForm");
    let dataset = new FormData(form);
    dataset.append('idmacceso',idmacceso);
    let urlAjax = url_base + "/Mostrar";
    fetch(urlAjax, {
    method:'POST',
    body: dataset })
    .then(response => response.json())
    .then(response => {
      $.each(response, function (label, valor) {
        $("#" + label).val(valor);
      });
      ActivarCheck('.chk');
      Accesos(idmacceso);
      Editar();
      Cancelar();
      proceso = "mostrar";
      Operacion(proceso);
    }
  );

}

//Función para Activar registros
function activar(idmacceso) {
    msgOpcion("¿Desea <b>Activar</b> el Registro?","warning").then((result) => {
    if (result.isConfirmed) {
      const form = document.querySelector("#dataForm");
      let dataset = new FormData(form);
      dataset.append('idmacceso',idmacceso);
      let urlAjax = url_base + "/Activar";
        fetch(urlAjax, {
        method:'POST',
        body:dataset })
        .then(response => response.json())
        .catch(error => console.error('Error:', error))
        .then(objData=> {
          if (objData.status) {
            Swal.fire({
              icon: "success",title: 'Exito!',
              html: objData.msg, showConfirmButton: false,timer: 1500,
            });
          } else {
            Swal.fire({ 
              icon: "error", title:'Error!',
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
        icon: "info",title: "Activación Cancelada!",
        showConfirmButton: false,timer: 1000,
      });
    }
  });
}

//Función para Desactivar registros
function desactivar(idmacceso) {
    msgOpcion("¿Desea <b>Desactivar</b> el Registro?","warning").then((result) => {
    if (result.isConfirmed) {
      const form = document.querySelector("#dataForm");
      let dataset = new FormData(form);
      dataset.append('idmacceso',idmacceso);
      let urlAjax = url_base + "/Desactivar";
        fetch(urlAjax, {
        method:'POST',
        body:dataset })
        .then(response => response.json())
        .catch(error => console.error('Error:', error))
        .then(objData=> {
          if (objData.status) {
            Swal.fire({
              icon: "success",title: 'Exito!',
              html: objData.msg, showConfirmButton: false,timer: 1500,
            });
          } else {
            Swal.fire({ 
              icon: "error", title:'Error!',
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
        icon: "info",title: "Desactivación Cancelada!",
        showConfirmButton: false,timer: 1000,
      });
    }
  });
}


//Función para Eliminar registros
function eliminar() {
  document.querySelector(".btnEliminar").addEventListener('click', function () {
    msgOpcion(
      "¿Esta Seguro de <b>Eliminar</b> los Registros Seleccionados?","warning"
    ).then((result) => {
      if (result.isConfirmed) {
        ProgressShow('Eliminando Registros!');  
        const form = document.querySelector("#tableForm");
        let dataset = new FormData(form);
        dataset.append('security','eliminar')
        let urlAjax = url_base + "/Eliminar";
        fetch(urlAjax, {
          method:'POST',
          body:dataset })
          .then(response => response.json())
          .catch(error => console.error('Error:', error))
          .then(objData=> {
            if (objData.status) {
              Swal.fire({
                icon: "success", title:"Exito!",
                html: objData.msg, showConfirmButton: false,
                timer: 1500,
              });
            } else {
              Swal.fire({
                icon: "error",title: "Error!",
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
          icon: "info",title: "Eliminacion Cancelada!",
          showConfirmButton: false,timer: 1500,
        });
        proceso = "listar";
        Operacion(proceso);
      }
    });
  });
}

function msgOpcion(mensaje,type) {
  return swal.fire({
    html: mensaje,
    icon: type,
    confirmButtonText: "Ok",
    cancelButtonText: "Cancelar",
    showCancelButton: true,
    customClass: {
      confirmButton: "btn btn-sm btnsw btn-success",
      cancelButton: "btn btn-sm btnsw btn-danger",
      icon: "color:red",
    },
    buttonsStyling: false,
  });
}

$("#tbdetalle").dataTable();

function Accesos(idmacceso) {

  $.post(url_base+'/AccesoTab', {'modulo':'config',idmacceso: idmacceso,'security':'listaaccesos' }, function (r) { 
    $("#config").html(r);
    $("input[type=checkbox].chk").attr("disabled",true);
  });

  $.post(url_base+'/AccesoTab', {'modulo':'inventario',idmacceso: idmacceso, 'security':'listaaccesos' },  function (r) { 
    $("#inventario").html(r);
    $("input[type=checkbox].chk").attr("disabled",true);
  });
  
  $.post(url_base+'/AccesoOp', {'modulo':'opinventario', idmacceso: idmacceso, 'security':'listaaccesos' },  function (r) {
    $("#opinventario").html(r);
    $("input[type=checkbox].chk").attr("disabled",true);
  });

  $.post(url_base+'/AccesoTab', {'modulo':'compras', idmacceso: idmacceso, 'security':'listaaccesos' },  function (r) {
    $("#compras").html(r);
    $("input[type=checkbox].chk").attr("disabled",true);
  });
  $.post(url_base+'/AccesoOp', {'modulo':'opcompras', idmacceso: idmacceso, 'security':'listaaccesos' },  function (r) {
    $("#opcompras").html(r);
    $("input[type=checkbox].chk").attr("disabled",true);
  });

  $.post(url_base+'/AccesoTab', {'modulo':'ventas', idmacceso: idmacceso, 'security':'listaaccesos' },  function (r) {
    $("#ventas").html(r);
    $("input[type=checkbox].chk").attr("disabled",true);
  });
  $.post(url_base+'/AccesoOp', {'modulo':'opventas', idmacceso: idmacceso, 'security':'listaaccesos' },  function (r) {
    $("#opventas").html(r);
    $("input[type=checkbox].chk").attr("disabled",true);
  });

  $.post(url_base+'/AccesoTab', {'modulo':'bancos', idmacceso: idmacceso, 'security':'listaaccesos' },  function (r) {
    $("#bancos").html(r);
    $("input[type=checkbox].chk").attr("disabled",true);
  });
  $.post(url_base+'/AccesoOp', {'modulo':'opbancos', idmacceso: idmacceso, 'security':'listaaccesos' },  function (r) {
    $("#opbancos").html(r);
    $("input[type=checkbox].chk").attr("disabled",true);
  });

}


function ActivarCheck(marcar) {
  chekOp = document.querySelectorAll('input'); //Rescatamos controles tipo Input
  for (i = 0; i < chekOp.length; i++) {//Ejecutamos y recorremos los controles
    if (chekOp[i].type == "checkbox") { // Ejecutamos si es una casilla de verificacion
      chekOp[i].checked = marcar.checked; // Si el input es CheckBox se aplica la funcion ActivarCasilla
    }
  }
}


function SeleccionarGrupo() {

  $("#btnMarcaConf").click(function () { 
    $('.chkconfig')
    .attr('checked', true)
    $('.aconfig')
    .removeClass('text-success fa fa-check-circle')
    .removeClass('text-danger fa fa-times-circle')
    .addClass('text-success fa fa-check-circle');
  });

  $("#btnDelConf").click(function () { 
    $('.chkconfig')
    .attr('checked', false)
    $('.aconfig')
    .removeClass('text-success fa fa-check-circle')
    .removeClass('text-danger fa fa-times-circle')
    .addClass('text-danger fa fa-times-circle');
  });

  $("#btnMarcaInv").click(function () { 
    $('.chkinventario,.chkopinventario')
      .attr('checked', true);
      $('.ainventario,.aopinventario')
			.removeClass('text-success fa fa-check-circle')
			.removeClass('text-danger fa fa-times-circle')
			.addClass('text-success fa fa-check-circle');
  });

  $("#btnDelInv").click(function () { 
    $('.chkinventario,.chkopinventario')
      .attr('checked', false);
      $('.ainventario,.aopinventario')
			.removeClass('text-success fa fa-check-circle')
			.removeClass('text-danger fa fa-times-circle')
			.addClass('text-danger fa fa-times-circle');
  });

  $("#btnMarcaCxp").click(function () { 
    $('.chkcompras,.chkopcompras')
    .attr('checked', true);
    $('.acompras,.aopcompras')
    .removeClass('text-success fa fa-check-circle')
    .removeClass('text-danger fa fa-times-circle')
    .addClass('text-success fa fa-check-circle');
  });

  $("#btnDelCxp").click(function () { 
    $('.chkcompras,.chkopcompras')
      .attr('checked', false);
      $('.acompras,.aopcompras')
			.removeClass('text-success fa fa-check-circle')
			.removeClass('text-danger fa fa-times-circle')
			.addClass('text-danger fa fa-times-circle');
  });

  
  $("#btnMarcaCxc").click(function () { 
    $('.chkventas,.chkopventas')
      .attr('checked', true);
      $('.aventas,.aopventas')
			.removeClass('text-success fa fa-check-circle')
			.removeClass('text-danger fa fa-times-circle')
			.addClass('text-success fa fa-check-circle');
  });

  $("#btnDelCxc").click(function () { 
    $('.chkventas,.chkopventas')
      .attr('checked', false);
      $('.aventas,.aopventas')
			.removeClass('text-success fa fa-check-circle')
			.removeClass('text-danger fa fa-times-circle')
			.addClass('text-danger fa fa-times-circle');
  });

  $("#btnMarcaBan").click(function () { 
    $('.chkbancos,.chkopbancos')
      .attr('checked', true);
      $('.abancos,.aopbancos')
			.removeClass('text-success fa fa-check-circle')
			.removeClass('text-danger fa fa-times-circle')
			.addClass('text-success fa fa-check-circle');
  });

  $("#btnDelBan").click(function () { 
    $('.chkbancos,.chkopbancos')
      .attr('checked', false);
      $('.abancos,.aopbancos')
			.removeClass('text-success fa fa-check-circle')
			.removeClass('text-danger fa fa-times-circle')
			.addClass('text-danger fa fa-times-circle');
  });
}
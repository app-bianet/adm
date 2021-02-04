let tabla;
let proceso;

document.addEventListener("DOMContentLoaded", function () {
  proceso = "listar";
  Operacion(proceso);
  InsertarEditar();
  eliminar();
  Nuevo();
  ConfirmarClaveUser();

  $("#imagena").change(function () {
    filePreview(this);
    $('label[for="imagena"]').html('Imagen Cargada');
  });

  $("input.filtro_buscar").on("keyup click", function () {
    filterGlobal();
  });

  $("input.column_filter").on("keyup click", function () {
    filterColumn($(this).parents("tr").attr("data-column"));
  });

});

function filePreview(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.readAsDataURL(input.files[0]);
    reader.onload = function (e) {
      $('#imagenmuestra').addClass('hidden');
      $('#imagenah').after('<img id="imagenmuestra" class="img-fluid img-bordered-sm mb-3 pad" style="max-width: 90%" src="' + e.target.result + '">');
    }
  }
}

function Select() {
  var formData = new FormData();
  formData.append('security', 'listar');
  let ajaxUrl = url_baseL + 'MAcceso/Selectpicker';
  fetch(ajaxUrl, {
    method: 'POST',
    body: formData
  })
    .then(response => response.text())
    .catch(error => console.error('Error:', error))
    .then(resp => {
      let dataln = resp;
      let ln = "";
      if (dataln.length > 0) {
        for (let index = 0; index < dataln.length; index++) {
          ln += dataln[index][0];
        }
        $("#idmacceso").html(ln);
      } else {
        $('#idmacceso').html('');
        $('#idmacceso').append('<option readonly>No Existen Registros</option>');
      }
    });
}

function ListarTabla() {
  //#region
  tabla = $("#tbdetalle")
    .dataTable({
      "language": language_dt(),
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true, //Paginación y filtrado realizados por el servidor
      dom: "Bfrtip", //Definimos los elementos del control de tabla
      columnDefs: [{
        targets: 0, // Tu primera columna
        width: "110px",
        className: "text-center",
        orderable: false,
      },
      {
        targets: 1,
        width: "15%",
        className: "text-center",
      },
      {
        targets: 3,
        width: "20%",
        orderable: false,
      },
      {
        targets: [4, 5],
        width: "5%",
        className: "text-center",
        orderable: false,
      }
      ],
      buttons: [{
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
        data: { 'security': 'listar' },
        dataSrc: "",
      },
      columns: [
        { data: "opciones" },
        { data: "cod_usuario" },
        { data: "desc_usuario" },
        { data: "acceso" },
        { data: "eliminar" },
        { data: "estatus" },
      ],
      scrollY: "44.5vh",
      scrollCollapse: true,
      paging: false,
      resonsieve: true,
      select: true,
      bSort: true,
      bFilter: true,
      bInfo: true,
      bDestroy: true,
      order: [
        [1, "asc"]
      ], //Ordenar (columna,orden)
    }).dataTable().css("width", "100% !important");
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
      $("#btnGuardar,#btnCancelar,select").attr("disabled", false);
      $("#btnEditar").attr("disabled", true);
      $("input[type=text],input[type=textc],input[type=password]").val("").attr("readonly", false)
        .removeClass("is-invalid,is-valid");
      $('#imagenmuestra').remove();
      $('#imagenah').after('<img id="imagenmuestra" class="img-fluid img-bordered-sm mb-3 pad \
      style="max-width: 50%" src="' + url_baseL + '/Files/images/items/no-foto.jpg">');
      Select()
      $(".ffecha").datepicker({
        changeMonth: true,
        changeYear: true,
        showWeek: true,
        autoclose: "false",
        format: "dd/mm/yyyy"
      }).datepicker("setDate", new Date());
      ConfirmarClaveUser();
      MostrarForm(true);
      break;

    case "mostrar":
      $('[data-toggle="tooltip"]').tooltip();
      $("input[type=text],input[type=textc],input[type=password]").attr("readonly", true);
      $("#btnEditar,#btnCancelar").attr("disabled", false);
      $("#btnGuardar,select").attr("disabled", true);
      $("label[for=imagena]").css({ 'cursor': 'default', 'background-color': '#ccc' });
      $("#imagena").attr('type', 'text');
      $("input[type=text],input[type=textc],input[type=password]").removeClass("is-invalid,is-valid");
      MostrarForm(true);
      break;

    case "editar":
      $("input[type=text],input[type=textc],input[type=password]").attr("readonly", false);
      $("#btnEditar").attr("disabled", true);
      $("#btnGuardar,#btnCancelar,select").attr("disabled", false);
      $("#clave").val("");
      $("#confclave").val("");
      $("label[for=imagena]").css({
        'cursor': 'pointer',
        'background-color': '#106BA0'
      });
      $("#imagena").attr('type', 'file');
      ConfirmarClaveUser();
      break;

    case "cancelar":
      $("input[type=text],input[type=textc],input[type=password]").attr("readonly", true);
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

    let strCampo = document.querySelectorAll("#cod_usuario,#desc_usuario");

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
        });
    }
  });
}

//Función para Mostrar registros
function mostrar(idusuario) {
  const form = document.querySelector("#dataForm");
  let dataset = new FormData(form);
  dataset.append('idusuario', idusuario);
  let urlAjax = url_base + "/Mostrar";
  fetch(urlAjax, {
    method: 'POST',
    body: dataset
  })
    .then(response => response.json())
    .then(response => {
      $.each(response, function (label, valor) {
        $("#" + label).val(valor);
        $('#idmacceso').val(response.idmacceso);
        let str = response.clave;
        if (str.length > 10) str = str.substring(0, 10);
        $("#clave").val(str);
        $("#confclave").val(str);
        Editar();
        Cancelar();
        proceso = "mostrar";
        Operacion(proceso);
        // 'style="max-width: 50%" src="'+url_baseL+'/Files/images/items/no-foto.jpg">');
      })
      if (response.imagen == '' || response.imagen == null) {
        $('#imagenmuestra').remove();
        $('#imagenah').after('<img id="imagenmuestra" class="img-fluid img-bordered-sm mb-3 pad \
      style="max-width: 50%" src="' + url_baseL + 'Files/images/items/no-foto.jpg">')
        $("#imagenactual").val('')
      } else {
        $('#imagenmuestra').remove();
        $('#imagenah').after('<img id="imagenmuestra" class="img-fluid img-bordered-sm mb-3 pad \
      style="max-width: 50%" src="' + url_baseL + 'Files/images/user/' + response.imagen + '">')
        $("#imagenactual").val(response.imagen)
      }
    });
  Select();
}

//Función para Activar registros
function activar(idusuario) {
  msgOpcion("¿Desea <b>Activar</b> el Registro?", "warning").then((result) => {
    if (result.isConfirmed) {
      const form = document.querySelector("#dataForm");
      let dataset = new FormData(form);
      dataset.append('idusuario', idusuario);
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
function desactivar(idusuario) {
  msgOpcion("¿Desea <b>Desactivar</b> el Registro?", "warning").then((result) => {
    if (result.isConfirmed) {
      const form = document.querySelector("#dataForm");
      let dataset = new FormData(form);
      dataset.append('idusuario', idusuario);
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

function ConfirmarClaveUser() {
  $("#confclave")
    .change(function () {
      if ($(this).val() != $("#clave").val()) {
        Swal.fire({
          icon: 'info',
          html: 'La Nueva <b>Clave Ingresada</b> no Concide con la <b>Clave de Confirmacion!</b>',
          showConfirmButton: true,
        });
      }
    })
    .on('keyup', function () {
      if ($(this).val() != $("#clave").val()) {
        $("#confclave,#clave").removeClass("is-valid");
        $("#confclave,#clave").addClass("is-invalid");
      } else {
        $("#confclave,#clave").removeClass("is-invalid");
        $("#confclave,#clave").addClass("is-valid");
      }
    });
}
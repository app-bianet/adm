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
});

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
      width: "120px",
      className: "text-center",
    },
    {
      targets: 2,
      width: "350px",
    },
    {
      targets: 3,
      width: "80px",
      className: "text-center",
    },
    {
      targets: 4,
      width: "250px",
    },
    {
      targets: 5,
      width: "120px",
      className:"text-right"
    },
    {
      targets: [6, 7],
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
      exportOptions: { columns: [1, 2, 4] },
    },
    {
      extend: "csvHtml5",
      text: '<i class="fa fa-file-archive"></i> CSV ',
      titleAttr: "Exportar a Texto",
      className: "btn btnx btn-sm btn-info",
      exportOptions: { columns: [1, 2, 4] },
    },
    {
      extend: "pdf",
      text: '<i class="fa fa-file-pdf"></i> PDF ',
      titleAttr: "Exportar a PDF",
      className: "btn btnx btn-sm btn-danger",
      exportOptions: { columns: [1, 2, 4] },
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
      { data: "cod_cuenta" },
      { data: "desc_cuenta" },
      { data: "cod_banco" },
      { data: "numcuenta" },
      { data: "saldot" },
      { data: "eliminar" },
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
    order: [
      [1, "asc"]
    ], //Ordenar (columna,orden)
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
      $("#btnGuardar,#btnCancelar").attr("disabled", false);
      $("#btnEditar").attr("disabled", true);
      $("input[type=text],input[type=textc]").val("").attr("readonly", false);
      MostrarForm(true);
      break;

    case "mostrar":
      $('[data-toggle="tooltip"]').tooltip();
      $("input[type=text],input[type=textc]").attr("readonly", true);
      $("#btnEditar,#btnCancelar").attr("disabled", false);
      $("#btnGuardar").attr("disabled", true);
      MostrarForm(true);
      break;

    case "editar":
      $("input[type=text],input[type=textc]").attr("readonly", false);
      $("#btnEditar").attr("disabled", true);
      $("#btnGuardar,#btnCancelar").attr("disabled", false);
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
    let strCampo = document.querySelectorAll("#cod_cuenta,#desc_cuenta");

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
function mostrar(idcuenta) {
  const form = document.querySelector("#dataForm");
  let dataset = new FormData(form);
  dataset.append('idcuenta', idcuenta);
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
      Editar();
      Cancelar();
      proceso = "mostrar";
      Operacion(proceso);
    });

}

//Función para Activar registros
function activar(idcuenta) {
  msgOpcion("¿Desea <b>Activar</b> el Registro?", "warning").then((result) => {
    if (result.isConfirmed) {
      const form = document.querySelector("#dataForm");
      let dataset = new FormData(form);
      dataset.append('idcuenta', idcuenta);
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
function desactivar(idcuenta) {
  msgOpcion("¿Desea <b>Desactivar</b> el Registro?", "warning").then((result) => {
    if (result.isConfirmed) {
      const form = document.querySelector("#dataForm");
      let dataset = new FormData(form);
      dataset.append('idcuenta', idcuenta);
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
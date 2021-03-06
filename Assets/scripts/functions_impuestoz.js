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

  $("#idimpuestozh").on("change", function () {
    SelectImp($("#idimpuestozh").val());
    ListarTabla($("#idimpuestozh").val());
  });
});

function SelecP() {
  let formData = new FormData();
  formData.append("security", "listar");

  let ajaxUrl = url_base + "/Selectpicker";
  fetch(ajaxUrl, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .catch((error) => {
      console.error("Error:", error);
    })
    .then((resp) => {
      $("#idimpuestozh").html(resp);
      SelectImp($("#idimpuestozh").val());
      ListarTabla($("#idimpuestozh").val());
    });
}

function SelectImp(id) {
  let formData = new FormData();
  formData.append("idimpuestoz", id);
  let ajaxUrl = url_base + "/Mostrar";
  fetch(ajaxUrl, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .catch((error) => {
      console.error("Error:", error);
    })
    .then((resp) => {
      $("#cod_impuestoz").val(resp.cod_impuestoz);
    });
}

function ListarTabla(id) {
  //#region
  tabla = $("#tbdetalle")
    .dataTable({
      language: language_dt(),
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true, //Paginación y filtrado realizados por el servidor
      dom: "frtilp", //Definimos los elementos del control de tabla
      columnDefs: [
        {
          targets: 0, // Tu primera columna
          width: "60px",
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
          width: "350px",
        },
        {
          targets: 3,
          width: "50px",
          className: "text-right",
        },
        {
          targets: [4, 5],
          width: "100px",
          className: "text-right",
        },
        {
          targets: 6,
          width: "50px",
          className: "text-center",
          orderable: false,
        },
      ],
      ajax: {
        url: url_base + "/Listar",
        method: "POST", //usamos el metodo POST
        data: { id: id },
        dataSrc: "",
      },
      columns: [
        { data: "opciones" },
        { data: "cod_concepto" },
        { data: "desc_concepto" },
        { data: "base" },
        { data: "retencion" },
        { data: "sustraendo" },
        { data: "eliminar" },
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
    .css("width", "100% !important");
  $("div.dataTables_filter").css("display", "none");
  //#endregion
}

function filterGlobal() {
  $("#tbdetalle").DataTable().search($("#filtro_buscar").val()).draw();
}

function Nuevo() {
  document.querySelector("#btnAgregar").addEventListener("click", function () {
    proceso = "nuevo";
    Operacion(proceso);
    Cancelar();
  });
}

function Cancelar() {
  document.querySelector("#btnCancelar").addEventListener("click", function () {
    proceso = "cancelar";
    Operacion(proceso);
  });
}

function Editar() {
  document.querySelector("#btnEditar").addEventListener("click", function () {
    proceso = "editar";
    Operacion(proceso);
  });
}

function Operacion(operacion) {
  switch (operacion) {
    case "listar":
      SelecP();
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
  document.addEventListener("submit", function (e) {
    e.preventDefault();
    form = document.querySelector("#dataForm");
    let strCampo = document.querySelectorAll("#cod_impuestoz,#desc_impuestoz");

    if (empty(strCampo[0].value && strCampo[1].value)) {
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
      let formData = new FormData(form);
      formData.append("security", "datos");
      let urlAjax = url_base + "/Insertar";
      fetch(urlAjax, {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .catch((error) => console.error("Error:", error))
        .then((objData) => {
          if (objData.status) {
            proceso = "listar";
            Operacion(proceso);
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
  });
}

//Función para Mostrar registros
function mostrar(idimpuestozd) {
  const form = document.querySelector("#dataForm");
  let dataset = new FormData(form);
  dataset.append("id", idimpuestozd);
  let urlAjax = url_base + "/MostrarDt";
  fetch(urlAjax, {
    method: "POST",
    body: dataset,
  })
    .then((response) => response.json())
    .then((response) => {
      $.each(response, function (label, valor) {
        $("#" + label).val(valor);
      });
      Editar();
      Cancelar();
      proceso = "mostrar";
      Operacion(proceso);
    });
}

//Función para Activar registros
function activar(idimpuestoz) {
  msgOpcion("¿Desea <b>Activar</b> el Registro?", "warning").then((result) => {
    if (result.isConfirmed) {
      const form = document.querySelector("#dataForm");
      let dataset = new FormData(form);
      dataset.append("idimpuestoz", idimpuestoz);
      let urlAjax = url_base + "/Activar";
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
        title: "Activación Cancelada!",
        showConfirmButton: false,
        timer: 1000,
      });
    }
  });
}

//Función para Desactivar registros
function desactivar(idimpuestoz) {
  msgOpcion("¿Desea <b>Desactivar</b> el Registro?", "warning").then(
    (result) => {
      if (result.isConfirmed) {
        const form = document.querySelector("#dataForm");
        let dataset = new FormData(form);
        dataset.append("idimpuestoz", idimpuestoz);
        let urlAjax = url_base + "/Desactivar";
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
          title: "Desactivación Cancelada!",
          showConfirmButton: false,
          timer: 1000,
        });
      }
    }
  );
}

//Función para Eliminar registros
function eliminar() {
  document.querySelector(".btnEliminar").addEventListener("click", function () {
    msgOpcion(
      "¿Esta Seguro de <b>Eliminar</b> los Registros Seleccionados?",
      "warning"
    ).then((result) => {
      if (result.isConfirmed) {
        ProgressShow("Eliminando Registros...");
        const form = document.querySelector("#tableForm");
        let dataset = new FormData(form);
        dataset.append("security", "eliminar");
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

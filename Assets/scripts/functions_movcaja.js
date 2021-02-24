let tabla;
let proceso;
let saldot=0;

document.addEventListener("DOMContentLoaded", function () {
  proceso = "listar";
  Operacion(proceso);
  InsertarEditar();
  Nuevo();
  Monto();
  SelectOp();

  $('.chk').on('click', function () {
    if ($(this).is(':checked')) {
        $(this).val('1')
    } else {
        $(this).val('0')
    }
});

  $("#idcaja").on('change', () => {
    SelectCaja($("#idcaja").val());
    $("#monto").val(0);
  })


  $("#idbanco").on('change', () => {
    SelectBanco($("#idbanco").val());
  })


  $("input.filtro_buscar").on("keyup click", function () {
    filterGlobal();
  });

  $("input.column_filter").on("keyup click", function () {
    filterColumn($(this).parents("tr").attr("data-column"));
  });
});

function SelectOp() {
  let formData = new FormData();
  formData.append("security", "listar");
  formData.append("op", "Banco");

  fetch(url_baseL + "Caja/Selectpicker", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .catch((error) => {
      console.error("Error:", error);
    })
    .then((resp) => {
      $("#idcaja").html(resp);
      SelectCaja($("#idcaja").val());
    });

  fetch(url_baseL + "Banco/Selectpicker", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .catch((error) => {
      console.error("Error:", error);
    })
    .then((resp) => {
      $("#idbanco").html(resp);
      SelectBanco($("#idbanco").val());
    });

  fetch(url_baseL + "Operacion/Selectpicker", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .catch((error) => {
      console.error("Error:", error);
    })
    .then((resp) => {
      $("#idoperacion").html(resp);
    });
}

function SelectCaja(id) {
  let formData = new FormData();
  formData.append("idcaja", id);
  fetch(url_baseL + "Caja/Mostrar", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .catch((error) => {
      console.error("Error:", error);
    })
    .then((resp) => {
      $("#cod_caja").val(resp.cod_caja);
      saldot=resp.saldototal;
    });
}

function SelectBanco(id) {
  let formData = new FormData();
  formData.append("idbanco", id);
  fetch(url_baseL + "Banco/Mostrar", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .catch((error) => {
      console.error("Error:", error);
    })
    .then((resp) => {
      $("#cod_banco").val(resp.cod_banco);
    });
}

//Determinar Forma si es Efectivo o Instrumentos Disntitos
function FormaOp() {
  $("#forma").on('change', ()=> {
    if ($("#forma").val() === 'Cheque' || $("#forma").val() === 'Tarjeta') {
      $("#idbanco").attr('disabled', false)
      $("#numeroc").attr('readonly', false);
      $("#idbanco,#numeroc").val("").attr('required', true);;
    } else {
      $("#idbanco").attr('disabled', true)
      $("#numeroc").attr('readonly', true);
      $("#idbanco,#numeroc").val("").attr('required', false);;
    }
  });
}

function Monto(){

	let monto;
	let tipo;
	$("#tipo").change(function(){
		tipo=$(this).val();
		monto=$("#monto").val();

		if (tipo=='Ingreso') {
      $("#forma").attr("disabled",false);
			$("#montod").val(monto);
			$("#montoh").val(0);
		} else {
      $("#forma").attr("disabled",true).val('Efectivo');
			$("#montoh").val(monto);
			$("#montod").val(0);
      ValidarSaldo(saldot, monto, tipo);
	  }
FormaOp();
	});

	$("#monto").change(function(){
		monto=$(this).val();
		tipo=$("#tipo").val();

		if (tipo=='Ingreso') {
      $("#forma").attr("disabled",false);
			$("#montod").val(monto);
			$("#montoh").val(0);
		} else {
      $("#forma").attr("disabled",true).val('Efectivo');
			$("#montoh").val(monto);
			$("#montod").val(0);
      ValidarSaldo(saldot, monto, tipo);
		}
	});


}

function ValidarSaldo(saldo, monto, op) {
  let validar = saldo - monto;
  if (op == 'Egreso' &&	monto > 0) {
    if (validar < 0) {
      msgOpcion("El Monto de la Operacion es Mayor al saldo Disponible!<br>\
        "+ ($.number(validar, 2, '.', ',')) + "</b> en Caja! ¿Desea Continuar?",
        "warning").then((result) => {
        if (!result.isConfirmed) {
          $("#monto").val(0.00);
          $("#montod").val(0.00);
          $("#montoh").val(0.00);
        }
      });
    }
  }
}

function ListarTabla() {
  //#region
  tabla = $("#tbdetalle").dataTable({
    language: language_dt(),
    aProcessing: true, //Activamos el procesamiento del datatables
    aServerSide: true, //Paginación y filtrado realizados por el servidor
    dom: "Bfrtilp", //Definimos los elementos del control de tabla
    columnDefs: [
      {
        targets: 0, // Tu primera columna
        width: "150px",
        className: "text-center",
        orderable: false,
      },
      {
        targets: 1, // Tu primera columna
        width: "90px",
        className: "text-center",
      },
      {
        targets: 2, // Tu primera columna
        width: "110px",
        className: "text-center",
      },
      {
        targets: 3, // Tu primera columna
        width: "350px",
      },
      {
        targets: [4, 5], // Tu primera columna
        width: "100px",
        className: "text-center",
      },
      {
        targets: 6, // Tu primera columna
        width: "100px",
      },
      {
        targets: 7, // Tu primera columna
        width: "150px",
        className: "text-right",
      },
      {
        targets: 8,
        width: "70px",
        className: "text-center",
        orderable: false,
      },
    ],
    buttons: [{
      extend: "excelHtml5",
      text: '<i class="fa fa-file-excel"></i> Excel ',
      titleAttr: "Exportar a Excel",
      className: "btn btnx btn-sm btn-success",
      exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8] },
    },
    {
      extend: "csvHtml5",
      text: '<i class="fa fa-file-archive"></i> CSV ',
      titleAttr: "Exportar a Texto",
      className: "btn btnx btn-sm btn-info",
      exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8] },
    },
    {
      extend: "pdf",
      text: '<i class="fa fa-file-pdf"></i> PDF ',
      titleAttr: "Exportar a PDF",
      className: "btn btnx btn-sm btn-danger",
      exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8] },
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
      { data: "cod_movcaja" },
      { data: "caja" },
      { data: "tipo" },
      { data: "forma" },
      { data: "numerod" },
      { data: "monto" },
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
    order: [[2, "asc"]], //Ordenar (columna,orden)
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
      $("#btnGuardar,#btnCancelar,select,.chk").attr("disabled", false);
      $("#btnEditar,#idbanco").attr("disabled", true);
      $("input[type=text],input[type=textc]").val("").attr("readonly", false);
      $("#origen").val("Caja");
      $("#estatus").val("Sin Procesar");
      $("#fechareg").datepicker({
        changeMonth: true,
        changeYear: true,
        autoclose: "true",
        format: "dd/mm/yyyy"
      }).datepicker("setDate", new Date());

      EventoCheckBox();
      $("#tipo").val('Ingreso');
 //     TipoOp($("#tipo").val());
      FormaOp();
      MostrarForm(true);
      break;

    case "mostrar":
      $('[data-toggle="tooltip"]').tooltip();
      $("input[type=text],input[type=textc],.idbanco").attr("readonly", true);
      $("#btnCancelar").attr("disabled", false);
      $("#btnGuardar,#idbanco,.chk,select").attr("disabled", true);
      EventoCheckBox();
      FormaOp();
      MostrarForm(true);
      break;

    case "editar":
      $("input[type=text],input[type=textc]").attr("readonly", false);
      $("#btnGuardar,#btnCancelar,.chk,select").attr("disabled", false);
      $("#btnEditar,#idbanco").attr("disabled", true);
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
    let strCampo = document.querySelectorAll("#numerod,#monto");

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
          $("*").attr("disabled",false);
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
function mostrar(idmovcaja) {
  const form = document.querySelector("#dataForm");
  let dataset = new FormData(form);
  dataset.append('idmovcaja', idmovcaja);
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

      let valuea = $("#tipo").val();
      let valueb = $("#montoh").val();
      let valuec = $("#montod").val();

      if (valuea === 'Ingreso') {
        $('#monto').val(valuec);
      } else if (valuea === 'Egreso') {
        $('#monto').val(valueb);
      }

      if (resp.origen == 'Caja' && resp.estatus != 'Anulado') {
        $("#btnEditar").attr('disabled', false);
      }
      else {
        $("#btnEditar").attr('disabled', true);
      }

      Editar();
      Cancelar();
      proceso = "mostrar";
      Operacion(proceso);
    });

}

//Función para Activar registros
function anular(idmovcaja, idcaja) {
  msgOpcion("¿Desea <b>Anular</b> el Registro?<br>\
  Este Proceso es Irreversible!", "warning").then((result) => {
    if (result.isConfirmed) {
      let dataset = new FormData();
      dataset.append('idmovcaja', idmovcaja);
      dataset.append('idcaja', idcaja);
      let urlAjax = url_base + "/Anular";
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
        title: "Anulación Cancelada!",
        showConfirmButton: false,
        timer: 1000,
      });
    }
  });
}

function eliminar(idmovcaja, idcaja) {
  msgOpcion("¿Desea <b>Eliminar</b> el Registro?<br>\
  Este Proceso es Irreversible!", "warning").then((result) => {
    if (result.isConfirmed) {
      let dataset = new FormData();
      dataset.append('idmovcaja', idmovcaja);
      dataset.append('idcaja', idcaja);
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
        title: "Eliminación Cancelada!",
        showConfirmButton: false,
        timer: 1000,
      });
    }
  });
}

$("#tbdetalle").dataTable();

function EventoCheckBox() {
  $("input[type=checkbox].chk").show(function () {
      var value = $(this).val();
      if (value == 0) {
          $(this).prop('checked', false);
      } else {
          $(this).prop('checked', true);
      }
  });

}
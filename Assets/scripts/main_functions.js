function language_dt() {
  lenguaje = {
    "processing": "Procesando...",
    "lengthMenu": "Mostrar _MENU_ registros",
    "zeroRecords": "No se encontraron resultados",
    "emptyTable": "No Existen Registros!",
    "info": "Total Registros: _TOTAL_ registros",
    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
    "search": "Buscar:",
    "infoThousands": ",",
    "loadingRecords": "Cargando...",
    "paginate": {
      "first": "Primero",
      "last": "Último",
      "next": "Siguiente",
      "previous": "Anterior"
    },
    "aria": {
      "sortAscending": ": Activar para ordenar la columna de manera ascendente",
      "sortDescending": ": Activar para ordenar la columna de manera descendente"
    },
    "buttons": {
      "copy": "Copiar",
      "colvis": "Visibilidad",
      "collection": "Colección",
      "colvisRestore": "Restaurar visibilidad",
      "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
      "copySuccess": {
        "1": "Copiada 1 fila al portapapeles",
        "_": "Copiadas %d fila al portapapeles"
      },
      "copyTitle": "Copiar al portapapeles",
      "csv": "CSV",
      "excel": "Excel",
      "pageLength": {
        "-1": "Mostrar todas las filas",
        "1": "Mostrar 1 fila",
        "_": "Mostrar %d filas"
      },
      "pdf": "PDF",
      "print": "Imprimir"
    },
    "autoFill": {
      "cancel": "Cancelar",
      "fill": "Rellene todas las celdas con <i>%d<\/i>",
      "fillHorizontal": "Rellenar celdas horizontalmente",
      "fillVertical": "Rellenar celdas verticalmentemente"
    },
    "decimal": ",",
    "searchBuilder": {
      "add": "Añadir condición",
      "button": {
        "0": "Constructor de búsqueda",
        "_": "Constructor de búsqueda (%d)"
      },
      "clearAll": "Borrar todo",
      "condition": "Condición",
      "conditions": {
        "date": {
          "after": "Despues",
          "before": "Antes",
          "between": "Entre",
          "empty": "Vacío",
          "equals": "Igual a",
          "not": "No",
          "notBetween": "No entre",
          "notEmpty": "No Vacio"
        },
        "moment": {
          "after": "Despues",
          "before": "Antes",
          "between": "Entre",
          "empty": "Vacío",
          "equals": "Igual a",
          "not": "No",
          "notBetween": "No entre",
          "notEmpty": "No vacio"
        },
        "number": {
          "between": "Entre",
          "empty": "Vacio",
          "equals": "Igual a",
          "gt": "Mayor a",
          "gte": "Mayor o igual a",
          "lt": "Menor que",
          "lte": "Menor o igual que",
          "not": "No",
          "notBetween": "No entre",
          "notEmpty": "No vacío"
        },
        "string": {
          "contains": "Contiene",
          "empty": "Vacío",
          "endsWith": "Termina en",
          "equals": "Igual a",
          "not": "No",
          "notEmpty": "No Vacio",
          "startsWith": "Empieza con"
        }
      },
      "data": "Data",
      "deleteTitle": "Eliminar regla de filtrado",
      "leftTitle": "Criterios anulados",
      "logicAnd": "Y",
      "logicOr": "O",
      "rightTitle": "Criterios de sangría",
      "title": {
        "0": "Constructor de búsqueda",
        "_": "Constructor de búsqueda (%d)"
      },
      "value": "Valor"
    },
    "searchPanes": {
      "clearMessage": "Borrar todo",
      "collapse": {
        "0": "Paneles de búsqueda",
        "_": "Paneles de búsqueda (%d)"
      },
      "count": "{total}",
      "countFiltered": "{shown} ({total})",
      "emptyPanes": "Sin paneles de búsqueda",
      "loadMessage": "Cargando paneles de búsqueda",
      "title": "Filtros Activos - %d"
    },
    "select": {
      "1": "%d fila seleccionada",
      "_": "%d filas seleccionadas",
      "cells": {
        "1": "1 celda seleccionada",
        "_": "$d celdas seleccionadas"
      },
      "columns": {
        "1": "1 columna seleccionada",
        "_": "%d columnas seleccionadas"
      }
    },
    "thousands": "."
  }
  return lenguaje;
}

function ActivarCheck(marcar) {
  chekOp = document.querySelectorAll('input'); //Rescatamos controles tipo Input
  for (i = 0; i < chekOp.length; i++) { //Ejecutamos y recorremos los controles
    if (chekOp[i].type == "checkbox") { // Ejecutamos si es una casilla de verificacion
      chekOp[i].checked = marcar.checked; // Si el input es CheckBox se aplica la funcion ActivarCasilla
    }
  }
}

function addCommas(nStr) {
  nStr += "";
  x = nStr.split(".");
  x1 = x[0];
  x2 = x.length > 1 ? "." + x[1] : "";
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1)) {
    x1 = x1.replace(rgx, "$1" + "," + "$2");
  }
  return x1 + x2;
}

function msgOpcion(mensaje, typeicon) {
  return swal.fire({
    html: mensaje,
    icon: typeicon,
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

function ProgressShow(messageProgress) {
  return Swal.fire({
    title: messageProgress,
    timerProgressBar: true,
    didOpen: () => {
      Swal.showLoading();
    }
  });
}

function empty(str) {
  if (typeof str == 'undefined' || !str || str.length === 0 || str === "" ||
    !/[^\s]/.test(str) || /^\s*$/.test(str) || str.replace(/\s/g, "") === "")
    return true;
  else
    return false;
}

function EventoChk() {

  $("input[type=checkbox]").show(function () {
    var value = $(this).val();
    if (value == 0) {
      $(this).prop('checked', false);
    } else {
      $(this).prop('checked', true);
    }
  });

}

function DateTimeSet() {
  // let date=new Date();
  // let d= date.getDate();
  // let m=((date.getMonth() + 1) < 10 ? '0' : '') + (date.getMonth() + 1);;
  // let a=date.getFullYear();

  // let dateDay=d+'/'+m+'/'+a;

  // return document.getElementById('fechareg').value =dateDay;

}

$(function () {

  let inputf = document.querySelectorAll('input.form-control,select.form-control');
  $('div.form-group>div.input-group,div.input-group>div.input-group').addClass('input-group-sm');

  for (let x = 0; x < inputf.length; x++) {
    inputf[x].classList.add('form-control-sm', 'form-control-border');
  }

  addCommas($('input[type=textn]').val())

  //desabilitar Tecla Intro al enviar formularios
  $("form").keypress(function (e) {
    if (e.which == 13) {
      return false;
    }
  });

  $('.nformat').number(true, 2, '.', ',').addClass('text-right');
  $('.nformatm').number(true, 0).addClass('text-right');

  $('.input-group.date,input.date').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    daysOfWeekHighlighted: "0",
    autoclose: true,
    todayHighlight: true,
    toggleActive: true
  }).datepicker("setDate", new Date());
});
let tabla,tabladt;
let proceso;
let iddep;
let permitir=false;
let validar,cantidadr,stockval,valorund=0;
let controlval;

document.addEventListener("DOMContentLoaded", function () {
  proceso = "listar";
  Operacion(proceso);
  InsertarEditar();
  Nuevo();
  SelectDeposito();
  SelccionDeposito();
  MostrarModal();
  agregarRengon();

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

function MostrarModal(){
	$("#btnAgregarArt").click(function () { 
		$("#ModalCrearArticulo").modal('show');	
    $('#ModalCrearArticulo').modal('handleUpdate');
    $("#iddeposito").attr('disabled',true);
	});

	$("#cod_articulom,#desc_articulom").click(function () { 
		$("#ModalArticulo").modal('show');
	});
}

function SelccionDeposito(){

	$("#iddeposito").change(function () { 
		iddep=$(this).val();
		$("#btnAgregarArt").prop('disabled',false);
		listarArticulos();	
    SelectUnidad();
	});
}

//Función Listar Articulos
function listarArticulos(){
	tabladt=$('#tbarticulos').dataTable({
    language: language_dt(),
		aProcessing: false,//Activamos el procesamiento del datatables
		aServerSide: false,//Paginación y filtrado realizados por el servidor
	  dom: 'frtip',//Definimos los elementos del control de tabla
    columnDefs: [{
      targets: 0,
      orderable: false,
    }],
		ajax:{
			url: url_base+'/ListarArticulos',
      type : "POST",
      data:{'id':iddep,'tipo':$("#tipo").val()},
			dataType : "json",						
			error: function(e){console.log(e.responseText);}
      },
			bDestroy: true,
      scrollCollapse: true,
      iDisplayLength:8,//Paginación
      order: [[1, "asc"]],
			bSort: true,
			bFilter:true,
      bInfo:true,
      paging:true,
	});

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
      $("#iddeposito").html(resp);
  });
}

function SelectUnidad() {
  let formData = new FormData();
    formData.append("security", "listar");
    let ajaxUrl = url_baseL + "Unidad/Selectpicker";
    fetch(ajaxUrl, {
        method: "POST",
        body: formData,
      })
      .then((response) => response.text())
      .catch((error) => {
        console.error("Error:", error);
      })
      .then((resp) => {
      $("#idunidad").html(resp);
    }
  );
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
        width: "100px",
        className: "text-center",
      },
      {
        targets: 3,
        width: "450px",
      },
      {
        targets: 4,
        width: "50px",
        className: "text-center",
      },
      {
        targets: 5,
        width: "150px",
        className:"text-right"
      },
      {
        targets: [6],
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
        data: {'security':'listar' },
        dataSrc: "",
        error: function (e) {
          console.log(e);
        }
      },
      columns: [
        { data: "opciones" },
        { data: "fechareg" },
        { data: "cod_ajuste" },
        { data: "desc_ajuste" },
        { data: "tipo" },
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

function Operacion(operacion) {
  switch (operacion) {
    case "listar":
      ListarTabla();
      MostrarForm(false);
      break;

    case "nuevo":
      $("#btnGuardar,#btnCancelar,select").attr("disabled", false);
      $("#btnEditar").attr("disabled", true);
      $("input[type=text],input[type=textc],#iddeposito").val("").attr("readonly", false);
      $("#totalstock,#totalv").html("0.00");
      $(".ffecha").datepicker({
        changeMonth: true,
        changeYear: true,
        showWeek: true,
        autoclose: "false",
        format: "dd/mm/yyyy"
      }).datepicker("setDate", new Date());
      $(".filas").remove();
      detalles=0;
      evaluar();
      $("#estatus").val("Sin Procesar");
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
    let strCampo = document.querySelectorAll("#fechareg");

      let tipomsg=$("#tipo").val();
      let mensaje="";
  
      if (tipomsg=="Inventario") {
        mensaje=" El Ajuste de Inventario de tipo Disponible <br>\
        No puede ser Eliminado o Anulado con respecto a Stock de Inventario! <br>\
        <b>¿Desea Continuar?</b>";
      } else {
        mensaje="¿Está Seguro de Guardar el Registro?";
      }
      msgOpcion(mensaje,"warning").
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
function mostrar(idajuste) {
  const form = document.querySelector("#dataForm");
  let dataset = new FormData(form);
  dataset.append('idajuste', idajuste);
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
      $.post(url_base+'/ListarDetalle',{'id':idajuste},function(r){
        $("#tbdetalles").html(r);
				$("#totalv").html($("#totalt").val());
		});
      proceso = "mostrar";
      Operacion(proceso);
    }); 
}

function eliminar(idajuste,tipo){

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
          form.append('id',idajuste);
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

function anular(idajuste,tipo){
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
          form.append('id',idajuste);
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

$("#tbdetalle").dataTable();

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

function agregarRengon(){
  $("#btnAceptarM").click(function(){
    if($("#tipo").val()=='Salida') {
			//permitir=true;
      validar=stockval-(cantidadr*valorund);
        if (validar<0) {
          if (permitir) {
            msgOpcion(
              "La Cantidad a Procesar es Mayor al Stock Disponible! <br>\
              Se generará un Stock Negativo de  <b>"+($.number(validar, 0)) + "</b> Unds. <br>\
              en el Deposito  <b>" + $("#iddeposito option:selected").text()+"</b>! Desea Continuar?"
            ).then((result) => {
              if (result.isConfirmed) {
                DataSetAgregarRenglon();
              } else{
                $("#cantidadm").val("0");
                $("#btnAceptarM").prop('disabled',true);
              }
            });
          } else{
            Swal.fire({icon: "error",title: "Error!",
              html: "La Cantidad a Procesar  de  <br>"+($.number(cantidadr,0))+"Und(s). <br>\
              es Mayor al Stock Disponible  <b>"+($.number(stockval,0))+"</b>  en el Deposito \
              <b>"+$("#iddeposito option:selected").text()+"</b>!  <br>\
              No es Posible realizar la Operacion",
              customClass: "swal-wide",
              customClass: {confirmButton: "btn btn-sm btnsw btn-info",icon: "color:red",},
              buttonsStyling: false,
            });
            $("#cantidadm").val("0");
            $("#btnAceptarM").prop('disabled',false);
          }
        } else{
          DataSetAgregarRenglon();
        }
    } else if($("#tipo").val()!='Salida'){
      DataSetAgregarRenglon();
    }
  });
}

//Datos Correspondientes al Renglon a Ingresar
function DataSetAgregarRenglon() {

	var idarticulov, idartunidadv, iddepositov, cantidadv, tipov, valorv, costov;
	var cod_articulov, desc_articulov, desc_unidadv;
	var totalt = 0;

	idarticulov = $.trim($("#idarticulom").val());
	iddepositov = $.trim($("#iddeposito").val());
	idartunidadv = $.trim($("#idartunidad").val());
	cod_articulov = $.trim($("#cod_articulom").val());
	desc_articulov = $.trim($("#desc_articulom").val());
	desc_unidadv = $.trim($('#desc_unidad').val());
	cantidadv = $.trim($("#cantidadm").val());
	costov = $.trim($("#costom").val());
	tipov = $.trim($("#tipom").val());
	valorv = $.trim($('#valorund').val());

  var w = 'style="width:';
	var a = '; text-align:';

	if($("#idarticulom").val()==$("#idarticulo").val()){

    Swal.fire({icon: "error",title:'Renglon Duplicado!',
      html:'El Articulo ya Fue Seleccionado<br>\
      Para hacer Cambios debe Eliminar el Renglon',
      customClass: "swal-wide",
      customClass: {confirmButton: "btn btn-sm btnsw btn-info",icon: "color:red",},
      buttonsStyling: false,
    });

  }else if($("#cantidadm").val()==0){
    Swal.fire({icon: "error",title: "Error!",
      html: "Debe ingresar una Cantidad para poder agregar el Artículo!",
      customClass: "swal-wide",
      customClass: {confirmButton: "btn btn-sm btnsw btn-info",icon: "color:red",},
      buttonsStyling: false,
    });
  }else{
    totalt = cantidadv * (costov * valorv);
    var fila = 
      '<tr class="filas" id="fila' + cont + '">' +
        '<td style="width:30px; text-align:center;">\
          <button type="button" class="btn btn-danger btn-xs" onclick="eliminarDetalle(' + cont + ')">\
          <span class="fa fa-times-circle"></span></button>\
        </td>'+
        '<td class="hidden">\
          <input type="hidden" name="idarticulo[]" id="idarticulo" value="' + idarticulov + '">\
          <input type="hidden" name="iddeposito[]" id="iddeposito" value="' + iddepositov + '">\
          <input type="hidden" name="tipoa[]" id="tipoa[]" value="' + tipov + '">\
          <input type="hidden" name="valor[]" id="valor[]" value="' + valorv + '">\
          <input type="text" onchange="modificarSubtotales();" name="cantidad[]" id="cantidad[]" value="' + cantidadv + '">\
          <input type="hidden" name="idartunidad[]" id="idartunidadr[]" value="' + idartunidadv + '">\
        </td>'+
        '<td ' + w + '200px;"><h6>' + cod_articulov + '</h6></td>' +
        '<td ' + w + '500px;">\
          <input type="text" class="form-control form-control-sm" \
          style="height: calc(1.650rem); border:none;" value="'+ desc_articulov + '">\
        </td>' +
        '<td ' + w + '90px;"><h6>' + desc_unidadv + '</h6></td>' +
        '<td ' + w + '80px' + a + 'right;"><h6>' + cantidadv + '</h6></td>' +
        '<td ' + w + '150px;">\
          <input type="text" onchange="modificarSubtotales();" class="text-right form-control form-control-sm"\
          name="costo[]" id="costo[]" value="' + ($.number(costov * valorv, 2, '.', '')) + '" style="height: calc(1.650rem); border:none;">\
        </td>' +
        '<td ' + w +'160px' + a + 'right;">\
          <h6 id="total" name="total" onchange="modificarSubtotales();calcularTotales();" \
          class="nformat">' + totalt + '</h6>\
        </td>' +
      '</tr>';
      cont++;
      detalles = detalles + 1;
      $('#tbdetalles').append(fila);
      modificarSubtotales();
      calcularTotales();
      $("input.control,select.control").val("");
      validar=0;
      stockval=0;
      cantidadr=0;
      valorund=0;
      $("#ModalCrearArticulo").modal('toggle');
  }
}

function modificarSubtotales(){
	var cant = document.getElementsByName("cantidad[]");
	var prec = document.getElementsByName("costo[]");
	var sub = document.getElementsByName("total");
		for (var i = 0; i <cant.length; i++){
			var inpC = cant[i];
			var inpP = prec[i];
			var inpS = sub[i];                           

			inpS.value = parseFloat(inpC.value)* parseFloat(inpP.value);

			document.getElementsByName("total")[i].innerHTML = parseFloat(inpS.value);
		}

		$('.nformat').number(true,2);	

	calcularTotales();
	evaluar();
}

function calcularTotales(){
	var sub = document.getElementsByName("total");
	var total = 0.0;

		for (var i = 0; i <sub.length; i++){
			total += document.getElementsByName("total")[i].value;
		}

	$("#totalv").html(total);
	$("#totalh").val(total);
	$('.nformat').number(true,2);	
	evaluar();
}	

function eliminarDetalle(indice){
	$("#fila" + indice).remove();
	detalles=detalles-1;
	calcularTotales();
	evaluar();
}

function evaluar(){
	if (detalles>0)
	{
		$("#btnGuardar").prop('disabled',false);
		$(".validar").prop('disabled',true);
	}
	else
	{
		$("#btnGuardar").prop('disabled',true);
		$(".validar").prop('disabled',false);		
		cont=0;	
	}
}


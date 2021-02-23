let tabla;
let proceso;
const percen = 100;

document.addEventListener("DOMContentLoaded", function () {
    proceso = "listar";
    Operacion(proceso);
    InsertarEditar();
    eliminar();
    Nuevo();
    SelectCategoria();
    SelectImpuesto();
    SelectModalPrecio();

    Montos();
    MontoPrecio('show')

    $('.chk').on('click', function () {
        if ($(this).is(':checked')) {
            $(this).val('1')
        } else {
            $(this).val('0')
        }
    });

    $("#costoprecio").on('click', function () {
        let costo = $("#costot").val();

        if ($(this).is(':checked')) {
            $("#preciom").val(costo);
            $("#margenm").val(0);

            var valor = parseFloat($("#preciom").val());
            var margen = $("#margenm").val();
            var imp = $("#tasa").val();

            $("#margent").val((valor * margen) / percen + valor);
            var margent = parseFloat($("#margent").val());
            $("#impuestot").val((margent * imp) / percen);
            $("#preciot").val((margent * imp) / percen + margent);
        } else {
            $("#preciom").val(0);
            $("#margenm").val(0);

            var valor = parseFloat($("#preciom").val());
            var margen = $("#margenm").val();
            var imp = $("#tasa").val();

            $("#margent").val((valor * margen) / percen + valor);
            var margent = parseFloat($("#margent").val());
            $("#impuestot").val((margent * imp) / percen);
            $("#preciot").val((margent * imp) / percen + margent);
        }

    });

    $("#idcategoria").on('change', function () {
        SelectLinea($("#idcategoria").val())
    });

    $("#idimpuesto").on('change', function () {
        SelectTasa($("#idimpuesto").val());
    });

    $("input.filtro_buscar").on("keyup click", function () {
        filterGlobal();
    });

    $("input.column_filter").on("keyup click", function () {
        filterColumn($(this).parents("tr").attr("data-column"));
    });

    $("#imagena").change(function () {
        filePreview(this);
        $('label[for="imagena"]').html('Imagen Cargada');
    });
});

function SelectCategoria() {
    let formData = new FormData();
    formData.append('security', 'listar');
    let ajaxUrl = url_baseL + 'Categoria/Selectpicker';
    fetch(ajaxUrl, {
        method: 'POST',
        body: formData,
    })
        .then(response => response.text())
        .catch(error => {
            console.error('Error:', error);
        })
        .then(resp => {
            $("#idcategoria").html(resp);
            SelectLinea($("#idcategoria").val())
        });
}

function SelectImpuesto() {
    let formData = new FormData();
    formData.append('security', 'listar');
    let ajaxUrl = url_baseL + 'Impuesto/Selectpicker';
    fetch(ajaxUrl, {
        method: 'POST',
        body: formData,
    })
        .then(response => response.text())
        .catch(error => {
            console.error('Error:', error);
        })
        .then(resp => {
            $("#idimpuesto").html(resp);
            SelectTasa($("#idimpuesto").val());
        });
}

function SelectModalPrecio() {

    let formData = new FormData();
    formData.append('security', 'listar');

    let ajaxUrl1 = url_baseL + 'TipoPrecio/Selectpicker';
    fetch(ajaxUrl1, {
        method: 'POST',
        body: formData,
    })
        .then(response => response.text())
        .catch(error => {
            console.error('Error:', error);
        })
        .then(resp => {
            $("#idtipoprecio").html(resp);
        });


    let ajaxUrl2 = url_baseL + 'Moneda/Selectpicker';
    fetch(ajaxUrl2, {
        method: 'POST',
        body: formData,
    })
        .then(response => response.text())
        .catch(error => {
            console.error('Error:', error);
        })
        .then(resp => {
            $("#idmoneda").html(resp);
        });
}

function SelectLinea(id) {
    let formData = new FormData();
    formData.append('idcategoria', id);
    formData.append('security', 'listar');
    let ajaxUrl = url_baseL + 'Linea/SelectpickerC';
    fetch(ajaxUrl, {
        method: 'POST',
        body: formData,
    })
        .then(response => response.text())
        .catch(error => {
            console.error('Error:', error);
        })
        .then(resp => {
            $("#idlinea").html(resp);
        });
}

function SelectTasa(id) {
    let formData = new FormData();
    formData.append('idimpuesto', id);
    formData.append('security', 'listar');
    let ajaxUrl = url_baseL + 'Impuesto/Mostrar';
    fetch(ajaxUrl, {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .catch(error => {
            console.error('Error:', error);
        })
        .then(resp => {
            $("#tasa").val(resp.tasa);
            Montos();
        });
}

function SelectUnidad() {
    let formData = new FormData();
    formData.append('security', 'listar');
    let ajaxUrl2 = url_baseL + 'Unidad/Selectpicker';
    fetch(ajaxUrl2, {
        method: 'POST',
        body: formData,
    })
        .then(response => response.text())
        .catch(error => {
            console.error('Error:', error);
        })
        .then(resp => {
            $("#idunidad").html(resp);
        });
}

function ListarTabla() {
    //#region
    tabla = $("#tbdetalle")
        .dataTable({
            language: language_dt(),
            aProcessing: true, //Activamos el procesamiento del datatables
            aServerSide: true, //Paginación y filtrado realizados por el servidor
            dom: "Bfrtilp", //Definimos los elementos del control de tabla
            buttons: [{
                extend: "excelHtml5",
                text: '<i class="fa fa-file-excel"></i> Excel ',
                titleAttr: "Exportar a Excel",
                className: "btn btnx btn-sm btn-success",
                exportOptions: { columns: [1, 2, 3, 4, 5, 7] },
            },
            {
                extend: "csvHtml5",
                text: '<i class="fa fa-file-archive"></i> CSV ',
                titleAttr: "Exportar a Texto",
                className: "btn btnx btn-sm btn-info",
                exportOptions: { columns: [1, 2, 3, 4, 5, 7] },
            },
            {
                extend: "pdf",
                text: '<i class="fa fa-file-pdf"></i> PDF ',
                titleAttr: "Exportar a PDF",
                className: "btn btnx btn-sm btn-danger",
                exportOptions: { columns: [1, 2, 3, 4, 5, 7] },
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
                { data: "cod_articulo" },
                { data: "desc_articulo" },
                { data: "categoria" },
                { data: "ref" },
                { data: "stock" },
                { data: "eliminar" },
                { data: "estatus" },
            ],
            order: [[1, "asc"]], //Ordenar (columna,orden)
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
            $("#btnGuardar,#btnCancelar,select,.ffecha,.chk").attr("disabled", false);
            $("#btnEditar,.btnl").attr("disabled", true);
            $("input[type=text],input[type=textc]").val("").attr("readonly", false);
            $("input[type=checkbox].chk").val("0");
            $('#imagenmuestra').remove();
            $("#tbtipoprecio,#tblListadoDep").html();
            $('#imagenah').after('<img id="imagenmuestra" class="img-fluid img-bshadow mb-3 pad" \
      style="max-width: 50%" src="' + url_baseL + '/Files/images/items/no-foto.jpg">');
            SelectTasa($("#idimpuesto").val());
            $('.ffecha').datepicker({
                format: "dd/mm/yyyy",
                language: "es",
                daysOfWeekHighlighted: "0",
                autoclose: true,
                todayHighlight: true,
                toggleActive: true
            }).datepicker("setDate", new Date());
            EventoCheckBox();
            MostrarForm(true);
            break;

        case "mostrar":
            SelectLinea($("#idcategoria").val())
            SelectTasa($("#idimpuesto").val());
            $("#btnGuardar,select,.ffecha,.chk").attr("disabled", true);
            $('[data-toggle="tooltip"]').tooltip();
            $("input[type=text],input[type=textc]").attr("readonly", true);
            $("#btnEditar,#btnCancelar").attr("disabled", false);
            $("label[for=imagena]").css({ 'cursor': 'default', 'background-color': '#ccc' });
            $("#imagena").attr('type', 'text');
            Montos();
            EventoCheckBox();
            MostrarForm(true);
            break;

        case "editar":
            $("input[type=text],input[type=textc]").attr("readonly", false);
            $("#btnEditar").attr("disabled", true);
            $("#btnGuardar,#btnCancelar,select,.ffecha,.chk,.btnl").attr("disabled", false);
            $("label[for=imagena]").css({ 'cursor': 'pointer', 'background-color': '#106BA0' });
            $("#imagena").attr('type', 'file');
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
        form = document.querySelector("#dataForm");
        let strCampo = document.querySelectorAll("#cod_articulo,#desc_articulo");

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
                        if (objData.RetornoId > 0) {
                            msgOpcion(objData.msg + "<br> Desea Ingresar ahora las <b>Unidades</b> para Este Articulo?", "info")
                                .then((result) => {
                                    if (result.isConfirmed) {
                                        FuncUnidad(objData.RetornoId)
                                        ListarUnidad(objData.RetornoId, $("#desc_articulo").val(), 'hidden')
                                    }
                                });

                        } else {
                            Swal.fire({
                                icon: "success",
                                title: 'Exito!',
                                html: objData.msg,
                                showConfirmButton: false,
                                timer: 1500,
                            });
                        }
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
                })
        }
    });
}

//Función para Mostrar registros
function mostrar(idarticulo) {
    const form = document.querySelector("#dataForm");
    let dataset = new FormData(form);
    dataset.append('idarticulo', idarticulo);
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

            ListarStock(resp.idarticulo, true);
            FuncUnidad(resp.idarticulo);
            FuncPrecio(resp.idarticulo, resp.desc_articulo);
            ListarPrecio(resp.idarticulo, true);

            if (resp.imagen == '' || resp.imagen == null) {
                $('#imagenmuestra').remove();
                $('#imagenah').after('<img id="imagenmuestra" class="img-fluid mb3 img-bshadow pad" \
        style="max-width: 180px" src="' + url_baseL + 'Files/images/items/no-foto.jpg">')
                $("#imagenactual").val('')
            } else {
                $('#imagenmuestra').remove();
                $('#imagenah').after('<img id="imagenmuestra" class="img-fluid mb3 img-bshadow pad" \
        style="max-width:180px" src="' + url_baseL + 'Files/images/items/' + resp.imagen + '">')
                $("#imagenactual").val(resp.imagen)
            }

            generarBarcode();
            Editar();
            Cancelar();
            proceso = "mostrar";
            Operacion(proceso);
        });

}

//Función para Activar registros
function activar(idarticulo) {
    msgOpcion("¿Desea <b>Activar</b> el Registro?", "warning").then((result) => {
        if (result.isConfirmed) {
            const form = document.querySelector("#dataForm");
            let dataset = new FormData(form);
            dataset.append('idarticulo', idarticulo);
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
function desactivar(idarticulo) {
    msgOpcion("¿Desea <b>Desactivar</b> el Registro?", "warning").then((result) => {
        if (result.isConfirmed) {
            const form = document.querySelector("#dataForm");
            let dataset = new FormData(form);
            dataset.append('idarticulo', idarticulo);
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

function Montos() {
    // tasa precion margen preciom precioimp preciot
    $("#costo").keyup(function () {
        var costo = $(this).val();
        let tasa = $("#tasa").val();
        $("#costoimp").val((costo * tasa) / percen);
        $("#costot").val(parseFloat((costo * tasa) / percen) + parseFloat(costo));
    }).change(function () {
        var costo = $(this).val();
        let tasa = $("#tasa").val();
        $("#costoimp").val((costo * tasa) / percen);
        $("#costot").val(parseFloat((costo * tasa) / percen) + parseFloat(costo));
    }).show(function () {
        var costo = $(this).val();
        let tasa = $("#tasa").val();
        $("#costoimp").val((costo * tasa) / percen);
        $("#costot").val(parseFloat((costo * tasa) / percen) + parseFloat(costo));
    });
}

function ListarStock(idarticulo, habilitar) {
    $.post(url_base + '/ListaStock', { 'id': idarticulo }, function (data) {
        $("#tblListadoDep").html(data);
        $('.paneltb').css('max-height', '160px');
        $(".btnl").attr('disabled', habilitar);
    });
}

//función para generar el código de barras
function generarBarcode() {
    if ($("#ref").val() != '' || $("#ref").val() != "") {
        artref = $("#ref").val();
        JsBarcode("#barcode", artref);
        $("#print").show();
    } else {
        $("#ref").val("")
    }
}

//Función para imprimir el Código de barras
function imprimirBarcode() {
    $("#print").printArea();
}

//función para generar el código de barras
function filePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.readAsDataURL(input.files[0]);
        reader.onload = function (e) {
            $('#imagenmuestra').remove();
            $("#imagenah").append($('img#imagenmuestra.img-responsive.pad.img-bshadow').html());
            $('#imagenah').after('<img id="imagenmuestra" class="img-responsive pad img-bshadow" \
      style="max-width:50%" src="' + e.target.result + '">');
        }
    }
}

function ListarPrecio(idarticulo, habilitar) {
    $.post(url_baseL + '/ArtPrecio/ListaPrecio', { 'id': idarticulo }, function (data) {
        $("#tbtipoprecio").html(data);
        $('.paneltb').css('max-height', '160px');
        $(".chk,.btnl").attr('disabled', habilitar);
        EventoCheckBox();
    });
}

function FuncPrecio(id, desc) {
    let BtnPrecio = document.querySelector("#btnPrecio");
    BtnPrecio.onclick = function () {

        $("#idartprecio").val("");
        $("#fecharegp").val("");
        $("#fechavenp").val("");
        $("#preciom").val(0);
        $("#margenm").val(0);
        $(".chk").val(0);
        SelectModalPrecio();
        EventoCheckBox();
        $('.ffecha').datepicker("setDate", new Date());
        $("#idarticulop").val(id);
        $("#Particulo").html(desc);
        $("#margent,#impuestot,#preciot").attr("readonly", true);
        $("#ModalPrecio").modal("show");
    };

    let GuardarPrecio = document.querySelector("#btnGuardarPrecio");
    GuardarPrecio.onclick = function () {
        const form = document.querySelector("#formPrecio");
        let dataSet = new FormData(form);
        dataSet.append('venc', $("#vencprecio").val());
        let AjaxUrl = url_baseL + '/ArtPrecio/GuadarEditarPrecio';
        fetch(AjaxUrl, {
            method: 'POST',
            body: dataSet
        })
            .then(res => res.json())
            .then(objData => {
                if (objData.status) {
                    Swal.fire({
                        icon: "success",
                        title: 'Exito!',
                        html: objData.msg,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $("#ModalPrecio").modal('toggle');
                    ListarPrecio($("#idarticulo").val(), false);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: 'Error!',
                        html: objData.msg,
                        customClass: { confirmButton: "btn btn-sm btnsw btn-primary", icon: "color:red" },
                        buttonsStyling: false
                    });
                }
            });
    };
}

function EditarPrecio(id) {
    let dataset = new FormData();
    dataset.append('id', id);
    fetch(url_baseL + 'ArtPrecio/MostrarPrecio', {
        method: 'POST',
        body: dataset
    })
        .then(res => res.json())
        .then(data => {
            $("#Particulo").html($("#desc_articulo").val());
            $("#idartprecio").val(id);
            $("#idarticulop").val(data.idarticulo);
            $("#idmoneda").val(data.idmoneda);
            $("#idtipoprecio").val(data.idtipoprecio);
            $("#fecharegp").val(data.fechareg);
            $("#fechavenp").val(data.fechaven);
            $("#vencprecio").val(data.vence);
            $("#preciom").val(data.montoprecio);
            $("#margenm").val(data.margen);
            $("#margent").val(data.preciom);
            $("#impuestot").val(data.imp);
            $("#preciot").val(data.preciot);
            EventoCheckBox();
            $("#margent,#impuestot,#preciot").attr("readonly", true);
            $("#ModalPrecio").modal("show");
        });
}

function eliminarPrecio(id) {
    msgOpcion(
        "¿Esta Seguro de <b>Eliminar</b> los Registros Seleccionados?", "warning"
    ).then((result) => {
        if (result.isConfirmed) {
            ProgressShow('Eliminando Registros...');
            let dataSet = new FormData();
            dataSet.append('id', id);
            let urlAjax = url_baseL + "/ArtPrecio/Eliminar";
            fetch(urlAjax, {
                method: 'POST',
                body: dataSet
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
                    ListarPrecio($("#idarticulo").val(), false)
                });
        } else {
            Swal.fire({
                icon: "info",
                title: "Eliminacion Cancelada!",
                showConfirmButton: false,
                timer: 1500,
            });
        }
    });
}

function MontoPrecio(event) {
    $("#margenm").val(0);

    $("#preciom").on(event, function () {
        var valor = parseFloat($(this).val());
        var margen = $("#margenm").val();
        var imp = $("#tasa").val();

        $("#margent").val((valor * margen) / percen + valor);
        var margent = parseFloat($("#margent").val());
        $("#impuestot").val((margent * imp) / percen);
        $("#preciot").val((margent * imp) / percen + margent);
    })
        .keyup(function () {
            var valor = parseFloat($(this).val());
            var margen = $("#margenm").val();
            var imp = $("#tasa").val();

            $("#margent").val((valor * margen) / percen + valor);
            var margent = parseFloat($("#margent").val());
            $("#impuestot").val((margent * imp) / percen);
            $("#preciot").val((margent * imp) / percen + margent);
        });

    $("#margenm")
        .change(function () {
            var valor = parseFloat($("#preciom").val());
            var margen = parseFloat($(this).val());
            var imp = parseFloat($("#tasa").val());

            $("#margent").val((valor * margen) / percen + valor);
            var margent = parseFloat($("#margent").val());
            $("#impuestot").val((margent * imp) / percen);
            $("#preciot").val((margent * imp) / percen + margent);
        })
        .keyup(function () {
            var valor = parseFloat($("#preciom").val());
            var margen = parseFloat($(this).val());
            var imp = parseFloat($("#tasa").val());

            $("#margent").val((valor * margen) / percen + valor);
            var margent = parseFloat($("#margent").val());
            $("#impuestot").val((margent * imp) / percen);
            $("#preciot").val((margent * imp) / percen + margent);
        });
}

function ListarUnidad(id, desc, visible) {
    $.post(url_baseL + '/ArtUnidad/ListarUnidad', { 'id': id }, function (data) {
        $("#Uarticulo").html(desc)
        $("#tbunidad").html(data);
        $('div.card-body.form').addClass('hidden');
        $('div.card-body.table').removeClass('hidden');
        $("#btnGuardarUnidad,#btnCancelarUnidad").attr("disabled", true);
        $("#btnAgregarUnidad,button.btn-secondary").attr("disabled", false);
        EventoCheckBox();
        SelectUnidad();
        $("#tbstock").addClass(visible);
        $('#ModalUnidad').modal('show');
    })
}

function MostrarModalUnidad(id) {
    document.querySelector("#btnMostrarUnidad").addEventListener('click', function (event) {
        event.preventDefault();
        $("#btnGuardarUnidad,#btnCancelarUnidad,#btnAgregarUnidad").removeClass('hidden');
        ListarUnidad(id, $("#desc_articulo").val(), 'hidden');
    });
}

function mostrarUnidad(id) {
    let dataset = new FormData();
    dataset.append('id', id);
    let urlAjax = url_baseL + "/ArtUnidad/MostrarUnidad";
    fetch(urlAjax, {
        method: 'POST',
        body: dataset
    })
        .then(response => response.json())
        .then(resp => {
            $("#valor").val(resp.valor);
            $("#principal").val(resp.principal);
            $("#idunidad").val(resp.idunidad);
            $("#idartunidad").val(resp.idartunidad);
            EventoCheckBox();
            $('div.card-body.table').addClass('hidden');
            $('div.card-body.form').removeClass('hidden');
            $("#btnGuardarUnidad,#btnCancelarUnidad,#btnAgregarUnidad").removeClass('hidden');
            $("#btnGuardarUnidad,button.btn-secondary,#btnCancelarUnidad").attr("disabled", false);
            $("#btnAgregarUnidad").attr("disabled", true);
        });
}

function eliminarUnidad(id, principal) {
    msgOpcion(
        "¿Esta Seguro de <b>Eliminar</b> los Registros Seleccionados?", "warning"
    ).then((result) => {
        if (result.isConfirmed) {
            ProgressShow('Eliminando Registros...');
            let dataSet = new FormData();
            dataSet.append('id', id);
            dataSet.append('principal', principal);
            let urlAjax = url_baseL + "/ArtUnidad/Eliminar";
            fetch(urlAjax, {
                method: 'POST',
                body: dataSet
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
                        ListarUnidad($("#idarticulo").val(), $("#desc_articulo").val(), 'hidden')
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            html: objData.msg,
                            customClass: "swal-wide",
                            customClass: { confirmButton: "btn btn-sm btnsw btn-info", icon: "color:red", },
                            buttonsStyling: false,
                        });
                    }
                });
        } else {
            Swal.fire({
                icon: "info",
                title: "Eliminacion Cancelada!",
                showConfirmButton: false,
                timer: 1500,
            });
        }
    });
}

function FuncUnidad(id) {

    MostrarModalUnidad(id);

    let agregar = document.querySelector("#btnAgregarUnidad");
    agregar.onclick = function (event) {
        event.preventDefault();
        $("#idarticulou").val(id);
        $("#idartunidad").val("");
        $("#valor").val(1);
        $("#principal").val();
        $("#idunidad").val("");
        SelectUnidad();
        EventoCheckBox();
        $('div.card-body.table').addClass('hidden');
        $('div.card-body.form').removeClass('hidden');
        $("#btnGuardarUnidad,#btnCancelarUnidad,#btnAgregarUnidad").removeClass('hidden');
        $("#btnGuardarUnidad,#btnCancelarUnidad").attr("disabled", false);
        $("#btnAgregarUnidad,button.btn-secondary").attr("disabled", true);
    }

    let guadar = document.querySelector("#btnGuardarUnidad");
    guadar.onclick = function (event) {
        event.preventDefault();
        const form = document.querySelector("#formUnidad");
        let dataSet = new FormData(form);
        dataSet.append('principal', $("#principal").val());
        let AjaxUrl = url_baseL + '/ArtUnidad/GuadarEditarUnidad';
        fetch(AjaxUrl, {
            method: 'POST',
            body: dataSet
        })
            .then(res => res.json())
            .then(objData => {
                if (objData.status) {
                    Swal.fire({
                        icon: "success",
                        title: 'Exito!',
                        html: objData.msg,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    ListarUnidad(id, $("#desc_articulo").val(), 'hidden');
                } else {
                    Swal.fire({
                        icon: "error",
                        title: 'Error!',
                        html: objData.msg,
                        customClass: { confirmButton: "btn btn-sm btnsw btn-primary", icon: "color:red" },
                        buttonsStyling: false
                    });
                }
            });
    }

    let cancelar = document.querySelector("#btnCancelarUnidad");
    cancelar.onclick = function (event) {
        event.preventDefault();
        $('div.card-body.form').addClass('hidden');
        $('div.card-body.table').removeClass('hidden');
        $("#btnGuardarUnidad,#btnCancelarUnidad,#btnAgregarUnidad").removeClass('hidden');
        $("#btnGuardarUnidad,#btnCancelarUnidad").attr("disabled", true);
        $("#btnAgregarUnidad,button.btn-secondary").attr("disabled", false);
    };
}

function ListadoStock(id, desc,) {
    $("#btnGuardarUnidad,#btnCancelarUnidad,#btnAgregarUnidad").addClass('hidden');
    $("#tbstock").removeClass('hidden');
    ListarUnidad(id, desc);
    $.post(url_base + '/ListaStock', { 'id': id }, function (data) {
        $("#tbstock").html(data);
        $('.paneltb').css('max-height', '160px');
        $(".chk,.btnl").attr('disabled', true);
    });
}

function listadoPrecio(id, desc) {
    $.post(url_baseL + '/ArtPrecio/ListaPrecio', { 'id': id }, function (data) {
        $("#tblistaPrecio").html(data);
        $(".chk,.btnl").attr('disabled', true);
        $("#LParticulo").html(desc)
        $("#ModalListaPrecio").modal('show');
    });
}
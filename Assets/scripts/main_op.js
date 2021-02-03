function Salir() {
    swal.fire({
        html: 'Está a punto de <b>Salir del Sistema</b> ¿Desea Continuar?',
        icon: 'warning',
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancelar',
        showCancelButton: true,
        customClass: {
            confirmButton: 'btn btn-sm btnsw btn-success',
            cancelButton: 'btn btn-sm btnsw btn-danger',
            icon: 'color:red'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            let timerInterval
            Swal.fire({
                title: 'Cerrar Sesión!',
                html: 'Cerrando Sesion <b></b>...',
                timer: 3000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                        const content = Swal.getContent()
                        if (content) {
                            const b = content.querySelector('b')
                            if (b) {
                                b.textContent = Swal.getTimerLeft()
                            }
                        }
                    }, 1000)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                    $.post(url_baseL + "Usuario/SessionOut", { 'security': 'cerraSession' }, function() {
                        window.location = url_baseL + '/Login';
                    });
                }
            })
        }
    })
}

function MostarModalClave() {
    $("#btnMostraModalt").click(function() {
        let dataset = new FormData();
        dataset.append('idusuario', '1');
        let urlAjax = url_baseL + "Usuario/Mostrar";
        fetch(urlAjax, {
                method: 'POST',
                body: dataset
            })
            .then(response => response.json())
            .catch(error => console.error('Error:', error))
            .then(data => {
                $("#cod_usuarioc").val(data.cod_usuario);
                $("#desc_usuarioc").val(data.desc_usuario);
                $("#clavec,#confclavec").val("");
                $("#btnGuardarCl").attr('disabled', true);
                $("#ModalCambiarClave").modal('show');
                ConfirmarClave()
            });
    });
}

function ConfirmarClave() {
    $("#confclavec")
        .change(function() {
            if ($(this).val() != $("#clavec").val()) {
                Swal.fire({
                    icon: 'info',
                    html: 'La Nueva <b>Clave Ingresada</b> no Concide con la <b>Clave de Confirmacion!</b>',
                    showConfirmButton: true,
                });
            }
        })
        .keyup(function() {
            if ($(this).val() != $("#clavec").val()) {
                $("#confclavec,#clavec").removeClass("is-valid");
                $("#confclavec,#clavec").addClass("is-invalid");
                $("#btnGuardarCl").attr('disabled', true);
            } else {
                $("#confclavec,#clavec").removeClass("is-invalid");
                $("#confclavec,#clavec").addClass("is-valid");
                $("#btnGuardarCl").attr('disabled', false);
            }
        });
}

$(function() {

    MostarModalClave()

    ActualizarClaveSet()

});

function ActualizarClaveSet() {
    document
        .getElementById("btnGuardarCl")
        .addEventListener('click', function(e) {
            e.preventDefault();
            swal
                .fire({
                    html: "¿Está Seguro de Cambiar Su Clave? <br>\
			      Para Hacer Efectivo el Cambio Saldra Automaticamente del Sistema",
                    icon: "warning",
                    confirmButtonText: "Ok",
                    cancelButtonText: "Cancelar",
                    showCancelButton: true,
                    customClass: {
                        confirmButton: "btn btn-sm btnsw btn-success",
                        cancelButton: "btn btn-sm btnsw btn-danger",
                        icon: "color:red",
                    },
                    buttonsStyling: false,
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        let xlr = new XMLHttpRequest();
                        let urlAjax = url_baseL + "Usuario/ActualizarClave";
                        let formData = new FormData();
                        formData.append('idusuario', $("#idusuarioc").val());
                        formData.append('clave', $("#clavec").val());
                        xlr.open('POST', urlAjax, true);
                        xlr.send(formData);
                        xlr.onreadystatechange = function() {
                            if (xlr.readyState == 4 && xlr.status == 200) {
                                let objData = JSON.parse(xlr.responseText);
                                if (objData.status) {
                                    let timerInterval;
                                    Swal.fire({
                                        title: "Cerrar Sesión!",
                                        html: objData.msg + "<br>  Cerrando Sesion <b></b>...",
                                        timer: 3000,
                                        timerProgressBar: true,
                                        didOpen: () => {
                                            Swal.showLoading();
                                            timerInterval = setInterval(() => {
                                                const content = Swal.getContent();
                                                if (content) {
                                                    const b = content.querySelector("b");
                                                    if (b) {
                                                        b.textContent = Swal.getTimerLeft() / 100;
                                                    }
                                                }
                                            }, 100);
                                        },
                                        willClose: () => {
                                            clearInterval(timerInterval)
                                            $.post(url_baseL + "Usuario/SessionOut", { 'security': 'cerraSession' }, function() {
                                                window.location = url_baseL + '/Login';
                                            });
                                        }
                                    });
                                } else {
                                    Swal.fire({ icon: "error", html: objData.msg });
                                }
                            }
                        };
                    }
                });
        });
}
});
}
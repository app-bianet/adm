$("#form_login").submit(function(e){

  e.preventDefault();

  let clave=$("#clave").val();
  let usuario=$("#cod_usuario").val();

    if (usuario==''|| clave=='') {

      Swal.fire({ 
        icon: "info", html: '<h5>Debe indicar su <b>Usuario</b> y <b>Clave</b> Correctamente para Ingresar al Sistema!</h5>',
        customClass: {
          confirmButton: "btn btn-sm btnsw btn-primary",
          icon: "color:red",
        },buttonsStyling: false,
      });
    } else{
      var formData = new FormData();
      formData.append('clave',$("#clave").val());
      formData.append('cod_usuario',$("#cod_usuario").val());
      let ajaxUrl=url_baseL+'Login/SessionStart';
      fetch(ajaxUrl, {
      method:'POST',
      body: formData
      })
      .then(response => response.json())
      .catch(error => console.error('Error:', error))
      .then(objData => {
        if (objData.status) {
          Swal.fire({
            icon: objData.icon, title:objData.msg,
            showConfirmButton: false,timer: 3000,
          });
          window.location=url_baseL+'Escritorio';     
        } else{
          Swal.fire({ 
            icon: objData.icon, html: objData.msg,
            customClass: {
              confirmButton: "btn btn-sm btnsw btn-primary",
              icon: "color:red",},buttonsStyling: false,
          });
        }
      });
    }    
});

$(function(){  


  $("#clave").val("");
  $("#cod_usuario").val("");


});
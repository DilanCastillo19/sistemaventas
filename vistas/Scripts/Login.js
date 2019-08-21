$("#frmAcceso").on('submit',function(e){
    e.preventDefault(); //Esta funcion sirve para evitar que el formulario busque el action
    usuario=$("#usuario").val();
    clave=$("#clave").val();
 
    $.post('../ajax/usuario.php?op=validaracceso',
            {"usuario": usuario, "clave": clave},function(data){
                if(data==="null"){
                    bootbox.alert("Usuario y/o constraseña incorrecto");
                }else{
                    $(location).attr("href","categoria.php");
                }
            });
            //para encriptacion de contraseña el metoso jash
})
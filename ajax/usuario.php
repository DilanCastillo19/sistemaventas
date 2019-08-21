<?php
    include("../modelos/Usuario.php");
    $acceso = new Usuario();
    session_start(); //Con este codigo se valida que exista un usuario logueado 
    switch($_GET["op"]){
        case 'validaracceso':
            $usuario=$_POST["usuario"];
            $clave=$_POST["clave"];
            $resultado = $acceso->validarusuario($usuario, $clave);
            if($fila=$resultado->fetch_object()){
                $_SESSION["nombre"]=$fila->nombre; // el nombre de la variable es $_SESSION["nombre"], cuando quiera usarla se escribe.
            }
            echo json_encode($fila);
        break;
        case 'salir':
            session_destroy();
            header("Location:../vistas/login.html");
        break;
    }
?>
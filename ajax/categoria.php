<?php
    include("../modelos/Categoria.php");
    //Se crea una instancia de clase Categoria
    $categoria = new Categoria();
    //Se traen los datos del formulario a traves del metodo POST
    $idcategoria="";
    $nombre="";
    $descripcion="";
    //Recibe el valor de cada variable, siempre y cuando se haya enviado algun valor 
    if(isset($_POST["idcategoria"])){
        $idcategoria=$_POST["idcategoria"];
    }
    if(isset($_POST["nombre"])){
        $nombre=$_POST["nombre"];
    }
    if(isset($_POST["descripcion"])){
        $descripcion=$_POST["descripcion"];
    }

    //Se invocan los metodos de la clase categoria 
    //Se valida el clic del usuario a traves de un parametro 
    //llamado "op" enviado por ajax usando el metodo GET 
    
    switch ($_GET["op"]) {
        case 'guardaryeditar':
             if (empty($idcategoria)) {
                 $rspta=$categoria->insertar($nombre,$descripcion);
                 echo $rspta ? "Categoria registrada" : "Categoria no se pudo registrar";
             }
             else {
                $rspta=$categoria->editar($idcategoria,$nombre,$descripcion);
                echo $rspta ? "Categoria actualizada" : "Categotia no se puede actualizar";
             }
            break;
        
        case 'desactivar':
                $rspta=$categoria->desactivar($idcategoria);
                echo $rspta ? "Categoria Desactivada" : "Categoria no se puede desactivar";
            break;

        case 'activar':
            $rspta=$categoria->activar($idcategoria);
            echo $rspta ? "Categoria Activada" : "Categoria no se puede activar";
            break;

        case 'mostrar':
            $rspta=$categoria->mostrar($idcategoria);
            if($rspta){
                header();
            }

            //Codificar el restultado utilizando json_encode(array)
            echo json_encode($rspta);
            break;

        case 'listar':
            $rspta=$categoria->listar();
            //Definir un array (arreglo)
            $data= Array();
            //Carga en la variable $reg el resultado de la consulta ejecutada con el metodo "listar" y realiza un ciclo por cada fila de datos 
            while ($reg=$rspta->fetch_object()) {
                //Almacena cada fila del resultado del SELECT en el array $data[]
                $data[]=array(
                    "0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idcategoria.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg->idcategoria.')"><i class="fa fa-close"></i></button>':
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idcategoria.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-primary" onclick="activar('.$reg->idcategoria.')"><i class="fa fa-check"></i></button>',
                    "1"=>$reg->nombre,
                    "2"=>$reg->descripcion,
                    "3"=>$reg->condicion
                );
            } 
            $results = array(
                "sECHO"=>1, //Mostrar desde la fila 1
                "iTotalRecords"=>count($data), //total registros de la tabla
                "iTotalDisplayRecords"=>count($data), //Total registros a visualizar en pantalla 
                "aaData"=>$data);//En este indice del array llamado "aaData" se envia los datos del array $data
            //Aqui retorna el array $results a traves de Json
            echo json_encode($results);
               
            break;
    }
    
?>

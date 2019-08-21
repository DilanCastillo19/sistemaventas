<?php
     include("../modelos/articulo.php");
     $articulo= new Articulo();
     $idarticulo="";
     $idcategoria="";
     $codigo="";
     $nombre="";
     $stock="";
     $descripcion="";
     $imagen="";
     $condicion="";
       if (isset($_POST["idarticulo"])) {
        $idarticulo=$_POST["idarticulo"];
       }
      if (isset($_POST["idcategoria"])) {
        $idcategoria=$_POST["idcategoria"];
    }
    if (isset($_POST["nombre"])) {
        $nombre=$_POST["nombre"];
    }
    if (isset($_POST["stock"])) {
        $stock=$_POST["stock"];
    }
    if (isset($_POST["descripcion"])) {
        $descripcion=$_POST["descripcion"];
    }
    if (isset($_POST["imagen"])) {
        $imagen=$_POST["imagen"];
    }
    if (isset($_POST["condicion"])) {
        $condicion=$_POST["condicion"];
    }
    switch ($_GET["op"]) {
        case 'guardaryeditar':
        //Si no existe o no ha sido cargado la image dentro del input de tipo "file" en la interfaz
             if(!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])){
                 //$imagen=$_POST["imagenactual"];
                 $imagen="";
             }else{
                 //explode: obtiene la extencsion del archivo
                 $ext = explode(".",$_FILES["imagen"]["name"]);
                 //Valida que el archivo cargado cumpla con las extensiones: jpg, jpeg, png
                 if($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png"){
                    //microtime: renombre el archivo con un formato de tiempo para que no tener archivos repetidos 
                    $imagen = round(microtime(true)) . '.' . end($ext);
                    //move_uploaded_file: copia el archivo de la ubicacion local y lo mueve a la carpeta del proyecto
                    move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos" .$imagen);
                 }
             }
        break;
        
        case 'desactivar':
                $rspta=$articulo->desactivar($idarticulo);
                echo $rspta ? "Articulo Desactivado" : "Articulo no se puede desactivar";
        break;

        case 'activar':
            $rspta=$articulo->activar($idarticulo);
            echo $rspta ? "Articulo Activado" : "Articulo no se puede activar";
        break;

        case 'mostrar':
            $rspta=$categoria->mostrar($idarticulo);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta=$articulo->listar();
            $data= Array();
            while ($reg=$rspta->fetch_object()) {
                $data[]=array(
                    "0"=>$reg->idarticulo,
                    "1"=>$reg->nombre,
                    "2"=>$reg->nomCategoria,
                    "3"=>$reg->codigo,
                    "4"=>$reg->stock,
                    "5"=>"<img src='../files/articulos/".$reg->imagen."' heigth='50px' width='50px'>",
                    "6"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
                                           '<span class="label bg-red">Desactivado</span>'
                );
            } 
            $results = array(
                "sECHO"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);  
        break;
        case 'selectCategoria':
                require_once "../modelos/Categoria.php";
                $categoria = new Categoria();
                $rspta = $categoria->select();
                while($reg = $rspta->fetch_object()){
                    echo '<option value=' . $reg->idcategoria . '>' .$reg->nombre . '</option>';
                }
        break;

    }
    
?>
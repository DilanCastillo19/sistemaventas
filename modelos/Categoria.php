<?php
    //Se hace referencia a la conexion de base de datos 
    include ("../config/Conexion.php");
    //Se define la clase categoria
    class Categoria
    {
        //Se define el constructor vacio 
        public function __construct()
        {

        }

        //Metodo para insertar registros 
        public function insertar($nombre, $descripcion)
        {
            $sql="INSERT INTO categoria (nombre, descripcion, condicion)
            VALUES ('$nombre','$descripcion','1')";
            return ejecutarConsulta($sql);
        }

        public function editar($idcategoria, $nombre, $descripcion)
        {
            $sql = "UPDATE categoria
            SET nombre = '$nombre', descripcion = '$descripcion'
            WHERE idcategoria = '$idcategoria'";
            return ejecutarConsulta($sql);
        }

        public function desactivar($idcategoria)
        {
            $sql = "UPDATE categoria
            SET condicion = '0'
            WHERE idcategoria = '$idcategoria'";
            return ejecutarConsulta($sql);
        }

        public function activar($idcategoria)
        {
            $sql = "UPDATE categoria
            SET condicion = '1'
            WHERE idcategoria = '$idcategoria'";
            return ejecutarConsulta($sql);
        }

        public function listar()
        {
            $sql = "SELECT *
            FROM categoria";
            return ejecutarConsulta($sql);
        }

        public function mostrar($idcategoria)
        {
            $sql = "SELECT *
            FROM categoria
            WHERE idcategoria = '$idcategoria'"; 
            return consultarUnaFila($sql);
        }

        public function selectCategoria (){
            $sql = "SELECT *
                    FROM articulo
                    WHERE condicion=1";
            return consultarUnaFila($sql);
        }
    }
?>
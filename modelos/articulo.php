<?php
    include ("../config/Conexion.php");
    class Articulo
    {
        public function __construct()
        {
        }
        public function insertar($codigo, $nombre, $stock, $descripcion, $imagen, $condicion)
        {
            $sql="INSERT INTO articulo (codigo, nombre, stock, descripcion, imagen, condicion)
            VALUES ('$codigo','$nombre','$stock','$descripcion','$imagen','1')";
            return ejecutarConsulta($sql);
        }

        public function editar($idarticulo, $nombre, $descripcion)
        {
            $sql = "UPDATE articulo
            SET nombre = '$nombre', descripcion = '$descripcion'
            WHERE idarticulo = '$idarticulo'";
            return ejecutarConsulta($sql);
        }

        public function desactivar($idarticulo)
        {
            $sql = "UPDATE articulo
            SET condicion = '0'
            WHERE idarticulo = '$idarticulo'";
            return ejecutarConsulta($sql);
        }

        public function activar($idarticulo)
        {
            $sql = "UPDATE articulo
            SET condicion = '1'
            WHERE idarticulo = '$idarticulo'";
            return ejecutarConsulta($sql);
        }

        public function listar()
        {
            $sql = "SELECT a.nombre, c.nombre as nomCategoria, a.codigo, a.stock, a.descripcion, a.imagen, a.condicion
            FROM articulo a, categoria c
            WHERE a.idcategoria=c.idcategoria";
            return ejecutarConsulta($sql);
        }

        public function mostrar($idarticulo)
        {
            $sql = "SELECT *
            FROM articulo
            WHERE idarticulo = '$idarticulo'"; 
            return consultarUnaFila($sql);
        }

    }
?>
<?php
session_start();
if(!isset($_SESSION["nombre"])) { // en esta linea se valida que existan datos en la variable de sesion
  header("Location:Login.html");
}else{
require 'header.php';
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Tabla <button class="btn btn-success" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                    <!-- Estructura de la tabla donde se mostrara el listado de las categorias de 
                    la base de datos  -->
                    <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                      <thead>
                        <th>Opciones</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">

                          <label>Nombre:</label>
                          <input type="hidden" name="idcategoria" id="idcategoria">
                          <input type="text" class="form-control" name="nombre" id="nombre" maxlength="50" placeholder="Nombre" required>

                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Descripcion:</label>
                          <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripcion">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"> Guardar</i></button>

                          <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left">Cancelar</i></button>
                          </div>


                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
require 'footer.php';
?>
<script src="Scripts/categoria.js"></script>
<?php
}
?>
//Variable global "tabla" que va a guardar todos los registros de la tabla categoria y de esta manera
//procesarlos dentro de algunas de las siguientes funciones
var tabla;

//Funcion init, la cual es llamada al final 
function init(){
    mostrarform(false);
    listar();
    //Cada vez que se de clic en el boton "Agregar" se activa el formulario y de esta manera se llama a la funcion de guardaryeditar
    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);
    })
}

//Limpia las cajas de texto
function limpiar() 
{
    $("#nombre").val("");
    $("#descripcion").val("");
    $("#idcategoria").val("");    
}

//Muestra u oculta el formulario y lista de datos
function mostrarform(bandera) {
    limpiar();
    if (bandera) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

//Funcion Cancelar Formulario
function cancelarform()
{
    //limpiar();
    mostrarform(false);
}

//Lista en una tabla de html (un datatable) todos los registros de la tabla de la base de datos 
function listar()
{
    //tbllistando es el id de una caja de la vista categoria.php
    //Organiza los datos en forma de tabla
    tabla=$('#tbllistado').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginacion y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [//Crea 4 botones para exportar los datos en diferentes formatos
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdf'
            ],
        "ajax":
                {
                    url: '../ajax/categoria.php?op=listar',
                    type: "get",
                    dataType: "json",
                    error: function(e){
                        console.log(e.responseText);
                    }
                },
            "bDestroy":true,
            "iDisplayLength": 5,//Mostrar de a 5 registros por pagina 
            "order": [[0, "desc"]]//Ordenar los datos (columna, orden) 
        }
        ).DataTable();      
}


function guardaryeditar(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/categoria.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}

function mostrar(idcategoria){
    $.post("../ajax/categoria.php?op=mostrar",{idcategoria :  idcategoria}, function(data, status)
    {
        data = JSON.parse(data);
        mostrarform(true);
        $("#nombre").val(data.nombre);
        $("#descripcion").val(data.descripcion);
        $("#idcategoria").val(data.idcategoria);
    })
}
//Funcion para desactivar registros
function desactivar(idcategoria)
{
    //El parametro result recibe true o false dependiendo del clic del usuario al mensaje de confirmacion
    bootbox.confirm("¿Esta seguro de desactivar la Categoria?", function(result){
        //Si result es verdadero, se desactivara la categoria de lo contrario no 
        if(result)
        {
            //e es el mensaje que recibe la url 
            $.post("../ajax/categoria.php?op=desactivar",{idcategoria : idcategoria}, function(e){
                bootbox.alert(e);
                //Recarga la tabla datatable 
                tabla.ajax.reload();
            });
        }
    })
}

function activar(idcategoria)
{
    bootbox.confirm("¿Esta seguro de activar la Categoria?", function(result){
        if(result)
        {
            $.post("../ajax/categoria.php?op=activar", {idcategoria : idcategoria}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}
init();
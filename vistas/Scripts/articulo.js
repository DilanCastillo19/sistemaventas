var tabla;
function init(){
    mostrarform(false);
    listar();
    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);
    })
    $.post("../ajax/articulo.php?op=selectCategoria" function(r){
        $("#idcategoria").html(r);
        $("#idcategoria").selectpicker('refresh');
    });
    $("#imagenmuestra").hide();
}
function limpiar() 
{
    $("#codigo").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
    $("#stock").val("");
    $("#idarticulo").val("");
}
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
function cancelarform()
{
    mostrarform(false);
}
function listar(){
    tabla=$('#tbllistado').dataTable(
        {
            "aProcessing":true,
            "aServerSide":true,
            dom: 'Bfrtip',
            buttons:[
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],
            "ajax":{
                url: '../ajax/articulo.php?op=listar',
                type : "get",
                dataType: "json",
                error: function(e){
                    console.log(e.responseText);
                } 
            },
            "bDestroy": true,
            "iDisplayLength": 5,
            "order": [[ 0, "desc" ]]
        }).DataTable();     
}
function guardaryeditar(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/articulo.php?op=guardaryeditar",
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

function mostrar(idarticulo){
    $.post("../ajax/articulo.php?op=mostrar",{idarticulo :  idarticulo}, function(data, status)
    {
        data = JSON.parse(data);
        mostrarform(true);
        $("#idcategoria").val(data.idcategoria);
        $("#idcategoria").selectpicker('refresh');
        $("#codigo").val(data.codigo);
        $("#nombre").val(data.nombre);
        $("#stock").val(data.stock);
        $("#descripcion").val(data.descripcion);
        $("#idarticulo").val(data.idarticulo);
    })
}
function desactivar(idarticulo)
{
    bootbox.confirm("¿Esta seguro de desactivar el articulo?", function(result){
        if(result)
        {
            $.post("../ajax/articulo.php?op=desactivar",{idarticulo : idarticulo}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

function activar(idarticulo)
{
    bootbox.confirm("¿Esta seguro de desactivar el articulo?", function(result){
        if(result)
        {
            $.post("../ajax/articulo.php?op=activar", {idarticulo : idarticulo}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}
init();
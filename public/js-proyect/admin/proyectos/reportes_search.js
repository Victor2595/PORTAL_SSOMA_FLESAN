$(function(){
	$("#selectUN").on('change',onSelectProjectChangeSearch);
	var $idu =  $("#selectUN").val();
	/*var $idp =  $("#selectProy").val();
	alert($idp);*/
	/*if($idu != -1){
		$.get('/configuracion_proyecto_registro/'+$idu, function(request){
			//$("#selectProy").append("<option value='-1'>Seleccione Proyecto</option>");
			for(var i=0;i<request.length;i++){
				$("#selectProy").append("<option value='"+request[i].id_proyecto+"'>"+request[i].nombre_proyecto+"</option");
			}
		});
	}*/
});

function onSelectProjectChangeSearch(){
	var $id = $(this).val();
	if($id != -1){
		$.get('/configuracion_proyecto_registro/'+$id, function(request){
			debugger;
			$("#selectProy").empty();
			$("#selectProy").append("<option value='-1'>Seleccione Proyecto</option>");
			for(var i=0;i<request.length;i++){
				$("#selectProy").append("<option style='font-size: 90%' value='"+request[i].id_proyecto+"' {{ old('selectProy')=="+request[i].id_proyecto+" ? 'selected' : ''}}>"+request[i].descripcion_proyecto+"</option");
			}
		});
	}else if($id == -1){
		$("#selectProy").empty();
		$("#selectProy").append("<option value='-1'>Seleccione Proyecto</option>");
	}
}
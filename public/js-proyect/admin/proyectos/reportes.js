$(function(){
	$("#selectUN").on('change',onSelectProjectChange);

	var $idp =  $("#selectUN").val();

});

function onSelectProjectChange(){
	var $id = $(this).val();
	if($id != -1){
		$.get('/configuracion_proyecto_registro/'+$id, function(request){
			debugger;
			if(request.length>0){
				$("#selectProy").prop('disabled',false);
				debugger;
			}else if(request.length=0){
				$("#selectProy").prop('disabled',true);
				debugger;
			}
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

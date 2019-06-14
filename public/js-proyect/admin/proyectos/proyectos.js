$(function(){
	$("#selectUN").on('change',onSelectProjectChange);
	$("#selectUN").on('change',onSelectJefe);
	$("#selectProy").on('change',onSelectProject);
	$("#selectRegimen").on('change',onSelectRegimen);
	
	var $idp =  $("#selectUN").val();
	if($idp != -1){
		var idproy = $("#idproy").val();
		$.get('/configuracion_proyecto_registro/'+$idp, function(request){
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
			if(idproy == request[i].id_proyecto){
				$("#selectProy").append("<option style='font-size: 90%' value='"+request[i].id_proyecto+"' selected>"+request[i].descripcion_proyecto+"</option");
			}else{
				$("#selectProy").append("<option style='font-size: 90%' value='"+request[i].id_proyecto+"'>"+request[i].descripcion_proyecto+"</option");	
			}
			
		}
	});


		$.get('/configuracion_proyecto_registro/id_jefe/'+$idp, function(request){
		$("#selectJef").empty();
		$("#selectJef").append("<option value='-1'>Seleccione Jefe</option");
		for(var i=0;i<request.length;i++){
			debugger;
			if(idproy == request[i].id_aplicacion_usuario){
				debugger;
				$("#selectJef").append("<option value='"+request[i].id_aplicacion_usuario+"' selected>"+request[i].username+"</option");			
			}else{
				debugger;
				$("#selectJef").append("<option value='"+request[i].id_aplicacion_usuario+"'>"+request[i].username+"</option");	
			}
		}
	});
	}
});

function onSelectProjectChange(){
	var $id = $(this).val();
	if($id != -1){
		$.get('/configuracion_proyecto_registro/'+$id, function(request){
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
		$("#nombreProy").val('');
		$("#inputGerente").val('');
		$("#inputResidente").val('');
		$("#inputValor").val('');
		$("#inputFechaI").val('');
		$("#inputFechaF").val('');
		$("#areaAlcance").val('');
		$("#inputCliente").val('');
		$("#idproy").val('');
		$("#inputTipoP").val('');
		$("#selectProy").empty();
		$("#selectProy").append("<option value='-1'>Seleccione Proyecto</option>");
	}
}

function onSelectJefe(){
	var $id = $(this).val();
	if($id != -1){
		$.get('/configuracion_proyecto_registro/id_jefe/'+$id, function(request){
			$("#selectJef").empty();
			$("#selectJef").append("<option value='-1'>Seleccione Jefe</option");
			for(var i=0;i<request.length;i++){
				$("#selectJef").append("<option value='"+request[i].id_aplicacion_usuario+"'>"+request[i].username+"</option");
			}
		});
	}else if($id == -1){
		$("#nombreProy").val('');
		$("#inputGerente").val('');
		$("#inputResidente").val('');
		$("#inputValor").val('');
		$("#inputFechaI").val('');
		$("#inputFechaF").val('');
		$("#areaAlcance").val('');
		$("#inputCliente").val('');
		$("#idproy").val('');
		$("#inputTipoP").val('');
		$("#selectProy").empty();
		$("#selectProy").append("<option value='-1'>Seleccione Proyecto</option>");
	}
}

function onSelectProject(){
	var $id_proyecto = $(this).val();
	if($id_proyecto == -1){
		$("#nombreProy").val('');
		$("#inputGerente").val('');
		$("#inputResidente").val('');
		$("#inputValor").val('');
		$("#inputFechaI").val('');
		$("#inputFechaF").val('');
		$("#areaAlcance").val('');
		$("#inputCliente").val('');
		$("#inputTipoP").val('');
	}else{
		$.get('/configuracion_proyecto_registro/id_proyecto/'+$id_proyecto, function(data){
			$("#idproy").val($id_proyecto);
			$("#inputTipoP").val(data[0].tipo_proyecto);
			$("#nombreProy").val(data[0].nombre_proyecto);
			$("#inputGerente").val(data[0].gerente_de_proyecto);
			$("#inputResidente").val(data[0].residente_obra);
			$("#inputValor").val(data[0].valor_contrato);
			$("#inputFechaI").val(data[0].fecha_inicio);
			$("#inputFechaF").val(data[0].fecha_fin);
			$("#areaAlcance").val(data[0].alcance);
			$("#inputCliente").val(data[0].cliente);
		});
	}
}

function onSelectRegimen(){
	var $id_regimen = $(this).val();
	if($id_regimen == '1'){
		$("#inputFactor").val("200000");
	}else if($id_regimen == '2'){
		$("#inputFactor").val("0");
	}else{
		$("#inputFactor").val("");
	}
}







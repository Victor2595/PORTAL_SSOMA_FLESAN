$(function(){
	$("#selectUN1").on('change',onSelectProjectChangeEdit);
	$("#selectUN1").on('change',onSelectJefeChangeEdit);
	$("#selectProy1").on('change',onSelectProjectEdit);
	$("#selectRegimen1").on('change',onSelectRegimenEdit);
	$("#selectJef1").on('change',onSelectJef1);

	var $idp =  $("#selectUN1").val();
	var $idu =  $("#selectProy1").val();
	var $idje = $("#selectJef1").val();
	var $idjeh = $("#selectJef1h").val();

	if($idje == -1){
		$("#selectJef1").empty();
		$("#selectJef1").append("<option value='-1' selected>Seleccione Jefe</option>");
		$.get('/configuracion_proyecto_registro/id_jefe/'+$idp, function(request){
			$("#selectJef1").empty();
			$("#selectJef1").append("<option value='-1' selected>Seleccione Jefe</option");
			for(var i=0;i<request.length;i++){
				$("#selectJef1").append("<option value='"+request[i].id_aplicacion_usuario+"'>"+request[i].username+"</option");
			}
		});
	}
	if($idjeh == -1){
		$("#selectJef1").val(-1);
	}
	if($idp == -1){
		$.get('/configuracion_proyecto_unidad_negocio', function(request){
			$("#selectUN1").empty();
			$("#selectJef1").empty();
			$("#inputGerente1").val('');
			$("#inputResidente1").val('');
			$("#inputValor1").val('');
			$("#inputFechaI1").val('');
			$("#inputFechaF1").val('');
			$("#areaAlcance1").val('');
			$("#inputCliente1").val('');
			$("#idproy1").val('');
			$("#inputTipoP1").val('');
			$("#selectUN1").focus();
			$("#selectJef1").append("<option value='-1' selected>Seleccione Jefe</option>");
			$("#selectUN1").append("<option value='-1' selected>Seleccione Empresa</option>");
			for(var i=0;i<request.length;i++){
				$("#selectUN1").append("<option value='"+request[i].COD_EMPRESA+"' >"+request[i].NOMBRE_EMPRESA+"</option");
			}
		});
		var idproy = $("#idproy").val();
		$.get('/configuracion_proyecto_unidad_negocio', function(request){
			$("#selectUN1").empty();
			$("#selectJef1").empty();
			$("#inputGerente1").val('');
			$("#inputResidente1").val('');
			$("#inputValor1").val('');
			$("#inputFechaI1").val('');
			$("#inputFechaF1").val('');
			$("#areaAlcance1").val('');
			$("#inputCliente1").val('');
			$("#idproy1").val('');
			$("#inputTipoP1").val('');
			$("#selectJef1").append("<option value='-1' selected>Seleccione Jefe</option>");
			$("#selectUN1").append("<option value='-1' selected>Seleccione Empresa</option>");
			for(var i=0;i<request.length;i++){
				$("#selectUN1").append("<option value='"+request[i].COD_EMPRESA+"' >"+request[i].NOMBRE_EMPRESA+"</option");
			}
		});
	}
	if($idu == -1 && $idp == -1){
		$.get('/configuracion_proyecto_registro/'+$idp, function(request){
			$("#inputGerente1").val('');
			$("#inputResidente1").val('');
			$("#inputValor1").val('');
			$("#inputFechaI1").val('');
			$("#inputFechaF1").val('');
			$("#areaAlcance1").val('');
			$("#inputCliente1").val('');
			$("#idproy1").val('');
			$("#inputTipoP1").val('');
			$('#nombreProy1').val('');
			$("#selectProy1").focus();
			$("#selectProy1").empty();
			$("#selectProy1").append("<option value='-1'>Seleccione Proyecto</option>");
			for(var i=0;i<request.length;i++){
				$("#selectProy1").append("<option value='"+request[i].id_proyecto+"'>"+request[i].descripcion_proyecto+"</option");
			}
		});
	}
	if($idu == -1){
		$("#inputGerente1").val('');
		$("#inputResidente1").val('');
		$("#inputValor1").val('');
		$("#inputFechaI1").val('');
		$("#inputFechaF1").val('');
		$("#areaAlcance1").val('');
		$("#inputCliente1").val('');
		$("#idproy1").val('');
		$("#inputTipoP1").val('');
		$('#nombreProy1').val('');
		$("#selectProy1").focus();
		$.get('/configuracion_proyecto_registro/'+$idp, function(request){
			if(request.length>0){
				$("#selectProy1").prop('disabled',false);
			}else if(request.length=0){
				$("#selectProy1").prop('disabled',true);
			}
			$("#selectProy1").empty();
			$("#selectProy1").append("<option value='-1'>Seleccione Proyecto</option>");
			for(var i=0;i<request.length;i++){
				$("#selectProy1").append("<option value='"+request[i].id_proyecto+"'>"+request[i].descripcion_proyecto+"</option");
			}
		});
	}
	
});


function sincronize($id){
	$.get('/configuracion_proyecto/'+$id+'/sincronizar', function(request){
		debugger;
		$("#inputGerente1").val(request[0].gerente_de_proyecto);
		$("#inputResidente1").val(request[0].residente_obra);
		$("#inputTipoP1").val(request[0].tipo_proyecto);
		$("#inputCliente1").val(request[0].cliente);
		$("#inputValor1").val(request[0].valor_contrato);
		$("#areaAlcance1").val(request[0].alcance);
		$("#inputFechaI1").val(request[0].fecha_inicio);
		$("#inputFechaF1").val(request[0].fecha_fin);
		$("#fecha_sincronize").val(request[0].fecha_sincronize);
	});
}


function onSelectProjectChangeEdit(){
	var $id_unidad_negocio = $(this).val();
	if($id_unidad_negocio != -1){
		$.get('/configuracion_proyecto_registro/'+$id_unidad_negocio, function(request){
			if(request.length>0){
				$("#selectProy1").prop('disabled',false);
			}else if(request.length=0){
				$("#selectProy1").prop('disabled',true);
			}
			//debugger;
			$("#selectProy1").empty();
			$("#selectProy1").append("<option value='-1'>Seleccione Proyecto</option>");
			for(var i=0;i<request.length;i++){
				$("#selectProy1").append("<option value='"+request[i].id_proyecto+"'>"+request[i].descripcion_proyecto+"</option");
				//debugger;
			}
		});
	}else if( $id_unidad_negocio == -1){
		$("#nombreProy1").val('');
		$("#idproy1").val('');
		$("#selectProy1").empty();
		$("#selectProy1").append("<option value='-1'>Seleccione Proyecto</option>");
		$("#selectJef1").val(-1);
		$("#inputGerente1").val('');
		$("#inputResidente1").val('');
		$("#inputValor1").val('');
		$("#inputTipoP1").val('');
		$("#inputFechaI1").val('');
		$("#inputFechaF1").val('');
		$("#areaAlcance1").val('');
		$("#inputCliente1").val('');
	}
}

function onSelectJefeChangeEdit(){
	var $id_unidad_negocio = $(this).val();
	//debugger;
	if($id_unidad_negocio != -1){
		$.get('/configuracion_proyecto_registro/id_jefe/'+$id_unidad_negocio, function(request){
			$("#selectJef1").empty();
			$("#selectJef1").append("<option value='-1'>Seleccione Jefe</option");
			for(var i=0;i<request.length;i++){
				$("#selectJef1").append("<option value='"+request[i].id_aplicacion_usuario+"'>"+request[i].username+"</option");
			}
		});
	}else if( $id_unidad_negocio == -1){
		$("#nombreProy1").val('');
		$("#idproy1").val('');
		$("#selectProy1").empty();
		$("#selectProy1").append("<option value='-1'>Seleccione Proyecto</option>");
		$("#selectJef1").val(-1);
		$("#inputGerente1").val('');
		$("#inputResidente1").val('');
		$("#inputValor1").val('');
		$("#inputFechaI1").val('');
		$("#inputTipoP1").val('');
		$("#inputFechaF1").val('');
		$("#areaAlcance1").val('');
		$("#inputCliente1").val('');
	}
}

function onSelectProjectEdit(){
	var $id_proyecto = $(this).val();
	if($id_proyecto == -1){
		$("#nombreProy1").val('');
		$("#idproy1").val('');
		$("#inputGerente1").val('');
		$("#inputResidente1").val('');
		$("#inputValor1").val('');
		$("#inputFechaI1").val('');
		$("#inputTipoP1").val('');
		$("#inputFechaF1").val('');
		$("#areaAlcance1").val('');
		$("#inputCliente1").val('');
	}else{
		$.get('/configuracion_proyecto_registro/id_proyecto/'+$id_proyecto, function(data){
			$("#idproy1").val($id_proyecto);
			$("#nombreProy1").val(data[0].nombre_proyecto);
			$("#inputGerente1").val(data[0].gerente_de_proyecto);
			$("#inputResidente1").val(data[0].residente_obra);
			$("#inputValor1").val(data[0].valor_contrato);
			$("#inputFechaI1").val(data[0].fecha_inicio);
			$("#inputFechaF1").val(data[0].fecha_fin);
			$("#areaAlcance1").val(data[0].alcance);
			$("#inputCliente1").val(data[0].cliente);
			$("#inputTipoP1").val(data[0].tipo_proyecto);
		});
	}
}

function onSelectRegimenEdit(){
	var $id_regimen = $(this).val();
	if($id_regimen == '1'){
		$("#inputFactor1").val("200000");
	}else if($id_regimen == '2'){
		$("#inputFactor1").val("0");
	}else{
		$("#inputFactor1").val("");
	}
}

function onSelectJef1(){
	var $id_jefe = this.value;
	$("#selectJef1h").val($id_jefe);
}
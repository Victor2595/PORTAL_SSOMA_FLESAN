function buscarUser(){
	if($("#inputEmail").val() != "" ){
		$email = $("#inputEmail").val();
		$empresa = "";
			
		$.get('/usuarios_informacion_carga/'+$email, function(request){
			if(request.length >= 1){
			$("#inputDni").val(request[0].pager);
			$("#inputNombres").val(request[0].givenName);
			$("#inputApellidos").val(request[0].sn);
			$empresa = request[0].company;
			$("#mensaje").prop("style","display : none");
			}else{
				$("#mensaje").prop("style","color : #d31a2b");
				$("#inputDni").val("");
				$("#inputNombres").val("");
				$("#inputApellidos").val("");
				$("#inputEmpresa").val("");
				$("#idEmpresa").val("");
				$empresa = "";
			}
		});

		$.get('/empresas', function(data){
			for(var $i=0;$i<data.length;$i++){
				$COD_EMPRESA = data[$i]['COD_EMPRESA'];

				if($empresa=='FP'){
					if($COD_EMPRESA == '0018'){
						$("#inputEmpresa").val(data[$i]['NOMBRE_EMPRESA']);
						$("#idEmpresa").val($COD_EMPRESA);
					}
				}else if($empresa=='DVC'){
					if($COD_EMPRESA == '0004'){
						$("#inputEmpresa").val(data[$i]['NOMBRE_EMPRESA']);
						$("#idEmpresa").val($COD_EMPRESA);
					}
				}else if($empresa=='FA'){
					if($COD_EMPRESA == '0010'){
						$("#inputEmpresa").val(data[$i]['NOMBRE_EMPRESA']);
						$("#idEmpresa").val($COD_EMPRESA);
					}
				}else if($empresa=='FAI'){
					if($COD_EMPRESA == '0019'){
						$("#inputEmpresa").val(data[$i]['NOMBRE_EMPRESA']);
						$("#idEmpresa").val($COD_EMPRESA);
					}
				}else if($empresa=='FE'){
					if($COD_EMPRESA == '0006'){
						$("#inputEmpresa").val(data[$i]['NOMBRE_EMPRESA']);
						$("#idEmpresa").val($COD_EMPRESA);
					}
				}else if($empresa=='FT'){
					if($COD_EMPRESA == '0020'){
						$("#inputEmpresa").val(data[$i]['NOMBRE_EMPRESA']);
						$("#idEmpresa").val($COD_EMPRESA);
					}
				}
			}
		});
	}else{
		$("#inputEmail").val("");
		$("#inputDni").val("");
		$("#inputNombres").val("");
		$("#inputApellidos").val("");
		$("#inputEmpresa").val("");
		$("#idEmpresa").val("");
		$("#mensaje").prop("style","display : none");
		$("#selectPerfil").empty();
		$("#selectPerfil").append("<option value='-1' selected>Seleccione Perfil</option>");
		$.get('/perfil', function(datax){
			for(var i=0;i<datax.length;i++){
				$("#selectPerfil").append("<option value='"+datax[i].id_rol+"'>"+datax[i].nombre+"</option>");
			}
		});
	}
}

function cancelar(){
	$("#inputEmail").val("");
	$("#inputDni").val("");
	$("#inputNombres").val("");
	$("#inputApellidos").val("");
	$("#inputEmpresa").val("");
	$("#idEmpresa").val("");
	$("#mensaje").prop("style","display : none");
	$("#btnGrabar").html('<i class="fas fa-user-plus"></i> Grabar');
	$("#selectPerfil").empty();
	$("#selectPerfil").append("<option value='-1' selected>Seleccione Perfil</option>");
	$.get('/perfil', function(datax){
		for(var i=0;i<datax.length;i++){
			$("#selectPerfil").append("<option value='"+datax[i].id_rol+"'>"+datax[i].nombre+"</option>");
		}
	});
}

function editUser($id){
	var $email = "";
	var $empresa = "";
    
    $.get('/administracion_usuarios/edit/'+$id, function(data){
    	if(data.length >= 1 ){
    		$("#inputEmailEdit").val(data[0].username);
			$("#inputDniEdit").val(data[0].dni);
			$("#inputNombresEdit").val(data[0].nombres);
			$("#inputApellidosEdit").val(data[0].apellidos);
			$("#selectPerfilEdit").val(data[0].id_rol);
			$("#mensajeEdit").prop("style","display : none");
			$.get('/empresas/'+data[0].id_empresa, function(request){
				$("#id_empresaEdit").val(data[0].id_empresa);
				$("#inputEmpresaEdit").val(request[0].NOMBRE_EMPRESA);
				
			});
		}
    });
}
$("#modal-default").on('hidden.bs.modal', function () {
		cancelar();
});

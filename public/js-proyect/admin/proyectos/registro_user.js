$(function(){
	$("#inputTipoDni").on('change',onSelectProjectChange);
});

function onSelectProjectChange(){
	var $id = $(this).val();
	if($id == 1){
		$("#lblDni").removeAttr('style');
		$("#inputDni").removeAttr('style');
		$("#lblPasaporte").prop("style","display : none");
		$("#inputPasaporte").prop("style","display : none");
		$("#inputPasaporte").val('');
	}else if($id==2){
		$("#lblPasaporte").removeAttr('style');
		$("#inputPasaporte").removeAttr('style');
		$("#lblDni").prop("style","display : none");
		$("#inputDni").prop("style","display : none");
		$("#inputDni").val('');
	}else if($id == -1){
		$("#lblDni").prop("style","display : none");
		$("#inputDni").prop("style","display : none");;
		$("#lblPasaporte").prop("style","display : none");
		$("#inputPasaporte").prop("style","display : none");
		$("#inputPasaporte").val('');
		$("#inputDni").val('');
	}

}


$(document).ready(function() {
    $('#dataTableIndicadores').DataTable();
});

$(document).ready(function() {
    $('#dataTableLG').DataTable();
});

/*function sumar() {
    var valor1 = $("#numeroHorasEntrenaDVC").val();
    var valor2 = $("#numeroHorasEntrenaSub").val();
    if (valor1 == null || valor1 == "") {
        valor1 = 0;
    }
    if (valor2 == null || valor2 == "") {
        valor2 = 0;
    }
    var suma = parseInt(valor1) + parseInt(valor2);
    $("#totalNHEObra").val(suma);
}*/




/*var progreso = 0;
var idIterval = setInterval(function(){

	var valor1 = $("#cantidadTrabajadores").val();
	var valor2 = $("#hombresHoraEx").val();
	var valor3 = $("#incidentesINC").val();
	var valor4 = $("#incidentesAP").val();
	var valor5 = $("#AAM").val();
	var valor6 = $("#ASP").val();
	var valor7 = $("#ACP").val();
	var valor8 = $("#AF").val();
	var valor9 = $("#diasPerdidos").val();
	var valor10 = $("#diasTransportados").val();
	var valor11 = $("#diasDesconectados").val();
	var valor12 = $("#cantidadColaboradoresS").val();
	var valor13 = $("#hombresHoraExSub").val();
	var valor14 = $("#incidentesINCSub").val();
	var valor15 = $("#incidentesAPSub").val();
	var valor16 = $("#AAMSub").val();
	var valor17 = $("#ASPSub").val();
	var valor18 = $("#ACPSub").val();
	var valor19 = $("#AFSub").val();
	var valor20 = $("#diasPerdidosSub").val();
	var valor21 = $("#diasTransportadosSub").val();
	var valor22 = $("#diasDesconectadosSub").val();
	var valor23 = $("#cantidadTrabEMI").val();
	var valor24 = $("#cantidadTrabEMS").val();
	var valor25 = $("#numeroTrabajEnfOcu").val();
	var valor26 = $("#numeroTrabExpOcEnferOcup").val();
	var valor27 = $("#numeroTrabajadCanceOcup").val();
	var valor28 = $("#numeroDiasAuseEnfNP").val();
	var valor29 = $("#certificadosRecibidos").val();
	var valor30 = $("#certificadosValilados").val();
	var valor31 = $("#accionesSustCambClimat").val();
	var valor32 = $("#descripcionSustCambiClima").val();
	var valor33 = $("#numeroHorasEntrenaDVC").val();
	var valor34 = $("#numeroHorasEntrenaSub").val();
	var valor35 = $("#totalNHEObra").val();
	var valor36 = $("#fechaRecepcionInforme").val();
	var valor37 = $("#totalNCOBS").val();
	var valor38 = $("#gestionAmbiental").val();
	var valor39 = $("#gestionSeguridadSalud").val();
	var valor40 = $("#evaluacionCumplimientoLegal").val();
	var valor41 = $("#interaccionPartPractSSOMA").val();
	var valor42 = $("#descripcionInteraccionParticionPracticas").val();
	var valor43 = $("#reunionesSSOMAObra").val();
	var valor44 = $("#generacionResiduosObrasEdif").val();
	var valor45 = $("#cantidadResiduosDispuestos").val();
	var valor46 = $("#consumoAguaObrEdif").val();
	var valor47 = $("#consumoEnergObrEdif").val();
		if(valor1 === null || valor1 === ''){incre1 = 0;}else{incre1 = 2.13;}
		if(valor2 === null || valor2 === ''){incre2 = 0;}else{incre2 = 2.13;}
		if(valor3 === null || valor3 === ''){incre3 = 0;}else{incre3 = 2.13;}
		if(valor4 === null || valor4 === ''){incre4 = 0;}else{incre4 = 2.13;}
		if(valor5 === null || valor5 === ''){incre5 = 0;}else{incre5 = 2.13;}
		if(valor6 === null || valor6 === ''){incre6 = 0;}else{incre6 = 2.13;}
		if(valor7 === null || valor7 === ''){incre7 = 0;}else{incre7 = 2.13;}
		if(valor8 === null || valor8 === ''){incre8 = 0;}else{incre8 = 2.13;}
		if(valor9 === null || valor9 === ''){incre9 = 0;}else{incre9 = 2.13;}
		if(valor10 === null || valor10 === ''){incre10 = 0;}else{incre10 = 2.13;}
		if(valor11 === null || valor11 === ''){incre11 = 0;}else{incre11 = 2.13;}
		if(valor12 === null || valor12 === ''){incre12 = 0;}else{incre12 = 2.13;}
		if(valor13 === null || valor13 === ''){incre13 = 0;}else{incre13 = 2.13;}
		if(valor14 === null || valor14 === ''){incre14 = 0;}else{incre14 = 2.13;}
		if(valor15 === null || valor15 === ''){incre15 = 0;}else{incre15 = 2.13;}
		if(valor16 === null || valor16 === ''){incre16 = 0;}else{incre16 = 2.13;}
		if(valor17 === null || valor17 === ''){incre17 = 0;}else{incre17 = 2.13;}
		if(valor18 === null || valor18 === ''){incre18 = 0;}else{incre18 = 2.13;}
		if(valor19 === null || valor19 === ''){incre19 = 0;}else{incre19 = 2.13;}
		if(valor20 === null || valor20 === ''){incre20 = 0;}else{incre20 = 2.13;}
		if(valor21 === null || valor21 === ''){incre21 = 0;}else{incre21 = 2.13;}
		if(valor22 === null || valor22 === ''){incre22 = 0;}else{incre22 = 2.13;}
		if(valor23 === null || valor23 === ''){incre23 = 0;}else{incre23 = 2.13;}
		if(valor24 === null || valor24 === ''){incre24 = 0;}else{incre24 = 2.13;}
		if(valor25 === null || valor25 === ''){incre25 = 0;}else{incre25 = 2.13;}
		if(valor26 === null || valor26 === ''){incre26 = 0;}else{incre26 = 2.13;}
		if(valor27 === null || valor27 === ''){incre27 = 0;}else{incre27 = 2.13;}
		if(valor28 === null || valor28 === ''){incre28 = 0;}else{incre28 = 2.13;}
		if(valor29 === null || valor29 === ''){incre29 = 0;}else{incre29 = 2.13;}
		if(valor30 === null || valor30 === ''){incre30 = 0;}else{incre30 = 2.13;}
		if(valor31 === null || valor31 === ''){incre31 = 0;}else{incre31 = 2.13;}
		if(valor32 === null || valor32 === ''){incre32 = 0;}else{incre32 = 2.13;}
		if(valor33 === null || valor33 === ''){incre33 = 0;}else{incre33 = 2.13;}
		if(valor34 === null || valor34 === ''){incre34 = 0;}else{incre34 = 2.13;}
		if(valor35 === null || valor35 === ''){incre35 = 0;}else{incre35 = 2.13;}
		if(valor36 === null || valor36 === ''){incre36 = 0;}else{incre36 = 2.13;}
		if(valor37 === null || valor37 === ''){incre37 = 0;}else{incre37 = 2.13;}
		if(valor38 === null || valor38 === ''){incre38 = 0;}else{incre38 = 2.13;}
		if(valor39 === null || valor39 === ''){incre39 = 0;}else{incre39 = 2.13;}
		if(valor40 === null || valor40 === ''){incre40 = 0;}else{incre40 = 2.13;}
		if(valor41 === null || valor41 === ''){incre41 = 0;}else{incre41 = 2.13;}
		if(valor42 === null || valor42 === ''){incre42 = 0;}else{incre42 = 2.13;}
		if(valor43 === null || valor43 === ''){incre43 = 0;}else{incre43 = 2.13;}
		if(valor44 === null || valor44 === ''){incre44 = 0;}else{incre44 = 2.13;}
		if(valor45 === null || valor45 === ''){incre45 = 0;}else{incre45 = 2.13;}
		if(valor46 === null || valor46 === ''){incre46 = 0;}else{incre46 = 2.13;}
		if(valor47 === null || valor47 === ''){incre47 = 0;}else{incre47 = 2.13;}

		progreso = incre1 + incre2 + incre3 + incre4 + incre5 + incre6 + incre7 + incre8 + incre9 + incre10 + 
		incre11 + incre12 + incre13 + incre14 + incre15 + incre16 + incre17+ incre18 + incre19 + incre20 + 
		incre21 + incre22 + incre23 + incre24 + incre25 + incre26 + incre27 + incre28 + incre29 + incre30 + 
		incre31 + incre32 + incre33 + incre34 + incre35 + incre36 + incre37 + incre38 + incre39 + incre40 + 
		incre41 + incre42 + incre43 + incre44 + incre45 + incre46 + incre47;

		$('#bar').css('width', progreso + '%');
		//2.10 
		//Si llegó a 100 elimino el interval
		if(progreso == 100){
		clearInterval(idIterval);
		}
},1000);*/




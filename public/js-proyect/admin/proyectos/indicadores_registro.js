function sumar() {
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
}
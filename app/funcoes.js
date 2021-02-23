
$("#cpfcnpj").keydown(function(){
    try {
        $("#cpfcnpj").unmask();
    } catch (e) {}

    var tamanho = $("#cpfcnpj").val().length;

    if(tamanho < 11){
        $("#cpfcnpj").mask("999.999.999-99");
    } else {
        $("#cpfcnpj").mask("99.999.999/9999-99");
    }

    // ajustando foco
    var elem = this;
    setTimeout(function(){
        // mudo a posição do seletor
        elem.selectionStart = elem.selectionEnd = 10000;
    }, 0);
    // reaplico o valor para mudar o foco
    var currentValue = $(this).val();
    $(this).val('');
    $(this).val(currentValue);
});

$("#fone").keydown(function(){
    $('#fone').mask("(99)99999-9999");
    
});

$("#cel").keydown(function(){
    $('#cel').mask("(99)99999-9999");
});

$("#cep").keydown(function(){
    $("#cep").mask("99999-999");
})

$("#limiteCredito").keydown(function(){
    $("#limiteCredito").mask("R$ 9.999.99");
})
$(".money").keydown(function(){
    $('.money').mask("#.##0,00", { reverse: true });
});


function somenteNumeros(e) {
    
    var charCode = e.charCode ? e.charCode : e.keyCode;
    // charCode 8 = backspace   
    // charCode 9 = tab
    if (charCode != 8 && charCode != 9) {
        // charCode 48 equivale a 0   
        // charCode 57 equivale a 9
        if (charCode < 48 || charCode > 57) {
            return false;
        }
    }
}

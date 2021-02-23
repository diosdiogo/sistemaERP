
  
    var publico = {};
    var custoCompra = $("input[name='custocompra']");
    var preco = $("input[name='precovista']");
    var margemLucro = $("#margemlucro");
    var boxmoney = $("#box-money");

    var calcularLucroChange = function () {
        
        var porcentagem = "<small>%</small>";
        removerClassesBoxMoney();
        var precoNumero = parseFloat(preco.val().replace('.', '').replace(',','.')).toFixed(2);
        var custoCompraNumero = parseFloat(custoCompra.val().replace('.', '').replace(',', '.')).toFixed(2);

        if (precoNumero > 0 && custoCompraNumero > 0) {
            var margem = ((((custoCompraNumero - precoNumero) / custoCompraNumero) * 100) * -1);
            if (margem > 0) {
                boxmoney.addClass('bg-green');
            } else if (margem == 0) {
                boxmoney.addClass('bg-blue');
            } else {
                boxmoney.addClass('bg-red');
            }

            margemLucro.html(margem + "" + porcentagem);
        } else {
            boxmoney.addClass('bg-blue');
            margemLucro.html("0" + porcentagem);
        }
    };

    var removerClassesBoxMoney = function () {
        boxmoney.removeClass('bg-blue');
        boxmoney.removeClass('bg-green');
        boxmoney.removeClass('bg-red');
    };

    var inicializarEventos = function () {
        custoCompra.on("change", calcularLucroChange);
        preco.on("change", calcularLucroChange);
    }

    init = function () {
        inicializarEventos();

        setTimeout(function () {
            custoCompra.trigger("change");
            preco.trigger("change");
        }, 100)
    };

init();
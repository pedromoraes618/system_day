



var data_inicial = document.getElementById('data_inicial')
var data_final = document.getElementById('data_final')
var conta_financeira = document.getElementById('conta_financeira')

resumo_extrato_financeiro(data_inicial.value, data_final.value, conta_financeira.value);

$("#consultar").click(function () {
    resumo_extrato_financeiro(data_inicial.value, data_final.value, conta_financeira.value);
})




function resumo_extrato_financeiro(data_inicial, data_final, conta_financeira) {

    $.ajax({
        type: 'GET',
        data: "extrato_financeiro=true&acao=resumo_extrato&data_inicial=" + data_inicial + "&data_final=" + data_final + "&conta_financeira=" + conta_financeira,
        url: "view/financeiro/extrato_financeiro/table/resumo.php",
        success: function (result) {
            return $('.tabela').html(result);
        },
    });
}

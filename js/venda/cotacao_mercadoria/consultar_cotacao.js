
//valores do campo de pesquisa //pesquisa via filtro
var conteudo_pesquisa = document.getElementById("pesquisa_conteudo");
var data_inicial = document.getElementById("data_inicial");
var data_final = document.getElementById("data_final");
var status = document.getElementById("status");

$(document).ready(function () {
    //consultar tabela
    $.ajax({
        type: 'GET',
        data: "consultar_cotacao=inicial&conteudo_pesquisa=" + conteudo_pesquisa.value + "&data_inicial=" + data_inicial.value + "&data_final=" + data_final.value,
        url: "view/venda/cotacao_mercadoria/table/consultar_cotacao.php",
        success: function (result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .tabela").html(result);
        },
    });
})


$("#adicionar_cotacao").click(function () {
 
    $.ajax({
        type: 'GET',
        data: "adicionar_cotacao=true",
        url: "view/venda/cotacao_mercadoria/cotacao_tela.php",
        success: function (result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .modal_show").html(result)+ $("#modal_adicionar_cotacao").modal('show');;

        },
    });
})





$("#pesquisar_filtro_pesquisa").click(function () {//realizar a pesquisa
    $.ajax({
        type: 'GET',
        data: "consultar_venda=detalhado&conteudo_pesquisa=" + conteudo_pesquisa.value + "&data_inicial=" + data_inicial.value + "&data_final=" + data_final.value + "&status_recebimento=" + status_recebimento.value ,
        url: "view/venda/venda_mercadoria/table/consultar_venda.php",
        success: function (result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .tabela").html(result);
        },
    });

})



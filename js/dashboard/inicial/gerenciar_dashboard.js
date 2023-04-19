$(document).ready(function() {
    // 
    //consultar informação tabela
    $(".bloco-pesquisa-menu .bloco-pesquisa-1-dashboard").css("display","block")
    $(".bloco-pesquisa-menu .bloco-pesquisa-2-dashboard").css("display","block") // aparecer tela de cadastro
    $.ajax({
        type: 'GET',
        data: "consultar_lancamento_financeiro=inicial",
        url: "view/dashboard/inicial/bloco/topo-1.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1-dashboard").html(result);
        },
    });

    $.ajax({
        type: 'GET',
        data: "consultar_lancamento_financeiro=inicial",
        url: "view/dashboard/inicial/bloco/body-1.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-2-dashboard").html(result);
        },
    });
})




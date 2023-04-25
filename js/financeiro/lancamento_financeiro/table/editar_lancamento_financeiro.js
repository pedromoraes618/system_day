//abrir a pagina de edição do formulario, pegando o id 
$(".editar_lancamento_financeiro").click(function () {
    var form_id = $(this).attr("lancamento_financeiro_id")
    var tipo = $(this).attr("tipo")
    
    if (tipo == "RECEITA") {
        $.ajax({
            type: 'GET',
            data: "editar_lancamento_financeiro=true&tipo=RECEITA&form_id=" + form_id,
            url: "view/financeiro/lancamento_financeiro/lancamento_financeiro_tela.php",
            success: function (result) {
                return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .modal_show").html(result) + $("#modal_lancamento_financeiro").modal('show');
            },
        });
    }
    if (tipo == "DESPESA") {
        $.ajax({
            type: 'GET',
            data: "editar_lancamento_financeiro=true&tipo=DESPESA&form_id=" + form_id,
            url: "view/financeiro/lancamento_financeiro/lancamento_financeiro_tela.php",
            success: function (result) {
                return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .modal_show").html(result) + $("#modal_lancamento_financeiro").modal('show');

            },
        });
    }

});
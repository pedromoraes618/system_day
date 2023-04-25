
//valores do campo de pesquisa //pesquisa via filtro
var conteudo_pesquisa = document.getElementById("pesquisa_conteudo");
var data_inicial = document.getElementById("data_inicial");
var data_final = document.getElementById("data_final");
var status_lancamento_financeiro = document.getElementById("status_lancamento");
var classificao_financeiro = document.getElementById("classificao_financeiro");
var tipo_lancamento = document.getElementById("tipo_lancamento");

$(document).ready(function () {
    let status_lancamento = document.getElementById("status_lancamento")
    let classificao_financeiro = document.getElementById("classificao_financeiro")
    // popular os select, trazer informações do banco //select status lancamento e classificacao
    $.ajax({
        type: "POST",
        data: "consultar_select=true",
        url: "modal/financeiro/lancamento_financeiro/gerenciar_lancamento_financeiro.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso) {
            for ($i = 0; $i < $dados.status_lancamento.length; $i++) {
                const newOptionStatusLancamento = document.createElement('option');
                newOptionStatusLancamento.value = $dados.status_lancamento[$i].id;
                newOptionStatusLancamento.text = $dados.status_lancamento[$i].descricao;

                // adiciona a option ao select status lancameto
                status_lancamento.add(newOptionStatusLancamento);
            }
            for ($i = 0; $i < $dados.classificao_financeiro.length; $i++) {
                const newOptionClassificaoFinanceiro = document.createElement('option');
                newOptionClassificaoFinanceiro.value = $dados.classificao_financeiro[$i].id;
                newOptionClassificaoFinanceiro.text = $dados.classificao_financeiro[$i].descricao;

                // adiciona a option ao select classificacao_financeiro
                classificao_financeiro.add(newOptionClassificaoFinanceiro);
            }
        }
    }
    function falha() {
        console.log("erro ao requisitar ao bd")
    }

    //consultar tabela
    $.ajax({
        type: 'GET',
        data: "consultar_lancamento_financeiro=inicial&conteudo_pesquisa=" + conteudo_pesquisa.value + "&data_inicial=" + data_inicial.value + "&data_final=" + data_final.value,
        url: "view/financeiro/lancamento_financeiro/table/consultar_lancamento_financeiro.php",
        success: function (result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .tabela").html(result);
        },
    });
})

//adicionar receita
$("#adicionar_lancamento_receita").click(function () {
    $.ajax({
        type: 'GET',
        data: "adicionar_lancamento_financeiro=true&tipo=RECEITA",
        url: "view/financeiro/lancamento_financeiro/lancamento_financeiro_tela.php",
        success: function (result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .modal_show").html(result) + $("#modal_lancamento_financeiro").modal('show');

        },
    });
})
//adicionar despesa
$("#adicionar_lancamento_despesa").click(function () {
    $.ajax({
        type: 'GET',
        data: "adicionar_lancamento_financeiro=true&tipo=DESPESA",
        url: "view/financeiro/lancamento_financeiro/lancamento_financeiro_tela.php",
        success: function (result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .modal_show").html(result) + $("#modal_lancamento_financeiro").modal('show');

        },
    });
})





$("#pesquisar_filtro_pesquisa").click(function () {//realizar a pesquisa
    $.ajax({
        type: 'GET',
        data: "consultar_lancamento_financeiro=detalhado&conteudo_pesquisa=" + conteudo_pesquisa.value + "&data_inicial=" + data_inicial.value + "&data_final=" + data_final.value + "&status_lancamento=" + status_lancamento_financeiro.value + "&classificao_financeiro=" + classificao_financeiro.value + "&tipo_lancamento=" + tipo_lancamento.value,
        url: "view/financeiro/lancamento_financeiro/table/consultar_lancamento_financeiro.php",
        success: function (result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .tabela").html(result);
        },
    });

})



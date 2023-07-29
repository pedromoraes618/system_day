//valores do campo de pesquisa //pesquisa via filtro
var conteudo_pesquisa = document.getElementById("pesquisa_conteudo")
var status_prod = document.getElementById("status_prod")
var tipo_produto = document.getElementById("tipo_produto")

//consultar tabela
$.ajax({
    type: 'GET',
    data: "consultar_produto=inicial",
    url: "view/estoque/produto/table/consultar_produto.php",
    success: function (result) {
        return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .tabela").html(result);
    },
});


$("#pesquisar_filtro_pesquisa").click(function () {
    if (conteudo_pesquisa.value == "" && status_prod.value == "0") {
        $(".alerta").html("<span class='alert alert-primary position-absolute' style role='alert'>Favor informe a palavra chave</span>")
        setTimeout(function () {
            $(".alerta .alert").css("display", "none")
        }, 5000);
    } else {
        $.ajax({
            type: 'GET',
            data: "consultar_produto=detalhado&conteudo_pesquisa=" + conteudo_pesquisa.value + "&status_prod=" + status_prod.value + "&tipo_produto=" + tipo_produto.value,
            url: "view/estoque/produto/table/consultar_produto.php",
            success: function (result) {
                return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .tabela").html(result);
            },
        });
    }
})


$("#adicionar_produto").click(function () {
    /*abrir modal */
    $.ajax({
        type: 'GET',
        data: "cadastro_produto=true",
        url: "view/estoque/produto/produto_tela.php",
        success: function (result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .modal_show").html(result) + $("#modal_produto").modal('show');;

        },
    });
})

//ao clicar no botão cadastrar produto
$("#adicionar_produto").click(function(e) {
    $(".bloco-pesquisa-menu .bloco-pesquisa-1").css("display","none")
    $(".bloco-pesquisa-menu .bloco-pesquisa-2").css("display","block")
  //  $(".bloco-pesquisa-menu .bloco-pesquisa-2").css("display","none") // aparecer tela de cadastro
    $.ajax({
        type: 'GET',
        data: "cadastro_produto=true",
        url: "view/estoque/produto/cadastro_produto.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-2").html(result);
        },
    });
})
//consultar tabela
$.ajax({
    type: 'GET',
    data: "consultar_produto=inicial",
    url: "view/estoque/produto/table/consultar_produto.php",
    success: function(result) {
        return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .tabela").html(result);
    },
});

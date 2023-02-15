$(document).ready(function() {
    
    //consultar informação tabela
    $(".bloco-pesquisa-menu .bloco-pesquisa-1").css("display","block")
    $(".bloco-pesquisa-menu .bloco-pesquisa-2").css("display","block") // aparecer tela de cadastro
    $.ajax({
        type: 'GET',
        data: "consultar_produto=inicial",
        url: "view/estoque/produto/consultar_produto.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1").html(result);
        },
    });
})



//valores do campo de pesquisa
let conteudo_pesquisa = document.getElementById("pesquisa_conteudo")
$("#pesquisar_filtro_pesquisa").click(function(e) {
    $.ajax({
        type: 'GET',
        data: "consultar_grupo=detalhado&conteudo_pesquisa=" + conteudo_pesquisa.value,
        url: "view/estoque/grupo_estoque/table/consultar_grupo_estoque.php",
        success: function(result) {
            return $(".bloco-pesquisa-2 .tabela").html(result);
        },
    });
})


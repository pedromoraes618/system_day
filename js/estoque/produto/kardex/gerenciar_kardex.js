$(document).ready(function() {
var id_produto = document.getElementById("id_produto")

$.ajax({
    type: 'GET',
    data: "kardex_produto=true&id_produto="+id_produto.value,
    url: "view/estoque/produto/karkex/table/consultar_kardex.php",
    success: function(result) {
        return $(".tabela").html(result);
    },
});
})

$("#voltar_consulta").click(function(e) {
    $(".bloco-pesquisa-menu .bloco-pesquisa-1").css("display","block") // remover tela de cadastro
    $(".bloco-pesquisa-menu .bloco-pesquisa-2").css("display","none") // aparecer tela de consulta
        $.ajax({
        type: 'GET',
        data: "consultar_grupo=inicial",
        url: "view/estoque/produto/consultar_produto.php",
        success: function(result) {
        return $(".bloco-pesquisa-menu .bloco-pesquisa-1").html(result);
        },
    });
    
})
    

//ao clicar no botão cadastrar produto
$(".editar_cliente").click(function(e) {
    $(".bloco-pesquisa-menu .bloco-pesquisa-1").css("display","none")
    $(".bloco-pesquisa-menu .bloco-pesquisa-2").css("display","block")
  //  $(".bloco-pesquisa-menu .bloco-pesquisa-2").css("display","none") // aparecer tela de cadastro
 var id_cliente= $(this).attr("id_cliente")
  $.ajax({
        type: 'GET',
        data: "editar_cliente=true&id_cliente="+id_cliente,
        url: "view/empresa/cliente/editar_cliente.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-2").html(result);
        },
    });
})


$(".consultar_historico").click(function(e) {
    var id_cliente = $(this).attr("id_cliente")
    $(".bloco-pesquisa-menu .bloco-pesquisa-1").css("display","none")
    $(".bloco-pesquisa-menu .bloco-pesquisa-2").css("display","block")
$.ajax({
    type: 'GET',
    data: "historico_cliente=true&id_cliente="+id_cliente,
    url: "view/empresa/historico/consultar_historico.php",
    success: function(result) {
        return $(".bloco-pesquisa-menu .bloco-pesquisa-2").html(result);
    },
});
})
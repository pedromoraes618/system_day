$(".editar_subcategoria").click(function(e) {
    $('.bloco-pesquisa-menu .bloco-pesquisa-1').css("display", 'none')
    $('.bloco-pesquisa-menu .bloco-pesquisa-1').fadeIn(500)
    let id_subcategoria = $(this).attr("id_subcategoria")
   
    $.ajax({
        type: 'GET',
        data: "editar_subcategoria=true&id_subcategoria=" + id_subcategoria,
        url: "view/suporte/tela/editar_subcategoria.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .bloco-cadastro-1").html(result);
        },
    });
})
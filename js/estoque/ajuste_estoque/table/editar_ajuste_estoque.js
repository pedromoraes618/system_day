$(".editar_ajuste").click(function () {
    var form_id = $(this).attr("codigo_nf")
    var data_lancamento = $(this).attr("data_lancamento")
    /*abrir modal */
    $.ajax({
        type: 'GET',
        data: "ajuste_estoque=true&codigo_nf=" + form_id + "&data_lancamento=" + data_lancamento,
        url: "view/estoque/ajuste_estoque/ajuste_tela.php",
        success: function (result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .modal_show").html(result) + $("#modal_ajuste_estoque").modal('show');;

        },
    });
})


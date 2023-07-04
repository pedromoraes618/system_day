
$(".alterar_produto_vnd").click(function () {
    var prod_id = $(this).attr("produto_id")
    $.ajax({
        type: 'GET',
        data: "item_nf=true&acao=alterar_prod_nf&id_item_nf=" + prod_id + "&serie=vnd",
        url: "view/include/produto/produto_nf.php",
        success: function (result) {
            return $(".modal_externo").html(result) + $("#modal_item_nf").modal('show');
        },
    })
})
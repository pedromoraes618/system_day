var descricao_dl = $('#descricao_delivery').val()
var img_produto = $('#img_produto').val()
var descricao_dl_ext = $('#descricao_ext_delivery').val()
$('#descricao_delivery_modal').val(descricao_dl);
$('#descricao_completo_delivery_modal').val(descricao_dl_ext);


$('.bg-img-produto').attr({//adicionar a imagem na div
    'style': 'background-image: url("img/produto/' + img_produto + '")', // alterar a img na div
});

$("#salvar_prod_delivery").click(function () {//adicionar observação no imput do formulario
    var valor_descricao_delivery = $('#descricao_delivery_modal').val();
    var valor_descricao_ext_delivery = $('#descricao_completo_delivery_modal').val();
    $('#descricao_delivery').val(valor_descricao_delivery);
    $('#descricao_ext_delivery').val(valor_descricao_ext_delivery);
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: "Informação salva com sucesso",
        showConfirmButton: false,
        timer: 3500
    })
})

// $('#modal_produto_delivery').on('hide.bs.modal', function (e) {
//     var valor_descricao_delivery = $('#descricao_delivery_modal').val();
//     var valor_descricao_ext_delivery = $('#descricao_completo_delivery_modal').val();
//     $('#descricao_delivery').val(valor_descricao_delivery);
//     $('#descricao_ext_delivery').val(valor_descricao_ext_delivery);
//     Swal.fire({
//         position: 'center',
//         icon: 'success',
//         title: "Informação salva com sucesso",
//         showConfirmButton: false,
//         timer: 3500
//     })
// });

$("#open_upload_img_prod").click(function () {
    $.ajax({
        type: 'GET',
        data: "upload_img_produto=true",
        url: "view/include/produto/produto_upload_img.php",
        success: function (result) {
            return $(".modal_externo_modal").html(result) + $("#modal_upload_produto_img").modal('show');

        },
    });
})


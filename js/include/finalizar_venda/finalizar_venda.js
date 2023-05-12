

$(".seleciona_fpg").click(function(){

    var id_fpg = $(this).attr("id_fpg")

   var descricao_fpg = $('.descricao_fpg_'+id_fpg).html()

    $('#id_forma_pagamento_venda').val(id_fpg)
    $('.descricao_forma_pagamento_venda').html(descricao_fpg)

})

var id_nf = $("#id").val()
if (id_nf != "") {//editar nf
    show_det_finalizar_nf(id_nf, codigo_nf.value)
    $('#finalizar_venda').html("Alterar venda")
    $("#modal_finalizar_venda .modal-title").html('Alterar venda')
}


//mostrar as informações no formulario show
function show_det_finalizar_nf(id, codigo_nf) {

    $.ajax({
        type: "POST",
        data: "venda_mercadoria=true&acao=show&nf_id=" + id + "&codigo_nf=" + codigo_nf,
        url: "modal/venda/venda_mercadoria/gerenciar_venda.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            $("#sub_total_venda").val($dados.valores['sub_total_venda'])
            $("#desconto_venda_real").val($dados.valores['desconto_venda_real'])
            $("#valor_liquido_venda").val($dados.valores['valor_liquido_venda'])
            $("#vendedor_id_venda").val($dados.valores['vendedor_id_venda'])
            $("#id_forma_pagamento_venda").val($dados.valores['id_forma_pagamento_venda'])
            $('.descricao_forma_pagamento_venda').html($dados.valores['descricao_forma_pagamento_venda'])
        }
    }

    function falha() {
        console.log("erro");
    }

}

$("#venda_mercadoria").submit(function (e) {
    e.preventDefault()
    var id_nf = $("#id").val()
    if(id_nf !=''){
        var mensagem = "Deseja alterar essa venda?"
    }else{
        var mensagem = "Deseja finalizar essa venda?"
    }
    var formulario = $(this);
    Swal.fire({
        title: 'Tem certeza?',
        text: mensagem,
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Não',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim'
    }).then((result) => {
        if (result.isConfirmed) {
            var retorno = create(formulario, produtos, codigo_nf.value);
        }
    })

})
//calulcar o valor liquido do produto
function calcular_desconto_venda_real() {
    var valor_bruto_Venda = $('#sub_total_venda').val();
    var desconto_venda_real = $('#desconto_venda_real').val();

    if (valor_bruto_Venda != "" && desconto_venda_real != "") {//verificar se o valores foram preenchidos
        if (desconto_venda_real) {
            if (desconto_venda_real.includes(",")) {
                desconto_venda_real = desconto_venda_real.replace(",", ".");
            }
            if (valor_bruto_Venda.includes(",")) {
                valor_bruto_Venda = valor_bruto_Venda.replace(",", ".");
            }
            desconto_venda_real = parseFloat(desconto_venda_real)
            valor_bruto_Venda = parseFloat(valor_bruto_Venda)
            valor_liquido_venda = valor_bruto_Venda - desconto_venda_real
            desconto_porcentagem = ((desconto_venda_real / valor_bruto_Venda) * 100)

            $('#desconto_venda_porcentagem').val(desconto_porcentagem.toFixed(2))

            $('#valor_liquido_venda').val(valor_liquido_venda.toFixed(2))

        }
    }
}
//calulcar o valor liquido do produto
function calcular_desconto_venda_porcentagem() {
    var valor_bruto_Venda = $('#sub_total_venda').val();
    var desconto_venda_porcentagem = $('#desconto_venda_porcentagem').val();
    var desconto_venda_real = $('#desconto_venda_real').val();


    if (valor_bruto_Venda != "" && desconto_venda_porcentagem != "") {//verificar se o valores foram preenchidos
        if (desconto_venda_porcentagem) {
            if (desconto_venda_porcentagem.includes(",")) {
                desconto_venda_porcentagem = desconto_venda_porcentagem.replace(",", ".");
            }
            if (valor_bruto_Venda.includes(",")) {
                valor_bruto_Venda = valor_bruto_Venda.replace(",", ".");
            }
            desconto_venda_porcentagem = parseFloat(desconto_venda_porcentagem)
            valor_bruto_Venda = parseFloat(valor_bruto_Venda)

            calcular_desconto_real = ((desconto_venda_porcentagem / 100) * valor_bruto_Venda)

            $('#desconto_venda_real').val(calcular_desconto_real.toFixed(2))
            $('#valor_liquido_venda').val((valor_bruto_Venda - desconto_venda_real).toFixed(2))
        }
    }
}


$(".seleciona_fpg").click(function () {

    var id_fpg = $(this).attr("id_fpg")
    var descricao_fpg = $('.descricao_fpg_' + id_fpg).html()
    $('#id_forma_pagamento_venda').val(id_fpg)
    $('.descricao_forma_pagamento_venda').html(descricao_fpg)

})
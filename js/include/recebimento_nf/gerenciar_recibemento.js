//retorna os dados para o formulario



var id_formulario = $("#nf_id").val()
if (id_formulario == "") {
} else {//exibir os dados na tela
    show(id_formulario) // funcao para retornar os dados para o formulario
}

$("#recebimento_nf").submit(function (e) {//adicionar o produto na venda
    e.preventDefault()
    var formulario = $(this);
    if (id_formulario != "") {//cadastrar
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja realizar o recebimento dessa venda",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Não',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (result.isConfirmed) {
                var retorno = create(formulario)
            }
        })
    }
})

//mostrar as informações no formulario show
function show(id) {
    $.ajax({
        type: "POST",
        data: "recebimento_nf_saida=true&acao=show&nf_id=" + id,
        url: "modal/recebimento_nf/nf_saida/gerenciar_recebimento.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            $("#numero_nf").val($dados.valores['numero_nf'])
            $("#valor_liquido").val($dados.valores['valor_liquido'])
            $("#forma_pagamento").val($dados.valores['forma_pagamento'])
            $("#cliente").val($dados.valores['cliente'])
        }
    }

    function falha() {
        console.log("erro");
    }

}


//mostrar as informações no formulario show
function create(dados) {
    console.log(dados.serialize())
    $.ajax({
        type: "POST",
        data: "recebimento_nf_saida=true&acao=create&" + dados.serialize(),
        url: "modal/recebimento_nf/nf_saida/gerenciar_recebimento.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: $dados.title,
                showConfirmButton: false,
                timer: 3500
            })
         

            $('#pesquisar_filtro_pesquisa').trigger('click'); // clicar automaticamente para realizar a consulta
           
            setTimeout(function () {
                $('#fechar_modal_recebimento').trigger('click'); // clicar automaticamente para fechar o modal
            }, 1000);
    
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Verifique!',
                text: $dados.title,
                timer: 7500,
            })

        }
    }

    function falha() {
        console.log("erro");
    }

}

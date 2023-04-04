$("#voltar").click(function (e) {
    $(".bloco-pesquisa-menu .bloco-pesquisa-2").css("display", "none") // aparecer tela de consulta

})

const fomulario_produto = document.getElementById("cadastrar_produto");
let id_forma_pagamento = document.getElementById("id")
let titulo = document.getElementById('title_modal')
let btn_form = document.getElementById('button_form')


//retorna s dados para o formulario
if (id_forma_pagamento.value == "") {
    $('#button_form').html('Cadastrar');
} else {
    $('#button_form').html('Alterar');

    show(id_forma_pagamento.value) // funcao para retorar os dados para o formulario
}

//formulario para cadstro
$("#forma_pagamento").submit(function (e) {
    if (id_forma_pagamento.value == "") {//cadastrar
        e.preventDefault()
        var formulario = $(this);
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja cadastrar esse produto?",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Não',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (result.isConfirmed) {
                var retorno = cadastrar_produto(formulario)
            }
        })
    } else {//editar

    }


})

function cadastrar_produto(dados) {
    $.ajax({
        type: "POST",
        data: dados.serialize(),
        url: "modal/estoque/produto/gerenciar_produto.php",
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
            fomulario_produto.reset(); // redefine os valores do formulário
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
//mostrar as informações no formulario show
function show(id) {
    $.ajax({
        type: "POST",
        data: "formulario_forma_pagamento=true&acao=show&forma_pagamento_id="+id,
        url: "modal/configuracao/forma_pagamento/gerenciar_forma_pagamento.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            $("#descricao").val($dados.valores['descricao'])
            $("#conta_financeira").val($dados.valores['conta_financeira'])
            $("#status").val($dados.valores['status_recebimento'])
        }
    }

    function falha() {
        console.log("erro");
    }

}


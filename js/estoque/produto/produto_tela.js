

const formulario_post = document.getElementById("produto");
let id_formulario = document.getElementById("id")
let btn_form = document.getElementById('button_form')


//retorna os dados para o formulario
if (id_formulario.value == "") {
    $(".title .sub-title").html("Cadastro de produtos")//alterar a label cabeçalho
    $("#button_form").html("Cadastrar")
} else {
    $('#alterar_venda').html('Alterar');
    $(".title .sub-title").html("Alterar lançamento")
    show(id_formulario.value) // funcao para retornar os dados para o formulario
}

$("#produto").submit(function (e) {//adicionar o produto na venda
    if (id_formulario.value == "") {//cadastrar
        e.preventDefault()
        var formulario = $(this);
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja cadastrar esss produto",
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
    } else {//editar

    }
})

function create(dados) {
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
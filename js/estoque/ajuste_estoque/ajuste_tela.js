function generateUniqueId() {
    var timestamp = Date.now().toString(); // Obter o timestamp atual como uma string
    var randomNum = Math.random().toString().substr(2, 5); // Gerar um número aleatório e extrair uma parte dele
    var uniqueId = timestamp + randomNum; // Concatenar o timestamp e o número aleatório
    return uniqueId;
}

$("#codigo_nf").val(generateUniqueId())
var codigo_nf = $("#codigo_nf").val()
tabela_produtos(codigo_nf)//consultar tabela de ajst
//modal para consultar o produto
$("#modal_produto").click(function () {
    $.ajax({
        type: 'GET',
        data: "adicionar_produto=true",
        url: "view/include/produto/pesquisa_produto.php",
        success: function (result) {
            return $(".modal_externo").html(result) + $("#modal_pesquisa_produto").modal('show');

        },
    });
});

$("#ajuste_estoque").submit(function (e) {
    e.preventDefault()
    var formulario = $(this);

    Swal.fire({
        title: 'Tem certeza?',
        text: "Deseja adicionar esse ajuste",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Não',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim'
    }).then((result) => {
        if (result.isConfirmed) {
            var retorno = create(formulario,codigo_nf)
        }
    })
})


function create(dados,codigo_nf) {
    $.ajax({
        type: "POST",
        data: "fomulario_ajuste_estoque=true&acao=create&" + dados.serialize(),
        url: "modal/estoque/ajuste_estoque/gerenciar_ajuste_estoque.php",
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
            tabela_produtos(codigo_nf)
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

function tabela_produtos(codigo_nf) {//tabela de produtos
    $.ajax({
        type: 'GET',
        data: "consultar_ajst_produtos=true&codigo_nf=" + codigo_nf,
        url: "view/estoque/ajuste_estoque/table/tabela_ajst.php",
        success: function (result) {
            return $(".tabela_externa").html(result)
        },
    })
}

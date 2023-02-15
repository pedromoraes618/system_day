//voltar para tela de cadastro
$("#voltar_cadastro").click(function(e) {
    // $('.tabela').css("display", 'none')
    // $('.tabela').fadeIn(500)

    $.ajax({
        type: 'GET',
        data: "cadastro_subgrupo=true",
        url: "view/estoque/subgrupo_estoque/cadastro_subgrupo_estoque.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1").html(result);
        },
    });
})

//editar
$("#editar_subgrupo_estoque").submit(function(e) {
    e.preventDefault()
    var formulario = $(this);
    var retorno = editar_subgrupo(formulario)
})

function editar_subgrupo(dados) {
 
    $.ajax({
        type: "POST",
        data: dados.serialize(),
        url: "modal/estoque/subgrupo_estoque/gerenciar_subgrupo_estoque.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $sucesso = $.parseJSON(data)["sucesso"];
        $mensagem = $.parseJSON(data)["mensagem"];
        if ($sucesso) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Subgrupo alterado com sucesso',
                showConfirmButton: false,
                timer: 1500

            })
              //recarregar tabela
        $.ajax({
            type: 'GET',
            data: "consultar_subgrupo=inicial",
            url: "view/estoque/subgrupo_estoque/table/consultar_subgrupo_estoque.php",
            success: function(result) {
                return $(".bloco-pesquisa-2 .tabela").html(result);
            },
        });

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Verifique!',
                text: $mensagem,
                timer: 7500,
            
            })

        }
    }

    function falha() {
        console.log("erro");
    }

}d
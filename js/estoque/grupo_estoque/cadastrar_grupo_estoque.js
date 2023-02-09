$("#cadastrar_grupo_estoque").submit(function(e) {
    e.preventDefault()
    var cadastrar = $(this);
    var retorno = cadastrar_grupo(cadastrar)
    var descricao = document.getElementById("descricao")

})

function cadastrar_grupo(dados) {
    $.ajax({
        type: "POST",
        data: dados.serialize(),
        url: "modal/estoque/grupo_estoque/gerenciar_grupo_estoque.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $sucesso = $.parseJSON(data)["sucesso"];
        $mensagem = $.parseJSON(data)["mensagem"];
        if ($sucesso) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Grupo cadastrado com sucesso',
                showConfirmButton: false,
                timer: 1500
            })
            //resetar valores de input
            descricao.value = "";

        //consultar informação tabela
        $.ajax({
            type: 'GET',
            data: "consultar_grupo=inicial",
            url: "view/estoque/grupo_estoque/table/consultar_grupo_estoque.php",
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

}
//resetar senha
$("#resetar_senha").click(function(e) {
    $('.bloco-pesquisa-menu .bloco-pesquisa-1').css("display", 'none')
    $('.bloco-pesquisa-menu .bloco-pesquisa-1').fadeIn(200)
    let id_user = $(this).attr("id_user")
    $.ajax({
        type: 'GET',
        data: "resetar_senha=true&id_user=" + id_user,
        url: "view/configuracao/users/resetar_senha.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1").html(result);
        },
    });

})

//voltar para tela de cadastro
$("#voltar_cadastro").click(function(e) {
    $('.bloco-pesquisa-menu .bloco-pesquisa-1').css("display", 'none')
    $('.bloco-pesquisa-menu .bloco-pesquisa-1').fadeIn(200)

    $.ajax({
        type: 'GET',
        data: "cadastrar=",
        url: "view/configuracao/users/cadastrar_user.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1").html(result);
        },
    });
})

//editar usuario
$("#editar_usuario").submit(function(e) {
    e.preventDefault()
    var editar_user = $(this);
    var retorno = editar_usuario(editar_user)


})

function editar_usuario(dados) {
    $.ajax({
        type: "POST",
        data: dados.serialize(),
        url: "modal/configuracao/users/usuario.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
        $sucesso = $.parseJSON(data)["sucesso"];
        $mensagem = $.parseJSON(data)["mensagem"];
        if ($sucesso) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Usúario alterado com sucesso',
                showConfirmButton: false,
                timer: 1500


            })
            //consultar inicial
            $.ajax({
                type: 'GET',
                data: "consultar_user=inicial",
                url: "view/configuracao/users/table/consultar_user.php",
                success: function(result) {
                    return $(".tabela").html(result);
                },
            });

        } else {
            Swal.fire({
                icon: 'error',
                title: $mensagem,

            })

        }
    }

    function falha() {
        console.log("erro");
    }

}
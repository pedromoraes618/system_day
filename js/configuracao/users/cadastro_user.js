$("#cadastrar_usuario").submit(function(e) {

    e.preventDefault()
    var cadastrar_user = $(this);
    var retorno = cadastrar_usuario(cadastrar_user)

    var nome = document.getElementById("nome")
    var usuario = document.getElementById("usuario")
    var senha = document.getElementById("senha")
    var confirmar_senha = document.getElementById("confirmar_senha")
    var perfil = document.getElementById("perfil")
    var situacao = document.getElementById("situacao")
})

function cadastrar_usuario(dados) {
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
                title: 'Usúario cadastrado com sucesso',
                showConfirmButton: false,
                timer: 1500
            })
            //resetavar valores de input
            nome.value = "";
            usuario.value = "";
            senha.value = "";
            confirmar_senha.value = "";
            perfil.value = "0";
            situacao.value = "s";


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
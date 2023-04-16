$(document).ready(function () {
    var id_user_logado = document.getElementById('id_user_logado').value
    show(id_user_logado)
})

$("#open_upload_img_user").click(function () {

    $.ajax({
        type: 'GET',
        data: "upload_img_user=true",
        url: "view/configuracao/meu_usuario/modal_upload_img.php",
        success: function (result) {
            return $(".acao .modal_show").html(result) + $("#modal_upload_img_user").modal('show');

        },
    });
})

//retornar as informações
function show(id) {
    $.ajax({
        type: "POST",
        data: "consultar_meu_user=true&acao=show&id_user=" + id,
        url: "modal/configuracao/meu_usuario/gerenciar_usuario.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            $('.bg-img-user').attr({
                'style': 'background-image: url("img/usuario/' + $dados.valores['img'] + '")',
            });
            $(".descricao_nome").html($dados.valores['nome'])
            $(".descricao_user").html($dados.valores['usuario'])
            $(".descricao_tipo").html($dados.valores['tipo_usuario'])
            $(".descricao_email").html($dados.valores['email'])

        }
    }

    function falha() {
        console.log("erro");
    }

}



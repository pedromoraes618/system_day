<?php 
include "../../../modal/configuracao/users/usuario.php";
?>
<form id="editar_usuario">
    <div class="acao">
        <div class="title">
            <label class="form-label">Editar Usúario</label>
        </div>
        <hr>
        <div class="row">
            <input type="hidden" name="formulario_editar_usuario">
            <?php include "../../input_include/usuario_logado.php"?>

            <input type="hidden" value="<?php echo $id_user; ?>" name="id_user">
            <div class="col-sm  mb-1">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder=""
                    value="<?php echo $nome_b ?>">
            </div>
            <div class="col-sm  mb-1">
                <label for="usuario" class="form-label">Usúario</label>
                <input type="text" readonly  class="form-control" id="usuario" name="usuario" placeholder=""
                    value="<?php echo $usuario_b; ?>">
            </div>
            <div class="col-sm mb-1">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" disabled class="form-control" id="senha" name="senha" placeholder=""
                    value="<?php echo $senha_b; ?>">
            </div>

            <div class="col-sm  mb-1">
                <label for="perfil" class="form-label">Perfil</label>
                <select name="perfil" id="perfil" class="form-select">
                    <option value="0">Selecione...</option>
                    <option <?php if($perfil_b == "adm"){echo "selected";} ?> value="adm">Adminstrador</option>
                    <option <?php if($perfil_b == "usuario"){echo "selected";} ?> value="usuario">Usúario</option>
                </select>
            </div>
            <div class="col-sm  mb-1">
                <label for="situacao" class="form-label">Situação</label>
                <select name="situacao" class="form-select" id="situacao">
                    <option value="s">Selecione...</option>
                    <option <?php if($situacao_b == 1){echo "selected";} ?> value="1">Ativo</option>
                    <option <?php if($situacao_b == 0){echo "selected";} ?> value="0">Inativo</option>
                </select>
            </div>
            <div class="group-btn d-grid gap-2 d-sm-block">
                <button type="subbmit" class="btn btn-outline-success">Alterar</button>
                <button type="button" id_user=<?php echo $id_user; ?> id="resetar_senha"
                    class="btn btn-outline-warning">Resetar senha</button>
                <button type="button" id="voltar_cadastro" class="btn btn-outline-dark">Voltar Para Cadastro</button>
            </div>
        </div>

    </div>
</form>


<script src="js/funcao.js"></script>
<script src="js/configuracao/users/user_logado.js"></script>
<script>
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
            //recarregar a tabela de usúarios
            $.ajax({
                type: 'GET',
                data: "consultar_user=",
                url: "view/configuracao/users/consultar_user.php",
                success: function(result) {
                    return $(".bloco-pesquisa-menu .bloco-pesquisa-2").html(result);
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
</script>
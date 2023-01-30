<?php 
include "../../../modal/configuracao/users/usuario.php";
?>
<form id="resetar_senha_usuario">
    <div class="acao">
        <div class="title">
            <label class="form-label">Resetar Senha</label>
        </div>
        <hr>
        <div class="row">
            <input type="hidden" name="formulario_resetar_senha_usuario">
            <?php include "../../input_include/usuario_logado.php"?>
            <input type="hidden" value="<?php echo $id_user; ?>" name="id_user">
        
            <div class="col-sm-3  mb-1">
                <label for="usuario" class="form-label">Usúario</label>
                <input type="text" readonly class="form-control" id="usuario" name="usuario" placeholder=""
                    value="<?php echo $usuario_b; ?>">
            </div>
            <div class="col-sm-3 mb-1">
                <label for="senha" class="form-label">Nova Senha</label>
                <input type="text"  class="form-control" id="senha" name="senha" placeholder=""
                    value="">
            </div>
            <div class="col-sm-3 mb-1">
                <label for="senha" class="form-label">Confirmar senha</label>
                <input type="text"  class="form-control" id="confirmar_senha" name="confirmar_senha" placeholder=""
                    value="">
            </div>

    
    
            <div class="group-btn d-grid gap-2 d-sm-block">
                <button type="subbmit" class="btn btn-outline-success">Alterar senha</button>
                <button type="button" id="voltar_cadastro" class="btn btn-outline-dark">Voltar Para Cadastro</button>
            </div>
        </div>

    </div>
</form>

<script src="js/configuracao/users/user_logado.js"></script>
<script>
$("#voltar_cadastro").click(function(e) {
    $('.bloco-pesquisa-menu.bloco-pesquisa-1').css("display", 'none')
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
$("#resetar_senha_usuario").submit(function(e) {

    e.preventDefault()
    var resetar_senha = $(this);
    var retorno = resetar_senha_usuario(resetar_senha)

})

function resetar_senha_usuario(dados) {
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
                title: 'Senha resetada com sucesso',
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
</script>
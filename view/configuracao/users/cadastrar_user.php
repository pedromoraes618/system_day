<form id="cadastrar_usuario">
    <div class="acao">
        <div class="title">
            <label class="form-label">Cadastrar Usúario</label>
        </div>
        <hr>
        <div class="row">
            <input type="hidden" name="formulario_cadastrar_usuario">
            
            <?php include "../../input_include/usuario_logado.php"?>

            <div class="col-sm  mb-1">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="" value="">
            </div>
            <div class="col-sm  mb-1">
                <label for="usuario" class="form-label">Usúario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="" value="">
            </div>
            <div class="col-sm mb-1">
                <label for="senha" class="form-label">Senha</label>
                <input type="text" class="form-control" id="senha" name="senha" placeholder="" value="">
            </div>
            <div class="col-sm  mb-1">
                <label for="nome" class="form-label">Confirma senha</label>
                <input type="text" class="form-control" id="confirmar_senha" name="confirmar_senha" placeholder=""
                    value="">
            </div>
            <div class="col-sm  mb-1">
                <label for="perfil" class="form-label">Perfil</label>
                <select name="perfil" id="perfil" class="form-select">
                    <option value="0">Selecione...</option>
                    <option value="adm">Adminstrador</option>
                    <option value="usuario">Usúario</option>
                </select>
            </div>
            <div class="col-sm  mb-1">
                <label for="situacao" class="form-label">Situação</label>
                <select name="situacao" class="form-select" id="situacao">
                    <option value="s">Selecione...</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                </select>
            </div>
            <div class="group-btn">
                <button type="subbmit" class="btn btn-success">Cadastrar</button>
            </div>
        </div>

    </div>
</form>

<script src="js/funcao.js"></script>
<script src="js/configuracao/users/user_logado.js"></script>
<script>


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
                data: "consultar_incial=true",
                url: "view/configuracao/users/table/consultar_inicial_user.php",
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
<form id="cadastrar_usuario">
    <div class="acao">
        <div class="title">
            <label class="form-label">Cadastrar Usúario</label>
            <div class="msg_title">
                <p>Esse menu tem como função o gerênciamento de usúarios. Cadastrar, editar, resetar senha e inativar usúario e feito aqui ! </p>
            </div>
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
<script src="js/configuracao/users/cadastro_user.js"></script>
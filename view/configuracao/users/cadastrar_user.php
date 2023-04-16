<form id="cadastrar_usuario">
    <div class="acao">
        <div class="title">
            <label class="form-label">Cadastrar Usúario</label>
            <div class="msg_title">
                <p>Esse menu tem como função o gerênciamento de usúarios. Cadastrar, editar, resetar senha e inativar usúario. </p>
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <input type="hidden" name="formulario_cadastrar_usuario">

            <?php include "../../input_include/usuario_logado.php" ?>

            <div class="col-md-3 mb-2">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="" value="">
            </div>
            <div class="col-md-3  mb-2">
                <label for="usuario" class="form-label">Usúario</label>
                <input type="text" class="form-control inputUser" id="usuario" name="usuario" autocomplete="off" placeholder="Apenas letras, números e símbolos" value="">
            </div>
            <div class="col-md-3 mb-2">
                <label for="senha" class="form-label">Senha</label>
                <input type="text" class="form-control inputUser" id="senha" name="senha" autocomplete="off" placeholder="Apenas letras, números e símbolos" value="">
            </div>
            <div class="col-md-3  mb-2">
                <label for="nome" class="form-label">Confirma senha</label>
                <input type="text" class="form-control inputUser" id="confirmar_senha" autocomplete="off" name="confirmar_senha" placeholder="Apenas letras, números e símbolos" value="">
            </div>
            <div class="col-md-3  mb-2">
                <label for="perfil" class="form-label">Perfil</label>
                <select name="perfil" id="perfil" class="form-select">
                    <option value="0">Selecione...</option>
                    <option value="adm">Adminstrador</option>
                    <option value="usuario">Usúario</option>

                </select>
            </div>
            <div class="col-md-3  mb-1">
                <label for="situacao" class="form-label">Situação</label>
                <select name="situacao" class="form-select" id="situacao">
                    <option value="s">Selecione...</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                </select>
            </div>
            <div class="col-md  mb-1">
                <label for="nome" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" autocomplete="off" name="email" value="">
            </div>

        </div>
        <div class="row">
            <div class="col-md-4  d-grid gap-2 d-sm-block mb-1  ">
                <button type="subbmit" class="btn btn-success">Cadastrar</button>
            </div>
        </div>

    </div>
</form>

<script src="js/funcao.js"></script>
<script src="js/configuracao/users/user_logado.js"></script>
<script src="js/configuracao/users/cadastro_user.js"></script>
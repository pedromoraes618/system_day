<?php
include "../../../modal/configuracao/users/usuario.php";
?>
<form id="editar_usuario">
    <div class="acao">
        <div class="title">
            <label class="form-label">Editar Usúario</label>
            <div class="msg_title">
                <p>Esse menu tem como função o gerênciamento de usúarios. Cadastrar, editar, resetar senha e inativar
                    usúario. </p>
            </div>
        </div>
        <hr>
        <div class="row mb-2">
            <input type="hidden" name="formulario_editar_usuario">
            <?php include "../../input_include/usuario_logado.php" ?>

            <input type="hidden" value="<?php echo $id_user; ?>" name="id_user">
            <div class="col-sm  mb-1">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="" value="<?php echo $nome_b ?>">
            </div>
            <div class="col-sm  mb-1">
                <label for="usuario" class="form-label">Usúario</label>
                <input type="text" readonly class="form-control inputUser" id="usuario" name="usuario" placeholder="Apenas letras e números" value="<?php echo $usuario_b; ?>">
            </div>

            <div class="col-sm  mb-1">
                <label for="perfil" class="form-label">Perfil</label>
                <select name="perfil" id="perfil" class="form-select">
                    <option value="0">Selecione...</option>
                    <option <?php if ($perfil_b == "adm") {
                                echo "selected";
                            } ?> value="adm">Adminstrador</option>
                    <option <?php if ($perfil_b == "usuario") {
                                echo "selected";
                            } ?> value="usuario">Usúario</option>

                </select>
            </div>
            <div class="col-sm  mb-2">
                <label for="situacao" class="form-label">Situação</label>
                <select name="situacao" class="form-select" id="situacao">
                    <option value="s">Selecione...</option>
                    <option <?php if ($situacao_b == 1) {
                                echo "selected";
                            } ?> value="1">Ativo</option>
                    <option <?php if ($situacao_b == 0) {
                                echo "selected";
                            } ?> value="0">Inativo</option>
                </select>
            </div>


        </div>
        <div class="row mb-2">
            <div class="col-md-4  mb-1">
                <label for="nome" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" autocomplete="off" name="email" value="<?php echo $email_b ?>">
            </div>
        </div>
        <div class="row">
            <div class="group-btn d-grid gap-2 d-sm-block">
                <button type="subbmit" class="btn btn-outline-success">Alterar</button>
                <button type="button" id_user=<?php echo $id_user; ?> id="resetar_senha" class="btn btn-outline-warning">Resetar senha</button>
                <button type="button" id="voltar_cadastro" class="btn btn-outline-dark">Voltar Para Cadastro</button>
            </div>
        </div>
    </div>
</form>


<script src="js/funcao.js"></script>
<script src="js/configuracao/users/user_logado.js"></script>
<script src="js/configuracao/users/editar_user.js"></script>
<?php 
include "../../../modal/suporte/serie/gerenciar_serie.php"; // trazer as informações da categoria
?>

<div class="title">
    <label class="form-label">Editar Serie</label>
    <div class="msg_title">
        <p>Edite as series </p>
    </div>
</div>
<hr>
<form id="editar_serie">
    <div class="row">
        <input type="hidden" name="formulario_editar_serie">

        <?php include "../../input_include/usuario_logado.php"?>

        <input type="hidden" value="<?php echo $id_serie; ?>" name="id_serie">

        <div class="col-sm-6 col-md mb-2">
            <label for="descricao"  class="form-label">Descrição</label>
            <input type="text" disabled class="form-control" id="descricao" name="descricao" placeholder="" value="<?php echo $descricao_b ?>">
        </div>
        <div class="col-sm-6 col-md mb-2">
            <label for="descricao" class="form-label">Valor</label>
            <input type="text" class="form-control" id="valor" name="valor" placeholder="" value="<?php echo $valor_b ?>">
        </div>
        <div class="col-sm-6 col-md mb-2">
            <label for="informacao" class="form-label">Informação</label>
            <input type="text" class="form-control" id="informacao" name="informacao" placeholder="" value="<?php echo $informacao_b; ?>">
        </div>

        <div class="group-btn d-grid gap-2 d-sm-block">
            <button type="subbmit" class="btn btn-outline-success">Alterar</button>
            <button type="button" id="voltar_cadastro" class="btn btn-outline-dark">Voltar Para Cadastro</button>
        </div>
    </div>


</form>

<script src="js/configuracao/users/user_logado.js"></script>

<script src="js/suporte/serie/editar_serie.js"></script>
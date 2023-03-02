<?php 
include "../../../modal/estoque/grupo_estoque/gerenciar_grupo_estoque.php"; // trazer as informações da categoria
?>

<div class="title">
    <label class="form-label">Editar grupo estoque</label>
    <div class="msg_title">
        <p>Edite os grupos de estoque </p>
    </div>
</div>
<hr>
<form id="editar_grupo_estoque">
    <div class="row">
        <input type="hidden" name="formulario_editar_grupo_estoque">

        <?php include "../../input_include/usuario_logado.php"?>

        <input type="hidden" value="<?php echo $id_grupo; ?>" id="id_grupo" name="id_grupo">
        <div class="col-sm  mb-2"> 
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" placeholder=""
                value="<?php echo $descricao_b; ?>">
        </div>
   

        <div class="group-btn d-grid gap-2 d-sm-block">
            <button type="subbmit" class="btn btn-outline-success">Alterar</button>
            <button type="button" id="remover" class="btn btn-outline-danger">Remover</button>
            <button type="button" id="voltar_cadastro" class="btn btn-outline-dark">Voltar Para Cadastro</button>
        </div>
    </div>


</form>

<script src="js/configuracao/users/user_logado.js"></script>

<script src="js/estoque/grupo_estoque/editar_grupo_estoque.js"></script>
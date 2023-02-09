<?php  include "../../../conexao/conexao.php"; ?>
<?php include "../../../modal/estoque/subgrupo_estoque/gerenciar_subgrupo_estoque.php";  
?>


<div class="title">
    <label class="form-label">Cadastrar Subcategoria estoque</label>
    <div class="msg_title">
        <p>Cadastrar subcategoria de estoque </p>
    </div>
</div>
<hr>
<form id="cadastrar_subgrupo_estoque">
    <div class="row">
        <input type="hidden" name="formulario_cadastrar_subgrupo_estoque">
        <?php include "../../input_include/usuario_logado.php"?>
        <div class="col-sm  mb-2">
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" placeholder="" value="">
        </div>

        <div class="group-btn">
            <button type="subbmit" class="btn btn-success">Cadastrar</button>
        </div>
    </div>


</form>

<script src="js/configuracao/users/user_logado.js"></script>

<script src="js/suporte/parametro/cadastrar_parametro.js"></script>
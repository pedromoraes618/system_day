<?php  include "../../../conexao/conexao.php"; ?>
<?php include "../../../modal/estoque/grupo_estoque/gerenciar_grupo_estoque.php";  
?>


<div class="title">
    <label class="form-label">Cadastrar Fabricante</label>
    <div class="msg_title">
        <p>Registre aqui os fabricantes dos seus produtos e ofereça qualidade e confiança aos seus clientes. </p>
    </div>
</div>
<hr>
<form id="cadastrar_fabricante">
    <div class="row">
        <input type="hidden" name="formulario_cadastrar_fabricante">
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

<script src="js/estoque/fabricante/cadastrar_fabricante.js"></script>
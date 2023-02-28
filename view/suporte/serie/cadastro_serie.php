<?php  include "../../../conexao/conexao.php"; ?>
<?php include "../../../modal/suporte/serie/gerenciar_serie.php";  
?>


<div class="title">
    <label class="form-label">Cadastrar Serie</label>
    <div class="msg_title">
        <p>Cadastrar Serie </p>
    </div>
</div>
<hr>
<form id="cadastrar_serie">
    <div class="row mb-2">
        <input type="hidden" name="formulario_cadastrar_serie">
        <?php include "../../input_include/usuario_logado.php"?>
        <div class="col-sm-6 col-md mb-2">
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" placeholder="" value="">
        </div>
        <div class="col-sm-6 col-md mb-2">
            <label for="descricao" class="form-label">Valor</label>
            <input type="text" class="form-control" id="valor" name="valor" placeholder="" value="">
        </div>

        <div class="group-btn d-grid gap-2 d-sm-block">
            <button type="subbmit" class="btn btn-success">Cadastrar</button>
        </div>
    </div>


</form>

<script src="js/configuracao/users/user_logado.js"></script>

<script src="js/suporte/serie/cadastrar_serie.js"></script>
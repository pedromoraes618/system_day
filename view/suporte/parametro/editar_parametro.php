<?php 
include "../../../modal/suporte/parametro/gerenciar_parametro.php"; // trazer as informações da categoria
?>

<div class="title">
    <label class="form-label">Editar parâmetro</label>
    <div class="msg_title">
        <p>Os parâmetros configuráveis permitem ajustar e personalizar o comportamento de um sistema sem alterar o
            código-fonte. </p>
    </div>
</div>
<hr>
<form id="editar_parametro">
    <div class="row">
        <input type="hidden" name="formulario_editar_parametro">

        <?php include "../../input_include/usuario_logado.php"?>

        <input type="hidden" value="<?php echo $id_parametro; ?>" name="id_parametro">
        <div class="col-sm col-md-7 mb-2">
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" placeholder=""
                value="<?php echo $descricao_b; ?>">
        </div>
        <div class="col-sm  mb-2">
            <label for="valor" class="form-label">Valor</label>
            <input type="text" class="form-control" id="valor" name="valor" placeholder=""
                value="<?php echo $valor_b; ?>">
        </div>
        <div class="col-sm  mb-2">
            <label for="configuracao" class="form-label">Configuração de Parametro</label>
            <select name="configuracao" id="configuracao" class="form-select">
                <option value="0">Selecione...</option>
                <option <?php if($configuracao_b =="seguranca"){echo "selected";} ?> value="seguranca">Segurança
                </option>
                <option <?php if($configuracao_b == "performance" ){echo "selected";} ?> value="performance">Performance
                </option>
                <option <?php if($configuracao_b == "usuario" ){echo "selected";} ?> value="usuario">Usuário
                </option>
                <option <?php if($configuracao_b =="interface"){echo "selected";} ?> value="interface">Interface</option>
            </select>
        </div>

        <div class="group-btn d-grid gap-2 d-sm-block">
            <button type="subbmit" class="btn btn-outline-success">Alterar</button>
            <button type="button" id="voltar_cadastro" class="btn btn-outline-dark">Voltar Para Cadastro</button>
        </div>
    </div>


</form>

<script src="js/configuracao/users/user_logado.js"></script>

<script src="js/suporte/parametro/editar_parametro.js"></script>
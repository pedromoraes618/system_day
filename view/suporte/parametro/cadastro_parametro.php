<div class="title">
    <label class="form-label">Cadastrar parâmetros</label>
    <div class="msg_title">
        <p>Os parâmetros configuráveis permitem ajustar e personalizar o comportamento de um sistema sem alterar o
            código-fonte. </p>
    </div>
</div>
<hr>
<form id="cadastrar_parametro">
    <div class="row">
        <input type="hidden" name="formulario_cadastrar_parametro">

        <?php include "../../input_include/usuario_logado.php"?>

        <div class="col-sm col-md-7 mb-2">
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" placeholder="" value="">
        </div>
        <div class="col-sm  mb-2">
            <label for="valor" class="form-label">Valor</label>
            <input type="text" class="form-control" id="valor" name="valor" placeholder="" value="">
        </div>
        <div class="col-sm  mb-2">
            <label for="configuracao" class="form-label">Configuração de Parametro</label>
            <select name="configuracao" id="configuracao" class="form-select">
                <option value="0">Selecione...</option>
                <option value="seguranca">Segurança</option>
                <option value="performance">Performance</option>
                <option value="usuario">Usuário</option>
                <option value="interface">Interface</option>
            </select>
        </div>
      
    </div>
    <div class="row">
        <div class="group-btn d-grid gap-2 d-sm-block">
            <button type="subbmit" class="btn btn-success">Cadastrar</button>
        </div>
    </div>


</form>

<script src="js/configuracao/users/user_logado.js"></script>

<script src="js/suporte/parametro/cadastrar_parametro.js"></script>
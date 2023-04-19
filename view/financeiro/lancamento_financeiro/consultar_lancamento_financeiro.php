<?php
include "../../../funcao/funcao.php";
?>
<div class="title">
    <label class="form-label">Consultar Lançamentos financeiros</label>
</div>
<hr>
<div class="row">
    <div class="row">
        <div class="col-sm-4 col-auto  mb-2">
            <div class="input-group">
                <span class="input-group-text">Dt. vencimento</span>
                <input type="text" class="form-control" maxlength="10" onkeyup="mascaraData(this);" id="data_inicial" name="data_incial" title="Data vencimento" placeholder="Data Inicial" value="<?php echo $data_inicial ?>">
                <input type="text" class="form-control" maxlength="10" onkeyup="mascaraData(this);" id="data_final" name="data_final" title="Data vencimento" placeholder="Data Final" value="<?php echo $data_final; ?>">
            </div>
        </div>


        <div class="col-md mb-2">
            <select name="status" class="form-select" id="status_lancamento">
                <option value="0">Status Lançamento..</option>

            </select>
        </div>
        <div class="col-md mb-2">
            <select name="status" class="form-select" id="classificao_financeiro">
                <option value="0">Classificação</option>

            </select>
        </div>
        <div class="col-md mb-2">
            <select name="status" class="form-select" id="tipo_lancamento">
                <option value="0">Tipo de lançamento..</option>
                <option value="RECEITA">Receita</option>
                <option value="DESPESA">Despesa</option>
            </select>
        </div>


    </div>
    <div class="row">
        <div class="col-md  mb-2">
            <div class="input-group">
                <input type="text" class="form-control" id="pesquisa_conteudo" placeholder="Tente pesquisar pela descrição ou número de documento" aria-label="Recipient's username" aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary" type="button" id="pesquisar_filtro_pesquisa">Pesquisar</button>
            </div>
        </Div>
        <div class="col-md-auto  d-grid gap-2 d-sm-block mb-2">
            <button type="button" id="adicionar_lancamento_financeiro" class="btn btn-dark" data-bs-toggle="modal">
                Adicionar Lançamento
            </button>
        </div>
    </div>

</div>
<div class="tabela">

</div>
<div class="modal_show">

</div>


<script src="js/financeiro/lancamento_financeiro/consultar_lancamento_financeiro.js"></script>

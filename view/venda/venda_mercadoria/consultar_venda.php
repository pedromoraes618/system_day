<?php
include "../../../funcao/funcao.php";
?>
<div class="title">
    <label class="form-label">Consultar Vendas</label>
</div>
<hr>
<div class="row">
    <div class="row mb-2">
        <div class="col-sm-4  mb-2">
            <div class="input-group">
                <span class="input-group-text">Dt. Venda</span>
                <input type="text" class="form-control inputNumber" maxlength="10" onkeyup="mascaraData(this);" id="data_inicial" name="data_incial" title="Data vencimento" placeholder="Data Inicial" value="<?php echo $data_inicial ?>">
                <input type="text" class="form-control inputNumber" maxlength="10" onkeyup="mascaraData(this);" id="data_final" name="data_final" title="Data vencimento" placeholder="Data Final" value="<?php echo $data_final; ?>">
            </div>
        </div>


        <div class="col-md-2 mb-2">
            <select name="status_recebimento" class="form-select" id="status_recebimento">
                <option value="0">Status Recebimento</option>
                <option value="1">Pendente</option>
                <option value="2">Recebido</option>
            </select>
        </div>

        <div class="col-md  mb-2">
            <div class="input-group">
                <input type="text" class="form-control" id="pesquisa_conteudo" placeholder="Tente pesquisar pelo Nº da venda ou cliente" aria-label="Recipient's username" aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary" type="button" id="pesquisar_filtro_pesquisa">Pesquisar</button>
            </div>
        </Div>
        <div class="col-md-auto  d-grid gap-2 d-sm-block mb-2">
            <button type="button" id="adicionar_venda" class="btn btn-dark">Adicionar Venda</button>

        </div>
    </div>

</div>
<div class="tabela">

</div>
<div class="modal_show">

</div>

<?php include '../../../funcao/funcaojavascript.jar'; ?>
<script src="js/funcao.js"></script>
<script src="js/venda/venda_mercadoria/consultar_venda.js"></script>
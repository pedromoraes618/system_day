<?php
include "../../../funcao/funcao.php";
?>
<div class="title">
    <label class="form-label">Consultar Cotação</label>
</div>
<hr>
<div class="row">
    <div class="row">
        <div class="col-sm-4    mb-2">
            <div class="input-group">
                <span class="input-group-text">Dt. Cotação</span>
                <input type="text" class="form-control inputNumber " maxlength="10" onkeyup="mascaraData(this);" id="data_inicial" name="data_incial"  placeholder="Data Inicial" value="<?php echo $data_inicial ?>">
                <input type="text" class="form-control inputNumber" maxlength="10" onkeyup="mascaraData(this);" id="data_final" name="data_final"  placeholder="Data Final" value="<?php echo $data_final; ?>">
            </div>
        </div>


        <div class="col-md-2 mb-2">
            <select name="status" class="form-select" id="status">
                <option value="0">Status</option>

            </select>
        </div>

        <div class="col-md  mb-2">
            <div class="input-group">
                <input type="text" class="form-control" id="pesquisa_conteudo" placeholder="Pesquise pelo Nº da cotação ou cliente" aria-label="Recipient's username" aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary" type="button" id="pesquisar_filtro_pesquisa">Pesquisar</button>
            </div>
        </Div>
        <div class="col-md-auto  d-grid gap-2 d-sm-block mb-2">
            <button type="button" id="adicionar_cotacao" class="btn btn-dark">Adicionar Cotação</button>

        </div>
    </div>

</div>
<div class="tabela">

</div>
<div class="modal_show">

</div>

<?php include '../../../funcao/funcaojavascript.jar'; ?>
<script src="js/funcao.js"></script>
<script src="js/venda/cotacao_mercadoria/consultar_cotacao.js"></script>
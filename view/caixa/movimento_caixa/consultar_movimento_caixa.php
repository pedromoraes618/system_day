<?php
include "../../../conexao/conexao.php";
include "../../../modal/caixa/movimento_caixa/gerenciar_movimento_caixa.php";
include "../../../funcao/funcao.php";
?>
<div class="title">
    <label class="form-label">Movimento do caixa</label>
</div>
<hr>
<div class="row mb-2">
    <div class="col-auto mb-2">
        <div class="input-group">
            <span class="input-group-text">Dada do movimento</span>
            <input type="text" class="form-control inputNumber" maxlength="10" onkeyup="mascaraData(this);" id="data_inicial" name="data_incial" title="Data vencimento" placeholder="Data Inicial" value="<?php echo $data_final ?>">
            <input type="text" class="form-control inputNumber" maxlength="10" onkeyup="mascaraData(this);" id="data_final" name="data_final" title="Data vencimento" placeholder="Data Final" value="<?php echo $data_final; ?>">
        </div>
    </div>

    <div class="col-md-auto  d-grid gap-2 d-sm-block mb-2">
        <button class="btn btn-outline-success" id="resumo">Resumo</button>
        <button class="btn btn-outline-success" id="venda_fpg">Vendas forma pagamento</button>
        <button nclick="capturarTela()" class="btn btn-default" type="button">Imprimir</button>
    </div>


</div>

<div class="tabela print">

</div>
<script src="js/funcao.js"></script>
<script src="js/caixa/movimento_caixa/consultar_movimento_caixa.js"></script>

<?php include '../../../funcao/funcaojavascript.jar'; ?>
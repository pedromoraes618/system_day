<?php
include "../../../conexao/conexao.php";  
include "../../../modal/estoque/kardex/gerenciar_kardex.php";  
include "../../../funcao/funcao.php" 
?>

<div class="title">
    <label class="form-label">Kardex</label>
</div>
<hr>
<div class="row mb-3">
    <div class="col-md">
        <label class="label_box">Histórico: <?php echo $descricao_b; ?></label>
    </div>
</div>
<div class="row">
    <input type="hidden" id="id_produto" value="<?php echo $id_produto; ?>">
    <!-- <div class="col-md-2  mb-1">
        <input type="text" class="form-control" maxlength="10" onkeyup="mascaraData(this);" id="data_inicial"
            name="data_incial" placeholder="Data inicial" value="<?php // echo $data_inicial ?>">
    </div>
    <div class="col-auto">Até</div>
    <div class="col-md-2  mb-1">
        <input type="text" class="form-control" maxlength="10" onkeyup="mascaraData(this);" id="data_final"
            name="data_final" placeholder="Data Final" value="<?php //echo $data_final;?>">
    </div> -->


    <div class="col-md-4  d-grid gap-2 d-sm-block mb-1 ">
        <!-- <button type="subbmit" class="btn btn-outline-secondary">Pesquisar</button> -->
        <button type="button" id="voltar_consulta" class="btn btn-outline-secondary col-md-8">Voltar</button>
    </div>
</div>

<div class="alerta">

</div>
<div class="tabela">

</div>


<script src="js/estoque/kardex/gerenciar_kardex.js">
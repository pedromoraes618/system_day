<?php
include "../../../conexao/conexao.php";
include "../../../modal/financeiro/extrato_financeiro/gerenciar_extrato_financeiro.php";
include "../../../funcao/funcao.php";
?>
<div class="title">
    <label class="form-label">Extrato financeiro</label>
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
    <div class="col-md-auto mb-2">
      
        <select name="conta_financeira" class="form-control" id="conta_financeira">
            <option value="0">Selecione a conta financeira..</option>
            <?php 
            while($linha = mysqli_fetch_assoc($consultar_conta_financeira)){
                $descricao = utf8_encode($linha['cl_banco']);
                $conta = $linha['cl_conta'];
                echo "<option value='$conta'>$descricao</option>";
            }
            ?>
        </select>
  
    </div>

    <div class="col-md-auto  d-grid gap-2 d-sm-block mb-2">
        <button class="btn btn-dark" id="consultar">Consultar</button>
        <button class="btn btn-dark" type="button">Imprimir</button>
    </div>


</div>

<div class="tabela  print ">

</div>
<?php include '../../../funcao/funcaojavascript.jar'; ?>
<script src="js/funcao.js"></script>
<script src="js/financeiro/extrato_financeiro/consultar_extrato_financeiro.js"></script>

<?php

include "../../../conexao/conexao.php";
include "../../../modal/recebimento_nf/nf_saida/gerenciar_recebimento.php";
include "../../../funcao/funcao.php";
if (isset($_GET['recebimento_nf'])) {
    $tipo = $_GET['tipo'];
    $id_nf = $_GET['nf_id'];
}
?>
<div class="modal fade" id="modal_recebimento_nf" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Recebimento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" id="fechar_modal_recebimento" aria-label="Close"></button>
            </div>
            <form action="" id="recebimento_nf">
                <?php include "../../input_include/usuario_logado.php" ?>
                <div class="modal-body">
                    <div class="row  mb-2">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                            <button type="submit" id="iniciar_venda" class="btn btn-sm btn-success">Salvar</button>
                            <button type="button" class="btn btn-sm btn-secondary" id="fechar_modal_recebimento" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-2 mb-2">
                            <label for="quantidade" class="form-label">Número</label>
                            <input type="text" class="form-control" disabled id="numero_nf" value="">
                            <input type="hidden" class="form-control" name="nf_id" id="nf_id" value="<?php echo $id_nf; ?>">
                        </div>

                        <div class="col-md mb-2">
                            <label for="vlr_liquido" class="form-label">Valor liquido</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="text" class="form-control" disabled name="valor_liquido" id="valor_liquido" value="">
                            </div>
                        </div>
                        <div class="col-md mb-2">
                            <label for="vlr_liquido" class="form-label">Forma pagamento</label>
                            <select name="forma_pagamento" class="form-control" id="forma_pagamento">
                                <option value="0">Selecione</option>
                                <?php
                                while ($linha = mysqli_fetch_assoc($consultar_forma_pagamento_2)) {
                                    $id = utf8_encode($linha['cl_id']);
                                    $descricao = utf8_encode($linha['cl_descricao']);
                                    echo "<option value='$id'>$descricao</option>";
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md  mb-2">
                            <label for="quantidade" class="form-label">Cliente</label>
                            <input type="text" disabled class="form-control" name="cliente" id="cliente" value="">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <?php
                        while ($linha = mysqli_fetch_assoc($consultar_forma_pagamento)) {
                            $id = utf8_encode($linha['cl_id']);
                            $descricao = utf8_encode($linha['cl_descricao']);
                        ?>
                            <div class="col-md-6 mb-2">
                                <div class="input-group mb-3">
                                    <span class="input-group-text "><?php echo $descricao; ?></span>
                                    <input type="text" class="form-control inputNumber" name="<?php echo $id; ?>" id="vlr_liquido" value="">
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
<div class="alert"></div>

<script src="js/funcao.js"></script>
<script src="js/configuracao/users/user_logado.js"></script>
<script src="js/include/recebimento_nf/gerenciar_recibemento.js"></script>
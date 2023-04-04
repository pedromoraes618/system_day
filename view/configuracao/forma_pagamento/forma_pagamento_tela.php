<?php
include "../../../conexao/conexao.php";
include "../../../modal/configuracao/forma_pagamento/gerenciar_forma_pagamento.php";
?>
<div class="modal fade" id="modal_forma_pagamento" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Forma de pagamento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="forma_pagamento">
                <?php include "../../input_include/usuario_logado.php" ?>
                <input type="hidden" id="id" value="<?php if (isset($_GET['forma_id'])) {
                                                        echo $_GET['forma_id'];
                                                    } ?>">
                <div class="modal-body">
                    <div class="col  mb-2">
                        <label for="descricao" class="form-label">Descrição</label>
                        <input type="text" class="form-control " id="descricao" name="descricao" value="">
                    </div>
                    <div class="col  mb-2">
                        <label for="conta_financeira" class="form-label">Conta financeira</label>
                        <select class="form-control" name="conta_financeira" id="conta_financeira">
                            <option value="0">Selecione..</option>
                            <?php while ($linha  = mysqli_fetch_assoc($consultar_conta_financeira)) {
                                $id_b = $linha['cl_id'];
                                $banco_b = utf8_encode($linha['cl_banco']);
                                echo "<option  value='$id_b'> $banco_b </option>";
                            } ?>
                        </select>
                    </div>
                    <div class="col  mb-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="0">Selecione..</option>
                            <?php while ($linha  = mysqli_fetch_assoc($consultar_status_recebimento)) {
                                $id_b = $linha['cl_id'];
                                $descricao_b = utf8_encode($linha['cl_descricao']);
                                echo "<option  value='$id_b'> $descricao_b </option>";
                            } ?>
                        </select>
                    </div>
                    <div class="col  mb-2">
                        <label for="status" class="form-label">Classificação</label>
                        <select class="form-control" name="classificacao" id="classificacao">
                            <option value="0">Selecione..</option>
                            <?php while ($linha  = mysqli_fetch_assoc($consultar_classificao_fpg)) {
                                $id_b = $linha['cl_id'];
                                $descricao_b = utf8_encode($linha['cl_descricao']);
                                echo "<option  value='$id_b'> $descricao_b </option>";
                            } ?>
                        </select>
                    </div>
                    <div class="col  mb-2">
                        <label for="status" class="form-label">Tipo Pagamento</label>
                        <select class="form-control" name="tipo_pagamento" id="tipo_pagamento">
                            <option value="0">Selecione..</option>
                            <?php while ($linha  = mysqli_fetch_assoc($consultar_tipo_pagamento)) {
                                $id_b = $linha['cl_id'];
                                $descricao_b = utf8_encode($linha['cl_descricao']);
                                echo "<option  value='$id_b'> $descricao_b </option>";
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" id="button_form" class="btn btn-success">Salvar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="js/funcao.js"></script>
<script src="js/configuracao/users/user_logado.js"></script>
<script src="js/configuracao/forma_pagamento/forma_pagamento_tela.js"></script>
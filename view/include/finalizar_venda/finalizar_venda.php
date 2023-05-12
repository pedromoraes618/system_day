<?php
include "../../../conexao/conexao.php";
include "../../../modal/venda/venda_mercadoria/gerenciar_venda.php";
include "../../../funcao/funcao.php";
?>
<div class="modal fade" id="modal_finalizar_venda" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Finalizar venda</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body">
                <div class="row">
                    <div class="col-md  mb-2">
                        <div class="card mb-2">
                            <div class="card-header">Selecione a forma de pagamento</div>
                            <ul class="list-group listar_fpg_venda  ">
                                <?php
                                while ($linha = mysqli_fetch_assoc($consultar_forma_pagamento)) {
                                    $descricao_fpg = utf8_encode($linha['cl_descricao']);
                                    $id_fpg = $linha['cl_id'];
                                ?>
                                    <li id_fpg="<?php echo $id_fpg ?>" class="list-group-item d-flex justify-content-between  align-items-start seleciona_fpg">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold descricao_fpg_<?php echo $id_fpg ?>"><?php echo $descricao_fpg; ?></div>
                                        </div>

                                        <span class="badge bg-success rounded-pill"><i class="bi bi-cash-stack"></i></span>
                                    </li>

                                <?php
                                }
                                ?>

                            </ul>
                        </div>

                        <div class="card">
                            <div class="card-header">Selecione o vendedor</div>
                            <div class="col">
                                <select class="form-control" name="" id="">
                                    <option value="">Selecione..</option>
                                    <?php
                                    if (isset($_GET['id_user_logado'])) {
                                        $id_user_logado = $_GET['id_user_logado'];
                                    }
                                    while ($linha = mysqli_fetch_assoc($consultar_vendedor)) {
                                        $vendedor = $linha['cl_usuario'];
                                        $id_vendedor = $linha['cl_id'];
                                    ?>
                                        <option <?php if ($id_user_logado == $id_vendedor) {
                                                    echo 'selected';
                                                } ?> value=""><?php echo $vendedor; ?></option>
                                    <?php
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>


                    </div>
                    <div class="col-md  mb-2">
                        <div class="card">
                            <div class="card-header">Resumo</div>
                            <div class="card-body">
                                <ul class="list-group ">
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">Cliente</div>
                                            Pedro henrique dos santos moraes
                                        </div>
                                        <span class="badge bg-primary rounded-pill"><i class="bi bi-person-circle"></i></span>
                                    </li>
                                    <li class="list-group-item mb-3 d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">Pagamento</div>
                                            <div class="descricao_forma_pagamento_venda">A definir...</div>
                                            <input type="hidden" id="id_forma_pagamento_venda" class="form-control">
                                        </div>
                                        <span class="badge bg-primary rounded-pill"><i class="bi bi-person-circle"></i></span>
                                    </li>
                                    <li class="list-group-item d-flex shadow border border-success-subtle justify-content-between align-items-start">

                                        <div class="col">
                                            <div class="input-group mb-1">
                                                <span class="input-group-text">Sub total </span>
                                                <input type="text" aria-label="First name" readonly value="120.00" class="form-control">
                                            </div>
                                            <div class="input-group mb-1">
                                                <span class="input-group-text">Desconto</span>
                                                <input type="text" aria-label="First name"  class="form-control">
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-text">Total</span>
                                                <input type="text" aria-label="First name" readonly value="120.00" class="form-control">
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="salvar_observacao" data-bs-dismiss="modal">Finalizar venda</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>

            </div>

        </div>
    </div>
</div>
<div class="alert"></div>
<script src="js/include/finalizar_venda/finalizar_venda.js"></script>
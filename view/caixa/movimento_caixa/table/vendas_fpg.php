<?php
include "../../../../conexao/conexao.php";
include "../../../../modal/caixa/movimento_caixa/gerenciar_movimento_caixa.php";

?>

<div class="card m-1 shadow border-0 mb-2 ">
    <div class="card-header header-card-dashboard ">
        <h6><i class="bi bi-exclamation-octagon"></i> Vendas</h6>
    </div>
    <div class="card-body p-1">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Data movimento</th>
                    <th scope="col">Doc</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Forma pgto</th>
                    <th scope="col">Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $valor_total = 0;
                while ($linha = mysqli_fetch_assoc($consultar_vendas_fpg)) {
                    $data_movimento = $linha['cl_data_movimento'];
                    $serie_nf = ($linha['cl_serie_nf']);
                    $numero_nf = ($linha['cl_numero_nf']);
                    $cliente = utf8_encode($linha['cl_razao_social']);
                    $forma_pagamento = utf8_encode($linha['formapg']);
                    $valor_liquido = ($linha['cl_valor_liquido']);
                    $valor_total = $valor_liquido + $valor_total;
                ?>
                    <tr>
                        <td><?php echo formatDateB($data_movimento); ?></td>
                        <td><?php echo $serie_nf . "" . $numero_nf;  ?></td>
                        <td><?php echo $cliente; ?></td>
                        <td><?php echo $forma_pagamento; ?></td>
                        <td><?php echo real_format($valor_liquido); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Tota</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th><?php echo real_format($valor_total); ?></td>

                </tr>
            </tfoot>
        </table>
    </div>

</div>

<div class="card m-1 shadow border-0 mb-2 ">
    <div class="card-header header-card-dashboard ">
        <h6><i class="bi bi-exclamation-octagon"></i> Resumo venda por forma de pagamento</h6>
    </div>
    <div class="card-body p-1">
        <table class="table table-hover">
            <tbody>
                <?php
                $valor_total = 0;
                while ($linha = mysqli_fetch_assoc($consultar_resumo_vendas_fpg)) {
                    $forma_pagamento = utf8_encode($linha['formapg']);
                    $valor_liquido = ($linha['valorliquido']);

                    $valor_total = $valor_liquido + $valor_total;
                ?>
                    <tr>
                        <th colspan="5"><?php echo ($forma_pagamento); ?></th>
                        <th><?php echo real_format($valor_liquido); ?></th>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5">Tota</th>
                    <th><?php echo real_format($valor_total); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
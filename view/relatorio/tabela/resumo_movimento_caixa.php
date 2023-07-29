<div class="info">
    <h2 class=""><?php echo $titulo_relatorio; ?></h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="titulo_tabela" colspan="5">Receita</th>
            </tr>
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
            $valor_receita = 0;
            while ($linha = mysqli_fetch_assoc($consultar_receita)) {
                $data_recebimento = $linha['cl_data_pagamento'];
                $documento = utf8_encode($linha['cl_documento']);
                $cliente = utf8_encode($linha['cl_razao_social']);
                $forma_pagamento = utf8_encode($linha['formapg']);
                $valor_liquido = ($linha['cl_valor_liquido']);
                $valor_receita = $valor_liquido + $valor_receita;
            ?>
                <tr>
                    <td><?php echo formatDateB($data_recebimento); ?></td>
                    <td><?php echo $documento;  ?></td>
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
                <th><?php echo real_format($valor_receita); ?></td>

            </tr>
        </tfoot>
    </table>
    <table class="table table-hover">

        <thead>
            <tr>
                <th class="titulo_tabela" colspan="5">Despesa</th>
            </tr>
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
            $valor_despesa = 0;
            while ($linha = mysqli_fetch_assoc($consultar_despesa)) {
                $data_recebimento = $linha['cl_data_pagamento'];
                $documento = utf8_encode($linha['cl_documento']);
                $cliente = utf8_encode($linha['cl_razao_social']);
                $forma_pagamento = utf8_encode($linha['formapg']);
                $valor_liquido = ($linha['cl_valor_liquido']);
                $valor_despesa = $valor_liquido + $valor_despesa;
            ?>
                <tr>
                    <td><?php echo formatDateB($data_recebimento); ?></td>
                    <td><?php echo $documento;  ?></td>
                    <td><?php echo $cliente; ?></td>
                    <td><?php echo $forma_pagamento; ?></td>
                    <td><?php echo real_format($valor_liquido); ?></td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tfoot>
                <tr>
                    <th>Tota</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th><?php echo real_format($valor_despesa); ?></td>

                </tr>
            </tfoot>
        </tfoot>
    </table>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col" colspan="6">Saldo inicial</th>
                <th><?php echo real_format($valor_fechado); ?></th>
            </tr>
            <tr>
                <th scope="col" colspan="6">Receita + </th>
                <th><?php echo real_format($valor_receita); ?></th>
            </tr>
            <tr>
                <th scope="col" colspan="6">Despesa -</th>
                <th><?php echo real_format($valor_despesa); ?></td>
            </tr>
            <tr>
                <th scope="col" colspan="6">Total</th>
                <th><?php echo real_format($valor_fechado + $valor_receita - $valor_despesa); ?></th>
            </tr>
        </thead>
    </table>
</div>
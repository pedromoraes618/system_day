<?php
include "../../../../conexao/conexao.php";
include "../../../../modal/estoque/kardex/gerenciar_kardex.php";
?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Data</th>
            <th scope="col">Doc</th>
            <th scope="col">Empresa</th>
            <th scope="col">Usúario</th>
            <th scope="col">Tipo</th>
            <th scope="col">Entrada</th>
            <th scope="col">Saida</th>
            <th scope="col">Saldo</th>
            <th scope="col">Status</th>
            <th scope="col">Preço venda</th>
            <th scope="col">Preço compra</th>

        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Estoque inicial</td>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope=""><?php echo $estoque_inicial ?></th>
            <th scope=""></th>
            <th scope=""></th>
            <th scope=""></th>
        </tr>
        <?php
        $saldo = 0 + $estoque_inicial;
        $operador = "";
        while ($linha = mysqli_fetch_assoc($consultar_historico_produto)) {
            $true_ajuste_inicial = $linha['cl_ajuste_inicial'];
            $quantidade_b = $linha['cl_quantidade'];
            $tipo_b = $linha['cl_tipo'];
            $doc_b = $linha['cl_documento'];
            $status_b = $linha['cl_status'];
            $data_b = $linha['cl_data_lancamento'];
            $usuario_b = $linha['usuario'];
            $empresa_b = $linha['empresa'];
            $pareiro_id = $linha['cl_parceiro_id'];
            $valor_venda = $linha['valorv'];
            $valor_compra = $linha['valorc'];

            if ($tipo_b == "ENTRADA") {
                if ($status_b == "cancelado") { //verificar se o ajuste foi cancelado
                    $saldo = 0 + $saldo;
                } else {
                    $saldo = $quantidade_b + $saldo;
                }
                $quantidade_entrada = $quantidade_b;
                $quantidade_saida = 0; // informar zero

                $cor = 'primary';
                $titulo = "Entrada";
            }
            if ($tipo_b == "SAIDA") {
                //foi um ajuste de saida
                if ($status_b == "cancelado") { //verificar se o ajuste foi cancelado
                    $saldo = 0 + $saldo;
                } else {
                    $saldo = $saldo - $quantidade_b;
                }

                $quantidade_saida = $quantidade_b;
                $quantidade_entrada = 0; // informar zero

                $cor = 'success';
                $titulo = "Saida";
            }

            if ($pareiro_id != "") {
                $empresa_b =  consulta_parceiro($conecta,$pareiro_id,"cl_razao_social");
            }

        ?>

            <tr>
                <td><?php echo formatDateB($data_b); ?></td>
                <td><?php echo $doc_b; ?></td>
                <td><?php echo $empresa_b ?></td>
                <td><?php echo $usuario_b; ?></td>
                <td><span class="badge text-bg-<?php echo $cor; ?>"><?php echo $titulo; ?></span>
                </td>

                <td><?php echo $quantidade_entrada ?></td>
                <td><?php echo $quantidade_saida ?></td>
                <td><?php echo $saldo; ?></td>
                <td style="width: 20px;">
                    <?php if ($status_b == "cancelado") {
                        echo "<i title='Cancelado' class='bi bi-x text-danger fs-4'></i>";
                    } ?>
                </td>
                <td><?php echo real_format($valor_venda); ?></td>
                <td><?php echo real_format($valor_compra); ?></td>

            </tr>

        <?php

        } ?>
        <tr>
            <td>Sub total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?php
                $sub_total = $estoque - $saldo;
                if ($sub_total == 0) {
                    echo $estoque; //quando for zerado, será informado o valor do estoque
                } else {
                    echo $sub_total;
                }

                ?></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td>Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?php echo $estoque; ?></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

    </tbody>
</table>
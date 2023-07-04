<?php
include "../../../../conexao/conexao.php";
include "../../../../modal/venda/venda_mercadoria/gerenciar_venda.php";
?>

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Item</th>
            <th scope="col">Código</th>
            <th scope="col">Descrição</th>
            <th scope="col">Unidade</th>
            <th scope="col">Referência</th>
            <th scope="col">P. Unitário</th>
            <th scope="col">Qtd</th>
            <th scope="col">Total</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody id="tabela_produtos">
        <?php
        $somatorio_total = 0;
        $item = 0;
        while ($linha = mysqli_fetch_assoc($consultar_produtos)) {
            $item = $item + 1;
            
            $id = $linha['cl_id'];
            $item_id = $linha['cl_item_id'];
            $descricao = utf8_encode($linha['cl_descricao_item']);
            $unidade = utf8_encode($linha['cl_unidade']);
            $referencia = utf8_encode($linha['cl_referencia']);
            $quantidade = $linha['cl_quantidade'];
            $valor_unitario = $linha['cl_valor_unitario'];
            $Valor_total = $linha['cl_valor_total'];

            $somatorio_total = $Valor_total + $somatorio_total;

        ?>
            <tr>
                <td><?php echo $item; ?></td>
                <td><?php echo $item_id; ?></td>
                <td><?php echo utf8_encode($descricao); ?></td>
                <td><?php echo $unidade; ?></td>
                <td><?php echo $referencia; ?></td>
                <td><?php echo real_format($valor_unitario); ?></td>
                <td><?php echo ($quantidade); ?></td>
                <td><?php echo real_format($Valor_total); ?></td>
                <td><button type="button" produto_id='<?php echo $id; ?>' class="btn btn-sm btn-info alterar_produto_vnd">Editar</button></td>


            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th scope="row">Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <th id="valor_total_produtos" scope="row"><?php echo real_format($somatorio_total); ?></th>
            <input type="hidden" id="vlr_total_prod" value="<?php echo $somatorio_total; ?>">
            <td></td>
        </tr>
    </tfoot>
</table>

<script src="js/venda/venda_mercadoria/table/tabela_produtos.js">
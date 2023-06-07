<?php
include "../../../../conexao/conexao.php";
include "../../../../modal/venda/venda_mercadoria/gerenciar_venda.php";

?>
<?php
if (!isset($consultar_tabela_inicialmente) or ($consultar_tabela_inicialmente == "S")) { //consultar parametro para carrregar inicialmente a tabela
?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Dt. Venda</th>
                <th scope="col">Número</th>
                <th scope="col">Cliente</th>
                <th scope="col">Vendedor</th>
                <th scope="col">Status</th>
                <th scope="col">Forma Pgt</th>
                <th scope="col">Desconto</th>
                <th scope="col">Valor</th>
                <th scope="col"></th>

            </tr>
        </thead>
        <tbody>

            <?php
            $valor_total = 0;

            while ($linha = mysqli_fetch_assoc($consultar_venda_mercadoria)) {
                $id_b = ($linha['id']);
                $data_movimento_b = ($linha['cl_data_movimento']);
                $numero_nf_b = ($linha['cl_numero_nf']);
                $serie_nf_b = ($linha['cl_serie_nf']);
                $status_recebmento_b = ($linha['cl_status_recebimento']);
                $status_recebmento_b_2 = ($linha['cl_status_recebimento']);
                $forma_pagamento_b = utf8_encode($linha['formapgt']);
                $razao_social_b = utf8_encode($linha['cl_razao_social']);
                $nome_fantasia_b = utf8_encode($linha['cl_nome_fantasia']);
                $valor_desconto_b = ($linha['cl_valor_desconto']);
                $valor_liquido_b = ($linha['cl_valor_liquido']);
                $vendedor_b = utf8_encode($linha['vendedor']);
                $valor_total = $valor_liquido_b + $valor_total;
            ?>
                <tr>
                    <th scope="row"><?php echo formatDateB($data_movimento_b) ?></th>
                    <td><?php echo $serie_nf_b . "" . $numero_nf_b; ?></td>
                    <td class="max_width_descricao"><?php echo $razao_social_b;  ?><br>
                        <hr class="mb-0"><?php echo $nome_fantasia_b; ?>
                    </td>
                    <td><?php echo $vendedor_b; ?></td>
                    <td><span class='badge rounded-pill  text-bg-<?php if ($status_recebmento_b == "1") {
                                                                        echo 'warning';
                                                                        $status_recebmento_b = "Pendente";
                                                                    } elseif ($status_recebmento_b == "2") {
                                                                        echo 'success';
                                                                        $status_recebmento_b = "Recebido";
                                                                    } else {
                                                                        echo 'danger';
                                                                        $status_recebmento_b = "Cancelado";
                                                                    } ?>'><?php echo $status_recebmento_b; ?></td>

                    <td><span class="badge rounded-pill text-bg-primary"><?php echo ($forma_pagamento_b); ?></span></td>
                    <td><?php echo real_format($valor_desconto_b); ?></td>
                    <td><?php echo real_format($valor_liquido_b); ?></td>

                    <?php if($status_recebmento_b_2=="1"){
                       echo  "<td class='td-btn'> <button type='button' venda_mercadoria_id= echo $id_b class='btn   btn-sm receber_venda'><i class='bi bi-clipboard-check-fill text-success fs-4'></i></button></td>";
                    }else{
                        echo "<td></td>";
                    }?>
                    <td class="td-btn"> <button type="button" venda_mercadoria_id="<?php echo $id_b; ?>" class="btn btn-info   btn-sm editar_venda_mercadoria">Editar</button></td>
                </tr>

            <?php } ?>



        </tbody>
        <tfoot>
            <th scope="col">Total</th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"><?php echo real_format($valor_total); ?></th>


        </tfoot>
    </table>
    <label>
        Registros <?php echo $qtd; ?>
    </label>
<?php
} else {
    include "../../../../view/alerta/alerta_pesquisa.php"; // mesnsagem para usuario pesquisar
}
?>
<script src="js/venda/venda_mercadoria/table/editar_venda.js">
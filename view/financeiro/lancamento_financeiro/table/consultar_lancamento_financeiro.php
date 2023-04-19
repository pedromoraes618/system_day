<?php
include "../../../../conexao/conexao.php";
include "../../../../modal/financeiro/lancamento_financeiro/gerenciar_lancamento_financeiro.php";

?>
<?php
if (!isset($consultar_tabela_inicialmente) or ($consultar_tabela_inicialmente == "S")) { //consultar parametro para carrregar inicialmente a tabela
?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Dt. Vencimento</th>
                <th scope="col">Dt. Pagamento</th>
                <th scope="col">Parceiro</th>
                <th scope="col">Descrição</th>
                <th scope="col">Doc</th>
            
                <th scope="col">Status</th>
                <th scope="col">Tipo</th>
                <th scope="col">Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($linha = mysqli_fetch_assoc($consultar_lancamento_financeiro)) {
                $id_b = $linha['cl_id'];
                $data_vencimento = ($linha['cl_data_vencimento']);
                $data_pagamento = ($linha['cl_data_pagamento']);
                $nome_fantasia_b = utf8_encode($linha['cl_nome_fantasia']);
                $razao_social_b = utf8_encode($linha['cl_razao_social']);
                $descricao_b = utf8_encode($linha['descricao']);
                $doc_b = utf8_encode($linha['cl_documento']);
                $forma_pagamento_b = utf8_encode($linha['formapgt']);
                $status_b = utf8_encode($linha['status']);
                $tipo_b = utf8_encode($linha['cl_tipo_lancamento']);
                $valor_liquido_b = ($linha['cl_valor_liquido']);
            ?>
                <tr>
                    <th scope="row"><?php echo formatDateB($data_vencimento) ?></th>
                    <th><?php echo formatDateB($data_pagamento) ?></th>
                    <td class="max_width_descricao"><?php echo $razao_social_b;  ?><br>
                        <hr class="mb-0"><?php echo $nome_fantasia_b; ?>
                    </td>
                    <td><?php echo ($descricao_b) ?></td>
                    <td><?php echo ($doc_b) ?></td>
        
                    <td><?php echo ($status_b) ?></td>

                    <td><span
                    class="badge text-bg-<?php if($tipo_b == "RECEITA" )
                    {echo 'success' ;}elseif($tipo_b=="DESPESA"){echo 'danger';}else{echo 'default';}?>"><?php echo $tipo_b; ?></span>
            </td>
                    <td><?php echo real_format($valor_liquido_b) ?></td>
                    <td class="td-btn"><button type="button" lancamento_financeiro_id=<?php echo $id_b; ?> class="btn btn-info   btn-sm editar_lancamento_financeira ">Editar</button>
                    </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
    <label>
        Registros <?php echo $qtd; ?>
    </label>
<?php
} else {
    include "../../../../view/alerta/alerta_pesquisa.php"; // mesnsagem para usuario pesquisar
}
?>
<script src="js/financeiro/lancamento_financeiro/table/editar_lancamento_financeiro.js">
    
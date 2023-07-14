<?php
include "../../../../conexao/conexao.php";
include "../../../../modal/estoque/produto/gerenciar_produto.php";

?>
<?php
if (!isset($consultar_tabela_inicialmente) or ($consultar_tabela_inicialmente == "S")) { //consultar parametro para carrregar inicialmente a tabela
?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Descrição</th>
                <th scope="col">Referência</th>
                <th scope="col">Und</th>
                <th scope="col">Fabricante</th>
                <th scope="col">Estoque</th>
                <th scope="col">Preço venda</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php while ($linha = mysqli_fetch_assoc($consultar_produtos)) {
                $produto_id = $linha['produtoid'];
                $codigo_produto_b = $linha['cl_codigo'];
                $descricao_b = utf8_encode($linha['descricao']);
                $referencia_b = utf8_encode($linha['cl_referencia']);
                $estoque_minimo_b = utf8_encode($linha['cl_estoque_minimo']);
                $estoque_maximo_b = utf8_encode($linha['cl_estoque_maximo']);
                $subgrupo_b = utf8_encode($linha['subgrupo']);
                $und_b = utf8_encode($linha['und']);
                $fabricante_b = utf8_encode($linha['fabricante']);
                $estoque_b = $linha['cl_estoque'];
                $preco_venda_b = ($linha['cl_preco_venda']);
                $preco_promocao_b = ($linha['cl_preco_promocao']);
                $ativo = ($linha['ativo']);
            ?>
                <tr>

                    <th scope="row"><?php echo $produto_id ?></th>
                    <td class="max_width_descricao"><?php echo $descricao_b; ?></td>
                    <td><?php echo $referencia_b; ?></td>

                    <td><?php echo $und_b; ?></td>
                    <td><?php echo $fabricante_b; ?></td>
                    <td><?php echo $estoque_b; ?></td>
                    <td><?php  echo real_format($preco_venda_b); 
                    if($preco_promocao_b !="" and $preco_promocao_b > 0){
                       echo " ". real_format($preco_promocao_b);
                    }
                    
                    ?></td>

                    <td><span class='badge text-bg-<?php echo ($ativo == "SIM") ? 'success' : 'danger' ?>'><?php echo ($ativo == "SIM") ? 'Ativo' : 'Inativo' ?></td>

                    <?php if ($ativo == "SIM") { ?>
                        <td class="td-btn">
                            <button type="button" estoque="<?php echo $estoque_b; ?>" unidade="<?php echo $und_b ?>" preco_venda="<?php echo $preco_venda_b; ?>" ativo=<?php echo $ativo; ?> id_produto=<?php echo $produto_id; ?> class="btn btn-info   btn-sm selecionar_produto ">Selecionar</button>
                        </td>

                    <?php } else {
                        echo '<td></td>';
                    } ?>

                    <?php if ($ativo == "SIM" and $preco_promocao_b != "" and $preco_promocao_b > 0) { ?>
                        <td class="td-btn">
                            <button type="button" promocao='sim' estoque="<?php echo $estoque_b; ?>" unidade="<?php echo $und_b ?>" preco_venda="<?php echo $preco_promocao_b; ?>" ativo=<?php echo $ativo; ?> id_produto=<?php echo $produto_id; ?> class="btn btn-dark   btn-sm selecionar_produto ">Promoção</button>
                        </td>
                    <?php } else {
                        echo '<td></td>';
                    } ?>

                    <td><input type="hidden" id="<?php echo $produto_id; ?>" value="<?php echo $descricao_b; ?>"></td>
                    <td><input type="hidden" referencia_<?php echo $produto_id ?>="<?php echo $produto_id; ?>" value="<?php echo $referencia_b; ?>"></td>

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
<script src="js/include/produto/pesquisa_produto.js">
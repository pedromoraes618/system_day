<?php 
include "../../../../conexao/conexao.php";
include "../../../../modal/estoque/produto/gerenciar_produto.php";

?>
<?php 
if(!isset($consultar_tabela_inicialmente) or ($consultar_tabela_inicialmente == "S")){ //consultar parametro para carrregar inicialmente a tabela
    ?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Código</th>
            <th scope="col">Descrição</th>
            <th scope="col">Referencia</th>
            <th scope="col">Grupo</th>
            <th scope="col">Unidade Md</th>
            <th scope="col">Fabricante</th>
            <th scope="col">Estoque</th>
            <th scope="col">Preço venda</th>
            <th scope="col">Status</th>
            <th scope="col"></th>
            <th scope="col"></th>

        </tr>
    </thead>
    <tbody>
        <?php while($linha = mysqli_fetch_assoc($consultar_produtos)){
                $produto_id = $linha['produtoid'];
                $codigo_produto_b = $linha['cl_codigo'];
                $descricao_b = utf8_encode($linha['descricao']);
                $referencia_b = utf8_encode($linha['cl_referencia']);
                $subgrupo_b = utf8_encode($linha['subgrupo']);
                $und_b = utf8_encode($linha['und']);
                $fabricante_b = utf8_encode($linha['fabricante']);
                $estoque_b = $linha['cl_estoque'];
                $preco_venda_b = real_format($linha['cl_preco_venda']);
                $ativo = ($linha['ativo']);
                if($ativo=="SIM"){
                    $ativo="Ativo";
                }else{
                    $ativo ="Inativo";
                }
        
            ?>
        <tr>
            <th scope="row"><?php echo $produto_id ?></th>
            <td><?php echo $descricao_b; ?></td>
            <td><?php echo $referencia_b; ?></td>
            <td><?php echo $subgrupo_b; ?></td>
            <td><?php echo $und_b; ?></td>
            <td><?php echo $fabricante_b; ?></td>
            <td><?php echo $estoque_b; ?></td>
            <td><?php echo $preco_venda_b; ?></td>
        
            <td><span
                    class="badge text-bg-<?php if($ativo == "Ativo"){echo 'success' ;}else{echo 'danger';} ?>"><?php echo $ativo; ?></span>
            </td>
            

            <td class="td-btn"><button type="button"  id_produto=<?php echo $produto_id; ?>
                    class="btn btn-info editar_produto ">Editar</button>
            </td>
            <td class="td-btn"><button type="button"  id_produto=<?php echo $produto_id; ?>
                    class="btn btn-warning consultar_kardex ">Karkex</button>
            </td>
        </tr>

        <?php }?>
    </tbody>
</table>
<label>
    Registros <?php echo $qtd; ?>
</label>

<?php
}else{
    include "../../../../view/alerta/alerta_pesquisa.php"; // mesnsagem para usuario pesquisar
}
?>
<script src="js/estoque/produto/table/editar_produto.js">
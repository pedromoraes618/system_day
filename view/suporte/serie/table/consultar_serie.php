<?php 
include "../../../../conexao/conexao.php";
include "../../../../modal/suporte/serie/gerenciar_serie.php";

?>

<?php 

if(!isset($consultar_tabela_inicialmente) or ($consultar_tabela_inicialmente == "S")){ //consultar parametro para carrregar inicialmente a tabela
    ?>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Código</th>
            <th scope="col">Descrição</th>
            <th scope="col">Valor</th>
            <th scope="col"></th>

        </tr>
    </thead>
    <tbody>
        <?php while($linha = mysqli_fetch_assoc($consultar_serie)){
                $id_serie_b = $linha['cl_id'];
                $descricao_b = $linha['cl_descricao'];
                $valor_b = $linha['cl_valor'];
            ?>
        <tr>
            <th scope="row"><?php echo $id_serie_b ?></th>
            <td><?php echo $descricao_b; ?></td>
            <td><?php echo $valor_b; ?></td>

            <td class="td-btn"><button type="button" id_serie=<?php echo $id_serie_b; ?>
                    class="btn btn-sm btn-info editar_serie">Editar</button>
            </td>
        </tr>

        <?php }?>
    </tbody>
</table>
<?php
}else{
    include "../../../../view/alerta/alerta_pesquisa.php"; // mesnsagem para usuario pesquisar
    
}
?>

<script src="js/suporte/serie/table/editar_serie.js">
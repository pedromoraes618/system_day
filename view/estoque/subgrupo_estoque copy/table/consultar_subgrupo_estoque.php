<?php 
include "../../../../conexao/conexao.php";
include "../../../../modal/estoque/subgrupo_estoque/gerenciar_subgrupo_estoque.php";

?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Código</th>
            <th scope="col">Descrição</th>
            <th scope="col"></th>

        </tr>
    </thead>
    <tbody>
        <?php while($linha = mysqli_fetch_assoc($consultar_subgrupo_estoque)){
                $id_subgrupo_b = $linha['cl_id'];
                $descricao_b = $linha['cl_descricao'];
            ?>
        <tr>
            <th scope="row"><?php echo $id_subgrupo_b ?></th>
            <td><?php echo $descricao_b; ?></td>
     
            <td><button type="button" id_subgrupo=<?php echo $id_subgrupo_b; ?>
                    class="btn btn-info editar_parametro">Editar</button>
            </td>
        </tr>

        <?php }?>
    </tbody>
</table>

<script src="js/suporte/parametro/table/editar_parametro.js">
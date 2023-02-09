<?php 
include "../../../../conexao/conexao.php";
include "../../../../modal/estoque/grupo_estoque/gerenciar_grupo_estoque.php";

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
        <?php while($linha = mysqli_fetch_assoc($consultar_grupo_estoque)){
                $id_grupo_b = $linha['cl_id'];
                $descricao_b = $linha['cl_descricao'];
            ?>
        <tr>
            <th scope="row"><?php echo $id_grupo_b ?></th>
            <td><?php echo $descricao_b; ?></td>
     
            <td><button type="button" id_grupo=<?php echo $id_grupo_b; ?>
                    class="btn btn-info editar_grupo_estoque">Editar</button>
            </td>
        </tr>

        <?php }?>
    </tbody>
</table>

<script src="js/estoque/grupo_estoque/table/editar_grupo_estoque.js">
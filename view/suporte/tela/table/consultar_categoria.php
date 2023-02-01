<?php 
include "../../../../conexao/conexao.php";
include "../../../../modal/suporte/tela/gerenciar_tela.php";

?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Código</th>
            <th scope="col">Categoria</th>
            <th scope="col">Icone</th>
            <th scope="col">Ordem</th>

        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($consultar_categorias)){
                $id_categoria_b = $row['cl_id'];
                $categoria_b = utf8_encode($row['cl_categoria']);
                $icone_b = $row['cl_icone'];
                $ordem_b = $row['cl_ordem'];

            ?>
        <tr>
            <th scope="row"><?php echo $id_categoria_b ?></th>
            <td><?php echo $categoria_b; ?></td>
            <td><?php echo $icone_b; ?></td>
            <td><?php echo $ordem_b; ?></td>

            <td><button type="button" id_categoria=<?php echo $id_categoria_b; ?>
                    class="btn btn-info editar_categoria">Editar</button>
            </td>
        </tr>

        <?php }?>
    </tbody>
</table>
<script src="js/suporte/tela/table/editar_categoria.js"></script>
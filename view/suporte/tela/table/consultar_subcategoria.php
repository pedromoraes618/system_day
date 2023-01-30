<?php 
include "../../../../conexao/conexao.php";
include "../../../../modal/suporte/tela/gerenciar_tela.php";

?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Código</th>
            <th scope="col">Subcategoria</th>
            <th scope="col">Ordem</th>
            <th scope="col">Diretorio Subcategoria</th>
            <th scope="col">Url subcategoria</th>
            <th scope="col">Diretorio Banco</th>
            <th scope="col">Categoria</th>

            <th scope="col"></th>
        
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($consultar_subcategorias)){
                $id_subcategoria_b = $row['cl_id'];
                $subcategoria_b = utf8_encode($row['cl_subcategoria']);
                $ordem_menu_b = $row['cl_ordem_menu'];
                $diretorio_b = $row['cl_diretorio'];
                $url_b = $row['cl_url'];
                $diretorio_banco_b = $row['cl_diretorio_bd'];
                $categoria_b = utf8_encode($row['categoria']);
            
            
            ?>
        <tr>
            <th scope="row"><?php echo $id_subcategoria_b ?></th>
            <td><?php echo $subcategoria_b; ?></td>
            <td><?php echo $ordem_menu_b; ?></td>
            <td><?php echo $diretorio_b; ?></td>
            <td><?php echo $url_b; ?></td>
            <td><?php echo $diretorio_banco_b; ?></td>
            <td><?php echo $categoria_b; ?></td>
            
            
            <td><button type="button" id_subcategoria=<?php echo $id_subcategoria_b; ?> class="btn btn-info editar_user">Editar</button>
            </td>
        </tr>

        <?php }?>
    </tbody>
</table>
<script src="js/configuracao/users/editar_user.js"></script>
<?php 
include "../../../../conexao/conexao.php";
include "../../../../modal/configuracao/users/usuario.php";

?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Código</th>
            <th scope="col">Nome</th>
            <th scope="col">Usúario</th>
            <th scope="col">Perfil</th>
            <th scope="col">Situação</th>
            <th scope="col">Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($consultar_usuarios)){
                $id_user_b = $row['cl_id'];
                $nome_b = $row['cl_nome'];
                $usuario_b = $row['cl_usuario'];
                $tipo_b = $row['cl_tipo'];
                $situacao_b = $row['cl_ativo'];
                if($situacao_b == 1){
                    $situacao_b ="Ativo";
                }else{
                    $situacao_b ="Inativo";
                }
              
            ?>
        <tr>
            <th scope="row"><?php echo $id_user_b ?></th>
            <td><?php echo $nome_b; ?></td>
            <td><?php echo $usuario_b; ?></td>
            <td><?php echo $tipo_b; ?></td>
            <td><?php echo $situacao_b; ?></td>
            <td><button type="button" id_user=<?php echo $id_user_b; ?>  class="btn btn-info editar_user">Editar</button></td>
        </tr>

        <?php }?>
    </tbody>
</table>
<script src="js/configuracao/users/editar_user.js"></script>
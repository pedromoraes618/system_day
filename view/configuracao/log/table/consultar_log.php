<?php 
include "../../../../modal/configuracao/log/log.php";
include "../../../../funcao/funcao.php";
?>

<div class="tabela">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Data</th>
                <th scope="col">Usúario</th>
                <th scope="col">Mensagem</th>
            </tr>
        </thead>
        <tbody>
            <?php while($linha = mysqli_fetch_assoc($consultar_log)){ 
                $data = $linha['cl_data_modificacao'];
                $usuario =$linha['cl_usuario'];
                $descricao = utf8_encode($linha['cl_descricao']);
                ?>
            <tr>
                <th scope="row"><?php echo  formatarTimeStamp($data); ?></th>
                <td><?php echo $usuario; ?></td>
                <td><?php echo $descricao ?></td>


            </tr>
            <?PHP }?>
        </tbody>
    </table>
</div>
<?php 
include "../../../../../conexao/conexao.php";  
include "../../../../../modal/estoque/produto/gerenciar_produto.php";  


?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Data</th>
            <th scope="col">Doc</th>
            <th scope="col">Empresa</th>
         
            <th scope="col">Usúario</th>
            <th scope="col">Tipo</th>
            <th scope="col">Entrada</th>
            <th scope="col">Saida</th>
            <th scope="col">Saldo</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php 
                $saldo = 0;
                $operador = "";
                while($linha = mysqli_fetch_assoc($consultar_historico_produto)){
                $true_ajuste_inicial = $linha['cl_ajuste_inicial'];
                $quantidade_b = $linha['cl_quantidade'];
                $tipo_b =$linha['cl_tipo'];
                //corrir depois 
                if($tipo_b =="ENTRADA"){
                    $saldo = $quantidade_b + $saldo;
                    $quantidade_entrada = $quantidade_b;
                    $quantidade_saida = 0; // informar zero
                }else{
                    //foi um ajuste de saida
                    $saldo = $saldo - $quantidade_b ;
                    $quantidade_saida = $quantidade_b;
                    $quantidade_entrada = 0; // informar zero
                }
                
                $tipo_b = strtolower($tipo_b);
                if($true_ajuste_inicial == "1"){
            ?>

        <tr>
            <td>Estoque inicial</td>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope=""><?php echo $quantidade_b ?></th>
            <th scope=""></th>
        </tr>
        <?php }else{?>
        <tr>
            <td>20/01/2023</td>
            <td>ajst-205</td>
            <td>system_day</td>
            <td>Pedro</td>
            <td><span
                    class="badge text-bg-<?php if($tipo_b == "saida"){echo 'success' ;}else{echo 'primary';} ?>"><?php echo $tipo_b; ?></span>
            </td>
          
            <td><?php echo $quantidade_entrada ?></td>
            <td><?php echo $quantidade_saida ?></td>
            <td><?php  echo $saldo; ?></td>
            <td></td>
        </tr>
        <?php }}?>

    </tbody>
</table>
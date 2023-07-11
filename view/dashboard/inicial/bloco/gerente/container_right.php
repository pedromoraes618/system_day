<?php
include "../../../../../modal/dashboard/inicial/gerenciar_dashboard.php";
?>

<div class="card m-1 shadow border-0 mb-2 ">
    <div class="card-header header-card-dashboard ">
        <h6><i class="bi bi-exclamation-octagon"></i> Caixa</h6>
    </div>
    <div class="card-body card-right p-1" style="text-align:center">
        <?php if ($resultado_consulta > 0) {
            if ($status == "aberto" or $status == "reaberto") {
                echo "<img style='max-width:180px;' class='img-fluid img_status' src='img/caixa_aberto.svg' ><p>Caixa aberto</p>";
            } else {
                echo "<img  style=max-width:180px;class='img-fluid img_status' src='img/caixa_fechado.svg' ><p>Caixa Fechado</p>";
            }
        } else {
            echo "<img   style=max-width:180px; class='img-fluid img_status' src='img/caixa_nao_aberto.svg' ><p>Caixa não aberto</p>";
        } ?>

    </div>
</div>

<div class="card m-1 shadow border-0 mb-2 ">
    <div class="card-header header-card-dashboard ">
        <h6><i class="bi bi-exclamation-octagon"></i> Lembretes</h6>
    </div>
    <div class="card-body card-right p-1">
        <?php if ($qtd_consultar_lembretes > 0) { ?>
            <?php while ($linha = mysqli_fetch_assoc($consultar_lembretes)) {
                $id_tarefa_b = $linha['cl_id'];
                $data_lancamento_b = ($linha['cl_data_lancamento']);
                $descricao_b = utf8_encode($linha['cl_descricao']);
                $comentario_b = utf8_encode($linha['cl_comentario']);
                $status_b = $linha['status'];
                $prioridade_b = $linha['cl_prioridade'];
                $data_limite_b = ($linha['cl_data_limite']);
                $usuario_func = $linha['usuario_func'];
                if ($prioridade_b == "1") {
                    $bordar = 'border border-danger-subtle';
                } else {
                    $bordar = '';
                }
            ?>
                <div class="card p-1 mb-2 <?php echo $bordar; ?>">
                    <div class="card-body p-1">
                        <h6 class="card-title"><?php echo formatDateB($data_lancamento_b) . ""; ?></h6>
                        <p class="card-text"><?php echo $descricao_b; ?></p>
                    </div>
                </div>
        <?php }
        } else {
            echo '<div class="sem_registro"><img class="img-fluid img_sem_registro" src="img/sem_registro.svg"> </div>';
        } ?>

    </div>
</div>

<div class="card m-1 shadow border-0 ">
    <div class="card-header header-card-dashboard">
        <h6><i class="bi bi-exclamation-octagon"></i> Desempenho da equipe</h6>
    </div>
    <div class="card-body card-right p-1">
        <div class="card p-1 mb-2">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <tH>Vnd</td>
                        <tH>Vendedor</tH>
                        <tH>Valor Vendas</tH>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($qtd_desempenho_equipe > 0) { ?>
                        <?php while ($linha = mysqli_fetch_assoc($consultar_desemepenho_equipe)) {
                            $vendedor_b = $linha['vendedor'];
                            $valor_b = $linha['valor'];
                            $vendas_b = $linha['vendas'];
                        ?>
                            <tr>
                                <td><?php echo $vendas_b; ?></td>
                                <td><?php echo $vendedor_b; ?></td>
                                <td><?php echo $valor_b; ?></td>
                            </tr>
                    <?php }
                    } else {
                        echo '<div class="sem_registro"><img class="img-fluid img_sem_registro" src="img/sem_registro.svg"> </div>';
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card m-1 shadow border-0 ">
    <div class="card-header header-card-dashboard">
        <h6><i class="bi bi-exclamation-octagon"></i> Produtos mais vendidos</h6>
    </div>
    <div class="card-body card-right p-1">

        <div class="card p-1 mb-2">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <tH>Rank</td>
                        <tH>Produto</tH>
                        <tH>Quantidade</tH>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($qtd_prod_mais_vendidos > 0) {
                        $rank = 0;
                        while ($linha = mysqli_fetch_assoc($consultar_prod_mais_vendidos)) {
                            $descricao = $linha['cl_descricao_item'];
                            $quantidade = $linha['total_vendido'];
                            $valor_total = $linha['valor_total'];

                            $rank = $rank + 1;
                    ?>
                            <tr>
                                <td><?php echo $rank; ?></td>
                                <td><?php echo $descricao; ?></td>
                                <td><?php echo $quantidade; ?></td>
                            </tr>
                    <?php }
                    } else {
                        echo '<div class="sem_registro"><img class="img-fluid img_sem_registro" src="img/sem_registro.svg"> </div>';
                    } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
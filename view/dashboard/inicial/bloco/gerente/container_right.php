<?php
include "../../../../../modal/dashboard/inicial/gerenciar_dashboard.php";
?>

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
                        <tH>Valor</tH>
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
                    }else{
                        echo '<div class="sem_registro"><img class="img-fluid img_sem_registro" src="img/sem_registro.svg"> </div>';
                    }?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<div class="card m-1 shadow border-0 ">
    <div class="card-header header-card-dashboard">
        <h6><i class="bi bi-exclamation-octagon"></i> Produtos mais comprados</h6>
    </div>
    <div class="card-body card-right p-1">

        <div class="card p-1 mb-2">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <tH>Rank</td>
                        <tH>Produto</tH>
                        <tH>Valor</tH>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1º</td>
                        <td>Martelete</td>
                        <td>R$ 5.000,00</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
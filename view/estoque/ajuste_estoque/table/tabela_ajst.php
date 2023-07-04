<?php

include "../../../../conexao/conexao.php";
include "../../../../modal/estoque/ajuste_estoque/gerenciar_ajuste_estoque.php";

?>

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Ajst</th>
            <th scope="col">Descrição</th>
            <th scope="col">Usuário</th>
            <th scope="col">Tipo</th>
            <th scope="col">Quantidade</th>
            <th scope="col">Motivo</th>
        </tr>
    </thead>
    <tbody>
        <?php

        while ($linha = mysqli_fetch_assoc($consultar_ajst_produtos)) {

            $id_produto = ($linha['id_produto']);
            $descricao_produto = utf8_encode($linha['produto']);
            $usuario = $linha['cl_usuario'];
            $documento = $linha['cl_documento'];
            $tipo = $linha['cl_tipo'];
            $quantidade = $linha['cl_quantidade'];
            $motivo = utf8_encode($linha['cl_motivo']);
            if ($tipo == "ENTRADA") {
                $cor = 'primary';
                $titulo = "Entrada";
            } else {
                $cor = 'success';
                $titulo = "Saida";
            }

        ?>
            <tr>

                <td><?php echo $documento; ?></td>
                <td><?php echo $descricao_produto; ?></td>
                <td><?php echo $usuario; ?></td>
                <td><span class="badge text-bg-<?php echo $cor; ?>"><?php echo $titulo; ?></span>
                <td><?php echo $quantidade; ?></td>
                <td><?php echo $motivo; ?></td>


            </tr>
        <?php } ?>
    </tbody>

</table>

<script src="js/venda/venda_mercadoria/table/tabela_produtos.js">
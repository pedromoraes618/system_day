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
            <th scope="col">Vlr compra</th>
            <th scope="col">Vlr venda</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php

        while ($linha = mysqli_fetch_assoc($consultar_ajst_produtos)) {
            $id_ajst = ($linha['id_ajst']);
            $id_produto = ($linha['id_produto']);
            $descricao_produto = utf8_encode($linha['produto']);
            $usuario = $linha['cl_usuario'];
            $documento = $linha['cl_documento'];
            $tipo = $linha['cl_tipo'];
            $quantidade = $linha['cl_quantidade'];
            $valor_compra = $linha['cl_valor_compra'];
            $valor_venda = $linha['cl_valor_venda'];
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
                <td><?php echo real_format($valor_compra); ?></td>
                <td><?php echo real_format($valor_venda); ?></td>
                <!-- <td><button type="button" id_ajst="<?php echo $id_ajst; ?>" class="btn btn-sm btn-danger cancelar_ajst">Cancelar</button></td> -->

            </tr>
        <?php } ?>
    </tbody>

</table>

<script src="js/estoque/ajuste_estoque/table/tabela_ajst.js"></script>
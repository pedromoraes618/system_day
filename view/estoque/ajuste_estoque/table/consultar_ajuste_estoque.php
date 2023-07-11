<?php
include "../../../../conexao/conexao.php";
include "../../../../modal/estoque/ajuste_estoque/gerenciar_ajuste_estoque.php";

?>
<?php
if (!isset($consultar_tabela_inicialmente) or ($consultar_tabela_inicialmente == "S")) { //consultar parametro para carrregar inicialmente a tabela
?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Data Lançamento</th>
                <th scope="col">Código</th>
                <th scope="col">Usuário</th>
                <th scope="col">Quantidade de ajustes</th>
                <th scope="col"></th>

            </tr>
        </thead>
        <tbody>
            <?php while ($linha = mysqli_fetch_assoc($consultar_ajuste_estoque)) {
                $codigo_nf = $linha['cl_codigo_nf'];
                $data_lancamento = $linha['cl_data_lancamento'];
                $usuario = $linha['cl_usuario'];
                $qtd_ajst = qtd_ajst($conecta,$codigo_nf);
                if ($codigo_nf != "") {
            ?>
                    <tr>
                        <th scope="row"><?php echo formatDateB($data_lancamento); ?></th>
                        <th scope="row"><?php echo $codigo_nf ?></th>
                        <th scope="row"><?php echo $usuario ?></th>
                        <th scope="row"><?php echo $qtd_ajst ?></th>
                        <td class="td-btn"><button type="button" data_lancamento="<?php echo $data_lancamento; ?>" codigo_nf=<?php echo $codigo_nf; ?> class="btn btn-sm btn-info editar_ajuste">Editar</button>
                        </td>
                    </tr>
            <?php
                }
            } ?>
        </tbody>
    </table>
    <label>
        Registros <?php echo $qtd; ?>
    </label>

<?php
} else {
    include "../../../../view/alerta/alerta_pesquisa.php"; // mesnsagem para usuario pesquisar
}
?>
<script src="js/estoque/ajuste_estoque/table/editar_ajuste_estoque.js">
<?php
include "../../../../conexao/conexao.php";
include "../../../../modal/configuracao/forma_pagamento/gerenciar_forma_pagamento.php";

?>
<?php
if (!isset($consultar_tabela_inicialmente) or ($consultar_tabela_inicialmente == "S")) { //consultar parametro para carrregar inicialmente a tabela
?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Forma de pagamneto</th>
                <th scope="col">Forma de pagamneto</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php while ($linha = mysqli_fetch_assoc($consultar_forma_pagamento)) {
                $forma_de_pagamento_id_b = $linha['cl_id'];
                $descricao_b = $linha['cl_descricao'];

            ?>
                <tr>

                    <th scope="row"><?php echo $forma_de_pagamento_id_b ?></th>
                    <td class="max_width_descricao"><?php echo $descricao_b; ?></td>


                    <td class="td-btn"><button type="button" forma_de_pagamento_id=<?php echo $forma_de_pagamento_id_b; ?> class="btn btn-info   btn-sm editar_forma_pagamento ">Editar</button>
                    </td>
                </tr>

            <?php } ?>
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
<script src="js/configuracao/forma_pagamento/table/editar_forma_pagamento.js">
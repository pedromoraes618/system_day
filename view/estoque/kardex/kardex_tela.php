<?php
include "../../../funcao/funcao.php";
if (isset($_GET['form_id'])) {
    $form_id = $_GET['form_id'];
} else {
    $form_id = "";
}
?>

<div class="modal fade" id="modal_kardex" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header mb-2">
                <h1 class="modal-title fs-5">Kardex</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body">
                <div class="title mb-2">
                    <label class="form-label sub-title">Histórico do produto</label>
                </div>

                <div class="row">
                    <div class="col-sm-4 col-auto  mb-2">
                        <input type="hidden" id="id" value="<?php echo $form_id; ?>">
                        <div class="input-group">
                            <span class="input-group-text">Movimento</span>
                            <input type="text" class="form-control inputnumber" maxlength="10" onkeyup="mascaraData(this);" id="data_inicial" name="data_incial" title="Data vencimento" placeholder="Data Inicial" value="<?php echo $data_inicial ?>">
                            <input type="text" class="form-control inputnumber" maxlength="10" onkeyup="mascaraData(this);" id="data_final" name="data_final" title="Data vencimento" placeholder="Data Final" value="<?php echo $data_final; ?>">
                        </div>
                    </div>
                    <div class="col-md  mb-2">
                        <div class="input-group">
                            <input type="text" class="form-control" id="pesquisa_conteudo_kardex" placeholder="Tente pesquisar pelo Doc" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn btn-outline-secondary" type="button" id="pesquisar_filtro_kardex">Pesquisar</button>
                        </div>
                    </div>
                    <div class="col-md-auto  d-grid gap-2 d-sm-block mb-2">
                        <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
                <div class="row">

                    <div class="tabela">

                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../../../funcao/funcaojavascript.jar'; ?>
<div class="modal_externo"></div>
<script src="js/funcao.js"></script>
<script src="js/estoque/kardex/gerenciar_kardex.js"></script>
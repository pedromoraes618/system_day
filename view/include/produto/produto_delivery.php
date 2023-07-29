<?php
include "../../../conexao/conexao.php";
include "../../../modal/estoque/produto/gerenciar_produto.php";

?>


<div class="modal fade" id="modal_produto_delivery" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Delivery produto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body">

                <div class="row  mb-2">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end btn-acao">
                        <button <?php if ($id_produto == "") {
                                    echo "type='button'";
                                } else {
                                    echo "type='submit'";
                                } ?> id="salvar_prod_delivery" class="btn btn-sm btn-success">Salvar</button>
                        <button type="button" class="btn btn btn-sm  btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-auto">
                        <div class="col-auto mb-3 ">
                            <div class="bg-secondary img-upload bg-img-produto rounded-circle">
                                <button type="button" class="btn btn-secondary border-0" id="open_upload_img_prod"><i class="bi bi-camera"></i></button>
                            </div>
                        </div>

                    </div>
                    <div class="col-md">
                        <div class="row mb-2">
                            <div class="col-md  mb-2">
                                <label for="descricao_delivery_modal" class="form-label">Descrição</label>
                                <input type="text" class="form-control" name="descricao_delivery_modal" id="descricao_delivery_modal" placeholder="Máximo 50 caracteres" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md mb-2">
                                <label for="descricao_completo_delivery_modal" class="form-label">Descrição completo</label>
                                <textarea name="descricao_completo_delivery_modal" id="descricao_completo_delivery_modal" class="form-control" cols="30" rows="5" placeholder="Máximo 500 caracteres"></textarea>
                            </div>
                        </div>
                        <?php if ($id_produto != "") { ?>
                            <div class="row">
                                <div class="col">
                                    <div class="card p-0">
                                        <div class="card-header h-50 d-flex justify-content-center">
                                            <div class="mx-3">
                                                <span class="badge text-bg-dark">Adicionais obrigatórios</span>
                                            </div>
                                            <div>

                                                <select name="max_add_obg" class="form-control p-2 m-0">
                                                    <option value="0">0</option>
                                                    <?php for ($i = 1; $i <= $qtd_consultar_produto_adicional_delivery_obg; $i++) {
                                                    ?>
                                                        <option <?php if ($qtd_max_obg == "$i") {
                                                                    echo 'selected';
                                                                } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="card-body p-1">
                                            <?php while ($linha = mysqli_fetch_assoc($consultar_produto_adicional_delivery_obg)) {

                                                $id_prod_add = $linha['cl_id'];
                                                $descricao = utf8_encode($linha['cl_descricao']);

                                                $select = "SELECT * FROM tb_produto_adicional_delivery WHERE cl_produto_adicional_id = '$id_prod_add' AND cl_status_ativo ='SIM' AND cl_obrigatorio='SIM' AND cl_produto_id ='$id_produto' "; // Aqui concatenamos o valor de $("#id").val() na string PHP.

                                                $consultar_status_ativo_add = mysqli_query($conecta, $select);
                                                $qtd_consultar_status_ativo_add = mysqli_num_rows($consultar_status_ativo_add);
                                                if ($qtd_consultar_status_ativo_add > 0) {
                                                    $check = "checked";
                                                } else {
                                                    $check = "";
                                                }
                                            ?>

                                                <div class="form-check form-check-inline" style="font-size: 0.8em">
                                                    <input class="form-check-input" type="checkbox" <?php echo $check; ?> id="addobg<?php echo $id_prod_add; ?>" name="addobg<?php echo $id_prod_add; ?>" value="">
                                                    <label class="form-check-label" for="addobg<?php echo $id_prod_add; ?>"><?php echo $descricao; ?></label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="card p-0">
                                        <div class="card-header h-50 d-flex justify-content-center">
                                            <div class="mx-3">
                                                <span class="badge text-bg-dark">Adicionais</span>
                                            </div>
                                        </div>
                                        <div class="card-body p-1">
                                            <?php while ($linha = mysqli_fetch_assoc($consultar_produto_adicional_delivery)) {

                                                $id_prod_add = $linha['cl_id'];
                                                $descricao = utf8_encode($linha['cl_descricao']);

                                                $select = "SELECT * FROM tb_produto_adicional_delivery WHERE cl_produto_adicional_id = '$id_prod_add' AND
                                             cl_status_ativo ='SIM' AND cl_obrigatorio='NAO' AND cl_produto_id ='$id_produto'";

                                                $consultar_status_ativo_add = mysqli_query($conecta, $select);
                                                $qtd_consultar_status_ativo_add = mysqli_num_rows($consultar_status_ativo_add);
                                                if ($qtd_consultar_status_ativo_add > 0) {
                                                    $check = "checked";
                                                } else {
                                                    $check = "";
                                                }
                                            ?>
                                                <div class="form-check form-check-inline" style="font-size: 0.8em">
                                                    <input class="form-check-input" type="checkbox" <?php echo $check; ?> id="add<?php echo $id_prod_add; ?>" name="add<?php echo $id_prod_add; ?>" value="">
                                                    <label class="form-check-label" for="add<?php echo $id_prod_add; ?>"><?php echo $descricao; ?></label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="modal_externo_modal"></div>

    </div>
</div>
</div>


<script src="js/include/produto/produto_delivery.js"></script>
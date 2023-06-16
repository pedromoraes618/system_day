<?php
include "../../../conexao/conexao.php";
include "../../../modal/estoque/produto/gerenciar_produto.php";
?>
<div class="modal fade" id="modal_produto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl   ">
        <div class="modal-content ">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Produto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="" id="produto">
                <?php include "../../input_include/usuario_logado.php" ?>
                <input type="hidden" id="id" name="id" value="<?php if (isset($_GET['form_id'])) {
                                                                    echo $_GET['form_id'];
                                                                } ?>">

                <div class="modal-body">
                    <div class="title mb-2">
                        <label class="form-label sub-title"></label>
                    </div>
                    <div class="row  mb-2">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                            <button type="submit" id="button_form"  class="btn btn-sm btn-success"></button>
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <input type="hidden" name="formulario_cadastrar_produto">
                        <?php include "../../input_include/usuario_logado.php" ?>
                        <div class="col-sm col-md-5  mb-2">
                            <label for="descricao" class="form-label">Descrição</label>
                            <input type="text" class="form-control " id="descricao" name="descricao" value="">
                        </div>
                        <div class="col-sm-6 col-md-2   mb-2">
                            <label for="referencia" class="form-label">Referência</label>
                            <input type="text" class="form-control" id="referencia" name="referencia" value="">
                        </div>
                        <div class="col-sm-6 col-md-2 mb-2">
                            <label for="equivalencia" class="form-label">Equivalencia</label>
                            <input type="text" class="form-control" id="equivalencia" name="equivalencia" value="">
                        </div>
                        <div class="col-sm-6 col-md-3  mb-2">
                            <label for="codigo_barras" class="form-label">Código de barras</label>
                            <input type="text" class="form-control" id="codigo_barras" name="codigo_barras" value="">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4  mb-2">
                            <label for="grupo_estoque" class="form-label">Grupo</label>
                            <select name="grupo_estoque" title="ao selecionar o grupo, os campos serão preenchidos automaticamente, para desativar essa funcionalidade verifique com o suporte" class="form-select" id="grupo_estoque">
                                <option value="0">Selecione..</option>
                                <?php while ($linha  = mysqli_fetch_assoc($consultar_subgrupo_estoque)) {
                                    $id_grupo = $linha['cl_id'];
                                    $descricao_b = utf8_encode($linha['cl_descricao']);
                                    $grupo = utf8_encode($linha['grupo']);
                                    echo "<option value='$id_grupo'> $grupo - $descricao_b </option>'";
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="fabricante" class="form-label">Fabricante</label>
                            <select name="fabricante" class="form-select" id="fabricante">
                                <option value="0">Selecione..</option>
                                <?php while ($linha  = mysqli_fetch_assoc($consultar_fabricantes)) {
                                    $id_fabricante = $linha['cl_id'];
                                    $descricao = utf8_encode($linha['cl_descricao']);

                                    echo "<option value='$id_fabricante' >$descricao</option>";
                                } ?>
                            </select>
                        </div>

                        <div class="col-md-3 mb-2">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select name="tipo" class="form-select" id="tipo">
                                <option value="0">Selecione..</option>
                                <?php while ($linha  = mysqli_fetch_assoc($consultar_tipo_produto)) {
                                    $id_tipo = $linha['cl_id'];
                                    $descricao = utf8_encode($linha['cl_descricao']);

                                    echo "<option  value='$id_tipo'>$descricao</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-select" id="status">
                                <option value="0">Selecione..</option>
                                <option selected value="SIM">Ativo</option>
                                <option value="NAO">Inativo</option>

                            </select>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <span class="badge rounded-2 mb-3 d-area dv">Informações de estoque</span>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-6 col-md-2   mb-2">
                            <label for="estoque" class="form-label">Estoque</label>
                            <input type="text" class="form-control inputNumber" id="estoque" name="estoque" value="">
                        </div>

                        <div class="col-sm-6 col-md-2  mb-2">
                            <label for="est_minimo" class="form-label">Estoque Mínimo</label>
                            <input type="text" class="form-control inputNumber" id="est_minimo" name="est_minimo" value="">
                        </div>

                        <div class="col-sm-6 col-md-2  mb-2">
                            <label for="est_maximo" class="form-label">Estoque Máximo</label>
                            <input type="text" class="form-control inputNumber" id="est_maximo" name="est_maximo" value="">
                        </div>
                        <div class="col-sm-6 col-md-2   mb-2">
                            <label for="local_produto" class="form-label">Local de Produto</label>
                            <input type="text" class="form-control" id="local_produto" name="local_produto" value="">
                        </div>
                        <div class="col-sm-6 col-md-2   mb-2">
                            <label for="tamanho" class="form-label">Tamanho</label>
                            <input type="text" class="form-control" id="tamanho" name="tamanho" value="">
                        </div>
                        <div class="col-sm-6 col-md-2  mb-2">
                            <label for="unidade_md" class="form-label">Unidade de medida</label>
                            <select name="unidade_md" class="form-select" id="unidade_md">
                                <option value="0">Selecione..</option>
                                <?php while ($linha  = mysqli_fetch_assoc($consultar_und_medida)) {
                                    $id_und = $linha['cl_id'];
                                    $descricao_und = utf8_encode($linha['cl_descricao']);
                                    $sigla_und = utf8_encode($linha['cl_sigla']);

                                    echo "<option  value='$id_und'> $descricao_und - $sigla_und </option>";
                                } ?>
                            </select>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <span class="badge rounded-2 mb-3 d-area dv">Informações de Valores</span>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-6 col-md-2   mb-2">
                            <label for="prc_venda" class="form-label">Preço de venda</label>
                            <input type="text" class="form-control inputNumber" onchange="maregm_lucro()" id="prc_venda" name="prc_venda" value="">
                        </div>
                        <div class="col-sm-6 col-md-2   mb-2">
                            <label for="prc_custo" class="form-label">Preço de Custo</label>
                            <input type="text" class="form-control inputNumber" onchange="maregm_lucro()" id="prc_custo" name="prc_custo" value="">
                        </div>

                        <div class="col-sm-6 col-md-2  mb-2">
                            <label for="margem_lucro" class="form-label">Magem de lucro %</label>
                            <input type="text" class="form-control inputNumber" onchange="preco_venda()" id="margem_lucro" name="margem_lucro" value="">
                        </div>

                        <div class="col-sm-6 col-md-2   mb-2">
                            <label for="prc_promocao" class="form-label">Preço Promoção</label>
                            <input type="text" class="form-control inputNumber" id="prc_promocao" name="prc_promocao" value="">
                        </div>
                        <div class="col-sm-6 col-md-2   mb-2">
                            <label for="desconto_maximo" class="form-label">Desconto Máximo %</label>
                            <input type="text" class="form-control inputNumber" id="desconto_maximo" name="desconto_maximo" value="">
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <span class="badge rounded-2 mb-3 d-area dv">Informações Fiscais</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-6 col-md-2   mb-2">
                            <label for="cest" class="form-label">Cest</label>
                            <div class="input-group c mb-3">
                                <input type="text" class="form-control inputNumber" id="cest" name="cest" aria-label="Recipient's username" aria-describedby="button-addon2">

                                <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modal_cunsultar_cest" data-bs-whatever="@mdo" title="pesquise pelo cest" type="button"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-2   mb-2">
                            <label for="ncm" class="form-label">Ncm</label>
                            <div class="input-group c mb-3">
                                <input type="text" class="form-control inputNumber" id="ncm" name="ncm" aria-label="Recipient's username" aria-describedby="button-addon2">

                                <button class="btn btn-outline-secondary" title="pesquise pelo ncm" data-bs-toggle="modal" data-bs-target="#modal_cunsultar_ncm" data-bs-whatever="@mdo" type="button"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-2   mb-2">
                            <label for="cst_icms" class="form-label">Cst icms</label>
                            <input class="form-control inputNumber" list="datalistOptionsIcms" id="cst_icms" name="cst_icms">
                            <datalist id="datalistOptionsIcms">
                                <?php while ($linha  = mysqli_fetch_assoc($consultar_icms)) {

                                    $icms_b = ($linha['cl_icms']);
                                    $descricao_b = utf8_encode($linha['cl_descricao']);

                                    echo "<option  value='$icms_b'> $descricao_b</option>";
                                } ?>
                            </datalist>
                        </div>



                        <div class="col-sm-6 col-md-1   mb-2">
                            <label for="cst_pis_s" class="form-label">Cst Pis S</label>
                            <input type="text" list="datalistOptionsPisS" class="form-control inputNumber" id="cst_pis_s" name="cst_pis_s" value="">
                            <datalist id="datalistOptionsPisS">
                                <?php while ($linha  = mysqli_fetch_assoc($consultar_pis_s)) {

                                    $icms_b = ($linha['cl_pis']);
                                    $descricao_b = utf8_encode($linha['cl_descricao']);

                                    echo "<option  value='$icms_b'> $descricao_b</option>";
                                } ?>
                            </datalist>
                        </div>

                        <div class="col-sm-6 col-md-1   mb-2">
                            <label for="cst_pis_s" class="form-label">Cst Pis E</label>
                            <input type="text" list="datalistOptionsPisE" class="form-control inputNumber" id="cst_pis_e" name="cst_pis_e" value="">
                            <datalist id="datalistOptionsPisE">
                                <?php while ($linha  = mysqli_fetch_assoc($consultar_pis_e)) {

                                    $icms_b = ($linha['cl_pis']);
                                    $descricao_b = utf8_encode($linha['cl_descricao']);

                                    echo "<option  value='$icms_b'> $descricao_b</option>";
                                } ?>
                            </datalist>
                        </div>


                        <div class="col-sm-6 col-md-2   mb-2">
                            <label for="cst_cofins_s" class="form-label">Cst Cofins S</label>
                            <input type="text" list="datalistOptionsCofinsS" class="form-control inputNumber" id="cst_cofins_s" name="cst_cofins_s" value="">
                            <datalist id="datalistOptionsCofinsS">
                                <?php while ($linha  = mysqli_fetch_assoc($consultar_cofins_s)) {

                                    $icms_b = ($linha['cl_cofins']);
                                    $descricao_b = utf8_encode($linha['cl_descricao']);

                                    echo "<option  value='$icms_b'> $descricao_b</option>";
                                } ?>
                            </datalist>
                        </div>

                        <div class="col-sm-6 col-md-2   mb-2">
                            <label for="cst_cofins_e" class="form-label">Cst Cofins E</label>
                            <input type="text" list="datalistOptionsCofinsE" class="form-control inputNumber" id="cst_cofins_e" name="cst_cofins_e" value="">
                            <datalist id="datalistOptionsCofinsE">
                                <?php while ($linha  = mysqli_fetch_assoc($consultar_cofins_e)) {
                                    $icms_b = ($linha['cl_cofins']);
                                    $descricao_b = utf8_encode($linha['cl_descricao']);

                                    echo "<option  value='$icms_b'> $descricao_b</option>";
                                } ?>
                            </datalist>
                        </div>

                        <div class="row mb-2">
                            <div class="col-sm-6 col-md-8   mb-2">
                                <label for="prc_venda" class="form-label">Observação</label>
                                <textarea class="form-control" name="observacao" id="observacao" aria-label="With textarea"></textarea>

                            </div>
                        </div>

                        <div class="">
                            <input type="hidden" class="form-control inputNumber" id="cfop_interno" name="cfop_interno" value="">
                            <input type="hidden" class="form-control inputNumber" id="cfop_externo" name="cfop_externo" value="">
                        </div>


                    </div>

                    <?php
                    // //incluir modal do cest
                    // include "../../../view/estoque/produto/include/cest.php";
                    // include "../../../view/estoque/produto/include/ncm.php";
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal_externo">

</div>
<script src="js/funcao.js"></script>
<script src="js/configuracao/users/user_logado.js"></script>
<script src="js/estoque/produto/produto_tela.js"></script>
<!-- 
<script src="js/estoque/produto/funcao/consultar.js"></script>

<script src="js/estoque/produto/cadastrar_produto.js"></script> -->
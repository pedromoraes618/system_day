<?php

include "../../../conexao/conexao.php";
include "../../../modal/venda/venda_mercadoria/gerenciar_venda.php";
include "../../../funcao/funcao.php";
?>
<div class="modal fade" id="modal_adicionar_venda" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Venda mercadoria</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="" id="venda_mercadoria">
                <?php include "../../input_include/usuario_logado.php" ?>
                <input type="hidden" id="id" name="id" value="<?php if (isset($_GET['form_id'])) {
                                                                    echo $_GET['form_id'];
                                                                } ?>">
                <input type="hidden" id="tipo" name="tipo" value="<?php if (isset($_GET['tipo'])) {
                                                                        echo $_GET['tipo'];
                                                                    } ?>">
                <input type="hidden" id="momento_venda" name="momento_venda" value="">
                <input type="hidden" class="form-control" name="observacao" id="observacao">
                <div class="modal-body">
                    <div class="title mb-2">
                        <label class="form-label sub-title"></label>
                        <label class="bg-primary status_momento_venda"></label>
                    </div>

                    <div class="row  mb-2">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                            <button type="button" id="iniciar_venda" class="btn btn-sm btn-primary">Iniciar venda</button>
                            <button type="button" id="modal_observacao" class="btn btn-sm btn-dark">Observação</button>
                            <button type="button" id="concluir_venda" onclick="calcula_v_liquido()" class="btn btn-sm btn-success">Concluir</button>
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                    <div class="card border-0 p-2 mb-2 shadow">
                        <div class="row mb-2">
                            <div class="col-md-3  mb-2">
                                <label for="data_movimento" class="form-label">Data Movimento</label>
                                <input type="text" class="form-control" maxlength="10" disabled onkeyup="mascaraData(this);" id="data_movimento" name="data_movimento" value="<?php if (!isset($_GET['form_id'])) {
                                                                                                                                                                                    echo $data_final;
                                                                                                                                                                                } ?>">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md  mb-2">
                                <label for="parceiro_descricao" class="form-label">Cliente</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" disabled id="parceiro_descricao" placeholder="Pesquise pelo Cliente/Fornecedor" aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <input type="hidden" class="form-control" name="parceiro_id" id="parceiro_id" value="">
                                    <button class="btn btn-outline-secondary" type="button" name="modal_parceiro" id="modal_parceiro">Pesquisar</button>
                                    <button class="btn btn-outline-danger " type="button" name="modal_parceiro_avulso" id="modal_parceiro_avulso">S/Cadastro</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 p-2 mb-2 shadow">
                        <div class="row mb-2">
                            <div class="col-md  mb-2">
                                <label for="descricao_produto" class="form-label">Produto</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" readonly id="descricao_produto" placeholder="">
                                    <input type="hidden" class="form-control" name="produto_id" id="produto_id" value="">
                                    <input type="hidden" class="form-control" name="referencia" id="referencia" value="">
                                    <input type="hidden" class="form-control" name="estoque" id="estoque" value="">
                                    <button class="btn btn-outline-secondary" type="button" name="modal_produto" id="modal_produto">Pesquisar</button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-1 mb-2">
                                <label for="quantidade" class="form-label">Unidade</label>
                                <input type="text" class="form-control" disabled name="unidade" id="unidade" value="">
                            </div>
                            <div class="col-md-2  mb-2">
                                <label for="quantidade" class="form-label">Quantidade</label>
                                <input type="text" class="form-control inputNumber" onblur="calcular_valor_total()" name="quantidade" id="quantidade" value="">
                            </div>
                            <div class="col-md  mb-2">
                                <label for="preco_venda" class="form-label">Preço Venda</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">R$</span>
                                    <input type="text" class="form-control inputNumber" onblur="calcular_desconto(),calcular_valor_total()" name="preco_venda" id="preco_venda" value="">
                                    <input type="hidden" class="form-control inputNumber" name="preco_venda_atual" id="preco_venda_atual" value="">
                                </div>
                            </div>


                            <div class="col-md  mb-2">
                                <label for="desconto" class="form-label">Desconto</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">%</span>
                                    <input type="text" class="form-control inputNumber" onblur="calcular_preco_venda()" name="desconto" id="desconto" value="">
                                </div>
                            </div>
                            <div class="col-md  mb-2">
                                <label for="valor_total_item" class="form-label">Preço total</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">R$</span>
                                    <input type="text" class="form-control" disabled name="valor_total" id="valor_total" value="">
                                    <button type="button" id="adicionar_produto" onclick="calcular_valor_total()" class="btn btn-success">Adicionar</button>
                                </div>
                                <input type="hidden" class="form-control" name="valor_total_item" id="valor_total_item" value="">
                            </div>
                        </div>
                    </div>
                    <div class="card p-2 border-0 border-top shadow tabela_modal tabela mb-2">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Código</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Unidade</th>
                                    <th scope="col">Referência</th>
                                    <th scope="col">P. Unitário</th>
                                    <th scope="col">Qtd</th>
                                    <th scope="col">Total</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="tabela_produtos">

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="row">Total</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <th id="valor_total_produtos" scope="row">
                                        </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div sr class="modal_externo_finalizar_venda">

                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal_externo">

</div>


<script src="js/funcao.js"></script>
<script src="js/configuracao/users/user_logado.js"></script>
<script src="js/venda/venda_mercadoria/venda_tela.js"></script>
<!-- <script src="js/include/parceiro/pesquisa_parceiro.js"></script> -->
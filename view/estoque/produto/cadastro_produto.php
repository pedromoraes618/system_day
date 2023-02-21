<?php  
include "../../../conexao/conexao.php";
include "../../../modal/estoque/produto/gerenciar_produto.php";  
?>


<div class="title">
    <label class="form-label">Cadastrar Produtos</label>
    <div class="msg_title">
        <p>Cadastrar grupo de estoque </p>
    </div>
</div>
<hr>
<form id="cadastrar_grupo_estoque">
    <div class="row mb-2">
        <input type="hidden" name="formulario_cadastrar_grupo_estoque">
        <?php include "../../input_include/usuario_logado.php"?>
        <div class="col-sm col-md-5  mb-2">
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" placeholder="" value="">
        </div>
        <div class="col-sm-6 col-md-2   mb-2">
            <label for="referencia" class="form-label">Referência</label>
            <input type="text" class="form-control" id="referencia" name="referencia" placeholder="" value="">
        </div>
        <div class="col-sm-6 col-md-2 mb-2">
            <label for="equivalencia" class="form-label">Equivalencia</label>
            <input type="text" class="form-control" id="equivalencia" name="equivalencia" placeholder="" value="">
        </div>
        <div class="col-sm-6 col-md-3  mb-2">
            <label for="codigo_barras" class="form-label">Código de barras</label>
            <input type="text" class="form-control" id="codigo_barras" name="codigo_barras" placeholder="" value="">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4  mb-2">
            <label for="grupo_estoque" class="form-label">Grupo</label>
            <select name="grupo_estoque" class="form-select" id="grupo_estoque">
                <option value="0">Selecione..</option>
                <?php while($linha  = mysqli_fetch_assoc($consultar_subgrupo_estoque)){ 
                $id_grupo = $linha['id'];
                $descricao_b = utf8_encode($linha['cl_descricao']);
                $grupo = utf8_encode($linha['grupo']);
                echo "<option value='$id_grupo'>$grupo - $descricao_b </option>'";
             }?>
            </select>
        </div>
        <div class="col-md-3 mb-2">
            <label for="fabricante" class="form-label">Fabricante</label>
            <select name="fabricante" class="form-select" id="fabricante">
                <option value="0">Selecione..</option>
                <?php while($linha  = mysqli_fetch_assoc($consultar_fabricantes)){ 
                $id_und = $linha['cl_id'];
                $descricao= utf8_encode($linha['cl_descricao']);
            
                echo "<option  value='$id_und'>$descricao</option>";
             }?>
            </select>
        </div>

        <div class="col-md-3 mb-2">
            <label for="tipo" class="form-label">Tipo</label>
            <select name="tipo" class="form-select" id="tipo">
                <option value="0">Selecione..</option>
                <?php while($linha  = mysqli_fetch_assoc($consultar_tipo_produto)){ 
                $id_und = $linha['cl_id'];
                $descricao= utf8_encode($linha['cl_descricao']);
            
                echo "<option  value='$id_und'>$descricao</option>";
             }?>
            </select>
        </div>
        <div class="col-md-2 mb-2">
            <label for="fabricante" class="form-label">Status</label>
            <select name="fabricante" class="form-select" id="fabricante">
                <option value="0">Selecione..</option>
                <option value="SIM">Ativo</option>
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
            <input type="text" class="form-control inputNumber" id="estoque" name="estoque" placeholder="EX. 10"
                value="">
        </div>

        <div class="col-sm-6 col-md-2  mb-2">
            <label for="est_minimo" class="form-label">Estoque Mínimo</label>
            <input type="text" class="form-control inputNumber" id="est_minimo" name="est_minimo" placeholder="Ex. 5"
                value="">
        </div>

        <div class="col-sm-6 col-md-2  mb-2">
            <label for="est_maximo" class="form-label">Estoque Máximo</label>
            <input type="text" class="form-control inputNumber" id="est_maximo" name="est_maximo" placeholder="Ex. 20"
                value="">
        </div>
        <div class="col-sm-6 col-md-2   mb-2">
            <label for="local_produto" class="form-label">Local de Produto</label>
            <input type="text" class="form-control" id="local_produto" name="local_produto"
                placeholder="Ex. prateleira a2" value="">
        </div>
        <div class="col-sm-6 col-md-2   mb-2">
            <label for="tamanho" class="form-label">Tamanho</label>
            <input type="text" class="form-control" id="tamanho" name="tamanho" placeholder="Ex. prateleira a2"
                value="">
        </div>
        <div class="col-sm-6 col-md-2  mb-2">
            <label for="unidade_md" class="form-label">Unidade de medida</label>
            <select name="unidade_md" class="form-select" id="unidade_md">
                <option value="0">Selecione..</option>
                <?php while($linha  = mysqli_fetch_assoc($consultar_und_medida)){ 
                $id_und = $linha['cl_id'];
                $descricao_und= utf8_encode($linha['cl_descricao']);
                $sigla_und = utf8_encode($linha['cl_sigla']);

                echo "<option  value='$id_und'> $descricao_und - $sigla_und </option>";
             }?>
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
            <input type="text" class="form-control inputNumber" onchange="maregm_lucro()" id="prc_venda" name="prc_venda"
                placeholder="EX. 1500.50" value="">
        </div>
        <div class="col-sm-6 col-md-2   mb-2">
            <label for="prc_custo" class="form-label">Preço de Custo</label>
            <input type="text" class="form-control inputNumber" onchange="maregm_lucro()"  id="prc_custo" name="prc_custo"
                placeholder="EX. 1100.20" value="">
        </div>


        <div class="col-sm-6 col-md-2  mb-2">
            <label for="margem_lucro" class="form-label">Magem de lucro %</label>
            <input type="text" class="form-control inputNumber" id="margem_lucro" name="margem_lucro"
                placeholder="Ex. 5" value="">
        </div>

        <div class="col-sm-6 col-md-2   mb-2">
            <label for="prc_promocao" class="form-label">Preço Promoção</label>
            <input type="text" class="form-control inputNumber" id="prc_promocao" name="prc_promocao"
                placeholder="Ex. 35.29" value="">
        </div>
        <div class="col-sm-6 col-md-2   mb-2">
            <label for="desconto_maximo" class="form-label">Desconto Máximo</label>
            <input type="text" class="form-control inputNumber" id="desconto_maximo" name="desconto_maximo"
                placeholder="Ex. 15" value="">
        </div>
        <div class="col-sm-6 col-md-2  mb-2">
            <label for="ult_prc_compra" class="form-label">Ultimo Preço de compra</label>
            <input type="text" class="form-control inputNumber" id="ult_prc_compra" name="ult_prc_compra"
                placeholder="Ex. prateleira a2" value="">
        </div>

    </div>

    <div class="row">
        <div class="col-sm">
            <span class="badge rounded-2 mb-3 d-area dv">Informações Fiscais</span>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-sm-6 col-md-3   mb-2">
            <label for="cest" class="form-label">Cest</label>
            <div class="input-group c mb-3">
                <input type="text" class="form-control" id="cest" name="cest" placeholder="Ex. 38151210"
                    aria-label="Recipient's username" aria-describedby="button-addon2">

                <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modal_cunsultar_cest"
                    data-bs-whatever="@mdo" type="button">Pesquisar</button>
            </div>
        </div>
        <!-- <label for="prc_venda" class="form-label">Cest</label>
            <input class="form-control" list="datalistOptions" id="cest" name="cest" placeholder="Type to search..."> -->



        <div class="col-sm-6 col-md-2   mb-2">
            <label for="prc_custo" class="form-label">Preço de Custo</label>
            <input type="text" class="form-control inputNumber" id="prc_custo" name="prc_custo"
                placeholder="EX. 1100.20" value="">
        </div>


        <div class="col-sm-6 col-md-2  mb-2">
            <label for="margem_lucro" class="form-label">Magem de lucro %</label>
            <input type="text" class="form-control inputNumber" id="margem_lucro" name="margem_lucro"
                placeholder="Ex. 5" value="">
        </div>

        <div class="col-sm-6 col-md-2   mb-2">
            <label for="prc_promocao" class="form-label">Preço Promoção</label>
            <input type="text" class="form-control inputNumber" id="prc_promocao" name="prc_promocao"
                placeholder="Ex. 35.29" value="">
        </div>
        <div class="col-sm-6 col-md-2   mb-2">
            <label for="desconto_maximo" class="form-label">Desconto Máximo</label>
            <input type="text" class="form-control inputNumber" id="desconto_maximo" name="desconto_maximo"
                placeholder="Ex. 15" value="">
        </div>
        <div class="col-sm-6 col-md-2  mb-2">
            <label for="ult_prc_compra" class="form-label">Ultimo Preço de compra</label>
            <input type="text" class="form-control inputNumber" id="ult_prc_compra" name="ult_prc_compra"
                placeholder="Ex. prateleira a2" value="">
        </div>

    </div>

    <?php
    //incluir modal do cest
     include "../../../view/estoque/produto/include/cest.php"; 
      ?>

    <div class="row">
        <div class="group-btn">
            <button type="subbmit" class="btn btn-success">Cadastrar</button>
            <button type="button" id="voltar_consulta" class="btn btn-outline-dark">Voltar Para consulta de
                produtos</button>
        </div>
    </div>



</form>
<script src="js/funcao.js"></script>
<script src="js/estoque/produto/funcao/consultar.js"></script>
<script src="js/configuracao/users/user_logado.js"></script>
<script src="js/estoque/produto/cadastrar_produto.js"></script>
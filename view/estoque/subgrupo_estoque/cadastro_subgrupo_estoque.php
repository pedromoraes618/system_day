<?php  include "../../../conexao/conexao.php"; ?>
<?php include "../../../modal/estoque/subgrupo_estoque/gerenciar_subgrupo_estoque.php";  
?>


<div class="title">
    <label class="form-label">Cadastrar subgrupo estoque</label>
    <div class="msg_title">
        <p>Cadastrar subgrupo de estoque </p>
    </div>
</div>
<hr>
<form id="cadastrar_subgrupo_estoque">
    <div class="row mb-3">
        <input type="hidden" name="formulario_cadastrar_subgrupo_estoque">
        <?php include "../../input_include/usuario_logado.php"?>
        <div class="col-sm  mb-2">
            <label for="descricao" class="form-label">Subgrupo</label>
            <input type="text" class="form-control" id="descricao" name="descricao"
                placeholder="Informe a descrição do subgrupo" value="">
        </div>
        <div class="col-sm  mb-2">
            <label for="grupo_estoque" class="form-label">Grupo Pai</label>
            <select name="grupo_estoque" class="form-select" id="grupo_estoque">
                <option value="0">Selecione..</option>
                <?php while($linha  = mysqli_fetch_assoc($consultar_grupo_estoque)){ 
                $id_grupo = $linha['cl_id'];
                $descricao_b = $linha['cl_descricao'];

                echo "<option value='$id_grupo'> $descricao_b </option>'";
             }?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <span class="badge rounded-2 mb-3 d-area dv">Informações quantitatiivas</span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm  mb-2">
            <label for="est_inicial" class="form-label">Estoque inicial</label>
            <input type="text" class="form-control inputNumber" id="est_inicial" name="est_inicial" placeholder="Ex.5"
                value="">
        </div>
        <div class="col-sm  mb-2">
            <label for="est_minimo" class="form-label">Estoque mínimo</label>
            <input type="text" class="form-control inputNumber" id="est_minimo" name="est_minimo" placeholder="Ex.20"
                value="">
        </div>
        <div class="col-sm  mb-2">
            <label for="est_maximo" class="form-label">Estoque máximo</label>
            <input type="text" class="form-control inputNumber" id="est_maximo" name="est_maximo" placeholder="Ex.200"
                value="">
        </div>
        <div class="col-sm  mb-2">
            <label for="local_estoque" class="form-label">Local de estoque</label>
            <input type="text" class="form-control" id="local_estoque" name="local_estoque"
                placeholder="Ex. prateleira Ab" value="">
        </div>

        <div class="col-sm  mb-2">
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
            <span class="badge rounded mb-3 d-area dv">Informações Fiscais</span>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4  mb-2">
            <label for="cfop_interno" class="form-label">Cfop Interno</label>
            <select name="cfop_interno" class="form-select" id="cfop_interno">
                <option value="0">Selecione..</option>
                <?php while($linha  = mysqli_fetch_assoc($consultar_cfop_interno)){ 
                $id_cfop = $linha['cl_id'];
                $codigo_cfop_b = $linha['cl_codigo_cfop'];
                $descricao_cfop_b = utf8_encode($linha['cl_desc_cfop']);
                echo "<option  value='$codigo_cfop_b'> $codigo_cfop_b - $descricao_cfop_b </option>";
             }?>
            </select>
        </div>
        <div class="col-md-4  mb-2">
            <label for="cfop_externo" class="form-label">Cfop Externo</label>
            <select name="cfop_externo" class="form-select" id="cfop_externo">
                <option value="0">Selecione..</option>
                <?php while($linha  = mysqli_fetch_assoc($consultar_cfop_externo)){ 
                $id_cfop = $linha['cl_id'];
                $codigo_cfop_externo_b = $linha['cl_codigo_cfop'];
                $descricao_cfop_externo_b = utf8_encode($linha['cl_desc_cfop']);
                echo "<option  value='$codigo_cfop_externo_b'> $codigo_cfop_externo_b  - $descricao_cfop_externo_b</option>";
             }?>
            </select>
        </div>
    </div>
    <div class="row">
    <div class="col-md-4  d-grid gap-2 d-sm-block mb-1  ">
            <button type="subbmit" class="btn btn-success">Cadastrar</button>
        </div>
    </div>


</form>
<script src="js/funcao.js"></script>
<script src="js/configuracao/users/user_logado.js"></script>
<script src="js/estoque/subgrupo_estoque/cadastrar_subgrupo_estoque.js"></script>
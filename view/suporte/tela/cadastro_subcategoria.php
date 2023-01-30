<?php  include "../../../conexao/conexao.php"; ?>
<?php   include "../../../modal/suporte/tela/gerenciar_tela.php" ?>
<form id="cadastrar_categoria">
    <div class="row">
        <input type="hidden" name="formulario_cadastrar_subcategoria">

        <?php include "../../input_include/usuario_logado.php"?>

        <div class="col-sm  mb-1">
            <label for="subcategoria" class="form-label">Subcategoria</label>
            <input type="text" class="form-control" id="subcategoria" name="subcategoria" placeholder="" value="">
        </div>
        <div class="col-sm  mb-1">
            <label for="ordem" class="form-label">Ordem</label>
            <input type="text" class="form-control" id="ordem" name="ordem" placeholder="" value="">
        </div>
        <div class="col-sm mb-1">
            <label for="diretorio_subc" class="form-label">Diretorio subcategoria</label>
            <input type="text" class="form-control" id="diretorio_subc" name="diretorio_subc" placeholder="" value="">
        </div>
    </div>
    <div class="row">
        <div class="col-sm  mb-1">
            <label for="url_sub" class="form-label">Url subcategoria</label>
            <input type="text" class="form-control" id="url_sub" name="url_sub" placeholder="" value="">
        </div>
        <div class="col-sm  mb-1">
            <label for="diretorio_bd" class="form-label">Diretorio Banco de dados</label>
            <input type="text" class="form-control" id="diretorio_bd" name="diretorio_bd" placeholder="" value="">
        </div>
     
        <div class="col-sm  mb-1">
            <label for="categoria" class="form-label">Categoria</label>
            <select name="categoria" class="form-select" id="categoria">
                <option value="0">Selecione</option>
                <?php while($linha = mysqli_fetch_assoc($consultar_categorias_selecao)){ 
                $id_categoria = $linha['cl_id'];
                $categoria_b = utf8_encode($linha['cl_categoria']);
                ?>
                <option value="<?php echo $id_categoria; ?>"><?php echo $categoria_b  ?></option>

                <?php
            } ?>
            </select>
        </div>

        <div class="group-btn">
            <button type="subbmit" class="btn btn-success">Cadastrar</button>
        </div>
    </div>


</form>


<script src="js/configuracao/users/user_logado.js"></script>
<script>
$("#cadastrar_categoria").submit(function(e) {
    e.preventDefault()
    var cadastrar = $(this);
    var retorno = cadastrar_categoria(cadastrar)

    var subcategoria = document.getElementById("subcategoria")
    var ordem = document.getElementById("ordem")
    var diretorio_subc = document.getElementById("diretorio_subc")
    var url_sub = document.getElementById("url_sub")
    var diretorio_bd = document.getElementById("diretorio_bd")
    var categoria = document.getElementById("categoria")


})

function cadastrar_categoria(dados) {
    $.ajax({
        type: "POST",
        data: dados.serialize(),
        url: "modal/suporte/tela/gerenciar_tela.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $sucesso = $.parseJSON(data)["sucesso"];
        $mensagem = $.parseJSON(data)["mensagem"];
        if ($sucesso) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Subcategoria cadastrada com sucesso',
                showConfirmButton: false,
                timer: 1500
            })



            //consultar subcaategorias já cadastradas
            $.ajax({
                type: 'GET',
                data: "consultar_tela_subcategoria=inicial",
                url: "view/suporte/tela/table/consultar_subcategoria.php",
                success: function(result) {
                    return $(".tabela").html(result);
                },
            });
            subcategoria.value = "";
            ordem.value = "";
            diretorio_subc.value = "";
            url_sub.value = "";
            diretorio_bd.value = "";
            categoria.value = "0";


        } else {
            Swal.fire({
                icon: 'error',
                title: $mensagem,

            })

        }
    }

    function falha() {
        console.log("erro");
    }

}
<?php 
include "../../../funcao/funcao.php";
include "../../../modal/configuracao/log/log.php";

//incluir data inial e final
?>
<div class="title">
    <label class="form-label">Consultar log do sistema</label>
</div>
<hr>

<div class="row">
    <div class="col-md-2  mb-1">
        <input type="text" class="form-control"  maxlength="10" onkeyup="mascaraData(this);"  id="data_incial" name="data_incial" placeholder="Data inicial"
            value="<?php echo $data_incial_log;?>">
    </div>
    <div class="col-md-2  mb-1">
        <input type="text" class="form-control" maxlength="10" onkeyup="mascaraData(this);"  id="data_final" name="data_final" placeholder="Data Final"
            value="<?php echo $data_final_log;?>">
    </div>

    <div class="col-md-2 mb-1">
        <select name="usuario" class="form-select" id="usuario">
            <option value="s">Selecione o usúario</option>
            <?php while($linha = mysqli_fetch_assoc($consultar_usuarios)){ 
                $id_user = $linha['cl_id'];
                $usuario = $linha['cl_usuario'];
                ?>
            <option value="<?php echo $usuario; ?>"><?php echo $usuario  ?></option>

            <?php
            } ?>
        </select>
    </div>
    <div class="col-md  mb-2">
        <div class="input-group">
            <input type="text" class="form-control" id="conteudo" placeholder="Tente pesquisar pela descrição"
                aria-label="Recipient's username" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="pesquisa_conteudo">Pesquisar</button>
        </div>
    </Div>
</div>
<?php include '../../../funcao/funcaojavascript.jar'; ?>

<script>
$("#pesquisa_conteudo").click(function(e) {
    $('.tabela').css("display", 'none')
    $('.tabela').fadeIn(500)
    let data_inicial = document.getElementById("data_incial").value;
    let data_final = document.getElementById("data_final").value;
    let usuario = document.getElementById("usuario").value;
    let conteudo = document.getElementById("conteudo").value;
    $.ajax({
        type: 'GET',
        data: "consultar_log=detelhado&data_inicial="+data_inicial+"&data_final="+data_final+"&usuario="+usuario+"&conteudo="+conteudo,
        url: "view/configuracao/log/table/consultar_log.php",
        success: function(result) {
            return $(".bloco-pesquisa-2 .table").html(result);
        },
    });
})
</script>
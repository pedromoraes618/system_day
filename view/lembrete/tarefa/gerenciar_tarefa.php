<div class="bloco-pesquisa-menu">
    <div class="bloco-pesquisa-1">

    </div>
    <div class="bloco-pesquisa-2">
        <div class="row">
            <div class="col-md-2  mb-1">
                <input type="text" class="form-control" maxlength="10" onkeyup="mascaraData(this);" id="data_inicial"
                    name="data_incial" placeholder="Data inicial" value="<?php echo $data_inicial ?>">
            </div>
            <div class="col-md-2  mb-1">
                <input type="text" class="form-control" maxlength="10" onkeyup="mascaraData(this);" id="data_final"
                    name="data_final" placeholder="Data Final" value="<?php echo $data_final;?>">
            </div>

            <div class="col-md-2 mb-1">
                <select name="status" class="form-select" id="status">
                    <option value="0">Status..</option>
                    <?php while($linha = mysqli_fetch_assoc($consultar_status_tarefas)){ 
                $id_status_tarefa = $linha['cl_id'];
                $descricao = $linha['cl_descricao'];
                ?>
                    <option value="<?php echo $id_status_tarefa; ?>"><?php echo $descricao  ?></option>
                    <?php
            } ?>
                </select>
            </div>
            <div class="col-md  mb-2">

                <div class="input-group">
                    <input type="text" class="form-control" id="pesquisa_conteudo"
                        placeholder="Tente pesquisar pela descrição ou valor" aria-label="Recipient's username"
                        aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="button" id="pesquisar_tarefa">Pesquisar</button>
                </div>
            </Div>
        </div>
        <div class="tabela">

        </div>

    </div>
</div>


<script>
$(document).ready(function() {
    $.ajax({
        type: 'GET',
        data: "cadastro_tarefa=true",
        url: "view/lembrete/tarefa/cadastro_tarefa.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1").html(result);
        },
    });
    //consultar parametros
    $.ajax({
        type: 'GET',
        data: "consultar_tarefa=inicial",
        url: "view/lembrete/tarefa/table/consultar_tarefa.php",
        success: function(result) {
            return $(".bloco-pesquisa-2 .tabela").html(result);
        },
    });
})

//valores do campo de pesquisa
let conteudo_pesquisa = document.getElementById("pesquisa_conteudo")
let conteudo_status = document.getElementById("status")
let data_inicial = document.getElementById("data_inicial")
let data_final = document.getElementById("data_final")
//consultar //tabela detalhado
$("#pesquisar_tarefa").click(function(e) {
    $('.tabela').css("display", 'none')
    $('.tabela').fadeIn(500)

    $.ajax({
        type: 'GET',
        data: "consultar_tarefa=detalhado&conteudo_pesquisa=" + conteudo_pesquisa.value +
            "&conteudo_status=" + conteudo_status.value+"&data_inicial="+data_inicial.value+"&data_final="+data_final.value,
        url: "view/lembrete/tarefa/table/consultar_tarefa.php",
        success: function(result) {
            return $(".bloco-pesquisa-2 .tabela").html(result);
        },
    });
})
</script>
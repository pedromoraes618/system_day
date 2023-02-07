
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
                        placeholder="Tente pesquisar pela descrição" aria-label="Recipient's username"
                        aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="button" id="pesquisar_tarefa">Pesquisar</button>
                </div>
            </Div>
        </div>
        <div class="tabela">

        </div>

    </div>
</div>


<script src="js/lembrete/minha_tarefa/gerenciar_minha_tarefa.js">

</script>
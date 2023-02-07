<?php  include "../../../conexao/conexao.php"; ?>
<?php include "../../../modal/lembrete/minha_tarefa/gerenciar_minha_tarefa.php";  
?>

<div class="title">
    <label class="form-label">Minhas tarefas</label>
    <div class="msg_title">
        <p>Adicione tarefas aos usúarios </p>
    </div>
</div>
<hr>
<form>
    <div class="row">
        <?php 
            while($linha  = mysqli_fetch_assoc($consultar_minhas_tarefas)){
                $data_lancamento_b = formatDateB($linha['cl_data_lancamento']);
                $descricao_b = utf8_encode($linha['cl_descricao']);
                $data_limite_b = formatDateB($linha['cl_data_limite']);
                $status_b = ($linha['status']);
                $status_id_b = ($linha['cl_status']);
                $usuario_ordem_b = $linha['usuarioord'];
                $comentario_b = utf8_encode($linha['cl_comentario']);
                $prioridade_b = ($linha['cl_prioridade']);
                $id_tarefa = ($linha['idtarefa']);
                $usuario_func = $linha['userfunc'];
        ?>

        <div class="col-sm-6 mb-3 mb-sm-0">
            <div class="card mb-2 card-tarefa card<?php echo $id_tarefa ?>">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-auto">
                            <span class="badge text-bg-primary"><?php echo $status_b; ?></span>
                        </div>
                        <div class="col-auto">
                            Dt lançamento: <?php echo $data_lancamento_b ?>
                        </div>


                        <?php if($data_limite_b != ""){ ?>
                        <div class="col-auto">
                            Dt limite: <?php echo $data_limite_b ?>
                        </div>
                        <?php }?>

                        <?php if($prioridade_b == "1"){?>

                        <div class="col-auto">
                            <span class="badge text-bg-danger">Prioridade</span>
                        </div>

                        <?php } ?>
                    </div>
                 
                    <div class="row mb-3">
                        <p class="card-text"><?php echo $descricao_b; ?></p>
                    </div>
                    <div class="row mb-3">
                        <p class="card-text">Obs: <?php echo $comentario_b; ?></p>
                    </div>
                    <div class="row mb-3">
                        <div class="col  mb-2">

                            <input type="text" class="form-control" id="comentario<?php echo $id_tarefa ?>"
                                name="comentario" placeholder="Adicione o seu comentario" value="">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-auto">
                            <button class="btn btn-info col-auto atualizar_tarefa" user_logado=<?php echo $usuario_func; ?>
                                status_tarefa=<?php echo $status_id_b; ?> id_tarefa=<?php echo $id_tarefa; ?>
                                type="button">Atualizar</button>
                        </div>
                        <div class="col-sm-5  mb-1">
                            <select name="status" id="status<?php echo $id_tarefa; ?>" class="form-select">
                                <option value="0">Status..</option>

                                <?php while($linha = mysqli_fetch_assoc($consultar_status_tarefas)){ 
                                $id_status_tarefa = $linha['cl_id'];
                                $descricao = $linha['cl_descricao'];
                                if($id_status_tarefa == $status_id_b){
                                    ?>
                                <option selected value="<?php echo $id_status_tarefa; ?>"><?php echo $descricao  ?></option>
                                <?php
                                }else{
                                     ?>
                                <option value="<?php echo $id_status_tarefa; ?>"><?php echo $descricao  ?></option>
                                <?php
                                 }    } ?>
                            </select>
                        </div>
                        <div class="col-auto">
                            Ordenador: <?php echo $usuario_ordem_b; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>

    </div>





</form>
<?php include '../../../funcao/funcaojavascript.jar'; ?>
<script src="js/lembrete/minha_tarefa/verificar_minha_tarefa.js"></script>
<script src="js/configuracao/users/user_logado.js"></script>
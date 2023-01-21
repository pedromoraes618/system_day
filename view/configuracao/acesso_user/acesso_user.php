<div class="bloco-pesquisa_config">
    <div class="bloco-pesquisa-1">
        <div class="col-sm-2  mb-1">
            <label for="select_user">Usuário</label>
            <select class="form-select" id="select_user">
                <option name="0" value="0">Selecione</option>
                <?php 
              while($linha = mysqli_fetch_assoc($consultar_usuarios)){?>
                <option value="<?php echo utf8_encode($linha["cl_id"]);?>">
                    <?php echo utf8_encode($linha["cl_usuario"]);?>
                </option>
                <?php
              }?>
            </select>
        </div>
    
        <div id="duvida" class="msg">
            <i class="fa-solid fa-comments"></i>

            <p>Apenas usuários tipo usuário estão nessa seleção de acessos</p>
        </div>
    </div>

    <div class="row bloco-pesquisa-2">
        <div class="col-sm-6 mb-3 mb-sm-0">

            <div class="card">
                <div class="card-header">
                    Acessos Disponiveis
                </div>
                <div class="card-body" id="card-body-1">

                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    Acessos Atuais
                </div>
                <div class="card-body">

                    <div class="sub_bloco_info-2">

                    </div>
                </div>
            </div>


        </div>




    </div>



</div>


<script src="js/configuracao/controle_de_acesso/script_selecao.js"></script>



</script>
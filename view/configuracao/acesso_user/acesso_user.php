<div class="bloco-topo">
    <p> <?php echo $categoria; ?> > Controle de acesso </p>
</div>
<div class="bloco-pesquisa_config">
    <div class="bloco-pesquisa-1">
        <div class="group-input">
            <label for="select_user">Usuário</label>
            <select id="select_user">
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
    <div class="bloco-pesquisa-2">

        <div class="sub_bloco">
            <div class="titulo">
                <p>Acessos disponiveis</p>
            </div>
            <div class="sub_bloco_info">

            </div>

        </div>
        <div class="sub_bloco">
            <div class="titulo">
                <p>Acessos Atuais</p>
            </div>
            <div class="sub_bloco_info-2">

            </div>

        </div>
    </div>

</div>


<script src="js/configuracao/controle_de_acesso/script_selecao.js"></script>


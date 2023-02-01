<form id="cadastrar_categoria">
    <div class="row">
        <input type="hidden" name="formulario_cadastrar_categoria">

        <?php include "../../input_include/usuario_logado.php"?>

        <div class="col-sm  mb-1">
            <label for="categoria" class="form-label">Categoria</label>
            <input type="text" class="form-control" id="categoria" name="categoria" placeholder="" value="">
        </div>
        <div class="col-sm  mb-1">
            <label for="icone" class="form-label">Icone</label>
            <input type="text" class="form-control" id="icone" name="icone"
                placeholder="Ex. <i class='<i class='bi bi-person'></i></i>" value="">
        </div>
        <div class="col-sm mb-1">
            <label for="ordem" class="form-label">Ordem</label>
            <input type="text" class="form-control" id="ordem" name="ordem" placeholder="Ex. 5" value="">
        </div>


        <div class="group-btn">
            <button type="subbmit" class="btn btn-success">Cadastrar</button>
        </div>
    </div>


</form>

<script src="js/configuracao/users/user_logado.js"></script>
<!-- cadastro da categoria -->
<script src="js/suporte/tela/cadastro_categoria.js"></script>


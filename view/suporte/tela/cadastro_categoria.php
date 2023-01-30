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
<script>
$("#cadastrar_categoria").submit(function(e) {
    e.preventDefault()
    var cadastrar = $(this);
    var retorno = cadastrar_categoria(cadastrar)

    var categoria = document.getElementById("categoria")
    var ordem = document.getElementById("ordem")
    var icone = document.getElementById("icone")

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
                title: 'Categoria cadastrada com sucesso',
                showConfirmButton: false,
                timer: 1500
            })
            //resetar valores de input
            categoria.value = "";
            ordem.value = "";
            icone.value = "";


            //consultar categorias já cadastradas
            $.ajax({
                type: 'GET',
                data: "consultar_tela_categoria=inicial",
                url: "view/suporte/tela/table/consultar_categoria.php",
                success: function(result) {
                    return $(".tabela").html(result);
                },
            });


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
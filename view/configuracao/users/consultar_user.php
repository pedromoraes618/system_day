<div class="row">
    <div class="col-md-2 mb-1">
        <select name="situacao" class="form-select" id="situacao_user">
            <option value="s">Situação do usúario</option>
            <option value="1">Ativo</option>
            <option value="0">Inativo</option>
        </select>
    </div>
    <div class="col-md  mb-2">
        <div class="input-group">
            <input type="text" class="form-control" id="pesquisa_conteudo" placeholder="Tente pesquisar pelo  usúario"
                aria-label="Recipient's username" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="pesquisar_user">Pesquisar</button>
        </div>
    </Div>
</div>
<div class="tabela">



</div>

<script>
$(document).ready(function(e) {
    //consultar inicial
    $.ajax({
        type: 'GET',
        data: "consultar_user=inicial",
        url: "view/configuracao/users/table/consultar_user.php",
        success: function(result) {
            return $(".tabela").html(result);
        },
    });
})
//valores do campo de pesquisa
let conteudo_pesquisa = document.getElementById("pesquisa_conteudo")
let conteudo_situacao = document.getElementById("situacao_user")
//consultar usuario especifico
$("#pesquisar_user").click(function(e) {
    $('.tabela').css("display", 'none')
    $('.tabela').fadeIn(500)

    $.ajax({
        type: 'GET',
        data: "consultar_user=detalhado&conteudo_pesquisa=" + conteudo_pesquisa.value+"&situacao_user="+conteudo_situacao.value,
        url: "view/configuracao/users/table/consultar_user.php",
        success: function(result) {
            return $(".tabela").html(result);
        },
    });
})
</script>
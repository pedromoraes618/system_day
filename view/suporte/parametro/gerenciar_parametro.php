<div class="bloco-pesquisa-menu">
    <div class="bloco-pesquisa-1">
        

    </div>
    <div class="bloco-pesquisa-2">
        <div class="row">
            <div class="col-md-2 mb-1">
                <select name="situacao" class="form-select" id="configuracao">
                    <option value="s">Configuração....</option>
                    <option value="seguranca">Segurança</option>
                    <option value="performance">Performance</option>
                    <option value="usuario">Usuário</option>
                    <option value="interface">Interface</option>
                </select>
            </div>
            <div class="col-md  mb-2">
                <div class="input-group">
                    <input type="text" class="form-control" id="pesquisa_conteudo"
                        placeholder="Tente pesquisar pela descrição ou valor" aria-label="Recipient's username"
                        aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="button" id="pesquisar_parametro">Pesquisar</button>
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
        data: "cadastro_parametro=true",
        url: "view/suporte/parametro/cadastro_parametro.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1").html(result);
        },
    });
    //consultar parametros
    $.ajax({
        type: 'GET',
        data: "consultar_parametro=inicial",
        url: "view/suporte/parametro/table/consultar_parametro.php",
        success: function(result) {
            return $(".bloco-pesquisa-2 .tabela").html(result);
        },
    });
})

//valores do campo de pesquisa
let conteudo_pesquisa = document.getElementById("pesquisa_conteudo")
let conteudo_configuracao = document.getElementById("configuracao")
//consultar usuario especifico
$("#pesquisar_parametro").click(function(e) {
    $('.tabela').css("display", 'none')
    $('.tabela').fadeIn(500)

    $.ajax({
        type: 'GET',
        data: "consultar_parametro=detalhado&conteudo_pesquisa=" + conteudo_pesquisa.value +
            "&conteudo_configuracao=" + conteudo_configuracao.value,
        url: "view/suporte/parametro/table/consultar_parametro.php",
        success: function(result) {
            return $(".bloco-pesquisa-2 .tabela").html(result);
        },
    });
})
</script>
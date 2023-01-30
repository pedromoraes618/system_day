<div class="bloco-pesquisa-menu">

    <div class="bloco-pesquisa-1">
        <div class="title">
            <label class="form-label">Alterar telas</label>
        </div>
        <hr>
        <div class="row-auto mb-sm-3">
            <button type="button" class="btn btn-outline-primary col-sm-2 btn_categoria btn_ativo">Categoria</button>
            <button type="button" class="btn btn-outline-secondary col-sm-2  btn_subcategoria">Subcategoria</button>
        </div>
        <div class="row-auto bloco-cadastro-1">

        </div>


    </div>

    <div class="row bloco-pesquisa-2">
        <div class="col-md  mb-2">
            <div class="input-group">
                <input type="text" class="form-control" id="conteudo" placeholder="Tente pesquisar pela Categoria ou a subcategoria"
                    aria-label="Recipient's username" aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary" type="button" id="pesquisa_conteudo">Pesquisar</button>
            </div>
        </div>
        <div class="tabela">


        </div>


    </div>



</div>

<script>
$(document).ready(function() {
    $.ajax({
        type: 'GET',
        data: "cadastro_categoria=true",
        url: "view/suporte/tela/cadastro_categoria.php",
        success: function(result) {
            return $(".bloco-cadastro-1").html(result);
        },
    });
    //consultar categorias já cadastradas
    $.ajax({
        type: 'GET',
        data: "consultar_tela_categoria=inicial",
        url: "view/suporte/tela/table/consultar_categoria.php",
        success: function(result) {
            return $(".tabela").html(result);
        },
    });
})

$(".btn_categoria").click(function() {
    $('.tabela').css("display", 'none')
    $('.tabela').fadeIn(500)
    //verificar se o atributo já possue a clase btn ativo
    if (!($(this).is(".btn_ativo"))) {
        $(this).addClass("btn_ativo");
        $('.btn_subcategoria').removeClass("btn_ativo")
    }

    $.ajax({
        type: 'GET',
        data: "cadastro_categoria=true",
        url: "view/suporte/tela/cadastro_categoria.php",
        success: function(result) {
            return $(".bloco-cadastro-1").html(result);
        },
    });
     //consultar categorias já cadastradas
     $.ajax({
        type: 'GET',
        data: "consultar_tela_categoria=inicial",
        url: "view/suporte/tela/table/consultar_categoria.php",
        success: function(result) {
            return $(".tabela").html(result);
        },
    });


})


$(".btn_subcategoria").click(function() {
    $('.tabela').css("display", 'none')
    $('.tabela').fadeIn(500)
    //verificar se o atributo já possue a clase btn ativo
    if (!($(this).is(".btn_ativo"))) {
        $(this).addClass("btn_ativo");
        $('.btn_categoria').removeClass("btn_ativo")
    }

    $.ajax({
        type: 'GET',
        data: "cadastro_categoria=true",
        url: "view/suporte/tela/cadastro_subcategoria.php",
        success: function(result) {
            return $(".bloco-cadastro-1").html(result);
        },
    });
    //consultar subcaategorias já cadastradas
    $.ajax({
        type: 'GET',
        data: "consultar_tela_subcategoria=inicial",
        url: "view/suporte/tela/table/consultar_subcategoria.php",
        success: function(result) {
            return $(".tabela").html(result);
        },
    });


})

$("#pesquisa_conteudo").click(function() {
    $('.tabela').css("display", 'none')
    $('.tabela').fadeIn(500)
    let pesquisa = document.getElementById("conteudo").value;
    //verificar se o atributo já possue a clase btn ativo
    if (($('.btn_categoria').is(".btn_ativo"))) {
        //consultar subcaategorias pelo filtro
        $.ajax({
        type: 'GET',
        data: "consultar_tela_categoria=detalhado&pesquisa="+pesquisa,
        url: "view/suporte/tela/table/consultar_categoria.php",
        success: function(result) {
            return $(".tabela").html(result);
        },
    });

    }else{
         //consultar subcaategorias pelo filtro
    $.ajax({
        type: 'GET',
        data: "consultar_tela_subcategoria=detalhado&pesquisa="+pesquisa,
        url: "view/suporte/tela/table/consultar_subcategoria.php",
        success: function(result) {
            return $(".tabela").html(result);
        },
    });
    
    }

 

})
</script>
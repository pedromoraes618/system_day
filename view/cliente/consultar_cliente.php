
 <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.4/jquery.inputmask.bundle.js"></script>
<div class="bloco-pesquisa">
    <div class="group-pesquisa">
        <div class="bloco-pesquisa-2">
            <p>Data</p>
            <div class="group-input-data">
                <input type="text" data-mask="00/00/0000">
                <input type="text" data-mask="00/00/0000">
            </div>
        </div>
        <div class="bloco-pesquisa-1">
            <div class="input-pesquisa">
                <input type="text" id="input-pesquisar-principal" placeholder="busque por razão social">
                <i id="buscar_pesquisa" class="fa-solid fa-magnifying-glass"></i>
            </div>
        </div>

        <div class="bloco-btn">
            <a
                onclick="window.open('?menu', 
'Editar_cotacao', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1600, HEIGHT=900');">
                <button class="btn-add" type="button">Adicionar</button>
            </a>
        </div>

    </div>
    <div class="tabela">

    </div>
</div>




<script src="js/jquery.js"></script>
<script>
$("#buscar_pesquisa").click(function(e) {

    // $('.bloco-principal .operacional').fadeIn(500)
    // $('.bloco-principal .operacional').slideDown(100)
    // $('.bloco-principal .operacional').css("display", "")
    $.ajax({
        type: 'GET',
        data: "tabela_cliente",
        url: "view/tabela/cliente/consultar_cliente.php",
        success: function(result) {
            return $(".bloco-right .bloco-pesquisa .tabela").html(result);
        },
    });
})
</script>
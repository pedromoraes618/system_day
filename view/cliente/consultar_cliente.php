<div class="bloco-pesquisa_config">

    <div class="bloco-pesquisa-1">

    </div>
    <div class="bloco-pesquisa-2">

    </div>

</div>

<script src="js/jquery.js"></script>
<script>
$("#buscar_pesquisa").click(function(e) {

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


<div class="bloco-pesquisa_config">
    <div class="bloco-pesquisa-1">
    </div>
    <div class="bloco-pesquisa-2">
    </div>

    

</div>
<script>
$(document).ready(function(e) {

    $.ajax({
        type: 'GET',
        data: "cadastrar",
        url: "view/configuracao/users/cadastrar_user.php",
        success: function(result) {
            return $(".bloco-pesquisa_config .bloco-pesquisa-1").html(result);
        },
    });
    $.ajax({
        type: 'GET',
        data: "consultar_user=",
        url: "view/configuracao/users/consultar_user.php",
        success: function(result) {
            return $(".bloco-pesquisa_config .bloco-pesquisa-2").html(result);
        },
    });
})
</script>
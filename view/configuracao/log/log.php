
<div class="bloco-pesquisa-menu">
    <div class="bloco-pesquisa-1">
    </div>
    <div class="bloco-pesquisa-2">
    </div>


</div>
<script>
$(document).ready(function(e) {
    $.ajax({
        type: 'GET',
        data: "filtro_log=",
        url: "view/configuracao/log/filtro_log.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1").html(result);
        },
    });
    $.ajax({
        type: 'GET',
        data: "consultar_log=inical",
        url: "view/configuracao/log/table/consultar_log.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-2").html(result);
        },
    });
})
</script>
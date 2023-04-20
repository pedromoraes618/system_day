$(document).ready(function() {
    // 
    var user = document.getElementById('user_logado').value

    //consultar informação tabela
    $(".bloco-pesquisa-menu .bloco-pesquisa-1-dashboard").css("display","block")
    $(".bloco-pesquisa-menu .bloco-pesquisa-2-dashboard").css("display","block") // aparecer tela de cadastro
    $.ajax({
        type: 'GET',
        data: "dashoboard=inicial",
        url: "view/dashboard/inicial/bloco/container-center.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1-dashboard #container-center-1 ").html(result);
        },
    });

    $.ajax({
        type: 'GET',
        data: "dashboard=inicial",
        url: "view/dashboard/inicial/bloco/container-right-1.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1-dashboard #container-right-1").html(result);
        },
    });
})




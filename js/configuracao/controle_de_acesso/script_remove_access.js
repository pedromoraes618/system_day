
//remover acesso
$("#card-body-2 ul li ul li a").click(function(e) {
    let id_subcategoria = $(this).attr("id");
    $(this).fadeOut();
    $.ajax({
        type: "POST",
        data: "removeracessos=&clienteID=" + usuario_id.value + "&idsubcategoria=" + id_subcategoria,
        url: "modal/configuracao/controle_de_acesso/acao_acesso.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
        $sucesso = $.parseJSON(data)["sucesso"];
        if ($sucesso) {
  
            $.ajax({
                type: 'GET',
                data: "refresh&clienteID=" + usuario_id.value,
                url: "view/configuracao/acesso_user/acessos_disponiveis.php",
                success: function(result) {
                    return $("#card-body-1").html(result);
                },
            });
        
            $.ajax({
                type: 'GET',
                data: "refresh&clienteID=" + usuario_id.value,
                url: "view/configuracao/acesso_user/acessos_atuais.php",
                success: function(result) {
                    return $("#card-body-2").html(result);
                },
            });

        } else {

        }
    }

    function falha() {
        console.log("erro remover acesso ao usuario")
    }
  



});
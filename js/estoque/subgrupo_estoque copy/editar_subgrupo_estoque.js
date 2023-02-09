//voltar para tela de cadastro
$("#voltar_cadastro").click(function(e) {
    $('.tabela').css("display", 'none')
    $('.tabela').fadeIn(500)

    $.ajax({
        type: 'GET',
        data: "cadastro_parametro=true",
        url: "view/suporte/parametro/cadastro_parametro.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1").html(result);
        },
    });
})

//editar usuario
$("#editar_parametro").submit(function(e) {
  
    e.preventDefault()
    var editar = $(this);
    var retorno = edt_parametro(editar)
})

function edt_parametro(dados) {
 
    $.ajax({
        type: "POST",
        data: dados.serialize(),
        url: "modal/suporte/parametro/gerenciar_parametro.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $sucesso = $.parseJSON(data)["sucesso"];
        $mensagem = $.parseJSON(data)["mensagem"];
        if ($sucesso) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Parametro alterada com sucesso',
                showConfirmButton: false,
                timer: 1500

            })
            //consultar parametros
            $.ajax({
            type: 'GET',
            data: "consultar_parametro=inicial",
            url: "view/suporte/parametro/table/consultar_parametro.php",
            success: function(result) {
            return $(".bloco-pesquisa-2 .tabela").html(result);
            },
            });


        } else {
            Swal.fire({
                icon: 'error',
                title: 'Verifique!',
                text: $mensagem,
                timer: 7500,
            
            })

        }
    }

    function falha() {
        console.log("erro");
    }

}d
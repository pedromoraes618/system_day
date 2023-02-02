$("#cadastrar_parametro").submit(function(e) {
    e.preventDefault()
    var cadastrar = $(this);
    var retorno = cadastrar_parametro(cadastrar)
    var descricao = document.getElementById("descricao")
    var valor = document.getElementById("valor")
    var configuracao = document.getElementById("configuracao")
})

function cadastrar_parametro(dados) {
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
                title: 'Parametro cadastrado com sucesso',
                showConfirmButton: false,
                timer: 1500
            })
            //resetar valores de input
            descricao.value = "";
            valor.value = "";
            configuracao.value = "";


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

}
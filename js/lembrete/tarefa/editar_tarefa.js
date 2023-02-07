//voltar para tela de cadastro
$("#voltar_cadastro").click(function(e) {
    $.ajax({
        type: 'GET',
        data: "cadastro_tarefa=true",
        url: "view/lembrete/tarefa/cadastro_tarefa.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1").html(result);
        },
    });
})

//editar formulario
$("#editar_tarefa").submit(function(e) {
    e.preventDefault()
    var editar_formulario = $(this);
    var retorno = edtarefa(editar_formulario)
})


function edtarefa(dados) {
    $.ajax({
        type: "POST",
        data: dados.serialize(),
        url: "modal/lembrete/tarefa/gerenciar_tarefa.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
    
        $sucesso = $.parseJSON(data)["sucesso"];
        $mensagem = $.parseJSON(data)["mensagem"];
    
        if ($sucesso) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Tarefa alterada com sucesso',
                showConfirmButton: false,
                timer: 1500


            })
            //consultar informaçãoes
            $.ajax({
                type: 'GET',
                data: "consultar_tarefa=inicial",
                url: "view/lembrete/tarefa/table/consultar_tarefa.php",
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
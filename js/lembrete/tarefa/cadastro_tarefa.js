$("#cadastrar_tarefa").submit(function(e) {
    e.preventDefault()

    var cadastrar = $(this);
    var retorno = cadastrar_tarefa(cadastrar)
    var descricao = document.getElementById("descricao")
    var data_limite = document.getElementById("data_limite")
    var usuario = document.getElementById("usuario")
    var comentario = document.getElementById("comentario")
    let status_lembrete = document.getElementById("status_lembrete")
    let prioridade = document.getElementById("prioridade")
})

function cadastrar_tarefa(dados) {
   
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
                title: 'Taréfa cadastrada com sucesso',
                showConfirmButton: false,
                timer: 1500
            })


           
            //resetar valores de input
            descricao.value = "";
            data_limite.value = "";
            comentario.value = "";
            usuario.value = "0";
            status_lembrete.value = "0";
            prioridade.checked = false;
       
            //realizar a consulta da tabela
            $.ajax({
                type: 'GET',
                data: "consultar_tarefa=inicial&user_logado="+user_logado,
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
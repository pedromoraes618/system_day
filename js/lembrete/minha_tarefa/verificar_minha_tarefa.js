$(".atualizar_tarefa").click(function(e) {
   var id_tarefa = $(this).attr("id_tarefa")
   var user_logado = $(this).attr("user_logado")
  

   var status = "status"+id_tarefa
   var status_lembrete = document.getElementById(status)

   var comentario = "comentario"+id_tarefa
   var comentario_tarefa = document.getElementById(comentario)

    $.ajax({
    type: "POST",
    data: "atualizar_minha_tarefa=true&status=" + status_lembrete.value + "&comentario="+comentario_tarefa.value+"&id_tarefa="+id_tarefa+"&user_logado="+user_logado,
    url: "modal/lembrete/minha_tarefa/gerenciar_minha_tarefa.php",
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

    //remover o card
    if(status_lembrete.value == "3"){
        $(".card"+id_tarefa).css("display", 'none')
        $(".card"+id_tarefa).fadeOut(500)
    }
     
    // $.ajax({
    //     type: 'GET',
    //     data: "refresh&clienteID=" + usuario_id.value,
    //     url: "view/configuracao/acesso_user/acessos_atuais.php",
    //     success: function(result) {
    //         return $(".sub_bloco_info-2").html(result);
    //     },
    // });

    }else{
        Swal.fire({
            icon: 'error',
            title: 'Verifique!',
            text: $mensagem,
            timer: 7500,
        
        })
    }
    }

    function falha() {
    console.log("erro adicionar acesso ao usuario")
    }


})


  
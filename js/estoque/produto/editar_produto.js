$("#voltar_consulta").click(function(e) {
    $(".bloco-pesquisa-menu .bloco-pesquisa-1").css("display","block") // remover tela de cadastro
    $(".bloco-pesquisa-menu .bloco-pesquisa-2").css("display","none") // aparecer tela de consulta
        $.ajax({
        type: 'GET',
        data: "consultar_grupo=inicial",
        url: "view/estoque/produto/consultar_produto.php",
        success: function(result) {
        return $(".bloco-pesquisa-menu .bloco-pesquisa-1").html(result);
        },
    });
    
})
    


// //editar usuario
// $("#editar_grupo_estoque").submit(function(e) {
//     e.preventDefault()
//     var editar = $(this);
//     var retorno = editar_grupo(editar)
// })

// function editar_grupo(dados) {
 
//     $.ajax({
//         type: "POST",
//         data: dados.serialize(),
//         url: "modal/estoque/grupo_estoque/gerenciar_grupo_estoque.php",
//         async: false
//     }).then(sucesso, falha);

//     function sucesso(data) {

//         $sucesso = $.parseJSON(data)["sucesso"];
//         $mensagem = $.parseJSON(data)["mensagem"];
//         if ($sucesso) {
//             Swal.fire({
//                 position: 'center',
//                 icon: 'success',
//                 title: 'Grupo alterada com sucesso',
//                 showConfirmButton: false,
//                 timer: 1500

//             })
      
//         //consultar informação tabela
//         $.ajax({
//             type: 'GET',
//             data: "consultar_grupo=inicial",
//             url: "view/estoque/grupo_estoque/table/consultar_grupo_estoque.php",
//             success: function(result) {
//                 return $(".bloco-pesquisa-2 .tabela").html(result);
//             },
//         });


//         } else {
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Verifique!',
//                 text: $mensagem,
//                 timer: 7500,
            
//             })

//         }
//     }

//     function falha() {
//         console.log("erro");
//     }

// }d
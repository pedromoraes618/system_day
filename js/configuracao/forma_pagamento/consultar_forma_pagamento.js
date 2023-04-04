
// //ao clicar no botão cadastrar produto
// $("#adicionar_produto").click(function(e) {
//     $(".bloco-pesquisa-menu .bloco-pesquisa-1").css("display","none")
//     $(".bloco-pesquisa-menu .bloco-pesquisa-2").css("display","block")
//   //  $(".bloco-pesquisa-menu .bloco-pesquisa-2").css("display","none") // aparecer tela de cadastro
//     $.ajax({
//         type: 'GET',
//         data: "cadastro_produto=true",
//         url: "view/estoque/produto/cadastro_produto.php",
//         success: function(result) {
//             return $(".bloco-pesquisa-menu .bloco-pesquisa-2").html(result);
//         },
//     });
// })

// //valores do campo de pesquisa //pesquisa via filtro
// var conteudo_pesquisa = document.getElementById("pesquisa_conteudo")

//condição se existe valor de pesquisa no localstorage recarregar a pesquisa automaticamente
//valor da pesquisa é guardado no localStorage, ao clicar em editar ou adicionar a pagina realizara a pesquisa novamente


$("#adicionar_fpg").click(function (e) {
    $.ajax({
        type: 'GET',
        data: "cadastrar_fpg=true",
        url: "view/configuracao/forma_pagamento/forma_pagamento_tela.php",
        success: function (result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .modal_show").html(result) + $("#modal_forma_pagamento").modal('show');

        },
    });
})


//valores do campo de pesquisa //pesquisa via filtro
var conteudo_pesquisa = document.getElementById("pesquisa_conteudo");

if (localStorage.getItem("storage_pesquisa")) {
    var memoria_pesquisa = localStorage.getItem("storage_pesquisa");
    conteudo_pesquisa.value = memoria_pesquisa
    $.ajax({
        type: 'GET',
        data: "consultar_fpg=detalhado&conteudo_pesquisa=" + conteudo_pesquisa.value,
        url: "view/configuracao/forma_pagamento/table/consultar_forma_pagamento.php",
        success: function (result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .tabela").html(result);
        },
    });
} else {
    //consultar tabela
    $.ajax({
        type: 'GET',
        data: "consultar_fpg=inicial",
        url: "view/configuracao/forma_pagamento/table/consultar_forma_pagamento.php",
        success: function (result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .tabela").html(result);
        },
    });
}


$("#pesquisar_filtro_pesquisa").click(function (e) {
    localStorage.setItem("storage_pesquisa", conteudo_pesquisa.value);
    $.ajax({
        type: 'GET',
        data: "consultar_fpg=detalhado&conteudo_pesquisa=" + conteudo_pesquisa.value,
        url: "view/configuracao/forma_pagamento/table/consultar_forma_pagamento.php",
        success: function (result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .tabela").html(result);
        },
    });

})



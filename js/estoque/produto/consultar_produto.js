//ao clicar no botão cadastrar produto
$("#adicionar_produto").click(function(e) {
    $(".bloco-pesquisa-menu .bloco-pesquisa-1").css("display","none")
    $(".bloco-pesquisa-menu .bloco-pesquisa-2").css("display","block")
  //  $(".bloco-pesquisa-menu .bloco-pesquisa-2").css("display","none") // aparecer tela de cadastro
    $.ajax({
        type: 'GET',
        data: "cadastro_produto=true",
        url: "view/estoque/produto/cadastro_produto.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-2").html(result);
        },
    });
})
//consultar tabela
$.ajax({
    type: 'GET',
    data: "consultar_produto=inicial",
    url: "view/estoque/produto/table/consultar_produto.php",
    success: function(result) {
        return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .tabela").html(result);
    },
});

//valores do campo de pesquisa //pesquisa via filtro
let conteudo_pesquisa = document.getElementById("pesquisa_conteudo")


$("#pesquisar_filtro_pesquisa").click(function(e) {
    localStorage.setItem("pesquisar_produto", conteudo_pesquisa.value);

    if(conteudo_pesquisa.value==""){
        $(".alerta").html("<span class='alert alert-primary position-absolute' style role='alert'>Favor informe a palavra chave</span>")
       setTimeout(function() {
        $(".alerta .alert").css("display","none")
      }, 5000);
    }else{
    $.ajax({
        type: 'GET',
        data: "consultar_produto=detalhado&conteudo_pesquisa=" + conteudo_pesquisa.value,
        url: "view/estoque/produto/table/consultar_produto.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .tabela").html(result);
        },
    });
}
})


//valor da pesquisa é guardado no localStorage, ao clicar em editar ou adicionar a pagina realizara a pesquisa novamente
if (localStorage.getItem("pesquisar_produto")) {
   
    let memoria_pesquisa = localStorage.getItem("pesquisar_produto");
    conteudo_pesquisa.value = memoria_pesquisa
    $.ajax({
        type: 'GET',
        data: "consultar_produto=detalhado&conteudo_pesquisa=" + conteudo_pesquisa.value,
        url: "view/estoque/produto/table/consultar_produto.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .tabela").html(result);
        },
    });
  }
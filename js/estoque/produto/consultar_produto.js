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

//valores do campo de pesquisa //pesquisa via filtro
var conteudo_pesquisa = document.getElementById("pesquisa_conteudo")
var status_prod = document.getElementById("status")

//condição se existe valor de pesquisa no localstorage recarregar a pesquisa automaticamente
//valor da pesquisa é guardado no localStorage, ao clicar em editar ou adicionar a pagina realizara a pesquisa novamente
if (localStorage.getItem("storage_pesquisa")) {
    var store_recuperado = localStorage.getItem("storage_pesquisa");
    const storage_pesquisa = JSON.parse(store_recuperado);
    conteudo_pesquisa.value = storage_pesquisa.input_pesquisa
    $("#status").val(storage_pesquisa.status)

    $.ajax({
        type: 'GET',
        data: "consultar_produto=detalhado&conteudo_pesquisa=" + storage_pesquisa.input_pesquisa + "&status_prod="+storage_pesquisa.status,
        url: "view/estoque/produto/table/consultar_produto.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .tabela").html(result);
        },
    });
}else{
//consultar tabela
$.ajax({
    type: 'GET',
    data: "consultar_produto=inicial",
    url: "view/estoque/produto/table/consultar_produto.php",
    success: function(result) {
        return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .tabela").html(result);
    },
});
}



$("#pesquisar_filtro_pesquisa").click(function() {
    const valores = { //array com os dados da pesquisa
        input_pesquisa: conteudo_pesquisa.value,
        status: status_prod.value,//status
    }
    const storage_pesquisa = JSON.stringify(valores);
    localStorage.setItem("storage_pesquisa", storage_pesquisa);
    if(conteudo_pesquisa.value=="" && status_prod.value == "0" ){
        $(".alerta").html("<span class='alert alert-primary position-absolute' style role='alert'>Favor informe a palavra chave</span>")
       setTimeout(function() {
        $(".alerta .alert").css("display","none")
      }, 5000);
    }else{
    $.ajax({
        type: 'GET',
        data: "consultar_produto=detalhado&conteudo_pesquisa=" + conteudo_pesquisa.value + "&status_prod="+status_prod.value,
        url: "view/estoque/produto/table/consultar_produto.php",
        success: function(result) {
            return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .tabela").html(result);
        },
    });
}
})







var data_inicial = document.getElementById('data_inicial')
var data_final = document.getElementById('data_final')

resumo_caixa(data_inicial.value,data_final.value);

$("#resumo_caixa").click(function() {
    resumo_caixa(data_inicial.value,data_final.value);
})

$("#venda_fpg_caixa").click(function() {
    vendas_fpg(data_inicial.value,data_final.value);
})
$("#print_relatorio").click(function() {
    var botaoAtivo = $("button.active");
  
    // Verificar se há algum botão com a classe "active"
    if (botaoAtivo.length > 0) {
      // Obter o ID do botão ativo
      var relatorio = botaoAtivo.attr("id");
      print_ralatorio(data_inicial.value,data_final.value,relatorio)
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Verifique!',
            text: "Informe o relatório",
            timer: 7500,
        })
    }
 //   print_ralatorio(data_inicial.value,data_final.value,"");
})

function print_ralatorio(data_inicial, data_final, relatorio) {
    var janela = "view/relatorio/modelo/modelo_1.php?relatorio="+relatorio+"&data_inicial=" + data_inicial + "&data_final=" + data_final 
    window.open(janela, 'popuppage',
        'width=1500,toolbar=0,resizable=1,scrollbars=yes,height=800,top=100,left=100');
}

function resetar_btn(){
    $(".btn").removeClass("btn-dark")
    $(".btn").addClass("btn-outline-success")
    $(".btn").removeClass("active")
}
function resumo_caixa(data_inicial,data_final){
    resetar_btn()
    $("#resumo_caixa").removeClass("btn-outline-success")
    $("#resumo_caixa").addClass("btn-dark")
    $("#resumo_caixa").addClass("active")

    $.ajax({
        type: 'GET',
        data: "movimento_caixa=true&acao=resumo&data_inicial="+data_inicial+"&data_final="+data_final,
        url: "view/caixa/movimento_caixa/table/resumo.php",
        success: function(result) {
            return $('.tabela').html(result);
        },
    });
}

function vendas_fpg(data_inicial,data_final){
    resetar_btn()
    $("#venda_fpg_caixa").removeClass("btn-outline-success")
    $("#venda_fpg_caixa").addClass("btn-dark")
    $("#venda_fpg_caixa").addClass("active")
    $.ajax({
        type: 'GET',
        data: "movimento_caixa=true&acao=vendas_fpg&data_inicial="+data_inicial+"&data_final="+data_final,
        url: "view/caixa/movimento_caixa/table/vendas_fpg.php",
        success: function(result) {
            return $('.tabela').html(result);
        },
    });
}
// //remover tarefa
// function caixa(caixa) {
//     $.ajax({
//         type: "POST",
//         data: "caixa=true&data=" + caixa,
//         url: "modal/caixa/abertura_fechamento/gerenciar_caixa.php",
//         async: false
//     }).then(sucesso, falha);

//     function sucesso(data) {
    
//         $sucesso = $.parseJSON(data)["sucesso"];
//         $mensagem = $.parseJSON(data)["mensagem"];
    
//         if ($sucesso) {
//            alert("opk")
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

// }
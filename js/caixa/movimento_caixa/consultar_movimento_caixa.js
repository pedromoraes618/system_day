

function capturarTela() {

    html2canvas(document.querySelector(".print"), {scale: 2}).then(function(canvas) {
      var novaJanela = window.open();
      novaJanela.document.body.appendChild(canvas);
    });
  }


var data_inicial = document.getElementById('data_inicial')
var data_final = document.getElementById('data_final')

resumo_caixa(data_inicial.value,data_final.value);

$("#resumo").click(function() {
    resumo_caixa(data_inicial.value,data_final.value);
})

$("#venda_fpg").click(function() {
    vendas_fpg(data_inicial.value,data_final.value);
})

function resetar_btn(){
    $(".btn").removeClass("btn-dark")
    $(".btn").addClass("btn-outline-success")
}
function resumo_caixa(data_inicial,data_final){
    resetar_btn()
    $("#resumo").removeClass("btn-outline-success")
    $("#resumo").addClass("btn-dark")
    
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
    $("#venda_fpg").removeClass("btn-outline-success")
    $("#venda_fpg").addClass("btn-dark")
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
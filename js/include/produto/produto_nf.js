
// if (tipo == "RECEITA") {
//     $.ajax({
//         type: 'GET',
//         data: "editar_lancamento_financeiro=true&tipo=RECEITA&form_id=" + form_id,
//         url: "view/financeiro/lancamento_financeiro/lancamento_financeiro_tela.php",
//         success: function (result) {
//             return $(".bloco-pesquisa-menu .bloco-pesquisa-1 .modal_show").html(result) + $("#modal_lancamento_financeiro").modal('show');
//         },
//     });
// }

//retorna os dados para o formulario
var id_item = $("#id_item_nf").val()
var serie_nf = $("#serie_nf").val()


if (serie_nf == "vnd") {
  if (id_item == "") {//inclur
    $("#modal_item_nf .modal-title").html("Adicionar Produto")//alterar a label cabeçalho
    $("#alterar_item").html("Adicionar")
  } else {//alterar
    $("#modal_item_nf .modal-title").html("Alterar Produto")//alterar a label cabeçalho
    $('#alterar_item').html('Salvar');
    show_det_produto(id_item) // funcao para retornar os dados para o formulario
  }
}

$("#alterar_item").click(function () {
  if (serie_nf == "vnd") {
    if (id_item == "") {//inclur

    } else {//alterar
      var id_produto = $("#id_produto_item").val()
      var id_item_nf = $("#id_item_nf").val()
      var descricao_produto = $("#descricao_item").val()
      var unidade = $("#unidade_item").val()
      var quantidade = $("#quantidade_item").val()
      var preco_venda = $("#preco_venda_item").val()
      var valor_total = $("#valor_total_item").val()
      //   var referencia = $("#referencia").val()
      //  var referencia = $("#referencia").val()

      var itens = {
        id_produto: id_produto,
        id_item_nf: id_item_nf,
        descricao_produto: descricao_produto,
        unidade: unidade,
        preco_venda: preco_venda,
        quantidade: quantidade,
        valor_total: valor_total,
        referencia: "",
      };


      alterar_produto_venda(itens, codigo_nf.value, id_user_logado, user_logado, "false")//função para adicioonar o produto na venda validando as informações do produto e exibir a listagem de produtos
    }
  }

})
//mostrar as informações no formulario
function show_det_produto(id) {
  $.ajax({
    type: "POST",
    data: "venda_mercadoria=true&acao=show_det_produto&produto_id=" + id,
    url: "modal/venda/venda_mercadoria/gerenciar_venda.php",
    async: false
  }).then(sucesso, falha);

  function sucesso(data) {
    $dados = $.parseJSON(data)["dados"];
    if ($dados.sucesso == true) {
      $("#descricao_item").val($dados.valores['descricao'])
      $("#quantidade_item").val($dados.valores['quantidade'])
      $("#preco_venda_item").val($dados.valores['preco_venda'])
      $("#valor_total_item").val($dados.valores['valor_total'])
      $("#unidade_item").val($dados.valores['unidade'])
      $("#preco_venda_item_atual").val($dados.valores['preco_venda_atual'])
      $("#desconto_item").val($dados.valores['desconto'])
      $("#id_produto_item").val($dados.valores['id_produto'])

    }
  }

  function falha() {
    console.log("erro");
  }

}


function alterar_produto_venda(itens, codigo_nf, id_user_logado, user_logado, autorizador) {

  let itensJSON = JSON.stringify(itens); //codificar para json
  $.ajax({
    type: "POST",
    data: {
      venda_mercadoria: true,
      acao: "validar_alteracao_produto",
      itens: itensJSON,
      cd_nf: codigo_nf,
      id_user: id_user_logado,
      user_nome: user_logado,
      check_autorizador: autorizador,
    },
    url: "modal/venda/venda_mercadoria/gerenciar_venda.php",
    async: false
  }).then(sucesso, falha);

  function sucesso(data) {

    $dados = $.parseJSON(data)["dados"];
    if ($dados.sucesso == true) {//se tiver ok com as informações do produto
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: $dados.title,
        showConfirmButton: false,
        timer: 3500
      })
      tabela_produtos(codigo_nf)
      //   resetarValoresProdutos()
    } else if ($dados.sucesso == "autorizar") {//validar autorizacao ao adicionar o produto
      $.ajax({
        type: 'GET',
        data: "autorizar_acao=true&mensagem=" + $dados.title,
        url: "view/include/autorizacao/autorizar_acao.php",
        success: function (result) {
          return $(".alert").html(result)
            + $("#modal_autorizar_acao").modal('show')
            + $("#autorizar_acao").addClass("autorizar_desconto_alterar_prd_venda");

        },

      });


    } else {//sucesso == false
      Swal.fire({
        icon: 'error',
        title: 'Verifique!',
        text: $dados.title,
        timer: 7500,

      })
    }
  }

  function falha() {
    console.log("erro");
  }

}

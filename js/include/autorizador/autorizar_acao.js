
function autorizar_acao_incluir_prd_venda(id_usuario, senha, itens) {
    $.ajax({
        type: "POST",
        data: {
            autorizar_acao: true,
            acao: "validar_usuario",
            tela: "venda",
            usuario_id: id_usuario,
            senha: senha
        },
        url: "modal/autorizador/usuario.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            produtos.push(itens)//guarda as informações do produto no array
            exibirProdutos(produtos);//listar os produtos na tela
            $(".table #valor_total_produtos").html(exibirValorTotalProdutos(produtos))
            resetarValoresProdutos()
        } else {
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


$("#autorizar_acao").click(function () {

    if ($("#autorizar_acao").hasClass("autorizar_desconto_prd_venda")) {//verificar se existe a classe
        var usuario_id = $("#id_usuario_autorizador").val()
        var senha = $("#senha_autorizador").val()

        /*pegar os valores  */
        var data_movimento = $("#data_movimento").val()
        var id_produto = $("#produto_id").val()
        var descricao_produto = $("#descricao_produto").val()
        var unidade = $("#unidade").val()
        var quantidade = $("#quantidade").val()
        var preco_venda = $("#preco_venda").val()
        var valor_total = $("#valor_total").val()
        var referencia = $("#referencia").val()
        var estoque = $("#estoque").val()
        var preco_venda_atual = $("#preco_venda_atual").val()

        var itens = {
            data_movimento: data_movimento,
            id_produto: id_produto,
            descricao_produto: descricao_produto,
            unidade: unidade,
            estoque: estoque,
            preco_venda: preco_venda,
            quantidade: quantidade,
            valor_total: valor_total,
            referencia: referencia,
            preco_venda_atual: preco_venda_atual,

        };

        autorizar_acao_incluir_prd_venda(usuario_id, senha, itens)//funcao validador de autorizacao

    }
});

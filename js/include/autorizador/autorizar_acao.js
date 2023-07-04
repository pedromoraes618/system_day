



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

    if ($("#autorizar_acao").hasClass("autorizar_desconto_alterar_prd_venda")) {
        var usuario_id = $("#id_usuario_autorizador").val()
        var senha = $("#senha_autorizador").val()

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


        autorizar_acao_alterar_prd_venda(usuario_id, senha, itens,codigo_nf.value)//funcao validador de autorizacao

    }//verificar se existe a classe
});

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
            // produtos.push(itens)//guarda as informações do produto no array
            // exibirProdutos(produtos);//listar os produtos na tela
            // $(".table #valor_total_produtos").html(exibirValorTotalProdutos(produtos))
            // resetarValoresProdutos()
           
            adicionar_produto_venda(itens, codigo_nf.value, id_user_logado, user_logado, "true");
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

function autorizar_acao_alterar_prd_venda(id_usuario, senha, itens, codigo_nf) {
    $.ajax({
        type: "POST",
        data: {
            autorizar_acao: true,
            acao: "validar_usuario",
            tela: "alterar_prd_venda",
            usuario_id: id_usuario,
            senha: senha
        },
        url: "modal/autorizador/usuario.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            alterar_produto_venda(itens, codigo_nf, id_usuario, "", "true");
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Verifique!',
                text: $dados.title,
                timer: 7500,

            })
            $('#fechar_modal_alterar_item').trigger('click'); // clicar automaticamente para realizar fechar o modal

        }

    }

    function falha() {
        console.log("erro");
    }

}
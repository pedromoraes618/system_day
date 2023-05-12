$("#voltar").click(function () {
    $(".bloco-pesquisa-menu .bloco-pesquisa-2").css("display", "none") // aparecer tela de consulta

})

const formulario_post = document.getElementById("venda_mercadoria");
let id_formulario = document.getElementById("id")
let titulo = document.getElementById('title_modal')
let btn_form = document.getElementById('button_form')
let tipo = document.getElementById('tipo')
var id_user_logado = $("#id_user_logado").val()
var produtos = [];//array de produtos

//modal para consultar o parceiro
$("#modal_parceiro").click(function () {
    $.ajax({
        type: 'GET',
        data: "adicionar_parceiro=true",
        url: "view/include/parceiro/pesquisa_parceiro.php",
        success: function (result) {
            return $(".modal_externo").html(result) + $("#modal_pesquisa_parceiro").modal('show');

        },
    });
});

//modal para adicionar parceiro avulso
$("#modal_parceiro_avulso").click(function () {

    $.ajax({
        type: 'GET',
        data: "adicionar_parceiro_avulso=true",
        url: "view/include/parceiro_avulso/adicionar_parceiro.php",
        success: function (result) {
            return $(".modal_externo").html(result) + $("#modal_adiciona_parceiro_avulso").modal('show');

        },
    });
});


//modal para consultar o produto
$("#modal_produto").click(function () {
    $.ajax({
        type: 'GET',
        data: "adicionar_produto=true",
        url: "view/include/produto/pesquisa_produto.php",
        success: function (result) {
            return $(".modal_externo").html(result) + $("#modal_pesquisa_produto").modal('show');

        },
    });
});

//modal para adicionar observacao
$("#modal_observacao").click(function () {
    $.ajax({
        type: 'GET',
        data: "adicionar_observacao=true",
        url: "view/include/observacao/adicionar_observacao.php",
        success: function (result) {
            return $(".modal_externo").html(result) + $("#modal_adiciona_observacao").modal('show');

        },
    });
});


/*funcões */
function resetarValoresProdutos() {
    $("#produto_id").val('')
    $("#descricao_produto").val('')
    $("#unidade").val('')
    $("#estoque").val('')
    $("#quantidade").val('')
    $("#valor_total").val('')
    $("#referencia").val('')
    $("#preco_venda").val('')
    $("#preco_venda_atual").val('')
    $("#desconto").val('')

}


function exibirProdutos(produtos) {//listar os produtos 
    valor_total_produtos = 0
    var tabela = $('#tabela_produtos');
    tabela.empty();
    for (var i = 0; i < produtos.length; i++) {
        item = i + 1;
        id_prod = produtos[i].id_produto
        descricao_prod = produtos[i].descricao_produto
        referencia_prod = produtos[i].referencia
        unidade_prod = produtos[i].unidade
        preco_venda_prod = produtos[i].preco_venda
        quantidade_prod = produtos[i].quantidade
        valor_total_prod = produtos[i].valor_total
        tabela.append('<tr><td>' + item + '</td><td>' + id_prod + '</td><td>' +
            descricao_prod + '</td><td>' + unidade_prod + '</td><td>' + referencia_prod + '</td><td>' + preco_venda_prod +
            '</td><td>' + quantidade_prod + '</td><td>' + valor_total_prod + '</td><td class="td-btn"><button type="button" venda_mercadoria_id=' + id_prod + ' class="btn btn-info   btn-sm editar_venda_mercadoria">Editar</button> </td></tr>');
    }
}
function exibirValorTotalProdutos(produtos) {//consultar o valor dos produtos
    valor_total_produtos = 0;
    for (var i = 0; i < produtos.length; i++) {
        valor_total_prod = produtos[i].valor_total
        valor_total_prod = parseFloat(valor_total_prod)
        valor_total_produtos = valor_total_prod + valor_total_produtos
        var valorFormatado = valor_total_produtos.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });//formatar para moeda brasileira

    }
    return valorFormatado
}
/*funcões */


//retorna os dados para o formulario
if (id_formulario.value == "") {
    $('#alterar_venda').html('Concluir');
    $(".title .sub-title").html("Lançar venda")//alterar a label cabeçalho
    var momento_venda = document.getElementById("momento_venda")//status da venda//1-iniciado 2-finalizado 3-edicao
    $(".title .status_momento_venda").css("display", "none")//display none para a label que ira informar o usuario qual é o status momento da venda

    $('#iniciar_venda').click(function () {//iniciar venda
        var tabela = $('#tabela_produtos');
        formulario_post.reset(); // redefine os valores do formulário
        $(".title .status_momento_venda").html("Venda Iniciada")//alterar a label cabeçalho
        $(".title .status_momento_venda").css("display", "")//display block para a label que ira informar o usuario qual é o status momento da venda
        setTimeout(function () {
            $(".title .status_momento_venda").html("Venda em Andamento..")//alterar a label cabeçalho
        }, 3000);
        tabela.empty();//resetar a tabela
        $(".table #valor_total_produtos ").html((0))
        if (momento_venda.value == "") {
            $("#momento_venda").val('1');//venda iniciada

        }

    })


    $("#adicionar_produto").click(function () {//adicionar o produto na venda
        if (momento_venda.value == "") {
            Swal.fire({
                icon: 'error',
                title: 'Verifique!',
                text: "A venda ainda não foi iniciada, Favor clique no botão Iniciar venda",
                timer: 7500,
            })
        } else if (momento_venda.value == "1") {//venda iniciada

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
            adicionar_produto_venda(itens)//função para adicioonar o produto na venda validando as informações do produto e exibir a listagem de produtos
        }

    })

    $('#concluir_venda').click(function () {

        if (momento_venda.value == "") {
            Swal.fire({
                icon: 'error',
                title: 'Verifique!',
                text: "A venda ainda não foi iniciada, Favor clique no botão Iniciar venda",
                timer: 7500,

            })
        } else if (momento_venda.value == "1") {//venda iniciada
            $.ajax({
                type: 'GET',
                data: "concluir_venda=true&id_user_logado=" + id_user_logado,
                url: "view/include/finalizar_venda/finalizar_venda.php",
                success: function (result) {
                    return $(".modal_externo_finalizar_venda").html(result) + $("#modal_finalizar_venda").modal('show')

                },
            });
        }
    })

} else {
    $('#alterar_venda').html('Alterar');
    $(".title .sub-title").html("Alterar lançamento")
    show(id_formulario.value) // funcao para retornar os dados para o formulario
}

//formulario para cadastro
$("#lancamento_financeiro").submit(function (e) {

    e.preventDefault()
    if (id_formulario.value == "") {//cadastrar
        var formulario = $(this);
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja adicionar esse lançamento?",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Não',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (result.isConfirmed) {
                var retorno = create(formulario)
            }
        })
    } else {//editar
        e.preventDefault()
        var formulario = $(this);
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja alterar essa conta financeira",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Não',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (result.isConfirmed) {
                var retorno = update(formulario)
            }
        })
    }


})

function create(dados) {

    $.ajax({
        type: "POST",
        data: "formulario_lancamento_financeiro=true&acao=create&" + dados.serialize(),
        url: "modal/financeiro/lancamento_financeiro/gerenciar_lancamento_financeiro.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: $dados.title,
                showConfirmButton: false,
                timer: 3500
            })
            formulario_post.reset(); // redefine os valores do formulário
            $('#pesquisar_filtro_pesquisa').trigger('click'); // clicar automaticamente para realizar a consulta

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


function adicionar_produto_venda(itens) {

    let itensJSON = JSON.stringify(itens); //codificar para json
    $.ajax({
        type: "POST",
        data: {
            venda_mercadoria: true,
            acao: "validar_produto",
            itens: itensJSON,
            resgistro: "sem_registro"
        },
        url: "modal/venda/venda_mercadoria/gerenciar_venda.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {//se tiver ok com as informações do prduto
            produtos.push(itens)//guarda as informações do produto no array
            exibirProdutos(produtos);//listar os produtos na tela
            $(".table #valor_total_produtos").html(exibirValorTotalProdutos(produtos))
            resetarValoresProdutos()
        } else if ($dados.sucesso == "autorizar") {//validar autorizacao ao adicionar o produto
            $.ajax({
                type: 'GET',
                data: "autorizar_acao=true&mensagem=" + $dados.title,
                url: "view/include/autorizacao/autorizar_acao.php",
                success: function (result) {
                    return $(".modal_externo").html(result)
                        + $("#modal_autorizar_acao").modal('show')
                        +$("#autorizar_acao").addClass("autorizar_desconto_prd_venda"); 
                       
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


function update(dados) {
    $.ajax({
        type: "POST",
        data: "formulario_lancamento_financeiro=true&acao=update&" + dados.serialize(),
        url: "modal/financeiro/lancamento_financeiro/gerenciar_lancamento_financeiro.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: $dados.title,
                showConfirmButton: false,
                timer: 3500
            })
            $('#pesquisar_filtro_pesquisa').trigger('click'); // clicar automaticamente para realizar a consulta
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



//mostrar as informações no formulario show
function show(id) {
    $.ajax({
        type: "POST",
        data: "formulario_lancamento_financeiro=true&acao=show&conta_financeira_id=" + id,
        url: "modal/financeiro/lancamento_financeiro/gerenciar_lancamento_financeiro.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            $("#data_movimento").val($dados.valores['data_movimento'])
            $("#data_vencimento").val($dados.valores['data_vencimento'])
            $("#data_pagamento").val($dados.valores['data_pagamento'])
            $("#conta_financeira").val($dados.valores['conta_financeira'])
            $("#forma_pagamento").val($dados.valores['forma_pagamento'])

            $("#parceiro_id").val($dados.valores['parceiro_id'])
            $("#parceiro_descricao").val($dados.valores['parceiro_descricao'])

            $("#status").val($dados.valores['status'])
            $("#classificacao").val($dados.valores['classificacao'])
            $("#descricao").val($dados.valores['descricao'])
            $("#documento").val($dados.valores['documento'])
            $("#ordem_servico").val($dados.valores['ordem_servico'])

            $("#valor_bruto").val($dados.valores['valor_bruto'])
            $("#valor_liquido").val($dados.valores['valor_liquido'])
            $("#juros").val($dados.valores['juros'])
            $("#taxa").val($dados.valores['taxa'])
            $("#baixa_parcial").val($dados.valores['baixa_parcial'])
            $("#desconto").val($dados.valores['desconto'])
            $("#observacao").val($dados.valores['observacao'])

        }
    }

    function falha() {
        console.log("erro");
    }

}


//calulcar o valor liquido do produto
function calcular_valor_total() {

    var quantidade = $('#quantidade').val();
    var preco_venda = $('#preco_venda').val();
    // var preco_venda_atual = $('#preco_venda_atual').val();

    if (quantidade) {//verificando se tem um virgula e substituindo pelo ponto, apos isso e transformado para numero(parsefloat)
        if (quantidade.includes(",")) {
            quantidade = quantidade.replace(",", ".");
        }
        quantidade = parseFloat(quantidade)
    }

    if (preco_venda) {
        if (preco_venda.includes(",")) {
            preco_venda = preco_venda.replace(",", ".");
        }
        preco_venda = parseFloat(preco_venda)
    }


    if (quantidade && preco_venda) {
        var valorFinal = (quantidade * preco_venda);
        valorFinal = (valorFinal.toFixed(2));

        $('#valor_total').val(valorFinal);
    }



}


//calulcar o valor liquido do produto
function calcular_desconto() {
    var preco_venda = $('#preco_venda').val();
    var preco_venda_atual = $('#preco_venda_atual').val();

    if (preco_venda != preco_venda_atual) {//verificar se o valor do preco de venda foi alterado
        if (preco_venda) {
            if (preco_venda.includes(",")) {
                preco_venda = preco_venda.replace(",", ".");
            }
            preco_venda = parseFloat(preco_venda)
        }

        if (preco_venda) {

            valor_final = ((preco_venda * 100) / preco_venda_atual)
            valor_final = (100 - valor_final)
            valor_final = (valor_final.toFixed(2));
            $('#desconto').val(valor_final);
        }

    }

}

//calulcar o valor liquido do produto
function calcular_preco_venda() {
    var desconto = $('#desconto').val();
    var preco_venda_atual = $('#preco_venda_atual').val();

    if (desconto) {//verificar se o valor do preco de venda foi alterado
        if (desconto) {
            if (desconto.includes(",")) {
                desconto = desconto.replace(",", ".");
            }
            desconto = parseFloat(desconto)
        }
        valor_final = preco_venda_atual - (desconto / 100) * preco_venda_atual;
        valor_final = (valor_final.toFixed(2));
        $('#preco_venda').val(valor_final);
    }

}
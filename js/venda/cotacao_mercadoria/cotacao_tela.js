// $("#voltar").click(function () {
//     $(".bloco-pesquisa-menu .bloco-pesquisa-2").css("display", "none") // aparecer tela de consulta

// })


const formulario_post = document.getElementById("cotaca_mercadoria");
let id_formulario = document.getElementById("id")
let titulo = document.getElementById('title_modal')
let btn_form = document.getElementById('button_form')
let tipo = document.getElementById('tipo')
let codigo_nf = document.getElementById('codigo_nf')
var id_user_logado = $("#id_user_logado").val()





/*funcões */
function resetarValoresProdutos() {
    $("#produto_id").val('')
    $("#descricao_produto").val('')
    $("#unidade").val('')
    $("#estoque").val('')
    $("#quantidade").val('')
    $("#valor_total").val('')
    $("#preco_venda").val('')
    $("#desconto").val('')

}


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


$(".fechar_tela_cotacao").click(function () {
    $('#pesquisar_filtro_pesquisa').trigger('click'); // clicar automaticamente para realizar fechar o modal
})




function generateUniqueId() {
    var timestamp = Date.now().toString(); // Obter o timestamp atual como uma string
    var randomNum = Math.random().toString().substr(2, 5); // Gerar um número aleatório e extrair uma parte dele
    var uniqueId = timestamp + randomNum; // Concatenar o timestamp e o número aleatório
    return uniqueId;
}

//retorna os dados para o formulario
if (id_formulario.value == "") {
    $(".title .sub-title").html("Lançar cotação")//alterar a label cabeçalho
    // var momento_venda = document.getElementById("momento_venda")//status da venda//1-iniciado 2-finalizado 3-edicao
    $(".title .status_momento_cotacao").css("display", "none")//display none para a label que ira informar o usuario qual é o status momento da venda

    $('#iniciar_cotacao').click(function () {//iniciar venda
        formulario_post.reset(); // redefine os valores do formulário
        $("#codigo_nf").val(generateUniqueId())//gerar_codigo_nf automaticamente
        $(".title .status_momento_cotacao").html("Cotação Iniciada")//alterar a label cabeçalho
        $(".title .status_momento_cotacao").css("display", "")//display block para a label que ira informar o usuario qual é o status momento da venda
        setTimeout(function () {
            $(".title .status_momento_cotacao").html("Cotacação em Andamento..")//alterar a label cabeçalho
        }, 3000);
        if ($("#vendedor option[value='" + id_user_logado + "']").length > 0) {//selecionar o vendedor automaticamente
            $("#vendedor").val(id_user_logado)
        }
        $("#status_cotacao").val(1)
        tabela_produtos(codigo_nf.value);
    })



} else {//editar venda
    $('#alterar_venda').html('Alterar');
    $(".title .sub-title").html("Alterar venda")//alterar a label cabeçalho
    $(".title .status_momento_venda").html("Venda em alteração")//alterar a label cabeçalho
    // show(id_formulario.value) // funcao para retornar os dados para o formulario
    $("#iniciar_venda").css("display", "none");//inicar venda em none
    // Criação do botão com classes do Bootstrap
    var cancelarVendaButton = $("<button type='button'></button>")
        .attr("id", "cancelar_nf")
        .addClass("btn btn-sm btn-danger")
        .text("Cancelar Venda");
    var remover_faturamento = $("<button type='button'></button>")
        .attr("id", "remover_nf_faturamento")
        .addClass("btn btn-sm btn-warning")
        .text("Remover do faturamento");
    // Adiciona o botão ao elemento com a classe "btn-acao"
    $(".btn-acao").prepend(cancelarVendaButton);

    show(id_formulario.value, codigo_nf.value)//dados da nf
    tabela_produtos(codigo_nf.value);

    $("#cancelar_nf").click(function () {
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja cancelar essa venda?",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Não',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (result.isConfirmed) {
                cancelar_nf(id_formulario.value, codigo_nf.value, id_user_logado)
            }
        })
    })
}

$("#cotaca_mercadoria").submit(function (e) {
    e.preventDefault()
    var formulario = $(this);

    if (codigo_nf.value == "") {
        Swal.fire({
            icon: 'error',
            title: 'Verifique!',
            text: "A Cotação não foi iniciada, Favor clique no botão Iniciar Cotação",
            timer: 7500,
        })
    } else {//venda iniciada
        create(formulario,codigo_nf.value)
        //  adicionar_produto_venda(itens, codigo_nf.value, id_user_logado, user_logado, "false")//função para adicioonar o produto na venda validando as informações do produto e exibir a listagem de produtos
    }
})



function create(dados,codigo_nf) {
    $.ajax({
        type: "POST",
        data: "cotacao_mercadoria=true&acao=create&" + dados.serialize() + "&check_autorizador=false",
        url: "modal/venda/cotacao_mercadoria/gerenciar_cotacao.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            // Swal.fire({
            //     position: 'center',
            //     icon: 'success',
            //     title: $dados.title,
            //     showConfirmButton: false,
            //     timer: 3500
            // })
            tabela_produtos(codigo_nf)
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

function tabela_produtos(codigo_nf) {//tabela de produtos
    alert("ok")
    $.ajax({
        type: 'GET',
        data: "tabela_produto=true&codigo_nf=" + codigo_nf,
        url: "view/venda/cotacao_mercadoria/table/tabela_produtos.php",
        success: function (result) {
            return $(".tabela_externa").html(result)

        },
    })
}

//mostrar as informações no formulario show
function show(id, codigo_nf) {

    $.ajax({
        type: "POST",
        data: "venda_mercadoria=true&acao=show&nf_id=" + id + "&codigo_nf=" + codigo_nf,
        url: "modal/venda/venda_mercadoria/gerenciar_venda.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            $("#data_movimento").val($dados.valores['data_movimento'])
            $("#parceiro_descricao").val($dados.valores['parceiro_descricao'])
            $("#parceiro_id").val($dados.valores['parceiro_id'])
            $("#observacao").val($dados.valores['observacao'])

            var status_venda = $dados.valores['status_venda']
            var status_recebimento = $dados.valores['status_recebimento']


            $('#venda_mercadoria .title').each(function () {
                $(this).append('<label class="bg-primary">' + $dados.valores['serie_nf'] + " " + $dados.valores['numero_nf'] + '</label>')
                if (status_venda == "3") {//botão cancelar venda
                    $(this).append('<label class="bg-danger">Venda cancelada</label>')
                }

                if (status_recebimento == "2") {//botãoremover do faturamento
                    $(".btn-acao").prepend(remover_faturamento)
                }


            })

        }
    }

    function falha() {
        console.log("erro");
    }

}


function adicionar_produto_venda(itens, codigo_nf, id_user_logado, user_logado, autorizador) {

    let itensJSON = JSON.stringify(itens); //codificar para json
    $.ajax({
        type: "POST",
        data: {
            venda_mercadoria: true,
            acao: "validar_produto",
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
        if ($dados.sucesso == true) {//se tiver ok com as informações do prduto
            // produtos.push(itens)//guarda as informações do produto no array
            // exibirProdutos(produtos);//listar os produtos na tela
            // $(".table #valor_total_produtos").html(exibirValorTotalProdutos(produtos))//retornar p somatorio dos valores dos produto

            tabela_produtos(codigo_nf)
            resetarValoresProdutos()
        } else if ($dados.sucesso == "autorizar") {//validar autorizacao ao adicionar o produto
            $.ajax({
                type: 'GET',
                data: "autorizar_acao=true&mensagem=" + $dados.title,
                url: "view/include/autorizacao/autorizar_acao.php",
                success: function (result) {
                    return $(".modal_externo").html(result)
                        + $("#modal_autorizar_acao").modal('show')
                        + $("#autorizar_acao").addClass("autorizar_desconto_prd_venda");

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



function cancelar_nf(id_formulario, codigo_nf, id_user_logado) {

    $.ajax({
        type: "POST",
        data: "venda_mercadoria=true&acao=cancelar_nf&id_nf=" + id_formulario + "&codigo_nf=" + codigo_nf + "&id_user_logado=" + id_user_logado,
        url: "modal/venda/venda_mercadoria/gerenciar_venda.php",
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
            //   tabela_produtos(codigo_nf);//recarregar a tabela de produtos
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
function remover_nf_faturamento(id_formulario, codigo_nf, id_user_logado) {

    $.ajax({
        type: "POST",
        data: "venda_mercadoria=true&acao=remover_nf_faturamento&id_nf=" + id_formulario + "&codigo_nf=" + codigo_nf + "&id_user_logado=" + id_user_logado,
        url: "modal/venda/venda_mercadoria/gerenciar_venda.php",
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
            //   tabela_produtos(codigo_nf);//recarregar a tabela de produtos
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

function delete_item(codigo_nf, id_item_nf, id_produto, quantidade, id_user_logado) {

    $.ajax({
        type: "POST",
        data: "venda_mercadoria=true&acao=delete_item&id_item_nf=" + id_item_nf + "&id_produto=" + id_produto + "&codigo_nf=" + codigo_nf
            + "&quantidade_prod=" + quantidade + "&id_user_logado=" + id_user_logado,
        url: "modal/venda/venda_mercadoria/gerenciar_venda.php",
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
            tabela_produtos(codigo_nf);//recarregar a tabela de produtos
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
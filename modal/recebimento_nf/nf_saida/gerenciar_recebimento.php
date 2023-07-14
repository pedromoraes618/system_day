<?php


if (isset($_POST['recebimento_nf_saida'])) {
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
    $retornar = array();
    $acao = $_POST['acao'];
    $nf_id = $_POST['nf_id'];

    $serie_venda = verifcar_descricao_serie($conecta, "12"); //verificar qual seria usado na venda
    $nf_atual = consultar_valor_serie($conecta, "12"); //verificar a numeração da venda atual
    $alterar_fpg = consultar_valor_serie($conecta, "16"); //verificar a numeração da venda atual
    $cliente_avulso_id = verficar_paramentro($conecta, "tb_parametros", "cl_id", "8"); //verificar o id do cliente avulso
    $classficacao_financeiro_id = verficar_paramentro($conecta, "tb_parametros", "cl_id", "11"); //verificar o id do cliente avulso

    //consultar vendedor
    $select = "SELECT * from tb_forma_pagamento where cl_ativo ='S' ";
    $consultar_forma_pagamento = mysqli_query($conecta, $select);
    $consultar_forma_pagamento_update = mysqli_query($conecta, $select);

    $select = "SELECT cl_status_recebimento,cl_parceiro_id,cl_codigo_nf,cl_numero_nf,cl_valor_liquido,cl_forma_pagamento_id,prc.cl_razao_social from tb_nf_saida as nf inner join tb_parceiros as prc on prc.cl_id = nf.cl_parceiro_id where nf.cl_id = $nf_id";
    $consultar_nf = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consultar_nf);
    $numero_nf = ($linha['cl_numero_nf']);
    $valor_liquido = ($linha['cl_valor_liquido']);
    $forma_pagamento_nf = ($linha['cl_forma_pagamento_id']);
    $parceiro_id = ($linha['cl_parceiro_id']);
    $codigo_nf = ($linha['cl_codigo_nf']);
    $cliente = utf8_encode($linha['cl_razao_social']);
    $status_recebiemento = $linha['cl_status_recebimento'];
    if ($acao == "show") {
        $informacao = array(
            "numero_nf" => $numero_nf,
            "valor_liquido" => $valor_liquido,
            "forma_pagamento" => $forma_pagamento_nf,
            "cliente" => $cliente,
        );
        $retornar["dados"] = array("sucesso" => true, "valores" => $informacao);
    }

    if ($acao == "create") {
        $forma_pagamento = $_POST['forma_pagamento'];
        $id_user_logado = $_POST['id_usuario_logado'];

        if ($status_recebiemento == "2") { //RECEBIDO
            $retornar["dados"] = array("sucesso" => false, "title" => "Essa venda já foi recebida, não é possivel realizar o recebimento novamente");
        } elseif ($alterar_fpg == "S" and $forma_pagamento == "0") { //parametro setado para indicar se o usuario pode alterar a forma de pagamento pela tela de recebimento
            $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("forma de pagamento"));
        } else {
            if ($alterar_fpg == "S") {
                $forma_pagamento = $forma_pagamento; //forma de pagamento setado pelo usuario na tela de recebimento
            } else {
                $forma_pagamento = $forma_pagamento_nf; //forma de pagamento que já está setado na venda
            }
            $valor_recebido = 0;
            while ($linha = mysqli_fetch_assoc($consultar_forma_pagamento)) {
                $id_fpg = ($linha['cl_id']);
                $valor = $_POST["$id_fpg"]; //valor informado pelo usuario na forma de pagamento
                if ($valor != "") {
                    if (verificaVirgula($valor)) { //verificar se tem virgula
                       $valor = formatDecimal($valor); // formatar virgula para ponto
                    }
                 }
                $valor_recebido = $valor + $valor_recebido;
            }
            if ($valor_recebido != $valor_liquido) {
                $retornar["dados"] = array("sucesso" => false, "title" => "O valor informado difere do valor líquido da venda, o que impossibilita o recebimento, favor, verifique essa divergência");
            } else { //adicionar no financeiro
                while ($linha = mysqli_fetch_assoc($consultar_forma_pagamento_update)) {
                    $id_fpg = ($linha['cl_id']);
                    $valor = $_POST["$id_fpg"]; //valor informado pelo usuario na forma de pagamento
                    if ($valor != "") {
                        if (verificaVirgula($valor)) { //verificar se tem virgula
                           $valor = formatDecimal($valor); // formatar virgula para ponto
                        }
                     }
                 
                    if ($valor > 0 and $valor != "") {
                        recebimento_nf($conecta, $id_fpg, $data_lancamento, $serie_venda, $numero_nf, $parceiro_id, $classficacao_financeiro_id, $valor, "$serie_venda$numero_nf", $codigo_nf); //lancar no financeiro o recebimento
                    }
                }
                update_status_nf($conecta, "2", $data_lancamento, $id_user_logado, $nf_id, $forma_pagamento); //atualizar o status da venda para recebido
                $retornar["dados"] = array("sucesso" => true, "title" => "Recebimento realizado com sucesso");
            }
        }
    }

    echo json_encode($retornar);
}


$select = "SELECT * from tb_forma_pagamento where cl_ativo ='S' ";
$consultar_forma_pagamento = mysqli_query($conecta, $select);
$consultar_forma_pagamento_2 = mysqli_query($conecta, $select);

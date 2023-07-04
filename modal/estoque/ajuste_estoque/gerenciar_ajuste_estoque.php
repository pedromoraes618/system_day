<?php

//consultar informações para tabela
if (isset($_GET['consultar_ajst_produtos'])) {
    include "../../../../conexao/conexao.php";
    include "../../../../funcao/funcao.php";
    $codigo_nf = $_GET['codigo_nf'];

    $select = "SELECT ajst.cl_motivo,ajst.cl_tipo, ajst.cl_quantidade, ajst.cl_produto_id as id_produto, prd.cl_descricao as produto,users.cl_usuario,ajst.cl_documento from 
    tb_ajuste_estoque as ajst inner join tb_produtos as prd on prd.cl_id = ajst.cl_produto_id inner join 
    tb_users as users on users.cl_id = ajst.cl_usuario_id  where ajst.cl_codigo_nf ='$codigo_nf' ";
    $consultar_ajst_produtos = mysqli_query($conecta, $select);
    if (!$consultar_ajst_produtos) {
        die("Falha no banco de dados");
    } else {
        $qtd = mysqli_num_rows($consultar_ajst_produtos); //quantidade de registros
    }
}



//cadastrar formulario
if (isset($_POST['fomulario_ajuste_estoque'])) {
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
    $retornar = array();
    $nome_usuario_logado = $_POST["nome_usuario_logado"];
    $id_usuario_logado = $_POST["id_usuario_logado"];
    $perfil_usuario_logado = $_POST['perfil_usuario_logado'];

    $acao = ($_POST["acao"]);

    if ($acao == "create") {
        $id_produto = ($_POST["produto_id"]);
        $tipo = ($_POST["tipo"]);
        $quantidade = ($_POST["qtd_ajuste"]);
        $motivo = utf8_decode($_POST["motivo"]);
        $codigo_nf = ($_POST["codigo_nf"]);

        if ($id_produto == "") {
            $retornar["dados"] = array("sucesso" => "false", "title" => "Favor selecione o produto");
        } elseif ($tipo == "0") {
            $retornar["dados"] = array("sucesso" => "false", "title" => mensagem_alerta_cadastro("tipo"));
        } elseif ($quantidade == "" or $quantidade == "0") {
            $retornar["dados"] = array("sucesso" => "false", "title" => mensagem_alerta_cadastro("quantidade"));
        } elseif ($motivo == "") {
            $retornar["dados"] = array("sucesso" => "false", "title" => mensagem_alerta_cadastro("motivo"));
        } else {

            if (consulta_tabela($conecta, 'tb_produtos', 'cl_id', $id_produto, 'cl_status_ativo') != "SIM") { //verificar se o produto está ativo
                $retornar["dados"] = array("sucesso" => "false", "title" => "Esse produto não está ativo, não é possivel realizar o ajuste");
            } else {

                if ($quantidade != "") {
                    if (verificaVirgula($quantidade)) { //verificar se tem virgula
                        $quantidade = formatDecimal($quantidade); // formatar virgula para ponto
                    }
                }

                if (verifcar_descricao_serie($conecta, "2") == "") { // verificar se a serie está cadastrada
                    $retornar["dados"] = array("sucesso" => "false", "title" => mensagem_serie_cadastrada());
                } else {

                    $ajuste_estoque = consultar_serie($conecta, "2");
                    $ajuste_estoque = $ajuste_estoque + 1; //incremento para adicionar na serie ajuste de estoque


                    //verificar parametro cliente responsavel para ajuste de estoque
                    $empresa_ajuste = verficar_paramentro($conecta, "tb_parametros", "cl_id", "3");

                    //verificar parametro formar de  pagamento usada no ajuste de estoque
                    $forma_pagamento_ajuste = verficar_paramentro($conecta, "tb_parametros", "cl_id", "4");

                    //verificar parametro ajuste com valor menor ou maio ao estoque minimo e maixmo
                    $parametro_ajuste_estoque_minimo_maximo = verficar_paramentro($conecta, "tb_parametros", "cl_id", "5");

                    $estoque_atual = consulta_tabela($conecta, 'tb_produtos', 'cl_id', $id_produto, 'cl_estoque'); //consultar estoque atual do produto
                    $estoque_minimo = consulta_tabela($conecta, 'tb_produtos', 'cl_id', $id_produto, 'cl_estoque_minimo'); //consultar estoque minimo do produto
                    $estoque_maximo = consulta_tabela($conecta, 'tb_produtos', 'cl_id', $id_produto, 'cl_estoque_maximo'); //consultar estoque minimo do produto

                    $preco_venda_atual = consulta_tabela($conecta, 'tb_produtos', 'cl_id', $id_produto, 'cl_preco_venda');
                    $preco_compra_atual = consulta_tabela($conecta, 'tb_produtos', 'cl_id', $id_produto, 'cl_ult_preco_compra');

                    $valor_venda = 0;
                    $valor_compra = 0;
                    if ($tipo == 'SAIDA') { //realizar a operação se for saida subtrair ao estoque se não somar
                        $novo_estoque = $estoque_atual - $quantidade;
                        $valor_venda = $preco_venda_atual;
                    } else {
                        $novo_estoque = $estoque_atual + $quantidade;
                        $valor_compra = $preco_compra_atual;
                    }



                    if ($tipo == 'SAIDA' and ($novo_estoque < 0)) { // verificar se o estoque vai ser negativo
                        $retornar["dados"] = array("sucesso" => "false", "title" => "Não será possível realizar o ajuste de estoque solicitado, uma vez que este resultaria em um saldo negativo no estoque desse produto");
                    } else {

                        if (($parametro_ajuste_estoque_minimo_maximo == "S") and (($novo_estoque < $estoque_minimo) or ($novo_estoque > $estoque_maximo))) {
                            if ($novo_estoque < $estoque_minimo) {
                                $retornar["dados"] = array("sucesso" => "false", "title" => "Não é possivel realizar o ajuste, uma vez que este resultaria em um saldo abaixo do estoque minimo do produto");
                            } elseif ($novo_estoque > $estoque_maximo) {
                                $retornar["dados"] = array("sucesso" => "false", "title" => "Não é possivel realizar o ajuste, uma vez que este resultaria em um saldo acima do estoque máximo do produto");
                            }
                        } else {
                            //adicionar ao ajuste de estoque
                            $juste = ajuste_estoque($conecta, $data, "AJST-$ajuste_estoque", $tipo, $id_produto, $quantidade, $empresa_ajuste, "", $id_usuario_logado, $forma_pagamento_ajuste, "$valor_venda", "$valor_compra", '0', $motivo, $codigo_nf);
                            if ($juste) { // verificar se o ajuste foi feito sem erro
                                $retornar["dados"] = array("sucesso" => true, "title" => "Ajuste realizado com sucesso", "qtd" => $novo_estoque);
                                $ajustar_qtd_produto = ajuste_qtd_produto($conecta, $id_produto, $novo_estoque);


                                //atualizar valor em serie ajst // ajuste de estoque
                                adicionar_valor_serie($conecta, "2", $ajuste_estoque);

                                //registrar no log
                                $mensagem = (utf8_decode("Usúario") . " $nome_usuario_logado realizou o ajuste de estoque do produto de codigo $id_produto tipo de ajuste $tipo, quantidade $quantidade ");
                                registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
                            }
                        }
                    }
                }
            }
        }
    }
    echo json_encode($retornar);
}




if (isset($_GET['consultar_ajuste_estoque']) == true) {
    $id_produto = $_GET['id_produto'];
    $select = "SELECT user.cl_usuario as usuario,ajst.cl_quantidade,ajst.cl_id,ajst.cl_data_lancamento,ajst.cl_tipo,
   ajst.cl_documento,ajst.cl_status from tb_ajuste_estoque as ajst inner join tb_users as user on user.cl_id = ajst.cl_usuario_id 
    where ajst.cl_produto_id = $id_produto and ajst.cl_ajuste_inicial !='1' order by ajst.cl_id ";
    $consultar_historico_produto = mysqli_query($conecta, $select);
}

<?php

//consultar informações para tabela
if (isset($_GET['consultar_venda'])) {
   include "../../../../conexao/conexao.php";
   include "../../../../funcao/funcao.php";
   $consulta = $_GET['consultar_venda'];
   $data_inicial = $_GET['data_inicial'];
   $data_final = $_GET['data_final'];

   //formatar data para o banco de dados
   $data_inicial =  formatarDataParaBancoDeDados($data_inicial);
   $data_final =  formatarDataParaBancoDeDados($data_final);

   if ($consulta == "inicial") {
      $consultar_tabela_inicialmente =  verficar_paramentro($conecta, "tb_parametros", "cl_id", "1"); //VERIFICAR PARAMETRO ID - 1
      $select = "SELECT nf.cl_id as id,nf.cl_data_movimento,nf.cl_numero_nf,nf.cl_serie_nf,nf.cl_status_recebimento,user.cl_usuario as vendedor,
      nf.cl_valor_desconto,nf.cl_valor_liquido,prc.cl_razao_social,prc.cl_nome_fantasia,fpg.cl_descricao as formapgt from tb_nf_saida as nf inner join tb_parceiros as prc on prc.cl_id = nf.cl_parceiro_id inner join
       tb_forma_pagamento as fpg on fpg.cl_id = nf.cl_forma_pagamento_id inner join tb_users as user on user.cl_id = nf.cl_usuario_id WHERE nf.cl_data_movimento between '$data_inicial' and '$data_final' order by nf.cl_status_recebimento asc";
      $consultar_venda_mercadoria = mysqli_query($conecta, $select);
      if (!$consultar_venda_mercadoria) {
         die("Falha no banco de dados");
      } else {
         $qtd = mysqli_num_rows($consultar_venda_mercadoria); //quantidade de registros
      }
   } else {
      $pesquisa = utf8_decode($_GET['conteudo_pesquisa']); //filtro
      $status_recebimento = $_GET['status_recebimento'];

      $select = "SELECT nf.cl_id as id,nf.cl_data_movimento,nf.cl_numero_nf,nf.cl_serie_nf,nf.cl_status_recebimento,user.cl_usuario as vendedor,
      nf.cl_valor_desconto,nf.cl_valor_liquido,prc.cl_razao_social,prc.cl_nome_fantasia,fpg.cl_descricao as formapgt from tb_nf_saida as nf inner join tb_parceiros as prc on prc.cl_id = nf.cl_parceiro_id inner join
       tb_forma_pagamento as fpg on fpg.cl_id = nf.cl_forma_pagamento_id inner join tb_users as user on user.cl_id = nf.cl_usuario_id WHERE nf.cl_data_movimento between '$data_inicial' and '$data_final' and 
      (nf.cl_numero_nf  like '%$pesquisa%' or prc.cl_razao_social  like '%$pesquisa%' or prc.cl_nome_fantasia  like '%$pesquisa%' )  ";

      if ($status_recebimento != "0") {
         $select .= " and nf.cl_status_recebimento = '$status_recebimento' ";
      }

      $select .= " order by nf.cl_status_recebimento asc";
      $consultar_venda_mercadoria = mysqli_query($conecta, $select);
      if (!$consultar_venda_mercadoria) {
         die("Falha no banco de dados");
      } else {
         $qtd = mysqli_num_rows($consultar_venda_mercadoria);
      }
   }
}

// // //cadastrar formulario
// if (isset($_POST['formulario_lancamento_financeiro'])) {
//    include "../../../conexao/conexao.php";
//    include "../../../funcao/funcao.php";
//    $retornar = array();
//    $acao = $_POST['acao'];
//    if ($acao == "show") {
//       $conta_financeira_id = $_POST['conta_financeira_id'];
//       $select = "SELECT lcf.cl_data_lancamento,lcf.cl_data_vencimento,lcf.cl_data_pagamento,lcf.cl_conta_financeira,lcf.cl_forma_pagamento_id,lcf.cl_parceiro_id,parc.cl_razao_social,lcf.cl_tipo_lancamento,
//       lcf.cl_status_id,lcf.cl_valor_bruto,lcf.cl_valor_liquido,lcf.cl_bx_parcial,lcf.cl_juros,lcf.cl_taxa,lcf.cl_desconto,lcf.cl_documento,lcf.cl_classificacao_id,lcf.cl_descricao,lcf.cl_observacao,cl_ordem_servico
//                from tb_lancamento_financeiro as lcf inner join tb_parceiros as parc on parc.cl_id = lcf.cl_parceiro_id WHERE lcf.cl_id = $conta_financeira_id  ";
//       $consultar_lancamento_financeiro = mysqli_query($conecta, $select);
//       $linha = mysqli_fetch_assoc($consultar_lancamento_financeiro);
//       $data_lancamento =  ($linha['cl_data_lancamento']);
//       $data_vencimento =  ($linha['cl_data_vencimento']);
//       $data_pagamento =  ($linha['cl_data_pagamento']);
//       $conta_financeira =  ($linha['cl_conta_financeira']);
//       $forma_pagamento =  ($linha['cl_forma_pagamento_id']);
//       $parceiro_id =  ($linha['cl_parceiro_id']);
//       $parceiro =  utf8_encode($linha['cl_razao_social']);
//       $status =  utf8_encode($linha['cl_status_id']);
//       $valor_bruto =  utf8_encode($linha['cl_valor_bruto']);


//       $descricao =  utf8_encode($linha['cl_descricao']);

//       $informacao = array(
//          "data_movimento" => formatDateB($data_lancamento),
//          "data_vencimento" => formatDateB($data_vencimento),
//          "data_pagamento" => formatDateB($data_pagamento),
//          "conta_financeira" => $conta_financeira,
//          "forma_pagamento" => $forma_pagamento,
//          "parceiro_id" => $parceiro_id,
//          "parceiro_descricao" => $parceiro,

//          "status" => $status,
//          "valor_bruto" => $valor_bruto,
//          "parceiro_descricao" => $parceiro,
//          "parceiro_descricao" => $parceiro,

//          "descricao" => $descricao,


//       );

//       $retornar["dados"] = array("sucesso" => true, "valores" => $informacao);
//    }
//    if ($acao == "show") {
//       $conta_financeira_id = $_POST['conta_financeira_id'];
//       $select = "SELECT lcf.cl_data_lancamento,lcf.cl_data_vencimento,lcf.cl_data_pagamento,lcf.cl_conta_financeira,lcf.cl_forma_pagamento_id,lcf.cl_parceiro_id,parc.cl_razao_social,lcf.cl_tipo_lancamento,
//       lcf.cl_status_id,lcf.cl_valor_bruto,lcf.cl_valor_liquido,lcf.cl_bx_parcial,lcf.cl_juros,lcf.cl_taxa,lcf.cl_desconto,lcf.cl_documento,
//       lcf.cl_classificacao_id,lcf.cl_descricao,lcf.cl_observacao,cl_ordem_servico from tb_lancamento_financeiro as lcf inner join tb_parceiros as parc on parc.cl_id = lcf.cl_parceiro_id WHERE lcf.cl_id = $conta_financeira_id  ";
//       $consultar_lancamento_financeiro = mysqli_query($conecta, $select);
//       $linha = mysqli_fetch_assoc($consultar_lancamento_financeiro);
//       $data_lancamento =  ($linha['cl_data_lancamento']);
//       $data_vencimento =  ($linha['cl_data_vencimento']);
//       $data_pagamento =  ($linha['cl_data_pagamento']);
//       $conta_financeira =  ($linha['cl_conta_financeira']);
//       $forma_pagamento =  ($linha['cl_forma_pagamento_id']);
//       $parceiro_id =  ($linha['cl_parceiro_id']);
//       $parceiro =  utf8_encode($linha['cl_razao_social']);
//       $status =  ($linha['cl_status_id']);
//       $valor_bruto =  ($linha['cl_valor_bruto']);
//       $valor_liquido =  ($linha['cl_valor_liquido']);
//       $baixa_parcial =  ($linha['cl_bx_parcial']);
//       $juros =  ($linha['cl_juros']);
//       $taxa =  ($linha['cl_taxa']);
//       $desconto =  ($linha['cl_desconto']);
//       $documento =  ($linha['cl_documento']);
//       $classificacao =  ($linha['cl_classificacao_id']);
//       $observacao =  utf8_encode($linha['cl_observacao']);
//       $ordem_servico =  ($linha['cl_ordem_servico']);
//       $descricao =  utf8_encode($linha['cl_descricao']);

//       $informacao = array(
//          "data_movimento" => formatDateB($data_lancamento),
//          "data_vencimento" => formatDateB($data_vencimento),
//          "data_pagamento" => formatDateB($data_pagamento),
//          "conta_financeira" => $conta_financeira,
//          "forma_pagamento" => $forma_pagamento,
//          "parceiro_id" => $parceiro_id,
//          "parceiro_descricao" => $parceiro,
//          "status" => $status,
//          "valor_bruto" => $valor_bruto,
//          "valor_liquido" => $valor_liquido,
//          "baixa_parcial" => $baixa_parcial,
//          "juros" => $juros,
//          "taxa" => $taxa,
//          "desconto" => $desconto,
//          "documento" => $documento,
//          "classificacao" => $classificacao,
//          "observacao" => $observacao,
//          "ordem_servico" => $ordem_servico,
//          "descricao" => $descricao,
//       );

//       $retornar["dados"] = array("sucesso" => true, "valores" => $informacao);
//    }


//    if ($acao == "create") {
//       $nome_usuario_logado = $_POST["nome_usuario_logado"];
//       $id_usuario_logado = $_POST["id_usuario_logado"];
//       $perfil_usuario_logado = $_POST['perfil_usuario_logado'];

//       $data_vencimento = ($_POST['data_vencimento']);
//       $data_pagamento = ($_POST['data_pagamento']);
//       $conta_financeira = utf8_decode($_POST['conta_financeira']);
//       $forma_pagamento = utf8_decode($_POST['forma_pagamento']);
//       $status = utf8_decode($_POST['status']);
//       $parceiro_id = ($_POST['parceiro_id']);
//       $descricao = utf8_decode($_POST['descricao']);
//       $classificacao = ($_POST['classificacao']);
//       $documento = utf8_decode($_POST['documento']);
//       $ordem_servico = ($_POST['ordem_servico']);
//       $valor_bruto = ($_POST['valor_bruto']);
//       $valor_liquido = ($_POST['valor_liquido']);
//       $baixa_parcial = ($_POST['baixa_parcial']);
//       $juros = ($_POST['juros']);
//       $taxa = ($_POST['taxa']);
//       $desconto = ($_POST['desconto']);
//       $observacao = utf8_decode($_POST['observacao']);
//       $tipo_lancamento = $_POST['tipo'];

//       if ($data_vencimento == "") {
//          $retornar["dados"] =  array("sucesso" => false, "title" => mensagem_alerta_cadastro("data vencimento"));
//       } elseif (($data_pagamento) == "" and ($status == "2" or $status == "4")) {
//          $retornar["dados"] =  array("sucesso" => false, "title" => mensagem_alerta_cadastro("data pagamento"));
//       } elseif (($data_pagamento) != "" and ($status == "1" or $status == "3")) {
//          $retornar["dados"] =  array("sucesso" => false, "title" => "Você informou a data de pagamento, mas não atualizou o status, favor, verifique e atualize o status");
//       } elseif (datecheck($data_vencimento) != true and $data_vencimento != "") {
//          $retornar["dados"] = array("sucesso" => false, "title" => "A data Vencimento não é uma data válida, Favor verifique");
//       } elseif (datecheck($data_pagamento) != true and $data_pagamento != "") {
//          $retornar["dados"] = array("sucesso" => false, "title" => "A data Pagamento não é uma data válida, Favor verifique");
//       } elseif ($conta_financeira == "0") {
//          $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("conta financeira"));
//       } elseif ($forma_pagamento == "0") {
//          $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("forma pagamento"));
//       } elseif ($status == "0") {
//          $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("status"));
//       } elseif ($classificacao == "0") {
//          $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("classificação"));
//       } else {


//          $data_vencimento = formatarDataParaBancoDeDados($data_vencimento);

//          if ($data_pagamento != "") {
//             $data_pagamento = formatarDataParaBancoDeDados($data_pagamento);
//          }

//          if ($parceiro_id == "") { //verificar se não foi informado nenehum parceiro, se caso não foi vai utilizar o parceiro padrão
//             $parceiro_id = verficar_paramentro($conecta, 'tb_parametros', 'cl_id', '8');
//          }

//          if ($valor_bruto != "") {
//             if (verificaVirgula($valor_bruto)) { //verificar se tem virgula
//                $valor_bruto = formatDecimal($valor_bruto); // formatar virgula para ponto
//             }
//          }

//          if ($valor_liquido != "") {
//             if (verificaVirgula($valor_liquido)) { //verificar se tem virgula
//                $valor_liquido = formatDecimal($valor_liquido); // formatar virgula para ponto
//             }
//          }
//          if ($baixa_parcial != "") {
//             if (verificaVirgula($baixa_parcial)) { //verificar se tem virgula
//                $baixa_parcial = formatDecimal($baixa_parcial); // formatar virgula para ponto
//             }
//          }
//          if ($juros != "") {
//             if (verificaVirgula($juros)) { //verificar se tem virgula
//                $juros = formatDecimal($juros); // formatar virgula para ponto
//             }
//          }
//          if ($taxa != "") {
//             if (verificaVirgula($taxa)) { //verificar se tem virgula
//                $taxa = formatDecimal($taxa); // formatar virgula para ponto
//             }
//          }
//          if ($desconto != "") {
//             if (verificaVirgula($desconto)) { //verificar se tem virgula
//                $desconto = formatDecimal($desconto); // formatar virgula para ponto
//             }
//          }

//          //query
//          $insert = "INSERT INTO `system_day`.`tb_lancamento_financeiro` (`cl_data_lancamento`, `cl_data_vencimento`, `cl_data_pagamento`, `cl_conta_financeira`, 
//          `cl_forma_pagamento_id`, `cl_parceiro_id`, `cl_tipo_lancamento`, `cl_status_id`, `cl_valor_bruto`, `cl_valor_liquido`, `cl_bx_parcial`, `cl_juros`, `cl_taxa`,
//           `cl_desconto`, `cl_documento`, `cl_classificacao_id`, `cl_descricao`, `cl_observacao`, `cl_serie_nf`,`cl_ordem_servico`) VALUES 
//          ( '$data_lancamento', '$data_vencimento', '$data_pagamento', '$conta_financeira', '$forma_pagamento', '$parceiro_id', '$tipo_lancamento', '$status', '$valor_bruto', '$valor_liquido', '$baixa_parcial',
//           '$juros', '$taxa', '$desconto', '$documento', '$classificacao', '$descricao', '$observacao', 'LCFAVUL','$ordem_servico' )";



//          if ($data_pagamento != "") { //verificar se o caixa está aberto
//             $caixa =  verifica_caixa_financeiro($conecta, $data_pagamento, $conta_financeira);
//             if (($caixa['resultado']) == "") { //verificar se o caixa já foi aberto
//                $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_caixa("VAZIO")); //alertar o usuario que o caixa ainda não foi aberto
//             } else {
//                if ($caixa['status'] == "fechado") {
//                   $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_caixa("FECHADO")); //alertar o usuario que o caixa está fechado
//                } else {
//                   $operacao_insert = mysqli_query($conecta, $insert); //realiZAR O insert no banco de dados
//                   if ($operacao_insert) {
//                      $retornar["dados"] = array("sucesso" => true, "title" => "Lançamento realizado om sucesso");
//                      $mensagem = utf8_decode("Usuário $nome_usuario_logado realizou o lançamento financeiro do tipo $tipo_lancamento no valor de $valor_liquido");
//                      registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
//                   }
//                }
//             }
//          } else {
//             $operacao_insert = mysqli_query($conecta, $insert);
//             if ($operacao_insert) {
//                $retornar["dados"] = array("sucesso" => true, "title" => "Lançamento realizado om sucesso");
//                $mensagem = utf8_decode("Usuário $nome_usuario_logado realizou o lançamento financeiro do tipo $tipo_lancamento no valor de $valor_liquido");
//                registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
//             }
//          }
//       }
//    }


//    if ($acao == "update") { // EDITAR
//       $nome_usuario_logado = $_POST["nome_usuario_logado"];
//       $id_usuario_logado = $_POST["id_usuario_logado"];
//       $perfil_usuario_logado = $_POST['perfil_usuario_logado'];
//       $id_lancamento = ($_POST['id']);

//       $data_vencimento = ($_POST['data_vencimento']);
//       $data_pagamento = ($_POST['data_pagamento']);
//       $conta_financeira = utf8_decode($_POST['conta_financeira']);
//       $forma_pagamento = utf8_decode($_POST['forma_pagamento']);
//       $status = utf8_decode($_POST['status']);
//       $parceiro_id = ($_POST['parceiro_id']);
//       $descricao = utf8_decode($_POST['descricao']);
//       $classificacao = ($_POST['classificacao']);
//       $documento = utf8_decode($_POST['documento']);
//       $ordem_servico = ($_POST['ordem_servico']);
//       $valor_bruto = ($_POST['valor_bruto']);
//       $valor_liquido = ($_POST['valor_liquido']);
//       $baixa_parcial = ($_POST['baixa_parcial']);
//       $juros = ($_POST['juros']);
//       $taxa = ($_POST['taxa']);
//       $desconto = ($_POST['desconto']);
//       $observacao = utf8_decode($_POST['observacao']);
//       $tipo_lancamento = $_POST['tipo'];

//       if ($data_vencimento == "") {
//          $retornar["dados"] =  array("sucesso" => false, "title" => mensagem_alerta_cadastro("data vencimento"));
//       } elseif (($data_pagamento) == "" and ($status == "2" or $status == "4")) {
//          $retornar["dados"] =  array("sucesso" => false, "title" => mensagem_alerta_cadastro("data pagamento"));
//       } elseif (($data_pagamento) != "" and ($status == "1" or $status == "3")) {
//          $retornar["dados"] =  array("sucesso" => false, "title" => "Você informou a data de pagamento, mas não atualizou o status, favor, verifique e atualize o status");
//       } elseif (datecheck($data_vencimento) != true and $data_vencimento != "") {
//          $retornar["dados"] = array("sucesso" => false, "title" => "A data Vencimento não é uma data válida, Favor verifique");
//       } elseif (datecheck($data_pagamento) != true and $data_pagamento != "") {
//          $retornar["dados"] = array("sucesso" => false, "title" => "A data Pagamento não é uma data válida, Favor verifique");
//       } elseif ($conta_financeira == "0") {
//          $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("conta financeira"));
//       } elseif ($forma_pagamento == "0") {
//          $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("forma pagamento"));
//       } elseif ($status == "0") {
//          $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("status"));
//       } elseif ($classificacao == "0") {
//          $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("classificação"));
//       } else {


//          $data_vencimento = formatarDataParaBancoDeDados($data_vencimento);

//          if ($data_pagamento != "") {
//             $data_pagamento = formatarDataParaBancoDeDados($data_pagamento);
//          }

//          if ($parceiro_id == "") { //verificar se não foi informado nenehum parceiro, se caso não foi vai utilizar o parceiro padrão
//             $parceiro_id = verficar_paramentro($conecta, 'tb_parametros', 'cl_id', '8');
//          }

//          if ($valor_bruto != "") {
//             if (verificaVirgula($valor_bruto)) { //verificar se tem virgula
//                $valor_bruto = formatDecimal($valor_bruto); // formatar virgula para ponto
//             }
//          }

//          if ($valor_liquido != "") {
//             if (verificaVirgula($valor_liquido)) { //verificar se tem virgula
//                $valor_liquido = formatDecimal($valor_liquido); // formatar virgula para ponto
//             }
//          }
//          if ($baixa_parcial != "") {
//             if (verificaVirgula($baixa_parcial)) { //verificar se tem virgula
//                $baixa_parcial = formatDecimal($baixa_parcial); // formatar virgula para ponto
//             }
//          }
//          if ($juros != "") {
//             if (verificaVirgula($juros)) { //verificar se tem virgula
//                $juros = formatDecimal($juros); // formatar virgula para ponto
//             }
//          }
//          if ($taxa != "") {
//             if (verificaVirgula($taxa)) { //verificar se tem virgula
//                $taxa = formatDecimal($taxa); // formatar virgula para ponto
//             }
//          }
//          if ($desconto != "") {
//             if (verificaVirgula($desconto)) { //verificar se tem virgula
//                $desconto = formatDecimal($desconto); // formatar virgula para ponto
//             }
//          }

//          //query
//          $update = "UPDATE `system_day`.`tb_lancamento_financeiro` SET 
//           `cl_data_vencimento` = '$data_vencimento', `cl_data_pagamento` = '$data_pagamento', `cl_conta_financeira` = '$conta_financeira',
//            `cl_forma_pagamento_id` = '$forma_pagamento', `cl_parceiro_id` = '$parceiro_id', `cl_status_id` = '$status',
//             `cl_valor_bruto` = '$valor_bruto', `cl_valor_liquido` = '$valor_liquido', `cl_bx_parcial` = '$baixa_parcial', `cl_juros` = '$juros', `cl_taxa` = '$taxa', 
//             `cl_desconto` = '$desconto', `cl_documento` = '$documento', `cl_classificacao_id` = '$classificacao', `cl_descricao` = '$descricao', `cl_observacao` = '$observacao',
//           `cl_ordem_servico` = '$ordem_servico' WHERE `tb_lancamento_financeiro`.`cl_id` = $id_lancamento ";



//          if ($data_pagamento != "") { //verificar se o caixa está aberto
//             $caixa =  verifica_caixa_financeiro($conecta, $data_pagamento, $conta_financeira);
//             if (($caixa['resultado']) == "") { //verificar se o caixa já foi aberto
//                $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_caixa("VAZIO")); //alertar o usuario que o caixa ainda não foi aberto
//             } else {
//                if ($caixa['status'] == "fechado") {
//                   $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_caixa("FECHADO")); //alertar o usuario que o caixa está fechado
//                } else {
//                   $operacao_update = mysqli_query($conecta, $update); //realiZAR O insert no banco de dados
//                   if ($operacao_update) {
//                      $retornar["dados"] = array("sucesso" => true, "title" => "Lançamento alterado om sucesso");
//                      $mensagem = utf8_decode("Usuário $nome_usuario_logado alterou o lançamento de código $id_lancamento");
//                      registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
//                   }
//                }
//             }
//          } else {
//             $operacao_update = mysqli_query($conecta, $update);
//             if ($operacao_update) {
//                $retornar["dados"] = array("sucesso" => true, "title" => "Lançamento alterado om sucesso");
//                $mensagem = utf8_decode("Usuário $nome_usuario_logado alterou o lançamento de código $id_lancamento");
//                registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
//             }
//          }
//       }
//    }

//    echo json_encode($retornar);
// }


if (isset($_POST['venda_mercadoria'])) {
   include "../../../conexao/conexao.php";
   include "../../../funcao/funcao.php";
   $acao = $_POST['acao'];
   $registro = $_POST['resgistro'];

   if ($acao == "validar_produto") {
      $validar_venda_sem_estoque = verficar_paramentro($conecta, "tb_parametros", "cl_id", "9"); //verificar no paramentro se pode adicionar o produto sem estoque
      $desconto_maximo_produto = verficar_paramentro($conecta, "tb_parametros", "cl_id", "10"); //verificar o desconto maimo para o produto na venda
      $itensJSON = $_POST['itens'];
      $itens = json_decode($itensJSON, true); //recuperar valor do array javascript decodificando o json

      $estoque = $itens['estoque'];
      $id_produto = $itens['id_produto'];
      $descricao_produto = $itens['descricao_produto'];
      $preco_venda = $itens['preco_venda'];
      $quantidade = $itens['quantidade'];
      $valor_total = $itens['valor_total'];
      $preco_venda_atual = $itens['preco_venda_atual'];

      if ($preco_venda != "" and $preco_venda_atual != "") {
         $calula_desconto = (($preco_venda * 100) / $preco_venda_atual);
         $calula_desconto = (100 - $calula_desconto);
      }

      if ($registro == 'sem_registro') {
         if ($estoque == "" or $id_produto == "" or $descricao_produto == "" or $preco_venda == ""  or $quantidade == "" or $valor_total == ""  or $preco_venda_atual =="" or $quantidade == "0" or $preco_venda == "0" or $preco_venda_atual == "0" or $valor_total = "0") {
            $retornar["dados"] =  array("sucesso" => false, "title" => "Favor informe todas as informações do produto");
         } elseif ($validar_venda_sem_estoque == "N" and $estoque == 0) {
            $retornar["dados"] =  array("sucesso" => false, "title" => "Não é possivel adicionar o produto, pois está sem estoque");
         } elseif (($desconto_maximo_produto < $calula_desconto and ($desconto_maximo_produto !=""))) {
            $retornar["dados"] =  array("sucesso" => "autorizar", "title" => "Não é possivel adicionar o produto, o desconto está acima do permitido, continue com a operação autorizando com a senha");
         } else {
            $retornar["dados"] =  array("sucesso" => true);
         }
      }
   }



   echo json_encode($retornar);
}


if (isset($_POST['consultar_select'])) {
   include "../../../conexao/conexao.php";
   include "../../../funcao/funcao.php";
   $retornar = array();
   $array_consulta_status_lancamento = array();
   $array_consulta_classificao_financeiro = array();

   $select = "SELECT * from tb_status_recebimento";
   $consultar_status_lancamento = mysqli_query($conecta, $select);

   $select = "SELECT * from tb_classificacao_financeiro";
   $consultar_classificao_financeiro = mysqli_query($conecta, $select);



   if ($consultar_status_lancamento) {
      while ($linha = mysqli_fetch_assoc($consultar_status_lancamento)) {
         $descricao = $linha['cl_descricao'];
         $id = $linha['cl_id'];

         $informacao = array(
            "descricao" => $descricao,
            'id' => $id,

         );
         array_push($array_consulta_status_lancamento, $informacao);
      }
   }

   if ($consultar_classificao_financeiro) {
      while ($linha = mysqli_fetch_assoc($consultar_classificao_financeiro)) {
         $descricao = $linha['cl_descricao'];
         $id = $linha['cl_id'];

         $informacao = array(
            "descricao" => $descricao,
            'id' => $id,
         );
         array_push($array_consulta_classificao_financeiro, $informacao);
      }
   }
   $retornar["dados"] = array("sucesso" => true, "status_lancamento" => $array_consulta_status_lancamento, "classificao_financeiro" => $array_consulta_classificao_financeiro);

   echo json_encode($retornar);
}


//consultar conta financeira
$select = "SELECT * from tb_users where cl_vendedor ='SIM' ";
$consultar_vendedor = mysqli_query($conecta, $select);

$select = "SELECT * from tb_forma_pagamento where cl_ativo ='S' ";
$consultar_forma_pagamento = mysqli_query($conecta, $select);

// //consultar status recebimento
// $select = "SELECT * from tb_status_recebimento ";
// $consultar_status_recebimento = mysqli_query($conecta, $select);

// //consultar forma pagamento
// $select = "SELECT * from tb_forma_pagamento ";
// $consultar_forma_pagamento = mysqli_query($conecta, $select);


// //consultar classificacao financeiro
// $select = "SELECT * from tb_classificacao_financeiro";
// $consultar_classificacao_financeiro = mysqli_query($conecta, $select);
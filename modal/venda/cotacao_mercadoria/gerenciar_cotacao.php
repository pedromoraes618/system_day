<?php

if (isset($_GET['form_id'])) {
   $id_nf = $_GET['form_id'];
   $tipo = $_GET['tipo'];
   $codigo_nf = $_GET['codigo_nf'];
} else {
   $id_nf = "";
   $tipo = "";
   $codigo_nf = "";
}


//consultar informações para tabela
if (isset($_GET['consultar_cotacao'])) {
   include "../../../../conexao/conexao.php";
   include "../../../../funcao/funcao.php";
   $consulta = $_GET['consultar_cotacao'];
   $data_inicial = $_GET['data_inicial'];
   $data_final = $_GET['data_final'];

   //formatar data para o banco de dados
   $data_inicial =  formatarDataParaBancoDeDados($data_inicial);
   $data_final =  formatarDataParaBancoDeDados($data_final);

   if ($consulta == "inicial") {
      $consultar_tabela_inicialmente =  verficar_paramentro($conecta, "tb_parametros", "cl_id", "1"); //VERIFICAR PARAMETRO ID - 1
      $select = "SELECT ctc.cl_id as id_cotacao,ctc.cl_codigo_nf,ctc.cl_parceiro_avulso,ctc.cl_data_movimento,
      ctc.cl_parceiro_id,prc.cl_razao_social,ctc.cl_status_cotacao_id,user.cl_usuario as vendedor,stc.cl_descricao as statusc,
      ctc.cl_validade,ctc.cl_valor_bruto,ctc.cl_valor_liquido,ctc.cl_valor_desconto from tb_cotacao as ctc inner join
      tb_Status_cotacao as stc on ctc.cl_status_cotacao_id = stc.cl_id inner join tb_parceiros as prc on prc.cl_id = ctc.cl_parceiro_id inner join tb_users as user on user.cl_id = ctc.cl_vendedor_id
      WHERE ctc.cl_data_movimento between '$data_inicial' and '$data_final' order by ctc.cl_id desc";
      $consultar_cotacao_mercadoria = mysqli_query($conecta, $select);
      if (!$consultar_cotacao_mercadoria) {
         die("Falha no banco de dados");
      } else {
         $qtd = mysqli_num_rows($consultar_cotacao_mercadoria); //quantidade de registros
      }
   } else {
      $pesquisa = utf8_decode($_GET['conteudo_pesquisa']); //filtro
      $status_recebimento = $_GET['status_recebimento'];

      $select = "SELECT nf.cl_codigo_nf, nf.cl_status_venda, fpg.cl_tipo_pagamento_id as tipopg, nf.cl_id as id,nf.cl_data_movimento,nf.cl_numero_nf,nf.cl_serie_nf,nf.cl_status_recebimento,user.cl_usuario as vendedor,
      nf.cl_valor_desconto,nf.cl_valor_liquido,prc.cl_razao_social,prc.cl_nome_fantasia,fpg.cl_descricao as formapgt from tb_nf_saida as nf inner join
       tb_parceiros as prc on prc.cl_id = nf.cl_parceiro_id inner join
       tb_forma_pagamento as fpg on fpg.cl_id = nf.cl_forma_pagamento_id inner join tb_users as user on user.cl_id = nf.cl_vendedor_id WHERE nf.cl_data_movimento between '$data_inicial' and '$data_final' and 
      ( nf.cl_numero_nf  like '%$pesquisa%' or prc.cl_razao_social  like '%$pesquisa%' or prc.cl_nome_fantasia  like '%$pesquisa%' )    ";

      if ($status_recebimento != "0") {
         $select .= " and nf.cl_status_recebimento = '$status_recebimento' and nf.cl_status_venda ='1' ";
      }

      $select .= " order by nf.cl_id desc";
      $consultar_venda_mercadoria = mysqli_query($conecta, $select);
      if (!$consultar_venda_mercadoria) {
         die("Falha no banco de dados");
      } else {
         $qtd = mysqli_num_rows($consultar_venda_mercadoria);
      }
   }
}

if (isset($_GET['tabela_produto'])) {
   include "../../../../conexao/conexao.php";
   include "../../../../funcao/funcao.php";
   $codigo_nf = $_GET['codigo_nf'];
   $select  = "SELECT * from tb_cotacao_item where cl_codigo_nf = '$codigo_nf'";
   $consultar_produtos = mysqli_query($conecta, $select);
}

if (isset($_POST['cotacao_mercadoria'])) {
   include "../../../conexao/conexao.php";
   include "../../../funcao/funcao.php";
   $acao = $_POST['acao'];
   $validar_venda_sem_estoque = verficar_paramentro($conecta, "tb_parametros", "cl_id", "9"); //verificar no paramentro se pode adicionar o produto sem estoque
   $desconto_maximo_produto = verficar_paramentro($conecta, "tb_parametros", "cl_id", "10"); //verificar o desconto maimo para o produto na venda
   $serie_venda = verifcar_descricao_serie($conecta, "12"); //verificar qual seria usado na venda
   $nf_atual = consultar_valor_serie($conecta, "12"); //verificar a numeração da venda atual
   $cliente_avulso_id = verficar_paramentro($conecta, "tb_parametros", "cl_id", "8"); //verificar o id do cliente avulso
   $classficacao_financeiro_id = verficar_paramentro($conecta, "tb_parametros", "cl_id", "11"); //verificar o id do cliente avulso
   $abrir_recibo = verficar_paramentro($conecta, "tb_parametros", "cl_id", "17"); //verificar o id do cliente avulso
   $venda_prd_vlr_zerado = verficar_paramentro($conecta, "tb_parametros", "cl_id", "27"); //verificar o id do cliente avulso
   $nf_novo = $nf_atual + 1;

   if ($acao == "validar_produto") { //validar dados do produto
      $preco_venda = 0;
      $desconto_real = 0;
      $calula_desconto = 0;

      // $registro = $_POST['resgistro'];
      $codigo_nf = $_POST['cd_nf'];
      $id_user_logado = $_POST['id_user'];
      $nome_usuario_logado = $_POST['user_nome'];
      $check_autorizador = $_POST['check_autorizador'];

      $itensJSON = $_POST['itens']; //array de produtos
      $itens = json_decode($itensJSON, true); //recuperar valor do array javascript decodificando o json

      $id_produto = $itens['id_produto'];
      $descricao_produto = utf8_decode($itens['descricao_produto']);
      $preco_venda = $itens['preco_venda'];
      $quantidade = $itens['quantidade'];
      $unidade = utf8_decode($itens['unidade']);


      if ($preco_venda != "") {
         if (verificaVirgula($preco_venda)) { //verificar se tem virgula
            $preco_venda = formatDecimal($preco_venda); // formatar virgula para ponto
         }
      }
      if ($quantidade != "") {
         if (verificaVirgula($quantidade)) { //verificar se tem virgula
            $quantidade = formatDecimal($quantidade); // formatar virgula para ponto
         }
      }


      if ($id_produto == "") { //validar se algum produto já foi selecionado
         $retornar["dados"] =  array("sucesso" => false, "title" => "Favor Selecione um produto");
      } else {
         //$valor_total = $itens['valor_total'];
         $estoque =  validar_prod_venda($conecta, $id_produto, "cl_estoque"); //estoque disponivel do produto
         $preco_venda_atual =  validar_prod_venda($conecta, $id_produto, "cl_preco_venda"); //preco de venda do produto no cadastro
         $preco_venda_promocao =  validar_prod_venda($conecta, $id_produto, "cl_preco_promocao"); //preco de venda do produto no cadastro

         $referencia =  validar_prod_venda($conecta, $id_produto, "cl_referencia"); //preco de venda do produto no cadastro
         $valor_total = $preco_venda * $quantidade;


         if ($preco_venda != "" and $preco_venda_atual != "" and $preco_venda != 0 and $preco_venda_atual != 0) {
            $calula_desconto = (($preco_venda * 100) / $preco_venda_atual);
            $calula_desconto = (100 - $calula_desconto); //desconto em porcentagem

            $desconto_real = $preco_venda_atual - $preco_venda; //desconto em real
         }

         if ($preco_venda == $preco_venda_promocao) {
            $preco_venda = $preco_venda_promocao;
            $desconto_real = 0;
            $calula_desconto = 0;
         }


         if ($estoque == "" or $id_produto == "" or $descricao_produto == "" or $preco_venda == ""  or $quantidade == ""  or $quantidade == "0") {
            $retornar["dados"] =  array("sucesso" => false, "title" => "Favor informe todas as informações do produto");
         } elseif ($venda_prd_vlr_zerado != "S" and $preco_venda == 0) {
            $retornar["dados"] =  array("sucesso" => false, "title" => "Não é possivel adicionar o produto, o preço de venda não pode ser 0");
         } elseif ($validar_venda_sem_estoque == "N" and $estoque == 0) {
            $retornar["dados"] =  array("sucesso" => false, "title" => "Não é possivel adicionar o produto, pois está sem estoque");
         } elseif (($desconto_maximo_produto < $calula_desconto and ($desconto_maximo_produto != "") and ($check_autorizador != "true"))) {
            $retornar["dados"] =  array("sucesso" => "autorizar", "title" => "Não é possivel adicionar o produto, o desconto está acima do permitido, continue com a operação autorizando com a senha");
         } elseif (validar_qtd_prod_venda($conecta, $id_produto, $codigo_nf, $quantidade) > $estoque) { //validar se a quantidade adicionado mais o mesmo produto que esta na venda atende o estoque
            $retornar["dados"] =  array("sucesso" => false, "title" => "Não é possivel adicionar o produto, a demanda no estoque não atende");
         } else {
            $nf = consulta_tabela($conecta, "tb_nf_saida", "cl_codigo_nf", $codigo_nf, "cl_numero_nf");
            if ($nf != "") { //Adicionando um prduto a uma venda já finalizada
               $status_recebimento = consulta_tabela($conecta, "tb_nf_saida", "cl_codigo_nf", $codigo_nf, "cl_status_recebimento");
               $status_venda = consulta_tabela($conecta, "tb_nf_saida", "cl_codigo_nf", $codigo_nf, "cl_status_venda");

               if ($status_venda == "3") { //venda cancelada
                  $retornar["dados"] = array("sucesso" => false, "title" => "Não é possível adicionar o produto, pois a venda foi cancelada");
               } elseif ($status_recebimento == "2") { //a venda está recebida
                  $retornar["dados"] = array("sucesso" => false, "title" => "Não é possível adicionar o produto, pois a venda já foi recebida, favor, remova-o do faturamento antes de prosseguir com a ação");
               } else {
                  $insert = "INSERT INTO `system_day`.`tb_nf_saida_item` ( `cl_data_movimento`, `cl_codigo_nf`,`cl_numero_nf`, `cl_usuario_id`, `cl_serie_nf`, 
               `cl_item_id`, `cl_descricao_item`, `cl_quantidade`, `cl_unidade`, `cl_valor_unitario`, `cl_valor_total`,
              `cl_desconto`, `cl_referencia`,`cl_status`) VALUES ( '$data_lancamento', '$codigo_nf','$nf', '$id_user_logado', '$serie_venda',
                   '$id_produto', '$descricao_produto', '$quantidade', '$unidade', '$preco_venda', '$valor_total', '$desconto_real',
              '$referencia','1') ";
                  $operacao_insert = mysqli_query($conecta, $insert);
                  if ($operacao_insert) {
                     $retornar["dados"] =  array("sucesso" => true);
                     recalcular_valor_nf($conecta, $codigo_nf);

                     $mensagem = utf8_decode("Adicionou o produto de código $id_produto na $serie_venda $nf já finalizada");
                     registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
                  } else {
                     $mensagem = utf8_decode("Tentativa do usuário $nome_usuario_logado adicionar um produto em uma venda com já finalizada, erro");
                     registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
                     $retornar["dados"] =  array("sucesso" => false, "title" => "Erro, não foi possivel adicionar o produto, favor verifique com o suporte");
                  }
               }
            } else { //adicionar um produto em uma nova venda
               $insert = "INSERT INTO `system_day`.`tb_nf_saida_item` ( `cl_data_movimento`, `cl_codigo_nf`, `cl_usuario_id`, `cl_serie_nf`, 
               `cl_item_id`, `cl_descricao_item`, `cl_quantidade`, `cl_unidade`, `cl_valor_unitario`, `cl_valor_total`,
              `cl_desconto`, `cl_referencia`,`cl_status`) VALUES ( '$data_lancamento', '$codigo_nf', '$id_user_logado', '$serie_venda',
                   '$id_produto', '$descricao_produto', '$quantidade', '$unidade', '$preco_venda', '$valor_total', '$desconto_real',
              '$referencia','2') ";
               $operacao_insert = mysqli_query($conecta, $insert);
               if ($operacao_insert) {
                  $retornar["dados"] =  array("sucesso" => true);
                  //   recalcular_valor_nf($conecta, $codigo_nf);
               } else {
                  $mensagem = utf8_decode("Tentativa do usuário $nome_usuario_logado adicionar um produto em uma venda com erro");
                  registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
                  $retornar["dados"] =  array("sucesso" => false, "title" => "Erro, não foi possivel adicionar o produto, favor verifique com o suporte");
               }
            }
         }
      }
   }
   if ($acao == "validar_alteracao_produto") { //validar dados do produto
      // $registro = $_POST['resgistro'];
      $codigo_nf = $_POST['cd_nf'];
      $id_user_logado = $_POST['id_user'];
      // $nome_usuario_logado = $_POST['user_nome'];
      $nome_usuario_logado = consulta_tabela($conecta, "tb_users", "cl_id", $id_user_logado, "cl_usuario");
      $check_autorizador = $_POST['check_autorizador'];

      $itensJSON = $_POST['itens']; //array de produtos
      $itens = json_decode($itensJSON, true); //recuperar valor do array javascript decodificando o json

      $id_produto = $itens['id_produto']; //id do produto que está cadastrado no sistema
      $id_item_nf = $itens['id_item_nf']; //id do produto na tabela nfe_saida_item
      $descricao_produto = utf8_decode($itens['descricao_produto']);
      $preco_venda = $itens['preco_venda'];
      $quantidade = $itens['quantidade'];
      $unidade = utf8_decode($itens['unidade']);


      if ($quantidade != "") {
         if (verificaVirgula($quantidade)) { //verificar se tem virgula
            $quantidade = formatDecimal($quantidade); // formatar virgula para ponto
         }
      }
      if ($preco_venda != "") {
         if (verificaVirgula($preco_venda)) { //verificar se tem virgula
            $preco_venda = formatDecimal($preco_venda); // formatar virgula para ponto
         }
      }

      $nf = consulta_tabela($conecta, "tb_nf_saida", "cl_codigo_nf", $codigo_nf, "cl_numero_nf");
      $preco_venda_promocao =  validar_prod_venda($conecta, $id_produto, "cl_preco_promocao"); //preco de venda do produto no cadastro


      if ($id_item_nf == "") { //validar se algum produto já foi selecionado
         $retornar["dados"] =  array("sucesso" => false, "title" => "Favor Selecione um produto");
      } else {
         //$valor_total = $itens['valor_total'];
         $estoque =  validar_prod_venda($conecta, $id_produto, "cl_estoque"); //estoque disponivel do produto
         $preco_venda_atual =  validar_prod_venda($conecta, $id_produto, "cl_preco_venda"); //preco de venda do produto no cadastro
         $referencia =  validar_prod_venda($conecta, $id_produto, "cl_referencia"); //preco de venda do produto no cadastro
         $valor_total = $preco_venda * $quantidade;

         if ($preco_venda != "" and $preco_venda_atual != "") {
            $calula_desconto = (($preco_venda * 100) / $preco_venda_atual);
            $calula_desconto = (100 - $calula_desconto); //desconto em porcentagem

            $desconto_real = $preco_venda_atual - $preco_venda; //desconto em real
         }

         if ($preco_venda == $preco_venda_promocao) {
            $preco_venda = $preco_venda_promocao;
            $desconto_real = 0;
            $calula_desconto = 0;
         }


         if ($estoque == "" or $id_produto == "" or $descricao_produto == "" or $preco_venda == ""  or $quantidade == "" or $valor_total == ""  or $preco_venda_atual == "" or $quantidade == "0" or $preco_venda == "0" or $preco_venda_atual == "0") {
            $retornar["dados"] =  array("sucesso" => false, "title" => "Favor informe todas as informações do produto");
         } elseif ($validar_venda_sem_estoque == "N" and $estoque == 0) {
            $retornar["dados"] =  array("sucesso" => false, "title" => "Não é possivel adicionar o produto, pois o produto está sem estoque");
         } elseif (($desconto_maximo_produto < $calula_desconto and ($desconto_maximo_produto != "") and ($check_autorizador != "true"))) {
            $retornar["dados"] =  array("sucesso" => "autorizar", "title" => "Não é possivel alterar o produto, o desconto está acima do permitido, continue com a operação autorizando com a senha");
         } elseif ((validar_qtd_prod_venda($conecta, $id_produto, $codigo_nf, $quantidade) >  $estoque)) { //validar se a quantidade adicionado mais o mesmo produto que esta na venda atende o estoque
            $retornar["dados"] =  array("sucesso" => false, "title" => "Não é possivel adicionar o produto, a demanda no estoque não atende");
         } else {

            if ($nf != "") { //Adicionando um prduto a uma venda já finalizada
               $status_recebimento = consulta_tabela($conecta, "tb_nf_saida", "cl_codigo_nf", $codigo_nf, "cl_status_recebimento");
               $status_venda = consulta_tabela($conecta, "tb_nf_saida", "cl_codigo_nf", $codigo_nf, "cl_status_venda");

               if ($status_venda == "3") { //venda cancelada
                  $retornar["dados"] = array("sucesso" => false, "title" => "Não é possível alterar o produto, pois a venda foi cancelada");
               } elseif ($status_recebimento == "2") { //a venda está recebida
                  $retornar["dados"] = array("sucesso" => false, "title" => "Não é possível alterar o produto, pois a venda já foi recebida, favor, remova-o do faturamento antes de prosseguir com a ação");
               } else { //alterar o produto com a venda já finalizada

                  $update = "UPDATE `system_day`.`tb_nf_saida_item` SET `cl_descricao_item` = '$descricao_produto', `cl_quantidade` = '$quantidade',
               `cl_valor_unitario` = '$preco_venda', `cl_valor_total` = '$valor_total', `cl_desconto` = '$desconto_real' WHERE `tb_nf_saida_item`.`cl_id` = $id_item_nf  ";
                  $operacao_update = mysqli_query($conecta, $update);
                  if ($operacao_update) {
                     $retornar["dados"] = array("sucesso" => true, "title" => "Produto alterado com sucesso");
                     recalcular_valor_nf($conecta, $codigo_nf);
                  } else {
                     $mensagem = utf8_decode("Tentativa do usuário $nome_usuario_logado alterar o produto de id $id_produto da venda sem sucesso");
                     registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
                     $retornar["dados"] =  array("sucesso" => false, "title" => "Erro, não foi possivel alterar o produto, favor verifique com o suporte");
                  }
               }
            } else { //alterar o produto com a venda em andamento

               $update = "UPDATE `system_day`.`tb_nf_saida_item` SET `cl_descricao_item` = '$descricao_produto', `cl_quantidade` = '$quantidade',
             `cl_valor_unitario` = '$preco_venda', `cl_valor_total` = '$valor_total', `cl_desconto` = '$desconto_real' WHERE `tb_nf_saida_item`.`cl_id` = $id_item_nf  ";
               $operacao_update = mysqli_query($conecta, $update);
               if ($operacao_update) {
                  $retornar["dados"] = array("sucesso" => true, "title" => "Produto alterado com sucesso");
               } else {
                  $mensagem = utf8_decode("Tentativa do usuário $nome_usuario_logado alterar o produto de id $id_produto da venda sem sucesso");
                  registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
                  $retornar["dados"] =  array("sucesso" => false, "title" => "Erro, não foi possivel alterar o produto, favor verifique com o suporte");
               }
            }
         }
      }
   }



   if ($acao == "create") {
      /*usuario logado */
      $nome_usuario_logado = $_POST["nome_usuario_logado"];
      $id_usuario_logado = $_POST["id_usuario_logado"];
      $perfil_usuario_logado = $_POST['perfil_usuario_logado'];
      $check_autorizador = $_POST['check_autorizador'];
      /*dados basicos da cotaccaco*/
      $codigo_nf = $_POST['codigo_nf'];
      $vendedor = $_POST['vendedor'];
      $status_cotacao = $_POST['status_cotacao'];
      $validade = $_POST['validade'];
      $att = $_POST['att'];
      $parceiro_descricao = utf8_decode($_POST['parceiro_descricao']);
      $parceiro_id = $_POST['parceiro_id'];
      $observacao = utf8_decode($_POST['observacao']);


      if ($parceiro_id == "") { //se a venda não possuir cliente será colocado o cliente padrão que está setado no parametro
         $parceiro_id = $cliente_avulso_id;
         $parceiro_avulso = $parceiro_descricao;
      } else {
         $parceiro_avulso = "";
      }




      /*dados do produto*/
      $id_produto = $_POST['produto_id'];
      $descricao_produto = $_POST['descricao_produto'];
      $quantidade = $_POST['quantidade'];
      $preco_venda = $_POST['preco_venda'];


      if ($id_produto != "") {
         $unidade_prod_id = consulta_tabela($conecta, "tb_produtos", "cl_id", $id_produto, "cl_und_id");
         $descricao_unidade_prod = consulta_tabela($conecta, "tb_unidade_medida", "cl_id", $unidade_prod_id, "cl_sigla");
         //$valor_total = $itens['valor_total'];
         $estoque =  validar_prod_venda($conecta, $id_produto, "cl_estoque"); //estoque disponivel do produto
         $preco_venda_atual =  validar_prod_venda($conecta, $id_produto, "cl_preco_venda"); //preco de venda do produto no cadastro
         $referencia =  validar_prod_venda($conecta, $id_produto, "cl_referencia"); //preco de venda do produto no cadastro
         $preco_venda_promocao =  validar_prod_venda($conecta, $id_produto, "cl_preco_promocao"); //preco de venda do produto no cadastro

         $valor_total = $preco_venda * $quantidade;

         if ($preco_venda != "" and $preco_venda_atual != "") {
            $calula_desconto = (($preco_venda * 100) / $preco_venda_atual);
            $calula_desconto = (100 - $calula_desconto); //desconto em porcentagem
            $desconto_real = $preco_venda_atual - $preco_venda; //desconto em real
         }

         if ($preco_venda == $preco_venda_promocao) {
            $preco_venda = $preco_venda_promocao;
            $desconto_real = 0;
            $calula_desconto = 0;
         }
      }


      if ($codigo_nf == "") {
         $retornar["dados"] = array("sucesso" => false, "title" => "É necessario iniciar a cotação para prosseguir");
      } else {
         $nf = consulta_tabela($conecta, "tb_cotacao", "cl_codigo_nf", $codigo_nf, "cl_id"); //verificar se já existe a cotação
         if ($nf == "") { //inserir a cotação
            if ($vendedor == "0") {
               $retornar["dados"] =  array("sucesso" => false, "title" => mensagem_alerta_cadastro("Vendedor"));
            } elseif ($status_cotacao == "0") {
               $retornar["dados"] =  array("sucesso" => false, "title" => mensagem_alerta_cadastro("Status cotação"));
            } elseif ($id_produto == "") {
               $retornar["dados"] =  array("sucesso" => false, "title" => "Favor, selecione o produto");
            } elseif ($descricao_produto == "" or $preco_venda == ""  or $quantidade == "" or $valor_total == ""  or $preco_venda_atual == "" or $quantidade == "0" or $preco_venda == "0" or $preco_venda_atual == "0") {
               $retornar["dados"] =  array("sucesso" => false, "title" => "Favor informe todas as informações do produto");
            } elseif (($desconto_maximo_produto < $calula_desconto and ($desconto_maximo_produto != "") and ($check_autorizador != "true"))) {
               $retornar["dados"] =  array("sucesso" => "autorizar", "title" => "Não é possivel adicionar o produto, o desconto está acima do permitido, continue com a operação autorizando com a senha");
            } else {
               $insert = "INSERT INTO `system_day`.`tb_cotacao` (`cl_data_movimento`, `cl_codigo_nf`, `cl_parceiro_id`,
             `cl_parceiro_avulso`, `cl_vendedor_id`, `cl_status_cotacao_id`, `cl_validade`, `cl_att`, `cl_valor_bruto`, `cl_valor_liquido`,
              `cl_valor_desconto`, `cl_data_fechamento`) VALUES 
              ( '$data_lancamento', '$codigo_nf', '$parceiro_id', '$parceiro_avulso', '$vendedor', '$status_cotacao', '$validade', '$att', '0', '4', '1', '2023-07-29')";
               $operacao_insert = mysqli_query($conecta, $insert);
               if ($operacao_insert) {
                  insert_produto_cotacao(
                     $conecta,
                     $data_lancamento,
                     $codigo_nf,
                     $vendedor,
                     $id_produto,
                     $descricao_produto,
                     $referencia,
                     $quantidade,
                     $descricao_unidade_prod,
                     $preco_venda,
                     $desconto_real,
                     $valor_total,
                     "",
                     1
                  );
                  $retornar["dados"] = array("sucesso" => true, "title" => "Produto alterado com sucesso");
               }
            }
         } else { //update na cotação

         }
      }
   }


   if ($acao == "show") { //dados da nf
      $nf_id = $_POST['nf_id'];
      $codigo_nf = $_POST['codigo_nf'];


      $select = "SELECT * from tb_nf_saida where cl_id = $nf_id and cl_codigo_nf ='$codigo_nf'";
      $consultar_nf = mysqli_query($conecta, $select);
      $linha = mysqli_fetch_assoc($consultar_nf);
      $parceiro_id = ($linha['cl_parceiro_id']);
      $data_movimento = formatDateB($linha['cl_data_movimento']);
      $observacao = utf8_encode($linha['cl_observacao']);
      $id_forma_pagamento_venda = ($linha['cl_forma_pagamento_id']);
      $vendedor_id_venda = ($linha['cl_vendedor_id']);
      $desconto_venda_real = ($linha['cl_valor_desconto']);
      $valor_liquido_venda = ($linha['cl_valor_liquido']);
      $sub_total_venda = ($linha['cl_valor_bruto']);
      $numero_nf = ($linha['cl_numero_nf']);
      $serie_nf = ($linha['cl_serie_nf']);
      $status_venda = ($linha['cl_status_venda']);
      $status_recebimento = ($linha['cl_status_recebimento']);


      $parceiro_descricao = utf8_encode(consulta_tabela($conecta, "tb_parceiros", "cl_id", $parceiro_id, "cl_razao_social"));
      $descricao_forma_pagamento_venda = utf8_encode(consulta_tabela($conecta, "tb_forma_pagamento", "cl_id", $id_forma_pagamento_venda, "cl_descricao"));



      $informacao = array(
         "data_movimento" => $data_movimento,
         "parceiro_descricao" => $parceiro_descricao,
         "parceiro_id" => $parceiro_id,
         "observacao" => $observacao,
         "valor_liquido_venda" => $valor_liquido_venda,
         "sub_total_venda" => $sub_total_venda,
         "desconto_venda_real" => $desconto_venda_real,
         "vendedor_id_venda" => $vendedor_id_venda,
         "id_forma_pagamento_venda" => $id_forma_pagamento_venda,
         "descricao_forma_pagamento_venda" => $descricao_forma_pagamento_venda,
         "numero_nf" => $numero_nf,
         "serie_nf" => $serie_nf,
         "status_venda" => $status_venda,
         "status_recebimento" => $status_recebimento,

      );

      $retornar["dados"] = array("sucesso" => true, "valores" => $informacao);
   }

   if ($acao == "cancelar_nf") {
      $id_nf = $_POST['id_nf'];
      $codigo_nf = $_POST['codigo_nf'];
      $id_user_logado = $_POST['id_user_logado'];
      $status_venda = consulta_tabela($conecta, "tb_nf_saida", "cl_codigo_nf", $codigo_nf, "cl_status_venda");
      $autorizado_cancelar_venda = consulta_tabela($conecta, "tb_users", "cl_id", $id_user_logado, "cl_cancelar_venda");

      if ($id_nf == "" or $codigo_nf == "") {
         $retornar["dados"] = array("sucesso" => false, "title" => "Não é possivel cancelar a venda, venda não encontrada, favor verifique");
      } elseif ($autorizado_cancelar_venda != "SIM") {
         $retornar["dados"] = array("sucesso" => false, "title" => "Não é possivel cancelar a venda, o seu usuário não tem autorização");
      } elseif ($status_venda == "3") {
         $retornar["dados"] = array("sucesso" => false, "title" => "Não é possível cancelar a venda, pois ela já está cancelada");
      } else {
         if (cancelar_nf($conecta, $id_nf, $codigo_nf, $id_user_logado, $data)) {
            $retornar["dados"] = array("sucesso" => true, "title" => "Venda cancelada com sucesso");
         } else {
            $retornar["dados"] = array("sucesso" => false, "title" => "Erro, favor comunique o suporte");
         }
      }
   }
   if ($acao == "remover_nf_faturamento") {
      $id_nf = $_POST['id_nf'];
      $codigo_nf = $_POST['codigo_nf'];
      $id_user_logado = $_POST['id_user_logado'];
      $status_venda = consulta_tabela($conecta, "tb_nf_saida", "cl_codigo_nf", $codigo_nf, "cl_status_venda");


      if ($id_nf == "" or $codigo_nf == "") {
         $retornar["dados"] = array("sucesso" => false, "title" => "Não é possivel cancelar a venda, venda não encontrada, favor verifique");
      } elseif ($status_venda == "3") {
         $retornar["dados"] = array("sucesso" => false, "title" => "Não é possível remover a venda do faturamento, pois ela está cancelada");
      } else {
         if (remover_nf_faturamento($conecta, $id_nf, $codigo_nf, $id_user_logado, $data)) {
            $retornar["dados"] = array("sucesso" => true, "title" => "Venda foi removida do faturamento com sucesso");
         } else {
            $retornar["dados"] = array("sucesso" => false, "title" => "Erro, favor comunique o suporte");
         }
      }
   }

   if ($acao == "show_det_produto") {
      $id_produto = $_POST['produto_id'];
      $select = "SELECT * from tb_nf_saida_item where cl_id = $id_produto";
      $consultar_produtos = mysqli_query($conecta, $select);
      $linha = mysqli_fetch_assoc($consultar_produtos);
      $descricao = utf8_encode($linha['cl_descricao_item']);
      $quantidade = $linha['cl_quantidade'];
      $valor_unitario = $linha['cl_valor_unitario'];
      $valor_total = $linha['cl_valor_total'];
      $unidade = utf8_encode($linha['cl_unidade']);
      $item_id = ($linha['cl_item_id']);
      $preco_venda_atual =  validar_prod_venda($conecta, $item_id, "cl_preco_venda"); //preco de venda do produto no cadastro

      $desconto_percente = calcularPorcentagemDesconto($valor_unitario, $preco_venda_atual);
      $informacao = array(
         "descricao" => $descricao,
         "quantidade" => $quantidade,
         "preco_venda" => $valor_unitario,
         "unidade" => $unidade,
         "valor_total" => $valor_total,
         "preco_venda_atual" => $preco_venda_atual,
         "desconto" => $desconto_percente,
         "id_produto" => $item_id,
      );

      $retornar["dados"] = array("sucesso" => true, "valores" => $informacao);
   }

   if ($acao == "delete_item") {

      $id_item_nf = $_POST['id_item_nf'];
      $produto_id = $_POST['id_produto'];
      $codigo_nf = $_POST['codigo_nf'];
      $quantidade = $_POST['quantidade_prod'];
      $id_user_logado = $_POST['id_user_logado'];

      $status_recebimento = consulta_tabela($conecta, "tb_nf_saida", "cl_codigo_nf", $codigo_nf, "cl_status_recebimento");
      $status_venda = consulta_tabela($conecta, "tb_nf_saida", "cl_codigo_nf", $codigo_nf, "cl_status_venda");

      if ($id_item_nf == "" or $codigo_nf == "") {
         $retornar["dados"] = array("sucesso" => false, "title" => "Não é possivel remover o produto, produto não encontrado, favor verifique");
      } elseif ($status_venda == "3") {
         $retornar["dados"] = array("sucesso" => false, "title" => "Não é possivel remover o produto, a venda está cancelada");
      } elseif ($status_recebimento == "2") { //a venda está recebida
         $retornar["dados"] = array("sucesso" => false, "title" => "Não é possível remover o produto, pois a venda já foi recebida, favor, remova-o do faturamento antes de prosseguir com a ação");
      } else {
         if (delete_item_nf($conecta, $id_item_nf, $produto_id, $codigo_nf, $quantidade, $id_user_logado, $data)) {
            $retornar["dados"] = array("sucesso" => true, "title" => "Produto removido com sucesso");
         } else {
            $retornar["dados"] = array("sucesso" => false, "title" => "Erro, favor comunique o suporte");
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



//consultar vendedor
$select = "SELECT * from tb_users where cl_vendedor ='SIM' ";
$consultar_vendedor = mysqli_query($conecta, $select);

//consultar status cotacao
$select = "SELECT * from tb_status_cotacao";
$consultar_status_cotacao = mysqli_query($conecta, $select);





if (isset($_GET['recibo'])) {
   $codigo_nf = $_GET['codigo_nf'];
   $serie_nf = $_GET['serie_nf'];

   /*dados da empresa */
   $select = "SELECT  * from tb_empresa where cl_id ='1' ";
   $consultar_empresa = mysqli_query($conecta, $select);
   $linha = mysqli_fetch_assoc($consultar_empresa);
   $empresa = utf8_encode($linha['cl_empresa']);
   $cnpj_empresa  = ($linha['cl_cnpj']);
   $endereco_empresa = utf8_encode($linha['cl_endereco']);
   $numero_empresa = ($linha['cl_numero']);
   $cep_empresa = ($linha['cl_cep']);
   $telefone_empresa = ($linha['cl_telefone']);
   $cidade_empresa =  utf8_encode($linha['cl_cidade']);
   $estado_empresa = ($linha['cl_estado']);

   /*dados da venda */
   $select = "SELECT  nf.cl_codigo_nf, nf.cl_observacao,nf.cl_status_venda, fpg.cl_tipo_pagamento_id as tipopg, nf.cl_id as id,nf.cl_data_movimento,nf.cl_numero_nf,nf.cl_serie_nf,nf.cl_status_recebimento,user.cl_nome as vendedor,
   nf.cl_valor_desconto,nf.cl_valor_liquido,prc.cl_razao_social,prc.cl_nome_fantasia,fpg.cl_descricao as formapgt from tb_nf_saida as nf inner join tb_parceiros as prc on prc.cl_id = nf.cl_parceiro_id inner join
    tb_forma_pagamento as fpg on fpg.cl_id = nf.cl_forma_pagamento_id inner join tb_users as user on user.cl_id = nf.cl_vendedor_id
     WHERE nf.cl_codigo_nf ='$codigo_nf' and nf.cl_serie_nf='$serie_nf' ";
   $consultar_nf_saida = mysqli_query($conecta, $select);
   $linha = mysqli_fetch_assoc($consultar_nf_saida);
   $data_movimento_b = ($linha['cl_data_movimento']);
   $numero_nf_b = ($linha['cl_numero_nf']);
   $codigo_nf = ($linha['cl_codigo_nf']);
   $serie_nf_b = ($linha['cl_serie_nf']);
   $status_recebmento_b = ($linha['cl_status_recebimento']);
   $status_recebmento_b_2 = ($linha['cl_status_recebimento']);
   $forma_pagamento_b = utf8_encode($linha['formapgt']);
   $razao_social_b = utf8_encode($linha['cl_razao_social']);
   $nome_fantasia_b = utf8_encode($linha['cl_nome_fantasia']);
   $valor_desconto_b = ($linha['cl_valor_desconto']);
   $valor_liquido_b = ($linha['cl_valor_liquido']);
   $vendedor_b = utf8_encode($linha['vendedor']);
   $tipo_pagamento = ($linha['tipopg']);
   $status_venda = ($linha['cl_status_venda']);
   $observacao = utf8_encode($linha['cl_observacao']);

   $select = "SELECT * from tb_nf_saida_item where cl_codigo_nf = '$codigo_nf' and cl_serie_nf='$serie_nf'";
   $consultar_nf_saida_item = mysqli_query($conecta, $select);
}


// //consultar status recebimento
// $select = "SELECT * from tb_status_recebimento ";
// $consultar_status_recebimento = mysqli_query($conecta, $select);

// //consultar forma pagamento
// $select = "SELECT * from tb_forma_pagamento ";
// $consultar_forma_pagamento = mysqli_query($conecta, $select);


// //consultar classificacao financeiro
// $select = "SELECT * from tb_classificacao_financeiro";
// $consultar_classificacao_financeiro = mysqli_query($conecta, $select);
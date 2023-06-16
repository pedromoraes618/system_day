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
      $select = "SELECT  nf.cl_id as id,nf.cl_data_movimento,nf.cl_numero_nf,nf.cl_serie_nf,nf.cl_status_recebimento,user.cl_usuario as vendedor,
      nf.cl_valor_desconto,nf.cl_valor_liquido,prc.cl_razao_social,prc.cl_nome_fantasia,fpg.cl_descricao as formapgt from tb_nf_saida as nf inner join tb_parceiros as prc on prc.cl_id = nf.cl_parceiro_id inner join
       tb_forma_pagamento as fpg on fpg.cl_id = nf.cl_forma_pagamento_id inner join tb_users as user on user.cl_id = nf.cl_vendedor_id WHERE nf.cl_data_movimento between '$data_inicial' and '$data_final' order by nf.cl_status_recebimento asc";
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
       tb_forma_pagamento as fpg on fpg.cl_id = nf.cl_forma_pagamento_id inner join tb_users as user on user.cl_id = nf.cl_vendedor_id WHERE nf.cl_data_movimento between '$data_inicial' and '$data_final' and 
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



if (isset($_POST['venda_mercadoria'])) {
   include "../../../conexao/conexao.php";
   include "../../../funcao/funcao.php";
   $acao = $_POST['acao'];
   $validar_venda_sem_estoque = verficar_paramentro($conecta, "tb_parametros", "cl_id", "9"); //verificar no paramentro se pode adicionar o produto sem estoque
   $desconto_maximo_produto = verficar_paramentro($conecta, "tb_parametros", "cl_id", "10"); //verificar o desconto maimo para o produto na venda
   $serie_venda = verifcar_descricao_serie($conecta, "12"); //verificar qual seria usado na venda
   $nf_atual = consultar_valor_serie($conecta, "12"); //verificar a numeração da venda atual
   $cliente_avulso_id = verficar_paramentro($conecta, "tb_parametros", "cl_id", "8"); //verificar o id do cliente avulso
   $classficacao_financeiro_id = verficar_paramentro($conecta, "tb_parametros", "cl_id", "11"); //verificar o id do cliente avulso
   $nf_novo = $nf_atual + 1;

   if ($acao == "validar_produto") { //validar dados do produto
      $registro = $_POST['resgistro'];
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
         if ($estoque == "" or $id_produto == "" or $descricao_produto == "" or $preco_venda == ""  or $quantidade == "" or $valor_total == ""  or $preco_venda_atual == "" or $quantidade == "0" or $preco_venda == "0" or $preco_venda_atual == "0" or $valor_total = "0") {
            $retornar["dados"] =  array("sucesso" => false, "title" => "Favor informe todas as informações do produto");
         } elseif ($validar_venda_sem_estoque == "N" and $estoque == 0) {
            $retornar["dados"] =  array("sucesso" => false, "title" => "Não é possivel adicionar o produto, pois está sem estoque");
         } elseif (($desconto_maximo_produto < $calula_desconto and ($desconto_maximo_produto != ""))) {
            $retornar["dados"] =  array("sucesso" => "autorizar", "title" => "Não é possivel adicionar o produto, o desconto está acima do permitido, continue com a operação autorizando com a senha");
         } else {
            $retornar["dados"] =  array("sucesso" => true);
         }
      }
   }

   if ($acao == "create") { //criar a venda
      ///  $momento_venda = $_POST['momento_venda'];


      $ordem_item = 0;
      $valor_total_bruto = 0;
      $produtosJSON = $_POST['produtos'];
      $produtos = json_decode($produtosJSON, true); //recuperar valor do array javascript decodificando o json

      $nome_usuario_logado = $_POST["nome_usuario_logado"];
      $id_usuario_logado = $_POST["id_usuario_logado"];
      $perfil_usuario_logado = $_POST['perfil_usuario_logado'];
      $id_venda = $_POST['id'];
      $vendedor_id_venda = $_POST['vendedor_id_venda'];
      $parceiro_id = $_POST['parceiro_id'];
      $parceiro_descricao = $_POST['parceiro_descricao'];
      $desconto_venda_real = $_POST['desconto_venda_real'];
      $forma_pagamento_id_venda = $_POST['forma_pagamento_id_venda'];
      $observacao = $_POST['observacao'];
      $autorizador_id = $_POST['autorizador_id'];
      $senha_autorizador = $_POST['senha_autorizador'];


      // Percorrer os itens do array de produtos
      foreach ($produtos as $itens) {
         $valor_total = $itens['valor_total'];
         $valor_total_bruto = $valor_total + $valor_total_bruto;
      }


      if ($desconto_venda_real == "") {
         $desconto_venda_real = 0;
      } else {
         if (verificaVirgula($desconto_venda_real)) { //verificar se tem virgula
            $desconto_venda_real = formatDecimal($desconto_venda_real); // formatar virgula para ponto
         }
      }

      if (verificaVirgula($valor_total_bruto)) { //verificar se tem virgula
         $valor_total_bruto = formatDecimal($valor_total_bruto); // formatar virgula para ponto
      }

      if ($parceiro_id == "") {
         $parceiro_id = $cliente_avulso_id;
         $parceiro_avulso = $parceiro_descricao;
      } else {
         $parceiro_avulso = "";
      }

      if ($id_venda != "") {
         $retornar["dados"] = array("sucesso" => false, "title" => "Não é possivel finalizar essa venda, pois já foi finalizada");
      } elseif ($valor_total_bruto == "") {
         $retornar["dados"] = array("sucesso" => false, "title" => "Não é possivel finalizar essa venda, não foi adicionado itens a venda");
      } elseif ($desconto_venda_real != "" and $desconto_venda_real < 0) {
         $retornar["dados"] = array("sucesso" => false, "title" => "Não é possivel finalizar essa venda, o desconto não pode ser negativo");
      } elseif ($vendedor_id_venda == "0") {
         $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("vendedor"));
      } elseif ($forma_pagamento_id_venda == "") {
         $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("forma de pagamento"));
      } elseif ($desconto_venda_real > (verifica_desconto_fpg($conecta, $forma_pagamento_id_venda)) and ($autorizador_id == "0" or $senha_autorizador == "")) {
         $retornar["dados"] =  array("sucesso" => "autorizar", "title" => "Não é possivel finalizar a venda, o desconto está acima do permitido, continue com a operação autorizando com a senha");
      } elseif ($desconto_venda_real > (verifica_desconto_fpg($conecta, $forma_pagamento_id_venda)) and (validar_usuario($conecta,$autorizador_id,$senha_autorizador)==false)) {
         $retornar["dados"] =  array("sucesso" => "autorizar", "title" => "Não é possivel finalizar a venda, senha incorreta, autorização não permitida");
      }elseif(verifica_repeticao_doc($conecta,"tb_nf_saida","cl_serie_nf","cl_numero_nf",$serie_venda,$nf_novo)){//verificar se já existe essa venda se sim, não realizar a venda
         $retornar["dados"] = array("sucesso" => false, "title" => "Não é possivel finalizar essa venda, o número de venda $nf_novo já está registrado no sistema, favor verifique");
      } else {

         $valor_liquido_venda = $valor_total_bruto - $desconto_venda_real; //valor liquido da venda


         // Percorrer os itens do array de produtos
         foreach ($produtos as $itens) {
            // Acessar os dados de cada item do array
            $id_produto = $itens['id_produto'];
            $descricao_produto = utf8_decode($itens['descricao_produto']);
            $unidade = utf8_decode($itens['unidade']);
            $preco_venda = $itens['preco_venda'];
            $quantidade = $itens['quantidade'];
            $valor_total = $itens['valor_total'];
            $referencia = utf8_decode($itens['referencia']);
            $valor_total = $itens['valor_total'];
            $ordem_item = $ordem_item + 1;

            $insert = "INSERT INTO `system_day`.`tb_nf_saida_item` ( `cl_data_movimento`, `cl_usuario_id`, `cl_serie_nf`, `cl_numero_nf`, 
         `cl_item_id`, `cl_descricao_item`, `cl_quantidade`,`cl_unidade`,`cl_valor_unitario`, `cl_valor_total`, `cl_desconto`, `cl_referencia`, `cl_item_ordem_nf` )
          VALUES ('$data_lancamento', '$id_usuario_logado', '$serie_venda', '$nf_novo', '$id_produto', '$descricao_produto', '$quantidade','$unidade', '$preco_venda', '$valor_total', '0', '$referencia', '$ordem_item' )";
            $operacao_insert = mysqli_query($conecta, $insert);
         }

         if (recebimento_nf_recebida($conecta, $forma_pagamento_id_venda, $data_lancamento, $serie_venda, $nf_novo, $parceiro_id, $classficacao_financeiro_id, $valor_liquido_venda, "$serie_venda $nf_novo")) {
            $status_recebimento = "2";
            $data_recebimento = $data_lancamento;
            $usuario_id_recebimento = $id_usuario_logado;
         } else {
            $status_recebimento = "1";
            $data_recebimento = "";
            $usuario_id_recebimento = $id_usuario_logado;
         }

         $insert = "INSERT INTO `system_day`.`tb_nf_saida` ( `cl_data_movimento`,  `cl_parceiro_id`, `cl_parceiro_avulso`, 
         `cl_forma_pagamento_id`, `cl_numero_nf`, `cl_numero_venda`, `cl_serie_nf`, `cl_status_recebimento`, `cl_valor_bruto`, 
         `cl_valor_liquido`, `cl_valor_desconto`,`cl_usuario_id`,`cl_observacao`,`cl_data_recebimento`,`cl_usuario_id_recebimento`,`cl_operacao`,`cl_vendedor_id`,`cl_status_venda` ) VALUES
            ( '$data_lancamento', '$parceiro_id', '$parceiro_avulso', '$forma_pagamento_id_venda', '$nf_novo', '$nf_novo', '$serie_venda', '$status_recebimento',
            '$valor_total_bruto', '$valor_liquido_venda', '$desconto_venda_real','$id_usuario_logado','$observacao','$data_recebimento','$usuario_id_recebimento','VENDA', '$vendedor_id_venda','2')";//STATUS 2 PARA VENDA FINALIZADA
         $operacao_insert = mysqli_query($conecta, $insert);
         if ($operacao_insert) {
            $retornar["dados"] = array("sucesso" => true, "title" => "Venda  Nº $nf_novo finalizada com sucesso ");


            //atualizar valor em serie de venda
            adicionar_valor_serie($conecta, "12", $nf_novo);
            
            $mensagem = utf8_decode("Usuário $nome_usuario_logado realizou a venda Nº $nf_novo");
            registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);

         } else {
            $retornar["dados"] = array("sucesso" => false, "title" => "Erro ao finalizar a venda Nº $nf_novo, favor comunique o suporte do sistema");
            $mensagem = utf8_decode("Tentativa sem sucesso de finalizar a venda Nº $nf_novo");
            registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
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

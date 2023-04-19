<?php

//consultar informações para tabela
if (isset($_GET['consultar_lancamento_financeiro'])) {
   include "../../../../conexao/conexao.php";
   include "../../../../funcao/funcao.php";
   $consulta = $_GET['consultar_lancamento_financeiro'];
   $data_inicial = $_GET['data_inicial'];
   $data_final = $_GET['data_final'];
   $data_inicial =  formatarDataParaBancoDeDados($data_inicial);
   $data_final =  formatarDataParaBancoDeDados($data_final);

   if ($consulta == "inicial") {
      $consultar_tabela_inicialmente =  verficar_paramentro($conecta, "tb_parametros", "cl_id", "1"); //VERIFICAR PARAMETRO ID - 1
      $select = "SELECT lcf.cl_id, lcf.cl_data_vencimento,star.cl_descricao as status, lcf.cl_tipo_lancamento, lcf.cl_data_pagamento,lcf.cl_descricao as descricao,fpg.cl_descricao as formapgt,
      lcf.cl_data_lancamento,lcf.cl_documento,lcf.cl_valor_liquido,ctf.cl_banco,parc.cl_razao_social,parc.cl_nome_fantasia,star.cl_descricao 
      FROM tb_lancamento_financeiro as lcf inner join tb_conta_financeira 
      as ctf on ctf.cl_conta = lcf.cl_conta_financeira inner join tb_parceiros as parc on
      parc.cl_id = lcf.cl_parceiro_id inner join tb_status_recebimento as star on star.cl_id = lcf.cl_status_id inner join tb_forma_pagamento as fpg on fpg.cl_id = lcf.cl_forma_pagamento_id 
      WHERE lcf.cl_data_vencimento between '$data_inicial' and '$data_final'";
      $consultar_lancamento_financeiro = mysqli_query($conecta, $select);
      if (!$consultar_lancamento_financeiro) {
         die("Falha no banco de dados");
      } else {
         $qtd = mysqli_num_rows($consultar_lancamento_financeiro);
      }
   } else {
      $pesquisa = utf8_decode($_GET['conteudo_pesquisa']); //filtro
      $status_lancamento = $_GET['status_lancamento'];
      $classificao_financeiro = $_GET['classificao_financeiro'];
      $tipo_lancamento = utf8_decode($_GET['tipo_lancamento']); //filtro
   

      $select = "SELECT lcf.cl_id, lcf.cl_data_vencimento,star.cl_descricao as status, lcf.cl_tipo_lancamento, lcf.cl_data_pagamento,lcf.cl_descricao as descricao,fpg.cl_descricao as formapgt,
      lcf.cl_data_lancamento,lcf.cl_documento,lcf.cl_valor_liquido,ctf.cl_banco,parc.cl_razao_social,parc.cl_nome_fantasia,star.cl_descricao 
      FROM tb_lancamento_financeiro as lcf inner join tb_conta_financeira 
      as ctf on ctf.cl_conta = lcf.cl_conta_financeira inner join tb_parceiros as parc on
      parc.cl_id = lcf.cl_parceiro_id inner join tb_status_recebimento as star on star.cl_id = lcf.cl_status_id inner join tb_forma_pagamento as fpg on fpg.cl_id = lcf.cl_forma_pagamento_id 
      WHERE lcf.cl_data_vencimento between '$data_inicial' and '$data_final' and 
       (lcf.cl_descricao  like '%$pesquisa%' or lcf.cl_documento like '%$pesquisa%') ";

      if($status_lancamento !="0"){
         $select .=" and lcf.cl_status_id = '$status_lancamento' ";
      }
      if($classificao_financeiro !="0"){
         $select .=" and lcf.cl_classificacao_id = '$classificao_financeiro' ";
      }
      if($tipo_lancamento !="0"){
         $select .=" and lcf.cl_tipo_lancamento = '$tipo_lancamento' ";
      }
    
       $consultar_lancamento_financeiro = mysqli_query($conecta, $select);
      if (!$consultar_lancamento_financeiro) {
         die("Falha no banco de dados");
      } else {
         $qtd = mysqli_num_rows($consultar_lancamento_financeiro);
      }
   }
}

// //cadastrar formulario
if (isset($_POST['formulario_conta_financeira'])) {
   include "../../../conexao/conexao.php";
   include "../../../funcao/funcao.php";
   $retornar = array();
   $acao = $_POST['acao'];
   if ($acao == "show") {
      $id_conta_financeira = $_POST['conta_financeira_id'];
      $select = "SELECT * from tb_conta_financeira WHERE cl_id = $id_conta_financeira";
      $consultar_forma_pagamento = mysqli_query($conecta, $select);
      $linha = mysqli_fetch_assoc($consultar_forma_pagamento);
      $descricao = utf8_encode($linha['cl_banco']);
      $conta = $linha['cl_conta'];
      $digito_conta = $linha['cl_digito_conta'];
      $agencia = $linha['cl_agencia'];
      $numero_banco = $linha['cl_numero_banco'];

      $informacao = array(
         "descricao" => $descricao,
         "conta" => $conta,
         "digito_conta" => $digito_conta,
         "agencia" => $agencia,
         "numero_banco" => $numero_banco,
      );

      $retornar["dados"] = array("sucesso" => true, "valores" => $informacao);
   }


   if ($acao == "create") {
      $nome_usuario_logado = $_POST["nome_usuario_logado"];
      $id_usuario_logado = $_POST["id_usuario_logado"];
      $perfil_usuario_logado = $_POST['perfil_usuario_logado'];

      $descricao = utf8_decode($_POST['descricao']);
      $conta = ($_POST['conta']);
      $digito_conta = ($_POST['digito_conta']);
      $agencia = ($_POST['agencia']);
      $numero_banco = ($_POST['numero_banco']);

      if ($descricao == "") {
         $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("descricão"));
      } elseif ($conta == "") {
         $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("conta"));
      } else {
         $insert = "INSERT INTO `system_day`.`tb_conta_financeira` ( `cl_banco`, `cl_conta`, `cl_digito_conta`, `cl_agencia`, `cl_numero_banco`) 
         VALUES ( '$descricao', '$conta', '$digito_conta', '$agencia', '$numero_banco')";
         $operacao_insert = mysqli_query($conecta, $insert);
         if ($operacao_insert) {
            $retornar["dados"] = array("sucesso" => true, "title" => "Conta fiananceira cadastrada com sucesso");
            $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado Adicionou a conta financeira $descricao");
            registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
         } else {
            $retornar["dados"] = array("sucesso" => false, "title" => "Erro insert banco de dados, favor contatar o suporte");
            $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado tentativa de inserir conta financeira  sem sucesso");
            registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
         }
      }
   }


   if ($acao == "update") { // EDITAR
      $nome_usuario_logado = $_POST["nome_usuario_logado"];
      $id_usuario_logado = $_POST["id_usuario_logado"];
      $perfil_usuario_logado = $_POST['perfil_usuario_logado'];

      $id = $_POST['id'];
      $descricao = utf8_decode($_POST['descricao']);
      $conta = ($_POST['conta']);
      $digito_conta = ($_POST['digito_conta']);
      $agencia = ($_POST['agencia']);
      $numero_banco = ($_POST['numero_banco']);


      // $ativo = $_POST['ativo'];
      if ($descricao == "") {
         $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("descricão"));
      } elseif ($conta == "") {
         $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("conta"));
      } else {

         $update = "UPDATE `system_day`.`tb_conta_financeira` SET `cl_banco` = '$descricao', `cl_conta` = '$conta', `cl_digito_conta` = '$digito_conta', `cl_agencia` = '$agencia',
          `cl_numero_banco` = '$numero_banco' WHERE `tb_conta_financeira`.`cl_id` = $id ";
         $operacao_update = mysqli_query($conecta, $update);
         if ($operacao_update) {
            $retornar["dados"] = array("sucesso" => true, "title" => "Conta financeira alterada com sucesso");
            $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado alterou a conta financeira codigo $id");
            registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
         } else {
            $retornar["dados"] = array("sucesso" => false, "title" => "Erro update banco de dados, favor contatar o suporte");
            $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado tentativa de alterar a conta financeira $descricao sem sucesso");
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

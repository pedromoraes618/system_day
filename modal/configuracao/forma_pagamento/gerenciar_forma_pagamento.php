<?php

//consultar informações para tabela
if (isset($_GET['consultar_fpg'])) {
   include "../../../../conexao/conexao.php";
   include "../../../../funcao/funcao.php";
   $consulta = $_GET['consultar_fpg'];
   if ($consulta == "inicial") {
      $consultar_tabela_inicialmente =  verficar_paramentro($conecta, "tb_parametros", "cl_id", "1"); //VERIFICAR PARAMETRO ID - 1
      $select = "SELECT fpg.cl_id as formaPagamentoID, fpg.cl_ativo,fpg.cl_descricao as formaPagamentoDescricao,fpg.cl_default,ctf.cl_banco,tpg.cl_descricao as tipoPagamento,strc.cl_descricao as statusRecebimento from tb_forma_pagamento as fpg inner join tb_conta_financeira as ctf on ctf.cl_id = fpg.cl_conta_financeira_id
      inner join tb_status_recebimento as strc on strc.cl_id = fpg.cl_status_id inner join tb_tipo_pagamento as tpg on tpg.cl_id = fpg.cl_tipo_pagamento_id ";
      $consultar_forma_pagamento = mysqli_query($conecta, $select);
      if (!$consultar_forma_pagamento) {
         die("Falha no banco de dados");
      } else {
         $qtd = mysqli_num_rows($consultar_forma_pagamento);
      }
   } else {
      $pesquisa = utf8_decode($_GET['conteudo_pesquisa']); //filtro
      $select = "SELECT fpg.cl_id as formaPagamentoID, fpg.cl_ativo,fpg.cl_descricao as formaPagamentoDescricao,fpg.cl_default,ctf.cl_banco,tpg.cl_descricao as tipoPagamento,strc.cl_descricao as statusRecebimento from tb_forma_pagamento as fpg inner join tb_conta_financeira as ctf on ctf.cl_id = fpg.cl_conta_financeira_id
      inner join tb_status_recebimento as strc on strc.cl_id = fpg.cl_status_id inner join tb_tipo_pagamento as tpg on tpg.cl_id = fpg.cl_tipo_pagamento_id WHERE fpg.cl_descricao like '%{$pesquisa}%' or fpg.cl_id like '%{$pesquisa}%'";
      $consultar_forma_pagamento = mysqli_query($conecta, $select);
      if (!$consultar_forma_pagamento) {
         die("Falha no banco de dados");
      } else {
         $qtd = mysqli_num_rows($consultar_forma_pagamento);
      }
   }
}

// //cadastrar formulario
if (isset($_POST['formulario_forma_pagamento'])) {
   include "../../../conexao/conexao.php";
   include "../../../funcao/funcao.php";
   $retornar = array();
   $acao = $_POST['acao'];
   if ($acao == "show") {
      $id_forma_pagamento = $_POST['forma_pagamento_id'];
      $select = "SELECT * from tb_forma_pagamento WHERE cl_id = $id_forma_pagamento";
      $consultar_forma_pagamento = mysqli_query($conecta, $select);
      $linha = mysqli_fetch_assoc($consultar_forma_pagamento);
      $descricao =utf8_encode($linha['cl_descricao']);
      $conta_financeira = $linha['cl_conta_financeira_id'];
      $status_recebimento = $linha['cl_status_id'];
      $classificao = $linha['cl_classificao_id'];
      $tipo_pagamento = $linha['cl_tipo_pagamento_id'];
      $avista = $linha['cl_avista'];
      $default = $linha['cl_default'];
      $prazo_fatura = $linha['cl_prazo_fatura'];
      $numero_parcela = $linha['cl_numero_parcela'];
      $intervalo_parcela = $linha['cl_intervalo_parcela'];
      $desconto_maximo = $linha['cl_desconto_maximo'];
      $taxa = $linha['cl_taxa'];
      $ativo = $linha['cl_ativo'];
      $informacao = array(
         "descricao" => $descricao,
         "conta_financeira" => $conta_financeira,
         "status_recebimento" => $status_recebimento,
         "classficacao" => $classificao,
         "tipo_pagamento" => $tipo_pagamento,
         "avista" => $avista,
         "default" => $default,
         "prazo_fatura" => $prazo_fatura,
         "numero_parcela" => $numero_parcela,
         "intervalo_parcela" => $intervalo_parcela,
         "desconto_maximo" => $desconto_maximo,
         "taxa" => $taxa,
         "ativo" => $ativo,

      );
      $retornar["dados"] = array("sucesso" => true, "valores" => $informacao);
   }


   if ($acao == "create") {
      $nome_usuario_logado = $_POST["nome_usuario_logado"];
      $id_usuario_logado = $_POST["id_usuario_logado"];
      $perfil_usuario_logado = $_POST['perfil_usuario_logado'];

      $descricao = utf8_decode($_POST['descricao']);
      $conta_financeira = $_POST['conta_financeira'];
      $status = $_POST['status'];
      $classificacao = $_POST['classificacao'];
      $tipo_pagamento = $_POST['tipo_pagamento'];
      $numero_parcela = $_POST['numero_parcela'];
      $prazo_fatura = $_POST['prazo_fatura'];
      $intervalo_parcela = $_POST['intervalo_parcela'];
      $desconto_maximo = $_POST['desconto_maximo'];
      $taxa = $_POST['taxa'];

      if (isset($_POST['ativo'])) {
         $ativo = 'S';
      } else {
         $ativo = 'N';
      }

      if (isset($_POST['default'])) {
         $default = 'S';
      } else {
         $default = 'N';
      }

      if (isset($_POST['avista'])) {
         $avista = 'S';
      } else {
         $avista = 'N';
      }

  

      if ($descricao == "") {
         $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("descricão"));
      } elseif ($conta_financeira == "0") {
         $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("conta financeira"));
      } elseif ($status == "0") {
         $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("status"));
      } elseif ($classificacao == "0") {
         $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("classificacao"));
      } elseif ($tipo_pagamento == "0") {
         $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("tipo pagamento"));
      } else {

         $insert = "INSERT INTO `system_day`.`tb_forma_pagamento` (`cl_descricao`, `cl_conta_financeira_id`, `cl_status_id`, `cl_classificao_id`, `cl_tipo_pagamento_id`, `cl_avista`, `cl_default`, 
         `cl_prazo_fatura`, `cl_numero_parcela`, `cl_intervalo_parcela`, `cl_desconto_maximo`, `cl_taxa`, `cl_ativo`) VALUES ( '$descricao', '$conta_financeira', '$status', '$classificacao', '$tipo_pagamento', '$avista', '$default',
          '$prazo_fatura', '$numero_parcela', '$intervalo_parcela', '$desconto_maximo', '$taxa', '$ativo' )";
         $operacao_insert = mysqli_query($conecta, $insert);
         if ($operacao_insert) {
            $retornar["dados"] = array("sucesso" => true, "title" => "Forma de pagamento cadastrado com sucesso");
            $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado Adicionou a forma de pagamento $descricao");
            registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
         } else {
            $retornar["dados"] = array("sucesso" => false, "title" => "Erro insert banco de dados, favor contatar o suporte");
            $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado tentativa de inserir forma de pagamento sem sucesso");
            registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
         }
      }
   }


   if ($acao == "update") { // EDITAR
      $nome_usuario_logado = $_POST["nome_usuario_logado"];
      $id_usuario_logado = $_POST["id_usuario_logado"];
      $perfil_usuario_logado = $_POST['perfil_usuario_logado'];

      $id = $_POST['id'];
      $descricao =utf8_decode($_POST['descricao']);
      $conta_financeira = $_POST['conta_financeira'];
      $status = $_POST['status'];
      $classificacao = $_POST['classificacao'];
      $tipo_pagamento = $_POST['tipo_pagamento'];
      $numero_parcela = $_POST['numero_parcela'];
      $prazo_fatura = $_POST['prazo_fatura'];
      $intervalo_parcela = $_POST['intervalo_parcela'];
      $desconto_maximo = $_POST['desconto_maximo'];
      $taxa = $_POST['taxa'];

      if (isset($_POST['ativo'])) {
         $ativo = 'S';
      } else {
         $ativo = 'N';
      }

      if (isset($_POST['default'])) {
         $default = 'S';
      } else {
         $default = 'N';
      }

      if (isset($_POST['avista'])) {
         $avista = 'S';
      } else {
         $avista = 'N';
      }

 


      // $ativo = $_POST['ativo'];

      if ($descricao == "") {
         $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("descricão"));
      } elseif ($conta_financeira == "0") {
         $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("conta financeira"));
      } elseif ($status == "0") {
         $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("status"));
      } elseif ($classificacao == "0") {
         $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("classificacao"));
      } elseif ($tipo_pagamento == "0") {
         $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("tipo pagamento"));
      } else {

         $update = " UPDATE `system_day`.`tb_forma_pagamento` SET `cl_descricao` = '$descricao', `cl_conta_financeira_id` = '$conta_financeira', `cl_status_id` = '$status', `cl_classificao_id` = '$classificacao', `cl_tipo_pagamento_id` = '$tipo_pagamento',
          `cl_avista` = '$avista', `cl_default` = '$default', `cl_prazo_fatura` = '$prazo_fatura', `cl_numero_parcela` = '$numero_parcela', `cl_intervalo_parcela` = '$intervalo_parcela',
           `cl_desconto_maximo` = '$desconto_maximo', `cl_taxa` = '$taxa', `cl_ativo` = '$ativo' WHERE `tb_forma_pagamento`.`cl_id` = $id ";
         $operacao_update = mysqli_query($conecta, $update);
         if ($operacao_update) {
            $retornar["dados"] = array("sucesso" => true, "title" => "Forma de pagamento alterada com sucesso");
            $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado alterou a forma de pagameto $id");
            registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
         } else {
            $retornar["dados"] = array("sucesso" => false, "title" => "Erro update banco de dados, favor contatar o suporte");
            $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado tentativa de inserir forma de pagamento sem sucesso");
            registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
         }
      }
   }

   echo json_encode($retornar);
}







// //editar formulario
// if(isset($_POST['formulario_editar_produto'])){
//    include "../../../conexao/conexao.php";
//    include "../../../funcao/funcao.php";
//        $retornar = array();
//        $nome_usuario_logado = $_POST["nome_usuario_logado"];
//        $id_usuario_logado = $_POST["id_usuario_logado"];
//        $perfil_usuario_logado = $_POST['perfil_usuario_logado'];

//        $id_produto = $_POST['id_produto'];
//        $codigo_produto = ($_POST["codigo_produto"]);
//        $descricao = utf8_decode($_POST["descricao"]);
//        $referencia = utf8_decode($_POST["referencia"]);
//        $fabricante = utf8_decode($_POST["fabricante"]);
//        $equivalencia = utf8_decode($_POST["equivalencia"]);
//        $observacao = utf8_decode($_POST["observacao"]);
//        $codigo_barras = ($_POST["codigo_barras"]);
//        $grupo_estoque = ($_POST["grupo_estoque"]);
//        $tipo = utf8_decode($_POST["tipo"]);
//        $status = ($_POST["status"]);

//        $est_minimo = ($_POST["est_minimo"]);
//        $est_maximo = ($_POST["est_maximo"]);
//        $local_produto = utf8_decode($_POST["local_produto"]);
//        $tamanho = utf8_decode($_POST["tamanho"]);
//        $unidade_md = ($_POST["unidade_md"]);

//        $margem_lucro = ($_POST["margem_lucro"]);
//        $prc_promocao = ($_POST["prc_promocao"]);
//        $desconto_maximo = ($_POST["desconto_maximo"]);
//        $cest = ($_POST["cest"]);
//        $ncm = ($_POST["ncm"]);
//        $cst_icms = ($_POST["cst_icms"]);
//        $cst_pis_s = ($_POST["cst_pis_s"]);
//        $cst_pis_e = ($_POST["cst_pis_e"]);
//        $cst_cofins_s = ($_POST["cst_cofins_s"]);
//        $cst_cofins_e = ($_POST["cst_cofins_e"]);
//        $cfop_interno = ($_POST["cfop_interno"]);
//        $cfop_externo = ($_POST["cfop_externo"]);

//        if($descricao == ""){
//            $retornar["dados"] = array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("descricão"));
//        }elseif($grupo_estoque=="0"){
//            $retornar["dados"] = array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("grupo")); 
//        }elseif($fabricante=="0"){
//            $retornar["dados"] = array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("fabricante")); 
//        }elseif($tipo =="0"){
//            $retornar["dados"] =  array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("tipo"));
//        }elseif($status=="0"){
//            $retornar["dados"] =  array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("status"));
//        }elseif($unidade_md=="0"){
//            $retornar["dados"] =  array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("unidade de medida"));
//        }else{


//         if($margem_lucro!=""){
//            if(verificaVirgula($margem_lucro)){//verificar se tem virgula
//              $margem_lucro = formatDecimal($margem_lucro); // formatar virgula para ponto
//            }
//         }
//         if($prc_promocao!=""){
//            if(verificaVirgula($prc_promocao)){//verificar se tem virgula
//             $prc_promocao = formatDecimal($prc_promocao); // formatar virgula para ponto
//            }
//         }
//         if($desconto_maximo!=""){
//            if(verificaVirgula($desconto_maximo)){//verificar se tem virgula
//              $desconto_maximo =  formatDecimal($desconto_maximo); // formatar virgula para ponto
//            }
//         }

//         if($est_minimo!=""){
//            if(verificaVirgula($est_minimo)){//verificar se tem virgula
//             $est_minimo = formatDecimal($est_minimo); // formatar virgula para ponto
//            }
//         }
//         if($est_maximo!=""){
//            if(verificaVirgula($est_maximo)){//verificar se tem virgula
//              $est_maximo = formatDecimal($est_maximo); // formatar virgula para ponto
//            }
//         }
//         if($cest!=""){
//            if(verificaVirgula($cest)){//verificar se tem virgula
//             $cest = formatDecimal($cest); // formatar virgula para ponto
//            }
//         }
//         if($ncm!=""){
//            if(verificaVirgula($ncm)){//verificar se tem virgula
//             $ncm = formatDecimal($ncm); // formatar virgula para ponto
//            }
//         }
//         if($cst_icms!=""){
//            if(verificaVirgula($cst_icms)){//verificar se tem virgula
//              $cst_icms = formatDecimal($cst_icms); // formatar virgula para ponto
//            }
//         }
//         if($cst_pis_s!=""){
//            if(verificaVirgula($cst_pis_s)){//verificar se tem virgula
//             $cst_pis_s = formatDecimal($cst_pis_s); // formatar virgula para ponto
//            }
//         }
//         if($cst_pis_e!=""){
//            if(verificaVirgula($ncm)){//verificar se tem virgula
//             $ncm = formatDecimal($ncm); // formatar virgula para ponto
//            }
//         }
//         if($cst_cofins_s!=""){
//            if(verificaVirgula($cst_cofins_s)){//verificar se tem virgula
//              $cst_cofins_s = formatDecimal($cst_cofins_s); // formatar virgula para ponto
//            }
//         }
//         if($cst_cofins_e!=""){
//            if(verificaVirgula($cst_cofins_e)){//verificar se tem virgula
//             $cst_cofins_e = formatDecimal($cst_cofins_e); // formatar virgula para ponto
//            }
//         }


//       $update = "UPDATE `tb_produtos` SET `cl_descricao`= '$descricao', `cl_tamanho` = '$tamanho', `cl_localizacao` = '$local_produto', `cl_referencia` = '$referencia',
//       `cl_equivalencia` = '$equivalencia', `cl_observacao` = '$observacao', `cl_codigo_barra` = '$codigo_barras', `cl_preco_promocao` =
//       '$prc_promocao', `cl_desconto_maximo` = '$desconto_maximo', `cl_margem_lucro` = '$margem_lucro', `cl_cest` = '$cest', `cl_ncm` = '$ncm', `cl_cst_icms` = '$cst_icms',
//       `cl_cst_pis_s` = '$cst_pis_s', `cl_cst_pis_e` = '$cst_pis_e', `cl_cst_cofins_s` = '$cst_cofins_s', `cl_cst_cofins_e` = '$cst_cofins_e',
//        `cl_estoque_minimo` = '$est_minimo', `cl_estoque_maximo`= '$est_maximo', `cl_cfop_interno` = '$cfop_interno', `cl_cfop_externo` = '$cfop_externo', 
//        `cl_fabricante_id` = '$fabricante', `cl_grupo_id` = '$grupo_estoque', `cl_und_id` = '$unidade_md', `cl_tipo_id` = '$tipo', 
//       `cl_status_ativo` = '$status'  WHERE `cl_id` = $id_produto";
//        $operacao_update = mysqli_query($conecta, $update);
//         $retornar["dados"] =array("sucesso"=>true,"title"=>"Produto alterado com sucesso");
//        //registrar no log
//        $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado Alterou o produto de codigo $codigo_produto");
//        registrar_log($conecta,$nome_usuario_logado,$data,$mensagem);
//        }


//            echo json_encode($retornar);

//        }

// // // //Editar formulario
// // if(isset($_POST['formulario_editar_grupo_estoque'])){
// //     include "../../../conexao/conexao.php";
// //     include "../../../funcao/funcao.php";
// //         $retornar = array();

// //         $nome_usuario_logado = $_POST["nome_usuario_logado"];
// //         $id_usuario_logado = $_POST["id_usuario_logado"];
// //         $perfil_usuario_logado = $_POST['perfil_usuario_logado'];

// //         $id_grupo = $_POST["id_grupo"];
// //         $descricao = utf8_decode($_POST["descricao"]);


// //         if($descricao == ""){
// //             $retornar["mensagem"] =mensagem_alerta_cadastro("descricão");
// //         }else{

// //         $update = "UPDATE tb_grupo_estoque set cl_descricao = '$descricao' where cl_id = $id_grupo";
// //         $operacao_update = mysqli_query($conecta, $update);
// //         if($operacao_update){
// //         $retornar["sucesso"] = true;
// //         //registrar no log
// //         $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado alterou dados do grupo de codigo $id_grupo para $descricao");
// //         registrar_log($conecta,$nome_usuario_logado,$data,$mensagem);
// //         }  

// //     }
// //     echo json_encode($retornar);
// // }

// //trazer informaçãoes
// if(isset($_GET['editar_produto'])==true){
//     include "../../../conexao/conexao.php";
//     include "../../../funcao/funcao.php";
//     $id_produto = $_GET['id_produto'];
//     $select = "SELECT * from tb_produtos where cl_id = $id_produto";
//     $consultar_produtos= mysqli_query($conecta, $select);
//     $linha = mysqli_fetch_assoc($consultar_produtos);
//     $codigo_produto_b = ($linha['cl_codigo']);
//     $descricao_b = utf8_encode($linha['cl_descricao']);
//     $referencia_b = utf8_encode($linha['cl_referencia']);
//     $equivalencia_b = utf8_encode($linha['cl_equivalencia']);
//     $codigo_barras_b = ($linha['cl_codigo_barra']);
//     $grupo_id_b = ($linha['cl_grupo_id']);
//     $fabricante_b = ($linha['cl_fabricante_id']);
//     $tipo_b = ($linha['cl_tipo_id']);
//     $estoque_b = ($linha['cl_estoque']);
//     $est_minimo_b = ($linha['cl_estoque_minimo']);
//     $est_max_b = ($linha['cl_estoque_maximo']);
//     $local_b = utf8_encode($linha['cl_localizacao']);
//     $tamanho_b = utf8_encode($linha['cl_tamanho']);
//     $und_b = ($linha['cl_und_id']);
//     $status_ativo_b = ($linha['cl_status_ativo']);
//     $preco_venda_b = ($linha['cl_preco_venda']);
//     $preco_custo_b = ($linha['cl_preco_custo']);
//     $margem_b = ($linha['cl_margem_lucro']);
//     $preco_promocao_b = ($linha['cl_preco_promocao']);
//     $desconto_maximo_b = ($linha['cl_desconto_maximo']);
//     $ult_preco_compra_b = ($linha['cl_ult_preco_compra']);
//     $cest_b = ($linha['cl_cest']);
//     $ncm_b = ($linha['cl_ncm']);
//     $cst_icms_b = ($linha['cl_cst_icms']);
//     $pis_s_b = ($linha['cl_cst_pis_s']);
//     $pis_e_b = ($linha['cl_cst_pis_e']);
//     $cofins_s_b = ($linha['cl_cst_cofins_s']);
//     $cofins_e_b = ($linha['cl_cst_cofins_e']);
//     $observacao_b = utf8_encode($linha['cl_observacao']);
// }




//consultar conta financeira
$select = "SELECT * from tb_conta_financeira ";
$consultar_conta_financeira = mysqli_query($conecta, $select);


//consultar conta financeira
$select = "SELECT * from tb_status_recebimento ";
$consultar_status_recebimento = mysqli_query($conecta, $select);

//consultar conta financeira
$select = "SELECT * from tb_classificacao_fpg ";
$consultar_classificao_fpg = mysqli_query($conecta, $select);

//consultar conta financeira
$select = "SELECT * from tb_tipo_pagamento ";
$consultar_tipo_pagamento = mysqli_query($conecta, $select);

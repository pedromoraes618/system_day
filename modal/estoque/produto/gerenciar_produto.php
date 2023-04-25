<?php 

//consultar informações para tabela
if(isset($_GET['consultar_produto'])){
include "../../../../conexao/conexao.php";
include "../../../../funcao/funcao.php";
        $consulta = $_GET['consultar_produto'];
     
        if($consulta== "inicial"){
            $consultar_tabela_inicialmente =  verficar_paramentro($conecta,"tb_parametros","cl_id","1");//VERIFICAR PARAMETRO ID - 1
            $select = "SELECT prd.cl_id as produtoid,prd.cl_codigo,prd.cl_estoque_minimo,prd.cl_estoque_maximo, prd.cl_descricao as descricao,prd.cl_status_ativo as ativo,prd.cl_referencia, subgrp.cl_descricao as subgrupo,und.cl_sigla as und,frb.cl_descricao as fabricante,prd.cl_estoque,prd.cl_preco_venda from tb_produtos as prd inner join tb_subgrupo_estoque as subgrp on subgrp.cl_id = prd.cl_grupo_id inner join
            tb_unidade_medida as und on und.cl_id = prd.cl_und_id inner join tb_fabricantes as frb on frb.cl_id = prd.cl_fabricante_id ORDER BY prd.cl_id";
            $consultar_produtos= mysqli_query($conecta, $select);
            if(!$consultar_produtos){
            die("Falha no banco de dados");
            }else{
            $qtd = mysqli_num_rows($consultar_produtos);
            }
        
        }else{
            $pesquisa = utf8_decode($_GET['conteudo_pesquisa']);//filtro
            if(isset($_GET['status_prod'])){
               $status_prod = $_GET['status_prod'];
            }
            $select = "SELECT prd.cl_id as produtoid,prd.cl_descricao as descricao,prd.cl_codigo,prd.cl_estoque_minimo,prd.cl_estoque_maximo,prd.cl_referencia,prd.cl_status_ativo as ativo, subgrp.cl_descricao as subgrupo,und.cl_sigla as und,frb.cl_descricao as fabricante,prd.cl_estoque,prd.cl_preco_venda 
            from tb_produtos as prd inner join tb_subgrupo_estoque as subgrp on subgrp.cl_id = prd.cl_grupo_id inner join
            tb_unidade_medida as und on und.cl_id = prd.cl_und_id inner join tb_fabricantes as frb on frb.cl_id = prd.cl_fabricante_id where (prd.cl_descricao like '%{$pesquisa}%' or
            prd.cl_id  like '%{$pesquisa}%' or frb.cl_descricao like '%{$pesquisa}%' or prd.cl_referencia LIKE '%{$pesquisa}%')";
            if(isset($status_prod ) and $status_prod!="0"){
            $select .=" and prd.cl_status_ativo = '$status_prod' ";
            }
            $select .=" ORDER BY prd.cl_id ";
            $consultar_produtos= mysqli_query($conecta, $select);
            if(!$consultar_produtos){
            die("Falha no banco de dados");
            }else{
            $qtd = mysqli_num_rows($consultar_produtos);
            }
    }
}

//cadastrar formulario
if(isset($_POST['formulario_cadastrar_produto'])){
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
        $retornar = array();
        $nome_usuario_logado = $_POST["nome_usuario_logado"];
        $id_usuario_logado = $_POST["id_usuario_logado"];
        $perfil_usuario_logado = $_POST['perfil_usuario_logado'];

        $descricao = utf8_decode($_POST["descricao"]);
        $referencia = utf8_decode($_POST["referencia"]);
        $fabricante = utf8_decode($_POST["fabricante"]);
        $equivalencia = utf8_decode($_POST["equivalencia"]);
        $observacao = utf8_decode($_POST["observacao"]);
        $codigo_barras = ($_POST["codigo_barras"]);
        $grupo_estoque = ($_POST["grupo_estoque"]);
        $tipo = utf8_decode($_POST["tipo"]);
        $status = ($_POST["status"]);
        $estoque = ($_POST["estoque"]);
        $est_minimo = ($_POST["est_minimo"]);
        $est_maximo = ($_POST["est_maximo"]);
        $local_produto = utf8_decode($_POST["local_produto"]);
        $tamanho = utf8_decode($_POST["tamanho"]);
        $unidade_md = ($_POST["unidade_md"]);
        $prc_venda = ($_POST["prc_venda"]);
        $prc_custo = ($_POST["prc_custo"]);
        $margem_lucro = ($_POST["margem_lucro"]);
        $prc_promocao = ($_POST["prc_promocao"]);
        $desconto_maximo = ($_POST["desconto_maximo"]);
        $cest = ($_POST["cest"]);
        $ncm = ($_POST["ncm"]);
        $cst_icms = ($_POST["cst_icms"]);
        $cst_pis_s = ($_POST["cst_pis_s"]);
        $cst_pis_e = ($_POST["cst_pis_e"]);
        $cst_cofins_s = ($_POST["cst_cofins_s"]);
        $cst_cofins_e = ($_POST["cst_cofins_e"]);
        $cfop_interno = ($_POST["cfop_interno"]);
        $cfop_externo = ($_POST["cfop_externo"]);
       
        if($descricao == ""){
            $retornar["dados"] = array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("descricão"));
        }elseif($grupo_estoque=="0"){
            $retornar["dados"] = array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("grupo")); 
        }elseif($fabricante=="0"){
            $retornar["dados"] = array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("fabricante")); 
        }elseif($tipo =="0"){
            $retornar["dados"] =  array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("tipo"));
        }elseif($status=="0"){
            $retornar["dados"] =  array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("status"));
        }elseif($unidade_md=="0"){
            $retornar["dados"] =  array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("unidade de medida"));
        }else{

        if($prc_custo!=""){
           if(verificaVirgula($prc_custo)){//verificar se tem virgula
             $prc_custo = formatDecimal($prc_custo); // formatar virgula para ponto
           }
        }
        if($prc_venda!=""){
            if(verificaVirgula($prc_venda)){//verificar se tem virgula
              $prc_venda = formatDecimal($prc_venda); // formatar virgula para ponto
            }
         }
         if($margem_lucro!=""){
            if(verificaVirgula($margem_lucro)){//verificar se tem virgula
              $margem_lucro = formatDecimal($margem_lucro); // formatar virgula para ponto
            }
         }
         if($prc_promocao!=""){
            if(verificaVirgula($prc_promocao)){//verificar se tem virgula
             $prc_promocao = formatDecimal($prc_promocao); // formatar virgula para ponto
            }
         }
         if($desconto_maximo!=""){
            if(verificaVirgula($desconto_maximo)){//verificar se tem virgula
              $desconto_maximo =  formatDecimal($desconto_maximo); // formatar virgula para ponto
            }
         }
         if($estoque!=""){
            if(verificaVirgula($estoque)){//verificar se tem virgula
             $estoque = formatDecimal($estoque); // formatar virgula para ponto
            }
         }
         if($est_minimo!=""){
            if(verificaVirgula($est_minimo)){//verificar se tem virgula
             $est_minimo = formatDecimal($est_minimo); // formatar virgula para ponto
            }
         }
         if($est_maximo!=""){
            if(verificaVirgula($est_maximo)){//verificar se tem virgula
              $est_maximo = formatDecimal($est_maximo); // formatar virgula para ponto
            }
         }
         if($cest!=""){
            if(verificaVirgula($cest)){//verificar se tem virgula
             $cest = formatDecimal($cest); // formatar virgula para ponto
            }
         }
         if($ncm!=""){
            if(verificaVirgula($ncm)){//verificar se tem virgula
             $ncm = formatDecimal($ncm); // formatar virgula para ponto
            }
         }
         if($cst_icms!=""){
            if(verificaVirgula($cst_icms)){//verificar se tem virgula
              $cst_icms = formatDecimal($cst_icms); // formatar virgula para ponto
            }
         }
         if($cst_pis_s!=""){
            if(verificaVirgula($cst_pis_s)){//verificar se tem virgula
             $cst_pis_s = formatDecimal($cst_pis_s); // formatar virgula para ponto
            }
         }
         if($cst_pis_e!=""){
            if(verificaVirgula($ncm)){//verificar se tem virgula
             $ncm = formatDecimal($ncm); // formatar virgula para ponto
            }
         }
         if($cst_cofins_s!=""){
            if(verificaVirgula($cst_cofins_s)){//verificar se tem virgula
              $cst_cofins_s = formatDecimal($cst_cofins_s); // formatar virgula para ponto
            }
         }
         if($cst_cofins_e!=""){
            if(verificaVirgula($cst_cofins_e)){//verificar se tem virgula
             $cst_cofins_e = formatDecimal($cst_cofins_e); // formatar virgula para ponto
            }
         }

      if(consultar_serie($conecta,"PRD") ==""){ // verificar se a serie está cadastrada
         $retornar["dados"] = array("sucesso"=>"false","title"=>mensagem_serie_cadastrada());
      }else{

         $codigo_produto = consultar_serie($conecta,"PRD"); 
         $codigo_produto = $codigo_produto + 1; //incremento para adicionar ao codigo do produto
      
        $inset = "INSERT INTO tb_produtos (cl_data_cadastro,cl_codigo,cl_descricao,cl_tamanho,cl_localizacao,cl_referencia,cl_codigo_barra,cl_observacao,cl_preco_custo,cl_preco_venda,cl_estoque,
        cl_preco_promocao,cl_desconto_maximo,cl_margem_lucro,cl_cest,cl_ncm,cl_cst_icms,cl_cst_pis_s,cl_cst_pis_e,cl_cst_cofins_s,cl_cst_cofins_e,
        cl_estoque_minimo,cl_estoque_maximo,cl_cfop_interno,cl_cfop_externo,cl_equivalencia,cl_fabricante_id,cl_und_id,cl_grupo_id,cl_tipo_id,cl_status_ativo)
         VALUES ('$data_lancamento','$codigo_produto','$descricao','$tamanho','$local_produto','$referencia','$codigo_barras','$observacao','$prc_custo','$prc_venda','$estoque',
         '$prc_promocao','$desconto_maximo','$margem_lucro','$cest','$ncm','$cst_icms','$cst_pis_s','$cst_pis_e','$cst_cofins_s','$cst_cofins_e',
         '$est_minimo','$est_maximo','$cfop_interno','$cfop_externo','$equivalencia','$fabricante','$unidade_md','$grupo_estoque','$tipo','$status')";
        $operacao_inserir = mysqli_query($conecta, $inset);
        if($operacao_inserir){  
         //pegar o id do ultimo produto cadastrado
        $select = "SELECT max(cl_id) as id from tb_produtos";
        $consultar_produto = mysqli_query($conecta, $select);
        $linha = mysqli_fetch_assoc($consultar_produto);
        $id_produto_b = $linha['id'];

      
        $retornar["dados"] =array("sucesso"=>true,"title"=>"cadastro realizado com sucesso, código do produto $codigo_produto");
        //registrar no log
        $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado cadastrou o produto de codigo $codigo_produto");
        registrar_log($conecta,$nome_usuario_logado,$data,$mensagem);
         



         //verificar parametro cliente responsavel para ajuste de estoque
         $empresa_ajuste = verficar_paramentro($conecta,"tb_parametros","cl_id","3");

         //verificar parametro formar de  pagamento usada no ajuste de estoque
         $forma_pagamento_ajuste = verficar_paramentro($conecta,"tb_parametros","cl_id","4");


         $ajuste_estoque= consultar_serie($conecta,"AJST"); 
         $ajuste_estoque = $ajuste_estoque + 1; //incremento para adicionar na serie ajuste de estoque

         //adicionar ao ajuste de estoque
         ajuste_estoque($conecta,$data,"AJST-$ajuste_estoque","ENTRADA",$id_produto_b,$estoque,$empresa_ajuste,$id_usuario_logado,$forma_pagamento_ajuste,$prc_venda,"0",'1','');

         //atualizar valor em serie PRD
         adicionar_valor_serie($conecta,"PRD",$codigo_produto);

         //atualizar valor em serie ajst // ajuste de estoque
         adicionar_valor_serie($conecta,"AJST",$ajuste_estoque);

         //registrar no log
        $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado adicionou ao cadastrar o produto o ajuste inicial $estoque, produto codigo $codigo_produto");
        registrar_log($conecta,$nome_usuario_logado,$data,$mensagem);
         


        }
      }
   }
   echo json_encode($retornar);

}
    

   
//editar formulario
if(isset($_POST['formulario_editar_produto'])){
   include "../../../conexao/conexao.php";
   include "../../../funcao/funcao.php";
       $retornar = array();
       $nome_usuario_logado = $_POST["nome_usuario_logado"];
       $id_usuario_logado = $_POST["id_usuario_logado"];
       $perfil_usuario_logado = $_POST['perfil_usuario_logado'];

       $id_produto = $_POST['id_produto'];
       $codigo_produto = ($_POST["codigo_produto"]);
       $descricao = utf8_decode($_POST["descricao"]);
       $referencia = utf8_decode($_POST["referencia"]);
       $fabricante = utf8_decode($_POST["fabricante"]);
       $equivalencia = utf8_decode($_POST["equivalencia"]);
       $observacao = utf8_decode($_POST["observacao"]);
       $codigo_barras = ($_POST["codigo_barras"]);
       $grupo_estoque = ($_POST["grupo_estoque"]);
       $tipo = utf8_decode($_POST["tipo"]);
       $status = ($_POST["status"]);
      
       $est_minimo = ($_POST["est_minimo"]);
       $est_maximo = ($_POST["est_maximo"]);
       $local_produto = utf8_decode($_POST["local_produto"]);
       $tamanho = utf8_decode($_POST["tamanho"]);
       $unidade_md = ($_POST["unidade_md"]);
      
       $margem_lucro = ($_POST["margem_lucro"]);
       $prc_promocao = ($_POST["prc_promocao"]);
       $desconto_maximo = ($_POST["desconto_maximo"]);
       $cest = ($_POST["cest"]);
       $ncm = ($_POST["ncm"]);
       $cst_icms = ($_POST["cst_icms"]);
       $cst_pis_s = ($_POST["cst_pis_s"]);
       $cst_pis_e = ($_POST["cst_pis_e"]);
       $cst_cofins_s = ($_POST["cst_cofins_s"]);
       $cst_cofins_e = ($_POST["cst_cofins_e"]);
       $cfop_interno = ($_POST["cfop_interno"]);
       $cfop_externo = ($_POST["cfop_externo"]);
      
       if($descricao == ""){
           $retornar["dados"] = array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("descricão"));
       }elseif($grupo_estoque=="0"){
           $retornar["dados"] = array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("grupo")); 
       }elseif($fabricante=="0"){
           $retornar["dados"] = array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("fabricante")); 
       }elseif($tipo =="0"){
           $retornar["dados"] =  array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("tipo"));
       }elseif($status=="0"){
           $retornar["dados"] =  array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("status"));
       }elseif($unidade_md=="0"){
           $retornar["dados"] =  array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("unidade de medida"));
       }else{

       
        if($margem_lucro!=""){
           if(verificaVirgula($margem_lucro)){//verificar se tem virgula
             $margem_lucro = formatDecimal($margem_lucro); // formatar virgula para ponto
           }
        }
        if($prc_promocao!=""){
           if(verificaVirgula($prc_promocao)){//verificar se tem virgula
            $prc_promocao = formatDecimal($prc_promocao); // formatar virgula para ponto
           }
        }
        if($desconto_maximo!=""){
           if(verificaVirgula($desconto_maximo)){//verificar se tem virgula
             $desconto_maximo =  formatDecimal($desconto_maximo); // formatar virgula para ponto
           }
        }
     
        if($est_minimo!=""){
           if(verificaVirgula($est_minimo)){//verificar se tem virgula
            $est_minimo = formatDecimal($est_minimo); // formatar virgula para ponto
           }
        }
        if($est_maximo!=""){
           if(verificaVirgula($est_maximo)){//verificar se tem virgula
             $est_maximo = formatDecimal($est_maximo); // formatar virgula para ponto
           }
        }
        if($cest!=""){
           if(verificaVirgula($cest)){//verificar se tem virgula
            $cest = formatDecimal($cest); // formatar virgula para ponto
           }
        }
        if($ncm!=""){
           if(verificaVirgula($ncm)){//verificar se tem virgula
            $ncm = formatDecimal($ncm); // formatar virgula para ponto
           }
        }
        if($cst_icms!=""){
           if(verificaVirgula($cst_icms)){//verificar se tem virgula
             $cst_icms = formatDecimal($cst_icms); // formatar virgula para ponto
           }
        }
        if($cst_pis_s!=""){
           if(verificaVirgula($cst_pis_s)){//verificar se tem virgula
            $cst_pis_s = formatDecimal($cst_pis_s); // formatar virgula para ponto
           }
        }
        if($cst_pis_e!=""){
           if(verificaVirgula($ncm)){//verificar se tem virgula
            $ncm = formatDecimal($ncm); // formatar virgula para ponto
           }
        }
        if($cst_cofins_s!=""){
           if(verificaVirgula($cst_cofins_s)){//verificar se tem virgula
             $cst_cofins_s = formatDecimal($cst_cofins_s); // formatar virgula para ponto
           }
        }
        if($cst_cofins_e!=""){
           if(verificaVirgula($cst_cofins_e)){//verificar se tem virgula
            $cst_cofins_e = formatDecimal($cst_cofins_e); // formatar virgula para ponto
           }
        }


      $update = "UPDATE `tb_produtos` SET `cl_descricao`= '$descricao', `cl_tamanho` = '$tamanho', `cl_localizacao` = '$local_produto', `cl_referencia` = '$referencia',
      `cl_equivalencia` = '$equivalencia', `cl_observacao` = '$observacao', `cl_codigo_barra` = '$codigo_barras', `cl_preco_promocao` =
      '$prc_promocao', `cl_desconto_maximo` = '$desconto_maximo', `cl_margem_lucro` = '$margem_lucro', `cl_cest` = '$cest', `cl_ncm` = '$ncm', `cl_cst_icms` = '$cst_icms',
      `cl_cst_pis_s` = '$cst_pis_s', `cl_cst_pis_e` = '$cst_pis_e', `cl_cst_cofins_s` = '$cst_cofins_s', `cl_cst_cofins_e` = '$cst_cofins_e',
       `cl_estoque_minimo` = '$est_minimo', `cl_estoque_maximo`= '$est_maximo', `cl_cfop_interno` = '$cfop_interno', `cl_cfop_externo` = '$cfop_externo', 
       `cl_fabricante_id` = '$fabricante', `cl_grupo_id` = '$grupo_estoque', `cl_und_id` = '$unidade_md', `cl_tipo_id` = '$tipo', 
      `cl_status_ativo` = '$status'  WHERE `cl_id` = $id_produto";
       $operacao_update = mysqli_query($conecta, $update);
        $retornar["dados"] =array("sucesso"=>true,"title"=>"Produto alterado com sucesso");
       //registrar no log
       $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado Alterou o produto de codigo $codigo_produto");
       registrar_log($conecta,$nome_usuario_logado,$data,$mensagem);
       }
       
           
           echo json_encode($retornar);

       }

// // //Editar formulario
// if(isset($_POST['formulario_editar_grupo_estoque'])){
//     include "../../../conexao/conexao.php";
//     include "../../../funcao/funcao.php";
//         $retornar = array();
      
//         $nome_usuario_logado = $_POST["nome_usuario_logado"];
//         $id_usuario_logado = $_POST["id_usuario_logado"];
//         $perfil_usuario_logado = $_POST['perfil_usuario_logado'];

//         $id_grupo = $_POST["id_grupo"];
//         $descricao = utf8_decode($_POST["descricao"]);
    

//         if($descricao == ""){
//             $retornar["mensagem"] =mensagem_alerta_cadastro("descricão");
//         }else{

//         $update = "UPDATE tb_grupo_estoque set cl_descricao = '$descricao' where cl_id = $id_grupo";
//         $operacao_update = mysqli_query($conecta, $update);
//         if($operacao_update){
//         $retornar["sucesso"] = true;
//         //registrar no log
//         $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado alterou dados do grupo de codigo $id_grupo para $descricao");
//         registrar_log($conecta,$nome_usuario_logado,$data,$mensagem);
//         }  
        
//     }
//     echo json_encode($retornar);
// }

//trazer informaçãoes
if(isset($_GET['editar_produto'])==true){
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
    $id_produto = $_GET['id_produto'];
    $select = "SELECT * from tb_produtos where cl_id = $id_produto";
    $consultar_produtos= mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consultar_produtos);
    $codigo_produto_b = ($linha['cl_codigo']);
    $descricao_b = utf8_encode($linha['cl_descricao']);
    $referencia_b = utf8_encode($linha['cl_referencia']);
    $equivalencia_b = utf8_encode($linha['cl_equivalencia']);
    $codigo_barras_b = ($linha['cl_codigo_barra']);
    $grupo_id_b = ($linha['cl_grupo_id']);
    $fabricante_b = ($linha['cl_fabricante_id']);
    $tipo_b = ($linha['cl_tipo_id']);
    $estoque_b = ($linha['cl_estoque']);
    $est_minimo_b = ($linha['cl_estoque_minimo']);
    $est_max_b = ($linha['cl_estoque_maximo']);
    $local_b = utf8_encode($linha['cl_localizacao']);
    $tamanho_b = utf8_encode($linha['cl_tamanho']);
    $und_b = ($linha['cl_und_id']);
    $status_ativo_b = ($linha['cl_status_ativo']);
    $preco_venda_b = ($linha['cl_preco_venda']);
    $preco_custo_b = ($linha['cl_preco_custo']);
    $margem_b = ($linha['cl_margem_lucro']);
    $preco_promocao_b = ($linha['cl_preco_promocao']);
    $desconto_maximo_b = ($linha['cl_desconto_maximo']);
    $ult_preco_compra_b = ($linha['cl_ult_preco_compra']);
    $cest_b = ($linha['cl_cest']);
    $ncm_b = ($linha['cl_ncm']);
    $cst_icms_b = ($linha['cl_cst_icms']);
    $pis_s_b = ($linha['cl_cst_pis_s']);
    $pis_e_b = ($linha['cl_cst_pis_e']);
    $cofins_s_b = ($linha['cl_cst_cofins_s']);
    $cofins_e_b = ($linha['cl_cst_cofins_e']);
    $observacao_b = utf8_encode($linha['cl_observacao']);
}




//consultar grupo estoque
$select = "SELECT subgrup.cl_id,subgrup.cl_descricao,grp.cl_descricao as grupo from tb_subgrupo_estoque as subgrup inner join tb_grupo_estoque as grp on grp.cl_id = subgrup.cl_grupo_id ";
$consultar_subgrupo_estoque= mysqli_query($conecta, $select);

//consultar cfop
$select = "SELECT * from tb_cfop";
$consultar_cfop_interno= mysqli_query($conecta, $select);

//consultar cfop
$select = "SELECT * from tb_cfop";
$consultar_cfop_externo= mysqli_query($conecta, $select);


//consultar tipo produto
$select = "SELECT * from tb_tipo_produto";
$consultar_tipo_produto= mysqli_query($conecta, $select);


//consultar tipo produto
$select = "SELECT * from tb_fabricantes";
$consultar_fabricantes= mysqli_query($conecta, $select);

//consultar unidade medida
$select = "SELECT * from tb_unidade_medida";
$consultar_und_medida= mysqli_query($conecta, $select);

//consultar cest
$select = "SELECT * from tb_cest";
$consultar_cest= mysqli_query($conecta, $select);

//consultar icms
$select = "SELECT * from tb_icms";
$consultar_icms= mysqli_query($conecta, $select);

//consultar pis
$select = "SELECT * from tb_pis";
$consultar_pis_s= mysqli_query($conecta, $select);
$consultar_pis_e= mysqli_query($conecta, $select);

//consultar cofins
$select = "SELECT * from tb_cofins";
$consultar_cofins_s= mysqli_query($conecta, $select);
$consultar_cofins_e= mysqli_query($conecta, $select);




//consultar informações para tabela
if(isset($_GET['consultar_cest'])){
    include "../../../../conexao/conexao.php";
    include "../../../../funcao/funcao.php";
    $pesquisa = $_GET['conteudo_pesquisa'];
    //consultar cest
    $select = "SELECT * from tb_cest where cl_cest like '%{$pesquisa}%' or cl_ncm like '%{$pesquisa}%' or cl_descricao like '%{$pesquisa}%'  order by cl_id";
    $buscar_cep= mysqli_query($conecta, $select);
            
}
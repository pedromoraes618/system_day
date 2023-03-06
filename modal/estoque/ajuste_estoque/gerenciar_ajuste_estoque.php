<?php
//cadastrar formulario
if(isset($_POST['formulario_cadastrar_ajuste_estoque'])){
include "../../../conexao/conexao.php";
include "../../../funcao/funcao.php";
$retornar = array();
$nome_usuario_logado = $_POST["nome_usuario_logado"];
$id_usuario_logado = $_POST["id_usuario_logado"];
$perfil_usuario_logado = $_POST['perfil_usuario_logado'];


$id_produto = ($_POST["id_produto"]);
$codigo_produto = ($_POST["codigo_produto"]);
$tipo = utf8_decode($_POST["tipo_ajuste"]);
$quantidade = ($_POST["quantidade"]);
$motivo = utf8_decode($_POST["motivo"]);


if($tipo == "0"){
$retornar["dados"] = array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("tipo"));
}elseif($quantidade==""){
$retornar["dados"] = array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("quantidade"));
}elseif($motivo==""){
$retornar["dados"] = array("sucesso"=>"false","title"=>mensagem_alerta_cadastro("motivo"));
}else{

if(consulta_tabela($conecta,'tb_produtos','cl_id',$id_produto,'cl_status_ativo')!="SIM"){//verificar se o produto está ativo
    $retornar["dados"] = array("sucesso"=>"false","title"=>"Esse produto não está ativo, não é possivel realizar o ajuste");
}else{

if($quantidade!=""){
    if(verificaVirgula($quantidade)){//verificar se tem virgula
    $quantidade = formatDecimal($quantidade); // formatar virgula para ponto
    }
    }
    
    if(consultar_serie($conecta,"AJST") ==""){ // verificar se a serie está cadastrada
    $retornar["dados"] = array("sucesso"=>"false","title"=>mensagem_serie_cadastrada());
    }else{
    
    $ajuste_estoque = consultar_serie($conecta,"AJST");
    $ajuste_estoque = $ajuste_estoque + 1; //incremento para adicionar na serie ajuste de estoque
    
    
    //verificar parametro cliente responsavel para ajuste de estoque
    $empresa_ajuste = verficar_paramentro($conecta,"tb_parametros","cl_id","3");
    
    //verificar parametro formar de  pagamento usada no ajuste de estoque
    $forma_pagamento_ajuste = verficar_paramentro($conecta,"tb_parametros","cl_id","4");

    //verificar parametro ajuste com valor menor ou maio ao estoque minimo e maixmo
    $parametro_ajuste_estoque_minimo_maximo = verficar_paramentro($conecta,"tb_parametros","cl_id","5");

    $estoque_atual = consulta_tabela($conecta,'tb_produtos','cl_id',$id_produto,'cl_estoque');//consultar estoque atual do produto
    $estoque_minimo = consulta_tabela($conecta,'tb_produtos','cl_id',$id_produto,'cl_estoque_minimo');//consultar estoque minimo do produto
    $estoque_maximo = consulta_tabela($conecta,'tb_produtos','cl_id',$id_produto,'cl_estoque_maximo');//consultar estoque minimo do produto
    
    if($tipo == 'SAIDA'){//realizar a operação se for saida subtrair ao estoque se não somar
        $novo_estoque = $estoque_atual - $quantidade;
    }else{
        $novo_estoque = $estoque_atual + $quantidade;
    }


        
if($tipo =='SAIDA' and ($novo_estoque < 0) ){ // verificar se o estoque vai ser menor quer zero
    $retornar["dados"] = array("sucesso"=>"false","title"=>"Não será possível realizar o ajuste de estoque solicitado, uma vez que este resultaria em um saldo negativo no estoque desse produto");
}else{

    if(($parametro_ajuste_estoque_minimo_maximo=="S") and (($novo_estoque < $estoque_minimo) or ($novo_estoque > $estoque_maximo) )  ) {
        if($novo_estoque < $estoque_minimo){
            $retornar["dados"] = array("sucesso"=>"false","title"=>"Não é possivel realizar o ajuste, uma vez que este resultaria em um saldo abaixo do estoque minimo do produto");
        }elseif($novo_estoque > $estoque_maximo){
            $retornar["dados"] = array("sucesso"=>"false","title"=>"Não é possivel realizar o ajuste, uma vez que este resultaria em um saldo acima do estoque maximo do produto");
        }
    }else{
            //adicionar ao ajuste de estoque
        $juste = ajuste_estoque($conecta,$data,"AJST-$ajuste_estoque",$tipo,$id_produto,$quantidade,$empresa_ajuste,$id_usuario_logado,$forma_pagamento_ajuste,"0","0",'0',$motivo);
        if($juste){ // verificar se o ajuste foi feito sem erro
        $retornar["dados"] =array("sucesso"=>true,"title"=>"Ajuste realizado com sucesso","qtd"=>$novo_estoque);
        $ajustar_qtd_produto = ajuste_qtd_produto($conecta,$id_produto,$novo_estoque);


        //atualizar valor em serie ajst // ajuste de estoque
        adicionar_valor_serie($conecta,"AJST",$ajuste_estoque);

        //registrar no log
        $mensagem = (utf8_decode("Usúario") . " $nome_usuario_logado realizou o ajuste de estoque do produto de codigo $codigo_produto tipo de ajuste $tipo, quantidade $quantidade ");
        registrar_log($conecta,$nome_usuario_logado,$data,$mensagem);
    }
    }

}
}

}
}
echo json_encode($retornar);

}




if(isset($_GET['consultar_ajuste_estoque'])==true){
   $id_produto = $_GET['id_produto'];
   $select ="SELECT user.cl_usuario as usuario,ajst.cl_quantidade,ajst.cl_id,ajst.cl_data_lancamento,ajst.cl_tipo,
   ajst.cl_documento,ajst.cl_status from tb_ajuste_estoque as ajst inner join tb_users as user on user.cl_id = ajst.cl_usuario_id 
    where ajst.cl_produto_id = $id_produto and ajst.cl_ajuste_inicial !='1' order by ajst.cl_id ";
   $consultar_historico_produto= mysqli_query($conecta, $select);


}
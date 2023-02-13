<?php  
//consultar informações para tabela
if(isset($_GET['consultar_subgrupo'])){
include "../../../../conexao/conexao.php";
include "../../../../funcao/funcao.php";
        $consulta = $_GET['consultar_subgrupo'];

        if($consulta== "inicial"){
            $select = "SELECT sbrgt.cl_id, sbrgt.cl_descricao,grpest.cl_descricao as grupo,und.cl_descricao as unidade, sbrgt.cl_cfop_interno,sbrgt.cl_cfop_externo,sbrgt.cl_estoque_inicial,sbrgt.cl_estoque_minimo,
            sbrgt.cl_estoque_maximo,sbrgt.cl_local from tb_subgrupo_estoque as sbrgt inner join tb_grupo_estoque as grpest on grpest.cl_id = sbrgt.cl_grupo_id inner join tb_unidade_medida as und on und.cl_id = sbrgt.cl_und_id order by sbrgt.cl_id ";
            $consultar_subgrupo_estoque= mysqli_query($conecta, $select);
            if(!$consultar_subgrupo_estoque){
            die("Falha no banco de dados");
            }
        
        }else{
        $pesquisa = utf8_decode($_GET['conteudo_pesquisa']);//filtro
        $select = "SELECT sbrgt.cl_id, sbrgt.cl_descricao,grpest.cl_descricao as grupo,und.cl_descricao as unidade, sbrgt.cl_cfop_interno,sbrgt.cl_cfop_externo,sbrgt.cl_estoque_inicial,sbrgt.cl_estoque_minimo,
        sbrgt.cl_estoque_maximo,sbrgt.cl_local from tb_subgrupo_estoque as sbrgt inner join tb_grupo_estoque as grpest on grpest.cl_id = sbrgt.cl_grupo_id
         inner join tb_unidade_medida as und on und.cl_id = sbrgt.cl_und_id where sbrgt.cl_descricao like '%{$pesquisa}%' or grpest.cl_descricao like '%{$pesquisa}%' or sbrgt.cl_id like '%{$pesquisa}%'  order by sbrgt.cl_id";
     

        $consultar_subgrupo_estoque= mysqli_query($conecta, $select);
        if(!$consultar_subgrupo_estoque){
        die("Falha no banco de dados"); 
        }
    }
}

//cadastrar dados formulario
if(isset($_POST['formulario_cadastrar_subgrupo_estoque'])){
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
        $retornar = array();
        $nome_usuario_logado = $_POST["nome_usuario_logado"];
        $id_usuario_logado = $_POST["id_usuario_logado"];


        $descricao = utf8_decode($_POST["descricao"]);
        $grupo_estoque_id = $_POST["grupo_estoque"];
        $estoque_inicial = $_POST['est_inicial'];
        $estoque_minimo = $_POST['est_minimo'];
        $estoque_maximo = $_POST['est_maximo'];
        $local_estoque = $_POST['local_estoque'];
        $unidade_medida_id = $_POST['unidade_md'];
        $cfop_interno = $_POST['cfop_interno'];
        $cfop_externo = $_POST['cfop_externo'];


        if($descricao == ""){
            $retornar["mensagem"] =mensagem_alerta_cadastro("descricão");
        }elseif($grupo_estoque_id=="0"){
            $retornar["mensagem"] =mensagem_alerta_cadastro("grupo pai");
        }elseif($unidade_medida_id =="0"){
            $retornar["mensagem"] =mensagem_alerta_cadastro("unidade de medida");
        }elseif($cfop_interno=="0"){
            $retornar["mensagem"] =mensagem_alerta_cadastro("cfop interno");
        }elseif($cfop_externo =="0"){
            $retornar["mensagem"] =mensagem_alerta_cadastro("cfop externo");
        }else{

        $inset = "INSERT INTO tb_subgrupo_estoque (cl_descricao,cl_grupo_id,cl_cfop_interno,cl_cfop_externo,cl_estoque_inicial,cl_estoque_minimo,cl_estoque_maximo,cl_local,cl_und_id)
         VALUES ('$descricao','$grupo_estoque_id','$cfop_interno','$cfop_externo','$estoque_inicial','$estoque_minimo','$estoque_maximo','$local_estoque','$unidade_medida_id')";
        $operacao_inserir = mysqli_query($conecta, $inset);
        if($operacao_inserir){
        $retornar["sucesso"] = true;
        //registrar no log
        $mensagem =  ( utf8_decode("Usúario") . " $nome_usuario_logado cadastrou o subgrupo $descricao ");
        registrar_log($conecta,$nome_usuario_logado,$data,$mensagem);
        }
        
        }
        
    echo json_encode($retornar);
}


//Editar formulario
if(isset($_POST['formulario_editar_subgrupo_estoque'])){
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
        $retornar = array();
      
        $nome_usuario_logado = $_POST["nome_usuario_logado"];
        $id_usuario_logado = $_POST["id_usuario_logado"];
        $perfil_usuario_logado = $_POST['perfil_usuario_logado'];

        $id_grupo = $_POST["id_grupo"];
        $descricao = utf8_decode($_POST["descricao"]);
    

        $descricao = utf8_decode($_POST["descricao"]);
        $grupo_estoque_id = $_POST["grupo_estoque"];
        $estoque_inicial = $_POST['est_inicial'];
        $estoque_minimo = $_POST['est_minimo'];
        $estoque_maximo = $_POST['est_maximo'];
        $local_estoque = $_POST['local_estoque'];
        $unidade_medida_id = $_POST['unidade_md'];
        $cfop_interno = $_POST['cfop_interno'];
        $cfop_externo = $_POST['cfop_externo'];


        if($descricao == ""){
            $retornar["mensagem"] =mensagem_alerta_cadastro("descricão");
        }elseif($grupo_estoque_id=="0"){
            $retornar["mensagem"] =mensagem_alerta_cadastro("grupo pai");
        }elseif($unidade_medida_id =="0"){
            $retornar["mensagem"] =mensagem_alerta_cadastro("unidade de medida");
        }elseif($cfop_interno=="0"){
            $retornar["mensagem"] =mensagem_alerta_cadastro("cfop interno");
        }elseif($cfop_externo =="0"){
            $retornar["mensagem"] =mensagem_alerta_cadastro("cfop externo");
        }else{
            
        $update = "UPDATE tb_grupo_estoque set cl_descricao = '$descricao' where cl_id = $id_grupo";
        $operacao_update = mysqli_query($conecta, $update);
        if($operacao_update){
        $retornar["sucesso"] = true;
        //registrar no log
        $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado alterou dados do grupo de codigo $id_grupo para $descricao");
        registrar_log($conecta,$nome_usuario_logado,$data,$mensagem);
        }  
        
    }
    echo json_encode($retornar);
}

//trazer informaçãoes
if(isset($_GET['editar_subgrupo_estoque'])==true){
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
    $id_subgrupo = $_GET['id_subgrupo'];
    $select = "SELECT * from tb_subgrupo_estoque where cl_id = $id_subgrupo";
    $consultar_grupo= mysqli_query($conecta, $select);
    $linha  = mysqli_fetch_assoc($consultar_grupo);
    $descricao_b = utf8_encode($linha['cl_descricao']);
    $grupo_pai_b = ($linha['cl_grupo_id']);
    $und_b = ($linha['cl_und_id']);
    $cfop_interno_b = ($linha['cl_cfop_interno']);
    $cfop_externo_b = ($linha['cl_cfop_externo']);
    $estoque_inicial_b = ($linha['cl_estoque_inicial']);
    $estoque_minimo_b = ($linha['cl_estoque_minimo']);
    $estoque_maximo_b = ($linha['cl_estoque_maximo']);
    $estoque_local_b = utf8_encode($linha['cl_local']);

}

//consultar grupo estoque
$select = "SELECT * from tb_grupo_estoque";
$consultar_grupo_estoque= mysqli_query($conecta, $select);


//consultar cfop
$select = "SELECT * from tb_cfop";
$consultar_cfop_interno= mysqli_query($conecta, $select);

//consultar cfop
$select = "SELECT * from tb_cfop";
$consultar_cfop_externo= mysqli_query($conecta, $select);

//consultar unidade medida
$select = "SELECT * from tb_unidade_medida";
$consultar_und_medida= mysqli_query($conecta, $select);
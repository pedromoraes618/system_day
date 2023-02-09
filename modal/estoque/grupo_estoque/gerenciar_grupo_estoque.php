<?php  
//consultar informações para tabela
if(isset($_GET['consultar_grupo'])){
include "../../../../conexao/conexao.php";
include "../../../../funcao/funcao.php";
        $consulta = $_GET['consultar_grupo'];

        if($consulta== "inicial"){
            $select = "SELECT * from tb_grupo_estoque order by cl_id";
            $consultar_grupo_estoque= mysqli_query($conecta, $select);
            if(!$consultar_grupo_estoque){
            die("Falha no banco de dados");
            }
        
        }else{
        $pesquisa = utf8_decode($_GET['conteudo_pesquisa']);//filtro
        $select = "SELECT * from tb_grupo_estoque where cl_descricao like '%{$pesquisa}%'  order by cl_id";
        $consultar_grupo_estoque= mysqli_query($conecta, $select);
        if(!$consultar_grupo_estoque){
        die("Falha no banco de dados"); 
        }
    }
}

//cadastrar formulario
if(isset($_POST['formulario_cadastrar_grupo_estoque'])){
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
        $retornar = array();
        $nome_usuario_logado = $_POST["nome_usuario_logado"];
        $id_usuario_logado = $_POST["id_usuario_logado"];
        $perfil_usuario_logado = $_POST['perfil_usuario_logado'];

        $descricao = utf8_decode($_POST["descricao"]);
       
        if($descricao == ""){
            $retornar["mensagem"] =mensagem_alerta_cadastro("descricão");

        }else{
         
        $inset = "INSERT INTO tb_grupo_estoque (cl_descricao)
         VALUES ('$descricao')";
        $operacao_inserir = mysqli_query($conecta, $inset);
        if($operacao_inserir){
        $retornar["sucesso"] = true;
        //registrar no log
        $mensagem =  ( utf8_decode("Usúario") . " $nome_usuario_logado cadastrou o grupo $descricao ");
        registrar_log($conecta,$nome_usuario_logado,$data,$mensagem);
        }
        

        }
        
    echo json_encode($retornar);
}


// //Editar formulario
if(isset($_POST['formulario_editar_grupo_estoque'])){
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
        $retornar = array();
      
        $nome_usuario_logado = $_POST["nome_usuario_logado"];
        $id_usuario_logado = $_POST["id_usuario_logado"];
        $perfil_usuario_logado = $_POST['perfil_usuario_logado'];

        $id_grupo = $_POST["id_grupo"];
        $descricao = utf8_decode($_POST["descricao"]);
    

        if($descricao == ""){
            $retornar["mensagem"] =mensagem_alerta_cadastro("descricão");
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
if(isset($_GET['editar_grupo_estoque'])==true){
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
    $id_grupo = $_GET['id_grupo'];
    $select = "SELECT * from tb_grupo_estoque where cl_id = $id_grupo";
    $consultar_grupo= mysqli_query($conecta, $select);
    $linha  = mysqli_fetch_assoc($consultar_grupo);
    $descricao_b = utf8_encode($linha['cl_descricao']);

 
}
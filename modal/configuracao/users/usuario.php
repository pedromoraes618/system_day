<?php  
//consultar usuario sem filtro
if(isset($_GET['consultar_incial'])==true){
$select = "SELECT * from tb_users ";
$consultar_usuarios = mysqli_query($conecta, $select);
if(!$consultar_usuarios){
die("Falha no banco de dados"); // colocar o svg do erro
}
}
//consultar usuario com filtro
if(isset($_GET['consultar_detalhada_user'])==true){
    $pesquisa_user = $_GET['consultar_detalhada_user'];
    $situacao_user = $_GET['situacao_user'];
    $select = "SELECT * from tb_users where cl_usuario LIKE '%{$pesquisa_user}%' ";
    if($situacao_user != "s"){
        $select .=" and cl_ativo = '$situacao_user'";
    }
 
    $consultar_usuarios_detalhado = mysqli_query($conecta, $select);
    if(!$consultar_usuarios_detalhado){
    die("Falha no banco de dados"); // colocar o svg do erro
    }
}
    




//cadastrar usuario
if(isset($_POST['formulario_cadastrar_usuario'])){
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
        $retornar = array();
        $nome_usuario_logado = $_POST["nome_usuario_logado"];
        $id_usuario_logado = $_POST["id_usuario_logado"];
        $nome = $_POST["nome"];
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];
        $confirmar_Senha = $_POST["confirmar_senha"];
        $perfil = $_POST["perfil"];
        $situacao =  $_POST["situacao"];

        if($nome == ""){
            $retornar["mensagem"] =mensagem_alerta_cadastro("nome");
        }elseif($usuario =="" ){
            $retornar["mensagem"] =mensagem_alerta_cadastro("usúario");
        }elseif($senha == "" ){
            $retornar["mensagem"] =mensagem_alerta_cadastro("senha");
        }elseif($confirmar_Senha == "" ){
            $retornar["mensagem"] =mensagem_alerta_cadastro("confirmar senha");
        }elseif($senha != $confirmar_Senha){
            $retornar["mensagem"] = "A confirmação da senha está diferente da senha";
        }elseif($perfil == "0" ){

            $retornar["mensagem"] =mensagem_alerta_cadastro("perfil");

        }elseif($situacao == "s" ){

            $retornar["mensagem"] =mensagem_alerta_cadastro("situacao");

        }else{
         
            if(verificar_user($conecta,$usuario,"cadastrar") > 0){
                $retornar["mensagem"] = "Já existe uma pessoa com o mesmo nome de usúario, favor verifique!";
            }else{
                $senha = base64_encode($senha);//criptografar a senha
                $inset = "INSERT INTO tb_users (cl_data_cadastro,cl_nome,cl_usuario,cl_senha,cl_tipo,cl_ativo) VALUES ('$data','$nome','$usuario','$senha','$perfil',$situacao)";
                $operacao_inserir = mysqli_query($conecta, $inset);
                if($operacao_inserir){
                $retornar["sucesso"] = true;
                //registrar no log
                $mensagem =  utf8_decode("Usúario $nome_usuario_logado cadastrou o novo usúario $usuario");
                registrar_log($conecta,$id_usuario_logado,$data,$mensagem);
                }
            }
            
        }
        
    
    echo json_encode($retornar);
}

//editar usuario
//pegar o id do usuario
if(isset($_GET['editar_user'])==true or isset($_GET['resetar_senha'])==true){
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";

    $id_user = $_GET['id_user'];

    $select = "SELECT * from tb_users where cl_id = $id_user ";
    $consultar_usuarios = mysqli_query($conecta, $select);
    $linha  = mysqli_fetch_assoc($consultar_usuarios);
    $usuario_b = $linha['cl_usuario'];
    $nome_b = $linha['cl_nome'];
    $senha_b = base64_decode($linha['cl_senha']);
    $perfil_b = $linha['cl_tipo'];
    $situacao_b = $linha['cl_ativo'];
    
}


if(isset($_POST['formulario_editar_usuario'])){
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
        $retornar = array();
        $nome_usuario_logado = $_POST["nome_usuario_logado"];
        $id_usuario_logado = $_POST["id_usuario_logado"];
        $id_user = $_POST["id_user"];
        $nome = $_POST["nome"];
        $usuario = $_POST["usuario"];
        $perfil = $_POST["perfil"];
        $situacao =  $_POST["situacao"];
       

        if($nome == ""){
            $retornar["mensagem"] =mensagem_alerta_cadastro("nome");
        }elseif($perfil == "0" ){
            $retornar["mensagem"] =mensagem_alerta_cadastro("perfil");
        }elseif($situacao == "s" ){
            $retornar["mensagem"] =mensagem_alerta_cadastro("situacao");
        }
        else{
      
            if(verificar_user($conecta,$usuario,"editar") == $id_user or verificar_user($conecta,$usuario,"editar") == ""){
            $update = "UPDATE tb_users set cl_nome = '$nome',cl_tipo = '$perfil',cl_ativo ='$situacao' where cl_id = $id_user ";
            $operacao_update = mysqli_query($conecta, $update);
            if($operacao_update){
            $retornar["sucesso"] = true;
            //registrar no log
            $mensagem =  utf8_decode("Usúario $nome_usuario_logado alterou dados do usúario $usuario");
            registrar_log($conecta,$id_usuario_logado,$data,$mensagem);
            }  
        }else{
            $retornar["mensagem"] = "Já existe uma pessoa com o mesmo nome de usúario, favor verifique!";
        }
            
        }
        
    
    echo json_encode($retornar);
}


//resetar senha
if(isset($_POST['formulario_resetar_senha_usuario'])){
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
        $retornar = array();
        $nome_usuario_logado = $_POST["nome_usuario_logado"];
        $id_usuario_logado = $_POST["id_usuario_logado"];
        $id_user = $_POST["id_user"];
        $senha = $_POST["senha"];
        $confirmar_Senha = $_POST["confirmar_senha"];

       if($senha == "" ){
            $retornar["mensagem"] =mensagem_alerta_cadastro("senha");
        }elseif($confirmar_Senha == "" ){
            $retornar["mensagem"] =mensagem_alerta_cadastro("confirmar senha");
        }elseif($senha != $confirmar_Senha){
            $retornar["mensagem"] = "A confirmação da senha está diferente da senha";
        }
        else{
        $senha = base64_encode($senha);//criptografar a senha
        $update = "UPDATE tb_users set cl_senha = '$senha' where cl_id = $id_user ";
        $operacao_update = mysqli_query($conecta, $update);
        if($operacao_update){
        $retornar["sucesso"] = true;
        $mensagem =  utf8_decode("Usúario $nome_usuario_logado Resetou a senha do usúario ".verificar_user_usuario($conecta,$id_user));
        registrar_log($conecta,$id_usuario_logado,$data,$mensagem);
        }  
    
            
        }
        
    
    echo json_encode($retornar);
}



?>
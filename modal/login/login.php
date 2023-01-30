<?php
include "../../conexao/conexao.php";
include "../../funcao/funcao.php";
session_start();
$usuario =  $_POST["usuario"];
$senha =  $_POST["senha"];
$consulta  = "SELECT * FROM tb_users WHERE cl_usuario = '$usuario' and cl_ativo = '1'";
$consulta_login = mysqli_query($conecta, $consulta);
if($usuario != "" and $senha !="" ){//verificar se os campos estão preenchidos
if($consulta_login ){
$user_acess = mysqli_fetch_assoc($consulta_login);
if (empty($user_acess)){
echo "login sem Sucesso";

 //registrar no log
 $mensagem =  utf8_decode("Tentativa de acesso do Usúario $usuario, sem sucesso ");
 registrar_log($conecta,$usuario,$data,$mensagem);

}else{
        $senha_bd = $user_acess['cl_senha'];
        $senha_bd = base64_decode($senha_bd);
        if($senha == $senha_bd){
        $_SESSION["user_session_portal"] = $user_acess["cl_id"];
        echo "ok";

        //registrar no log    
        $mensagem =  utf8_decode("Usúario $usuario acessou ao sistema");
        registrar_log($conecta,$usuario,$data,$mensagem);

        }else{
        echo "senha incorreta";
         //registrar no log
         $mensagem =  utf8_decode("Tentativa de acesso do Usúario $usuario, sem sucesso ");
         registrar_log($conecta,$usuario,$data,$mensagem);
        }
   }
}else{
    die("Falha na consulta ao banco de dados");
}
}else{
echo "informe a sua senha e seu usuario";
}

?>
<?php
include "../../conexao/conexao.php";
include "../../funcao/funcao.php";
session_start();


if (isset($_COOKIE['algn'])) {
    $chave_aleatoria = $_COOKIE['algn'];

    $consulta  = "SELECT * FROM tb_users WHERE  cl_chave_aleatoria = '$chave_aleatoria'";
    $consulta_login = mysqli_query($conecta, $consulta);

    if($consulta_login ){
        $user_acess = mysqli_fetch_assoc($consulta_login);
        if (!empty($user_acess)){
     
             $_SESSION["user_session_portal"] = $user_acess["cl_id"];
             echo "ok";
        
            //registrar no log    
            $mensagem =  utf8_decode("Usúario $usuario acessou ao sistema");
            registrar_log($conecta,$usuario,$data,$mensagem);
    
            }
           }

  }





?>
<?php 
date_default_timezone_set('America/Fortaleza');
$data = date('Y/m/d H:i:s');


//mensagem de alerta cadastro
function mensagem_alerta_cadastro($campo){
    return "Campo $campo não foi informado, favor verifique!";
}

function verificar_user($conecta,$usuario,$acao){
    if($acao =="cadastrar"){
    //verificar se já existe uma pessoa cadastrada com o mesmo usuario
    $select = "SELECT * from tb_users where cl_usuario ='$usuario'";
    $consultar_verficar_user = mysqli_query($conecta,$select);
    $cont = mysqli_num_rows($consultar_verficar_user);
    return $cont;
    }else{
    //verificar se já existe uma pessoa cadastrada com o mesmo usuario diferente do usuario que será alterado
    $select = "SELECT * from tb_users where cl_usuario = '$usuario'";
    $consultar_verficar_user = mysqli_query($conecta,$select);
    $linha = mysqli_fetch_assoc($consultar_verficar_user);
    $id_user_b = $linha['cl_id'];
    return $id_user_b;
    }
}
?>
<?php 
date_default_timezone_set('America/Fortaleza');
$data = date('Y/m/d H:i:s');

$data_incial_log =date('01/01/Y');
$data_final_log =date('d/m/Y');

///formatar data 
function formatarTimeStamp($value){
    $value = date("d/m/Y H:i:s",strtotime($value));
    return $value;
  
 }
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


function verificar_user_usuario($conecta,$id_user){
    //verificar usuario pelo id
    $select = "SELECT * from tb_users where cl_id ='$id_user'";
    $consultar_verficar_user = mysqli_query($conecta,$select);
    $linha = mysqli_fetch_assoc($consultar_verficar_user);
    $usuario_b = $linha['cl_usuario'];
    return $usuario_b;
    
}

function registrar_log($conecta,$id_usuario_logado,$data,$mensagem){
    $inset = "INSERT INTO tb_log (cl_data_modificacao,cl_usuario,cl_descricao) VALUES ('$data','$id_usuario_logado','$mensagem')";
    $operacao_inserir = mysqli_query($conecta, $inset);
    return $operacao_inserir;
}
?>
<?php
include "/../../../conexao/conexao.php";
$select = "SELECT * from tb_users";
$consultar_usuarios = mysqli_query($conecta, $select);
if(!$consultar_usuarios){
die("Falha no banco de dados"); // colocar o svg do erro
}

if(isset($_GET['consultar_log'])){
    $consulta = $_GET['consultar_log'];
    if($consulta == "inical"){
    $data_incial_log_m  = date('Y-01-01 01:01:01');
    $data_final_log_m = date('Y-m-31 23:59:59');
    $select = "SELECT log.cl_data_modificacao , user.cl_usuario,log.cl_descricao from tb_log as log inner join tb_users as user on user.cl_id = log.cl_usuario where log.cl_data_modificacao 
    between '$data_incial_log_m' and '$data_final_log_m'";
    $consultar_log = mysqli_query($conecta, $select);
    if(!$consultar_log){
    die("Falha no banco de dados"); // colocar o svg do erro
    }
}elseif($consulta == "detelhado"){
    //pegar as data pelo filtro // FILTRO PELA DATA USUARIO E DESCRICAO

    $data_incial_log_d = $_GET['data_inicial'];
    $data_final_log_d =$_GET['data_final'];
  
    if($data_incial_log_d !=""){
    $div1 = explode("/",$_GET['data_inicial']);
    $data_incial_log_d = $div1[2]."-".$div1[1]."-".$div1[0];  

    $data_incial_log_d = ($data_incial_log_d.' 01:01:01');
    }else{
        $data_incial_log_d  = date('Y-01-01 01:01:01');
    }

    if($data_final_log_d !=""){
    $div2 = explode("/",$_GET['data_final']);
    $data_final_log_d = $div2[2]."-".$div2[1]."-".$div2[0];  
    $data_final_log_d = ($data_final_log_d.' 23:59:59');
    }else{
        $data_final_log_d  = date('Y-m-31 23:59:59');
    }

    $usuario_id = $_GET['usuario_id'];
    $conteudo = $_GET['conteudo'];

    $select = "SELECT log.cl_data_modificacao , user.cl_usuario,log.cl_descricao from tb_log as log inner join tb_users as user on user.cl_id = log.cl_usuario where log.cl_data_modificacao 
    between '$data_incial_log_d' and '$data_final_log_d' and log.cl_descricao LIKE '%{$conteudo}%' ";
    if($usuario_id !="s"){
    $select .=" and log.cl_usuario = $usuario_id";
    }
    $consultar_log = mysqli_query($conecta, $select);
    if(!$consultar_log){
    die("Falha no banco de dados"); // colocar o svg do erro
    }
}
}
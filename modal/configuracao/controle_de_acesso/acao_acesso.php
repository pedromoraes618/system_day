<?php
include "../../../conexao/conexao.php";
//remover acesso
if(isset($_POST['removeracessos']) and (isset($_POST['idsubcategoria'])) and (isset($_POST['clienteID'])) ){
    $id_subcategoria = $_POST['idsubcategoria'];
    $usuario_id = $_POST['clienteID'];
    $retornar = array();    
    
    $select = "SELECT * from tb_acessos where cl_usuario_id = '$usuario_id' and cl_subcategoria = '$id_subcategoria'";
    $consulta_acesso_usuario = mysqli_query($conecta,$select);
    $cont = mysqli_num_rows($consulta_acesso_usuario);
    if($cont > 0){//se o acesso existir porém não está desabilitado fazer um update para ativar o acesso para o usuario
        $update = "UPDATE tb_acessos set cl_acesso_ativo = '0' where cl_usuario_id = '$usuario_id' and cl_subcategoria = '$id_subcategoria'";
        $update_alterar_inativo = mysqli_query($conecta,$update);
        if($update_alterar_inativo){
            $retornar["sucesso"] = true;
        }else{
            $retornar["sucesso"] = false;
        }
    }
    echo json_encode($retornar);
    }
        
//adiciionar acesso
if(isset($_POST['addicionaracesso']) and (isset($_POST['idsubcategoria'])) and (isset($_POST['clienteID'])) ){
    $id_subcategoria = $_POST['idsubcategoria'];
    $usuario_id = $_POST['clienteID'];
    $retornar = array();    
    
    $select = "SELECT * from tb_acessos where cl_usuario_id = '$usuario_id' and cl_subcategoria = '$id_subcategoria'";
    $consulta_acesso_usuario = mysqli_query($conecta,$select);
    $cont = mysqli_num_rows($consulta_acesso_usuario);
    if($cont > 0){//se o acesso existir porém não está desabilitado fazer um update para ativar o acesso para o usuario
        $update = "UPDATE tb_acessos set cl_acesso_ativo = '1' where cl_usuario_id = '$usuario_id' and cl_subcategoria = '$id_subcategoria'";
        $update_alterar_ativo = mysqli_query($conecta,$update);
        if($update_alterar_ativo){
            $retornar["sucesso"] = true;
        }else{
            $retornar["sucesso"] = false;
        }
    }else{//se o acesso não exister, fazer um inset do acesso para o usuario
        $insert = "INSERT INTO tb_acessos (cl_usuario_id,cl_subcategoria,cl_acesso_ativo) values ('$usuario_id','$id_subcategoria','1')";
        $insert_acesso_usuario = mysqli_query($conecta,$insert);
        if($update_alterar_ativo){
            $retornar["sucesso"] = true;
        }else{
            $retornar["sucesso"] = false;
        }

    }
    echo json_encode($retornar);
    
}
<?php


//cadastrar usuario
if (isset($_POST['autorizar_acao'])) {
    include "../../conexao/conexao.php";
    include "../../funcao/funcao.php";
    $retornar = array();
    $acao = $_POST['acao'];
   // $tela = $_POST['tela'];


    $id_usuario = $_POST['usuario_id'];
    $senha = $_POST['senha'];

    if ($acao == "validar_usuario") {
        if (validar_usuario($conecta, $id_usuario, $senha) == false) {
            $retornar["dados"] = array("sucesso" => false, "title" => "Senha incorreta, autorização não permitida"); //alertar o usuario que o caixa está fechado

        }else{
            $retornar["dados"] = array("sucesso" => true); //alertar o usuario que o caixa está fechado
        }
    }

    echo json_encode($retornar);
}


$select = "SELECT * from tb_users where cl_autorizar_desconto ='SIM' and cl_ativo ='1' ";
$consultar_usuarios_autorizados = mysqli_query($conecta, $select);

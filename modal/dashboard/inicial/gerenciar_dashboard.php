<?php
if (isset($_POST['dashboard_inicial'])) {
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
    $retornar = array();
    $usuario = $_POST['usuario'];

    $verifica_periodo = $_POST['verifica_periodo'];
    if($verifica_periodo !="consultar"){
        $update = "UPDATE tb_users SET cl_periodo_dashboard = '$verifica_periodo' WHERE cl_usuario = '$usuario'";
        $update_usuario = mysqli_query($conecta,$update);
      
    }

    $select = "SELECT * from tb_users where cl_usuario = '$usuario'";
    $consultar_usuario = mysqli_query($conecta,$select);
    $linha = mysqli_fetch_assoc($consultar_usuario);
    $periodo = $linha['cl_periodo_dashboard'];
    $area = $linha['cl_usuario_area'];


    $retornar["dados"] = array("sucesso" => true, "periodo" =>$periodo,"area"=>$area );

    echo json_encode($retornar);
}

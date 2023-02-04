<?php
//pegar o id
if ($_SESSION["user_session_portal"]) {
    $user = $_SESSION["user_session_portal"];
    $consulta  = "SELECT * FROM tb_users WHERE cl_id = $user";
    $consulta_users = mysqli_query($conecta, $consulta);
    $row = mysqli_fetch_assoc($consulta_users);
    $usuario = $row['cl_usuario'];
    $tipo = $row['cl_tipo'];


    //verficar a quantidade de lembretes com o staus a fazer ou inciado para o usuario
    $consulta  = "SELECT count(*) as qtd FROM tb_tarefas where cl_usuario = $user and cl_status !='3'";
    $consulta_qtd_lembrete = mysqli_query($conecta, $consulta);
    $row = mysqli_fetch_assoc($consulta_qtd_lembrete);
    $qtd_lembrete = $row['qtd'];

    
    if(isset($_GET['ctg'])){
        $categoria_top = $_GET['ctg'];
    }else{
        $categoria_top ="Inicial";
    }
    
    //pegar qual a subcategoria o usuario está
    if(isset($_GET['ctg']) and isset($_GET['id'])){
        $subcategoria_id = $_GET['id'];
        $consulta  = "SELECT * FROM tb_subcategorias WHERE cl_id = $subcategoria_id";
        $consulta_subcategoria = mysqli_query($conecta, $consulta);
        $row = mysqli_fetch_assoc($consulta_subcategoria);
        $subcategoria = utf8_encode($row['cl_subcategoria']);
        $sub_top = $categoria_top." > ". $subcategoria;
     
    }else{
    
        $sub_top = "";
    }
    
}
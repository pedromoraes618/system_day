<?php
//pegar o id
if ($_SESSION["user_session_portal"]) {
    $user = $_SESSION["user_session_portal"];
    $consulta  = "SELECT * FROM tb_users WHERE cl_id = $user";
    $consulta_users = mysqli_query($conecta, $consulta);
    $row = mysqli_fetch_assoc($consulta_users);
    $usuario = $row['cl_usuario'];

}
if(isset($_GET['ctg'])){
    $categoria = $_GET['ctg'];
}else{
    $categoria ="Inicial";
}

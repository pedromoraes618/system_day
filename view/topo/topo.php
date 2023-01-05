<?php 
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
?>

<div class="topo">
    <div class="left">
        <p><?php echo $categoria; ?></p>
    </div>
    <div class="right">
        <ul>
            <li><i class="fa-solid fa-user"></i>
                <ul class="menu_user">
                    <li>
                        <a href="?menu&user">Meu usuário</a>
                    </li>
                    <li>
                        <a href="?menu&logout">Sair</a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="user">
            <p><?php echo $usuario; ?></p>
        </div>
        
    </div>

</div>


<script src="js/jquery.js"></script>

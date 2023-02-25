<?php 
include("conexao/conexao.php");
session_start();
ini_set('session.gc_maxlifetime', 10800); // Expire em 1 hora (3600 segundos)

if(!$_GET){ 
    if(isset($_SESSION["user_session_portal"])){
        include "view/menu/menu.php";
    }else{
        
        include "view/login/login.php";
    }
}else{
    if(isset($_SESSION["user_session_portal"])){
        include "controllers/cotroller.php";
    }elseif(isset($_GET['resetar_password'])){
        include "view/resetar_senha/resetar_password.php";
    }else{
      
        include "view/login/login.php";
    }
}
mysqli_close($conecta);
?>
<script src="js/index/index.js"></script>
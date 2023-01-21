<?php 

include("conexao/conexao.php");

session_start();
if(!$_GET){ 
    if(isset($_SESSION["user_session_portal"])){
        include "view/menu/menu.php";
    }else{
        include "view/login/login.php";
    }
}else{
    if(isset($_SESSION["user_session_portal"])){
        include "controllers/cotroller.php";
    }else{
        include "view/login/login.php";
    }

    
}

mysqli_close($conecta);

?>
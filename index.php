<?php 

include("conexao/conexao.php");

session_start();
if(!$_GET){ 
    if(isset($_SESSION["user_session_portal"])){
        include "view/menu/menu.php";
    }else{
        include "login.php";
    }
   
}else{
    include "controllers/cotroller.php";
}

mysqli_close($conecta);

?>
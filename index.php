<?php 

include("conexao/conexao.php");
if(!$_GET){ 
    include "login.php";
}else{
    include "controllers/cotroller.php";
}

mysqli_close($conecta);

?>
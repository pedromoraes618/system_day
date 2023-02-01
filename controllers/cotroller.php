<?php
if(isset($_GET['resetar_password'])){
    include "view/resetar_senha/resetar_password.php";
}elseif(isset($_GET['menu'])){
    include "view/menu/menu.php";
}elseif(isset($_GET['logout'])){ // se for definido logout 
    include 'parameters/parameters.php';
    //setcookie("login", time() - 9600);
    include 'logout.php';
}
?>
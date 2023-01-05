<?php
if(isset($_GET['resetar_password'])){
    include "resetar_password.php";

}elseif(isset($_GET['menu'])){
    include "conexao/sessao.php";
    include "view/menu/menu.php";
}else{
    header("Location:?menu");
}
?>
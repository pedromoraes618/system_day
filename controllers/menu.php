<?php 
if(isset($_GET['menu'])){
    if(isset($_GET['ctg'])){
        if(isset($_GET['id'])){
            $id_subctg = $_GET['id'];
            //funcao para verificar o id da subcategoria e buscar o diretorio
            include "view/".consultar_subcategoria($id_subctg);
            
        }
    }elseif(isset($_GET['logout'])){
     include "logout.php";  
    }
}
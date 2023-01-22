<?php

if(isset($_GET['menu'])){
   
    if(isset($_GET['ctg'])){
        if(isset($_GET['id'])){
            $id_subctg = $_GET['id'];
            if(consultar_diretorio_bd($id_subctg)!=""){//diretorio dos arquivos bd
                include "modal/".consultar_diretorio_bd($id_subctg);
            }
            //funcao para verificar o id da subcategoria e buscar o diretorio
            
            include "view/".consultar_subcategoria($id_subctg);
    
        }
    }

}
include "view/title/titulo.php";
?>
<!-- usuario logado -->
<input type="hidden" id="user_logado" value="<?php echo $usuario ?>">
<input type="hidden" id="id_user_logado" value="<?php echo $id_user ?>">
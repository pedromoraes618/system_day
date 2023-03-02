<?php 
if(isset($_GET['kardex_produto'])==true){
   
    $id_produto = $_GET['id_produto'];
    $select ="SELECT * from tb_produtos where cl_id = $id_produto";
    $consultar_produto= mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consultar_produto);
    $descricao_b = $linha['cl_descricao'];
 
    $select ="SELECT * from tb_ajuste_estoque where cl_produto_id = $id_produto order by cl_id ";
    $consultar_historico_produto= mysqli_query($conecta, $select);
 
   
 }
 
 
?>
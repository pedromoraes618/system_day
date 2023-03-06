<?php 
if(isset($_GET['kardex_produto'])==true){
   
    $id_produto = $_GET['id_produto'];
    $select ="SELECT * from tb_produtos where cl_id = $id_produto";
    $consultar_produto= mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consultar_produto);
    $descricao_b = $linha['cl_descricao'];
 
    // $select ="SELECT * from tb_ajuste_estoque where cl_produto_id = $id_produto order by cl_id ";
    // $consultar_historico_produto= mysqli_query($conecta, $select);
 
    $select ="SELECT user.cl_usuario as usuario,ajst.cl_ajuste_inicial,ajst.cl_quantidade,ajst.cl_id,ajst.cl_data_lancamento,ajst.cl_tipo,
    ajst.cl_documento,ajst.cl_status from tb_ajuste_estoque as ajst inner join tb_users as user on user.cl_id = ajst.cl_usuario_id 
     where ajst.cl_produto_id = $id_produto  order by ajst.cl_id ";
    $consultar_historico_produto= mysqli_query($conecta, $select);
   
 }
 
 
?>
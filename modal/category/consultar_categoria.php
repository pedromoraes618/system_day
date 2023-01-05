<?php
 $select = "SELECT * from tb_categorias";
 $consultar_categoria = mysqli_query($conecta,$select);

//passar o diretorio da subcategoria via url
function consultar_subcategoria($id_subctg){
include 'conexao/conexao.php';
$select = "SELECT * FROM tb_subcategorias where cl_id = $id_subctg";
$consultar_subcategoria = mysqli_query($conecta,$select);
$row = mysqli_fetch_assoc($consultar_subcategoria);
$diretorio = $row['cl_diretorio'];
return $diretorio;
 }



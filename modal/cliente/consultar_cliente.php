<?php
 $select = "SELECT * FROM tb_categorias ";
 $consultar_categoria = mysqli_query($conecta,$select);
 $linha = mysqli_fetch_assoc($consultar_categoria);
 $id_categoria = $linha['cl_id'];


<?php
$consulta  = "SELECT * FROM tb_empresa WHERE cl_id = 1";
$consulta_empresa = mysqli_query($conecta, $consulta);
$row = mysqli_fetch_assoc($consulta_empresa);
$empresa = $row['cl_site'];

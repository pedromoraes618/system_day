<?php
include "parameters/parameters.php";
include "view/tema_sistema/estilo.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/menu.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- icons bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="icon" type="img/icon.svg" href="img/icon.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-labels@1.1.0/dist/chartjs-plugin-labels.min.js"></script>

</head>

<body>
    <div class="bloco">
        <!-- menu -->
        <div class="bloco-left">
            <?php
            include "modal/category/consultar_categoria.php";
            include "view/nav/menu_desktop.php";

            ?>
        </div>
        <!-- parte principal -->
        <div class="bloco-right">
            <?php
            include "modal/topo/topo.php";
            include "view/topo/topo.php";
            include "controllers/menu.php";
            ?>
        </div>

    </div>

  
    <script src="js/jquery.js"></script>
    <script src="https://malsup.github.io/jquery.form.js"></script>
    <script src="js/menu/estilo/gerenciar_menu.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

</body>

</html>
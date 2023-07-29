<?php
include "../../../modal/relatorio/gerenciar_modelo_1.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório</title>
    <!-- Link para o CSS do Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="../../../css/relatorio.css" rel="stylesheet">

</head>

<body>
    <header>
        <!-- <img src="../../img/logo_effmax.png" alt="Logo da Empresa" width="100" height="100"> -->
        <h1><?php echo $empresa; ?></h1>
        <p>CNPJ: <?php echo $cnpj_empresa; ?></p>
        <p>Data: <?php echo formatDateB($data_lancamento) ?></p>
    </header>
    <input type="hidden" id="relatorio" value="<?php echo $relatorio; ?>">
    <div class="dados">
        <?php
        if ($relatorio == "resumo_extrato_financeiro") {
            include "../tabela/extrato_financeiro.php";
        }elseif($relatorio=="resumo_caixa"){
            include "../tabela/resumo_movimento_caixa.php";
        }elseif($relatorio=="venda_fpg_caixa"){
            include "../tabela/forma_pagamento_caixa.php";
        }
        ?>
    </div>

    <!-- <footer>
        <p>@Todos os direitos reservados a effmax</p>
    
    </footer> -->

    <script src="../../../js/jquery.js"></script>

    <!-- <script src="../../../js/relatorio/tabela/extrato_financeiro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script> -->
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

</body>

</html>
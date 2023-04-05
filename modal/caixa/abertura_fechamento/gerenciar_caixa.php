<?php

//a brir o caixa
if (isset($_POST['abertura_caixa'])) {
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
    $retornar = array();
    $consultar_tipo_contabiizacao =  verficar_paramentro($conecta, "tb_parametros", "cl_id", "6"); //VERIFICAR PARAMETRO ID - 1
    $data_caixa = $_POST['data_caixa'];
    $user_id = $_POST['id_user'];
    $nome_usuario_logado = $_POST['user_logado'];
    // Divide a data em partes
    $partes = explode('-', $data_caixa);

    // Extrai o ano, o mês e o dia
    $ano = $partes[0];
    $mes = $partes[1];
    $dia = $partes[2];

    $data_abertura = date('Y-m-d');

    $caixa = verifica_status_caixa($conecta, $consultar_tipo_contabiizacao, $dia, $mes, $ano);


    $resultado_consulta = $caixa['resultado'];


    $saldo_final_periodo_anterior =  verifica_saldo_final($conecta, $consultar_tipo_contabiizacao, $dia, $mes, $ano);

    if ($resultado_consulta > 0) { // se o caixa já estiver aberto apenas reabir o periodo

        $update = "UPDATE tb_caixa SET cl_valor_abertura = '$saldo_final_periodo_anterior', cl_status='reaberto', cl_usuario_abertura='$user_id'
             WHERE  cl_mes = '$mes' and cl_ano = '$ano' ";
        if ($consultar_tipo_contabiizacao == "DIA") { //verificar se o parametro estiver setado com dia, realizar o update naquela data especifica
            $update .= " and cl_dia = '$dia'";
        }
        $operacao_update = mysqli_query($conecta, $update);
        if ($operacao_update) {
            $retornar["dados"] = array("sucesso" => true, "title" => "Caixa reaberto com sucesso");
            $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado reabriu o caixa do periodo $dia/$mes/$ano");
            registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
        }
    } else { // se o caixa ainda não tiver aberto adicionar o caixa 
        $inset = "INSERT INTO tb_caixa (cl_data_abertura,cl_valor_abertura, cl_status, cl_usuario_abertura,cl_dia,cl_mes,cl_ano)
        VALUES ('$data_abertura','$saldo_final_periodo_anterior','aberto','$user_id','$dia','$mes','$ano')";
        $operacao_inserir = mysqli_query($conecta, $inset);
        if ($operacao_inserir) {
            $retornar["dados"] = array("sucesso" => true, "title" => "Caixa aberto com sucesso");
            $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado Abriu o caixa do periodo $dia/$mes/$ano");
            registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
        }
    }

    echo json_encode($retornar);
}



//fechar o caixa
if (isset($_POST['fechar_caixa'])) {
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
    $retornar = array();
    $consultar_tipo_contabiizacao =  verficar_paramentro($conecta, "tb_parametros", "cl_id", "6"); //VERIFICAR PARAMETRO ID - 1
    $data_caixa = $_POST['data_caixa'];
    $user_id = $_POST['id_user'];
    $nome_usuario_logado = $_POST['user_logado'];

    // Divide a data em partes
    $partes = explode('-', $data_caixa);

    // Extrai o ano, o mês e o dia
    $ano = $partes[0];
    $mes = $partes[1];
    $dia = $partes[2];

    $data_fechamento = date('Y-m-d');

    $caixa = verifica_status_caixa($conecta, $consultar_tipo_contabiizacao, $dia, $mes, $ano);
    $resultado_consulta = $caixa['resultado'];

    //$saldo_final_periodo_anterior =  verifica_saldo_final($conecta, $consultar_tipo_contabiizacao, $dia, $mes, $ano);

    if ($resultado_consulta > 0) { // se o caixa já estiver aberto apenas reabir o periodo
        $valor_abertura = $caixa['valor_aberto'];
        $valor_fechado = $valor_abertura + 5;
        $update = "UPDATE tb_caixa SET cl_valor_fechamento='$valor_fechado',cl_status='fechado',cl_usuario_fechamento='$user_id', cl_data_fechamento='$data_fechamento', cl_usuario_abertura='$user_id' 
        WHERE cl_mes = '$mes' and cl_ano = '$ano'";
        if ($consultar_tipo_contabiizacao == "DIA") { //verificar se o parametro estiver setado com dia, realizar o update naquela data especifica
            $update .= " and cl_dia = '$dia'";
        }
        $operacao_update = mysqli_query($conecta, $update);
        if ($operacao_update) {
            $retornar["dados"] = array("sucesso" => true, "title" => "Caixa fechado com sucesso");
            $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado fechou o caixa do periodo $dia/$mes/$ano");
            registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
        }
    } else { // infomar que o periodo que o uúario quer fehar ainda não foi aberto
        $retornar["dados"] = array("sucesso" => false, "title" => "O caixa desse periodo ainda não foi aberto");
    }

    echo json_encode($retornar);
}



if (isset($_GET['status_caixa'])) { //Verificar o status do caixa
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
    $data = $_GET['data_caixa'];
    $consultar_contabilizacao_caixa =  verficar_paramentro($conecta, "tb_parametros", "cl_id", "6"); //VERIFICAR PARAMETRO ID - 6 // verificar se periodo do caixa vai ser contabilizado por dia ou mês
    // Divide a data em partes
    $partes = explode('-', $data);

    // Extrai o ano, o mês e o dia
    $ano = $partes[0];
    $mes = $partes[1];
    $dia = $partes[2];


    $select = "SELECT * FROM tb_caixa where cl_ano !='' ";
    if ($consultar_contabilizacao_caixa == "DIA") {
        $select .= " and cl_dia = '$dia' and cl_mes ='$mes' and cl_ano='$ano' "; // se for por periodo de contabilização em dia a dia vai verifiar o dia, o mes e o ano
    } elseif ($consultar_contabilizacao_caixa == "MES") {
        $select .= " and cl_mes = '$mes' and cl_ano ='$ano'"; // se for por periodo de contabilização em mes a mes vai verifiar o mes e o ano
    } else {
        $select .= " and cl_dia = '$dia' and cl_mes ='$mes' and cl_ano='$ano' "; // se o paramentro estivir com valor incorreto será atribuido o periodo de dia a dia
    }

    $consulta_caixa = mysqli_query($conecta, $select);
    if ($consulta_caixa) {
        $resultado_consulta = mysqli_num_rows($consulta_caixa);
        $linha = mysqli_fetch_assoc($consulta_caixa);
        $status = $linha['cl_status'];
        $valor_fechado = $linha['cl_valor_abertura'];
    }
}
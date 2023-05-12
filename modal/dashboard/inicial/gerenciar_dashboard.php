<?php
if (isset($_POST['dashboard_inicial'])) {
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
    $retornar = array();
    $usuario = $_POST['usuario'];

    $verifica_periodo = $_POST['verifica_periodo'];
    if ($verifica_periodo != "consultar") {
        $update = "UPDATE tb_users SET cl_periodo_dashboard = '$verifica_periodo' WHERE cl_usuario = '$usuario'";
        $update_usuario = mysqli_query($conecta, $update);
    }

    $select = "SELECT * from tb_users where cl_usuario = '$usuario'";
    $consultar_usuario = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consultar_usuario);
    $periodo = $linha['cl_periodo_dashboard'];
    $area = $linha['cl_usuario_area'];


    $retornar["dados"] = array("sucesso" => true, "periodo" => $periodo, "area" => $area);

    echo json_encode($retornar);
}


//consultar informações para tabela
if (isset($_GET['dashboard_inicial'])) {
    include "../../../../../conexao/conexao.php";
    include "../../../../../funcao/funcao.php";
    $ano = date('Y');

    if (isset($_GET['periodo'])) {
        $periodo = $_GET['periodo'];
    }
    if (isset($_GET['usuario'])) {
        $usuario = $_GET['usuario'];
    }




    $select_receita = "SELECT sum(cl_valor_liquido) as valor from tb_lancamento_financeiro where";

    $select_despesa = "SELECT sum(cl_valor_liquido) as valor from tb_lancamento_financeiro where";

    $select_a_receber = "SELECT DATEDIFF(CURRENT_DATE(),lcf.cl_data_vencimento) as atraso,  lcf.cl_data_vencimento,prc.cl_razao_social,lcf.cl_valor_liquido from tb_lancamento_financeiro as 
    lcf inner join tb_parceiros as prc on prc.cl_id = lcf.cl_parceiro_id where";

    $select_a_pagar = "SELECT DATEDIFF(CURRENT_DATE(),lcf.cl_data_vencimento) as atraso, lcf.cl_data_vencimento,prc.cl_razao_social,lcf.cl_valor_liquido from tb_lancamento_financeiro as 
    lcf inner join tb_parceiros as prc on prc.cl_id = lcf.cl_parceiro_id where";

    $select_lembretes = "SELECT trf.cl_id, userord.cl_usuario as usuarioordem, trf.cl_data_lancamento,trf.cl_descricao,trf.cl_comentario,user.cl_usuario 
    as usuario_func,trf.cl_prioridade,trf.cl_data_limite,strf.cl_descricao as status from tb_tarefas as trf inner join tb_users as user on user.cl_id = trf.cl_usuario_func inner join tb_users as userord on userord.cl_id = trf.cl_usuario
    inner join tb_status_tarefas as strf on strf.cl_id = trf.cl_status where user.cl_usuario   = '$usuario' and (trf.cl_status ='1' or trf.cl_status='2') ";

    if ($periodo == "DIA") {

        $select_receita .= " cl_data_pagamento between '$data_dia_bd' and '$data_dia_bd' and cl_status_id ='2' "; //receita
        $select_despesa .= " cl_data_pagamento between '$data_dia_bd' and '$data_dia_bd' and cl_status_id ='4' "; //despesa
        $select_a_receber .= " lcf.cl_data_vencimento between '$data_dia_bd' and '$data_dia_bd' and lcf.cl_status_id ='1' order by lcf.cl_data_vencimento desc"; //contas a receber
        $select_a_pagar .= " lcf.cl_data_vencimento between '$data_dia_bd' and '$data_dia_bd' and lcf.cl_status_id ='3'order by lcf.cl_data_vencimento  desc"; //contas a pagar
        $select_lembretes .= " and  trf.cl_data_lancamento between '$data_dia_bd' and '$data_dia_bd'"; //lembretes

    } elseif ($periodo == "MES") {

        $select_receita .= " cl_data_pagamento between '$data_inicial_mes_bd' and '$data_final_mes_bd' and cl_status_id ='2' "; //receita
        $select_despesa .= " cl_data_pagamento between '$data_inicial_mes_bd' and '$data_final_mes_bd' and cl_status_id ='4' "; //despesa
        $select_a_receber .= " lcf.cl_data_vencimento between '$data_inicial_mes_bd' and '$data_final_mes_bd' and lcf.cl_status_id ='1' order by lcf.cl_data_vencimento desc"; //contas a receber
        $select_a_pagar .= " lcf.cl_data_vencimento between '$data_inicial_mes_bd' and '$data_final_mes_bd' and lcf.cl_status_id ='3'order by lcf.cl_data_vencimento desc "; //contas a pagar
        $select_lembretes .= " and  trf.cl_data_lancamento between '$data_inicial_mes_bd' and '$data_final_mes_bd'"; //lembretes
    } else {

        $select_receita .= " cl_data_pagamento between '$data_inical_ano_bd' and '$data_final_ano_bd' and cl_status_id ='2' "; //receita
        $select_despesa .= " cl_data_pagamento between '$data_inical_ano_bd' and '$data_final_ano_bd' and cl_status_id ='4' "; //despesa
        $select_a_receber .= " lcf.cl_data_vencimento between '$data_inical_ano_bd' and '$data_final_ano_bd' and lcf.cl_status_id ='1' order by lcf.cl_data_vencimento desc "; //contas a receber
        $select_a_pagar .= " lcf.cl_data_vencimento between '$data_inical_ano_bd' and '$data_final_ano_bd' and lcf.cl_status_id ='3'order by lcf.cl_data_vencimento desc"; //contas a pagar
        $select_lembretes .= " and  trf.cl_data_lancamento between '$data_inical_ano_bd' and '$data_final_ano_bd'"; //lembretes

    }
    $consultar_receita_total = mysqli_query($conecta, $select_receita); //receita para o card //container center 
    $linha = mysqli_fetch_assoc($consultar_receita_total);
    $receita_total = ($linha['valor']);

    $consultar_despesa_total = mysqli_query($conecta, $select_despesa); //receita para o card //container center 
    $linha = mysqli_fetch_assoc($consultar_despesa_total);
    $despesa_total = ($linha['valor']);

    $consultar_contas_a_receber = mysqli_query($conecta, $select_a_receber); //contas a receber //container center 
    $qtd_consultar_contas_a_receber = mysqli_num_rows($consultar_contas_a_receber);

    $consultar_contas_a_pagar = mysqli_query($conecta, $select_a_pagar); //contas a pagar //container center 
    $qtd_consultar_contas_a_pagar = mysqli_num_rows($consultar_contas_a_pagar);

    $consultar_lembretes = mysqli_query($conecta, $select_lembretes); //consultar tarefas
    $qtd_consultar_lembretes = mysqli_num_rows($consultar_lembretes);

    function consultar_receita_anual_detalhado($i, $ano)
    { //arrey de receita por mes durante o ano
        include "../../../../../conexao/conexao.php";
        $select = "SELECT sum(cl_valor_liquido) as valor from tb_lancamento_financeiro where cl_data_pagamento between '$ano-$i-01' and '$ano-$i-31' and cl_status_id ='2'";
        $consulta_valores_receita_array = mysqli_query($conecta, $select);
        $linha = mysqli_fetch_assoc($consulta_valores_receita_array);
        $valor_total  = $linha['valor'];
        return $valor_total;
    }

    
    function consultar_receita_anual_anterior_detalhado($i, $ano)
    { //arrey de receita por mes durante o ano
        include "../../../../../conexao/conexao.php";
        $ano = $ano-1;
        $select = "SELECT sum(cl_valor_liquido) as valor from tb_lancamento_financeiro where cl_data_pagamento between '$ano-$i-01' and '$ano-$i-31' and cl_status_id ='2'";
        $consulta_valores_receita_array = mysqli_query($conecta, $select);
        $linha = mysqli_fetch_assoc($consulta_valores_receita_array);
        $valor_total  = $linha['valor'];
        return $valor_total;
    }

    function consultar_despesa_anual_detalhado($i, $ano)
    { //arrey de despesa por mes durante o ano
        include "../../../../../conexao/conexao.php";
        $select = "SELECT sum(cl_valor_liquido) as valor from tb_lancamento_financeiro where cl_data_pagamento between '$ano-$i-01' and '$ano-$i-31' and cl_status_id ='4'";
        $consulta_valores_receita_array = mysqli_query($conecta, $select);
        $linha = mysqli_fetch_assoc($consulta_valores_receita_array);
        $valor_total  = $linha['valor'];
        return $valor_total;
    }
    function consultar_despesa_anual_anterior_detalhado($i, $ano)
    { //arrey de despesa por mes durante o ano

        include "../../../../../conexao/conexao.php";
        $ano = $ano-1;
        $select = "SELECT sum(cl_valor_liquido) as valor from tb_lancamento_financeiro where cl_data_pagamento between '$ano-$i-01' and '$ano-$i-31' and cl_status_id ='4'";
        $consulta_valores_receita_array = mysqli_query($conecta, $select);
        $linha = mysqli_fetch_assoc($consulta_valores_receita_array);
        $valor_total  = $linha['valor'];
        return $valor_total;
    }
}

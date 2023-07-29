<?php
date_default_timezone_set('America/Fortaleza');
$data = date('Y/m/d H:i:s');


$data_lancamento = date('Y-m-d');

$data_incial_lembrete = date('01/01/Y');

$data_incial_log = date('01/m/Y');
$data_final_log = date('d/m/Y');

$data_inicial = date('01/m/Y');
$data_final = date('d/m/Y');


$data_dia_bd = date('Y-m-d');

$data_inicial_mes_bd = date('Y-m-01');
$data_final_mes_bd = date('Y-m-d');

$data_inical_ano_bd = date('Y-01-01');
$data_final_ano_bd = date('Y-m-d');

///formatar data 
function formatarTimeStamp($value)
{
    $value = date("d/m/Y H:i:s", strtotime($value));
    return $value;
}
//mensagem de alerta cadastro
function mensagem_alerta_cadastro($campo)
{
    return "Campo $campo não foi informado, favor verifique!";
}

//mensagem de alerta de permissao
function mensagem_alerta_permissao()
{
    return "Ação bloqueada. Você não possui permissão para realizar esta ação no sistema. Por favor, verifique as suas permissões de acesso ou 
     entre em contato com o administrador do sistema para obter mais informações";
}

//mensagem de alerta de caixa 
function mensagem_alerta_caixa($valor)
{
    if ($valor == "VAZIO") {
        return "O caixa desse período ainda não foi aberto, favor, verifique";
    }
    if ($valor == "FECHADO") {
        return "O caixa desse período já foi fechado, não é possivel realizar a ação";
    }
}

//mensagem de alerta de serie cadastrada
function mensagem_serie_cadastrada()
{
    return "A serie não está cadastrada, não é possivel realizar a ação, favor, verifique com o suporte";
}

//formatar data do banco de dados
function formatDateB($value)
{
    if (($value != "") and ($value != "0000-00-00")) {
        $value = date("d/m/Y", strtotime($value));
        return $value;
    }
}

function formatarDataParaBancoDeDados($data)
{
    // Cria um objeto DateTime a partir da string da data no formato 'dd/mm/aaaa'
    $dataObj = DateTime::createFromFormat('d/m/Y', $data);

    // Retorna a data formatada no formato 'aaaa-mm-dd'
    return $dataObj->format('Y-m-d');
}

function datecheck($value)
{
    $d = DateTime::createFromFormat('d/m/Y', $value);
    if ($d && $d->format('d/m/Y') == $value) {
        return true;
    } else {
        return false;
    }
}

function verificar_user($conecta, $usuario, $acao)
{
    if ($acao == "cadastrar") {
        //verificar se já existe uma pessoa cadastrada com o mesmo usuario
        $select = "SELECT * from tb_users where cl_usuario ='$usuario'";
        $consultar_verficar_user = mysqli_query($conecta, $select);
        $cont = mysqli_num_rows($consultar_verficar_user);
        return $cont;
    } else {
        //verificar se já existe uma pessoa cadastrada com o mesmo usuario diferente do usuario que será alterado
        $select = "SELECT * from tb_users where cl_usuario = '$usuario'";
        $consultar_verficar_user = mysqli_query($conecta, $select);
        $linha = mysqli_fetch_assoc($consultar_verficar_user);
        $id_user_b = $linha['cl_id'];
        return $id_user_b;
    }
}

function reduzir_texto($texto)
{
    if (strlen($texto) > 30) { // verifica se o texto é maior do que 30 caracteres
        $texto = substr($texto, 0, 20) . "..."; // corta o texto em 30 caracteres e adiciona "..."
    } else {
        $texto = $texto; // se o texto for menor ou igual a 30 caracteres, mantém o texto original
    }
    return $texto;
}

function verificar_user_usuario($conecta, $id_user)
{
    //verificar usuario pelo id
    $select = "SELECT * from tb_users where cl_id ='$id_user'";
    $consultar_verficar_user = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consultar_verficar_user);
    $usuario_b = $linha['cl_usuario'];
    return $usuario_b;
}


//verificar se a opção remover podera ser feita
function verificar_dados_existentes($conecta, $tabela, $filtro, $resultado_filtro)
{
    //verificar usuario pelo id
    $select = "SELECT count(*) as qtd from $tabela where $filtro ='$resultado_filtro'";
    $consultar_dados_existentes = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consultar_dados_existentes);
    $resultado = $linha['qtd'];
    return $resultado;
}


//registrar log da acão
function registrar_log($conecta, $nome_usuario_logado, $data, $mensagem)
{
    $inset = "INSERT INTO tb_log (cl_data_modificacao,cl_usuario,cl_descricao) VALUES ('$data','$nome_usuario_logado','$mensagem')";
    $operacao_inserir = mysqli_query($conecta, $inset);
    return $operacao_inserir;
}


function verficar_paramentro($conecta, $tabela, $filtro, $valor)
{
    $select = "SELECT * from $tabela where $filtro = $valor";
    $consultar_parametros = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consultar_parametros);
    $valor_parametro = $linha['cl_valor'];
    return $valor_parametro;
}

//funcao para saber qual usuario foi selecionado para adicionar ou remover acesso
function consultar_usuario_acesso($conecta, $usuario_id)
{
    //consultar nome do usuario
    $select = "SELECT * from tb_users where cl_id = '$usuario_id' ";
    $consulta_usuario = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consulta_usuario);
    $usuario_b = $linha['cl_usuario'];
    return $usuario_b;
}

//funcao para saber qual subcategoria foi selecionado para adicionar ou remover para o usúario
function consultar_subcategoria_acesso($conecta, $id_subcategoria)
{
    //consultar nome da subcategoria
    $select = "SELECT * from tb_subcategorias where cl_id = '$id_subcategoria' ";
    $consulta_subcategoria = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consulta_subcategoria);
    $subcategoria_b =  utf8_encode($linha['cl_subcategoria']);
    return $subcategoria_b;
}


//funcao para saber qual é o valor da serie pelo id
function consultar_serie($conecta, $id_serie)
{
    //consultar nome da subcategoria
    $select = "SELECT * from tb_serie where cl_id = '$id_serie' ";
    $consulta_serie = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consulta_serie);
    $valor = $linha['cl_valor'];
    return $valor;
}


//funcao para saber qual é o valor da serie
function consultar_valor_serie($conecta, $id)
{
    //consultar nome da subcategoria
    $select = "SELECT * from tb_serie where cl_id = $id ";
    $consulta_serie = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consulta_serie);
    $valor = $linha['cl_valor'];
    return $valor;
}

//funcao para realizar ajuste de estoque
function ajuste_estoque($conecta, $data, $doc, $tipo, $produto_id, $quantidade, $empresa_id, $parceiro_id, $usuario_id, $forma_pagamento_id, $valor_venda, $valor_compra, $ajuste_inical, $motivo, $codigo_nf)
{
    $inset = "INSERT INTO `tb_ajuste_estoque` (`cl_data_lancamento`, `cl_documento`, `cl_produto_id`, `cl_tipo`, `cl_quantidade`, 
    `cl_empresa_id`,`cl_parceiro_id`,`cl_usuario_id`, `cl_forma_pagamento_id`, `cl_valor_venda`, `cl_valor_compra`,`cl_ajuste_inicial`,`cl_status`,`cl_motivo`,`cl_codigo_nf`) VALUES 
    ('$data', '$doc', '$produto_id', '$tipo', '$quantidade', '$empresa_id','$parceiro_id','$usuario_id', '$forma_pagamento_id', '$valor_venda', '$valor_compra','$ajuste_inical','ok','$motivo','$codigo_nf')";
    $operacao_inserir = mysqli_query($conecta, $inset);
    return $operacao_inserir;
}

//funcao para realizar ajuste na quantidade do produto
function ajuste_qtd_produto($conecta, $produto_id, $quantidade, $data_validade)
{

    $update = "UPDATE `tb_produtos` SET `cl_estoque`= '$quantidade',`cl_data_validade`= '$data_validade'  where cl_id = $produto_id";
    $operacao_update = mysqli_query($conecta, $update);
    return $operacao_update;
}


//funcao para atualizar valor em serie
function adicionar_valor_serie($conecta, $id_serie, $valor)
{
    //consultar nome da subcategoria
    $update = "UPDATE `tb_serie` SET `cl_valor`= '$valor' where cl_id = '$id_serie'";
    $update_serie = mysqli_query($conecta, $update);
    if ($update_serie) {
        return true;
    } else {
        return false;
    }
}

//funcao para atualizar valor em serie
function atualizar_valor_serie($conecta, $id, $valor)
{
    //consultar nome da subcategoria
    $update = "UPDATE `tb_serie` SET `cl_valor`= '$valor' where cl_id = $id";
    $update_serie = mysqli_query($conecta, $update);
    if ($update_serie) {
        return true;
    } else {
        return false;
    }
}
//funcao para atualizar valor em serie
function verifcar_descricao_serie($conecta, $id)
{
    //consultar nome da subcategoria
    $select = "SELECT * from tb_serie where cl_id = $id ";
    $consulta_serie = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consulta_serie);
    $valor = $linha['cl_descricao'];
    return $valor;
}

//consultar se já existe um parceiro cadastrado no sistema com o mesmo cnpj que não seja ele propio
function consultar_cnpj_cadastrado($conecta, $cnpjcpf, $id_cliente)
{
    //verifiar se o campo está vazio
    if ($cnpjcpf != "") {
        $select = "SELECT count(*) as qtd from tb_parceiros where cl_cnpj_cpf = '$cnpjcpf' and cl_id != $id_cliente ";
        $consulta_tabela = mysqli_query($conecta, $select);
        $linha = mysqli_fetch_assoc($consulta_tabela);
        $qtd_encontrados = $linha["qtd"];
        return $qtd_encontrados;
    } else {
        return 0;
    }
}
//formatar cnpj
function formatCNPJCPF($cnpjcpf)
{
    $cnpjcpf = preg_replace("/[^0-9]/", "", $cnpjcpf); // Remove tudo que não é número
    if (strlen($cnpjcpf) == "14") { //formatar para cnpj
        $cnpjcpf = str_pad($cnpjcpf, 14, '0', STR_PAD_LEFT); // Completa com zeros à esquerda até 14 dígitos

        $cnpjFormatado = substr($cnpjcpf, 0, 2) . '.'; // Adiciona o primeiro ponto
        $cnpjFormatado .= substr($cnpjcpf, 2, 3) . '.'; // Adiciona o segundo ponto
        $cnpjFormatado .= substr($cnpjcpf, 5, 3) . '/'; // Adiciona a barra
        $cnpjFormatado .= substr($cnpjcpf, 8, 4) . '-'; // Adiciona o hífen
        $cnpjFormatado .= substr($cnpjcpf, 12); // Adiciona os últimos 2 dígitos

        return $cnpjFormatado;
    } elseif (strlen($cnpjcpf) == "11") { //formatar para cpf
        $cnpjcpf = preg_replace("/[^0-9]/", "", $cnpjcpf); // Remove tudo que não é número
        $cnpjcpf = str_pad($cnpjcpf, 11, '0', STR_PAD_LEFT); // Completa com zeros à esquerda até 11 dígitos

        $cpfFormatado = substr($cnpjcpf, 0, 3) . '.'; // Adiciona o primeiro ponto
        $cpfFormatado .= substr($cnpjcpf, 3, 3) . '.'; // Adiciona o segundo ponto
        $cpfFormatado .= substr($cnpjcpf, 6, 3) . '-'; // Adiciona o hífen
        $cpfFormatado .= substr($cnpjcpf, 9); // Adiciona os últimos 2 dígitos

        return $cpfFormatado;
    } else {
        return $cnpjcpf;
    }
}


//consultar qualuer tabela do bd
function consulta_tabela($conecta, $tabela, $coluna_filtro, $valor, $coluna_valor)
{
    $select = "SELECT * from $tabela where $coluna_filtro = '$valor' ";
    $consulta_tabela = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consulta_tabela);
    $valor = $linha["$coluna_valor"];
    return $valor;
}
//  Em PHP, você pode usar a função ctype_alpha para verificar se um caractere é uma 
//letra e a função strtoupper para transformar uma letra em maiúscula.
//   Aqui está uma função que verifica se um caractere é uma letra e, se for, converte-o em maiúscu
function uppercaseLetter($char)
{
    if (ctype_alpha($char)) {
        return strtoupper($char);
    } else {
        return $char;
    }
}


function validaCPF($cpf)
{
    // Elimina possivel mascara
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    // Verifica se o numero de digitos informados é igual a 11
    if (strlen($cpf) != 11) {
        return false;
    }
    // Verifica se nenhuma das sequências invalidas abaixo
    // foi digitada. Caso afirmativo, retorna falso
    else if (
        $cpf == '00000000000' ||
        $cpf == '11111111111' ||
        $cpf == '22222222222' ||
        $cpf == '33333333333' ||
        $cpf == '44444444444' ||
        $cpf == '55555555555' ||
        $cpf == '66666666666' ||
        $cpf == '77777777777' ||
        $cpf == '88888888888' ||
        $cpf == '99999999999'
    ) {
        return false;
        // Calcula os digitos verificadores para verificar se o CPF é válido
    } else {
        for ($i = 9; $i < 11; $i++) {
            $j = 0;
            $soma = 0;
            for ($j = 0; $j < $i; $j++) {
                $soma += $cpf{
                    $j} * (($i + 1) - $j);
            }
            $resto = $soma % 11;
            if ($resto < 2) {
                $dg = 0;
            } else {
                $dg = 11 - $resto;
            }
            if ($cpf{
                $i} != $dg) {
                return false;
            }
        }
        return true;
    }
}

//validar cnpj
function validarCNPJ($cnpj)
{
    // Remove caracteres especiais
    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

    // Verifica se o CNPJ possui 14 dígitos
    if (strlen($cnpj) != 14) {
        return false;
    }

    // Verifica se todos os dígitos são iguais
    if (preg_match('/(\d)\1{13}/', $cnpj)) {
        return false;
    }

    // Verifica o primeiro dígito verificador
    $soma = 0;
    for ($i = 0; $i < 12; $i++) {
        $soma += intval($cnpj[$i]) * (($i < 4) ? 5 - $i : 13 - $i);
    }
    $digito1 = (($soma % 11) < 2) ? 0 : 11 - ($soma % 11);
    if ($cnpj[12] != $digito1) {
        return false;
    }

    // Verifica o segundo dígito verificador
    $soma = 0;
    for ($i = 0; $i < 13; $i++) {
        $soma += intval($cnpj[$i]) * (($i < 5) ? 6 - $i : 14 - $i);
    }
    $digito2 = (($soma % 11) < 2) ? 0 : 11 - ($soma % 11);
    if ($cnpj[13] != $digito2) {
        return false;
    }

    // Se chegou até aqui, o CNPJ é válido
    return true;
}



//formatar para moeda real
function real_format($valor)
{
    $valor  = number_format($valor, 2, ",", ".");
    return "R$ " . $valor;
}


//verificar se tem virgula na string
function verificaVirgula($valor)
{
    if (strpos($valor, ',') !== false) {
        // echo "A string contém uma vírgula.";
        return true;
    } else {
        // echo "A string não contém uma vírgula.";
        return false;
    }
}

//substituir uma virgula por um ponto
function formatDecimal($valor)
{
    $string_com_virgula = $valor;
    $string_com_ponto = str_replace(",", ".", $string_com_virgula);
    return $string_com_ponto;
}


function verifica_status_caixa($conecta, $consultar_tipo_contabilizacao, $dia, $mes, $ano, $conta_financeira)
{
    $select = "SELECT * FROM tb_caixa where cl_ano !='' and cl_conta ='$conta_financeira'";
    if ($consultar_tipo_contabilizacao == "DIA") {
        $select .= " and cl_dia = '$dia' and cl_mes ='$mes' and cl_ano='$ano' "; // se for por periodo de contabilização em dia a dia vai verifiar o dia, o mes e o ano
    } elseif ($consultar_tipo_contabilizacao == "MES") {
        $select .= " and cl_mes = '$mes' and cl_ano ='$ano'"; // se for por periodo de contabilização em mes a mes vai verifiar o mes e o ano
    } else {
        $select .= " and cl_dia = '$dia' and cl_mes ='$mes' and cl_ano='$ano' "; // se o paramentro estivir com valor incorreto será atribuido o periodo de dia a dia
    }
    $consulta_caixa = mysqli_query($conecta, $select);
    $resultado_consulta = mysqli_num_rows($consulta_caixa);
    $linha = mysqli_fetch_assoc($consulta_caixa);

    $status_caixa = $linha['cl_status'];
    $valor_aberto = $linha['cl_valor_abertura'];
    $dados = array("resultado" => $resultado_consulta, "status" => $status_caixa, "valor_aberto" => $valor_aberto);
    return $dados;
}

function verifica_saldo_final($conecta, $consultar_tipo_contabilizacao, $dia, $mes, $ano, $conta_financeira)
{


    // $ultimo_dia_mes_atual = date("t", strtotime(date("$ano-$mes-d")));
    $data = ("$dia-$mes-$ano");
    $ultimo_dia_mes_anterior = date('t', strtotime('-1 month', strtotime($data))); // pegar o ultimo dia do mes anterior
    $mes_anterior = date('m', strtotime('-1 month', strtotime($data))); //pegar o mes anterior
    $dia_anerior = date('d', strtotime('-1 day', strtotime($data))); //pegar o dia anterior


    $select = "SELECT * FROM tb_caixa where cl_ano !='' and cl_conta = '$conta_financeira' ";
    if ($consultar_tipo_contabilizacao == "DIA") {
        if ($mes == "01" and $dia == "01") { //se for primeiro dia do ano vai verificar o ultimo dia do mes anterior
            $dia = 31;
            $ano = $ano - 1;
            $mes = 12;
        } elseif ($dia == "01") { //se for primerio dia de cada mes, vai verificar o saldo do ultimo dia do mes anterior
            $dia = "$ultimo_dia_mes_anterior";
            $mes = "$mes_anterior";
        } else { //se for um dia qualquer verificar o dia anterior
            $dia = $dia_anerior;
        }
        $select .= " and cl_dia = '$dia' and cl_mes = '$mes' and cl_ano='$ano' "; // se for por periodo de contabilização em dia a dia vai verifiar o dia, o mes e o ano
    } elseif ($consultar_tipo_contabilizacao == "MES") {
        if ($mes == "01") {
            $ano = $ano - 1;
            $mes = 12;
        } else {
            $mes = $mes_anterior;
        }
        $select .= " and cl_mes = '$mes' and cl_ano ='$ano'"; // se for por periodo de contabilização em mes a mes vai verifiar o mes e o ano
    }
    $consulta_caixa = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consulta_caixa);
    $saldo_fechado = $linha['cl_valor_fechamento'];
    return $saldo_fechado;
}

//função para verificar os parametros do caixa do periodo
function verifica_caixa_financeiro($conecta, $data_pagamento, $conta_financeira)
{
    $select = "SELECT * FROM tb_parametros where cl_id = '6'";
    $conulta_parametros = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($conulta_parametros);
    $consultar_tipo_contabilizacao = $linha['cl_valor'];

    // Divide a data em partes
    $partes = explode('-', $data_pagamento);
    // Extrai o ano, o mês e o dia
    $ano = $partes[0];
    $mes = $partes[1];
    $dia = $partes[2];


    $select = "SELECT * FROM tb_caixa where cl_ano !='' and cl_conta ='$conta_financeira'";
    if ($consultar_tipo_contabilizacao == "DIA") {
        $select .= " and cl_dia = '$dia' and cl_mes ='$mes' and cl_ano='$ano' "; // se for por periodo de contabilização em dia a dia vai verifiar o dia, o mes e o ano
    } elseif ($consultar_tipo_contabilizacao == "MES") {
        $select .= " and cl_mes = '$mes' and cl_ano ='$ano'"; // se for por periodo de contabilização em mes a mes vai verifiar o mes e o ano
    } else {
        $select .= " and cl_dia = '$dia' and cl_mes ='$mes' and cl_ano='$ano' "; // se o paramentro estivir com valor incorreto será atribuido o periodo de dia a dia
    }
    $consulta_caixa = mysqli_query($conecta, $select);
    $resultado_consulta = mysqli_num_rows($consulta_caixa);
    $linha = mysqli_fetch_assoc($consulta_caixa);
    $status_caixa = $linha['cl_status'];
    $valor_aberto = $linha['cl_valor_abertura'];

    $dados = array("resultado" => $resultado_consulta, "status" => $status_caixa, "valor_aberto" => $valor_aberto);
    return $dados;
}

function validar_usuario($conecta, $id_usuario, $senha)
{ //validar usuario
    $senha = base64_encode($senha); //criptografar a senha
    $select = "SELECT * FROM tb_users where cl_id ='$id_usuario' and cl_senha ='$senha'";
    $consulta_usuario = mysqli_query($conecta, $select);
    $valida = mysqli_num_rows($consulta_usuario);

    if ($valida > 0) { //validado usuario
        return true;
    } else { //não foi validado
        return false;
    }
}


function recebimento_nf_recebida($conecta, $fpg_id, $data, $serie_nf, $numero_nf, $parceiro_id, $classificacao, $valor, $documento, $codigo_nf) //verificar se a forma de pagamento é com stauts recebido se for realizar o lançamento financeiro
{
    $select = "SELECT * FROM tb_forma_pagamento where cl_id = $fpg_id ";
    $consulta_forma_pagamento = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consulta_forma_pagamento);
    $status_id = $linha['cl_status_id'];
    $conta_financeira = $linha['cl_conta_financeira'];
    if ($status_id == "2") {
        $descricao = utf8_decode("Recebimento referente a $serie_nf $numero_nf");
        $insert = "INSERT INTO `system_day`.`tb_lancamento_financeiro` (`cl_data_lancamento`, `cl_data_vencimento`,
        `cl_data_pagamento`, `cl_conta_financeira`, `cl_forma_pagamento_id`, `cl_parceiro_id`, `cl_tipo_lancamento`, 
        `cl_status_id`, `cl_valor_bruto`, `cl_valor_liquido`,`cl_documento`, `cl_classificacao_id`, `cl_descricao`, `cl_nf`, `cl_serie_nf`, `cl_codigo_nf` )
         VALUES ('$data', '$data', '$data', '$conta_financeira', '$fpg_id', '$parceiro_id', 'RECEITA', '2', '$valor', '$valor',
          '$documento', '$classificacao','$descricao','$numero_nf','$serie_nf','$codigo_nf' )";
        $operacao_insert = mysqli_query($conecta, $insert);
        if ($operacao_insert) {
            return true;
        }
    } else {
        return false;
    }
}

function verifica_desconto_fpg($conecta, $fpg_id)
{
    if ($fpg_id != "") {
        $select = "SELECT * FROM tb_forma_pagamento where cl_id = $fpg_id ";
        $consulta_forma_pagamento = mysqli_query($conecta, $select);
        $linha = mysqli_fetch_assoc($consulta_forma_pagamento);
        $desconto_maximo = $linha['cl_desconto_maximo'];

        return $desconto_maximo;
    } else {
        return 0;
    }
}
//verificar se doc está repetido
function verifica_repeticao_doc($conecta, $tabela, $filtro1, $filtro2, $valor1, $valor2)
{
    $select = "SELECT count(*) as repetiacao FROM $tabela where $filtro1 = '$valor1' and $filtro2 = '$valor2' ";
    $consulta_repeticao_doc = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consulta_repeticao_doc);
    $repeticao = $linha['repetiacao'];
    if ($repeticao > 0) {
        return true;
    } else {
        return false;
    }
}


//função para retornar o ultimo id de uma tabela
function retornar_ultimo_id($conecta, $tabela)
{
    //pegar o id do ultimo produto cadastrado
    $select = "SELECT max(cl_id) as id from $tabela";
    $consultar_produto = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consultar_produto);
    $id_b = $linha['id'];
    return $id_b;
}

function validar_prod_venda($conecta, $id_produto, $retorno)
{
    //pegar o id do ultimo produto cadastrado
    $select = "SELECT * from tb_produtos where cl_id =$id_produto ";
    $consultar_produto = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consultar_produto);
    $valor = $linha["$retorno"];
    return $valor;
}

function validar_qtd_prod_venda($conecta, $id_produto, $codigo_nf, $quantidade)
{
    $select = " SELECT sum(cl_quantidade) as qtd from tb_nf_saida_item where cl_item_id = '$id_produto' and cl_codigo_nf ='$codigo_nf' ";
    $consultar_produto = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consultar_produto);
    $valor = $linha["qtd"];
    $total = $valor + $quantidade;
    return $total;
}
function valores_prod_nf($conecta, $codigo_nf)
{
    $select = "SELECT sum(cl_valor_total) as vlr_total from tb_nf_saida_item where cl_codigo_nf ='$codigo_nf' ";
    $consultar_vlr_produto = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consultar_vlr_produto);
    $valor = $linha["vlr_total"];
    return $valor;
}
function finalizar_produtos_nf($conecta, $codigo_nf, $serie_vnd, $numero_nf, $desconto, $data, $parceiro_id, $id_usuario_logado, $forma_pagamento_id)
{
    $ordem_item = 0;

    $select = "SELECT * from tb_nf_saida_item where cl_codigo_nf ='$codigo_nf' ";
    $consultar_produto_nf = mysqli_query($conecta, $select);
    $qtd_prod = mysqli_num_rows($consultar_produto_nf);

    if ($desconto != "0") {
        $desconto_rat = $desconto / $qtd_prod; //rateio do desconto
    } else {
        $desconto_rat = 0;
    }

    while ($linha = mysqli_fetch_assoc($consultar_produto_nf)) {
        $id_produto = $linha['cl_item_id'];
        $quantidade_vendida = $linha['cl_quantidade'];
        $prc_venda_unitario = $linha['cl_valor_unitario'];

        $estoque = validar_prod_venda($conecta, $id_produto, "cl_estoque");

        $quantidade_atual = $estoque - $quantidade_vendida;
        $ordem_item = $ordem_item + 1;
        $update = "UPDATE `system_day`.`tb_nf_saida_item` SET `cl_numero_nf` = '$numero_nf', `cl_item_ordem` = '$ordem_item', 
        `cl_desconto_rat` = '$desconto_rat', `cl_status` = '1' WHERE `tb_nf_saida_item`.`cl_codigo_nf` = '$codigo_nf' ";
        $operacao_update = mysqli_query($conecta, $update);
        if ($operacao_update) {
            $update = "UPDATE `system_day`.`tb_produtos` SET `cl_estoque` = '$quantidade_atual' WHERE `tb_produtos`.`cl_id` = $id_produto ";
            $operacao_update_estoque = mysqli_query($conecta, $update);
            //adicionar ao ajuste de estoque
            ajuste_estoque($conecta, $data, "$serie_vnd-$numero_nf", "SAIDA", $id_produto, $quantidade_vendida, "1", $parceiro_id, $id_usuario_logado, $forma_pagamento_id, $prc_venda_unitario, "0", '0', '', "$codigo_nf");
        }
    };
}

function consulta_parceiro($conecta, $parceiro_id, $filtro_valor)
{
    $select = "SELECT * from tb_parceiros where cl_id = $parceiro_id ";
    $consultar_parceiro = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consultar_parceiro);
    $valor = $linha["$filtro_valor"];
    return $valor;
}


function calcularPorcentagemDesconto($valorUnitario, $valorAtual)
{
    $porcentagemDesconto = (($valorAtual - $valorUnitario) / $valorAtual) * 100;
    return  number_format($porcentagemDesconto, 2);
}
function qtd_ajst($conecta, $codigo_nf)
{
    $select = "SELECT * from tb_ajuste_estoque where cl_codigo_nf ='$codigo_nf'";
    $consultar_ajuste_estoque = mysqli_query($conecta, $select);
    $qtd = mysqli_num_rows($consultar_ajuste_estoque);
    return $qtd;
}

function verificar_data_ajst($conecta, $codigo_nf)
{
    $select = "SELECT * from tb_ajuste_estoque where cl_codigo_nf ='$codigo_nf' ";
    $consultar_ajuste_estoque = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consultar_ajuste_estoque);
    $data_lancamento = $linha['cl_data_lancamento'];
    return $data_lancamento;
}


function recebimento_nf($conecta, $fpg_id, $data, $serie_nf, $numero_nf, $parceiro_id, $classificacao, $valor, $documento, $codigo_nf) //receber a venda manualmente
{
    $select = "SELECT * FROM tb_forma_pagamento where cl_id = $fpg_id ";
    $consulta_forma_pagamento = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consulta_forma_pagamento);
    $conta_financeira = $linha['cl_conta_financeira'];

    $descricao = utf8_decode("Recebimento  referente a $serie_nf $numero_nf");
    $insert = "INSERT INTO `system_day`.`tb_lancamento_financeiro` (`cl_data_lancamento`, `cl_data_vencimento`,
        `cl_data_pagamento`, `cl_conta_financeira`, `cl_forma_pagamento_id`, `cl_parceiro_id`, `cl_tipo_lancamento`, 
        `cl_status_id`, `cl_valor_bruto`, `cl_valor_liquido`,`cl_documento`, `cl_classificacao_id`, `cl_descricao`, `cl_nf`, `cl_serie_nf`, `cl_codigo_nf` )
         VALUES ('$data', '$data', '$data', '$conta_financeira', '$fpg_id', '$parceiro_id', 'RECEITA', '2', '$valor', '$valor',
          '$documento', '$classificacao','$descricao','$numero_nf','$serie_nf','$codigo_nf' )";
    $operacao_insert = mysqli_query($conecta, $insert);
    if ($operacao_insert) {
        return true;
    }
}

function update_status_nf($conecta, $status, $data_recebimento, $usuario_recebimento, $nf_id, $forma_pagamento)
{

    if ($status == 2) { //recebido
        $data_recebimento = $data_recebimento;
        $usuario_recebimento = $usuario_recebimento;
        $forma_pagamento = $forma_pagamento;
    } else {
        $data_recebimento = "";
        $usuario_recebimento = "";
        $forma_pagamento = "";
    }
    $update = "UPDATE `system_day`.`tb_nf_saida` SET `cl_status_recebimento` = '$status', 
    `cl_data_recebimento` = '$data_recebimento', `cl_usuario_id_recebimento` = '$usuario_recebimento',`cl_forma_pagamento_id` = '$forma_pagamento' WHERE `tb_nf_saida`.`cl_id` = $nf_id ";
    $operacao_update = mysqli_query($conecta, $update);
    if ($operacao_update) {
        return true;
    }
}

function delete_item_nf($conecta, $id_item_nf, $produto_id, $codigo_nf, $quantidade, $id_user_logado, $data)
{
    $estoque = (consulta_tabela($conecta, "tb_produtos", "cl_id", $produto_id, "cl_estoque")); //verificar o estoque atual do produto
    $nome_usuario_logado = (consulta_tabela($conecta, "tb_users", "cl_id", $id_user_logado, "cl_usuario")); //Nome do usuário que está removendo o produto da venda
    $numero_nf = (consulta_tabela($conecta, "tb_nf_saida", "cl_codigo_nf", $codigo_nf, "cl_numero_nf")); //numero da venda
    $serie_nf = (consulta_tabela($conecta, "tb_nf_saida", "cl_codigo_nf", $codigo_nf, "cl_serie_nf")); //serie nf

    $select = "SELECT * from tb_ajuste_estoque where cl_produto_id ='$produto_id'
    and cl_codigo_nf= '$codigo_nf' and cl_quantidade ='$quantidade' ";
    $consultar_ajst = mysqli_query($conecta, $select);
    $qtd_registros = mysqli_num_rows($consultar_ajst); //verificar se o ajuste feito apos a finalização da venda está no ajuste de estoque
    if ($qtd_registros > 0) { //se tiver registro na tabela ajuste de estoque, atualizar o status para cancelado
        $update = "UPDATE `system_day`.`tb_ajuste_estoque` SET `cl_status` = 'cancelado' 
       WHERE `tb_ajuste_estoque`.`cl_produto_id` = '$produto_id' and  cl_codigo_nf='$codigo_nf' ";
        $operacao_update  = mysqli_query($conecta, $update);
        if ($operacao_update) { //deletar produto da nf
            $delete = "DELETE FROM `system_day`.`tb_nf_saida_item` WHERE `tb_nf_saida_item`.`cl_id` = $id_item_nf ";
            $operacao_delete = mysqli_query($conecta, $delete);
            if ($operacao_delete) { //atualizar o estoque do produto 
                $novo_estoque = $estoque + $quantidade;
                $update = "UPDATE `system_day`.`tb_produtos` SET `cl_estoque` = '$novo_estoque' 
                WHERE `tb_produtos`.`cl_id` = '$produto_id' ";
                $operacao_update = mysqli_query($conecta, $update);
                if ($operacao_update) {
                    if (recalcular_valor_nf($conecta, $codigo_nf)) { //atualizar valor total da nota
                        $mensagem = utf8_decode("Usuário $nome_usuario_logado removeu $quantidade produto(s) de código $produto_id, $serie_nf  $numero_nf");
                        registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    } else { //remover apenas da venda, a vennda ainda não foi finalizada
        $delete = "DELETE FROM `system_day`.`tb_nf_saida_item` WHERE `tb_nf_saida_item`.`cl_id` = $id_item_nf ";
        $operacao_delete = mysqli_query($conecta, $delete);
        if ($operacao_delete) {
            return true;
        } else {
            return false;
        }
    }
}



function verificar_status_recebimento_vnd($conecta, $id, $codigo_nf)
{ //verificar se a venda já está recebida
    $select = "SELECT * from tb_nf_saida where cl_id =$id and codigo_nf= '$codigo_nf' ";
    $consultar_status_recebiento = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consultar_status_recebiento);
    $status_recebimento = $linha['cl_status_recebimento'];
    if ($status_recebimento == "2") { //pendente
        return true;
    } else {
        return false;
    }
}

function recalcular_valor_nf($conecta, $codigo_nf)
{ //atualizar valor bruto e liquido da nf

    $select = "SELECT * from tb_nf_saida where cl_codigo_nf ='$codigo_nf' ";
    $consultar_nf = mysqli_query($conecta, $select);
    $qtd_nf = mysqli_num_rows($consultar_nf);

    if ($qtd_nf > 0) { //verificar se existe uma nf já feita
        $valor_desconto = (consulta_tabela($conecta, "tb_nf_saida", "cl_codigo_nf", $codigo_nf, "cl_valor_desconto")); //verificar o estoque atual do produto

        $select = "SELECT sum(cl_valor_total) as valor from tb_nf_saida_item where cl_codigo_nf ='$codigo_nf' and cl_status ='1' ";
        $consultar_produto_nf = mysqli_query($conecta, $select);
        $linha = mysqli_fetch_assoc($consultar_produto_nf);
        $valor_bruto = $linha['valor'];

        $valor_liquido = $valor_bruto - $valor_desconto;

        $update = "UPDATE `system_day`.`tb_nf_saida` SET `cl_valor_bruto` = '$valor_bruto',`cl_valor_liquido` = '$valor_liquido' WHERE `tb_nf_saida`.`cl_codigo_nf` = '$codigo_nf' ";
        $operacao_update_nf = mysqli_query($conecta, $update);
        if ($operacao_update_nf) {
            return true;
        } else {
            return false;
        }
        //adicionar ao ajuste de estoque
    }
}


function cancelar_nf($conecta, $id_nf, $codigo_nf, $id_user_logado, $data)
{
    // $estoque = (consulta_tabela($conecta, "tb_produtos", "cl_id", $produto_id, "cl_estoque")); //verificar o estoque atual do produto
    $nome_usuario_logado = (consulta_tabela($conecta, "tb_users", "cl_id", $id_user_logado, "cl_usuario")); //Nome do usuário que está removendo o produto da venda
    $numero_nf = (consulta_tabela($conecta, "tb_nf_saida", "cl_codigo_nf", $codigo_nf, "cl_numero_nf")); //numero da venda
    $serie_nf = (consulta_tabela($conecta, "tb_nf_saida", "cl_codigo_nf", $codigo_nf, "cl_serie_nf")); //serie nf



    $select = "SELECT * FROM `system_day`.`tb_nf_saida_item` WHERE `tb_nf_saida_item`.`cl_codigo_nf` = '$codigo_nf' ";
    $consultar_nf_saida_item = mysqli_query($conecta, $select);
    $qtd_nf_saida_item = mysqli_num_rows($consultar_nf_saida_item);

    $select = "SELECT * FROM `system_day`.`tb_lancamento_financeiro` WHERE `tb_lancamento_financeiro`.`cl_codigo_nf` = '$codigo_nf' ";
    $consultar_lancamento_financeiro = mysqli_query($conecta, $select);
    $qtd_lancamento_financeiro = mysqli_num_rows($consultar_nf_saida_item);

    $select = "SELECT * FROM `system_day`.`tb_nf_saida` WHERE `tb_nf_saida`.`cl_codigo_nf` = '$codigo_nf' ";
    $consultar_nf_saida = mysqli_query($conecta, $select);
    $qtd_nf_saida = mysqli_num_rows($consultar_nf_saida);
    if ($qtd_nf_saida > 0) { //atualizar o status da nf_saida para cancelado
        $update = "UPDATE `system_day`.`tb_nf_saida` SET `cl_status_venda` = '3' 
        WHERE `tb_nf_saida`.`cl_codigo_nf` = '$codigo_nf' and  cl_id='$id_nf' ";
        $operacao_update  = mysqli_query($conecta, $update);
        if ($operacao_update) {
            if ($qtd_nf_saida_item > 0) {
                while ($linha = mysqli_fetch_assoc($consultar_nf_saida_item)) {
                    $id_item_nf = $linha['cl_id'];
                    $produto_id = $linha['cl_item_id'];
                    $quantidade = $linha['cl_quantidade'];
                    $estoque = (consulta_tabela($conecta, "tb_produtos", "cl_id", $produto_id, "cl_estoque")); //verificar o estoque atual do produto
                    $novo_estoque = $estoque + $quantidade;

                    $update = "UPDATE `system_day`.`tb_nf_saida_item` SET `cl_status` = '3' 
                WHERE `tb_nf_saida_item`.`cl_id` = '$id_item_nf' and  cl_codigo_nf='$codigo_nf' ";
                    $operacao_update  = mysqli_query($conecta, $update); //atualizar o status dos itens na tabela nf_saida_item para cancelado
                    if ($operacao_update) { //atualizar para cancelado o ajuste de estoque
                        $update = "UPDATE `system_day`.`tb_ajuste_estoque` SET `cl_status` = 'cancelado' 
                        WHERE `tb_ajuste_estoque`.`cl_produto_id` = '$produto_id' and  cl_codigo_nf='$codigo_nf' and cl_quantidade ='$quantidade' ";
                        $operacao_update  = mysqli_query($conecta, $update);
                        if ($operacao_update) { //atualizar o estoque
                            $update = "UPDATE `system_day`.`tb_produtos` SET `cl_estoque` = '$novo_estoque' 
                            WHERE `tb_produtos`.`cl_id` = '$produto_id' ";
                            $operacao_update  = mysqli_query($conecta, $update);
                            if (!$operacao_update) {
                                return false;
                                break;
                            }
                        } else {
                            return false;
                            break;
                        }
                    } else {
                        return false;
                        break;
                    }
                }
            }
            if ($qtd_lancamento_financeiro > 0) {
                $delete = "DELETE FROM `system_day`.`tb_lancamento_financeiro` WHERE `tb_lancamento_financeiro`.`cl_codigo_nf` = '$codigo_nf'";
                $operacao_delete  = mysqli_query($conecta, $delete);
                if (!$operacao_delete) { //deletar o recebimento da venda
                    return false;
                }
            }
            $mensagem = utf8_decode("Usuário $nome_usuario_logado cancelou a $serie_nf $numero_nf ");
            registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);

            return true;
        } else {
            return false;
        }
    }
}

function remover_nf_faturamento($conecta, $id, $codigo_nf, $id_user_logado, $data)
{ //verificar se a venda já está recebida

    $nome_usuario_logado = (consulta_tabela($conecta, "tb_users", "cl_id", $id_user_logado, "cl_usuario")); //Nome do usuário que está removendo o produto da venda
    $numero_nf = (consulta_tabela($conecta, "tb_nf_saida", "cl_codigo_nf", $codigo_nf, "cl_numero_nf")); //numero da venda
    $serie_nf = (consulta_tabela($conecta, "tb_nf_saida", "cl_codigo_nf", $codigo_nf, "cl_serie_nf")); //serie nf


    $update = "UPDATE `system_day`.`tb_nf_saida` SET `cl_status_recebimento` = '1' 
    WHERE `tb_nf_saida`.`cl_id` = '$id' and cl_codigo_nf ='$codigo_nf' ";
    $operacao_update  = mysqli_query($conecta, $update);
    if ($operacao_update) {
        $delete = "DELETE FROM `system_day`.`tb_lancamento_financeiro` WHERE `tb_lancamento_financeiro`.`cl_codigo_nf` = '$codigo_nf'";
        $operacao_delete  = mysqli_query($conecta, $delete);
        if ($operacao_delete) {
            $mensagem = utf8_decode("Usuário $nome_usuario_logado removeu a $serie_nf $numero_nf do faturamento ");
            registrar_log($conecta, $nome_usuario_logado, $data, $mensagem);

            return true;
        } else {
            return false;
        }
    }
}


function atualizar_status_produto_adicional($conecta, $produto_adicional_id, $produto_id, $acao, $ischeck) //funcão referente ao adicional do delivery no produto
{
    $select = "SELECT * from tb_produto_adicional_delivery WHERE cl_produto_adicional_id ='$produto_adicional_id' and cl_produto_id ='$produto_id'
     and cl_obrigatorio ='NAO' "; //tipo adicinou poara delivery
    $consultar_adicionais = mysqli_query($conecta, $select);
    $qtd_consultar_adicionais = mysqli_num_rows($consultar_adicionais);
    if ($qtd_consultar_adicionais > 0) {
        $linha = mysqli_fetch_assoc($consultar_adicionais);
        $id = $linha['cl_id'];
        $status = $linha['cl_status_ativo'];

        if ($status == "NAO" and $acao == "INCLUIR") {
            $update = "UPDATE `system_day`.`tb_produto_adicional_delivery` SET `cl_status_ativo` = 'SIM' 
    WHERE `tb_produto_adicional_delivery`.`cl_id` = '$id' ";
            $operacao_update  = mysqli_query($conecta, $update);
        } elseif ($status == "SIM" and $acao == "REMOVER") {
            $update = "UPDATE `system_day`.`tb_produto_adicional_delivery` SET `cl_status_ativo` = 'NAO' 
            WHERE `tb_produto_adicional_delivery`.`cl_id` = '$id' ";
            $operacao_update  = mysqli_query($conecta, $update);
        }
    } else {
        if ($ischeck == 'CHECK') {
            $insert = "INSERT INTO `system_day`.`tb_produto_adicional_delivery` (`cl_produto_adicional_id`, `cl_produto_id`,
            `cl_status_ativo`, `cl_obrigatorio`) VALUES ('$produto_adicional_id', '$produto_id', 'SIM', 'NAO') ";
            $operacao_inserir  = mysqli_query($conecta, $insert);
        }
    }
}


function verifica_status_produto_adicional($conecta, $produto_adicional_id, $produto_id) //funcão referente ao adicional do delivery no produto
{
    $select = "SELECT * from tb_produto_adicional_delivery WHERE cl_produto_adicional_id ='$produto_adicional_id' and cl_produto_id ='$produto_id' and cl_obrigatorio ='NAO' "; //tipo adicinou poara delivery
    $consultar_adicionais = mysqli_query($conecta, $select);
    $qtd_consultar_adicionais = mysqli_num_rows($consultar_adicionais);
}

function atualizar_status_produto_adicional_obrigatorio($conecta, $produto_adicional_id, $produto_id, $acao, $ischeck) //funcão referente ao adicional do delivery no produto
{
    $select = "SELECT * from tb_produto_adicional_delivery WHERE cl_produto_adicional_id ='$produto_adicional_id' and cl_produto_id ='$produto_id' and cl_obrigatorio ='SIM' "; //tipo adicinou poara delivery
    $consultar_adicionais = mysqli_query($conecta, $select);
    $qtd_consultar_adicionais = mysqli_num_rows($consultar_adicionais);
    if ($qtd_consultar_adicionais > 0) {
        $linha = mysqli_fetch_assoc($consultar_adicionais);
        $id = $linha['cl_id'];
        $status = $linha['cl_status_ativo'];

        if ($status == "NAO" and $acao == "INCLUIR") {
            $update = "UPDATE `system_day`.`tb_produto_adicional_delivery` SET `cl_status_ativo` = 'SIM' 
    WHERE `tb_produto_adicional_delivery`.`cl_id` = '$id' ";
            $operacao_update  = mysqli_query($conecta, $update);
        } elseif ($status == "SIM" and $acao == "REMOVER") {
            $update = "UPDATE `system_day`.`tb_produto_adicional_delivery` SET `cl_status_ativo` = 'NAO' 
            WHERE `tb_produto_adicional_delivery`.`cl_id` = '$id' ";
            $operacao_update  = mysqli_query($conecta, $update);
        }
    } else {
        if ($ischeck == 'CHECK') {
            $insert = "INSERT INTO `system_day`.`tb_produto_adicional_delivery` (`cl_produto_adicional_id`, `cl_produto_id`,
         `cl_status_ativo`, `cl_obrigatorio`) VALUES ('$produto_adicional_id', '$produto_id', 'SIM', 'SIM') ";
            $operacao_inserir  = mysqli_query($conecta, $insert);
        }
    }
}


function verifica_status_produto_adicional_obrigatorio($conecta, $produto_adicional_id, $produto_id) //funcão referente ao adicional do delivery no produto
{
    $select = "SELECT * from tb_produto_adicional_delivery WHERE cl_produto_adicional_id ='$produto_adicional_id' and cl_produto_id ='$produto_id' and cl_obrigatorio ='SIM' "; //tipo adicinou poara delivery
    $consultar_adicionais = mysqli_query($conecta, $select);
    $qtd_consultar_adicionais = mysqli_num_rows($consultar_adicionais);
}


function insert_produto_cotacao(
    $conecta,
    $data_lancamento,
    $codigo_nf,
    $cl_vendedor_id,
    $item_id,
    $descricao_item,
    $referencia,
    $quantidade,
    $unidade,
    $valor_unitario,
    $desconto_item,
    $valor_total,
    $prazo_entrega,
    $status_item
) {
    $insert = "INSERT INTO `system_day`.`tb_cotacao_item` (`cl_data_movimento`, `cl_codigo_nf`, `cl_vendedor_id`,
 `cl_item_id`, `cl_descricao_item`, `cl_referencia`, `cl_quantidade`, `cl_unidade`, `cl_valor_unitario`, `cl_desconto_item`,
  `cl_valor_total`, `cl_prazo_entrega`, `cl_status_item_id`)VALUES ('$data_lancamento', '$codigo_nf', '$cl_vendedor_id', '$item_id', '$descricao_item', '$referencia', '$quantidade', 
  '$unidade', '$valor_unitario', '$desconto_item', '$valor_total', '$prazo_entrega', '$status_item')";
    $operacao_insert = mysqli_query($conecta, $insert);
    if ($operacao_insert) {
        return true;
    } else {
        return false;
    }
}

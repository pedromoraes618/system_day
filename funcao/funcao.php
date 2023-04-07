<?php
date_default_timezone_set('America/Fortaleza');
$data = date('Y/m/d H:i:s');


$data_lancamento = date('y-m-d');


$data_incial_log = date('01/m/Y');
$data_final_log = date('d/m/Y');

$data_inicial = date('01/m/Y');
$data_final = date('d/m/Y');
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
     entre em contato com o administrador do sistema para obter mais informações.";
}


//mensagem de alerta de serie cadastrada
function mensagem_serie_cadastrada()
{
    return "A serie não está cadastrada, não é possivel realizar a ação, favor verifique com o suporte";
}

//formatar data do banco de dados
function formatDateB($value)
{
    if (($value != "") and ($value != "0000-00-00")) {
        $value = date("d/m/Y", strtotime($value));
        return $value;
    }
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
    $subcategoria_b = $linha['cl_subcategoria'];
    return $subcategoria_b;
}


//funcao para saber qual é o valor da serie
function consultar_serie($conecta, $serie)
{
    //consultar nome da subcategoria
    $select = "SELECT * from tb_serie where cl_descricao = '$serie' ";
    $consulta_serie = mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consulta_serie);
    $valor = $linha['cl_valor'];
    return $valor;
}


//funcao para realizar ajuste de estoque
function ajuste_estoque($conecta, $data, $doc, $tipo, $produto_id, $quantidade, $empresa_id, $usuario_id, $forma_pagamento_id, $valor_venda, $valor_compra, $ajuste_inical, $motivo)
{

    $inset = "INSERT INTO `tb_ajuste_estoque` (`cl_data_lancamento`, `cl_documento`, `cl_produto_id`, `cl_tipo`, `cl_quantidade`, 
    `cl_empresa_id`, `cl_usuario_id`, `cl_forma_pagamento_id`, `cl_valor_venda`, `cl_valor_compra`,`cl_ajuste_inicial`,`cl_status`,`cl_motivo`) VALUES 
    ('$data', '$doc', '$produto_id', '$tipo', '$quantidade', '$empresa_id', '$usuario_id', '$forma_pagamento_id', '$valor_venda', '$valor_compra','$ajuste_inical','ok','$motivo')";
    $operacao_inserir = mysqli_query($conecta, $inset);
    return $operacao_inserir;
}

//funcao para realizar ajuste na quantidade do produto
function ajuste_qtd_produto($conecta, $produto_id, $quantidade)
{

    $update = "UPDATE `tb_produtos` SET `cl_estoque`= $quantidade where cl_id = $produto_id";
    $operacao_update = mysqli_query($conecta, $update);
    return $operacao_update;
}


//funcao para atualizar valor em serie
function adicionar_valor_serie($conecta, $serie, $valor)
{
    //consultar nome da subcategoria
    $update = "UPDATE `tb_serie` SET `cl_valor`= '$valor' where cl_descricao = '$serie'";
    $update_serie = mysqli_query($conecta, $update);
    if ($update_serie) {
        return true;
    } else {
        return false;
    }
}

//consultar se já existe um parceiro cadastrado no sistema com o mesmo cnpj que não seja ele propio
function consultar_cnpj_cadastrado($conecta, $cnpjcpf, $id_cliente)
{   
    //verifiar se o campo está vazio
    if($cnpjcpf !=""){
        $select = "SELECT count(*) as qtd from tb_parceiros where cl_cnpj_cpf = '$cnpjcpf' and cl_id != $id_cliente ";
        $consulta_tabela = mysqli_query($conecta, $select);
        $linha = mysqli_fetch_assoc($consulta_tabela);
        $qtd_encontrados = $linha["qtd"];
        return $qtd_encontrados;
    }else{
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


function verifica_status_caixa($conecta, $consultar_tipo_contabilizacao, $dia, $mes, $ano)
{
    $select = "SELECT * FROM tb_caixa where cl_ano !='' ";
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
    $dados = array("resultado"=>$resultado_consulta,"status"=>$status_caixa,"valor_aberto"=>$valor_aberto);
    return $dados;
}

function verifica_saldo_final($conecta, $consultar_tipo_contabilizacao, $dia, $mes, $ano)
{


    // $ultimo_dia_mes_atual = date("t", strtotime(date("$ano-$mes-d")));
    $data = ("$dia-$mes-$ano");
    $ultimo_dia_mes_anterior = date('t', strtotime('-1 month', strtotime($data))); // pegar o ultimo dia do mes anterior
    $mes_anterior = date('m', strtotime('-1 month', strtotime($data))); //pegar o mes anterior
    $dia_anerior = date('d', strtotime('-1 day', strtotime($data)));//pegar o dia anterior


    $select = "SELECT * FROM tb_caixa where cl_ano !='' ";
    if ($consultar_tipo_contabilizacao == "DIA") {
        if ($mes == "01" and $dia == "01") {//se for primeiro dia do ano vai verificar o ultimo dia do mes anterior
            $dia = 31;
            $ano = $ano - 1;
            $mes = 12;
        } elseif ($dia == "01") { //se for primerio dia de cada mes, vai verificar o saldo do ultimo dia do mes anterior
            $dia = "$ultimo_dia_mes_anterior";
            $mes = "$mes_anterior";
        } else {//se for um dia qualquer verificar o dia anterior
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

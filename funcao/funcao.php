<?php 
date_default_timezone_set('America/Fortaleza');
$data = date('Y/m/d H:i:s');

$data_lancamento = date('y-m-d');

$data_incial_log =date('01/m/Y');
$data_final_log =date('d/m/Y');

$data_inicial=date('01/m/Y');
$data_final=date('d/m/Y');
///formatar data 
function formatarTimeStamp($value){
    $value = date("d/m/Y H:i:s",strtotime($value));
    return $value;
 }
//mensagem de alerta cadastro
function mensagem_alerta_cadastro($campo){
    return "Campo $campo não foi informado, favor verifique!";
}

//mensagem de alerta de permissao
function mensagem_alerta_permissao(){
    return "Ação bloqueada. Você não possui permissão para realizar esta ação no sistema. Por favor, verifique as suas permissões de acesso ou 
     entre em contato com o administrador do sistema para obter mais informações.";
}


//mensagem de alerta de serie cadastrada
function mensagem_serie_cadastrada(){
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

function datecheck($value){
    $d = DateTime::createFromFormat('d/m/Y', $value);
    if($d && $d->format('d/m/Y') == $value){
    return true;
    }else{
    return false;
    }
}

function verificar_user($conecta,$usuario,$acao){
    if($acao =="cadastrar"){
    //verificar se já existe uma pessoa cadastrada com o mesmo usuario
    $select = "SELECT * from tb_users where cl_usuario ='$usuario'";
    $consultar_verficar_user = mysqli_query($conecta,$select);
    $cont = mysqli_num_rows($consultar_verficar_user);
    return $cont;
    }else{
    //verificar se já existe uma pessoa cadastrada com o mesmo usuario diferente do usuario que será alterado
    $select = "SELECT * from tb_users where cl_usuario = '$usuario'";
    $consultar_verficar_user = mysqli_query($conecta,$select);
    $linha = mysqli_fetch_assoc($consultar_verficar_user);
    $id_user_b = $linha['cl_id'];
    return $id_user_b;
    }
}


function verificar_user_usuario($conecta,$id_user){
    //verificar usuario pelo id
    $select = "SELECT * from tb_users where cl_id ='$id_user'";
    $consultar_verficar_user = mysqli_query($conecta,$select);
    $linha = mysqli_fetch_assoc($consultar_verficar_user);
    $usuario_b = $linha['cl_usuario'];
    return $usuario_b;
    
}


//verificar se a opção remover podera ser feita
function verificar_dados_existentes($conecta,$tabela,$filtro,$resultado_filtro){
    //verificar usuario pelo id
    $select = "SELECT count(*) as qtd from $tabela where $filtro ='$resultado_filtro'";
    $consultar_dados_existentes = mysqli_query($conecta,$select);
    $linha = mysqli_fetch_assoc($consultar_dados_existentes);
    $resultado = $linha['qtd'];
    return $resultado;
    
}


//registrar log da acão
function registrar_log($conecta,$nome_usuario_logado,$data,$mensagem){
    $inset = "INSERT INTO tb_log (cl_data_modificacao,cl_usuario,cl_descricao) VALUES ('$data','$nome_usuario_logado','$mensagem')";
    $operacao_inserir = mysqli_query($conecta, $inset);
    return $operacao_inserir;
}
    

function verficar_paramentro($conecta,$tabela,$filtro,$valor){
    $select = "SELECT * from $tabela where $filtro = $valor";
    $consultar_parametros= mysqli_query($conecta, $select);
    $linha = mysqli_fetch_assoc($consultar_parametros);
    $valor_parametro = $linha['cl_valor'];
    return $valor_parametro;
}

//funcao para saber qual usuario foi selecionado para adicionar ou remover acesso
function consultar_usuario_acesso($conecta,$usuario_id){
   //consultar nome do usuario
   $select = "SELECT * from tb_users where cl_id = '$usuario_id' ";
   $consulta_usuario= mysqli_query($conecta,$select);
   $linha = mysqli_fetch_assoc($consulta_usuario);
   $usuario_b = $linha['cl_usuario'];
   return $usuario_b;
}

//funcao para saber qual subcategoria foi selecionado para adicionar ou remover para o usúario
function consultar_subcategoria_acesso($conecta,$id_subcategoria){
   //consultar nome da subcategoria
   $select = "SELECT * from tb_subcategorias where cl_id = '$id_subcategoria' ";
   $consulta_subcategoria= mysqli_query($conecta,$select);
   $linha = mysqli_fetch_assoc($consulta_subcategoria);
   $subcategoria_b = $linha['cl_subcategoria'];
   return $subcategoria_b;
}


//funcao para saber qual é o valor da serie
function consultar_serie($conecta,$serie){
    //consultar nome da subcategoria
    $select = "SELECT * from tb_serie where cl_descricao = '$serie' ";
    $consulta_serie= mysqli_query($conecta,$select);
    $linha = mysqli_fetch_assoc($consulta_serie);
    $valor = $linha['cl_valor'];
    return $valor;
 }


//funcao para realizar ajuste de estoque
function ajuste_estoque($conecta,$data,$doc,$tipo,$produto_id,$quantidade,$empresa_id,$usuario_id,$forma_pagamento_id,$valor_venda,$valor_compra,$ajuste_inical){

    $inset = "INSERT INTO `tb_ajuste_estoque` (`cl_data_lancamento`, `cl_documento`, `cl_produto_id`, `cl_tipo`, `cl_quantidade`, 
    `cl_empresa_id`, `cl_usuario_id`, `cl_forma_pagamento_id`, `cl_valor_venda`, `cl_valor_compra`,`cl_ajuste_inicial`,`cl_status`) VALUES 
    ('$data', '$doc', '$produto_id', '$tipo', '$quantidade', '$empresa_id', '$usuario_id', '$forma_pagamento_id', '$valor_venda', '$valor_compra','$ajuste_inical','ok')";
    $operacao_inserir = mysqli_query($conecta, $inset);
    return $operacao_inserir;
 }


 //funcao para atualizar valor em serie
function adicionar_valor_serie($conecta,$serie,$valor){
    //consultar nome da subcategoria
    $update = "UPDATE `tb_serie` SET `cl_valor`= '$valor' where cl_descricao = '$serie'";
    $update_serie= mysqli_query($conecta,$update);
    if($update_serie){
        return true;
    }else{
        return false;
    }
 
 }

//consultar qualuer tabela do bd
 function consulta_tabela($conecta,$tabela,$coluna_filtro,$valor,$coluna_valor){
    $select = "SELECT * from $tabela where $coluna_filtro = '$valor' ";
    $consulta_tabela= mysqli_query($conecta,$select);
    $linha = mysqli_fetch_assoc($consulta_tabela);
    $valor = $linha["$coluna_valor"];
    return $valor;
 }
//  Em PHP, você pode usar a função ctype_alpha para verificar se um caractere é uma 
//letra e a função strtoupper para transformar uma letra em maiúscula.
//   Aqui está uma função que verifica se um caractere é uma letra e, se for, converte-o em maiúscu
 function uppercaseLetter($char) {
    if (ctype_alpha($char)) {
      return strtoupper($char);
    } else {
      return $char;
    }
  }


function validarCPF($cpf) {
    // Remove caracteres que não sejam números
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verifica se o CPF possui 11 dígitos
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se todos os dígitos são iguais (ex: 111.111.111-11)
    if (preg_match('/^(\d)\1*$/', $cpf)) {
        return false;
    }

    // Calcula o primeiro dígito verificador
    $soma = 0;
    for ($i = 0; $i < 9; $i++) {
        $soma += (int) $cpf[$i] * (10 - $i);
    }
    $resto = $soma % 11;
    $dv1 = ($resto < 2) ? 0 : 11 - $resto;

    // Calcula o segundo dígito verificador
    $soma = 0;
    for ($i = 0; $i < 10; $i++) {
        $soma += (int) $cpf[$i] * (11 - $i);
    }
    $resto = $soma % 11;
    $dv2 = ($resto < 2) ? 0 : 11 - $resto;

    // Verifica se os dígitos verificadores calculados são iguais aos do CPF
    if ($cpf[9] != $dv1 || $cpf[10] != $dv2) {
        return false;
    }

    // CPF válido
    return true;
}

//formatar para moeda real
function real_format($valor) {
    $valor  = number_format($valor,2,",",".");
    return "R$ " . $valor;
}


//verificar se tem virgula na string
function verificaVirgula($valor){
    if (strpos($valor, ',') !== false) {
        // echo "A string contém uma vírgula.";
        return true;
    } else {
        // echo "A string não contém uma vírgula.";
        return false;
    }
}

//substituir uma virgula por um ponto
function formatDecimal($valor){
    $string_com_virgula = $valor;
    $string_com_ponto = str_replace(",", ".", $string_com_virgula);
    return $string_com_ponto;
}


// $cpf = '123.456.789-00';
// if (validarCPF($cpf)) {
//     echo 'CPF válido';
// } else {
//     echo 'CPF inválido';
// }
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

//mensagem de alerta cadastro
function mensagem_alerta_permissao(){
    return "Ação bloqueada. Você não possui permissão para realizar esta ação no sistema. Por favor, verifique as suas permissões de acesso ou 
     entre em contato com o administrador do sistema para obter mais informações.";
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

function registrar_log($conecta,$nome_usuario_logado,$data,$mensagem){
    $inset = "INSERT INTO tb_log (cl_data_modificacao,cl_usuario,cl_descricao) VALUES ('$data','$nome_usuario_logado','$mensagem')";
    $operacao_inserir = mysqli_query($conecta, $inset);
    return $operacao_inserir;
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


// $cpf = '123.456.789-00';
// if (validarCPF($cpf)) {
//     echo 'CPF válido';
// } else {
//     echo 'CPF inválido';
// }
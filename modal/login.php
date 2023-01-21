


<?php
session_start();

// Recupera os dados enviados pelo formulário
$email = $_POST["usuario"];
$senha = $_POST["senha"];

// Verifica se o usuário e senha estão corretos
if ($email === "admin@admin.com" && $senha === "admin") {
  // Inicia a sessão do usuário
  $_SESSION["usuario"] = $email;

  // Retorna "ok" para o JavaScript
  echo "ok";
} else {
  // Retorna "erro" para o JavaScript
  echo "erro";
}


// cadastrar usuario if(isset($_POST['btn_resetar_senha'])){
//     $usuario =  $_POST["usuario"];
//     $senha =  $_POST["senha"];
//     $senha =  $_POST["nova_senha"];
//     $confirmar_Senha =  $_POST["confirmar_Senha"];

//     $senha = base64_encode($senha);//criptografar a senha
//     $inset = "INSERT INTO tb_users (cl_data_cadastro,cl_usuario,cl_senha,cl_tipo) VALUES ('$data','$usuario','$senha','adm')";
//     $operacao_inserir = mysqli_query($conecta, $inset);
//     if($operacao_inserir){
//         echo "cadastrado";
//     }else{
//         die("Falha na consulta ao banco de dados");
//     }

// }


?>
<script src="sweetalert2.all.min.js"></script>
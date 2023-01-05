<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
echo "<p style=display:none>,</p>";
include "funcao/funcao.php";

if(isset($_POST["btn_login"])){
    $usuario =  $_POST["usuario"];
    $senha =  $_POST["senha"];
    $consulta  = "SELECT * FROM tb_users WHERE cl_usuario = '$usuario'";
    $consulta_login = mysqli_query($conecta, $consulta);
    if($usuario != "" and $senha !="" ){//verificar se os campos estão preenchidos
    if($consulta_login ){
    $user_acess = mysqli_fetch_assoc($consulta_login);
    if (empty($user_acess)){
        ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: "Login sem sucesso",
    footer: ''
})
</script>
<?php
    }else{
            $senha_bd = $user_acess['cl_senha'];
            $senha_bd = base64_decode($senha_bd);
            if($senha == $senha_bd){
            $_SESSION["user_session_portal"] = $user_acess["cl_id"];
            header("Location:?menu");
            }else{
                ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: "Senha incorreta",
    footer: ''
})
</script>
<?php
            }
       }
    }else{
        die("Falha na consulta ao banco de dados");
    }
    }else{
        ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: "Informe o seu usuário e sua senha",
    footer: ''
})
</script>
<?php
    }
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
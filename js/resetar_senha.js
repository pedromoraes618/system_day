

var usuario = document.getElementById("usuario");
var senha = document.getElementById("senha");
var nova_senha = document.getElementById("nova_senha");
var confirma_senha = document.getElementById("confirmar_Senha");

$("#formulario_resetar_senha").submit(function(e) {
    e.preventDefault();
    var formulario_resetar_senha = $(this);
    var retorno = resetar_senha(formulario_resetar_senha)
})

function resetar_senha(dados) {
    $.ajax({
        type: "POST",
        data: dados.serialize(),
        url: "modal/resetar_password.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $mensagem = $.parseJSON(data)["mensagem"];
        $sucesso = $.parseJSON(data)["sucesso"];

        if ($sucesso) {
       
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Senha Resetada com sucesso!',
                showConfirmButton: false,
                timer: 2500
            })
            //resetar valores dos campos
            usuario.value = "";
            senha.value = "";
            nova_senha.value = "";
            confirma_senha.value = "";


        } else {

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: $mensagem,
                footer: ''
            })
        }
    }

    function falha() {
        console.log("erro");
    }

}

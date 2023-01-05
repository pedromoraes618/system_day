let senha = document.getElementById("senha")
let usuario = document.getElementById("usuario")
let btn_login = document.getElementById("btn_login")

$(document).keydown(function(event) {
    if (usuario.value != "" & senha.value != "") {
        btn_login.removeAttribute("disabled", "disabled");
    } else {
        btn_login.setAttribute("disabled", "disabled");
    }
})

$("#mostrar_senha").click(function() {
    if (senha.type == "password") {
        senha.type = "text";

    } else {
        senha.type = "password";
    }
})
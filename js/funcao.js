
//funcão para input receber apenas numero
const onlyNumbers = (input) => {
  input.addEventListener("input", function () {
    this.value = this.value.replace(/[^0-9]/g, "");
  });
};

const inputnumer = document.querySelectorAll(".inputNumber");
inputnumer.forEach(input => onlyNumbers(input));


//funcão para input receber apenas numero
const onlyUsers = (input) => {
  input.addEventListener("input", function () {
    this.value = this.value.replace(/[^a-zA-Z0-9@#$%&*-+]/g, "");
  });
};

const inputuser = document.querySelectorAll(".inputUser");
inputuser.forEach(input => onlyUsers(input));


// //bloquear caracteres espaço e virgula
// const campo_usuario = document.getElementById("usuario");
// campo_usuario.addEventListener("keypress", function(e) {
//     if((e.key === " ") || (e.key ===","))  {
//       e.preventDefault();
//     }
  
// });



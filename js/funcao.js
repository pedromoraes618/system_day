//bloquear caracteres espaço e virgula
const campo_usuario = document.getElementById("usuario");
campo_usuario.addEventListener("keypress", function(e) {
    if((e.key === " ") || (e.key ===","))  {
      e.preventDefault();
    }
  
});

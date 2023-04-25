const OPENAI_API_KEY = "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";
const form_chat = document.getElementById("form_chat");
var buscar_chat = document.getElementById("buscar_chat");


$("#abrir_chat").click(function () {

    $('#pergunta_chat').val('');
  
})

if (form_chat) {
    form_chat.addEventListener("submit", async (e) => {
        e.preventDefault();

        let pergunta = document.getElementById("pergunta_chat").value
        let resposta_div = document.getElementById("resposta")

        buscar_chat.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
        buscar_chat.setAttribute("disabled", "disabled");

      
        if (pergunta == "") {
            Swal.fire({
                icon: 'error',
                title: 'Verifique!',
                text: "Favor informe a sua pergunta",
                timer: 7500,
            })
            buscar_chat.innerHTML = 'Pesquisar'
            buscar_chat.removeAttribute("disabled", "disabled");
        } else {

            await fetch("https://api.openai.com/v1/completions", {

                // Método para enviar os dados
                method: "POST",

                // Dados ennviados no cabeçalho da requisição
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer " + OPENAI_API_KEY,
                },


                //enviar os dados no corpo da requisicao
                body: JSON.stringify({
                    model: "text-davinci-003",//modelo
                    prompt: pergunta,//texto da pergunta
                    max_tokens: 3048,//tamanho da resposta
                    temperature: 0.5//criatividade da resposta
                }),
            })
                .then((resposta) => resposta.json())
                .then((dados) => {
                    buscar_chat.innerHTML = 'Pesquisar'
                    buscar_chat.removeAttribute("disabled", "disabled");
                    //informar a resposta para o usuario
                    resposta_div.innerHTML = dados.choices[0].text
                })

                .catch((erro) => {
                    console.log(erro);
                })
        }
    });


}
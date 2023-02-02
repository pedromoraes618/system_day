$("#cadastrar_categoria").submit(function(e) {
    e.preventDefault()
    var cadastrar = $(this);
    var retorno = cadastrar_categoria(cadastrar)
    var categoria = document.getElementById("categoria")
    var ordem = document.getElementById("ordem")
    var icone = document.getElementById("icone")
  
})

function cadastrar_categoria(dados) {
    $.ajax({
        type: "POST",
        data: dados.serialize(),
        url: "modal/suporte/tela/gerenciar_tela.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $sucesso = $.parseJSON(data)["sucesso"];
        $mensagem = $.parseJSON(data)["mensagem"];
        if ($sucesso) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Categoria cadastrada com sucesso',
                showConfirmButton: false,
                timer: 1500
            })
            //resetar valores de input
            categoria.value = "";
            ordem.value = "";
            icone.value = "";


            //consultar categorias já cadastradas
            $.ajax({
                type: 'GET',
                data: "consultar_tela_categoria=inicial",
                url: "view/suporte/tela/table/consultar_categoria.php",
                success: function(result) {
                    return $(".table").html(result);
                },
            });


        } else {
            Swal.fire({
                icon: 'error',
                title: 'Verifique!',
                text: $mensagem,
                timer: 7500,
            

            })

        }
    }

    function falha() {
        console.log("erro");
    }

}
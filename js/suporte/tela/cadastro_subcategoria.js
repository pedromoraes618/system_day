$("#cadastrar_subcategoria").submit(function(e) {
    e.preventDefault()
    var cadastrar = $(this);
    var retorno = cadastrar_subcategoria(cadastrar)

    var subcategoria = document.getElementById("subcategoria")
    var ordem = document.getElementById("ordem")
    var diretorio_subc = document.getElementById("diretorio_subc")
    var url_sub = document.getElementById("url_sub")
    var diretorio_bd = document.getElementById("diretorio_bd")
    var categoria = document.getElementById("categoria")


})

function cadastrar_subcategoria(dados) {
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
                title: 'Subcategoria cadastrada com sucesso',
                showConfirmButton: false,
                timer: 1500
            })



            //consultar subcaategorias já cadastradas
            $.ajax({
                type: 'GET',
                data: "consultar_tela_subcategoria=inicial",
                url: "view/suporte/tela/table/consultar_subcategoria.php",
                success: function(result) {
                    return $(".table").html(result);
                },
            });
            subcategoria.value = "";
            ordem.value = "";
            diretorio_subc.value = "";
            url_sub.value = "";
            diretorio_bd.value = "";
            categoria.value = "0";


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
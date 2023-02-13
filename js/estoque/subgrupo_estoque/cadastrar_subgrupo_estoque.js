$("#cadastrar_subgrupo_estoque").submit(function(e) {
    e.preventDefault()
    var formulario = $(this);
    var retorno = cadastrar_subgrupo(formulario)

    var descricao = document.getElementById("descricao")
    var grupo_estoque = document.getElementById("grupo_estoque")
    var est_inicial = document.getElementById("est_inicial")
    var est_minimo = document.getElementById("est_minimo")
    var est_maximo = document.getElementById("est_maximo")
    var local_estoque = document.getElementById("local_estoque")
    var unidade_md = document.getElementById("unidade_md")
    var cfop_interno = document.getElementById("cfop_interno")
    var cfop_externo = document.getElementById("cfop_externo")

})

function cadastrar_subgrupo(dados) {
    $.ajax({
        type: "POST",
        data: dados.serialize(),
        url: "modal/estoque/subgrupo_estoque/gerenciar_subgrupo_estoque.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $sucesso = $.parseJSON(data)["sucesso"];
        $mensagem = $.parseJSON(data)["mensagem"];
        if ($sucesso) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Subgrupo cadastrado com sucesso',
                showConfirmButton: false,
                timer: 1500
            })
            //resetar valores de input
            descricao.value = "";
            grupo_estoque.value = "0";
            est_inicial.value = "";
            est_minimo.value = "";
            est_maximo.value = "";
            local_estoque.value = "";
            unidade_md.value = "0";
            cfop_interno.value = "0";
            cfop_externo.value = "0";


        //recarregar tabela
        $.ajax({
            type: 'GET',
            data: "consultar_subgrupo=inicial",
            url: "view/estoque/subgrupo_estoque/table/consultar_subgrupo_estoque.php",
            success: function(result) {
                return $(".bloco-pesquisa-2 .tabela").html(result);
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
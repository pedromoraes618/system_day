//consultar o cest e informar no campo
$(document).ready(function(){
    $(".consulta_cest").css("display","none")
  })
  
  $("#buscar_cep").click(function() {
      var consulta = document.getElementById("pesquisa_conteudo_cest").value
      $.ajax({
          type: 'GET',
          data: "consultar_cest=true&conteudo_pesquisa="+consulta,
          url: "view/estoque/produto/consultar/consultar_cest.php",
          success: function(result) {
          return $(".bloco-pesquisa-menu .consulta_cest").html(result);
          },
      });
  
      function mostrarElemento(){
          $(".consulta_cest").css("display","block")
      }
    
      setTimeout(mostrarElemento, 1000);
  
  })

  $(".selecionar_cest").click(function() {
    var cest = $(this).attr("valor")
    var input_cest = document.getElementById("cest")
    input_cest.value=cest
    $('.btn-close').trigger('click');
})


//verificar margem de lucro
function maregm_lucro(){
    var preco_venda= document.getElementById("prc_venda").value
    var preco_custo= document.getElementById("prc_custo").value
    var maregm_lucro = (((preco_venda - preco_custo)/preco_venda)*100).toFixed(2);

    var margem = document.getElementById("margem_lucro")
    margem.value = maregm_lucro

}


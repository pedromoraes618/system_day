<?php  
//consultar categoria
if(isset($_GET['consultar_tela_categoria'])){
    $consulta = $_GET['consultar_tela_categoria'];
    if($consulta == "inicial"){
   
        $select = "SELECT * from tb_categorias";
        $consultar_categorias= mysqli_query($conecta, $select);
        if(!$consultar_categorias){
        die("Falha no banco de dados"); // colocar o svg do erro
        }
    }else{
        $pesquisa = utf8_decode($_GET['pesquisa']);
        $select = "SELECT * from tb_categorias where cl_categoria like '%{$pesquisa}%' ";
        $consultar_categorias= mysqli_query($conecta, $select);
        if(!$consultar_categorias){
        die("Falha no banco de dados"); // colocar o svg do erro
        }
    }

}
//consultar subcategoria
if(isset($_GET['consultar_tela_subcategoria'])){
    $consulta = $_GET['consultar_tela_subcategoria'];
    if($consulta =="inicial"){
        $select = "SELECT subc.cl_id,subc.cl_subcategoria,subc.cl_ordem_menu,subc.cl_diretorio,subc.cl_url,ctg.cl_categoria as categoria, 
        subc.cl_diretorio_bd from tb_subcategorias as subc inner join tb_categorias as ctg on ctg.cl_id = subc.cl_categoria";
        $consultar_subcategorias= mysqli_query($conecta, $select);
        if(!$consultar_subcategorias){
        die("Falha no banco de dados"); // colocar o svg do erro
        }
    }else{
        $pesquisa = utf8_decode($_GET['pesquisa']);
        $select = "SELECT subc.cl_id,subc.cl_subcategoria,subc.cl_ordem_menu,subc.cl_diretorio,subc.cl_url,ctg.cl_categoria as categoria, 
        subc.cl_diretorio_bd from tb_subcategorias as subc inner join tb_categorias as ctg on ctg.cl_id = subc.cl_categoria WHERE subc.cl_subcategoria like '%{$pesquisa}%' or ctg.cl_categoria  like '%{$pesquisa}%'";
        $consultar_subcategorias= mysqli_query($conecta, $select);
        if(!$consultar_subcategorias){
        die("Falha no banco de dados"); // colocar o svg do erro
        }
    }

}

//cadastrar categoria
if(isset($_POST['formulario_cadastrar_categoria'])){
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
        $retornar = array();
        $nome_usuario_logado = $_POST["nome_usuario_logado"];
        $id_usuario_logado = $_POST["id_usuario_logado"];

        $categoria = utf8_decode($_POST["categoria"]);
        $icone = $_POST["icone"];
        $ordem = $_POST["ordem"];
    
    
        if($categoria == ""){
            $retornar["mensagem"] =mensagem_alerta_cadastro("categoria");
        }elseif($icone =="" ){
            $retornar["mensagem"] =mensagem_alerta_cadastro("icone");
        }elseif($ordem == "" ){
            $retornar["mensagem"] =mensagem_alerta_cadastro("ordem");
        }else{
         

            $inset = "INSERT INTO tb_categorias (cl_categoria,cl_icone,cl_ordem) VALUES ('$categoria','$icone','$ordem')";
            $operacao_inserir = mysqli_query($conecta, $inset);
            if($operacao_inserir){
            $retornar["sucesso"] = true;
            //registrar no log
            $mensagem =  ( utf8_decode("Usúario") . " $nome_usuario_logado cadastrou a categoria $categoria");
            registrar_log($conecta,$nome_usuario_logado,$data,$mensagem);
            }
            
            
        }
        
    echo json_encode($retornar);
}



//cadastrar subcategoria
if(isset($_POST['formulario_cadastrar_subcategoria'])){
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
        $retornar = array();
        $nome_usuario_logado = $_POST["nome_usuario_logado"];
        $id_usuario_logado = $_POST["id_usuario_logado"];

        $subcategoria = utf8_decode($_POST["subcategoria"]);
        $orden = $_POST["ordem"];
        $diretorio_subc = $_POST["diretorio_subc"];
        $url_sub = $_POST["url_sub"];
        $diretorio_bd = $_POST["diretorio_bd"];
        $categoria = $_POST["categoria"];
    
    
        if($subcategoria == ""){
            $retornar["mensagem"] =mensagem_alerta_cadastro("subcategoria");
        }elseif($orden =="" ){
            $retornar["mensagem"] =mensagem_alerta_cadastro("ordem");
        }elseif($diretorio_subc == "" ){
            $retornar["mensagem"] =mensagem_alerta_cadastro("diretorio subcategoria");
        }elseif($url_sub == "" ){
            $retornar["mensagem"] =mensagem_alerta_cadastro("url subcategoria");
        }elseif($diretorio_bd == "" ){
            $retornar["mensagem"] =mensagem_alerta_cadastro("diretorio banco de dados");
        }elseif($categoria == "0" ){
            $retornar["mensagem"] ="Favor selecione a Categoria";
        }else{
         
            $inset = "INSERT INTO tb_subcategorias (cl_subcategoria,cl_ordem_menu,cl_diretorio,cl_url,cl_categoria,cl_diretorio_bd) VALUES ('$subcategoria','$orden','$diretorio_subc','$url_sub','$categoria','$diretorio_bd')";
            $operacao_inserir = mysqli_query($conecta, $inset);
            if($operacao_inserir){
            $retornar["sucesso"] = true;
            //registrar no log
            $mensagem =  ( utf8_decode("Usúario") . " $nome_usuario_logado cadastrou a subcategoria $subcategoria");
            registrar_log($conecta,$nome_usuario_logado,$data,$mensagem);
            }
            
            
        }
        
    echo json_encode($retornar);
}



//consultar categoria
$select = "SELECT * from tb_categorias";
$consultar_categorias_selecao= mysqli_query($conecta, $select);
if(!$consultar_categorias_selecao){
die("Falha no banco de dados"); // colocar o svg do erro
}
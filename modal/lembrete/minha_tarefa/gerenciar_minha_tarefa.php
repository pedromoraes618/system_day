<?php  
//consultar informações para tabela
if(isset($_GET['consultar_tarefa'])){
include "../../../../conexao/conexao.php";
include "../../../../funcao/funcao.php";
    $consulta = $_GET['consultar_tarefa'];
    if($consulta== "inicial"){
        $select = "SELECT trf.cl_id, trf.cl_data_lancamento,trf.cl_descricao,trf.cl_comentario,user.cl_usuario 
        as usuario,trf.cl_prioridade,trf.cl_data_limite,strf.cl_descricao as status from tb_tarefas as trf inner join tb_users as user on user.cl_id = trf.cl_usuario 
        inner join tb_status_tarefas as strf on strf.cl_id = trf.cl_status order by trf.cl_data_lancamento desc ,trf.cl_status";
        $consultar_tarefas= mysqli_query($conecta, $select);
        if(!$consultar_tarefas){
        die("Falha no banco de dados"); // colocar o svg do erro
        }
    
    }else{
        $pesquisa = utf8_decode($_GET['conteudo_pesquisa']);
        $status = ($_GET['conteudo_status']);
        $data_inicial = $_GET['data_inicial'];
        $data_final = $_GET['data_final'];

        
    if(datecheck($data_inicial) && datecheck($data_final)){
        //formatar data para o banco
        if($data_inicial !=""){
        $div1 = explode("/",$_GET['data_inicial']);
        $data_inicial = $div1[2]."-".$div1[1]."-".$div1[0];  
        }
        if($data_final !=""){
            $div2 = explode("/",$_GET['data_final']);
            $data_final = $div2[2]."-".$div2[1]."-".$div2[0];  
        }
    

    $select = "SELECT trf.cl_id, trf.cl_data_lancamento,trf.cl_descricao,trf.cl_comentario,user.cl_usuario 
    as usuario,trf.cl_prioridade,trf.cl_data_limite,strf.cl_descricao as status from tb_tarefas as trf inner join tb_users as user on user.cl_id = trf.cl_usuario 
    inner join tb_status_tarefas as strf on strf.cl_id = trf.cl_status where trf.cl_descricao like '%{$pesquisa}%' and trf.cl_data_lancamento between '$data_inicial' and '$data_final' ";
    if($status !="0"){
        $select .=" and trf.cl_status = '$status'";
    }
    $select .="order by trf.cl_data_lancamento desc ,trf.cl_status";
    $consultar_tarefas= mysqli_query($conecta, $select);
    if(!$consultar_tarefas){
    die("Falha no banco de dados"); // colocar o svg do erro
    }
}
}

}


//cadastrar formulario
if(isset($_POST['formulario_cadastrar_tarefa'])){
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
        $retornar = array();
        $nome_usuario_logado = $_POST["nome_usuario_logado"];
        $id_usuario_logado = $_POST["id_usuario_logado"];
        $perfil_usuario_logado = $_POST['perfil_usuario_logado'];

        $descricao = utf8_decode($_POST["descricao"]);
        $data_limite = $_POST["data_limite"];
        $status = $_POST["status"];
        $usuario = $_POST["usuario"];
        $comentario = utf8_decode($_POST["comentario"]);
    

        if($descricao == ""){
            $retornar["mensagem"] =mensagem_alerta_cadastro("descricão");

        }elseif($status =="0"){
            $retornar["mensagem"] =mensagem_alerta_cadastro("status");
        }elseif(datecheck($data_limite)!=true and $data_limite !=""){
            $retornar["mensagem"] ="Verifique o campo data limite";
        }elseif($usuario =="0"){
            $retornar["mensagem"] =mensagem_alerta_cadastro("usúario");
        }else{

        if(isset($_POST['prioridade'])){
            $prioridade = '1';
        }else{
            $prioridade = "0";
        }

        if($data_limite !=""){
        $div1 = explode("/",$_POST['data_limite']);
        $data_limite = $div1[2]."-".$div1[1]."-".$div1[0];  
       }   
       
        

         
        $inset = "INSERT INTO tb_tarefas (cl_data_lancamento,cl_descricao,cl_data_limite,cl_status,cl_usuario,cl_comentario,cl_prioridade)
         VALUES ('$data_lancamento','$descricao','$data_limite','$status','$usuario','$comentario','$prioridade')";
        $operacao_inserir = mysqli_query($conecta, $inset);
        if($operacao_inserir){
        $retornar["sucesso"] = true;
        //registrar no log
        $mensagem =  ( utf8_decode("Usúario") . " $nome_usuario_logado adicionou o lembrete $descricao ");
        registrar_log($conecta,$nome_usuario_logado,$data,$mensagem);
        }
            
    
            
        }
        
    echo json_encode($retornar);
}

// //Editar formulario
if(isset($_POST['formulario_editar_tarefa'])){
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
        $retornar = array();
      
        $nome_usuario_logado = $_POST["nome_usuario_logado"];
        $id_usuario_logado = $_POST["id_usuario_logado"];
        $perfil_usuario_logado = $_POST['perfil_usuario_logado'];

        $id_tarefa = $_POST["id_tarefa"];
        $descricao = utf8_decode($_POST["descricao"]);
        $data_limite = $_POST["data_limite"];
        $status = $_POST["status"];
        $usuario = $_POST["usuario"];
        $comentario = utf8_decode($_POST["comentario"]);
      

        if($descricao == ""){
            $retornar["mensagem"] =mensagem_alerta_cadastro("descricão");
        }elseif($status =="0"){
            $retornar["mensagem"] =mensagem_alerta_cadastro("status");
        }elseif(datecheck($data_limite)!=true and $data_limite !=""){
            $retornar["mensagem"] ="Verifique o campo data limite";
        }elseif($usuario =="0"){
            $retornar["mensagem"] =mensagem_alerta_cadastro("usúario");
        }else{

        if(isset($_POST['prioridade'])){
            $prioridade = '1';
        }else{
            $prioridade = "0";
        }

        if($data_limite !=""){
        $div1 = explode("/",$_POST['data_limite']);
        $data_limite = $div1[2]."-".$div1[1]."-".$div1[0];  
       }   


        $update = "UPDATE tb_tarefas set cl_descricao = '$descricao', cl_data_limite = '$data_limite', cl_status = '$status',cl_usuario='$usuario',cl_comentario='$comentario',cl_prioridade = '$prioridade' where cl_id = $id_tarefa";
        $operacao_update = mysqli_query($conecta, $update);
        if($operacao_update){
        $retornar["sucesso"] = true;
        //registrar no log
        $mensagem =  (utf8_decode("Usúario") . "$nome_usuario_logado alterou tarefa de código $id_tarefa");
        registrar_log($conecta,$nome_usuario_logado,$data,$mensagem);
            }  
        }
        echo json_encode($retornar);

}


///Editar formulario
if(isset($_POST['atualizar_minha_tarefa'])){
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
        $retornar = array();
      
        $id_tarefa = $_POST["id_tarefa"];
        $nome_usuario_logado = $_POST['user_logado'];
        $status = $_POST["status"];
        $comentario = $_POST["comentario"];

        if($status == "0"){
            $retornar["mensagem"] =mensagem_alerta_cadastro("status");
        }else{
            $update = "UPDATE tb_tarefas set cl_status = '$status',cl_comentario_func= '$comentario'  where cl_id = $id_tarefa";
            $operacao_update = mysqli_query($conecta, $update);
            if($operacao_update){
            $retornar["sucesso"] = true;
            //registrar no log
            $mensagem =  (utf8_decode("Usúario") . " $nome_usuario_logado atualizou a tarefa de codigo $id_tarefa");
            registrar_log($conecta,$nome_usuario_logado,$data,$mensagem);
         }
        }

        echo json_encode($retornar);
}

//trazer informaçãoes
if(isset($_GET['verificar_tarefa'])==true){
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";
    $usuario_logado = $_GET['usuario_logado'];
    $select = "SELECT trf.cl_id as idtarefa, trf.cl_data_lancamento,trf.cl_descricao,trf.cl_comentario, user.cl_usuario as usuarioord , userfunc.cl_usuario as userfunc,trf.cl_status,
    trf.cl_prioridade,trf.cl_data_limite,sttrf.cl_descricao as status from tb_tarefas as trf inner join tb_users as user on user.cl_id = trf.cl_usuario 
    inner join tb_status_tarefas as sttrf on sttrf.cl_id = trf.cl_status inner join tb_users as userfunc on userfunc.cl_id = trf.cl_usuario_func where userfunc.cl_usuario = '$usuario_logado' and trf.cl_status !='3' order by trf.cl_data_lancamento desc, trf.cl_data_limite ";
    $consultar_minhas_tarefas= mysqli_query($conecta, $select);


}
//consultar para filtro
$select = "SELECT * from tb_status_tarefas";
$consultar_status_tarefas = mysqli_query($conecta, $select);
if(!$consultar_status_tarefas){
die("Falha no banco de dados"); // colocar o svg do erro
}

$select = "SELECT * from tb_users";
$consultar_usuarios = mysqli_query($conecta, $select);
if(!$consultar_usuarios){
die("Falha no banco de dados"); // colocar o svg do erro
}
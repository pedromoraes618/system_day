<?php 

if(isset($_GET['ctg'])){
    $categoria = $_GET['ctg'];
}else{
    $categoria ="Inicial";
}
?>

<div class="topo">
    <div class="left">
        <p><?php echo $categoria; ?></p>
    </div>
    <div class="right" id='dropdown_user' aria-expanded="false">
        <ul>
            <li><i class="fa-solid fa-user"></i>
                <ul  class="menu_user">
                    <li>
                        <a href="?menu&user">Meu usuário</a>
                    </li>
                   
                    <li>
                        <a href="?menu&logout">Sair</a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="user">
            <p><?php echo $usuario; ?></p>
        </div>

    </div>

</div>


<script src="js/jquery.js"></script>
<script>
    const acesso_menu_user = document.getElementById('dropdown_user');
    document.addEventListener('mousedown',(event)=>{
        if(acesso_menu_user.contains(event.target)){
            $(".right ul li ul").css("display","block")
         
        }else{
            $(".right ul li ul").css("display","none")
        }
    })
   
</script>
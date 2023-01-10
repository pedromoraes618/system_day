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
    <div class="right">
        <ul>
            <li><i class="fa-solid fa-user"></i>
                <ul class="menu_user">
                    <li>
                        <a href="?menu&user">Meu usuário</a>
                    </li>
                    <?php if($tipo == "adm"){ ?>
                    <li>
                        <a href="?menu&acessosuser">Acessos usuário</a>
                    </li>
                    <?php }?>
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
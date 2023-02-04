<div class="topo">

    <?php include "view/nav/menu_mobile.php" ?>

    <div class="left">
        <p><?php echo $categoria_top; ?></p>
    </div>
    <div class="right" aria-expanded="false">
        <button type="img" class="btn position-relative btn_notificacao">
            <a href="?menu&notficacao">
                <i class="bi bi-bell-fill"></i>
            </a>
            <?php if($qtd_lembrete > 0){
                ?>
            <span class="position-absolute top-0 start-10 translate-middle badge rounded-pill bg-success">
                <?php echo $qtd_lembrete; ?>
                <?php
            } ?>


            </span>
        </button>
        <nav id="dropdown_user">
            <ul>
                <li><i class="bi bi-person"></i>
                    <ul class="menu_user">
                        <li>
                            <a href="?menu&user">Meu usuário</a>
                        </li>

                        <li>
                            <a href="?logout">Sair</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="user">
                <p><?php echo $usuario; ?></p>
            </div>
        </nav>
    </div>

</div>
<?php 
if(isset($_GET['ctg']) and isset($_GET['id'])){
?>
<div class="bloco-topo">
    <p> <?php echo $sub_top; ?></p>
</div>

<?php
}
?>
<script src="js/jquery.js"></script>
<script>
const acesso_menu_user = document.getElementById('dropdown_user');
document.addEventListener('mousedown', (event) => {
    if (acesso_menu_user.contains(event.target)) {
        $(".right ul li ul").css("display", "block")

    } else {
        $(".right ul li ul").css("display", "none")
    }
})
</script>
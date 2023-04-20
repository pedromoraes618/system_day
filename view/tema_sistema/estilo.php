<style>
    :root {
        --cor_principal: #131520;
        --borda_princiapl: #40475e;
        --cor_principal_hover: #31333e;
        --cor_texto: #9fa6bc;
        --cor_tabel: #141824;
        --cor_texto_sub: rgba(138, 148, 173);
        --cor_sub_bloco: #141824;
        --cor_principal_claro: #215EBE;
        --borda_princiapl_claro: #2a7bd0;
        --cor_principal_hover_claro: #4785e4;
    }

    <?php if ($tema_sistema == "DARK" or $tema_sistema == "") { ?>.bloco .bloco-left .categoria .topo {
        color: var(--cor_texto);
    }

    .bloco .bloco-left {
        background-color: var(--cor_principal);
        border-right: 1px solid var(--borda_princiapl);
    }

    .bloco .bloco-right .bloco-pesquisa-menu .title label {
        background-color: #40475e;
    }

    .bloco .bloco-left .categoria nav ul li a {
        color: white;
    }

    .bloco .bloco-left .categoria nav ul li {
        color: white;
    }

    .bloco .bloco-left .categoria nav ul li:hover {
        background-color: var(--cor_principal_hover);
    }

    .bloco .bloco-left .categoria nav ul ul li:hover {
        border-left: 2px solid white;
    }

    .bloco .bloco-left .categoria nav ul ul li a {

        color: #bbbbbb;

    }

    .bloco .bloco-left .categoria nav ul ul li a:hover {
        color: white;
    }

    .bloco .bloco-left .categoria .footer p {
        color: #bbbbbb;
    }

    /*topo */

    .bloco .bloco-right {
        background-color: #F8F8F8;
    }

    .bloco .bloco-right .topo {
        background-color: var(--cor_principal);
        border-bottom: 1px solid var(--borda_princiapl);
        border-left: 1px solid var(--borda_princiapl);

    }



    .bloco .bloco-right .topo .left p {

        color: white;

    }

    .bloco .bloco-right .topo .right ul li {
        color: var(--cor_texto_sub);
    }


    .bloco .bloco-right .topo .right ul ul {

        background: rgba(3, 48, 61, 0.85);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    .bloco .bloco-left .categoria nav ul ul {

        background-color: var(--cor_principal);

    }

    .bloco .bloco-left .categoria nav ul ul::before {

        border: 10px solid transparent;
        border-right-color: var(--cor_principal);
        border-left: none;
        /* removemos a borda à esquerda */


    }

    .bloco .bloco-right .topo .right ul ul li a {
        color: white;

    }

    .bloco .bloco-right .topo .right ul ul li:hover {
        color: #bbbbbb;
    }

    .bloco-topo {

        background-color: #0f111a;
    }

    .bloco-topo p {
        color: #bbbbbb;
    }

    

    <?php
    } elseif ($tema_sistema == "CLARO") { ?>.bloco .bloco-left .categoria .topo {
        color: white;
    }

    .bloco .bloco-right .bloco-pesquisa-menu .title label {
        background-color: var(--cor_principal_hover_claro);
    }

    .bloco .bloco-left {
        background: rgb(42, 107, 208);
        background: -moz-linear-gradient(90deg, rgba(42, 107, 208, 1) 25%, rgba(46, 111, 212, 1) 70%);
        background: -webkit-linear-gradient(90deg, rgba(42, 107, 208, 1) 25%, rgba(46, 111, 212, 1) 70%);
        background: linear-gradient(90deg, rgba(42, 107, 208, 1) 25%, rgba(46, 111, 212, 1) 70%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#2a6bd0", endColorstr="#2e6fd4", GradientType=1);
        border-right: 1px solid var(--borda_princiapl_claro);
    }


    .bloco .bloco-left .categoria nav ul li a {
        color: white;
    }

    .bloco .bloco-left .categoria nav ul li {
        color: white;
    }

    .bloco .bloco-left .categoria nav ul li:hover {
        background-color: var(--cor_principal_hover_claro);
    }

    .bloco .bloco-left .categoria nav ul ul {

        background-color: var(--cor_principal_claro);

    }

    .bloco .bloco-left .categoria nav ul ul::before {

        border: 10px solid transparent;
        border-right-color: var(--cor_principal_claro);
        border-left: none;
        /* removemos a borda à esquerda */




    }

    .bloco .bloco-left .categoria nav ul ul li:hover {
        border-left: 2px solid white;
    }

    .bloco .bloco-left .categoria nav ul ul li a {

        color: white;

    }

    .bloco .bloco-left .categoria nav ul ul li a:hover {
        color: white;
    }

    .bloco .bloco-left .categoria .footer p {
        color: #bbbbbb;
    }


    /*topo */


    .bloco .bloco-right .topo {
        background-color: var(--cor_principal_claro);
        border-bottom: 1px solid var(--borda_princiapl_claro);
        border-left: 1px solid var(--borda_princiapl_claro);
    }

    .bloco .bloco-right .topo .left p {
        color: white;
    }

    .bloco .bloco-right .topo .right ul li {
        color: var(--cor_texto_sub);
    }

    .bloco .bloco-right .topo .right ul ul {
        background-color: var(--cor_principal_claro);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    .bloco .bloco-right .topo .right ul ul li a {
        color: white;

    }

    .bloco .bloco-right .topo .right ul ul li:hover {
        color: #bbbbbb;
    }

    .bloco-topo {
        background-color: var(--cor_principal_hover_claro);
    }

    .bloco-topo p {
        color: #e8e8e8;
    }

    <?php
    }
    ?>
</style>
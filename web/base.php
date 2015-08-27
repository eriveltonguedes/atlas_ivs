<?php
// include_once './header.php';
include_once ('../config/conexao.class.php');

$base_expl = explode("/", $base);
$url = str_replace(strrchr($_SERVER["REQUEST_URI"], "?"), "", $_SERVER["REQUEST_URI"]);
if(isset($_GET['cod'])) {
    $gets = explode("/", $_GET["cod"]);
} else {
    $gets[] = "pt";
}

$ltemp = "";

if ($gets[0] == "pt" || $gets[0] == "en" || $gets[0] == "es")
{
    array_shift($gets);
}

$pag = $gets[0];
if (sizeof($gets) > 1)
{
    $pagNext = $gets[1];
}
?>
<body id="body" onresize="javascript:initApp();" style='overflow-x: hidden;'>
    <?php
    require_once 'bloqueios/blockAllView.php';

    if ($pag == "destaques" || $pag == "consulta" || $pag == "perfil" 
            || $pag == "ranking" || $pag == "o_atlas" || $pag == "download" 
            || $pag == "arvore" || $pag == 'graficos')
    {

        echo "<div class='contentMenu' style=''>";
        require_once "./menu/menu.php";
        echo "</div>
                <div class='speratorShadow'></div>
            ";
    }
    else if ($pag == 'arvore_print' || $pag == 'perfil_print' 
            || $pag == 'imprimir_mapa' || $pag == 'histograma_print')
    {
        require_once './menu/menu_print.php';
        echo "<div class='speratorShadow'></div>";
    }
    else if ($pag == 'home' || $pag == '')
    {
        echo "<div class='contentMenu'>";
        require_once './menu/menu.php';
        echo "</div>";
    }
    else
    {
        echo "<div class='contentMenu'>";
        require_once './menu/menu.php';
        echo "</div>";
        echo "<div class='speratorShadow'></div>";
    }
    ?>
    <div id="center" class="defaltWidthContent">
    <?php echo $content; ?>
    </div>

    <?php
    $url = str_replace(strrchr($_SERVER["REQUEST_URI"], "?"), "", $_SERVER["REQUEST_URI"]);
    $gets = explode("/", $_GET["cod"]);

    if ($gets[0] == "pt" || $gets[0] == "en" || $gets[0] == "es")
    {
        array_shift($gets);
    }
    $pag = $gets[0];
    if (sizeof($gets) > 1)
    {
        $pagNext = $gets[1];
    }

    if ($pag == "destaques" || $pag == "consulta" || $pag == "perfil" 
            || $pag == "ranking" || $pag == "o_atlas" || $pag == "download" 
            || $pag == "arvore" || $pag == 'graficos' || $pag == 'mapa')
    {
        echo "<div class='speratorShadowFooter'></div>";
        include 'footer/footer.php';
    }
    else if ($pag == 'arvore_print' || $pag == 'perfil_print' || $pag == 'imprimir_mapa')
    {
        echo "<div class='speratorShadowFooter'></div>";
        include ("footer/footerPrint.php");
    }
    else if ($pag == 'home' || $pag == '')
    {
        if ($pagNext != '')
            echo "<div class='speratorShadowFooter'></div>";
        /*include ("footer/footer.php");*/
        include ("footer/footerHome.php");
    }
    else
    {
        echo "<div class='speratorShadowFooter'></div>";
        include ("footer/footerPrint.php");
    }
    ?>
    <div id="maskTransparent"></div>
    <div id="contentLoading">
        <div id='contentLoading-text' style='margin-top: 0px !important'></div>
        <div>
            <img src='assets/img/icons/ajax-loader.gif' />
        </div>
    </div>
</body>

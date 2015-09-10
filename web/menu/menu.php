<?php
if (!isset($_SESSION)) {
    session_start();
}
ob_start();


//    include ('./config/config_home.php');
$url = str_replace(strrchr($_SERVER["REQUEST_URI"], "?"), "", $_SERVER["REQUEST_URI"]);

if(isset($_GET['cod'])) {
    $gets = explode("/", $_GET["cod"]);
} else {
    $gets[] = "pt";
}

$i = 0;
$urlComplet = '';
for ($i = 0; $i < count($gets); $i++) {
    if (empty($gets[0])) {
        $urlComplet = ' ';
    }
}

if ($gets[0] == "pt" || $gets[0] == "en" || $gets[0] == "es") {
    array_shift($gets);
}

for ($i = 0; $i < count($gets); $i++) {
    if (!empty($gets[$i])) {
        $urlComplet .= $gets[$i] . '/';
    }
}

if (sizeof($base_expl) == 1) {
    $pag = $gets[0];
    if (sizeof($gets) > 1) {
        $pagNext = $gets[1];
    } else {
        $pagNext = '';
    }
    if (sizeof($gets) > 2) {
        $pagNext2 = $gets[2];
    } else {
        $pagNext2 = '';
    }
}
?>

<?php
if ($pag == 'perfil' || $pag == 'perfil_print' || $pag == 'perfil_m' || $pag == 'perfil_rm' || $pag == 'perfil_uf' || $pag == 'perfil_udh') {
    ?>
    <script src="system/modules/profile/js/function_format.js" type="text/javascript"></script> 
    <script src="system/modules/profile/js/itChartsPerfil.js" type="text/javascript"></script>
<?php } ?>

    <style type="text/css">

        #div_lang_selector 
        {
            visibility: <?php echo(HIDE_INTER) ? 'hidden;' : 'visible;'; ?>
        }

        div.link_inter a
        {
            color: black;
        }

        a.<?php echo 'link_' . $_SESSION['lang']; ?>
        {
            font-weight: bold;
        }

    </style>
    
<div class="contentCenterMenu" id="voltarTopo">

    <div id="div_lang_selector" style="float:right; margin-right: 25px;" class="link_inter" >    
<?php
$link = explode("|", LINKS_IDIOMAS);

foreach ($link as $value) {
    if ($value == 'pt')
        echo "<a class='link_pt' href='pt/".$urlComplet."'> Português </a>&nbsp;";

    if ($value == 'en')
        echo "<a class='link_en' href='en/".$urlComplet."'> English </a>&nbsp;";

    if ($value == 'es')
        echo "<a class='link_es' href='es/".$urlComplet."'> Español </a>&nbsp;";
}
?>
    </div>


    <div class="mainMenuTop">   
        <img src="<?php echo $path_dir ?>./assets/img/icons/setaMenu.png" id="setaMenu" style="display: none;position: absolute; width: 80px" alt=""/>
        <div class="imgLogo">
            <a href="<?php echo $path_dir . $_SESSION["lang"] . '/' ?>"><!--<img src=<?php echo $path_dir . "assets/img/logos/branca.png"; ?> alt=""/>--><h1 style="font-family: 'Passion One', cursive;max-width: 340px; color: #333;    font-weight: 500;">Atlas da Vulnerabilidade Social</h1></a>
        </div>
        <ul class="mainMenuTopUl no-print" <?php if (LINKS_IDIOMAS == "") echo "style='margin-top: 57px;'" ?>>
            <li><a href="<?php echo $path_dir; ?><?php echo $_SESSION["lang"]; ?>/home/" <?php
        if (($pag == 'home' || $pag == '') && $pagNext == '') {
            echo 'class="ativo"';
        }
?> id="menu_home"><?php echo $lang_mng->getString('menu_home'); ?></a></li>

                   <?php
                   if (atlas_has_lang($_SESSION["lang"])) {
                       ?>
                <li><a href="<?php echo $path_dir; ?><?php echo $_SESSION["lang"]; ?>/o_atlas/o_atlas_/" <?php
                if ($pag == "o_atlas") {
                    echo 'class="ativo"';
                }
                ?> id="menu_oAtlas"><?php echo $lang_mng->getString('menu_oAtlas'); ?></a></li>
                    <?php
                   }
                   ?>

                <!--   <?php
                   if (destaque_has_lang(@$_SESSION["lang"])) {
                       ?>
                <li><a href="<?php echo $path_dir; ?><?php echo $_SESSION["lang"]; ?>/destaques/" <?php
                if ($pag == "destaques") {
                    echo 'class="ativo"';
                }
                ?> id="menu_destaques"><?php echo $lang_mng->getString('menu_destaques'); ?></a></li> 
                    <?php
                   }
                   ?>

                   <?php
                   if (perfil_has_lang(@$_SESSION["lang"])) {
                       ?>
                <li><a href="<?php echo $path_dir; ?><?php echo $_SESSION["lang"]; ?>/perfil/" <?php
                if ($pag == 'perfil' && $pagNext2 == '') {
                    echo 'class="ativo"';
                }
                ?> id="menu_perfil"><?php echo $lang_mng->getString('menu_perfil'); ?></a></li>
                    <?php
                   }
                   ?> !-->  

                   <?php
                   if (consulta_has_lang(@$_SESSION["lang"])) {
                       ?>
                <li><a href="<?php echo $path_dir; ?><?php echo $_SESSION["lang"]; ?>/consulta/" <?php
                if ($pag == 'consulta' && $pagNext2 == '') {
                    echo 'class="ativo"';
                }
                ?> id="menu_consulta"><?php echo $lang_mng->getString('menu_consulta'); ?></a></li>
                    <?php
                   }
                   ?>

                   <?php
                   if (mapa_has_lang(@$_SESSION["lang"])) {
                       ?>
                <li><a href="<?php echo $path_dir; ?><?php echo $_SESSION["lang"]; ?>/mapa/" <?php
                if ($pag == 'mapa' && $pagNext2 == '') {
                    echo 'class="ativo"';
                }
                ?> id="menu_mapa"><?php echo $lang_mng->getString('menu_mapa'); ?></a></li>
                    <?php
                   }
                   ?>

                  <!-- <?php
                   if (arvore_has_lang(@$_SESSION["lang"])) {
                       ?>
                <li><a href="<?php echo $path_dir; ?><?php echo $_SESSION["lang"]; ?>/arvore/" <?php
                if ($pag == 'arvore' && ($pagNext == '' || $pagNext == 'estado' || $pagNext == 'municipio' || $pagNext == 'aleatorio')) {
                    echo 'class="ativo"';
                }
                ?> id='menu_arvore'><?php echo $lang_mng->getString('menu_arvore'); ?></a></li>
                    <?php
                   }
                   ?> !-->

                   <?php
//                if(grafico_has_lang(@$_SESSION["lang"])){
                   ?>
<!--<li><a href="<?php //echo $path_dir;  ?><?php //echo $_SESSION["lang"]; ?>/graficos/" <?php //if($pag == 'graficos' && $pagNext == '') {echo 'class="ativo"';}  ?> id='menu_graficos'></a></li>-->
            <?php
//                }
            ?> 

            <!--<?php
            if (ranking_has_lang(@$_SESSION["lang"])) {
                ?>
                <li><a href="<?php echo $path_dir; ?><?php echo $_SESSION["lang"]; ?>/ranking" <?php
                if ($pag == 'ranking' && $pagNext == '') {
                    echo 'class="ativo"';
                }
                ?> id="menu_ranking"><?php echo $lang_mng->getString('menu_ranking'); ?></a></li>
                    <?php
                   }
                   ?>  -->

                   <?php
                   if (download_has_lang(@$_SESSION["lang"])) {
                       ?>
                <li><a href="<?php echo $path_dir; ?><?php echo $_SESSION["lang"]; ?>/download/"<?php echo $_SESSION["lang"]; ?> <?php
                if ($pag == "download" && $pagNext == '') {
                    echo 'class="ativo"';
                }
                ?> id="menu_download"><?php echo $lang_mng->getString('menu_download'); ?></a></li>
                    <?php
                   }
                   ?>

        </ul>
    </div> 
</div>

<!--&& (pagNext == '' || pagNext2 == 'municipio' || pagNext2 == 'estado' || pagNext2 == 'aleatorio' || pagNext == lang-->


<script type="text/javascript">
    $(document).ready(function() {
        initApp();
    });

    /**
     * Init.
     */
    function initApp() {
        var pag = '<?= $pag ?>';
        var pagNext = '<?= $pagNext ?>';
        var pagNext2 = '<?= $pagNext2 ?>';

        if ((pag == 'destaques') || (pag == 'graficos' && pagNext == '') || pag == 'mapa'
                || (pag == 'consulta' && pagNext == '') || (pag == 'perfil' && pagNext2 == '') || (pag == 'download' || pag == 'ranking') ||
                (pag == 'arvore' && (pagNext == '' || pagNext == 'municipio' || pagNext == 'estado' || pagNext == 'aleatorio'))
                || (pag == 'o_atlas' && (pagNext == '' || pagNext == 'o_atlas_' || pagNext == 'quem_faz' || pagNext == 'para_que' || pagNext == 'processo' || pagNext == 'desenvolvimento_humano' || pagNext == 'idhm' || pagNext == 'metodologia' && (pagNext2 == 'idhm_longevidade' || pagNext2 == 'idhm_educacao' || pagNext2 == 'idhm_renda') || pagNext == 'glossario' || pagNext == 'perguntas_frequentes' || pagNext == 'tutorial' || pagNext == ''))) {

            var pos             = $(".mainMenuTopUl .ativo").position();
            var largura         = $(".mainMenuTopUl .ativo").css("width");
            var tamanho         = parseInt(largura.length);
            var tamanho2        = tamanho - 2;
            var numberLargura   = parseInt(largura.substr(0, tamanho2));
            var metLargura      = numberLargura / 2;
            
            document.getElementById("setaMenu").style.display = 'block';
            
            var left, top;
            left = parseInt(pos.left + metLargura - 27);
//            top = pos.top + 69;
            top = pos.top + 49;
            
            $('#setaMenu').css('left', left + "px");
            $('#setaMenu').css('top', top + "px");
        }
    }

//    $("#menu_home").html(lang_mng.getString("menu_home"));
//    $("#menu_oAtlas").html(lang_mng.getString("menu_oAtlas"));
//    $("#menu_destaques").html(lang_mng.getString("menu_destaques"));
//    $("#menu_perfil").html(lang_mng.getString("menu_perfil"));
//    $("#menu_consulta").html(lang_mng.getString("menu_consulta"));
//    $("#menu_mapa").html(lang_mng.getString("menu_mapa"));
//    $("#menu_arvore").html(lang_mng.getString("menu_arvore"));
//    $("#menu_graficos").html(lang_mng.getString("menu_graficos"));
//    $("#menu_ranking").html(lang_mng.getString("menu_ranking"));
//    $("#menu_download").html(lang_mng.getString("menu_download"));

</script>


<?php
    ob_start();
    $url = str_replace(strrchr($_SERVER["REQUEST_URI"], "?"), "", $_SERVER["REQUEST_URI"]);
    $separator = explode("/", $_GET["cod"]);


    if ($separator[0] == "pt" || $separator[0] == "en" || $separator[0] == "es") {
        array_shift($separator);
    }
?>

<script type="text/javascript">
    function myfunction(valor) {
        lang = '<?= $_SESSION["lang"] ?>';
        pag = '<?= $path_dir ?>' + lang + '/destaques/';

        if (valor == 1) {
            url = pag + "metodologia/";
        }

        else if (valor == 2) {
            url = pag + "faixas_idhm/";
        }

        else if (valor == 3) {
            url = pag + "idhm_brasil/";
        }

        else if (valor == 4) {
            url = pag + "educacao/";
        }

        else if (valor == 5) {
            url = pag + "longevidade/";
        }

        else if (valor == 6) {
            url = pag + "renda/";
        }

        location.href = url;
    }
</script>

<div class="contentPages">
    <div class="containerPage">
        <div class="containerTitlePage">
            <div class="titlePage">
                <div id='destaques_title' class="titletopPage"></div>
            </div>
        </div>   
   
        <div class="linhaDivisoria"></div>
        
        <div id="conteudo_atlas">
            <?php
            if ($separator[1] == 'metodologia' || $separator[1] == '') {
                include 'destaques/' . $_SESSION["lang"] . '/metodologiaView.php';
            } 
            else if ($separator[1] == 'faixas_idhm') {
                include 'destaques/' . $_SESSION["lang"] . '/faixasIDHMView.php';
            } 
            else if ($separator[1] == 'idhm_brasil') {
                include 'destaques/' . $_SESSION["lang"] . '/idhmBrasilView.php';
            } 
            else if ($separator[1] == 'educacao') {
                include 'destaques/' . $_SESSION["lang"] . '/educacaoView.php';
            } 
            else if ($separator[1] == 'longevidade') {
                include 'destaques/' . $_SESSION["lang"] . '/longevidadeView.php';
            } 
            else if ($separator[1] == 'renda') {
                include 'destaques/' . $_SESSION["lang"] . '/rendaView.php';
            }
            ?>
        </div>
    </div>
    <input type="button" class="voltarTopo" onclick="$j('html,body').animate({scrollTop: $('#voltarTopo').offset().top}, 2000);" value="Voltar ao topo" >
</div>

<script type="text/javascript">
    $("#destaques_longevidade").html(lang_mng.getString("destaques_longevidade"));
    $("#destaques_renda").html(lang_mng.getString("destaques_renda"));
    $("#destaques_educacao").html(lang_mng.getString("destaques_educacao"));
    $("#destaques_idhmBrasil").html(lang_mng.getString("destaques_idhmBrasil"));
    $("#destaques_faixas_idhm").html(lang_mng.getString("destaques_faixas_idhm"));
    $("#destaques_metodologia").html(lang_mng.getString("destaques_metodologia"));
    $("#destaques_title").html(lang_mng.getString("destaques_title"));
</script>
<?php
    $title = "Destaques";
    $meta_title = 'Destaques';
    $meta_description = 'O Atlas do Desenvolvimento Humano no Brasil 2013 é uma plataforma de consulta ao Índice de Desenvolvimento Humano Municipal – IDHM - de 5.565 municípios brasileiros, além de mais de 180 indicadores de população, educação, habitação, saúde, trabalho, renda e vulnerabilidade, com dados extraídos dos Censos Demográficos de 1991, 2000 e 2010.';
    $content = ob_get_contents();
    ob_end_clean();
    include "base.php";
?>

<?php
    require_once BASE_ROOT . 'system/modules/ranking/controller/rankingController.php';
?>

<form id="f_cross_data_ranking" method="post">
    <input type="hidden" name="cross_data_ranking" id="cross_data_ranking"/>
    <input type="hidden" name="cross_data_download" id="cross_data_download" value="false"/>
</form>

<div class="containerPage">
    <div class="containerTitlePage">
        <div class="titlePage">
            <div class="titletopPage" style="font-size: 52pt;"><?php echo $lang_mng->getString("rankin_ranking") ?> <?php echo $compTitle; ?><br /><br /><span style="font-size: 30pt" id="span_year_show"></span></div>
            <div class='' style="float: right; margin-top: 38px">
                <?php echo $ranking->writeButton(); ?>
            </div>
        </div>
    </div>   
</div>

<div class="tabbable inlineBlock">
    <!-- Abas de Espacialidades do Ranking -->
    <ul class="nav nav-tabs">
        <li class="<?php echo $classBtn1; ?> abaRank" onclick="<?php echo $onClick1; ?>"><a href="#tab1" data-toggle="tab"><?php echo $lang_mng->getString("rankin_municipal") ?></a></li>
        <li class="<?php echo $classBtn2; ?> abaRank" onclick="<?php echo $onClick2; ?>"><a href="#tab2" data-toggle="tab"><?php echo $lang_mng->getString("rankin_Estadual") ?></a></li>
        <li class="<?php echo $classBtn3; ?> abaRank" onclick="<?php echo $onClick3; ?>"><a href="#tab3" data-toggle="tab"><?php echo $lang_mng->getString("rankin_rm") ?></a></li>
        <li class="<?php echo $classBtn4; ?> abaRank" onclick="<?php echo $onClick4; ?>"><a href="#tab4" data-toggle="tab"><?php echo $lang_mng->getString("rankin_udh") ?></a></li>
    </ul>
    <!-- Seletor de Ano-->
    <div id="selct_ano">
        <span style="color:black; font-weight: bold;"><?php echo $lang_mng->getString("rankin_Ano") ?></span> 
        <?php $ranking->drawAnoSelect(); ?>
    </div>
</div>
<div class="leftContentRank">
    <div class="btnsRank"><?php $ranking->drawSelect(); ?></div>

    <div class="btnsRank"><?php echo $lang_mng->getString("rankin_order_by") ?> <b><?php echo $ranking->nOrdem; ?></b></div>
    <?php echo $ranking->drawLegenda(); ?>
</div>
<?php
    $ranking->draw();
?>
<input type="button" class="voltarTopo" onclick="$j('html,body').animate({scrollTop: $('#voltarTopo').offset().top}, 2000);" value="Voltar ao topo" >
<div style="clear: both"></div>


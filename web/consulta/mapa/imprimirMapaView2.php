<?php
ob_start();
//header('Content-Type: text/html; charset=utf-8');
?>

<script type="text/javascript">
    $(document).ready(function ()
    {
        $('#m_leg_title').html(lang_mng.getString("mapa_leg").toUpperCase());
        $('#img_lg_idhm').attr("src", lang_mng.getString("mapa_idh_img"));
        javascript:self.print();
    });
</script>

<style type="text/css"> 

    .map-title-print 
    {
        line-height: 16pt;
        position: relative;
        float: left;
        font-size: 16pt;
        font-family: Passion One;
        width: 590px;
        padding: 0px;
        margin: 0px;
        border: 0px;
    }

    .data_impressao
    {

        position: relative;
        /*float: right;*/
        padding: 0px;
        margin: 0px;
        border: 0px;
    }

</style>

<div id="titulo_mapa" class="titulo_mapa">
    <h3></h3>
</div>
<div id="mapa_personalizado">
    <?php include BASE_ROOT . '/system/modules/map/view/ConsultaMapaView.php'; ?>
</div>

<?php
$title = 'Impressão do Mapa';
$title_print = 'Mapa';
$content = ob_get_contents();
ob_end_clean();
include "base.php";

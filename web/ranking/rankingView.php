<?php ob_start(); ?>
<meta name="description" content="" />
<div class="contentPages">
    <?php 
        require_once '../system/modules/ranking/view/rankingView.php';
    ?>
    <div style="clear: both"></div>
</div>

<?php 
    $title = $lang_mng->getString("rankin_title");
    $meta_title = $lang_mng->getString("rankin_metaTitle");
    $meta_description = $lang_mng->getString("rankin_metaDescricao");
    $content = ob_get_contents();
    ob_end_clean();
    include "base.php";
?>
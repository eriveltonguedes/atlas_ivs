<?php ob_start(); ?>
<div id="content">
    <div class="containerPage">
        <div class="containerTitlePage">
            <div class="titlePage">
                <div class="titletopPage">Consulta</div>
            </div>
            <div class="iconAtlas">
                <img src="./assets/img/icons/table_gray.png" class="buttonDesabilitado">
                <img src="./assets/img/icons/brazil_gray.png" class="buttonDesabilitado">
            </div>
        </div>
    </div>
</div>
<div class="linhaDivisoria"></div>
<?php include 'downloadNavegadoresView.php'; ?>

<?php 
    $title = "Atualização de Navegador";
    $content = ob_get_contents();
    ob_end_clean();
    include "base.php";
?>

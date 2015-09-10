<?php

$url = str_replace(strrchr($_SERVER["REQUEST_URI"], "?"), "", $_SERVER["REQUEST_URI"]);
$gets = explode("/", $url);
$pag = $gets[2];
?>
<?php //if($pag != 'perfil_print') { ?>
<div class="clear"></div>
<div id="footer">
    <div class="footerbottomCenter">
        <div class="footerLeft">
            <div class="redesSociais">
                <span id="footer_novidades"></span>
                <p>
                    <a href="<?php echo $home_FooterFacebook ?>" target="_blank"><img src="./assets/img/footer/facebook.png" alt="Facebook"/></a>
                    <a href="<?php echo $home_FooterTwitter ?>" target="_blank"><img src="./assets/img/footer/twitter.png" alt="Twitter"/></a>
                    <a href="<?php echo $home_FooterYoutube ?>" target="_blank"><img src="./assets/img/footer/youtube.png" alt="Youtube"/></a>
                </p>
            </div>
            <div class="menuFooter">
                <?php
                if (atlas_has_lang(@$_SESSION["lang"])) {
                    ?>
                    <a href="<?php echo $path_dir . @$_SESSION["lang"] . "/" . $home_perguntasFrequentes; ?>" id="footer_perguntasFrequestes"></a><br />
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="footerRight">
            <div class="realizacao">
                <p id="footer_realizacao"><p>
                <div class="logosFooter">
                    <!--<a href="<?php echo $home_footerPNUD ?>" target="_blank"><img src="./assets/img/footer/logo_PNUD.png" alt="PNUD"/></a>
                    <a href="<?php echo $home_footerFJP ?>" target="_blank"><img src="./assets/img/footer/logo_fundacao_ joao_pinheiro.png" style="margin-top: 30px; padding-right: 5px; padding-left: 5px;" alt="Fundação João Pinheiro"/></a>-->
                    <a href="<?php echo $home_footerIPEA ?>" target="_blank"><img src="./assets/img/footer/logo_ipea.png" style="height:100px;" alt="IPEA"/></a>
                </div>
            </div>
        </div>
            <div class="realizacao">
                <p id="footer_realizacao" style="margin-top: 30px;">Parceiros institucionais<p>
                <div class="logosFooter">
                    <a href="<?php echo $home_footerIPEA ?>" target="_blank"><img src="./assets/img/footer/logo-secima.png" alt="SECIMA"/></a>
                    <a href="<?php echo $home_footerIPEA ?>" target="_blank"><img src="./assets/img/footer/logo-fjp.png" alt="Fundação João Pinheiro"/></a>
                    <a href="<?php echo $home_footerIPEA ?>" target="_blank"><img src="./assets/img/footer/logo-sei.png" alt="SEI"/></a>
                    <a href="<?php echo $home_footerIPEA ?>" target="_blank"><img src="./assets/img/footer/logo-ceperj.jpg" alt="CEPERJ"/></a>
                    <a href="<?php echo $home_footerIPEA ?>" target="_blank"><img src="./assets/img/footer/logo-seade.png" alt="SEADE"/></a>
                    <a href="<?php echo $home_footerIPEA ?>" target="_blank"><img src="./assets/img/footer/logo-ipardes.jpg" alt="IPARDES"/></a>
                    <a href="<?php echo $home_footerIPEA ?>" target="_blank"><img src="./assets/img/footer/logo-fapespa.jpg" alt="FAPESPA"/></a>
                </div>
            </div>
            <!--<div class="realizacao">
                <p id="footer_realizacao" style="margin-top: 30px;">Apoio Institucional<p>
                <div class="logosFooter">
                    <span style="font-weight: bold; font-size: 13pt; margin-right: 6px; float:left; margin-top:10px;"> <img src="./assets/img/oAtlas/Apoio Institucional/SGPR/marcadogovernofederal.png" style="width:150px;margin-top:5px;" />  </span>
        <span style="font-weight: bold; font-size: 13pt; margin-right: 6px; float:left; margin-top:10px;"> <img src="./assets/img/oAtlas/Apoio Institucional/Banco do Brasil/BancodoBrasil_Logo.jpg" style="width:200px;margin-top:7px;" />  </span>
        <span style="font-weight: bold; font-size: 13pt; margin-right: 6px; float:left; margin-top:10px;"> <img src="./assets/img/oAtlas/Apoio Institucional/Caixa/logo_CAIXA.jpg" style="width:120px;margin-top: 5px;" />  </span>
        <span style="font-weight: bold; font-size: 13pt; margin-right: 6px; float:left; margin-top:10px;"> <img src="./assets/img/home/fapemig.png" style="width:155px;margin-top: 5px;" />  </span>
                </div>
            </div>-->
            
        
    </div>
</div>

<script>
    $("#footer_novidades").html(lang_mng.getString("footer_novidades"));
    $("#footer_perguntasFrequestes").html(lang_mng.getString("footer_perguntasFrequestes"));
    $("#footer_realizacao").html(lang_mng.getString("footer_realizacao"));
</script>

<?php

$url = str_replace(strrchr($_SERVER["REQUEST_URI"], "?"), "", $_SERVER["REQUEST_URI"]);
$gets = explode("/", $url);
$pag = $gets[2];
?>
<?php //if($pag != 'perfil_print') { ?>
<div class="clear"></div>
<div id="footer">
    <div class="footerbottomCenter">
        <!-- <div class="footerLeft"> -->
           <!--  <div class="redesSociais">
                <span id="footer_novidades"></span>
             
            </div> -->
   <!--          <div class="menuFooter">
                <?php
                if (atlas_has_lang(@$_SESSION["lang"])) {
                    ?>
                    <a href="<?php echo $path_dir . @$_SESSION["lang"] . "/" . $home_perguntasFrequentes; ?>" id="footer_perguntasFrequestes"></a><br />
                    <?php
                }
                ?>
            </div> -->
        <!-- </div> -->
        <!-- <div class="footerRight"> -->
            <div class="realizacao">
                <p id="footer_realizacao"><p>
                <div class="logosFooter">
                    <a href="<?php echo $home_footerPNUD ?>" target="_blank"><img src="./assets/img/footer/logo_PNUD.png" alt="PNUD"/></a>
                    <a href="<?php echo $home_footerFJP ?>" target="_blank"><img src="./assets/img/footer/logo_fundacao_ joao_pinheiro.png" style="margin-top: 30px; padding-right: 5px; padding-left: 5px;" alt="Fundação João Pinheiro"/></a>
                    <a href="<?php echo $home_footerIPEA ?>" target="_blank"><img src="./assets/img/footer/logo_ipea.png" style="margin-top: 55px;" alt="IPEA"/></a>
                </div>
            </div>
            <div class="realizacao">
                <p id="footer_realizacao" style="margin-top: 30px;">Parceiros institucionais<p>
                <div class="logosFooter">
                    <a href="http://www.braskem.com.br/" target="_blank"><img src="./assets/img/oAtlas/Parceiros Institucionais/Braskem/Marca Principal.jpg" style="margin-left: 15px; width:100px; margin-top: 39px;" alt="PNUD"/></a>
                    <a href="http://www.petrobras.com.br/" target="_blank"><img src="./assets/img/oAtlas/Parceiros Institucionais/Petrobras/Petrobras_Logo.jpg" style="margin-left: 15px;margin-top:28px;width:150px; padding-right: 5px; padding-left: 5px;" alt="Fundação João Pinheiro"/></a>
                    <a href="http://www.sebrae.com.br/" target="_blank"><img src="./assets/img/oAtlas/Apoio Institucional/Sebrae/Logo Sebrae (azul).jpg" style="margin-left: 15px;width: 85px;margin-top:28px;" alt="IPEA"/></a>
                    <a href="http://www.bnb.gov.br/" target="_blank"><img src="./assets/img/oAtlas/Parceiros Institucionais/Banco do Nordeste/BancodoNordeste_Logo.jpg" style="margin-left: 15px;margin-top:28px;width: 110px;" alt="IPEA"/></a>
                    <a href="http://www.furnas.com.br/" target="_blank"><img src="./assets/img/oAtlas/Parceiros Institucionais/Furnas/cor_com_degrade_principal.jpg" style="margin-left: 15px;width: 64px;" alt="IPEA"/></a>
                </div>
            </div>
            <div class="realizacao">
                <p id="footer_realizacao" style="margin-top: 30px;">Apoio Institucional<p>
                <div class="logosFooter">
                    <span style="font-weight: bold; font-size: 13pt; margin-right: 6px; float:left; margin-top:10px;"> <img src="./assets/img/oAtlas/Apoio Institucional/SGPR/marcadogovernofederal.png" style="width:150px;margin-top:5px;" />  </span>
        <span style="font-weight: bold; font-size: 13pt; margin-right: 6px; float:left; margin-top:10px;"> <img src="./assets/img/oAtlas/Apoio Institucional/Banco do Brasil/BancodoBrasil_Logo.jpg" style="width:200px;margin-top:7px;" />  </span>
        <span style="font-weight: bold; font-size: 13pt; margin-right: 6px; float:left; margin-top:10px;"> <img src="./assets/img/oAtlas/Apoio Institucional/Caixa/logo_CAIXA.jpg" style="width:120px;margin-top: 5px;" />  </span>
        <span style="font-weight: bold; font-size: 13pt; margin-right: 6px; float:left; margin-top:10px;"> <img src="./assets/img/home/fapemig.png" style="width:155px;margin-top: 5px;" />  </span>
                </div>
            </div>
            
        <!-- </div> -->
    </div>
</div>

<script>
    $("#footer_novidades").html(lang_mng.getString("footer_novidades"));
    $("#footer_perguntasFrequestes").html(lang_mng.getString("footer_perguntasFrequestes"));
    $("#footer_realizacao").html(lang_mng.getString("footer_realizacao"));
</script>

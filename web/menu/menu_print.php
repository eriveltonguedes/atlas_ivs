<div class="contentCenterMenu">
    <div class="mainMenuTopPrint">   
        <div class="imgLogoPrint">
            <img src=<?php echo "./assets/img/logos/branca.png";?> alt="" style="z-index: 1"/>
        </div>
        <?php 
            if($pag == 'perfil_print'){
        ?>
            <script src="system/modules/profile/js/function_format.js" type="text/javascript"></script> 
        <?php
                echo "<div class='titlePrintPerfil'>".$title_print."</div>";
            }            
            else{
                echo "<div class='titlePrint'>".$title_print."</div>";
            }
        ?>
        
    </div> 
</div>

 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
 "http://www.w3.org/TR/html4/loose.dtd">
 <html>
 <head>

      <!-- Define o nome do autor da página. -->
     <meta name="author" content="Ricardo Ruas" />
     <!-- Define indioma. -->
     <meta http-equiv="Content-Language" content="pt-br">
     <!-- Define o tipo de conteúdo da página e o tipo de codificação de caracteres. -->
     <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 

 </head>
 <body> 
 <div class='contentMenu' style=''> 
     <div class="contentCenterMenu" id="voltarTopo">
        <div class="mainMenuTop">   
            <img src="<?php echo $path_dir ?>../assets/img/icons/setaMenu.png" id="setaMenu" style="display: none;position: absolute; width: 80px" alt=""/>
            <div class="imgLogo">
                <img src=<?php echo $path_dir . "./assets/img/logos/branca.png"; ?> alt=""/>
            </div>   
        </div> 
    </div>
</div>
<div class="speratorShadow"></div>
<div class="defaltWidthContent" id="center" style="margin-bottom:40px" >
    <div class="contentAtualizacaoNav" >
            <h3>Atenção! Seu navegador está desatualizado e você não pode acessar o Atlas.
            Atualize o seu navegador favorito para continuar:</h3>
            <p>Heads up! Your browser is out of date and you can not access the Atlas. Update your favorite browser to continue:</p>
            <table style="width:100%; margin-top:20px;">
              <tr>
                <td style="text-align:center"><a href="https://www.mozilla.org/pt-BR/firefox/new/" target="_blank"><img src=<?php echo $path_dir ."./assets/img/icons/logo_firefox.jpg";?> /><p style="margin-top:10px;">Firefox</p></a></td>
                <td style="text-align:center"><a href="http://www.google.com/intl/pt-BR/chrome/" target="_blank"><img src=<?php echo $path_dir ."./assets/img/icons/logo_chrome.jpg";?>  /><p style="margin-top:10px;">Google Chrome</p></a></td>
                <td style="text-align:center"><a href="http://www.apple.com/br/safari/" target="_blank"><img src=<?php echo $path_dir ."./assets/img/icons/logo_safari.jpg";?>  /><a href="http://www.apple.com/br/safari/" target="_blank"><p style="margin-top:10px;">Safari</p></a></td>
                <td style="text-align:center"><a href="http://www.microsoft.com/pt-br/download/internet-explorer-10-details.aspx" target="_blank"><img src=<?php echo $path_dir ."./assets/img/icons/logo_ie.jpg";?>        /><p style="margin-top:10px;">Internet Explorer</p></a></td>
                <td style="text-align:center"><a href="http://www.opera.com/" target="_blank"><img src=<?php echo $path_dir ."./assets/img/icons/logo_opera.jpg";?>   /><p style="margin-top:10px;">Opera</p></a></td>
              </tr>  
            </table>    
    </div>
</div>
<div class="speratorShadowFooter" style="margin-top:30px; "></div>
<?php
 include(BASE_ROOT."web/footer/footerPrint.php");
 ?> 
 </body>
 </html> 
<?php
    $url = str_replace(strrchr($_SERVER["REQUEST_URI"], "?"), "", $_SERVER["REQUEST_URI"]);
    $separator = explode("/",$_GET["cod"]);
    
    if($separator[0] == "pt" || $separator[0] == "en" || $separator[0] == "es")
    {
        array_shift ( $separator );
    } 

?>

<script type="text/javascript">
    function myfunction2(valor){//só para redirecionar
        lang = '<?=$_SESSION["lang"]?>';
        pag = '<?=$path_dir?>' + lang + '/o_atlas/metodologia/';

        if(valor == 1){
            url = pag + "idhm_longevidade/";
            /*url = pag + "calculo-do-idhm-e-seus-subindices/";*/
        }

        else if(valor == 2){
            url = pag + "idhm_educacao/";
            
        }

        else if(valor == 3){
            url = pag + "idhm_renda/";
        }

        else if(valor == 4){
            url = pag + "construcao-das-unidades-de-desenvolvimento-humano/";
        }
        
        location.href= url;
    }
</script>

<div id="processo" style="width:900px; min-height: 1600px;">
    <div class="areatitle" id='atlas_Metodologia'></div>
    
    <div class="menuAtlasMet">
        <ul class="menuAtlasMetUl">
                <!-- <li>
                    <a id="atlas_aba_1" onclick="myfunction2('1')" 
                <?php if($separator[2] == 'calculo-do-idhm-e-seus-subindices' || $separator[0] == '') {echo 'class="ativo2"'; } ?>> CÁLCULO DO IDHM E SEUS SUBÍNDICES </a>
                <span class='ballMarker'>&bull;</span>
                </li> -->                
                <li><a id="atlas_menuIdhmLongevidade" onclick="myfunction2('1')" 
                <?php if($separator[2] == 'idhm_longevidade' || $separator[0] == '') {echo 'class="ativo2"'; } ?>>IDHM LONGEVIDADE</a><span class='ballMarker'>&bull;</span></li>
            <li><a id="atlas_menuIdhmEducacao" onclick="myfunction2('2')" 
                <?php if($separator[2] == 'idhm_educacao') {echo 'class="ativo2"';}?> >IDHM EDUCAÇÃO</a><span class='ballMarker'>&bull;</span></li>
            <li><a id="atlas_menuIdhmRenda" onclick="myfunction2('3')" 
                <?php if($separator[2] == 'idhm_renda') {echo 'class="ativo2"';} ?> >IDHM RENDA</a></li>
                <li>
                    <a id="atlas_aba_2" onclick="myfunction2('4')" 
                <?php if($separator[2] == 'construcao-das-unidades-de-desenvolvimento-humano') {echo 'class="ativo2"';}?> >IDHM EDUCAÇÃO</a>
                <!-- <span class='ballMarker'>&bull;</span> -->
                </li>
        </ul>
    </div>
    <div class="linhaDivisoriaMet"></div>
    <div class="title-geral">
        <h1>O IDHM</h1>
<p>O IDHM é obtido pela média geométrica dos três subíndices das dimensões que
compõem o índice: longevidade, educação e renda.</p>
    </div>
    
    
    <?php
                if($separator[2] == 'idhm_longevidade' || $separator[1] == ''){
                    include 'o_atlas/'.$_SESSION["lang"].'/idhmLongevidadeView.php';
                }

                else if($separator[2] == 'idhm_educacao'){
                    include 'o_atlas/'.$_SESSION["lang"].'/idhmEducacaoView.php';
                }
                
                else if($separator[2] == 'construcao-das-unidades-de-desenvolvimento-humano'){
                    include 'o_atlas/'.$_SESSION["lang"].'/construcaoUnidadesDesenvolvimentoHumano.php';
                }
                
                else if($separator[2] == 'idhm_renda'){
                    include 'o_atlas/'.$_SESSION["lang"].'/idhmRendaView.php';
                }
            ?>
</div>

<script type="text/javascript">
    $("#atlas_Metodologia").html(lang_mng.getString("atlas_Metodologia"));
    $("#atlas_aba_1").html(lang_mng.getString("atlas_metodologia_aba_1"));
    $("#atlas_aba_2").html(lang_mng.getString("atlas_metodologia_aba_2"));
    /*$("#atlas_menuIdhmEducacao").html(lang_mng.getString("atlas_menuIdhmEducacao"));
    $("#atlas_menuIdhmRenda").html(lang_mng.getString("atlas_menuIdhmRenda"));*/
</script>
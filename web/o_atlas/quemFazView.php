<?php
    $url = str_replace(strrchr($_SERVER["REQUEST_URI"], "?"), "", $_SERVER["REQUEST_URI"]);
    $separator = explode("/",$_GET["cod"]);
    
    if($separator[0] == "pt" || $separator[0] == "en" || $separator[0] == "es")
    {
        array_shift ( $separator );
    } 
?>

<script type="text/javascript">
    function myfunction2(valor){
        lang = '<?=$_SESSION["lang"]?>';
        pag = '<?=$path_dir?>' + lang + '/o_atlas/quem_faz/';

        if(valor == 1){
            url = pag + "atlas/";
        }

        else if(valor == 2){
            url = pag + "atlas_regiao_metropolitana/";
        }
        
        location.href= url;
    }
</script>

    <div class="areatitle" id='atlas_titleQuemFazIDHMunicipio'></div>
    
    <!--<div class="menuAtlasMet">
        <ul class="menuAtlasMetUl">
            <li><a id="atlas_menuAtlasIDHMunicipio" onclick="myfunction2('1')" 
                <?php if($separator[2] == 'atlas' || $separator[0] == '') {echo 'class="ativo2"'; } ?>></a><span class='ballMarker'>&bull;</span></li>
            <li><a id="atlas_menuAtlasRegiaoMetropolitana" onclick="myfunction2('2')" 
                <?php if($separator[2] == 'atlas_regiao_metropolitana') {echo 'class="ativo2"';}?> ></a><span class='ballMarker'></span></li>
        </ul>
    </div>
    <div class="linhaDivisoriaQuemFaz"></div>-->
    
    <?php
                if($separator[2] == 'atlas' || $separator[1] == ''){
                    include 'o_atlas/'.$_SESSION["lang"].'/quemFazAtlasMunicipioView.php';
                }
                
                else if($separator[2] == 'atlas_regiao_metropolitana'){
                    include 'o_atlas/'.$_SESSION["lang"].'/quemFazAtlasRMView.php';
                }
            ?>
</div>

<script type="text/javascript">
    $("#atlas_titleQuemFazIDHMunicipio").html(lang_mng.getString("atlas_titleQuemFazIDHMunicipio"));
    $("#atlas_menuAtlasIDHMunicipio").html(lang_mng.getString("atlas_menuAtlasIDHMunicipio"));
    $("#atlas_menuAtlasRegiaoMetropolitana").html(lang_mng.getString("atlas_menuAtlasRegiaoMetropolitana"));
</script>
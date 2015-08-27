<?php
    ob_start(); 
    $url = str_replace(strrchr($_SERVER["REQUEST_URI"], "?"), "", $_SERVER["REQUEST_URI"]);
    $separator = explode("/",$_GET["cod"]);
    

    if($separator[0] == "pt" || $separator[0] == "en" || $separator[0] == "es")
    {
        array_shift ($separator);
    }
    
?>

<script type="text/javascript">
    function myfunction(valor){
       lang = '<?=$_SESSION["lang"]?>';
        pag = '<?=$path_dir?>' + lang + '/o_atlas/';
        lang = '<?=$_SESSION["lang"]?>';

        if(valor == 1){
            url = pag + "o_atlas_/";
        }

        else if(valor == 2){
            url = pag + "quem_faz/atlas_regiao_metropolitana/";
        }

        else if(valor == 3){
            url = pag + "para_que/";
        }
        
        else if(valor == 4){
            url = pag + "processo/atlas-desenvolvimento-humano-regioes-metropolitanas/";
        }
        
        else if(valor == 5){
            url = pag + "desenvolvimento_humano/";
        }
        
        else if(valor == 6){
            url = pag + "idhm/";
        }
        
        else if(valor == 7){

            url = pag + "metodologia/construcao-das-unidades-de-desenvolvimento-humano/";
        }
        
        else if(valor == 8){
            url = pag + "glossario/";
        }
        
        else if(valor == 9){
            url = pag + "perguntas_frequentes/";
        }
        
        else if(valor == 10){
            url = pag + "tutorial";
        }
        
        location.href= url;
    }
</script>

<div class="contentPages">
    <div class="containerPage">
        <div class="containerTitlePage">
            <div class="titlePage">
                <div class="titletopPage" id="atlas_titleOAtlas"></div>
            </div>
        </div>  
         <div class="menuAtlas">
            <ul class="menuAtlasUl" style="margin-left: 19px">
                <li><a id="atlas_menuOAtlas" onclick="myfunction('1')" 
                    <?php 
                            if($separator[1] == 'o_atlas_' || $separator[1] == '' )
                                echo 'class="ativo2"';
                     ?>></a><span class='ballMarker'>&bull;</span>
                </li>
                <li><a id="atlas_menuQuemFaz" onclick="myfunction('2')" 
                    <?php 
                                if($separator[1] == 'quem_faz')
                                echo 'class="ativo2"';
                   ?> ></a><span class='ballMarker'>&bull;</span>
                </li>
                <li><a id="atlas_menuParaQue" onclick="myfunction('3')" 
                    <?php 
                                if($separator[1] == 'para_que')
                                echo 'class="ativo2"';
                    ?> ></a><span class='ballMarker'>&bull;</span>
                </li>
                <li><a id="atlas_menuProcesso" onclick="myfunction('4')" 
                    <?php 
                                if($separator[1] == 'processo')
                                echo 'class="ativo2"';
                        ?> ></a><span class='ballMarker'>&bull;</span>
                </li>
                <li><a id="atlas_menuDesenvolvimentoHumano" onclick="myfunction('5')" 
                    <?php
                                if($separator[1] == 'desenvolvimento_humano')
                                echo 'class="ativo2"';
                       ?> ></a><span class='ballMarker'>&bull;</span>
                </li>
                <li><a id="atlas_menuIdhm" onclick="myfunction('6')" 
                    <?php 
                                if($separator[1] == 'idhm')
                                echo 'class="ativo2"';
                        ?> ></a><span class='ballMarker'>&bull;</span>
                </li>
                <li><a id="atlas_menuMetodologia" onclick="myfunction('7')" 
                    <?php 
                                if($separator[1] == 'metodologia')
                                echo 'class="ativo2"';
                        ?> ></a><span class='ballMarker'>&bull;</span>
                </li>
                <li><a id="atlas_menuGlossario" onclick="myfunction('8')"
                    <?php
                                if($separator[1] == 'glossario')
                                echo 'class="ativo2"';
                       ?> ></a><span class='ballMarker'>&bull;</span>
                </li>
                <li><a id="atlas_menuFAQ" onclick="myfunction('9')"
                    <?php
                                if($separator[1] == 'perguntas_frequentes')
                                echo 'class="ativo2"';
                    ?> ></a><!-- <span class='ballMarker'>&bull;</span> --></li>
       <!--          <li><a id="atlas_menututorial" onclick="myfunction('10')"
                    <?php
                                if($separator[1] == 'tutorial')
                                echo 'class="ativo2"';
                    ?> ></a></li> -->
            </ul>
        </div>
        <div class="linhaDivisoria"></div>
        
        <div id="conteudo_atlas">
            <?php
                    if($separator[1] == 'o_atlas_' || $separator[1] == ''){
                        include 'o_atlas/'.$_SESSION["lang"].'/oAtlasView.php';
                    }

                    else if($separator[1] == 'quem_faz'){
                        include 'o_atlas/quemFazView.php';
                    }

                    else if($separator[1] == 'para_que'){
                        include 'o_atlas/'.$_SESSION["lang"].'/paraQueView.php';
                    }
                    else if($separator[1] == 'processo'){
                        include 'o_atlas/processoView.php';
                    }
                    else if($separator[1] == 'desenvolvimento_humano'){
                        include 'o_atlas/'.$_SESSION["lang"].'/desenvolvimentoHumanoView.php';
                    }
                    else if($separator[1] == 'idhm'){
                        include 'o_atlas/'.$_SESSION["lang"].'/idhmView.php';
                    }
                    else if($separator[1] == 'metodologia'){
                        include 'o_atlas/metodologiaView.php';
                    }

                    else if($separator[1] == 'glossario'){
                        include 'o_atlas/'.$_SESSION["lang"].'/glossarioView.php';
                    }

                    else if($separator[1] == 'perguntas_frequentes'){
                        include 'o_atlas/'.$_SESSION["lang"].'/perguntasFrequentesView.php';
                    }
                    
                    else if($separator[1] == 'tutorial'){
                        include 'o_atlas/tutorialView.php';
                    }
            ?>
        </div>
    </div>
    
    <input type="button" class="voltarTopo" onclick="$j('html,body').animate({scrollTop: $('#voltarTopo').offset().top}, 2000);" value="<?php echo $lang_mng->getString("voltarTopo")?>">
</div>

<script type="text/javascript">
//     $(".voltarTopo").html(lang_var.getString("voltarTopo"));;
     $("#atlas_titleOAtlas").html(lang_mng.getString("atlas_titleOAtlas"));
     $("#atlas_menuOAtlas").html(lang_mng.getString("atlas_menuOAtlas"));
     $("#atlas_menuQuemFaz").html(lang_mng.getString("atlas_menuQuemFaz"));
     $("#atlas_menuParaQue").html(lang_mng.getString("atlas_menuParaQue"));
     $("#atlas_menuProcesso").html(lang_mng.getString("atlas_menuProcesso"));
     $("#atlas_menuDesenvolvimentoHumano").html(lang_mng.getString("atlas_menuDesenvolvimentoHumano"));
     $("#atlas_menuIdhm").html(lang_mng.getString("atlas_menuIdhm"));
     $("#atlas_menuMetodologia").html(lang_mng.getString("atlas_menuMetodologia"));
     $("#atlas_menuGlossario").html(lang_mng.getString("atlas_menuGlossario"));
     $("#atlas_menuFAQ").html(lang_mng.getString("atlas_menuFAQ"));
     $("#atlas_menututorial").html(lang_mng.getString("atlas_menututorial"));
</script>
<?php
    $title = $lang_mng->getString("atlas_title");
    $meta_title = $lang_mng->getString("atlas_metaTitle");
    $meta_description = $lang_mng->getString("atlas_metaDescricao");
    $content = ob_get_contents();
    ob_end_clean();
    include "base.php";
?>

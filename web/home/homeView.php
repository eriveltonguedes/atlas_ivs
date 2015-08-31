<?php
    ob_start(); 
?>

<!--JavaScript que recupera o valor na caixa de busca do perfil e redireciona para a página deste.-->
<script type="text/javascript">
    var baseUrl = "<?php echo $path_dir . "$ltemp" ?>";
    var storedName = "";

    $(document).ready(function() {
        inputHandler.add($('#perfil_search_municipio'), 'buscaHome', 2, "", false, getNomeMunUF);
        inputHandler.add($('#perfil_search_rm'), 'buscaPerfilRM', 6, "", false, getNomeMunUFRM);
        inputHandler.add($("#perfil_search_uf"), 'buscaPerfilUF', 4, "", false, getNomeMunUFUF)
        inputHandler.add($("#perfil_search_udh"), 'buscaPerfilUDH', 5, "", false, getNomeMunUFUDH)

        // seleciona o input correto
        $(".buscaHome li a[rel^='perfil-']").click(function(e){
            e.preventDefault();
            $(".buscaHome li a[rel^='perfil-']").removeClass("ativo");
            $(this).addClass("ativo");
            var idBusca = $(this).attr('rel');
            $('.perfil-search-main_home').hide();
            $('.perfil-search-main_home.'+idBusca).show()
        });
    });

    function getNomeMunUF(nome) {
        storedName = retira_acentos(nome);
        buscaPerfil();
    }

    function buscaPerfil() {
        if ($("#buscaHome").attr("i") != 0)
            RedirectSearch(storedName, "/perfil_m/");
        else if (storedName == "")
            document.getElementById('home_erroBusca').style.display = "block";
    }
    
    function getNomeMunUFUF(nome) {
        storedName = retira_acentos(nome);
        buscaPerfilUF();
    }

    function buscaPerfilUF() {
        if($("#buscaPerfilUF").attr("i") != 0) {
            RedirectSearch(storedName, "/perfil_uf/");
        } else if(storedName == "") {
            document.getElementById("setaMenu").style.display = 'block';
        }
    }

    function getNomeMunUFRM(nome) {
        storedName = retira_acentos(nome);
        buscaPerfilRM();
    }

    function buscaPerfilRM() {
        if($("#buscaPerfilRM").attr("i") != 0) {
            RedirectSearch(storedName, "/perfil_rm/");
        } else if(storedName == "") {
            document.getElementById("setaMenu").style.display = 'block';
        }
    }

    function getNomeMunUFUDH(nome) {
        storedName = retira_acentos(nome);
        buscaPerfilUDH();
    }

    function buscaPerfilUDH() {
        if($("#buscaPerfilUDH").attr("i") != 0) {
            RedirectSearch(storedName, "/perfil_udh/");
        } else if(storedName == "") {
            document.getElementById("setaMenu").style.display = 'block';
        }
    }

    function RedirectSearch(nome, perfilType) {
        window.location = baseUrl + perfilType + retira_acentos(nome);
    }

</script>



<script>
    $(document).ready(function(){
        var tempo = 5000;
        var ativo = 0;
        /*function transicaoBanner(elem){
            clearInterval(interBanner);
            if(elem != -1) {
                var i = elem;
            } else {
                if( $('.nh-banner ul li.ativo').next().size()) {
                    var i = $('.nh-banner ul li.ativo').next().index();
                } else {
                    var i = 0;
                }
            }
            $('.nh-banner ul li').fadeOut().removeClass('ativo');
            $('.nh-banner ul li:eq('+i+')').fadeIn().addClass('ativo');
            ativo = $('.nh-banner ul li.ativo').index();
            if( ativo+1 == $('.nh-banner ul li').length ){
                ativo = -1;
            }
            interBanner = setTimeout(function() { transicaoBanner(ativo+1) }, tempo);
        }

        var interBanner = setTimeout(function() { transicaoBanner(ativo+1) }, tempo);*/
    });
</script>

<div class="container nh-container">
    <div class="nh-banner" style='overflow-x: hidden'>
    
    <ul>
        <li class='ativo'>
            <a href="<?php echo $path_dir . "$ltemp" ?>/consulta/"><img src="./assets/img/home/banner/modelo_banner_site_v02.jpg" alt=""></a>
        </li>
        <!--<li>
            <a href="<?php echo $path_dir . "$ltemp" ?>/download/"><img src="./assets/img/home/banner/banner-cebolao.png" alt=""></a>
        </li> -->
        <!-- <li>
            <a href="<?php echo $path_dir . "$ltemp" ?>/destaques/"><img src="./assets/img/home/banner/banner_2.jpg" alt=""></a>
        </li> -->
    </ul>
    
</div> <!-- /banner -->
    <!-- <div class="row nh-busca-perfil">
        <div class="span12">
            <?php if (buscaPerfil_has_lang(@$_SESSION["lang"])) {     #Só irá aparecer a caixa de busca do perfil para as linguagens setadas
            ?>
            <!-- ========================== PERFIL ====================================== --> 
    <!--        <div class="containerPerfil nh-containerPerfil">
                <div class="contentPerfil">
                    <div class="contentTitlePefil">
                        <div class="titulo_divs">
                            <div class="h1Home nh-h1Home" id="home_titlePerfil"></div>
                            <span id="home_textoPerfil"></span>
                        </div>
                    </div>

                    <div class="buscaHome">
                        <div id="home_erroBusca" class="erro_BuscaHome"></div>
                        <div class="nh-perfil-busca">
                            <ul>
                            <li><a href="#" rel="perfil-municipio" class="ativo"><?php echo $lang_mng->getString('home_busca_municipio')?></a></li>
                                <li><a href="#" rel="perfil-uf"><?php echo $lang_mng->getString('home_busca_estado')?></a></li>
                                <li><a href="#" rel="perfil-rm"><?php echo $lang_mng->getString('home_busca_rm')?></a></li>
                                <li><a href="#" rel="perfil-udh"><?php echo $lang_mng->getString('home_busca_udh')?></a></li>
                            </ul>
                        </div>
                        <div class="perfil-search-main_home nh-perfil-search-main_home perfil-busca perfil-municipio"  id="perfil_search_municipio">
                            <a onclick="buscaPerfil()" id="busca"><button id="home_buttonBusca" title="" type="button" name="" value="" class="blue_button big_bt"  style=" padding:5px 15px; margin-top: 18px; margin-right: 10px; float: right"></button></a>
                        </div>

                        <div class="perfil-search-main_home nh-perfil-search-main_home perfil-busca perfil-uf"  id="perfil_search_uf" style="display: none">
                            <button id="busca" onclick="buscaPerfilUF()" title="" type="button" name="" value="" class="blue_button big_bt"  style=" padding:5px 15px; margin-top: 18px; margin-right: 10px; float: right">Busca</button>
                        </div>

                        <div class="perfil-search-main_home nh-perfil-search-main_home perfil-busca perfil-rm"  id="perfil_search_rm" style="display: none">
                            <button id="busca" onclick="buscaPerfilRM()" title="" type="button" name="" value="" class="blue_button big_bt"  style=" padding:5px 15px; margin-top: 18px; margin-right: 10px; float: right">Busca</button>
                        </div>

                        <div class="perfil-search-main_home nh-perfil-search-main_home perfil-busca perfil-udh"  id="perfil_search_udh" style="display: none">
                            <button id="busca" onclick="buscaPerfilUDH()" title="" type="button" name="" value="" class="blue_button big_bt"  style=" padding:5px 15px; margin-top: 18px; margin-right: 10px; float: right">Busca</button>
                        </div>

                    </div>
                    <p style="margin-left: 250px;" id="home_exemploBusca"></p>
                </div> <!-- /contentPerfil -->
        <!--    </div> <!-- /containerPerfil -->
            <?php } ?>
        <!--</div> <!-- /span12 -->
    <!--</div> <!-- /row -->

    <hr />

    <div class="row">
         <div class="nh-box">
            <div class="nh-box-content" style="text-align:left;">
                <span style="font-size:22pt; line-height: 32px; color: #333;font-family: 'Passion One', cursive;"></span>
                <span style="font-size:22pt; line-height: 32px; color: #333;font-family: 'Passion One', cursive;"><?php echo $lang_mng->getString('home_escolha_como') ?></span>
            </div>
        </div> <!-- /nh-box -->
        <div class="nh-box">
            <a href="<?php echo $path_dir . "$ltemp" ?>/consulta/">
            <div class="nh-box-content">
                <div class="nh-box-icon">
                    <img src="./assets/img/home/tabela-icone.png" alt="">
                </div>
                <div class="nh-box-right">
                <h3 class="nh-title"><?php echo $lang_mng->getString('home_titleConsulta') ?></h3>
                <p><?php echo $lang_mng->getString('home_textoConsulta') ?></p></div>
            </div>
            </a>
        </div> <!-- /nh-box -->

        <div class="nh-box">
            <div class="nh-box-content">
                <a href="<?php echo $path_dir . "$ltemp" ?>/mapa/">
                <div class="nh-box-icon">
                    <img src="./img/nh-mapa.png" alt="">
                </div>
                <div class="nh-box-right">
                    <h3 class="nh-title"><?php echo $lang_mng->getString('home_titleMapas') ?></h3>
                    <p><?php echo $lang_mng->getString('home_textoMapas') ?></p></div>
            </div>
            </a>
        </div> <!-- /nh-box -->
    
    <!--<div style="clear:both"></div>
              <div class="nh-box">
                <a href="<?php echo $path_dir . "$ltemp" ?>/arvore/">
            <div class="nh-box-content">
                <div class="nh-box-icon" style="width: 57px;">
                    <img src="./img/nh-arvore1.png" alt="">
                </div>
                <div class="nh-box-right">
                <h3 class="nh-title"><?php echo $lang_mng->getString('home_titleidhmArvore') ?></h3>
                <p><?php echo $lang_mng->getString('home_textoidhmArvore') ?></p></div>

            </div>
            </a>
        </div> <!-- /nh-box -->
     <!--<div class="nh-box">
        <a href="<?php echo $path_dir . "$ltemp" ?>/ranking/">
            <div class="nh-box-content">
                <div class="nh-box-icon">
                    <img src="./assets/img/home/ranking-podio.png" alt="">
                </div>
                <div class="nh-box-right">
                <h3 class="nh-title"><?php echo $lang_mng->getString('home_titleRank') ?></h3>
                <p><?php echo $lang_mng->getString('home_textoRank') ?></p></div>
            </div>
            </a>
        </div> <!-- /nh-box -->
        <!--<div class="nh-box">
            <div class="nh-box-content">
                <a href="<?php echo $path_dir . "$ltemp" ?>/perfil/">
                <div class="nh-box-icon">
                    <img src="./assets/img/home/icone-perfil.png" alt="">
                </div>
                <div class="nh-box-right">
                <h3 class="nh-title"><?php echo $lang_mng->getString('home_titlePerfil') ?></h3>
                <p><?php echo $lang_mng->getString('home_textoPerfil') ?></p></div>
            </div>
            </a>
        </div> <!-- /nh-box -->
        <div class="nh-clear"></div>
        </div> <!-- /row -->
    </div> <!-- /row -->

    <hr>

    <div class="nh-clear" style='margin-bottom: 20px'></div>

   <!-- <div class="row">
        <div class="nh-video-player">
            <iframe width="440" height="248" src="//www.youtube.com/embed/K7Cftgj250Y" frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="nh-video-descricao">
        <h3 class="nh-subtitle nh-left"><?php echo $lang_mng->getString('atlas_titleOAtlas') ?></h3>
        <p><?php echo $lang_mng->getString('home_oAtlasDescricao') ?>
                <a href="<?php echo $path_dir . "$ltemp" ?>/o_atlas/o_atlas_/"> Saiba Mais </a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="<?php echo $path_dir . "$ltemp" ?>/o_atlas/perguntas_frequentes/"> Perguntas frequentes </a>
            </p>
           <p style="margin-top: 50px; float: right;">
                <a href="<?php echo $home_FooterFacebook ?>" target="_blank"><img src="./assets/img/footer/facebook.png" alt="Facebook"/></a>
                <a href="<?php echo $home_FooterTwitter ?>" target="_blank"><img src="./assets/img/footer/twitter.png" alt="Twitter"/></a>
                <a href="<?php echo $home_FooterYoutube ?>" target="_blank"><img src="./assets/img/footer/youtube.png" alt="Youtube"/></a>
                <a href="http://www.pnud.org.br/IDH/Boletim.aspx" target="_blank"><img  style="width: 34px; height: 34px;" src="./assets/img/home/mail.png" alt="Boletim"/></a>
            </p>
        </div>
  

        <div class="nh-clear" style='margin-bottom: 40px'></div>
    </div> <!-- /row -->
    
    <div class="nh-clear" style='margin-bottom: 40px;'></div>
    <hr>

</div> <!-- /container -->

<script>
    $(document).ready(function() {
        $('.carousel').carousel({
            interval: 3000
        });
    });

    $("#home_titlePerfil").html(lang_mng.getString("home_titlePerfil"));
    $("#home_textoPerfil").html(lang_mng.getString("home_textoPerfil"));
    $("#home_exemploBusca").html(lang_mng.getString("home_exemploBusca"));
    $("#home_erroBusca").html(lang_mng.getString("home_erroBusca"));
    $("#home_buttonBusca").html(lang_mng.getString("home_buttonBusca"));
</script>

<?php 
    $title = $lang_mng->getString("home_title");
    $meta_title = $lang_mng->getString("home_metaTitle");
    $meta_description = $lang_mng->getString("home_metaDescricao");
    $content = ob_get_contents();
    ob_end_clean();
    include "base.php";
?>

<?php
//header('Content-Type: text/html; charset=utf-8');
ob_start();

set_include_path(get_include_path() . PATH_SEPARATOR . "system/modules/perfil/");
require_once '../system/modules/perfil/controller/Perfil.class.php';
$perfil = new Perfil($MunicipioPefil);
?>
<meta name="description" content="" />

<!-- SELETOR UDH -->
<link rel="stylesheet" href="assets/css/filter-search_perfil.css">
<script	src="system/modules/perfil/componentes/seletor-perfil/view/js/filter-search.js"></script>
<script	src="system/modules/perfil/componentes/seletor-perfil/view/js/seletor-espacialidade.js"></script>
<!-- SELETOR UDH -->

<script type="text/javascript">

    $(document).ready(function()
    {
        $('#toolTipPrintDown').tooltip({html: true, delay: 500});
        $("#perfil_title_uf").html(lang_mng.getString("home_titlePerfilUF"));
        $("#perfil_title_m").html(lang_mng.getString("home_titlePerfil"));
        $("#perfil_title_rm").html(lang_mng.getString("home_titlePerfilRM"));        
        $("#perfil_title_udh").html(lang_mng.getString("home_titlePerfilUDH"));

        // readyGo();
    });

</script>



<div id="content">
    <div class="containerPerfilTop" id="teste2">
        <div class="containerTitlePage">
            
           
            
            
            <div class="titlePerfilPage">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li><a href="#perfil_uf" data-toggle="tab">Estado</a></li>
                    <li class="active"><a href="#perfil_rm" data-toggle="tab">Região Metropolitana</a></li>    
                    <li><a href="#perfil_m" data-toggle="tab">Município</a></li>                                    
                    <li><a href="#perfil_udh" data-toggle="tab">Unidade de Desenvolvimento Humano</a></li>
<!--                    <li><a href="#busca_perfil_avancado" data-toggle="tab">Busca Avançada</a></li>-->
                </ul>

                <!-- Tab panes - BootsTrap -->
                <div class="tab-content">
                    <div class="tab-pane" id="perfil_uf">
                        
                        <div data-toggle="tab">
                            <div class="titletopPage" id="perfil_title_uf"></div>
                            <div class="perfil-search-main"  id="perfil_search_uf">
                                <a class="buttonBuscaPagePerfil" onclick="buscaPerfilUF()" id="busca">
                                    <img class="lupaBusca" src="./assets/img/perfil/lupa_busca.png" /></a>
                            </div>
                            <div id="erroBuscaUF" class="erro_BuscaPerfil">*Selecione um estado para continuar</div>
                        </div>
                        
                    </div>
                    <div class="tab-pane active" id="perfil_rm">
                        
                        <div data-toggle="tab">
                            <div class="titletopPage" id="perfil_title_rm"></div>
                            <div class="perfil-search-main"  id="perfil_search_rm">
                                <a class="buttonBuscaPagePerfil" onclick="buscaPerfilRM()" id="busca">
                                    <img class="lupaBusca" src="./assets/img/perfil/lupa_busca.png" /></a>
                            </div>
                            <div id="erroBuscaRM" class="erro_BuscaPerfil">*Selecione uma região metropolitana para continuar</div>
                        </div>                        
                    </div>    
                    <div class="tab-pane" id="perfil_m">
                        
                        <div data-toggle="tab">
                            <div class="titletopPage" id="perfil_title_m"></div>
                            <div class="perfil-search-main"  id="perfil_search">
                                <a class="buttonBuscaPagePerfil" onclick="buscaPerfil()" id="busca">
                                    <img class="lupaBusca" src="./assets/img/perfil/lupa_busca.png" /></a>
                            </div>
                            <div id="erroBusca" class="erro_BuscaPerfil">*Selecione um município para continuar</div>
                        </div>

                    </div>                                    
                    <div class="tab-pane" id="perfil_udh">
                        
                        <div data-toggle="tab">
                            <div class="titletopPage" id="perfil_title_udh"></div>
                            <div class="perfil-search-main"  id="perfil_search_udh">
                                <a class="buttonBuscaPagePerfil" onclick="buscaPerfilUDH()" id="busca">
                                    <img class="lupaBusca" src="./assets/img/perfil/lupa_busca.png" /></a>
                            </div>
                            <div id="erroBuscaUDH" class="erro_BuscaPerfil">*Selecione uma UDH para continuar</div>
                        </div>

<!--        </div>  <div data-toggle="tab"> -----@#-------------------------------------------------------------->
                    </div>
                    <div class="tab-pane" id="busca_perfil_avancado">
                        
                        <div data-toggle="tab">
                            <div class="titletopPage" id="perfil_title_busca_avancada"></div>                      
                            
                       <!-- MODAL SELETOR PERFIL -->
            <!--            <div class="divCallOutLugares">
                            <button type="button" class="blue_button big_bt" id="button-fs" style="margin-right: 31px !important; font-size: 14px; height: 34px;"></button>
                        </div>-->
                        <div class="modal fs">
                            <div class="modal-body">
                                <div class="span8 left-content">
                                    <div class="row-fluid row-search">
                                        <div class="span12">
                                            <div class="form-inline">
                                                <input type="text" class="input-large input-fs-search">
                                            </div><!-- /input-group -->
                                        </div><!-- /.span-6 -->					  
                                    </div>
                                    <div class="row-fluid">
                                        <div class="mensagem" id="msg-bottom-search"></div>
                                    </div>
                                    <div class="row-fluid selectors">
                                    </div>
                                </div>
                            </div>
                        </div>	
               <!-- MODAL SELETOR PERFIL -->                    
                            
                        </div>
                    </div>
                    
                    
                    
                </div>

            </div>
        </div>
    </div>    
</div>

<?php
$perfil->drawScripts();
$perfil->drawNome();
$perfil->drawMenu();
  
?> 
<div id="MainContentPerfil" class="blockArea">
</div> 

<?php
//==========================================================================
//Include corpo do site
//==========================================================================

$content = ob_get_contents();
if ($MunicipioPefil == null)
    $title = $lang_mng->getString("mapa_title");
else
    $title = $lang_mng->getString("mapa_title_mun") . $perfil->getNomeCru();
$meta_title = $lang_mng->getString("mapa_metaTitle");
$meta_description = $lang_mng->getString("mapa_metaDescricao");
ob_end_clean();
include "base.php";
$BancoDeDados = null;
?>
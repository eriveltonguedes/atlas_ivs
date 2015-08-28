<link rel="stylesheet" href="assets/css/filter-search.css">
<link rel="stylesheet" href="assets/css/table-component.css?v=0.1">
<link rel="stylesheet" href="assets/StickyTableHeaders/css/component.css">
<link rel="stylesheet" href="assets/StickyTableHeaders/css/normalize.css">
<link rel="stylesheet" href="assets/css/consulta.css">
<link rel="stylesheet" href="assets/css/seletor-indicador/seletor-indicador-new.css">
<style type="text/css">
    .modal-backdrop{
        /*z-index: 99995;*/
    }
    #container_mapa_personalizado {
        position: absolute; 
        top: -58px; 
        left: 0;
        /* Bootstrap CSS @todo */
        z-index: 1040; 
        display: none; 
        width:100%;
    }
    #container_mapa_personalizado .toolbar_mapa_personalizado {
        background-color: white; 
        padding-bottom: 10px; 
        width: 100%; 
        float: left; 
        clear: both; 
        border-bottom: 1px solid #ccc;
    }
    #aviso_sem_indicador {
        position: absolute; 
        top: 125px; 
        left: 450px; 
        display: none;
        padding: 10px; 
        height: auto;
    }
    #container_indicador {
        float: left; 
        width: 100%; 
        height: 100%; 
        display: none;
    }
</style>

<script src="assets/js/consulta.js" type="text/javascript" charset="utf-8"></script>
<script src="system/modules/tabela2/view/builder.tabela.js" type="text/javascript" charset="utf-8"></script>
<script	src="system/modules/seletor-espacialidade/view/js/filter-search.js"></script>
<script	src="system/modules/seletor-espacialidade/view/js/seletor-espacialidade.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"></script>
<script src="assets/StickyTableHeaders/js/jquery.ba-throttle-debounce.min.js"></script>
<script src="assets/StickyTableHeaders/js/jquery.stickyheader.js"></script>
<script src="system/modules/tabela2/view/js/table-component.js"></script>
<script src="system/modules/histogram/principal.js"></script>
<style type="text/css">
    #seletor_ano2 {
        position: absolute;
        right: 10px;
        top: 65px;
        background-color: pink;
        padding: 10px;
    }
    #seletor_ano2 span{
        cursor: pointer;
        color: #aaa;
        text-align: center;
        width: 45px;
    }
    #seletor_ano2 .ano_atual{
        color: black;
        font-weight: bold;
    }
</style>
<script type="text/javascript">
    var local2;
    var map_indc2;
    var tab_indc;
    var path_dir = '<?= $path_dir ?>';
    var lang = '<?= $_SESSION["lang"] ?>';

    $(document).ready(function () {

        $("#espac_on_table").html(lang_mng.getString("mapa_espacialidade").toUpperCase());
        $("#selec_tb_01").html(lang_mng.getString("selecionar"));

        $("#limparTodasLinhasTabela").html(lang_mng.getString("limpar_lugares"));
        $("#limparTodosIndices").html(lang_mng.getString("limpar_indicadores"));

        map_indc2 = new LocalSelector();

        //retirado pois o método "map_indcator_selector_tabela" não estava fazendo absolutamente nada
        /*map_indc2.startSelector(true, "uimapindicator_selector_tabela",
         map_indcator_selector_tabela, "right", "uiindicator_selector_tabela_mult");*/

        tab_indc = new IndicatorSelector();
        html = tab_indc.html("uiindicator_selector_tabela_mult");
        $("#calloutIndicadores").append(html);
        $("#calloutIndicadores").append("<h5>" + lang_mng.getString("mapa_indicadores").toUpperCase() + "</h5>");
        /*tab_indc.startSelector(true, "uiindicator_selector_tabela_mult", tab_indcator_selector_tabela, "bottom", true, "uimapindicator_selector_tabela");*/
        tab_indc.startSelector(true, "modal-seletor-indicadores", tab_indcator_selector_tabela, "bottom", true, "uimapindicator_selector_tabela");
    });

    //retirado listener tabela inidicador, não era utilizado

    function tab_indcator_selector_tabela(array) {
        geral.setIndicadores(array);
        tabela_build(); // método que monta tabela
    }

    function listnerTabelaLocal(e, obj)
    {
        if (e == "changetab" || e == "reloadList") {
            // geral.removeIndicadoresExtras();
            map_indc2.refresh();
            lug = geral.getLugares();

            t = true;
            for (var i in lug) {
                try
                {
                    if (lug[i].l.length != 0) {
                        t = false;
                        break;
                    }
                } catch (e) {

                }
            }
            if (t) {
                fillEnptyTabela();
                loadingHolder.dispose();
                return;
            }

            tabela_build('');
        }
    }


    //map_indcator_selector_tabela retirado, não havia código nenhum na função

</script>

<div id="lugaresTabela22"></div>

<!-- ============= IFrama Histograma ================ -->
<div style="position: relative; z-index: 99999">
    <div id="iframeHistograma"></div>
</div>
<!-- ============================================== -->

<div class="titleTable">
    <div id="lugaresTabela"></div>
    <div class="titleLugares" onclick=''>
        <div id="uimapindicator_selector_tabela"
             style="float: right; margin-right: 0px;">
            <div class="divCallOutLugares">
                <button type="button" class="blue_button big_bt" id="button-fs" style="margin-right: 31px !important; font-size: 14px; height: 34px;"></button>
            </div>
        </div>
        <h5 id="btn-spatiality" data-toggle="tooltip" data-original-title="Tooltip on right"></h5>
    </div>
    <div class="titleIndices" id="calloutIndicadores"></div>
    <div class="iconAtlas">

        <!-- ======== Botão da agregação =========== --> 
        <!-- COMENTAR AS LINHAS 163 a 165 da tag button para retirar o botão de agregação -->
        <button data-toggle="modal" class="agregacao small_bt disabled" id="botao-agregacao-tabela" title="">
            Agregação
        </button>

        <!-- ======== Botão do Mapa =========== -->
        <button data-toggle="modal" class="gray_button small_bt disabled" id="imgTab2" data-original-title='Ver no mapa' title="" data-placement='bottom'>
            <img src="./assets/img/icons/brazil_gray.png">
        </button>
        
        <!-- ======== Botão do Mapa MapScript =========== -->
        <!--<button data-toggle="modal" class="gray_button small_bt disabled" id="imgTab4" data-original-title='Ver no mapa' title="" data-placement='bottom' onclick="changeAba(2,this);" value="" name="" type="button">-->
        <!--<button data-toggle="modal" class="gray_button small_bt" id="imgTab4" data-original-title='Ver no mapa' title="" data-placement='bottom'>
            <img src="./assets/img/icons/brazil_gray2.png">
        </button> -->

        <!--======== Botão do Histograma ===========--> 
        <!-- COMENTAR AS LINAS 181 a 183 da tag button abaixo para retirar o botão de histograma -->
        <button data-toggle="modal" class="gray_button small_bt disabled" id="imgTab3" data-original-title='O Histograma está disponível para municípios, estados e regiões metropolitanas.' title="" data-placement='top' >
            <img src="./assets/img/icons/bars_gray.png">
        </button>

        <div class="inIconAtlas">
            <form method="post" action="consulta/download/" target="_blank" id="form2">
                <input type="hidden" id="form2_lugares" name="form2_lugares" value="" /> 
                <input type="hidden" id="form2_indicadores" name="form2_indicadores" value="" />
            </form>
            <!-- ======== Botão de Download =========== -->
            <button class="gray_button big_bt disabled" id="imgTab6"  data-toggle="modal" data-target="#modalDownload" data-original-title='Download da lista em formato csv (compatível com o Microsoft Excel e outras planilhas eletrônicas).' title data-placement='bottom' icon="download_2" onclick="novaPagina(2)">
                <img src="assets/img/icons/download_2.png" />
            </button>
        </div>
    </div>
</div>

<!--<div class="modal fade" id="modalDownload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> -->
<div class="modal hide" id="modalDownload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Download</h4>
      </div>
      <div class="modal-body" id="modalDownload-body">
        ...
      </div>
      <div class="modal-footer" id="modalDownload-footer">
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Download</button>-->
      </div> 
    </div>
  </div>
</div>

<!-- HTML Alert AtlasBrasil.message -->
<div class="alert fade in general-alert">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h4 class="alert-header"></h4>
    <div class="alert-body"></div>
</div>
<!-- END HTML Alert AtlasBrasil.message  -->

<!-- HTML Modal AtlasBrasil.message -->
<div id="general-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Modal header</h3>
    </div>
    <div class="modal-body">
        <p>One fine body…</p>
    </div>
    <div class="modal-footer">
        <div class="modal-text-footer"></div>
        <div class="modal-buttons-footer">
            <!-- <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
            <button class="btn btn-primary">Ok</button> -->
        </div>
    </div>
</div>

<div id="general-modal-2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Modal header</h3>
    </div>
    <div class="modal-body">
        <p>One fine body…</p>
    </div>
    <div class="modal-footer">
        <div class="modal-text-footer"></div>
        <div class="modal-buttons-footer">
            <!-- <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
            <button class="btn btn-primary">Ok</button> -->
        </div>
    </div>
</div>

<div id="modal-espacialidade" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-body">
        <p>One fine body…</p>
    </div>
    <div class="modal-footer">
        <div class="modal-text-footer"></div>
        <div class="modal-buttons-footer">
            <!-- <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
            <button class="btn btn-primary">Ok</button> -->
        </div>
    </div>
</div>

<!-- END Modal AtlasBrasil.message -->
<div class="container" id="container-table-component">
    <div class="component" id="table-container">
        <div style="display: none;">
        <p class="texto-aviso-udh">
            <strong>Atenção </strong>UDHs com indicadores indênticos correspondem a recortes espaciais que foram agregados para fins de extração de dados.
            Para maiores explicações <a href="<?php echo $path_dir . "$ltemp" ?>/o_atlas/metodologia/construcao-das-unidades-de-desenvolvimento-humano/#limitacoes" target="_blank">clique aqui</a>.
        </p>
        </div>
    </div>
</div>
<!-- /container -->

<div id="containerTabela" style="position: relative; display:none;">

    <!-- ============= Mapa Personalizado ================ -->
    <div id="container_mapa_personalizado">
        <div class="toolbar_mapa_personalizado no-print" style="">
            <div class="iconAtlas">
                <button data-toggle="modal" class="gray_button small_bt" id="fechar_mapa"
                        data-original-title="Voltar para tabela" title="" data-placement="bottom">
                    <img src="./assets/img/icons/table_gray.png">
                </button>
                 <?php /*
                <button style="display:none;" class="gray_button big_bt disabled" id="download_csv"
                        data-original-title="Download da lista em formato csv (compatível com o Microsoft Excel e outras planilhas eletrônicas)."
                        title="" data-placement="bottom" icon="download_2" onclick="novaPagina(2)">
                    <img src="assets/img/icons/print_gray.png">
                </button> */ ?>
            </div>
        </div>
        <div id="titulo_mapa" class="titulo_mapa">
            <h3 class="titulo"></h3>
        </div>
        <div id="mapa_personalizado">
            <?php include BASE_ROOT . '/system/modules/map/view/ConsultaMapaView.php'; ?>
        </div>
    </div>
    
    <!-- msg max shapes mapa -->
    <div class="modal hide" id="modal-limite-espacialidades">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><?php echo $lang_mng->getString('mp_title_aviso'); ?></h3>
        </div>
        <div class="modal-body">
            <p><?php 
                $label_espacialidade_max_shapes = '<span id="max_espacialidade"></span>'; 
                $max_shapes = MAX_SHAPES;
                echo sprintf($lang_mng->getString('mp_max_shapes_msg'), $label_espacialidade_max_shapes, $max_shapes); ?></p>
        </div>
        <div class="modal-footer">
            <button class="blue_button" data-dismiss="modal" aria-hidden="true"><?php echo $lang_mng->getString('mp_close_btn_aviso'); ?></button>
        </div>
    </div>
    <!-- /msg max shapes mapa -->

    <!-- ============= Histograma ================ -->
    <div id="container_histograma" style="position: absolute; top: -58px; left: 0; z-index: 1039; display: none; width:100%; background: white; height: 745px;">
        <div style="background-color: white; padding-bottom: 10px; width: 100%; float: left; clear: both;">
            <div style="background-color: white; padding-bottom: 10px; width: 100%; float: left; clear: both; border-bottom: 1px solid #CCC;">
                <div class="iconAtlas">
                    <button data-toggle="modal" class="gray_button small_bt" id="fechar_histograma"
                            data-original-title="Voltar para tabela" title="" data-placement="bottom">
                        <img src="./assets/img/icons/table_gray.png">
                    </button>
                    <?php /*
                    <button class="gray_button big_bt disabled" id="imprimirHistograma"
                            data-original-title="Imprimir Histograma"
                            title="" data-placement="bottom" onclick="imprimir(2)">
                        <img src="assets/img/icons/print_gray.png">
                    </button> */ ?>
                </div>
            </div>
        </div>

        <div id="titulo_histograma" class="titulo_histograma">
            <div class="histograma" style="font-size: 20px; font-weight: bold; text-align: center; line-height: 1.3;"></div>
        </div>
        <!--        <div id="seletor_ano2">
                    <span id="1"
        <?php echo ($ano == 1) ? 'class="ano_atual"' : ''; ?>>1991</span>
                    <span id="2"
        <?php echo ($ano == 2) ? 'class="ano_atual"' : ''; ?>>2000</span>
                    <span id="3"
        <?php echo ($ano == 3) ? 'class="ano_atual"' : ''; ?>>2010</span>
                </div>-->
        <div id="iframe_histograma">
            <?php include BASE_ROOT . '/system/modules/histogram/view/histogramView.php'; ?>
        </div>
    </div>

    <div id="tabelaPlace">
        <div id="localTabelaConsulta"></div>
        <div style="clear: both"></div>
    </div> 
    <div id="pageNav"></div>
    <div id="loadingTabela"></div>


    <!-- aviso sem indicador -->
    <div id="aviso_sem_indicador" class="alert alert-danger">
        <button type="button" class="close">&times;</button>
        <?php echo $lang_mng->getString('mp_aviso_sem_indicador'); ?>
    </div>
    <!-- aviso sem indicador -->

</div>

<!-- INÍCIO MODAL DO SELETOR DE ESPACIALIDADE -->
<div class="modal hide fs modal-seletor-espacialidades">
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
        <div class="span4 selecteds">
            <div class="row-title-selecteds">
                <h3 id="title-selecteds">Selecionados</h3>
                <div class="save-list-alert" style="display:none;">
                    <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
                    <div class="alert-body">
                        Não há itens selecionados
                    </div>
                </div>
            </div>
            <div class="itens-selecteds"></div>    		
        </div>

    </div><!-- /.modal-body -->
    <div class="modal-footer row-fluid">
        <button type="button" class="btn gray_button" id="btn-minhas-listas" style="float:left; height: 30px;"></button>
        <button type="button" class="btn gray_button" id="btn-salvar-listas" style="float:left; height: 30px;"></button>


        <button type="button" class="blue_button big_bt btn-ok-fs" data-backdrop="false" data-dismiss="modal" style="float:right;height:30px;font-size: 11pt;">Ok</button>
        <button type="button" class="btn gray_button" id="btn-clean-selecteds" style="float:right; height: 30px;"></button>
    </div>
    <!-- MODAL DO SALVAR LISTAS DO USUÁRIO-->
    <div id="modal-seletor-lista-usuario" class="modal hide fade">
        <!--   <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Modal header</h3>
          </div> -->
        <div class="modal-body">
            <h3> Salvar lista </h3>
            <div style="padding:10px;">
                <p>A lista de espacialidades selecionadas ficará salva no cache do seu navegador para consultas futuras. Escreva um nome para a sua lista e clique em <strong>Salvar</strong></p>
                <!-- <p> Entre com o nome da lista: </p> -->
                <input type="text" class="" style="width: 96%;"/>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="blue_button big_bt btn-ok-fs-save-list btn-dismiss" data-backdrop="false" style="float:right;height:30px;font-size: 11pt;">Salvar</button>
            <button type="button" class="btn btn-default btn-dismiss" style="float:right; margin-right:10px;">Cancelar</button>
        </div>
    </div>
    <!-- FIM DO MODAL SALVAR LISTAS DO USUÁRIO -->
    <!-- </div><!-- /.modal-dialog -->
</div><!-- /.modal -->		
<!-- FIM MODAL DO SELETOR DE ESPACIALIDADE -->

<!-- MODAL DO SELETOR DE INDICADORES -->
<div id="modal-seletor-indicadores" class="modal hide">
    <!--   <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Modal header</h3>
      </div> -->
    <div class="modal-body">
        <p>One fine body…</p>
    </div>
    <div class="modal-footer">
        <!-- <a href="#" class="btn">Close</a>
        <a href="#" class="btn btn-primary">Save changes</a> -->
    </div>
</div>
<!-- FIM DO MODAL DO SELETOR DE INDICADORES -->

<!-- Modal -->
<div id="modalMapa" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="modalMapaLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="modalMapaLabel"><?php echo $lang_mng->getString('mp_label_exibir_espacialidade') ?></h4>
    </div>
    <div class="modal-body">
        <!-- espacialidade -->
        <div id="container_espacialidade"
             style="float: left; width: 100%; height: 100%; margin-right: 1px;">
            <ul id="lista_espacialidade">
                <li data-id="4"><?php echo $lang_mng->getString('mp_item_camada_estado'); ?></li>
                <!--<li data-id="6"><?php echo $lang_mng->getString('mp_item_camada_rm'); ?></li>-->
                <li data-id="2"><?php echo $lang_mng->getString('mp_item_camada_mun'); ?></li>
                <!--<li data-id="7"><?php echo $lang_mng->getString('mp_item_camada_ri'); ?></li>
                <li data-id="5"><?php echo $lang_mng->getString('mp_item_camada_udh'); ?></li>
                <li data-id="3"><?php echo $lang_mng->getString('mp_item_camada_reg'); ?></li>-->
            </ul>
        </div>
        <!-- /espacialidade -->

        <!-- indicador -->
        <div id="container_indicador">
            <ul id="lista_indicador"></ul>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer" style="display: none"></div>
        <!-- /indicador -->
    </div>
</div>

<div id="modalHist" class="modal hide" tabindex="-1" role="dialog"aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="modalLabelHist"><?php echo $lang_mng->getString('mp_label_exibir_espacialidade') ?></h4>
    </div>
    <div class="modal-body">
        <!-- espacialidade -->
        <div id="container_espacialidade_histograma" style="float: left; width: 100%; height: 100%; margin-right: 1px;">
            <ul id="lista_espacialidade_histograma">
                <li data-id="4"><?php echo $lang_mng->getString('mp_item_camada_estado'); ?></li>
                <li data-id="6"><?php echo $lang_mng->getString('mp_item_camada_rm'); ?></li>
                <li data-id="2"><?php echo $lang_mng->getString('mp_item_camada_mun'); ?></li>
                <li data-id="5"><?php echo $lang_mng->getString('mp_item_camada_udh'); ?></li>
            </ul>
        </div>
        <!-- /espacialidade -->

        <!-- indicador -->
        <div id="container_indicador_histograma" style="float: left; width: 100%; height: 100%; display: none;">
            <ul id="lista_indicador_histograma"></ul>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer" style="display: none"></div>
        <!-- /indicador -->
    </div>
</div>
<!-- /Modal -->

<!-- aviso sem indicador -->
<div id="aviso_sem_indicador" class="alert alert-danger">
    <button type="button" class="close">&times;</button>
    <?php echo $lang_mng->getString('mp_aviso_sem_indicador'); ?>
</div>
<!-- aviso sem indicador -->

<!--  Mapa embutido -->
<script type="text/javascript">
    // internacionalização
    $("#botao-agregacao-tabela").html(lang_mng.getString('title_agregacao'));




    // seta ano padrão de acordo config.
    $('#mapa_personalizado').data('ano_sel', <?php echo ANO_PADRAO; ?>);
    
    var map2 = false;
    
    /**
     * Função que retorna as espacialidades selecionadas pelo usuário/componente.
     *
     * @param {string|number} id
     * @return {string}
     */
    function getEspacialidade(id) {
        var arrayDeEspacialidades = seletor.getSelectedsItens(), retorno;

        if (!$.isArray(arrayDeEspacialidades) || arrayDeEspacialidades.length === 0) {
            return '';
        }

        // filtra pelo id da espacialidade
        retorno = $(arrayDeEspacialidades).filter(function () {
            return (+this['e'] === +id);
        });
        return retorno[0]['l'];
    }

    /**
     * Função que retorna as espacialidades selecionadas pelo usuário, 
     * filtrada pelo seu tipo: est, mun, rm e reg.
     *
     * @example est, mun, rm ou reg.
     * @param {string} tipo O tipo da espacialidade de acordo com o protocolo.
     * @param {string|number} id Id referente a espacialidade.
     * @return {string}
     */
    function getEspacialidadeDeTipo(tipo, id) {
        var itens = seletor.getSelectedsItens(), ret;

        if (!$.isArray(itens) || itens.length === 0) {
            return '';
        }
        ret = $(itens).filter(function () {
            return (+this['e'] === +id);
        });

        return ret[0][tipo];
    }


    /**
     * Função que verifica se alguma espacialidade 
     * já foi selecionada pelo usuário.
     *
     * @return {boolean}
     */
    function existeEspacialidadeSelecionada() {
        return $(seletor.getSelectedsItens()).filter(function () {
            return (($.isArray(this.l) && this.l.length > 0)
                    || ($.isArray(this.est) && this.est.length > 0)
                    || ($.isArray(this.mun) && this.mun.length > 0)
                    || ($.isArray(this.udh) && this.udh.length > 0)
                    || ($.isArray(this.rm) && this.rm.length > 0));
        });
    }

    /**
     * Alerta falta de indicador.
     * 
     */
    function mostraAvisoSemIndicador() {
        var screenWidth = $('.defaltWidthContent').innerWidth();
        var alertWidth = $('#aviso_sem_indicador').innerWidth();
        
        $('#aviso_sem_indicador').css('left', screenWidth / 2 - alertWidth / 2).show();

        setTimeout(function () {
            $('#aviso_sem_indicador').hide();
        }, 3000); // fecha automaticamente após 3 segs
    }

    $(document).ready(function () {

        $('#fechar_mapa').click(function () {
            // limpa cache contexto e espacialidade
            MAPA_API.setContexto(null);
            MAPA_API.setEspacialidade(null);
            
            $("#container_mapa_personalizado,#legenda_mapa,#containerTabela,.fixedTable,#aviso_1991").hide();
            $('#container-table-component').show();
        });


        $('#aviso_sem_indicador .close').click(function () {
            $(this).parent().hide();
        });

        $('#imgTab2').click(function () {
            var indicadores = geral.getIndicadores(),
            espacialidades = seletor.getSelecteds();
            
            map2 = false;

            if (($.isArray(indicadores) && indicadores.length === 0) 
                    || ($.isArray(espacialidades) && espacialidades.length === 0)) {
                mostraAvisoSemIndicador();
            } else {
                $('#container_espacialidade').show();
                $('#container_indicador').hide();

                $('#modalMapaLabel').text(lang_mng.getString('mp_label_exibir_espacialidade'));

                var numItens = 0, itemIdAtual;

                $(seletor.getSelectedsItens()).each(function (i, item) {
                    if (typeof item.l !== 'undefined'
                            && ($.isArray(item.l) && item.l.length > 0)
                            || ($.isArray(item.est) && item.est.length > 0)
                            || ($.isArray(item.mun) && item.mun.length > 0)
                            || ($.isArray(item.udh) && item.udh.length > 0)
                            || ($.isArray(item.rm) && item.rm.length > 0)) {
                        $("#lista_espacialidade li[data-id='" + item.e + "']").css('display', 'block');
                        numItens++;
                        itemIdAtual = item.e;
                    } else {
                        $("#lista_espacialidade li[data-id='" + item.e + "']").css('display', 'none');
                    }
                });

                if (numItens === 1) {
                    $("#lista_espacialidade li[data-id=" + itemIdAtual + "]").trigger('click');

                    if ($.isArray(indicadores) && indicadores.length > 1) {
                        $('#modalMapa').modal('show');
                    }
                } else {
                    $('#modalMapa').modal('show');
                }
            }
        });

        $('#imgTab4').click(function () {
            var indicadores = geral.getIndicadores(),
                    espacialidades = seletor.getSelecteds();

            map2 = true;

            if (($.isArray(indicadores) && indicadores.length === 0) ||
                    ($.isArray(espacialidades) && espacialidades.length === 0)) {
                mostraAvisoSemIndicador();
            } else {
                $('#container_espacialidade').show();
                $('#container_indicador').hide();

                $('#modalMapaLabel').text(lang_mng.getString('mp_label_exibir_espacialidade'));

                var numItens = 0, itemIdAtual;

                $(seletor.getSelectedsItens()).each(function (i, item) {
                    if (typeof item.l !== 'undefined'
                            || ($.isArray(item.l) && item.l.length > 0)
                            || ($.isArray(item.est) && item.est.length > 0)
                            || ($.isArray(item.mun) && item.mun.length > 0)
                            || ($.isArray(item.udh) && item.udh.length > 0)
                            || ($.isArray(item.rm) && item.rm.length > 0)) {
                        $("#lista_espacialidade li[data-id='" + item.e + "']").css('display', 'block');
                        numItens++;
                        itemIdAtual = item.e;
                    } else {
                        $("#lista_espacialidade li[data-id='" + item.e + "']").css('display', 'none');
                    }
                }); // fim each

                if (numItens === 1) {
                    $("#lista_espacialidade li[data-id=" + itemIdAtual + "]").trigger('click');

                    if ($.isArray(indicadores) && indicadores.length > 1) {
                        $('#modalMapa').modal('show');
                    }
                } else {
                    $('#modalMapa').modal('show');
                }
            }
        });

        $("#lista_espacialidade").delegate('li', 'click', function () {
            var indicadorAtual,
                    indicadores,
                    mapaAnoId = ['1991', '2000', '2010'];

            var $this = $(this),
                    $lista_indicador = $('#lista_indicador'),
                    $mapa_personalizado = $('#mapa_personalizado');

            $lista_indicador.find("li").remove();

            indicadores = geral.getIndicadores();
            $(indicadores).each(function (i, item) {
                $lista_indicador.append('<li data-id="' + item['id'] + '" data-ano-id="' + item['a'] + '"><span class="nome">' + item['nc'] + '</span> (' + mapaAnoId[(item['a'] - 1)] + ')</li>');
            });

            $mapa_personalizado
                    .data('nome_espacialidade', $this.text())
                    .data('espacialidade_sel', $this.attr('data-id'));


            // testa se há somente um indicador para escolha automatica
            if (indicadores.length === 1) {
                indicadorAtual = indicadores[0];

                $('#modalMapa').modal('hide');
//                $("#container-table-component").hide();
                $("#containerTabela").show();


                $mapa_personalizado
                        .data('nome_indicador', indicadorAtual['desc'])
                        .data('indicador_sel', indicadorAtual['id'])
                        .data('ano_sel', indicadorAtual['a']);

                if (map2) {
                    //geral.setListenerIndicadores(map_listener_indicador);
                    //geral.setListenerLugares(map_listener_lugar);
                    //geral.dispatchListeners('changetab');
                    changeAba(2, this);
                }
                else {
                    verificaMapaPersonalizado();
                }

            } else {                
                $('#container_espacialidade').hide();
                $('#container_indicador').show();
                $('#modalMapaLabel').text(lang_mng.getString('mp_label_exibir_indicador'));
            }
        });

        $("#lista_indicador").delegate('li', 'click', function () {
            var $this = $(this);

            $('#modalMapa').modal('hide');
//            $("#container-table-component").hide();
            $("#containerTabela").show();

            $('#mapa_personalizado')
                    .data('nome_indicador', $this.find('.nome').text())
                    .data('indicador_sel', $this.attr('data-id'))
                    .data('ano_sel', $this.attr('data-ano-id'));

            if (map2) {
                changeAba(2, this);
            } else {
                verificaMapaPersonalizado();
            }
        });
    });

    /**
     * Aviso máximo de shapes selecionados. 
     * 
     * @param {string} espacialidade Espacialidade selecionada.
     * @return {undefined}
     */
    function showAvisoMaxEspacialidades(espacialidade) {
        $('#max_espacialidade').text(espacialidade); 
        $('#modal-limite-espacialidades').modal('show');
    }

    $('#modal-limite-espacialidades').on('hidden', function () {
        // todo:
        $('#containerTabela,.fixedTable').hide();
        
        $('#button-fs').trigger('click');
    });

    /**
     * Contexto a partir do protocolo de comnicação.
     * 
     * @param {object} params Ver protocolo de comunicação.
     * @param {number} espacialidade
     * @return {number} Contexto
     */
    function getContextoFromUrlParams(params, espacialidade) {
        var result = null;
        
        if (!params) {
            return null;
        }

        if ('udh' in params && ($.isArray(params.udh) && params.udh.length > 0)) {  
            result = ESP_CONSTANTES.udh; 
        }
        
        if ('mun' in params && ($.isArray(params.mun) && params.mun.length > 0)) { 
            result = ESP_CONSTANTES.municipal; 
        }
        
        if ('rm' in params && ($.isArray(params.rm) && params.rm.length > 0)) { 
            result = ESP_CONSTANTES.regiaometropolitana; 
        }
        
        if ('est' in params && ($.isArray(params.est) && params.est.length > 0)) { 
            result = ESP_CONSTANTES.estadual;
        }
        
        if ('id' in params && ($.isArray(params.id) && params.id.length > 0)) { 
            result = espacialidade; 
        }

        return result;
    }

    /**
     * Constrói object que será utilizado para query params de AJAX.
     * 
     * @param {number} espacialidade
     * @returns {object}     
     */
    function getUrlParamsToMapQuery(espacialidade) {
        return {
            id  : getEspacialidade(espacialidade),
            est : getEspacialidadeDeTipo('est', espacialidade),
            //rm  : getEspacialidadeDeTipo('rm', espacialidade),
            //udh : getEspacialidadeDeTipo('udh', espacialidade),
            mun : getEspacialidadeDeTipo('mun', espacialidade)
        };
    }


    /**
     * Verifica número de espacialidade antes do Mapa personalizado.
     * 
     */
    function verificaMapaPersonalizado() {
        var self = this, params, baseUrl, espacialidade,
                $mapa_personalizado = $('#mapa_personalizado');

        espacialidade = $mapa_personalizado.data('espacialidade_sel');
        
        // parâmetros AJAX
        params = getUrlParamsToMapQuery(espacialidade);
        params = $.extend({
            tipo            : 'total',
            contexto        : getContextoFromUrlParams(params, espacialidade),
            espacialidade   : espacialidade,
            indicador       : $mapa_personalizado.data('indicador_sel'),
            ano             : $mapa_personalizado.data('ano_sel')
        }, params);

        // url mapa serviço
        baseUrl = MAPA_API.getBaseUrl() + 'system/modules/map/controller/MapService.php';

        $.ajax({
            type        : 'get',
            dataType    : 'json',
            data        : $.param(params),
            cache       : false,
            url         : baseUrl,
            beforeSend  : function () {
                MAPA_API.mostraAvisoCarregando();
            },
            error       : function (err) {
                if (self._debug) {
                    console && console.log(err);
                }
            },
            success     : function (resposta) {
                if (resposta['sucesso']) {
                    if (+resposta.retorno['__total__'] > <?php echo MAX_SHAPES; ?>) {
                        var espacialidadeSelecionada = $('#mapa_personalizado').data('espacialidade_sel'),
                                espacialidade = $('#lista_espacialidade').find('li[data-id=' + espacialidadeSelecionada + ']').text();
                        
                        MAPA_API.fechaAvisoCarregando(function() {
                            showAvisoMaxEspacialidades(espacialidade);
                        });                        
                        
                    } else {
                        // esconde tabela antes de mostrar mapa
                        $("#container-table-component").hide();

                        mapaPersonalizado();
                    }
                }
            }
        });
    }


    /**
     * Mostra o mapa personalizado do tabela.
     * 
     * @param {boolean=} centralizaMapa Por padrão centraliza o mapa.
     * @param {boolean=} somenteValores Apenas atualiza valores.
     */
    function mapaPersonalizado(centralizaMapa, somenteValores) {
        var params, contexto, espacialidade, indicador, ano,
                $mapa_personalizado = $('#mapa_personalizado');

        var tituloMapa = 
                '<div class="tipo_mapa">' + lang_mng.getString('mp_mapa') + ' / ' + $mapa_personalizado.data('nome_espacialidade') + '</div>' +
                '<div class="nome_indicador">' + $mapa_personalizado.data('nome_indicador') + '</div>';
        
        $('#titulo_mapa .titulo').html(tituloMapa);

        espacialidade   = $mapa_personalizado.data('espacialidade_sel');
        indicador       = $mapa_personalizado.data('indicador_sel');
        ano             = $mapa_personalizado.data('ano_sel');

        params = getUrlParamsToMapQuery(espacialidade);
        
        contexto = getContextoFromUrlParams(params, espacialidade);
        
        $('#container_mapa_personalizado').show();

        if (!centralizaMapa) {
            MAPA_API.atualizaMapa();
            MAPA_API.centralizaMapa();
        }

        MAPA_API.mapQuery(
            params,
            contexto,
            espacialidade,
            indicador,
            ano,
            somenteValores
        );

        $('#seletor_ano span').removeClass('ano_atual');
        $('#ano_' + ano).addClass('ano_atual');
        
        if (GMaps.testaDados1991(espacialidade, indicador, ano)) {
            MAPA_API.mostraAviso1991(true);
        }
    }


    </script>
<!--  /mapa embutido -->

<?php 

    // para resolver conflito bootstrap css colocar aqui
    include BASE_ROOT . '/system/modules/map/components/ModalFaixasLegendaPersonalizada.php';


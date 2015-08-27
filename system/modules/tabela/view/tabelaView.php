<link rel="stylesheet" href="assets/css/filter-search.css">

<script src="system/modules/tabela/view/builder.tabela.js" type="text/javascript" charset="utf-8"></script>
<script	src="system/modules/seletor-espacialidade/view/js/filter-search.js"></script>
<script	src="system/modules/seletor-espacialidade/view/js/seletor-espacialidade.js"></script>

<script type="text/javascript">
    var local2;
    var map_indc2;
    var tab_indc;
    var url = '';

    $(document).ready(function() {
        $("#espac_on_table").html(lang_mng.getString("mapa_espacialidade").toUpperCase());
        $("#selec_tb_01").html(lang_mng.getString("selecionar"));

        $("#limparTodasLinhasTabela").html(lang_mng.getString("limpar_lugares"));
        $("#limparTodosIndices").html(lang_mng.getString("limpar_indicadores"));

        map_indc2 = new LocalSelector();

        map_indc2.startSelector(true, "uimapindicator_selector_tabela",
                map_indcator_selector_tabela, "right", "uiindicator_selector_tabela_mult");

        tab_indc = new IndicatorSelector();
        html = tab_indc.html("uiindicator_selector_tabela_mult");
        $("#calloutIndicadores").append(html);
        $("#calloutIndicadores").append("<h5>" + lang_mng.getString("mapa_indicadores").toUpperCase() + "</h5>");
        tab_indc.startSelector(true, "uiindicator_selector_tabela_mult", tab_indcator_selector_tabela, "bottom", true, "uimapindicator_selector_tabela");
    });

    function montaUrl(dataHistograma) {
        var espacialidade = dataHistograma.e;
        var lugares = replaceAllChars(',', '_', dataHistograma.l);
        var indicador = dataHistograma.i;
        var ano = dataHistograma.a;
        url = '<?= $path_dir . $_SESSION['lang'] ?>' + '/histograma_print/' + dataHistograma.e + '/' + lugares + '/' + dataHistograma.i + '/' + dataHistograma.a + '/';
    }

    function imprimir(opcao) {
        window.open(url, '_blank');
    }

    function listnerTabelaIndicadores(obj)
    {
        //tabela_build('');
    }

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


    function map_indcator_selector_tabela(array)
    {

    }

</script>
<script src="system/modules/histogram/principal.js"></script>
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


        <!-- ======== Botão do Mapa =========== -->
        <button data-toggle="modal" class="gray_button small_bt" id="imgTab2" data-original-title='Ver no mapa' title="" data-placement='bottom'>
            <img src="./assets/img/icons/brazil_gray.png">
        </button>

         <!--======== Botão do Histograma ===========--> 
        <button data-toggle="modal" class="gray_button small_bt" id="imgTab3" data-original-title='Ver no Histograma' title="" data-placement='bottom'>
            <img src="./assets/img/icons/bars_gray.png">
        </button>

        
        <div class="inIconAtlas">
            <form method="post" action="consulta/download/" target="_blank" id="form2">
                <input type="hidden" id="form2_lugares" name="form2_lugares" value="" /> 
                <input type="hidden" id="form2_indicadores" name="form2_indicadores" value="" />
            </form>
            <!-- ======== Botão de Download =========== -->
            <button class="gray_button big_bt" id="imgTab6"  data-toggle="modal" data-target="#modalDownload" data-original-title='Download da lista em formato csv (compatível com o Microsoft Excel e outras planilhas eletrônicas).' title data-placement='bottom' icon="download_2" onclick="novaPagina(2)">
                <img src="assets/img/icons/download_2.png" />
            </button>
            
            <!--<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" onclick="novaPagina(2)">
				demo modal
			</button>-->
            
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


<div id="containerTabela" style="position: relative;">

    <!-- ============= Mapa Personalizado ================ -->
    <div id="container_mapa_personalizado" style="position: absolute; top: -58px; left: 0; z-index: 999; display: none; width:100%;">
        <div style="background-color: white; padding-bottom: 10px; width: 100%; float: left; clear: both; border-bottom: 1px solid #ccc;">
            <div class="iconAtlas">
                <button data-toggle="modal" class="gray_button small_bt" id="fechar_mapa"
                        data-original-title="Voltar para tabela" title="" data-placement="bottom">
                    <img src="./assets/img/icons/table_gray.png">
                </button>
                <button class="gray_button big_bt disabled" id="download_csv"
                        data-original-title="Download da lista em formato csv (compatível com o Microsoft Excel e outras planilhas eletrônicas)."
                        title="" data-placement="bottom" icon="download_2" onclick="novaPagina(2)" disabled="disabled">
                    <img src="assets/img/icons/download_2.png">
                </button>
            </div>
        </div>
        <div id="titulo_mapa" class="titulo_mapa">
            <h3></h3>
        </div>
        <div id="mapa_personalizado">
            <?php include BASE_ROOT . '/system/modules/map/view/ConsultaMapaView.php'; ?>
        </div>
    </div>

    <!-- ============= Histograma ================ -->
    <div id="container_histograma" style="position: absolute; top: -58px; left: 0; z-index: 99999; display: none; width:100%; background: white; height: 745px;">
        <div style="background-color: white; padding-bottom: 10px; width: 100%; float: left; clear: both;">
            <div style="background-color: white; padding-bottom: 10px; width: 100%; float: left; clear: both; border-bottom: 1px solid #CCC;">
                <div class="iconAtlas">
                    <button data-toggle="modal" class="gray_button small_bt" id="fechar_histograma"
                            data-original-title="Voltar para tabela" title="" data-placement="bottom">
                        <img src="./assets/img/icons/table_gray.png">
                    </button>
                    <button class="gray_button big_bt" id="imprimirHistograma"
                            data-original-title="Imprimir Histograma"
                            title="" data-placement="bottom" onclick="imprimir(2)">
                        <img src="assets/img/icons/print_gray.png">
                    </button>
                </div>
            </div>
        </div>

        <div id="titulo_histograma" class="titulo_histograma">
            <div class="histograma" style="font-size: 20px; font-weight: bold; text-align: center; line-height: 1.3;"></div>
        </div>
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
    <div id="aviso_sem_indicador" class="alert alert-danger"
         style="position: absolute; top: 15px; left: 250px; display: none; padding: 10px; height: auto;">
        <button type="button" class="close">&times;</button>
        <?php echo $lang_mng->getString('mp_aviso_sem_indicador'); ?>
    </div>
    <!-- aviso sem indicador -->

</div>

<!-- INÍCIO MODAL DO SELETOR DE ESPACIALIDADE -->
<div class="modal hide fs">
    <!-- <div class="modal-dialog"> -->
    <div class="modal-body">
        <!-- <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Modal title</h4>
        </div> -->
        <div class="span8 left-content">
            <div class="row-fluid row-search">
                <div class="span12">
                    <div class="form-inline">
                        <input type="text" class="input-large input-fs-search">

<!-- <span class="input-group-btn">
  <button class="btn btn-default button-fs-search" type="button"><i class="icon-search" style="margin: 3px;"></i></button>
</span> -->
                    </div><!-- /input-group -->
                </div><!-- /.span-6 -->					  
            </div>
            <div class="row-fluid">
                <div class="mensagem" id="msg-bottom-search"></div>
            </div>
            <div class="row-fluid selectors">
                <!-- <div class="container-fluid">
                        
                </div> -->
            </div>
        </div>
        <div class="span4 selecteds">
            <div class="row-title-selecteds">
                <h3 id="title-selecteds">Selecionados</h3>
            </div>
            <div class="itens-selecteds"></div>    		
        </div>

    </div><!-- /.modal-body -->
    <div class="modal-footer row-fluid">
        <button type="button" class="blue_button big_bt btn-ok-fs" data-backdrop="false" data-dismiss="modal" style="float:right;height:30px;font-size: 11pt;">Ok</button>
        <button type="button" class="btn btn-default" id="btn-clean-selecteds" style="float:right;"></button>
    </div>
    <!-- </div><!-- /.modal-dialog -->
</div><!-- /.modal -->		
<!-- FIM MODAL DO SELETOR DE ESPACIALIDADE -->


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
                <li data-id="6"><?php echo $lang_mng->getString('mp_item_camada_rm'); ?></li>
                <li data-id="2"><?php echo $lang_mng->getString('mp_item_camada_ri'); ?></li>
                <li data-id="2"><?php echo $lang_mng->getString('mp_item_camada_mun'); ?></li>
                <li data-id="5"><?php echo $lang_mng->getString('mp_item_camada_udh'); ?></li>
            </ul>
        </div>
        <!-- /espacialidade -->

        <!-- indicador -->
        <div id="container_indicador"
             style="float: left; width: 100%; height: 100%; display: none;">
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

<!-- aviso sem indicador --
<div id="aviso_sem_indicador" class="alert alert-danger"
     style="position: absolute; top: 125px; left: 450px; display: none; padding: 10px; height: auto;">
    <button type="button" class="close">&times;</button>
<?php echo $lang_mng->getString('mp_aviso_sem_indicador'); ?>
</div>
<!-- aviso sem indicador -->

<!--  Mapa embutido -->
<script type="text/javascript">
    // ANO PADRÃO
    $('#mapa_personalizado').data('ano_sel', <?php echo ANO_PADRAO; ?>);

    /**
     * Função que retorna as espacialidades selecionadas pelo usuário.
     *
     * @param {String} espacialidadeId Id da espacialidade.
     * @return {String}
     */
    function getIds(espacialidadeId) {
        var l = geral.getLugaresStringCC(), r;

        if (!$.isArray(l) || l.length === 0) {
            return '';
        }

        r = $(l).filter(function() {
            return (+this['e'] === +espacialidadeId);
        });

        return r[0]['ids'].split(',');
    }

    /**
     * Função que retorna as espacialidades selecionadas pelo usuário.
     *
     * @param {String} tipo O tipo da espacialidade de acordo com o protocolo.
     * @param {String|Integer} id Id referente a espacialidade.
     * @return {String}
     */
    function converteParaTipoPeloId(tipo, id) {
        var l = seletor.getSelectedsItens(), r;

        if (!$.isArray(l) || l.length === 0) {
            return '';
        }
        r = $(l).filter(function() {
            return (+this['e'] === +id);
        });

        return r[0][tipo];
    }


    /**
     * Função que verifica se alguma espacialidade 
     * já foi selecionada pelo usuário.
     *
     * @return {Boolean}
     */
    function verificaSeExisteEspacialidade() {
        return $(seletor.getSelectedsItens()).filter(function() {
            return (($.isArray(this.l) && this.l.length > 0)
                    || ($.isArray(this.est) && this.est.length > 0)
                    || ($.isArray(this.mun) && this.mun.length > 0)
                    || ($.isArray(this.udh) && this.udh.length > 0)
                    || ($.isArray(this.rm) && this.rm.length > 0));
        });
    }

    /**
     * Alerta falta de indicador.
     */
    function mostraAvisoSemIndicador() {
        var screenWidth = $('.defaltWidthContent').innerWidth(),
                alertWidth = $('#aviso_sem_indicador').innerWidth();

        $('#aviso_sem_indicador').css('left', screenWidth / 2 - alertWidth / 2).show();

        setTimeout(function() {
            $('#aviso_sem_indicador').hide();
        }, 3000); // fecha automaticamente após 3 segs
    }

    $(document).ready(function() {
        // fechar mapa personalizado retornando a tabela
        $('#fechar_mapa').click(function() {
            $('#container_mapa_personalizado').hide();
        });

        // fechar aviso não há indicador selecionado
        $('#aviso_sem_indicador .close').click(function() {
            $(this).parent().hide();
        });

        // gera mapa personalizado
        $('#imgTab2').click(function() {
            var ind = geral.getIndicadores(),
                    esp = verificaSeExisteEspacialidade();

            if (($.isArray(ind) && ind.length === 0) || ($.isArray(esp) && esp.length === 0)) {
                mostraAvisoSemIndicador();
            } else {
                $('#container_espacialidade').show();
                $('#container_indicador').hide();

                $('#modalMapaLabel').text(lang_mng.getString('mp_label_exibir_espacialidade'));

                // mostra espacialidades válidas
                var numItens = 0, itemIdAtual;
                $(seletor.getSelectedsItens()).each(function(i, item) {
                    if (typeof item.l !== 'undefined'
                            || ($.isArray(item.l) && item.l.length > 0)
                            || ($.isArray(item.est) && item.est.length > 0)
                            || ($.isArray(item.mun) && item.mun.length > 0)
                            || ($.isArray(item.udh) && item.udh.length > 0)
                            || ($.isArray(item.rm) && item.rm.length > 0)
                            ) {
                        $("#lista_espacialidade li[data-id='" + item.e + "']").css('display', 'block');
                        numItens++;
                        itemIdAtual = item.e;
                    } else {
                        $("#lista_espacialidade li[data-id='" + item.e + "']").css('display', 'none');
                    }
                });

                // se houver somente uma espacialidade, seleciona automaticamente
                if (numItens === 1) {
                    $("#lista_espacialidade li[data-id=" + itemIdAtual + "]").trigger('click');

                    // se houver uma espacialidade e vários indicadores 
                    // escolher um dos indicadores
                    if ($.isArray(ind) && ind.length > 1) {
                        $('#modalMapa').modal('show');
                    }
                } else {
                    $('#modalMapa').modal('show');
                }
            }
        });

        // lista de espacialidades em que será escolhido 
        // para ser mostrar no mapa personalizado
        $("#lista_espacialidade").delegate('li', 'click', function() {
            var indicadorAtual,
                    indicadores,
                    mapaAnoId = ['1991', '2000', '2010'],
                    $this = $(this),
                    $lista_indicador = $('#lista_indicador'),
                    $mapa_personalizado = $('#mapa_personalizado');

            // remove listagem anterior
            $lista_indicador.find("li").remove();

            // cria nova listagem
            indicadores = geral.getIndicadores();
            $(indicadores).each(function(i, item) {
                $lista_indicador.append('<li data-id="' + item['id'] + '" data-ano-id="' + item['a'] + '"><span class="nome">' + item['nc'] + '</span> (' + mapaAnoId[(item['a'] - 1)] + ')</li>');
            });

            // espacialidade global
            $mapa_personalizado
                    .data('nome_espacialidade', $this.text())
                    .data('espacialidade_sel', $this.attr('data-id'));

            // testa se há somente um indicador, escolhe automaticamente
            if (indicadores.length === 1) {
                indicadorAtual = indicadores[0];

                $('#modalMapa').modal('hide');

                // valores do indicador atual 
                // para mostrar no título do mapa
                $mapa_personalizado
                        .data('nome_indicador', indicadorAtual['desc'])
                        .data('indicador_sel', indicadorAtual['id'])
                        .data('ano_sel', indicadorAtual['a']);

                // mapa
                mostraMapaPersonalizado();
            } else {
                $('#container_espacialidade').hide();
                $('#container_indicador').show();
                $('#modalMapaLabel').text(lang_mng.getString('mp_label_exibir_indicador'));
            }
        });

        $("#lista_indicador").delegate('li', 'click', function() {
            var $this = $(this);

            $('#modalMapa').modal('hide');

            // seta novos valores atuais para mapa personalizado
            $('#mapa_personalizado')
                    .data('nome_indicador', $this.find('.nome').text())
                    .data('indicador_sel', $this.attr('data-id'))
                    .data('ano_sel', $this.attr('data-ano-id'));

            mostraMapaPersonalizado();
        });
    });


    /**
     * Mostra o mapa personalizado do tabela.
     * 
     * @param {Boolean|null} centralizaMapa Por padrão centraliza o mapa.
     * @return {void} 
     */
    function mostraMapaPersonalizado(centralizaMapa) {
        var params, espacialidadeSelecionada;
        var $mapa_personalizado = $('#mapa_personalizado');

        espacialidadeSelecionada = $mapa_personalizado.data('espacialidade_sel');

        // título mapa personalizado
        $('#titulo_mapa h3').html(
                lang_mng.getString('mp_mapa') + ' / ' +
                $mapa_personalizado.data('nome_espacialidade') + '<br />' +
                $mapa_personalizado.data('nome_indicador'));

        params = getUrlParamsToMapQuery(espacialidadeSelecionada);

        // mostra o mapa personalizado
        $('#container_mapa_personalizado').show();

        // refresh mapa 
        // posicionando no centro do mapa
        if (!centralizaMapa) {
            MAPA_API.atualizaMapa();
            MAPA_API.centralizaMapa();
        }

        // faz consulta personalizada
        MAPA_API.mapQuery(
                params,
                espacialidadeSelecionada,
                espacialidadeSelecionada,
                $mapa_personalizado.data('indicador_sel'),
                $mapa_personalizado.data('ano_sel'));

        // seta o ano escolhido do indicador
//        $('#seletor_ano span').removeClass('ano_atual');;
//        $('#ano_' + $mapa_personalizado.data('ano_sel')).addClass('ano_atual');

        // posiciona o foco para o mapa
        $('html, body').scrollTop(285);
    }


</script>
<!--  /mapa embutido -->
<?php
ob_start();

require_once BASE_ROOT . '/config/conexao.class.php';
require_once dirname(__FILE__) . '/../init.php';
require_once dirname(__FILE__) . '/../model/autoload.php';

ini_set('display_errors', DISPLAY_ERRORS);

$conexao = new Conexao();
$bd = new Bd($conexao->open());

$rm_dao = new RmDao($bd);
$lista_rm = $rm_dao->getContexto();
$json_lista_rm = json_encode($lista_rm->toArray());

$estado_dao = new EstadoDao($bd);
$lista_estados = $estado_dao->getContexto();
$json_lista_uf = json_encode($lista_estados->toArray());


/*
 * Configuração do mapa.
 */
$mapa_espacialidade = array(
    ESP_REGIAOMETROPOLITANA => array(
        'sufixo_var'    => 'RM',
        'nome'          => $lang_mng->getString('mp_item_contexto_rm')
    ),
    ESP_ESTADUAL => array(
        'sufixo_var'    => 'UF',
        'nome'          => $lang_mng->getString('mp_item_contexto_estado')
    ),
    ESP_PAIS => array(
        'nome'          => $lang_mng->getString('mp_item_contexto_brasil')
    )
);
?>

<!-- css -->
<link rel="stylesheet" type="text/css" href="<?php echo $path_dir; ?>system/modules/map/assets/css/cupertino/jquery-ui-1.10.4.custom.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $path_dir; ?>system/modules/map/assets/css/componentes.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $path_dir; ?>system/modules/map/assets/css/mapa.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $path_dir ?>system/modules/map/assets/css/seletor_indicador.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $path_dir; ?>system/modules/map/assets/css/indicadores.css" />
<style type="text/css">.containerPage { margin-right: 0; }</style>
<!-- /css -->

<div id="content">
    <!-- carregando -->
    <div id="carregando_mapa" style="color: #555; min-height: 500px;">
        <img src="./assets/img/loader.gif" alt=""> <span id="msg"><?php echo $lang_mng->getString("mp_aviso_carregando_mapa"); ?></span>
    </div>
    <!-- /carregando -->
    
    <!-- mapa -->
    <div id="tab_map" style="position: relative; display: none;">

        <?php include_once dirname(__FILE__) . '/../components/SeletorIndicador.php'; ?>

        <div class="container">
            <div class="row-fluid">
                <div id="map-canvas" style="min-height: 500px; width: 100%;"></div>
                
                <?php
                // Componentes
                require_once dirname(__FILE__) . '/../components/Legenda.php';
                require_once dirname(__FILE__) . '/../components/CampoBusca.php';
                require_once dirname(__FILE__) . '/../components/SeletorIndicadorAtual.php';
                require_once dirname(__FILE__) . '/../components/SeletorAno.php';
                require_once dirname(__FILE__) . '/../components/SeletorEspacialidade.php';
                require_once dirname(__FILE__) . '/../components/SeletorTipoMapa.php';
                require_once dirname(__FILE__) . '/../components/IndicadorContextoAtual.php';
                require_once dirname(__FILE__) . '/../components/SeletorContexto.php';
                require_once dirname(__FILE__) . '/../components/SliderTransparencia.php';
                require_once dirname(__FILE__) . '/../components/ZoomControle.php';
                require_once dirname(__FILE__) . '/../components/BotaoAvisoAjuda.php';
                ?>
                
                <!-- aviso -->
                <div class="aviso-ajuda" id="aviso-ajuda-mapa">
                    <div class="close">&times;</div>
                    <div class="msg"><?php echo $lang_mng->getString('mp_aviso_ajuda_marcador');?></div>
                </div>
                
                
                <script>
                    $(document).ready(function () {
                        $('#aviso-ajuda-mapa .close').bind('click', function (evt) {
                            $('.aviso-ajuda').hide();
                            $('#botao-aviso-ajuda').removeClass('selecionado');
                            evt.stopPropagation();
                        });
                        
                        setMsgMarcadorAjudaMapa();
                    });
                </script>
                <!-- /aviso -->
                
            </div>
        </div>
    </div>
    <!-- /mapa -->
</div>

<!-- js -->
<script type="text/javascript" src="<?php echo $path_dir; ?>system/modules/map/assets/js/main.js"></script>
<script type="text/javascript" src="<?php echo $path_dir; ?>system/modules/map/assets/js/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&v=3.14&libraries=geometry&key=<?php echo GOOGLE_MAPS_API_KEY; ?>"></script>
<script type="text/javascript" src="<?php echo $path_dir ?>system/modules/map/assets/js/util.js"></script>
<script type="text/javascript" src="<?php echo $path_dir; ?>system/modules/map/assets/js/google_maps.js"></script>
<script type="text/javascript">
    var user_lang = lang_mng.getString('lang_id');

    var COORDS_RM = <?php echo $json_lista_rm; ?>;
    var COORDS_UF = <?php echo $json_lista_uf; ?>;
    
    var ESP_CONSTANTES = <?php echo ConstantesEspacialidade::toJson(); ?>;


    try {
        var MAPA_API = new GMaps(<?php
        if (CONTEXTO_PADRAO != 10) {
            echo "COORDS_" . $mapa_espacialidade[CONTEXTO_PADRAO]['sufixo_var'];
        }
?>);
    } catch (err) {
        window.onload = function() {
            document.getElementById('carregando_mapa').innerHTML = lang_mng.getString('mp_aviso_erro_carregamento_mapa');
        };
    }
    
    /**
     * Calcula tamanho do mapa e o posiciona na tela.
     */
    var calcNewPosMapa = function() {
         var alturaAtual = ($(window).innerHeight() - $('.mainMenuTop').innerHeight());
        $('#map-canvas').css('height', alturaAtual).focus();
    };
    
    /**
     * Reset scroll mapa.
     */
    var setTopScrollMapa = function() {
        // top mapa
        $('html, body').scrollTop(0);
    };
    
    MAPA_API.addScrollEvent(function() {
        calcNewPosMapa();
        MAPA_API && MAPA_API.atualizaMapa();
        setTopScrollMapa();
    });


    MAPA_API.addLoadEvent(function() {
        if (MAPA_API) {
            MAPA_API.setBaseUrl('<?php echo $path_dir; ?>');
            MAPA_API.setLarguraLinha(<?php echo LARGURA_LINHA_PADRAO; ?>);
            
            MAPA_API.setIndicador(null);
            
            var $mapCanvas = $('#map-canvas');
            
            // default
            $mapCanvas
                    .data('contexto', <?php echo CONTEXTO_PADRAO; ?>)
                    .data('espacialidade', <?php echo ESPACIALIDADE_PADRAO; ?>)
                    .data('ano', <?php echo ANO_PADRAO; ?>);
            
            
            $('#carregando_mapa').hide('fast', function() {
                
                $('#tab_map').css('display', 'block');
                $('#center').css({width: '100%', marginTop: '-10px'});
                $('body').css('overflow', 'hidden');
                
                calcNewPosMapa();

                MAPA_API.inicializaMapa();
                MAPA_API.centralizaMapa();

                var maxZoom = convertType(<?php echo MAX_ZOOM;?>), 
                    minZoom = convertType(<?php echo MIN_ZOOM;?>);
                MAPA_API.setZoomRange(maxZoom, minZoom);
                

                setTopScrollMapa();
            });


<?php if (defined('CONTEXTO_PADRAO') && CONTEXTO_PADRAO == 10) { // contexto brasil         ?>
                contextoBrasil();
                $('#espacialidade_atual').html(lang_mng.getString('mp_camada_estado'));
<?php } ?>
    
    
        } 
    }); // fim: google.maps.event.addDomListener
    
    
    $(document).ready(function() {
        $('.aviso-ajuda').click('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
        });

        $('html').click(function () {
            $('.lista-contexto, .lista-espacialidade, #indicador-holder').hide();
            $('#espacialidade_atual,#contexto_atual').removeClass('highlight');
            
            // aviso ajuda
            $('.aviso-ajuda').hide();
            $('#botao-aviso-ajuda').removeClass('selecionado');
        });    
    });
    
    
</script>
<!-- /js -->

<?php include_once dirname(__FILE__) . '/../components/ModalFaixasLegendaPersonalizada.php'; ?>

<?php
$title = $lang_mng->getString('mp_mapa');
$meta_title = $lang_mng->getString('meta_title');
$meta_description = $lang_mng->getString('meta_description');

$content = ob_get_contents();
ob_end_clean();

include 'base.php';
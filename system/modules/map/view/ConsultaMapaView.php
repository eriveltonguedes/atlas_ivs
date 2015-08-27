<?php 

require_once dirname(__FILE__) . '/../init.php';
require_once dirname(__FILE__) . '/../model/autoload.php';

// mostrar erros
ini_set('display_errors', DISPLAY_ERRORS);

?>

<link rel="stylesheet" type="text/css" href="<?php echo $path_dir ?>system/modules/map/assets/css/cupertino/jquery-ui-1.9.2.custom.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $path_dir ?>system/modules/map/assets/css/componentes.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $path_dir ?>system/modules/map/assets/css/mapa.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $path_dir ?>system/modules/map/assets/css/legenda.css" />
<style type="text/css">
    .modal-body ul {
        list-style: none;
        margin: 0;
        padding: 0;
        display: block;
    }

    .modal-body li {
        padding: 5px;
        text-indent: 10px;
    }

    .modal-body li.active,.modal-body li:hover {
        background-color: #eee;
        cursor: pointer;
    }

    .titulo_mapa {
        position: relative;
        top: 0;
        left: 0;
        color: black;
        width: 100%;
        background-color: white;
        border-bottom: 1px solid #ccc;
        display: table;
        text-align: center;
        vertical-align: middle;
        height: 90px;
    }

    .titulo_mapa .titulo {
        line-height: 1.4;
        text-align: center;
        font-weight: normal;
        padding: 10px 0;
        margin: 0;
    }
    
    .titulo_mapa .nome_indicador {
        font-weight: bold;
        line-height: 1;
    }
    .titulo_mapa .tipo_mapa {
        font-weight: bold;
        color: #999;
    }

    .modal h5 {
        font-size: 16px;
        padding: 5px;
        text-shadow: 1px 1px 0 white;
        border-bottom: 1px solid #eee;
    }

    #mapa_personalizado {
        position: relative;
        width: 100%;
        height: 615px;
        background-color: white;
        padding: 0;
        margin: 0;
    }

    #seletor_ano {
        top: 30px;
    }
</style>

<!-- mapa -->
<div id="map-canvas" style="width: 960px;"></div>
<!-- /mapa -->

<!-- js -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&v=3.14&libraries=geometry&key=<?php echo GOOGLE_MAPS_API_KEY; ?>"></script>
<script type="text/javascript" src="<?php echo $path_dir ?>system/modules/map/assets/js/util.js"></script>
<script type="text/javascript" src="<?php echo $path_dir ?>system/modules/map/assets/js/google_maps.js"></script>
<script type="text/javascript">
    // Constantes Espacialidades:
    var ESP_CONSTANTES = <?php echo ConstantesEspacialidade::toJson(); ?>;
    
    // Mapa interface
    var MAPA_API = new GMaps();

    MAPA_API.setBaseUrl('<?php echo $path_dir; ?>');
    MAPA_API.setLarguraLinha(<?php echo LARGURA_LINHA_PADRAO; ?>);

    MAPA_API.setIndicador(null);
    MAPA_API.setContexto(<?php echo CONTEXTO_PADRAO; ?>);
    MAPA_API.setEspacialidade(<?php echo ESPACIALIDADE_PADRAO; ?>);
    MAPA_API.setAno(<?php echo ANO_PADRAO; ?>);

    MAPA_API.addLoadEvent(function() {
        MAPA_API.inicializaMapa();
        MAPA_API.centralizaMapa();
        MAPA_API.setZoomRange(<?php echo MAX_ZOOM;?>, <?php echo MIN_ZOOM;?>);
    });
</script>
<!-- js -->
<script type="text/javascript" src="<?php echo $path_dir ?>system/modules/map/assets/js/main.js"></script>
<script type="text/javascript" src="<?php echo $path_dir ?>system/modules/map/assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<!-- /js -->


<?php
	require_once BASE_ROOT . 'system/modules/map/components/Legenda.php';
	require_once BASE_ROOT . 'system/modules/map/components/SeletorAnoConsulta.php';
	require_once BASE_ROOT . 'system/modules/map/components/SeletorTipoMapa.php';
	require_once BASE_ROOT . 'system/modules/map/components/SliderTransparencia.php';
	require_once BASE_ROOT . 'system/modules/map/components/ZoomControle.php';
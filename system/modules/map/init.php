<?php

/*
 * Config Map.
 * 
 * @package map
 * @author AtlasBrasil
 */
require_once dirname(__FILE__) . '/../../../config/config_gerais.php';
require_once dirname(__FILE__) . '/../../../config/constants.php';

switch (strtoupper(CONFIG_MAP_TYPE))
{
    case 'XML':
        $xml = simplexml_load_file(CONFIG_MAP_FILE);
        define_map_config_constants((array) $xml);
        break;

    case 'JSON':
        $json_file = file_get_contents(CONFIG_MAP_FILE);
        $json = json_decode($json_file, true);
        define_map_config_constants($json);
        break;

    case 'PHP':
        $php = get_config_map_php();
        define_map_config_constants($php);
        break;

    default:
        throw new Exception('Erro ao gerar mapa: RulesFactoryDao');
}

/**
 * Verifica constantes de espacialidades.
 * 
 * @see config/constantes.php
 * @param int|string $const_name
 */
function verify_config_map_constants($const_name)
{
    if (defined('ESP_' . $const_name))
    {
        $result = constant('ESP_' . $const_name);
    }
    else if (strtoupper($const_name) == 'BRASIL')
    {
        $result = constant('ESP_PAIS');
    }
    else
    {
        $result = $const_name;
    }
    return $result;
}

/**
 * Carrega config php para mapa.
 */
function get_config_map_php()
{
    return (include_once CONFIG_MAP_FILE);
}

/**
 * Carrega constantes utilizados para o mapa.
 * 
 * @param array $valores
 */
function define_map_config_constants(array $valores)
{
    define('GOOGLE_MAPS_API_KEY',       $valores['google_maps_api_key']);

    define('CONTEXTO_PADRAO',           verify_config_map_constants($valores['contexto_padrao']));
    define('ESPACIALIDADE_PADRAO',      verify_config_map_constants($valores['espacialidade_padrao']));

    define('ANO_PADRAO',                $valores['ano_padrao']);
    define('TRANSPARENCIA_PADRAO',      $valores['transparencia_padrao']);

    define('PRECISAO_PADRAO',           $valores['precisao_padrao']);
    define('LARGURA_LINHA_PADRAO',      $valores['largura_linha_padrao']);
    define('GEOM_PADRAO',               $valores['geom_padrao']);

    define('VALOR_LINHA_PADRAO',        -0.3);
    define('COR_LINHA_PADRAO',          'black');
    define('COR_PREENCHIMENTO_PADRAO',  'transparent');

    define('MAX_FAIXAS_MAPA',           $valores['max_faixas_mapa']);
    define('MIN_FAIXAS_MAPA',           $valores['min_faixas_mapa']);
    define('FAIXAS_MAPA_PADRAO',        $valores['faixas_mapa_padrao']);

    define('MAX_ZOOM',                  is_null($valores['max_zoom']) ? 'null' : $valores['max_zoom']);
    define('MIN_ZOOM',                  is_null($valores['min_zoom']) ? 'null' : $valores['min_zoom']);

    define('MAX_SHAPES',                $valores['max_shapes']);

    define('RULES_MAP_TYPE',            $valores['rules_map_type']);
    define('RULES_MAP_FILE',            sprintf($valores['rules_map_file'], BASE_ROOT));

    define('DISPLAY_ERRORS',            $valores['display_errors']);
}
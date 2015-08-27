<?php

/*
 * Configuração do mapa.
 * 
 * @package config
 * @author AtlasBrasil
 */
return array(
    /*
     * Google Maps v3 API KEY.
     */
    'google_maps_api_key' => 'AIzaSyBkJruNegrUCj8j086LtInDp11qcZKitos',
    /*
     * Define qual a contexto do mapa.
     * 
     * Contextos (atualmente):
     *      4 - Estados
     *      6 - Regiões Metropolitanas
     *     10 - Brasil
     */
    'contexto_padrao' => 6,
    /*
     * Define qual o espacialidade padrão do mapa.
     */
    'espacialidade_padrao' => 6,
    /*
     * Define qual o ano padrão do mapa.
     */
    'ano_padrao' => 3,
    /*
     * Transparência padrão do mapa.
     */
    'transparencia_padrao' => 50,
    /*
     * Precisão padrão do mapa.
     */
    'precisao_padrao' => 15,
    /*
     * Define a largura padrão da linha no mapa.
     */
    'largura_linha_padrao' => 0.35,
    /*
     * Define the_geom no mapa.
     */
    'geom_padrao' => 'the_geom',
    /*
     * Mostrar erros no mapa.
     */
    'display_errors' => 1,
    /*
     * Número máximo de faixas da legenda para o mapa.
     */
    'max_faixas_mapa' => 8,
    /*
     * Número mínimo de faixas da legenda para o mapa.
     */
    'min_faixas_mapa' => 2,
    /**
     * Número padrão de faixas da legenda para o mapa.
     */
    'faixas_mapa_padrao' => 5,
    /*
     * Max zoom.
     */
    'min_zoom' => 4,
    /*
     * Min zoom.
     */
    'max_zoom' => null,
    /**
     * Número máximo de shapes a serem renderizado para o mapa.
     */
    'max_shapes' => 1700,
    /*
     * Define o formato que as regras para criação de objetos
     * de espacialidades para o mapa.
     * 
     * XML, JSON e PHP
     */
    'rules_map_type' => 'PHP',
    /*
     * Define o arquivo o 'casos especiais' para o mapa.
     * 
     * Obs.: Substitui em tempo de execução o '%s' por BASE_PATH (diretório base).
     */
    'rules_map_file' => '%s/config/rules_map.php',
);

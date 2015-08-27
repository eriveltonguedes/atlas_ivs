<?php
/*
 * Regras para integração do mapa.
 * 
 * @package config
 * @author AtlasBrasil
 */
return array(
    /*
     * Config 1.) Para contexto Brasil e espacialidade munícipio seta precisão para 3.
     */
    array(
        'context'   => ESP_BRASIL,
        'layer'     => ESP_MUNICIPAL,
        'cut'       => 3,
        'the_geom'  => GEOM_PADRAO,
        'symplify'  => true,
        'source'    => 'poly',
        'cache'     => false,
        'maxzoom'   => 10,
        'active'    => true // ativa ou desativa essa regra
    ),
    /*
     * Config 2.) Para contexto Brasil e espacialidade munícipio com the_geom_light2.
     */
    array(
        'context'   => ESP_BRASIL,
        'layer'     => ESP_MUNICIPAL,
        'cut'       => PRECISAO_PADRAO,
        'the_geom'  => 'the_geom_light2',
        'symplify'  => true,
        'source'    => 'poly',
        'cache'     => false,
        'maxzoom'   => 10,
        'active'    => false
    ),
    /*
     * Config 3.) Para contexto RM e espacialidade UDH seta precisão para 3. (TESTE)
     */
    array(
        'context'   => ESP_REGIAOMETROPOLITANA,
        'layer'     => ESP_UDH,
        'cut'       => 3,
        'the_geom'  => GEOM_PADRAO,
        'symplify'  => false,
        'source'    => 'poly',
        'cache'     => false,
        'maxzoom'   => 10,
        'active'    => true
    ),
);

<?php
/**
 * Mapeador de Tabelas da Espacialidade.
 * 
 * @package map
 * @author AtlasBrasil
 */
class MapaTabela
{

    /**
     * Mapa de IDs referentes às espacialidades.
     * 
     * @link config/Constantes.php
     * @var array
     */
    private static $mapa_espacialidade = array(
        ESP_MUNICIPAL           => 'municipio',
        ESP_REGIONAL            => 'regional',
        ESP_UDH                 => 'udh',
        ESP_ESTADUAL            => 'estado',
        ESP_REGIAOMETROPOLITANA => 'rm',
        ESP_REGIAODEINTERESSE   => 'regiao_interesse', // hack
        ESP_PAIS                => 'pais'
    );

    /**
     * 
     * @param int $id_tabela
     * @return string
     */
    public static function getTabela($id_tabela)
    {
        return static::$mapa_espacialidade[$id_tabela];
    }

    /**
     * Retorna chave estrangeira.
     * Convenção campos começados com 'fk_'.
     * 
     * @static
     * @param int $tabela
     * @param int $fk_espacialidade
     * @return string
     */
    public static function getChaveEstrangeira($tabela, $fk_espacialidade)
    {
        // chave estrangeira prefixo 'fk_'
        $fk = 'fk_' . static::$mapa_espacialidade[$tabela];

        // tabela 5 (UDH) possui fk_municipio
        if (($tabela == ESP_MUNICIPAL) && ($fk_espacialidade == ESP_UDH)) {
            $fk = 'fk_municipio';
        }
        
        // tabela 3 (regional)
        if (($tabela == ESP_MUNICIPAL) && ($fk_espacialidade == ESP_REGIONAL)) {
            $fk = 'fk_mun';
        }
        
        return $fk;
    }
    
    /**
     * Retorna campos de "latitude" e "longitude" do banco de dados caso existam, 
     * caso contrário retorna função que calcula o centro do shape da espacialidade.
     * 
     * @param int $espacialidade
     * @return array Array contendo latitude e longitude.
     */
    public static function getLatLngFields($espacialidade) 
    {
        if ($espacialidade == ESP_ESTADUAL) {
//                TODO:
//                || $espacialidade == ESP_MUNICIPAL) {
            return array('latitude', 'longitude');
        } if ($espacialidade == ESP_REGIAOMETROPOLITANA) {
            return array('lat', 'lon');
        } else {
            return array(
                'ST_Y(ST_Centroid(the_geom))',  // latitude
                'ST_X(ST_Centroid(the_geom))'   // longitude
            );
        }
    }

}

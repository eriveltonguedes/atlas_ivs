<?php

/**
 * Constantes Espacialidade.
 * 
 * @package map
 * @author AtlasBrasil
 */
class ConstantesEspacialidade {

    /**
     * Constantes de espacialidades em array.
     * 
     * @static
     * @return array
     */
    public static function toArray()
    {
        $defined_esp_vars = get_defined_constants(true);
        $vars = $defined_esp_vars['user'];
        
        $result = array();
        foreach ($vars as $k => $v)
        {
            // Convenção toda constantes começa: ESP_
            if (stripos($k, 'ESP_') === 0)
            {
                $result[strtolower(substr($k, 4))] = $v;
            }
        }
        return $result;
    }

    /**
     * Constantes de espacialidades em formato JSON.
     * 
     * @static
     * @return string
     */
    public static function toJson()
    {
        return json_encode(static::toArray());
    }

}

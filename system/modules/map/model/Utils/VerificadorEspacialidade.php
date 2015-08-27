<?php

/**
 * Valor variável.
 * 
 * @package map
 * @author AtlasBrasil
 */
class VerificadorEspacialidade {

    /**
     * Espacialidade.
     * 
     * @param type $espacialidade
     * @return int
     */
    public static function getEspacialidade($espacialidade)
    {
        switch ($espacialidade)
        {
            case ESP_MUNICIPAL:
            case ESP_REGIONAL:
            case ESP_UDH:
                return 2;
            default:
                return 4;
        }
    }

}

<?php

/**
 * Classe para Protocolo.
 * 
 * @see Documentação Protocolo de Comunicação.
 * @package map
 * @author AtlasBrasil
 */
abstract class Protocolo {

    /**
     * Retorna a SQL apropriada.
     * 
     * @param string $sql
     * @param array|int $id
     * @param string $count Defaults * (ALL).
     * @return string
     */
    public static function prepareSql($sql, $id, $count = FALSE)
    {
        $query = "SELECT * FROM ({$sql}) AS tmp";

        // se for um array e não possuir -1 
        // pelo protocolo definido todos
        if (is_array($id) && !in_array(-1, $id))
        {
            $id = implode(", ", $id);
        }

        if ((is_int($id) && $id != -1) || is_string($id))
        {
            $query .= " WHERE id IN ({$id})";
        }

        // todo:
        // necessário ordenação por ID
        $query .= ' ORDER BY id ASC';

//        die($query);

        return (!$count) ? $query : "SELECT COUNT(*) AS total FROM ({$query}) AS t";
    }

    /**
     * Mapa de espacialidades usados pelo protocolo.
     * 
     * @return array
     */
    public static function getMapaEspacialidade()
    {

        return array(
            'est'   => ESP_ESTADUAL,
            'rm'    => ESP_REGIAOMETROPOLITANA,
            'mun'   => ESP_MUNICIPAL,
            'udh'   => ESP_UDH,
        );
    }
    
    /**
     * Mapa de espacialidades usados pelo protocolo.
     * 
     * @return array
     */
    public static function getEspacialidades()
    {

        return array_keys(static::getMapaEspacialidade());
    }

}

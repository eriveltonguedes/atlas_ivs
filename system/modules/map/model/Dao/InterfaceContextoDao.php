<?php

/**
 * Interface para auxiliar o componente de contexto.
 * 
 * @package map
 * @author AtlasBrasil
 */
interface InterfaceContextoDao
{

    /**
     * Recupera todas as espacialidades referentes ao contexto.
     * 
     * @abstract
     */
    public function getContexto();
    
    /**
     * Recupera o ID contexto a partir do ID espacialidade.
     * 
     * @abstract
     * @return int
     */
    public function getContextoId($espacialidade, $id);
}

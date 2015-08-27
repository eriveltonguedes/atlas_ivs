<?php

/**
 * Classe ResultSet Dao.
 *
 * @package map
 * @author AtlasBrasil
 */
abstract class AbstractResultSetDao
{
    /**
     * Lista de resultados.
     * 
     * @var array
     */
    protected $result = array();
    
    /**
     * Adiciona nova valor ao ResultSet.
     *
     * @param mixed $obj
    */
    public function add($obj)
    {
        $this->result[] = $obj;
    }
    
    /**
     * Get.
     *
     * @return mixed
     */
    public function get($chave)
    {
        return $this->result[$chave];
    }
    
    /**
     * Total.
     *
     * @return int
     */
    public function count()
    {
        return count($this->result);
    }
    
    /**
     * Retorna result set em forma de array.
     * 
     * @return array|null
     */
    public abstract function toArray();
}

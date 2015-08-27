<?php

/**
 * Classe abstrata para Contexto.
 * 
 * @package map
 * @author AtlasBrasil
 */
abstract class AbstractContextoDao extends AbstractEspacialidadeDao {

    /**
     * ResultSet.
     * 
     * @var \ResultSetEspacialidadeDao
     */
    private $result_set_contexto;

    /**
     * Construtor.
     * 
     * @param \Bd $conexao
     */
    public function __construct(\Bd $conexao)
    {
        parent::__construct($conexao);
        $this->result_set_contexto = new ResultSetContextoDao;
    }

    /**
     * Adicona no result set.
     * 
     * @param Object $obj
     */
    public function addContexto(InterfaceContexto $obj)
    {
        $this->result_set_contexto->add($obj);
    }

    /**
     * Resultset contexto.
     * 
     * @return \AbstractContextoDao
     */
    public function getResultSetContexto()
    {
        return $this->result_set_contexto;
    }

}

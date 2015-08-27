<?php

/**
 * Classe Factory Contexto DAO.
 * 
 * @package map
 * @author AtlasBrasil
 */
class FactoryContextoDao {

    /**
     * Bd.
     * 
     * @var \Conexao
     * @access protected
     */
    protected $bd;

    /**
     * Constructor.
     * 
     * @param Bd $conexao
     */
    public function __construct(Bd $conexao) {
        $this->bd = $conexao;
    }

    /**
     * Retorna o DAO correspondente ao contexto ID.
     * 
     * @param int $espacialidade
     * @return \InterfaceContextoDao
     */
    public function getContexto($espacialidade) {
        switch ($espacialidade) {
            case ESP_REGIAOMETROPOLITANA:
                return new RmDao($this->bd);
            case ESP_ESTADUAL:
                return new EstadoDao($this->bd);
            default:
                return null;
        }
    }

}

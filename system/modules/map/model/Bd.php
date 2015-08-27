<?php

/**
 * Classe decorator para Conexao.
 * 
 * @package map
 * @author AtlasBrasil
 */
class Bd
{

    /**
     * Iterador de linhas da consulta.
     *
     * @var $contador
     */
    private $contador = 0;

    /**
     * Iterador de linhas da consulta.
     *
     * @var $contador
     */
    private $query;

    /**
     */
    private $conexao;

    /**
     * @constructor
     */
    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    /**
     * Realiza uma consulta no banco de dados.
     *
     * @param $sql Consulta
     *        	SQL
     */
    public function execSql($sql)
    {
        $this->contador = 0;
        $this->query = pg_query($this->conexao, $sql);
    }

    /**
     * Retorna a próxima linha do banco de dados.
     *
     * @return object
     */
    public function proximo()
    {
        $this->contador++;
        return pg_fetch_object($this->query);
    }

    /**
     * Escapa string antes de ser inserida no banco de dados.
     *
     * @static
     * @return string
     */
    public static function escape($string)
    {
        return pg_escape_string($string);
    }

}

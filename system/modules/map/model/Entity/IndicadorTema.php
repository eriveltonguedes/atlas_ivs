<?php

/**
 * Entity tema.
 * 
 * @package map
 * @autor AtlasBrasil
 */
class IndicadorTema {

    /**
     * Variável.
     * 
     * @var int
     */
    private $variavel;

    /**
     * Tema.
     * 
     * @var string
     */
    private $tema;

    /**
     * Constructor.
     * 
     * @param int $tema
     * @param int $variavel
     */
    public function __construct($tema, $variavel)
    {
        $this->tema = $tema;
        $this->variavel = $variavel;
    }

    /**
     * Getter variável.
     * 
     * @return string
     */
    public function getVariavel()
    {
        return $this->variavel;
    }

    /**
     * Getter tema.
     * 
     * @return string
     */
    public function getTema()
    {
        return $this->tema;
    }

}

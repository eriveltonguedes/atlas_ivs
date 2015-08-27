<?php

/**
 * Entity indicador.
 * 
 * @package map
 * @autor AtlasBrasil
 */
class NomeIndicador {

    /**
     * Dimesnões.
     * 
     * @var array
     */
    private $dimensoes;

    /**
     * Temas.
     * 
     * @var array
     */
    private $temas;

    /**
     * Indicadores.
     * 
     * @var array
     */
    private $indicadores;

    /**
     * Indicadores tema.
     * 
     * @var array
     */
    private $indicadores_tema;

    /**
     * Constructor.
     * 
     * @param array $dimensoes
     * @param array $temas
     * @param array $indicadores
     */
    public function __construct($dimensoes, $temas, $indicadores, $indicadores_tema)
    {
        $this->dimensoes        = $dimensoes;
        $this->temas            = $temas;
        $this->indicadores      = $indicadores;
        $this->indicadores_tema = $indicadores_tema;
    }

    /**
     * Lista de dimensoes.
     * 
     * @return array
     */
    public function getDimensoes()
    {
        return $this->dimensoes;
    }

    /**
     * Lista de temas.
     * 
     * @return array
     */
    public function getTemas()
    {
        return $this->temas;
    }

    /**
     * Lista de indicadores.
     * 
     * @return array
     */
    public function getIndicadores()
    {
        return $this->indicadores;
    }

    /**
     * Lista de indicadores tema.
     * 
     * @return array
     */
    public function getIndicadoresTema()
    {
        return $this->indicadores_tema;
    }

}

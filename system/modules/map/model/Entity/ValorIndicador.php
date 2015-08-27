<?php

/**
 * Classe valor do indicador.
 * 
 * @package map
 * @author AtlasBrasil
 */
class ValorIndicador {

    /**
     * @var int
     */
    private $id;

    /**
     * @var double
     */
    private $valor;

    /**
     * Setter id.
     * 
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Getter id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Setter valor.
     *
     * @param int $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * Getter valor.
     */
    public function getValor()
    {
        return $this->valor;
    }

}

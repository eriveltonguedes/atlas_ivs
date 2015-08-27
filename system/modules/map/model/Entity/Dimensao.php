<?php

/**
 * Entity indicador.
 * 
 * @package map
 * @autor AtlasBrasil
 */
class Dimensao {

    /**
     * ID.
     * 
     * @var int
     */
    private $id;

    /**
     * Nome.
     * 
     * @var string
     */
    private $nome;

    /**
     * Constructor.
     * 
     * @param int|string $id
     * @param string $nome
     */
    public function __construct($id, $nome)
    {
        $this->id   = $id;
        $this->nome = $nome;
    }

    /**
     * Getter ID.
     * 
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Getter nome.
     * 
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

}

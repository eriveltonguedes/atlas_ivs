<?php

/**
 * Entity tema.
 * 
 * @package map
 * @autor AtlasBrasil
 */
class Tema {

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
     * Nível.
     * 
     * @var int|string
     */
    private $nivel;

    /**
     * Tema superior.
     * 
     * @var int|string|null
     */
    private $tema_superior;

    /**
     * Constructor.
     * 
     * @param int $id
     * @param string $nome
     * @param int $nivel
     * @param int $tema_superior
     */
    public function __construct($id, $nome, $nivel, $tema_superior)
    {
        $this->id               = $id;
        $this->nome             = $nome;
        $this->nivel            = $nivel;
        $this->tema_superior    = $tema_superior;
    }

    /**
     * Getter ID.
     * 
     * @return string|string
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

    /**
     * Getter nível.
     * 
     * @return int
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * Getter tema superior.
     * 
     * @return int|string|null
     */
    public function getTemaSuperior()
    {
        return $this->tema_superior;
    }

}

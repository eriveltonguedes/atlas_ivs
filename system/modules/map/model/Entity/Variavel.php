<?php

/**
 * Entity indicador.
 * 
 * @package map
 * @autor AtlasBrasil
 */
class Variavel {

    /**
     * ID.
     * 
     * @var int
     */
    private $id;

    /**
     * Nome curto.
     * 
     * @var string
     */
    private $nome_curto;

    /**
     * Nome longo (descrição).
     * 
     * @var string
     */
    private $nome_longo;

    /**
     * Sigla.
     * 
     * @var string
     */
    private $sigla;

    /**
     * Constructor.
     * 
     * @param int $id
     * @param string $sigla
     * @param string $nome_curto
     * @param string $nome_longo
     */
    public function __construct($id, $sigla, $nome_curto, $nome_longo)
    {
        $this->id           = $id;
        $this->sigla        = $sigla;
        $this->nome_curto   = $nome_curto;
        $this->nome_longo   = $nome_longo;
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
     * Getter Sigla.
     * 
     * @return string
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Getter nome curto.
     * 
     * @return string
     */
    public function getNomeCurto()
    {
        return $this->nome_curto;
    }

    /**
     * Getter nome longo.
     * 
     * @return string
     */
    public function getNomeLongo()
    {
        return $this->nome_longo;
    }

}

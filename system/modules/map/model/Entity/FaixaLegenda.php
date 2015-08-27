<?php

/**
 * Faixa Legenda.
 * 
 * @package map
 * @author AtlasBrasil
 */
class FaixaLegenda
{

    /**
     * Nome daquela faixa da legenda.
     * 
     * @var string 
     */
    private $nome;

    /**
     * Max.
     * 
     * @var float 
     */
    private $max;

    /**
     * Min.
     * 
     * @var float 
     */
    private $min;

    /**
     * Cor referente aquela faixa da legenda.
     * 
     * @var cor 
     */
    private $cor;

    /**
     * ID referente a faixa da legenda.
     * 
     * @var int
     */
    private $id;

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
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Setter nome.
     * 
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
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
     * Setter cor.
     * 
     * @param string $cor
     */
    public function setCor($cor)
    {
        $this->cor = $cor;
    }

    /**
     * Getter cor.
     * 
     * @return string
     */
    public function getCor()
    {
        return $this->cor;
    }

    /**
     * Setter max.
     * 
     * @param string $n
     */
    public function setMax($n)
    {
        $this->max = $n;
    }

    /**
     * Getter cor.
     * 
     * @return string
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * Setter min.
     * 
     * @param string $n
     */
    public function setMin($n)
    {
        $this->min = $n;
    }

    /**
     * Getter cor.
     * 
     * @return string     
     */
    public function getMin()
    {
        return $this->min;
    }

}

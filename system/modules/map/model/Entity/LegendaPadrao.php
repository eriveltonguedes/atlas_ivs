<?php

/**
 * Legenda Padrão do mapa.
 * 
 * @package map
 * @autor AtlasBrasil
 */
class LegendaPadrao {

    /**
     * As faixas que compõem a legenda.
     *
     * @var array
     */
    protected $faixas = array();

    /**
     * Ordem descendente ou ascedente da legenda.
     * 
     * @var boolean 
     */
    protected $ordem = true;

    /**
     * Retorna todas faixas da legenda.
     *
     * @return array
     */
    public function getFaixasArray() {
        $result = array();
        
        for ($i = 0; $i < count($this->faixas); $i++) {
            $result[$i]['id']                = $this->faixas[$i]->getId();
            $result[$i]['nome']              = $this->faixas[$i]->getNome();
            $result[$i]['max']               = $this->faixas[$i]->getMax();
            $result[$i]['min']               = $this->faixas[$i]->getMin();
            $result[$i]['cor_preenchimento'] = $this->faixas[$i]->getCor();
        }
        
        return ($this->ordem) ? $result : array_reverse($result);
    }

    /**
     * Adiciona uma nova faixa na legenda.
     * 
     * @param object FaixaLegenda $faixa
     */
    public function addFaixa($faixa) {
        $this->faixas[] = $faixa;
    }

    /**
     * Seta ordem descendente ou ascendente da legeda.
     * 
     * @param bool $ordem
     */
    public function setOrdem($ordem) {
        $this->ordem = (bool) $ordem;
    }
}

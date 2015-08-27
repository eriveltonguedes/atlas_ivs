<?php

/**
 * ResultSet do Contextos.
 *
 * @package map
 * @author AtlasBrasil
 */
class ResultSetNomeIndicadorDao extends AbstractResultSetDao {

    /**
     * Para array de dimensões.
     * 
     * @param array $dim Array de Dimensão.
     * @return array
     */
    public function _toDimensoesArray($dim)
    {
        $arr = array();
        for ($i = 0, $t = count($dim); $i < $t; $i ++)
        {
            $arr[] = array(
                'id'    => $dim[$i]->getId(),
                'n'     => $dim[$i]->getNome(),
            );
        }
        return $arr;
    }

    /**
     * Para array de temas.
     * 
     * @param array $temas Array de Temas.
     * @return array
     */
    public function _toTemasArray($temas)
    {
        $arr = array();
        for ($i = 0, $t = count($temas); $i < $t; $i ++)
        {
            $arr[] = array(
                'id'            => $temas[$i]->getId(),
                'n'             => $temas[$i]->getNome(),
                'nivel'         => $temas[$i]->getNivel(),
                'tema_superior' => $temas[$i]->getTemaSuperior(),
            );
        }
        return $arr;
    }

    /**
     * Para array de indicadores.
     * 
     * @param array $ind Array de Indicadores.
     * @return array
     */
    public function _toVariavelArray($ind)
    {
        $arr = array();
        for ($i = 0, $t = count($ind); $i < $t; $i ++)
        {
            $arr[] = array(
                'id'        => $ind[$i]->getId(),
                'sigla'     => $ind[$i]->getSigla(),
                'nc'        => $ind[$i]->getNomeCurto(),
                'desc'      => $ind[$i]->getNomeLongo(),
            );
        }
        return $arr;
    }
    
    /**
     * Para array de indicadores has temas.
     * 
     * @param array $ind Array de Indicadores has Temas.
     * @return array
     */
    public function _toIndicadoresTemaArray($ind)
    {
        $arr = array();
        for ($i = 0, $t = count($ind); $i < $t; $i ++)
        {
            $arr[] = array(
                'variavel'  => $ind[$i]->getVariavel(),
                'tema'      => $ind[$i]->getTema(),
            );
        }
        return $arr;
    }
    
    /**
     * {@inheritDoc}
     */
    function toArray()
    {
        $item = $this->get(0);

        // atributos indicadores
        $dimensoes          = $item->getDimensoes();
        $temas              = $item->getTemas();
        $indicadores        = $item->getIndicadores();
        $indicadores_tema   = $item->getIndicadoresTema();


        return array(
            'indicadores'       => $this->_toVariavelArray($indicadores),
            'temas'             => $this->_toTemasArray($temas),
            'dimensoes'         => $this->_toDimensoesArray($dimensoes),
            'var_has_tema'      => $this->_toIndicadoresTemaArray($indicadores_tema),
        );
    }

}

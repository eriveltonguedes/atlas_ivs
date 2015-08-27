<?php

/**
 * ResultSet do Contextos.
 *
 * @package map
 * @author AtlasBrasil
 */
class ResultSetContextoDao extends AbstractResultSetDao
{

    /**
     * {@inheritDoc}
     */
    function toArray()
    {
        $result = array();
        
        for ($i = 0, $t = $this->count(); $i < $t; $i ++) {
            $item = $this->get($i);
            $result[$i]['cor_linha']            = $item->getCorLinha();
            $result[$i]['largura_linha']        = $item->getLarguraLinha();
            $result[$i]['cor_preenchimento']    = $item->getCorPreenchimento();
            $result[$i]['zoom']                 = $item->getZoom();
            $result[$i]['nome']                 = $item->getNome();
            $result[$i]['lat']                  = $item->getLat();
            $result[$i]['lng']                  = $item->getLng();
            $result[$i]['id']                   = $item->getId();
        }
        
        return $result;
    }
}

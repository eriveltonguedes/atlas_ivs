<?php

/**
 * ResultSet ValorIndicador.
 * 
 * @package map
 * @author AtlasBrasil
 */
class ResultSetValorIndicadorDao extends AbstractResultSetDao
{

    /**
     * {@inhritDoc}
     */
    public function toArray()
    {
        $result = array();
        for ($i = 0, $t = $this->count(); $i < $t; $i ++) {
            $item = $this->get($i);
            $result[$i][0] = intval($item->getId());
            $result[$i][1] = $item->getValor();
        }
        return $result;
    }
}

<?php

/**
 * ResultSet das Espacialidades.
 *
 * @package map
 * @author AtlasBrasil
 */
class ResultSetEspacialidadeDao extends AbstractResultSetDao
{

    /**
     * {@inheritDoc}
     */
    function toArray()
    {
        $r = array();
        for ($i = 0, $t = $this->count(); $i < $t; $i++) {
            $item       = $this->get($i);
            $r[$i][]    = intval($item->getId());
            $r[$i][]    = trim($item->getNome());
            $r[$i][]    = $item->getGeoJson();
            
            // caso o ID da espacialidade 
            // não poder ser usado no perfil
            if (method_exists($item, 'getCod'))
            {
                $r[$i][] = $item->getCod();
            }
        }

        return $r;
    }

}

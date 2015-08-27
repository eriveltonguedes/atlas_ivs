<?php

/**
 * Classe DAO para Estados.
 * 
 * @package map
 * @author AtlasBrasil
 */
class CoordsEspacialidadeDao {

    private $bd;

    /**
     * Construtor.
     * 
     * @param Bd $bd
     */
    public function __construct(Bd $bd) {
        $this->bd = $bd;
    }

    /**
     * Recupera coordenadas centro da espacialidade.
     * 
     * @param int $id
     * @param int $espacialidade
     * @return \CoordsEspacialidade
     */
    public function getLatLng($id, $espacialidade) {
        list($lat, $lng) = MapaTabela::getLatLngFields($espacialidade);

        $sql = 'SELECT '
                . "{$lat} AS lat, "
                . "{$lng} AS lng "
                . 'FROM ' . MapaTabela::getTabela($espacialidade) . ' '
                . 'WHERE id=' . $id . ' '
                . 'LIMIT 1;';

//        print $sql; exit;
        $this->bd->execSql($sql);

        $obj = null;
        if ($row = $this->bd->proximo()) {
            $obj = new CoordsEspacialidade;
            $obj->setLat($row->lat);
            $obj->setLng($row->lng);
        }

        return $obj;
    }

}

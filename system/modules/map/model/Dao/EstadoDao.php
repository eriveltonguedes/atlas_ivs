<?php

/**
 * Classe DAO para Estados.
 * 
 * @package map
 * @author AtlasBrasil
 */
class EstadoDao extends AbstractContextoDao implements InterfaceContextoDao {

    /**
     * Construtor.
     *
     * @param Conexao $conexao        	
     */
    public function __construct(Bd $conexao)
    {
        parent::__construct($conexao);
    }

    /**
     * {@inheritDoc}
     */
    public function getContexto()
    {
        $sql = "SELECT
                id, nome, latitude AS lat, longitude AS lng, CASE WHEN zoom IS NULL then 8 ELSE zoom END
            FROM
                estado
            ORDER BY
                nome ASC";

        $this->bd->execSql($sql);

        while ($row = $this->bd->proximo())
        {
            $obj = new EstadoContexto;
            $obj->setId($row->id);
            $obj->setCorPreenchimento($this->cor_preenchimento);
            $obj->setLarguraLinha($this->largura_linha);
            $obj->setCorLinha($this->cor_linha);
            $obj->setLat((double) $row->lat);
            $obj->setLng((double) $row->lng);
            $obj->setZoom($row->zoom);
            $obj->setNome(wordwrap($row->nome, 25, "<br>"));

            $this->addContexto($obj);
        }

        return $this->getResultSetContexto();
    }

    /**
     * {@inheritDoc}
     */
    protected function getTemplateSql()
    {
        $sql = "
            (SELECT
                e.id AS id
                ,e.cod_estatlas AS cod
                ,e.nome AS nome
                ,ST_AsGeoJSON(" . $this->checkSimplifiedTheGeom('e.%s') . ", %d) AS geo_json
            FROM
                estado AS e)";

        return $sql;
    }

    /**
     * {@inheritDoc}
     */
    public function getEspacialidadesById($id)
    {
        $sql = $this->getSqlById($id);
        $this->bd->execSql($sql);

        while ($row = $this->bd->proximo())
        {
            $obj = new Estado;
            $obj->setGeoJson($row->geo_json);
            $obj->setNome($row->nome);
            $obj->setId($row->id);
            $obj->setCod($row->cod);

            $this->addEspacialidade($obj);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getContextoId($espacialidade, $id) {
        $_id = Db::escape($id);
        
        $tab = MapaTabela::getTabela($espacialidade);
        $fk  = MapaTabela::getChaveEstrangeira(ESP_ESTADUAL, $espacialidade);
        
        $sql = sprintf("SELECT 
                e.id AS id
            FROM 
                estado AS e,
                %s AS t
            WHERE 
                t.id=%d 
                AND t.%s=e.id", $tab, $_id, $fk);
        $this->bd->execSql($sql);

        if ($row = $this->bd->proximo())
        {
            return $row->id;
        }

        return null;
    }

}

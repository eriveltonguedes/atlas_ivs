<?php

/**
 * Classe DAO para RMs.
 * 
 * @package map
 * @author AtlasBrasil
 */
class RmDao extends AbstractContextoDao implements InterfaceContextoDao
{

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
        $sql = sprintf("(SELECT 
                rm.id, (rm.tipo_rm || ' - ' ||  rm.nome) AS nome, lat, lon AS lng, CASE WHEN zoom IS NULL then 8 ELSE zoom END
            FROM 
                rm
            WHERE
                ativo='t')", $this->the_geom, $this->precisao);

        $this->bd->execSql($sql);

        while ($row = $this->bd->proximo()) {
            $obj = new RmContexto;
            $obj->setId($row->id);
            $obj->setCorPreenchimento($this->cor_preenchimento);
            $obj->setLarguraLinha($this->largura_linha);
            $obj->setCorLinha($this->cor_linha);
            $obj->setLat((double) $row->lat);
            $obj->setLng((double) $row->lng);
            $obj->setZoom($row->zoom);
            $obj->setNome(wordwrap(trim($row->nome), 25, "<br>"));

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
                r.id AS id
                ,CASE WHEN r.nome IS NULL THEN 'Sem Nome' ELSE r.tipo_rm || ' - ' || r.nome END as nome
                ,ST_AsGeoJSON(" . $this->checkSimplifiedTheGeom('r.%s') . ", %d) AS geo_json
            FROM
                rm as r 
            WHERE
                ativo='t')";

        return $sql;
    }

    /**
     * {@inheritDoc}
     */
    public function getEspacialidadesById($id)
    {
        $sql = $this->getSqlById($id);
        $this->bd->execSql($sql);

        while ($row = $this->bd->proximo()) {
            $obj = new Rm;
            $obj->setGeoJson($row->geo_json);
            $obj->setNome(wordwrap(trim($row->nome), 25, "<br>"));
            $obj->setId($row->id);
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
        $fk  = MapaTabela::getChaveEstrangeira(ESP_REGIAOMETROPOLITANA, $espacialidade);
        
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
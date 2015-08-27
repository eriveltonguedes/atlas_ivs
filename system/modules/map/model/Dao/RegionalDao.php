<?php

/**
 * Classe DAO para Regional.
 * 
 * @package map
 * @author AtlasBrasil
 */
class RegionalDao extends AbstractEspacialidadeDao
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
    protected function getTemplateSql()
    {
        $sql = "(SELECT
                r.id AS id
                ,CASE WHEN r.nome IS NULL THEN 'Sem Nome' ELSE r.nome END as nome
                ,ST_AsGeoJSON(" . $this->checkSimplifiedTheGeom('r.%s') . ", %d) AS geo_json
            FROM
                regional AS r)";
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
            $obj = new Regional;
            $obj->setGeoJson($row->geo_json);
            $obj->setNome(wordwrap(trim($row->nome), 25, "<br>"));
            $obj->setId($row->id);
            $this->addEspacialidade($obj);
        }
        
        return $this;
    }

}
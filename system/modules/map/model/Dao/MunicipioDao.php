<?php

/**
 * Classe DAO para Muncípios.
 * 
 * @package map
 * @author AtlasBrasil
 */
class MunicipioDao extends AbstractEspacialidadeDao
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
        $sql = "SELECT
                m.id AS id
                ,CASE WHEN m.nome IS NULL THEN 'Sem Nome' ELSE m.nome END AS nome
                ,ST_AsGeoJSON(" . $this->checkSimplifiedTheGeom('m.%s') . ", %d) AS geo_json 
            FROM
                municipio AS m";
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
            $obj = new Municipio;
            $obj->setId($row->id);
            $obj->setNome($row->nome);
            $obj->setGeoJson($row->geo_json);
            
            $this->addEspacialidade($obj);
        }
        
        return $this;
    }

}

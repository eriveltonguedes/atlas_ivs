<?php

/**
 * Classe DAO para Muncípios.
 * 
 * @package map
 * @author AtlasBrasil
 */
class MunicipioRegiaoDeInteresseDao extends AbstractEspacialidadeDao
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
                ri.id AS id
                ,m.id AS mun_id
                ,CASE WHEN m.nome IS NULL THEN 'Sem Nome' ELSE m.nome END AS nome
                ,ST_AsGeoJSON(" . $this->checkSimplifiedTheGeom('m.%s') . ", %d) AS geo_json 
            FROM
                regiao_interesse AS ri
            INNER JOIN
                regiao_interesse_has_municipio AS rhm ON rhm.fk_regiao_interesse=ri.id
            INNER JOIN 
                municipio AS m ON m.id=rhm.fk_municipio)";
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
            $obj->setId($row->mun_id);
            $obj->setNome($row->nome);
            $obj->setGeoJson($row->geo_json);
        
            $this->addEspacialidade($obj);
        }
        
        return $this;
    }

}
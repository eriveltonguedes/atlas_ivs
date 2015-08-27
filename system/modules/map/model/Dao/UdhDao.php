<?php

/**
 * Classe DAO para UDHs.
 * 
 * @package map
 * @author AtlasBrasil
 */
class UdhDao extends AbstractEspacialidadeDao
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
        $sql = "
            (SELECT
                u.id AS id
                ,CASE WHEN u.nome IS NULL THEN 'Sem Nome' ELSE u.nome END as nome
                ,ST_AsGeoJSON(" . $this->checkSimplifiedTheGeom('u.%s') . ", %d) AS geo_json
            FROM
                udh AS u
            INNER JOIN
                municipio m ON u.fk_municipio = m.id
            INNER JOIN
                estado e ON m.fk_estado = e.id)";

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
            $obj = new Udh;
            $obj->setGeoJson($row->geo_json);
            $obj->setNome(wordwrap($row->nome, 25, "<br>")); // nomes grandes
            $obj->setId($row->id);
            $this->addEspacialidade($obj);
        }

        return $this;
    }

}

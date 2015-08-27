<?php

/**
 * Classe para Legenda.
 * 
 * @package map
 * @author AtlasBrasil
 */
class NomeIndicadorDao {

    /**
     * Conexão com banco de dados.
     *
     * @var Conexao
     */
    protected $db;

    /**
     * User lang.
     *
     * @var Conexao
     */
    protected $user_lang;

    /**
     * Dimensões.
     *
     * @var array
     */
    protected $result_set;

    /**
     * Construtor.
     *
     * @param Conexao $conexao            
     */
    public function __construct(Bd $conexao, $user_lang)
    {
        $this->bd           = $conexao;
        $this->user_lang    = $user_lang;
        
        $dimensoes          = $this->_getDimensoesArray();
        $temas              = $this->_getTemasArray();
        $indicadores        = $this->_getIndicadoresArray();
        $indicadores_tema   = $this->_getIndicadoresTemaArray();

        // collection result
        $this->result_set = new ResultSetNomeIndicadorDao();
        
        $this->result_set->add(new NomeIndicador(
                $dimensoes, 
                $temas, 
                $indicadores, 
                $indicadores_tema
        ));
    }

    /**
     * Result set menu indicador.
     * 
     * @return \ResultSetIndicadorIdhmDao
     */
    public function getResultSet()
    {
        return $this->result_set;
    }

    /**
     * Retorna array de dimensões dos indicadores.
     * 
     * @return array
     */
    private function _getDimensoesArray()
    {
        $sql = sprintf("SELECT t.id AS id, lg.nome AS nome "
                . "FROM tema t INNER JOIN lang_tema lg ON lg.fk_tema = t.id "
                . "WHERE t.id_tema_superior IS NULL AND lg.lang='%s' "
                . "ORDER BY t.cod, id ASC ", Bd::escape($this->user_lang));

        $this->bd->execSql($sql);

        $result = array();
        while ($row = $this->bd->proximo())
        {
            $obj = new Dimensao($row->id, $row->nome);
            $result[] = $obj;
        }
        return $result;
    }

    /**
     * Retorna array de temas.
     * 
     * @return array
     */
    private function _getTemasArray()
    {
        $sql = sprintf("SELECT t.id AS id, lg.nome AS nome, t.nivel AS nivel, t.id_tema_superior AS id_tema_superior  "
                . "FROM tema t INNER JOIN lang_tema lg ON lg.fk_tema = t.id "
                . "WHERE lg.lang ='%s'  "
                . "ORDER BY id_tema_superior, cod ", Bd::escape($this->user_lang));

        $this->bd->execSql($sql);

        $result = array();
        while ($row = $this->bd->proximo())
        {
            $obj = new Tema($row->id, $row->nome, $row->nivel, $row->id_tema_superior);
            $result[] = $obj;
        }
        return $result;
    }

    /**
     * Retorna array de indicadores.
     * 
     * @return array
     */
    private function _getIndicadoresArray()
    {
        $sql = sprintf("SELECT var.id AS id, var.sigla AS sigla, lg.nomecurto AS nomecurto, lg.nomelongo AS nomelongo "
                . "FROM variavel var INNER JOIN lang_var lg on var.id = lg.fk_variavel "
                . "WHERE lg.lang = '%s' "
                . "ORDER BY var.ordem ASC", Bd::escape($this->user_lang));

        $this->bd->execSql($sql);

        $result = array();
        while ($row = $this->bd->proximo())
        {
            $obj = new Variavel($row->id, $row->sigla, $row->nomecurto, $row->nomelongo);
            $result[] = $obj;
        }
        return $result;
    }

    /**
     * Retorna array dos tema dos indicadores.
     * 
     * @return array
     */
    private function _getIndicadoresTemaArray()
    {
        $sql = "SELECT fk_variavel, fk_tema FROM variavel_has_tema";

        $this->bd->execSql($sql);

        $result = array();
        while ($row = $this->bd->proximo())
        {
            $obj = new IndicadorTema($row->fk_tema, $row->fk_variavel);
            $result[] = $obj;
        }
        return $result;
    }

}

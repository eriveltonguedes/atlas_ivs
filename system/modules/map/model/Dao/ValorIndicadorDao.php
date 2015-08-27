<?php

/**
 * Classe DAO para Valor Indicador.
 * 
 * @package map
 * @author AtlasBrasil
 */
class ValorIndicadorDao extends Protocolo implements InterfaceDao {

    /**
     * Conexão banco de dados.
     * 
     * @var Bd 
     */
    private $bd;

    /**
     * @var ResultSetValorIndicadorDao
     */
    private $result_set;

    /**
     * Construtor.
     *
     * @param Conexao $conexao            
     */
    public function __construct(Bd $conexao)
    {
        $this->bd = $conexao;
        $this->result_set = new ResultSetValorIndicadorDao;
    }

    /**
     * Result Set.
     * 
     * @return \ResultSetValorIndicadorDao
     */
    public function getResultSet()
    {
        return $this->result_set;
    }

    /**
     * Lista valores.
     * 
     * @param int $contexto
     * @param int $espacialidade
     * @param int $indicador
     * @param int $ano
     * @return \ValorIndicador
     */
    public function get($contexto, $espacialidade, $id, $indicador, $ano)
    {
        $_sql = $this->getSql($contexto, $espacialidade, $id, $indicador, $ano);
        $this->bd->execSql($_sql);

        while ($row = $this->bd->proximo())
        {
            $valor_indicador = new ValorIndicador;
            $valor_indicador->setId($row->id);
            $valor_indicador->setValor($row->valor);

            // adiciona novos valores
            $this->result_set->add($valor_indicador);
        }

        return $this->result_set;
    }

    /**
     * Formata SQL.
     * 
     * @param int $contexto ID espacialidade.
     * @param int $espacialidade ID espacialidade.
     * @param int $id
     * @param int $indicador ID indicador.
     * @param int $ano ID ano.
     * @return string
     */
    public function getSql($contexto, $espacialidade, $id, $indicador, $ano)
    {
        $tabela = MapaTabela::getTabela($espacialidade);
        $chave_estrangeira = MapaTabela::getChaveEstrangeira($espacialidade, $contexto);
        $valor_variavel = $tabela;

        // região de interesse - caso especial
        if ($espacialidade == ESP_REGIAODEINTERESSE)
        {
            $tabela = $this->_getSqlRegiaoDeInteresse();

            $valor_variavel     = 'municipio';
            $chave_estrangeira  = 'fk_municipio';
            $id                 = $tabela;
        }

        // tabela mun = municipio
        if (strtolower($valor_variavel) == 'municipio')
        {
            $valor_variavel = 'mun';
        }

        $sql = $this->_toSql(
                $tabela, 
                $valor_variavel,
                $chave_estrangeira, 
                $indicador, 
                $ano);

        return static::prepareSql($sql, $id);
    }

    /**
     * SQL especial para casos de Região de Interesse.
     * 
     * @return string
     */
    private function _getSqlRegiaoDeInteresse()
    {
        return "(SELECT
                    m.id AS id
                FROM
                    regiao_interesse AS ri
                INNER JOIN
                    regiao_interesse_has_municipio AS rhm ON rhm.fk_regiao_interesse=ri.id
                INNER JOIN 
                    municipio AS m ON m.id=rhm.fk_municipio)";
    }

    /**
     * SQL.
     * 
     * @param string $tabela
     * @param string $sufixo_tabela_valor_variavel
     * @param string $chave_estrangeira_valor_variavel
     * @param int|string $indicador
     * @param int|string $ano
     * @return string
     */
    private function _toSql(
            $tabela, 
            $sufixo_tabela_valor_variavel,
            $chave_estrangeira_valor_variavel, 
            $indicador, 
            $ano) {

        return "(SELECT
                e.id AS id
                ,v.valor AS valor
            FROM
            	{$tabela} AS e
            INNER JOIN
            	valor_variavel_{$sufixo_tabela_valor_variavel} AS v ON v.{$chave_estrangeira_valor_variavel}=e.id
            WHERE
                valor IS NOT NULL
                AND v.fk_variavel={$indicador}
            	AND v.fk_ano_referencia={$ano})";
    }

}

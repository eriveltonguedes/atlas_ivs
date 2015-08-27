<?php

/**
 * Classe abstrata para Espacialidade.
 * 
 * @package map
 * @author AtlasBrasil
 */
abstract class AbstractEspacialidadeDao extends Protocolo {

    /**
     * Conexão com banco de dados.
     *
     * @var Conexao
     */
    protected $db;

    /**
     * Cor de preenchimento padrão do mapa.
     *
     * @var string $cor_preenchimento_padrao
     */
    protected $cor_preenchimento = COR_PREENCHIMENTO_PADRAO;

    /**
     * Cor da linha padrão do mapa.
     *
     * @var string $cor_linha_padrao
     */
    protected $cor_linha = COR_LINHA_PADRAO;

    /**
     * Largura da linha padrão do mapa.
     *
     * @var string $largura_linha_padrao
     */
    protected $largura_linha = LARGURA_LINHA_PADRAO;

    /**
     * Atributo padrão geométrico(shape) para desenho do mapa.
     *
     * @var string $the_geom_padrao
     */
    protected $the_geom = GEOM_PADRAO;

    /**
     * Aplica simplificação geométrico(shape) para desenho do mapa.
     *
     * @var boolean $simplified
     */
    protected $simplified_map = false;

    /**
     * Atributo de corte padrão para desenho do mapa.
     *
     * @var int $precisao_padrao
     */
    protected $precisao = PRECISAO_PADRAO;

    /**
     * Simplied map tolerance.
     *
     * @var int $precisao_padrao
     */
    protected $tolerance = 0.1;

    /**
     * Max zoom.
     *
     * @var int $precisao_padrao
     */
    protected $max_zoom = MAX_ZOOM;

    /**
     * ResultSet.
     * 
     * @var \ResultSetEspacialidadeDao
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
        $this->result_set = new ResultSetEspacialidadeDao();
    }

    /**
     * Simplificado mapa.
     * 
     * @param $simplified boolean
     */
    public function setSimplifiedMap($simplified)
    {
        $this->simplified_map = $simplified;
    }

    /**
     * Simplificado mapa.
     * 
     * @return boolean
     */
    public function isSimplifiedMap()
    {
        return $this->simplified_map;
    }

    /**
     * Novo atributo geométrico(shape) referente ao desenho do mapa.
     *
     * @param string $the_geom            
     */
    public function setTheGeom($the_geom)
    {
        $this->the_geom = $the_geom;
    }

    /**
     * Seta atributo a claridade da cor do desenho do mapa.
     *
     * @param string $valor            
     */
    public function setValorCorLinha($valor)
    {
        $this->valor_cor_linha = $valor;
    }

    /**
     * Seta precisão.
     *
     * @param double $valor            
     */
    public function setPrecisao($valor)
    {
        $this->precisao = $valor;
    }

    /**
     * Seta largura da linha.
     *
     * @param double $valor            
     */
    public function setLarguraLinha($valor)
    {
        $this->largura_linha = $valor;
    }

    /**
     * Seta max zoom.
     * 
     * @param integer $valor
     */
    public function setMaxZoom($valor)
    {
        $this->max_zoom = $valor;
    }

    /**
     * Get max zoom.
     * 
     * @return integer
     */
    public function getMaxZoom()
    {
        return $this->max_zoom;
    }

    /**
     * Escape ID ou um array de IDs.
     * 
     * @param integer|array $id
     * @return integer|array
     */
    protected function escapeId($id)
    {
        // id pode ser um array ou ser valor único
        if (!is_array($id))
        {
            $id = Bd::escape($id);
        }
        else
        {
            foreach ($id as $k => $v)
            {
                $id[$k] = Bd::escape($v);
            }
        }
        return $id;
    }

    /**
     * Seleciona a consulta de acordo com parâmetros fornecidos.
     *
     * @param int $id            
     * @param boolean $count Default FALSE.          
     * @return string SQL
     */
    public function getSqlById($id, $count = FALSE)
    {
        $_id = $this->escapeId($id);
        
        $sql = sprintf($this->getTemplateSql(), 
                $this->the_geom, $this->precisao);

        if (!$count)
        {
            $result = static::prepareSql($sql, $_id);
        }
        else
        {
            $result = static::prepareSql($sql, $_id, TRUE);
        }

        return $result;
    }

    /**
     * Caso the $simpiflied é true, retorna the_geom simplicaficado,
     * caso contrário, the_geom normal. 
     * 
     * @param string $the_geom
     * @return string
     */
    protected function checkSimplifiedTheGeom($the_geom)
    {
        if (!$this->isSimplifiedMap())
        {
            return $the_geom;
        }
        else
        {
            return "ST_SimplifyPreserveTopology($the_geom, $this->tolerance)";
        }
    }

    /**
     * Retorna result set.
     * 
     * @return \ResultSetEspacialidadeDao
     */
    public function getResultSet()
    {
        return $this->result_set;
    }

    /**
     * Retorna as informações geográficas de acordo o ID.
     *
     * @abstract
     * @param int|string $id          
     * @return \AbstractEspacialidadeDao
     */
    abstract public function getEspacialidadesById($id);

    /**
     * Retorna o número de espacialidade daquela espacialidade.
     *
     * @abstract
     * @param int|string $id          
     * @return \AbstractEspacialidadeDao
     */
    public function getCountById($id)
    {
        $sql = $this->getSqlById($id, TRUE);
        
        $this->bd->execSql($sql);
        
        return (($row = $this->bd->proximo()) ? (int) $row->total : -1);
    }

    /**
     * Retorna template de sql sem indicador selecionado.
     * 
     * @abstract
     */
    abstract protected function getTemplateSql();

    /**
     * Adicona no result set.
     * 
     * @param InterfaceEspacialidade $obj
     */
    public function addEspacialidade(InterfaceEspacialidade $obj)
    {
        $this->result_set->add($obj);
    }

}
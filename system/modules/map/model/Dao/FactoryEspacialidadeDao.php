<?php

/**
 * Classe Factory DAO.
 * 
 * @package map
 * @author AtlasBrasil
 */
class FactoryEspacialidadeDao {

    /**
     * Bd.
     * 
     * @var \Conexao
     * @access protected
     */
    protected $db;

    /**
     * Diretivas de config.
     * 
     * @var array 
     */
    protected $config = array();

    /**
     * Constructor.
     * 
     * @param Bd $db
     * @param array $config
     */
    public function __construct(Bd $db) {
        $this->db = $db;
    }

    /**
     * Seta nova config.
     * 
     * @param array $config
     */
    public function setConfig(array $config) {
        $this->config = $config;
    }

    /**
     * Recupera constante de especialidades.
     * 
     * @param array $currentRule
     * @param string $constant
     * @return string
     */
    private function hasConstante($currentRule, $constant) {
        if (defined('ESP_' . $currentRule[$constant])) {
            $r = constant('ESP_' . $currentRule[$constant]);
        } else if (strtoupper($currentRule[$constant]) == 'BRASIL') {
            $r = constant('ESP_PAIS');
        } else {
            $r = $currentRule[$constant];
        }

        return $r;
    }

    /**
     * Cria DAO respectivo pela Espacialidade.
     * 
     * @param int $espacialidade
     * @param int|null $contexto
     * @return \AbstractEspacialidadeDao
     */
    public function getDao($espacialidade, $contexto = null) {
        $dao = $this->_criaDao($espacialidade);

        $rules_found = false;
        $rules = RulesFactoryEspacialidadeDao::getRules();

        foreach ($rules as $current_rule) {
            $current_rule = (array) $current_rule;

            $_contexto = $this->hasConstante($current_rule, 'context');
            $_camada = $this->hasConstante($current_rule, 'layer');

            if (($_contexto == $contexto || $this->boolval($_contexto == null)) 
                    && ($_camada == $espacialidade) 
                    && ($this->boolval($current_rule['active']))) {

                $current_rule['the_geom'] = (!defined($current_rule['the_geom'])) 
                        ? $current_rule['the_geom'] 
                        : constant($current_rule['the_geom']);

                $current_rule['cut'] = (!defined($current_rule['cut'])) 
                        ? $current_rule['cut'] 
                        : constant($current_rule['cut']);

                $dao->setTheGeom($current_rule['the_geom']);
                $dao->setPrecisao($current_rule['cut']);
                $dao->setMaxZoom($current_rule['maxzoom']);
                // $dao->setSimplified($currentRule['symplify']);

                $rules_found = true;
            }
        }

        if ($rules_found == false) {
            $this->_setValoresPadroes($dao);
        }

        return $dao;
    }

    /**
     * Seta valores padrões definidos pela config.
     * 
     * @param \AbstractEspacialidadeDao $dao
     */
    private function _setValoresPadroes($dao) {
        $dao->setLarguraLinha(LARGURA_LINHA_PADRAO);
        $dao->setPrecisao(PRECISAO_PADRAO);
        $dao->setTheGeom(GEOM_PADRAO);
    }

    /**
     * Cria DAO referente a espacialidade.
     * 
     * @param int|string $espacialidade
     * @return \RegionalDao
     * @throws Exception
     */
    private function _criaDao($espacialidade) {
        if ($espacialidade == ESP_ESTADUAL) {
            $dao = new EstadoDao($this->db);
        } else if ($espacialidade == ESP_REGIAOMETROPOLITANA) {
            $dao = new RmDao($this->db);
        } else if ($espacialidade == ESP_UDH) {
            $dao = new UdhDao($this->db);
        } else if ($espacialidade == ESP_MUNICIPAL) {
            $dao = new MunicipioDao($this->db);
        } else if ($espacialidade == ESP_REGIAODEINTERESSE) {
            $dao = new MunicipioRegiaoDeInteresseDao($this->db);
        } else if ($espacialidade == ESP_REGIONAL) {
            $dao = new RegionalDao($this->db);
        } else if ($espacialidade == ESP_REGIAODEINTERESSE) {
//            $dao = new RegiaoDeInteresseDao($this->db);
            $dao = new MunicipioRegiaoDeInteresseDao($this->db);
        } else {
            throw new Exception("Espacialidade não encontrada.");
        }

        return $dao;
    }

    /** Checks a variable to see if it should be considered a boolean true or false.
     *     Also takes into account some text-based representations of true of false,
     *     such as 'false','N','yes','on','off', etc.
     * 
     * @see <http://www.samuellevy.com/blog/2009/10/boolval-the-missing-function>
     * @author Samuel Levy <sam+nospam@samuellevy.com>
     * @param mixed $in The variable to check
     * @param bool $strict If set to false, consider everything that is not false to
     *                     be true.
     * @return bool The boolean equivalent or null (if strict, and no exact equivalent)
     */
    private function boolval($var, $strict = false) {
        $out = null;
        $in = (is_string($var) ? strtolower($var) : $var);
        // if not strict, we only have to check if something is false
        if (in_array($in, array('false', 'no', 'n', '0', 'off', false, 0), true) || !$in) {
            $out = false;
        } else if ($strict) {
            // if strict, check the equivalent true values
            if (in_array($in, array('true', 'yes', 'y', '1', 'on', true, 1), true)) {
                $out = true;
            }
        } else {
            // not strict? let the regular php bool check figure it out (will
            //     largely default to true)
            $out = ($in ? true : false);
        }
        return $out;
    }

}

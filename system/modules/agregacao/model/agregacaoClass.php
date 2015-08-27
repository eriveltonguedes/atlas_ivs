<?php

require_once '../../../../config/conexao.class.php';

class Agregacao {
    private $conexao;
    private $variavel_sql = array(
        0 => array(
            'espacialidade' => 'pais',
            'variavel' => 'valor_variavel_pais',
            'variavel_fk' => 'fk_pais'
        ),
        2 => array(
            'espacialidade'=> 'municipio',
            'variavel'=> 'valor_variavel_mun',
            'variavel_fk'=> 'fk_municipio'
        ),
        3 => array(
            'espacialidade'=> 'regional',
            'variavel'=> 'valor_variavel_regional',
            'variavel_fk'=> 'fk_regional'
        ),
        4 => array(
            'espacialidade'=> 'estado',
            'variavel'=> 'valor_variavel_estado',
            'variavel_fk'=> 'fk_estado'
        ),
        5 => array(
            'espacialidade'=> 'udh',
            'variavel'=> 'valor_variavel_udh',
            'variavel_fk'=> 'fk_udh'
        ),
        6 => array(
            'espacialidade'=> 'rm',
            'variavel'=> 'valor_variavel_rm',
            'variavel_fk'=> 'fk_rm'
        ),
        7 => array(
            'espacialidade'=> 'municipio',
            'variavel'=> 'valor_variavel_mun',
            'variavel_fk'=> 'fk_municipio'
        )
    );
    private $variavel_agregacao = array(
        1 => array(
            'var_id_1' => 0,
            'var_id_2' => 0,
            'operacao_var_1' => '',
            'operacao_var_2' => '',
            'valor_var_1' => 0,
            'valor_var_2' => 0,
            'sql_1' => 'SELECT SUM(agregacao) as valor FROM ( sql ) as consulta',
            'sql_2' => 'SELECT SUM(valor) as valor FROM ( sql ) as consulta_2',
        ),
        'IDHM_L' => array(
            'var_sigla_1' => 'ESPVIDA',
            'var_id_1' => '',
            'var_sigla_2' => 'NASCVIVO12M',
            'var_id_2' => '',
            'operacao_var_1' => '',
            'operacao_var_2' => 'SUM(valor) as valor',
            'valor_var_1' => 0,
            'valor_var_2' => 0,
            'sql_1' => 'SELECT SUM(agregacao) / pop as valor FROM ( sql ) as consulta',
            'sql_2' => 'SELECT (valor-25) / (85 - 25) as valor FROM ( sql ) as consulta_2',
        ),
        'IDHM_R' => array(
            'var_sigla_1' => 'RDPC',
            'var_id_1' => '',
            'var_sigla_2' => 'POP',
            'var_id_2' => '',
            'operacao_var_1' => '',
            'operacao_var_2' => 'SUM(valor) as valor',
            'valor_var_1' => 0,
            'valor_var_2' => 0,
            'sql_1' => 'SELECT SUM(agregacao) / pop as valor FROM ( sql ) as consulta',
            'sql_2' => 'SELECT (LN(valor)-LN(8)) / (LN(4033)-LN(8)) as valor FROM ( sql ) as consulta_2',
        ),
        'IDHM_E' => array(
            'var_sigla_1' => 'T_FUND18M',
            'var_id_1' => '',
            'var_sigla_2' => 'PESO18',
            'var_id_2' => '',
            'operacao_var_1' => '',
            'operacao_var_2' => 'SUM(valor) as valor',
            'valor_var_1' => 0,
            'valor_var_2' => 0,
            'sql_1' => 'SELECT SUM(agregacao) / pop / 100 as valor FROM ( sql ) as consulta_2',
            'sql_2' => 'SELECT mul(valor) as valor FROM ( sql ) as consulta',
        ),
        5 => array(
            'var_sigla_1' => 'T_FREQ5A6',
            'var_id_1' => '',
            'var_sigla_2' => 'PESO5',
            'var_id_2' => '',
            'var_sigla_3' => 'PESO6',
            'var_id_3' => '',
            'operacao_var_1' => '',
            'operacao_var_2' => 'SUM(valor) as valor',
            'valor_var_1' => 0,
            'valor_var_2' => 0,
            'valor_var_3' => 0,
            'sql_1' => 'SELECT 100 * SUM(agregacao) / pop as valor FROM ( sql ) as consulta_2',
            'sql_2' => 'SELECT mul(valor) / 100 as valor FROM ( sql ) as consulta',
        ),
        6 => array(
            'var_sigla_1' => 'T_FUND11A13',
            'var_id_1' => '',
            'var_sigla_2' => 'PESO1113',
            'var_id_2' => '',
            'operacao_var_1' => '',
            'operacao_var_2' => 'SUM(valor) as valor',
            'valor_var_1' => 0,
            'valor_var_2' => 0,
            'sql_1' => 'SELECT 100 * SUM(agregacao) / pop as valor FROM ( sql ) as consulta_2',
            'sql_2' => 'SELECT mul(valor) / 100 as valor FROM ( sql ) as consulta',
        ),
        7 => array(
            'var_sigla_1' => 'T_FUND15A17',
            'var_id_1' => '',
            'var_sigla_2' => 'PESO1517',
            'var_id_2' => '',
            'operacao_var_1' => '',
            'operacao_var_2' => 'SUM(valor) as valor',
            'valor_var_1' => 0,
            'valor_var_2' => 0,
            'sql_1' => 'SELECT 100 * SUM(agregacao) / pop as valor FROM ( sql ) as consulta_2',
            'sql_2' => 'SELECT mul(valor) / 100 as valor FROM ( sql ) as consulta',
        ),
        8 => array(
            'var_sigla_1' => 'T_MED18A20',
            'var_id_1' => '',
            'var_sigla_2' => 'PESO1820',
            'var_id_2' => '',
            'operacao_var_1' => '',
            'operacao_var_2' => 'SUM(valor) as valor',
            'valor_var_1' => 0,
            'valor_var_2' => 0,
            'sql_1' => 'SELECT 100 * SUM(agregacao) / pop as valor FROM ( sql ) as consulta_2',
            'sql_2' => 'SELECT mul(valor) / 100 as valor FROM ( sql ) as consulta',
        ),
        
    );

    private $espacialidades;
    public $ids_espacialidades;
    public $sql_espacialidades;
    private $indicadores;
    public $data_tabela;
    private $key_espacialidade;

    function __construct($espacialidades, $indicadores) {
        $this->conexao = new Conexao();
        $this->espacialidades = $espacialidades;
        $this->indicadores = $indicadores;

        $this->processar_espacialidades();

        $sql_quant_indicadores = "SELECT COUNT(*) as contador FROM (" . $this->ids_espacialidades . ") as espacialidades";
        $runSQL = pg_query($this->conexao->open(), $sql_quant_indicadores) or die('Não foi possível recuperar a informação');
        $obj = pg_fetch_object($runSQL);
        $quantidade_espacialidades = $obj->contador;
        if ($quantidade_espacialidades > MAX_ESPACIALIDADES_AGREGACAO) {
            $resposta = array(
                'erro' => "O número de espacialidades selecionadas deve ser menor que " . MAX_ESPACIALIDADES_AGREGACAO . ".<br> Por favor, reduza a quantidade de municípios selecionados e refaça a agregação.",
            );
            header('Content-Type: application/json');
            echo json_encode($resposta); exit;
        }

        $this->processar_indicadores();
        foreach($this->indicadores as $ind) {
            if($ind[4] == 'IDHM') {
                $valor = $this->get_idhm($espacialidades, $ind[1], $ind[2]);
                if($valor >= 1) {
                    die('Error ao executar calculo');
                }
                $this->data_tabela[] = array(
                    'id' => $ind[0] . '_' . $ind[1],
                    'valor' => $valor,
                );
            } else if($ind[4] == 'IDHM_E') {
                $this->processar_variavel_agregacao($ind[4]);
                $data_tabela_valor = $this->get_agregacao($ind);
                if($data_tabela_valor > 0) {
                    $data_tabela_valor = number_format($data_tabela_valor, $ind[2]);
                }
                $ed_adulto = $data_tabela_valor;
                $valor_parcial = 0;

                $valor_parcial = 0;
                $array_indicadores = array('5', '6', '7', '8');
                foreach($array_indicadores as $i) {
                    $this->processar_variavel_agregacao($i);
                    $ind_temp = array(
                        0 => $this->variavel_agregacao[$i]['var_id_1'],
                        1 => $ind[1],
                        2 => $ind[2],
                        3 => $i,
                        4 => $i,
                    );
                    $val_temp = $this->get_agregacao($ind_temp);
                    $valor_parcial = $valor_parcial + $val_temp;
                }
                $ed_jovens = $valor_parcial/400;

                $val_educ_parcial = $ed_adulto*$ed_jovens*$ed_jovens;
                $exp = 1/3;

                $valor = number_format(pow($val_educ_parcial, $exp), $ind_temp[2]);
                if($valor >= 1) {
                    die('Error ao executar cálculo');
                }
                $this->data_tabela[] = array(
                    'id' => $ind[0] . '_' . $ind[1],
                    'valor' => $valor,
                );
            } else {
                $this->processar_variavel_agregacao($ind[4]);
                $data_tabela_valor = $this->get_agregacao($ind);
                if($data_tabela_valor > 0) {
                    $data_tabela_valor = number_format($data_tabela_valor, $ind[2]);
                }
                if($data_tabela_valor >= 1 && $ind[3] != 1) {
                    die('Error ao executar cálculo ' . $ind[4]);
                }
                $this->data_tabela[] = array(
                    'id' => $ind[0] . '_' . $ind[1],
                    'valor' => $data_tabela_valor,
                );
            }
        }
        
        foreach($this->data_tabela as $key => $row) {
            $label[$key] = $row['id'];
        }
        array_multisort($label, SORT_ASC, SORT_STRING, $this->data_tabela);
    }

    public function get_idhm($espacialidades, $ano, $decimais) {
        $ind = array('IDHM_L', 'IDHM_R', 'IDHM_E');
        foreach($ind as $indicador) {
            $sql = "SELECT id FROM variavel WHERE sigla = '". $indicador ."'";
            $runSQL = pg_query($this->conexao->open(), $sql) or die('Não foi possível recuperar a informação');
            $obj = pg_fetch_object($runSQL);
            $indicadores[] = array(
                'id' => $obj->id,
                'a' => $ano
            );
        }

        $agregacao = new Agregacao($espacialidades, $indicadores);
        $idhm_parcial = 1;
        foreach($agregacao->data_tabela as $row) {
            $idhm_parcial = $idhm_parcial * $row['valor'];
        }
        $idhm_parcial = number_format(pow($idhm_parcial, 1/3), $decimais);
        return $idhm_parcial;
    }

    public function processar_variavel_agregacao($sigla) {
        if(isset($this->variavel_agregacao[$sigla])) {
            if(isset($this->variavel_agregacao[$sigla]['var_sigla_1'])) {
                $sql = "SELECT id FROM variavel WHERE sigla = '" . $this->variavel_agregacao[$sigla]['var_sigla_1'] . "'";
                $runSQL = pg_query($this->conexao->open(), $sql) or die('Não foi possível recuperar a informação');
                $obj = pg_fetch_object($runSQL);
                $this->variavel_agregacao[$sigla]['var_id_1'] = $obj->id;
            }
            if(isset($this->variavel_agregacao[$sigla]['var_sigla_2'])) {
                $sql = "SELECT id FROM variavel WHERE sigla = '" . $this->variavel_agregacao[$sigla]['var_sigla_2'] . "'";
                $runSQL = pg_query($this->conexao->open(), $sql) or die('Não foi possível recuperar a informação');
                $obj = pg_fetch_object($runSQL);
                $this->variavel_agregacao[$sigla]['var_id_2'] = $obj->id;
            }
            if(isset($this->variavel_agregacao[$sigla]['var_sigla_3'])) {
                $sql = "SELECT id FROM variavel WHERE sigla = '" . $this->variavel_agregacao[$sigla]['var_sigla_3'] . "'";
                $runSQL = pg_query($this->conexao->open(), $sql) or die('Não foi possível recuperar a informação');
                $obj = pg_fetch_object($runSQL);
                $this->variavel_agregacao[$sigla]['var_id_3'] = $obj->id;
            }
        }
    }

    private function processar_indicadores() {
        foreach($this->indicadores as $ind) {
            $indicadoresporano[] = array($ind["id"], $ind["a"]);
        }

        $this->indicadores = $indicadoresporano;

        $i = 0;
        
        $len = count($this->indicadores)-1;

        foreach($this->indicadores as $key => $value) {
            $sql_ano = "SELECT label_ano_referencia FROM ano_referencia WHERE id = '$value[1]'";
            $run_sql = pg_query($this->conexao->open(), $sql_ano);
            $obj = pg_fetch_object($run_sql);
            $ano = $obj->label_ano_referencia;

            $sql_variavel_desc = "SELECT 
                                        var.id,
                                        var.decimais,
                                        var.tipo_agregacao,
                                        var.sigla
                                  FROM 
                                        variavel var
                                  WHERE var.id = '$value[0]'";
            $run_sql = pg_query($this->conexao->open(), $sql_variavel_desc);
            $obj = pg_fetch_object($run_sql);
            $this->indicadores[$key][2] = $obj->decimais > 0 ? $obj->decimais : 0;
            $this->indicadores[$key][3] = $obj->tipo_agregacao;
            $this->indicadores[$key][4] = $obj->sigla;
        }
    }

    private function processar_espacialidades() {
        foreach($this->espacialidades as $e) {
            if(isset($e["l"]) && 
                    ($e['l']   != null ||
                     $e['est'] != null ||
                     $e['rm']  != null )) {
                $espacialidade = implode(',', $e["l"]);
                $outras_espacialidades['est'] = implode(',', $e["est"]);
                $outras_espacialidades['rm'] = implode(',', $e["rm"]);
                $this->get_id_espacialidades($e['e'], $espacialidade, $outras_espacialidades);
                $this->key_espacialidade = $e['e'];
                $espacialidade = null;
                $outras_espacialidades['est'] = null;
                $outras_espacialidades['rm'] = null;
            }
        }
    }

    public function get_id_espacialidades($key_e, $espacialidade, $outras_espacialidades) {
        if($espacialidade != "-1") {
            if(isset($key_e) && $key_e == 7) {
                $sql_esp = "SELECT e.id FROM ". $this->variavel_sql[$key_e]['espacialidade'] ." e INNER JOIN regiao_interesse_has_municipio rim ON e.id = rim.fk_municipio ";
                $sql_esp .= " AND rim.fk_regiao_interesse IN (".$espacialidade.")";
                $this->sql_espacialidades[] = $sql_esp;
            } else {
                if(isset($espacialidade) && $espacialidade != "") {
                    $sql_esp = "SELECT id FROM ". $this->variavel_sql[$key_e]['espacialidade'] ." WHERE id IN (".$espacialidade.")";
                    $this->sql_espacialidades[] = $sql_esp;
                }
            }
            if(isset($outras_espacialidades['est']) && $outras_espacialidades['est'] != null) {
                $sql_esp = "SELECT id FROM ". $this->variavel_sql[$key_e]['espacialidade'] ." WHERE fk_estado IN (".$outras_espacialidades['est'].")";
                $this->sql_espacialidades[] = $sql_esp;
            }

            if(isset($outras_espacialidades['rm']) && $outras_espacialidades['rm'] != null) {
                $sql_esp = "SELECT id FROM ". $this->variavel_sql[$key_e]['espacialidade'] ." WHERE fk_rm IN (".$outras_espacialidades['rm'].")";
                $this->sql_espacialidades[] = $sql_esp;
            }

            if(isset($outras_espacialidades['mun']) && $outras_espacialidades['mun'] != null) {
                $sql_esp = "SELECT id FROM ". $this->variavel_sql[$key_e]['espacialidade'] ." WHERE fk_mun IN (".$outras_espacialidades['mun'].")";
                $this->sql_espacialidades[] = $sql_esp;
            }

            if(count($this->sql_espacialidades) > 0) {
                $this->ids_espacialidades = implode(" UNION ALL ", $this->sql_espacialidades);
            }
        }  else {
            $this->ids_espacialidades = "-1";
            $resposta = array(
                'erro' => "O número de espacialidades selecionadas deve ser menor que " . MAX_ESPACIALIDADES_AGREGACAO . ".<br> Por favor, reduza a quantidade de municípios selecionados e refaça a agregação.",
            );
            header('Content-Type: application/json');
            echo json_encode($resposta); exit;
        }
    }

    public function get_agregacao($ind) {
        if(isset($ind[4]) && $ind[4] != null && $ind[4] != "") {
            $agg = $ind[4];
            if($ind[3] == '1') {
                $agg = $ind[3];
            }
            if(isset($this->variavel_agregacao[$agg])) {
                if($this->variavel_agregacao[$agg]['operacao_var_2'] != "") {
                    $sql = "SELECT ".$this->variavel_agregacao[$agg]['operacao_var_2'];
                    $sql .= " FROM ".$this->variavel_sql[$this->key_espacialidade]['variavel'];
                    $sql .= " where fk_variavel = ".$this->variavel_agregacao[$agg]['var_id_2']." AND ";
                    $sql .= " fk_ano_referencia = " . $ind[1];

                    if($this->ids_espacialidades != "-1") {
                        $sql .= " AND  " . $this->variavel_sql[$this->key_espacialidade]['variavel_fk'] . " IN (".$this->ids_espacialidades.")";
                    }

                    $run_sql = pg_query($this->conexao->open(), $sql) OR die('Não foi possivel realizar a operação');
                    $obj = pg_fetch_object($run_sql);
                    $this->variavel_agregacao[$agg]['valor_var_2'] = $obj->valor;

                    if(isset($this->variavel_agregacao[$agg]['var_sigla_3'])) {
                        $sql = "SELECT ".$this->variavel_agregacao[$agg]['operacao_var_2'];
                        $sql .= " FROM ".$this->variavel_sql[$this->key_espacialidade]['variavel'];
                        $sql .= " where fk_variavel = ".$this->variavel_agregacao[$agg]['var_id_3']." AND ";
                        $sql .= " fk_ano_referencia = " . $ind[1];
                        if($this->ids_espacialidades != '-1') {
                            $sql .= " AND  " . $this->variavel_sql[$this->key_espacialidade]['variavel_fk'] . " IN (".$this->ids_espacialidades.")";
                        }

                        $run_sql = pg_query($this->conexao->open(), $sql) OR die('Não foi possível realizar a operação');
                        $obj = pg_fetch_object($run_sql);
                        $valor_var_2 = $this->variavel_agregacao[$agg]['valor_var_2'];
                        $this->variavel_agregacao[$agg]['valor_var_2'] = $valor_var_2 + $obj->valor;
                    }
                }

                if(isset($this->variavel_agregacao[$agg]['operacao_var_3'])) {
                    $sql = "SELECT ".$this->variavel_agregacao[$agg]['operacao_var_2'];
                    $sql .= " FROM ".$this->variavel_sql[$this->key_espacialidade]['variavel'];
                    $sql .= " where fk_variavel = ".$this->variavel_agregacao[$agg]['var_id_2']." AND ";
                    $sql .= " fk_ano_referencia = " . $ind[1];
                    if($this->ids_espacialidades != '-1') {
                        $sql .= " AND  " . $this->variavel_sql[$this->key_espacialidade]['variavel_fk'] . " IN (".$this->ids_espacialidades.")";
                    }

                    $run_sql = pg_query($this->conexao->open(), $sql) OR die('Não foi possível realizar a operação');
                    $obj = pg_fetch_object($run_sql);
                    $this->variavel_agregacao[$agg]['valor_var_2'] = $obj->valor;
                }
            }

            if(isset($this->variavel_agregacao[$agg]['var_sigla_3'])) {
                $sql = " SELECT trim(nome), mul(valor) as agregacao FROM (";
                $sql .= " SELECT trim(e.nome) as nome, valor FROM  " . $this->variavel_sql[$this->key_espacialidade]['variavel'] . " vve ";
                $sql .= " INNER JOIN ".$this->variavel_sql[$this->key_espacialidade]['espacialidade'];
                $sql .= " e ON vve.".$this->variavel_sql[$this->key_espacialidade]['variavel_fk']." = e.id ";
                if($this->ids_espacialidades != '-1') {
                    $sql .= " AND e.id IN (".$this->ids_espacialidades.") ";
                }
                $sql .= " INNER JOIN variavel v ON vve.fk_variavel = v.id WHERE ";
                if($this->variavel_agregacao[$agg]['var_id_1'] == 0) {
                    $this->variavel_agregacao[$agg]['var_id_1'] = $ind[0];
                }
                $sql .= " (vve.fk_variavel = ".$this->variavel_agregacao[$agg]['var_id_1']." AND vve.fk_ano_referencia = ".$ind[1].") ";

                $sql .= " UNION ";

                $sql .= " SELECT trim(e.nome) as nome, sum(valor) as valor FROM  " . $this->variavel_sql[$this->key_espacialidade]['variavel'] . " vve ";
                $sql .= " INNER JOIN ".$this->variavel_sql[$this->key_espacialidade]['espacialidade'];
                $sql .= " e ON vve.".$this->variavel_sql[$this->key_espacialidade]['variavel_fk']." = e.id ";
                if($this->ids_espacialidades != '-1') {
                    $sql .= " AND e.id IN (".$this->ids_espacialidades.") ";
                }
                $sql .= " INNER JOIN variavel v ON vve.fk_variavel = v.id WHERE ";
                $sql .= " (vve.fk_variavel = ".$this->variavel_agregacao[$agg]['var_id_2']." AND vve.fk_ano_referencia = ".$ind[1].") OR ";
                $sql .= " (vve.fk_variavel = ".$this->variavel_agregacao[$agg]['var_id_3']." AND vve.fk_ano_referencia = ".$ind[1].") ";
                $sql .= " GROUP BY nome ";
                $sql .= " ) as agg GROUP BY nome ";
            } else {
                $sql = " SELECT trim(e.nome) as nome, mul(valor) as agregacao ";
                $sql .= " FROM ".$this->variavel_sql[$this->key_espacialidade]['variavel']." vve ";
                $sql .= " INNER JOIN ".$this->variavel_sql[$this->key_espacialidade]['espacialidade'];
                $sql .= " e ON vve.".$this->variavel_sql[$this->key_espacialidade]['variavel_fk']." = e.id ";
                if($this->ids_espacialidades != '-1') {
                    $sql .= " AND e.id IN (".$this->ids_espacialidades.") ";
                }
                $sql .= " INNER JOIN variavel v ON vve.fk_variavel = v.id WHERE ";
                if($this->variavel_agregacao[$agg]['var_id_1'] == 0) {
                    $this->variavel_agregacao[$agg]['var_id_1'] = $ind[0];
                }
                $sql .= "(vve.fk_variavel = ".$this->variavel_agregacao[$agg]['var_id_1']." AND vve.fk_ano_referencia = ".$ind[1].") ";
                if($this->variavel_agregacao[$agg]['var_id_2'] != 0) {
                    $sql .= " OR (vve.fk_variavel = ".$this->variavel_agregacao[$agg]['var_id_2']." AND vve.fk_ano_referencia = ".$ind[1].") ";
                }
                $sql .= " GROUP BY nome ";
            }


            if($this->variavel_agregacao[$agg]['valor_var_2'] > 0) {
                $this->variavel_agregacao[$agg]['sql_1'] = str_replace('pop', $this->variavel_agregacao[$agg]['valor_var_2'], $this->variavel_agregacao[$agg]['sql_1']);
            }

            if ($this->variavel_agregacao[$agg]['sql_1'] != "") {
                $sql = str_replace('sql', $sql, $this->variavel_agregacao[$agg]['sql_1']);
            }
            if ($this->variavel_agregacao[$agg]['sql_2'] != "") {
                $sql = str_replace('sql', $sql, $this->variavel_agregacao[$agg]['sql_2']);
            }

            $run_sql = pg_query($this->conexao->open(), $sql) OR die('Não foi possível recuperar a informação');
            $obj = pg_fetch_object($run_sql);
            return $obj->valor;
        }
        return "";
    }

}

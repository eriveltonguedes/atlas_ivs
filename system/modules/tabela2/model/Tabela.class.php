<?php

require_once '../../../../config/conexao.class.php';

class Tabela {
    private $conexao;
    private $variavel_sql = array(
        0 => array(
            'espacialidade' => 'pais',
            'variavel' => 'valor_variavel_pais',
            'variavel_fk' => 'fk_pais',
            'perfil' => '',
            'prefixo' => '',
        ),
        2 => array(
            'espacialidade'=> 'municipio',
            'variavel'=> 'valor_variavel_mun',
            'variavel_fk'=> 'fk_municipio',
            'perfil' => 'perfil_m',
            'prefixo' => '',
        ),
        3 => array(
            'espacialidade'=> 'regional',
            'variavel'=> 'valor_variavel_regional',
            'variavel_fk'=> 'fk_regional',
            'perfil' => '',
            'prefixo' => '',
        ),
        4 => array(
            'espacialidade'=> 'estado',
            'variavel'=> 'valor_variavel_estado',
            'variavel_fk'=> 'fk_estado',
            'perfil' => 'perfil_uf',
            'prefixo' => '',
        ),
        5 => array(
            'espacialidade'=> 'udh',
            'variavel'=> 'valor_variavel_udh',
            'variavel_fk'=> 'fk_udh',
            'perfil' => 'perfil_udh',
            'prefixo' => '',
        ),
        6 => array(
            'espacialidade'=> 'rm',
            'variavel'=> 'valor_variavel_rm',
            'variavel_fk'=> 'fk_rm',
            'perfil' => 'perfil_rm',
            'prefixo' => 'RM ',
        ),
        7 => array(
            'espacialidade'=> 'municipio',
            'variavel'=> 'valor_variavel_mun',
            'variavel_fk'=> 'fk_municipio',
            'perfil' => 'perfil_m',
            'prefixo' => '',
        )
    );

    private $espacialidades;
    private $indicadores;
    private $pagina;
    private $limit;
    public $total_espacialidades = 0;
    private $sqls;
    private $offset;
    public $colunas;
    public $data_tabela;
    private $order_by;
    private $order_by_type;
    private $lang;
    public $perfil;
    public $descricao;

    function __construct($espacialidades, $indicadores, $limit, $offset, $pagina, $column, $lang) {
        $this->conexao = new Conexao();
        $this->espacialidades = $espacialidades;
        $this->indicadores = $indicadores;
        $this->limit = $limit;
        $this->pagina = $pagina;
        $this->offset = $offset;
        $this->lang = $lang;
        if(isset($column['title'])) {
            $this->order_by = str_replace('_', 'z', $column['id']);
            $this->order_by_type = $column['order'];
        }

        $this->processar_indicadores();
        $this->processar_espacialidades();
        $this->data_tabela = $this->montar_linhas();
    }

    private function montar_linhas() {
        if(count($this->sqls) > 0) {
            $runSQL = pg_query($this->conexao->open(), $this->get_sql()) or die('Não foi possível recuperar a informação');
            while($res = pg_fetch_array($runSQL)) {
                if($this->total_espacialidades == 0) {
                    $this->total_espacialidades = $res['total_linhas'];
                }
                $nome = explode("|", $res['nome']);
                $resultado[] = $nome[0];
                if(count($nome) > 1) {
                    $this->perfil[] = $nome[1];
                } else {
                    $this->perfil[] = "";
                }

                if(count($nome) > 2) {
                    $this->descricao[] = $nome[2];
                } else {
                    $this->descricao[] = "-";
                }


                $i = 1;
                foreach($this->indicadores as $ind) {
                    $resultado[] = $res[$i] == "" ? "" : $res[$i];
                    $i = $i + 1;
                }
                $data_tabela[] = $resultado;
                unset($resultado);
            }
        }

        $sql_brasil = $this->montar_sql_brasil();
        $runSQL = pg_query($this->conexao->open(), $sql_brasil) or die('Não foi possível recuperar a informação');

        $res = pg_fetch_array($runSQL);
        $resultado[] = $res['nome'];
        $i = 1;
        foreach($this->indicadores as $ind) {
            $resultado[] = $res[$i] == "" ? "" : $res[$i];
            $i = $i + 1;
        }
        if(isset($data_tabela) && count($data_tabela) > 0) {
            array_unshift($data_tabela, $resultado);
        } else {
            $data_tabela[] = $resultado;
        }
        unset($resultado);

        return $data_tabela;
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
                                        lg.nomecurto, 
                                        lg.nomelongo, 
                                        lg.definicao,
                                        var.id,
                                        var.decimais
                                  FROM 
                                        variavel var
                                  INNER JOIN lang_var lg on var.id = lg.fk_variavel
                                  WHERE var.id = '$value[0]' AND lg.lang = '".$this->lang."'";
            $run_sql = pg_query($this->conexao->open(), $sql_variavel_desc);
            $obj = pg_fetch_object($run_sql);
            $nomecurto = $obj->nomecurto;
            $this->indicadores[$key][2] = $nomecurto . ' ' . $ano;
            $this->indicadores[$key][3] = $obj->nomelongo;
            $this->indicadores[$key][4] = $obj->id . '_' . $ano;
            $this->indicadores[$key][5] = $nomecurto;
            $this->indicadores[$key][6] = $ano;
            $this->indicadores[$key][7] = $obj->definicao;
            $this->indicadores[$key][8] = $obj->decimais > 0 ? $obj->decimais : 0;
        }

        foreach($this->indicadores as $key => $row) {
            $label[$key] = $row[4];
        }
        array_multisort($label, SORT_ASC, SORT_STRING, $this->indicadores);

        $this->colunas[] = array(
            'title' => 'Espacialidades',
            'id'    => 'espacialidades',
            'subtitle' => '',
            'title_column' => $this->traduz("seletor_espacialidade_plural"),
            'year'     => '',
            'definition' => '',
        );
        foreach($this->indicadores as $ind) {
            $this->colunas[] = array(
                'title'    => $ind[2],
                'id'       => $ind[0].'_'.$ind[1],
                'subtitle' => $ind[3],
                'title_column' => $ind[5],
                'year'     => $ind[6],
                'definition' => $ind[7]
            );
        }

    }

    public function processar_espacialidades() {
        foreach($this->espacialidades as $e) {
            if(isset($e["l"]) &&
                    (count($e['l']) > 0 ||
                     count($e['est']) > 0 ||
                     count($e['mun']) > 0 ||
                     count($e['rm']) > 0 )) {
                $espacialidade = implode(',', $e["l"]);
                $outras_espacialidades['est'] = implode(',', $e["est"]);
                $outras_espacialidades['rm'] = implode(',', $e["rm"]);
                $outras_espacialidades['mun'] = implode(',', $e["mun"]);
                $this->montar_sql($e['e'], $espacialidade, $outras_espacialidades);
                $espacialidade = null;
                $outras_espacialidades['est'] = null;
                $outras_espacialidades['rm'] = null;
                $outras_espacialidades['mun'] = null;
            }
        }
    }

    private function montar_sql($key_e, $espacialidade, $outras_espacialidades) {
        if($espacialidade == null && $outras_espacialidades == null) {
            return;
        }
        $i = 0;
        $len = count($this->indicadores)-1;

        $sql = "SELECT nome, ";
        foreach($this->indicadores as $ind) {
            if($i == $len) {
                $sql .= " round(\"". $ind[0] . "z" . $ind[1] . "\", ".$ind[8].") AS  \"". $ind[0] . "z" . $ind[1] . "\"";
            } else {
                $sql .= " round(\"". $ind[0] . "z" . $ind[1] . "\", ".$ind[8].") AS  \"". $ind[0] . "z" . $ind[1] . "\", ";
            }
            $i++;
        }
        $i = 0;
        $sql .=  " FROM crosstab('
            SELECT ";
        if($key_e == 2) {
            $sql .= "concat_ws($$|$$, $$" . $this->variavel_sql[$key_e]['prefixo'] . "$$";
            $sql .= "||trim(e.nome)|| $$ ($$ || estado.uf || $$)$$, $$";
            $sql .= $this->lang."/".$this->variavel_sql[$key_e]['perfil']."/$$ || e.id, ";
            $sql .= " concat_ws($$$$, $$<p><strong>Estado</strong>: $$ || estado.nome || $$</p>$$, $$<p><strong>RM</strong>: $$ || rm.nome || $$</p>$$)) AS nome, ";
        } else if($key_e == 5 || $key_e == 3) {
            $sql .= "CASE rm.tipo_rm WHEN 1 THEN concat_ws($$|$$, $$" . $this->variavel_sql[$key_e]['prefixo'] . "$$";
            $sql .= "||trim(e.nome)|| $$ ($$ || municipio.nome || $$&#44; RM - $$";
            $sql .= "||rm.nome|| $$)$$, $$";
            if($this->variavel_sql[$key_e]['perfil'] != '') {
                $sql .= $this->lang."/".$this->variavel_sql[$key_e]['perfil'];
                $sql .= "/$$ || e.id, concat_ws($$$$, $$<p><strong>RM</strong>: $$ || rm.nome || $$</p>$$, $$<p><strong>Município</strong>: $$ || municipio.nome || $$</p>$$, $$<p>$$ || e.descricao || $$</p>$$)) ";
            } else $sql .= "$$, concat_ws($$<p><strong>RM</strong>: $$ || rm.nome || $$</p>$$, $$<p><strong>Estado</strong>: $$ || estado.nome || $$</p>$$ ))";
            $sql .= " WHEN 2 THEN concat_ws($$|$$, $$" . $this->variavel_sql[$key_e]['prefixo'] . "$$";
            $sql .= "||trim(e.nome)|| $$ ($$ || municipio.nome || $$&#44; RIDE - $$";
            $sql .= "||rm.nome|| $$)$$, $$";
            if($this->variavel_sql[$key_e]['perfil'] != '') {
                $sql .= $this->lang."/".$this->variavel_sql[$key_e]['perfil'];
                $sql .= "/$$ || e.id, concat_ws($$$$, $$<strong>RM</strong>: $$ || rm.nome, $$<br><strong>Município</strong>: $$ || municipio.nome, $$<p>$$ || e.descricao || $$</p>$$)) ";
            } else $sql .= "$$, concat_ws($$<p><strong>RM</strong>: $$ || rm.nome || $$</p>$$, $$<p><strong>Estado</strong>: $$ || estado.nome || $$</p>$$ ))";
            $sql .= " END AS nome, ";
        } else {
            if($key_e == 4) {
                $sql .= "concat_ws($$|$$, $$" . $this->variavel_sql[$key_e]['prefixo'] . "$$||trim(e.nome)||$$|".$this->lang."/".$this->variavel_sql[$key_e]['perfil']."/$$ || e.cod_estatlas, $$<p><strong>Região</strong>: $$ || regiao.nome || $$</p>$$) AS nome, ";
            } else if ($key_e == 6) {
                $sql .= "concat_ws($$|$$, $$" . $this->variavel_sql[$key_e]['prefixo'] . "$$||trim(e.nome)||$$|".$this->lang."/".$this->variavel_sql[$key_e]['perfil']."/$$ || e.id, e.descricao) AS nome, ";
            } else {
                $sql .= "$$" . $this->variavel_sql[$key_e]['prefixo'] . "$$||trim(e.nome)||$$|".$this->lang."/".$this->variavel_sql[$key_e]['perfil']."/$$ || e.id AS nome, ";
            }
        }
        $sql .= ' vve.fk_variavel || $$z$$ || fk_ano_referencia AS var,
                vve.valor
                FROM
                ' . $this->variavel_sql[$key_e]['variavel'] . " vve
                INNER JOIN " . $this->variavel_sql[$key_e]['espacialidade'] . " e ON vve.".$this->variavel_sql[$key_e]['variavel_fk']."= e.id ";

        if($key_e == 2) {
            $sql .= " FULL OUTER JOIN rm ON rm.id = e.fk_rm INNER JOIN estado ON estado.id = e.fk_estado ";
        } else if ($key_e == 5) {
            $sql .= " INNER JOIN municipio ON municipio.id = e.fk_municipio
                      INNER JOIN rm ON rm.id = e.fk_rm AND rm.ativo IS TRUE ";
        } else if($key_e == 3) {
            $sql .= " INNER JOIN municipio ON municipio.id = e.fk_mun
                      INNER JOIN estado estado ON estado.id = municipio.fk_estado
                      INNER JOIN rm ON rm.id = e.fk_rm ";
        }

        if($key_e == 4) {
            $sql .= " INNER JOIN regiao ON regiao.id = e.fk_regiao ";
        }

        if($key_e == 7) {
            $sql .= " INNER JOIN regiao_interesse_has_municipio rim ON rim.fk_municipio = e.id 
                      INNER JOIN regiao_interesse ri ON ri.id = rim.fk_regiao_interesse AND ri.id IN ($espacialidade) ";
        }

        if($espacialidade != "-1") {
            if(isset($outras_espacialidades['est']) && $outras_espacialidades['est'] != null) {
                $sql_esp = "SELECT id FROM ". $this->variavel_sql[$key_e]['espacialidade'] ." WHERE fk_estado IN (".$outras_espacialidades['est'].") ";
                $runSQL = pg_query($this->conexao->open(), $sql_esp) or die('Não foi possível recuperar a informação');
                while($a = pg_fetch_array($runSQL)) {
                    $nova_espacialidade[] = $a['id'];
                }
            }

            if(isset($outras_espacialidades['rm']) && $outras_espacialidades['rm'] != null) {
                $sql_esp = "SELECT id FROM rm WHERE id IN (".$outras_espacialidades['rm'].") AND ativo IS TRUE";
                $runSQL = pg_query($this->conexao->open(), $sql_esp) or die('Não foi possível recuperar a informação');
                while($a = pg_fetch_array($runSQL)) {
                    $temp_nova_espacialidade[] = $a['id'];
                }

                $sql_esp = "SELECT id FROM ". $this->variavel_sql[$key_e]['espacialidade'] ." WHERE fk_rm IN (".implode(",", $temp_nova_espacialidade).") ";
                $runSQL = pg_query($this->conexao->open(), $sql_esp) or die('Não foi possível recuperar a informação');
                while($a = pg_fetch_array($runSQL)) {
                    $nova_espacialidade[] = $a['id'];
                }
            }

            if(isset($outras_espacialidades['mun']) && $outras_espacialidades['mun'] != null) {
                if($key_e == 3) {
                    $sql_esp = "SELECT id FROM ". $this->variavel_sql[$key_e]['espacialidade'] ." WHERE fk_mun IN (".$outras_espacialidades['mun'].")";
                } else {
                    $sql_esp = "SELECT id FROM ". $this->variavel_sql[$key_e]['espacialidade'] ." WHERE fk_municipio IN (".$outras_espacialidades['mun'].")";
                }
                $runSQL = pg_query($this->conexao->open(), $sql_esp) or die('Não foi possível recuperar a informação');
                while($a = pg_fetch_array($runSQL)) {
                    $nova_espacialidade[] = $a['id'];
                }
            }
            if(isset($nova_espacialidade) && count($nova_espacialidade) > 0) {
                $espacialidade .= implode(',', $nova_espacialidade);
            }

            if($key_e != 7) {
                $sql .= " AND e.id IN (". $espacialidade .")";
            }
        } 

        $sql .= "INNER JOIN variavel v ON vve.fk_variavel = v.id
                INNER JOIN ano_referencia ar ON vve.fk_ano_referencia = ar.id ";

        if($key_e == 2) {
            $sql .= " INNER JOIN estado est ON e.fk_estado = est.id ";
        }

        $sql .= " WHERE (";
        foreach($this->indicadores as $ind ) {
            if($i == $len) {
                $sql .= "(vve.fk_variavel = ". $ind[0] ." AND vve.fk_ano_referencia = " . $ind[1] . ")";
            } else {
                $sql .= "(vve.fk_variavel = ". $ind[0] ." AND vve.fk_ano_referencia = " . $ind[1] . ") OR ";
            }
            $i++;
        }

        $sql .= ")";

        if( $key_e == 6) {
            $sql .= " AND e.ativo IS TRUE ";
        }

        $sql .= " ORDER BY 1, var'
        ) as ct(
            nome text,";

        $i = 0;
        foreach($this->indicadores as $ind) {
            if($i == $len) {
                $sql .= "\"". $ind[0] ."z". $ind[1] . "\" numeric";
            } else {
                $sql .= "\"". $ind[0] ."z". $ind[1] . "\" numeric, ";
            }
            $i++;
        }
        $sql .= ") ";

        $this->sqls[] = $sql;
    }

    private function montar_sql_brasil() {
        $i = 0;
        $len = count($this->indicadores)-1;
        $key_e = 0;
        $espacialidade = 103;

        $sql = "SELECT nome, ";
        foreach($this->indicadores as $ind) {
            if($i == $len) {
                $sql .= " round(\"". $ind[0] . "z" . $ind[1] . "\", ".$ind[8].") AS  \"". $ind[0] . "z" . $ind[1] ."\"";
            } else {
                $sql .= " round(\"". $ind[0] . "z" . $ind[1] . "\", ".$ind[8].") AS  \"". $ind[0] . "z" . $ind[1] ."\", ";
            }
            $i++;
        }
        $i = 0;
        $sql .=  " FROM crosstab('
            SELECT
            trim(e.nome_pais) as nome,";
        $sql .= 'vve.fk_variavel || $$z$$ || fk_ano_referencia AS var, ';
        $sql .= "vve.valor
                FROM
                " . $this->variavel_sql[$key_e]['variavel'] . " vve
                INNER JOIN " . $this->variavel_sql[$key_e]['espacialidade'] . " e ON vve.".$this->variavel_sql[$key_e]['variavel_fk']."= e.id
                INNER JOIN variavel v ON vve.fk_variavel = v.id
                INNER JOIN ano_referencia ar ON vve.fk_ano_referencia = ar.id
                WHERE
                (";
        foreach($this->indicadores as $ind ) {
            if($i == $len) {
                $sql .= "(vve.fk_variavel = ". $ind[0] ." AND vve.fk_ano_referencia = " . $ind[1] . ")";
            } else {
                $sql .= "(vve.fk_variavel = ". $ind[0] ." AND vve.fk_ano_referencia = " . $ind[1] . ") OR ";
            }
            $i++;
        }

        $sql .= ")";
        if($espacialidade != "-1") {
            $sql .= " AND vve.".$this->variavel_sql[$key_e]['variavel_fk']." IN (". $espacialidade.")";
        }

        $sql .= " ORDER BY 1, var'
        ) as ct(
            nome text,";

        $i = 0;
        foreach($this->indicadores as $ind) {
            if($i == $len) {
                $sql .= "\"". $ind[0] ."z". $ind[1] . "\" numeric";
            } else {
                $sql .= "\"". $ind[0] ."z". $ind[1] . "\" numeric, ";
            }
            $i++;
        }
        $sql .= ") ";

        return $sql;
    }

    public function get_sql_base() {
        $sql = "SELECT consulta.*, COUNT(*) OVER() as TOTAL_LINHAS FROM ( ";

        if(count($this->sqls) > 1) {
            $sql .= implode(" UNION ALL ", $this->sqls);
        } else if (count($this->sqls) == 1) {
            $sql .= $this->sqls[0];
        } else {
            return "";
        }

        $sql .= " ) as consulta ";

        return $sql;
    }

    public function get_sql() {
        $sql = $this->get_sql_base();

        if($this->order_by != "") {
            if($this->order_by != "espacialidades") {
                $sql .= " ORDER BY \"" . $this->order_by . "\" " . $this->order_by_type . " ";
            } else {
                $sql .= " ORDER BY \"nome\" " . $this->order_by_type . " ";
            }
        } else {
            $sql .= " ORDER BY \"nome\" " . $this->order_by_type . " ";
        }

        $sql .= " LIMIT " . $this->limit. " ";
        
        $sql .= "OFFSET " . $this->offset;

        return $sql;
    }

    public function traduz($lang_key) {
        $lang_var = null;
        $ltemp = $this->lang;

        include_once '../../../../config/config_gerais.php';
        include_once '../../../../config/config_path.php';
        include_once '../../../../config/langs/LangManager.php';
        include_once '../../../../config/langs/lang_' . $ltemp . '.php';

        include_once '../../../../config/langs/LangManager.php';

        $lang_mng = new LangManager($lang_var);
        return $lang_mng->getString($lang_key);
    }

}

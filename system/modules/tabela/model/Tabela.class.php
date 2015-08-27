<?php

require_once '../../../config/conexao.class.php';

class Tabela {
    private $conexao;
    private $variavel_sql = array(
        2 => array(
            'espacialidade'=> 'municipio',
            'variavel'=> 'valor_variavel_mun',
            'variavel_fk'=> 'fk_municipio'
        ),
        4 => array(
            'espacialidade'=> 'estado',
            'variavel'=> 'valor_variavel_estado',
            'variavel_fk'=> 'fk_estado'
        ),
    );
    private $espacialidades;
    private $indicadores;
    private $ordem;
    private $pagina = 0;
    private $total_espacialidades = 0;
    private $sqls;
    private $quantpagina = 10;

    function __construct($espacialidades, $indicadores, $ordem, $pagina) {
        $this->conexao = new Conexao();
        $this->espacialidades = $espacialidades;
        $this->indicadores = $indicadores;
        $this->ordem = $ordem;
        $this->pagina = $pagina;
        if($this->pagina < 1) {
            $this->pagina = 0;
        }
        $this->processar_indicadores();
        $this->processar_espacialidades();
    }

    public function get_html_tabela() {

        if(count($this->sqls) > 1) {
            $sql = implode(" UNION ALL ", $this->sqls);
        } else {
            $sql = $this->sqls[0];
        }

        $total = floor($this->total_espacialidades/$this->quantpagina)+1;

        if($this->ordem != "") {
            $sql .= " ORDER BY \"" . $this->ordem["by"] . "\" " . $this->ordem["order"];
        }

        $sql .= " LIMIT " . $this->quantpagina . " ";

        if($this->pagina > 0) {
            $sql .= "OFFSET " . ($this->pagina)*$this->quantpagina;
        }

        $runSQL = pg_query($this->conexao->open(), $sql) or die('Não foi possível recuperar a informação');

        $tabela_html = "";

        $tabela_html .= "<div class='table-inner'>";

        $tabela_html .= "<table><tr class='title'>";
        $tabela_html .= "<th style='background: white;'></th>";

        foreach($this->indicadores as $ind) {
            $tabela_html .= "<td>$ind[3]</td>";
        }
        $tabela_html .= "</tr>";

        $tabela_html .= $titulo;

        while($obj = pg_fetch_array($runSQL)) {
            $tabela_html .= "<tr>";
            $tabela_html .= "<th>" . $obj["nome"] . "</th>";
            foreach($this->indicadores as $key => $ind) {
                $tabela_html .= "<td>" . $obj[$ind[2]] . "</td>";
            }
            $tabela_html .= "</tr>";
        }
        $tabela_html .= "</table>";
        $tabela_html .= "</div>";

        $tabela_html .= $this->paginacao();

        return $tabela_html;
    }

    private function paginacao() {
        $total = floor($this->total_espacialidades/$this->quantpagina)+1;

        $paginacao = "<p class='btn-group' style='float: right; margin-top: 20px;'>";
        if($this->pagina == 0) {
            $paginacao .= "<a href='javascript:void(0)' class='pagina btn btn-default disabled' rel='0'>&lt;&lt;</a>";
        } else {
            $paginacao .= "<a href='javascript:void(0)' class='pagina btn btn-default btn-primary' rel='0'>&lt;&lt;</a>";
        }

        if($this->pagina < 6) {
            $i = 1;
        } else if($this->pagina >= 6) {
            $i = $this->pagina - 5;
        }

        if( ($i+10) > $total) {
            $j = $total+1;
        } else {
            $j = $i + 10;
        }

        while($i < $j) {
            if($this->pagina == $i-1) {
                $paginacao .= "<a href='javascript:void(0)' class='pagina btn btn-default disabled' rel='$i'>$i</a>";
            } else {
                $paginacao .= "<a href='javascript:void(0)' class='pagina btn btn-default btn-primary' rel='$i'>$i</a>";
            }
            $i = $i + 1;
        }

        if($this->pagina == $total-1 ) {
            $paginacao .= "<a href='javascript:void(0)' class='pagina btn btn-default disabled' rel='".$total."'>&gt;&gt;</a>";
        } else {
            $paginacao .= "<a href='javascript:void(0)' class='pagina btn btn-default btn-primary' rel='".$total."'>&gt;&gt;</a>";
        }
        $paginacao .= "</p>";

        return $paginacao;
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

            $sql_variavel_desc = "SELECT nomecurto FROM variavel WHERE id = '$value[0]'";
            $run_sql = pg_query($this->conexao->open(), $sql_variavel_desc);
            $obj = pg_fetch_object($run_sql);
            $nomecurto = $obj->nomecurto;

            $this->indicadores[$key][2] = $nomecurto . ' ' . $ano;
            if($this->ordem != "") {
                if($this->ordem['order'] == "DESC" && $this->ordem['by'] == $this->indicadores[$key][2]) {
                    $this->indicadores[$key][3] = '<a href="#" rel="'.$this->indicadores[$key][2].'" class="order ord_asc">' . $nomecurto . ' <span>' . $ano . '</span></a>';
                } else if( $this->ordem['order'] == "ASC" && $this->ordem['by'] == $this->indicadores[$key][2] ) {
                    $this->indicadores[$key][3] = '<a href="#" rel="'.$this->indicadores[$key][2].'" class="order ord_desc">' . $nomecurto . ' <span>' . $ano . '</span></a>';
                } else {
                    $this->indicadores[$key][3] = '<a href="#" rel="'.$this->indicadores[$key][2].'" class="order">' . $nomecurto . ' <span>' . $ano . '</span></a>';
                }
            } else {
                $this->indicadores[$key][3] = '<a href="#" rel="'.$this->indicadores[$key][2].'" class="order">' . $nomecurto . ' <span>' . $ano . '</span></a>';
            }
        }
    }

    private function processar_espacialidades() {
        foreach($this->espacialidades as $e) {
            if(isset($e["l"])) {
                $this->total_espacialidades = $this->total_espacialidades + count($e["l"]);
                $espacialidade = implode(',', $e["l"]);
                if($espacialidade != "") {
                    $this->montar_sql($e['e'], $espacialidade);
                    if($espacialidade == "-1") {
                        $this->total_espacialidades = $this->contar_espacialidades($e['e']);
                    }
                }
            }
        }
    }

    private function montar_sql($key_e, $espacialidade) {
        $i = 0;
        $len = count($this->indicadores)-1;

        $sql = "SELECT * FROM crosstab('
            SELECT
            trim(e.nome) as nome,
                vve.fk_variavel || $$ $$ || fk_ano_referencia AS var,
                vve.valor
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
                $sql .= "\"". $ind[2] ."\" numeric";
            } else {
                $sql .= "\"". $ind[2] ."\" numeric, ";
            }
            $i++;
        }
        $sql .= ") ";

        $this->sqls[] = $sql;
    }

    private function contar_espacialidades($e) {
        $sql = "SELECT count(*) as total from ". $this->variavel_sql[$e]["espacialidade"];
        $runSQL = pg_query($this->conexao->open(), $sql) or die('Não foi possível recuperar a informação');
        $count = pg_fetch_array($runSQL);
        return $count['total'];
    }

    public function get_sql() {

        if(count($this->sqls) > 1) {
            $sql = implode(" UNION ALL ", $this->sqls);
        } else {
            $sql = $this->sqls[0];
        }
        $total = floor($this->total_espacialidades/$this->quantpagina)+1;
        if($this->ordem != null) {
            $sql .= " ORDER BY \"" . $this->ordem["by"] . "\" " . $this->ordem["order"];
        }
        $sql .= " LIMIT " . $this->quantpagina . " ";
        if($this->pagina > 0) {
            $sql .= "OFFSET " . ($this->pagina)*$this->quantpagina;
        }

        return $sql;
    }
}

?>

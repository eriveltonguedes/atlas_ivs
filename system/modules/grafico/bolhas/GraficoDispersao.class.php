<?php

/**
 * Description of GraficoDispersao
 *
 * @author Elaine Soares Moreira
 */
class GraficoDispersao {

    private $dados;
    private $eixo_x;
    private $eixo_y;
    private $eixo_size;
    private $eixo_color;
    private $bd;
    private $eixo2 = array('X', 'Y', 'Color', 'Size');

    public function __construct($lugares, $indicadores, $espacialidade, $ano) {
        $this->eixo_x = $indicadores[0];
        $this->eixo_y = $indicadores[1];
        $this->eixo_color = $indicadores[2];
        $this->eixo_size = $indicadores[3];

        $this->bd = new bd();
        $this->consultar($lugares, $indicadores, $espacialidade, $ano);
    }

    public function draw() {
        $draw = array();
        $counter = 0;
        $draw[$counter][] = 'Lugar';
        $draw[$counter][] = $this->eixo["X"];
        $draw[$counter][] = $this->eixo["Y"];
        $draw[$counter][] = $this->eixo["Color"];
        $draw[$counter][] = $this->eixo["Size"];
//        echo 'this->eixo[Color]: ' . $this->eixo["Color"];
//        echo 'draw[counter]: ' . $draw[$counter][0];
//        echo 'this->dados: ' . $this->dados;
        if ($this->dados != '') {
            foreach ($this->dados as $d) {
                $counter++;
                $draw[$counter] = $d->draw();
            }
        }
        else{
            $draw[$counter] = 0;
        }


        echo json_encode($draw);
    }

    private function consultar($lugares, $indicadores, $espacialidade, $ano) {
        $ParteInicialSQL = "";
        $filtro = "";
        switch ($espacialidade) {
            case Consulta::$ESP_MUNICIPAL:
                $ParteInicialSQL = "SELECT valor, fk_municipio,fk_ano_referencia as id_a,fk_variavel as id_v, m.nome as nome,e.uf as uf 
                                        FROM valor_variavel_mun as vv
                                        INNER JOIN variavel as v ON (vv.fk_variavel = v.id)
                                        INNER JOIN municipio as m ON (m.id = vv.fk_municipio)
                                        INNER JOIN estado as e ON (e.id = m.fk_estado)
                                        INNER JOIN regiao as r ON (r.id = e.fk_regiao)
                                        WHERE ";
                $filtro = "fk_municipio";
                break;
            case Consulta::$ESP_ESTADUAL:
                $ParteInicialSQL = "SELECT valor, fk_estado,fk_ano_referencia as id_a,fk_variavel as id_v, e.nome FROM valor_variavel_estado as vv
                                        INNER JOIN variavel as v ON (vv.fk_variavel = v.id)
                                        INNER JOIN estado as e ON (e.id = vv.fk_estado)
                                        INNER JOIN regiao as r ON (r.id = e.fk_regiao)
                                        WHERE ";
                $filtro = "fk_estado";
                break;
            case Consulta::$ESP_REGIAODEINTERESSE:
                $lugs2 = array();
                $tam_lug2 = count($lugares);
                for ($i = 0; $i < $tam_lug2; $i++) {
                    $lugs2[] = "(fk_regiao_interesse = $lugares[$i])";
                }
                $whereLugs2 = '(' . implode(' OR ', $lugs2) . ')';
                $RI = "SELECT Distinct m.id as id
                            FROM valor_variavel_mun as vv
                            INNER JOIN regiao_interesse_has_municipio as b ON (b.fk_municipio = vv.fk_municipio)
                            INNER JOIN municipio as m ON (vv.fk_municipio = m.id)
                            INNER JOIN estado as e ON (e.id = m.fk_estado)
                            INNER JOIN regiao_interesse as ri ON (b.fk_regiao_interesse = ri.id)
                            WHERE " . $whereLugs2;
                $RI .= "ORDER BY m.id";

                $Resp = pg_query($this->bd->getConexaoLink(), $RI) or die("Nao foi possivel executar a consulta! ");
                $Linha = pg_fetch_assoc($Resp);
                $cmdtuples = pg_affected_rows($Resp);
                $lugares = array();
                $i = 0;
                while ($Linha = pg_fetch_assoc($Resp)) {
                    $lugares[$i] = $Linha['id'];
                    $i++;
                }

                $ParteInicialSQL = "SELECT valor, fk_municipio,fk_ano_referencia as id_a,fk_variavel as id_v, m.nome as nome,e.uf as uf FROM valor_variavel_mun as vv
                                        INNER JOIN variavel as v ON (vv.fk_variavel = v.id)
                                        INNER JOIN municipio as m ON (m.id = vv.fk_municipio)
                                        INNER JOIN estado as e ON (e.id = m.fk_estado)
                                        INNER JOIN regiao as r ON (r.id = e.fk_regiao)
                                        WHERE ";
                $filtro = "fk_municipio";
                break;
            case Consulta::$ESP_UDH:
                $ParteInicialSQL = "SELECT valor, fk_udh,fk_ano_referencia,fk_variavel, udh.nome FROM valor_variavel_udh as vv
                                        INNER JOIN variavel as v ON (vv.fk_variavel = v.id)
                                        INNER JOIN udh ON (udh.id = vv.fk_udh)
                                        WHERE ";
                $filtro = "fk_udh";
                break;
            case Consulta::$ESP_REGIAOMETROPOLITANA:
                $ParteInicialSQL = "SELECT valor, fk_rm,fk_ano_referencia,fk_variavel, rm.nome FROM valor_variavel_rm as vv
                                        INNER JOIN variavel as v ON (vv.fk_variavel = v.id)
                                        INNER JOIN rm ON (rm.id = vv.fk_rm)
                                        WHERE ";
                $filtro = "fk_rm";
                break;
        }

        $lugs = array();
        $tam_lug = count($lugares);
        $TamLugPreenchidos = 0;
        for ($i = 0; $i < $tam_lug; $i++) {
            $lugs[] = "($filtro = $lugares[$i])";
            if($lugares[$i] != 0){
                $TamLugPreenchidos ++;
            }
        }
//        echo $TamLugPreenchidos.'     ';
        
        $whereLugs = '(' . implode(' OR ', $lugs) . ')';

        $vars = array();
        $identify = array();
        $variaveis = array();
        $tam_ind = count($indicadores);
        $indicadores2 = $indicadores;
        $indicadores[0] = $indicadores2[1];
        $indicadores[1] = $indicadores2[0];
        $indicadores[2] = $indicadores2[3];
        $indicadores[3] = $indicadores2[2];
//        echo $lugares[0] . '     ';
//        echo $lugares[1] . '     ';
//        echo $lugares[2] . '     ';
//        echo $tam_lug.'     ';
        if ($TamLugPreenchidos != 0) {
            for ($i = 0; $i < 4; $i ++) {
//                echo 'FOR     ';
                $whereVars = "(fk_variavel = $indicadores[$i])";
                //            echo 'whereVars: ' . $whereVars . '     ';
                $identify["{$indicadores[$i]}"] = $this->eixo2[$i];
                //            echo 'this->eixo2[' . $i . ']: ' . $this->eixo2[$i] . '     ';
                $ParteFinalSQL = $ParteInicialSQL . ' ' . $whereVars . " AND " . $whereLugs . "AND fk_ano_referencia = {$ano}";
                //            echo 'Parte Final SQL: '.$ParteFinalSQL. '     ';
                $Resposta = pg_query($this->bd->getConexaoLink(), $ParteFinalSQL) or die("Nao foi possivel executar a consulta! ");

                $cmdtuples = pg_affected_rows($Resposta);       //Verifica o número de linhas retornado da consulta
//                echo 'Linhas: ' . $cmdtuples;
                if ($cmdtuples != 0) {
                    while ($Linha = pg_fetch_assoc($Resposta)) {
                        //                    echo 'While     ';
                        if (isset($this->dados[$Linha[$filtro]])) {
                            //                        echo '$Linha[$filtro]: ' . $Linha[$filtro] . '     ';
                            $this->dados[$Linha[$filtro]]->addEixo($Linha['valor'], $identify["{$Linha['id_v']}"]);
                        } else {
                            //                        echo 'else     ';
                            $lugar = new Lugar($Linha["nome"]);
                            $this->dados[$Linha[$filtro]] = new Data($lugar);
                            //                        echo '$Linha[id_v]: '.$Linha['id_v'].'     ';
                            $this->dados[$Linha[$filtro]]->addEixo($Linha['valor'], $identify["{$Linha['id_v']}"]);
                        }
                    }
                }
            }
            $SQL = "select nomecurto, id from variavel where id IN (" . implode(',', $indicadores) . ")";
            $Resposta = pg_query($this->bd->getConexaoLink(), $SQL) or die("Nao foi possivel executar a consulta! ");

            $i = 0;
            $k = 0;
            $ids = array();
            $teste = array(' ', ' ', ' ', ' ');
            $nome = array(' ', ' ', ' ', ' ');
            while ($Linha = pg_fetch_assoc($Resposta)) {
                for ($j = 0; $j < $tam_ind; $j++) {
                    if ($Linha['id'] == $indicadores[$j]) {
                        $this->eixo[$this->eixo2[$j]] = $Linha['nomecurto'];
                    }
                }
                $k++;
            }
        }
    }

}

class Lugar {

    private $nome;

    public function __construct($nome) {
        $this->nome = $nome;
    }

    public function getNome() {
        return $this->nome;
    }

}

class Data {

    private $lugar;
    private $eixo;

    public function __construct($lugar) {
        $this->lugar = $lugar;
    }

    public function draw() {
        $draw = array();
        $draw[] = $this->lugar->getNome();
        $draw[] = (float) $this->eixo["X"];
        $draw[] = (float) $this->eixo["Y"];
        $draw[] = (float) $this->eixo["Color"];
        $draw[] = (float) $this->eixo["Size"];
        return $draw;
    }

    public function addEixo($valor, $eixo) {
        $this->eixo[$eixo] = $valor;
    }

}

?>

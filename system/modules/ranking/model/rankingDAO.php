<?php
/**
 *
 * @authors Lorran and Elaine Moreira
 */
function cutNumber($num, $casas_decimais, $decimal = ',', $milhar = '.') {
    $ex = explode('.', $num);
    if (strlen($ex[1]) >= $casas_decimais) {
        return substr($num, 0, strpos($num, '.') + $casas_decimais + 1);
    }
    if ($num == "") {
        return ' - ';
    } else {
        $con = "";
        for ($diff = $casas_decimais - strlen($ex[1]); $diff > 0; $diff--) {
            $con .= "0";
        }
        return $num . $con;
    }
}
function download_send_headers($filename) {
   /* header('Content-Type: text/html; charset=utf-8');
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");*/
    header("Content-Type: application/force-download");
    /*header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");*/
    header("Content-Disposition: attachment;filename={$filename}");
    /*header("Content-Transfer-Encoding: binary");*/
}
class Ranking {
    const vB = 0.500;
    const vC = 0.600;
    const vD = 0.700;
    const vE = 0.800;
    const nA1 = "IDHM Muito Baixo";
    const nA = "IDHM Baixo";
    const nB = "IDHM Médio";
    const nC = "IDHM Alto";
    const nD = "IDHM Muito Alto";
    private $sql_proto = array(
        "municipal" => "SELECT valor as v, valor_variavel_mun.fk_municipio as i, m.nome as n, e.uf (TBS) 
                            FROM valor_variavel_mun
                            INNER JOIN municipio as m ON (fk_municipio = m.id)
                            INNER JOIN estado as e ON (e.id = m.fk_estado)
                            INNER JOIN rank as r ON (r.fk_municipio = m.id)
                            WHERE fk_variavel IN (VARS) and valor_variavel_mun.fk_ano_referencia = (ANO) and r.fk_ano_referencia = (ANO) (MOREWHERE)",
        "estadual" => "SELECT valor as v, valor_variavel_estado.fk_estado as i, m.nome as n (TBS) FROM valor_variavel_estado
                              INNER JOIN estado as m ON (fk_estado = m.id)
                              INNER JOIN rank_estado as r ON (r.fk_estado = m.id)
                              WHERE fk_variavel IN (VARS) and valor_variavel_estado.fk_ano_referencia = (ANO) and r.fk_ano_referencia = (ANO)",
        "rm" => "SELECT valor as v, valor_variavel_rm.fk_rm as i, m.nome as n (TBS), m.ativo as at 
                                FROM valor_variavel_rm
                              INNER JOIN rm as m ON (fk_rm = m.id)
                              INNER JOIN rank_rm as r ON (r.fk_rm = m.id)
                              WHERE fk_variavel IN (VARS) and valor_variavel_rm.fk_ano_referencia = (ANO) and r.fk_ano_referencia = (ANO)",
        "udh" => "SELECT valor as v, valor_variavel_udh.fk_udh as i, m.nome as n, m.cod_udhatlas as idgeo, e.nome as nrm(TBS) 
                            FROM valor_variavel_udh
                            INNER JOIN udh as m ON (fk_udh = m.id)
                            INNER JOIN rm as e ON (e.id = m.fk_rm)
                            INNER JOIN rank_udh as r ON (r.fk_udh = m.id)
                            WHERE fk_variavel IN (VARS) and valor_variavel_udh.fk_ano_referencia = (ANO) and r.fk_ano_referencia = (ANO) AND e.ativo = TRUE (MOREWHERE)",
        "count_estadual" => "SELECT count(*) FROM valor_variavel_estado
                              INNER JOIN estado as m ON (fk_estado = m.id)
                              WHERE fk_variavel IN (VARS) and fk_ano_referencia = (ANO) ",
        "count_municipal" => "SELECT count(*) FROM valor_variavel_mun
                              WHERE fk_variavel IN (VARS) and fk_ano_referencia = (ANO) "
    );
    private $sql_f = array(
        "municipal" => "SELECT valor as v, fk_municipio as i, fk_variavel as k FROM valor_variavel_mun
                              INNER JOIN municipio as m ON (fk_municipio = m.id)
                              WHERE fk_variavel IN (VARS) and fk_ano_referencia = (ANO)",
        "estadual" => "SELECT valor as v, fk_estado as i, fk_variavel as k FROM valor_variavel_estado
                              INNER JOIN estado as m ON (fk_estado = m.id)
                              WHERE fk_variavel IN (VARS) and fk_ano_referencia = (ANO)",
        "rm" => "SELECT valor as v, fk_rm as i, fk_variavel as k 
                                FROM valor_variavel_rm
                                INNER JOIN rm as m ON (fk_rm = m.id)
                                WHERE fk_variavel IN (VARS) and fk_ano_referencia = (ANO)",
        "udh" => "SELECT valor as v, fk_udh as i, fk_variavel as k 
                                FROM rm as r, valor_variavel_udh as vu
                                INNER JOIN udh as m ON (vu.fk_udh = m.id)
                                WHERE vu.fk_variavel IN (VARS) and vu.fk_ano_referencia = (ANO) and r.ativo = TRUE and m.fk_rm = r.id"
    );
    private $id_indics = array(INDICADOR_IDH, INDICADOR_RENDA, INDICADOR_LONGEVIDADE, INDICADOR_EDUCACAO);
    private $data = array();
    public $pOrdem_id;
    public $pOrdem;
    public $pLimit;
    public $pEspc;
    public $pPag;
    public $pEstado;
    public $Paginas;
    public $pStart;
    public $nOrdem;
    public $estados;
    public $showBtn;
    public $nomeEstado = "";
    public $fkAno = 3;
    public $municipio;
    public $uf;
    public function __construct($ordem_id = null, $ordem = null, $pag = null, $espc = null, $start = null, $estado = null, $estados_pos = null, $load_more = false, $download = false, $ano = 3, $lang = null) {
        $limit = 100;
        if ($lang != null) {    //Se $lang for diferente de null
            $this->lang = $lang;
        } else if (get_class($ordem_id) == "LangManager") {   //Se a classe de $ordem_id for igual a LangManager
            $this->lang = $ordem_id;
            $ordem_id = null;
        }
        $this->showBtn = $load_more;
        if ($load_more) {
            $limit = 12000;
        }
        if (is_null($ordem_id)) {    //Se $ordem_id for null
            $ordem_id = INDICADOR_IDH;  //INDICADOR_IDH é igual a 196
        }
        if (is_null($ordem)) {   //Se $ordem for igual a null
            $ordem = "asc";     //$ordem será igual a asc
        }
        if (is_null($limit)) {   //Se $lmiti for igual a null
            $limit = 100;
        }
        if (is_null($espc)) {    //Se $espc for igual a null
            $espc = "municipal";
        }
        if (is_null($pag)) {     //Se $pag for igual a null
            $pag = 1;
        }
        if (is_null($start) || $start < 0) {
            $start = 1;
        }
        if (is_null($estado)) {
            $estado = 0;
        }
        if ($ordem != "desc" && $ordem != "asc") {
            $ordem = "asc";
        }
        $this->fkAno = (int) $ano;
        
        if ($this->fkAno == 0)
            $this->fkAno = 3;
        if (($espc == 'udh' || $espc == 'rm') && $this->fkAno == 1) {    //Para rm e udh o ano será somente 2010
            $this->fkAno = 3;
        }
        $this->pOrdem_id = (int) $ordem_id;
        $this->pOrdem = $ordem;
        $this->pLimit = (int) $limit;
        $this->pEspc = $espc;
        $this->pPag = (int) $pag;
        $this->pStart = (int) $start;
        $this->pEstado = (int) $estado;
        $bd = new bd();
        $rankingBy = "";
        //Colunas do Ranking. Os Cases indicam a primeira coluna
        switch ($ordem_id) {
            case INDICADOR_IDH: //Coluna IDHM
                $this->nOrdem = $this->lang->getString("rankin_idhm");  //Nome da Coluna
                $rankingBy = "posicao_idh";
                break;
            case INDICADOR_RENDA:   //Coluna IDHM RENDA
                $this->nOrdem = $this->lang->getString("rankin_renda2");
                $rankingBy = "posicao_idhr";
                break;
            case INDICADOR_LONGEVIDADE:     //Coluna IDHM LONGEVIDADE
                $this->nOrdem = $this->lang->getString("rankin_Long");
                $rankingBy = "posicao_idhl";
                break;
            case INDICADOR_EDUCACAO:    //Coluna IDHM EDUCAÇÃO
                $this->nOrdem = $this->lang->getString("rankin_edu");
                $rankingBy = "posicao_idhe";
                break;
            default:
                break;
        }
//        echo $this->fkAno;
        //Dentro de $this->sql_proto[$espc], onde tiver VARS, substitui pelo valor de $ordem_id
        $sql_seletor = str_replace("VARS", $ordem_id, $this->sql_proto[$espc]) . " ORDER BY ot $ordem LIMIT $limit offset " . (($pag - 1) * $limit);
        //Dentro de $sql_seletor, onde tiver (ANO), substitui pelo valor de $this->fkAno
        $sql_seletor = str_replace("(ANO)", $this->fkAno, $sql_seletor);
        if ($this->pEstado > 0 && $espc == "municipal") {
            $sql_seletor = str_replace("(MOREWHERE)", " AND e.id = {$this->pEstado} ", $sql_seletor);
            $rankingBy = str_replace("_", "_e_", $rankingBy);
        } else if ($this->pEstado > 0 && $espc == "udh") {
            $sql_seletor = str_replace("(MOREWHERE)", " AND e.id = {$this->pEstado} ", $sql_seletor);
            $rankingBy = str_replace("_", "_r_", $rankingBy);
        } else {
            //Dentro de $sql_seletor, onde tiver (MOREWHERE), substituir por ""(vazio)
            $sql_seletor = str_replace("(MOREWHERE)", "", $sql_seletor);
        }
        $sql_seletor = str_replace("(TBS)", ",$rankingBy as ot", $sql_seletor);
        $res = $bd->ExecutarSQL($sql_seletor, "frist");
        $ids = array();
        if ($espc == "municipal") {     //Se a espacialidade for igual a 'municipal'
            foreach ($res as $key => $val) {
                $this->municipio = array("mun" => "{$val["n"]}", "uf" => "{$val["uf"]}");
                
                $this->data[$val["i"]] = array(//$val[i] é a fk do município
                    "mun" => "{$val["n"]}",
                    "uf" => "{$val["uf"]}",
                    "n" => "{$val["n"]} ({$val["uf"]})", //$val[n] é o nome do município. $val[uf] é a UF
                    "ot" => $val["ot"], //Posição no ranking
                    "vs" => array(
                        $ordem_id => array(
                            "v" => $val["v"],
                            "k" => $ordem_id    //Id da variavel 'IDH'
                        )
                    )
                );
                $ids[] = $val["i"];     //Salva no array $ids as chaves de município
            }
            $SQL_e = "SELECT nome, id FROM estado order by nome";   //Retorna os nomes dos estados
            $resp = $bd->ExecutarSQL($SQL_e, "estado 22");
            $this->estados = $resp;
        } else if ($espc == "udh") {     //Se a espacialidade for igual a 'udh'
            foreach ($res as $key => $val) {
                
                $this->data[$val["i"]] = array(//$val[i] é a fk do município
                    "udh" => "{$val["n"]}",
                    "mun" => "{$val["nrm"]}", 
                    "idgeo" => "{$val['idgeo']}",
                    "n" => "{$val["n"]} ({$val["nrm"]})", //$val[n] é o nome do município. $val[uf] é a UF
                    "ot" => $val["ot"], //Posição no ranking
                    "vs" => array(
                        $ordem_id => array(
                            "v" => $val["v"],
                            "k" => $ordem_id    //Id da variavel 'IDH'
                        )
                    )
                );
                $ids[] = $val["i"];     //Salva no array $ids as chaves de município
            }
            $SQL_e = "SELECT nome, id FROM rm WHERE ativo = TRUE order by nome";   //Retorna os nomes dos estados
            $resp = $bd->ExecutarSQL($SQL_e, "ranking 16");
            $this->estados = $resp;
        } else if ($espc == "estadual" || $espc == 'rm') {     //Se a espacialidade for estadual
            $counter = 0;
            $last = 0;
            $hidden_array = array();
            $arr = explode(",", $estados_pos);
            $t = count($arr) - 1;
            foreach ($res as $key => $val) {
                if ($ordem == "desc") {
                    if ($last != cutNumber($val["v"], 3, '.'))
                        $counter++;
                    $last = cutNumber($val["v"], 3, '.');
                }
                if ($ordem == "asc") {
                    $counter = $arr[$t];
                    if($t != 0) {
                        $t--;
                    }
                }
                $hidden_array[] = $counter;

                $val_at = isset($val['at']) ? $val['at'] : '';
                
                $this->data[$val["i"]] = array(
                    "ot" => $val["ot"],
                    "n" => "{$val["n"]}",
                    "ativo" => "{$val_at}",
                    "vs" => array(
                        $ordem_id => array(
                            "v" => $val["v"],
                            "k" => $ordem_id
                        )
                    )
                );
                $ids[] = $val["i"];
            }
            echo "<input type='hidden' value='" . join(",", $hidden_array) . "' id='holderRankEstados' />";
        }
        $places = implode(",", $ids);   //Separa cada id de município por uma vírgula
        $vars = implode(",", array_diff($this->id_indics, array($ordem_id)));   //Retorna a diferença entre os arrays
        $var_name = "";
        if ($espc == "municipal")
            $var_name = "fk_municipio";
        elseif ($espc == "estadual") {
            $var_name = "fk_estado";
        } else if ($espc == 'rm') {
            $var_name = 'fk_rm';
        } else if ($espc == 'udh') {
            $var_name = 'fk_udh';
        }
        //Dentro de $this->sql_f[$espc], onde tiver (ANO), substitui pelo valor de $this->fkAno
        $this->sql_f[$espc] = str_replace("(ANO)", $this->fkAno, $this->sql_f[$espc]);
        //Dentro de $this->sql_f[$espc]) . " and $var_name IN ($places) order by fk_variavel, onde tiver VARS, substitui pelo valor de $vars 
        //Valores das outras 3 colunas do ranking
        $sql_follower = str_replace("VARS", $vars, $this->sql_f[$espc]) . " and $var_name IN ($places) order by fk_variavel";
        $res_f = $bd->ExecutarSQL($sql_follower);
        foreach ($res_f as $key => $val) {
            $this->data[$val["i"]]["vs"][$val["k"]] = array(//Completa o array $this->data com os valores das 3 variáveis
                "v" => $val["v"],
                "k" => $val["k"]
            );
        }
        
        if ($download) {
            ob_end_clean();//Encerro o segundo buffer de saída da pilha e jogo conteúdo fora
            ob_clean();// Limpo o primeiro buffer de saída
            
            /*echo "\t";*/
            $n = $this->getNomeIndicador($ordem_id);
            $n = str_replace(" ", "_", $n);
            if ($espc == "municipal") {
                if ($estado == 0)
                    download_send_headers("AtlasIDHM_RankingMunicipal_" . $n . "_" . convertAnoIDtoLabel($this->fkAno) . "_Brasil.csv");
                else {
                    $n2 = $this->getEstadoNome();
                    $n2 = str_replace(" ", "_", $n2);
                    download_send_headers("AtlasIDHM_RankingMunicipal_" . $n . "_" . convertAnoIDtoLabel($this->fkAno) . "_$n2.csv");
                }
            } else if ($espc == "estadual") {
                download_send_headers("AtlasIDHM_RankingEstadual_" . convertAnoIDtoLabel($this->fkAno) . ".csv");
            } else if ($espc == 'rm') {
                download_send_headers("AtlasIDHM_RankingRM_" . convertAnoIDtoLabel($this->fkAno) . ".csv");
            }
            else if($espc == 'udh') {
                download_send_headers("AtlasIDHM_RankingUDH_" . convertAnoIDtoLabel($this->fkAno) . ".csv");   
            }
            foreach ($this->data as $key => $val) {
                $c = 0;
                echo "sep=;\n";
                echo utf8_decode($lang->getString("cols_ranking_pos") . ";" . $lang->getString("cols_ranking_na") . ";");
                foreach ($val["vs"] as $k => $v) {
                    $or = "desc";
                    $class = "";
                    $class_ds = "";
                    switch ($v["k"]) {
                        case INDICADOR_IDH:
                            echo "{$this->lang->getString("rankin_idhm")} (" . convertAnoIDtoLabel($this->fkAno) . ")";
                            break;
                        case INDICADOR_RENDA:
                            echo "{$this->lang->getString("rankin_renda")} (" . convertAnoIDtoLabel($this->fkAno) . ")";
                            break;
                        case INDICADOR_LONGEVIDADE:
                            echo "{$this->lang->getString("rankin_Long")} (" . convertAnoIDtoLabel($this->fkAno) . ")";
                            break;
                        case INDICADOR_EDUCACAO:
                            echo utf8_decode("{$this->lang->getString("rankin_edu")}") . " (" . convertAnoIDtoLabel($this->fkAno) . ")";
                            break;
                        default:
                            break;
                    }
                    if ($c <= 2)
                        echo ";";
                    $c++;
                }
                break;
            }

            echo "\n";
            $ts = false;
            $counter = 0;
            $last = "0";
            $answer = "";
            $j = 0;
            

            foreach ($this->data as $key => $val) {
            
                $n = (float) cutNumber($val["vs"][INDICADOR_IDH]['v'], 3, '.');
                if (cutNumber($val["vs"][$this->pOrdem_id]['v'], 3, '.', '') != $last) {
                    $counter++;
                }
                $answer.= "{$val["ot"]} º;";
                $answer.= "{$val["n"]};";
                /*$answer.= str_replace(",", "-", $val["n"]). ",";*/
                $c = 0;
                foreach ($val["vs"] as $k => $v) {
                    $val["vs"][$k]["v"] = cutNumber($v["v"], 3, ',', '');
                    if ($c <= 2)
                        $answer.= $val["vs"][$k]["v"] . ";";
                    else
                        $answer.= $val["vs"][$k]["v"];
                    $c++;
                }
                $last = $val["vs"][$this->pOrdem_id]['v'];
                $answer.= "\n";
                $ts = !$ts;
                $j++;
            }

            
            echo utf8_decode($answer);


            if (isset($_POST["cross_data_download"])) {
                $_POST["cross_data_download"] = false;
            }
            die();
        }
    }
    private $lang;
    public function addInstance($v) {
        $this->lang = $v;
    }
    public function getEstadoNome() {
        foreach ($this->estados as $key => $val) {
            if ($this->pEstado == $val["id"])
                return $val["nome"];
        }
        return "Brasil";
    }
    public function retira_acentos($nome){
//       echo $nome;
       $clear_array = array( "á" => "a" , "é" => "e" , "í" => "i" , "ó" => "o" , "ú" => "u" ,
            "à" => "a" , "è" => "e" , "ì" => "i" , "ò" => "o" , "ù" => "u" ,
            "ã" => "a" , "õ" => "o" , "â" => "a" , "ê" => "e" , "î" => "i" , "ô" => "o" , "û" => "u" , "ç" => "c" , "ü" => "u",
            "Á" => "A" , "É" => "E" , "Í" => "I" , "Ó" => "O" , "Ú" => "U",
            "À" => "A" , "È" => "E" , "Ì" => "I" , "Ò" => "O" , "Ù" => "U",
            "Ã" => "A" , "Õ" => "O" , "Â" => "A" , "Ê" => "E" , "Î" => "I" , "Ô" => "O" , "Û" => "U" , "Ç" => "C" , "Ü" => "U", " " => "-"); 
       
        //Tirando acentos do municipio 1
        foreach($clear_array as $key=>$val){
//            echo $key;
//            echo $val;
            $nome = str_replace($key, $val, $nome);
//            echo $nome;
        } 
        
        return $nome;
    }
    
    public function trataNome($nome){
        $nome = $this->retira_acentos($nome);
        $nome = str_replace(' ', '-', $nome);
        $nome = strtolower($nome);
        return $nome;
    }
    
    public function draw() {
        $ts = false;
        $counter = 0;
        $last = "0";
        $answer = "";
        $j = 0;
        foreach ($this->data as $key => $val) {
            $label = "";
            $class = "bolinhaRank ";
            $n = (float) cutNumber($val["vs"][INDICADOR_IDH]['v'], 3, '.');
            $n = (float) cutNumber($val["vs"][INDICADOR_IDH]['v'], 3, '.');
            //Indica a cor da bolinha que será usada
            if ($n < Ranking::vB) {
                $class.="bolinhaMuitoRuim";
                $label = $this->lang->getString("rankin_m_baixo");
            } elseif ($n < Ranking::vC) {
                $class.="bolinhaRuim";
                $label = $this->lang->getString("rankin_baixo");
            } elseif ($n < Ranking::vD) {
                $class.="bolinhaMedia";
                $label = $this->lang->getString("rankin_medio");
            } elseif (($n < Ranking::vE)) {
                $class.="bolinhaBom";
                $label = $this->lang->getString("rankin_alto");
            } else {
                $class.="bolinhaOtimo";
                $label = $this->lang->getString("rankin_fm_alto");
            }
            if (cutNumber($val["vs"][$this->pOrdem_id]['v'], 3, '.', '') != $last) {
                $counter++;
            }

            //Preparação do link para o perfil
            if($this->pEspc == 'municipal'){
                $link = "<a href=".$_SESSION['lang'].'/perfil_m/'.$this->trataNome($val['mun']).'_'.$espc2Convertida = strtolower($val['uf'])." target='_blank'>";
                $balao = "data-original-title='' title data-placement='bottom";
            }
            if ($this->pEspc == 'estadual'){
                $link = "<a href=".$_SESSION['lang'].'/perfil_uf/'.$this->trataNome($val['n'])." target='_blank'>";
            }
            if($this->pEspc == 'rm'){
                if($val['ativo'] == 't'){
                    $link = "<a href=".$_SESSION['lang'].'/perfil_rm/'.$this->trataNome($val['n'])." target='_blank'>";
                }
                else 
                    $link = '';
            }
            if($this->pEspc == 'udh'){
                $link = "<a href=".$_SESSION['lang'].'/perfil_udh/'.$val['idgeo']." target='_blank'>";
            }
            echo "<tr class='rank'>";
            $answer.= "<td class='numRank'>$link{$val["ot"]} º</a></td>";
            
            $answer.= "<td class='rankLugar' >$link{$val["n"]}</a></td>";
            $c = 0;
            foreach ($val["vs"] as $k => $v) {
                $val["vs"][$k]["v"] = cutNumber($v["v"], 3, ',', '');
                if ($k == INDICADOR_IDH) {
                    $answer.= "<td class='cell_rank td_rank_cell _$c'>".$link.$val["vs"][$k]["v"] . "<div class='$class float-right' data-original-title='$label' title data-placement='bottom'></div></a></td>";
                } else
                    $answer.= "<td class='cell_rank td_rank_cell _$c'>".$link.$val["vs"][$k]["v"] . "</a></td>";
                $c++;
            }
            $last = $val["vs"][$this->pOrdem_id]['v'];
            $answer.= "</tr>";
            $ts = !$ts;
            $j++;
        }
        $this->pStart = $counter;
        echo "<table class='rank_table'>";
        echo "<thead><th class='numRank padding-10px-bottom'>{$this->lang->getString("rankin_posicao")}</th><th class='rankLugar'>{$this->lang->getString("rankin_Lugar")}</th>";
        $or = "asc";
        foreach ($this->data as $key => $val) {
            $c = 0;
            foreach ($val["vs"] as $k => $v) {
                $or = "asc";
                $class = "";
                $class_ds = "";
                if ($v["k"] == $this->pOrdem_id) {
                    if ($this->pOrdem == "asc") {
                        $or = "desc";
                        $class_ds = "destaqueRank1";
                        $class = "rank_arrow rank_arrow_down";
                    } else {
                        $class_ds = "destaqueRank1";
                        $class = "rank_arrow rank_arrow_up";
                    }
                }
                switch ($v["k"]) {
                    case INDICADOR_IDH:
                        echo "<th onclick=\"sendData({$v["k"]},'$or',{$this->pPag},'{$this->pEspc}',{$this->pStart},{$this->pEstado})\" class='indicRank'><div class='$class' data-original-title='Ordenar' data-placement='bottom' ></div><div style='clear: both'></div><div class='nameIndcRank idh-td-rank $class_ds j_$c'>{$this->lang->getString("rankin_idhm")}</div></th>";
                        break;
                    case INDICADOR_RENDA:
                        echo "<th onclick=\"sendData({$v["k"]},'$or',{$this->pPag},'{$this->pEspc}',{$this->pStart},{$this->pEstado})\" class='indicRank'><div class='$class' data-original-title='Ordenar' data-placement='bottom'></div><div style='clear: both'></div><div class='nameIndcRank $class_ds j_$c'>{$this->lang->getString("rankin_renda2")}</div></th>";
                        break;
                    case INDICADOR_LONGEVIDADE:
                        echo "<th onclick=\"sendData({$v["k"]},'$or',{$this->pPag},'{$this->pEspc}',{$this->pStart},{$this->pEstado})\" class='indicRank'><div class='$class' data-original-title='Ordenar' data-placement='bottom'></div><div style='clear: both'></div><div class='nameIndcRank $class_ds j_$c'>{$this->lang->getString("rankin_Long")}</div></th>";
                        break;
                    case INDICADOR_EDUCACAO:
                        echo "<th onclick=\"sendData({$v["k"]},'$or',{$this->pPag},'{$this->pEspc}',{$this->pStart},{$this->pEstado})\" class='indicRank'><div class='$class' data-original-title='Ordenar' data-placement='bottom'></div><div style='clear: both'></div><div class='nameIndcRank $class_ds j_$c'>{$this->lang->getString("rankin_edu")}</div></th>";
                        break;
                    default:
                        break;
                }
                $c++;
            }
            break;
        }
        echo "</thead>";
        echo $answer;
        if (!$this->showBtn) {
            if ($j > 99)
                echo "<tr id='tr_load_more'><td colspan='100%'><a class='button-carregar-mais' style='float:right' type='button'>{$this->lang->getString("rankin_exibir_all")}</a></td></tr>";
        }else {
            ?>
            <script>
                $('html, body').animate({
                    scrollTop: $("tr:eq(100)").offset().top - 300
                }, 300);
            </script>
            <?php
            if ($j > 99)
                echo "<tr id='tr_load_more'><td colspan='100%'><a style='float:right;cursor:pointer' type='button' onclick='javascript:$(\"html,body\").scrollTop(0)'></a></td></tr>";
        }
        echo "</table>";
    }
    public function getNomeIndicador($id) {
        switch ($id) {
            case INDICADOR_IDH:
                return $this->lang->getString("rankin_idhm");
            case INDICADOR_RENDA:
                return $this->lang->getString("rankin_renda");
            case INDICADOR_LONGEVIDADE:
                return $this->lang->getString("rankin_Long");
            case INDICADOR_EDUCACAO:
                return $this->lang->getString("rankin_edu");
            default:
                return null;
        }
    }
    public function drawSelect() {
        if ($this->pEspc == "estadual" || $this->pEspc == 'rm') {
            echo "<select  style='display:none' id=\"selectEstados\">";
        } else if ($this->pEspc == 'udh') {
            echo "{$this->lang->getString("rankin_rm")}: <select id=\"selectEstados\">";
        } else
            echo "{$this->lang->getString("rankin_estado")}: <select id=\"selectEstados\">";
        if ($this->pEstado == 0 && $this->pEspc != 'udh')
            echo "<option selected=\"selected\" value='0'>{$this->lang->getString("rankin_todos")}</option>";
        else if ($this->pEstado == 0 && $this->pEspc == 'udh')
            echo "<option selected=\"selected\" value='0'>{$this->lang->getString("rankin_todas")}</option>";
        else
            echo "<option value='0'>Todos</option>";
        foreach ($this->estados as $key => $val) {
            if ($this->pEstado == $val["id"]) {
                echo "<option selected=\"selected\" value='{$val["id"]}'>{$val["nome"]}</option>";
                $this->nomeEstado = $val["nome"];
            } else
                echo "<option value='{$val["id"]}'>{$val["nome"]}</option>";
        }
        echo "</select>";
    }
    public function drawButtons() {
        echo 'drawButtons<br />';
        $aDis = "rank_hover";
        $bDis = "rank_hover";
        $cDis = "rank_hover";
        $dDis = "rank_hover";
        $onclick_a = "onclick=\"sendData({$this->pOrdem_id},'{$this->pOrdem}',1,'{$this->pEspc}',1,{$this->pEstado})\"";
        $onclick_b = "onclick=\"sendData({$this->pOrdem_id},'{$this->pOrdem}'," . ($this->pPag - 1) . ",'{$this->pEspc}',{$this->pStart},{$this->pEstado})\"";
        $onclick_c = "onclick=\"sendData({$this->pOrdem_id},'{$this->pOrdem}'," . ($this->pPag + 1) . ",'{$this->pEspc}',{$this->pStart},{$this->pEstado})\"";
        $onclick_d = "onclick=\"sendData({$this->pOrdem_id},'{$this->pOrdem}',{$this->Paginas},'{$this->pEspc}',{$this->pStart},{$this->pEstado})\"";
        if ($this->Paginas <= 1) {
            $aDis = "disabled";
            $bDis = "disabled";
            $cDis = "disabled";
            $dDis = "disabled";
            $onclick_a = "";
            $onclick_b = "";
            $onclick_c = "";
            $onclick_d = "";
        } elseif ($this->pPag == 1) {
            $aDis = "disabled";
            $bDis = "disabled";
            $onclick_a = "";
            $onclick_b = "";
        } elseif ($this->Paginas == $this->pPag) {
            $cDis = "disabled";
            $dDis = "disabled";
            $onclick_c = "";
            $onclick_d = "";
        }
        echo "<div class='divPaginacaoRank'><div class=\"pagination\">
                        <ul>
                          <li class='$aDis'><a $onclick_a > &#60;&#60; </a></li>
                          <li class='$bDis'><a $onclick_b > &#60; </a></li>
                          <li class='disabled'><a> $this->pPag/{$this->Paginas} </a></li>
                          <li class='$cDis'><a $onclick_c > &#62; </a></li>
                          <li class='$dDis'><a $onclick_d > &#62;&#62; </a></li>
                         </ul>
                       </div></div>";
    }
    public function drawLegenda() {
        $label1 = "bolinha ruim";
        $label2 = "bolinha média";
        $label3 = "bolinha boa";
        $label4 = "bolinha ótima";
        ?>
        <script>$(document).ready(function() {
                $('.rank_arrow').tooltip();
            })</script>
        <div class='legendaRank'>
            <div class='titleLegendaRank'><?php echo $this->lang->getString("rankin_faixas") ?></div>
            <table class="table table-bordered table-condensed td-custom">
                <tr>
                    <td><div class='bolinhaRank bolinhaOtimo'></div></td>
                    <td><?php echo $this->lang->getString("rankin_fm_alto") ?></td>
                    <td>0,800 - 1,000</td>
                </tr>
                <tr>
                    <td><div class='bolinhaRank bolinhaBom'></div></td>
                    <td><?php echo $this->lang->getString("rankin_alto") ?></td>
                    <td>0,700 - 0,799</td>
                </tr>
                <tr>
                    <td><div class='bolinhaRank bolinhaMedia'></div></td>
                    <td><?php echo $this->lang->getString("rankin_medio") ?></td>
                    <td>0,600 - 0,699</td>
                </tr>
                <tr>
                    <td><div class='bolinhaRank bolinhaRuim'></div></td>
                    <td><?php echo $this->lang->getString("rankin_baixo") ?></td>
                    <td>0,500 - 0,599</td>
                </tr>
                <tr>
                    <td><div class='bolinhaRank bolinhaMuitoRuim'></div></td>
                    <td><?php echo $this->lang->getString("rankin_m_baixo") ?></td>
                    <td>0,000 - 0,499</td>
                </tr>
            </table>
        </div>
        <?
        //            echo "<div class='fl_rank'><div></div><div style='text-align:center; width:62px'><small>0,801<br />-<br />1</small></div></div>";
        //            echo "<div class='fl_rank'><div class='bolinhaRank bolinhaBom' data-original-title='Entre 0,651 e 0,800' title data-placement='bottom'></div><div>Alto</div><div style='text-align:center; width:40px'><small>0,651<br />-<br />0,800</small></div></div>";
        //            echo "<div class='fl_rank'><div class='bolinhaRank bolinhaMedia' data-original-title='Entre 0,501 e 0,650' title data-placement='bottom'></div><div>Médio</div><div style='text-align:center; width:40px'><small>0,501<br />-<br />0,650</small></div></div>";
        //            echo "<div class='fl_rank'><div class='bolinhaRank bolinhaRuim' data-original-title='IDH menor que 0,500' title data-placement='bottom'></div><div>Baixo</div><div style='text-align:center; width:40px'><small>0<br />-<br />0,500</small></div></div>";
        }
        //Botão de Download
        public function writeButton() {
        ?>
        <button class="gray_button big_bt" id="imgTab6" data-original-title='Download da lista em formato csv (compatível com o Microsoft Excel e outras planilhas eletrônicas).' title data-placement='bottom' icon="download_2" onclick="sendDataDownload()">
            <img src="assets/img/icons/download_2.png"/>
        </button>
        <?
        }
        public function drawAnoSelect(){
        ?>
        <?php if($this->pEspc != 'rm' && $this->pEspc != 'udh') { ?>
        <span id="1" <?php if($this->fkAno == 1) echo 'class="ano_atual"'; else 'class=""'?> >1991</span> 
        <?php }?>
        <span id="2" <?php if($this->fkAno == 2) echo 'class="ano_atual"'; else 'class=""'?> >2000</span>
        <span id="3" <?php if($this->fkAno == 3) echo 'class="ano_atual"'; else 'class=""'?> >2010</span>
        
        
<!--        <div>
            <div class='labels'>
                <span class="one">1991</span>
                <span class="two">2000</span>
                <span class="tree">2010</span>
            </div>
        </div>
        <div class="sliderDivFather">
            <div class="sliderDivIn">
                <input type='text' id="ranking_year_slider" data-slider="true" data-slider-values="1991,2000,2010" data-slider-equal-steps="true" data-slider-snap="true" data-slider-theme="volume" />
            </div>    
        </div>  -->
        <?php
   /*    return;
       echo "<select id='selct_ano' name='selct_ano'>";
       if ($this->fkAno == 1) {
           echo "<option value='1' selected='selected'>1991</option>";
       } else {
           echo "<option value='1'>1991</option>";
       }
       if ($this->fkAno == 2) {
           echo "<option value='2' selected='selected'>2000</option>";
       } else {
           echo "<option value='2'>2000</option>";
       }
       if ($this->fkAno == 3) {
           echo "<option value='3' selected='selected'>2010</option>";
       } else {
           echo "<option value='3'>2010</option>";
       }
       echo "</select>";*/
    }
}
function convertAnoIDtoLabel($anoLabel) {
    /*echo 'anoLabel: ' . $anoLabel . '<br />';*/
    switch ((int) $anoLabel) {
        case 1:
            return 1991;
        case 2:
            return 2000;
        case 3:
            return 2010;
        default :
            return 2010;
    }
}

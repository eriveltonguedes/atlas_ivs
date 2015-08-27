<?php

class Histogram {

    private $idIndicador;
    private $idAno;
    private $espacialidade;
    private $parteInicialSQL;
    private $parteFinalSQL;
    private $SQL;
    private $casasDecimais;
    private $sqlValorVariaveis;
    private $arrayConsulta;
    private $conexao;
    private $xmax;
    private $xmin;
    private $quantidade;
    private $quantidadeClasse;
    private $amplitudeTotal;
    private $amplitudeDaClasse;
    private $media;
    private $mediana;
    private $variancia;
    private $desvioPadrao;
    private $assimetria;
    private $curtose;
    private $lugares;
    private $limiteMinDeEspacialidade = 16;

    /**
      name: construct
      desc: seta os valores de idIndicador, idAno e espacialidade

      arg: $indicador
      desc: id do indicador

      arg: $ano
      desc: id do ano

      arg: $espacialidade
      desc: valor da espacialidade
     * */
    public function __construct($arrayConsulta) {
        $this->espacialidade = $arrayConsulta[0];
        $this->idAno = $arrayConsulta[3];
        $this->idIndicador = $arrayConsulta[2];
        $this->lugares = $arrayConsulta[1];
        $this->getSQL();
        /*var_dump($this->parteFinalSQL);*/
        $this->bd = new bd();
        $this->consultar();
    }

    public function getSQL() {
        $this->getParteInicialSQL();
        $this->getParteFinalSQL();
    }

    public function getParteFinalSQL() {
        $SQL2 = "fk_ano_referencia = $this->idAno AND fk_variavel = $this->idIndicador";

        $ests = 0;
        $muns = 0;
        $muns_e = 0;
        $muns_r = 0;
        $rms = 0;
        $udhs = 0;
        $udhs_r = 0;
        $udhs_m = 0;
        $ris = 0;
        $regis = 0;
        $regis_m = 0;
        if ($this->espacialidade == 2) {   //Verifica se a espacialidade é municipal
            if (isset($this->lugares['est'])) {    //Se $val['est'](estado selecionado p/ municipio) não estiver vazio
                $muns_e = implode(',', $this->lugares['est']);
            }
            if (isset($this->lugares['rm'])) {
                $muns_r = implode(',', $this->lugares['rm']);
            }
            if (isset($this->lugares['id'])) {
                $muns = implode(',', $this->lugares['id']);
            }
        } 
        else if ($this->espacialidade == 3) {    //Regional
            if (isset($this->lugares['id']))
                $regis = implode(',', $this->lugares['id']);
            if (isset($this->lugares['mun']))
                $regis_m = implode(',', $this->lugares['mun']);
        }
        else if ($this->espacialidade == 4) {    //Estadual
            $ests = implode(',', $this->lugares['id']);
        }
        else if ($this->espacialidade == 5) {  //UDH
            if (isset($this->lugares['rm']))
                $udhs_r = implode(',', $this->lugares['rm']);
            if (isset($this->lugares['mun']))
                $udhs_m = implode(',', $this->lugares['mun']);
            if (isset($this->lugares['id']))
                $udhs = implode(',', $this->lugares['id']);
        }
        else if ($this->espacialidade == 6) {    //Região Metropolitana
            if (isset($this->lugares['id']))
                $rms = implode(',', $this->lugares['id']);
        }
        else if ($this->espacialidade == 7) {    //Região de Interesse
            if (isset($this->lugares['id']))
                $ris = implode(',', $this->lugares['id']);
        }
        
        switch ($this->espacialidade) {
            case Consulta::$ESP_ESTADUAL:
                if ($ests == '-1') {
                    $this->parteFinalSQL = $this->parteInicialSQL . "fk_estado in (SELECT id FROM estado) AND $SQL2";
                } else {
                    $this->parteFinalSQL = $this->parteInicialSQL . "fk_estado in ($ests) AND $SQL2";
                }
                break;
            case Consulta::$ESP_MUNICIPAL:
                if ($muns == '-1') {      //Foi escolhido todos os municipios do Brasil
                    $this->parteFinalSQL = $this->parteInicialSQL . "fk_municipio in (SELECT id FROM municipio) AND $SQL2";
                } else if ($muns != 0 || $muns_r != 0 || $muns_e != 0) {
                    $this->parteFinalSQL = $this->parteInicialSQL . "(fk_municipio in ($muns) OR fk_rm in ($muns_r) OR fk_estado in ($muns_e)) AND $SQL2";
                }
                break;
            case Consulta::$ESP_REGIAOMETROPOLITANA:
                if ($rms == '-1') {
                    $this->parteFinalSQL = $this->parteInicialSQL . "fk_rm in (SELECT id FROM rm) AND $SQL2";
                } else {
                    $this->parteFinalSQL = $this->parteInicialSQL . "fk_rm in ($rms) AND $SQL2";
                }
                break;
            case Consulta::$ESP_REGIONAL:
                if ($regis == '-1') {
                    $this->parteFinalSQL = $this->parteInicialSQL . "fk_rm in (SELECT id FROM rm) AND $SQL2";
                } else {
                    $this->parteFinalSQL = $this->parteInicialSQL . "fk_rm in ($regis) AND $SQL2";
                }
                break;
        }
    }

    public function getParteInicialSQL() {
        $this->parteInicialSQL = "";
        switch ($this->espacialidade) {
            case Consulta::$ESP_ESTADUAL:
                $this->parteInicialSQL = "SELECT vv.valor, v.decimais
                                            FROM valor_variavel_estado as vv
                                            INNER JOIN variavel as v ON (vv.fk_variavel = v.id)
                                            INNER JOIN estado as e ON (e.id = vv.fk_estado)
                                            INNER JOIN regiao as r ON (r.id = e.fk_regiao)
                                            WHERE ";
                break;
            case Consulta::$ESP_MUNICIPAL:
                $this->parteInicialSQL = "SELECT vv.valor, v.decimais
                                            FROM valor_variavel_mun as vv
                                            INNER JOIN variavel as v ON (vv.fk_variavel = v.id)
                                            INNER JOIN municipio as m ON (m.id = vv.fk_municipio)
                                            INNER JOIN estado as e ON (e.id = m.fk_estado)
                                            INNER JOIN regiao as r ON (r.id = e.fk_regiao)
                                            WHERE ";
                break;
            case Consulta::$ESP_UDH:
                $this->parteInicialSQL = "SELECT vv.valor, v.decimais
                                            FROM valor_variavel_udh as vv
                                            INNER JOIN variavel as v ON (vv.fk_variavel = v.id)
                                            INNER JOIN udh ON (udh.id = vv.fk_udh)
                                            WHERE ";
                break;
            case Consulta::$ESP_REGIAOMETROPOLITANA:
                $this->parteInicialSQL = "SELECT vv.valor, v.decimais
                                            FROM valor_variavel_rm as vv
                                            INNER JOIN variavel as v ON (vv.fk_variavel = v.id)
                                            INNER JOIN rm ON (rm.id = vv.fk_rm)
                                            WHERE ";
                break;
            case Consulta::$ESP_REGIONAL:
                $this->parteInicialSQL = "SELECT vv.valor, v.decimais
                                            FROM valor_variavel_regional as vv
                                            INNER JOIN variavel as v ON (vv.fk_variavel = v.id)
                                            INNER JOIN regional as r ON (r.id = v.fk_regional)
                                            WHERE ";
        }
    }

    public function consultar() {
        $ParteInicialSQL = "";
        $filtro = "";
        switch ($this->espacialidade) {
            case Consulta::$ESP_ESTADUAL:
                $parteInicialSQL = "SELECT vv.valor, vv.fk_variavel 
                                        FROM valor_variavel_estado as vv
                                        INNER JOIN variavel as v ON (vv.fk_variavel = v.id)
                                        INNER JOIN estado as e ON (e.id = vv.fk_estado)
                                        INNER JOIN regiao as r ON (r.id = e.fk_regiao)
                                        WHERE ";
                $filtro = "fk_estado";
                break;
            case Consulta::$ESP_MUNICIPAL:
                $parteInicialSQL = "SELECT valor, fk_municipio,fk_ano_referencia as id_a,fk_variavel as id_v, m.nome as nome,e.uf as uf 
                                        FROM valor_variavel_mun as vv
                                        INNER JOIN variavel as v ON (vv.fk_variavel = v.id)
                                        INNER JOIN municipio as m ON (m.id = vv.fk_municipio)
                                        INNER JOIN estado as e ON (e.id = m.fk_estado)
                                        INNER JOIN regiao as r ON (r.id = e.fk_regiao)
                                        WHERE ";
                $filtro = "fk_municipio";
                break;
            case Consulta::$ESP_UDH:
                $parteInicialSQL = "SELECT valor, fk_udh,fk_ano_referencia,fk_variavel, udh.nome 
                                        FROM valor_variavel_udh as vv
                                        INNER JOIN variavel as v ON (vv.fk_variavel = v.id)
                                        INNER JOIN udh ON (udh.id = vv.fk_udh)
                                        WHERE ";
                $filtro = "fk_udh";
                break;
            case Consulta::$ESP_REGIAOMETROPOLITANA:
                $parteInicialSQL = "SELECT valor, fk_rm,fk_ano_referencia,fk_variavel, rm.nome 
                                        FROM valor_variavel_rm as vv
                                        INNER JOIN variavel as v ON (vv.fk_variavel = v.id)
                                        INNER JOIN rm ON (rm.id = vv.fk_rm)
                                        WHERE ";
                $filtro = "fk_rm";
                break;
        }
        
        $Resposta = pg_query($this->bd->getConexaoLink(), $this->parteFinalSQL) or die('Não foi possível executar a consulta');
        $i = 0;
        while ($linha = pg_fetch_array($Resposta)) {
            $this->casasDecimais = $linha[1];
            $this->arrayConsulta[] = ($linha[0] != '') ? $linha[0] : 0;
            $i++;

        }
        sort($this->arrayConsulta);     //Ordena o array
        $iN = count($this->arrayConsulta);      //Quantidade de linhas retornadas na consulta

        if($iN < $this->limiteMinDeEspacialidade){
            $retorno = array();
            $retorno['status'] = false;
            $retorno['data'] = $this->limiteMinDeEspacialidade;
            $retorno['msg'] = "mensagem-limite-espacialidade-histograma";
            echo json_encode($retorno);
            exit();
        }
//        $this->xmax = $this->round_up($this->arrayConsulta[$iN - 1], $this->casasDecimais);        //Valor Máximo
//        $this->xmin = $this->round_down($this->arrayConsulta[0], $this->casasDecimais);
        $this->xmax = $this->arrayConsulta[$iN - 1];
//        echo 'Max: '.$this->xmax.'   / ';
        $this->xmin = $this->arrayConsulta[0];
//        echo 'Min: '.$this->xmin.'   / ';
        $this->quantidade = $iN;
        $this->kSturges();
        $this->lAmplitude();
        $this->hAmplitude();
    }

    //============================================================
    // Calcular a quantidade de classes por Sturges
    //============================================================
    public function kSturges() {
        if ($this->quantidade > 250) {
            $this->quantidadeClasse = 10;
        } else if ($this->quantidade > 100) {
            $this->quantidadeClasse = 7;
        } else if ($this->quantidade > 50) {
            $this->quantidadeClasse = 6;
        } else if ($this->quantidade > 10) {
            $this->quantidadeClasse = 5;
        } else if ($this->quantidade >= 3) {
            $this->quantidadeClasse = 3;
        } else {
            $this->quantidadeClasse = $this->quantidade;
        }
//        echo 'Qtd de classes: '.$this->quantidadeClasse.'   / ';
    }

    //============================================================//
    //Calcular a amplitude do conjunto de dados
    //============================================================//
    public function lAmplitude() {
        $this->amplitudeTotal = $this->xmax - $this->xmin;
//        echo 'Amplitude: '.$this->amplitudeTotal.'   / ';
    }

    //============================================================//
    //Calcular a amplitude(largura) da classe
    //============================================================//
    public function hAmplitude() {
        $this->amplitudeDaClasse = $this->amplitudeTotal/$this->quantidadeClasse;
//        $this->amplitudeDaClasse = $this->amplitudeTotal/$this->quantidadeClasse;
//        echo 'Amplitude da classe: '.$this->amplitudeDaClasse.'  / ';
    }

    public function round_down($number, $precision = 3) {
        $fig = (int) str_pad('1', $precision, '0');
        return (floor($number * $fig) / $fig);
    }

//    public function round_up($number, $precision = 3) {
////        echo '// '.$number.'  ';
////        $fig = (int) str_pad('1', $precision, '0');        
////        echo $fig.'   ';
////        echo ceil($number * $fig).'   ';
////        return (ceil($number * $fig) / $fig);
//        
//        if ($precision < 0) { 
//            $precision = 0; 
//        }
//        $mult = pow(10, $precision);
//        return ceil($number * $mult) / $mult;
//    }
    function round_up ($value, $places=0) {
        if ($places < 0) { $places = 0; }
        $mult = pow(10, $places);
        return ceil($value * $mult) / $mult;
      }

    //============================================================
    // Cálculo da média Aritmética
    //============================================================
    public function media() {
        $this->media = 0;
        foreach ($this->arrayConsulta as $key => $val) {
            $this->media += $this->arrayConsulta[$key];
        }
        $this->media = $this->media / $this->quantidade; 
//        echo $this->media.'  ';
                
                
        $this->media = str_replace('.', ',', $this->media); //Transformo o .(ponto) em ,(vírgula)
        $pos = strpos($this->media, ',');     //Posição da vírgula
        if ($this->casasDecimais <> 0){
            $this->media = substr($this->media, 0, ($pos + 1) + $this->casasDecimais);    
        }
        else{
            if ($pos > 0){ 
                $this->media = number_format($this->media, 3, ',', '.');
            }
            else{
                $this->media = number_format($this->media, 0, ',','.');
            }
        }
    }
    
    //============================================================
    // Cálculo da Variância
    //============================================================
    public function variancia(){
        $x = 0;
        $k = 0;
        foreach ($this->arrayConsulta as $key => $val){
            $media = str_replace(',', '.', $this->media);
            $k = $this->arrayConsulta[$key] - $media;
            $x += pow($k, 2);
        }
        $this->variancia = $x / $this->quantidade;
        if ($this->variancia > 0){
            $this->variancia = str_replace('.', ',', $x /$this->quantidade);
            $pos = strpos($this->variancia, ',');
            if ($this->casasDecimais <> 0){
                $this->variancia = substr($this->variancia, 0, ($pos + 1) + $this->casasDecimais);    
            }
            else{
                if ($pos > 0){ 
                    $this->variancia = number_format($this->variancia, 3, ',', '.');
                }
                else{
                    $this->variancia = number_format($this->variancia, 0, ',','.');
                }
            }
//            $this->variancia = substr($this->variancia, 0, ($pos + 1) + $this->casasDecimais);
        }
        else{
            $this->variancia = number_format($this->variancia, $this->casasDecimais, ',', '.');
        }
    }
    
    //============================================================
    // Cálculo do Desvio Padrão
    //============================================================
    public function desvioPadrao(){
        $this->desvioPadrao = sqrt(str_replace(',', '.', $this->variancia));
        if ($this->desvioPadrao > 0){
            $this->desvioPadrao = str_replace('.', ',', $this->desvioPadrao);
            $pos = strpos($this->desvioPadrao, ',');
            if ($this->casasDecimais <> 0){
                $this->desvioPadrao = substr($this->desvioPadrao, 0, ($pos + 1) + $this->casasDecimais);    
            }
            else{
                if ($pos > 0){ 
                    $this->desvioPadrao = number_format($this->desvioPadrao, 3, ',', '.');
                }
                else{
                    $this->desvioPadrao = number_format($this->desvioPadrao, 0, ',','.');
                }
            }
//            $this->desvioPadrao = substr($this->desvioPadrao, 0, ($pos + 1) + $this->casasDecimais);
        }
        else{
            $this->desvioPadrao = number_format($this->desvioPadrao, $this->casasDecimais, ',', '.');
        }
    }
    
    //============================================================
    // Cálculo da Mediana
    //============================================================
    public function mediana(){
        $q = count($this->arrayConsulta);

        if ($q % 2 == 0) {  //Se a quantidade da amostra for par
            $meio = ($q / 2) - 1;
            $meio2 = $meio + 1;
//            echo $this->arrayConsulta[$meio].'  '.  $this->arrayConsulta[$meio2].'  ';
            $this->mediana = ($this->arrayConsulta[$meio] + $this->arrayConsulta[$meio2]) / 2;
//            echo $this->mediana.'  ';
        } else { //Se a quantidade da amostra for ímpar
            $this->mediana = $this->arrayConsulta[(($q + 1) / 2) - 1];
        } 
        $this->mediana = str_replace('.', ',', $this->mediana); //Transformo o .(ponto) em ,(vírgula)
//        echo $this->mediana.'  ';
        $pos = strpos($this->mediana, ',');     //Posição da vírgula
        if ($this->casasDecimais <> 0){
            $this->mediana = substr($this->mediana, 0, ($pos + 1) + $this->casasDecimais);    
        }
        else{
            if ($pos > 0){ 
                $this->mediana = number_format($this->mediana, 3, ',', '.');
            }
            else{
                $this->mediana = number_format($this->mediana, 0, ',','.');
            }
        }
//        $this->mediana = substr($this->mediana, 0, ($pos + 1) + $this->casasDecimais);
    }

    public function DrawTabela() {
        echo "<table class='data'  width='500px'>
                    <thead id='relatorio_thead'>
                        <tr>
                            <th rowspan='' style='width:90px;text-align:center'>Observa��es</th>
                            <th colspan='' style='width:90px;text-align:center'>M�nimo</th>
                            <th colspan='' style='width:90px;text-align:center'>Mediana</th>
                            <th colspan='' style='width:90px;text-align:center'>M�ximo</th>
                            <th colspan='' style='width:90px;text-align:center'>Amplitude</th>
                            <th colspan='' style='width:90px;text-align:center'>M�dia</th>
                            <th colspan='' style='width:90px;text-align:center'>Desvio Padr�o</th>
                            <th colspan='' style='width:90px;text-align:center'>Assimetria</th>
                            <th colspan='' style='width:90px;text-align:center'>Curtose</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style='text-align:center;width:90px;'>{$this->Quantidade}</td>
                            <td style='text-align:center;width:90px;'>{$this->Xmin}</td>
                            <td style='text-align:center;width:90px;'>{$this->Mediana}</td>
                            <td style='text-align:center;width:90px;'>{$this->Xmax}</td>
                            <td style='text-align:center;width:90px;'>{$this->AmplitudeTotal}</td>
                            <td style='text-align:center;width:90px;'>" . number_format($this->Media, 3, ',', '') . "</td>
                            <td style='text-align:center;width:90px;'>" . number_format($this->DesvioPadrao, 2, ',', '') . "</td>
                            <td style='text-align:center;width:90px;'>" . number_format($this->Assimetria, 2, ',', '') . "</td>
                            <td style='text-align:center;width:90px;'>" . number_format($this->Curtose, 2, ',', '') . "</td>   
                        </tr>
                    </tbody>
                  </table><br />";
    }

    public function convertAnoIDtoLabel($anoLabel) {
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

    //============================================================//
    //Desenha o histograma, se n�o definir o elemento ele desenha 
    //onde chamar o metodo.
    //============================================================//
    public function DrawHistograma() {
//        echo $this->amplitudeDaClasse;
                
        $nomeElemento = "chart_div";
        $tempArray = $this->arrayConsulta;
        $pontoMedio = $this->xmin;
        $int = $this->xmax / 10;
//        $limiteInferior = $this->round_down($this->xmin, $this->casasDecimais);
        $limiteInferior = $this->xmin;
        for ($i = 0; $i < $this->quantidadeClasse; $i++) {
            $contador = 0;
            if ($this->quantidadeClasse < 3) {
                $contador++;
                if ($this->casasDecimais == 0) {
                    $printMedia[] = '0 - ' . (number_format(intval($tempArray[$i]), $this->casasDecimais, ',', '.'));  //intval retorna a parte inteira do número
                } else {
                    $printMedia[] = '0 - ' . number_format($tempArray[$i], $this->casasDecimais, ',', '.');
                }
                $frequencia[] = $contador;
            } else {
                $limiteSuperior = $limiteInferior + $this->amplitudeDaClasse;
                if ($this->casasDecimais == 0) {
                    $printMedia[] = (number_format(intval($limiteInferior), $this->casasDecimais, ',', '.')) . ' - ' . (number_format(intval($limiteSuperior), $this->casasDecimais, ',', '.'));
                } else {
                    $printMedia[] = number_format($limiteInferior, $this->casasDecimais, ",", ".") . ' - ' . number_format($limiteSuperior, $this->casasDecimais, ",", ".");
                }
                
//                
                foreach ($tempArray as $key => $val) {
//                    
                    //Compara para ver se o valor dentro de $tempArray[$key] é maior ou que o limite inferior da classe atual e menor que o limite superior desta.
                    //Se conferir com a condição, incrementa o contador
                    if ($limiteInferior == $limiteSuperior) {
                        $contador++;
                        break;
                    }

                    if ($tempArray[$key] >= $limiteInferior && ($tempArray[$key] < $limiteSuperior)) {
//                        echo $limiteInferior.'   ';
//                        echo $limiteSuperior.'   ';
//                        echo $tempArray[$key].'   ';
                        $contador++; //8  //6  //7  //5  //1
                    }

                    //Se não conferir com a condição acima, significa que o valor não está dentro do intervalo da classe, podendo então, sair do foreach
                    if ($tempArray[$key] > $limiteSuperior) {
                        break;
                    }
                }
                $frequencia[] = $contador;
                $limiteInferior = $limiteSuperior;
            }
        }
        if (empty($frequencia)) {
            return;
        }
        
        $data2 = array();
//        echo $printMedia[count($printMedia)-1].'  ';
        $diff = $this->quantidade - array_sum($frequencia);
//        echo $diff.'  ';
        $frequencia[count($frequencia)-1]+=$diff;
        foreach ($printMedia as $key => $val) {
            $amplitude[] = $printMedia[$key];
            $valor[] = $frequencia[$key];    //quantidade de elementos por barra
        }

        
        $data2['ano_referencia'] = $this->convertAnoIDtoLabel($this->idAno);
        $data2['intervalo'] = $amplitude;
        $data2['frequencia'] = $valor;
        $data2['media'] = $this->media;
        
        $data3['options'] = array(
            'legend' => array(
                'position' => 'none'
            ),
            'chartArea' => array(
                'left' => 80,
                'top' => 50,
                'width' => 960,
            ),
            'width' => 960,
            'height' => 500,
            'hAxis' => array(
                'title' => 'Intervalo',
                'titleTextStyle' => array(
                    'fontSize' => 14,
                    'italic' => false
                ),
                'maxAlternation' => 0,
                'maxTextLines' => 10,
                'minTextSpacing' => 1,
                'gridlines' => array(
                    'count' => 6
                ),
                'ticks' => array(0, 2, 4, 6, 10, 12, 14, 16, 18, 20)
            ),
            'bar' => array(
                'groupWidth' => '70%'
            ),
            'vAxis' => array(
                'title' => 'Frequência de espacialidades',
                'gridlines' => 4,
                'titleTextStyle' => array(
                    'fontSize' => 14,
                    'italic' => false
                )
            )
        );

        $data3['ne'] = $nomeElemento;
//        echo $this->nomeVariavel;
//        $data3['nomeVariavel'] = $this->nomeVariavel;
        $data3['nomeVariavel'] = 'Intervalo';
        $qtd = count($printMedia);
        $data3['qtdPrintMedia'] = $qtd;
        
        $this->media();
        $data2['media'] = $this->media;
        $this->variancia();
        $data2['variancia'] = $this->variancia;
        $this->desvioPadrao();
        $data2['desvio_padrao'] = $this->desvioPadrao;
        $this->mediana();
        $data2['mediana'] = $this->mediana;
               
        return ($data2 + $data3);
    }

    //============================================================//
    //Calcular a amplitude do conjunto de dados
    //============================================================//
    public function mMedia($arrColuna, $arrLinha) {
        $x = 0;
        foreach ($this->arrayConsulta as $key => $val) {
            $x += $this->arrayConsulta[$key];
        }
//        echo 'X: '.$x.'<br />';

        $this->media = $x / $this->quantidade;
        echo $this->media.'  ';
        
        $x = 0;

        foreach ($this->arrayConsulta as $key => $val) {
            echo 'Array: '.$this->arrayConsult[$key].'  ';
            if ($arrLinha[$key] == 0)
                continue;
            $k = $this->arrayConsult[$key] - $this->media;
            echo $k.'  ';
            $x += bcpow($k, 2, 3);
            echo $x.'  ';
        }
        $this->desvioPadrao = sqrt($x / $this->quantidade);

        $q = count($this->arrayConsulta);

        if ($q % 2 == 0) {
            $meio = ($q / 2);
            $meio2 = $meio + 1;
            $this->mediana = ($this->arrayConsulta[$meio] + $this->arrayConsulta[$meio2]) / 2;
        } else {
            $this->mediana = $this->arrayConsulta[($q + 1) / 2];
        }

        $moda = 3 * ($this->media - $this->mediana);
        $this->assimetria = $moda / $this->desvioPadrao;
        $fac = array();
        $a = 0;
        foreach ($arrLinha as $key => $val) {
            $a += $arrLinha[$key];
            $fac[] = $a;
        }
        $e1 = ($this->quantidade / 4);
        $e1_V = 0;
        for ($x = 0; $x < count($fac); $x++) {
            if ($fac[$x] >= $e1) {
                $e1_V = $x;
                break;
            }
        }
        $f = $this->amplitudeDaClasse;
        $somatorio = $e1;
        $somatorioAnterior = isset($fac[$e1_V - 1]) ? $fac[$e1_V - 1] : 0;
        $frequenciaSimples = $arrLinha[$e1_V];
        $numDaColuna = str_replace(",", ".", $arrColuna[$e1_V]);
        $limiteInferio = $numDaColuna - ($this->amplitudeDaClasse / 2);
        $q1 = $limiteInferio + (($somatorio - $somatorioAnterior) * $f) / $frequenciaSimples;
        $e1 = ((3 * $this->quantidade) / 4);
        $e1_V = 0;
        for ($x = 0; $x < count($fac); $x++) {
            if ($fac[$x] >= $e1) {
                $e1_V = $x;
                break;
            }
        }
        $somatorio = $e1;
        $somatorioAnterior = isset($fac[$e1_V - 1]) ? $fac[$e1_V - 1] : 0;
        $frequenciaSimples = $arrLinha[$e1_V];
        $numDaColuna = str_replace(",", ".", $arrColuna[$e1_V]);
        $limiteInferio = $numDaColuna - ($this->amplitudeDaClasse / 2);
        $q3 = $limiteInferio + (($somatorio - $somatorioAnterior) * $f) / $frequenciaSimples;

        $e1 = ((10 * $this->quantidade) / 100);
        $e1_V = 0;
        for ($x = 0; $x < count($fac); $x++) {
            if ($fac[$x] >= $e1) {
                $e1_V = $x;
                break;
            }
        }
        $somatorio = $e1;
        $somatorioAnterior = isset($fac[$e1_V - 1]) ? $fac[$e1_V - 1] : 0;
        $frequenciaSimples = $arrLinha[$e1_V];
        $numDaColuna = str_replace(",", ".", $arrColuna[$e1_V]);
        $limiteInferio = $numDaColuna - ($this->amplitudeDaClasse / 2);
        $p10 = $limiteInferio + (($somatorio - $somatorioAnterior) * $f) / $frequenciaSimples;

        $e1 = ((90 * $this->quantidade) / 100);
        $e1_V = 0;
        for ($x = 0; $x < count($fac); $x++) {
            if ($fac[$x] >= $e1) {
                $e1_V = $x;
                break;
            }
        }
        $somatorio = $e1;
        $somatorioAnterior = isset($fac[$e1_V - 1]) ? $fac[$e1_V - 1] : 0;
        $frequenciaSimples = $arrLinha[$e1_V];
        $numDaColuna = str_replace(",", ".", $arrColuna[$e1_V]);

        $limiteInferio = $numDaColuna - ($this->amplitudeDaClasse / 2);
        $p90 = $limiteInferio + (($somatorio - $somatorioAnterior) * $f) / $frequenciaSimples;
        if ($p90 - $p10 != 0)
            $c = ($q3 - $q1) / (2 * ($p90 - $p10));
        else
            $c = "-";

        $this->curtose = $c;
//        echo 'Curtose: '.$this->curtose.'<br />';
    }

}

/**
  name: selectByRegions
  desc: seleciona as variáveis referentes ás regiões

  arg: $regions
  desc: array com os ids regiões

  arg: $in
  desc: id do indicador

  arg: $an
  desc: id do ano
 * */
//        public function selectByRegions($regions, $in, $an) { //regiao, indicador e ano
//            if(sizeof($regions) <= 0)return 0;
//
//            foreach ($regions as $value) {
//                $regions_to_search = $regions_to_search . $value . ",";
//            }
//            $regions_to_search = substr($regions_to_search, 0, -1);
//            $sql = "";
//            
//            if ($this->espacialidade == Consulta::$ESP_REGIONAL){
//                $sql = "SELECT r.id, v.valor 
//                        FROM regiao r 
//                        INNER JOIN valor_variavel_regiao v 
//                        ON r.id = v.fk_regiao 
//                        WHERE fk_regiao in($regions_to_search) AND v.fk_ano_referencia = $an AND v.fk_variavel = $in ";
//            }
//            else if($this->espacialidade == Consulta::$ESP_ESTADUAL){
//                $sql = "SELECT e.id, v.valor 
//                        FROM estado e 
//                        INNER JOIN valor_variavel_estado v on e.id = v.fk_estado 
//                        INNER JOIN regiao r 
//                        ON r.id = e.fk_regiao 
//                        WHERE fk_regiao in($regions_to_search) AND v.fk_ano_referencia = $an AND v.fk_variavel = $in ";              
//            }
//            else if ($this->espacialidade == Consulta::$ESP_MUNICIPAL) {
//                $sql = "SELECT m.id, v.valor 
//                        FROM municipio m 
//                        INNER JOIN valor_variavel_mun v 
//                        ON m.id = v.fk_municipio 
//                        INNER JOIN estado e 
//                        ON e.id = m.fk_estado 
//                        INNER JOIN regiao r 
//                        ON r.id = e.fk_regiao 
//                        WHERE e.fk_regiao in($regions_to_search) AND v.fk_ano_referencia = $an AND v.fk_variavel = $in ";              
//            }
//           $this->sqlValorVariaveis = $sql;
//        }
//        
////        public function selectByStates($states, $in, $an) {
//        public function selectByStates();
//            if(sizeof($states) <= 0)return 0;
//            
//            foreach ($this->lugares as $value) {
//                $states_to_search = $states_to_search . $value . ",";
//            }
//            
//            $states_to_search = substr($states_to_search, 0, -1);
//
//            $sql = "";
//
//            if($this->espacialidade == Consulta::$ESP_ESTADUAL){
//                $sql = "SELECT e.id, v.valor 
//                        FROM estado e 
//                        INNER JOIN valor_variavel_estado v 
//                        ON e.id = v.fk_estado 
//                        WHERE fk_estado in ($states_to_search) AND v.fk_ano_referencia = $an AND v.fk_variavel = $in ";              
//            }
//            if($this->espacialidade == Consulta::$ESP_MUNICIPAL) {            
//                $sql = "SELECT m.id, v.valor 
//                        FROM municipio m 
//                        INNER JOIN valor_variavel_mun v 
//                        ON m.id = v.fk_municipio 
//                        INNER JOIN estado e 
//                        ON e.id =  m.fk_estado 
//                        WHERE fk_estado in ($states_to_search) AND v.fk_ano_referencia = $an AND v.fk_variavel = $in ";              
//            }
//            $this->sqlValorVariaveis = $sql;
//        }
//        
//     public function selectByCities($cities, $in, $an) {
//        foreach ($cities as $value) {
//            $cities_to_search = $cities_to_search . $value . ",";
//        }
//        $cities_to_search = substr($cities_to_search, 0, -1);
//
//        $sql = "";
//        
//        if ($this->espacialidade == Consulta::$ESP_MUNICIPAL) {            
//            $sql = "SELECT m.id, v.valor 
//                    FROM municipio m 
//                    INNER JOIN valor_variavel_mun v 
//                    ON m.id = v.fk_municipio 
//                    WHERE fk_municipio in ($cities_to_search) AND v.fk_ano_referencia = $an AND v.fk_variavel = $in ";              
//        }
//        $this->sqlValorVariaveis = $sql;
//
//    }
//        
//        //============================================================//
//        //Faz a consulta passando para a variavel ArrayConsulta
//	//$ConexaoLink: Recebe a vari�vel de conex�o ao banco de dados
//        //============================================================//
//        public function ConsultarSQL($con){
//            $link = $con->open();
//            $resultado = pg_query($link, $this->sqlValorVariaveis);
//            $row = pg_fetch_row($resultado, null, PGSQL_ASSOC);
//            while ($linha = pg_fetch_array($resultado)){
//                $linha['id'];
//                $this->arrayConsulta[] = ($linha[0] != "") ? $linha[0] : 0;
//            }
//            sort($this->arrayConsulta);
//        }
//        
//        
//        
//        
//        public function getFunctions($con){
//            $this->ConsultarSQL($con);
//            $iN = count($this->arrayConsulta);
//            $this->xmax = $this->arrayConsulta[$iN - 1];
//            $this->xmin = $this->arrayConsulta[0];
//            $this->quantidade = $iN;
//            //$this->fNomeVariavel($con);
//            //$this->fLabelAno($ConexaoLink);
//            $this->kSturges();
//            $this->lAmplitude();
//            $this->hAmplitude();
//        }
//
//        
//        public function ImprimirBtn(){
//            $url = str_replace(strrchr($_SERVER["REQUEST_URI"], "?"), "", $_SERVER["REQUEST_URI"]);
//            $url[strlen($url)-1] != "/" ? $url[strlen($url)] = "/": "";
//        }
//
//        
//        //============================================================//
//        //Pegar o nome da regi�o
//        //============================================================//
//        public function getNomeArea($Area,$ID = 0,$ConexaoLink = null/*,$Estado = false*/){
//            if(!$Estado){
//                switch ($Area){
//                    case 'MR':
//                        $tabela = "microregiao";
//                        $this->NomeAreaPesquisa = 'Todos os munic�pios da microregi�o ';
//                        break;
//                    case 'ES':
//                        $tabela = "estado";
//                        $this->NomeAreaPesquisa = 'Todos os munic�pios do estado ';
//                        break;
//                    case 'RE':
//                        $tabela = "regiao";
//                        $this->NomeAreaPesquisa = 'Todos os munic�pios da regi�o ';
//                        break;
//                    case 'AL':
//                        $this->NomeAreaPesquisa = "Todos os munic�pios do Brasil";
//                        return;
//                        break;
//                }
//					
//                $SQL = "SELECT nome 
//                        FROM $tabela
//                        WHERE id = {$ID} LIMIT 1";
//                $Resultado = pg_query($ConexaoLink, $SQL);
//                if ($linha = pg_fetch_array($Resultado)){
//                    $this->NomeAreaPesquisa = $this->NomeAreaPesquisa . $linha[0];
//                }
//            }
//            else{
//                switch ($Area){
//                    case 'RE':
//                        $tabela = "regiao";
//                        $this->NomeAreaPesquisa = 'Todos os Estados da regi�o ';
//                        break;
//                    case 'AL':
//                        $this->NomeAreaPesquisa = "Todos os Estados do Brasil";
//                        return;
//                        break;
//                }
//                $SQL = "SELECT nome 
//                        FROM $tabela
//                        WHERE id = {$ID} LIMIT 1";
//                $Resultado = pg_query($ConexaoLink, $SQL);
//                if ($linha = pg_fetch_array($Resultado)){
//                    $this->NomeAreaPesquisa = $this->NomeAreaPesquisa . $linha[0];
//                }
//            }
//    }
//
//        //============================================================//
//        //Densenha a tablea
//        //============================================================//
//
//        //============================================================//
//        //Gera o sql da consulta do estado
//        //============================================================//
//        /*public function GerarSQLQuantidadeBarrasEstado($Local,$Valor = 0)
//        {
//            switch ($Local)
//            {
//                case 'RE':
//                    $SQL = "SELECT valor FROM valor_variavel_estado
//                            INNER JOIN estado ON (estado.id = valor_variavel_estado.fk_estado) and (estado.fk_regiao = $Valor)
//                            WHERE 
//                                    fk_variavel = ".$this->IDVariavel." AND
//                                    fk_ano_referencia = ".$this->IDAno;
//                break;
//                case 'AL':
//                    $SQL = "SELECT valor FROM valor_variavel_estado
//                            INNER JOIN estado ON (estado.id = valor_variavel_estado.fk_estado)
//                            WHERE 
//                                    fk_variavel = ".$this->IDVariavel." AND
//                                    fk_ano_referencia = ".$this->IDAno;
//                break;
//            }
//            $this->SQLValorVariaveis = $SQL;
//        }*/
//        
//    //============================================================//
//    //Pega o nome curto da vari�vel da pesquisa
//    //$ConexaoLink: Recebe a vari�vel de conex�o ao banco de dados
//    //============================================================//
//    public function fNomeVariavel($con){
//       // echo 'Indicador: '.$this->idIndicador.'<br />';
//        $sql = "SELECT nomelongo 
//                FROM variavel
//                WHERE id = {$this->idIndicador} 
//                LIMIT 1";
//        //echo 'sql: '.$sql.'<br />';
//        $resultado = pg_query($con, $sql);
//        if ($linha = pg_fetch_array($resultado)){
//	$this->nomeVariavel = $linha['nomelongo'];
//	//echo 'Nome Variavel: '.$this->nomeVariavel.'<br />';
//        }
//    }
//    //============================================================//
//    //Busca a Label do ano
//    //$ConexaoLink: Recebe a vari�vel de conex�o ao banco de dados
//    //============================================================//
//    public function fLabelAno($ConexaoLink){
//        $SQL = "SELECT label_ano_referencia 
//                FROM ano_referencia
//                WHERE id = {$this->IDAno} 
//                LIMIT 1";
//        $Resultado = pg_query($ConexaoLink, $SQL);
//        if ($linha = pg_fetch_array($Resultado))
//            $this->LabelAno = $linha[0];
//    }
//
//        
//        
//        //============================================================//
//        //da print nas op��es 
//        //============================================================//
//        /*public function PritOptions($Sufixo)
//        {
//            $Title = "{$this->NomeVariavel} ({$this->LabelAno}) - {$this->NomeAreaPesquisa}";
//            is_null($ElementoDestinoDoDesenho) ? $NomeElemento = "chart_div" : $NomeElemento = $ElementoDestinoDoDesenho;
//            
//            $TempArray = $this->ArrayConsulta;
//            $PontoMedio = $this->Xmin;
//            $InicialBarra = $this->Xmin;
//            //die(var_dump($TempArray));
//            for($i = 0; $i < $this->QuantidadeClasse;$i++)
//            {
//                $PontoMedio += $this->AmplitudeDaClasse / 2;
//                $PrintMedia[] = number_format($PontoMedio,2,",","");
//                $PontoMedio += $this->AmplitudeDaClasse / 2;
//                $Contador = 0;
//                foreach($TempArray as $key=>$val)
//                {
//                    if($TempArray[$key] >= $InicialBarra  && $TempArray[$key] < $PontoMedio)
//                    {
//                        $Contador++;
//                    }
//                    if($TempArray[$key] > $PontoMedio)
//                        break;
//                }
//                $PrintCidadesa[] = $Contador;
//                $InicialBarra += $this->AmplitudeDaClasse;
//            }
//            $diff = $this->Quantidade - array_sum($PrintCidadesa);
//            $PrintCidadesa[count($PrintCidadesa)-1]+=$diff;
//            if(empty($PrintCidadesa))
//            {
//                echo "<br><br><p id='relatorio_caption'>Nenhum registro foi encontrado para esta consulta.</p>";
//                return;
//            }
//            $Retorno .= "var data$Sufixo = google.visualization.arrayToDataTable([";
//                $Retorno .= "\r\n";
//            $Retorno .= "['Amplitude', '{$this->NomeVariavel}']";
//                $Retorno .= "\r\n";
//            foreach($PrintMedia as $key=>$val)
//            {
//                $Retorno .= ",['{$PrintMedia[$key]}', {$PrintCidadesa[$key]}]";
//                $Retorno .= "\r\n";
//            }
//            $Retorno .= "]);var options$Sufixo = {";
//                $Retorno .= "\r\n";
//            $Retorno .= "    title: '$Title',";
//                $Retorno .= "\r\n";
//            $Retorno .= "    hAxis: {title: 'Histograma', titleTextStyle: {color: 'black'},minTextSpacing : 70}, legend:{position: 'none'},bar : {groupWidth:'70%'},
//                chartArea : {width:900}
//                
//    ";
//                $Retorno .= "\r\n";
//            $Retorno .= "  };
//                var chart = new google.visualization.ColumnChart(document.getElementById('char1'));
//               chart.draw(data$Sufixo, options$Sufixo);";
//            echo $Retorno;
//        }*/
//        
//    }
?>
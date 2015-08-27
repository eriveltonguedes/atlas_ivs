<?php

/**
 * Construção do Componente por Tipo e Idioma
 *
 * @author Andre Castro
 */
class ITComparacao extends IT {

    //Unidade de Desenvolvimento Humano
    //PT
    protected $textoUdhPT = "Enquanto o IDHM da UDH é [idhm10], em 2010, o do município e o da RM
        onde ela está situada é, respectivamente, [idhm10_mun_udh] e [idhm10_rm_udh].
        Nesse mesmo ano, o hiato de desenvolvimento humano, ou seja, a distância entre o IDHM da UDH e
        o limite máximo do índice, que é 1, é de [hiato10].
            ";
    
    //EN
    protected $textoUdhEN = "[EN]Enquanto o IDHM da UDH é <IDHM 2010>, em 2010, o do município e o da RM
        onde ela está situada é, respectivamente, <IDHM 2010> e <IDHM 2010>.
        Nesse mesmo ano, o hiato de desenvolvimento humano, ou seja, a distância entre o IDHM da UDH e
        o limite máximo do índice, que é 1, é de <(1-IDHM 2010)>.
            ";
    //ES
    protected $textoUdhES = "[ES]Los años de estudio esperados indican el número de años que el niño que comienza la vida escolar en el año de referencia tiende a completar.
        En 2010, [municipio] tenía [e_anosestudo10] años de estudio esperados, mientras que en el 2000 tenía 
        [e_anosestudo00] años y en 1991, [e_anosestudo91] años. 
        En tanto, [estado_municipio] tenía [ufe_anosestudo10] años de estudio esperados en 2010,
        [ufe_anosestudo00] años en el 2000 y [ufe_anosestudo91] años en 1991.
            ";
    //Padrão
    protected $subtituloPT = "Comparação";
    protected $subtituloEN = "[EN] Comparação";
    protected $subtituloES = "[ES] Comparação";
    
    function getChartComparacao($nomeUDH, $idhm_udh10, $nome_mun_udh, $minValueMun, $maxValueMun, $nome_rm_udh, $minValueRM, $maxValueRM ) {

//        $renda = json_encode($this->chart->getIDHDesenvolvimentoHumano($idMunicipio, "IDHM_R"));
//        $educacao = json_encode($this->chart->getIDHDesenvolvimentoHumano($idMunicipio, "IDHM_E"));
//        $longevidade = json_encode($this->chart->getIDHDesenvolvimentoHumano($idMunicipio, "IDHM_L"));
//        $idhm = $this->chart->getIDHDesenvolvimentoHumano($idMunicipio, "IDHM");
//        
//        
//                graficoDesenvolvimentoHumanoIDHM('" . $this->lang . "','" . $this->type . "');
        
//        echo "<br>idhm_mun91 - " . $idhm_mun91 . "<br>";
//        echo "idhm_mun10 - " . $idhm_mun10 . "<br>";
//        echo "idhm_rm91 - " . $idhm_rm00 . "<br>";
//        echo "idhm_rm10 - " . $idhm_rm10 . "<br>";
//        die();
        
        echo "<script language='javascript' type='text/javascript'>

                      var data = { 
                        idhValue: $idhm_udh10,
                        minValueRM: $minValueRM,
                        maxValueRM: $maxValueRM,
                        minValueMun:  $minValueMun,
                        maxValueMun:  $maxValueMun,
                        nomeMun: '$nome_mun_udh',
                        nomeRM: '$nome_rm_udh',
                        nomeUDH: '$nomeUDH',
                    };
                    // Seta configurações (atenção para os nomes dos atributos)

                    var options = {
                      stringRM: 'RM',
                      stringUDH: 'UDH',
                      stringMun: 'Município',
                      stringIDHM: 'IDHM',
                    };

                     var chart = new PnudChart(document.getElementById('chartDiv'));
                     chart.draw(data,options);
                </script>";
        
//        echo "<script language='javascript' type='text/javascript'>
//
//                      var data = { 
//                        idhValue: 0.957,
//                        minValueRM: 0.616,
//                        maxValueRM: 0.957,
//                        minValueMun:  0.616,
//                        maxValueMun:  0.957,
//                        nomeMun: 'Brasília',
//                  nomeRM: 'RIDE - DF e Entorno',
//                  nomeUDH: 'Brasília : Asa Norte',
//                    };
//                    // Seta configurações (atenção para os nomes dos atributos)
//
//                    var options = {
//                      stringRM: 'RM',
//                      stringUDH: 'UDH',
//                      stringMun: 'Município',
//                      stringIDHM: 'IDHM',
//                    };
//
//                     var chart = new PnudChart(document.getElementById('chartDiv'));
//                     chart.draw(data,options);
//                </script>";

        return "<div id='chartDiv' width='800' height='300' align='center'></div>";
        
//        return "<div style='width: 100%; height: 300px;'>
//                    <div id='chartDesenvolvimentoHumanoIDHM' style='float:left; width: 700px; height: 300px;'>            
//                        <input id='renda' type='hidden' value=' " . $renda . "' /> 
//                        <input id='educacao' type='hidden' value='" . $educacao . "' />
//                        <input id='longevidade' type='hidden' value='" . $longevidade . "' /> 
//
//                    </div>
//                    <div id='idhm' style='float: left; width: 100px; height: 245px;' >
//                            <table border='0' style='height: 245px; font-size: 19pt;' >
//                            <tr>
//                              <td style='height: 50px; text-align:center; font-size:12pt;'>IDHM</td>  
//                            </tr>
//                            <tr>
//                              <td style='height: 50px;'><b>" . number_format($idhm[0]["valor"], 3, ',', '.') . "</b></td>  
//                            </tr>
//                            <tr>
//                              <td style='height: 50px;'><b>" . number_format($idhm[1]["valor"], 3, ',', '.') . "</b></td>
//                            </tr>
//                            <tr>
//                              <td style='height: 50px;'><b>" . number_format($idhm[2]["valor"], 3, ',', '.') . "</b></td>
//                            </tr>
//                            </table>
//                    </div>
//                </div>";
    
        
        
    }

}



?>

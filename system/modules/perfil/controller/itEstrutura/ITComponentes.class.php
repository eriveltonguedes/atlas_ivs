<?php

/**
 * Construção do Componente por Tipo e Idioma
 *
 * @author Andre Castro
 */
class ITComponentes extends IT {

    //Municipio
    //PT
    protected $textoMunPT = "O Índice de Desenvolvimento Humano (IDHM) - [municipio] é [idh], em [2010],
            o que situa esse município na faixa de Desenvolvimento Humano [Faixa_DH].      
            A dimensão que mais contribui para o IDHM do município é [Dimensao2010].
            ";
    //EN
    protected $textoMunEN = "The Municipal Human Development Index (MHDI) of [municipio] is [idh] in [2010].
            The municipality is located in category [Faixa_DH] Human Development.            
            Between 2000 and 2010, the dimension that grew the most in absolute terms was [Dimensao2000a2010].                        
            Between 1991 and 2000, the dimension that grew the most in absolute terms was [Dimensao1991a2000].
            ";
    //ES
    protected $textoMunES = "El Índice de Desarrollo Humano Municipal (IDHM) de [municipio] es de [idh] para [2010].
            El municipio tiene un nivel de desarrollo humano [Faixa_DH].            
            Entre el 2000 y 2010, el factor que más se incrementó en términos absolutos fue [Dimensao2000a2010].                        
            Entre 1991 y el 2000, el factor que más se incrementó en términos absolutos fue [Dimensao1991a2000].
            ";
    //Região Metropolitana
    //PT
    protected $textoRmPT = "O Índice de Desenvolvimento Humano (IDHM) - [municipio] é [idh], em [2010],
            o que situa essa Região Metropolitana (RM) na faixa de Desenvolvimento Humano [Faixa_DH].      
            A dimensão que mais contribui para o IDHM da RM é [Dimensao2010].
            ";
    //EN
    protected $textoRmEN = "The Human Development Index (HDI) of [municipio] is [idh] in [2010].
            The region is located in category [Faixa_DH] Human Development.            
            Between 2000 and 2010, the dimension that grew the most in absolute terms was [Dimensao2000a2010].                        
            Between 1991 and 2000, the dimension that grew the most in absolute terms was [Dimensao1991a2000].
            ";
    //ES
    protected $textoRmES = "El Índice de Desarrollo Humano (IDHM) de [municipio] es de [idh] para [2010].
            El regiao tiene un nivel de desarrollo humano [Faixa_DH].            
            Entre el 2000 y 2010, el factor que más se incrementó en términos absolutos fue [Dimensao2000a2010].                        
            Entre 1991 y el 2000, el factor que más se incrementó en términos absolutos fue [Dimensao1991a2000].
            ";
    //Estado
    //PT //@#Changed
    protected $textoUfPT = "O Índice de Desenvolvimento Humano (IDHM) - [municipio] é [idh], em [2010],
            o que situa essa Unidade Federativa (UF) na faixa de Desenvolvimento Humano [Faixa_DH].      
            A dimensão que mais contribui para o IDHM da UF é [Dimensao2010].
            ";
    //EN
    protected $textoUfEN = "The Human Development Index (HDI) of [municipio] is [idh] in [2010].
            The state is located in category [Faixa_DH] Human Development.            
            Between 2000 and 2010, the dimension that grew the most in absolute terms was [Dimensao2000a2010].                        
            Between 1991 and 2000, the dimension that grew the most in absolute terms was [Dimensao1991a2000].
            ";
    //ES
    protected $textoUfES = "El Índice de Desarrollo Humano (IDHM) de [municipio] es de [idh] para [2010].
            El estado tiene un nivel de desarrollo humano [Faixa_DH].            
            Entre el 2000 y 2010, el factor que más se incrementó en términos absolutos fue [Dimensao2000a2010].                        
            Entre 1991 y el 2000, el factor que más se incrementó en términos absolutos fue [Dimensao1991a2000].
            ";
    //Unidade de Desenvolvimento Humano
    //PT
    protected $textoUdhPT = "O Índice de Desenvolvimento Humano Municipal (IDHM) da Unidade
            de Desenvolvimento Humano (UDH) em questão, localizada no município de [municipio_udh] da RM de [rm],
            é [idh], em 2010. Esse valor situa a UDH na faixa de Desenvolvimento Humano [Faixa_DH].
            A dimensão que mais contribui para o valor do IDHM da UDH é [Dimensao2010].
                ";
    //EN
    protected $textoUdhEN = "The Human Development Index (HDI) of [municipio] is [idh] in [2010].
            The Unit of Human Development (UHD) is located in category [Faixa_DH] Human Development.            
            Between 2000 and 2010, the dimension that grew the most in absolute terms was [Dimensao2000a2010].                        
            Between 1991 and 2000, the dimension that grew the most in absolute terms was [Dimensao1991a2000].
            ";
    //ES
    protected $textoUdhES = "El Índice de Desarrollo Humano (IDHM) de [municipio] es de [idh] para [2010].
            El Unidad de Desarrollo Humano tiene un nivel de desarrollo humano [Faixa_DH].            
            Entre el 2000 y 2010, el factor que más se incrementó en términos absolutos fue [Dimensao2000a2010].                        
            Entre 1991 y el 2000, el factor que más se incrementó en términos absolutos fue [Dimensao1991a2000].
            ";
    //RM
    //PT
    protected $textoShowRmPT = "A RM de [esp] é constituída por [esp_count] municípios, sendo eles: [municipios]
                de acordo com a configuração territorial de 01 de agosto de 2012.
            ";
    protected $textoShowRmEN = "A RM de [esp] é constituída por [esp_count] municípios, sendo eles: [municipios]
                de acordo com a configuração territorial de 01 de agosto de 2012.
            ";
    protected $textoShowRmES = "A RM de [esp] é constituída por [esp_count] municípios, sendo eles: [municipios]
                de acordo com a configuração territorial de 01 de agosto de 2012.
            ";
    protected $textoShowUdhPT = "A UDH em questão faz parte da RM de [nome_rm], que é constituída por [esp_count] municípios,
                sendo eles: [municipios] de acordo com a configuração territorial de 01 de agosto de 2012.
            ";
    protected $textoShowUdhEN = "A UDH em questão faz parte da RM de [nome_rm], que é constituída por [esp_count] municípios,
                sendo eles: [municipios] de acordo com a configuração territorial de 01 de agosto de 2012.
            ";
    protected $textoShowUdhES = "A UDH em questão faz parte da RM de [nome_rm], que é constituída por [esp_count] municípios,
                sendo eles: [municipios] de acordo com a configuração territorial de 01 de agosto de 2012.
            ";
    //Padrão
    protected $tituloPT = "IDHM";
    protected $subtituloPT = "Componentes";
    protected $tituloEN = "MHDI";
    protected $subtituloEN = "Components";
    protected $tituloES = "IDHM";
    protected $subtituloES = "Componentes";
    //Tabela
    protected $tituloTablePT = "IDHM e componentes";
    protected $captionPT = "Índice de Desenvolvimento Humano Municipal e seus componentes";
    protected $tituloTableEN = "MHDI and components";
    protected $captionEN = "Municipal Human Development Index (MHDI)";
    protected $tituloTableES = "IDHM y componentes";
    protected $captionES = "Índice de Desarrollo Humano Municipal y sus componentes";

    function getChartDesenvolvimentoHumano($idMunicipio) {

        $renda = json_encode($this->chart->getIDHDesenvolvimentoHumano($idMunicipio, "IDHM_R"));
        $educacao = json_encode($this->chart->getIDHDesenvolvimentoHumano($idMunicipio, "IDHM_E"));
        $longevidade = json_encode($this->chart->getIDHDesenvolvimentoHumano($idMunicipio, "IDHM_L"));
        $idhm = $this->chart->getIDHDesenvolvimentoHumano($idMunicipio, "IDHM");

        echo "<script language='javascript' type='text/javascript'>
                graficoDesenvolvimentoHumanoIDHM('" . $this->lang . "','" . $this->type . "');</script>";

        $html = "<div style='width: 100%; height: 300px;'>
                    <div id='chartDesenvolvimentoHumanoIDHM' style='float:left; width: 700px; height: 300px;'>            
                        <input id='renda' type='hidden' value=' " . $renda . "' /> 
                        <input id='educacao' type='hidden' value='" . $educacao . "' />
                        <input id='longevidade' type='hidden' value='" . $longevidade . "' /> 

                    </div>
                    <div id='idhm' style='float: left; width: 100px; height: 245px;' >
                            <table border='0' style='height: 245px; font-size: 19pt;' >
                            <tr>
                              <td style='height: 50px; text-align:center; font-size:12pt;'>IDHM</td>  
                            </tr>";

        if ($this->type !== "perfil_rm" && $this->type !== "perfil_udh") {
            $html .= "<tr>
                        <td style='height: 50px;'><b>" . number_format($idhm[0]["valor"], 3, ',', '.') . "</b></td>  
                      </tr>
                      <tr>
                        <td style='height: 50px;'><b>" . number_format($idhm[1]["valor"], 3, ',', '.') . "</b></td>
                      </tr>
                      <tr>
                        <td style='height: 50px;'><b>" . number_format($idhm[2]["valor"], 3, ',', '.') . "</b></td>
                      </tr>";
        } else {
            $html .= "
                    <tr>
                      <td style='height: 50px;'><b>" . number_format($idhm[1]["valor"], 3, ',', '.') . "</b></td>
                    </tr>
                    <tr>
                      <td style='height: 50px;'><b>" . number_format($idhm[2]["valor"], 3, ',', '.') . "</b></td>
                    </tr>";
        }


        $html .= "</table>
                    </div>
                </div>";

        return $html;
    }

}

?>

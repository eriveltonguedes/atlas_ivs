<?php

/**
 * Construção da Estrutura Etária por Tipo e Idioma
 *
 * @author Andre Castro
 */
class ITEstruturaEtaria extends IT {

    //Municipio
    //PT
    protected $textoMunPT = "
            Entre 2000 e 2010, a razão de dependência no município passou de [rz_dependencia00]% para
            [rz_dependencia10]% e a taxa de envelhecimento, de [indice_envelhecimento00]% para [indice_envelhecimento10]%.
            Em 1991, esses dois indicadores eram, respectivamente, [rz_dependencia91]% e [indice_envelhecimento91]%.
            Já na UF, a razão de dependência passou de [rz_dependencia91_br]% em 1991, para [rz_dependencia00_br]%
            em 2000 e [rz_dependencia10_br]% em 2010; enquanto a taxa de envelhecimento passou de [indice_envelhecimento91_br]%,
            para [indice_envelhecimento00_br]% e para [indice_envelhecimento10_br]%, respectivamente.";
    //EN
    protected $textoMunEN = "Between 2000 and 2010, the dependency ratio of [municipio] went from [rz_dependencia00]%
            to [rz_dependencia10]% and the aging index increased from [indice_envelhecimento00]% to
            [indice_envelhecimento10]%.
            Between 1991 and 2000, the dependency ratio went from [rz_dependencia91]% to [rz_dependencia00]%,
            while the aging index increased from [indice_envelhecimento91]% to [indice_envelhecimento00]%.";
    //ES
    protected $textoMunES = "Entre el 2000 y 2010, la razón de dependencia de [municipio] pasó de un [rz_dependencia00]%
            a un [rz_dependencia10]% y la tasa de envejecimiento pasó de un [indice_envelhecimento00]% a un [indice_envelhecimento10]%.
            Entre 1991 y el 2000, la razón de dependencia pasó de un [rz_dependencia91]% a un [rz_dependencia00]%,
            mientras que la tasa de envejecimiento pasó de un [indice_envelhecimento91]% a un [indice_envelhecimento00]%.";
    //Região Metropolitana
    //PT
    protected $textoRmPT = "
            Entre 2000 e 2010, a razão de dependência na RM passou de [rz_dependencia00]% para
            [rz_dependencia10]% e a taxa de envelhecimento, de [indice_envelhecimento00]% para [indice_envelhecimento10]%.
            
            Já no Brasil, a razão de dependência passou de [rz_dependencia91_br]% em 1991, para [rz_dependencia00_br]%
            em 2000 e [rz_dependencia10_br]% em 2010; enquanto a taxa de envelhecimento passou de [indice_envelhecimento91_br]%,
            para [indice_envelhecimento00_br]% e para [indice_envelhecimento10_br]%, respectivamente.";
    //EN
    protected $textoRmEN = "Between 2000 and 2010, the dependency ratio of [municipio] went from [rz_dependencia00]%
            to [rz_dependencia10]% and the aging index increased from [indice_envelhecimento00]% to
            [indice_envelhecimento10]%.
            Between 1991 and 2000, the dependency ratio went from [rz_dependencia91]% to [rz_dependencia00]%,
            while the aging index increased from [indice_envelhecimento91]% to [indice_envelhecimento00]%.";
    //ES
    protected $textoRmES = "Entre el 2000 y 2010, la razón de dependencia de [municipio] pasó de un [rz_dependencia00]%
            a un [rz_dependencia10]% y la tasa de envejecimiento pasó de un [indice_envelhecimento00]% a un [indice_envelhecimento10]%.
            Entre 1991 y el 2000, la razón de dependencia pasó de un [rz_dependencia91]% a un [rz_dependencia00]%,
            mientras que la tasa de envejecimiento pasó de un [indice_envelhecimento91]% a un [indice_envelhecimento00]%.";
    //Estado
    //PT
    protected $textoUfPT = "
            Entre 2000 e 2010, a razão de dependência na UF passou de [rz_dependencia00]% para
            [rz_dependencia10]% e a taxa de envelhecimento, de [indice_envelhecimento00]% para [indice_envelhecimento10]%.
            Em 1991, esses dois indicadores eram, respectivamente, [rz_dependencia91]% e [indice_envelhecimento91]%.
            Já no Brasil, a razão de dependência passou de [rz_dependencia91_br]% em 1991, para [rz_dependencia00_br]%
            em 2000 e [rz_dependencia10_br]% em 2010; enquanto a taxa de envelhecimento passou de [indice_envelhecimento91_br]%,
            para [indice_envelhecimento00_br]% e para [indice_envelhecimento10_br]%, respectivamente.";

//            Entre 2000 e 2010, a razão de dependência de [municipio] passou de [rz_dependencia00]%
//            para [rz_dependencia10]% e a taxa de envelhecimento evoluiu de [indice_envelhecimento00]% para [indice_envelhecimento10]%.
//            Entre 1991 e 2000, a razão de dependência foi de [rz_dependencia91]% para [rz_dependencia00]%,
//            enquanto a taxa de envelhecimento evoluiu de [indice_envelhecimento91]% para [indice_envelhecimento00]%.";
    //EN
    protected $textoUfEN = "Between 2000 and 2010, the dependency ratio of [municipio] went from [rz_dependencia00]%
            to [rz_dependencia10]% and the aging index increased from [indice_envelhecimento00]% to
            [indice_envelhecimento10]%.
            Between 1991 and 2000, the dependency ratio went from [rz_dependencia91]% to [rz_dependencia00]%,
            while the aging index increased from [indice_envelhecimento91]% to [indice_envelhecimento00]%.";
    //ES
    protected $textoUfES = "Entre el 2000 y 2010, la razón de dependencia de [municipio] pasó de un [rz_dependencia00]%
            a un [rz_dependencia10]% y la tasa de envejecimiento pasó de un [indice_envelhecimento00]% a un [indice_envelhecimento10]%.
            Entre 1991 y el 2000, la razón de dependencia pasó de un [rz_dependencia91]% a un [rz_dependencia00]%,
            mientras que la tasa de envejecimiento pasó de un [indice_envelhecimento91]% a un [indice_envelhecimento00]%.";
    //Unidade de Desenvolvimento Humano
    //PT
    protected $textoUdhPT = "Em 2010, a razão de dependência na UDH é de [rz_dependencia10]% e a taxa de envelhecimento, de
             [indice_envelhecimento10]%. Já o município apresenta razão de dependência de [rz_dependencia10_mun_udh]% em 2010, e a
             taxa de envelhecimento de [indice_envelhecimento10_mun_udh]%, no mesmo ano. Na RM, os valores respectivos são [rz_dependencia10_rm_udh]% 
             e [indice_envelhecimento10_rm_udh]%.";
    //EN
    protected $textoUdhEN = "Between 2000 and 2010, the dependency ratio of [municipio] went from [rz_dependencia00]%
            to [rz_dependencia10]% and the aging index increased from [indice_envelhecimento00]% to
            [indice_envelhecimento10]%.
            Between 1991 and 2000, the dependency ratio went from [rz_dependencia91]% to [rz_dependencia00]%,
            while the aging index increased from [indice_envelhecimento91]% to [indice_envelhecimento00]%.";
    //ES
    protected $textoUdhES = "Entre el 2000 y 2010, la razón de dependencia de [municipio] pasó de un [rz_dependencia00]%
            a un [rz_dependencia10]% y la tasa de envejecimiento pasó de un [indice_envelhecimento00]% a un [indice_envelhecimento10]%.
            Entre 1991 y el 2000, la razón de dependencia pasó de un [rz_dependencia91]% a un [rz_dependencia00]%,
            mientras que la tasa de envejecimiento pasó de un [indice_envelhecimento91]% a un [indice_envelhecimento00]%.";
    //Padrão
    protected $subtituloPT = "Estrutura Etária";
    protected $subtituloEN = "Age structure";
    protected $subtituloES = "Estructura de edad";
    //Blocos de Texto
    protected $rDependenciaPT = "<b>O que é razão de<br>
                                dependência?</b><br>
                                Percentual da população <br>
                                de menos de 15 anos e <br>
                                da população de 65 anos <br>
                                e mais (população <br>
                                dependente) em relação <br>
                                à população de 15 <br>
                                a 64 anos (população <br>
                                potencialmente ativa).";
    protected $rDependenciaEN = "<b>What is the dependency<br>
                                ratio?</b><br>
                                Percentage of the population <br>
                                aged less than 15 years <br>
                                and population aged 65 years <br>
                                and older (population <br>
                                dependent) compared to <br>
                                the population aged 15-64 <br>
                                years (potentially active <br>
                                population).";
    protected $rDependenciaES = "<b>¿Qué es la razón de<br> 
                                dependencia?</b><br>
                                Es el porcentaje de la <br>
                                población menor de 15 <br>
                                años y de al menos 65 <br>
                                años (población dependente) <br>
                                con respecto a la población <br>
                                de entre 15 y 64 años<br>
                                (población potencialmente<br>
                                activa).";
    
    protected $tEnvelhecimentoPT = "<b>O que é taxa de<br> envelhecimento?</b><br>
                                    Razão entre a população <br>
                                    de 65 anos ou mais <br>
                                    de idade em relação <br>
                                    à população total.";
    protected $tEnvelhecimentoEN = "<b>What is the<br> aging index?</b><br>
                                    Population aged 65 <br>
                                    years or older compared <br>
                                    to the population aged <br>
                                    less than 15 years.";
    protected $tEnvelhecimentoES = "<b>¿Qué es la tasa de<br> envejecimiento?</b><br>
                                    Es la razón entre la <br>
                                    población de al menos <br>
                                    65 años y la población <br>
                                    total multiplicada.";
    
    //Tabela
    protected $tituloTablePT = "Estrutura Etária";
    protected $captionPT = "Estrutura Etária da População";
    protected $tituloTableEN = "Age structure";
    protected $captionEN = "The age structure";
    protected $tituloTableES = "Estructura de edad";
    protected $captionES = "Estructura de edad de la población";
    
    //Colunas
    protected $coluna1PT = "População";
    protected $coluna2PT = "% do Total";
    protected $coluna1EN = "Population";
    protected $coluna2EN = "% of total";
    protected $coluna1ES = "Población";
    protected $coluna2ES = "% del total";
    
    //Variaveis
    protected $stringMenos15anosPT = "Menos de 15 anos";
    protected $stringMenos15anosEN = "Less than 15 years (of age)";
    protected $stringMenos15anosES = "Menos de 15 años";
    
    protected $string15a64anosPT = "15 a 64 anos";
    protected $string15a64anosEN = "15 to 64 years";
    protected $string15a64anosES = "15 a 64 años";

     public function getColunaTable1() {

        if ($this->lang == "pt")
            return $this->coluna1PT;
        else if ($this->lang == "en")
            return $this->coluna1EN;
        else if ($this->lang == "es")
            return $this->coluna1ES;
    }
    
    public function getColunaTable2() {

        if ($this->lang == "pt")
            return $this->coluna2PT;
        else if ($this->lang == "en")
            return $this->coluna2EN;
        else if ($this->lang == "es")
            return $this->coluna2ES;
    }
    
    public function getRDependencia() {

        if ($this->lang == "pt")
            return $this->rDependenciaPT;
        else if ($this->lang == "en")
            return $this->rDependenciaEN;
        else if ($this->lang == "es")
            return $this->rDependenciaES;
    }
    
    public function getTEnvelhecimento() {

        if ($this->lang == "pt")
            return $this->tEnvelhecimentoPT;
        else if ($this->lang == "en")
            return $this->tEnvelhecimentoEN;
        else if ($this->lang == "es")
            return $this->tEnvelhecimentoES;
    }
    
    public function getMenos15anos() {

        if ($this->lang == "pt")
            return $this->stringMenos15anosPT;
        else if ($this->lang == "en")
            return $this->stringMenos15anosEN;
        else if ($this->lang == "es")
            return $this->stringMenos15anosES;
    }
    
    public function get15a64anos() {

        if ($this->lang == "pt")
            return $this->string15a64anosPT;
        else if ($this->lang == "en")
            return $this->string15a64anosEN;
        else if ($this->lang == "es")
            return $this->string15a64anosES;
    }
    
    function getChartPiramideEtaria1($idMunicipio) {

        //$chart = new FunctionsChart();

        $piram_fem_1991_arr = $this->chart->getPiramideEtariaFeminina($idMunicipio, 1991);
        $piram_fem_1991 = json_encode($piram_fem_1991_arr);
        $piram_masc_1991 = json_encode($this->chart->getPiramideEtariaMasculina($idMunicipio, 1991));
        $piram_total_1991 =  json_encode($this->chart->getPiramideEtariaTotal($idMunicipio, 1991));

        return $this->getChart($piram_fem_1991_arr, $piram_fem_1991, $piram_masc_1991,
                $piram_total_1991, "1991");
       
    }
    
    function getChartPiramideEtaria2($idMunicipio) {

        //$chart = new FunctionsChart();
        
        $piram_fem_2000_arr= $this->chart->getPiramideEtariaFeminina($idMunicipio, 2000);
        $piram_fem_2000 = json_encode($piram_fem_2000_arr);
        $piram_masc_2000 = json_encode($this->chart->getPiramideEtariaMasculina($idMunicipio, 2000));
        $piram_total_2000 =  json_encode($this->chart->getPiramideEtariaTotal($idMunicipio, 2000));
    
        return $this->getChart($piram_fem_2000_arr, $piram_fem_2000, $piram_masc_2000,
                $piram_total_2000, "2000");        
        
    }
    
    function getChartPiramideEtaria3($idMunicipio) {

        //$chart = new FunctionsChart();

        $piram_fem_2010_arr= $this->chart->getPiramideEtariaFeminina($idMunicipio, 2010);
        $piram_fem_2010 = json_encode($piram_fem_2010_arr);
        $piram_masc_2010 = json_encode($this->chart->getPiramideEtariaMasculina($idMunicipio, 2010));
        $piram_total_2010 =  json_encode($this->chart->getPiramideEtariaTotal($idMunicipio, 2010));
        
        return $this->getChart($piram_fem_2010_arr, $piram_fem_2010, $piram_masc_2010,
                $piram_total_2010, "2010");
    }
    
    public function getChart($piram_fem_arr, $piram_fem, $piram_masc, $piram_total, $ano){
        
        if ($this->lang == "pt"){
            $piramideLabel = "Pirâmide etária";
            $piramideDescricao = "Distribuição por  Sexo, segundo os grupos de idade";
        }else if ($this->lang == "en"){
            $piramideLabel = "Age pyramid";
            $piramideDescricao = "Distributed by gender, according to age groups";
        }else if ($this->lang == "es"){
            $piramideLabel = "Pirámide demográfica";
            $piramideDescricao = "Distribución por sexo según los grupos de edad";
        }     
        
        if ($this->type !== "perfil_rm" && $this->type !== "perfil_uf")
            $tituloUf = " - ". $piram_fem_arr[0]["uf"];
        else
            $tituloUf = "";

            echo "<script language='javascript' type='text/javascript'>
                graficoFaixaEtaria('" . $this->lang . "','" . $this->type . "','" . $ano . "');</script>";

            return "<div id='chart_piramide_".$ano."' style='width: 100%; '>
                    <div id='titulo' style='height: 400px; margin-top: 30px;' >
                        <div  style='width: 450px; margin: 0 auto;'>
                            <div style='float: left; height: 40px; width: 75px; font-weight:bold; font-size: 20pt; margin-top: 11px; '>".$ano."</div>
                                <div  style=' color: #FF66CC; font-size: 13pt; '>
                                        <b>" . $piramideLabel." - ". $piram_fem_arr[0]["nome"] . $tituloUf . "</b>
                                        <div style=' color: #FF66CC; font-size: 11pt; '>".$piramideDescricao."</div>
                                </div>
                        </div>
                        <div id='chart_piram_".$ano."' style='width: 800px;  float:left; ' >
                            <input id='piram_fem' type='hidden' value=' " . $piram_fem . "' /> 
                            <input id='piram_masc' type='hidden' value='" . $piram_masc . "' />
                            <input id='piram_total' type='hidden' value='" . $piram_total . "' />
                        </div>      
                   </div>
             </div>";    
    }
            
   
    
}

?>

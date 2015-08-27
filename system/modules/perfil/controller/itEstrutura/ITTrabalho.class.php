<?php

/**
 * Construção do Componente por Tipo e Idioma
 *
 * @author Andre Castro
 */
class ITTrabalho extends IT {

    //Municipio
    //PT
    protected $textoMunPT = "Entre 2000 e 2010, a <b>taxa de atividade</b> da população de 18 anos ou mais
            (ou seja, o percentual dessa população que era economicamente ativa)
            passou de [tx_ativ_18m_00]% em 2000 para [tx_ativ_18m_10]% em 2010.
            Ao mesmo tempo, sua <b>taxa de desocupação</b> (ou seja, o percentual da população economicamente ativa
            que estava desocupada) passou de [tx_des18m_00]% em 2000 para [tx_des18m_10]% em 2010.
            ";
    //EN
    protected $textoMunEN = "Between 2000 and 2010, the <b>activity rate</b> of the population aged 18 years or older (that is, the percentage of 
            the economically-active population) increased from [tx_ativ_18m_00]% in 2000 to [tx_ativ_18m_10]% in 2010.
            At the same time, the <b>unemployment rate</b> (that is, the percentage of the economically-active,
            but unemployed, population) increased from [tx_des18m_00]% in 2000 to [tx_des18m_10]% in 2010.
            ";
    //ES
    protected $textoMunES = "Entre el 2000 y 2010, la <b>tasa de actividad</b> de la población de 18 años o más (es decir, el porcentaje de esa población que era económicamente activa) paso de un 
            [tx_ativ_18m_00]% en el 2000 a un [tx_ativ_18m_10]% en 2010. Asimismo, su <b>tasa de desempleo</b> (es decir, el porcentaje de la población económicamente activa que estaba desocupada) pasó de un 
            [tx_des18m_00]% en el 2000 a un [tx_des18m_10]% en 2010.
            ";
    //Região Metropolitana
    //PT
    protected $textoRmPT = "
            Entre 2000 e 2010, a <b>taxa de atividade</b> da população de 18 anos ou mais (ou seja,
            o percentual dessa população que era economicamente ativa) da RM passou de 
            [tx_ativ_18m_00]% para [tx_ativ_18m_10]%. Ao mesmo tempo, a <b>taxa de desocupação</b> nessa
            faixa etária (ou seja, o percentual da população economicamente ativa que estava desocupada)
            passou de [tx_des18m_00]% para [tx_des18m_10]%.";
    //EN
    protected $textoRmEN = "Between 2000 and 2010, the <b>activity rate</b> of the population aged 18 years or older (that is, the percentage of 
            the economically-active population) increased from [tx_ativ_18m_00]% in 2000 to [tx_ativ_18m_10]% in 2010.
            At the same time, the <b>unemployment rate</b> (that is, the percentage of the economically-active,
            but unemployed, population) increased from [tx_des18m_00]% in 2000 to [tx_des18m_10]% in 2010.
            ";
    //ES
    protected $textoRmES = "Entre el 2000 y 2010, la <b>tasa de actividad</b> de la población de 18 años o más (es decir, el porcentaje de esa población que era económicamente activa) paso de un 
            [tx_ativ_18m_00]% en el 2000 a un [tx_ativ_18m_10]% en 2010. Asimismo, su <b>tasa de desempleo</b> (es decir, el porcentaje de la población económicamente activa que estaba desocupada) pasó de un 
            [tx_des18m_00]% en el 2000 a un [tx_des18m_10]% en 2010.
            ";
    //Estado
    //PT
    protected $textoUfPT = "
            Entre 2000 e 2010, a <b>taxa de atividade</b> da população de 18 anos ou mais (ou seja,
            o percentual dessa população que era economicamente ativa) da UF passou de 
            [tx_ativ_18m_00]% para [tx_ativ_18m_10]%. Ao mesmo tempo, a <b>taxa de desocupação</b> nessa
            faixa etária (ou seja, o percentual da população economicamente ativa que estava desocupada)
            passou de [tx_des18m_00]% para [tx_des18m_10]%.";

//Entre 2000 e 2010, a <b>taxa de atividade</b> da população de 18 anos ou mais
//            (ou seja, o percentual dessa população que era economicamente ativa)
//            passou de [tx_ativ_18m_00]% em 2000 para [tx_ativ_18m_10]% em 2010.
//            Ao mesmo tempo, a <b>taxa de desocupação</b> (ou seja, o percentual da população economicamente ativa
//            que estava desocupada) passou de [tx_des18m_00]% em 2000 para [tx_des18m_10]% em 2010.
//            ";
    //EN
    protected $textoUfEN = "Between 2000 and 2010, the <b>activity rate</b> of the population aged 18 years or older (that is, the percentage of 
            the economically-active population) increased from [tx_ativ_18m_00]% in 2000 to [tx_ativ_18m_10]% in 2010.
            At the same time, the <b>unemployment rate</b> (that is, the percentage of the economically-active,
            but unemployed, population) increased from [tx_des18m_00]% in 2000 to [tx_des18m_10]% in 2010.
            ";
    //ES
    protected $textoUfES = "Entre el 2000 y 2010, la <b>tasa de actividad</b> de la población de 18 años o más (es decir, el porcentaje de esa población que era económicamente activa) paso de un 
            [tx_ativ_18m_00]% en el 2000 a un [tx_ativ_18m_10]% en 2010. Asimismo, su <b>tasa de desempleo</b> (es decir, el porcentaje de la población económicamente activa que estaba desocupada) pasó de un 
            [tx_des18m_00]% en el 2000 a un [tx_des18m_10]% en 2010.
            ";
    //Unidade de Desenvolvimento Humano
    //PT
    protected $textoUdhPT = "Em 2010, a taxa de atividade da população de 18 anos ou mais 
            (ou seja, o percentual dessa população que é economicamente ativa) é de [tx_ativ_18m_10]% na UDH. Ao mesmo
            tempo, a taxa de desocupação na UDH (ou seja, o percentual da população economicamente
            ativa de 18 anos ou mais que está desocupada) é de [tx_des18m_10]%.
            ";
    //EN
    protected $textoUdhEN = "Between 2000 and 2010, the <b>activity rate</b> of the population aged 18 years or older (that is, the percentage of 
            the economically-active population) increased from [tx_ativ_18m_00]% in 2000 to [tx_ativ_18m_10]% in 2010.
            At the same time, the <b>unemployment rate</b> (that is, the percentage of the economically-active,
            but unemployed, population) increased from [tx_des18m_00]% in 2000 to [tx_des18m_10]% in 2010.
            ";
    //ES
    protected $textoUdhES = "Entre el 2000 y 2010, la <b>tasa de actividad</b> de la población de 18 años o más (es decir, el porcentaje de esa población que era económicamente activa) paso de un 
            [tx_ativ_18m_00]% en el 2000 a un [tx_ativ_18m_10]% en 2010. Asimismo, su <b>tasa de desempleo</b> (es decir, el porcentaje de la población económicamente activa que estaba desocupada) pasó de un 
            [tx_des18m_00]% en el 2000 a un [tx_des18m_10]% en 2010.
            ";
    
    //Municipio2
    //PT2
    protected $texto2MunPT = "Em 2010, das pessoas ocupadas na faixa etária de 18 anos ou mais do município,
            [p_agro_10]%   trabalhavam no setor agropecuário,  [p_extr_10]%
            na indústria extrativa, [p_transf_10]%  na indústria de transformação,
            [p_constr_10]%  no setor de  construção, [p_siup_10]%   nos setores de utilidade pública, [p_com_10]%
            no comércio e [p_serv_10]%  no setor de serviços.
            ";
    //EN2
    protected $texto2MunEN = "In 2010 [p_agro_10]% of the employed people aged 18 years or older were employed in the agricultural sector,
            [p_extr_10]% in mining, [p_transf_10]% in manufacturing, [p_constr_10]% in the construction sector,
            [p_siup_10]% in the public sector, [p_com_10]% in trade and [p_serv_10]%
            in service sector.
            ";
    //ES2
    protected $texto2MunES = "En 2010, de las personas ocupadas de 18 años o más, un [p_agro_10]% trabajaba en el sector agropecuario, un [p_extr_10]%
            en la industria extractiva, un [p_transf_10]% en la industria de transformación, un [p_constr_10]% en el sector de la construcción, un [p_siup_10]%
            en sectores de utilidad pública, un [p_com_10]%
            en el comercio y un [p_serv_10]% en el sector de servicios.
            ";
    //Região Metropolitana2
    //PT2
    protected $texto2RmPT = "Em 2010, das pessoas ocupadas na faixa etária de 18 anos ou mais da RM,
            [p_agro_10]%   trabalhavam no setor agropecuário,  [p_extr_10]%
            na indústria extrativa, [p_transf_10]%  na indústria de transformação,
            [p_constr_10]%  no setor de  construção, [p_siup_10]%   nos setores de utilidade pública, [p_com_10]%
            no comércio e [p_serv_10]%  no setor de serviços.
            ";
    //EN2
    protected $texto2RmEN = "In 2010 [p_agro_10]% of the employed people aged 18 years or older were employed in the agricultural sector,
            [p_extr_10]% in mining, [p_transf_10]% in manufacturing, [p_constr_10]% in the construction sector,
            [p_siup_10]% in the public sector, [p_com_10]% in trade and [p_serv_10]%
            in service sector.
            ";
    //ES2
    protected $texto2RmES = "En 2010, de las personas ocupadas de 18 años o más, un [p_agro_10]% trabajaba en el sector agropecuario, un [p_extr_10]%
            en la industria extractiva, un [p_transf_10]% en la industria de transformación, un [p_constr_10]% en el sector de la construcción, un [p_siup_10]%
            en sectores de utilidad pública, un [p_com_10]%
            en el comercio y un [p_serv_10]% en el sector de servicios.
            ";
    //Estado2
    //PT2
    protected $texto2UfPT = "Em 2010, das pessoas ocupadas na faixa etária de 18 anos ou mais da UF,
            [p_agro_10]%   trabalhavam no setor agropecuário,  [p_extr_10]%
            na indústria extrativa, [p_transf_10]%  na indústria de transformação,
            [p_constr_10]%  no setor de  construção, [p_siup_10]%   nos setores de utilidade pública, [p_com_10]%
            no comércio e [p_serv_10]%  no setor de serviços.
            ";
    //EN2
    protected $texto2UfEN = "In 2010 [p_agro_10]% of the employed people aged 18 years or older were employed in the agricultural sector,
            [p_extr_10]% in mining, [p_transf_10]% in manufacturing, [p_constr_10]% in the construction sector,
            [p_siup_10]% in the public sector, [p_com_10]% in trade and [p_serv_10]%
            in service sector.
            ";
    //ES2
    protected $texto2UfES = "En 2010, de las personas ocupadas de 18 años o más, un [p_agro_10]% trabajaba en el sector agropecuario, un [p_extr_10]%
            en la industria extractiva, un [p_transf_10]% en la industria de transformación, un [p_constr_10]% en el sector de la construcción, un [p_siup_10]%
            en sectores de utilidad pública, un [p_com_10]%
            en el comercio y un [p_serv_10]% en el sector de servicios.
            ";
    //Unidade de Desenvolvimento Humano2
    //PT2
    protected $texto2UdhPT = "Em 2010, das pessoas ocupadas na faixa etária de 18 anos ou mais, [p_agro_10]%   trabalhavam no setor agropecuário,  [p_extr_10]%
            na indústria extrativa, [p_transf_10]%  na indústria de transformação, [p_constr_10]%  no setor de  construção, [p_siup_10]%   nos setores de utilidade pública, [p_com_10]%
            no comércio e [p_serv_10]%  no setor de serviços.
            ";
    //EN2
    protected $texto2UdhEN = "In 2010 [p_agro_10]% of the employed people aged 18 years or older were employed in the agricultural sector,
            [p_extr_10]% in mining, [p_transf_10]% in manufacturing, [p_constr_10]% in the construction sector,
            [p_siup_10]% in the public sector, [p_com_10]% in trade and [p_serv_10]%
            in service sector.
            ";
    //ES2
    protected $texto2UdhES = "En 2010, de las personas ocupadas de 18 años o más, un [p_agro_10]% trabajaba en el sector agropecuario, un [p_extr_10]%
            en la industria extractiva, un [p_transf_10]% en la industria de transformación, un [p_constr_10]% en el sector de la construcción, un [p_siup_10]%
            en sectores de utilidad pública, un [p_com_10]%
            en el comercio y un [p_serv_10]% en el sector de servicios.
            ";
    //Padrão
    protected $tituloPT = "Trabalho";
    protected $tituloEN = "Labour";
    protected $tituloES = "Trabajo";

    //Tabela
    protected $captionPT = "Ocupação da população de 18 anos ou mais";
    protected $captionEN = "Employment rates of the population aged 18 years or older";
    protected $captionES = "Ocupación de la población de 18 años o más";
    
    protected $subCaption1PT = "Nível educacional dos ocupados";
    protected $subCaption1EN = "Educational level of the employed";
    protected $subCaption1ES = "Nivel de educación de los ocupados";
    
    protected $subCaption2PT = "Rendimento médio";
    protected $subCaption2EN = "Average income";
    protected $subCaption2ES = "Ingreso promedio";
    
    public function getSubCaption1() {

        if ($this->lang == "pt")
            return $this->subCaption1PT;
        else if ($this->lang == "en")
            return $this->subCaption1EN;
        else if ($this->lang == "es")
            return $this->subCaption1ES;
    }
    
    public function getSubCaption2() {

        if ($this->lang == "pt")
            return $this->subCaption2PT;
        else if ($this->lang == "en")
            return $this->subCaption2EN;
        else if ($this->lang == "es")
            return $this->subCaption2ES;
    }

    function getChartTrabalho($idMunicipio) {

       // $chart = new FunctionsChart();

        //$trabalho = json_encode($this->chart->getTrabalho2010($idMunicipio));
        $trabalho_ativo = json_encode($this->chart->getTrabalhoAtivos2010($idMunicipio));

        if ($this->lang == "pt"){
            $titulo = "Composição da população de 18 anos ou mais de idade – 2010";
            $img = "./assets/img/perfil/pop_econ_ativa.png";
        }else if ($this->lang == "en"){
             $titulo = "[EN]Composição da população de 18 anos ou mais de idade – 2010";
             $img = "./assets/img/perfil/pop_econ_ativa_en.png";
        }else if ($this->lang == "es"){
            $titulo = "[ES]Composição da população de 18 anos ou mais de idade – 2010";
            $img = "./assets/img/perfil/pop_econ_ativa_es.png";        
        }
        
        echo "<script language='javascript' type='text/javascript'>
              graficoTrabalho('" . $this->lang . "','" . $this->type . "');</script>";

//        echo "<script language='javascript' type='text/javascript'>
//              graficoTrabalhoAtivos('" . $this->lang . "','" . $this->type . "');</script>";

//            echo '<script language="javascript" type="text/javascript">graficoTrabalho();</script>';
//            echo '<script language="javascript" type="text/javascript">graficoTrabalhoAtivos();</script>';

        return "<div style='height: 50px; text-align:center; font-size: 15pt; font-weight: bold;'>".$titulo."</div>
                	
         <div id='chart_trab' style='width: 100%; height: 457px; margin-left:15%;'> 
               <div id='chart_trabalho' style='width: 800px; height: 535px; float:left;' >
                    <input id='trabalho_perfil' type='hidden' value=' " . $trabalho_ativo . "' /> 
                </div>
         </div>";
        
//        return "<div style='height: 50px; text-align:center; font-size: 15pt; font-weight: bold;'>".$titulo."</div>
//                <div><img src='".$img."' width='348' height='57' style='margin-left:80px'/></div>	
//         <div id='chart_trab' style='width: 100%; height: 457px; margin-left:8%;'> 
//               <div id='chart_trabalho' style='width: 500px; height: 500px; float:left;' >
//                    <input id='trabalho_perfil' type='hidden' value=' " . $trabalho_ativo . "' /> 
//                </div>
//                <div id='chart_trabalho_ativos' style='width: 350px; height: 400px; float:left; margin-top: 45px;' >
//                    <input id='trabalho_ativo' type='hidden' value=' " . $trabalho_ativo . "' /> 
//                </div>
//         </div>";


    }

}

?>

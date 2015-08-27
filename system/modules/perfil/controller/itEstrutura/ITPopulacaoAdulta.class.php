<?php

/**
 * Construção do Componente por Tipo e Idioma
 *
 * @author Andre Castro
 */
class ITPopulacaoAdulta extends IT {

    //Municipio
    //PT
    protected $textoMunPT = "
            Também compõe o IDHM Educação um indicador de escolaridade da população adulta, 
            o percentual da população de 18 anos ou mais com o ensino fundamental completo. 
            Esse indicador carrega uma grande inércia, em função do peso das gerações mais antigas, de menor escolaridade.
            Entre 2000 e 2010, esse percentual passou de [t_fund18m_00]% para [t_fund18m_10]%, 
            no município, e de [t_fund18m_br_00]% para [t_fund18m_br_10]%, na UF. Em 1991, os percentuais 
            eram de [t_fund18m_91]% ,no município, e [t_fund18m_br_91]%, na UF.
            Em 2010, considerando-se a população municipal de 25 anos ou mais de idade, 
            [t_analf25m_10]% eram analfabetos, [t_fund25m_10]% tinham o ensino fundamental completo,
            [t_med25m_10]% possuíam o ensino médio completo e [t_super25m_10]%, o superior completo. 
            No Brasil, esses percentuais são, respectivamente, [t_analf25m_br_10]%, [t_fund25m_br_10]%, [t_medin25m_br_10]% e [t_super25m_br_10]%.";
    //EN
    protected $textoMunEN = "The educational level of the adult population is an important indicator in terms of access to knowledge – hence, it is part of MHDI Education.
            <br><br>In 2010, [25_fund_10]% of the population aged 18 years or older had completed primary education and [25_medio_10]%
            had completed secondary education. In [estado_municipio], [25_fund_10_Estado]% and [25_medio_10_Estado]%.
            This indicator bears inertia - depending on the weight of the older and less-educated generation.
            <br><br>The illiteracy rate of the population aged 18 years or older [diminuiu_aumentou] [25_analf_9110] in the last two decades.
            ";
    //ES
    protected $textoMunES = "La escolaridad de la población adulta es un indicador importante de acceso al conocimiento y compone el IDHM Educación.
            <br><br>En 2010, el [25_fund_10]% de la población de 18 años o más había terminado la educación primaria y el [25_medio_10]%,
            la educación secundaria. En [estado_municipio], correspondían al [25_fund_10_Estado]% y al [25_medio_10_Estado]%, respectivamente.
            Este indicador está sujeto a una gran inercia, debido al peso de las generaciones más antiguas y con menos escolaridad.
            <br><br>La tasa de analfabetismo de la población de 18 años o más [diminuiu_aumentou] un [25_analf_9110] en las dos últimas décadas.
            ";
    //Região Metropolitana
    //PT
    protected $textoRmPT = "
            Também compõe o IDHM Educação um indicador de escolaridade da população adulta, 
            o percentual da população de 18 anos ou mais com o ensino fundamental completo. 
            Esse indicador carrega uma grande inércia, em função do peso das gerações mais antigas, de menor escolaridade.
            Entre 2000 e 2010, esse percentual passou de [t_fund18m_00]% para [t_fund18m_10]%, 
            na RM, e de [t_fund18m_br_00]% para [t_fund18m_br_10]%, no Brasil.<br><br> 
            
            Em 2010, considerando-se a população metropolitana de 25 anos ou mais de idade, 
            [t_analf25m_10]% eram analfabetos, [t_fund25m_10]% tinham o ensino fundamental completo,
            [t_med25m_10]% possuíam o ensino médio completo e [t_super25m_10]%, o superior completo. 
            No Brasil, esses percentuais são, respectivamente, [t_analf25m_br_10]%, [t_fund25m_br_10]%, [t_medin25m_br_10]% e [t_super25m_br_10]%.";
    //EN
    protected $textoRmEN = "The educational level of the adult population is an important indicator in terms of access to knowledge – hence, it is part of HDI Education.
            <br><br>In 2010, [25_fund_10]% of the population aged 18 years or older had completed primary education and [25_medio_10]%
            had completed secondary education. This indicator bears inertia - depending on the weight of the older and less-educated generation.
            <br><br>The illiteracy rate of the population aged 18 years or older [diminuiu_aumentou] [25_analf_9110] in the last two decades.
            ";
    //ES
    protected $textoRmES = "La escolaridad de la población adulta es un indicador importante de acceso al conocimiento y compone el IDH Educación.
            <br><br>En 2010, el [25_fund_10]% de la población de 18 años o más había terminado la educación primaria y el [25_medio_10]%,
            la educación secundaria. Este indicador está sujeto a una gran inercia, debido al peso de las generaciones más antiguas y con menos escolaridad.
            <br><br>La tasa de analfabetismo de la población de 18 años o más [diminuiu_aumentou] un [25_analf_9110] en las dos últimas décadas.
            ";
    //Estado
    //PT
    protected $textoUfPT = "
            Também compõe o IDHM Educação um indicador de escolaridade da população adulta, 
            o percentual da população de 18 anos ou mais com o ensino fundamental completo. 
            Esse indicador carrega uma grande inércia, em função do peso das gerações mais antigas, de menor escolaridade.
            <br><br>Entre 2000 e 2010, esse percentual passou de [t_fund18m_00]% para [t_fund18m_10]%, 
            na UF, e de [t_fund18m_br_00]% para [t_fund18m_br_10]%, no Brasil. Em 1991, os percentuais 
            eram de [t_fund18m_91]% ,na UF, e [t_fund18m_br_91]%,no país.
            <br><br>Em 2010, considerando-se a população da UF de 25 anos ou mais de idade, 
            [t_analf25m_10]% eram analfabetos, [t_fund25m_10]% tinham o ensino fundamental completo,
            [t_med25m_10]% possuíam o ensino médio completo e [t_super25m_10]%, o superior completo. 
            No Brasil, esses percentuais são, respectivamente, [t_analf25m_br_10]%, [t_fund25m_br_10]%, [t_medin25m_br_10]% e [t_super25m_br_10]%.";
//A escolaridade da população adulta é importante indicador de acesso a conhecimento e também compõe o IDH Educação.
//            <br><br>Em 2010, [25_fund_10]% da população de 18 anos ou mais de idade tinha completado o ensino fundamental e [25_medio_10]%
//            o ensino médio. Esse indicador carrega uma grande inércia, em função do peso das gerações mais antigas e de menos escolaridade.
//            <br><br>A taxa de analfabetismo da população de 18 anos ou mais [diminuiu_aumentou] [25_analf_9110] nas últimas duas décadas.
//            ";
    //EN
    protected $textoUfEN = "The educational level of the adult population is an important indicator in terms of access to knowledge – hence, it is part of HDI Education.
            <br><br>In 2010, [25_fund_10]% of the population aged 18 years or older had completed primary education and [25_medio_10]%
            had completed secondary education. This indicator bears inertia - depending on the weight of the older and less-educated generation.
            <br><br>The illiteracy rate of the population aged 18 years or older [diminuiu_aumentou] [25_analf_9110] in the last two decades.
            ";
    //ES
    protected $textoUfES = "La escolaridad de la población adulta es un indicador importante de acceso al conocimiento y compone el IDH Educación.
            <br><br>En 2010, el [25_fund_10]% de la población de 18 años o más había terminado la educación primaria y el [25_medio_10]%,
            la educación secundaria. Este indicador está sujeto a una gran inercia, debido al peso de las generaciones más antiguas y con menos escolaridad.
            <br><br>La tasa de analfabetismo de la población de 18 años o más [diminuiu_aumentou] un [25_analf_9110] en las dos últimas décadas.
            ";
    //Unidade de Desenvolvimento Humano
    //PT
    protected $textoUdhPT = "Também compõe o IDHM Educação um indicador de escolaridade da população adulta,
        o percentual da população de 18 anos ou mais com o ensino fundamental completo. Esse indicador carrega
        uma grande inércia, em função do peso das gerações mais antigas, de menor escolaridade.<br><br>
            
            Em 2010, esse percentual era de [t_fund18m_10]% na UDH e de [t_fund18m_10_mun_udh]% e [t_fund18m_10_rm_udh]%
            no município e na região metropolitana nos quais ela se localiza, respectivamente. <br><br>
            
            Em 2010, considerando-se a população de 25 anos ou mais de idade da UDH, [t_analf25m_10]% eram analfabetos,
            [t_fund25m_10]% tinham o ensino fundamental completo, [t_med25m_10]% possuíam o ensino médio completo e
            [t_super25m_10]%, o superior completo. No município onde se situa a UDH, esses percentuais são, respectivamente,
            [t_analf25m_10_mun_udh]%, [t_fund25m_10_mun_udh]%, [t_med25m_10_mun_udh]% e [t_super25m_10_mun_udh]%.
            Já na RM, os percentuais são [t_analf25m_10_rm_udh]%, [t_fund25m_10_rm_udh]%, [t_med25m_10_rm_udh]% 
            e [t_super25m_10_rm_udh]%, respectivamente.";
    //EN
    protected $textoUdhEN = "The educational level of the adult population is an important indicator in terms of access to knowledge – hence, it is part of HDI Education.
            <br><br>In 2010, [25_fund_10]% of the population aged 18 years or older had completed primary education and [25_medio_10]%
            had completed secondary education. In [estado_municipio], [25_fund_10_Estado]% and [25_medio_10_Estado]%.
            This indicator bears inertia - depending on the weight of the older and less-educated generation.
            <br><br>The illiteracy rate of the population aged 18 years or older [diminuiu_aumentou] [25_analf_9110] in the last two decades.
            ";
    //ES
    protected $textoUdhES = "La escolaridad de la población adulta es un indicador importante de acceso al conocimiento y compone el IDH Educación.
            <br><br>En 2010, el [25_fund_10]% de la población de 18 años o más había terminado la educación primaria y el [25_medio_10]%,
            la educación secundaria. En [estado_municipio], correspondían al [25_fund_10_Estado]% y al [25_medio_10_Estado]%, respectivamente.
            Este indicador está sujeto a una gran inercia, debido al peso de las generaciones más antiguas y con menos escolaridad.
            <br><br>La tasa de analfabetismo de la población de 18 años o más [diminuiu_aumentou] un [25_analf_9110] en las dos últimas décadas.
            ";
    //Padrão
    protected $subtituloPT = "População Adulta";
    protected $subtituloEN = "Adult population";
    protected $subtituloES = "Población adulta";

    function getChartEscolaridadePopulacao($idMunicipio) {

        $freq_1991 = json_encode($this->chart->getFrequenciaEscolar25ouMais($idMunicipio, 1991));
        $freq_2000 = json_encode($this->chart->getFrequenciaEscolar25ouMais($idMunicipio, 2000));
        $freq_2010 = json_encode($this->chart->getFrequenciaEscolar25ouMais($idMunicipio, 2010));

        if ($this->lang == "pt") {
            $img = "./assets/img/perfil/25_ou_mais.png";
            $img0010 = "./assets/img/perfil/25_ou_mais_0010.png";
            $img10 = "./assets/img/perfil/25_ou_mais_10.png";
        } else if ($this->lang == "en")
            $img = "./assets/img/perfil/25_ou_mais_en.png";
        else if ($this->lang == "es")
            $img = "./assets/img/perfil/25_ou_mais_es.png";


        if ($this->type != "perfil_rm" && $this->type != "perfil_udh") {

            echo "<script language='javascript' type='text/javascript'>
              graficoEscolaridadePop91('" . $this->lang . "','" . $this->type . "');</script>";

            echo "<script language='javascript' type='text/javascript'>
              graficoEscolaridadePop00('" . $this->lang . "','" . $this->type . "');</script>";

            echo "<script language='javascript' type='text/javascript'>
              graficoEscolaridadePop10('" . $this->lang . "','" . $this->type . "');</script>";

            $html = "<div id='chart_escola' style='width:100%; height: 330px'>
                <div><img src='" . $img . "' width='736' height='47' style='margin-left:95px; margin-bottom:-25px; z-index:1; position:relative;'/></div>";

            $html .= "<div id='chartEscolaridadePop91' style='width: 360px; height: 283px; float:left; position:none;'>            
                <input id='freq_1991' type='hidden' value=' " . $freq_1991 . "' /> 
                </div>";

            $html .= "<div id='chartEscolaridadePop00' style='width: 285px; height: 283px;float:left; position:none;'>            
                    <input id='freq_2000' type='hidden' value=' " . $freq_2000 . "' /> 
                </div>";

            $html .= "<div id='chartEscolaridadePop10' style='width: 230px; height: 283px;float:left; position:none;'>            
                    <input id='freq_2010' type='hidden' value=' " . $freq_2010 . "' /> 
                </div>
           </div>";
            
        } else if ($this->type == "perfil_udh"){

            echo "<script language='javascript' type='text/javascript'>
              graficoEscolaridadePop10('" . $this->lang . "','" . $this->type . "');</script>";

            $html = "<div id='chart_escola' style='width:100%; height: 330px'>
            <div><img src='" . $img10 . "' width='736' height='47' style='margin-left:95px; margin-bottom:-25px; z-index:1; position:relative;'/></div>";

            $html .= "<div id='chartEscolaridadePop10' style='width: 360px; height: 283px; float:left; position:none; margin-left:45px;'>            
                    <input id='freq_2010' type='hidden' value=' " . $freq_2010 . "' /> 
                </div>
           </div>";
            
        }else if ($this->type == "perfil_rm"){

            echo "<script language='javascript' type='text/javascript'>
              graficoEscolaridadePop00('" . $this->lang . "','" . $this->type . "');</script>";

            echo "<script language='javascript' type='text/javascript'>
              graficoEscolaridadePop10('" . $this->lang . "','" . $this->type . "');</script>";

            $html = "<div id='chart_escola' style='width:100%; height: 330px'>
            <div><img src='" . $img0010 . "' width='736' height='47' style='margin-left:95px; margin-bottom:-25px; z-index:1; position:relative;'/></div>";

            $html .= "<div id='chartEscolaridadePop00' style='width: 360px; height: 283px;float:left; position:none;'>            
                    <input id='freq_2000' type='hidden' value=' " . $freq_2000 . "' /> 
                </div>";

            $html .= "<div id='chartEscolaridadePop10' style='width: 285px; height: 283px; float:left; position:none; margin-left:45px;'>            
                    <input id='freq_2010' type='hidden' value=' " . $freq_2010 . "' /> 
                </div>
           </div>";
        }

        return $html;
    }

}

?>

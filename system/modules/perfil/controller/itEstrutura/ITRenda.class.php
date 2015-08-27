<?php

/**
 * Construção da Estrutura Etária por Tipo e Idioma
 *
 * @author Andre Castro
 */
class ITRenda extends IT {

    //Municipio
    //PT
    protected $textoMunPT = "
            A renda per capita média de [municipio] [caiu_cresceu] [tx_cresc_renda_9110]%
            nas últimas duas décadas, passando de R$ [renda91], em 1991, para R$ [renda00], em 2000,
            e para R$ [renda10], em 2010. 
            
            Isso equivale a uma taxa média anual de crescimento nesse período de [tx_media_anual_cresc_renda9110_1por19]%. 
            A taxa média anual de crescimento foi de [tx_media_anual_cresc_renda0010_1por9]%, entre 1991 e 2000, 
            e [tx_media_anual_cresc_renda0010]%, entre 2000 e 2010. 
            
            A proporção de pessoas pobres, ou seja, com renda domiciliar per capita inferior a R$ 140,00
            (a preços de agosto de 2010), passou de [pmpob_91]%, em 1991, para [pmpob_00]%, em 2000,
            e para [pmpob_10]%, em 2010.
            A evolução da desigualdade de renda nesses dois períodos pode ser descrita através do Índice de Gini,
            que passou de [gini_91], em 1991, para [gini_00], em 2000, e para [gini_10], em 2010.";
    
    //            A taxa média anual de crescimento foi de [tx_media_anual_cresc_renda9100]%,
//            entre 1991 e 2000, e [tx_media_anual_cresc_renda0010]%, entre 2000 e 2010.
//            
    //EN
    protected $textoMunEN = "During the last two decades, the average income per capita of [municipio] [caiu_cresceu] [tx_cresc_renda]%,
            from R$[renda91], in 1991, to R$[renda00] in 2000 and R$[renda10] in 2010.
            In the first period the average annual growth rate was
            [tx_cresc_renda9100]% and, in the second period, [tx_cresc_renda0010]%.
            Extreme poverty (as measured by the proportion of people with income per capita below R$ 70,00 in August 2010) went from
            [tx_pobreza_91]% in 1991 to [tx_pobreza_00]%
            in 2000 and to [tx_pobreza_10]%  in 2010.
            <br><br>The inequality [diminuiu_aumentou]: the Gini coefficient rose from [gini_91]
            in 1991 to [gini_00] in 2000 and to [gini_10] in 2010.";
    //ES
    protected $textoMunES = "El ingreso per cápita promedio de [municipio] [caiu_cresceu] un [tx_cresc_renda]% en las dos últimas décadas,
            tras pasar de R$[renda91] en 1991 a R$[renda00] en el 2000 y a R$[renda10] en 2010. La tasa anual promedio de crecimiento se situó en un 
            [tx_cresc_renda9100]% en el primer período y en un [tx_cresc_renda0010]% en el segundo. La pobreza extrema (medida de acuerdo con la proporción de personas con ingreso familiar per cápita inferior a 70,00 R$ en reales de agosto de 2010) pasó de un 
            [tx_pobreza_91]% en 1991 a un [tx_pobreza_00]%
            en el 2000 y a un [tx_pobreza_10]% en 2010.
            <br><br>La desigualdad [diminuiu_aumentou]: el Índice de Gini pasó de 
            [gini_91] en 1991 a [gini_00] en el 2000 y a [gini_10] en 2010.";
    //Região Metropolitana
    //PT
    protected $textoRmPT = "
            A renda per capita média da RM de [municipio] [caiu_cresceu] [tx_cresc_renda0010]%
            na última década, passando de R$ [renda00], em 2000,
            para R$ [renda10], em 2010. A taxa média anual de crescimento foi de [tx_media_anual_cresc_renda0010]%, entre 2000 e 2010.
            A proporção de pessoas pobres, ou seja, com renda domiciliar per capita inferior a R$ 140,00
            (a preços de agosto de 2010), passou de [pmpob_00]%, em 2000,
            para [pmpob_10]%, em 2010.
            A evolução da desigualdade de renda nesses dois períodos pode ser descrita através do Índice de Gini,
            que passou de [gini_00], em 2000, para [gini_10], em 2010.";
    //EN
    protected $textoRmEN = "During the last two decades, the average income per capita of [municipio] [caiu_cresceu] [tx_cresc_renda]%,
            from R$[renda91], in 1991, to R$[renda00] in 2000 and R$[renda10] in 2010.
            In the first period the average annual growth rate was
            [tx_cresc_renda9100]% and, in the second period, [tx_cresc_renda0010]%.
            Extreme poverty (as measured by the proportion of people with income per capita below R$ 70,00 in August 2010) went from
            [tx_pobreza_91]% in 1991 to [tx_pobreza_00]%
            in 2000 and to [tx_pobreza_10]%  in 2010.
            <br><br>The inequality [diminuiu_aumentou]: the Gini coefficient rose from [gini_91]
            in 1991 to [gini_00] in 2000 and to [gini_10] in 2010.";
    //ES
    protected $textoRmES = "El ingreso per cápita promedio de la [municipio] [caiu_cresceu] un [tx_cresc_renda]% en las dos últimas décadas,
            tras pasar de R$[renda91] en 1991 a R$[renda00] en el 2000 y a R$[renda10] en 2010. La tasa anual promedio de crecimiento se situó en un 
            [tx_cresc_renda9100]% en el primer período y en un [tx_cresc_renda0010]% en el segundo. La pobreza extrema (medida de acuerdo con la proporción de personas con ingreso familiar per cápita inferior a 70,00 R$ en reales de agosto de 2010) pasó de un 
            [tx_pobreza_91]% en 1991 a un [tx_pobreza_00]%
            en el 2000 y a un [tx_pobreza_10]% en 2010.
            <br><br>La desigualdad [diminuiu_aumentou]: el Índice de Gini pasó de 
            [gini_91] en 1991 a [gini_00] en el 2000 y a [gini_10] en 2010.";
    //Estado
    //PT
    protected $textoUfPT = "
            A renda per capita média de [municipio] [caiu_cresceu] [tx_cresc_renda_9110]%
            nas últimas duas décadas, passando de R$ [renda91], em 1991, para R$ [renda00], em 2000,
            e para R$ [renda10], em 2010. 
            
            Isso equivale a uma taxa média anual de crescimento nesse período de [tx_media_anual_cresc_renda9110_1por19]%. 
            A taxa média anual de crescimento foi de [tx_media_anual_cresc_renda0010_1por9]%, entre 1991 e 2000, 
            e [tx_media_anual_cresc_renda0010]%, entre 2000 e 2010.            

     
            A proporção de pessoas pobres, ou seja, com renda domiciliar per capita inferior a R$ 140,00
            (a preços de agosto de 2010), passou de [pmpob_91]%, em 1991, para [pmpob_00]%, em 2000,
            e para [pmpob_10]%, em 2010.
            <br><br>A evolução da desigualdade de renda nesses dois períodos pode ser descrita através do Índice de Gini,
            que passou de [gini_91], em 1991, para [gini_00], em 2000, e para [gini_10], em 2010.";
//A renda per capita média de [municipio] [caiu_cresceu] [tx_cresc_renda]%  nas últimas duas décadas,
//            passando de R$[renda91] em 1991 para R$[renda00] em 2000 e R$[renda10] em 2010. A taxa média anual de crescimento foi
//            de [tx_cresc_renda9100]% no primeiro período e [tx_cresc_renda0010]% no segundo. A extrema pobreza (medida pela proporção de pessoas com
//            renda domiciliar per capita inferior a R$ 70,00, em reais de agosto de 2010) passou de [tx_pobreza_91]%  em 1991 para [tx_pobreza_00]%
//            em 2000 e para [tx_pobreza_10]%  em 2010.
//            <br><br>A desigualdade [diminuiu_aumentou]: o Índice de Gini passou de [gini_91] em 1991 para [gini_00] em 2000 e  para [gini_10] em 2010.";
    //EN
    protected $textoUfEN = "During the last two decades, the average income per capita of [municipio] [caiu_cresceu] [tx_cresc_renda]%,
            from R$[renda91], in 1991, to R$[renda00] in 2000 and R$[renda10] in 2010.
            In the first period the average annual growth rate was
            [tx_cresc_renda9100]% and, in the second period, [tx_cresc_renda0010]%.
            Extreme poverty (as measured by the proportion of people with income per capita below R$ 70,00 in August 2010) went from
            [tx_pobreza_91]% in 1991 to [tx_pobreza_00]%
            in 2000 and to [tx_pobreza_10]%  in 2010.
            <br><br>The inequality [diminuiu_aumentou]: the Gini coefficient rose from [gini_91]
            in 1991 to [gini_00] in 2000 and to [gini_10] in 2010.";
    //ES
    protected $textoUfES = "El ingreso per cápita promedio de [municipio] [caiu_cresceu] un [tx_cresc_renda]% en las dos últimas décadas,
            tras pasar de R$[renda91] en 1991 a R$[renda00] en el 2000 y a R$[renda10] en 2010. La tasa anual promedio de crecimiento se situó en un 
            [tx_cresc_renda9100]% en el primer período y en un [tx_cresc_renda0010]% en el segundo. La pobreza extrema (medida de acuerdo con la proporción de personas con ingreso familiar per cápita inferior a 70,00 R$ en reales de agosto de 2010) pasó de un 
            [tx_pobreza_91]% en 1991 a un [tx_pobreza_00]%
            en el 2000 y a un [tx_pobreza_10]% en 2010.
            <br><br>La desigualdad [diminuiu_aumentou]: el Índice de Gini pasó de 
            [gini_91] en 1991 a [gini_00] en el 2000 y a [gini_10] en 2010.";
    //Unidade de Desenvolvimento Humano
    //PT


    protected $textoUdhPT = "
            A renda per capita média da UDH é de [renda10], em 2010, enquanto no município [mun_udh] é
            de [renda10_mun_udh] e na RM de [rm_udh], de [renda10_rm_udh]. No mesmo ano, a proporção de pessoas pobres, ou seja,
            com renda domiciliar per capita inferior a R$ 140,00 (a preços de agosto de 2010) é de [pmpob_10]%
            na UDH, de [pmpob_10_mun_udh]% no município e de [pmpob_10_rm_udh]% na RM.";
    //EN
    protected $textoUdhEN = "During the last two decades, the average income per capita of [municipio] [caiu_cresceu] [tx_cresc_renda]%,
            from R$[renda91], in 1991, to R$[renda00] in 2000 and R$[renda10] in 2010.
            In the first period the average annual growth rate was
            [tx_cresc_renda9100]% and, in the second period, [tx_cresc_renda0010]%.
            Extreme poverty (as measured by the proportion of people with income per capita below R$ 70,00 in August 2010) went from
            [tx_pobreza_91]% in 1991 to [tx_pobreza_00]%
            in 2000 and to [tx_pobreza_10]%  in 2010.
            <br><br>The inequality [diminuiu_aumentou]: the Gini coefficient rose from [gini_91]
            in 1991 to [gini_00] in 2000 and to [gini_10] in 2010.";
    //ES
    protected $textoUdhES = "El ingreso per cápita promedio de [municipio] [caiu_cresceu] un [tx_cresc_renda]% en las dos últimas décadas,
            tras pasar de R$[renda91] en 1991 a R$[renda00] en el 2000 y a R$[renda10] en 2010. La tasa anual promedio de crecimiento se situó en un 
            [tx_cresc_renda9100]% en el primer período y en un [tx_cresc_renda0010]% en el segundo. La pobreza extrema (medida de acuerdo con la proporción de personas con ingreso familiar per cápita inferior a 70,00 R$ en reales de agosto de 2010) pasó de un 
            [tx_pobreza_91]% en 1991 a un [tx_pobreza_00]%
            en el 2000 y a un [tx_pobreza_10]% en 2010.
            <br><br>La desigualdad [diminuiu_aumentou]: el Índice de Gini pasó de 
            [gini_91] en 1991 a [gini_00] en el 2000 y a [gini_10] en 2010.";
    //Padrão
    protected $tituloPT = "Renda";
    protected $tituloEN = "Income";
    protected $tituloES = "Ingresos";
    //Blocos de Texto
    protected $iGiniPT = "<br><b>O que é Índice de Gini?</b><br>
            É um instrumento usado para medir<br>
            o grau de concentração de renda.<br>
            Ele aponta a diferença entre os <br>
            rendimentos dos mais pobres e dos <br>
            mais ricos. Numericamente, varia <br>
            de 0 a 1, sendo que 0 representa <br>
            a situação de total igualdade, ou seja,<br>
            todos têm a mesma renda, e o valor <br>
            1 significa completa desigualdade<br>
            de renda, ou seja, se uma só pessoa <br>
            detém toda a renda do lugar.";
    protected $iGiniEN = "<br><b>What is the Gini Index?</b><br>
            The Gini index is an instrument used<br>
            to measure the degree of income concentration.<br>
            It points out the difference <br>
            between the poorest and richest incomes. <br>
            Numerically, it varies from 0 to 1, <br>
            with 0 representing a situation of  <br>
            complete equality or everyone having <br>
            the same income. The value of 1 means <br>
            complete income inequality, or a situation <br>
            where only one person holds all <br>
            the income in a given place.";
    protected $iGiniES = "<br><b>¿Qué es el Índice de Gini?</b><br>
            Es un instrumento para medir <br>
            el grado de concentración de los ingresos <br>
            en función de la diferencia entre los ingresos <br>
            de los más pobres y de los más ricos. <br>
            Se trata de un valor que varía de entre 0 y 1,<br>
            donde 0 representa una situación de igualdad total,<br>
            es decir, donde todos perciben los mismos ingresos,<br>
            y el valor 1 refleja una desigualdad total,<br>
            a saber, en que una sola persona percibe <br>
            todos los ingresos del lugar.";
    //Tabela
    protected $captionPT = "Renda, Pobreza e Desigualdade";
    protected $captionEN = "Income, poverty and inequality";
    protected $captionES = "Ingresos, pobreza y desigualdad";
    protected $caption2PT = "Porcentagem da Renda Apropriada por Estratos da População";
    protected $caption2EN = "Percentage of appropriate income by shares of the population";
    protected $caption2ES = "Porcentaje de los ingresos percibidos por estratos de la población";
    //Comparações  
    protected $cresceuPT = "cresceu";
    protected $cresceuEN = "grew";
    protected $cresceuES = "aumentó";
    protected $caiuPT = "caiu";
    protected $caiuEN = "fell";
    protected $caiuES = "disminuyó";
    protected $diminiuPT = "diminuiu";
    protected $diminiuEN = "decreased";
    protected $diminiuES = "disminuyó";
    protected $mantevePT = "se manteve";
    protected $manteveEN = "remained";
    protected $manteveES = "permanecido";
    protected $aumentouPT = "aumentou";
    protected $aumentouEN = "increased";
    protected $aumentouES = "aumentó";

    public function getCresceu() {

        if ($this->lang == "pt")
            return $this->cresceuPT;
        else if ($this->lang == "en")
            return $this->cresceuEN;
        else if ($this->lang == "es")
            return $this->cresceuES;
    }

    public function getCaiu() {

        if ($this->lang == "pt")
            return $this->caiuPT;
        else if ($this->lang == "en")
            return $this->caiuEN;
        else if ($this->lang == "es")
            return $this->caiuES;
    }

    public function getDiminuiu() {

        if ($this->lang == "pt")
            return $this->diminiuPT;
        else if ($this->lang == "en")
            return $this->diminiuEN;
        else if ($this->lang == "es")
            return $this->diminiuES;
    }

    public function getManteve() {

        if ($this->lang == "pt")
            return $this->mantevePT;
        else if ($this->lang == "en")
            return $this->manteveEN;
        else if ($this->lang == "es")
            return $this->manteveES;
    }

    public function getAumentou() {

        if ($this->lang == "pt")
            return $this->aumentouPT;
        else if ($this->lang == "en")
            return $this->aumentouEN;
        else if ($this->lang == "es")
            return $this->aumentouES;
    }

    public function getIGini() {

        if ($this->lang == "pt")
            return $this->iGiniPT;
        else if ($this->lang == "en")
            return $this->iGiniEN;
        else if ($this->lang == "es")
            return $this->iGiniES;
    }

    function getChartRendaPorQuintos($idMunicipio) {

        $rend_1991 = json_encode($this->chart->getRendaPorQuintosPopulacao($idMunicipio, 1991));
        $rend_2000 = json_encode($this->chart->getRendaPorQuintosPopulacao($idMunicipio, 2000));
        $rend_2010 = json_encode($this->chart->getRendaPorQuintosPopulacao($idMunicipio, 2010));

        if ($this->lang == "pt") {
            $img = "./assets/img/perfil/renda_por_quinto.png";
            $img0010 = "./assets/img/perfil/renda_por_quinto_0010.png";
            $img10 = "./assets/img/perfil/renda_por_quinto_10.png";
        } else if ($this->lang == "en")
            $img = "./assets/img/perfil/renda_por_quinto_en.png";
        else if ($this->lang == "es")
            $img = "./assets/img/perfil/renda_por_quinto_es.png";

        if ($this->type != "perfil_rm" && $this->type != "perfil_udh") {

            echo "<script language='javascript' type='text/javascript'>
              graficoRendaPorQuintos91('" . $this->lang . "','" . $this->type . "');</script>";

            echo "<script language='javascript' type='text/javascript'>
                  graficoRendaPorQuintos00('" . $this->lang . "','" . $this->type . "');</script>";

            echo "<script language='javascript' type='text/javascript'>
                  graficoRendaPorQuintos10('" . $this->lang . "','" . $this->type . "');</script>";

            $html = "<div id='chart_escola' style='width:100%; height: 330px'>
                    <div><img src='" . $img . "' width='736' height='47' style='margin-left:110px; margin-bottom:-35px; z-index:1; position:relative;'/></div>";

            $html .= "
            <div id='chartRendaPorQuintos91' style='width: 360px; height: 283px; float:left; position:none;'>            
            <input id='rend_1991' type='hidden' value=' " . $rend_1991 . "' /> 
            </div>";

            $html .= "<div id='chartRendaPorQuintos00' style='width: 285px; height: 283px;float:left; position:none;'>            
                <input id='rend_2000' type='hidden' value=' " . $rend_2000 . "' /> 
                </div>";

            $html .= "<div id='chartRendaPorQuintos10' style='width: 230px; height: 283px;float:left; position:none;'>            
                <input id='rend_2010' type='hidden' value=' " . $rend_2010 . "' /> 
                </div>
                   </div><br><br>";
            
        } else if ($this->type == "perfil_udh"){

            echo "<script language='javascript' type='text/javascript'>
                  graficoRendaPorQuintos10('" . $this->lang . "','" . $this->type . "');</script>";

            $html = "<div id='chart_escola' style='width:100%; height: 330px'>
                    <div><img src='" . $img10 . "' width='736' height='47' style='margin-left:110px; margin-bottom:-35px; z-index:1; position:relative;'/></div>";

            $html .= "<div id='chartRendaPorQuintos10' style='width: 360px; height: 283px;float:left; position:none; margin-left:15px;''>            
                <input id='rend_2010' type='hidden' value=' " . $rend_2010 . "' /> 
                </div>
                   </div><br><br>";
            
        }else if ($this->type == "perfil_rm"){
            
            echo "<script language='javascript' type='text/javascript'>
                  graficoRendaPorQuintos00('" . $this->lang . "','" . $this->type . "');</script>";

            echo "<script language='javascript' type='text/javascript'>
                  graficoRendaPorQuintos10('" . $this->lang . "','" . $this->type . "');</script>";

            $html = "<div id='chart_escola' style='width:100%; height: 330px'>
                    <div><img src='" . $img0010 . "' width='736' height='47' style='margin-left:110px; margin-bottom:-35px; z-index:1; position:relative;'/></div>";

            $html .= "<div id='chartRendaPorQuintos00' style='width: 360px; height: 283px;float:left; position:none;'>            
                <input id='rend_2000' type='hidden' value=' " . $rend_2000 . "' /> 
                </div>";

            $html .= "<div id='chartRendaPorQuintos10' style='width: 285px; height: 283px;float:left; position:none; margin-left:15px;''>            
                <input id='rend_2010' type='hidden' value=' " . $rend_2010 . "' /> 
                </div>
                   </div><br><br>";
            
        }

        return $html;
    }

}

?>

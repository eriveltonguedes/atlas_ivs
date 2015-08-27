<?php

/**
 * Construção do Componente por Tipo e Idioma
 *
 * @author Andre Castro
 */
class ITLongMortFecund extends IT {

    //Municipio
    //PT
    protected $textoMunPT = "
            A mortalidade infantil (mortalidade de crianças com menos de um ano de idade)
            no município passou de [mortinfantil00] por mil nascidos vivos, em 2000, para [mortinfantil10]
            por mil nascidos vivos, em 2010. Em 1991, a taxa era de [mortinfantil91]. 
            Já na UF, a taxa era de [mortinfantil10_Estado], em 2010, de [mortinfantil00_Estado], em 2000 e [mortinfantil91_Estado], em 1991.
            Entre 2000 e 2010, a taxa de mortalidade infantil no país caiu de [mortinfantil00_br]
            por mil nascidos vivos para [mortinfantil10_br] por mil nascidos vivos. 
            Em 1991, essa taxa era de [mortinfantil91_br] por mil nascidos vivos.<br>
            Com a taxa observada em 2010, o Brasil cumpre uma das metas dos 
            Objetivos de Desenvolvimento do Milênio das Nações Unidas, segundo a qual a mortalidade infantil
            no país deve estar abaixo de 17,9 óbitos por mil em 2015.";
    //EN
    protected $textoMunEN = "The infant mortality (mortality of children under one year) in [municipio] [mort1_diminuiu_aumentou] [reducao_mortalinfantil0010]%,
            from [mortinfantil00] per thousand of live births in 2000 to [mortinfantil10] per thousand live births in 2010.
            According to the Millennium Development Goals of the United Nations, infant mortality in Brazil should be below 17.9 deaths per thousand in 2015.
            In 2010, the infant mortality rates in the state and the country were [mortinfantil10_Estado] and [mortinfantil10_Brasil] per thousand live births.";
    //ES
    protected $textoMunES = "La mortalidad infantil (mortalidad de los niños de menos de un año) en [municipio] [mort1_diminuiu_aumentou] un [reducao_mortalinfantil0010]%,
            tras pasar de [mortinfantil00] por mil nacidos vivos en el 2000 a [mortinfantil10] por mil nacidos vivos en 2010.
            De acuerdo con los Objetivos de Desarrollo del Milenio de las Naciones Unidas, la mortalidad infantil de Brasil deberá ser inferior a 17,9 muertes por mil en 2015.
            En 2010, las tasas de mortalidad infantil del estado y del país eran de [mortinfantil10_Estado] y [mortinfantil10_Brasil] por mil nacidos vivos, respectivamente.";
    //Municipio2
    //PT2
    protected $texto2MunPT = "
            A esperança de vida ao nascer é o indicador utilizado para compor a dimensão Longevidade
            do Índice de Desenvolvimento Humano Municipal (IDHM). No município, a esperança de vida ao nascer
            cresceu [aumento_esp_nascer0010] anos na última década, passando de 
            [esp_nascer00] anos, em 2000, para [esp_nascer10] anos, em 2010. Em 1991, era de [esp_nascer91] anos.
            No Brasil, a esperança de vida ao nascer é de [esp_nascer10_br] anos, em 2010, de [esp_nascer00_br] anos,
            em 2000, e de [esp_nascer91_br] anos em 1991.";
    //EN2
    protected $texto2MunEN = "The life expectancy at birth is the indicator that composes the Longevity dimension in the Municipal Human Development Index (MHDI).
            In [municipio], life expectancy at birth increased by [aumento_esp_nascer0010] years in the last two decades, from [esp_nascer91] years in 1991 to [esp_nascer00] years in 2000,
            and to [esp_nascer10] years in 2010. In 2010, life expectancy at birth for the state average is [esp_nascer10_estado] years and for the country,
            [esp_nascer10_pais] years.";
    //ES2
    protected $texto2MunES = "La esperanza de vida al nacer es el indicador usado para constituir el factor de longevidad del Índice de Desarrollo Humano Municipal (IDHM).
            En [municipio], la esperanza de vida al nacer aumentó en [aumento_esp_nascer0010] años en las dos últimas décadas, tras pasar de [esp_nascer91] años en 1991 a [esp_nascer00] años en el 2000 y 
            [esp_nascer10] años en 2010. En 2010, la esperanza de vida al nacer promedio era de [esp_nascer10_estado]años en el estado y de 
            [esp_nascer10_pais] años a nivel nacional.";
    //Região Metropolitana
    //PT
    protected $textoRmPT = "
            A mortalidade infantil (mortalidade de crianças com menos de um ano de idade)
            na RM passou de [mortinfantil00] por mil nascidos vivos, em 2000, para [mortinfantil10]
            por mil nascidos vivos, em 2010.
            Entre 2000 e 2010, a taxa de mortalidade infantil no país caiu de [mortinfantil00_br]
            por mil nascidos vivos para [mortinfantil10_br] por mil nascidos vivos. 
            
            Com a taxa observada em 2010, o Brasil cumpre uma das metas dos 
            Objetivos de Desenvolvimento do Milênio das Nações Unidas, segundo a qual a mortalidade infantil
            no país deve estar abaixo de 17,9 óbitos por mil em 2015.";
    //EN
    protected $textoRmEN = "The infant mortality (mortality of children under one year) in [municipio] [mort1_diminuiu_aumentou] [reducao_mortalinfantil0010]%,
            from [mortinfantil00] per thousand of live births in 2000 to [mortinfantil10] per thousand live births in 2010.
            According to the Millennium Development Goals of the United Nations, infant mortality in Brazil should be below 17.9 deaths per thousand in 2015.
            In 2010, the infant mortality rates in the country were [mortinfantil10_Brasil] per thousand live births.";
    //ES
    protected $textoRmES = "La mortalidad infantil (mortalidad de los niños de menos de un año) en la [municipio] [mort1_diminuiu_aumentou] un [reducao_mortalinfantil0010]%,
            tras pasar de [mortinfantil00] por mil nacidos vivos en el 2000 a [mortinfantil10] por mil nacidos vivos en 2010.
            De acuerdo con los Objetivos de Desarrollo del Milenio de las Naciones Unidas, la mortalidad infantil de Brasil deberá ser inferior a 17,9 muertes por mil en 2015.
            En 2010, las tasas de mortalidad infantil del país era de [mortinfantil10_Brasil] por mil nacidos vivos.";
    //Região Metropolitana2
    //PT2
    protected $texto2RmPT = "
            A esperança de vida ao nascer é o indicador utilizado para compor a dimensão Longevidade
            do Índice de Desenvolvimento Humano Municipal (IDHM). Na RM, a esperança de vida ao nascer
            cresceu [aumento_esp_nascer0010] anos na última década, passando de 
            [esp_nascer00] anos, em 2000, para [esp_nascer10] anos, em 2010.
            No Brasil, a esperança de vida ao nascer é de [esp_nascer10_br] anos, em 2010, de [esp_nascer00_br] anos,
            em 2000.";
    //EN2
    protected $texto2RmEN = "The life expectancy at birth is the indicator that composes the Longevity dimension in the Human Development Index (HDI).
            In [municipio], life expectancy at birth increased by [aumento_esp_nascer0010] years in the last two decades, from [esp_nascer91] years in 1991 to [esp_nascer00] years in 2000,
            and to [esp_nascer10] years in 2010. In 2010, life expectancy at birth for the country average were [esp_nascer10_pais] years.";
    //ES2
    protected $texto2RmES =  "La esperanza de vida al nacer es el indicador usado para constituir el factor de longevidad del Índice de Desarrollo Humano (IDH).
            En la [municipio], la esperanza de vida al nacer aumentó en [aumento_esp_nascer0010] años en las dos últimas décadas, tras pasar de [esp_nascer91] años en 1991 a [esp_nascer00] años en el 2000 y 
            [esp_nascer10] años en 2010. En 2010, la esperanza de vida al nacer promedio era de [esp_nascer10_pais] años a nivel nacional.";
    //Estado
    //PT
    protected $textoUfPT = "
            A mortalidade infantil (mortalidade de crianças com menos de um ano de idade)
            na UF passou de [mortinfantil00] por mil nascidos vivos, em 2000, para [mortinfantil10]
            por mil nascidos vivos, em 2010. Em 1991, a taxa era de [mortinfantil91]. 
            Entre 2000 e 2010, a taxa de mortalidade infantil no país caiu de [mortinfantil00_br]
            por mil nascidos vivos para [mortinfantil10_br] por mil nascidos vivos. 
            Em 1991, essa taxa era de [mortinfantil91_br] por mil nascidos vivos.<br>
            Com a taxa observada em 2010, o Brasil cumpre uma das metas dos 
            Objetivos de Desenvolvimento do Milênio das Nações Unidas, segundo a qual a mortalidade infantil
            no país deve estar abaixo de 17,9 óbitos por mil em 2015.";

//            A mortalidade infantil (mortalidade de crianças com menos de um ano) em [municipio]
//            [mort1_diminuiu_aumentou] [reducao_mortalinfantil0010]%,
//            passando de [mortinfantil00] por mil nascidos vivos em 2000 para [mortinfantil10]
//            por mil nascidos vivos em 2010.
//            Segundo os Objetivos de Desenvolvimento do Milênio das Nações Unidas,
//            a mortalidade infantil para o Brasil deve estar abaixo de 17,9 óbitos por mil em 2015.
//            Em 2010, as taxas de mortalidade infantil do país era [mortinfantil10_Brasil] por mil nascidos vivos";
    //EN
    protected $textoUfEN = "The infant mortality (mortality of children under one year) in [municipio] [mort1_diminuiu_aumentou] [reducao_mortalinfantil0010]%,
            from [mortinfantil00] per thousand of live births in 2000 to [mortinfantil10] per thousand live births in 2010.
            According to the Millennium Development Goals of the United Nations, infant mortality in Brazil should be below 17.9 deaths per thousand in 2015.
            In 2010, the infant mortality rates in the country were [mortinfantil10_Brasil] per thousand live births.";
    //ES
    protected $textoUfES = "La mortalidad infantil (mortalidad de los niños de menos de un año) en [municipio] [mort1_diminuiu_aumentou] un [reducao_mortalinfantil0010]%,
            tras pasar de [mortinfantil00] por mil nacidos vivos en el 2000 a [mortinfantil10] por mil nacidos vivos en 2010.
            De acuerdo con los Objetivos de Desarrollo del Milenio de las Naciones Unidas, la mortalidad infantil de Brasil deberá ser inferior a 17,9 muertes por mil en 2015.
            En 2010, las tasas de mortalidad infantil del país era de [mortinfantil10_Brasil] por mil nacidos vivos.";
    //Estado2
    //PT2
    protected $texto2UfPT = "
            A esperança de vida ao nascer é o indicador utilizado para compor a dimensão Longevidade
            do Índice de Desenvolvimento Humano Municipal (IDHM). Na UF, a esperança de vida ao nascer
            cresceu [aumento_esp_nascer0010] anos na última década, passando de 
            [esp_nascer00] anos, em 2000, para [esp_nascer10] anos, em 2010. Em 1991, era de [esp_nascer91] anos.
            No Brasil, a esperança de vida ao nascer é de [esp_nascer10_br] anos, em 2010, de [esp_nascer00_br] anos,
            em 2000, e de [esp_nascer91_br] anos em 1991.";

//A esperança de vida ao nascer é o indicador utilizado para compor a dimensão Longevidade do Índice de Desenvolvimento Humano (IDH).
//            Em [municipio], a esperança de vida ao nascer aumentou [aumento_esp_nascer0010] anos nas últimas duas décadas, passando de [esp_nascer91] anos em 1991 para [esp_nascer00] anos em 2000,
//            e para [esp_nascer10] anos em 2010. Em 2010, a esperança de vida ao nascer média para o país era de [esp_nascer10_pais] anos.";
    //EN2
    protected $texto2UfEN = "The life expectancy at birth is the indicator that composes the Longevity dimension in the Human Development Index (HDI).
            In [municipio], life expectancy at birth increased by [aumento_esp_nascer0010] years in the last two decades, from [esp_nascer91] years in 1991 to [esp_nascer00] years in 2000,
            and to [esp_nascer10] years in 2010. In 2010, life expectancy at birth for the country average were [esp_nascer10_pais] years.";
    //ES2
    protected $texto2UfES = "La esperanza de vida al nacer es el indicador usado para constituir el factor de longevidad del Índice de Desarrollo Humano (IDH).
            En [municipio], la esperanza de vida al nacer aumentó en [aumento_esp_nascer0010] años en las dos últimas décadas, tras pasar de [esp_nascer91] años en 1991 a [esp_nascer00] años en el 2000 y 
            [esp_nascer10] años en 2010. En 2010, la esperanza de vida al nacer promedio era de [esp_nascer10_pais] años a nivel nacional.";
    //Unidade de Desenvolvimento Humano
    //PT
    protected $textoUdhPT = "A mortalidade infantil (mortalidade de crianças com menos de um ano) na UDH
             é de [mortinfantil10] por mil nascidos vivos, em 2010. As taxas de mortalidade infantil do
             município e da região metropolitana são de [mortinfantil10_mun_udh] e [mortinfantil10_rm_udh] por mil nascidos vivos,
             respectivamente, para o mesmo ano.";
    //EN
    protected $textoUdhEN = "The infant mortality (mortality of children under one year) in [municipio] [mort1_diminuiu_aumentou] [reducao_mortalinfantil0010]%,
            from [mortinfantil00] per thousand of live births in 2000 to [mortinfantil10] per thousand live births in 2010.
            According to the Millennium Development Goals of the United Nations, infant mortality in Brazil should be below 17.9 deaths per thousand in 2015.
            In 2010, the infant mortality rates in the state and the country were [mortinfantil10_Estado] and [mortinfantil10_Brasil] per thousand live births.";
    //ES
    protected $textoUdhES = "La mortalidad infantil (mortalidad de los niños de menos de un año) en [municipio] [mort1_diminuiu_aumentou] un [reducao_mortalinfantil0010]%,
            tras pasar de [mortinfantil00] por mil nacidos vivos en el 2000 a [mortinfantil10] por mil nacidos vivos en 2010.
            De acuerdo con los Objetivos de Desarrollo del Milenio de las Naciones Unidas, la mortalidad infantil de Brasil deberá ser inferior a 17,9 muertes por mil en 2015.
            En 2010, las tasas de mortalidad infantil del estado y del país eran de [mortinfantil10_Estado] y [mortinfantil10_Brasil] por mil nacidos vivos, respectivamente.";
    //Unidade de Desenvolvimento Humano2
    //PT2
    protected $texto2UdhPT = "A esperança de vida ao nascer é o indicador utilizado para compor a dimensão
             Longevidade do Índice de Desenvolvimento Humano Municipal (IDHM). Em 2010, enquanto na UDH
             a esperança de vida ao nascer é de [esp_nascer10] anos, no município ela é de [esp_nascer10_mun_udh]
             anos e, na região metropolitana, de [esp_nascer10_rm_udh] anos.";
    //EN2
    protected $texto2UdhEN = "The life expectancy at birth is the indicator that composes the Longevity dimension in the Human Development Index (HDI).
            In [municipio], life expectancy at birth increased by [aumento_esp_nascer0010] years in the last two decades, from [esp_nascer91] years in 1991 to [esp_nascer00] years in 2000,
            and to [esp_nascer10] years in 2010. In 2010, life expectancy at birth for the state average is [esp_nascer10_estado] years and for the country,
            [esp_nascer10_pais] years.";
    //ES2
    protected $texto2UdhES = "La esperanza de vida al nacer es el indicador usado para constituir el factor de longevidad del Índice de Desarrollo Humano (IDH).
            En [municipio], la esperanza de vida al nacer aumentó en [aumento_esp_nascer0010] años en las dos últimas décadas, tras pasar de [esp_nascer91] años en 1991 a [esp_nascer00] años en el 2000 y 
            [esp_nascer10] años en 2010. En 2010, la esperanza de vida al nacer promedio era de [esp_nascer10_estado]años en el estado y de 
            [esp_nascer10_pais] años a nivel nacional.";
    //Padrão
    protected $subtituloPT = "Longevidade, mortalidade e fecundidade";
    protected $subtituloEN = "Longevity, Mortality and Fertility";
    protected $subtituloES = "Longevidad, mortalidad y fecundidad";
    //Comparações
    protected $reduziuPT = "reduziu";
    protected $reduziuEN = "reduced";
    protected $reduziuES = "bajó";
    protected $aumentouPT = "aumentou";
    protected $aumentouEN = "increased";
    protected $aumentouES = "aumentó";
    //Tabela
    protected $captionPT = "Longevidade, Mortalidade e Fecundidade";
    protected $captionEN = "Longevity, Mortality and Fertility";
    protected $captionES = "Longevidad, mortalidad y fecundidad";
    
    public function getReduziu() {

        if ($this->lang == "pt")
            return $this->reduziuPT;
        else if ($this->lang == "en")
            return $this->reduziuEN;
        else if ($this->lang == "es")
            return $this->reduziuES;
    }

    public function getAumentou() {

        if ($this->lang == "pt")
            return $this->aumentouPT;
        else if ($this->lang == "en")
            return $this->aumentouEN;
        else if ($this->lang == "es")
            return $this->aumentouES;
    }
    
}

?>

<?php

/**
 * Construção da Evolução por Tipo e Idioma
 *
 * @author Andre Castro
 */
class ITEvolucao extends IT {

    //Municipio
    //PT
    protected $textoMunPT = "<b>Entre 2000 e 2010</b><br>
            O IDHM passou de [IDHM2000] em 2000 para [IDHM2010] em 2010 - uma taxa de crescimento de [Tx_crescimento_0010]%.
            O hiato de desenvolvimento humano, ou seja, a distância entre o IDHM do município e o limite máximo do índice, que é 1,
            foi [reduzido_aumentado] em [reducao_hiato_0010]% entre 2000 e 2010.<br><br>
            Nesse período, a dimensão cujo índice mais cresceu em termos absolutos foi [Dimensao2000a2010].<br><br>";
    protected $texto2MunPT = "<b>Entre 1991 e 2000</b><br>
            O IDHM passou de [IDHM1991] em 1991 para [IDHM2000] em 2000 - uma taxa de crescimento de [Tx_crescimento_9100]%.
            O hiato de desenvolvimento humano foi [reduzido_aumentado] em [reducao_hiato_9100]% entre 1991 e 2000.<br><br>            
            Nesse período, a dimensão cujo índice mais cresceu em termos absolutos foi [Dimensao1991a2000].<br><br>";
    protected $texto3MunPT = "<b>Entre 1991 e 2010</b><br>            
            De 1991 a 2010, o IDHM do município passou de [idhm_uf_91], em 1991, para [idhm_uf_10],
            em 2010, enquanto o IDHM da Unidade Federativa (UF) passou de [idhm_br_91] para [idhm_br_10].
            Isso implica em uma taxa de crescimento de [Tx_crescimento_9110]% para o município e
            [tx_cresc_Brasil9110]% para a UF; e em uma taxa de redução do hiato de desenvolvimento
            humano de [reducao_hiato_9110]% para o município e [reducao_hiato_brasil_9110]% para a UF.
            No município, a dimensão cujo índice mais cresceu em termos absolutos foi [Dimensao1991a2000].
            Na UF, por sua vez, a dimensão cujo índice mais cresceu em termos absolutos foi
            [Dimensao1991a2000_br].";
    //EN
    protected $textoMunEN = "<b>Between 2000 and 2010</b><br>
            The MHDI increased from [IDHM2000] in 2000 to [IDHM2010] in 2010 - growth rate being [Tx_crescimento_0010]%.
            The gap of human development, in other words, the distance between the MHDI of the municipality and the maximum index value of 1, was
            [reduzido_aumentado] em [reducao_hiato_0010]% between the years 2000 and 2010.<br><br>";
    protected $texto2MunEN = "<b>Between 1991 and 2000</b><br>
            The MHDI increased from [IDHM1991] in 1991 to [IDHM2000] in 2000 - the growth rate being [Tx_crescimento_9100]%.
            The human development gap, in other words, the distance between the MHDI of the municipality and the maximum index value of 1, was
            [reduzido_aumentado] by [reducao_hiato_9100]% between the years 1991 and 2000.<br><br>";
    protected $texto3MunEN = "<b>Between 1991 and 2010</b><br>
            The MHDI of [municipio] increased [Tx_crescimento_9110]% in the last two decades which was
            [abaixo_acima] the average national growth ([tx_cresc_Brasil9110]%) and [abaixo_acima_uf] the average state growth ([tx_cresc_Estado9110]%).
            The human development gap, in other words, the distance between the MHDI of the municipality and the maximum index (which is 1) was
            [reduzido_aumentado] by [reducao_hiato_9110]% between 1991 and 2010.";
    //ES
    protected $textoMunES = "<b>Entre el 2000 y 2010</b><br>
            El IDHM pasó de [IDHM2000] en el 2000 a [IDHM2010] en 2010 - un crecimiento de [Tx_crescimento_0010]%.
            La brecha de desarrollo humano, es decir, la distancia entre el IDHM del municipio y el límite máximo del índice, equivalente a 1,
            se [reduzido_aumentado] un [reducao_hiato_0010]% entre el 2000 y 2010.<br><br>";
    protected $texto2MunES = "<b>Entre 1991 y el 2000</b><br>
            El IDHM pasó de [IDHM1991] en el 1991 a [IDHM2000] en el 2000 - un crecimiento de [Tx_crescimento_9100]%.
            La brecha de desarrollo humano, es decir, la distancia entre el IDHM del municipio y el límite máximo del índice, equivalente a 1,
            se [reduzido_aumentado] un [reducao_hiato_9100]% entre 1991 y el 2000.<br><br>";
    protected $texto3MunES = "<b>Entre 1991 y 2010</b><br>
            El IDHM de [municipio] aumentó un [Tx_crescimento_9110]% en las dos últimas décadas,
            porcentaje [abaixo_acima] al crecimiento promedio nacional ([tx_cresc_Brasil9110]%) y [abaixo_acima_uf] al crecimiento promedio estadual ([tx_cresc_Estado9110]%).
            La brecha de desarrollo humano, es decir, la distancia entre el IDHM del municipio y el límite máximo del índice, equivalente a 1,
            se [reduzido_aumentado] un [reducao_hiato_9110]% entre 1991 y 2010.";
    //Região Metropolitana
    //PT
//    protected $textoRmPT = "<b>Entre 2000 e 2010</b><br>
//            O IDHM passou de [IDHM2000] em 2000 para [IDHM2010] em 2010 - uma taxa de crescimento de [Tx_crescimento_0010]%.
//            O hiato de desenvolvimento humano, ou seja, a distância entre o IDHM da RM e o limite máximo do índice, que é 1,
//            foi [reduzido_aumentado] em [reducao_hiato_0010]% entre 2000 e 2010.<br><br>
//            Nesse período, a dimensão cujo índice mais cresceu em termos absolutos foi [Dimensao2000a2010].<br><br>";
//    protected $texto2RmPT = "<b>Entre 1991 e 2000</b><br>
//            O IDH passou de [IDHM1991] em 1991 para [IDHM2000] em 2000 - uma taxa de crescimento de [Tx_crescimento_9100]%.
//            O hiato de desenvolvimento humano, ou seja, a distância entre o IDH da Região Metropolitana e o limite máximo do índice, que é 1,
//            foi [reduzido_aumentado] em [reducao_hiato_9100]% entre 1991 e 2000.<br><br>";
    protected $texto3RmPT = "<b>Entre 2000 e 2010</b><br>
            <br>
            De 2000 a 2010, o IDHM da RM passou de [idhm_uf_00], em 2000, para [idhm_uf_10], em 2010,
            enquanto o IDHM do Brasil passou de [idhm_br_00] para [idhm_br_10], respectivamente.
            Isso implica em uma taxa de crescimento de [Tx_crescimento_0010]% para a RM e
            [tx_cresc_Brasil0010]% para o país; e em uma taxa de redução do hiato de desenvolvimento humano de
            [reducao_hiato_0010]% para a RM e [reducao_hiato_brasil_0010]% para o Brasil.
            Na RM, a dimensão cujo índice mais cresceu em termos absolutos foi [Dimensao2000a2010].
            No Brasil, por sua vez, a dimensão cujo índice mais cresceu em termos absolutos foi
            [Dimensao2000a2010_br].";

//            De 1991 a 2010, o IDHM da RM passou de [idhm_uf_91], em 1991, para [idhm_uf_10],
//            em 2010, enquanto o IDHM do Brasil passou de [idhm_br_91] para [idhm_br_10], respectivamente.
//            Isso implica em uma taxa de crescimento de [Tx_crescimento_9110]% para a RM e
//            [tx_cresc_Brasil9110]% para o país; e em uma taxa de redução do hiato de desenvolvimento
//            humano de [reducao_hiato_9110]% para a RM e [reducao_hiato_brasil_9110]% para o Brasil.
//            Na RM, a dimensão cujo índice mais cresceu em termos absolutos foi [Dimensao1991a2000].
//            No Brasil, por sua vez, a dimensão cujo índice mais cresceu em termos absolutos foi
//            [Dimensao1991a2000_br].";
    //EN
    protected $textoRmEN = "<b>Between 2000 and 2010</b><br>
            The HDI increased from [IDHM2000] in 2000 to [IDHM2010] in 2010 - growth rate being [Tx_crescimento_0010]%.
            The gap of human development, in other words, the distance between the HDI of the Metropolitan Region and the maximum index value of 1, was
            [reduzido_aumentado] em [reducao_hiato_0010]% between the years 2000 and 2010.<br><br>";
    protected $texto2RmEN = "<b>Between 1991 and 2000</b><br>
            The HDI increased from [IDHM1991] in 1991 to [IDHM2000] in 2000 - the growth rate being [Tx_crescimento_9100]%.
            The human development gap, in other words, the distance between the HDI of the Metropolitan Region and the maximum index value of 1, was
            [reduzido_aumentado] by [reducao_hiato_9100]% between the years 1991 and 2000.<br><br>";
    protected $texto3RmEN = "<b>Between 1991 and 2010</b><br>
            The HDI of [municipio] increased [Tx_crescimento_9110]% in the last two decades which was
            [abaixo_acima] the average national growth ([tx_cresc_Brasil9110]%).
            The human development gap, in other words, the distance between the HDI of the Metropolitan Region and the maximum index (which is 1) was
            [reduzido_aumentado] by [reducao_hiato_9110]% between 1991 and 2010.";
    //ES
    protected $textoRmES = "<b>Entre el 2000 y 2010</b><br>
            El IDH pasó de [IDHM2000] en el 2000 a [IDHM2010] en 2010 - un crecimiento de [Tx_crescimento_0010]%.
            La brecha de desarrollo humano, es decir, la distancia entre el IDH del Región Metropolitana y el límite máximo del índice, equivalente a 1,
            se [reduzido_aumentado] un [reducao_hiato_0010]% entre el 2000 y 2010.<br><br>";
    protected $texto2RmES = "<b>Entre 1991 y el 2000</b><br>
            El IDH pasó de [IDHM1991] en el 1991 a [IDHM2000] en el 2000 - un crecimiento de [Tx_crescimento_9100]%.
            La brecha de desarrollo humano, es decir, la distancia entre el IDM del Región Metropolitana y el límite máximo del índice, equivalente a 1,
            se [reduzido_aumentado] un [reducao_hiato_9100]% entre 1991 y el 2000.<br><br>";
    protected $texto3RmES = "<b>Entre 1991 y 2010</b><br>
            El IDH da [municipio] aumentó un [Tx_crescimento_9110]% en las dos últimas décadas,
            porcentaje [abaixo_acima] al crecimiento promedio nacional ([tx_cresc_Brasil9110]%).
            La brecha de desarrollo humano, es decir, la distancia entre el IDH del Región Metropolitana y el límite máximo del índice, equivalente a 1,
            se [reduzido_aumentado] un [reducao_hiato_9110]% entre 1991 y 2010.";
    //Estado
    //PT
    protected $textoUfPT = "        
            <b>Entre 2000 e 2010</b><br>
            O IDHM passou de [IDHM2000] em 2000 para [IDHM2010] em 2010 - uma taxa de crescimento de [Tx_crescimento_0010]%.
            O hiato de desenvolvimento humano, ou seja, a distância entre o IDHM da UF e o limite máximo do índice, que é 1,
            foi [reduzido_aumentado] em [reducao_hiato_0010]% entre 2000 e 2010.
            Nesse período, a dimensão cujo índice mais cresceu em termos absolutos foi [Dimensao2000a2010].<br><br>";
    protected $texto2UfPT = "<b>Entre 1991 e 2000</b><br>
            O IDHM passou de [IDHM1991] em 1991 para [IDHM2000] em 2000 - uma taxa de crescimento de [Tx_crescimento_9100]%.
            O hiato de desenvolvimento humano foi [reduzido_aumentado] em [reducao_hiato_9100]% entre 1991 e 2000.            
            Nesse período, a dimensão cujo índice mais cresceu em termos absolutos foi [Dimensao1991a2000].<br><br>";
    protected $texto3UfPT = "<b>Entre 1991 e 2010</b><br>            
            De 1991 a 2010, o IDHM da UF passou de [idhm_uf_91], em 1991, para [idhm_uf_10],
            em 2010, enquanto o IDHM do Brasil passou de [idhm_br_91] para [idhm_br_10], respectivamente.
            Isso implica em uma taxa de crescimento de [Tx_crescimento_9110]% para a UF e
            [tx_cresc_Brasil9110]% para o país; e em uma taxa de redução do hiato de desenvolvimento
            humano de [reducao_hiato_9110]% para a UF e [reducao_hiato_brasil_9110]% para o Brasil.
            Na UF, a dimensão cujo índice mais cresceu em termos absolutos foi [Dimensao1991a2000].
            No Brasil, por sua vez, a dimensão cujo índice mais cresceu em termos absolutos foi
            [Dimensao1991a2000_br].";
//            De 1991 a 2010, o IDHM da UF passou de 
//            [municipio] teve um incremento no seu IDHM de [Tx_crescimento_9110]% nas últimas duas décadas,
//            [abaixo_acima] média de crescimento nacional ([tx_cresc_Brasil9110]%).
//            O hiato de desenvolvimento humano, ou seja, a distância entre o IDHM do estado e o limite máximo do índice, que é 1,
//            foi [reduzido_aumentado] em [reducao_hiato_9110]% entre 1991 e 2010.";
    //EN		
    protected $textoUfEN = "<b>Between 2000 and 2010</b><br>
            The HDI increased from [IDHM2000] in 2000 to [IDHM2010] in 2010 - growth rate being [Tx_crescimento_0010]%.
            The gap of human development, in other words, the distance between the HDI of the state and the maximum index value of 1, was
            [reduzido_aumentado] em [reducao_hiato_0010]% between the years 2000 and 2010.<br><br>";
    protected $texto2UfEN = "<b>Between 1991 and 2000</b><br>
            The HDI increased from [IDHM1991] in 1991 to [IDHM2000] in 2000 - the growth rate being [Tx_crescimento_9100]%.
            The human development gap, in other words, the distance between the HDI of the state and the maximum index value of 1, was
            [reduzido_aumentado] by [reducao_hiato_9100]% between the years 1991 and 2000.<br><br>";
    protected $texto3UfEN = "<b>Between 1991 and 2010</b><br>
            The HDI of [municipio] increased [Tx_crescimento_9110]% in the last two decades which was
            [abaixo_acima] the average national growth ([tx_cresc_Brasil9110]%).
            The human development gap, in other words, the distance between the HDI of the state and the maximum index (which is 1) was
            [reduzido_aumentado] by [reducao_hiato_9110]% between 1991 and 2010.";
    //ES
    protected $textoUfES = "<b>Entre el 2000 y 2010</b><br>
            El IDH pasó de [IDHM2000] en el 2000 a [IDHM2010] en 2010 - un crecimiento de [Tx_crescimento_0010]%.
            La brecha de desarrollo humano, es decir, la distancia entre el IDH del estado y el límite máximo del índice, equivalente a 1,
            se [reduzido_aumentado] un [reducao_hiato_0010]% entre el 2000 y 2010.<br><br>";
    protected $texto2UfES = "<b>Entre 1991 y el 2000</b><br>
            El IDH pasó de [IDHM1991] en el 1991 a [IDHM2000] en el 2000 - un crecimiento de [Tx_crescimento_9100]%.
            La brecha de desarrollo humano, es decir, la distancia entre el IDM del estado y el límite máximo del índice, equivalente a 1,
            se [reduzido_aumentado] un [reducao_hiato_9100]% entre 1991 y el 2000.<br><br>";
    protected $textoU3fES = "<b>Entre 1991 y 2010</b><br>
            El IDH da [municipio] aumentó un [Tx_crescimento_9110]% en las dos últimas décadas,
            porcentaje [abaixo_acima] al crecimiento promedio nacional ([tx_cresc_Brasil9110]%).
            La brecha de desarrollo humano, es decir, la distancia entre el IDH del estado y el límite máximo del índice, equivalente a 1,
            se [reduzido_aumentado] un [reducao_hiato_9110]% entre 1991 y 2010.";
    //Unidade de Desenvolvimento Humano
    //PT
    protected $textoUdhPT = "<b>Entre 2000 e 2010</b><br>
            O IDH passou de [IDHM2000] em 2000 para [IDHM2010] em 2010 - uma taxa de crescimento de [Tx_crescimento_0010]%.
            O hiato de desenvolvimento humano, ou seja, a distância entre o IDH da Unidade de Desenvolvimento Humano e o limite máximo do índice, que é 1,
            foi [reduzido_aumentado] em [reducao_hiato_0010]% entre 2000 e 2010.<br><br>";
    protected $texto2UdhPT = "<b>Entre 1991 e 2000</b><br>
            O IDH passou de [IDHM1991] em 1991 para [IDHM2000] em 2000 - uma taxa de crescimento de [Tx_crescimento_9100]%.
            O hiato de desenvolvimento humano, ou seja, a distância entre o IDH da Unidade de Desenvolvimento Humano e o limite máximo do índice, que é 1,
            foi [reduzido_aumentado] em [reducao_hiato_9100]% entre 1991 e 2000.<br><br>";
    protected $texto3UdhPT = "<b>Entre 1991 e 2010</b><br>
            [municipio] teve um incremento no seu IDH de [Tx_crescimento_9110]% nas últimas duas décadas,
            [abaixo_acima] média de crescimento nacional ([tx_cresc_Brasil9110]%) e [abaixo_acima_uf] média de crescimento regional ([tx_cresc_Estado9110]%).
            O hiato de desenvolvimento humano, ou seja, a distância entre o IDH da Unidade de Desenvolvimento Humano e o limite máximo do índice, que é 1,
            foi [reduzido_aumentado] em [reducao_hiato_9110]% entre 1991 e 2010.";
    //EN
    protected $textoUdhEN = "<b>Between 2000 and 2010</b><br>
            The HDI increased from [IDHM2000] in 2000 to [IDHM2010] in 2010 - growth rate being [Tx_crescimento_0010]%.
            The gap of human development, in other words, the distance between the HDI of the Unit of Human Development and the maximum index value of 1, was
            [reduzido_aumentado] em [reducao_hiato_0010]% between the years 2000 and 2010.<br><br>";
    protected $texto2UdhEN = "<b>Between 1991 and 2000</b><br>
            The HDI increased from [IDHM1991] in 1991 to [IDHM2000] in 2000 - the growth rate being [Tx_crescimento_9100]%.
            The human development gap, in other words, the distance between the HDI of the Unit of Human Development and the maximum index value of 1, was
            [reduzido_aumentado] by [reducao_hiato_9100]% between the years 1991 and 2000.<br><br>";
    protected $texto3UdhEN = "<b>Between 1991 and 2010</b><br>
            The HDI of [municipio] increased [Tx_crescimento_9110]% in the last two decades which was
            [abaixo_acima] the average national growth ([tx_cresc_Brasil9110]%) and [abaixo_acima_uf] the average region growth ([tx_cresc_Estado9110]%).
            The human development gap, in other words, the distance between the HDI of the Unit of Human Development and the maximum index (which is 1) was
            [reduzido_aumentado] by [reducao_hiato_9110]% between 1991 and 2010.";
    //ES
    protected $textoUdhES = "<b>Entre el 2000 y 2010</b><br>
            El IDH pasó de [IDHM2000] en el 2000 a [IDHM2010] en 2010 - un crecimiento de [Tx_crescimento_0010]%.
            La brecha de desarrollo humano, es decir, la distancia entre el IDH del Unidad de Desarrollo Humano y el límite máximo del índice, equivalente a 1,
            se [reduzido_aumentado] un [reducao_hiato_0010]% entre el 2000 y 2010.<br><br>";
    protected $texto2UdhES = "<b>Entre 1991 y el 2000</b><br>
            El IDH pasó de [IDHM1991] en el 1991 a [IDHM2000] en el 2000 - un crecimiento de [Tx_crescimento_9100]%.
            La brecha de desarrollo humano, es decir, la distancia entre el IDM del Unidad de Desarrollo Humano y el límite máximo del índice, equivalente a 1,
            se [reduzido_aumentado] un [reducao_hiato_9100]% entre 1991 y el 2000.<br><br>";
    protected $texto3UdhES = "<b>Entre 1991 y 2010</b><br>
            El IDH da [municipio] aumentó un [Tx_crescimento_9110]% en las dos últimas décadas,
            porcentaje [abaixo_acima] al crecimiento promedio nacional ([tx_cresc_Brasil9110]%) y [abaixo_acima_uf] al crecimiento promedio regional ([tx_cresc_Estado9110]%).
            La brecha de desarrollo humano, es decir, la distancia entre el IDH del Unidad de Desarrollo Humano y el límite máximo del índice, equivalente a 1,
            se [reduzido_aumentado] un [reducao_hiato_9110]% entre 1991 y 2010.";
    //Subtitulos
    protected $subtituloPT = "Evolução";
    protected $subtituloEN = "Evolution";
    protected $subtituloES = "Evolución";
    //Comparações
    protected $reduzidoPT = "reduzido";
    protected $reduzidoEN = "reduced";
    protected $reduzidoES = "redujo";
    protected $aumentadoPT = "aumentado";
    protected $aumentadoEN = "increased";
    protected $aumentadoES = "creció";
    protected $abaixoPT = "abaixo da";
    protected $abaixoEN = "below";
    protected $abaixoES = "disminuyó";
    protected $acimaPT = "acima da";
    protected $acimaEN = "above";
    protected $acimaES = "aumentó";
    protected $igualPT = "igual à";
    protected $igualEN = "equal to";
    protected $igualES = "igual";
    //Tabela
    protected $tituloTable1PT = "Taxa de Crescimento";
    protected $tituloTable2PT = "Hiato de Desenvolvimento";
    protected $tituloTable1EN = "Growth rate";
    protected $tituloTable2EN = "Development gap";
    protected $tituloTable1ES = "Tasa de crecimiento";
    protected $tituloTable2ES = "Brecha de desarrollo";
    protected $Entre9100PT = "Entre 1991 e 2000";
    protected $Entre0010PT = "Entre 2000 e 2010";
    protected $Entre9110PT = "Entre 1991 e 2010";
    protected $Entre9100EN = "Between 1991 and 2000";
    protected $Entre0010EN = "Between 2000 and 2010";
    protected $Entre9110EN = "Between 1991 and 2010";
    protected $Entre9100ES = "Entre 1991 y el 2000";
    protected $Entre0010ES = "Entre el 2000 y 2010";
    protected $Entre9110ES = "Entre 1991 y 2010";

    public function getReduzido() {

        if ($this->lang == "pt")
            return $this->reduzidoPT;
        else if ($this->lang == "en")
            return $this->reduzidoEN;
        else if ($this->lang == "es")
            return $this->reduzidoES;
    }

    public function getAumentado() {

        if ($this->lang == "pt")
            return $this->aumentadoPT;
        else if ($this->lang == "en")
            return $this->aumentadoEN;
        else if ($this->lang == "es")
            return $this->aumentadoES;
    }

    public function getAbaixo() {

        if ($this->lang == "pt")
            return $this->abaixoPT;
        else if ($this->lang == "en")
            return $this->abaixoEN;
        else if ($this->lang == "es")
            return $this->abaixoES;
    }

    public function getAcima() {

        if ($this->lang == "pt")
            return $this->acimaPT;
        else if ($this->lang == "en")
            return $this->acimaEN;
        else if ($this->lang == "es")
            return $this->acimaES;
    }

    public function getIgual() {

        if ($this->lang == "pt")
            return $this->igualPT;
        else if ($this->lang == "en")
            return $this->igualEN;
        else if ($this->lang == "es")
            return $this->igualES;
    }

    public function getTituloTable1() {

        if ($this->lang == "pt")
            return $this->tituloTable1PT;
        else if ($this->lang == "en")
            return $this->tituloTable1EN;
        else if ($this->lang == "es")
            return $this->tituloTable1ES;
    }

    public function getTituloTable2() {

        if ($this->lang == "pt")
            return $this->tituloTable2PT;
        else if ($this->lang == "en")
            return $this->tituloTable2EN;
        else if ($this->lang == "es")
            return $this->tituloTable2ES;
    }

    public function getEntre9100() {

        if ($this->lang == "pt")
            return $this->Entre9100PT;
        else if ($this->lang == "en")
            return $this->Entre9100EN;
        else if ($this->lang == "es")
            return $this->Entre9100ES;
    }

    public function getEntre0010() {

        if ($this->lang == "pt")
            return $this->Entre0010PT;
        else if ($this->lang == "en")
            return $this->Entre0010EN;
        else if ($this->lang == "es")
            return $this->Entre0010ES;
    }

    public function getEntre9110() {

        if ($this->lang == "pt")
            return $this->Entre9110PT;
        else if ($this->lang == "en")
            return $this->Entre9110EN;
        else if ($this->lang == "es")
            return $this->Entre9110ES;
    }

    function getChartEvolucao($id) {

        //$chart = new FunctionsChart($this->type);

        $idhm_max_min_ano = json_encode($this->chart->getIDHMaiorMenorAno());
        $idhm_mun = json_encode($this->chart->getIDHEvolucao($id));
        $idhm_media_brasil = json_encode($this->chart->getIDHMediaBrasil());

        if ($this->type == "perfil_udh")
            $idhm_uf_rm = json_encode($this->chart->getIDHRM($id));
        else
            $idhm_uf_rm = json_encode($this->chart->getIDHEstado($id));

        echo "<script language='javascript' type='text/javascript'>
                graficoEvolucaoIDHM('" . $this->lang . "','" . $this->type . "');</script>";

        return "<div id='chartEvolucao' style='width: 100%; height: 510px;'>            
                    <input id='idhm_mun' type='hidden' value=' " . $idhm_mun . "' /> 
                    <input id='idhm_max_min_ano' type='hidden' value='" . $idhm_max_min_ano . "' />
                    <input id='idhm_media_brasil' type='hidden' value='" . $idhm_media_brasil . "' /> 
                    <input id='idhm_estado' type='hidden' value='" . $idhm_uf_rm . "' />  
                 </div>";
    }

}

?>

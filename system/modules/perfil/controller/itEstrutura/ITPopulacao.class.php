<?php

/**
 * Construção do Componente por Tipo e Idioma
 *
 * @author Andre Castro
 */
class ITPopulacao extends IT {

    //Municipio
    //PT
    protected $textoMunPT = "
           Entre 2000 e 2010, a população de [municipio] cresceu a uma taxa média anual de [tx_cres_pop_0010]%,
           enquanto no Brasil foi de [tx_cresc_pop_pais_0010]%, no mesmo período.
           Nesta década, a taxa de urbanização
           do município passou de [tx_urbanizacao_00]% para [tx_urbanizacao_10]%.
           Em 2010 viviam, no município, [pesotot_10] pessoas.<br><br>
           Entre 1991 e 2000, a população do município cresceu a uma taxa média anual de [tx_cres_pop_9100]%.
           Na UF, esta taxa foi de [tx_cresc_pop_estado_9100]%, enquanto no Brasil foi de [tx_cresc_pop_pais_9100]%, no mesmo período.
           Na década, a taxa de urbanização
           do município passou de [tx_urbanizacao_91]% para [tx_urbanizacao_00]%.";
    
//    Entre 2000 e 2010, a população de [municipio] cresceu a uma taxa média anual de [tx_cres_pop_0010]%.
//           Na UF, esta taxa foi de [tx_cresc_pop_estado_0010]%, enquanto no Brasil foi de [tx_cresc_pop_pais_0010]%, no mesmo período.
//           Nesta década, a taxa de urbanização
//           do município passou de [tx_urbanizacao_00]% para [tx_urbanizacao_10]%.
//           Em 2010, viviam, no município [pesotot_10] pessoas.<br><br>
//           Entre 1991 e 2000, a população do município cresceu a uma taxa média anual de [tx_cres_pop_9100]%.
//           Na UF, esta taxa foi de [tx_cresc_pop_estado_9100]%, enquanto no Brasil foi de [tx_cresc_pop_pais_9100]%, no mesmo período.
//           Na década, a taxa de urbanização
//           do município passou de [tx_urbanizacao_91]% para [tx_urbanizacao_00]%.
    //EN
    protected $textoMunEN = "Between 2000 and 2010, the population of [municipio] had an average annual growth of
            [tx_cres_pop_0010]%. In the previous decade, 1991-2000, the average annual growth rate was
            [tx_cres_pop_9100]%. At the state level, these rates were [tx_cresc_pop_estado_0010]% between 2000 and 2010 and 
            [tx_cresc_pop_estado_9100]% between 1991 and 2000. In the country, they were [tx_cresc_pop_pais_0010]%
            between 2000 and 2010 and [tx_cresc_pop_pais_9100]% between 1991 and 2000.
            In the last two decades, the urbanization rate increased by [tx_urbanizacao]%.";
    //ES
    protected $textoMunES = "Entre el 2000 y 2010, la población de [municipio] registró una tasa de crecimiento anual promedio de [tx_cres_pop_0010]%.
            En la década anterior, de 1991 al 2000, la tasa de crecimiento anual promedio fue de 
            [tx_cres_pop_9100]%. En el estado, estas tasas se situaron en un [tx_cresc_pop_estado_0010]% entre el 2000 y 2010 y un 
            [tx_cresc_pop_estado_9100]% entre 1991 y el 2000.
            A nivel nacional, se situaron en un [tx_cresc_pop_pais_0010]% entre el 2000 y 2010 y en un 
            [tx_cresc_pop_pais_9100]% entre 1991 y el 2000.
            En las dos últimas décadas, la tasa de urbanización creció un [tx_urbanizacao]%.";
    //Região Metropolitana
    //PT
    protected $textoRmPT = "
           Entre 2000 e 2010, a população de [municipio] cresceu a uma taxa média anual de [tx_cres_pop_0010]%.
           No Brasil, esta taxa foi de [tx_cresc_pop_pais_0010]% no mesmo período. Nesta década, a taxa de urbanização
           da RM passou de [tx_urbanizacao_00]% para [tx_urbanizacao_10]%.
           No Brasil, esta taxa passou de [tx_urbanizacao_00_br]% para [tx_urbanizacao_10_br]% no mesmo período.  
           Em 2010 viviam, na RM, [pesotot_10] pessoas.";
    //EN
    protected $textoRmEN = "Between 2000 and 2010, the population of [municipio] had an average annual growth of
            [tx_cres_pop_0010]%. In the previous decade, 1991-2000, the average annual growth rate was
            [tx_cres_pop_9100]%. At the country level, these rates were [tx_cresc_pop_pais_0010]%
            between 2000 and 2010 and [tx_cresc_pop_pais_9100]% between 1991 and 2000.
            In the last two decades, the urbanization rate increased by [tx_urbanizacao]%.";
    //ES
    protected $textoRmES = "Entre el 2000 y 2010, la población de la [municipio] registró una tasa de crecimiento anual promedio de [tx_cres_pop_0010]%.
            En la década anterior, de 1991 al 2000, la tasa de crecimiento anual promedio fue de 
            [tx_cres_pop_9100]%. A nivel nacional, se situaron en un [tx_cresc_pop_pais_0010]% entre el 2000 y 2010 y en un 
            [tx_cresc_pop_pais_9100]% entre 1991 y el 2000.
            En las dos últimas décadas, la tasa de urbanización creció un [tx_urbanizacao]%.";
    //Estado
    //PT
    protected $textoUfPT = "
           Entre 2000 e 2010, a população de [municipio] cresceu a uma taxa média anual de [tx_cres_pop_0010]%.
           No Brasil, esta taxa foi de [tx_cresc_pop_pais_0010]% no mesmo período. Nesta década, a taxa de urbanização
           da UF passou de [tx_urbanizacao_00]% para [tx_urbanizacao_10]%.
           Em 2010 viviam, na UF, [pesotot_10] pessoas.<br><br>
           Entre 1991 e 2000, a população da UF cresceu a uma taxa média anual de [tx_cres_pop_9100]%.
           No Brasil, esta taxa foi de [tx_cresc_pop_pais_9100]% no mesmo período. Na década, a taxa de urbanização
           da UF passou de [tx_urbanizacao_91]% para [tx_urbanizacao_00]%.";


//            Entre 2000 e 2010, a população de [municipio] teve uma taxa média de crescimento anual
//            de [tx_cres_pop_0010]%. Na década anterior, de 1991 a 2000, a taxa média de crescimento anual
//            foi de [tx_cres_pop_9100]%. No país, as taxas foram de [tx_cresc_pop_pais_0010]% entre 2000 e 2010 e [tx_cresc_pop_pais_9100]% entre 1991 e 2000.
//            Nas últimas duas décadas, a taxa de urbanização cresceu [tx_urbanizacao]%.";
    //EN
    protected $textoUfEN = "Between 2000 and 2010, the population of [municipio] had an average annual growth of
            [tx_cres_pop_0010]%. In the previous decade, 1991-2000, the average annual growth rate was
            [tx_cres_pop_9100]%. At the country level, these rates were [tx_cresc_pop_pais_0010]%
            between 2000 and 2010 and [tx_cresc_pop_pais_9100]% between 1991 and 2000.
            In the last two decades, the urbanization rate increased by [tx_urbanizacao]%.";
    //ES
    protected $textoUfES = "Entre el 2000 y 2010, la población de [municipio] registró una tasa de crecimiento anual promedio de [tx_cres_pop_0010]%.
            En la década anterior, de 1991 al 2000, la tasa de crecimiento anual promedio fue de 
            [tx_cres_pop_9100]%. A nivel nacional, se situaron en un [tx_cresc_pop_pais_0010]% entre el 2000 y 2010 y en un 
            [tx_cresc_pop_pais_9100]% entre 1991 y el 2000.
            En las dos últimas décadas, la tasa de urbanización creció un [tx_urbanizacao]%.";
    //Unidade de Desenvolvimento Humano
    //PT
    protected $textoUdhPT = "Entre 2000 e 2010, a população da UDH cresceu a uma taxa média anual de [tx_cres_pop_0010]%.
                No município onde ela está situada, essa taxa foi de [tx_cres_pop_0010_mun_udh]% e na região metropolitana,
                de [tx_cres_pop_0010_rm_udh]%. Já no país, a taxa ficou em [tx_cresc_pop_pais_0010]% no mesmo período. 
                Em 2010 viviam, na UDH, [pesotot_10] pessoas.";
    //EN
    protected $textoUdhEN = "Between 2000 and 2010, the population of [municipio] had an average annual growth of
            [tx_cres_pop_0010]%. In the previous decade, 1991-2000, the average annual growth rate was
            [tx_cres_pop_9100]%. At the state level, these rates were [tx_cresc_pop_estado_0010]% between 2000 and 2010 and 
            [tx_cresc_pop_estado_9100]% between 1991 and 2000. In the country, they were [tx_cresc_pop_pais_0010]%
            between 2000 and 2010 and [tx_cresc_pop_pais_9100]% between 1991 and 2000.
            In the last two decades, the urbanization rate increased by [tx_urbanizacao]%.";
    //ES
    protected $textoUdhES = "Entre el 2000 y 2010, la población de [municipio] registró una tasa de crecimiento anual promedio de [tx_cres_pop_0010]%.
            En la década anterior, de 1991 al 2000, la tasa de crecimiento anual promedio fue de 
            [tx_cres_pop_9100]%. En el estado, estas tasas se situaron en un [tx_cresc_pop_estado_0010]% entre el 2000 y 2010 y un 
            [tx_cresc_pop_estado_9100]% entre 1991 y el 2000.
            A nivel nacional, se situaron en un [tx_cresc_pop_pais_0010]% entre el 2000 y 2010 y en un 
            [tx_cresc_pop_pais_9100]% entre 1991 y el 2000.
            En las dos últimas décadas, la tasa de urbanización creció un [tx_urbanizacao]%.";
    //Padrão
    protected $tituloPT = "Demografia e Saúde";
    protected $subtituloPT = "População";
    protected $tituloEN = "Demography and health";
    protected $subtituloEN = "Population";
    protected $tituloES = "Demografía y salud";
    protected $subtituloES = "Población";
    //Tabela
    protected $tituloTablePT = "População";
    protected $captionPT = "População Total, por Gênero, Rural/Urbana"; //e Taxa de Urbanização";
    protected $captionUdhPT = "População Total e por Gênero"; //e Taxa de Urbanização";
    
    protected $tituloTableEN = "Population";
    protected $captionEN = "Total Population by Gender, Rural / Urban and Urbanization rate";
    protected $tituloTableES = "Población";
    protected $captionES = "Población total, por género, rural/urbana y tasa de urbanización";
    //Colunas
    protected $coluna1PT = "População";
    protected $coluna2PT = "% do Total";
    protected $coluna1EN = "Population";
    protected $coluna2EN = "% of total";
    protected $coluna1ES = "Población";
    protected $coluna2ES = "% del total";
    
    protected $taxaUrbanizacaoPT = "Taxa de Urbanização";
    protected $taxaUrbanizacaoEN = "Urbanization Rate";
    protected $taxaUrbanizacaoES = "Tasa de urbanización";
    
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
    
    public function getTaxaUrbanizacao() {

        if ($this->lang == "pt")
            return $this->taxaUrbanizacaoPT;
        else if ($this->lang == "en")
            return $this->taxaUrbanizacaoEN;
        else if ($this->lang == "es")
            return $this->taxaUrbanizacaoES;
    }
    
    //#Sobreescrevendo
    public function getCaption() {

        if ($this->type == "perfil_udh") {
            
            if ($this->lang == "pt")
                return $this->captionUdhPT;
            else if ($this->lang == "en")
                return $this->captionUdhEN;
            else if ($this->lang == "es")
                return $this->captionUdhES;
            
        }else {

            if ($this->lang == "pt")
                return $this->captionPT;
            else if ($this->lang == "en")
                return $this->captionEN;
            else if ($this->lang == "es")
                return $this->captionES;
            
        }
    }

}

?>

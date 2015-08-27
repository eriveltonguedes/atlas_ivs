<?php

require_once BASE_ROOT . 'config/config_path.php';
require_once PERFIL_PACKAGE . 'controller/Texto.class.php';
require_once BASE_ROOT . 'config/config_gerais.php';
require_once PERFIL_PACKAGE . 'model/bd.class.php';
require_once PERFIL_PACKAGE . 'controller/chart/chartsPerfil.php';
require_once PERFIL_PACKAGE . 'controller/Formulas.class.php';

//define("PATH_DIRETORIO", $path_dir);
/**
 * Description of GerenateTexts
 *
 * @author Andre Castro
 */

class TextBuilder_ES {

    static public $idMunicipio = 0;
    static public $nomeMunicipio = "";
    static public $ufMunicipio = "";
    static public $bd;    
    static public $print;
    static public $lang = "es";
    
    //Variável de configuração da Fonte de Dados do perfil
    static public $fontePerfil = "Fuente: PNUD, Ipea y FJP"; //@#Menos template 5

    static public function generateIDH_componente($block_componente) {

        if (TextBuilder_ES::$print){ 
            $block_componente->setData("quebra", "<div style='page-break-after: always'></div>");
        }else
            $block_componente->setData("quebra", "");
        
        $block_componente->setData("fonte", TextBuilder_ES::$fontePerfil);
        $block_componente->setData("titulo", "IDHM"); //@Translate
        $block_componente->setData("subtitulo", "Componentes"); //@Translate
        $block_componente->setData("canvasContent", getChartDesenvolvimentoHumano(TextBuilder_ES::$idMunicipio, TextBuilder_ES::$lang));        
        $block_componente->setData("info", "");

        $idhm = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "IDHM"); //IDHM
        $idhm_r = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "IDHM_R"); //IDHM_R
        $idhm_l = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "IDHM_L"); //IDHM_L
        $idhm_e = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "IDHM_E"); //IDHM_E
        
        //@Translate
        $str = "El Índice de Desarrollo Humano Municipal (IDHM) de [municipio] es de [idh] para [2010].
            El municipio tiene un nivel de desarrollo humano [Faixa_DH].            
            Entre el 2000 y 2010, el factor que más se incrementó en términos absolutos fue [Dimensao2000a2010].                        
            Entre 1991 y el 2000, el factor que más se incrementó en términos absolutos fue [Dimensao1991a2000].
            ";

        $texto = new Texto($str);
        $texto->replaceTags("2010", Formulas::getLabelAno2010($idhm));
        $texto->replaceTags("municipio", TextBuilder_ES::$nomeMunicipio);
        $texto->replaceTags("idh", Formulas::getIDH2010($idhm));
        
        $texto->replaceTags("Faixa_DH", Formulas::getSituacaoIDH($idhm, TextBuilder_ES::$lang));

        $texto->replaceTags("Dimensao2000a2010", Formulas::getDimensao(TextBuilder_ES::$lang, $idhm_r, $idhm_l, $idhm_e, array("faixa0010" => true, "faixa9100" => false)));
        $texto->replaceTags("Dimensao1991a2000", Formulas::getDimensao(TextBuilder_ES::$lang, $idhm_r, $idhm_l, $idhm_e, array("faixa0010" => false, "faixa9100" => true)));

        $block_componente->setData("text", $texto->getTexto());
    }

    static public function generateIDH_table_componente($block_table_componente) {

        $variaveis = array();

        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "IDHM_E")); //IDHM Educação
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_FUND18M")); //"% de 18 ou mais anos com fundamental completo"
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_FREQ5A6")); //% de 5 a 6 anos na escola
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_FUND11A13")); //% de 12 a 14 anos nos anos finais do fundamental
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_FUND15A17")); //% de 16 a 18 anos com fundamental completo
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_MED18A20")); //% de 19 a 21 anos com médio completo
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "IDHM_L")); //IDHM Longevidade
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "ESPVIDA")); //Esperança de vida ao nascer
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "IDHM_R")); //IDHM Renda
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "RDPC")); //Renda per capita

        $block_table_componente->setData("titulo", "IDHM y componentes");//@Translate
        $block_table_componente->setData("caption", "Índice de Desarrollo Humano Municipal y sus componentes");//@Translate
        $block_table_componente->setData("fonte", TextBuilder_ES::$fontePerfil);        
        $block_table_componente->setData("municipio", TextBuilder_ES::$nomeMunicipio . " - " . TextBuilder_ES::$ufMunicipio);

        Formulas::printTableComponente($block_table_componente, $variaveis);
    }

    static public function generateIDH_evolucao($block_evolucao) {

        $idhm = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "IDHM"); //IDHM
        $idhm_uf = TextBuilder_ES::getVariaveis_Uf(TextBuilder_ES::$idMunicipio, "IDHM"); //IDHM do Estado
        $idhm_brasil = TextBuilder_ES::getVariaveis_Brasil(TextBuilder_ES::$idMunicipio, "IDHM"); //IDHM do Brasil

        $block_evolucao->setData("subtitulo", "Evolución");//@Translate
        $block_evolucao->setData("fonte", TextBuilder_ES::$fontePerfil);
        //----------------------------------------------------------------------------------------
        //Evolução entre os anos de 2000 e 2010
        $block_evolucao->setData("info1", "");
        
        //@Translate
        $str1 = "<b>Entre el 2000 y 2010</b><br>
            El IDHM pasó de [IDHM2000] en el 2000 a [IDHM2010] en 2010 - un crecimiento de [Tx_crescimento_0010]%.
            La brecha de desarrollo humano, es decir, la distancia entre el IDHM del municipio y el límite máximo del índice, equivalente a 1,
            se [reduzido_aumentado] un [reducao_hiato_0010]% entre el 2000 y 2010.<br><br>";
        $texto1 = new Texto($str1);
        $texto1->replaceTags("municipio", TextBuilder_ES::$nomeMunicipio);

        $texto1->replaceTags("IDHM2000", Formulas::getIDH2000($idhm));
        $texto1->replaceTags("IDHM2010", Formulas::getIDH2010($idhm));
        $texto1->replaceTags("Tx_crescimento_0010", Formulas::getTaxaCrescimento0010($idhm));

        //Cálculo do HIATO
        //$reducao_hiato_0010 = (($idhm[2]["valor"] - $idhm[1]["valor"]) / (1 - $idhm[1]["valor"])) * 100;
        $texto1->replaceTags("reducao_hiato_0010", Formulas::getReducaoHiato0010($idhm));

        if (Formulas::getReducaoHiato0010puro($idhm) >= 0)
            $texto1->replaceTags("reduzido_aumentado", "redujo");//@Translate
        else
            $texto1->replaceTags("reduzido_aumentado", "creció");//@Translate

        $block_evolucao->setData("text1", $texto1->getTexto());

        //----------------------------------------------------------------------------------------
        //Evolução entre os anos de 1991 e 2000
        $block_evolucao->setData("info2", "");
        
        //@Translate
        $str2 = "<b>Entre 1991 y el 2000</b><br>
            El IDHM pasó de [IDHM1991] en el 1991 a [IDHM2000] en el 2000 - un crecimiento de [Tx_crescimento_9100]%.
            La brecha de desarrollo humano, es decir, la distancia entre el IDHM del municipio y el límite máximo del índice, equivalente a 1,
            se [reduzido_aumentado] un [reducao_hiato_9100]% entre 1991 y el 2000.<br><br>";
        
        $texto2 = new Texto($str2);
        $texto2->replaceTags("municipio", TextBuilder_ES::$nomeMunicipio);

        $texto2->replaceTags("IDHM1991", Formulas::getIDH1991($idhm));
        $texto2->replaceTags("IDHM2000", Formulas::getIDH2000($idhm));
        $texto2->replaceTags("Tx_crescimento_9100", Formulas::getTaxaCrescimento9100($idhm));

        //Cálculo do HIATO
        //$reducao_hiato_9100 = (($idhm[1]["valor"] - $idhm[0]["valor"]) / (1 - $idhm[0]["valor"])) * 100;
        $texto2->replaceTags("reducao_hiato_9100", Formulas::getReducaoHiato9100($idhm));

        if (Formulas::getReducaoHiato9100puro($idhm) >= 0)
            $texto2->replaceTags("reduzido_aumentado", "redujo");//@Translate
        else
            $texto2->replaceTags("reduzido_aumentado", "creció");//@Translate

        $block_evolucao->setData("text2", $texto2->getTexto());

        //----------------------------------------------------------------------------------------
        //Evolução entre os anos de 1991 e 2010
        $block_evolucao->setData("info3", "");
        
        //@Translate
        $str3 = "<b>Entre 1991 y 2010</b><br>
            El IDHM de [municipio] aumentó un [Tx_crescimento_9110]% en las dos últimas décadas,
            porcentaje [abaixo_acima] al crecimiento promedio nacional ([tx_cresc_Brasil9110]%) y [abaixo_acima_uf] al crecimiento promedio estadual ([tx_cresc_Estado9110]%).
            La brecha de desarrollo humano, es decir, la distancia entre el IDHM del municipio y el límite máximo del índice, equivalente a 1,
            se [reduzido_aumentado] un [reducao_hiato_9110]% entre 1991 y 2010.";
        
        $texto3 = new Texto($str3);
        $texto3->replaceTags("municipio", TextBuilder_ES::$nomeMunicipio);

        //Taxa de Crescimento
        $tx_cresc_9110 = Formulas::getTaxaCrescimento9110($idhm);
        $texto3->replaceTags("Tx_crescimento_9110", $tx_cresc_9110);

        //----------------------------------------
        //Taxa de Crescimento em relação ao BRASIL
        $tx_cresc_Brasil9110 = Formulas::getTaxaCrescimento9110BRASIL($idhm_brasil);
        
        if ($tx_cresc_Brasil9110 < $tx_cresc_9110){
            $texto3->replaceTags("tx_cresc_Brasil9110", abs($tx_cresc_Brasil9110));
            $texto3->replaceTags("abaixo_acima", "aumentó");//@Translate
        }else if ($tx_cresc_Brasil9110 == $tx_cresc_9110){
            $texto3->replaceTags("tx_cresc_Brasil9110", abs($tx_cresc_Brasil9110));
            $texto3->replaceTags("abaixo_acima", "igual");//@Translate
        }else if ($tx_cresc_Brasil9110 > $tx_cresc_9110){
            $texto3->replaceTags("tx_cresc_Brasil9110", abs($tx_cresc_Brasil9110));
            $texto3->replaceTags("abaixo_acima", "disminuyó");//@Translate
        }            

        //----------------------------------------
        //Taxa de Crescimento em relação ao ESTADO
        $tx_cresc_Estado9110 = Formulas::getTaxaCrescimento9110ESTADO($idhm_uf);
        
        if ($tx_cresc_Estado9110 < $tx_cresc_9110){
            $texto3->replaceTags("abaixo_acima_uf", "aumentó");//@Translate
            $texto3->replaceTags("tx_cresc_Estado9110", abs($tx_cresc_Estado9110));
        }  
        else if ($tx_cresc_Estado9110 == $tx_cresc_9110){
            $texto3->replaceTags("tx_cresc_Estado9110", abs($tx_cresc_Estado9110));
            $texto3->replaceTags("abaixo_acima_uf", "igual");//@Translate
        }
        else if ($tx_cresc_Estado9110 > $tx_cresc_9110){
            $texto3->replaceTags("abaixo_acima_uf", "disminuyó");//@Translate
            $texto3->replaceTags("tx_cresc_Estado9110", abs($tx_cresc_Estado9110));
        }
        
        //Cálculo do HIATO
        //$reducao_hiato_9110 = (($idhm[2]["valor"] - $idhm[0]["valor"]) / (1 - $idhm[0]["valor"])) * 100;
        $texto3->replaceTags("reducao_hiato_9110", Formulas::getReducaoHiato9110($idhm));

        if (Formulas::getReducaoHiato9110puro($idhm) >= 0)
            $texto3->replaceTags("reduzido_aumentado", "redujo");//@Translate
        else
            $texto3->replaceTags("reduzido_aumentado", "creció");//@Translate

        $block_evolucao->setData("text3", $texto3->getTexto());
        
        if (TextBuilder_ES::$print){ 
            $block_evolucao->setData("quebra", "<div style='page-break-after: always'></div>");
        }else
            $block_evolucao->setData("quebra", "");

        $block_evolucao->setData("canvasContent", getChartEvolucao(TextBuilder_ES::$idMunicipio, TextBuilder_ES::$lang));
    }
    
    static public function generateIDH_table_taxa_hiato($block_table_taxa_hiato) {
        
        $idhm = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "IDHM"); //IDHM

        $block_table_taxa_hiato->setData("titulo", "");
        $block_table_taxa_hiato->setData("fonte", TextBuilder_ES::$fontePerfil);
        $block_table_taxa_hiato->setData("ano1", "Tasa de crecimiento");//@Translate
        $block_table_taxa_hiato->setData("ano2", "Brecha de desarrollo");//@Translate

        $taxa9100 = Formulas::getTaxa9100($idhm);
        $taxa0010 = Formulas::getTaxa0010($idhm);        
        $taxa9110 = Formulas::getTaxa9110($idhm);

        $reducao_hiato_0010 = Formulas::getReducaoHiato0010($idhm);
        $reducao_hiato_9100 = Formulas::getReducaoHiato9100($idhm);
        $reducao_hiato_9110 = Formulas::getReducaoHiato9110($idhm);

        //TODO: FAZER O MAIS E MENOS DA TAXA E HIATO UTILIZANDO IMAGENS
        
            $block_table_taxa_hiato->setData("v1", "Entre 1991 y el 2000");//@Translate
            
                Formulas::printTableTaxaHiatoEntre9100($block_table_taxa_hiato, $taxa9100, $reducao_hiato_9100);
                
            $block_table_taxa_hiato->setData("v2", "Entre el 2000 y 2010");//@Translate
            
                Formulas::printTableTaxaHiatoEntre0010($block_table_taxa_hiato, $taxa0010, $reducao_hiato_0010);
            
            $block_table_taxa_hiato->setData("v3", "Entre 1991 y 2010");//@Translate
            
                Formulas::printTableTaxaHiatoEntre9110($block_table_taxa_hiato, $taxa9110, $reducao_hiato_9110);

    }

    static public function generateIDH_ranking($block_ranking) {

        $ranking = TextBuilder_ES::getRanking(); //IDHM
        $uf = TextBuilder_ES::getUf(TextBuilder_ES::$idMunicipio); //IDHM
        $ranking_uf = TextBuilder_ES::getRankingUf($uf[0]["id"]); //IDHM

        $block_ranking->setData("subtitulo", "Ranking");//@Translate
        $block_ranking->setData("info", "");
        
        //@Translate
        $str = "[municipio] ocupa la posición [ranking_municipio_IDHM]ª en 2010 entre los 5565 municipios de Brasil, 
            a sabiendas de que [municipios_melhor_IDHM] ([municipios_melhor_IDHM_p]%) municipios se encuentran en mejor posición y [municipios_pior_IDHM] ([municipios_pior_IDHM_p]%) municipios
            están en una situación igual o peor.";
        
        if (TextBuilder_ES::$idMunicipio != 735){
            //@Translate
            $str = $str . "Con respecto a los otros [numero_municipios_estado] municipios de [estado_municipio], [municipio] ocupa la posición
            [ranking_estados_IDHM]ª, con lo cual hay [municipios_melhor_IDHM_estado] ([municipios_melhor_IDHM_p_estado]%) municipios en mejor situación y [municipios_pior_IDHM_estado] ([municipios_pior_IDHM_p_estado]%)
            en peor o igual situación.";
        }   
         
        $texto = new Texto($str);

        $texto->replaceTags("municipio", TextBuilder_ES::$nomeMunicipio);       
        
        Formulas::getRanking($block_ranking, $texto, $ranking, $uf, $ranking_uf);
        
    }

    // OUTRA CATEGORIA
    static public function generateDEMOGRAFIA_SAUDE_populacao($block_populacao) {

        $pesotot = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PESOTOT"); //PESOTOT
        $pesourb = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PESOURB"); //PESORUR
        $pesotot_uf = TextBuilder_ES::getVariaveis_Uf(TextBuilder_ES::$idMunicipio, "PESOTOT"); //PESOTOT do Estado
        $pesotot_brasil = TextBuilder_ES::getVariaveis_Brasil(TextBuilder_ES::$idMunicipio, "PESOTOT"); //PESOTOT do Brasil        
        //$pesorur = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PESORUR"); //PESORUR        
        
        if (TextBuilder_ES::$print){ 
            $block_populacao->setData("quebra", "<div style='page-break-after: always'></div>");
        }else
            $block_populacao->setData("quebra", "");
        
        $block_populacao->setData("fonte", TextBuilder_ES::$fontePerfil);
        $block_populacao->setData("titulo", "Demografía y salud");//@Translate
        $block_populacao->setData("subtitulo", "Población");//@Translate
        $block_populacao->setData("info", "");
        
        //@Translate
        $str = "Entre el 2000 y 2010, la población de [municipio] registró una tasa de crecimiento anual promedio de [tx_cres_pop_0010]%.
            En la década anterior, de 1991 al 2000, la tasa de crecimiento anual promedio fue de 
            [tx_cres_pop_9100]%. En el estado, estas tasas se situaron en un [tx_cresc_pop_estado_0010]% entre el 2000 y 2010 y un 
            [tx_cresc_pop_estado_9100]% entre 1991 y el 2000.
            A nivel nacional, se situaron en un [tx_cresc_pop_pais_0010]% entre el 2000 y 2010 y en un 
            [tx_cresc_pop_pais_9100]% entre 1991 y el 2000.
            En las dos últimas décadas, la tasa de urbanización creció un [tx_urbanizacao]%.";

        $texto = new Texto($str);
        $texto->replaceTags("municipio", TextBuilder_ES::$nomeMunicipio);
        $texto->replaceTags("tx_cres_pop_0010", Formulas::getTaxaCrescimentoPop0010($pesotot)); //(((PESOTOT 2010 / PESOTOT 2000)^(1/10))-1)*100
        $texto->replaceTags("tx_cres_pop_9100", Formulas::getTaxaCrescimentoPop9100($pesotot));  //(((PESOTOT 2000 / PESOTOT 1991)^(1/9))-1)*100

        $texto->replaceTags("tx_cresc_pop_estado_0010", Formulas::getTaxaCrescimentoPop0010ESTADO($pesotot_uf));
        $texto->replaceTags("tx_cresc_pop_estado_9100", Formulas::getTaxaCrescimentoPop9100ESTADO($pesotot_uf));

        $texto->replaceTags("tx_cresc_pop_pais_0010", Formulas::getTaxaCrescimentoPop0010BRASIL($pesotot_brasil));
        $texto->replaceTags("tx_cresc_pop_pais_9100", Formulas::getTaxaCrescimentoPop9100BRASIL($pesotot_brasil));
        
        $texto->replaceTags("tx_urbanizacao", Formulas::getTaxaUrbanizacao($pesourb, $pesotot));
                
        $block_populacao->setData("text", $texto->getTexto());
        $block_populacao->setData("tableContent", "");
    }

    static public function generateIDH_table_populacao($block_table_populacao) {

        $variaveis = array();
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PESOTOT")); //População Total
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "HOMEMTOT")); //Homens
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "MULHERTOT")); //Mulheres
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PESOURB")); //População Urbana
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PESORUR")); //População Rural
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "")); //Taxa de Urbanização

        $block_table_populacao->setData("titulo", "Población");//@Translate
        $block_table_populacao->setData("caption", "Población total, por género, rural/urbana y tasa de urbanización");//@Translate
        $block_table_populacao->setData("fonte", TextBuilder_ES::$fontePerfil);        
        $block_table_populacao->setData("municipio", TextBuilder_ES::$nomeMunicipio . " - " . TextBuilder_ES::$ufMunicipio);
        $block_table_populacao->setData("coluna1", "Población");//@Translate
        $block_table_populacao->setData("coluna2", "% del total");//@Translate
        
        $stringTaxaUrbanizacao = "Tasa de urbanización";//@Translate
        Formulas::printTablePopulacao($block_table_populacao, $variaveis, $stringTaxaUrbanizacao);
        
    }

    static public function generateDEMOGRAFIA_SAUDE_etaria($block_etaria) {

        $tenv = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_ENV"); //T_ENV
        $rd = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "RAZDEP"); //T_ENV

        $block_etaria->setData("subtitulo", "Estructura de edad");//@Translate
        $block_etaria->setData("info", "");
                 
        //@Translate
        $str = "Entre el 2000 y 2010, la razón de dependencia de [municipio] pasó de un [rz_dependencia00]%
            a un [rz_dependencia10]% y la tasa de envejecimiento pasó de un [indice_envelhecimento00]% a un [indice_envelhecimento10]%.
            Entre 1991 y el 2000, la razón de dependencia pasó de un [rz_dependencia91]% a un [rz_dependencia00]%,
            mientras que la tasa de envejecimiento pasó de un [indice_envelhecimento91]% a un [indice_envelhecimento00]%.";
        
        $texto = new Texto($str);
        $texto->replaceTags("municipio", TextBuilder_ES::$nomeMunicipio);
        $texto->replaceTags("indice_envelhecimento91", Formulas::getIndiceEnvelhecimento91($tenv));
        $texto->replaceTags("indice_envelhecimento00", Formulas::getIndiceEnvelhecimento00($tenv));
        $texto->replaceTags("indice_envelhecimento10", Formulas::getIndiceEnvelhecimento10($tenv));
        
        $texto->replaceTags("rz_dependencia91", Formulas::getRazaoDependencia91($rd));
        $texto->replaceTags("rz_dependencia00", Formulas::getRazaoDependencia00($rd));
        $texto->replaceTags("rz_dependencia10", Formulas::getRazaoDependencia10($rd));
        
        $block_etaria->setData("text", $texto->getTexto());
        
        //@Translate
        $block_etaria->setData("block_box1", "<b>¿Qué es la razón de<br> dependencia?</b><br>
            Es el porcentaje de la <br>
            población menor de 15 <br>
            años y de al menos 65 <br>
            años (población dependente) <br>
            con respecto a la población <br>
            de entre 15 y 64 años<br>
            (población potencialmente<br>
            activa).");
        $block_etaria->setData("block_box2","<b>¿Qué es la tasa de<br> envejecimiento?</b><br>
            Es la razón entre la <br>
            población de al menos <br>
            65 años y la población <br>
            total multiplicada.");
        
        $block_etaria->setData("tableContent", "");
    }

    static public function generateIDH_table_etaria($block_table_etaria) {

        $pesotot = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PESOTOT"); //PESOTOT

        $variaveis = array();
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PESO15")); //Menos de 15 anos (PESOTOT-PESO15)
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "")); //15 a 64 anos
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PESO65")); //65 anos ou mais
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "RAZDEP")); //Razão de Dependência(Planilha Piramide)               
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_ENV")); //Índice de Envelhecimento

        $block_table_etaria->setData("titulo", "Estructura de edad");//@Translate        
        $block_table_etaria->setData("caption", "Estructura de edad de la población");//@Translate
        $block_table_etaria->setData("fonte", TextBuilder_ES::$fontePerfil);
        $block_table_etaria->setData("municipio", TextBuilder_ES::$nomeMunicipio . " - " . TextBuilder_ES::$ufMunicipio);
        $block_table_etaria->setData("coluna1", "Población");//@Translate
        $block_table_etaria->setData("coluna2", "% del total");//@Translate
        
        $stringMenos15anos = "Menos de 15 años"; //@Translate //Não é uma variável específica
        $string15a64anos = "15 a 64 años"; //@Translate //Não é uma variável específica
        Formulas::printTableEtaria($block_table_etaria, $variaveis, $pesotot, $stringMenos15anos, $string15a64anos);
        
        if (TextBuilder_ES::$print){ 
            $block_table_etaria->setData("quebra1", "<div style='page-break-after: always'></div>");
        }else
            $block_table_etaria->setData("quebra1", "");
        
        $block_table_etaria->setData("canvasContent1", getChartPiramideEtaria1(TextBuilder_ES::$idMunicipio, TextBuilder_ES::$lang));
        $block_table_etaria->setData("canvasContent2", getChartPiramideEtaria2(TextBuilder_ES::$idMunicipio, TextBuilder_ES::$lang));    
        $block_table_etaria->setData("canvasContent3", getChartPiramideEtaria3(TextBuilder_ES::$idMunicipio, TextBuilder_ES::$lang));
        
    }

    static public function generateDEMOGRAFIA_SAUDE_longevidade1($block_longevidade) {

        $mort1 = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "MORT1"); //MORT1
        $mort1_uf = TextBuilder_ES::getVariaveis_Uf(TextBuilder_ES::$idMunicipio, "MORT1"); //MORT1 do Estado
        $mort1_brasil = TextBuilder_ES::getVariaveis_Brasil(TextBuilder_ES::$idMunicipio, "MORT1"); //MORT1 do Brasil
                
        if (TextBuilder_ES::$print){ 
            $block_longevidade->setData("quebra", "<div style='page-break-after: always'></div>");
        }else
            $block_longevidade->setData("quebra", "");
        
        $block_longevidade->setData("subtitulo", "Longevidad, mortalidad y fecundidad");//@Translate
        $block_longevidade->setData("info", "");
        
        //@Translate
        $str1 = "La mortalidad infantil (mortalidad de los niños de menos de un año) en [municipio] [mort1_diminuiu_aumentou] un [reducao_mortalinfantil0010]%,
            tras pasar de [mortinfantil00] por mil nacidos vivos en el 2000 a [mortinfantil10] por mil nacidos vivos en 2010.
            De acuerdo con los Objetivos de Desarrollo del Milenio de las Naciones Unidas, la mortalidad infantil de Brasil deberá ser inferior a 17,9 muertes por mil en 2015.
            En 2010, las tasas de mortalidad infantil del estado y del país eran de [mortinfantil10_Estado] y [mortinfantil10_Brasil] por mil nacidos vivos, respectivamente.";
        
        $texto1 = new Texto($str1);
        $texto1->replaceTags("municipio", TextBuilder_ES::$nomeMunicipio);
        //TODO: Tem que ser sempre positivo
        $texto1->replaceTags("reducao_mortalinfantil0010", Formulas::getReducaoMortalidadeInfantil0010($mort1));
        $texto1->replaceTags("mortinfantil00", Formulas::getMortalidadeInfantil00($mort1));
        $texto1->replaceTags("mortinfantil10", Formulas::getMortalidadeInfantil10($mort1));
        $texto1->replaceTags("mortinfantil10_Estado", Formulas::getMortalidadeInfantil10ESTADO($mort1_uf));
        $texto1->replaceTags("mortinfantil10_Brasil", Formulas::getMortalidadeInfantil10BRASIL($mort1_brasil));

        //TODO: Tirar o igual da comparação (feito pq a base não é oficial e há replicações
        if (Formulas::getMortalidadeInfantil10puro($mort1) <= Formulas::getMortalidadeInfantil00puro($mort1))
            $texto1->replaceTags("mort1_diminuiu_aumentou", "bajó");//@Translate
        else if (Formulas::getMortalidadeInfantil10puro($mort1) > Formulas::getMortalidadeInfantil00puro($mort1))
            $texto1->replaceTags("mort1_diminuiu_aumentou", "aumentó");//@Translate
        
        $block_longevidade->setData("text2", "");
        $block_longevidade->setData("tableContent", "");

        $block_longevidade->setData("text1", $texto1->getTexto());

    }

    static public function generateIDH_table_longevidade($block_table_longevidade) {

        $variaveis = array();
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "ESPVIDA")); //Esperança de vida ao nascer (anos)
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "MORT1")); //Mortalidade até 1 ano de idade (por mil nascidos vivos)
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "MORT5")); //Mortalidade até 5 anos de idade (por mil nascidos vivos)
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "FECTOT")); //Taxa de fecundidade total (filhos por mulher) 

        $block_table_longevidade->setData("titulo", "");
        $block_table_longevidade->setData("caption", "Longevidad, mortalidad y fecundidad");//@Translate
        $block_table_longevidade->setData("fonte", TextBuilder_ES::$fontePerfil);        
        $block_table_longevidade->setData("municipio", TextBuilder_ES::$nomeMunicipio . " - " . TextBuilder_ES::$ufMunicipio);
        
        Formulas::printTableLongevidade($block_table_longevidade, $variaveis);
        
    }
    
       static public function generateDEMOGRAFIA_SAUDE_longevidade2($block_longevidade) {

        $espvida = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "ESPVIDA"); //ESPVIDA
        $espvida_uf = TextBuilder_ES::getVariaveis_Uf(TextBuilder_ES::$idMunicipio, "ESPVIDA"); //ESPVIDA do Estado
        $espvida_brasil = TextBuilder_ES::getVariaveis_Brasil(TextBuilder_ES::$idMunicipio, "ESPVIDA"); //ESPVIDA do Brasil

        $block_longevidade->setData("subtitulo", "");
        $block_longevidade->setData("info", "");

        //@Translate
        $str2 = "La esperanza de vida al nacer es el indicador usado para constituir el factor de longevidad del Índice de Desarrollo Humano Municipal (IDHM).
            En [municipio], la esperanza de vida al nacer aumentó en [aumento_esp_nascer0010] años en las dos últimas décadas, tras pasar de [esp_nascer91] años en 1991 a [esp_nascer00] años en el 2000 y 
            [esp_nascer10] años en 2010. En 2010, la esperanza de vida al nacer promedio era de [esp_nascer10_estado]años en el estado y de 
            [esp_nascer10_pais] años a nivel nacional.";
        
        $texto2 = new Texto($str2);
        $texto2->replaceTags("municipio", TextBuilder_ES::$nomeMunicipio);
        $texto2->replaceTags("aumento_esp_nascer0010", Formulas::getAumentoEsperancaVidaNascer0010($espvida));
        $texto2->replaceTags("esp_nascer91", Formulas::getEsperancaVidaNascer91($espvida));
        $texto2->replaceTags("esp_nascer00", Formulas::getEsperancaVidaNascer00($espvida));
        $texto2->replaceTags("esp_nascer10", Formulas::getEsperancaVidaNascer10($espvida));
        $texto2->replaceTags("esp_nascer10_estado", Formulas::getEsperancaVidaNascer10ESTADO($espvida_uf));
        $texto2->replaceTags("esp_nascer10_pais", Formulas::getEsperancaVidaNascer10BRASIL($espvida_brasil));
        $block_longevidade->setData("text2", $texto2->getTexto());
        
        $block_longevidade->setData("text1", "");
        $block_longevidade->setData("tableContent", "");
        
        if (TextBuilder_ES::$print){ 
            $block_longevidade->setData("quebra", "");
        }else
            $block_longevidade->setData("quebra", "");
    }

    static public function generateEDUCACAO_nivel_educacional($block_nivel_educacional) {
       
        $t_freq4a6 = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_FREQ5A6"); //T_FREQ5A6 - Mudou variável
        $t_fund12a14 = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_FUND11A13");  //T_FUND11A13 - Mudou variável
        $t_fund16a18 = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_FUND15A17");  //T_FUND15A17 - Mudou variável
        $t_med19a21 = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_MED18A20");  //T_MED18A20 - Mudou variável
        
        $t_atraso_0_fund = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_ATRASO_0_FUND");  //T_ATRASO_0_FUND 
        $t_flfund = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_FLFUND");  //T_FLFUND 

        $t_atraso_0_med = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_ATRASO_0_MED");  //T_ATRASO_0_MED 
        $t_flmed = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_FLMED");  //T_FLMED 
        $t_flsuper = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_FLSUPER");  //T_FLSUPER 

        $t_freq6a14 = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_FREQ6A14");  //T_FREQ6A14 
        $t_freq15a17 = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_FREQ15A17");  //T_FREQ15A17 
        //$t_freq18a24 = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_FREQ18A24");  //T_FREQ15A17 
        
        if (TextBuilder_ES::$print){ 
            $block_nivel_educacional->setData("quebra", "<div style='page-break-after: always'></div>");
        }else
            $block_nivel_educacional->setData("quebra", "");
        
        $block_nivel_educacional->setData("fonte", TextBuilder_ES::$fontePerfil);
        $block_nivel_educacional->setData("titulo", "Educación");//@Translate
        $block_nivel_educacional->setData("subtitulo", "Niños y jóvenes");//@Translate
        $block_nivel_educacional->setData("info", "");
        
        //@Translate
        $str1 = "<br>La proporción de niños y jóvenes que cursan o terminaron determinados ciclos refleja la situación de la educación entre la población en edad escolar del municipio y compone el IDHM Educación. 
        <br><br>Entre el 2000 y 2010, la proporción de <b>niños de 5 a 6 años que van a la escuela</b> aumentó un [cresc_4-6esc_0010]% y entre 1991 y el 2000
        un [cresc_4-6esc_9100]%. La proporción de <b>niños de 11 a 13 años que cursa los últimos años de la educación primaria</b> aumentó un [cresc_12-14esc_0010]%
        entre el 2000 y 2010 y un [cresc_12-14esc_9100]% entre 1991 y el 2000. 
        
        <br><br>La proporción de <b>jóvenes de 15 a 17 años con educación primaria completa</b> aumentó un [cresc_16-18fund_0010]% entre el 2000 y 2010 y un
        [cresc_16-18fund_9100]% entre 1991 y el 2000. Y la proporción de <b>jóvenes de entre 18 y 20 años con educación secundaria completa</b> aumentó un [cresc_19-21medio_0010]%
        entre el 2000 y 2010 y un [cresc_19-21medio_9100]% entre 1991 y el 2000.";

        $texto1 = new Texto($str1);
        $texto1->replaceTags("municipio", TextBuilder_ES::$nomeMunicipio);

        $texto1->replaceTags("cresc_4-6esc_0010", Formulas::getCrescimento4a6Esc0010($t_freq4a6));
        $texto1->replaceTags("cresc_4-6esc_9100", Formulas::getCrescimento4a6Esc9100($t_freq4a6));

        $texto1->replaceTags("cresc_12-14esc_0010", Formulas::getCrescimento12a14Esc0010($t_fund12a14));
        $texto1->replaceTags("cresc_12-14esc_9100", Formulas::getCrescimento12a14Esc9100($t_fund12a14));

        $texto1->replaceTags("cresc_16-18fund_0010", Formulas::getCrescimento16a18Fund0010($t_fund16a18));
        $texto1->replaceTags("cresc_16-18fund_9100", Formulas::getCrescimento16a18Fund9100($t_fund16a18));

        $texto1->replaceTags("cresc_19-21medio_0010", Formulas::getCrescimento19a21Medio0010($t_med19a21));
        $texto1->replaceTags("cresc_19-21medio_9100", Formulas::getCrescimento19a21Medio9100($t_med19a21));

        $block_nivel_educacional->setData("text1", $texto1->getTexto());        

        if (TextBuilder_ES::$print){ 
            $block_nivel_educacional->setData("quebra4", "<div style=margin-top: 20px;'></div>");
        }else
            $block_nivel_educacional->setData("quebra4", "");
        
        $block_nivel_educacional->setData("canvasContent1", getChartFluxoEscolar(TextBuilder_ES::$idMunicipio, TextBuilder_ES::$lang));
        
        if (TextBuilder_ES::$print){ 
            $block_nivel_educacional->setData("quebra1", "<div style='page-break-after: always'></div>");
        }else
            $block_nivel_educacional->setData("quebra1", "");
        
        $block_nivel_educacional->setData("canvasContent2", getChartFrequenciaEscolar(TextBuilder_ES::$idMunicipio, TextBuilder_ES::$lang));
        
        //@Translate
        $str2 = "<br>En 2010, el [tx_fund_sematraso_10]% de los estudiantes de [municipio] entre 6 y 14 años cursaban la educación primaria regular en el nivel adecuado para su edad.
        En el 2000 eran un [tx_fund_sematraso_00]% y en 1991, un
        [tx_fund_sematraso_91]%. Entre los jóvenes de 15 a 17 años, el [tx_medio_sematraso_10]% cursaba la educación secundaria regular sin retraso.
        En el 2000 eran un [tx_medio_sematraso_00]% y en 1991, un [tx_medio_sematraso_91]%. 
        Ente los alumnos de 18 a 24 años, un [t_flsuper_10]% cursaba la educación superior en 2010, un [t_flsuper_00]% % la cursaba en el 2000 y un [t_flsuper_91]% la cursaba en 1991.
        <br><br>
        Nótese que, en 2010, el [p6a14]% de los niños de 6 a 14 años no iba a la escuela, porcentaje que, entre los jóvenes de 15 a 17 años ascendía a un [p15a17]%.";

        $texto2 = new Texto($str2);
        $texto2->replaceTags("municipio", TextBuilder_ES::$nomeMunicipio);
        $texto2->replaceTags("tx_fund_sematraso_10", Formulas::getTxFundSemAtraso10($t_atraso_0_fund, $t_flfund));
        $texto2->replaceTags("tx_fund_sematraso_00", Formulas::getTxFundSemAtraso00($t_atraso_0_fund, $t_flfund));
        $texto2->replaceTags("tx_fund_sematraso_91", Formulas::getTxFundSemAtraso91($t_atraso_0_fund, $t_flfund));

        $texto2->replaceTags("tx_medio_sematraso_10", Formulas::getTxMedioSemAtraso10($t_atraso_0_med, $t_flmed));
        $texto2->replaceTags("tx_medio_sematraso_00", Formulas::getTxMedioSemAtraso00($t_atraso_0_med, $t_flmed));
        $texto2->replaceTags("tx_medio_sematraso_91", Formulas::getTxMedioSemAtraso91($t_atraso_0_med, $t_flmed));
        
        $texto2->replaceTags("t_flsuper_10", Formulas::getTxFLSuper10($t_flsuper));
        $texto2->replaceTags("t_flsuper_00", Formulas::getTxFLSuper00($t_flsuper));
        $texto2->replaceTags("t_flsuper_91", Formulas::getTxFLSuper91($t_flsuper));       
                
        $texto2->replaceTags("p6a14", Formulas::getP6a14($t_freq6a14));
        $texto2->replaceTags("p15a17", Formulas::getP15a17($t_freq15a17));
        
        $block_nivel_educacional->setData("text2", $texto2->getTexto());
        
        if (TextBuilder_ES::$print){ 
            $block_nivel_educacional->setData("quebra2", "<div style='page-break-after: always'></div>");
        }else
            $block_nivel_educacional->setData("quebra2", "");
        
        $block_nivel_educacional->setData("canvasContent3", getChartFrequenciaDe6a14(TextBuilder_ES::$idMunicipio, TextBuilder_ES::$lang));              
        $block_nivel_educacional->setData("canvasContent4", getChartFrequenciaDe15a17(TextBuilder_ES::$idMunicipio, TextBuilder_ES::$lang));
        $block_nivel_educacional->setData("canvasContent5", getChartFrequenciaDe18a24(TextBuilder_ES::$idMunicipio, TextBuilder_ES::$lang));
        
        if (TextBuilder_ES::$print){ 
            $block_nivel_educacional->setData("quebra3", "<div style='page-break-after: always'></div>");
        }else
            $block_nivel_educacional->setData("quebra3", "");
        
    }

    static public function generateEDUCACAO_populacao_adulta($block_populacao_adulta) {

        $t_analf25m = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_ANALF18M"); //T_ANALF18M - Mudou variável
        $t_fundin25m = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_FUND18M");  //T_FUND18M  - Mudou variável
        $t_medin25m = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_MED18M");  //T_MED18M  - Mudou variável
        
        $t_fundin25m_uf = TextBuilder_ES::getVariaveis_Uf(TextBuilder_ES::$idMunicipio, "T_FUND18M");  //T_FUND18M - Mudou variável
        $t_medin25m_uf = TextBuilder_ES::getVariaveis_Uf(TextBuilder_ES::$idMunicipio, "T_MED18M");  //T_MED18M - Mudou variável
        
        $e_anosesperados = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "E_ANOSESTUDO"); //E_ANOSESTUDO
        $e_anosesperados_uf = TextBuilder_ES::getVariaveis_Uf(TextBuilder_ES::$idMunicipio, "E_ANOSESTUDO");  //E_ANOSESTUDO
               
        $uf = TextBuilder_ES::getUf(TextBuilder_ES::$idMunicipio); //UF
        
        $block_populacao_adulta->setData("subtitulo", "Población adulta");//@Translate
        $block_populacao_adulta->setData("fonte", TextBuilder_ES::$fontePerfil);
        $block_populacao_adulta->setData("info", "");
        
        //@Translate
        $str = "La escolaridad de la población adulta es un indicador importante de acceso al conocimiento y compone el IDHM Educación.
            <br><br>En 2010, el [25_fund_10]% de la población de 18 años o más había terminado la educación primaria y el [25_medio_10]%,
            la educación secundaria. En [estado_municipio], correspondían al [25_fund_10_Estado]% y al [25_medio_10_Estado]%, respectivamente.
            Este indicador está sujeto a una gran inercia, debido al peso de las generaciones más antiguas y con menos escolaridad.
            <br><br>La tasa de analfabetismo de la población de 18 años o más [diminuiu_aumentou] un [25_analf_9110] en las dos últimas décadas.";
        $texto = new Texto($str);
        $texto->replaceTags("municipio", TextBuilder_ES::$nomeMunicipio);
        $texto->replaceTags("estado_municipio", $uf[0]["nome"]);
        
        $texto->replaceTags("25_fund_10", Formulas::get25Fund10($t_fundin25m));
        $texto->replaceTags("25_medio_10", Formulas::get25Medio10($t_medin25m));
        $texto->replaceTags("25_fund_10_Estado", Formulas::get25Fund10ESTADO($t_fundin25m_uf));
        $texto->replaceTags("25_medio_10_Estado", Formulas::get25Medio10ESTADO($t_medin25m_uf));
        
        $dif_analf = Formulas::getDifAnalf($t_analf25m);
        if ($dif_analf > 0){
            $texto->replaceTags("diminuiu_aumentou", "aumentó");//@Translate
            $texto->replaceTags("25_analf_9110", number_format($dif_analf, 2, ",", ".") . "%");
        }else if ($dif_analf == 0) {
            $texto->replaceTags("diminuiu_aumentou", "permanecido");//@Translate
            $texto->replaceTags("25_analf_9110", "");
        }else if ($dif_analf < 0) {
            $texto->replaceTags("diminuiu_aumentou", "disminuyó");//@Translate
            $texto->replaceTags("25_analf_9110", number_format(abs($dif_analf), 2, ",", ".") . "%");
        }
        
        $block_populacao_adulta->setData("text", $texto->getTexto());
        $block_populacao_adulta->setData("canvasContent", getChartEscolaridadePopulacao(TextBuilder_ES::$idMunicipio, TextBuilder_ES::$lang));
        
        $block_populacao_adulta->setData("subtitulo2", "Años de estudio esperados");//@Translate
        $block_populacao_adulta->setData("info2", "");
        
        //@Translate
        $str2 = "Los años de estudio esperados indican el número de años que el niño que comienza la vida escolar en el año de referencia tiende a completar.
        En 2010, [municipio] tenía [e_anosestudo10] años de estudio esperados, mientras que en el 2000 tenía 
        [e_anosestudo00] años y en 1991, [e_anosestudo91] años. 
        En tanto, [estado_municipio] tenía [ufe_anosestudo10] años de estudio esperados en 2010,
        [ufe_anosestudo00] años en el 2000 y [ufe_anosestudo91] años en 1991.";
        
        $texto2 = new Texto($str2);
        $texto2->replaceTags("municipio", TextBuilder_ES::$nomeMunicipio);
        $texto2->replaceTags("estado_municipio", $uf[0]["nome"]);
        
        $texto2->replaceTags("e_anosestudo10", Formulas::getEAnosEstudo10($e_anosesperados));
        $texto2->replaceTags("e_anosestudo00", Formulas::getEAnosEstudo00($e_anosesperados));
        $texto2->replaceTags("e_anosestudo91", Formulas::getEAnosEstudo91($e_anosesperados));
        
        $texto2->replaceTags("ufe_anosestudo10", Formulas::getEAnosEstudo10ESTADO($e_anosesperados_uf));
        $texto2->replaceTags("ufe_anosestudo00", Formulas::getEAnosEstudo00ESTADO($e_anosesperados_uf));
        $texto2->replaceTags("ufe_anosestudo91", Formulas::getEAnosEstudo91ESTADO($e_anosesperados_uf));
        
        $block_populacao_adulta->setData("text2", $texto2->getTexto());
     
    }

    static public function generateRENDA($block_renda) {

        $rdpc = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "RDPC"); //RDPC  
        $pind = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PIND");  //PIND 
        $pop = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "POP");  //POP 
        $gini = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "GINI");  //GINI 

        if (TextBuilder_ES::$print){ 
            $block_renda->setData("quebra", "<div style='page-break-after: always'></div>");
        }else
            $block_renda->setData("quebra", "");

        $block_renda->setData("fonte", TextBuilder_ES::$fontePerfil);
        $block_renda->setData("titulo", "Ingresos");//@Translate
        $block_renda->setData("subtitulo", "");
        $block_renda->setData("info", "");
        
        //@Translate
        $str = "El ingreso per cápita promedio de [municipio] [caiu_cresceu] un [tx_cresc_renda]% en las dos últimas décadas,
            tras pasar de R$[renda91] en 1991 a R$[renda00] en el 2000 y a R$[renda10] en 2010. La tasa anual promedio de crecimiento se situó en un 
            [tx_cresc_renda9100]% en el primer período y en un [tx_cresc_renda0010]% en el segundo. La pobreza extrema (medida de acuerdo con la proporción de personas con ingreso familiar per cápita inferior a 70,00 R$ en reales de agosto de 2010) pasó de un 
            [tx_pobreza_91]% en 1991 a un [tx_pobreza_00]%
            en el 2000 y a un [tx_pobreza_10]% en 2010.
            <br><br>La desigualdad [diminuiu_aumentou]: el Índice de Gini pasó de 
            [gini_91] en 1991 a [gini_00] en el 2000 y a [gini_10] en 2010. 
            ";
        $texto = new Texto($str);
        $texto->replaceTags("municipio", TextBuilder_ES::$nomeMunicipio);

        //TODO: Tirar o igual da comparação (feito pq a base não é oficial e há replicações
        if (Formulas::getRenda10puro($rdpc) >= Formulas::getRenda91puro($rdpc))
            $texto->replaceTags("caiu_cresceu", "aumentó");//@Translate
        else if (Formulas::getRenda10puro($rdpc) < Formulas::getRenda91puro($rdpc))
            $texto->replaceTags("caiu_cresceu", "disminuyó");//@Translate

        $texto->replaceTags("tx_cresc_renda", Formulas::getTxCrescRenda($rdpc));
        $texto->replaceTags("renda91", Formulas::getRenda91($rdpc));
        $texto->replaceTags("renda00", Formulas::getRenda00($rdpc));
        $texto->replaceTags("renda10", Formulas::getRenda10($rdpc));
        $texto->replaceTags("tx_cresc_renda9100", Formulas::getTxCrescRenda9100($rdpc));
        $texto->replaceTags("tx_cresc_renda0010", Formulas::getTxCrescRenda0010($rdpc));

        $texto->replaceTags("tx_pobreza_91", Formulas::getTxPobreza91($pind));
        $texto->replaceTags("tx_pobreza_00", Formulas::getTxPobreza00($pind));
        $texto->replaceTags("tx_pobreza_10", Formulas::getTxPobreza10($pind));
        //$texto->replaceTags("red_extrema_pobreza", str_replace(".",",",number_format((( ($pind[0]["valor"] * $pop[0]["valor"]) - ($pind[2]["valor"] * $pop[2]["valor"]) ) / ($pind[0]["valor"] * $pop[0]["valor"])) * 100, 2)));

        if (Formulas::getGini10puro($gini) < Formulas::getGini91puro($gini))
            $texto->replaceTags("diminuiu_aumentou", "disminuyó");//@Translate
        else if (Formulas::getGini10puro($gini) == Formulas::getGini91puro($gini))
            $texto->replaceTags("diminuiu_aumentou", "permanecido");//@Translate
        else if (Formulas::getGini10puro($gini) > Formulas::getGini91puro($gini))
            $texto->replaceTags("diminuiu_aumentou", "aumentó");//@Translate

        $texto->replaceTags("gini_91", Formulas::getGini91($gini));
        $texto->replaceTags("gini_00", Formulas::getGini00($gini));
        $texto->replaceTags("gini_10", Formulas::getGini10($gini));

        $block_renda->setData("text", $texto->getTexto());
        //@Translate
        $block_renda->setData("block_box1", "<br><b>¿Qué es el Índice de Gini?</b><br>
            Es un instrumento para medir <br>
            el grado de concentración de los ingresos <br>
            en función de la diferencia entre los ingresos <br>
            de los más pobres y de los más ricos. <br>
            Se trata de un valor que varía de entre 0 y 1,<br>
            donde 0 representa una situación de igualdad total,<br>
            es decir, donde todos perciben los mismos ingresos,<br>
            y el valor 1 refleja una desigualdad total,<br>
            a saber, en que una sola persona percibe <br>
            todos los ingresos del lugar.");
        
        // GRAFICO
        $block_renda->setData("tableContent", "");
        $block_renda->setData("tableContent2", "");

    }

    static public function generateIDH_table_renda($block_table_renda) {

        $variaveis = array();
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "RDPC")); //Renda per capita média (R$ de 2010)
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PIND")); //Proporção de extremamente pobres - total (%)
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PMPOB")); //Proporção de pobres 
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "GINI")); //Índice de Gini

        $block_table_renda->setData("titulo", "");
        $block_table_renda->setData("fonte", TextBuilder_ES::$fontePerfil);
        $block_table_renda->setData("caption", "Ingresos, pobreza y desigualdad");//@Translate
        $block_table_renda->setData("municipio", TextBuilder_ES::$nomeMunicipio . " - " . TextBuilder_ES::$ufMunicipio);
        
        Formulas::printTableRenda($block_table_renda, $variaveis);          
        
    } 
    
    static public function generateIDH_table_renda2($block_table_renda2) {

        $variaveis = array();
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PREN20")); //20% mais pobres
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PREN40")); //40% mais pobres
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PREN60")); //60% mais pobres
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PREN80")); //80% mais pobres
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PREN20RICOS")); //20% mais ricos

        $block_table_renda2->setData("titulo", "");
        $block_table_renda2->setData("fonte", TextBuilder_ES::$fontePerfil);
        $block_table_renda2->setData("caption", "Porcentaje de los ingresos percibidos por estratos de la población");//@Translate
        $block_table_renda2->setData("municipio", TextBuilder_ES::$nomeMunicipio . " - " . TextBuilder_ES::$ufMunicipio);
                
        Formulas::printTableRenda2($block_table_renda2, $variaveis);

    }

    static public function generateTRABALHO1($block_trabalho) {

        $t_ativ18m = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_ATIV18M"); //T_ATIV18M  
        $t_des18m = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_DES18M");  //T_DES18M 
        
        if (TextBuilder_ES::$print){ 
            $block_trabalho->setData("quebra", "<div style='page-break-after: always'></div>");
        }else
            $block_trabalho->setData("quebra", "");
        
        $block_trabalho->setData("fonte", TextBuilder_ES::$fontePerfil);
        $block_trabalho->setData("titulo", "Trabajo");//@Translate
        $block_trabalho->setData("canvasContent", getChartTrabalho(TextBuilder_ES::$idMunicipio, TextBuilder_ES::$lang));
       
        $block_trabalho->setData("subtitulo", "");
        $block_trabalho->setData("info", "");

        //@Translate
        $str1 = "Entre el 2000 y 2010, la <b>tasa de actividad</b> de la población de 18 años o más (es decir, el porcentaje de esa población que era económicamente activa) paso de un 
            [tx_ativ_18m_00]% en el 2000 a un [tx_ativ_18m_10]% en 2010. Asimismo, su <b>tasa de desempleo</b> (es decir, el porcentaje de la población económicamente activa que estaba desocupada) pasó de un 
            [tx_des18m_00]% en el 2000 a un [tx_des18m_10]% en 2010.";
        $texto1 = new Texto($str1);
        $texto1->replaceTags("municipio", TextBuilder_ES::$nomeMunicipio);

        $texto1->replaceTags("tx_ativ_18m_00", Formulas::getTxAtiv18m00($t_ativ18m));
        $texto1->replaceTags("tx_ativ_18m_10", Formulas::getTxAtiv18m10($t_ativ18m));

        $texto1->replaceTags("tx_des18m_00", Formulas::getTxDes18m00($t_des18m));
        $texto1->replaceTags("tx_des18m_10", Formulas::getTxDes18m10($t_des18m));

        $block_trabalho->setData("text1", $texto1->getTexto());
        $block_trabalho->setData("text2", "");
        
    }

    static public function generateIDH_table_trabalho($block_table_trabalho) {

        $variaveis = array();
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_ATIV18M")); //Taxa de atividade
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_DES18M")); //Taxa de desocupação
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "P_FORMAL")); //Grau de formalização dos ocuupados
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "P_FUND")); //% de empregados com fundamental completo
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "P_MED")); //% de empregados com médio completo
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "REN1")); //% com até 1 s.m. 
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "REN2")); //% com até 2 s.m. 
        //array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "THEILtrab")); //% Theil dos rendimentos do trabalho  

        $block_table_trabalho->setData("titulo", "");
        $block_table_trabalho->setData("fonte", TextBuilder_ES::$fontePerfil);
        $block_table_trabalho->setData("caption", "Ocupación de la población de 18 años o más");//@Translate
        $block_table_trabalho->setData("titulo1", "Nivel de educación de los ocupados");//@Translate
        $block_table_trabalho->setData("titulo2", "Ingreso promedio");//@Translate
        $block_table_trabalho->setData("t", "");
        $block_table_trabalho->setData("municipio", TextBuilder_ES::$nomeMunicipio . " - " . TextBuilder_ES::$ufMunicipio);
        
        Formulas::printTableTrabalho($block_table_trabalho, $variaveis);
    }
    
    static public function generateTRABALHO2($block_trabalho) {

        $p_agro = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "P_AGRO");  //P_AGRO 
        $p_extr = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "P_EXTR");  //P_EXTR
        $p_transf = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "P_TRANSF");  //P_TRANSF
        $p_constr = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "P_CONSTR"); //P_CONSTR
        $p_siup = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "P_SIUP");  //P_SIUP
        $p_com = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "P_COM");  //P_COM
        $p_serv = TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "P_SERV");  //P_SERV
        
        $block_trabalho->setData("titulo", "");
        $block_trabalho->setData("canvasContent", "");
        $block_trabalho->setData("subtitulo", "");
        $block_trabalho->setData("info", "");

        //@Translate
        $str2 = "En 2010, de las personas ocupadas de 18 años o más, un [p_agro_10]% trabajaba en el sector agropecuario, un [p_extr_10]%
            en la industria extractiva, un [p_transf_10]% en la industria de transformación, un [p_constr_10]% en el sector de la construcción, un [p_siup_10]%
            en sectores de utilidad pública, un [p_com_10]%
            en el comercio y un [p_serv_10]% en el sector de servicios.";
        $texto2 = new Texto($str2);
        
        $texto2->replaceTags("p_agro_10", Formulas::getPAgro10($p_agro));
        $texto2->replaceTags("p_extr_10", Formulas::getPExtr10($p_extr));
        $texto2->replaceTags("p_transf_10", Formulas::getPTransf10($p_transf));
        $texto2->replaceTags("p_constr_10", Formulas::getPConstr10($p_constr));
        $texto2->replaceTags("p_siup_10", Formulas::getPSiup10($p_siup));
        $texto2->replaceTags("p_com_10", Formulas::getPCom10($p_com));
        $texto2->replaceTags("p_serv_10", Formulas::getPServ10($p_serv));
        
        $block_trabalho->setData("text2", $texto2->getTexto());
        $block_trabalho->setData("text1", "");

        
    }

    static public function generateHABITACAO($block_habitacao) {

        if (TextBuilder_ES::$print){ 
            $block_habitacao->setData("quebra", "<div style='page-break-after: always'></div>");
        }else
            $block_habitacao->setData("quebra", "");
        
        $block_habitacao->setData("fonte", TextBuilder_ES::$fontePerfil);
        $block_habitacao->setData("titulo", "Vivienda");//@Translate
        $block_habitacao->setData("subtitulo", "");
        $block_habitacao->setData("info", "");
        $block_habitacao->setData("tableContent", "");

    }

    static public function generateIDH_table_habitacao($block_table_habitacao) {

        $variaveis = array();
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_AGUA")); //água encanada
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_LUZ")); //energia elétrica
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_LIXO")); //coleta de lixo*

        $block_table_habitacao->setData("titulo", "");
        $block_table_habitacao->setData("fonte", TextBuilder_ES::$fontePerfil);
        $block_table_habitacao->setData("caption", "Indicadores de vivienda");//@Translate
        $block_table_habitacao->setData("municipio", TextBuilder_ES::$nomeMunicipio . " - " . TextBuilder_ES::$ufMunicipio);
        
        //@Translate
        $texto = " *Solo para la población urbana";
        Formulas::printTableHabitacao($block_table_habitacao, $variaveis, $texto);
        
         if (TextBuilder_ES::$print){ 
            $block_table_habitacao->setData("quebra", "<div style='page-break-after: always'></div>");
        }else
            $block_table_habitacao->setData("quebra", "");

    }

    static public function generateVULNERABILIDADE($block_vulnerabilidade) {

        if (TextBuilder_ES::$print){ 
            $block_vulnerabilidade->setData("quebra", "<div style='page-break-after: always'></div>");
        }else
            $block_vulnerabilidade->setData("quebra", "");
        
        $block_vulnerabilidade->setData("fonte", TextBuilder_ES::$fontePerfil);
        $block_vulnerabilidade->setData("titulo", "Vulnerabilidad social");//@Translate
        $block_vulnerabilidade->setData("subtitulo", "");
        $block_vulnerabilidade->setData("info", "");

        $block_vulnerabilidade->setData("tableContent", "");
    }

    static public function generateIDH_table_vulnerabilidade($block_table_vulnerabilidade) {

        $variaveis = array();
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "MORT1")); //Mortalidade infantil
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_FORA4A5")); //Percentual de pessoas de 4 a 5 anos de idade fora da escola
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_FORA6A14")); //Percentual de pessoas de 6 a 14 anos de idade fora da escola
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_NESTUDA_NTRAB_MMEIO")); //Percentual de pessoas de 15 a 24 anos de idade que não estuda e não trabalha e cuja renda per capita <½  salário mínimo
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_M10A14CF")); //Percentual de mulheres de 10 a 14 anos de idade que tiveram filhos
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_M15A17CF")); //Percentual de mulheres de 15 a 17 anos de idade que tiveram filhos
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_ATIV1014")); //Taxa de atividade de crianças e jovens que possuem entre 10 e 14 anos de idade
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_MULCHEFEFIF014")); //Percentual de mães chefes de família sem fundamental completo com filhos menores de 15 anos 
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_RMAXIDOSO")); //Percentual de pessoas em domicílios com renda per capita < ½ salário mínimo e cuja principal renda é de pessoa com 65 anos ou mais
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PINDCRI")); //Percentual de crianças que vivem em extrema pobreza, ou seja, em domicílios com renda per capita abaixo de R% 70,00.
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "PPOB")); //#XXPercentual de pessoas em domicílios com renda per capita inferior a R$ 225,00 (1/2 salário mínimo em agosto/2010)
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "T_FUNDIN18MINF")); //Percentual de pessoas de 18 anos ou mais sem fundamental completo e em ocupação informal
        array_push($variaveis, TextBuilder_ES::getVariaveis_table(TextBuilder_ES::$idMunicipio, "AGUA_ESGOTO")); //Percentual de pessoas em domicílios cujo abastecimento de água não seja por rede geral ou esgotamento sanitário não realizado por rede coletora de esgoto ou fossa séptica

        $block_table_vulnerabilidade->setData("titulo", "Niños y jóvenes");//@Translate
        $block_table_vulnerabilidade->setData("titulo1", "Familia");//@Translate
        $block_table_vulnerabilidade->setData("titulo2", "Trabajo e ingresos");//@Translate
        $block_table_vulnerabilidade->setData("titulo3", "Condiciones de vivienda");//@Translate
        $block_table_vulnerabilidade->setData("fonte", TextBuilder_ES::$fontePerfil);
        $block_table_vulnerabilidade->setData("t", "");
        $block_table_vulnerabilidade->setData("caption", "Vulnerabilidad social");//@Translate
        $block_table_vulnerabilidade->setData("municipio", TextBuilder_ES::$nomeMunicipio . " - " . TextBuilder_ES::$ufMunicipio);
        
        Formulas::printTableVulnerabilidade($block_table_vulnerabilidade, $variaveis);
    }
    
    static function my_number_format($number,$decimais=2,$separador_decimal=",",$separador_milhar="."){ 
        // Número vazio? 
        if(trim($number)=="") return $number; 
        // se for um double precisamos garantir que não será covertido em 
        // notação científica e que valores terminados em .90 tenha o zero removido 
        if(is_float($number) || is_double($number)){ 
        $number = sprintf("%.{$decimais}f",$number); 
        } 
        // Convertendo para uma string numérica 
        $number = preg_replace('#\D#','',$number); 

        // separando a parte decimal 
        $decimal=''; 
        if($decimais>0){ 
        $number = sprintf("%.{$decimais}f",($number / pow(10,$decimais))); 
        if(preg_match("#^(\d+)\D(\d{{$decimais}})$#",$number,$matches)){ 
        $decimal=$separador_decimal . $matches[2]; 
        $number=$matches[1]; 
        } 
        } 
        // formatando a parte inteira 
        if($separador_milhar!=''){ 
        $number = implode($separador_milhar,array_reverse(array_map('strrev',str_split(strrev($number),3)))); 
        } 
        return $number . $decimal; 
    } 
    
    static function getVariaveis_table($municipio, $variavel) {

        $SQL = "SELECT label_ano_referencia, lang_var.nomecurto,  lang_var.nome_perfil, lang_var.definicao, valor
                FROM valor_variavel_mun INNER JOIN variavel
                ON fk_variavel = variavel.id
                INNER JOIN ano_referencia
                ON ano_referencia.id = fk_ano_referencia
                INNER JOIN lang_var
                ON variavel.id = lang_var.fk_variavel
                WHERE fk_municipio = $municipio and sigla like '$variavel' and lang like '". TextBuilder_ES::$lang ."'
                 ORDER BY label_ano_referencia";

        //echo $SQL . "<br><br>"; 
        return TextBuilder_ES::$bd->ExecutarSQL($SQL, "getVariaveis_table");
    }

    static function getVariaveis_Uf($municipio, $variavel) {

        $SQL = "SELECT label_ano_referencia, nomecurto, valor 
                FROM valor_variavel_estado
                INNER JOIN municipio
                ON municipio.fk_estado = valor_variavel_estado.fk_estado
                INNER JOIN variavel
                ON fk_variavel = variavel.id
                INNER JOIN ano_referencia
                ON ano_referencia.id = fk_ano_referencia
                WHERE municipio.id = $municipio and sigla like '$variavel'
                 ORDER BY label_ano_referencia;";

        return TextBuilder_ES::$bd->ExecutarSQL($SQL, "getVariaveis_Uf");
    }

    static function getVariaveis_Brasil($municipio, $variavel) {

        $SQL = "SELECT label_ano_referencia, nomecurto, valor 
                FROM valor_variavel_pais
                INNER JOIN pais
                ON pais.id = valor_variavel_pais.fk_pais
                INNER JOIN estado
                ON pais.id = estado.fk_pais
                INNER JOIN municipio
                ON municipio.fk_estado = estado.id
                INNER JOIN variavel
                ON fk_variavel = variavel.id
                INNER JOIN ano_referencia
                ON ano_referencia.id = fk_ano_referencia
                WHERE municipio.id = $municipio and variavel.sigla like '$variavel' ORDER BY label_ano_referencia;";

        return TextBuilder_ES::$bd->ExecutarSQL($SQL, "getVariaveis_Brasil");
    }
    
    static function getRanking() {

        $SQL = "SELECT ROW_NUMBER() OVER(ORDER BY valor DESC, municipio.nome ASC), municipio.id, municipio.nome, nomecurto, valor 
        FROM valor_variavel_mun INNER JOIN variavel
        ON fk_variavel = variavel.id
        INNER JOIN municipio
        ON municipio.id = valor_variavel_mun.fk_municipio
        WHERE sigla like 'IDHM' AND fk_ano_referencia = 3;";

        return TextBuilder_ES::$bd->ExecutarSQL($SQL, "getRanking");
    }

    static function getUf($municipio) {

        $SQL = "SELECT estado.id, estado.nome
            FROM municipio
            INNER JOIN estado
            ON estado.id = municipio.fk_estado
            WHERE municipio.id= $municipio;";

        return TextBuilder_ES::$bd->ExecutarSQL($SQL, "getRanking");
    }

    static function getRankingUf($estado) {

        $SQL = "SELECT ROW_NUMBER() OVER(ORDER BY valor DESC, municipio.nome ASC), municipio.id, municipio.nome, estado.id as id_uf, estado.nome, nomecurto, valor 
            FROM valor_variavel_mun INNER JOIN variavel
            ON fk_variavel = variavel.id
            INNER JOIN municipio
            ON municipio.id = valor_variavel_mun.fk_municipio
            INNER JOIN estado
            ON estado.id = municipio.fk_estado
            WHERE sigla like 'IDHM' AND fk_ano_referencia = 3 AND estado.id= $estado;";

        return TextBuilder_ES::$bd->ExecutarSQL($SQL, "getRanking");
    }

    static function getIDHM_Igual($idhm) {

        $SQL = "SELECT municipio.id, municipio.nome, nomecurto, valor 
            FROM valor_variavel_mun INNER JOIN variavel
            ON fk_variavel = variavel.id
            INNER JOIN municipio
            ON municipio.id = valor_variavel_mun.fk_municipio
            WHERE valor = $idhm AND fk_ano_referencia = 3
            ORDER BY  municipio.nome ASC";

        return TextBuilder_ES::$bd->ExecutarSQL($SQL, "getIDHM_Igual");
    }

    static function getIDHM_Igual_Uf($idhm, $estado) {

        $SQL = "SELECT municipio.id, municipio.nome, nomecurto, valor 
            FROM valor_variavel_mun INNER JOIN variavel
            ON fk_variavel = variavel.id
            INNER JOIN municipio
            ON municipio.id = valor_variavel_mun.fk_municipio
            INNER JOIN estado
            ON estado.id = municipio.fk_estado
            WHERE valor = $idhm AND fk_ano_referencia = 3 AND estado.id = $estado 
            ORDER BY  municipio.nome ASC";

        return TextBuilder_ES::$bd->ExecutarSQL($SQL, "getIDHM_Igual");
    } 

}

?>
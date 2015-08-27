<?php

require_once BASE_ROOT . 'config/config_path.php';
require_once PERFIL_PACKAGE . 'controller/Texto.class.php';
require_once PERFIL_PACKAGE . 'controller/itEstrutura/IT.class.php';
require_once PERFIL_PACKAGE . 'controller/itEstrutura/Chart.class.php';
require_once PERFIL_PACKAGE . 'controller/itEstrutura/ITCaracterizacao.class.php';
require_once PERFIL_PACKAGE . 'controller/itEstrutura/ITComponentes.class.php';
require_once PERFIL_PACKAGE . 'controller/itEstrutura/ITComparacao.class.php';
require_once PERFIL_PACKAGE . 'controller/itEstrutura/ITEvolucao.class.php';
require_once PERFIL_PACKAGE . 'controller/itEstrutura/ITRanking.class.php';
require_once PERFIL_PACKAGE . 'controller/itEstrutura/ITPopulacao.class.php';
require_once PERFIL_PACKAGE . 'controller/itEstrutura/ITEstruturaEtaria.class.php';
require_once PERFIL_PACKAGE . 'controller/itEstrutura/ITLongMortFecund.class.php';
require_once PERFIL_PACKAGE . 'controller/itEstrutura/ITCriancasJovens.class.php';
require_once PERFIL_PACKAGE . 'controller/itEstrutura/ITPopulacaoAdulta.class.php';
//require_once PERFIL_PACKAGE . 'controller/itEstrutura/ITAnosEsperados.class.php';
require_once PERFIL_PACKAGE . 'controller/itEstrutura/ITExpectativaAnosEstudo.class.php';
require_once PERFIL_PACKAGE . 'controller/itEstrutura/ITRenda.class.php';
require_once PERFIL_PACKAGE . 'controller/itEstrutura/ITTrabalho.class.php';
require_once PERFIL_PACKAGE . 'controller/itEstrutura/ITHabitacao.class.php';
require_once PERFIL_PACKAGE . 'controller/itEstrutura/ITVulnerabilidade.class.php';
require_once BASE_ROOT . 'config/config_gerais.php';
require_once PERFIL_PACKAGE . 'model/bd.class.php';
//require_once MOBILITI_PACKAGE . 'display/controller/chart/chartsPerfil.php';
require_once PERFIL_PACKAGE . 'controller/Formulas.class.php';

//define("PATH_DIRETORIO", $path_dir);
/**
 * Description of GerenateTexts
 *
 * @author Andre Castro (versÃ£o 2)
 */
class TextBuilder {

    static public $idMunicipio = 0;
    static public $nomeMunicipio = "";
    static public $ufMunicipio = "";
    static public $bd;
    static public $print;
    static public $lang;
    static public $type;
    static public $aba;
    //VariÃ¡vel de configuraÃ§Ã£o da Fonte de Dados do perfil
    static public $fontePerfil = "Fonte: PNUD, Ipea e FJP"; //@#Menos template 5

    static public function generateIDH_componente($block_componente) {


        if (TextBuilder::$print) {
            $block_componente->setData("quebra", "<div style='page-break-after: always;'></div>");
        } else
            $block_componente->setData("quebra", "");

        $block_componente->setData("fonte", TextBuilder::$fontePerfil);
        $block_componente->setData("titulo", TextBuilder::$aba->getTitulo()); //@Translate
        $block_componente->setData("subtitulo", TextBuilder::$aba->getSubTitulo()); //@Translate
        $block_componente->setData("canvasContent", TextBuilder::$aba->getChartDesenvolvimentoHumano(TextBuilder::$idMunicipio));
        $block_componente->setData("info", "");

        $idhm = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "IDHM"); //IDHM
        $idhm_r = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "IDHM_R"); //IDHM_R
        $idhm_l = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "IDHM_L"); //IDHM_L
        $idhm_e = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "IDHM_E"); //IDHM_E
        //@Translate
        $str = TextBuilder::$aba->getTexto();
        $texto = new Texto($str);

        $texto->replaceTags("2010", Formulas::getLabelAno2010($idhm));
        $texto->replaceTags("municipio", TextBuilder::$nomeMunicipio);

        $mDaUdh = TextBuilder::getMUN_udh(TextBuilder::$idMunicipio);
        if(isset($mDaUdh[0]) && count($mDaUdh[0]) > 0) {
            $mDaUdh_nome = $mDaUdh[0]["nome"];
        } else {
            $mDaUdh_nome = '';
        }
        $texto->replaceTags("municipio_udh", $mDaUdh_nome);
        
        $rmDaUdh = TextBuilder::getRM_udh(TextBuilder::$idMunicipio);
		
		if(empty ($rmDaUdh[0]["nome"])) 
        	$texto->replaceTags("rm",$mDaUdh_nome);
		else 
			$texto->replaceTags("rm",$rmDaUdh[0]["nome"]);
			
        $texto->replaceTags("idh", Formulas::getIDH2010($idhm));
        $texto->replaceTags("Faixa_DH", Formulas::getSituacaoIDH($idhm, TextBuilder::$lang));
        $texto->replaceTags("Dimensao2010", Formulas::getDimensao2010(TextBuilder::$lang, $idhm_r, $idhm_l, $idhm_e));

        //$texto->replaceTags("Dimensao2000a2010", Formulas::getDimensao(TextBuilder::$lang, $idhm_r, $idhm_l, $idhm_e, array("faixa0010" => true, "faixa9100" => false)));
        //$texto->replaceTags("Dimensao1991a2000", Formulas::getDimensao(TextBuilder::$lang, $idhm_r, $idhm_l, $idhm_e, array("faixa0010" => false, "faixa9100" => true)));
        //Novo trecho criado para apresentaÃ§Ã£o inicial de RMs e UDHs ---------------------
        if (TextBuilder::$type == "perfil_rm" || TextBuilder::$type == "perfil_udh") {

            $strShow = TextBuilder::$aba->getTextoShow();
            $textoShow = new Texto($strShow);

            if (TextBuilder::$type == "perfil_udh") {
                $rmDaUdh = TextBuilder::getRM_udh(TextBuilder::$idMunicipio);
                $textoShow->replaceTags("nome_rm", $rmDaUdh[0]["nome"]);
                $municipios = TextBuilder::getMunicipios_rm($rmDaUdh[0]["id"]);
            } else
                $municipios = TextBuilder::getMunicipios_rm(TextBuilder::$idMunicipio);

            //URL - Busca ------------
            $server = $_SERVER['SERVER_NAME'];
            $endereco = $_SERVER ['REQUEST_URI'];
            $pieces = explode("/", $endereco);
            $urlAtual = "http://" . $server . "/" . $pieces[1] . "/" . TextBuilder::$lang . "/perfil_m/";
            //-----------------------------

            $textMunicipios = "";
            foreach ($municipios as &$value) {
                // if ($value["id"] == TextBuilder::$idMunicipio)
                $textMunicipios .= "<a href='" . $urlAtual . $value["id"] . "' target='blank'>" . $value["nome"] . " (" . $value["uf"] . ")" . "</a>, ";
            }

            $textoShow->replaceTags("municipios", $textMunicipios);
            $textoShow->replaceTags("esp_count", sizeof($municipios));
            $textoShow->replaceTags("esp", TextBuilder::$nomeMunicipio);
            $block_componente->setData("text_show", $textoShow->getTexto());
        } else
            $block_componente->setData("text_show", "");
        //----------------------------------------------------------------

        $block_componente->setData("text", $texto->getTexto());
    }

    static public function generateIDH_table_componente($block_table_componente) {

        $variaveis = array();

        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "IDHM_E")); //IDHM EducaÃ§Ã£o
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FUND18M")); //"% de 18 ou mais anos com fundamental completo"
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FREQ5A6")); //% de 5 a 6 anos na escola
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FUND11A13")); //% de 12 a 14 anos nos anos finais do fundamental
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FUND15A17")); //% de 16 a 18 anos com fundamental completo
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_MED18A20")); //% de 19 a 21 anos com mÃ©dio completo
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "IDHM_L")); //IDHM Longevidade
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "ESPVIDA")); //EsperanÃ§a de vida ao nascer
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "IDHM_R")); //IDHM Renda
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "RDPC")); //Renda per capita

        $block_table_componente->setData("titulo", TextBuilder::$aba->getTituloTable()); //@Translate
        $block_table_componente->setData("caption", TextBuilder::$aba->getCaption()); //@Translate
        $block_table_componente->setData("fonte", TextBuilder::$fontePerfil);

        if (TextBuilder::$type == "perfil_rm" || TextBuilder::$type == "perfil_uf") {
            $block_table_componente->setData("municipio", TextBuilder::$nomeMunicipio);
        } else {
            $block_table_componente->setData("municipio", TextBuilder::$nomeMunicipio . " - " . TextBuilder::$ufMunicipio);
        }

        Formulas::printTableComponente($block_table_componente, $variaveis, TextBuilder::$type);
    }

    static public function generateComparacao($block_comparacao) {

        $idhm = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "IDHM"); //IDHM

        $block_comparacao->setData("subtitulo", TextBuilder::$aba->getSubTitulo()); //@Translate
        $block_comparacao->setData("info", "");
        $block_comparacao->setData("fonte", TextBuilder::$fontePerfil);
        //@Translate
        $str = TextBuilder::$aba->getTexto();

        $texto = new Texto($str);

//        $texto->replaceTags("municipio", TextBuilder::$nomeMunicipio);
//        $texto->replaceTags("estado_municipio", $uf[0]["nome"]);

        $texto->replaceTags("idhm10", Formulas::getIDH2010($idhm));

        //MunicÃ­pio e RM em que a UDH estÃ¡ situada
        $mun_da_udh = TextBuilder::getMUN_udh(TextBuilder::$idMunicipio);
        $rm_da_udh = TextBuilder::getRM_udh(TextBuilder::$idMunicipio);


        $minValueRM = TextBuilder::getMaiorMenorIDHM_UDH("rm", $rm_da_udh[0]["id"], "ASC");
        $maxValueRM = TextBuilder::getMaiorMenorIDHM_UDH("rm", $rm_da_udh[0]["id"], "DESC");
        $minValueMun = TextBuilder::getMaiorMenorIDHM_UDH("mun", $mun_da_udh[0]["id"], "ASC");
        $maxValueMun = TextBuilder::getMaiorMenorIDHM_UDH("mun", $mun_da_udh[0]["id"], "DESC");

        $idhm_mun = TextBuilder::getVariaveis_tablePersonalizado($mun_da_udh[0]["id"], "IDHM", "perfil_m"); //PESOTOT
        $idhm_rm = TextBuilder::getVariaveis_tablePersonalizado($rm_da_udh[0]["id"], "IDHM", "perfil_rm"); //PESOTOT

        $texto->replaceTags("idhm10_mun_udh", Formulas::getIDH2010($idhm_mun));
        $texto->replaceTags("idhm10_rm_udh", Formulas::getIDH2010($idhm_rm));

        $texto->replaceTags("hiato10", number_format((1 - $idhm[2]["valor"]), 3, ",", ".")); //<(1-IDHM 2010)>

        $block_comparacao->setData("text", $texto->getTexto());
        $block_comparacao->setData("canvasContent", TextBuilder::$aba->getChartComparacao(TextBuilder::$nomeMunicipio, $idhm[2]["valor"], $mun_da_udh[0]["nome"], $minValueMun[0]["valor"], $maxValueMun[0]["valor"], $rm_da_udh[0]["nome"], $minValueRM[0]["valor"], $maxValueRM[0]["valor"]));
    }

    static public function generateIDH_evolucao($block_evolucao) {

        $idhm = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "IDHM"); //IDHM

        $idhm_r = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "IDHM_R"); //IDHM_R
        $idhm_l = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "IDHM_L"); //IDHM_L
        $idhm_e = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "IDHM_E"); //IDHM_E

        if (TextBuilder::$type == "perfil_udh")
            $idhm_rm = TextBuilder::getVariaveis_RM(TextBuilder::$idMunicipio, "IDHM"); //IDHM do Estado
        else
            $idhm_uf = TextBuilder::getVariaveis_Uf(TextBuilder::$idMunicipio, "IDHM"); //IDHM do Estado

        $idhm_brasil = TextBuilder::getVariaveis_Brasil("IDHM"); //IDHM do Brasil
        $idhm_r_br = TextBuilder::getVariaveis_Brasil("IDHM_R"); //IDHM_R
        $idhm_l_br = TextBuilder::getVariaveis_Brasil("IDHM_L"); //IDHM_L
        $idhm_e_br = TextBuilder::getVariaveis_Brasil("IDHM_E"); //IDHM_E

        $block_evolucao->setData("subtitulo", TextBuilder::$aba->getSubTitulo()); //@Translate
        $block_evolucao->setData("fonte", TextBuilder::$fontePerfil);
        //----------------------------------------------------------------------------------------
        //EvoluÃ§Ã£o entre os anos de 2000 e 2010
        $block_evolucao->setData("info1", "");

        if (TextBuilder::$type != "perfil_rm") {

            //@Translate
            $str1 = TextBuilder::$aba->getTexto();

            $texto1 = new Texto($str1);
            $texto1->replaceTags("municipio", TextBuilder::$nomeMunicipio);

            $texto1->replaceTags("IDHM2000", Formulas::getIDH2000($idhm));
            $texto1->replaceTags("IDHM2010", Formulas::getIDH2010($idhm));
            $texto1->replaceTags("Tx_crescimento_0010", Formulas::getTaxaCrescimento0010($idhm));

            //CÃ¡lculo do HIATO
            //$reducao_hiato_0010 = (($idhm[2]["valor"] - $idhm[1]["valor"]) / (1 - $idhm[1]["valor"])) * 100;
            $texto1->replaceTags("reducao_hiato_0010", Formulas::getReducaoHiato0010($idhm));

            //print_r(Formulas::getReducaoHiato0010puro($idhm)); die();
            if (Formulas::getReducaoHiato0010puro($idhm) >= 0)
                $texto1->replaceTags("reduzido_aumentado", TextBuilder::$aba->getReduzido()); //@Translate
            else
                $texto1->replaceTags("reduzido_aumentado", TextBuilder::$aba->getAumentado()); //@Translate

            $texto1->replaceTags("Dimensao2000a2010", Formulas::getDimensao(TextBuilder::$lang, $idhm_r, $idhm_l, $idhm_e, array("faixa0010" => true, "faixa9100" => false, "faixa9110" => false)));

            $block_evolucao->setData("text1", $texto1->getTexto());

            //----------------------------------------------------------------------------------------
            //EvoluÃ§Ã£o entre os anos de 1991 e 2000
            $block_evolucao->setData("info2", "");

            //@Translate
            $str2 = TextBuilder::$aba->getTexto2();

            $texto2 = new Texto($str2);
            $texto2->replaceTags("municipio", TextBuilder::$nomeMunicipio);

            $texto2->replaceTags("IDHM1991", Formulas::getIDH1991($idhm));
            $texto2->replaceTags("IDHM2000", Formulas::getIDH2000($idhm));

            //@NÃ£oInclusoEmRM&UDH
            if (TextBuilder::$type != "perfil_rm" && TextBuilder::$type != "perfil_udh")
                $texto2->replaceTags("Tx_crescimento_9100", Formulas::getTaxaCrescimento9100($idhm));

            //CÃ¡lculo do HIATO
            //$reducao_hiato_9100 = (($idhm[1]["valor"] - $idhm[0]["valor"]) / (1 - $idhm[0]["valor"])) * 100;
            $texto2->replaceTags("reducao_hiato_9100", Formulas::getReducaoHiato9100($idhm));

            if (Formulas::getReducaoHiato9100puro($idhm) >= 0)
                $texto2->replaceTags("reduzido_aumentado", TextBuilder::$aba->getReduzido()); //@Translate
            else
                $texto2->replaceTags("reduzido_aumentado", TextBuilder::$aba->getAumentado()); //@Translate

            $texto2->replaceTags("Dimensao1991a2000", Formulas::getDimensao(TextBuilder::$lang, $idhm_r, $idhm_l, $idhm_e, array("faixa0010" => false, "faixa9100" => true, "faixa9110" => false)));

            $block_evolucao->setData("text2", $texto2->getTexto());
        }
        //----------------------------------------------------------------------------------------
        //EvoluÃ§Ã£o entre os anos de 1991 e 2010
        $block_evolucao->setData("info3", "");

        //@Translate
        $str3 = TextBuilder::$aba->getTexto3();

        $texto3 = new Texto($str3);
        $texto3->replaceTags("municipio", TextBuilder::$nomeMunicipio);

        $texto3->replaceTags("idhm_uf_91", number_format($idhm[0]["valor"], 3, ",", "."));
        $texto3->replaceTags("idhm_uf_00", number_format($idhm[1]["valor"], 3, ",", "."));
        $texto3->replaceTags("idhm_uf_10", number_format($idhm[2]["valor"], 3, ",", "."));

        $texto3->replaceTags("idhm_br_91", number_format($idhm_brasil[0]["valor"], 3, ",", "."));
        $texto3->replaceTags("idhm_br_00", number_format($idhm_brasil[1]["valor"], 3, ",", "."));
        $texto3->replaceTags("idhm_br_10", number_format($idhm_brasil[2]["valor"], 3, ",", "."));

        $texto3->replaceTags("Tx_crescimento_0010", Formulas::getTaxaCrescimento0010($idhm));

        //Taxa de Crescimento
        //@NÃ£oInclusoEmRM&UDH
        if (TextBuilder::$type != "perfil_rm" && TextBuilder::$type != "perfil_udh") {
            $tx_cresc_9110 = Formulas::getTaxaCrescimento9110($idhm);
            $texto3->replaceTags("Tx_crescimento_9110", $tx_cresc_9110);


            //----------------------------------------
            //Taxa de Crescimento em relaÃ§Ã£o ao BRASIL
            $tx_cresc_Brasil9110 = Formulas::getTaxaCrescimento9110BRASIL($idhm_brasil);

            if ($tx_cresc_Brasil9110 < $tx_cresc_9110) {
                $texto3->replaceTags("tx_cresc_Brasil9110", abs($tx_cresc_Brasil9110));
                $texto3->replaceTags("abaixo_acima", TextBuilder::$aba->getAcima()); //@Translate
            } else if ($tx_cresc_Brasil9110 == $tx_cresc_9110) {
                $texto3->replaceTags("tx_cresc_Brasil9110", abs($tx_cresc_Brasil9110));
                $texto3->replaceTags("abaixo_acima", TextBuilder::$aba->getIgual()); //@Translate
            } else if ($tx_cresc_Brasil9110 > $tx_cresc_9110) {
                $texto3->replaceTags("tx_cresc_Brasil9110", abs($tx_cresc_Brasil9110));
                $texto3->replaceTags("abaixo_acima", TextBuilder::$aba->getAbaixo()); //@Translate
            }

            //----------------------------------------
            //Taxa de Crescimento em relaÃ§Ã£o ao ESTADO
            if (TextBuilder::$type == "perfil_udh")
                $tx_cresc_UfRm9110 = Formulas::getTaxaCrescimento9110UfRm($idhm_rm);
            else
                $tx_cresc_UfRm9110 = Formulas::getTaxaCrescimento9110UfRm($idhm_uf);

            if ($tx_cresc_UfRm9110 < $tx_cresc_9110) {
                $texto3->replaceTags("abaixo_acima_uf", TextBuilder::$aba->getAcima()); //@Translate
                $texto3->replaceTags("tx_cresc_Estado9110", abs($tx_cresc_UfRm9110));
            } else if ($tx_cresc_UfRm9110 == $tx_cresc_9110) {
                $texto3->replaceTags("tx_cresc_Estado9110", abs($tx_cresc_UfRm9110));
                $texto3->replaceTags("abaixo_acima_uf", TextBuilder::$aba->getIgual()); //@Translate
            } else if ($tx_cresc_UfRm9110 > $tx_cresc_9110) {
                $texto3->replaceTags("abaixo_acima_uf", TextBuilder::$aba->getAbaixo()); //@Translate
                $texto3->replaceTags("tx_cresc_Estado9110", abs($tx_cresc_UfRm9110));
            }
        }//@NÃ£oInclusoEmRM&UDH
        //
        //
        
        $tx_cresc_0010 = Formulas::getTaxaCrescimento0010($idhm);
        //----------------------------------------
        //Taxa de Crescimento em relaÃ§Ã£o ao BRASIL
        $tx_cresc_Brasil0010 = Formulas::getTaxaCrescimento0010BRASIL($idhm_brasil);

        if ($tx_cresc_Brasil0010 < $tx_cresc_0010) {
            $texto3->replaceTags("tx_cresc_Brasil0010", abs($tx_cresc_Brasil0010));
            $texto3->replaceTags("abaixo_acima", TextBuilder::$aba->getAcima()); //@Translate
        } else if ($tx_cresc_Brasil0010 == $tx_cresc_0010) {
            $texto3->replaceTags("tx_cresc_Brasil0010", abs($tx_cresc_Brasil0010));
            $texto3->replaceTags("abaixo_acima", TextBuilder::$aba->getIgual()); //@Translate
        } else if ($tx_cresc_Brasil0010 > $tx_cresc_0010) {
            $texto3->replaceTags("tx_cresc_Brasil0010", abs($tx_cresc_Brasil0010));
            $texto3->replaceTags("abaixo_acima", TextBuilder::$aba->getAbaixo()); //@Translate
        }

        //CÃ¡lculo do HIATO
        //$reducao_hiato_9110 = (($idhm[2]["valor"] - $idhm[0]["valor"]) / (1 - $idhm[0]["valor"])) * 100;
        $texto3->replaceTags("reducao_hiato_9110", Formulas::getReducaoHiato9110($idhm));
        $texto3->replaceTags("reducao_hiato_0010", Formulas::getReducaoHiato0010($idhm));

        $texto3->replaceTags("reducao_hiato_brasil_9110", Formulas::getReducaoHiato9110($idhm_brasil));
        $texto3->replaceTags("reducao_hiato_brasil_0010", Formulas::getReducaoHiato0010($idhm_brasil));

        $texto3->replaceTags("Dimensao1991a2000", Formulas::getDimensao(TextBuilder::$lang, $idhm_r, $idhm_l, $idhm_e, array("faixa0010" => false, "faixa9100" => false, "faixa9110" => true)));
        $texto3->replaceTags("Dimensao2000a2010", Formulas::getDimensao(TextBuilder::$lang, $idhm_r, $idhm_l, $idhm_e, array("faixa0010" => true, "faixa9100" => false, "faixa9110" => false)));

        $texto3->replaceTags("Dimensao1991a2000_br", Formulas::getDimensao(TextBuilder::$lang, $idhm_r_br, $idhm_l_br, $idhm_e_br, array("faixa0010" => false, "faixa9100" => false, "faixa9110" => true)));
        $texto3->replaceTags("Dimensao2000a2010_br", Formulas::getDimensao(TextBuilder::$lang, $idhm_r_br, $idhm_l_br, $idhm_e_br, array("faixa0010" => true, "faixa9100" => false, "faixa9110" => false)));


        if (Formulas::getReducaoHiato9110puro($idhm) >= 0)
            $texto3->replaceTags("reduzido_aumentado", TextBuilder::$aba->getReduzido()); //@Translate
        else
            $texto3->replaceTags("reduzido_aumentado", TextBuilder::$aba->getAumentado()); //@Translate

        $block_evolucao->setData("text3", $texto3->getTexto());

        if (TextBuilder::$print) {
            $block_evolucao->setData("quebra", "<div style='page-break-after: always'></div>");
        } else
            $block_evolucao->setData("quebra", "");

        $block_evolucao->setData("canvasContent", TextBuilder::$aba->getChartEvolucao(TextBuilder::$idMunicipio));
    }

    static public function generateIDH_table_taxa_hiato($block_table_taxa_hiato) {

        $idhm = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "IDHM"); //IDHM

        $block_table_taxa_hiato->setData("titulo", "");
        $block_table_taxa_hiato->setData("fonte", TextBuilder::$fontePerfil);
        $block_table_taxa_hiato->setData("ano1", TextBuilder::$aba->getTitulotable1()); //@Translate
        $block_table_taxa_hiato->setData("ano2", TextBuilder::$aba->getTitulotable2()); //@Translate
        //@NÃ£oInclusoEmRM&UDH
        if (TextBuilder::$type != "perfil_rm" && TextBuilder::$type != "perfil_udh") {
            $taxa9100 = Formulas::getTaxa9100($idhm);
            $reducao_hiato_9100 = Formulas::getReducaoHiato9100($idhm);
            $block_table_taxa_hiato->setData("v1", TextBuilder::$aba->getEntre9100()); //@Translate
            Formulas::printTableTaxaHiatoEntre9100($block_table_taxa_hiato, $taxa9100, $reducao_hiato_9100);
        }

        $taxa0010 = Formulas::getTaxa0010($idhm);
        $taxa9110 = Formulas::getTaxa9110($idhm);

        $reducao_hiato_0010 = Formulas::getReducaoHiato0010($idhm);

        $reducao_hiato_9110 = Formulas::getReducaoHiato9110($idhm);

        //TODO: FAZER O MAIS E MENOS DA TAXA E HIATO UTILIZANDO IMAGENS      

        $block_table_taxa_hiato->setData("v2", TextBuilder::$aba->getEntre0010()); //@Translate

        Formulas::printTableTaxaHiatoEntre0010($block_table_taxa_hiato, $taxa0010, $reducao_hiato_0010);

        $block_table_taxa_hiato->setData("v3", TextBuilder::$aba->getEntre9110()); //@Translate

        Formulas::printTableTaxaHiatoEntre9110($block_table_taxa_hiato, $taxa9110, $reducao_hiato_9110);
    }

    static public function generateIDH_ranking($block_ranking) {

        $ranking = TextBuilder::getRanking("todos"); //IDHM
        $ranking_first = TextBuilder::getRanking("primeiro"); //IDHM
        $ranking_last = TextBuilder::getRanking("ultimo"); //IDHM
        //die();
        //$uf = TextBuilder::getUf(TextBuilder::$idMunicipio); //IDHM
        //$ranking_uf = TextBuilder::getRankingUf($uf[0]["id"]); //IDHM

        $block_ranking->setData("subtitulo", TextBuilder::$aba->getSubtitulo()); //@Translate
        $block_ranking->setData("info", "");

        //@Translate
        $str = TextBuilder::$aba->getTexto();

//        if (TextBuilder::$idMunicipio != 735) {
//            //@Translate
//            $str = $str . TextBuilder::$aba->getTexto2();
//        }

        $texto = new Texto($str);

        $texto->replaceTags("municipio", TextBuilder::$nomeMunicipio);

        // Formulas::getRanking($block_ranking, $texto, $ranking, $uf, $ranking_uf);
        if (TextBuilder::$type != "perfil_udh") {
            Formulas::getRanking($block_ranking, $texto, $ranking, $ranking_first, $ranking_last, TextBuilder::$type);
        } else {

            $rm_da_udh = TextBuilder::getRM_udh(TextBuilder::$idMunicipio);
            $count_udh = TextBuilder::getCountUDH_rm($rm_da_udh[0]["id"]);

            $minValueRM_idhm = TextBuilder::getMaiorMenorIDHM_UDH("rm", $rm_da_udh[0]["id"], "ASC");
            $maxValueRM_idhm = TextBuilder::getMaiorMenorIDHM_UDH("rm", $rm_da_udh[0]["id"], "DESC");

            $minValueRM_idhm_L = TextBuilder::getMaiorMenorIDHM_UDH("rm", $rm_da_udh[0]["id"], "ASC", "IDHM_L");
            $maxValueRM_idhm_L = TextBuilder::getMaiorMenorIDHM_UDH("rm", $rm_da_udh[0]["id"], "DESC", "IDHM_L");

            $minValueRM_idhm_E = TextBuilder::getMaiorMenorIDHM_UDH("rm", $rm_da_udh[0]["id"], "ASC", "IDHM_E");
            $maxValueRM_idhm_E = TextBuilder::getMaiorMenorIDHM_UDH("rm", $rm_da_udh[0]["id"], "DESC", "IDHM_E");

            $minValueRM_idhm_R = TextBuilder::getMaiorMenorIDHM_UDH("rm", $rm_da_udh[0]["id"], "ASC", "IDHM_R");
            $maxValueRM_idhm_R = TextBuilder::getMaiorMenorIDHM_UDH("rm", $rm_da_udh[0]["id"], "DESC", "IDHM_R");

            
            Formulas::getRankingUDH($block_ranking, $texto, $rm_da_udh, $minValueRM_idhm, $maxValueRM_idhm, $minValueRM_idhm_L, $maxValueRM_idhm_L, $minValueRM_idhm_E, $maxValueRM_idhm_E, $minValueRM_idhm_R, $maxValueRM_idhm_R, $count_udh, TextBuilder::$type);
        }
    }

    //@#Feito fora do padrÃ£o por causa do lanÃ§amento-->
    static public function generateIDH_table_ranking($block_table_ranking) {

        $block_table_ranking->setData("caption", "Índice de Desenvolvimento Humano Municipal e seus componentes 2010"); //@Translate        
        $block_table_ranking->setData("titulo", ""); //@Translate
        $block_table_ranking->setData("fonte", TextBuilder::$fontePerfil);

        $idhm = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "IDHM"); //IDHM
        $idhm_r = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "IDHM_R"); //IDHM_R
        $idhm_l = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "IDHM_L"); //IDHM_L
        $idhm_e = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "IDHM_E"); //IDHM_E
        //MunicÃ­pio e RM em que a UDH estÃ¡ situada
        $mun_da_udh = TextBuilder::getMUN_udh(TextBuilder::$idMunicipio);
        $rm_da_udh = TextBuilder::getRM_udh(TextBuilder::$idMunicipio);
//        $rm_da_udh = TextBuilder::getRM_udh(TextBuilder::$idMunicipio);
//        $count_udh = TextBuilder::getCountUDH_rm($rm_da_udh[0]["id"]);

        $minValueRM_idhm = TextBuilder::getMaiorMenorIDHM_UDH("rm", $rm_da_udh[0]["id"], "ASC");
        $maxValueRM_idhm = TextBuilder::getMaiorMenorIDHM_UDH("rm", $rm_da_udh[0]["id"], "DESC");

        $minValueRM_idhm_L = TextBuilder::getMaiorMenorIDHM_UDH("rm", $rm_da_udh[0]["id"], "ASC", "IDHM_L");
        $maxValueRM_idhm_L = TextBuilder::getMaiorMenorIDHM_UDH("rm", $rm_da_udh[0]["id"], "DESC", "IDHM_L");

        $minValueRM_idhm_E = TextBuilder::getMaiorMenorIDHM_UDH("rm", $rm_da_udh[0]["id"], "ASC", "IDHM_E");
        $maxValueRM_idhm_E = TextBuilder::getMaiorMenorIDHM_UDH("rm", $rm_da_udh[0]["id"], "DESC", "IDHM_E");

        $minValueRM_idhm_R = TextBuilder::getMaiorMenorIDHM_UDH("rm", $rm_da_udh[0]["id"], "ASC", "IDHM_R");
        $maxValueRM_idhm_R = TextBuilder::getMaiorMenorIDHM_UDH("rm", $rm_da_udh[0]["id"], "DESC", "IDHM_R");



        $minValueMUN_idhm = TextBuilder::getMaiorMenorIDHM_UDH("mun", $mun_da_udh[0]["id"], "ASC");
        $maxValueMUN_idhm = TextBuilder::getMaiorMenorIDHM_UDH("mun", $mun_da_udh[0]["id"], "DESC");

        $minValueMUN_idhm_L = TextBuilder::getMaiorMenorIDHM_UDH("mun", $mun_da_udh[0]["id"], "ASC", "IDHM_L");
        $maxValueMUN_idhm_L = TextBuilder::getMaiorMenorIDHM_UDH("mun", $mun_da_udh[0]["id"], "DESC", "IDHM_L");

        $minValueMUN_idhm_E = TextBuilder::getMaiorMenorIDHM_UDH("mun", $mun_da_udh[0]["id"], "ASC", "IDHM_E");
        $maxValueMUN_idhm_E = TextBuilder::getMaiorMenorIDHM_UDH("mun", $mun_da_udh[0]["id"], "DESC", "IDHM_E");

        $minValueMUN_idhm_R = TextBuilder::getMaiorMenorIDHM_UDH("mun", $mun_da_udh[0]["id"], "ASC", "IDHM_R");
        $maxValueMUN_idhm_R = TextBuilder::getMaiorMenorIDHM_UDH("mun", $mun_da_udh[0]["id"], "DESC", "IDHM_R");



        $block_table_ranking->setData("IDHM_2010", number_format($idhm[2]['valor'], 3, ",", "."));
        $block_table_ranking->setData("IDHM_2010_menor_UDH_mun", number_format($minValueMUN_idhm[0]['valor'], 3, ",", "."));
        $block_table_ranking->setData("IDHM_2010_maior_UDH_mun", number_format($maxValueMUN_idhm[0]['valor'], 3, ",", "."));
        $block_table_ranking->setData("IDHM_2010_menor_UDH_rm", number_format($minValueRM_idhm[0]['valor'], 3, ",", "."));
        $block_table_ranking->setData("IDHM_2010_maior_UDH_rm", number_format($maxValueRM_idhm[0]['valor'], 3, ",", "."));

        $block_table_ranking->setData("IDHM_L_2010", number_format($idhm_l[2]['valor'], 3, ",", "."));
        $block_table_ranking->setData("IDHM_L_2010_menor_UDH_mun", number_format($minValueMUN_idhm_L[0]['valor'], 3, ",", "."));
        $block_table_ranking->setData("IDHM_L_2010_maior_UDH_mun", number_format($maxValueMUN_idhm_L[0]['valor'], 3, ",", "."));
        $block_table_ranking->setData("IDHM_L_2010_menor_UDH_rm", number_format($minValueRM_idhm_L[0]['valor'], 3, ",", "."));
        $block_table_ranking->setData("IDHM_L_2010_maior_UDH_rm", number_format($maxValueRM_idhm_L[0]['valor'], 3, ",", "."));

        $block_table_ranking->setData("IDHM_E_2010", number_format($idhm_e[2]['valor'], 3, ",", "."));
        $block_table_ranking->setData("IDHM_E_2010_menor_UDH_mun", number_format($minValueMUN_idhm_E[0]['valor'], 3, ",", "."));
        $block_table_ranking->setData("IDHM_E_2010_maior_UDH_mun", number_format($maxValueMUN_idhm_E[0]['valor'], 3, ",", "."));
        $block_table_ranking->setData("IDHM_E_2010_menor_UDH_rm", number_format($minValueRM_idhm_E[0]['valor'], 3, ",", "."));
        $block_table_ranking->setData("IDHM_E_2010_maior_UDH_rm", number_format($maxValueRM_idhm_E[0]['valor'], 3, ",", "."));

        $block_table_ranking->setData("IDHM_R_2010", number_format($idhm_r[2]['valor'], 3, ",", "."));
        $block_table_ranking->setData("IDHM_R_2010_menor_UDH_mun", number_format($minValueMUN_idhm_R[0]['valor'], 3, ",", "."));
        $block_table_ranking->setData("IDHM_R_2010_maior_UDH_mun", number_format($maxValueMUN_idhm_R[0]['valor'], 3, ",", "."));
        $block_table_ranking->setData("IDHM_R_2010_menor_UDH_rm", number_format($minValueRM_idhm_R[0]['valor'], 3, ",", "."));
        $block_table_ranking->setData("IDHM_R_2010_maior_UDH_rm", number_format($maxValueRM_idhm_R[0]['valor'], 3, ",", "."));
    }

    // OUTRA CATEGORIA
    static public function generateDEMOGRAFIA_SAUDE_populacao($block_populacao) {

        $pesotot = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PESOTOT"); //PESOTOT


        $pesourb = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PESOURB"); //PESORUR
        $pesotot_uf = TextBuilder::getVariaveis_Uf(TextBuilder::$idMunicipio, "PESOTOT"); //PESOTOT do Estado

        $pesourb_br = TextBuilder::getVariaveis_Brasil("PESOURB"); //PESORUR
        $pesotot_br = TextBuilder::getVariaveis_Brasil("PESOTOT"); //PESOTOT do Brasil        
        //$pesorur = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PESORUR"); //PESORUR        
        $block_populacao->setData("quebra", "");

        $block_populacao->setData("fonte", TextBuilder::$fontePerfil);
        $block_populacao->setData("titulo", TextBuilder::$aba->getTitulo()); //@Translate
        $block_populacao->setData("subtitulo", TextBuilder::$aba->getSubTitulo()); //@Translate
        $block_populacao->setData("info", "");

        //@Translate
        $str = TextBuilder::$aba->getTexto();

        $texto = new Texto($str);
        $texto->replaceTags("municipio", TextBuilder::$nomeMunicipio);

        //@NÃ£oInclusoEmRM&UDH
        if (TextBuilder::$type != "perfil_rm" && TextBuilder::$type != "perfil_udh") {
            $texto->replaceTags("tx_cres_pop_9100", Formulas::getTaxaCrescimentoPop9100($pesotot));  //(((PESOTOT 2000 / PESOTOT 1991)^(1/9))-1)*100
            $texto->replaceTags("tx_cresc_pop_estado_9100", Formulas::getTaxaCrescimentoPop9100ESTADO($pesotot_uf));
            $texto->replaceTags("tx_cresc_pop_pais_9100", Formulas::getTaxaCrescimentoPop9100BRASIL($pesotot_br));
            $texto->replaceTags("tx_urbanizacao_91", Formulas::getTaxaUrbanizacao91($pesourb, $pesotot));

            $texto->replaceTags("tx_urbanizacao", Formulas::getTaxaUrbanizacao($pesourb, $pesotot));
        }

        $texto->replaceTags("pesotot_10", number_format($pesotot[2]["valor"], 0, ",", "."));

        $texto->replaceTags("tx_cres_pop_0010", Formulas::getTaxaCrescimentoPop0010($pesotot)); //(((PESOTOT 2010 / PESOTOT 2000)^(1/10))-1)*100             

        $texto->replaceTags("tx_cresc_pop_estado_0010", Formulas::getTaxaCrescimentoPop0010ESTADO($pesotot_uf));

        $texto->replaceTags("tx_cresc_pop_pais_0010", Formulas::getTaxaCrescimentoPop0010BRASIL($pesotot_br));

        $texto->replaceTags("tx_urbanizacao_00", Formulas::getTaxaUrbanizacao00($pesourb, $pesotot));
        $texto->replaceTags("tx_urbanizacao_10", Formulas::getTaxaUrbanizacao10($pesourb, $pesotot));

        $texto->replaceTags("tx_urbanizacao_00_br", Formulas::getTaxaUrbanizacao00BRASIL($pesourb_br, $pesotot_br));
        $texto->replaceTags("tx_urbanizacao_10_br", Formulas::getTaxaUrbanizacao10BRASIL($pesourb_br, $pesotot_br));

        if (TextBuilder::$type === "perfil_udh") {
            //MunicÃ­pio e RM em que a UDH estÃ¡ situada
            $mun_da_udh = TextBuilder::getMUN_udh(TextBuilder::$idMunicipio);
            $rm_da_udh = TextBuilder::getRM_udh(TextBuilder::$idMunicipio);

            $pesotot_mun = TextBuilder::getVariaveis_tablePersonalizado($mun_da_udh[0]["id"], "PESOTOT", "perfil_m"); //PESOTOT
            $pesotot_rm = TextBuilder::getVariaveis_tablePersonalizado($rm_da_udh[0]["id"], "PESOTOT", "perfil_rm"); //PESOTOT

            $texto->replaceTags("tx_cres_pop_0010_mun_udh", Formulas::getTaxaCrescimentoPop0010($pesotot_mun));
            $texto->replaceTags("tx_cres_pop_0010_rm_udh", Formulas::getTaxaCrescimentoPop0010($pesotot_rm));
        }

        $block_populacao->setData("text", $texto->getTexto());
        $block_populacao->setData("tableContent", "");
    }

    static public function generateIDH_table_populacao($block_table_populacao) {

        $variaveis = array();
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PESOTOT")); //PopulaÃ§Ã£o Total 166
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "HOMEMTOT")); //Homens 236
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "MULHERTOT")); //Mulheres 237
        //
        if (TextBuilder::$type != "perfil_udh") {
            array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PESOURB")); //PopulaÃ§Ã£o Urbana 168
            array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PESORUR")); //PopulaÃ§Ã£o Rural 167
        }
        //array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "")); //Taxa de UrbanizaÃ§Ã£o

        $block_table_populacao->setData("titulo", TextBuilder::$aba->getTituloTable()); //@Translate
        $block_table_populacao->setData("caption", TextBuilder::$aba->getCaption()); //@Translate
        $block_table_populacao->setData("fonte", TextBuilder::$fontePerfil);

        if (TextBuilder::$type == "perfil_rm" || TextBuilder::$type == "perfil_uf")
            $block_table_populacao->setData("municipio", TextBuilder::$nomeMunicipio);
        else
            $block_table_populacao->setData("municipio", TextBuilder::$nomeMunicipio . " - " . TextBuilder::$ufMunicipio);

        $block_table_populacao->setData("coluna1", TextBuilder::$aba->getColunaTable1()); //@Translate
        $block_table_populacao->setData("coluna2", TextBuilder::$aba->getColunaTable2()); //@Translate

        $stringTaxaUrbanizacao = TextBuilder::$aba->getTaxaUrbanizacao(); //@Translate

        Formulas::printTablePopulacao($block_table_populacao, $variaveis, $stringTaxaUrbanizacao, TextBuilder::$type);
    }

    static public function generateDEMOGRAFIA_SAUDE_etaria($block_etaria) {

        $tenv = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_ENV"); //T_ENV
        $rd = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "RAZDEP"); //T_ENV

        $tenv_br = TextBuilder::getVariaveis_Brasil("T_ENV"); //T_ENV
        $rd_br = TextBuilder::getVariaveis_Brasil("RAZDEP"); //T_ENV
        
        if (TextBuilder::$print) {
            $block_etaria->setData("quebra", "<div style='page-break-after: always'></div>");
        } else
            $block_etaria->setData("quebra", "");

        $block_etaria->setData("subtitulo", TextBuilder::$aba->getSubTitulo()); //@Translate
        $block_etaria->setData("info", "");

        //@Translate
        $str = TextBuilder::$aba->getTexto();

        $texto = new Texto($str);
        $texto->replaceTags("municipio", TextBuilder::$nomeMunicipio);
        $texto->replaceTags("indice_envelhecimento91", Formulas::getIndiceEnvelhecimento91($tenv));
        $texto->replaceTags("indice_envelhecimento00", Formulas::getIndiceEnvelhecimento00($tenv));
        $texto->replaceTags("indice_envelhecimento10", Formulas::getIndiceEnvelhecimento10($tenv));

        $texto->replaceTags("rz_dependencia91", Formulas::getRazaoDependencia91($rd));
        $texto->replaceTags("rz_dependencia00", Formulas::getRazaoDependencia00($rd));
        $texto->replaceTags("rz_dependencia10", Formulas::getRazaoDependencia10($rd));

        $texto->replaceTags("indice_envelhecimento91_br", Formulas::getIndiceEnvelhecimento91($tenv_br));
        $texto->replaceTags("indice_envelhecimento00_br", Formulas::getIndiceEnvelhecimento00($tenv_br));
        $texto->replaceTags("indice_envelhecimento10_br", Formulas::getIndiceEnvelhecimento10($tenv_br));

        $texto->replaceTags("rz_dependencia91_br", Formulas::getRazaoDependencia91($rd_br));
        $texto->replaceTags("rz_dependencia00_br", Formulas::getRazaoDependencia00($rd_br));
        $texto->replaceTags("rz_dependencia10_br", Formulas::getRazaoDependencia10($rd_br));

        if (TextBuilder::$type === "perfil_udh") {
            //MunicÃ­pio e RM em que a UDH estÃ¡ situada
            $mun_da_udh = TextBuilder::getMUN_udh(TextBuilder::$idMunicipio);
            $rm_da_udh = TextBuilder::getRM_udh(TextBuilder::$idMunicipio);

            $tenv_mun = TextBuilder::getVariaveis_tablePersonalizado($mun_da_udh[0]["id"], "T_ENV", "perfil_m"); //T_ENV
            $rd_mun = TextBuilder::getVariaveis_tablePersonalizado($mun_da_udh[0]["id"], "RAZDEP", "perfil_m"); //T_ENV
            $tenv_rm = TextBuilder::getVariaveis_tablePersonalizado($rm_da_udh[0]["id"], "T_ENV", "perfil_rm"); //T_ENV
            $rd_rm = TextBuilder::getVariaveis_tablePersonalizado($rm_da_udh[0]["id"], "RAZDEP", "perfil_rm"); //T_ENV

            $texto->replaceTags("indice_envelhecimento10_mun_udh", Formulas::getTaxaCrescimentoPop0010($tenv_mun));
            $texto->replaceTags("rz_dependencia10_mun_udh", Formulas::getTaxaCrescimentoPop0010($rd_mun));
            $texto->replaceTags("indice_envelhecimento10_rm_udh", Formulas::getTaxaCrescimentoPop0010($tenv_rm));
            $texto->replaceTags("rz_dependencia10_rm_udh", Formulas::getTaxaCrescimentoPop0010($rd_rm));
        }

        $block_etaria->setData("text", $texto->getTexto());

        //@Translate
        $block_etaria->setData("block_box1", TextBuilder::$aba->getRDependencia());
        $block_etaria->setData("block_box2", TextBuilder::$aba->getTEnvelhecimento());

        $block_etaria->setData("tableContent", "");
    }

    static public function generateIDH_table_etaria($block_table_etaria) {

        $pesotot = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PESOTOT"); //PESOTOT

        $variaveis = array();
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PESO15")); //Menos de 15 anos (PESOTOT-PESO15)
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "")); //15 a 64 anos
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PESO65")); //65 anos ou mais
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "RAZDEP")); //RazÃ£o de DependÃªncia(Planilha Piramide)               
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_ENV")); //Ã�ndice de Envelhecimento

        $block_table_etaria->setData("titulo", TextBuilder::$aba->getTituloTable()); //@Translate        
        $block_table_etaria->setData("caption", TextBuilder::$aba->getCaption()); //@Translate
        $block_table_etaria->setData("fonte", TextBuilder::$fontePerfil);

        if (TextBuilder::$type == "perfil_rm" || TextBuilder::$type == "perfil_uf")
            $block_table_etaria->setData("municipio", TextBuilder::$nomeMunicipio);
        else
            $block_table_etaria->setData("municipio", TextBuilder::$nomeMunicipio . " - " . TextBuilder::$ufMunicipio);

        $block_table_etaria->setData("coluna1", TextBuilder::$aba->getColunaTable1()); //@Translate
        $block_table_etaria->setData("coluna2", TextBuilder::$aba->getColunaTable2()); //@Translate

        $stringMenos15anos = TextBuilder::$aba->getMenos15anos(); //@Translate //NÃ£o Ã© uma variÃ¡vel especÃ­fica
        $string15a64anos = TextBuilder::$aba->get15a64anos(); //@Translate //NÃ£o Ã© uma variÃ¡vel especÃ­fica
        Formulas::printTableEtaria($block_table_etaria, $variaveis, $pesotot, $stringMenos15anos, $string15a64anos, TextBuilder::$type);

        if (TextBuilder::$print) {
            $block_table_etaria->setData("quebra1", "<div style='page-break-after: always;'></div>");
            $block_table_etaria->setData("quebra2", "<div style='margin-top:100px;'></div>");
        } else{
            $block_table_etaria->setData("quebra1", "");
            $block_table_etaria->setData("quebra2", "");
        }
        if (TextBuilder::$type != "perfil_udh") {
            if (TextBuilder::$type != "perfil_rm")
                $block_table_etaria->setData("canvasContent1", TextBuilder::$aba->getChartPiramideEtaria1(TextBuilder::$idMunicipio));

            $block_table_etaria->setData("canvasContent2", TextBuilder::$aba->getChartPiramideEtaria2(TextBuilder::$idMunicipio));
            $block_table_etaria->setData("canvasContent3", TextBuilder::$aba->getChartPiramideEtaria3(TextBuilder::$idMunicipio));
        }
    }

    static public function generateDEMOGRAFIA_SAUDE_longevidade1($block_longevidade) {

        $mort1 = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "MORT1"); //MORT1
        $mort1_uf = TextBuilder::getVariaveis_Uf(TextBuilder::$idMunicipio, "MORT1"); //MORT1 do Estado
        $mort1_brasil = TextBuilder::getVariaveis_Brasil("MORT1"); //MORT1 do Brasil

        $block_longevidade->setData("subtitulo", TextBuilder::$aba->getSubTitulo()); //@Translate
        $block_longevidade->setData("info", "");

        //@Translate
        $str1 = TextBuilder::$aba->getTexto();

        $texto1 = new Texto($str1);
        $texto1->replaceTags("municipio", TextBuilder::$nomeMunicipio);
        //TODO: Tem que ser sempre positivo
        $texto1->replaceTags("reducao_mortalinfantil0010", Formulas::getReducaoMortalidadeInfantil0010($mort1));
        $texto1->replaceTags("mortinfantil00", Formulas::getMortalidadeInfantil00($mort1));
        $texto1->replaceTags("mortinfantil10", Formulas::getMortalidadeInfantil10($mort1));
        $texto1->replaceTags("mortinfantil91", Formulas::getMortalidadeInfantil91($mort1));

        $texto1->replaceTags("mortinfantil10_Estado", Formulas::getMortalidadeInfantil10ESTADO($mort1_uf));
        $texto1->replaceTags("mortinfantil00_Estado", Formulas::getMortalidadeInfantil00ESTADO($mort1_uf));
        $texto1->replaceTags("mortinfantil91_Estado", Formulas::getMortalidadeInfantil91ESTADO($mort1_uf));

        $texto1->replaceTags("mortinfantil10_br", Formulas::getMortalidadeInfantil10BRASIL($mort1_brasil));
        $texto1->replaceTags("mortinfantil00_br", Formulas::getMortalidadeInfantil00BRASIL($mort1_brasil));
        $texto1->replaceTags("mortinfantil91_br", Formulas::getMortalidadeInfantil91BRASIL($mort1_brasil));


        if (TextBuilder::$type === "perfil_udh") {
            //MunicÃ­pio e RM em que a UDH estÃ¡ situada
            $mun_da_udh = TextBuilder::getMUN_udh(TextBuilder::$idMunicipio);
            $rm_da_udh = TextBuilder::getRM_udh(TextBuilder::$idMunicipio);

            $mort1_mun = TextBuilder::getVariaveis_tablePersonalizado($mun_da_udh[0]["id"], "MORT1", "perfil_m"); //T_ENV
            $mort1_rm = TextBuilder::getVariaveis_tablePersonalizado($rm_da_udh[0]["id"], "MORT1", "perfil_rm"); //T_ENV

            $texto1->replaceTags("mortinfantil10_mun_udh", Formulas::getMortalidadeInfantil10($mort1_mun));
            $texto1->replaceTags("mortinfantil10_rm_udh", Formulas::getMortalidadeInfantil10($mort1_rm));
        }

        //TODO: Tirar o igual da comparaÃ§Ã£o (feito pq a base nÃ£o Ã© oficial e hÃ¡ replicaÃ§Ãµes
        if (Formulas::getMortalidadeInfantil10puro($mort1) <= Formulas::getMortalidadeInfantil00puro($mort1))
            $texto1->replaceTags("mort1_diminuiu_aumentou", TextBuilder::$aba->getReduziu()); //@Translate
        else if (Formulas::getMortalidadeInfantil10puro($mort1) > Formulas::getMortalidadeInfantil00puro($mort1))
            $texto1->replaceTags("mort1_diminuiu_aumentou", TextBuilder::$aba->getAumentou()); //@Translate

        $block_longevidade->setData("text2", "");
        $block_longevidade->setData("tableContent", "");

        $block_longevidade->setData("text1", $texto1->getTexto());
        
        if (TextBuilder::$print && TextBuilder::$type === "perfil_m" ) {
        	$block_longevidade->setData("quebra", "<div style='page-break-after: always'></div>");
        } else
        	$block_longevidade->setData("quebra", "");
    }

    static public function generateIDH_table_longevidade($block_table_longevidade) {

        $variaveis = array();
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "ESPVIDA")); //EsperanÃ§a de vida ao nascer (anos)
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "MORT1")); //Mortalidade atÃ© 1 ano de idade (por mil nascidos vivos)
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "MORT5")); //Mortalidade atÃ© 5 anos de idade (por mil nascidos vivos)
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "FECTOT")); //Taxa de fecundidade total (filhos por mulher) 

        $block_table_longevidade->setData("titulo", "");
        $block_table_longevidade->setData("caption", TextBuilder::$aba->getCaption()); //@Translate
        $block_table_longevidade->setData("fonte", TextBuilder::$fontePerfil);
        
        if (TextBuilder::$print) {
            $block_table_longevidade->setData("quebra", "<div style='page-break-after: always'></div>");
        } else
            $block_table_longevidade->setData("quebra", "");
        
        if (TextBuilder::$type == "perfil_rm" || TextBuilder::$type == "perfil_uf")
            $block_table_longevidade->setData("municipio", TextBuilder::$nomeMunicipio);
        else
            $block_table_longevidade->setData("municipio", TextBuilder::$nomeMunicipio . " - " . TextBuilder::$ufMunicipio);

        Formulas::printTableLongevidade($block_table_longevidade, $variaveis, TextBuilder::$type);
    }

    static public function generateDEMOGRAFIA_SAUDE_longevidade2($block_longevidade) {

        $espvida = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "ESPVIDA"); //ESPVIDA
        $espvida_uf = TextBuilder::getVariaveis_Uf(TextBuilder::$idMunicipio, "ESPVIDA"); //ESPVIDA do Estado
        $espvida_brasil = TextBuilder::getVariaveis_Brasil("ESPVIDA"); //ESPVIDA do Brasil

        $block_longevidade->setData("subtitulo", "");
        $block_longevidade->setData("info", "");

        //@Translate
        $str2 = TextBuilder::$aba->getTexto2();

        $texto2 = new Texto($str2);
        $texto2->replaceTags("municipio", TextBuilder::$nomeMunicipio);

        $texto2->replaceTags("esp_nascer91", Formulas::getEsperancaVidaNascer91($espvida));
        $texto2->replaceTags("esp_nascer00", Formulas::getEsperancaVidaNascer00($espvida));
        $texto2->replaceTags("esp_nascer10", Formulas::getEsperancaVidaNascer10($espvida));
        $texto2->replaceTags("aumento_esp_nascer0010", Formulas::getAumentoEsperancaVidaNascer0010($espvida));
        $texto2->replaceTags("esp_nascer10_estado", Formulas::getEsperancaVidaNascer10ESTADO($espvida_uf));

        $texto2->replaceTags("esp_nascer10_br", Formulas::getEsperancaVidaNascer10BRASIL($espvida_brasil));
        $texto2->replaceTags("esp_nascer00_br", Formulas::getEsperancaVidaNascer00BRASIL($espvida_brasil));
        $texto2->replaceTags("esp_nascer91_br", Formulas::getEsperancaVidaNascer91BRASIL($espvida_brasil));

        if (TextBuilder::$type === "perfil_udh") {
            //MunicÃ­pio e RM em que a UDH estÃ¡ situada
            $mun_da_udh = TextBuilder::getMUN_udh(TextBuilder::$idMunicipio);
            $rm_da_udh = TextBuilder::getRM_udh(TextBuilder::$idMunicipio);

            $espvida_mun = TextBuilder::getVariaveis_tablePersonalizado($mun_da_udh[0]["id"], "ESPVIDA", "perfil_m"); //T_ENV
            $espvida_rm = TextBuilder::getVariaveis_tablePersonalizado($rm_da_udh[0]["id"], "ESPVIDA", "perfil_rm"); //T_ENV

            $texto2->replaceTags("esp_nascer10_mun_udh", Formulas::getEsperancaVidaNascer10($espvida_mun));
            $texto2->replaceTags("esp_nascer10_rm_udh", Formulas::getEsperancaVidaNascer10($espvida_rm));
        }

        $block_longevidade->setData("text2", $texto2->getTexto());

        $block_longevidade->setData("text1", "");
        $block_longevidade->setData("tableContent", "");

        if (TextBuilder::$print) {
            $block_longevidade->setData("quebra", "");
        } else
            $block_longevidade->setData("quebra", "");
    }

    static public function generateEDUCACAO_nivel_educacional($block_nivel_educacional) {

        //VariÃ¡veis do Primeiro Texto
        $t_freq5a6 = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FREQ5A6"); //T_FREQ5A6 - Mudou variÃ¡vel
        $t_fund11a13 = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FUND11A13");  //T_FUND11A13 - Mudou variÃ¡vel
        $t_fund15a17 = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FUND15A17");  //T_FUND15A17 - Mudou variÃ¡vel
        $t_med18a20 = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_MED18A20");  //T_MED18A20 - Mudou variÃ¡vel
        //VariÃ¡veis do Segundo Texto
        $t_atraso_0_fund = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_ATRASO_0_FUND");  //T_ATRASO_0_FUND 62
        $t_flfund = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FLFUND");  //T_FLFUND 57

        $t_atraso_2_bas = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_ATRASO_2_BASICO");  //T_ATRASO_2_BASICO
        $t_flbas = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FLBAS");  //T_FLBAS

        $t_atraso_0_med = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_ATRASO_0_MED");  //T_ATRASO_0_MED 
        $t_flmed = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FLMED");  //T_FLMED 
        $t_flsuper = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FLSUPER");  //T_FLSUPER 
        $t_freq6a14 = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FREQ6A14");  //T_FREQ6A14 
        $t_freq15a17 = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FREQ15A17");  //T_FREQ15A17 
        //$t_freq18a24 = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FREQ18A24");  //T_FREQ15A17 

        if (TextBuilder::$print) {
            $block_nivel_educacional->setData("quebra", "<div style='page-break-after: always'></div>");
        } else
            $block_nivel_educacional->setData("quebra", "");

        $block_nivel_educacional->setData("fonte", TextBuilder::$fontePerfil);
        $block_nivel_educacional->setData("titulo", TextBuilder::$aba->getTitulo()); //@Translate
        $block_nivel_educacional->setData("subtitulo", TextBuilder::$aba->getSubTitulo()); //@Translate
        $block_nivel_educacional->setData("info", "");

        //@Translate
        $str1 = TextBuilder::$aba->getTexto();

        $texto1 = new Texto($str1);
        $texto1->replaceTags("municipio", TextBuilder::$nomeMunicipio);

        $texto1->replaceTags("t_freq5a6_10", Formulas::get5a6Esc10($t_freq5a6));
        $texto1->replaceTags("t_fund11a13_10", Formulas::get11a13Esc10($t_fund11a13));
        $texto1->replaceTags("t_fund15a17_10", Formulas::get15a17Fund10($t_fund15a17));
        $texto1->replaceTags("t_med18a20_10", Formulas::get18a20Medio10($t_med18a20));

        $texto1->replaceTags("getCrescimento5a6Esc9110", Formulas::getCrescimento5a6Esc9110($t_freq5a6));
        $texto1->replaceTags("getCrescimento11a13Esc9110", Formulas::getCrescimento11a13Esc9110($t_fund11a13));
        $texto1->replaceTags("getCrescimento15a17Fund9110", Formulas::getCrescimento15a17Fund9110($t_fund15a17));
        $texto1->replaceTags("getCrescimento18a20Medio9110", Formulas::getCrescimento18a20Medio9110($t_med18a20));

        $texto1->replaceTags("getCrescimento5a6Esc0010", Formulas::getCrescimento5a6Esc0010($t_freq5a6));
        $texto1->replaceTags("getCrescimento11a13Esc0010", Formulas::getCrescimento11a13Esc0010($t_fund11a13));
        $texto1->replaceTags("getCrescimento15a17Fund0010", Formulas::getCrescimento15a17Fund0010($t_fund15a17));
        $texto1->replaceTags("getCrescimento18a20Medio0010", Formulas::getCrescimento18a20Medio0010($t_med18a20));

//        $texto1->replaceTags("cresc_4-6esc_0010", Formulas::getCrescimento4a6Esc0010($t_freq4a6));
//        $texto1->replaceTags("cresc_4-6esc_9100", Formulas::getCrescimento4a6Esc9100($t_freq4a6));
//
//        $texto1->replaceTags("cresc_11-13esc_0010", Formulas::getCrescimento11a13Esc0010($t_fund11a13));
//        $texto1->replaceTags("cresc_11-13esc_9100", Formulas::getCrescimento11a13Esc9100($t_fund11a13));
//
//        $texto1->replaceTags("cresc_16-18fund_0010", Formulas::getCrescimento16a18Fund0010($t_fund16a18));
//        $texto1->replaceTags("cresc_16-18fund_9100", Formulas::getCrescimento16a18Fund9100($t_fund16a18));
//
//        $texto1->replaceTags("cresc_19-21medio_0010", Formulas::getCrescimento19a21Medio0010($t_med19a21));
//        $texto1->replaceTags("cresc_19-21medio_9100", Formulas::getCrescimento19a21Medio9100($t_med19a21));

        $block_nivel_educacional->setData("text1", $texto1->getTexto());

        if (TextBuilder::$print) {
            $block_nivel_educacional->setData("quebra4", "<div style=margin-top: 20px;'></div>");
            $block_nivel_educacional->setData("quebra1", "<div style='page-break-after: always'></div>");
        } else{
            $block_nivel_educacional->setData("quebra4", "");
            $block_nivel_educacional->setData("quebra1", "");
        }   

        if (TextBuilder::$type !== "perfil_udh")
            $block_nivel_educacional->setData("canvasContent1", TextBuilder::$aba->getChartFluxoEscolar(TextBuilder::$idMunicipio));

        

        $block_nivel_educacional->setData("canvasContent2", TextBuilder::$aba->getChartFrequenciaEscolar(TextBuilder::$idMunicipio));

        //@Translate
        $str2 = TextBuilder::$aba->getTexto2();

        $texto2 = new Texto($str2);
        $texto2->replaceTags("municipio", TextBuilder::$nomeMunicipio);
//        $texto2->replaceTags("tx_fund_sematraso_10", Formulas::getTxFundSemAtraso10($t_atraso_0_fund, $t_flfund));
//        $texto2->replaceTags("tx_fund_sematraso_00", Formulas::getTxFundSemAtraso00($t_atraso_0_fund, $t_flfund));
        $texto2->replaceTags("tx_fund_sematraso_10", Formulas::getTxBasSemAtraso10($t_atraso_2_bas, $t_flbas));
        $texto2->replaceTags("tx_fund_sematraso_00", Formulas::getTxBasSemAtraso00($t_atraso_2_bas, $t_flbas));
        $texto2->replaceTags("tx_fund_sematraso_91", Formulas::getTxBasSemAtraso91($t_atraso_2_bas, $t_flbas));

        //$texto2->replaceTags("tx_fund_sematraso_91", Formulas::getTxFundSemAtraso91($t_atraso_0_fund, $t_flfund));

        $texto2->replaceTags("tx_medio_sematraso_10", Formulas::getTxMedioSemAtraso10($t_atraso_0_med, $t_flmed));
        $texto2->replaceTags("tx_medio_sematraso_00", Formulas::getTxMedioSemAtraso00($t_atraso_0_med, $t_flmed));
        $texto2->replaceTags("tx_medio_sematraso_91", Formulas::getTxMedioSemAtraso91($t_atraso_0_med, $t_flmed));

        $texto2->replaceTags("t_flsuper_10", Formulas::getTxFLSuper10($t_flsuper));
        $texto2->replaceTags("t_flsuper_00", Formulas::getTxFLSuper00($t_flsuper));
        $texto2->replaceTags("t_flsuper_91", Formulas::getTxFLSuper91($t_flsuper));

        $texto2->replaceTags("p6a14", Formulas::getP6a14($t_freq6a14));
        $texto2->replaceTags("p15a17", Formulas::getP15a17($t_freq15a17));

        $block_nivel_educacional->setData("text2", $texto2->getTexto());

        if (TextBuilder::$print) {
            $block_nivel_educacional->setData("quebra2", "<div style='page-break-after: always'></div>");
        } else
            $block_nivel_educacional->setData("quebra2", "");

        //Retirado da Nova VersÃ£o Perfil
//        $block_nivel_educacional->setData("canvasContent3", TextBuilder::$aba->getChartFrequenciaDe6a14(TextBuilder::$idMunicipio));
//        $block_nivel_educacional->setData("canvasContent4", TextBuilder::$aba->getChartFrequenciaDe15a17(TextBuilder::$idMunicipio));
//        $block_nivel_educacional->setData("canvasContent5", TextBuilder::$aba->getChartFrequenciaDe18a24(TextBuilder::$idMunicipio));

        if (TextBuilder::$print) {
            $block_nivel_educacional->setData("quebra3", "<div style='page-break-after: always'></div>");
        } else
            $block_nivel_educacional->setData("quebra3", "");
    }

    static public function generateEDUCACAO_populacao_adulta($block_populacao_adulta) {

        $t_analf18m = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_ANALF18M"); //T_ANALF18M
        $t_analf25m = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_ANALF25M"); //T_ANALF25M
        $t_analf25m_br = TextBuilder::getVariaveis_Brasil("T_ANALF25M"); //T_ANALF25M

        $t_fund25m = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FUND25M");  //T_FUND18M
        $t_fund18m = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FUND18M");  //T_FUND18M
        $t_fund18m_br = TextBuilder::getVariaveis_Brasil("T_FUND18M");  //T_FUND18M
        $t_fund25m_uf = TextBuilder::getVariaveis_Uf(TextBuilder::$idMunicipio, "T_FUND18M");  //T_FUND18M
        $t_fund25m_br = TextBuilder::getVariaveis_Brasil("T_FUND25M");  //T_FUND18M

        $t_med18m = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_MED18M");  //T_MED18M
        $t_med25m = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_MED25M");  //T_MED18M
        $t_med25m_uf = TextBuilder::getVariaveis_Uf(TextBuilder::$idMunicipio, "T_MED25M");  //T_MED18M
        $t_med25m_br = TextBuilder::getVariaveis_Brasil("T_MED25M");  //T_MED18M

        $t_super25m = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_SUPER25M");  //T_MED18M
        $t_super25m_br = TextBuilder::getVariaveis_Brasil("T_SUPER25M");  //T_MED18M

        $uf = TextBuilder::getUf(TextBuilder::$idMunicipio); //UF

        $block_populacao_adulta->setData("subtitulo", TextBuilder::$aba->getSubTitulo()); //@Translate
        $block_populacao_adulta->setData("fonte", TextBuilder::$fontePerfil);
        $block_populacao_adulta->setData("info", "");

        //@Translate
        $str = TextBuilder::$aba->getTexto();

        $texto = new Texto($str);
        $texto->replaceTags("municipio", TextBuilder::$nomeMunicipio);
        $texto->replaceTags("estado_municipio", $uf[0]["nome"]);

        $texto->replaceTags("t_fund18m_91", Formulas::get18Fund91($t_fund18m));
        $texto->replaceTags("t_fund18m_00", Formulas::get18Fund00($t_fund18m));
        $texto->replaceTags("t_fund18m_10", Formulas::get18Fund10($t_fund18m));

        $texto->replaceTags("t_fund18m_br_91", Formulas::get18FundBr91($t_fund18m_br));
        $texto->replaceTags("t_fund18m_br_00", Formulas::get18FundBr00($t_fund18m_br));
        $texto->replaceTags("t_fund18m_br_10", Formulas::get18FundBr10($t_fund18m_br));

//        $texto->replaceTags("25_medio_10", Formulas::get25Medio10($t_medin25m));
//        $texto->replaceTags("25_fund_10_Estado", Formulas::get25Fund10ESTADO($t_fundin25m_uf));
//        $texto->replaceTags("25_medio_10_Estado", Formulas::get25Medio10ESTADO($t_medin25m_uf));

        $texto->replaceTags("t_analf25m_10", Formulas::get25Analf10($t_analf25m));
        $texto->replaceTags("t_fund25m_10", Formulas::get25Fund10($t_fund25m));
        $texto->replaceTags("t_med25m_10", Formulas::get25Medio10($t_med25m));
        $texto->replaceTags("t_super25m_10", Formulas::get25Super10($t_super25m));

        $texto->replaceTags("t_analf25m_br_10", Formulas::get25Analf10BRASIL($t_analf25m_br));
        $texto->replaceTags("t_fund25m_br_10", Formulas::get25Fund10BRASIL($t_fund25m_br));
        $texto->replaceTags("t_medin25m_br_10", Formulas::get25Medio10BRASIL($t_med25m_br));
        $texto->replaceTags("t_super25m_br_10", Formulas::get25Super10BRASIL($t_super25m_br));

        if (TextBuilder::$type === "perfil_udh") {
            //MunicÃ­pio e RM em que a UDH estÃ¡ situada
            $mun_da_udh = TextBuilder::getMUN_udh(TextBuilder::$idMunicipio);
            $rm_da_udh = TextBuilder::getRM_udh(TextBuilder::$idMunicipio);

            $t_fund18m_mun = TextBuilder::getVariaveis_tablePersonalizado($mun_da_udh[0]["id"], "T_FUND18M", "perfil_m"); //T_ENV
            $t_fund18m_rm = TextBuilder::getVariaveis_tablePersonalizado($rm_da_udh[0]["id"], "T_FUND18M", "perfil_rm"); //T_ENV

            $t_analf25m_mun = TextBuilder::getVariaveis_tablePersonalizado($mun_da_udh[0]["id"], "T_ANALF25M", "perfil_m"); //T_ENV
            $t_analf25m_rm = TextBuilder::getVariaveis_tablePersonalizado($rm_da_udh[0]["id"], "T_ANALF25M", "perfil_rm"); //T_ENV

            $t_fund25m_mun = TextBuilder::getVariaveis_tablePersonalizado($mun_da_udh[0]["id"], "T_FUND25M", "perfil_m"); //T_ENV
            $t_fund25m_rm = TextBuilder::getVariaveis_tablePersonalizado($rm_da_udh[0]["id"], "T_FUND25M", "perfil_rm"); //T_ENV 

            $t_med25m_mun = TextBuilder::getVariaveis_tablePersonalizado($mun_da_udh[0]["id"], "T_MED25M", "perfil_m"); //T_ENV
            $t_med25m_rm = TextBuilder::getVariaveis_tablePersonalizado($rm_da_udh[0]["id"], "T_MED25M", "perfil_rm"); //T_ENV 

            $t_super25m_mun = TextBuilder::getVariaveis_tablePersonalizado($mun_da_udh[0]["id"], "T_SUPER25M", "perfil_m"); //T_ENV
            $t_super25m_rm = TextBuilder::getVariaveis_tablePersonalizado($rm_da_udh[0]["id"], "T_SUPER25M", "perfil_rm"); //T_ENV        
            //$e_anosesperados_mun = TextBuilder::getVariaveis_tablePersonalizado($mun_da_udh[0]["id"], "E_ANOSESTUDO", "perfil_m"); //T_ENV
            //$e_anosesperados_rm = TextBuilder::getVariaveis_tablePersonalizado($rm_da_udh[0]["id"], "E_ANOSESTUDO", "perfil_rm"); //T_ENV

            $texto->replaceTags("t_fund18m_10_mun_udh", Formulas::get18Fund10($t_fund18m_mun));
            $texto->replaceTags("t_fund18m_10_rm_udh", Formulas::get18Fund10($t_fund18m_rm));

            $texto->replaceTags("t_analf25m_10_mun_udh", Formulas::get25Analf10($t_analf25m_mun));
            $texto->replaceTags("t_analf25m_10_rm_udh", Formulas::get25Analf10($t_analf25m_rm));

            $texto->replaceTags("t_fund25m_10_mun_udh", Formulas::get25Fund10($t_fund25m_mun));
            $texto->replaceTags("t_fund25m_10_rm_udh", Formulas::get25Fund10($t_fund25m_rm));

            $texto->replaceTags("t_med25m_10_mun_udh", Formulas::get25Medio10($t_med25m_mun));
            $texto->replaceTags("t_med25m_10_rm_udh", Formulas::get25Medio10($t_med25m_rm));

            $texto->replaceTags("t_super25m_10_mun_udh", Formulas::get25Super10($t_super25m_mun));
            $texto->replaceTags("t_super25m_10_rm_udh", Formulas::get25Super10($t_super25m_rm));
        }

//        $dif_analf = Formulas::getDifAnalf($t_analf25m);
//        if ($dif_analf > 0) {
//            $texto->replaceTags("diminuiu_aumentou", "aumentou"); //@Translate
//            $texto->replaceTags("25_analf_9110", number_format($dif_analf, 2, ",", ".") . "%");
//        } else if ($dif_analf == 0) {
//            $texto->replaceTags("diminuiu_aumentou", "se manteve"); //@Translate
//            $texto->replaceTags("25_analf_9110", "");
//        } else if ($dif_analf < 0) {
//            $texto->replaceTags("diminuiu_aumentou", "diminuiu"); //@Translate
//            $texto->replaceTags("25_analf_9110", number_format(abs($dif_analf), 2, ",", ".") . "%");
//        }
        
        if (TextBuilder::$print) {
            $block_populacao_adulta->setData("quebra1", "<div style='page-break-after: always'></div>");
        } else
            $block_populacao_adulta->setData("quebra1", "");
        
        $block_populacao_adulta->setData("text", $texto->getTexto());
        $block_populacao_adulta->setData("canvasContent", TextBuilder::$aba->getChartEscolaridadePopulacao(TextBuilder::$idMunicipio));
    }

//    static public function generateAnosEsperadosEstudo($block_anos_esperados) {
//
//        $e_anosesperados = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "E_ANOSESTUDO"); //E_ANOSESTUDO
//        $e_anosesperados_uf = TextBuilder::getVariaveis_Uf(TextBuilder::$idMunicipio, "E_ANOSESTUDO");  //E_ANOSESTUDO
//        $uf = TextBuilder::getUf(TextBuilder::$idMunicipio); //UF
//
//        $block_anos_esperados->setData("subtitulo2", TextBuilder::$aba->getSubTitulo()); //@Translate
//        $block_anos_esperados->setData("info2", "");
//
//        //@Translate
//        $str2 = TextBuilder::$aba->getTexto();
//
//        $texto2 = new Texto($str2);
//        $texto2->replaceTags("municipio", TextBuilder::$nomeMunicipio);
//        $texto2->replaceTags("estado_municipio", $uf[0]["nome"]);
//
//        $texto2->replaceTags("e_anosestudo10", Formulas::getEAnosEstudo10($e_anosesperados));
//        $texto2->replaceTags("e_anosestudo00", Formulas::getEAnosEstudo00($e_anosesperados));
//        $texto2->replaceTags("e_anosestudo91", Formulas::getEAnosEstudo91($e_anosesperados));
//
//        $texto2->replaceTags("ufe_anosestudo10", Formulas::getEAnosEstudo10ESTADO($e_anosesperados_uf));
//        $texto2->replaceTags("ufe_anosestudo00", Formulas::getEAnosEstudo00ESTADO($e_anosesperados_uf));
//        $texto2->replaceTags("ufe_anosestudo91", Formulas::getEAnosEstudo91ESTADO($e_anosesperados_uf));
//
//        $block_anos_esperados->setData("text2", $texto2->getTexto());
//    }
//    
    static public function generateExpectativaAnosEstudo($block_anos_esperados) {

        $e_anosesperados = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "E_ANOSESTUDO"); //E_ANOSESTUDO
        $e_anosesperados_uf = TextBuilder::getVariaveis_Uf(TextBuilder::$idMunicipio, "E_ANOSESTUDO");  //E_ANOSESTUDO
        $e_anosesperados_br = TextBuilder::getVariaveis_Brasil("E_ANOSESTUDO");  //E_ANOSESTUDO
        $uf = TextBuilder::getUf(TextBuilder::$idMunicipio); //UF

        $block_anos_esperados->setData("subtitulo", TextBuilder::$aba->getSubTitulo()); //@Translate
        $block_anos_esperados->setData("info", "");

        //@Translate
        $str = TextBuilder::$aba->getTexto();

        $texto = new Texto($str);
        $texto->replaceTags("municipio", TextBuilder::$nomeMunicipio);
        $texto->replaceTags("estado_municipio", $uf[0]["nome"]);

        $texto->replaceTags("e_anosestudo10", Formulas::getEAnosEstudo10($e_anosesperados));
        $texto->replaceTags("e_anosestudo00", Formulas::getEAnosEstudo00($e_anosesperados));
        $texto->replaceTags("e_anosestudo91", Formulas::getEAnosEstudo91($e_anosesperados));

        $texto->replaceTags("ufe_anosestudo10", Formulas::getEAnosEstudo10ESTADO($e_anosesperados_uf));
        $texto->replaceTags("ufe_anosestudo00", Formulas::getEAnosEstudo00ESTADO($e_anosesperados_uf));
        $texto->replaceTags("ufe_anosestudo91", Formulas::getEAnosEstudo91ESTADO($e_anosesperados_uf));

        $texto->replaceTags("bre_anosestudo10", Formulas::getEAnosEstudo10BRASIL($e_anosesperados_br));
        $texto->replaceTags("bre_anosestudo00", Formulas::getEAnosEstudo00BRASIL($e_anosesperados_br));
        $texto->replaceTags("bre_anosestudo91", Formulas::getEAnosEstudo91BRASIL($e_anosesperados_br));

        if (TextBuilder::$type === "perfil_udh") {
            //MunicÃ­pio e RM em que a UDH estÃ¡ situada
            $mun_da_udh = TextBuilder::getMUN_udh(TextBuilder::$idMunicipio);
            $rm_da_udh = TextBuilder::getRM_udh(TextBuilder::$idMunicipio);

            $e_anosesperados_mun = TextBuilder::getVariaveis_tablePersonalizado($mun_da_udh[0]["id"], "E_ANOSESTUDO", "perfil_m"); //T_ENV
            $e_anosesperados_rm = TextBuilder::getVariaveis_tablePersonalizado($rm_da_udh[0]["id"], "E_ANOSESTUDO", "perfil_rm"); //T_ENV

            $texto->replaceTags("e_anosestudo10_mun_udh", Formulas::getEsperancaVidaNascer10($e_anosesperados_mun));
            $texto->replaceTags("e_anosestudo10_rm_udh", Formulas::getEsperancaVidaNascer10($e_anosesperados_rm));
        }

        $block_anos_esperados->setData("text", $texto->getTexto());
    }

    static public function generateRENDA($block_renda) {

        $rdpc = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "RDPC"); //RDPC  
        $pind = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PIND");  //PIND 
        $pop = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "POP");  //POP 
        $gini = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "GINI");  //GINI 

        $pmpob = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PMPOB");  //GINI 

        if (TextBuilder::$print) {
            $block_renda->setData("quebra", "<div style='page-break-after: always'></div>");
        } else
            $block_renda->setData("quebra", "");

        $block_renda->setData("fonte", TextBuilder::$fontePerfil);
        $block_renda->setData("titulo", TextBuilder::$aba->getTitulo()); //@Translate
        $block_renda->setData("subtitulo", "");
        $block_renda->setData("info", "");

        //@Translate
        $str = TextBuilder::$aba->getTexto();

        $texto = new Texto($str);
        $texto->replaceTags("municipio", TextBuilder::$nomeMunicipio);

        //TODO: Tirar o igual da comparaÃ§Ã£o (feito pq a base nÃ£o Ã© oficial e hÃ¡ replicaÃ§Ãµes
        if (Formulas::getRenda10puro($rdpc) >= Formulas::getRenda91puro($rdpc))
            $texto->replaceTags("caiu_cresceu", TextBuilder::$aba->getCresceu()); //@Translate
        else if (Formulas::getRenda10puro($rdpc) < Formulas::getRenda91puro($rdpc))
            $texto->replaceTags("caiu_cresceu", TextBuilder::$aba->getCaiu()); //@Translate







            
//@NÃ£oInclusoEmRM&UDH
        if (TextBuilder::$type != "perfil_rm" && TextBuilder::$type != "perfil_udh") {
            //$texto->replaceTags("tx_cresc_renda", Formulas::getTxCrescRenda($rdpc));

            $texto->replaceTags("tx_cresc_renda_9110", Formulas::getTxCrescRenda9110($rdpc));
            $texto->replaceTags("tx_media_anual_cresc_renda9110_1por19", Formulas::getTxMediaAnualCrescRenda9110_1por19($rdpc));
            $texto->replaceTags("tx_media_anual_cresc_renda0010_1por9", Formulas::getTxMediaAnualCrescRenda9100_1por9($rdpc));
            $texto->replaceTags("tx_media_anual_cresc_renda0010", Formulas::getTxMediaAnualCrescRenda0010($rdpc));

            //$texto->replaceTags("tx_cresc_renda", Formulas::getTxCrescRenda($rdpc));
            $texto->replaceTags("renda91", Formulas::getRenda91($rdpc));
            $texto->replaceTags("tx_cresc_renda9100", Formulas::getTxCrescRenda9100($rdpc));
            $texto->replaceTags("pmpob_91", Formulas::getProporcaoPobres91($pmpob));
            $texto->replaceTags("tx_pobreza_91", Formulas::getTxPobreza91($pind));
            $texto->replaceTags("gini_91", Formulas::getGini91($gini));

            if (Formulas::getGini10puro($gini) < Formulas::getGini91puro($gini))
                $texto->replaceTags("diminuiu_aumentou", TextBuilder::$aba->getDiminuiu()); //@Translate
            else if (Formulas::getGini10puro($gini) == Formulas::getGini91puro($gini))
                $texto->replaceTags("diminuiu_aumentou", TextBuilder::$aba->getManteve()); //@Translate
            else if (Formulas::getGini10puro($gini) > Formulas::getGini91puro($gini))
                $texto->replaceTags("diminuiu_aumentou", TextBuilder::$aba->getAumentou()); //@Translate      
        }

        $texto->replaceTags("gini_00", Formulas::getGini00($gini));
        $texto->replaceTags("gini_10", Formulas::getGini10($gini));

        $texto->replaceTags("renda00", Formulas::getRenda00($rdpc));
        $texto->replaceTags("renda10", Formulas::getRenda10($rdpc));

        $texto->replaceTags("tx_cresc_renda0010", Formulas::getTxCrescRenda0010($rdpc));
        $texto->replaceTags("tx_media_anual_cresc_renda0010", Formulas::getTxMediaAnualCrescRenda0010($rdpc));

        $texto->replaceTags("pmpob_00", Formulas::getProporcaoPobres00($pmpob));
        $texto->replaceTags("pmpob_10", Formulas::getProporcaoPobres10($pmpob));

        $texto->replaceTags("tx_pobreza_00", Formulas::getTxPobreza00($pind));
        $texto->replaceTags("tx_pobreza_10", Formulas::getTxPobreza10($pind));
        //$texto->replaceTags("red_extrema_pobreza", str_replace(".",",",number_format((( ($pind[0]["valor"] * $pop[0]["valor"]) - ($pind[2]["valor"] * $pop[2]["valor"]) ) / ($pind[0]["valor"] * $pop[0]["valor"])) * 100, 2)));

        if (TextBuilder::$type === "perfil_udh") {
            //MunicÃ­pio e RM em que a UDH estÃ¡ situada
            $mun_da_udh = TextBuilder::getMUN_udh(TextBuilder::$idMunicipio);
            $rm_da_udh = TextBuilder::getRM_udh(TextBuilder::$idMunicipio);

            $texto->replaceTags("mun_udh", $mun_da_udh[0]["nome"]);
            $texto->replaceTags("rm_udh", $rm_da_udh[0]["nome"]);

            $rdpc_mun = TextBuilder::getVariaveis_tablePersonalizado($mun_da_udh[0]["id"], "RDPC", "perfil_m"); //T_ENV
            $rdpc_rm = TextBuilder::getVariaveis_tablePersonalizado($rm_da_udh[0]["id"], "RDPC", "perfil_rm"); //T_ENV

            $pmpob_mun = TextBuilder::getVariaveis_tablePersonalizado($mun_da_udh[0]["id"], "PMPOB", "perfil_m"); //T_ENV            
            $pmpob_rm = TextBuilder::getVariaveis_tablePersonalizado($rm_da_udh[0]["id"], "PMPOB", "perfil_rm"); //T_ENV

            $texto->replaceTags("renda10_mun_udh", Formulas::getRenda10($rdpc_mun));
            $texto->replaceTags("renda10_rm_udh", Formulas::getRenda10($rdpc_rm));

            $texto->replaceTags("pmpob_10_mun_udh", Formulas::getProporcaoPobres10($pmpob_mun));
            $texto->replaceTags("pmpob_10_rm_udh", Formulas::getProporcaoPobres10($pmpob_rm));
        }


        $block_renda->setData("text", $texto->getTexto());
        //@Translate
        $block_renda->setData("block_box1", TextBuilder::$aba->getIGini());

        // GRAFICO
        $block_renda->setData("tableContent", "");
        $block_renda->setData("tableContent2", "");
    }

    static public function generateIDH_table_renda($block_table_renda) {

        $variaveis = array();
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "RDPC")); //Renda per capita mÃ©dia (R$ de 2010)
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PIND")); //ProporÃ§Ã£o de extremamente pobres - total (%)
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PMPOB")); //ProporÃ§Ã£o de pobres 
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "GINI")); //Ã�ndice de Gini

        $block_table_renda->setData("titulo", "");
        $block_table_renda->setData("fonte", TextBuilder::$fontePerfil);
        $block_table_renda->setData("caption", TextBuilder::$aba->getCaption()); //@Translate

        if (TextBuilder::$type == "perfil_rm" || TextBuilder::$type == "perfil_uf")
            $block_table_renda->setData("municipio", TextBuilder::$nomeMunicipio);
        else
            $block_table_renda->setData("municipio", TextBuilder::$nomeMunicipio . " - " . TextBuilder::$ufMunicipio);

        Formulas::printTableRenda($block_table_renda, $variaveis, TextBuilder::$type);

        $block_table_renda->setData("canvasContent", TextBuilder::$aba->getChartRendaPorQuintos(TextBuilder::$idMunicipio));
    }

//    static public function generateIDH_table_renda2($block_table_renda2) {
//
//        $variaveis = array();
//        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PREN20")); //20% mais pobres
//        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PREN40")); //40% mais pobres
//        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PREN60")); //60% mais pobres
//        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PREN80")); //80% mais pobres
//        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PREN20RICOS")); //20% mais ricos
//
//        $block_table_renda2->setData("titulo", "");
//        $block_table_renda2->setData("fonte", TextBuilder::$fontePerfil);
//        $block_table_renda2->setData("caption", TextBuilder::$aba->getCaption2()); //@Translate
//
//        if (TextBuilder::$type == "perfil_rm" || TextBuilder::$type == "perfil_uf")
//            $block_table_renda2->setData("municipio", TextBuilder::$nomeMunicipio);
//        else
//            $block_table_renda2->setData("municipio", TextBuilder::$nomeMunicipio . " - " . TextBuilder::$ufMunicipio);
//
//        Formulas::printTableRenda2($block_table_renda2, $variaveis, TextBuilder::$type);
//    }

    static public function generateTRABALHO1($block_trabalho) {

        $t_ativ18m = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_ATIV18M"); //T_ATIV18M  
        $t_des18m = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_DES18M");  //T_DES18M 

        if (TextBuilder::$print) {
            $block_trabalho->setData("quebra", "<div style='page-break-after: always'></div>");
        } else
            $block_trabalho->setData("quebra", "");

        $block_trabalho->setData("fonte", TextBuilder::$fontePerfil);
        $block_trabalho->setData("titulo", TextBuilder::$aba->getTitulo()); //@Translate
        $block_trabalho->setData("canvasContent", TextBuilder::$aba->getChartTrabalho(TextBuilder::$idMunicipio));

        $block_trabalho->setData("subtitulo", "");
        $block_trabalho->setData("info", "");

        //@Translate
        $str1 = TextBuilder::$aba->getTexto();
        $texto1 = new Texto($str1);
        $texto1->replaceTags("municipio", TextBuilder::$nomeMunicipio);

        $texto1->replaceTags("tx_ativ_18m_00", Formulas::getTxAtiv18m00($t_ativ18m));
        $texto1->replaceTags("tx_ativ_18m_10", Formulas::getTxAtiv18m10($t_ativ18m));

        $texto1->replaceTags("tx_des18m_00", Formulas::getTxDes18m00($t_des18m));
        $texto1->replaceTags("tx_des18m_10", Formulas::getTxDes18m10($t_des18m));

        $block_trabalho->setData("text1", $texto1->getTexto());
        $block_trabalho->setData("text2", "");
    }

    static public function generateIDH_table_trabalho($block_table_trabalho) {

        $variaveis = array();
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_ATIV18M")); //Taxa de atividade
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_DES18M")); //Taxa de desocupaÃ§Ã£o
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "P_FORMAL")); //Grau de formalizaÃ§Ã£o dos ocuupados
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "P_FUND")); //% de empregados com fundamental completo
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "P_MED")); //% de empregados com mÃ©dio completo
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "REN1")); //% com atÃ© 1 s.m. 
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "REN2")); //% com atÃ© 2 s.m. 
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "REN5")); //% com atÃ© 5 s.m. 
        //array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "THEILtrab")); //% Theil dos rendimentos do trabalho  

        $block_table_trabalho->setData("titulo", "");
        $block_table_trabalho->setData("fonte", TextBuilder::$fontePerfil);
        $block_table_trabalho->setData("caption", TextBuilder::$aba->getCaption()); //@Translate
        $block_table_trabalho->setData("titulo1", TextBuilder::$aba->getSubCaption1()); //@Translate
        $block_table_trabalho->setData("titulo2", TextBuilder::$aba->getSubCaption2()); //@Translate
        $block_table_trabalho->setData("t", "");

        if (TextBuilder::$type == "perfil_rm" || TextBuilder::$type == "perfil_uf")
            $block_table_trabalho->setData("municipio", TextBuilder::$nomeMunicipio);
        else
            $block_table_trabalho->setData("municipio", TextBuilder::$nomeMunicipio . " - " . TextBuilder::$ufMunicipio);

        Formulas::printTableTrabalho($block_table_trabalho, $variaveis);
    }

    static public function generateTRABALHO2($block_trabalho) {

        $p_agro = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "P_AGRO");  //P_AGRO 
        $p_extr = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "P_EXTR");  //P_EXTR
        $p_transf = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "P_TRANSF");  //P_TRANSF
        $p_constr = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "P_CONSTR"); //P_CONSTR
        $p_siup = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "P_SIUP");  //P_SIUP
        $p_com = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "P_COM");  //P_COM
        $p_serv = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "P_SERV");  //P_SERV

        $block_trabalho->setData("titulo", "");
        $block_trabalho->setData("canvasContent", "");
        $block_trabalho->setData("subtitulo", "");
        $block_trabalho->setData("info", "");

        //@Translate
        $str2 = TextBuilder::$aba->getTexto2();
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

        if (TextBuilder::$print) {
            $block_habitacao->setData("quebra", "<div style='page-break-after: always'></div>");
        } else
            $block_habitacao->setData("quebra", "");

        $block_habitacao->setData("fonte", TextBuilder::$fontePerfil);
        $block_habitacao->setData("titulo", TextBuilder::$aba->getTitulo()); //@Translate
        $block_habitacao->setData("subtitulo", "");
        $block_habitacao->setData("info", "");
        $block_habitacao->setData("tableContent", "");
    }

    static public function generateIDH_table_habitacao($block_table_habitacao) {

        $variaveis = array();
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_AGUA")); //Ã¡gua encanada
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_LUZ")); //energia elÃ©trica
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_LIXO")); //coleta de lixo*

        $block_table_habitacao->setData("titulo", "");
        $block_table_habitacao->setData("fonte", TextBuilder::$fontePerfil);
        $block_table_habitacao->setData("caption", TextBuilder::$aba->getCaption()); //@Translate

        if (TextBuilder::$type == "perfil_rm" || TextBuilder::$type == "perfil_uf")
            $block_table_habitacao->setData("municipio", TextBuilder::$nomeMunicipio);
        else
            $block_table_habitacao->setData("municipio", TextBuilder::$nomeMunicipio . " - " . TextBuilder::$ufMunicipio);

        //@Translate
        $texto = TextBuilder::$aba->getObs();
        Formulas::printTableHabitacao($block_table_habitacao, $variaveis, $texto, TextBuilder::$type);

        if (TextBuilder::$print) {
            $block_table_habitacao->setData("quebra", "<div style='page-break-after: always'></div>");
        } else
            $block_table_habitacao->setData("quebra", "");
    }

    static public function generateVULNERABILIDADE($block_vulnerabilidade) {

        if (TextBuilder::$print) {
            $block_vulnerabilidade->setData("quebra", "<div style='page-break-after: always'></div>");
        } else
            $block_vulnerabilidade->setData("quebra", "");

        $block_vulnerabilidade->setData("fonte", TextBuilder::$fontePerfil);
        $block_vulnerabilidade->setData("titulo", TextBuilder::$aba->getTitulo()); //@Translate
        $block_vulnerabilidade->setData("subtitulo", "");
        $block_vulnerabilidade->setData("info", "");

        $block_vulnerabilidade->setData("tableContent", "");
    }

    static public function generateIDH_table_vulnerabilidade($block_table_vulnerabilidade) {

        $variaveis = array();
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "MORT1")); //Mortalidade infantil
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FORA0A5")); //Percentual de pessoas de 4 a 5 anos de idade fora da escola
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FORA6A14")); //Percentual de pessoas de 6 a 14 anos de idade fora da escola
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_NESTUDA_NTRAB_MMEIO")); //Percentual de pessoas de 15 a 24 anos de idade que nÃ£o estuda e nÃ£o trabalha e cuja renda per capita <Â½  salÃ¡rio mÃ­nimo
        //array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_M10A14CF")); //Percentual de mulheres de 10 a 14 anos de idade que tiveram filhos
        //array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_M15A17CF")); //Percentual de mulheres de 15 a 17 anos de idade que tiveram filhos
        //@#Mudar variÃ¡vel - T_M10A17CF   (T_M15A17CF)
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_M10A17CF")); //Percentual de mulheres de 10 a 17 anos de idade que tiveram filhos
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_ATIV1014")); //Taxa de atividade de crianÃ§as e jovens que possuem entre 10 e 14 anos de idade

        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_MULCHEFEFIF014")); //Percentual de mÃ£es chefes de famÃ­lia sem fundamental completo com filhos menores de 15 anos 
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_RMAXIDOSO")); //Percentual de pessoas em domicÃ­lios com renda per capita < Â½ salÃ¡rio mÃ­nimo e cuja principal renda Ã© de pessoa com 65 anos ou mais
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PINDCRI")); //Percentual de crianÃ§as que vivem em extrema pobreza, ou seja, em domicÃ­lios com renda per capita abaixo de R% 70,00.

        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PPOB")); //#XXPercentual de pessoas em domicÃ­lios com renda per capita inferior a R$ 225,00 (1/2 salÃ¡rio mÃ­nimo em agosto/2010)
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_FUNDIN18MINF")); //Percentual de pessoas de 18 anos ou mais sem fundamental completo e em ocupaÃ§Ã£o informal
        //array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "AGUA_ESGOTO")); //Percentual de pessoas em domicÃ­lios cujo abastecimento de Ã¡gua nÃ£o seja por rede geral ou esgotamento sanitÃ¡rio nÃ£o realizado por rede coletora de esgoto ou fossa sÃ©ptica
        array_push($variaveis, TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "T_BANAGUA"));

        $block_table_vulnerabilidade->setData("titulo", TextBuilder::$aba->getSubCaption1()); //@Translate
        $block_table_vulnerabilidade->setData("titulo1", TextBuilder::$aba->getSubCaption2()); //@Translate
        $block_table_vulnerabilidade->setData("titulo2", TextBuilder::$aba->getSubCaption3()); //@Translate
        $block_table_vulnerabilidade->setData("titulo3", TextBuilder::$aba->getSubCaption4()); //@Translate
        $block_table_vulnerabilidade->setData("fonte", TextBuilder::$fontePerfil);
        $block_table_vulnerabilidade->setData("t", "");
        $block_table_vulnerabilidade->setData("caption", TextBuilder::$aba->getCaption()); //@Translate

        if (TextBuilder::$type == "perfil_rm" || TextBuilder::$type == "perfil_uf")
            $block_table_vulnerabilidade->setData("municipio", TextBuilder::$nomeMunicipio);
        else
            $block_table_vulnerabilidade->setData("municipio", TextBuilder::$nomeMunicipio . " - " . TextBuilder::$ufMunicipio);

        Formulas::printTableVulnerabilidade($block_table_vulnerabilidade, $variaveis, TextBuilder::$type);
    }

    static function my_number_format($number, $decimais = 2, $separador_decimal = ",", $separador_milhar = ".") {
        // NÃºmero vazio? 
        if (trim($number) == "")
            return $number;
        // se for um double precisamos garantir que nÃ£o serÃ¡ covertido em 
        // notaÃ§Ã£o cientÃ­fica e que valores terminados em .90 tenha o zero removido 
        if (is_float($number) || is_double($number)) {
            $number = sprintf("%.{$decimais}f", $number);
        }
        // Convertendo para uma string numÃ©rica 
        $number = preg_replace('#\D#', '', $number);

        // separando a parte decimal 
        $decimal = '';
        if ($decimais > 0) {
            $number = sprintf("%.{$decimais}f", ($number / pow(10, $decimais)));
            if (preg_match("#^(\d+)\D(\d{{$decimais}})$#", $number, $matches)) {
                $decimal = $separador_decimal . $matches[2];
                $number = $matches[1];
            }
        }
        // formatando a parte inteira 
        if ($separador_milhar != '') {
            $number = implode($separador_milhar, array_reverse(array_map('strrev', str_split(strrev($number), 3))));
        }
        return $number . $decimal;
    }

    static function getVariaveis_table($municipio, $variavel) {

        if (TextBuilder::$type == "perfil_m") {
            $espacialidade = "municipio";
            $valor_variavel = "valor_variavel_mun";
            $fk = "fk_municipio";
        } else if (TextBuilder::$type == "perfil_rm") {
            $espacialidade = "rm";
            $valor_variavel = "valor_variavel_rm";
            $fk = "fk_rm";
        } else if (TextBuilder::$type == "perfil_uf") {
            $espacialidade = "estado";
            $valor_variavel = "valor_variavel_estado";
            $fk = "fk_estado";
        } else if (TextBuilder::$type == "perfil_udh") {
            $espacialidade = "udh";
            $valor_variavel = "valor_variavel_udh";
            $fk = "fk_udh";
        }

        $SQL = "SELECT label_ano_referencia, lang_var.nomecurto,  lang_var.nome_perfil,
                lang_var.definicao, valor
                FROM " . $valor_variavel . " INNER JOIN variavel
                ON fk_variavel = variavel.id
                INNER JOIN ano_referencia
                ON ano_referencia.id = fk_ano_referencia
                INNER JOIN lang_var
                ON variavel.id = lang_var.fk_variavel
                WHERE " . $fk . " = $municipio and sigla like '$variavel' and lang like '" . TextBuilder::$lang . "'
                 ORDER BY label_ano_referencia";

        //echo $SQL . "<br><br>"; 
        return TextBuilder::$bd->ExecutarSQL($SQL, "getVariaveis_table");
    }

    static function getVariaveis_tablePersonalizado($municipio, $variavel, $type) {

        if ($type == "perfil_m") {
            $espacialidade = "municipio";
            $valor_variavel = "valor_variavel_mun";
            $fk = "fk_municipio";
        } else if ($type == "perfil_rm") {
            $espacialidade = "rm";
            $valor_variavel = "valor_variavel_rm";
            $fk = "fk_rm";
        } else if ($type == "perfil_uf") {
            $espacialidade = "estado";
            $valor_variavel = "valor_variavel_estado";
            $fk = "fk_estado";
        } else if ($type == "perfil_udh") {
            $espacialidade = "udh";
            $valor_variavel = "valor_variavel_udh";
            $fk = "fk_udh";
        }

        $SQL = "SELECT label_ano_referencia, lang_var.nomecurto,  lang_var.nome_perfil,
                lang_var.definicao, valor
                FROM " . $valor_variavel . " INNER JOIN variavel
                ON fk_variavel = variavel.id
                INNER JOIN ano_referencia
                ON ano_referencia.id = fk_ano_referencia
                INNER JOIN lang_var
                ON variavel.id = lang_var.fk_variavel
                WHERE " . $fk . " = $municipio and sigla like '$variavel' and lang like '" . TextBuilder::$lang . "'
                 ORDER BY label_ano_referencia";

        //echo $SQL . "<br><br>"; 
        return TextBuilder::$bd->ExecutarSQL($SQL, "getVariaveis_tablePersonalizado");
    }

//    static function getMenorIDHM_UDH_RM($rm_id) {
//
//        $SQL = "SELECT u.fk_rm, valor FROM udh u
//            INNER JOIN valor_variavel_udh vvu ON u.id = vvu.fk_udh
//            INNER JOIN variavel v ON vvu.fk_variavel = v.id
//            WHERE u.fk_rm = $rm_id AND v.sigla ilike 'IDHM' AND fk_ano_referencia = 3
//            ORDER BY valor ASC LIMIT 1";
// 
//        return TextBuilder::$bd->ExecutarSQL($SQL, "getMenorIDHM_UDH_RM");
//    }

    static function getMaiorMenorIDHM_UDH($area, $id, $asc_desc, $variavel = "IDHM") {

        if ($area === "mun") {
            $fk = "fk_municipio";
        } else if ($area === "rm") {
            $fk = "fk_rm";
        }

        $SQL = "SELECT u.id, u.nome, valor FROM udh u
            INNER JOIN valor_variavel_udh vvu ON u.id = vvu.fk_udh
            INNER JOIN variavel v ON vvu.fk_variavel = v.id
            WHERE u.$fk = $id AND v.sigla ilike '$variavel' AND fk_ano_referencia = 3
            ORDER BY valor $asc_desc LIMIT 1";

        return TextBuilder::$bd->ExecutarSQL($SQL, "getMenorIDHM_UDH_RM");
    }

    static function getVariaveis_Uf($municipio, $variavel) {


        if (TextBuilder::$type == "perfil_udh")
            $espacialidade = "udh";
        else
            $espacialidade = "municipio";

        $SQL = "SELECT label_ano_referencia, variavel.nomecurto, valor 
                FROM valor_variavel_estado";

        $SQL .= " INNER JOIN municipio
                ON municipio.fk_estado = valor_variavel_estado.fk_estado";

        if (TextBuilder::$type == "perfil_udh") {
            $SQL .= " INNER JOIN udh
            ON udh.fk_municipio = municipio.id";
        }

        $SQL .= " INNER JOIN variavel
                ON fk_variavel = variavel.id
                INNER JOIN ano_referencia
                ON ano_referencia.id = fk_ano_referencia
                WHERE " . $espacialidade . ".id = $municipio and sigla like '$variavel'
                 ORDER BY label_ano_referencia;";

        // echo $SQL;
        return TextBuilder::$bd->ExecutarSQL($SQL, "getVariaveis_Uf");
    }

    static function getVariaveis_RM($municipio, $variavel) {

        $SQL = "SELECT label_ano_referencia, variavel.nomecurto, valor 
                FROM valor_variavel_rm";

        $SQL .= " INNER JOIN municipio
                ON municipio.fk_rm = valor_variavel_rm.fk_rm";

        $SQL .= " INNER JOIN udh
            ON udh.fk_municipio = municipio.id";

        $SQL .= " INNER JOIN variavel
                ON fk_variavel = variavel.id
                INNER JOIN ano_referencia
                ON ano_referencia.id = fk_ano_referencia
                WHERE udh.id = $municipio and sigla like '$variavel'
                 ORDER BY label_ano_referencia;";

        // echo $SQL;
        return TextBuilder::$bd->ExecutarSQL($SQL, "getVariaveis_Uf");
    }

    //static function getVariaveis_Brasil($municipio, $variavel) {
    static function getVariaveis_Brasil($variavel) {

//        $SQL = "SELECT label_ano_referencia, variavel.nomecurto, valor 
//                FROM valor_variavel_pais
//                INNER JOIN pais
//                ON pais.id = valor_variavel_pais.fk_pais
//                INNER JOIN estado
//                ON pais.id = estado.fk_pais
//                INNER JOIN municipio
//                ON municipio.fk_estado = estado.id
//                INNER JOIN variavel
//                ON fk_variavel = variavel.id
//                INNER JOIN ano_referencia
//                ON ano_referencia.id = fk_ano_referencia
//                WHERE municipio.id = $municipio and variavel.sigla like '$variavel' ORDER BY label_ano_referencia;";

        $SQL = "SELECT label_ano_referencia, variavel.nomecurto, valor 
                FROM valor_variavel_pais
                INNER JOIN pais
                ON pais.id = valor_variavel_pais.fk_pais
                INNER JOIN variavel
                ON fk_variavel = variavel.id
                INNER JOIN ano_referencia
                ON ano_referencia.id = fk_ano_referencia
                WHERE variavel.sigla like '$variavel' ORDER BY label_ano_referencia;";

        return TextBuilder::$bd->ExecutarSQL($SQL, "getVariaveis_Brasil");
    }

    static function getRanking($condicao) {

        if (TextBuilder::$type == "perfil_m") {
            $espacialidade = "municipio";
            $valor_variavel = "valor_variavel_mun";
            $fk = "fk_municipio";
        } else if (TextBuilder::$type == "perfil_rm") {
            $espacialidade = "rm";
            $valor_variavel = "valor_variavel_rm";
            $fk = "fk_rm";
        } else if (TextBuilder::$type == "perfil_uf") {
            $espacialidade = "estado";
            $valor_variavel = "valor_variavel_estado";
            $fk = "fk_estado";
        } else if (TextBuilder::$type == "perfil_udh") {
            $espacialidade = "udh";
            $valor_variavel = "valor_variavel_udh";
            $fk = "fk_udh";
        }

        $SQL = "SELECT ROW_NUMBER() OVER(ORDER BY valor DESC, " . $espacialidade . ".nome ASC),
            " . $espacialidade . ".id, " . $espacialidade . ".nome, nomecurto, valor 
        FROM " . $valor_variavel . " INNER JOIN variavel
        ON fk_variavel = variavel.id
        INNER JOIN " . $espacialidade . "
        ON " . $espacialidade . ".id = " . $valor_variavel . "." . $fk . "
        WHERE sigla like 'IDHM' AND fk_ano_referencia = 3 ";

        if (TextBuilder::$type == "perfil_rm") {
            $SQL .= " AND rm.ativo = TRUE ";
        }

        if ($condicao == "todos")
            $SQL .= ";";
        else if ($condicao == "primeiro")
            $SQL .= "ORDER BY row_number ASC LIMIT 1;";
        else if ($condicao == "ultimo")
            $SQL .= "ORDER BY row_number DESC LIMIT 1;";

        return TextBuilder::$bd->ExecutarSQL($SQL, "getRanking");
    }

    static function getUf($municipio) {


        if (TextBuilder::$type == "perfil_udh")
            $espacialidade = "udh";
        else
            $espacialidade = "municipio";

        $SQL = "SELECT estado.id, estado.nome
            FROM " . $espacialidade;

        if (TextBuilder::$type == "perfil_udh") {
            $SQL .= " INNER JOIN municipio
            ON udh.fk_municipio = municipio.id";
        }

        $SQL .= " INNER JOIN estado
            ON estado.id = municipio.fk_estado
            WHERE " . $espacialidade . ".id= $municipio;";

        //echo $SQL;
        return TextBuilder::$bd->ExecutarSQL($SQL, "getRanking");
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

        return TextBuilder::$bd->ExecutarSQL($SQL, "getRanking");
    }

    static function getIDHM_Igual($idhm) {

        $SQL = "SELECT municipio.id, municipio.nome, variavel.nomecurto, valor 
            FROM valor_variavel_mun INNER JOIN variavel
            ON fk_variavel = variavel.id
            INNER JOIN municipio
            ON municipio.id = valor_variavel_mun.fk_municipio
            WHERE valor = $idhm AND fk_ano_referencia = 3
            ORDER BY  municipio.nome ASC";

        return TextBuilder::$bd->ExecutarSQL($SQL, "getIDHM_Igual");
    }

    static function getIDHM_Igual_Uf($idhm, $estado) {

        $SQL = "SELECT municipio.id, municipio.nome, variavel.nomecurto, valor 
            FROM valor_variavel_mun INNER JOIN variavel
            ON fk_variavel = variavel.id
            INNER JOIN municipio
            ON municipio.id = valor_variavel_mun.fk_municipio
            INNER JOIN estado
            ON estado.id = municipio.fk_estado
            WHERE valor = $idhm AND fk_ano_referencia = 3 AND estado.id = $estado 
            ORDER BY  municipio.nome ASC";

        return TextBuilder::$bd->ExecutarSQL($SQL, "getIDHM_Igual");
    }

    static function getMunicipios_rm($id) {


        $SQL = "SELECT municipio.id, municipio.nome, estado.uf FROM rm INNER JOIN municipio ON
            rm.id = municipio.fk_rm
            INNER JOIN estado ON municipio.fk_estado = estado.id
            WHERE rm.id  = $id 
                ORDER BY municipio.nome";

        //echo $SQL . "<br><br>"; 
        return TextBuilder::$bd->ExecutarSQL($SQL, "getMunicipios_rm");
    }

    static function getCountUDH_rm($id) {


        $SQL = "SELECT count(*) as count_udh FROM udh
                WHERE udh.fk_rm = $id";

        return TextBuilder::$bd->ExecutarSQL($SQL, "getCountUDH_rm");
    }

    static function getRM_udh($id) {

        $SQL = "SELECT rm.id, rm.nome FROM udh 
            INNER JOIN rm ON udh.fk_rm = rm.id
            WHERE udh.id  = $id ";

        //echo $SQL . "<br><br>"; 
        return TextBuilder::$bd->ExecutarSQL($SQL, "getRM_udh");
    }

    static function getMUN_udh($id) {

        $SQL = "SELECT municipio.id, municipio.nome FROM udh 
            INNER JOIN municipio ON udh.fk_municipio = municipio.id
            WHERE udh.id  = $id ";

        //echo $SQL . "<br><br>"; 
        return TextBuilder::$bd->ExecutarSQL($SQL, "getMUN_udh");
    }

}

?>

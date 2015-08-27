<?php

/**
 * Construção do Componente por Tipo e Idioma
 *
 * @author Andre Castro
 */
class ITCaracterizacao extends IT {

    //Municipio
    //PT
    //Padrão
//    protected $tituloPT = "IDHM";
//    protected $subtituloPT = "Componentes";
//    protected $tituloEN = "MHDI";
//    protected $subtituloEN = "Components";
//    protected $tituloES = "IDHM";
//    protected $subtituloES = "Componentes";
//    //Tabela
//    protected $tituloTablePT = "IDHM e componentes";
//    protected $captionPT = "Índice de Desenvolvimento Humano Municipal e seus componentes";
//    protected $tituloTableEN = "MHDI and components";
//    protected $captionEN = "Municipal Human Development Index (MHDI)";
//    protected $tituloTableES = "IDHM y componentes";
//    protected $captionES = "Índice de Desarrollo Humano Municipal y sus componentes";

    function getTabelaCaracterizacao() {

        $carac_mun = Perfil::getCaracteristicas(TextBuilder::$idMunicipio); //IDHM
        $pop = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "PESOTOT"); //IDHM_R
        
        $area = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "AREA"); //IDHM_R
        $densidade = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "DENSIDADE"); //IDHM_R
        $anoinst = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "ANOINST"); //IDHM_R
        
        $micro_meso = Perfil::getMicroMeso(TextBuilder::$idMunicipio, "PESOTOT"); //IDHM_R
        $uf_rm = Perfil::getUfRm(TextBuilder::$idMunicipio);
        $idhm = TextBuilder::getVariaveis_table(TextBuilder::$idMunicipio, "IDHM"); //IDHM_R


        

        switch ($this->type) {
            case "perfil_m":

                if ($this->lang == "pt") {

                    $tabela = new BlockTabela("Caracterização do território", 2, 4, $this->type);
                    //$tabela->setManual("link", $path_dir."atlas/tabela/nulo/mapa/municipal/filtro/municipio/{$this->nomeCru}/indicador/idhm-2010");
                    $tabela->addBox("Área", str_replace(".", ",", $carac_mun[0]["area"]) . " km²");
                    $tabela->addBox("IDHM 2010", str_replace(".", ",", number_format($idhm[2]["valor"], 3)));
                    $tabela->addBox("Faixa do IDHM", Formulas::getSituacaoIDH($idhm, $this->lang));
                    $tabela->addBox("População (Censo 2010)", number_format($pop[2]["valor"], 0, ",", ".")  . " hab.");

                    $tabela->addBox("Densidade demográfica", str_replace(".", ",", $carac_mun[0]["densidade"]) . " hab/km²");
                    $tabela->addBox("Ano de instalação", $carac_mun[0]["anoinst"]);
                    $tabela->addBox("Microrregião", $micro_meso[0]["micro"]);
                    $tabela->addBox("Mesorregião", $micro_meso[0]["meso"]);
                } else if ($this->lang == "en") {

                    $tabela = new BlockTabela("Characterization of the territory", 2, 4, $this->type);
                    //$tabela->setManual("link", $path_dir."atlas/tabela/nulo/mapa/municipal/filtro/municipio/{$this->nomeCru}/indicador/idhm-2010");
                    $tabela->addBox("Area", str_replace(".", ",", $carac_mun[0]["area"]) . " km²");
                    $tabela->addBox("MHDI 2010", str_replace(".", ",", number_format($idhm[2]["valor"], 3)));
                    $tabela->addBox("MHDI category", Formulas::getSituacaoIDH($idhm, $this->lang));
                    $tabela->addBox("Population (Census of 2000)", number_format($pop[2]["valor"], 0, ",", ".") . " Inhabitants");

                    $tabela->addBox("Population density", str_replace(".", ",", $carac_mun[0]["densidade"]) . " inhabitants/km²");
                    $tabela->addBox("Year of Establishment", $carac_mun[0]["anoinst"]);
                    $tabela->addBox("Microregion", $micro_meso[0]["micro"]);
                    $tabela->addBox("Mesoregion", $micro_meso[0]["meso"]);
                } else if ($this->lang == "es") {

                    $tabela = new BlockTabela("Caracterización del territorio", 2, 4, $this->type);
                    //$tabela->setManual("link", $path_dir."atlas/tabela/nulo/mapa/municipal/filtro/municipio/{$this->nomeCru}/indicador/idhm-2010");
                    $tabela->addBox("Area", str_replace(".", ",", $carac_mun[0]["area"]) . " km²");
                    $tabela->addBox("IDHM 2010", str_replace(".", ",", number_format($idhm[2]["valor"], 3)));
                    $tabela->addBox("Nivel de IDHM", Formulas::getSituacaoIDH($idhm, $this->lang));
                    $tabela->addBox("Población (censo 2010)", number_format($pop[2]["valor"], 0, ",", ".") . " hab.");

                    $tabela->addBox("Densidad demográfica", str_replace(".", ",", $carac_mun[0]["densidade"]) . " hab/km²");
                    $tabela->addBox("Año de fundación", $carac_mun[0]["anoinst"]);
                    $tabela->addBox("Microrregión", $micro_meso[0]["micro"]);
                    $tabela->addBox("Mesorregión", $micro_meso[0]["meso"]);
                }

                break;

            case "perfil_rm":

                if ($this->lang == "pt") {

                    $tabela = new BlockTabela("Caracterização do território", 1, 5, $this->type);
                    //$tabela->setManual("link", $path_dir."atlas/tabela/nulo/mapa/municipal/filtro/municipio/{$this->nomeCru}/indicador/idhm-2010");
                    //$tabela->addBox("Área", $area[2]["valor"] . " km²");
                    $tabela->addBox("IDHM 2010", str_replace(".", ",", number_format($idhm[2]["valor"], 3)));
                    $tabela->addBox("Faixa do IDHM", Formulas::getSituacaoIDH($idhm, $this->lang));
                    $tabela->addBox("População (Censo 2010)", number_format($pop[2]["valor"], 0, ",", ".") . " hab.");
                    $tabela->addBox("Área", isset($area[2]["valor"]) ? str_replace(".", ",",$area[2]["valor"]) . " km²" : "");
                    $tabela->addBox("Densidade demográfica", isset($densidade[2]["valor"]) ? str_replace(".", ",",$densidade[2]["valor"]) . " hab/km²" : "");
                    //$tabela->addBox("Ano de instalação", $anoinst[2]["valor"]);
//                    $tabela->addBox("Região", $micro_meso[0]["micro"]);
//                    $tabela->addBox("Estado", $micro_meso[0]["meso"]);
//                    $tabela->addBox("", ""); 
//                    $tabela->addBox("", ""); 
//                    $tabela->addBox("", "");
                } else if ($this->lang == "en") {

                    $tabela = new BlockTabela("Characterization of the territory", 2, 4, $this->type);
                    //$tabela->setManual("link", $path_dir."atlas/tabela/nulo/mapa/municipal/filtro/municipio/{$this->nomeCru}/indicador/idhm-2010");
                    $tabela->addBox("Area", "");
                    $tabela->addBox("MHDI 2010", str_replace(".", ",", number_format($idhm[2]["valor"], 3)));
                    $tabela->addBox("MHDI category", Formulas::getSituacaoIDH($idhm, $this->lang));
                    $tabela->addBox("Population (Census of 2000)", number_format($pop[2]["valor"], 0, ",", ".") . " Inhabitants");

                    $tabela->addBox("Population density", "");
                    $tabela->addBox("Year of Establishment", "");
                    $tabela->addBox("", "");
                    $tabela->addBox("", "");
                } else if ($this->lang == "es") {

                    $tabela = new BlockTabela("Caracterización del territorio", 2, 4, $this->type);
                    //$tabela->setManual("link", $path_dir."atlas/tabela/nulo/mapa/municipal/filtro/municipio/{$this->nomeCru}/indicador/idhm-2010");
                    $tabela->addBox("Area", "");
                    $tabela->addBox("IDHM 2010", str_replace(".", ",", number_format($idhm[2]["valor"], 3)));
                    $tabela->addBox("Nivel de IDHM", Formulas::getSituacaoIDH($idhm, $this->lang));
                    $tabela->addBox("Población (censo 2010)", number_format($pop[2]["valor"], 0, ",", ".") . " hab.");

                    $tabela->addBox("Densidad demográfica", "");
                    $tabela->addBox("Año de fundación", "");
                    $tabela->addBox("", "");
                    $tabela->addBox("", "");
                }
                break;

            case "perfil_uf":

                if ($this->lang == "pt") {

                    $tabela = new BlockTabela("Caracterização do território", 1, 5, $this->type);
                    //$tabela->setManual("link", $path_dir."atlas/tabela/nulo/mapa/municipal/filtro/municipio/{$this->nomeCru}/indicador/idhm-2010");
                    $tabela->addBox("IDHM 2010", str_replace(".", ",", number_format($idhm[2]["valor"], 3)));
                    $tabela->addBox("Faixa do IDHM", Formulas::getSituacaoIDH($idhm, $this->lang));
                    $tabela->addBox("População (Censo 2010)", number_format($pop[2]["valor"], 0, ",", ".") . " hab.");
                    $tabela->addBox("Área", isset($area[2]["valor"]) ? str_replace(".", ",",$area[2]["valor"]) . " km²" : "");
                    $tabela->addBox("Densidade demográfica", isset($densidade[2]["valor"]) ? str_replace(".", ",",$densidade[2]["valor"]) . " hab/km²" : "");
                    
                    //$tabela->addBox("Ano de instalação", "");
                    //$tabela->addBox("", "");
                    //$tabela->addBox("", "");
                } else if ($this->lang == "en") {

                    $tabela = new BlockTabela("Characterization of the territory", 1, 5, $this->type);
                    //$tabela->setManual("link", $path_dir."atlas/tabela/nulo/mapa/municipal/filtro/municipio/{$this->nomeCru}/indicador/idhm-2010");                    
                    $tabela->addBox("MHDI 2010", str_replace(".", ",", number_format($idhm[2]["valor"], 3)));
                    $tabela->addBox("MHDI category", Formulas::getSituacaoIDH($idhm, $this->lang));
                    $tabela->addBox("Population (Census of 2000)", number_format($pop[2]["valor"], 0, ",", ".") . " Inhabitants");
                    $tabela->addBox("Area", "");
                    $tabela->addBox("Population density", "");
                   
                    //$tabela->addBox("Year of Establishment", "");
                    //$tabela->addBox("", "");
                    //$tabela->addBox("", "");
                } else if ($this->lang == "es") {

                    $tabela = new BlockTabela("Caracterización del territorio", 1, 5, $this->type);
                    //$tabela->setManual("link", $path_dir."atlas/tabela/nulo/mapa/municipal/filtro/municipio/{$this->nomeCru}/indicador/idhm-2010");                    
                    $tabela->addBox("IDHM 2010", str_replace(".", ",", number_format($idhm[2]["valor"], 3)));
                    $tabela->addBox("Nivel de IDHM", Formulas::getSituacaoIDH($idhm, $this->lang));
                    $tabela->addBox("Población (censo 2010)", number_format($pop[2]["valor"], 0, ",", ".") . " hab.");
                    $tabela->addBox("Area", "");
                    $tabela->addBox("Densidad demográfica", "");
                   
                    //$tabela->addBox("Año de fundación", "");
                    //$tabela->addBox("", "");
                    //$tabela->addBox("", "");
                }

                break;

            case "perfil_udh":
                
//                echo "<script type='text/javascript'>
//            
//                    rmUrl = retira_acentos('" . $uf_rm[0]["nome"] . "').replace(/\s/g, '-');
//                    ufUrl = retira_acentos('" . $uf_rm[0]["nomeuf"] . "').replace(/\s/g, '-');
//
//                    splited = document.URL.split('/');
//
//                    rmLink = splited[0]+ '/' +splited[1]+ '/' +splited[2]+ '/' +splited[3]+ '/'
//                    +splited[4]+ '/' +'perfil_rm/' + rmUrl;
//
//                    ufLink = splited[0]+ '/' +splited[1]+ '/' +splited[2]+ '/' +splited[3]+ '/'
//                    +splited[4]+ '/' +'perfil_uf/' + ufUrl;
//
//                    document.getElementById('myRmLink').href = rmLink;
//                    document.getElementById('myUfLink').href = ufLink;
//
//                    //alert(mont);
//                    </script>";

                if ($this->lang == "pt") {

                    $tabela = new BlockTabela("Caracterização do território", 1, 5, $this->type);
                    //$tabela->setManual("link", $path_dir."atlas/tabela/nulo/mapa/municipal/filtro/municipio/{$this->nomeCru}/indicador/idhm-2010");
                    //$tabela->addBox("Área", "");
                    $tabela->addBox("IDHM 2010", str_replace(".", ",", number_format($idhm[2]["valor"], 3)));
                    $tabela->addBox("Faixa do IDHM", Formulas::getSituacaoIDH($idhm, $this->lang));
                    $tabela->addBox("População (Censo 2010)", number_format($pop[2]["valor"], 0, ",", ".") . " hab.");
                    $tabela->addBox("Área", isset($area[2]["valor"]) ? str_replace(".", ",",$area[2]["valor"]) . " km²" : "");
                    $tabela->addBox("Densidade demográfica", isset($densidade[2]["valor"]) ? str_replace(".", ",",$densidade[2]["valor"]) . " hab/km²" : "");
                    
//                    $tabela->addBox("Ano de instalação", "");
//                    $tabela->addBox("Região Metropolitana", "<a href='#' id='myRmLink'>" . $uf_rm[0]["rm"] . "</a>");
//                    $tabela->addBox("Estado", "<a href='#' id='myUfLink'>" . $uf_rm[0]["nomeuf"] . "</a>");
                } else if ($this->lang == "en") {

                    $tabela = new BlockTabela("Characterization of the territory", 2, 4, $this->type);
                    //$tabela->setManual("link", $path_dir."atlas/tabela/nulo/mapa/municipal/filtro/municipio/{$this->nomeCru}/indicador/idhm-2010");
                    $tabela->addBox("Area", "");
                    $tabela->addBox("MHDI 2010", str_replace(".", ",", number_format($idhm[2]["valor"], 3)));
                    $tabela->addBox("MHDI category", Formulas::getSituacaoIDH($idhm, $this->lang));
                    $tabela->addBox("Population (Census of 2000)", number_format($pop[2]["valor"], 0, ",", ".") . " Inhabitants");

                    $tabela->addBox("Population density", "");
                    $tabela->addBox("Year of Establishment", "");
                    $tabela->addBox("Metropolitan Region", "<a href='#' id='myRmLink'>" . $uf_rm[0]["rm"] . "</a>");
                    $tabela->addBox("State", "<a href='#' id='myUfLink'>" . $uf_rm[0]["nomeuf"] . "</a>");
                } else if ($this->lang == "es") {

                    $tabela = new BlockTabela("Caracterización del territorio", 2, 4, $this->type);
                    //$tabela->setManual("link", $path_dir."atlas/tabela/nulo/mapa/municipal/filtro/municipio/{$this->nomeCru}/indicador/idhm-2010");
                    $tabela->addBox("Area", "");
                    $tabela->addBox("IDHM 2010", str_replace(".", ",", number_format($idhm[2]["valor"], 3)));
                    $tabela->addBox("Nivel de IDHM", Formulas::getSituacaoIDH($idhm, $this->lang));
                    $tabela->addBox("Población (censo 2010)", number_format($pop[2]["valor"], 0, ",", ".") . " hab.");

                    $tabela->addBox("Densidad demográfica", "");
                    $tabela->addBox("Año de fundación", "");
                    $tabela->addBox("Región Metropolitana", "<a href='#' id='myRmLink'>" . $uf_rm[0]["rm"] . "</a>");
                    $tabela->addBox("Estado", "<a href='#' id='myUfLink'>" . $uf_rm[0]["nomeuf"] . "</a>");
                }

                break;
                ;

            default:
                break;
        }


        $tabela->draw();
    }

}

?>

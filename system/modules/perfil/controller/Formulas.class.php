<?php

/**
 * Description of Formulas
 *
 * @author André Castro
 */
class Formulas {

    //Variável de configuração da Fonte de Dados do perfil
    static public $fontePerfil = "Fonte: Pnud, Ipea e FJP"; //@#Menos template 5

    static public function getLabelAno2010($idhm) {
        return $idhm[2]["label_ano_referencia"];
    }

    static public function getIDH2010($idhm) {
        return number_format($idhm[2]["valor"], 3, ",", ".");
    }

    static public function getIDH2000($idhm) {
        return number_format($idhm[1]["valor"], 3, ",", ".");
    }

    static public function getIDH1991($idhm) {
        return number_format($idhm[0]["valor"], 3, ",", ".");
    }

    static public function getSituacaoIDH($idhm, $lang) {

        if ($lang == "pt") {
            if ($idhm[2]["valor"] >= 0.000 && $idhm[2]["valor"] <= 0.499)
                return "Muito Baixo (IDHM entre 0 e 0,499)";
            else if ($idhm[2]["valor"] >= 0.500 && $idhm[2]["valor"] <= 0.599)
                return "Baixo (IDHM entre 0,500 e 0,599)";
            else if ($idhm[2]["valor"] >= 0.600 && $idhm[2]["valor"] <= 0.699)
                return "Médio (IDHM entre 0,600 e 0,699)";
            else if ($idhm[2]["valor"] >= 0.700 && $idhm[2]["valor"] <= 0.799)
                return "Alto (IDHM entre 0,700 e 0,799)";
            else if ($idhm[2]["valor"] >= 0.800 && $idhm[2]["valor"] <= 1.000)
                return "Muito Alto (IDHM entre 0,800 e 1)";
        }
        else if ($lang == "en") {
            if ($idhm[2]["valor"] >= 0.000 && $idhm[2]["valor"] <= 0.499)
                return "Very Low (MHDI between 0 and 0,499)";
            else if ($idhm[2]["valor"] >= 0.500 && $idhm[2]["valor"] <= 0.599)
                return "Low (MHDI between 0,500 and 0,599)";
            else if ($idhm[2]["valor"] >= 0.600 && $idhm[2]["valor"] <= 0.699)
                return "Medium (MHDI between 0,600 and 0,699)";
            else if ($idhm[2]["valor"] >= 0.700 && $idhm[2]["valor"] <= 0.799)
                return "High (MHDI between 0,700 and 0,799)";
            else if ($idhm[2]["valor"] >= 0.800 && $idhm[2]["valor"] <= 1.000)
                return "Very High (MHDI between 0,800 and 1)";
        }
        else if ($lang == "es") {
            if ($idhm[2]["valor"] >= 0.000 && $idhm[2]["valor"] <= 0.499)
                return "Muy Bajo (IDHM entre 0 y 0,499)";
            else if ($idhm[2]["valor"] >= 0.500 && $idhm[2]["valor"] <= 0.599)
                return "Bajo (IDHM entre 0,500 y 0,599)";
            else if ($idhm[2]["valor"] >= 0.600 && $idhm[2]["valor"] <= 0.699)
                return "Promedio (IDHM entre 0,600 y 0,699)";
            else if ($idhm[2]["valor"] >= 0.700 && $idhm[2]["valor"] <= 0.799)
                return "Alto (IDHM entre 0,700 y 0,799)";
            else if ($idhm[2]["valor"] >= 0.800 && $idhm[2]["valor"] <= 1.000)
                return "Muy Alto (IDHM entre 0,800 y 1)";
        }
    }

    static public function getDimensao($lang, $idhm_r, $idhm_l, $idhm_e, $confDimensao) {

        if ($lang == "pt") {

            if ($confDimensao["faixa0010"]) {//2010 - 2000
                $idhm_r0010 = array("valor" => number_format(($idhm_r[2]["valor"] - $idhm_r[1]["valor"]), 3, ",", "."), "dimensao" => "Renda");
                $idhm_l0010 = array("valor" => number_format(($idhm_l[2]["valor"] - $idhm_l[1]["valor"]), 3, ",", "."), "dimensao" => "Longevidade");
                $idhm_e0010 = array("valor" => number_format(($idhm_e[2]["valor"] - $idhm_e[1]["valor"]), 3, ",", "."), "dimensao" => "Educação");
            } else if ($confDimensao["faixa9100"]) {//1991 - 2000        
                $idhm_r0010 = array("valor" => number_format(($idhm_r[1]["valor"] - $idhm_r[0]["valor"]), 3, ",", "."), "dimensao" => "Renda");
                $idhm_l0010 = array("valor" => number_format(($idhm_l[1]["valor"] - $idhm_l[0]["valor"]), 3, ",", "."), "dimensao" => "Longevidade");
                $idhm_e0010 = array("valor" => number_format(($idhm_e[1]["valor"] - $idhm_e[0]["valor"]), 3, ",", "."), "dimensao" => "Educação");
            } else if ($confDimensao["faixa9110"]) {//1991 - 2010        
                $idhm_r0010 = array("valor" => number_format(($idhm_r[2]["valor"] - $idhm_r[0]["valor"]), 3, ",", "."), "dimensao" => "Renda");
                $idhm_l0010 = array("valor" => number_format(($idhm_l[2]["valor"] - $idhm_l[0]["valor"]), 3, ",", "."), "dimensao" => "Longevidade");
                $idhm_e0010 = array("valor" => number_format(($idhm_e[2]["valor"] - $idhm_e[0]["valor"]), 3, ",", "."), "dimensao" => "Educação");
            }

            $max = max($idhm_r0010, $idhm_l0010, $idhm_e0010);
            $min = min($idhm_r0010, $idhm_l0010, $idhm_e0010);

            if ($max["dimensao"] === "Renda") {
                if ($min["dimensao"] === "Educação") {
                    return $max["dimensao"] . " (com crescimento de " . $max["valor"] . ")" . ", seguida por Longevidade e por " . $min["dimensao"];
                } else if ($min["dimensao"] === "Longevidade") {
                    return $max["dimensao"] . " (com crescimento de " . $max["valor"] . ")" . ", seguida por Educação e por " . $min["dimensao"];
                }
            } else if ($max["dimensao"] === "Educação") {
                if ($min["dimensao"] === "Renda") {
                    return $max["dimensao"] . " (com crescimento de " . $max["valor"] . ")" . ", seguida por Longevidade e por " . $min["dimensao"];
                } else if ($min["dimensao"] === "Longevidade") {
                    return $max["dimensao"] . " (com crescimento de " . $max["valor"] . ")" . ", seguida por Renda e por " . $min["dimensao"];
                }
            } else if ($max["dimensao"] === "Longevidade") {
                if ($min["dimensao"] === "Educação") {
                    return $max["dimensao"] . " (com crescimento de " . $max["valor"] . ")" . ", seguida por Renda e por " . $min["dimensao"];
                } else if ($min["dimensao"] === "Renda") {
                    return $max["dimensao"] . " (com crescimento de " . $max["valor"] . ")" . ", seguida por Educação e por " . $min["dimensao"];
                }
            }
        } else if ($lang == "en") {

            if ($confDimensao["faixa0010"]) {//2010 - 2000
                $idhm_r0010 = array("valor" => number_format(($idhm_r[2]["valor"] - $idhm_r[1]["valor"]), 3, ",", "."), "dimensao" => "Income");
                $idhm_l0010 = array("valor" => number_format(($idhm_l[2]["valor"] - $idhm_l[1]["valor"]), 3, ",", "."), "dimensao" => "Longevity");
                $idhm_e0010 = array("valor" => number_format(($idhm_e[2]["valor"] - $idhm_e[1]["valor"]), 3, ",", "."), "dimensao" => "Education");
            } else if ($confDimensao["faixa9100"]) {//1991 - 2000        
                $idhm_r0010 = array("valor" => number_format(($idhm_r[1]["valor"] - $idhm_r[0]["valor"]), 3, ",", "."), "dimensao" => "Income");
                $idhm_l0010 = array("valor" => number_format(($idhm_l[1]["valor"] - $idhm_l[0]["valor"]), 3, ",", "."), "dimensao" => "Longevity");
                $idhm_e0010 = array("valor" => number_format(($idhm_e[1]["valor"] - $idhm_e[0]["valor"]), 3, ",", "."), "dimensao" => "Education");
            }

            $max = max($idhm_r0010, $idhm_l0010, $idhm_e0010);
            $min = min($idhm_r0010, $idhm_l0010, $idhm_e0010);

            if ($max["dimensao"] === "Income") {
                if ($min["dimensao"] === "Education") {
                    return $max["dimensao"] . " (increase of " . $max["valor"] . ")" . ", followed by Longevity and " . $min["dimensao"];
                } else if ($min["dimensao"] === "Longevity") {
                    return $max["dimensao"] . " (increase of " . $max["valor"] . ")" . ", followed by Education and " . $min["dimensao"];
                }
            } else if ($max["dimensao"] === "Education") {
                if ($min["dimensao"] === "Income") {
                    return $max["dimensao"] . " (increase of " . $max["valor"] . ")" . ", followed by Longevity and " . $min["dimensao"];
                } else if ($min["dimensao"] === "Longevity") {
                    return $max["dimensao"] . " (increase of " . $max["valor"] . ")" . ", followed by Income and " . $min["dimensao"];
                }
            } else if ($max["dimensao"] === "Longevity") {
                if ($min["dimensao"] === "Education") {
                    return $max["dimensao"] . " (increase of " . $max["valor"] . ")" . ", followed by Income and " . $min["dimensao"];
                } else if ($min["dimensao"] === "Income") {
                    return $max["dimensao"] . " (increase of " . $max["valor"] . ")" . ", followed by Education and " . $min["dimensao"];
                }
            }
        } else if ($lang == "es") {

            if ($confDimensao["faixa0010"]) {//2010 - 2000
                $idhm_r0010 = array("valor" => number_format(($idhm_r[2]["valor"] - $idhm_r[1]["valor"]), 3, ",", "."), "dimensao" => "Ingresos");
                $idhm_l0010 = array("valor" => number_format(($idhm_l[2]["valor"] - $idhm_l[1]["valor"]), 3, ",", "."), "dimensao" => "Longevidad");
                $idhm_e0010 = array("valor" => number_format(($idhm_e[2]["valor"] - $idhm_e[1]["valor"]), 3, ",", "."), "dimensao" => "Educación");
            } else if ($confDimensao["faixa9100"]) {//1991 - 2000        
                $idhm_r0010 = array("valor" => number_format(($idhm_r[1]["valor"] - $idhm_r[0]["valor"]), 3, ",", "."), "dimensao" => "Ingresos");
                $idhm_l0010 = array("valor" => number_format(($idhm_l[1]["valor"] - $idhm_l[0]["valor"]), 3, ",", "."), "dimensao" => "Longevidad");
                $idhm_e0010 = array("valor" => number_format(($idhm_e[1]["valor"] - $idhm_e[0]["valor"]), 3, ",", "."), "dimensao" => "Educación");
            }

            $max = max($idhm_r0010, $idhm_l0010, $idhm_e0010);
            $min = min($idhm_r0010, $idhm_l0010, $idhm_e0010);

            if ($max["dimensao"] === "Ingresos") {
                if ($min["dimensao"] === "Educación") {
                    return $max["dimensao"] . " (con un crecimiento de " . $max["valor"] . ")" . ", seguida de Longevidad y " . $min["dimensao"];
                } else if ($min["dimensao"] === "Longevidad") {
                    return $max["dimensao"] . " (con un crecimiento de " . $max["valor"] . ")" . ", seguida de Educación y " . $min["dimensao"];
                }
            } else if ($max["dimensao"] === "Educación") {
                if ($min["dimensao"] === "Ingresos") {
                    return $max["dimensao"] . " (con un crecimiento de " . $max["valor"] . ")" . ", seguida de Longevidad y " . $min["dimensao"];
                } else if ($min["dimensao"] === "Longevidad") {
                    return $max["dimensao"] . " (con un crecimiento de " . $max["valor"] . ")" . ", seguida de Ingresos y " . $min["dimensao"];
                }
            } else if ($max["dimensao"] === "Longevidad") {
                if ($min["dimensao"] === "Educación") {
                    return $max["dimensao"] . " (con un crecimiento de " . $max["valor"] . ")" . ", seguida de Ingresos y " . $min["dimensao"];
                } else if ($min["dimensao"] === "Ingresos") {
                    return $max["dimensao"] . " (con un crecimiento de " . $max["valor"] . ")" . ", seguida de Educación y " . $min["dimensao"];
                }
            }
        }
    }

    static public function getDimensao2010($lang, $idhm_r, $idhm_l, $idhm_e) {

        if ($lang == "pt") {

            $idhm_r0010 = array("valor" => number_format($idhm_r[2]["valor"], 3, ",", "."), "dimensao" => "Renda");
            $idhm_l0010 = array("valor" => number_format($idhm_l[2]["valor"], 3, ",", "."), "dimensao" => "Longevidade");
            $idhm_e0010 = array("valor" => number_format($idhm_e[2]["valor"], 3, ",", "."), "dimensao" => "Educação");

            $max = max($idhm_r0010, $idhm_l0010, $idhm_e0010);
            $min = min($idhm_r0010, $idhm_l0010, $idhm_e0010);

            if ($max["dimensao"] === "Renda") {
                if ($min["dimensao"] === "Educação") {
                    $media = $idhm_l0010;
                    return $max["dimensao"] . ", com índice de " . $max["valor"] . ", seguida de " . $media["dimensao"] .
                            ", com índice de " . $media["valor"] . ", e de " . $min["dimensao"] . ", com índice de " . $min["valor"];
                } else if ($min["dimensao"] === "Longevidade") {
                    $media = $idhm_e0010;
                    return $max["dimensao"] . ", com índice de " . $max["valor"] . ", seguida de " . $media["dimensao"] .
                            ", com índice de " . $media["valor"] . ", e de " . $min["dimensao"] . ", com índice de " . $min["valor"];
                }
            } else if ($max["dimensao"] === "Educação") {
                if ($min["dimensao"] === "Renda") {
                    $media = $idhm_l0010;
                    return $max["dimensao"] . ", com índice de " . $max["valor"] . ", seguida de " . $media["dimensao"] .
                            ", com índice de " . $media["valor"] . ", e de " . $min["dimensao"] . ", com índice de " . $min["valor"];
                } else if ($min["dimensao"] === "Longevidade") {
                    $media = $idhm_r0010;
                    return $max["dimensao"] . ", com índice de " . $max["valor"] . ", seguida de " . $media["dimensao"] .
                            ", com índice de " . $media["valor"] . ", e de " . $min["dimensao"] . ", com índice de " . $min["valor"];
                }
            } else if ($max["dimensao"] === "Longevidade") {
                if ($min["dimensao"] === "Educação") {
                    $media = $idhm_r0010;
                    return $max["dimensao"] . ", com índice de " . $max["valor"] . ", seguida de " . $media["dimensao"] .
                            ", com índice de " . $media["valor"] . ", e de " . $min["dimensao"] . ", com índice de " . $min["valor"];
                } else if ($min["dimensao"] === "Renda") {
                    $media = $idhm_e0010;
                    return $max["dimensao"] . ", com índice de " . $max["valor"] . ", seguida de " . $media["dimensao"] .
                            ", com índice de " . $media["valor"] . ", e de " . $min["dimensao"] . ", com índice de " . $min["valor"];
                }
            }
        }
//        else if($lang == "en"){
//            
//            if ($confDimensao["faixa0010"]) {//2010 - 2000
//                $idhm_r0010 = array("valor" => number_format(($idhm_r[2]["valor"] - $idhm_r[1]["valor"]), 3, ",", "."), "dimensao" => "Income");
//                $idhm_l0010 = array("valor" => number_format(($idhm_l[2]["valor"] - $idhm_l[1]["valor"]), 3, ",", "."), "dimensao" => "Longevity");
//                $idhm_e0010 = array("valor" => number_format(($idhm_e[2]["valor"] - $idhm_e[1]["valor"]), 3, ",", "."), "dimensao" => "Education");
//            } else if ($confDimensao["faixa9100"]) {//1991 - 2000        
//                $idhm_r0010 = array("valor" => number_format(($idhm_r[1]["valor"] - $idhm_r[0]["valor"]), 3, ",", "."), "dimensao" => "Income");
//                $idhm_l0010 = array("valor" => number_format(($idhm_l[1]["valor"] - $idhm_l[0]["valor"]), 3, ",", "."), "dimensao" => "Longevity");
//                $idhm_e0010 = array("valor" => number_format(($idhm_e[1]["valor"] - $idhm_e[0]["valor"]), 3, ",", "."), "dimensao" => "Education");
//            }
//  
//        $max = max($idhm_r0010, $idhm_l0010, $idhm_e0010);        
//        $min = min($idhm_r0010, $idhm_l0010, $idhm_e0010);
//        
//            if ($max["dimensao"] === "Income"){
//                if ($min["dimensao"] === "Education"){
//                    return $max["dimensao"] . " (increase of " . $max["valor"] . ")" . ", followed by Longevity and " . $min["dimensao"];
//                }else if ($min["dimensao"] === "Longevity"){
//                    return $max["dimensao"] . " (increase of " . $max["valor"] . ")" . ", followed by Education and " . $min["dimensao"];
//                }
//            }                
//            else if ($max["dimensao"] === "Education"){
//                if ($min["dimensao"] === "Income"){
//                    return $max["dimensao"] . " (increase of " . $max["valor"] . ")" . ", followed by Longevity and " . $min["dimensao"];
//                }else if ($min["dimensao"] === "Longevity"){
//                    return $max["dimensao"] . " (increase of " . $max["valor"] . ")" . ", followed by Income and " . $min["dimensao"];
//                }
//            }
//            else if ($max["dimensao"] === "Longevity"){
//                if ($min["dimensao"] === "Education"){
//                    return $max["dimensao"] . " (increase of " . $max["valor"] . ")" . ", followed by Income and " . $min["dimensao"];
//                }else if ($min["dimensao"] === "Income"){
//                    return $max["dimensao"] . " (increase of " . $max["valor"] . ")" . ", followed by Education and " . $min["dimensao"];
//                }
//            }
//        }
//        else if($lang == "es"){
//            
//            if ($confDimensao["faixa0010"]) {//2010 - 2000
//                $idhm_r0010 = array("valor" => number_format(($idhm_r[2]["valor"] - $idhm_r[1]["valor"]), 3, ",", "."), "dimensao" => "Ingresos");
//                $idhm_l0010 = array("valor" => number_format(($idhm_l[2]["valor"] - $idhm_l[1]["valor"]), 3, ",", "."), "dimensao" => "Longevidad");
//                $idhm_e0010 = array("valor" => number_format(($idhm_e[2]["valor"] - $idhm_e[1]["valor"]), 3, ",", "."), "dimensao" => "Educación");
//            } else if ($confDimensao["faixa9100"]) {//1991 - 2000        
//                $idhm_r0010 = array("valor" => number_format(($idhm_r[1]["valor"] - $idhm_r[0]["valor"]), 3, ",", "."), "dimensao" => "Ingresos");
//                $idhm_l0010 = array("valor" => number_format(($idhm_l[1]["valor"] - $idhm_l[0]["valor"]), 3, ",", "."), "dimensao" => "Longevidad");
//                $idhm_e0010 = array("valor" => number_format(($idhm_e[1]["valor"] - $idhm_e[0]["valor"]), 3, ",", "."), "dimensao" => "Educación");
//            }
//  
//        $max = max($idhm_r0010, $idhm_l0010, $idhm_e0010);        
//        $min = min($idhm_r0010, $idhm_l0010, $idhm_e0010);
//        
//            if ($max["dimensao"] === "Ingresos"){
//                if ($min["dimensao"] === "Educación"){
//                    return $max["dimensao"] . " (con un crecimiento de " . $max["valor"] . ")" . ", seguida de Longevidad y " . $min["dimensao"];
//                }else if ($min["dimensao"] === "Longevidad"){
//                    return $max["dimensao"] . " (con un crecimiento de " . $max["valor"] . ")" . ", seguida de Educación y " . $min["dimensao"];
//                }
//            }                
//            else if ($max["dimensao"] === "Educación"){
//                if ($min["dimensao"] === "Ingresos"){
//                    return $max["dimensao"] . " (con un crecimiento de " . $max["valor"] . ")" . ", seguida de Longevidad y " . $min["dimensao"];
//                }else if ($min["dimensao"] === "Longevidad"){
//                    return $max["dimensao"] . " (con un crecimiento de " . $max["valor"] . ")" . ", seguida de Ingresos y " . $min["dimensao"];
//                }
//            }
//            else if ($max["dimensao"] === "Longevidad"){
//                if ($min["dimensao"] === "Educación"){
//                    return $max["dimensao"] . " (con un crecimiento de " . $max["valor"] . ")" . ", seguida de Ingresos y " . $min["dimensao"];
//                }else if ($min["dimensao"] === "Ingresos"){
//                    return $max["dimensao"] . " (con un crecimiento de " . $max["valor"] . ")" . ", seguida de Educación y " . $min["dimensao"];
//                }
//            }
//        }
    }

    static public function getTaxaCrescimento0010($idhm) {
        return number_format((($idhm[2]["valor"] / $idhm[1]["valor"]) - 1) * 100, 2, ",", ".");
    }

    static public function getTaxaCrescimento9100($idhm) {
        return number_format((($idhm[1]["valor"] / $idhm[0]["valor"]) - 1) * 100, 2, ",", ".");
    }

    static public function getTaxaCrescimento9110($idhm) {
        return number_format((($idhm[2]["valor"] / $idhm[0]["valor"]) - 1) * 100, 2, ",", ".");
    }

    static public function getTaxaCrescimento9110BRASIL($idhm_brasil) {
        return number_format((($idhm_brasil[2]["valor"] / $idhm_brasil[0]["valor"]) - 1) * 100, 2, ",", ".");
    }

    static public function getTaxaCrescimento0010BRASIL($idhm_brasil) {
        return number_format((($idhm_brasil[2]["valor"] / $idhm_brasil[1]["valor"]) - 1) * 100, 2, ",", ".");
    }

    static public function getTaxaCrescimento9110UfRm($idhm_uf) {
        return number_format((($idhm_uf[2]["valor"] / $idhm_uf[0]["valor"]) - 1) * 100, 2, ",", ".");
    }

//    static public function getReducaoHiato0010($idhm) {
//        $reducao_hiato_0010 = (($idhm[2]["valor"] - $idhm[1]["valor"]) / (1 - $idhm[1]["valor"])) * 100;
//        return number_format($reducao_hiato_0010, 2, ",", ".");
//    }

    static public function getReducaoHiato0010($idhm) {
        //<(((1-IDHM 2010)/(1-IDHM 2000))-1)*100 * -1>%
        $reducao_hiato_0010 = (( ( ( (1 - $idhm[2]["valor"]) / (1 - $idhm[1]["valor"]) ) * (-1) ) * 100) * (-1) );
        return number_format($reducao_hiato_0010, 2, ",", ".");
    }

//    static public function getReducaoHiato9100($idhm) {
//        $reducao_hiato_9100 = (($idhm[1]["valor"] - $idhm[0]["valor"]) / (1 - $idhm[0]["valor"])) * 100;
//        return number_format($reducao_hiato_9100, 2, ",", ".");
//    }

    static public function getReducaoHiato9100($idhm) {
        //<(((1-IDHM 2010)/(1-IDHM 2000))-1)*100 * -1>%
        $reducao_hiato_0010 = (( ( ( (1 - $idhm[1]["valor"]) / (1 - $idhm[0]["valor"]) ) * (-1) ) * 100) * (-1) );
        return number_format($reducao_hiato_0010, 2, ",", ".");
    }

//    static public function getReducaoHiato9110($idhm) {
//        $reducao_hiato_9110 = (($idhm[2]["valor"] - $idhm[0]["valor"]) / (1 - $idhm[0]["valor"])) * 100;
//        return number_format($reducao_hiato_9110, 2, ",", ".");
//    }

    static public function getReducaoHiato9110($idhm) {
        //<(((1-IDHM 2010)/(1-IDHM 2000))-1)*100 * -1>%
        $reducao_hiato_0010 = (( ( ( (1 - $idhm[2]["valor"]) / (1 - $idhm[0]["valor"]) ) * (-1) ) * 100) * (-1) );
        return number_format($reducao_hiato_0010, 2, ",", ".");
    }

//    static public function getReducaoHiato0010puro($idhm) {
//        $reducao_hiato_0010 = (($idhm[2]["valor"] - $idhm[1]["valor"]) / (1 - $idhm[1]["valor"])) * 100;
//        return $reducao_hiato_0010;
//    }

    static public function getReducaoHiato0010puro($idhm) {

        $reducao_hiato_0010 = (( ( ( (1 - $idhm[2]["valor"]) / (1 - $idhm[1]["valor"]) ) * (-1) ) * 100) * (-1) );
        return $reducao_hiato_0010;
    }

//    static public function getReducaoHiato9100puro($idhm) {
//        $reducao_hiato_9100 = (($idhm[1]["valor"] - $idhm[0]["valor"]) / (1 - $idhm[0]["valor"])) * 100;
//        return $reducao_hiato_9100;
//    }

    static public function getReducaoHiato9100puro($idhm) {
        $reducao_hiato_9100 = (( ( ( (1 - $idhm[1]["valor"]) / (1 - $idhm[0]["valor"]) ) * (-1) ) * 100) * (-1) );
        return $reducao_hiato_9100;
    }

//    static public function getReducaoHiato9110puro($idhm) {
//        $reducao_hiato_9110 = (($idhm[2]["valor"] - $idhm[0]["valor"]) / (1 - $idhm[0]["valor"])) * 100;
//        return $reducao_hiato_9110;
//    }

    static public function getReducaoHiato9110puro($idhm) {
        $reducao_hiato_9110 = (( ( ( (1 - $idhm[2]["valor"]) / (1 - $idhm[0]["valor"]) ) * (-1) ) * 100) * (-1) );
        return $reducao_hiato_9110;
    }

    static public function getTaxa9100($idhm) {
        return number_format((($idhm[1]["valor"] / $idhm[0]["valor"]) - 1) * 100, 2, ",", ".");
    }

    static public function getTaxa0010($idhm) {
        return number_format((($idhm[2]["valor"] / $idhm[1]["valor"]) - 1) * 100, 2, ",", ".");
    }

    static public function getTaxa9110($idhm) {
        return number_format((($idhm[2]["valor"] / $idhm[0]["valor"]) - 1) * 100, 2, ",", ".");
    }

    static public function getTaxaCrescimentoPop0010($pesotot) {
        return number_format((pow(($pesotot[2]["valor"] / $pesotot[1]["valor"]), 1 / 10) - 1) * 100, 2, ",", ".");
    }

    static public function getTaxaCrescimentoPop9100($pesotot) {
        return number_format((pow(($pesotot[1]["valor"] / $pesotot[0]["valor"]), 1 / 9) - 1) * 100, 2, ",", ".");
    }

    static public function getTaxaCrescimentoPop0010ESTADO($pesotot_uf) {
        return number_format((pow(($pesotot_uf[2]["valor"] / $pesotot_uf[1]["valor"]), 1 / 10) - 1) * 100, 2, ",", ".");
        //return number_format(pow(($pesotot_uf[2]["valor"] / $pesotot_uf[1]["valor"]), 1 / 10), 2, ",", ".");
    }

    static public function getTaxaCrescimentoPop9100ESTADO($pesotot_uf) {
        return number_format((pow(($pesotot_uf[1]["valor"] / $pesotot_uf[0]["valor"]), 1 / 9) - 1) * 100, 2, ",", ".");
        //return number_format(pow(($pesotot_uf[1]["valor"] / $pesotot_uf[0]["valor"]), 1 / 9), 2, ",", ".");
    }

    static public function getTaxaCrescimentoPop0010BRASIL($pesotot_brasil) {
        return number_format((pow(($pesotot_brasil[2]["valor"] / $pesotot_brasil[1]["valor"]), 1 / 10) - 1) * 100, 2, ",", ".");
        //return number_format(pow(($pesotot_brasil[2]["valor"] / $pesotot_brasil[1]["valor"]), 1 / 10), 2, ",", ".");
    }

    static public function getTaxaCrescimentoPop9100BRASIL($pesotot_brasil) {
        return number_format((pow(($pesotot_brasil[1]["valor"] / $pesotot_brasil[0]["valor"]), 1 / 9) - 1) * 100, 2, ",", ".");
        //return number_format(pow(($pesotot_brasil[1]["valor"] / $pesotot_brasil[0]["valor"]), 1 / 9), 2, ",", ".");
    }

    static public function getTaxaUrbanizacao($pesourb, $pesotot) {
        return number_format(( ((($pesourb[2]["valor"] / $pesotot[2]["valor"]) * 100) - (($pesourb[0]["valor"] / $pesotot[0]["valor"]) * 100)) / (($pesourb[0]["valor"] / $pesotot[0]["valor"]) * 100) ) * 100, 2, ",", ".");
    }

    static public function getTaxaUrbanizacao91($pesourb, $pesotot) {
        return number_format(($pesourb[0]["valor"] / $pesotot[0]["valor"]) * 100, 2, ",", ".");
    }

    static public function getTaxaUrbanizacao00($pesourb, $pesotot) {
        return number_format(($pesourb[1]["valor"] / $pesotot[1]["valor"]) * 100, 2, ",", ".");
    }

    static public function getTaxaUrbanizacao10($pesourb, $pesotot) {
        return number_format(($pesourb[2]["valor"] / $pesotot[2]["valor"]) * 100, 2, ",", ".");
    }

    static public function getTaxaUrbanizacao00BRASIL($pesourb_br, $pesotot_br) {
        return number_format(($pesourb_br[1]["valor"] / $pesotot_br[1]["valor"]) * 100, 2, ",", ".");
    }

    static public function getTaxaUrbanizacao10BRASIL($pesourb_br, $pesotot_br) {
        return number_format(($pesourb_br[2]["valor"] / $pesotot_br[2]["valor"]) * 100, 2, ",", ".");
    }

    static public function getIndiceEnvelhecimento91($tenv) {
        return number_format($tenv[0]["valor"], 2, ",", ".");
    }

    static public function getIndiceEnvelhecimento00($tenv) {
        return number_format($tenv[1]["valor"], 2, ",", ".");
    }

    static public function getIndiceEnvelhecimento10($tenv) {
        return number_format($tenv[2]["valor"], 2, ",", ".");
    }

    static public function getRazaoDependencia91($rd) {
        return number_format($rd[0]["valor"], 2, ",", ".");
    }

    static public function getRazaoDependencia00($rd) {
        return number_format($rd[1]["valor"], 2, ",", ".");
    }

    static public function getRazaoDependencia10($rd) {
        return number_format($rd[2]["valor"], 2, ",", ".");
    }

    static public function getReducaoMortalidadeInfantil0010($mort1) {
        return abs(number_format((($mort1[1]["valor"] - $mort1[2]["valor"]) / $mort1[1]["valor"]) * 100, 2, ",", "."));
    }

    static public function getMortalidadeInfantil00($mort1) {
        return number_format($mort1[1]["valor"], 1, ",", ".");
    }

    static public function getMortalidadeInfantil10($mort1) {
        return number_format($mort1[2]["valor"], 1, ",", ".");
    }

    static public function getMortalidadeInfantil91($mort1) {
        return number_format($mort1[0]["valor"], 1, ",", ".");
    }

    static public function getMortalidadeInfantil00puro($mort1) {
        return $mort1[1]["valor"];
    }

    static public function getMortalidadeInfantil10puro($mort1) {
        return $mort1[2]["valor"];
    }

    static public function getMortalidadeInfantil91ESTADO($mort1_uf) {
        return number_format($mort1_uf[0]["valor"], 1, ",", ".");
    }

    static public function getMortalidadeInfantil00ESTADO($mort1_uf) {
        return number_format($mort1_uf[1]["valor"], 1, ",", ".");
    }

    static public function getMortalidadeInfantil10ESTADO($mort1_uf) {
        return number_format($mort1_uf[2]["valor"], 1, ",", ".");
    }

    static public function getMortalidadeInfantil10BRASIL($mort1_brasil) {
        return number_format($mort1_brasil[2]["valor"], 1, ",", ".");
    }

    static public function getMortalidadeInfantil00BRASIL($mort1_brasil) {
        return number_format($mort1_brasil[1]["valor"], 1, ",", ".");
    }

    static public function getMortalidadeInfantil91BRASIL($mort1_brasil) {
        return number_format($mort1_brasil[0]["valor"], 1, ",", ".");
    }

    static public function getAumentoEsperancaVidaNascer0010($espvida) {
        return number_format($espvida[2]["valor"] - $espvida[1]["valor"], 1, ",", ".");
    }

    static public function getEsperancaVidaNascer91($espvida) {
        return number_format($espvida[0]["valor"], 1, ",", ".");
    }

    static public function getEsperancaVidaNascer00($espvida) {
        return number_format($espvida[1]["valor"], 1, ",", ".");
    }

    static public function getEsperancaVidaNascer10($espvida) {
        return number_format($espvida[2]["valor"], 1, ",", ".");
    }

    static public function getEsperancaVidaNascer10ESTADO($espvida_uf) {
        return number_format($espvida_uf[2]["valor"], 1, ",", ".");
    }

    static public function getEsperancaVidaNascer10BRASIL($espvida_brasil) {
        return number_format($espvida_brasil[2]["valor"], 1, ",", ".");
    }

    static public function getEsperancaVidaNascer00BRASIL($espvida_brasil) {
        return number_format($espvida_brasil[1]["valor"], 1, ",", ".");
    }

    static public function getEsperancaVidaNascer91BRASIL($espvida_brasil) {
        return number_format($espvida_brasil[0]["valor"], 1, ",", ".");
    }

    // - INICIO - Funções de generateEDUCACAO_nivel_educacional ---------------------------------------------------------------
//    static public function getCrescimento4a6Esc0010($t_freq4a6) {
//        return number_format((($t_freq4a6[2]["valor"] - $t_freq4a6[1]["valor"]) / $t_freq4a6[1]["valor"]) * 100, 2, ",", ".");
//    }
//    
//    static public function getCrescimento4a6Esc9100($t_freq4a6) {
//        return number_format((($t_freq4a6[1]["valor"] - $t_freq4a6[0]["valor"]) / $t_freq4a6[0]["valor"]) * 100, 2, ",", ".");
//    }

    static public function get5a6Esc10($t_freq5a6) {
        return number_format($t_freq5a6[2]["valor"], 2, ",", ".");
    }

    static public function getCrescimento5a6Esc9110($t_freq5a6) {
        return number_format(($t_freq5a6[2]["valor"] - $t_freq5a6[0]["valor"]), 2, ",", ".");
    }

    static public function getCrescimento5a6Esc0010($t_freq5a6) {
        return number_format(($t_freq5a6[2]["valor"] - $t_freq5a6[1]["valor"]), 2, ",", ".");
    }

//    static public function getCrescimento11a13Esc0010($t_fund12a14) {
//        return number_format((($t_fund12a14[2]["valor"] - $t_fund12a14[1]["valor"]) / $t_fund12a14[1]["valor"]) * 100, 2, ",", ".");
//    }
//    
//    static public function getCrescimento11a13Esc9100($t_fund12a14) {
//        return number_format((($t_fund12a14[1]["valor"] - $t_fund12a14[0]["valor"]) / $t_fund12a14[0]["valor"]) * 100, 2, ",", ".");
//    }

    static public function get11a13Esc10($t_fund11a13) {
        return number_format($t_fund11a13[2]["valor"], 2, ",", ".");
    }

    static public function getCrescimento11a13Esc9110($t_fund11a13) {
        return number_format(($t_fund11a13[2]["valor"] - $t_fund11a13[0]["valor"]), 2, ",", ".");
    }

    static public function getCrescimento11a13Esc0010($t_fund11a13) {
        return number_format(($t_fund11a13[2]["valor"] - $t_fund11a13[1]["valor"]), 2, ",", ".");
    }

//    static public function getCrescimento16a18Fund0010($t_fund16a18) {
//        return number_format((($t_fund16a18[2]["valor"] - $t_fund16a18[1]["valor"]) / $t_fund16a18[1]["valor"]) * 100, 2, ",", ".");
//    }
//    
//    static public function getCrescimento16a18Fund9100($t_fund16a18) {
//        return number_format((($t_fund16a18[1]["valor"] - $t_fund16a18[0]["valor"]) / $t_fund16a18[0]["valor"]) * 100, 2, ",", ".");
//    }

    static public function get15a17Fund10($t_fund15a17) {
        return number_format($t_fund15a17[2]["valor"], 2, ",", ".");
    }

    static public function getCrescimento15a17Fund9110($t_fund15a17) {
        return number_format(($t_fund15a17[2]["valor"] - $t_fund15a17[0]["valor"]), 2, ",", ".");
    }

    static public function getCrescimento15a17Fund0010($t_fund15a17) {
        return number_format(($t_fund15a17[2]["valor"] - $t_fund15a17[1]["valor"]), 2, ",", ".");
    }

//    static public function getCrescimento19a21Medio0010($t_med19a21) {
//        return number_format((($t_med19a21[2]["valor"] - $t_med19a21[1]["valor"]) / $t_med19a21[1]["valor"]) * 100, 2, ",", ".");
//    }
//    
//    static public function getCrescimento19a21Medio9100($t_med19a21) {
//        return number_format((($t_med19a21[1]["valor"] - $t_med19a21[0]["valor"]) / $t_med19a21[0]["valor"]) * 100, 2, ",", ".");
//    }

    static public function get18a20Medio10($t_med18a20) {
        return number_format($t_med18a20[2]["valor"], 2, ",", ".");
    }

    static public function getCrescimento18a20Medio9110($t_med18a20) {
        return number_format(($t_med18a20[2]["valor"] - $t_med18a20[0]["valor"]), 2, ",", ".");
    }

    static public function getCrescimento18a20Medio0010($t_med18a20) {
        return number_format(($t_med18a20[2]["valor"] - $t_med18a20[1]["valor"]), 2, ",", ".");
    }

    // - FIM - Funções de generateEDUCACAO_nivel_educacional ---------------------------------------------------------------



    static public function getTxFundSemAtraso91($t_atraso_0_fund, $t_flfund) {
        return number_format(($t_atraso_0_fund[0]["valor"] * $t_flfund[0]["valor"]) / 100, 2, ",", ".");
    }

    static public function getTxFundSemAtraso00($t_atraso_0_fund, $t_flfund) {
        return number_format(($t_atraso_0_fund[1]["valor"] * $t_flfund[1]["valor"]) / 100, 2, ",", ".");
    }

    static public function getTxFundSemAtraso10($t_atraso_0_fund, $t_flfund) {
        return number_format(($t_atraso_0_fund[2]["valor"] * $t_flfund[2]["valor"]) / 100, 2, ",", ".");
    }

    static public function getTxBasSemAtraso91($t_atraso_2_bas, $t_flbas) {
        return number_format(100 - ($t_atraso_2_bas[0]["valor"] * $t_flbas[0]["valor"]) / 100, 2, ",", ".");
        ;
    }

    static public function getTxBasSemAtraso00($t_atraso_2_bas, $t_flbas) {
        return number_format(100 - ($t_atraso_2_bas[1]["valor"] * $t_flbas[1]["valor"]) / 100, 2, ",", ".");
    }

    static public function getTxBasSemAtraso10($t_atraso_2_bas, $t_flbas) {
        return number_format(100 - ($t_atraso_2_bas[2]["valor"] * $t_flbas[2]["valor"]) / 100, 2, ",", ".");
    }

    static public function getTxMedioSemAtraso91($t_atraso_0_med, $t_flmed) {
        return number_format(($t_atraso_0_med[0]["valor"] * $t_flmed[0]["valor"]) / 100, 2, ",", ".");
    }

    static public function getTxMedioSemAtraso00($t_atraso_0_med, $t_flmed) {
        return number_format(($t_atraso_0_med[1]["valor"] * $t_flmed[1]["valor"]) / 100, 2, ",", ".");
    }

    static public function getTxMedioSemAtraso10($t_atraso_0_med, $t_flmed) {
        return number_format(($t_atraso_0_med[2]["valor"] * $t_flmed[2]["valor"]) / 100, 2, ",", ".");
    }

    static public function getTxFLSuper91($t_flsuper) {
        return number_format($t_flsuper[0]["valor"], 2, ",", ".");
    }

    static public function getTxFLSuper00($t_flsuper) {
        return number_format($t_flsuper[1]["valor"], 2, ",", ".");
    }

    static public function getTxFLSuper10($t_flsuper) {
        return number_format($t_flsuper[2]["valor"], 2, ",", ".");
    }

    static public function getP6a14($t_freq6a14) {
        return number_format(100 - $t_freq6a14[2]["valor"], 2, ",", ".");
    }

    static public function getP15a17($t_freq15a17) {
        return number_format(100 - $t_freq15a17[2]["valor"], 2, ",", ".");
    }

//    static public function get25Fund10($t_fundin25m) {
//        return number_format($t_fundin25m[2]["valor"], 2, ",", ".");
//    }

    static public function get18Fund91($t_fund18m) {
        return number_format($t_fund18m[0]["valor"], 2, ",", ".");
    }

    static public function get18Fund00($t_fund18m) {
        return number_format($t_fund18m[1]["valor"], 2, ",", ".");
    }

    static public function get18Fund10($t_fund18m) {
        return number_format($t_fund18m[2]["valor"], 2, ",", ".");
    }

    static public function get18FundBr91($t_fund18m_br) {
        return number_format($t_fund18m_br[0]["valor"], 2, ",", ".");
    }

    static public function get18FundBr00($t_fund18m_br) {
        return number_format($t_fund18m_br[1]["valor"], 2, ",", ".");
    }

    static public function get18FundBr10($t_fund18m_br) {
        return number_format($t_fund18m_br[2]["valor"], 2, ",", ".");
    }

//    static public function get25Fund10ESTADO($t_fundin25m_uf) {
//        return number_format($t_fundin25m_uf[2]["valor"], 2, ",", ".");
//    }
//    
//    static public function get25Medio10($t_medin25m) {
//        return number_format($t_medin25m[2]["valor"], 2, ",", ".");
//    }
//    
//    static public function get25Medio10ESTADO($t_medin25m_uf) {
//        return number_format($t_medin25m_uf[2]["valor"], 2, ",", ".");
//    }

    static public function get25Analf10($t_analf25m) {
        return number_format($t_analf25m[2]["valor"], 2, ",", ".");
    }

    static public function get25Fund10($t_fund25m) {
        return number_format($t_fund25m[2]["valor"], 2, ",", ".");
    }

    static public function get25Medio10($t_med25m) {
        return number_format($t_med25m[2]["valor"], 2, ",", ".");
    }

    static public function get25Super10($t_super25m) {
        return number_format($t_super25m[2]["valor"], 2, ",", ".");
    }

    static public function get25Analf10BRASIL($t_analf25m_br) {
        return number_format($t_analf25m_br[2]["valor"], 2, ",", ".");
    }

    static public function get25Fund10BRASIL($t_fund25m_br) {
        return number_format($t_fund25m_br[2]["valor"], 2, ",", ".");
    }

    static public function get25Medio10BRASIL($t_med25m_br) {
        return number_format($t_med25m_br[2]["valor"], 2, ",", ".");
    }

    static public function get25Super10BRASIL($t_super25m_br) {
        return number_format($t_super25m_br[2]["valor"], 2, ",", ".");
    }

    static public function getDifAnalf($t_analf25m) {
        return $t_analf25m[2]["valor"] - $t_analf25m[0]["valor"];
    }

    static public function getEAnosEstudo91($e_anosesperados) {
        return number_format($e_anosesperados[0]["valor"], 2, ",", ".");
    }

    static public function getEAnosEstudo00($e_anosesperados) {
        return number_format($e_anosesperados[1]["valor"], 2, ",", ".");
    }

    static public function getEAnosEstudo10($e_anosesperados) {
        return number_format($e_anosesperados[2]["valor"], 2, ",", ".");
    }

    static public function getEAnosEstudo91ESTADO($e_anosesperados_uf) {
        return number_format($e_anosesperados_uf[0]["valor"], 2, ",", ".");
    }

    static public function getEAnosEstudo00ESTADO($e_anosesperados_uf) {
        return number_format($e_anosesperados_uf[1]["valor"], 2, ",", ".");
    }

    static public function getEAnosEstudo10ESTADO($e_anosesperados_uf) {
        return number_format($e_anosesperados_uf[2]["valor"], 2, ",", ".");
    }

    static public function getEAnosEstudo91BRASIL($e_anosesperados_br) {
        return number_format($e_anosesperados_br[0]["valor"], 2, ",", ".");
    }

    static public function getEAnosEstudo00BRASIL($e_anosesperados_br) {
        return number_format($e_anosesperados_br[1]["valor"], 2, ",", ".");
    }

    static public function getEAnosEstudo10BRASIL($e_anosesperados_br) {
        return number_format($e_anosesperados_br[2]["valor"], 2, ",", ".");
    }

    static public function getRenda91($rdpc) {
        return number_format($rdpc[0]["valor"], 2, ",", ".");
    }

    static public function getRenda00($rdpc) {
        return number_format($rdpc[1]["valor"], 2, ",", ".");
    }

    static public function getRenda10($rdpc) {
        return number_format($rdpc[2]["valor"], 2, ",", ".");
    }

    static public function getRenda91puro($rdpc) {
        return $rdpc[0]["valor"];
    }

    static public function getRenda00puro($rdpc) {
        return $rdpc[1]["valor"];
    }

    static public function getRenda10puro($rdpc) {
        return $rdpc[2]["valor"];
    }

//    static public function getTxCrescRenda($rdpc) {
//        return number_format((($rdpc[2]["valor"] - $rdpc[0]["valor"]) / $rdpc[0]["valor"]) * 100, 2, ",", ".");
//    }

    static public function getTxCrescRenda9100($rdpc) {
        //return number_format((($rdpc[1]["valor"] - $rdpc[0]["valor"]) / $rdpc[0]["valor"]) * 100, 2, ",", ".");
        return number_format(( ( ( $rdpc[1]["valor"] / $rdpc[0]["valor"]) - 1) * 100), 2, ",", ".");
    }

    static public function getTxCrescRenda9110($rdpc) {
        //return number_format((($rdpc[1]["valor"] - $rdpc[0]["valor"]) / $rdpc[0]["valor"]) * 100, 2, ",", ".");
        return number_format(( ( ( $rdpc[2]["valor"] / $rdpc[0]["valor"]) - 1) * 100), 2, ",", ".");
    }

    static public function getTxCrescRenda0010($rdpc) {
        //return number_format((( $rdpc[2]["valor"] - $rdpc[1]["valor"]) / $rdpc[1]["valor"]) * 100, 2, ",", ".");
        return number_format(( ( ( $rdpc[2]["valor"] / $rdpc[1]["valor"]) - 1) * 100), 2, ",", ".");
    }

    static public function getTxMediaAnualCrescRenda0010($rdpc) {
        return number_format(( ( ( pow(( $rdpc[2]["valor"] / $rdpc[1]["valor"]), (1 / 10))) - 1) * 100), 2, ",", ".");
    }

    static public function getTxMediaAnualCrescRenda9110($rdpc) {
        return number_format(( ( ( pow(( $rdpc[2]["valor"] / $rdpc[0]["valor"]), (1 / 10))) - 1) * 100), 2, ",", ".");
    }

    static public function getTxMediaAnualCrescRenda9100($rdpc) {
        return number_format(( ( ( pow(( $rdpc[1]["valor"] / $rdpc[0]["valor"]), (1 / 10))) - 1) * 100), 2, ",", ".");
    }

    static public function getTxMediaAnualCrescRenda9110_1por19($rdpc) {
        return number_format(( ( ( pow(( $rdpc[2]["valor"] / $rdpc[0]["valor"]), (1 / 19))) - 1) * 100), 2, ",", ".");
    }

    static public function getTxMediaAnualCrescRenda9100_1por9($rdpc) {
        return number_format(( ( ( pow(( $rdpc[1]["valor"] / $rdpc[0]["valor"]), (1 / 9))) - 1) * 100), 2, ",", ".");
    }

    static public function getTxPobreza91($pind) {
        return number_format($pind[0]["valor"], 2, ",", ".");
    }

    static public function getTxPobreza00($pind) {
        return number_format($pind[1]["valor"], 2, ",", ".");
    }

    static public function getTxPobreza10($pind) {
        return number_format($pind[2]["valor"], 2, ",", ".");
    }

    static public function getProporcaoPobres91($pmpob) {
        return number_format($pmpob[0]["valor"], 2, ",", ".");
    }

    static public function getProporcaoPobres00($pmpob) {
        return number_format($pmpob[1]["valor"], 2, ",", ".");
    }

    static public function getProporcaoPobres10($pmpob) {
        return number_format($pmpob[2]["valor"], 2, ",", ".");
    }

    static public function getGini91($gini) {
        return number_format($gini[0]["valor"], 2, ",", ".");
    }

    static public function getGini00($gini) {
        return number_format($gini[1]["valor"], 2, ",", ".");
    }

    static public function getGini10($gini) {
        return number_format($gini[2]["valor"], 2, ",", ".");
    }

    static public function getGini91puro($gini) {
        return $gini[0]["valor"];
    }

    static public function getGini00puro($gini) {
        return $gini[1]["valor"];
    }

    static public function getGini10puro($gini) {
        return $gini[2]["valor"];
    }

    static public function getTxAtiv18m00($t_ativ18m) {
        return number_format($t_ativ18m[1]["valor"], 2, ",", ".");
    }

    static public function getTxAtiv18m10($t_ativ18m) {
        return number_format($t_ativ18m[2]["valor"], 2, ",", ".");
    }

    static public function getTxDes18m00($t_des18m) {
        return number_format($t_des18m[1]["valor"], 2, ",", ".");
    }

    static public function getTxDes18m10($t_des18m) {
        return number_format($t_des18m[2]["valor"], 2, ",", ".");
    }

    static public function getPAgro10($p_agro) {
        return number_format($p_agro[2]["valor"], 2, ",", ".");
    }

    static public function getPExtr10($p_extr) {
        return number_format($p_extr[2]["valor"], 2, ",", ".");
    }

    static public function getPTransf10($p_transf) {
        return number_format($p_transf[2]["valor"], 2, ",", ".");
    }

    static public function getPConstr10($p_constr) {
        return number_format($p_constr[2]["valor"], 2, ",", ".");
    }

    static public function getPSiup10($p_siup) {
        return number_format($p_siup[2]["valor"], 2, ",", ".");
    }

    static public function getPCom10($p_com) {
        return number_format($p_com[2]["valor"], 2, ",", ".");
    }

    static public function getPServ10($p_serv) {
        return number_format($p_serv[2]["valor"], 2, ",", ".");
    }

    static public function printTableComponente($block_table_componente, $variaveis, $type) {

        //@NãoInclusoEmRM&UDH
        if ($type != "perfil_rm" && $type != "perfil_udh")
            $block_table_componente->setData("ano1", $variaveis[0][0]["label_ano_referencia"]); // Ano 1 (1991)    

        $block_table_componente->setData("ano2", $variaveis[0][1]["label_ano_referencia"]); // Ano 2 (2000)       
        $block_table_componente->setData("ano3", $variaveis[0][2]["label_ano_referencia"]); // Ano 3 (2010)

        for ($i = 1; $i <= count($variaveis); $i++) {

            if ($i === 1 || $i === 7 || $i === 9) {
                $block_table_componente->setData("v$i", $variaveis[$i - 1][0]["nome_perfil"]);

                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh")
                    $block_table_componente->setData("v$i" . "_a1", $variaveis[$i - 1][0]["valor"] <> 0 ? number_format($variaveis[$i - 1][0]["valor"], 3, ",", ".") : "-"); // Ano 1 (1991) 

                $block_table_componente->setData("v$i" . "_a2", $variaveis[$i - 1][1]["valor"] <> 0 ? number_format($variaveis[$i - 1][1]["valor"], 3, ",", ".") : "-"); // Ano 2 (2000)              
                $block_table_componente->setData("v$i" . "_a3", $variaveis[$i - 1][2]["valor"] <> 0 ? number_format($variaveis[$i - 1][2]["valor"], 3, ",", ".") : "-"); // Ano 3 (2010)
            }else {
                $block_table_componente->setData("v$i", $variaveis[$i - 1][0]["nome_perfil"]);

                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh")
                    $block_table_componente->setData("v$i" . "_a1", $variaveis[$i - 1][0]["valor"] <> 0 ? number_format($variaveis[$i - 1][0]["valor"], 2, ",", ".") : "-"); // Ano 1 (1991) 

                $block_table_componente->setData("v$i" . "_a2", $variaveis[$i - 1][1]["valor"] <> 0 ? number_format($variaveis[$i - 1][1]["valor"], 2, ",", ".") : "-"); // Ano 2 (2000)               
                $block_table_componente->setData("v$i" . "_a3", $variaveis[$i - 1][2]["valor"] <> 0 ? number_format($variaveis[$i - 1][2]["valor"], 2, ",", ".") : "-"); // Ano 3 (2010)
            }
        }
    }

    static public function printTableTaxaHiatoEntre9100($block_table_taxa_hiato, $taxa9100, $reducao_hiato_9100) {

        if ($taxa9100 >= 0)
            $block_table_taxa_hiato->setData("v1_a2", "+ " . $taxa9100 . "%"); // Ano 1 (1991)
        else
            $block_table_taxa_hiato->setData("v1_a2", "" . $taxa9100 . "%"); // Ano 1 (1991)

        if ($reducao_hiato_9100 >= 0)
            $block_table_taxa_hiato->setData("v1_a3", "+ " . $reducao_hiato_9100 . "%"); // Ano 2 (2000)
        else
            $block_table_taxa_hiato->setData("v1_a3", "" . $reducao_hiato_9100 . "%"); // Ano 2 (2000)
    }

    static public function printTableTaxaHiatoEntre0010($block_table_taxa_hiato, $taxa0010, $reducao_hiato_0010) {

        if ($taxa0010 >= 0)
            $block_table_taxa_hiato->setData("v2_a2", "+ " . $taxa0010 . "%"); // Ano 1 (1991)
        else
            $block_table_taxa_hiato->setData("v2_a2", "" . $taxa0010 . "%"); // Ano 1 (1991)

        if ($reducao_hiato_0010 >= 0)
            $block_table_taxa_hiato->setData("v2_a3", "+ " . $reducao_hiato_0010 . "%"); // Ano 2 (2000)
        else
            $block_table_taxa_hiato->setData("v2_a3", "" . $reducao_hiato_0010 . "%"); // Ano 2 (2000)
    }

    static public function printTableTaxaHiatoEntre9110($block_table_taxa_hiato, $taxa9110, $reducao_hiato_9110) {

        if ($taxa9110 >= 0)
            $block_table_taxa_hiato->setData("v3_a2", "+ " . $taxa9110 . "%"); // Ano 1 (1991)
        else
            $block_table_taxa_hiato->setData("v3_a2", "" . $taxa9110 . "%"); // Ano 1 (1991)

        if ($reducao_hiato_9110 >= 0)
            $block_table_taxa_hiato->setData("v3_a3", "+ " . $reducao_hiato_9110 . "%"); // Ano 2 (2000)
        else
            $block_table_taxa_hiato->setData("v3_a3", "" . $reducao_hiato_9110 . "%"); // Ano 2 (2000)
    }

//     static public function getRanking($block_ranking, $texto, $ranking, $uf, $ranking_uf) {
//        //RANKING POR MUN
//        $count = 1;
//        
//        $sqlinha = "select posicao_idh,posicao_e_idh from rank where fk_municipio = ".TextBuilder::$idMunicipio ." AND fk_ano_referencia = 3";
//        $var = TextBuilder::$bd->ExecutarSQL($sqlinha, "sqlinha_teste");
//        
//        $l_posicao_idh = $var[0]['posicao_idh'];
//        $l_posicao_e_idh = $var[0]['posicao_e_idh'];
//        $l_posicao_idh_menores = $var[0]['posicao_idh'] - 1;
//        $l_posicao_e_idh_menores = $var[0]['posicao_e_idh'] - 1;       
//        
//        foreach ($ranking as &$value) {
//            if ($value["id"] == TextBuilder::$idMunicipio) {
//                $texto->replaceTags("ranking_municipio_IDHM", $var[0]['posicao_idh']);
//                $idhm_igual = TextBuilder::getIDHM_Igual($value["valor"]); //IDHM
//
//                $count_iguais = 1;
//                foreach ($idhm_igual as &$value2) {
//                    if ($value2["id"] == TextBuilder::$idMunicipio) {
//                        $texto->replaceTags("municipios_melhor_IDHM", $var[0]['posicao_idh']-1);
//                        $texto->replaceTags("municipios_melhor_IDHM_p", number_format((($var[0]['posicao_idh']-1) / count($ranking)) * 100, 2, ",", "."));
//                        $texto->replaceTags("municipios_pior_IDHM", TextBuilder::my_number_format(count($ranking) - ($var[0]['posicao_idh'] - 1),0));
//                        $texto->replaceTags("municipios_pior_IDHM_p", number_format(((count($ranking) - ($var[0]['posicao_idh'] - 1)) / count($ranking)) * 100, 2, ",", "."));
//                        break;
//                    }
//                    $count_iguais++;
//                }
//                break;
//            }
//            $count++;
//        }
//
//        //RANKING POR ESTADO
//        $texto->replaceTags("estado_municipio", $uf[0]["nome"]);
//        $texto->replaceTags("numero_municipios_estado", count($ranking_uf));
//
//        $count = 1;
//        foreach ($ranking_uf as &$value) {
//            if ($value["id"] == TextBuilder::$idMunicipio) {
//
//                $texto->replaceTags("ranking_estados_IDHM", $var[0]['posicao_e_idh']);
//                $idhm_igual = TextBuilder::getIDHM_Igual_Uf($value["valor"], $uf[0]["id"]); //IDHM
//
//                $count_iguais = 1;
//                foreach ($idhm_igual as &$value2) {
//                    if ($value2["id"] == TextBuilder::$idMunicipio) {
//                        $texto->replaceTags("municipios_melhor_IDHM_estado", $var[0]['posicao_e_idh']-1);
//                        $texto->replaceTags("municipios_melhor_IDHM_p_estado", number_format((($var[0]['posicao_e_idh']-1) / count($ranking_uf)) * 100, 2, ",", "."));
//                        $texto->replaceTags("municipios_pior_IDHM_estado", TextBuilder::my_number_format((count($ranking_uf) - ($var[0]['posicao_e_idh'] - 1)),0));
//                        $texto->replaceTags("municipios_pior_IDHM_p_estado", number_format(((count($ranking_uf) - ($var[0]['posicao_e_idh'] - 1)) / count($ranking_uf)) * 100, 2, ",", "."));
//                        break;
//                    }
//                    $count_iguais++;
//                }
//                break;
//            }
//            $count++;
//        }
//
//        $block_ranking->setData("text", $texto->getTexto());
//         
//     }

    static public function getRanking($block_ranking, $texto, $ranking, $ranking_first, $ranking_last, $type) {

        if ($type == "perfil_m") {
            $rank_table = "rank";
            $rank_key = "fk_municipio";
        } else if ($type == "perfil_rm") {
            $rank_table = "rank_rm";
            $rank_key = "fk_rm";
        } else if ($type == "perfil_uf") {
            $rank_table = "rank_estado";
            $rank_key = "fk_estado";
        } else if ($type == "perfil_udh") {
            $rank_table = "rank_udh";
            $rank_key = "fk_udh";
        }


        $sqlinha = "select posicao_idh from " . $rank_table . " where " . $rank_key . " = " . TextBuilder::$idMunicipio . " AND fk_ano_referencia = 3";
        $var = TextBuilder::$bd->ExecutarSQL($sqlinha, "sqlinha");

        $texto->replaceTags("ranking_municipio_IDHM", $var[0]['posicao_idh']);

        foreach ($ranking_first as &$value) {
            $texto->replaceTags("maior_IDHM", number_format($value["valor"], 3, ",", "."));
            $texto->replaceTags("nome_maior", $value["nome"]);
        }

        foreach ($ranking_last as &$value) {
            $texto->replaceTags("menor_IDHM", number_format($value["valor"], 3, ",", "."));
            $texto->replaceTags("nome_menor", $value["nome"]);
        }

        $block_ranking->setData("text", $texto->getTexto());
    }

    static public function getRankingUDH($block_ranking, $texto, $rm_da_udh, $minValueRM_idhm, $maxValueRM_idhm, $minValueRM_idhm_L, $maxValueRM_idhm_L, $minValueRM_idhm_E, $maxValueRM_idhm_E, $minValueRM_idhm_R, $maxValueRM_idhm_R, $count_udh, $type) {

        $sqlinha = "SELECT ru.fk_udh, r.nome, u.fk_rm, posicao_r_idh, posicao_r_idhr, posicao_r_idhl, posicao_r_idhe from rank_udh ru
                INNER JOIN udh u ON u.id = ru.fk_udh
                INNER JOIN rm r ON u.fk_rm = r.id
                WHERE ru.fk_udh =" . TextBuilder::$idMunicipio . " AND ru.fk_ano_referencia = 3";

        $var = TextBuilder::$bd->ExecutarSQL($sqlinha, "sqlinha");


        $texto->replaceTags("ranking_udh_IDHM", $var[0]['posicao_r_idh']);
        $texto->replaceTags("count_udh", $count_udh[0]['count_udh']);
        $texto->replaceTags("rm_udh", $var[0]['nome']);

        $texto->replaceTags("maior_idhm_udh", number_format($maxValueRM_idhm[0]['valor'], 3, ",", "."));
        $texto->replaceTags("nome_maior_udh", $maxValueRM_idhm[0]['nome']);

        $texto->replaceTags("menor_idhm_udh", number_format($minValueRM_idhm[0]['valor'], 3, ",", "."));
        $texto->replaceTags("nome_menor_udh", $minValueRM_idhm[0]['nome']);

        $texto->replaceTags("ranking_udh_IDHM_L", $var[0]['posicao_r_idhl']);
        $texto->replaceTags("maior_idhm_udh_L", number_format($maxValueRM_idhm_L[0]['valor'], 3, ",", "."));
        $texto->replaceTags("nome_maior_udh_L", $maxValueRM_idhm_L[0]['nome']);

        $texto->replaceTags("menor_idhm_udh_L", number_format($minValueRM_idhm_L[0]['valor'], 3, ",", "."));
        $texto->replaceTags("nome_menor_udh_L", $minValueRM_idhm_L[0]['nome']);

        $texto->replaceTags("ranking_udh_IDHM_E", $var[0]['posicao_r_idhe']);
        $texto->replaceTags("maior_idhm_udh_E", number_format($maxValueRM_idhm_E[0]['valor'], 3, ",", "."));
        $texto->replaceTags("nome_maior_udh_E", $maxValueRM_idhm_E[0]['nome']);

        $texto->replaceTags("menor_idhm_udh_E", number_format($minValueRM_idhm_E[0]['valor'], 3, ",", "."));
        $texto->replaceTags("nome_menor_udh_E", $minValueRM_idhm_E[0]['nome']);

        $texto->replaceTags("ranking_udh_IDHM_R", $var[0]['posicao_r_idhr']);
        $texto->replaceTags("maior_idhm_udh_R", number_format($maxValueRM_idhm_R[0]['valor'], 3, ",", "."));
        $texto->replaceTags("nome_maior_udh_R", $maxValueRM_idhm_R[0]['nome']);

        $texto->replaceTags("menor_idhm_udh_R", number_format($minValueRM_idhm_R[0]['valor'], 3, ",", "."));
        $texto->replaceTags("nome_menor_udh_R", $minValueRM_idhm_R[0]['nome']);

        $block_ranking->setData("text", $texto->getTexto());
    }

    static public function printTablePopulacao($block_table_populacao, $variaveis, $stringTaxaUrbanizacao, $type) {


        //@NãoInclusoEmRM&UDH
        if ($type != "perfil_rm" && $type != "perfil_udh")
            $block_table_populacao->setData("ano1", $variaveis[0][0]["label_ano_referencia"]); // Ano 1 (1991)

        $block_table_populacao->setData("ano2", $variaveis[0][1]["label_ano_referencia"]); // Ano 2 (2000)
        $block_table_populacao->setData("ano3", $variaveis[0][2]["label_ano_referencia"]); // Ano 3 (2010)

        for ($i = 1; $i <= count($variaveis); $i++) {
            if ($i != 6) {
                $block_table_populacao->setData("v$i", $variaveis[$i - 1][0]["nome_perfil"]);
                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh") {
                    $block_table_populacao->setData("v$i" . "_a1", TextBuilder::my_number_format($variaveis[$i - 1][0]["valor"], 0)); // Ano 1 (1991)
                    $block_table_populacao->setData("v$i" . "__a1", number_format((($variaveis[$i - 1][0]["valor"] / $variaveis[0][0]["valor"]) * 100), 2, ",", ".")); // Ano 1 (1991)
                }
                $block_table_populacao->setData("v$i" . "_a2", TextBuilder::my_number_format($variaveis[$i - 1][1]["valor"], 0)); // Ano 2 (2000)
                $block_table_populacao->setData("v$i" . "__a2", number_format((($variaveis[$i - 1][1]["valor"] / $variaveis[0][1]["valor"]) * 100), 2, ",", ".")); // Ano 2 (2000)
                $block_table_populacao->setData("v$i" . "_a3", TextBuilder::my_number_format($variaveis[$i - 1][2]["valor"], 0)); // Ano 3 (2010)
                $block_table_populacao->setData("v$i" . "__a3", number_format((($variaveis[$i - 1][2]["valor"] / $variaveis[0][2]["valor"]) * 100), 2, ",", ".")); // Ano 3 (2010) 
            } else {
                $block_table_populacao->setData("v$i", $stringTaxaUrbanizacao); //(PESOURB/PESOTOT)*100
                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh") {
                    $block_table_populacao->setData("v$i" . "_a1", "-"); // Ano 1 (1991)
                    $block_table_populacao->setData("v$i" . "__a1", number_format((($variaveis[3][0]["valor"] / $variaveis[0][0]["valor"]) * 100), 2, ",", ".")); // Ano 1 (1991)
                }
                $block_table_populacao->setData("v$i" . "_a2", "-"); // Ano 2 (2000)
                $block_table_populacao->setData("v$i" . "__a2", number_format((($variaveis[3][1]["valor"] / $variaveis[0][1]["valor"]) * 100), 2, ",", ".")); // Ano 2 (2000)
                $block_table_populacao->setData("v$i" . "_a3", "-"); // Ano 3 (2010)
                $block_table_populacao->setData("v$i" . "__a3", number_format((($variaveis[3][2]["valor"] / $variaveis[0][2]["valor"]) * 100), 2, ",", ".")); // Ano 3 (2010)
            }
        }
    }

    static public function printTableEtaria($block_table_etaria, $variaveis, $pesotot, $stringMenos15anos, $string15a64anos, $type) {

        //@NãoInclusoEmRM&UDH
        if ($type != "perfil_rm" && $type != "perfil_udh")
            $block_table_etaria->setData("ano1", $variaveis[0][0]["label_ano_referencia"]); // Ano 1 (1991)

        $block_table_etaria->setData("ano2", $variaveis[0][1]["label_ano_referencia"]); // Ano 2 (2000)
        $block_table_etaria->setData("ano3", $variaveis[0][2]["label_ano_referencia"]); // Ano 3 (2010)

        for ($i = 1; $i <= count($variaveis); $i++) {
            if ($i == 1) {
                $block_table_etaria->setData("v$i", $stringMenos15anos);
                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh") {
                    $block_table_etaria->setData("v$i" . "_a1", TextBuilder::my_number_format($pesotot[0]["valor"] - $variaveis[$i - 1][0]["valor"], 0)); // Ano 1 (1991)
                    $block_table_etaria->setData("v$i" . "__a1", number_format((($pesotot[0]["valor"] - $variaveis[$i - 1][0]["valor"]) / $pesotot[0]["valor"]) * 100, 2, ",", ".")); // Ano 1 (1991)
                }
                $block_table_etaria->setData("v$i" . "_a2", TextBuilder::my_number_format($pesotot[1]["valor"] - $variaveis[$i - 1][1]["valor"], 0)); // Ano 2 (2000)
                $block_table_etaria->setData("v$i" . "__a2", number_format((($pesotot[1]["valor"] - $variaveis[$i - 1][1]["valor"]) / $pesotot[1]["valor"]) * 100, 2, ",", ".")); // Ano 2 (2000)
                $block_table_etaria->setData("v$i" . "_a3", TextBuilder::my_number_format($pesotot[2]["valor"] - $variaveis[$i - 1][2]["valor"], 0)); // Ano 3 (2010)
                $block_table_etaria->setData("v$i" . "__a3", number_format((($pesotot[2]["valor"] - $variaveis[$i - 1][2]["valor"]) / $pesotot[2]["valor"]) * 100, 2, ",", ".")); // Ano 3 (2010)
            } else if ($i == 2) {
                $block_table_etaria->setData("v$i", $string15a64anos);
                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh") {
                    $block_table_etaria->setData("v$i" . "_a1", TextBuilder::my_number_format($variaveis[$i - 2][0]["valor"] - $variaveis[$i][0]["valor"], 0)); // Ano 1 (1991)
                    $block_table_etaria->setData("v$i" . "__a1", number_format((($variaveis[$i - 2][0]["valor"] - $variaveis[$i][0]["valor"]) / $pesotot[0]["valor"]) * 100, 2, ",", ".")); // Ano 1 (1991)
                }
                $block_table_etaria->setData("v$i" . "_a2", TextBuilder::my_number_format($variaveis[$i - 2][1]["valor"] - $variaveis[$i][1]["valor"], 0)); // Ano 2 (2000)
                $block_table_etaria->setData("v$i" . "__a2", number_format((($variaveis[$i - 2][1]["valor"] - $variaveis[$i][1]["valor"]) / $pesotot[1]["valor"]) * 100, 2, ",", ".")); // Ano 2 (2000)
                $block_table_etaria->setData("v$i" . "_a3", TextBuilder::my_number_format($variaveis[$i - 2][2]["valor"] - $variaveis[$i][2]["valor"], 0)); // Ano 3 (2010)
                $block_table_etaria->setData("v$i" . "__a3", number_format((($variaveis[$i - 2][2]["valor"] - $variaveis[$i][2]["valor"]) / $pesotot[2]["valor"]) * 100, 2, ",", ".")); // Ano 3 (2010)
            } else if ($i == 3) {
                $block_table_etaria->setData("v$i", $variaveis[$i - 1][0]["nome_perfil"]);
                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh") {
                    $block_table_etaria->setData("v$i" . "_a1", TextBuilder::my_number_format($variaveis[$i - 1][0]["valor"], 0)); // Ano 1 (1991)
                    $block_table_etaria->setData("v$i" . "__a1", number_format(($variaveis[$i - 1][0]["valor"] / $pesotot[0]["valor"]) * 100, 2, ",", ".")); // Ano 1 (1991)
                }
                $block_table_etaria->setData("v$i" . "_a2", TextBuilder::my_number_format($variaveis[$i - 1][1]["valor"], 0)); // Ano 2 (2000)
                $block_table_etaria->setData("v$i" . "__a2", number_format(($variaveis[$i - 1][1]["valor"] / $pesotot[1]["valor"]) * 100, 2, ",", ".")); // Ano 2 (2000)
                $block_table_etaria->setData("v$i" . "_a3", TextBuilder::my_number_format($variaveis[$i - 1][2]["valor"], 0)); // Ano 3 (2010)
                $block_table_etaria->setData("v$i" . "__a3", number_format(($variaveis[$i - 1][2]["valor"] / $pesotot[2]["valor"]) * 100, 2, ",", ".")); // Ano 3 (2010)
            } else if ($i == 4) {
                $block_table_etaria->setData("v$i", $variaveis[$i - 1][0]["nome_perfil"]);
                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh") {
                    $block_table_etaria->setData("v$i" . "_a1", $variaveis[$i - 1][0]["valor"] <> 0 ? number_format($variaveis[$i - 1][0]["valor"], 2, ",", ".") : "-"); // Ano 1 (1991)
                    $block_table_etaria->setData("v$i" . "__a1", "-"); // Ano 1 (1991)
                }
                $block_table_etaria->setData("v$i" . "_a2", $variaveis[$i - 1][1]["valor"] <> 0 ? number_format($variaveis[$i - 1][1]["valor"], 2, ",", ".") : "-"); // Ano 2 (2000)
                $block_table_etaria->setData("v$i" . "__a2", "-"); // Ano 2 (2000)
                $block_table_etaria->setData("v$i" . "_a3", $variaveis[$i - 1][2]["valor"] <> 0 ? number_format($variaveis[$i - 1][2]["valor"], 2, ",", ".") : "-"); // Ano 3 (2010)
                $block_table_etaria->setData("v$i" . "__a3", "-"); // Ano 3 (2010)
            } else {
                $block_table_etaria->setData("v$i", $variaveis[$i - 1][0]["nome_perfil"]);
                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh") {
                    $block_table_etaria->setData("v$i" . "_a1", $variaveis[$i - 1][0]["valor"] <> 0 ? number_format($variaveis[$i - 1][0]["valor"], 2, ",", ".") : "-"); // Ano 1 (1991)
                    $block_table_etaria->setData("v$i" . "__a1", "-"); // Ano 1 (1991)
                }
                $block_table_etaria->setData("v$i" . "_a2", $variaveis[$i - 1][1]["valor"] <> 0 ? number_format($variaveis[$i - 1][1]["valor"], 2, ",", ".") : "-"); // Ano 2 (2000)
                $block_table_etaria->setData("v$i" . "__a2", "-"); // Ano 2 (2000)
                $block_table_etaria->setData("v$i" . "_a3", $variaveis[$i - 1][2]["valor"] <> 0 ? number_format($variaveis[$i - 1][2]["valor"], 2, ",", ".") : "-"); // Ano 3 (2010)
                $block_table_etaria->setData("v$i" . "__a3", "-"); // Ano 3 (2010)
            }
        }
    }

    static public function printTableLongevidade($block_table_longevidade, $variaveis, $type) {

        //@NãoInclusoEmRM&UDH
        if ($type != "perfil_rm" && $type != "perfil_udh")
            $block_table_longevidade->setData("ano1", $variaveis[0][0]["label_ano_referencia"]); // Ano 1 (1991)

        $block_table_longevidade->setData("ano2", $variaveis[0][1]["label_ano_referencia"]); // Ano 2 (2000)
        $block_table_longevidade->setData("ano3", $variaveis[0][2]["label_ano_referencia"]); // Ano 3 (2010)

        for ($i = 1; $i <= count($variaveis); $i++) {
            $block_table_longevidade->setData("v$i", $variaveis[$i - 1][0]["nome_perfil"]);
            //@NãoInclusoEmRM&UDH
            if ($type != "perfil_rm" && $type != "perfil_udh")
                $block_table_longevidade->setData("v$i" . "_a1", $variaveis[$i - 1][0]["valor"] <> 0 ? number_format($variaveis[$i - 1][0]["valor"], 1, ",", ".") : "-"); // Ano 1 (1991)

            $block_table_longevidade->setData("v$i" . "_a2", $variaveis[$i - 1][1]["valor"] <> 0 ? number_format($variaveis[$i - 1][1]["valor"], 1, ",", ".") : "-"); // Ano 2 (2000)
            $block_table_longevidade->setData("v$i" . "_a3", $variaveis[$i - 1][2]["valor"] <> 0 ? number_format($variaveis[$i - 1][2]["valor"], 1, ",", ".") : "-"); // Ano 3 (2010)
        }
    }

    static public function printTableRenda($block_table_renda, $variaveis, $type) {

        //@NãoInclusoEmRM&UDH
        if ($type != "perfil_rm" && $type != "perfil_udh")
            $block_table_renda->setData("ano1", $variaveis[0][0]["label_ano_referencia"]); // Ano 1 (1991)

        $block_table_renda->setData("ano2", $variaveis[0][1]["label_ano_referencia"]); // Ano 2 (2000)
        $block_table_renda->setData("ano3", $variaveis[0][2]["label_ano_referencia"]); // Ano 3 (2010)

        for ($i = 1; $i <= count($variaveis); $i++) {

            if ($i == 2) {
                $block_table_renda->setData("v$i", $variaveis[$i - 1][0]["nomecurto"]);
                $block_table_renda->setData("v" . $i . "_tt", $variaveis[$i - 1][0]["definicao"]);

                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh")
                    $block_table_renda->setData("v$i" . "_a1", $variaveis[$i - 1][0]["valor"] <> 0 ? number_format($variaveis[$i - 1][0]["valor"], 2, ",", ".") : "-"); // Ano 1 (1991)

                $block_table_renda->setData("v$i" . "_a2", $variaveis[$i - 1][1]["valor"] <> 0 ? number_format($variaveis[$i - 1][1]["valor"], 2, ",", ".") : "-"); // Ano 2 (2000)
                $block_table_renda->setData("v$i" . "_a3", $variaveis[$i - 1][2]["valor"] <> 0 ? number_format($variaveis[$i - 1][2]["valor"], 2, ",", ".") : "-"); // Ano 3 (2010)
            }else if ($i == 3) {
                $block_table_renda->setData("v$i", $variaveis[$i - 1][0]["nomecurto"]);
                $block_table_renda->setData("v" . $i . "_tt", $variaveis[$i - 1][0]["definicao"]);

                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh")
                    $block_table_renda->setData("v$i" . "_a1", $variaveis[$i - 1][0]["valor"] <> 0 ? number_format($variaveis[$i - 1][0]["valor"], 2, ",", ".") : "-"); // Ano 1 (1991)

                $block_table_renda->setData("v$i" . "_a2", $variaveis[$i - 1][1]["valor"] <> 0 ? number_format($variaveis[$i - 1][1]["valor"], 2, ",", ".") : "-"); // Ano 2 (2000)
                $block_table_renda->setData("v$i" . "_a3", $variaveis[$i - 1][2]["valor"] <> 0 ? number_format($variaveis[$i - 1][2]["valor"], 2, ",", ".") : "-"); // Ano 3 (2010)
            }else {
                $block_table_renda->setData("v$i", $variaveis[$i - 1][0]["nome_perfil"]);

                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh")
                    $block_table_renda->setData("v$i" . "_a1", $variaveis[$i - 1][0]["valor"] <> 0 ? number_format($variaveis[$i - 1][0]["valor"], 2, ",", ".") : "-"); // Ano 1 (1991)

                $block_table_renda->setData("v$i" . "_a2", $variaveis[$i - 1][1]["valor"] <> 0 ? number_format($variaveis[$i - 1][1]["valor"], 2, ",", ".") : "-"); // Ano 2 (2000)
                $block_table_renda->setData("v$i" . "_a3", $variaveis[$i - 1][2]["valor"] <> 0 ? number_format($variaveis[$i - 1][2]["valor"], 2, ",", ".") : "-"); // Ano 3 (2010)
            }
        }
    }

    static public function printTableRenda2($block_table_renda2, $variaveis, $type) {

        //@NãoInclusoEmRM&UDH
        if ($type != "perfil_rm" && $type != "perfil_udh")
            $block_table_renda2->setData("ano1", $variaveis[0][0]["label_ano_referencia"]); // Ano 1 (1991)

        $block_table_renda2->setData("ano2", $variaveis[0][1]["label_ano_referencia"]); // Ano 2 (2000)
        $block_table_renda2->setData("ano3", $variaveis[0][2]["label_ano_referencia"]); // Ano 3 (2010)

        for ($i = 1; $i <= count($variaveis); $i++) {

            if ($i == 1) {
                $block_table_renda2->setData("v$i", $variaveis[$i - 1][0]["nomecurto"]);
                $block_table_renda2->setData("v" . $i . "_tt", $variaveis[$i - 1][0]["definicao"]);
                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh")
                    $block_table_renda2->setData("v$i" . "_a1", number_format($variaveis[$i - 1][0]["valor"], 2, ",", ".")); // Ano 1 (1991)

                $block_table_renda2->setData("v$i" . "_a2", number_format($variaveis[$i - 1][1]["valor"], 2, ",", ".")); // Ano 2 (2000)
                $block_table_renda2->setData("v$i" . "_a3", number_format($variaveis[$i - 1][2]["valor"], 2, ",", ".")); // Ano 3 (2010)
            }
            else if ($i == 2) {
                $block_table_renda2->setData("v$i", $variaveis[$i - 1][0]["nomecurto"]);
                $block_table_renda2->setData("v" . $i . "_tt", $variaveis[$i - 1][0]["definicao"]);
                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh")
                    $block_table_renda2->setData("v$i" . "_a1", number_format($variaveis[$i - 1][0]["valor"], 2, ",", ".")); // Ano 1 (1991)

                $block_table_renda2->setData("v$i" . "_a2", number_format($variaveis[$i - 1][1]["valor"], 2, ",", ".")); // Ano 2 (2000)
                $block_table_renda2->setData("v$i" . "_a3", number_format($variaveis[$i - 1][2]["valor"], 2, ",", ".")); // Ano 3 (2010)
            }
            else if ($i == 3) {
                $block_table_renda2->setData("v$i", $variaveis[$i - 1][0]["nomecurto"]);
                $block_table_renda2->setData("v" . $i . "_tt", $variaveis[$i - 1][0]["definicao"]);
                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh")
                    $block_table_renda2->setData("v$i" . "_a1", number_format($variaveis[$i - 1][0]["valor"], 2, ",", ".")); // Ano 1 (1991)

                $block_table_renda2->setData("v$i" . "_a2", number_format($variaveis[$i - 1][1]["valor"], 2, ",", ".")); // Ano 2 (2000)
                $block_table_renda2->setData("v$i" . "_a3", number_format($variaveis[$i - 1][2]["valor"], 2, ",", ".")); // Ano 3 (2010)
            }
            else if ($i == 4) {
                $block_table_renda2->setData("v$i", $variaveis[$i - 1][0]["nomecurto"]);
                $block_table_renda2->setData("v" . $i . "_tt", $variaveis[$i - 1][0]["definicao"]);
                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh")
                    $block_table_renda2->setData("v$i" . "_a1", number_format($variaveis[$i - 1][0]["valor"], 2, ",", ".")); // Ano 1 (1991)

                $block_table_renda2->setData("v$i" . "_a2", number_format($variaveis[$i - 1][1]["valor"], 2, ",", ".")); // Ano 2 (2000)
                $block_table_renda2->setData("v$i" . "_a3", number_format($variaveis[$i - 1][2]["valor"], 2, ",", ".")); // Ano 3 (2010)
            }
            else if ($i == 5) {
                $block_table_renda2->setData("v$i", $variaveis[$i - 1][0]["nomecurto"]);
                $block_table_renda2->setData("v" . $i . "_tt", $variaveis[$i - 1][0]["definicao"]);
                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh")
                    $block_table_renda2->setData("v$i" . "_a1", number_format($variaveis[$i - 1][0]["valor"], 2, ",", ".")); // Ano 1 (1991)

                $block_table_renda2->setData("v$i" . "_a2", number_format($variaveis[$i - 1][1]["valor"], 2, ",", ".")); // Ano 2 (2000)
                $block_table_renda2->setData("v$i" . "_a3", number_format($variaveis[$i - 1][2]["valor"], 2, ",", ".")); // Ano 3 (2010)
            }
        }
    }

    static public function printTableTrabalho($block_table_trabalho, $variaveis) {

        $block_table_trabalho->setData("ano1", $variaveis[0][0]["label_ano_referencia"]); // Ano 1 (1991)
        $block_table_trabalho->setData("ano2", $variaveis[0][1]["label_ano_referencia"]); // Ano 2 (2000)
        $block_table_trabalho->setData("ano3", $variaveis[0][2]["label_ano_referencia"]); // Ano 3 (2010)

        for ($i = 1; $i <= count($variaveis); $i++) {
            $block_table_trabalho->setData("v$i", $variaveis[$i - 1][0]["nome_perfil"]);
            //$block_table_trabalho->setData("v$i"."_a1", $variaveis[$i-1][0]["valor"]); // Ano 1 (1991)
            $block_table_trabalho->setData("v$i" . "_a2", $variaveis[$i - 1][1]["valor"] <> 0 ? number_format($variaveis[$i - 1][1]["valor"], 2, ",", ".") : "-"); // Ano 2 (2000)
            $block_table_trabalho->setData("v$i" . "_a3", $variaveis[$i - 1][2]["valor"] <> 0 ? number_format($variaveis[$i - 1][2]["valor"], 2, ",", ".") : "-"); // Ano 3 (2010)
        }
    }

    static public function printTableHabitacao($block_table_habitacao, $variaveis, $texto, $type) {

        //@NãoInclusoEmRM&UDH
        if ($type != "perfil_rm" && $type != "perfil_udh")
            $block_table_habitacao->setData("ano1", $variaveis[0][0]["label_ano_referencia"]); // Ano 1 (1991)

        $block_table_habitacao->setData("ano2", $variaveis[0][1]["label_ano_referencia"]); // Ano 2 (2000)
        $block_table_habitacao->setData("ano3", $variaveis[0][2]["label_ano_referencia"]); // Ano 3 (2010)

        for ($i = 1; $i <= count($variaveis); $i++) {

            if ($i == 3) {
                $block_table_habitacao->setData("v$i", $variaveis[$i - 1][0]["nome_perfil"]);
                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh")
                    $block_table_habitacao->setData("v$i" . "_a1", $variaveis[$i - 1][0]["valor"] <> 0 ? number_format($variaveis[$i - 1][0]["valor"], 2, ",", ".") : "-"); // Ano 1 (1991)

                $block_table_habitacao->setData("v$i" . "_a2", $variaveis[$i - 1][1]["valor"] <> 0 ? number_format($variaveis[$i - 1][1]["valor"], 2, ",", ".") : "-"); // Ano 2 (2000)
                $block_table_habitacao->setData("v$i" . "_a3", $variaveis[$i - 1][2]["valor"] <> 0 ? number_format($variaveis[$i - 1][2]["valor"], 2, ",", ".") : "-"); // Ano 3 (2010)
            }else {
                $block_table_habitacao->setData("v$i", $variaveis[$i - 1][0]["nomecurto"]);
                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh")
                    $block_table_habitacao->setData("v$i" . "_a1", $variaveis[$i - 1][0]["valor"] <> 0 ? number_format($variaveis[$i - 1][0]["valor"], 2, ",", ".") : "-"); // Ano 1 (1991)

                $block_table_habitacao->setData("v$i" . "_a2", $variaveis[$i - 1][1]["valor"] <> 0 ? number_format($variaveis[$i - 1][1]["valor"], 2, ",", ".") : "-"); // Ano 2 (2000)
                $block_table_habitacao->setData("v$i" . "_a3", $variaveis[$i - 1][2]["valor"] <> 0 ? number_format($variaveis[$i - 1][2]["valor"], 2, ",", ".") : "-"); // Ano 3 (2010)
            }
        }
    }

    static public function printTableVulnerabilidade($block_table_vulnerabilidade, $variaveis, $type) {

        //@NãoInclusoEmRM&UDH
        if ($type != "perfil_rm" && $type != "perfil_udh")
            $block_table_vulnerabilidade->setData("ano1", $variaveis[0][0]["label_ano_referencia"]); // Ano 1 (1991)

        $block_table_vulnerabilidade->setData("ano2", $variaveis[0][1]["label_ano_referencia"]); // Ano 2 (2000)
        $block_table_vulnerabilidade->setData("ano3", $variaveis[0][2]["label_ano_referencia"]); // Ano 3 (2010)

        for ($i = 1; $i <= count($variaveis); $i++) {

            if ($i == 4) {
                $block_table_vulnerabilidade->setData("v$i", $variaveis[$i - 1][0]["nomecurto"]);
                $block_table_vulnerabilidade->setData("v" . $i . "_tt", $variaveis[$i - 1][0]["definicao"]);

                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh")
                    $block_table_vulnerabilidade->setData("v$i" . "_a1", ($variaveis[$i - 1][0]["valor"]) != 0 ? number_format($variaveis[$i - 1][0]["valor"], 2, ",", ".") : "-"); // Ano 1 (1991)


                $block_table_vulnerabilidade->setData("v$i" . "_a2", $variaveis[$i - 1][1]["valor"] <> 0 ? number_format($variaveis[$i - 1][1]["valor"], 2, ",", ".") : "-"); // Ano 2 (2000)
                $block_table_vulnerabilidade->setData("v$i" . "_a3", $variaveis[$i - 1][2]["valor"] <> 0 ? number_format($variaveis[$i - 1][2]["valor"], 2, ",", ".") : "-"); // Ano 3 (2010)
            }

            else if ($i == 9) {
                $block_table_vulnerabilidade->setData("v$i", $variaveis[$i - 1][0]["nome_perfil"]);
                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh")
                    $block_table_vulnerabilidade->setData("v$i" . "_a1", ($variaveis[$i - 1][0]["valor"]) != 0 ? number_format($variaveis[$i - 1][0]["valor"], 2, ",", ".") : "-"); // Ano 1 (1991)

                $block_table_vulnerabilidade->setData("v$i" . "_a2", $variaveis[$i - 1][1]["valor"] <> 0 ? number_format($variaveis[$i - 1][1]["valor"], 2, ",", ".") : "-"); // Ano 2 (2000)
                $block_table_vulnerabilidade->setData("v$i" . "_a3", $variaveis[$i - 1][2]["valor"] <> 0 ? number_format($variaveis[$i - 1][2]["valor"], 2, ",", ".") : "-"); // Ano 3 (2010)
            }

            else if ($i == 10) {
                $block_table_vulnerabilidade->setData("v$i", $variaveis[$i - 1][0]["nomecurto"]);
                $block_table_vulnerabilidade->setData("v" . $i . "_tt", $variaveis[$i - 1][0]["definicao"]);
                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh")
                    $block_table_vulnerabilidade->setData("v$i" . "_a1", ($variaveis[$i - 1][0]["valor"]) != 0 ? number_format($variaveis[$i - 1][0]["valor"], 2, ",", ".") : "-"); // Ano 1 (1991)


                $block_table_vulnerabilidade->setData("v$i" . "_a2", $variaveis[$i - 1][1]["valor"] <> 0 ? number_format($variaveis[$i - 1][1]["valor"], 2, ",", ".") : "-"); // Ano 2 (2000)
                $block_table_vulnerabilidade->setData("v$i" . "_a3", $variaveis[$i - 1][2]["valor"] <> 0 ? number_format($variaveis[$i - 1][2]["valor"], 2, ",", ".") : "-"); // Ano 3 (2010)
            }

            else {
                $block_table_vulnerabilidade->setData("v$i", $variaveis[$i - 1][0]["nomecurto"]);
                //@NãoInclusoEmRM&UDH
                if ($type != "perfil_rm" && $type != "perfil_udh")
                    $block_table_vulnerabilidade->setData("v$i" . "_a1", ($variaveis[$i - 1][0]["valor"]) != 0 ? number_format($variaveis[$i - 1][0]["valor"], 2, ",", ".") : "-"); // Ano 1 (1991)

                $block_table_vulnerabilidade->setData("v$i" . "_a2", $variaveis[$i - 1][1]["valor"] <> 0 ? number_format($variaveis[$i - 1][1]["valor"], 2, ",", ".") : "-"); // Ano 2 (2000)
                $block_table_vulnerabilidade->setData("v$i" . "_a3", $variaveis[$i - 1][2]["valor"] <> 0 ? number_format($variaveis[$i - 1][2]["valor"], 2, ",", ".") : "-"); // Ano 3 (2010)
            }
        }
    }

}

?>

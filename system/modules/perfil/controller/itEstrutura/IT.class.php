<?php

/**
 * Construção da Classe principal do PerfilBuilder
 *
 * @author Andre Castro
 */
//require_once PERFIL_PACKAGE . 'controller/chart/FunctionsChart.class.php';

abstract class IT {

    //Requisitos
    protected $lang;
    protected $type;
    protected $chart;

    public function __construct($lang, $type) {
        $this->lang = $lang;
        $this->type = $type;

        $this->chart = new Chart($type);
    }

    public function getTexto() {

        switch ($this->type) {
            case "perfil_m":

                if ($this->lang == "pt")
                    return $this->textoMunPT;
                else if ($this->lang == "en")
                    return $this->textoMunEN;
                else if ($this->lang == "es")
                    return $this->textoMunES;

                break;

            case "perfil_rm":

                if ($this->lang == "pt")
                    return $this->textoRmPT;
                else if ($this->lang == "en")
                    return $this->textoRmEN;
                else if ($this->lang == "es")
                    return $this->textoRmES;

                break;

            case "perfil_uf":

                if ($this->lang == "pt")
                    return $this->textoUfPT;
                else if ($this->lang == "en")
                    return $this->textoUfEN;
                else if ($this->lang == "es")
                    return $this->textoUfES;

                break;

            case "perfil_udh":

                if ($this->lang == "pt")
                    return $this->textoUdhPT;
                else if ($this->lang == "en")
                    return $this->textoUdhEN;
                else if ($this->lang == "es")
                    return $this->textoUdhES;

                break;

            default:
                break;
        }
    }

    public function getTexto2() {

        switch ($this->type) {
            case "perfil_m":

                if ($this->lang == "pt")
                    return $this->texto2MunPT;
                else if ($this->lang == "en")
                    return $this->texto2MunEN;
                else if ($this->lang == "es")
                    return $this->texto2MunES;

                break;

            case "perfil_rm":

                if ($this->lang == "pt")
                    return $this->texto2RmPT;
                else if ($this->lang == "en")
                    return $this->texto2RmEN;
                else if ($this->lang == "es")
                    return $this->texto2RmES;

                break;

            case "perfil_uf":

                if ($this->lang == "pt")
                    return $this->texto2UfPT;
                else if ($this->lang == "en")
                    return $this->texto2UfEN;
                else if ($this->lang == "es")
                    return $this->texto2UfES;

                break;

            case "perfil_udh":

                if ($this->lang == "pt")
                    return $this->texto2UdhPT;
                else if ($this->lang == "en")
                    return $this->texto2UdhEN;
                else if ($this->lang == "es")
                    return $this->texto2UdhES;

                break;

            default:
                break;
        }
    }

    public function getTexto3() {

        switch ($this->type) {
            case "perfil_m":

                if ($this->lang == "pt")
                    return $this->texto3MunPT;
                else if ($this->lang == "en")
                    return $this->texto3MunEN;
                else if ($this->lang == "es")
                    return $this->texto3MunES;

                break;

            case "perfil_rm":

                if ($this->lang == "pt")
                    return $this->texto3RmPT;
                else if ($this->lang == "en")
                    return $this->texto3RmEN;
                else if ($this->lang == "es")
                    return $this->texto3RmES;

                break;

            case "perfil_uf":

                if ($this->lang == "pt")
                    return $this->texto3UfPT;
                else if ($this->lang == "en")
                    return $this->texto3UfEN;
                else if ($this->lang == "es")
                    return $this->texto3UfES;

                break;

            case "perfil_udh":

                if ($this->lang == "pt")
                    return $this->texto3UdhPT;
                else if ($this->lang == "en")
                    return $this->texto3UdhEN;
                else if ($this->lang == "es")
                    return $this->texto3UdhES;

                break;

            default:
                break;
        }
    }

    public function getTextoShow() {

        switch ($this->type) {
            case "perfil_m":

                if ($this->lang == "pt")
                    return $this->textoShowMunPT;
                else if ($this->lang == "en")
                    return $this->textoShowMunEN;
                else if ($this->lang == "es")
                    return $this->textoShowMunES;

                break;

            case "perfil_rm":

                if ($this->lang == "pt")
                    return $this->textoShowRmPT;
                else if ($this->lang == "en")
                    return $this->textoShowRmEN;
                else if ($this->lang == "es")
                    return $this->textoShowRmES;

                break;

            case "perfil_uf":

                if ($this->lang == "pt")
                    return $this->textoShowUfPT;
                else if ($this->lang == "en")
                    return $this->textoShowUfEN;
                else if ($this->lang == "es")
                    return $this->textoShowUfES;

                break;

            case "perfil_udh":

                if ($this->lang == "pt")
                    return $this->textoShowUdhPT;
                else if ($this->lang == "en")
                    return $this->textoShowUdhEN;
                else if ($this->lang == "es")
                    return $this->textoShowUdhES;

                break;

            default:
                break;
        }
    }

    public function getTitulo() {

        if ($this->lang == "pt")
            return $this->tituloPT;
        else if ($this->lang == "en")
            return $this->tituloEN;
        else if ($this->lang == "es")
            return $this->tituloES;
    }

    public function getSubTitulo() {

        if ($this->lang == "pt")
            return $this->subtituloPT;
        else if ($this->lang == "en")
            return $this->subtituloEN;
        else if ($this->lang == "es")
            return $this->subtituloES;
    }

    public function getTituloTable() {

        if ($this->lang == "pt")
            return $this->tituloTablePT;
        else if ($this->lang == "en")
            return $this->tituloTableEN;
        else if ($this->lang == "es")
            return $this->tituloTableES;
    }

    public function getCaption() {

//        if ($this->type == "perfil_udh") {
//            
//            if ($this->lang == "pt")
//                return $this->captionUdhPT;
//            else if ($this->lang == "en")
//                return $this->captionUdhEN;
//            else if ($this->lang == "es")
//                return $this->captionUdhES;
//            
//        }else {

            if ($this->lang == "pt")
                return $this->captionPT;
            else if ($this->lang == "en")
                return $this->captionEN;
            else if ($this->lang == "es")
                return $this->captionES;
            
        //}
    }

    public function getCaption2() {

        if ($this->lang == "pt")
            return $this->caption2PT;
        else if ($this->lang == "en")
            return $this->caption2EN;
        else if ($this->lang == "es")
            return $this->caption2ES;
    }

    public function __destruct() {
        
    }

}

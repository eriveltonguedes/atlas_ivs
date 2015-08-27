<?php

/**
 * Construção do Componente por Tipo e Idioma
 *
 * @author Andre Castro
 */
class ITVulnerabilidade extends IT {

    //Padrão
    protected $tituloPT = "Vulnerabilidade social";
    protected $tituloEN = "Social vulnerability";
    protected $tituloES = "Vulnerabilidad social";

    //Tabela
    protected $captionPT = "Vulnerabilidade Social";
    protected $captionEN = "Social vulnerability";
    protected $captionES = "Vulnerabilidad social";
    
    protected $subCaption1PT = "Crianças e Jovens";
    protected $subCaption1EN = "Children and young people";
    protected $subCaption1ES = "Niños y jóvenes";
    
    protected $subCaption2PT = "Família";
    protected $subCaption2EN = "Family";
    protected $subCaption2ES = "Familia";
    
    protected $subCaption3PT = "Trabalho e Renda";
    protected $subCaption3EN = "Labour and Income";
    protected $subCaption3ES = "Trabajo e ingresos";
    
    protected $subCaption4PT = "Condição de Moradia";
    protected $subCaption4EN = "Living conditions";
    protected $subCaption4ES = "Condiciones de vivienda";
    
    public function getSubCaption1() {

        if ($this->lang == "pt")
            return $this->subCaption1PT;
        else if ($this->lang == "en")
            return $this->subCaption1EN;
        else if ($this->lang == "es")
            return $this->subCaption1ES;
    }
    
    public function getSubCaption2() {

        if ($this->lang == "pt")
            return $this->subCaption2PT;
        else if ($this->lang == "en")
            return $this->subCaption2EN;
        else if ($this->lang == "es")
            return $this->subCaption2ES;
    }
    
    public function getSubCaption3() {

        if ($this->lang == "pt")
            return $this->subCaption3PT;
        else if ($this->lang == "en")
            return $this->subCaption3EN;
        else if ($this->lang == "es")
            return $this->subCaption3ES;
    }
    
    public function getSubCaption4() {

        if ($this->lang == "pt")
            return $this->subCaption4PT;
        else if ($this->lang == "en")
            return $this->subCaption4EN;
        else if ($this->lang == "es")
            return $this->subCaption4ES;
    }
}

?>

<?php

/**
 * Construção do Componente por Tipo e Idioma
 *
 * @author Andre Castro
 */
class ITHabitacao extends IT {

    //Padrão
    protected $tituloPT = "Habitação";
    protected $tituloEN = "Housing";
    protected $tituloES = "Vivienda";

    //Tabela
    protected $captionPT = "Indicadores de Habitação";
    protected $captionEN = "Indicators of housing";
    protected $captionES = "Indicadores de vivienda";
    
    //Observação
    protected $obsPT = " *Somente para população urbana";
    protected $obsEN = " *For the urban population only";
    protected $obsES = " *Solo para la población urbana";
    
    public function getObs() {

        if ($this->lang == "pt")
            return $this->obsPT;
        else if ($this->lang == "en")
            return $this->obsEN;
        else if ($this->lang == "es")
            return $this->obsES;
    }

}

?>

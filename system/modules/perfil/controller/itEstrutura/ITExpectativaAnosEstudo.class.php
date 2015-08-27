<?php

/**
 * Construção do Componente por Tipo e Idioma
 *
 * @author Andre Castro
 */
class ITExpectativaAnosEstudo extends IT {

    //Municipio
    //PT
    protected $textoMunPT = "O indicador Expectativa de Anos de Estudo também sintetiza a frequência escolar
        da população em idade escolar. Mais precisamente, indica o número de anos de estudo que uma criança 
        que inicia a vida escolar no ano de referência deverá completar ao atingir a idade de 18 anos.
        Entre 2000 e 2010, ela passou de [e_anosestudo00] anos para [e_anosestudo10] anos, no município, 
        enquanto na UF passou de [ufe_anosestudo00] anos para [ufe_anosestudo10] anos. Em 1991, a expectativa 
        de anos de estudo era de [e_anosestudo91] anos, no município, e de [ufe_anosestudo91] anos, na UF.
            ";
    //EN
    protected $textoMunEN = "The expected years of schooling indicates the number of years that a child who starts his/her school life in the reference year tends to attend.
        In 2010, in [municipio], the expected years of schooling of the population was [e_anosestudo10] years; 
        in 2000, it was [e_anosestudo00] years and, in 1991, [e_anosestudo91] years. 
        The expected years of schooling in [estado_municipio] were [ufe_anosestudo10] years in 2010,
        [ufe_anosestudo00] years in 2000 and [ufe_anosestudo91] years in 1991.
            ";
    //ES
    protected $textoMunES = "Los años de estudio esperados indican el número de años que el niño que comienza la vida escolar en el año de referencia tiende a completar.
        En 2010, [municipio] tenía [e_anosestudo10] años de estudio esperados, mientras que en el 2000 tenía 
        [e_anosestudo00] años y en 1991, [e_anosestudo91] años. 
        En tanto, [estado_municipio] tenía [ufe_anosestudo10] años de estudio esperados en 2010,
        [ufe_anosestudo00] años en el 2000 y [ufe_anosestudo91] años en 1991.
            ";
    //Região Metropolitana
    //PT
    protected $textoRmPT = "
        O indicador Expectativa de Anos de Estudo também sintetiza a frequência escolar da população em idade escolar.
        Mais precisamente, indica o número de anos de estudo que uma criança que inicia a vida escolar no ano de referência
        deverá completar ao atingir a idade de 18 anos.
        Entre 2000 e 2010, a expectativa de anos de estudo passou de [e_anosestudo00] anos para [e_anosestudo10] anos na RM,
        enquanto no Brasil passou de [bre_anosestudo00] anos para [bre_anosestudo10] anos.
            ";

    //EN
    protected $textoRmEN = "The expected years of schooling indicates the number of years that a child who starts his/her school life in the reference year tends to attend.
        In 2010, in [municipio], the expected years of schooling of the population was [e_anosestudo10] years; 
        in 2000, it was [e_anosestudo00] years and, in 1991, [e_anosestudo91] years. 
        The expected years of schooling in Brazil were [ufe_anosestudo10] years in 2010,
        [ufe_anosestudo00] years in 2000 and [ufe_anosestudo91] years in 1991.
            ";
    //ES
    protected $textoRmES = "Los años de estudio esperados indican el número de años que el niño que comienza la vida escolar en el año de referencia tiende a completar.
        En 2010, la [municipio] tenía [e_anosestudo10] años de estudio esperados, mientras que en el 2000 tenía 
        [e_anosestudo00] años y en 1991, [e_anosestudo91] años. 
        En tanto, el Brasil tenía [ufe_anosestudo10] años de estudio esperados en 2010,
        [ufe_anosestudo00] años en el 2000 y [ufe_anosestudo91] años en 1991.
            ";
    //Estado
    //PT
    protected $textoUfPT = "O indicador Expectativa de Anos de Estudo também sintetiza a frequência 
        escolar da população em idade escolar. Mais precisamente, indica o número de anos de estudo 
        que uma criança que inicia a vida escolar no ano de referência deverá completar ao atingir a idade de 18 anos.
        Entre 2000 e 2010, ela passou de [e_anosestudo00] anos para [e_anosestudo10] anos, na UF,
        enquanto no Brasil passou de [bre_anosestudo00] anos para [bre_anosestudo10] anos. Em 1991,
        a expectativa de anos de estudo era de [e_anosestudo91] anos, na UF, e de [bre_anosestudo91] anos no Brasil.";
    //EN
    protected $textoUfEN = "The expected years of schooling indicates the number of years that a child who starts his/her school life in the reference year tends to attend.
        In 2010, in [municipio], the expected years of schooling of the population was [e_anosestudo10] years; 
        in 2000, it was [e_anosestudo00] years and, in 1991, [e_anosestudo91] years. 
        The expected years of schooling in Brazil were [ufe_anosestudo10] years in 2010,
        [ufe_anosestudo00] years in 2000 and [ufe_anosestudo91] years in 1991.
            ";
    //ES
    protected $textoUfES = "Los años de estudio esperados indican el número de años que el niño que comienza la vida escolar en el año de referencia tiende a completar.
        En 2010, [municipio] tenía [e_anosestudo10] años de estudio esperados, mientras que en el 2000 tenía 
        [e_anosestudo00] años y en 1991, [e_anosestudo91] años. 
        En tanto, el Brasil tenía [ufe_anosestudo10] años de estudio esperados en 2010,
        [ufe_anosestudo00] años en el 2000 y [ufe_anosestudo91] años en 1991.
            ";
    //Unidade de Desenvolvimento Humano
    //PT
    protected $textoUdhPT = "O indicador Expectativa de Anos de Estudo também sintetiza a frequência
        escolar da população em idade escolar. Mais precisamente, indica o número de anos de estudo
        que uma criança que inicia a vida escolar no ano de referência deverá completar ao atingir a idade de 18 anos.
        Em 2010, a expectativa de anos de estudo na UDH é de [e_anosestudo10] anos, enquanto no município e na região
        metropolitana onde a UDH está situada ela é de [e_anosestudo10_mun_udh] e [e_anosestudo10_rm_udh] anos, respectivamente.
            ";
    
    //EN
    protected $textoUdhEN = "The expected years of schooling indicates the number of years that a child who starts his/her school life in the reference year tends to attend.
        In 2010, in [municipio], the expected years of schooling of the population was [e_anosestudo10] years; 
        in 2000, it was [e_anosestudo00] years and, in 1991, [e_anosestudo91] years. 
        The expected years of schooling in [estado_municipio] were [ufe_anosestudo10] years in 2010,
        [ufe_anosestudo00] years in 2000 and [ufe_anosestudo91] years in 1991.
            ";
    //ES
    protected $textoUdhES = "Los años de estudio esperados indican el número de años que el niño que comienza la vida escolar en el año de referencia tiende a completar.
        En 2010, [municipio] tenía [e_anosestudo10] años de estudio esperados, mientras que en el 2000 tenía 
        [e_anosestudo00] años y en 1991, [e_anosestudo91] años. 
        En tanto, [estado_municipio] tenía [ufe_anosestudo10] años de estudio esperados en 2010,
        [ufe_anosestudo00] años en el 2000 y [ufe_anosestudo91] años en 1991.
            ";
    //Padrão
    protected $subtituloPT = "Expectativa de Anos de Estudo";
    protected $subtituloEN = "Expected years of schooling";
    protected $subtituloES = "Años de estudio esperados";

}

?>

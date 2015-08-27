<?php

/**
 * Construção do Componente por Tipo e Idioma
 *
 * @author Andre Castro
 */
class ITRanking extends IT {

    //Municipio
    //PT
    protected $textoMunPT = "
            [municipio] ocupa a [ranking_municipio_IDHM]ª posição entre os 5.565 municípios brasileiros segundo o IDHM.
            Nesse ranking, o maior IDHM é [maior_IDHM] ([nome_maior]) e o menor é [menor_IDHM] ([nome_menor]).";
    //EN
    protected $textoMunEN = "Comparing the 5,565 municipalities of Brazil, [municipio] holds the [ranking_municipio_IDHM]th position in 2010, with
            [municipios_melhor_IDHM] ([municipios_melhor_IDHM_p]%) of Brazilian municipalities in a better situation and 
            [municipios_pior_IDHM] ([municipios_pior_IDHM_p]%) of municipalities in the same situation or worse.";
    //ES
    protected $textoMunES = "[municipio] ocupa la posición [ranking_municipio_IDHM]ª en 2010 entre los 5565 municipios de Brasil, 
            a sabiendas de que [municipios_melhor_IDHM] ([municipios_melhor_IDHM_p]%) municipios se encuentran en mejor posición y [municipios_pior_IDHM] ([municipios_pior_IDHM_p]%) municipios
            están en una situación igual o peor.";
    //PT2
    protected $texto2MunPT = "Em relação aos [numero_municipios_estado] outros municípios de [estado_municipio], [municipio] ocupa a
            [ranking_estados_IDHM]ª posição, sendo que [municipios_melhor_IDHM_estado] ([municipios_melhor_IDHM_p_estado]%) municípios estão em situação melhor e [municipios_pior_IDHM_estado] ([municipios_pior_IDHM_p_estado]%) municípios
            estão em situação pior ou igual.";
    //EN2
    protected $texto2MunEN = "Compared to [numero_municipios_estado] other municipalities in [estado_municipio], [municipio] occupies the 
	        [ranking_estados_IDHM]th position, with [municipios_melhor_IDHM_estado] ([municipios_melhor_IDHM_p_estado]%) municipalities are in a better situation and [municipios_pior_IDHM_estado] ([municipios_pior_IDHM_p_estado]%) municipalities  
			are in the same situation or worse.";
    //ES2
    protected $texto2MunES = "En comparación con los otros [numero_municipios_estado] municipios de [estado_municipio], [municipio] ocupa la 
	        [ranking_estados_IDHM]ª posición, con [municipios_melhor_IDHM_estado] ([municipios_melhor_IDHM_p_estado]%)  municipios están en una mejor situación y [municipios_pior_IDHM_estado] ([municipios_pior_IDHM_p_estado]%) municipios 
			están en la misma situación o peor.";
    
    //Região Metropolitana
    //PT
    protected $textoRmPT = "
            [municipio] ocupa a [ranking_municipio_IDHM]ª posição entre as 16 regiões metropolitanas brasileiras segundo o IDHM.
            Nesse ranking, o maior IDHM é [maior_IDHM] ([nome_maior]) e o menor é [menor_IDHM] ([nome_menor]).";
    //EN
    protected $textoRmEN = "Comparing the 36 Metropolitan Region of Brazil, The [municipio] holds the [ranking_municipio_IDHM]th position in 2010, with
            [municipios_melhor_IDHM] ([municipios_melhor_IDHM_p]%) of Brazilian Metropolitan Region in a better situation and 
            [municipios_pior_IDHM] ([municipios_pior_IDHM_p]%) of Metropolitan Region in the same situation or worse.";
			
    //ES
    protected $textoRmES = " El [municipio] ocupa la posición [ranking_municipio_IDHM]ª en 2010 entre los 36 Regiones Metropolitanas de Brasil, 
            a sabiendas de que [municipios_melhor_IDHM] ([municipios_melhor_IDHM_p]%) Regiones Metropolitanas se encuentran en mejor posición y [municipios_pior_IDHM] ([municipios_pior_IDHM_p]%) Regiones Metropolitanas
            están en una situación igual o peor.";
    //PT2
    protected $texto2RmPT = " Em relação as [numero_municipios_estado] outras Regiões Metropolitanas do Brasil, A [municipio] ocupa a
            [ranking_estados_IDHM]ª posição, sendo que [municipios_melhor_IDHM_estado] ([municipios_melhor_IDHM_p_estado]%) Regiões Metropolitanas estão em situação melhor e [municipios_pior_IDHM_estado] ([municipios_pior_IDHM_p_estado]%) Regiões Metropolitanas
            estão em situação pior ou igual.";
			
    //EN2
    protected $texto2RmEN = "Compared to [numero_municipios_estado] other Metropolitan Regions of Brazil, The [municipio] occupies the 
	        [ranking_estados_IDHM]th position, with [municipios_melhor_IDHM_estado] ([municipios_melhor_IDHM_p_estado]%) Metropolitan Regions are in a better situation and [municipios_pior_IDHM_estado] ([municipios_pior_IDHM_p_estado]%) Metropolitan Regions  
			are in the same situation or worse.";
    //ES2
    protected $texto2RmES = "En comparación con las otras [numero_municipios_estado] Regiones Metropolitanas de Brasil, La [municipio] ocupa la 
	        [ranking_estados_IDHM]ª posición, con [municipios_melhor_IDHM_estado] ([municipios_melhor_IDHM_p_estado]%)  Regiones Metropolitanas están en una mejor situación y [municipios_pior_IDHM_estado] ([municipios_pior_IDHM_p_estado]%) Regiones Metropolitanas 
			están en la misma situación o peor.";
    //Estado
    //PT
    protected $textoUfPT = "
            [municipio] ocupa a [ranking_municipio_IDHM]ª posição entre as 27 unidades federativas brasileiras segundo o IDHM.
            Nesse ranking, o maior IDHM é [maior_IDHM] ([nome_maior]) e o menor é [menor_IDHM] ([nome_menor]).";

    //EN
    protected $textoUfEN = "Comparing the 26 states of Brazil, [municipio] holds the [ranking_municipio_IDHM]th position in 2010, with
            [municipios_melhor_IDHM] ([municipios_melhor_IDHM_p]%) of Brazilian states in a better situation and 
            [municipios_pior_IDHM] ([municipios_pior_IDHM_p]%) of states in the same situation or worse.";
    //ES
    protected $textoUfES = "[municipio] ocupa la posición [ranking_municipio_IDHM]ª en 2010 entre los 26 estados de Brasil, 
            a sabiendas de que [municipios_melhor_IDHM] ([municipios_melhor_IDHM_p]%) estados se encuentran en mejor posición y [municipios_pior_IDHM] ([municipios_pior_IDHM_p]%) estados
            están en una situación igual o peor.";
    //PT2
    protected $texto2UfPT = " Em relação aos [numero_municipios_estado] outros estados do Brasil, [municipio] ocupa a
            [ranking_estados_IDHM]ª posição, sendo que [municipios_melhor_IDHM_estado] ([municipios_melhor_IDHM_p_estado]%) estados estão em situação melhor e [municipios_pior_IDHM_estado] ([municipios_pior_IDHM_p_estado]%) estados
            estão em situação pior ou igual.";
    //EN2
    protected $texto2UfEN = "Compared to [numero_municipios_estado] other states of Brazil, [municipio] occupies the 
	        [ranking_estados_IDHM]th position, with [municipios_melhor_IDHM_estado] ([municipios_melhor_IDHM_p_estado]%) states are in a better situation and [municipios_pior_IDHM_estado] ([municipios_pior_IDHM_p_estado]%) states  
			are in the same situation or worse.";
    //ES2
    protected $texto2UfES = "En comparación con los otros [numero_municipios_estado] estados de Brasil, [municipio] ocupa la 
	        [ranking_estados_IDHM]ª posición, con [municipios_melhor_IDHM_estado] ([municipios_melhor_IDHM_p_estado]%)  estados están en una mejor situación y [municipios_pior_IDHM_estado] ([municipios_pior_IDHM_p_estado]%) estados 
			están en la misma situación o peor.";
			
    //Unidade de Desenvolvimento Humano
    //PT
//    protected $textoUdhPT = "[municipio] ocupa a [ranking_municipio_IDHM]ª posição, em 2010, em relação as 623 Unidades de Desenvolvimento Humano do Brasil, 
//            sendo que [municipios_melhor_IDHM] ([municipios_melhor_IDHM_p]%) Unidades de Desenvolvimento Humano estão em situação melhor e [municipios_pior_IDHM] ([municipios_pior_IDHM_p]%) Unidades de Desenvolvimento Humano
//            estão em situação igual ou pior.";
    
     protected $textoUdhPT = "A UDH ocupa a [ranking_udh_IDHM]ª posição entre as [count_udh] UDHs da [rm_udh], segundo o valor do IDHM.
         Nesse ranking, o maior índice é [maior_idhm_udh], encontrado na UDH [nome_maior_udh], e o menor, [menor_idhm_udh], observado na UDH [nome_menor_udh].<br><br>
         
         No caso do índice da dimensão Longevidade, a UDH ocupa a [ranking_udh_IDHM_L]ª posição no ranking das UDHs da RM, no qual o maior e o menor valores são,
         respectivamente, [maior_idhm_udh_L], observado na UDH [nome_maior_udh_L] e [menor_idhm_udh_L], na UDH [nome_menor_udh_L].<br><br>
         
         No tocante à dimensão Educação, a UDH está na [ranking_udh_IDHM_E]ª posição do ranking, que tem como valores máximo e mínimo [maior_idhm_udh_E], na UDH [nome_maior_udh_E],
         e [menor_idhm_udh_E], na UDH [nome_menor_udh_E], respectivamente.<br><br>
         
         Quanto à dimensão Renda, a UDH ocupa a [ranking_udh_IDHM_R]ª posição, sendo [maior_idhm_udh_R] o maior índice, observado na UDH [nome_maior_udh_R], e [menor_idhm_udh_R] o menor índice,
         encontrado na UDH [nome_menor_udh_R].";

    //EN
    protected $textoUdhEN = "Comparing the 623 Human Development Units of Brazil, [municipio] holds the [ranking_municipio_IDHM]th position in 2010, with
            [municipios_melhor_IDHM] ([municipios_melhor_IDHM_p]%) of Brazilian Human Development Units in a better situation and 
            [municipios_pior_IDHM] ([municipios_pior_IDHM_p]%) of Human Development Units in the same situation or worse.";
    //ES
    protected $textoUdhES = "[municipio] ocupa la posición [ranking_municipio_IDHM]ª en 2010 entre las 623 Unidades de Desarrollo Humano de Brasil, 
            a sabiendas de que [municipios_melhor_IDHM] ([municipios_melhor_IDHM_p]%) Unidades de Desarrollo Humano se encuentran en mejor posición y [municipios_pior_IDHM] ([municipios_pior_IDHM_p]%) Unidades de Desarrollo Humano
            están en una situación igual o peor.";
    //PT2
    protected $texto2UdhPT = "Em relação as [numero_municipios_estado] outras Unidades de Desenvolvimento Humano de [estado_municipio], [municipio] ocupa a
            [ranking_estados_IDHM]ª posição, sendo que [municipios_melhor_IDHM_estado] ([municipios_melhor_IDHM_p_estado]%) Unidades de Desenvolvimento Humano estão em situação melhor e [municipios_pior_IDHM_estado] ([municipios_pior_IDHM_p_estado]%) Unidades de Desenvolvimento Humano
            estão em situação pior ou igual.";
    //EN2
    protected $texto2UdhEN = "Compared to [numero_municipios_estado] other Human Development Units in [estado_municipio], [municipio] occupies the 
	        [ranking_estados_IDHM]th position, with [municipios_melhor_IDHM_estado] ([municipios_melhor_IDHM_p_estado]%) Human Development Units are in a better situation and [municipios_pior_IDHM_estado] ([municipios_pior_IDHM_p_estado]%) Human Development Units  
			are in the same situation or worse.";
    //ES2
    protected $texto2UdhES = "En comparación con las otras [numero_municipios_estado] Unidades de Desarrollo Humano de [estado_municipio], [municipio] ocupa la 
	        [ranking_estados_IDHM]ª posición, con [municipios_melhor_IDHM_estado] ([municipios_melhor_IDHM_p_estado]%)  Unidades de Desarrollo Humano están en una mejor situación y [municipios_pior_IDHM_estado] ([municipios_pior_IDHM_p_estado]%) Unidades de Desarrollo Humano 
			están en la misma situación o peor.";
    
    //Padrão
    protected $subtituloPT = "Ranking";
    protected $subtituloEN = "Ranking";
    protected $subtituloES = "Ranking";}

?>

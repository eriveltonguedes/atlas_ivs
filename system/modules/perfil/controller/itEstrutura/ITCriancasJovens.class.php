<?php

/**
 * Construção do Crianças e Jovens por Tipo e Idioma
 *
 * @author Andre Castro
 */
class ITCriancasJovens extends IT {

    //Municipio
    //PT
    protected $textoMunPT = "<br>Proporções de crianças e jovens frequentando ou tendo completado determinados ciclos indica a situação da educação entre a 
        população em idade escolar do estado e compõe o IDHM Educação. 
        
        No município, a proporção de crianças de 5 a 6 anos na escola é de [t_freq5a6_10]%,
        em 2010. No mesmo ano, a proporção de crianças de 11 a 13 anos frequentando os anos
        finais do ensino fundamental é de [t_fund11a13_10]%; a proporção de jovens de 15 a 17 anos
        com ensino fundamental completo é de [t_fund15a17_10]%; e a proporção de jovens de 18 a 20 anos
        com ensino médio completo é de [t_med18a20_10]%. Entre 1991 e 2010, essas proporções aumentaram,
        respectivamente, em [getCrescimento5a6Esc9110] pontos percentuais,
        [getCrescimento11a13Esc9110] pontos percentuais, [getCrescimento15a17Fund9110] pontos percentuais
        e [getCrescimento18a20Medio9110] pontos percentuais.";
    //EN
    protected $textoMunEN = "<br>The share of children and young people attending school or having completed the given educational grades indicates the state of education among the school-age population of a municipality – and hence, it is part of MHDI Education.. 
        <br><br>In 2000-2010 the share of <b>children aged 5 to 6 years attending school</b>
        and grew [cresc_4-6esc_0010]% and, in 1991- 2000,
        [cresc_4-6esc_9100]%. The share of <b>children aged 11 to 13 years attending the final years of primary education
        </b> grew [cresc_12-14esc_0010]%
        between 2000 and 2010, and [cresc_12-14esc_9100]% between 1991 and 2000. 
        
        <br><br>The share of <b>young people aged between 15 to 17 years having completed primary education</b>
        increased by [cresc_16-18fund_0010]% between 2000 and 2010 and by
        [cresc_16-18fund_9100]% between 1991 and 2000. And the share of <b>young people aged between 18 and 20 years having completed secondary education</b>
        grew [cresc_19-21medio_0010]%
        between 2000 and 2010, and [cresc_19-21medio_9100]% between 1991 and 2000.";
    //ES
    protected $textoMunES = "<br>La proporción de niños y jóvenes que cursan o terminaron determinados ciclos refleja la situación de la educación entre la población en edad escolar del municipio y compone el IDHM Educación. 
        <br><br>Entre el 2000 y 2010, la proporción de <b>niños de 5 a 6 años que van a la escuela</b> aumentó un [cresc_4-6esc_0010]% y entre 1991 y el 2000
        un [cresc_4-6esc_9100]%. La proporción de <b>niños de 11 a 13 años que cursa los últimos años de la educación primaria</b> aumentó un [cresc_12-14esc_0010]%
        entre el 2000 y 2010 y un [cresc_12-14esc_9100]% entre 1991 y el 2000. 
        
        <br><br>La proporción de <b>jóvenes de 15 a 17 años con educación primaria completa</b> aumentó un [cresc_16-18fund_0010]% entre el 2000 y 2010 y un
        [cresc_16-18fund_9100]% entre 1991 y el 2000. Y la proporción de <b>jóvenes de entre 18 y 20 años con educación secundaria completa</b> aumentó un [cresc_19-21medio_0010]%
        entre el 2000 y 2010 y un [cresc_19-21medio_9100]% entre 1991 y el 2000.";
    //Municipio2
    //PT2
    protected $texto2MunPT = "
        Em 2010, [tx_fund_sematraso_10]% da população de 6 a 17
        anos do município estavam cursando o ensino básico regular com até dois anos de defasagem
        idade-série. Em 2000 eram [tx_fund_sematraso_00]% e, em 1991, [tx_fund_sematraso_91]%.<br><br>
        Dos jovens adultos de 18 a 24 anos, [t_flsuper_10]% estavam cursando o ensino superior em 2010. Em 2000
        eram [t_flsuper_00]% e, em 1991, [t_flsuper_91]%.";
    //EN2
    protected $texto2MunEN = "<br>In 2010, [tx_fund_sematraso_10]% of the students aged between 6 and 14 years of [municipio]
        attended primary school regularly, in grades appropriate to their age.
        In 2000, this percentage was [tx_fund_sematraso_00]% and in 1991
        [tx_fund_sematraso_91]%.
        [tx_medio_sematraso_10]% of young people aged15 to 17 years who were attending school regularly, without educational delays.
        In 2000, the percentage was [tx_medio_sematraso_00]% and, in 1991, [tx_medio_sematraso_91]%. 
        [t_flsuper_10]% of students aged 18 to 24 years were attending higher education in 2010,
        [t_flsuper_00]% in 2000 and [t_flsuper_91]% in 1991.
        <br><br>
        It is noteworthy that, in 2010, [p6a14]% of the children aged 6 to14 years did not attend school.
        Among young people aged 15 to 17 years, the percentage reached [p15a17]%.";
    //ES2
    protected $texto2MunES = "<br>En 2010, el [tx_fund_sematraso_10]% de los estudiantes de [municipio] entre 6 y 14 años cursaban la educación primaria regular en el nivel adecuado para su edad.
        En el 2000 eran un [tx_fund_sematraso_00]% y en 1991, un
        [tx_fund_sematraso_91]%. Entre los jóvenes de 15 a 17 años, el [tx_medio_sematraso_10]% cursaba la educación secundaria regular sin retraso.
        En el 2000 eran un [tx_medio_sematraso_00]% y en 1991, un [tx_medio_sematraso_91]%. 
        Ente los alumnos de 18 a 24 años, un [t_flsuper_10]% cursaba la educación superior en 2010, un [t_flsuper_00]% % la cursaba en el 2000 y un [t_flsuper_91]% la cursaba en 1991.
        <br><br>
        Nótese que, en 2010, el [p6a14]% de los niños de 6 a 14 años no iba a la escuela, porcentaje que, entre los jóvenes de 15 a 17 años ascendía a un [p15a17]%.";
    //Região Metropolitana
    //PT
    protected $textoRmPT = "<br>Proporções de crianças e jovens frequentando ou tendo completado determinados ciclos indica a situação da educação entre a 
        população em idade escolar da RM e compõe o IDHM Educação. 
        
        Na RM, a proporção de crianças de 5 a 6 anos na escola é de [t_freq5a6_10]%,
        em 2010. No mesmo ano, a proporção de crianças de 11 a 13 anos frequentando os anos
        finais do ensino fundamental é de [t_fund11a13_10]%; a proporção de jovens de 15 a 17 anos
        com ensino fundamental completo é de [t_fund15a17_10]%; e a proporção de jovens de 18 a 20 anos
        com ensino médio completo é de [t_med18a20_10]%. 
        
        Entre 2000 e 2010, essas proporções aumentaram,
        respectivamente, em [getCrescimento5a6Esc0010] pontos percentuais,
        [getCrescimento11a13Esc0010] pontos percentuais, [getCrescimento15a17Fund0010] pontos percentuais
        e [getCrescimento18a20Medio0010] pontos percentuais.";
    //EN
    protected $textoRmEN = "<br>The share of children and young people attending school or having completed the given educational grades indicates the state of education among the school-age population of the metropolitan area – and hence, it is part of MHDI Education.. 
        <br><br>In 2000-2010 the share of <b>children aged 5 to 6 years attending school</b>
        and grew [cresc_4-6esc_0010]% and, in 1991- 2000,
        [cresc_4-6esc_9100]%. The share of <b>children aged 11 to 13 years attending the final years of primary education
        </b> grew [cresc_12-14esc_0010]%
        between 2000 and 2010, and [cresc_12-14esc_9100]% between 1991 and 2000. 
        
        <br><br>The share of <b>young people aged between 15 to 17 years having completed primary education</b>
        increased by [cresc_16-18fund_0010]% between 2000 and 2010 and by
        [cresc_16-18fund_9100]% between 1991 and 2000. And the share of <b>young people aged between 18 and 20 years having completed secondary education</b>
        grew [cresc_19-21medio_0010]%
        between 2000 and 2010, and [cresc_19-21medio_9100]% between 1991 and 2000.";
    //ES
    protected $textoRmES = "<br>La proporción de niños y jóvenes que cursan o terminaron determinados ciclos refleja la situación de la educación entre la población en edad escolar de la zona metropolitana  y compone el IDHM Educación. 
        <br><br>Entre el 2000 y 2010, la proporción de <b>niños de 5 a 6 años que van a la escuela</b> aumentó un [cresc_4-6esc_0010]% y entre 1991 y el 2000
        un [cresc_4-6esc_9100]%. La proporción de <b>niños de 11 a 13 años que cursa los últimos años de la educación primaria</b> aumentó un [cresc_12-14esc_0010]%
        entre el 2000 y 2010 y un [cresc_12-14esc_9100]% entre 1991 y el 2000. 
        
        <br><br>La proporción de <b>jóvenes de 15 a 17 años con educación primaria completa</b> aumentó un [cresc_16-18fund_0010]% entre el 2000 y 2010 y un
        [cresc_16-18fund_9100]% entre 1991 y el 2000. Y la proporción de <b>jóvenes de entre 18 y 20 años con educación secundaria completa</b> aumentó un [cresc_19-21medio_0010]%
        entre el 2000 y 2010 y un [cresc_19-21medio_9100]% entre 1991 y el 2000.";
    //Região Metropolitana2
    //PT2
    protected $texto2RmPT = "
        Em 2010, [tx_fund_sematraso_10]% da população de 6 a 17
        anos da RM estavam cursando o ensino básico regular com até dois anos de defasagem
        idade-série. Em 2000 eram [tx_fund_sematraso_00]%.<br><br>
        Dos jovens adultos de 18 a 24 anos, [t_flsuper_10]% estavam cursando o ensino superior em 2010. Em 2000
        eram [t_flsuper_00]%.";
    //EN2
    protected $texto2RmEN = "<br>In 2010, [tx_fund_sematraso_10]% of the students aged between 6 and 14 years the [municipio]
        attended primary school regularly, in grades appropriate to their age.
        In 2000, this percentage was [tx_fund_sematraso_00]% and in 1991
        [tx_fund_sematraso_91]%.
        [tx_medio_sematraso_10]% of young people aged15 to 17 years who were attending school regularly, without educational delays.
        In 2000, the percentage was [tx_medio_sematraso_00]% and, in 1991, [tx_medio_sematraso_91]%. 
        [t_flsuper_10]% of students aged 18 to 24 years were attending higher education in 2010,
        [t_flsuper_00]% in 2000 and [t_flsuper_91]% in 1991.
        <br><br>
        It is noteworthy that, in 2010, [p6a14]% of the children aged 6 to14 years did not attend school.
        Among young people aged 15 to 17 years, the percentage reached [p15a17]%.";
    //ES2
    protected $texto2RmES = "<br>En 2010, el [tx_fund_sematraso_10]% de los estudiantes la [municipio] entre 6 y 14 años cursaban la educación primaria regular en el nivel adecuado para su edad.
        En el 2000 eran un [tx_fund_sematraso_00]% y en 1991, un
        [tx_fund_sematraso_91]%. Entre los jóvenes de 15 a 17 años, el [tx_medio_sematraso_10]% cursaba la educación secundaria regular sin retraso.
        En el 2000 eran un [tx_medio_sematraso_00]% y en 1991, un [tx_medio_sematraso_91]%. 
        Ente los alumnos de 18 a 24 años, un [t_flsuper_10]% cursaba la educación superior en 2010, un [t_flsuper_00]% % la cursaba en el 2000 y un [t_flsuper_91]% la cursaba en 1991.
        <br><br>
        Nótese que, en 2010, el [p6a14]% de los niños de 6 a 14 años no iba a la escuela, porcentaje que, entre los jóvenes de 15 a 17 años ascendía a un [p15a17]%.";
    //Estado
    //PT
    protected $textoUfPT = "<br>Proporções de crianças e jovens frequentando ou tendo completado determinados ciclos indica a situação da educação entre a 
        população em idade escolar do estado e compõe o IDHM Educação. 
        
        Na UF, a proporção de crianças de 5 a 6 anos na escola é de [t_freq5a6_10]%,
        em 2010. No mesmo ano, a proporção de crianças de 11 a 13 anos frequentando os anos
        finais do ensino fundamental é de [t_fund11a13_10]%; a proporção de jovens de 15 a 17 anos
        com ensino fundamental completo é de [t_fund15a17_10]%; e a proporção de jovens de 18 a 20 anos
        com ensino médio completo é de [t_med18a20_10]%. Entre 1991 e 2010, essas proporções aumentaram,
        respectivamente, em [getCrescimento5a6Esc9110] pontos percentuais,
        [getCrescimento11a13Esc9110] pontos percentuais, [getCrescimento15a17Fund9110] pontos percentuais
        e [getCrescimento18a20Medio9110] pontos percentuais.";
        
//        <br><br>No período de 2000 a 2010, a proporção de <b>crianças de 5 a 6 anos na escola</b> cresceu [cresc_4-6esc_0010]% e no de período 1991 a 2000,
//        [cresc_4-6esc_9100]%. A proporção de <b>crianças de 11 a 13 anos frequentando os anos finais do ensino fundamental</b> cresceu [cresc_12-14esc_0010]%
//        entre 2000 e 2010 e [cresc_12-14esc_9100]%  entre 1991 e 2000. 
//        
//        <br><br>A proporção de <b>jovens entre 15 e 17 anos com ensino fundamental completo</b> cresceu [cresc_16-18fund_0010]% no período de 2000 a 2010 e
//        [cresc_16-18fund_9100]% no período de 1991 a 2000. E a proporção de <b>jovens entre 18 e 20 anos com ensino médio completo</b> cresceu [cresc_19-21medio_0010]%
//        entre 2000 e 2010 e [cresc_19-21medio_9100]% entre 1991 e 2000.";
    //EN
    protected $textoUfEN = "<br>The share of children and young people attending school or having completed the given educational grades indicates the state of education among the school-age population of a state – and hence, it is part of HDI Education.. 
        <br><br>In 2000-2010 the share of <b>children aged 5 to 6 years attending school</b>
        and grew [cresc_4-6esc_0010]% and, in 1991- 2000,
        [cresc_4-6esc_9100]%. The share of <b>children aged 11 to 13 years attending the final years of primary education
        </b> grew [cresc_12-14esc_0010]%
        between 2000 and 2010, and [cresc_12-14esc_9100]% between 1991 and 2000. 
        
        <br><br>The share of <b>young people aged between 15 to 17 years having completed primary education</b>
        increased by [cresc_16-18fund_0010]% between 2000 and 2010 and by
        [cresc_16-18fund_9100]% between 1991 and 2000. And the share of <b>young people aged between 18 and 20 years having completed secondary education</b>
        grew [cresc_19-21medio_0010]%
        between 2000 and 2010, and [cresc_19-21medio_9100]% between 1991 and 2000.";
    //ES
    protected $textoUfES = "<br>La proporción de niños y jóvenes que cursan o terminaron determinados ciclos refleja la situación de la educación entre la población en edad escolar del estado y compone el IDH Educación. 
        <br><br>Entre el 2000 y 2010, la proporción de <b>niños de 5 a 6 años que van a la escuela</b> aumentó un [cresc_4-6esc_0010]% y entre 1991 y el 2000
        un [cresc_4-6esc_9100]%. La proporción de <b>niños de 11 a 13 años que cursa los últimos años de la educación primaria</b> aumentó un [cresc_12-14esc_0010]%
        entre el 2000 y 2010 y un [cresc_12-14esc_9100]% entre 1991 y el 2000. 
        
        <br><br>La proporción de <b>jóvenes de 15 a 17 años con educación primaria completa</b> aumentó un [cresc_16-18fund_0010]% entre el 2000 y 2010 y un
        [cresc_16-18fund_9100]% entre 1991 y el 2000. Y la proporción de <b>jóvenes de entre 18 y 20 años con educación secundaria completa</b> aumentó un [cresc_19-21medio_0010]%
        entre el 2000 y 2010 y un [cresc_19-21medio_9100]% entre 1991 y el 2000.";
    //Estado2
    //PT2
    protected $texto2UfPT = "
        Em 2010, [tx_fund_sematraso_10]% da população de 6 a 17
        anos da UF estavam cursando o ensino básico regular com até dois anos de defasagem
        idade-série. Em 2000 eram [tx_fund_sematraso_00]% e, em 1991, [tx_fund_sematraso_91]%.<br><br>
        Dos jovens adultos de 18 a 24 anos, [t_flsuper_10]% estavam cursando o ensino superior em 2010. Em 2000
        eram [t_flsuper_00]% e, em 1991, [t_flsuper_91]%.";


//<br>Em 2010, [tx_fund_sematraso_10]%  dos alunos entre 6 e 14 anos de [municipio] estavam cursando
//        o ensino fundamental regular  na série correta para a idade. Em 2000 eram [tx_fund_sematraso_00]%  e, em 1991,
//        [tx_fund_sematraso_91]%. Entre os jovens de 15 a 17 anos, [tx_medio_sematraso_10]% estavam cursando o ensino médio regular sem atraso.
//        Em 2000 eram [tx_medio_sematraso_00]% e, em 1991, [tx_medio_sematraso_91]%. 
//        Entre os alunos de 18 a 24 anos, [t_flsuper_10]% estavam cursando o ensino superior em 2010, [t_flsuper_00]% em 2000 e [t_flsuper_91]% em 1991.
//        <br><br>
//        Nota-se que, em 2010 , [p6a14]% das crianças de 6 a 14 anos não frequentavam a escola, percentual que,
//        entre os jovens de 15 a 17 anos atingia [p15a17]%.";
    //EN2
    protected $texto2UfEN = "<br>In 2010, [tx_fund_sematraso_10]% of the students aged between 6 and 14 years of [municipio]
        attended primary school regularly, in grades appropriate to their age.
        In 2000, this percentage was [tx_fund_sematraso_00]% and in 1991
        [tx_fund_sematraso_91]%.
        [tx_medio_sematraso_10]% of young people aged15 to 17 years who were attending school regularly, without educational delays.
        In 2000, the percentage was [tx_medio_sematraso_00]% and, in 1991, [tx_medio_sematraso_91]%. 
        [t_flsuper_10]% of students aged 18 to 24 years were attending higher education in 2010,
        [t_flsuper_00]% in 2000 and [t_flsuper_91]% in 1991.
        <br><br>
        It is noteworthy that, in 2010, [p6a14]% of the children aged 6 to14 years did not attend school.
        Among young people aged 15 to 17 years, the percentage reached [p15a17]%.";
    //ES2
    protected $texto2UfES = "<br>En 2010, el [tx_fund_sematraso_10]% de los estudiantes de [municipio] entre 6 y 14 años cursaban la educación primaria regular en el nivel adecuado para su edad.
        En el 2000 eran un [tx_fund_sematraso_00]% y en 1991, un
        [tx_fund_sematraso_91]%. Entre los jóvenes de 15 a 17 años, el [tx_medio_sematraso_10]% cursaba la educación secundaria regular sin retraso.
        En el 2000 eran un [tx_medio_sematraso_00]% y en 1991, un [tx_medio_sematraso_91]%. 
        Ente los alumnos de 18 a 24 años, un [t_flsuper_10]% cursaba la educación superior en 2010, un [t_flsuper_00]% % la cursaba en el 2000 y un [t_flsuper_91]% la cursaba en 1991.
        <br><br>
        Nótese que, en 2010, el [p6a14]% de los niños de 6 a 14 años no iba a la escuela, porcentaje que, entre los jóvenes de 15 a 17 años ascendía a un [p15a17]%.";
    //Unidade de Desenvolvimento Humano
    //PT
    protected $textoUdhPT = "<br>Proporções de crianças e jovens frequentando ou tendo completado determinados
             ciclos indicam a situação da frequência escolar entre a população em idade escolar e constituem
             um dos componentes do IDHM Educação. Na UDH, a proporção de crianças de 5 a 6 anos na escola é de
             [t_freq5a6_10]%, em 2010. No mesmo ano, a proporção de crianças de 11 a 13 anos frequentando os
             anos finais do ensino fundamental é de [t_fund11a13_10]%; a proporção de jovens de 15 a 17 anos
             com ensino fundamental completo é de [t_fund15a17_10]%; e a proporção de jovens de 18 a 20 anos
             com ensino médio completo é de [t_med18a20_10]%.";
    //EN
    protected $textoUdhEN = "<br>The share of children and young people attending school or having completed the given educational grades indicates the state of education among the school-age population of the Unit for Human Development – and hence, it is part of HDI Education.. 
        <br><br>In 2000-2010 the share of <b>children aged 5 to 6 years attending school</b>
        and grew [cresc_4-6esc_0010]% and, in 1991- 2000,
        [cresc_4-6esc_9100]%. The share of <b>children aged 11 to 13 years attending the final years of primary education
        </b> grew [cresc_12-14esc_0010]%
        between 2000 and 2010, and [cresc_12-14esc_9100]% between 1991 and 2000. 
        
        <br><br>The share of <b>young people aged between 15 to 17 years having completed primary education</b>
        increased by [cresc_16-18fund_0010]% between 2000 and 2010 and by
        [cresc_16-18fund_9100]% between 1991 and 2000. And the share of <b>young people aged between 18 and 20 years having completed secondary education</b>
        grew [cresc_19-21medio_0010]%
        between 2000 and 2010, and [cresc_19-21medio_9100]% between 1991 and 2000.";
    //ES
    protected $textoUdhES = "<br>La proporción de niños y jóvenes que cursan o terminaron determinados ciclos refleja la situación de la educación entre la población en edad escolar de la Unidad de Desarrollo Humano y compone el IDH Educación. 
        <br><br>Entre el 2000 y 2010, la proporción de <b>niños de 5 a 6 años que van a la escuela</b> aumentó un [cresc_4-6esc_0010]% y entre 1991 y el 2000
        un [cresc_4-6esc_9100]%. La proporción de <b>niños de 11 a 13 años que cursa los últimos años de la educación primaria</b> aumentó un [cresc_12-14esc_0010]%
        entre el 2000 y 2010 y un [cresc_12-14esc_9100]% entre 1991 y el 2000. 
        
        <br><br>La proporción de <b>jóvenes de 15 a 17 años con educación primaria completa</b> aumentó un [cresc_16-18fund_0010]% entre el 2000 y 2010 y un
        [cresc_16-18fund_9100]% entre 1991 y el 2000. Y la proporción de <b>jóvenes de entre 18 y 20 años con educación secundaria completa</b> aumentó un [cresc_19-21medio_0010]%
        entre el 2000 y 2010 y un [cresc_19-21medio_9100]% entre 1991 y el 2000.";
    //Unidade de Desenvolvimento Humano2
    //PT2
    protected $texto2UdhPT = "
        Em 2010, [tx_fund_sematraso_10]% da população de 6 a 17
        anos da UDH estavam cursando o ensino básico regular com até dois anos de defasagem
        idade-série. Dos jovens adultos de 18 a 24 anos,
        [t_flsuper_10]% estavam cursando o ensino superior no mesmo ano.";
    //EN2
    protected $texto2UdhEN = "<br>In 2010, [tx_fund_sematraso_10]% of the students aged between 6 and 14 years of [municipio]
        attended primary school regularly, in grades appropriate to their age.
        In 2000, this percentage was [tx_fund_sematraso_00]% and in 1991
        [tx_fund_sematraso_91]%.
        [tx_medio_sematraso_10]% of young people aged15 to 17 years who were attending school regularly, without educational delays.
        In 2000, the percentage was [tx_medio_sematraso_00]% and, in 1991, [tx_medio_sematraso_91]%. 
        [t_flsuper_10]% of students aged 18 to 24 years were attending higher education in 2010,
        [t_flsuper_00]% in 2000 and [t_flsuper_91]% in 1991.
        <br><br>
        It is noteworthy that, in 2010, [p6a14]% of the children aged 6 to14 years did not attend school.
        Among young people aged 15 to 17 years, the percentage reached [p15a17]%.";
    //ES2
    protected $texto2UdhES = "<br>En 2010, el [tx_fund_sematraso_10]% de los estudiantes de [municipio] entre 6 y 14 años cursaban la educación primaria regular en el nivel adecuado para su edad.
        En el 2000 eran un [tx_fund_sematraso_00]% y en 1991, un
        [tx_fund_sematraso_91]%. Entre los jóvenes de 15 a 17 años, el [tx_medio_sematraso_10]% cursaba la educación secundaria regular sin retraso.
        En el 2000 eran un [tx_medio_sematraso_00]% y en 1991, un [tx_medio_sematraso_91]%. 
        Ente los alumnos de 18 a 24 años, un [t_flsuper_10]% cursaba la educación superior en 2010, un [t_flsuper_00]% % la cursaba en el 2000 y un [t_flsuper_91]% la cursaba en 1991.
        <br><br>
        Nótese que, en 2010, el [p6a14]% de los niños de 6 a 14 años no iba a la escuela, porcentaje que, entre los jóvenes de 15 a 17 años ascendía a un [p15a17]%.";
    
    //Padrão
    protected $tituloPT = "Educação";
    protected $subtituloPT = "Crianças e Jovens";
    protected $tituloEN = "Education";
    protected $subtituloEN = "Children and young people";
    protected $tituloES = "Educación";
    protected $subtituloES = "Niños y jóvenes";

    function getChartFluxoEscolar($idMunicipio) {

        //$chart = new FunctionsChart();

        $freq_esc_5a6 = json_encode($this->chart->getFreqEscolar5a6($idMunicipio, $this->lang));
        $freq_esc_11a13 = json_encode($this->chart->getFreqEscolar11a13($idMunicipio, $this->lang));
        $freq_esc_15a17 = json_encode($this->chart->getFreqEscolar15a17($idMunicipio, $this->lang));
        $freq_esc_18a20 = json_encode($this->chart->getFreqEscolar18a20($idMunicipio, $this->lang));

        echo "<script language='javascript' type='text/javascript'>
                graficoFluxoEscolar('" . $this->lang . "','" . $this->type . "');</script>";

        return "<div id='chartFluxoEscolar' style='width: 100%; height: 600px;'>            
                <input id='freq_esc_5a6' type='hidden' value=' " . $freq_esc_5a6 . "' /> 
                <input id='freq_esc_11a13' type='hidden' value='" . $freq_esc_11a13 . "' />
                <input id='freq_esc_15a17' type='hidden' value='" . $freq_esc_15a17 . "' /> 
                <input id='freq_esc_18a20' type='hidden' value='" . $freq_esc_18a20 . "' />  
             </div>";
    }
    
    function getChartFrequenciaEscolar($idMunicipio) {
        
        //$chart = new FunctionsChart();

        $freq_esc_mun = json_encode($this->chart->getFreqEscolarFaixaEtariaMun($idMunicipio, $this->lang));
        
        if ($this->type != "perfil_rm" && $this->type != "perfil_uf")            
            $freq_esc_uf = json_encode($this->chart->getFreqEscolarFaixaEtariaEstado($idMunicipio));
        else            
            $freq_esc_uf = "";
        
        $freq_esc_pais = json_encode($this->chart->getFreqEscolarFaixaEtariaBrasil($idMunicipio));

        echo "<script language='javascript' type='text/javascript'>
            graficoFrequenciaEscolar('" . $this->lang . "','" . $this->type . "');</script>";

        return "<div id='chartFrequenciaEscolar' style='width: 100%; height: 600px;'>            
                <input id='freq_esc_mun' type='hidden' value=' " . $freq_esc_mun . "' /> 
                <input id='freq_esc_uf' type='hidden' value='" . $freq_esc_uf . "' />
                <input id='freq_esc_pais' type='hidden' value='" . $freq_esc_pais . "' /> 
             </div>";
    }
    
    function getChartFrequenciaDe6a14($idMunicipio) {

        //$chart = new FunctionsChart();

        $freq_esc_6a14 = json_encode($this->chart->getFrequenciaEscolar6a14Anos($idMunicipio));

        echo "<script language='javascript' type='text/javascript'>
                graficoFrequenciaEscolarDe6a14Anos('" . $this->lang . "','" . $this->type . "');</script>";

        return "<div id='chart_freq' style='width: 100%; height: 400px; '> 
                    <div id='chart_freq_6a14' style='width: 100%; height: 360px; float:left;' >
                        <input id='freq_esc_6a14' type='hidden' value=' " . $freq_esc_6a14 . "' /> 
                    </div>
             </div>";
    }

    function getChartFrequenciaDe15a17($idMunicipio){

        //$chart = new FunctionsChart();

        $freq_esc_15a17 = json_encode($this->chart->getFrequenciaEscolar15a17Anos($idMunicipio));

        echo "<script language='javascript' type='text/javascript'>
                graficoFrequenciaEscolarDe15a17Anos('" . $this->lang . "','" . $this->type . "');</script>";
        
        return "<div id='chart_freq' style='width: 100%; height: 400px; '> 
                    <div id='chart_freq_15a17' style='width: 100%; height: 360px; float:left;' >
                        <input id='freq_esc_15a17' type='hidden' value='" . $freq_esc_15a17 . "' />
                    </div>
             </div>";
    }

    function getChartFrequenciaDe18a24($idMunicipio) {

        //$chart = new FunctionsChart();

        $freq_esc_18a24 = json_encode($this->chart->getFrequenciaEscolar18a24Anos($idMunicipio));

        echo "<script language='javascript' type='text/javascript'>
                graficoFrequenciaEscolarDe18a24Anos('" . $this->lang . "','" . $this->type . "');</script>";
  
        return "<div id='chart_freq' style='width: 100%; height: 420px;'> 
                    <div id='chart_freq_18a24' style='width: 100%; height: 360px; float:left;' >
                        <input id='freq_esc_18a24' type='hidden' value='" . $freq_esc_18a24 . "' />
                    </div>
             </div>";
    }



}

?>

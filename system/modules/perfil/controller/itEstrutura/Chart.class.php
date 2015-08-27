<?php

class Chart {

    //Variâncias
    protected $id;
    protected $espacialidade;
    protected $valor_variavel;
    protected $fk;
    protected $type;

    public function __construct($type) {

        $this->type = $type;

        if ($this->type == "perfil_m") {
            $this->espacialidade = "municipio";
            $this->valor_variavel = "valor_variavel_mun";
            $this->fk = "fk_municipio";
        } else if ($this->type == "perfil_rm") {
            $this->espacialidade = "rm";
            $this->valor_variavel = "valor_variavel_rm";
            $this->fk = "fk_rm";
        } else if ($this->type == "perfil_uf") {//@#AINDA ESTÁ COM VALORES MUNICIPIO
            $this->espacialidade = "estado";
            $this->valor_variavel = "valor_variavel_estado";
            $this->fk = "fk_estado";
        } else if ($this->type == "perfil_udh") {
            $this->espacialidade = "udh";
            $this->valor_variavel = "valor_variavel_udh";
            $this->fk = "fk_udh";
        }
    }

    //Gráfico Desenvolvimento HUMANO IDHM ---------------------------------------------------------------------------------------
//    function getRenda($idMunicipio) {
//        $SQL_RENDA = "SELECT replace(replace(municipio.nome,'''','&#39;'),'''','&#39;') as nome,label_ano_referencia, nomecurto, valor
//            FROM valor_variavel_mun INNER JOIN variavel
//            ON fk_variavel = variavel.id
//            INNER JOIN ano_referencia
//            ON ano_referencia.id = fk_ano_referencia
//            INNER JOIN municipio
//            ON fk_municipio = municipio.id
//            WHERE fk_municipio = $idMunicipio and sigla like 'IDHM_R';";
//
//        return TextBuilder::$bd->ExecutarSQL($SQL_RENDA, "getRenda");
//    }
//
//    function getLongevidade($idMunicipio) {
//        $SQL_LONGEVIDADE = "SELECT replace(replace(municipio.nome,'''','&#39;'),'''','&#39;') as nome,label_ano_referencia, nomecurto, valor
//            FROM valor_variavel_mun INNER JOIN variavel
//            ON fk_variavel = variavel.id
//            INNER JOIN ano_referencia
//            ON ano_referencia.id = fk_ano_referencia
//            INNER JOIN municipio
//            ON fk_municipio = municipio.id
//            WHERE fk_municipio = $idMunicipio and sigla like 'IDHM_L';";
//
//        return TextBuilder::$bd->ExecutarSQL($SQL_LONGEVIDADE, "getLongevidade");
//    }
//
//    function getEducacao($idMunicipio) {
//        $SQL_EDUCACAO = "SELECT replace(replace(municipio.nome,'''','&#39;'),'''','&#39;') as nome,label_ano_referencia, nomecurto, valor
//            FROM valor_variavel_mun INNER JOIN variavel
//            ON fk_variavel = variavel.id
//            INNER JOIN ano_referencia
//            ON ano_referencia.id = fk_ano_referencia
//            INNER JOIN municipio
//            ON fk_municipio = municipio.id
//            WHERE fk_municipio = $idMunicipio and sigla like 'IDHM_E';";
//
//        return TextBuilder::$bd->ExecutarSQL($SQL_EDUCACAO, "getEducacao");
//    }
    //GráficoEvolução IDHM ---------------------------------------------------------------------------------------
    public function getIDHMaiorMenorAno() {

        $SQL_MAIOR_MENOR_ANO_BRASIL = "SELECT MAX(valor) as maxvalue, MIN(valor) as minvalue, label_ano_referencia
        FROM " . $this->valor_variavel . " INNER JOIN variavel
        ON fk_variavel = variavel.id
        INNER JOIN ano_referencia ON fk_ano_referencia = ano_referencia.id
        where sigla like 'IDHM' GROUP BY label_ano_referencia ORDER BY label_ano_referencia;";

        //echo $SQL_MAIOR_MENOR_ANO_BRASIL;
        //die();
        return TextBuilder::$bd->ExecutarSQL($SQL_MAIOR_MENOR_ANO_BRASIL, "getIDHMaiorMenosAno");
    }

    function getIDHDesenvolvimentoHumano($id, $tipo_idhm) {

        $SQL_MUN_IDH = "SELECT replace(replace(" . $this->espacialidade . ".nome,'''','&#39;'),'''','&#39;') as nome,
            label_ano_referencia, nomecurto, valor
        FROM " . $this->valor_variavel . " INNER JOIN variavel
        ON fk_variavel = variavel.id
        INNER JOIN ano_referencia
        ON ano_referencia.id = fk_ano_referencia
        INNER JOIN " . $this->espacialidade . "
        ON " . $this->fk . " = " . $this->espacialidade . ".id
        WHERE " . $this->fk . " = $id and sigla like '" . $tipo_idhm . "' ORDER BY label_ano_referencia;";

        //echo $SQL_MUN_IDH;
        return TextBuilder::$bd->ExecutarSQL($SQL_MUN_IDH, "getIDHEvolucao");
    }

    function getIDHEvolucao($id) {

        $SQL_MUN_IDH = "SELECT replace(replace(" . $this->espacialidade . ".nome,'''','&#39;'),'''','&#39;') as nome,
            label_ano_referencia, nomecurto, valor
        FROM " . $this->valor_variavel . " INNER JOIN variavel
        ON fk_variavel = variavel.id
        INNER JOIN ano_referencia
        ON ano_referencia.id = fk_ano_referencia
        INNER JOIN " . $this->espacialidade . "
        ON " . $this->fk . " = " . $this->espacialidade . ".id
        WHERE " . $this->fk . " = $id and sigla like 'IDHM' ORDER BY label_ano_referencia;";

        //echo $SQL_MUN_IDH;
        return TextBuilder::$bd->ExecutarSQL($SQL_MUN_IDH, "getIDHEvolucao");
    }

    function getIDHEstado($idMunicipio) {

        $SQL_ESTADO_IDH = "SELECT  estado.uf,estado.nome,label_ano_referencia, nomecurto, valor 
	FROM valor_variavel_estado";

        $SQL_ESTADO_IDH .= " INNER JOIN municipio
	ON municipio.fk_estado = valor_variavel_estado.fk_estado";

        if ($this->type == "perfil_udh")
            $SQL_ESTADO_IDH .= " INNER JOIN udh
                ON udh.fk_municipio = municipio.id";

        $SQL_ESTADO_IDH .= " INNER JOIN variavel
	ON fk_variavel = variavel.id
	INNER JOIN ano_referencia
	ON ano_referencia.id = fk_ano_referencia
	INNER JOIN estado 
        ON municipio.fk_estado = estado.id";

        if ($this->type == "perfil_udh")
            $SQL_ESTADO_IDH .= " WHERE udh.id = $idMunicipio and sigla
                like 'IDHM' ORDER BY label_ano_referencia;";
        else
            $SQL_ESTADO_IDH .= " WHERE municipio.id = $idMunicipio and sigla
                like 'IDHM' ORDER BY label_ano_referencia;";

        return TextBuilder::$bd->ExecutarSQL($SQL_ESTADO_IDH, "getIDHEstado");
    }

    function getIDHRM($idMunicipio) {

        $SQL_RM_IDH = "SELECT  estado.uf, rm.nome,label_ano_referencia, nomecurto, valor 
	FROM valor_variavel_rm";

        $SQL_RM_IDH .= " INNER JOIN municipio
	ON municipio.fk_rm = valor_variavel_rm.fk_rm";

        $SQL_RM_IDH .= " INNER JOIN udh
            ON udh.fk_municipio = municipio.id";

        $SQL_RM_IDH .= " INNER JOIN variavel
	ON fk_variavel = variavel.id
	INNER JOIN ano_referencia
	ON ano_referencia.id = fk_ano_referencia
        INNER JOIN estado 
        ON municipio.fk_estado = estado.id
	INNER JOIN rm 
        ON municipio.fk_rm = rm.id";

        if ($this->type == "perfil_udh")
            $SQL_RM_IDH .= " WHERE udh.id = $idMunicipio and sigla
                like 'IDHM' ORDER BY label_ano_referencia;";
        else
            $SQL_RM_IDH .= " WHERE municipio.id = $idMunicipio and sigla
                like 'IDHM' ORDER BY label_ano_referencia;";

        return TextBuilder::$bd->ExecutarSQL($SQL_RM_IDH, "getIDHRM");
    }

    function getIDHMediaBrasil() {

        $SQL_MEDIA_BRASIL = "SELECT label_ano_referencia, nomecurto, valor
        FROM valor_variavel_pais INNER JOIN variavel
        ON fk_variavel = variavel.id
        INNER JOIN ano_referencia
        ON ano_referencia.id = fk_ano_referencia
        WHERE variavel.sigla like 'IDHM' ORDER BY label_ano_referencia; ";

        return TextBuilder::$bd->ExecutarSQL($SQL_MEDIA_BRASIL, "getIDHMediaBrasil");
    }

    //GráficoFluxoEscolar IDHM ---------------------------------------------------------------------------------------


    function getFreqEscolar5a6($idMunicipio, $lang) {

        $SQL_FREQ_ESC_CRIAN_E_JOVENS = "SELECT ";

        if ($this->type == "perfil_m" || $this->type == "perfil_udh")
            $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "estado.uf,";

        $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "replace(" . $this->espacialidade . ".nome,'''','&#39;') as nome,
            label_ano_referencia, lang_var.nomecurto, valor
            FROM " . $this->valor_variavel . " INNER JOIN variavel
            ON fk_variavel = variavel.id
            INNER JOIN ano_referencia
            ON ano_referencia.id = fk_ano_referencia
            INNER JOIN lang_var
                ON variavel.id = lang_var.fk_variavel
            INNER JOIN " . $this->espacialidade . "
            ON " . $this->fk . " = " . $this->espacialidade . ".id ";

        if ($this->type == "perfil_m") {
            $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "INNER JOIN estado 
                ON " . $this->espacialidade . ".fk_estado = estado.id ";
        } else if ($this->type == "perfil_udh") {
            $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "INNER JOIN municipio 
                ON " . $this->espacialidade . ".fk_municipio = municipio.id ";
            $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "INNER JOIN estado 
                ON municipio.fk_estado = estado.id ";
        }

        $SQL_FREQ_ESC_CRIAN_E_JOVENS .=
                "WHERE " . $this->fk . " = $idMunicipio and sigla ILIKE 'T_FREQ5A6' and lang like '" . $lang . "' 
            ORDER BY label_ano_referencia;";

        //echo $SQL_FREQ_ESC_CRIAN_E_JOVENS;
        return TextBuilder::$bd->ExecutarSQL($SQL_FREQ_ESC_CRIAN_E_JOVENS, "getFreqEscolar5a6");
    }

    function getFreqEscolar11a13($idMunicipio, $lang) {

        $SQL_FREQ_ESC_CRIAN_E_JOVENS = "SELECT ";

        if ($this->type == "perfil_m" || $this->type == "perfil_udh")
            $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "estado.uf,";

        $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "replace(" . $this->espacialidade . ".nome,'''','&#39;') as nome,
            label_ano_referencia, lang_var.nomecurto, valor
            FROM " . $this->valor_variavel . " INNER JOIN variavel
            ON fk_variavel = variavel.id
            INNER JOIN ano_referencia
            ON ano_referencia.id = fk_ano_referencia
            INNER JOIN lang_var
                ON variavel.id = lang_var.fk_variavel
            INNER JOIN " . $this->espacialidade . "
            ON " . $this->fk . " = " . $this->espacialidade . ".id ";

        if ($this->type == "perfil_m") {
            $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "INNER JOIN estado 
                ON " . $this->espacialidade . ".fk_estado = estado.id ";
        } else if ($this->type == "perfil_udh") {
            $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "INNER JOIN municipio 
                ON " . $this->espacialidade . ".fk_municipio = municipio.id ";
            $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "INNER JOIN estado 
                ON municipio.fk_estado = estado.id ";
        }

        $SQL_FREQ_ESC_CRIAN_E_JOVENS .=
                "WHERE " . $this->fk . " = $idMunicipio and  sigla ILIKE 'T_FUND11A13' and lang like '" . $lang . "' 
                ORDER BY label_ano_referencia;";

        return TextBuilder::$bd->ExecutarSQL($SQL_FREQ_ESC_CRIAN_E_JOVENS, "getFreqEscolar11a13");
    }

    function getFreqEscolar15a17($idMunicipio, $lang) {

        $SQL_FREQ_ESC_CRIAN_E_JOVENS = "SELECT ";

        if ($this->type == "perfil_m" || $this->type == "perfil_udh")
            $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "estado.uf,";

        $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "replace(" . $this->espacialidade . ".nome,'''','&#39;') as nome,
            label_ano_referencia, lang_var.nomecurto, valor
            FROM " . $this->valor_variavel . " INNER JOIN variavel
            ON fk_variavel = variavel.id
            INNER JOIN ano_referencia
            ON ano_referencia.id = fk_ano_referencia
            INNER JOIN lang_var
                ON variavel.id = lang_var.fk_variavel
            INNER JOIN " . $this->espacialidade . "
            ON " . $this->fk . " = " . $this->espacialidade . ".id ";

        if ($this->type == "perfil_m") {
            $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "INNER JOIN estado 
                ON " . $this->espacialidade . ".fk_estado = estado.id ";
        } else if ($this->type == "perfil_udh") {
            $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "INNER JOIN municipio 
                ON " . $this->espacialidade . ".fk_municipio = municipio.id ";
            $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "INNER JOIN estado 
                ON municipio.fk_estado = estado.id ";
        }

        $SQL_FREQ_ESC_CRIAN_E_JOVENS .=
                "WHERE " . $this->fk . " = $idMunicipio and  sigla ILIKE 'T_FUND15A17' and lang like '" . $lang . "' 
                ORDER BY label_ano_referencia;";

        return TextBuilder::$bd->ExecutarSQL($SQL_FREQ_ESC_CRIAN_E_JOVENS, "getFreqEscolar15a17");
    }

    function getFreqEscolar18a20($idMunicipio, $lang) {

        $SQL_FREQ_ESC_CRIAN_E_JOVENS = "SELECT ";

        if ($this->type == "perfil_m" || $this->type == "perfil_udh")
            $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "estado.uf,";

        $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "replace(" . $this->espacialidade . ".nome,'''','&#39;') as nome,
            label_ano_referencia, lang_var.nomecurto, valor
            FROM " . $this->valor_variavel . " INNER JOIN variavel
            ON fk_variavel = variavel.id
            INNER JOIN ano_referencia
            ON ano_referencia.id = fk_ano_referencia
            INNER JOIN lang_var
                ON variavel.id = lang_var.fk_variavel
            INNER JOIN " . $this->espacialidade . "
            ON " . $this->fk . " = " . $this->espacialidade . ".id ";

        if ($this->type == "perfil_m") {
            $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "INNER JOIN estado 
                ON " . $this->espacialidade . ".fk_estado = estado.id ";
        } else if ($this->type == "perfil_udh") {
            $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "INNER JOIN municipio 
                ON " . $this->espacialidade . ".fk_municipio = municipio.id ";
            $SQL_FREQ_ESC_CRIAN_E_JOVENS .= "INNER JOIN estado 
                ON municipio.fk_estado = estado.id ";
        }

        $SQL_FREQ_ESC_CRIAN_E_JOVENS .=
                "WHERE " . $this->fk . " = $idMunicipio and  sigla ILIKE 'T_MED18A20' and lang like '" . $lang . "' 
                ORDER BY label_ano_referencia;";

        return TextBuilder::$bd->ExecutarSQL($SQL_FREQ_ESC_CRIAN_E_JOVENS, "getFreqEscolar18a20");
    }

    //GráficoFrequenciaEscolar IDHM ---------------------------------------------------------------------------------------

    function getFreqEscolarFaixaEtariaMun($idMunicipio, $lang) {

        $SQL_FREQ_ESC_CRIAN_E_JOVENS = "SELECT  replace(replace(" . $this->espacialidade . ".nome,'''','&#39;'),'''','&#39;') as nome,label_ano_referencia, lang_var.nomecurto, valor,sigla 
            FROM " . $this->valor_variavel . " INNER JOIN variavel
            ON fk_variavel = variavel.id
            INNER JOIN ano_referencia
            ON ano_referencia.id = fk_ano_referencia
            INNER JOIN lang_var
            ON variavel.id = lang_var.fk_variavel
            INNER JOIN " . $this->espacialidade . "
            ON " . $this->fk . " = " . $this->espacialidade . ".id
            WHERE " . $this->fk . " = $idMunicipio and label_ano_referencia = 2010
                and  sigla IN ('T_FREQ5A6','T_FUND11A13','T_FUND15A17','T_MED18A20')
                and lang like '" . $lang . "';";

        return TextBuilder::$bd->ExecutarSQL($SQL_FREQ_ESC_CRIAN_E_JOVENS, "getFreqEscolarFaixaEtariaMun");
    }

    function getFreqEscolarFaixaEtariaEstado($idMunicipio) {

        $SQL_ESTADO_IDH = "SELECT ";

        if ($this->type == "perfil_m" || $this->type == "perfil_udh")
            $SQL_ESTADO_IDH .= "estado.uf, estado.nome, ";

        $SQL_ESTADO_IDH .= "label_ano_referencia, nomecurto, valor,sigla 
		FROM valor_variavel_estado
		INNER JOIN " . $this->espacialidade;

        if ($this->type == "perfil_udh") {
            $SQL_ESTADO_IDH .= " INNER JOIN municipio 
                    ON " . $this->espacialidade . ".fk_municipio = municipio.id ";
            $SQL_ESTADO_IDH .= "INNER JOIN estado 
                    ON municipio.fk_estado = estado.id ";
            $SQL_ESTADO_IDH .= "ON municipio.fk_estado = valor_variavel_estado.fk_estado ";
        } else
            $SQL_ESTADO_IDH .= " ON " . $this->espacialidade . ".fk_estado = valor_variavel_estado.fk_estado ";

        $SQL_ESTADO_IDH .= "INNER JOIN variavel
		ON fk_variavel = variavel.id
		INNER JOIN ano_referencia
		ON ano_referencia.id = fk_ano_referencia ";

        if ($this->type == "perfil_m") {
            $SQL_ESTADO_IDH .= "INNER JOIN estado 
                    ON " . $this->espacialidade . ".fk_estado = estado.id ";
        }

        $SQL_ESTADO_IDH .= "WHERE " . $this->espacialidade . ".id = $idMunicipio and label_ano_referencia = 2010 and sigla IN ('T_FREQ5A6','T_FUND11A13','T_FUND15A17','T_MED18A20');";


        return TextBuilder::$bd->ExecutarSQL($SQL_ESTADO_IDH, "getIDHEstado");
    }

    function getFreqEscolarFaixaEtariaBrasil() {

        $SQL_MEDIA_BRASIL = "SELECT label_ano_referencia, nomecurto, valor,sigla 
			FROM valor_variavel_pais INNER JOIN variavel
			ON fk_variavel = variavel.id
			INNER JOIN ano_referencia
			ON ano_referencia.id = fk_ano_referencia
			WHERE label_ano_referencia = 2010 and variavel.sigla IN ('T_FREQ5A6','T_FUND11A13','T_FUND15A17','T_MED18A20');";

        return TextBuilder::$bd->ExecutarSQL($SQL_MEDIA_BRASIL, "getIDHMediaBrasil");
    }

    //Gráficos Escolaridade Populacao Adulta 25oumais ---------------------------------------------------------------------------------------

    function getFrequenciaEscolar25ouMais($idMunicipio, $ano) {

        $SQL_25_OU_MAIS = "SELECT sigla,replace(" . $this->espacialidade . ".nome,'''','&#39;') as nome,label_ano_referencia, nomecurto, valor
        FROM " . $this->valor_variavel . " INNER JOIN variavel
        ON fk_variavel = variavel.id
        INNER JOIN ano_referencia
        ON ano_referencia.id = fk_ano_referencia
        INNER JOIN " . $this->espacialidade . "
        ON " . $this->fk . " = " . $this->espacialidade . ".id
        WHERE " . $this->fk . " = $idMunicipio and ano_referencia.label_ano_referencia = " . $ano . " and sigla 
        IN ('T_ANALF25M','T_FUND25M','T_MED25M','T_SUPER25M');";

        return TextBuilder::$bd->ExecutarSQL($SQL_25_OU_MAIS, "getFrequenciaEscolar25ouMais");
    }
    
    function getRendaPorQuintosPopulacao($idMunicipio, $ano) {

        $SQL_25_OU_MAIS = "SELECT sigla,replace(" . $this->espacialidade . ".nome,'''','&#39;') as nome,label_ano_referencia, nomecurto, valor
        FROM " . $this->valor_variavel . " INNER JOIN variavel
        ON fk_variavel = variavel.id
        INNER JOIN ano_referencia
        ON ano_referencia.id = fk_ano_referencia
        INNER JOIN " . $this->espacialidade . "
        ON " . $this->fk . " = " . $this->espacialidade . ".id
        WHERE " . $this->fk . " = $idMunicipio and ano_referencia.label_ano_referencia = " . $ano . " and sigla 
        IN ('RDPC1','RDPC2','RDPC3','RDPC4', 'RDPC5');";

        return TextBuilder::$bd->ExecutarSQL($SQL_25_OU_MAIS, "getFrequenciaEscolar25ouMais");
    }

//    function getFrequenciaEscolar25ouMais2000($idMunicipio) {
//
//        $SQL_25_OU_MAIS_2000 = "SELECT sigla,replace(municipio.nome,'''','&#39;') as nome,label_ano_referencia, nomecurto, valor
//                FROM valor_variavel_mun INNER JOIN variavel
//                ON fk_variavel = variavel.id
//                INNER JOIN ano_referencia
//                ON ano_referencia.id = fk_ano_referencia
//                INNER JOIN municipio
//                ON fk_municipio = municipio.id
//                WHERE fk_municipio = $idMunicipio and ano_referencia.label_ano_referencia = 2000 and sigla 
//                IN ('T_ANALF25M','T_FUND25M','T_MED25M','T_SUPER25M');";
//
//        return TextBuilder::$bd->ExecutarSQL($SQL_25_OU_MAIS_2000, "getFrequenciaEscolar25ouMais1991");
//    }
//    function getFrequenciaEscolar25ouMais2010($idMunicipio) {
//
//        $SQL_25_OU_MAIS_2010 = "SELECT sigla,replace(municipio.nome,'''','&#39;') as nome,label_ano_referencia, nomecurto, valor
//                FROM valor_variavel_mun INNER JOIN variavel
//                ON fk_variavel = variavel.id
//                INNER JOIN ano_referencia
//                ON ano_referencia.id = fk_ano_referencia
//                INNER JOIN municipio
//                ON fk_municipio = municipio.id
//                WHERE fk_municipio = $idMunicipio and ano_referencia.label_ano_referencia = 2010 and sigla 
//                IN ('T_ANALF25M','T_FUND25M','T_MED25M','T_SUPER25M');";
//
//        return TextBuilder::$bd->ExecutarSQL($SQL_25_OU_MAIS_2010, "getFrequenciaEscolar25ouMais1991");
//    }

    function getFrequenciaEscolar18a24Anos($idMunicipio) {

        $SQL_FREQ_18a24 = "SELECT sigla,";

        if ($this->type == "perfil_m" || $this->type == "perfil_udh")
            $SQL_FREQ_18a24 .= "estado.uf,";

        $SQL_FREQ_18a24 .= "replace(" . $this->espacialidade . ".nome,'''','&#39;') as nome,label_ano_referencia,nomecurto,
        valor
        FROM " . $this->valor_variavel . " INNER JOIN variavel
        ON fk_variavel = variavel.id
        INNER JOIN ano_referencia
        ON ano_referencia.id = fk_ano_referencia
        INNER JOIN " . $this->espacialidade . "
        ON " . $this->fk . " = " . $this->espacialidade . ".id ";

        if ($this->type == "perfil_m") {
            $SQL_FREQ_18a24 .= "INNER JOIN estado 
                ON " . $this->espacialidade . ".fk_estado = estado.id ";
        } else if ($this->type == "perfil_udh") {
            $SQL_FREQ_18a24 .= "INNER JOIN municipio 
                ON " . $this->espacialidade . ".fk_municipio = municipio.id ";
            $SQL_FREQ_18a24 .= "INNER JOIN estado 
                ON municipio.fk_estado = estado.id ";
        }

        $SQL_FREQ_18a24 .= "WHERE " . $this->fk . " = $idMunicipio  and ano_referencia.label_ano_referencia = 2010 and sigla 
        IN ('T_FLSUPER','T_FREQFUND1824','T_FREQMED1824','T_FREQ18A24') ORDER BY sigla;";

        return TextBuilder::$bd->ExecutarSQL($SQL_FREQ_18a24, "getFrequenciaEscolar18a24Anos");
    }

    function getFrequenciaEscolar15a17Anos($idMunicipio) {

        $SQL_FREQ_15a17 = "SELECT sigla,";

        if ($this->type == "perfil_m" || $this->type == "perfil_udh")
            $SQL_FREQ_15a17 .= "estado.uf,";


        $SQL_FREQ_15a17 .= "replace(" . $this->espacialidade . ".nome,'''','&#39;') as nome,label_ano_referencia,nomecurto,
        valor
        FROM " . $this->valor_variavel . " INNER JOIN variavel
        ON fk_variavel = variavel.id
        INNER JOIN ano_referencia
        ON ano_referencia.id = fk_ano_referencia
        INNER JOIN " . $this->espacialidade . "
        ON " . $this->fk . " = " . $this->espacialidade . ".id ";

        if ($this->type == "perfil_m") {
            $SQL_FREQ_15a17 .= "INNER JOIN estado 
                ON " . $this->espacialidade . ".fk_estado = estado.id ";
        } else if ($this->type == "perfil_udh") {
            $SQL_FREQ_15a17 .= "INNER JOIN municipio 
                ON " . $this->espacialidade . ".fk_municipio = municipio.id ";
            $SQL_FREQ_15a17 .= "INNER JOIN estado 
                ON municipio.fk_estado = estado.id ";
        }

        $SQL_FREQ_15a17 .= "WHERE " . $this->fk . " = $idMunicipio and ano_referencia.label_ano_referencia = 2010 and sigla 
        IN ('T_FLMED','T_ATRASO_0_MED','T_ATRASO_1_MED','T_ATRASO_2_MED','T_FREQFUND1517','T_FREQSUPER1517','T_FREQ15A17' ) ORDER BY sigla;";

        return TextBuilder::$bd->ExecutarSQL($SQL_FREQ_15a17, "getFrequenciaEscolar15a17Anos");
    }

    function getFrequenciaEscolar6a14Anos($idMunicipio) {

        $SQL_FREQ_6A14 = "SELECT  sigla,";

        if ($this->type == "perfil_m" || $this->type == "perfil_udh")
            $SQL_FREQ_6A14 .= "estado.uf,";


        $SQL_FREQ_6A14 .= "replace(" . $this->espacialidade . ".nome,'''','&#39;') as nome,label_ano_referencia,nomecurto,
        valor
        FROM " . $this->valor_variavel . " INNER JOIN variavel
        ON fk_variavel = variavel.id
        INNER JOIN ano_referencia
        ON ano_referencia.id = fk_ano_referencia
        INNER JOIN " . $this->espacialidade . "
        ON " . $this->fk . " = " . $this->espacialidade . ".id ";

        if ($this->type == "perfil_m") {
            $SQL_FREQ_6A14 .= "INNER JOIN estado 
                ON " . $this->espacialidade . ".fk_estado = estado.id ";
        } else if ($this->type == "perfil_udh") {
            $SQL_FREQ_6A14 .= "INNER JOIN municipio 
                ON " . $this->espacialidade . ".fk_municipio = municipio.id ";
            $SQL_FREQ_6A14 .= "INNER JOIN estado 
                ON municipio.fk_estado = estado.id ";
        }

        $SQL_FREQ_6A14 .= "WHERE " . $this->fk . " = $idMunicipio and ano_referencia.label_ano_referencia = 2010 and sigla 
        IN ('T_ATRASO_0_FUND','T_ATRASO_1_FUND',
        'T_ATRASO_2_FUND','T_FREQMED614','T_FREQ6A14','T_FLFUND'
        )ORDER BY sigla;";

        return TextBuilder::$bd->ExecutarSQL($SQL_FREQ_6A14, "getFrequenciaEscolar6a14Anos");
    }

    function getTrabalhoAtivos2010($idMunicipio) {

        $SQL_TRABALHO_2010 = "SELECT sigla,replace(" . $this->espacialidade . ".nome,'''','&#39;') as nome,label_ano_referencia, nomecurto, valor
        FROM " . $this->valor_variavel . " INNER JOIN variavel
        ON fk_variavel = variavel.id
        INNER JOIN ano_referencia
        ON ano_referencia.id = fk_ano_referencia
        INNER JOIN " . $this->espacialidade . "
        ON " . $this->fk . " = " . $this->espacialidade . ".id
        WHERE " . $this->fk . " = $idMunicipio and ano_referencia.label_ano_referencia = 2010 
        and sigla IN ('PESO18','T_ATIV18M','T_DES18M');";

        return TextBuilder::$bd->ExecutarSQL($SQL_TRABALHO_2010, "getTrabalhoAtivos2010");
    }

    // FUNCAO INATIVA
//    function getTrabalho2010($idMunicipio) {
//
//        $SQL_TRABALHO_2010 = "SELECT sigla,replace(" . $this->espacialidade . ".nome,'''','&#39;') as nome,label_ano_referencia, nomecurto, valor
//        FROM " . $this->valor_variavel . " INNER JOIN variavel
//        ON fk_variavel = variavel.id
//        INNER JOIN ano_referencia
//        ON ano_referencia.id = fk_ano_referencia
//        INNER JOIN " . $this->espacialidade . "
//        ON " . $this->fk . " = " . $this->espacialidade . ".id
//        WHERE " . $this->fk . " = $idMunicipio and ano_referencia.label_ano_referencia = 2010 
//        and sigla IN ('PESO18','T_ATIV18M');";
//
//        return TextBuilder::$bd->ExecutarSQL($SQL_TRABALHO_2010, "getTrabalho2010");
//    }

    //-----------------------PIRAMIDE ETARIA-----------------------------//
    function getPiramideEtariaMasculina($idMunicipio, $ano) {

        $SQL_MASC = "SELECT sigla,";

        if ($this->type == "perfil_m" || $this->type == "perfil_udh")
            $SQL_MASC .= "estado.uf,";

        $SQL_MASC .= "replace(" . $this->espacialidade . ".nome,'''','&#39;') as nome,label_ano_referencia, nomecurto, valor
        FROM " . $this->valor_variavel . " INNER JOIN variavel
        ON fk_variavel = variavel.id
        INNER JOIN ano_referencia
        ON ano_referencia.id = fk_ano_referencia
        INNER JOIN " . $this->espacialidade . "
        ON " . $this->fk . " = " . $this->espacialidade . ".id ";

        if ($this->type == "perfil_m") {
            $SQL_MASC .= "INNER JOIN estado 
            ON " . $this->espacialidade . ".fk_estado = estado.id ";
        } else if ($this->type == "perfil_udh") {
            $SQL_MASC .= "INNER JOIN municipio 
            ON " . $this->espacialidade . ".fk_municipio = municipio.id ";
            $SQL_MASC .= "INNER JOIN estado 
            ON municipio.fk_estado = estado.id ";
        }

        $SQL_MASC .= "WHERE " . $this->fk . " = $idMunicipio and label_ano_referencia = " . $ano . " and sigla IN ('HOMEM0A4','HOMEM5A9','HOMEM10A14','HOMEM15A19',
            'HOMEM20A24','HOMEM25A29','HOMEM30A34','HOMEM35A39','HOMEM40A44','HOMEM45A49','HOMEM50A54','HOMEM55A59',
            'HOMEM60A64','HOMEM65A69','HOMEM70A74','HOMEM75A79','HOMENS80');";

        return TextBuilder::$bd->ExecutarSQL($SQL_MASC, "getPiramideEtariaMasc" . $ano);
    }

    function getPiramideEtariaFeminina($idMunicipio, $ano) {

        $SQL_FEMIN = "SELECT sigla,";

        if ($this->type == "perfil_m" || $this->type == "perfil_udh")
            $SQL_FEMIN .= "estado.uf,";

        $SQL_FEMIN .= "replace(" . $this->espacialidade . ".nome,'''','&#39;') as nome,label_ano_referencia, nomecurto, valor
        FROM " . $this->valor_variavel . " INNER JOIN variavel
        ON fk_variavel = variavel.id
        INNER JOIN ano_referencia
        ON ano_referencia.id = fk_ano_referencia
        INNER JOIN " . $this->espacialidade . "
        ON " . $this->fk . " = " . $this->espacialidade . ".id ";

        if ($this->type == "perfil_m") {
            $SQL_FEMIN .= "INNER JOIN estado 
            ON " . $this->espacialidade . ".fk_estado = estado.id ";
        } else if ($this->type == "perfil_udh") {
            $SQL_FEMIN .= "INNER JOIN municipio 
            ON " . $this->espacialidade . ".fk_municipio = municipio.id ";
            $SQL_FEMIN .= "INNER JOIN estado 
            ON municipio.fk_estado = estado.id ";
        }

        $SQL_FEMIN .= "WHERE " . $this->fk . " = $idMunicipio and label_ano_referencia = " . $ano . " and sigla IN ('MULH0A4','MULH5A9','MULH10A14','MULH15A19',
        'MULH20A24','MULH25A29','MULH30A34','MULH35A39','MULH40A44','MULH45A49','MULH50A54','MULH55A59',
        'MULH60A64','MULH65A69','MULH70A74','MULH75A79','MULHER80');";

        return TextBuilder::$bd->ExecutarSQL($SQL_FEMIN, "getPiramideEtariaFemin" . $ano);
    }

//    function getPiramideEtariaMasc2000($idMunicipio) {
//
//        $SQL_MASC = "SELECT sigla,estado.uf,replace(municipio.nome,'''','&#39;') as nome,label_ano_referencia, nomecurto, valor
//        FROM valor_variavel_mun INNER JOIN variavel
//        ON fk_variavel = variavel.id
//        INNER JOIN ano_referencia
//        ON ano_referencia.id = fk_ano_referencia
//        INNER JOIN municipio
//        ON fk_municipio = municipio.id
//		INNER JOIN estado 
//		ON municipio.fk_estado = estado.id
//        WHERE fk_municipio = $idMunicipio and label_ano_referencia = 2000 and sigla IN ('HOMEM0A4','HOMEM5A9','HOMEM10A14','HOMEM15A19',
//'HOMEM20A24','HOMEM25A29','HOMEM30A34','HOMEM35A39','HOMEM40A44','HOMEM45A49','HOMEM50A54','HOMEM55A59',
//'HOMEM60A64','HOMEM65A69','HOMEM70A74','HOMEM75A79','HOMENS80');";
//
//        return TextBuilder::$bd->ExecutarSQL($SQL_MASC, "getPiramideEtariaMasc2000");
//    }
//    function getPiramideEtariaFemin2000($idMunicipio) {
//
//        $SQL_FEMIN = "SELECT sigla,estado.uf,replace(municipio.nome,'''','&#39;') as nome,label_ano_referencia, nomecurto, valor
//        FROM valor_variavel_mun INNER JOIN variavel
//        ON fk_variavel = variavel.id
//        INNER JOIN ano_referencia
//        ON ano_referencia.id = fk_ano_referencia
//        INNER JOIN municipio
//        ON fk_municipio = municipio.id
//		INNER JOIN estado 
//		ON municipio.fk_estado = estado.id
//        WHERE fk_municipio = $idMunicipio and label_ano_referencia = 2000 and sigla IN ('MULH0A4','MULH5A9','MULH10A14','MULH15A19',
//'MULH20A24','MULH25A29','MULH30A34','MULH35A39','MULH40A44','MULH45A49','MULH50A54','MULH55A59',
//'MULH60A64','MULH65A69','MULH70A74','MULH75A79','MULHER80');";
//
//        return TextBuilder::$bd->ExecutarSQL($SQL_FEMIN, "getPiramideEtariaFemin2000");
//    }
//    function getPiramideEtariaMasc2010($idMunicipio) {
//
//        $SQL_MASC = "SELECT sigla,estado.uf,replace(municipio.nome,'''','&#39;') as nome,label_ano_referencia, nomecurto, valor
//        FROM valor_variavel_mun INNER JOIN variavel
//        ON fk_variavel = variavel.id
//        INNER JOIN ano_referencia
//        ON ano_referencia.id = fk_ano_referencia
//        INNER JOIN municipio
//        ON fk_municipio = municipio.id
//		INNER JOIN estado 
//		ON municipio.fk_estado = estado.id
//        WHERE fk_municipio = $idMunicipio and label_ano_referencia = 2010 and sigla IN ('HOMEM0A4','HOMEM5A9','HOMEM10A14','HOMEM15A19',
//'HOMEM20A24','HOMEM25A29','HOMEM30A34','HOMEM35A39','HOMEM40A44','HOMEM45A49','HOMEM50A54','HOMEM55A59',
//'HOMEM60A64','HOMEM65A69','HOMEM70A74','HOMEM75A79','HOMENS80','HOMEMTOT');";
//
//        return TextBuilder::$bd->ExecutarSQL($SQL_MASC, "getPiramideEtariaMasc2010");
//    }
//    function getPiramideEtariaFemin2010($idMunicipio) {
//
//        $SQL_FEMIN = "SELECT sigla,estado.uf as uf,replace(municipio.nome,'''','&#39;') as nome,label_ano_referencia, nomecurto, valor
//        FROM valor_variavel_mun INNER JOIN variavel
//        ON fk_variavel = variavel.id
//        INNER JOIN ano_referencia
//        ON ano_referencia.id = fk_ano_referencia
//        INNER JOIN municipio
//        ON fk_municipio = municipio.id
//		INNER JOIN estado 
//		ON municipio.fk_estado = estado.id
//        WHERE fk_municipio = $idMunicipio and label_ano_referencia = 2010 and sigla IN ('MULH0A4','MULH5A9','MULH10A14','MULH15A19',
//'MULH20A24','MULH25A29','MULH30A34','MULH35A39','MULH40A44','MULH45A49','MULH50A54','MULH55A59',
//'MULH60A64','MULH65A69','MULH70A74','MULH75A79','MULHER80','MULHERTOT');";
//
//        return TextBuilder::$bd->ExecutarSQL($SQL_FEMIN, "getPiramideEtariaFemin2010");
//    }

    function getPiramideEtariaTotal($idMunicipio, $ano) {
        $SQL_TOTAL = "SELECT  SUM( valor) as valor
            FROM " . $this->valor_variavel . " INNER JOIN variavel
            ON fk_variavel = variavel.id
            INNER JOIN ano_referencia
            ON ano_referencia.id = fk_ano_referencia
            INNER JOIN " . $this->espacialidade . "
            ON " . $this->fk . " = " . $this->espacialidade . ".id		
            WHERE " . $this->fk . " = $idMunicipio and label_ano_referencia = " . $ano . " and sigla IN ('HOMEMTOT','MULHERTOT');";
        return TextBuilder::$bd->ExecutarSQL($SQL_TOTAL, "getPiramideEtariaTotal1991");
    }

//    function getPiramideEtariaTotal2000($idMunicipio){
//        $SQL_TOTAL = "SELECT  SUM( valor) as valor
//            FROM valor_variavel_mun INNER JOIN variavel
//            ON fk_variavel = variavel.id
//            INNER JOIN ano_referencia
//            ON ano_referencia.id = fk_ano_referencia
//            INNER JOIN municipio
//            ON fk_municipio = municipio.id   
//            WHERE fk_municipio = $idMunicipio and label_ano_referencia = 2000 and sigla IN ('HOMEMTOT','MULHERTOT');";
//       return TextBuilder::$bd->ExecutarSQL($SQL_TOTAL, "getPiramideEtariaTotal2000");
//
//    }
//    function getPiramideEtariaTotal2010($idMunicipio){
//        $SQL_TOTAL = "SELECT  SUM( valor) as valor
//            FROM valor_variavel_mun INNER JOIN variavel
//            ON fk_variavel = variavel.id
//            INNER JOIN ano_referencia
//            ON ano_referencia.id = fk_ano_referencia
//            INNER JOIN municipio
//            ON fk_municipio = municipio.id		
//            WHERE fk_municipio = $idMunicipio and label_ano_referencia = 2010 and sigla IN ('HOMEMTOT','MULHERTOT');";
//       return TextBuilder::$bd->ExecutarSQL($SQL_TOTAL, "getPiramideEtariaTotal2010");
//
//    }
}

?>
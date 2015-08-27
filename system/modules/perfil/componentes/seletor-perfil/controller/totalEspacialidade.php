<?php

ini_set("display_errors", 0);
ob_start("ob_gzhandler");
/* =================== Bloqueia o acesso direto pela url =================== */
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest' )) {
    include '../erro.php';
    die();
}

/* =================== LER VALORES DA REQUISIÇÃO =============================== */

/* =================== LIMPA REQUISIÇÃO ======================================== */

$lugs = $_GET['lugs'];

$_GET = null;
$_POST = null;
$_REQUEST = null;

/* =================== FECHA LEITURA DAS VARIÁVEIS E LIMPEZA DA REQUISIÇÃO ===== */
header("Content-Type: text/html; charset=ISO-8859-1");

//include_once('../../../../config/conexao.class.php');
require_once BASE_ROOT . "config/conexao.class.php";

function iGetSQLSecundarioCC($Array) {
    //die(var_dump($Array));
    //die($Array);

    $ParteInicialSQL = getSelectCC();

    $SQLVariaveis = array();
    $ests = 0;
    $muns = 0;
    $muns_r = 0;
    $muns_e = 0;
    $pais = 0;
    $rms = 0;
    $udhs = 0;
    $udhs_r = 0;
    $udhs_m = 0;
    $ris = 0;
    $regis = 0;
    $regis_m = 0;
    //var_dump($Array);
    foreach ($Array as $val)
        if ($val['e'] == 2) {
            if (strlen($val['l'][0]))
                $muns = implode(",", $val['l']);
            if (strlen($val['est'][0]))
                $muns_e = implode(",", $val['est']);
            if (strlen($val['rm'][0]))
                $muns_r = implode(",", $val['rm']);
        }elseif ($val['e'] == 3) {
            if (strlen($val['l'][0]))
                $regis = implode(",", $val['l']);
            if (strlen($val['mun'][0]))
                $regis_m = implode(",", $val['mun']);
        }elseif ($val['e'] == 4) {
            if (strlen($val['l'][0]))
                $ests = implode(",", $val['l']);
        }elseif ($val['e'] == 5) {
            if (strlen($val['l'][0]))
                $udhs = implode(",", $val['l']);
            if (strlen($val['rm'][0]))
                $udhs_r = implode(",", $val['rm']);
            if (strlen($val['mun'][0]))
                $udhs_m = implode(",", $val['mun']);
        }elseif ($val['e'] == 6) {
            if (strlen($val['l'][0]))
                $rms = implode(",", $val['l']);
        }elseif ($val['e'] == 7) {
            if (strlen($val['l'][0]))
                $ris = implode(",", $val['l']);
        }elseif ($val['e'] == 10)
            if (strlen($val['l'][0]))
                $pais = implode(",", $val['l']);

    if ($muns == '-1')
        $ParteInicialSQL = str_replace("%municipios%", "(select id from municipio)", $ParteInicialSQL);
    //$ParteInicialSQL = str_replace("%municipios%", "(select distinct(fk_municipio) from valor_variavel_mun)", $ParteInicialSQL);
    else
        $ParteInicialSQL = str_replace("%municipios%", "($muns) or fk_rm in ($muns_r) or fk_estado in ($muns_e)", $ParteInicialSQL);

    if ($ris == '-1')
        $ParteInicialSQL = str_replace("%ris%", "(select id from regiao_interesse)", $ParteInicialSQL);
    else
        $ParteInicialSQL = str_replace("%ris%", "($ris)", $ParteInicialSQL);

    if ($ests == '-1')
        $ParteInicialSQL = str_replace("%estados%", "(select id from estado)", $ParteInicialSQL);
    //$ParteInicialSQL = str_replace("%estados%", "(select distinct(fk_estado) from valor_variavel_estado)", $ParteInicialSQL);
    else
        $ParteInicialSQL = str_replace("%estados%", "($ests)", $ParteInicialSQL);

    if ($udhs == '-1')
    //$ParteInicialSQL = str_replace("%udhs%", "(select id from udh)", $ParteInicialSQL);
        $ParteInicialSQL = str_replace("%udhs%", "(select distinct(fk_udh) from valor_variavel_udh)", $ParteInicialSQL);
    else
        $ParteInicialSQL = str_replace("%udhs%", "($udhs) or fk_rm in ($udhs_r) or fk_municipio in ($udhs_m)", $ParteInicialSQL);

    if ($regis == '-1')
    //$ParteInicialSQL = str_replace("%regis%", "(select id from regional)", $ParteInicialSQL);
        $ParteInicialSQL = str_replace("%regis%", "(select distinct(fk_regional) from valor_variavel_regional)", $ParteInicialSQL);
    else
        $ParteInicialSQL = str_replace("%regis%", "($regis) or fk_mun in ($regis_m)", $ParteInicialSQL);

    if ($rms == '-1')
        $ParteInicialSQL = str_replace("%rms%", "(select id from rm where ativo is true)", $ParteInicialSQL);
    else
        $ParteInicialSQL = str_replace("%rms%", "($rms)", $ParteInicialSQL);

    $ParteInicialSQL = str_replace("%paises%", "($pais)", $ParteInicialSQL);

    //die("$ParteInicialSQL");
    return "$ParteInicialSQL";
}

function getSelectCC() {
    //and id in (select distinct(fk_udh) from valor_variavel_udh) 
    $ParteInicialSQL = "SELECT count(distinct(nome)) as valor FROM 
			(
			SELECT nome_pais as nome from pais WHERE id IN %paises% 
			union all
			SELECT r.nome_curto||r.cod_rmatlas as nome from rm as r where id in %rms% 	
			union all 
			SELECT g.nome||g.cod_regatlas as nome from regional as g where id in %regis% 
			union all 
			SELECT ud.nome||ud.cod_udhatlas from udh as ud WHERE id IN %udhs% 
			union all 
			SELECT m.nome||m.fk_estado as nome from municipio as m WHERE id IN %municipios% 
			union all 
			SELECT e.nome||e.uf as nome from estado as e WHERE id IN %estados%  
			union all
			SELECT m.nome||m.fk_estado as nome FROM municipio as m
				INNER JOIN regiao_interesse_has_municipio as b ON (b.fk_municipio = m.id) 
				WHERE fk_regiao_interesse IN %ris% 
			) as tot";

    return $ParteInicialSQL;
}

function consults($sql) {
    $minhaConexao = new Conexao();
    $con = $minhaConexao->open();

    $result = pg_query($con, $sql) or die("Nao foi possivel executar a consulta!");
    $row = pg_fetch_array($result);
    return $row["valor"];
}

echo consults(iGetSQLSecundarioCC($lugs));

?>
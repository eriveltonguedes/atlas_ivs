<?php

//$comPath = BASE_ROOT . "system/modules/perfil//";
require_once '../../../../config/config_path.php';
require_once '../../../../config/config_gerais.php';
require_once PERFIL_PACKAGE . 'controller/Perfil.class.php';
require_once PERFIL_PACKAGE . 'controller/TextBuilder.class.php';
//require_once PERFIL_PACKAGE . 'controller/TextBuilder_EN.class.php';
//require_once PERFIL_PACKAGE . 'controller/TextBuilder_ES.class.php';
//require_once PERFIL_PACKAGE . 'controller/PerfilBuilder.php';
require_once PERFIL_PACKAGE . 'Block.class.php';
//require_once $comPath . "util/protect_sql_injection.php";

if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    header("Location: {$path_dir}404");
    die();
}

$cidade = $_POST["city"];
$lang = $_POST["lang"];
$perfilType = $_POST["perfilType"];

//(isset($_POST["print"]) ? $print = true : $print = false );

$perfil = new Perfil($cidade, $perfilType);

TextBuilder::$idMunicipio = $perfil->getCityId();
TextBuilder::$nomeMunicipio = $perfil->getCityName();
TextBuilder::$ufMunicipio = $perfil->getUfName();
TextBuilder::$lang = $lang;
TextBuilder::$type = $perfilType;
TextBuilder::$print = true; //@#Todo perfil já estará adaptado para impressão.

$perfil->drawScriptsMaps();
$perfil->drawMap();
//$perfil->drawBoxes($lang, $perfilType);
TextBuilder::$bd = new bd();

$boxes = new ITCaracterizacao($lang, $perfilType);
$boxes->getTabelaCaracterizacao();

//IDH ----------------------------------  
TextBuilder::$aba = new ITComponentes($lang, $perfilType);
$block_componente = new Block(1);
TextBuilder::generateIDH_componente($block_componente);
$block_componente->draw();

//@NãoInclusoEmRM&UDH
if ($perfilType != "perfil_rm" && $perfilType != "perfil_udh")
    $block_table_componente = new Block(15);
else
    $block_table_componente = new Block(29);

TextBuilder::generateIDH_table_componente($block_table_componente);
$block_table_componente->draw();


//NOVO TOPICO PARA UDH
if ($perfilType === "perfil_udh") {
    TextBuilder::$aba = new ITComparacao($lang, $perfilType);
    $block_comparacao = new Block(41);
    TextBuilder::generateComparacao($block_comparacao);
    $block_comparacao->draw();
}

if ($perfilType != "perfil_udh" && $perfilType != "perfil_rm") {
    TextBuilder::$aba = new ITEvolucao($lang, $perfilType);
    //EVOLUCAO ----------------------------------
    $block_evolucao = new Block(2);
    TextBuilder::generateIDH_evolucao($block_evolucao);
    $block_evolucao->draw();
} else if ($perfilType === "perfil_rm") {
    TextBuilder::$aba = new ITEvolucao($lang, $perfilType);
    //EVOLUCAO ----------------------------------
    $block_evolucao = new Block(42);
    TextBuilder::generateIDH_evolucao($block_evolucao);
    $block_evolucao->draw();
}

//RANKING ----------------------------------
TextBuilder::$aba = new ITRanking($lang, $perfilType);
$block_ranking = new Block(4);
TextBuilder::generateIDH_ranking($block_ranking);
$block_ranking->draw();

if ($perfilType == "perfil_udh") {
    $block_table_ranking = new Block(46);
    TextBuilder::generateIDH_table_ranking($block_table_ranking);
    $block_table_ranking->draw();
}


//DEMOGRAFIA ------------------------------  
TextBuilder::$aba = new ITPopulacao($lang, $perfilType);
$block_populacao = new Block(6);
TextBuilder::generateDEMOGRAFIA_SAUDE_populacao($block_populacao);
$block_populacao->draw();

//@NãoInclusoEmRM&UDH
if ($perfilType != "perfil_udh" && $perfilType != "perfil_rm") {
    $block_table_populacao = new Block(43);
} elseif ($perfilType == "perfil_rm") {
    $block_table_populacao = new Block(30);
} elseif ($perfilType == "perfil_udh") {
    $block_table_populacao = new Block(44);
}

TextBuilder::generateIDH_table_populacao($block_table_populacao);
$block_table_populacao->draw();

TextBuilder::$aba = new ITEstruturaEtaria($lang, $perfilType);
$block_etaria = new Block(7);
TextBuilder::generateDEMOGRAFIA_SAUDE_etaria($block_etaria);
$block_etaria->draw();

//@NãoInclusoEmRM&UDH
if ($perfilType != "perfil_rm" && $perfilType != "perfil_udh")
    $block_table_etaria = new Block(17);
else if ($perfilType === "perfil_udh")
    $block_table_etaria = new Block(40);
else
    $block_table_etaria = new Block(31);

TextBuilder::generateIDH_table_etaria($block_table_etaria);
$block_table_etaria->draw();

TextBuilder::$aba = new ITLongMortFecund($lang, $perfilType);
$block_longevidade1 = new Block(8);
TextBuilder::generateDEMOGRAFIA_SAUDE_longevidade1($block_longevidade1);
$block_longevidade1->draw();

//@NãoInclusoEmRM&UDH
if ($perfilType != "perfil_rm" && $perfilType != "perfil_udh")
    $block_table_longevidade = new Block(18);
else
    $block_table_longevidade = new Block(32);
//$block_table_longevidade = new Block(18);
TextBuilder::generateIDH_table_longevidade($block_table_longevidade);
$block_table_longevidade->draw();

$block_longevidade2 = new Block(8);
TextBuilder::generateDEMOGRAFIA_SAUDE_longevidade2($block_longevidade2);
$block_longevidade2->draw();
//
////EDUCACAO ---------------------------------- 
TextBuilder::$aba = new ITCriancasJovens($lang, $perfilType);
if ($perfilType != "perfil_udh" && $perfilType != "perfil_rm") {
    $block_nivel_educacional = new Block(9);
}else if($perfilType == "perfil_rm") {
    $block_nivel_educacional = new Block(47); 
}else {
    $block_nivel_educacional = new Block(45);
}

TextBuilder::generateEDUCACAO_nivel_educacional($block_nivel_educacional);
$block_nivel_educacional->draw();

//TextBuilder::$aba = new ITAnosEsperados($lang, $perfilType);
//    $block_anos_esperados = new Block(28);
//    TextBuilder::generateAnosEsperadosEstudo($block_anos_esperados);
//    $block_anos_esperados->draw();

TextBuilder::$aba = new ITExpectativaAnosEstudo($lang, $perfilType);
$block_anos_esperados = new Block(28);
TextBuilder::generateExpectativaAnosEstudo($block_anos_esperados);
$block_anos_esperados->draw();

//POPULAÇÃO ADULTA

TextBuilder::$aba = new ITPopulacaoAdulta($lang, $perfilType);
if ($perfilType != "perfil_udh") {
    $block_populacao_adulta = new Block(10);
}else
    $block_populacao_adulta = new Block(48);
TextBuilder::generateEDUCACAO_populacao_adulta($block_populacao_adulta);
$block_populacao_adulta->draw();



//RENDA -------------------------------------  
TextBuilder::$aba = new ITRenda($lang, $perfilType);
$block_renda = new Block(11);
TextBuilder::generateRENDA($block_renda);
$block_renda->draw();

//@NãoInclusoEmRM&UDH
if ($perfilType != "perfil_rm" && $perfilType != "perfil_udh")
    $block_table_renda = new Block(27);
else
    $block_table_renda = new Block(33);
//$block_table_renda = new Block(27);
TextBuilder::generateIDH_table_renda($block_table_renda);
$block_table_renda->draw();

//@NãoInclusoEmRM&UDH
//if ($perfilType != "perfil_rm" && $perfilType != "perfil_udh")
//    $block_table_renda2 = new Block(19);
//else
//    $block_table_renda2 = new Block(34);
////$block_table_renda2 = new Block(19);
//TextBuilder::generateIDH_table_renda2($block_table_renda2);
//$block_table_renda2->draw();
//TRABALHO ------------------------------------- 
TextBuilder::$aba = new ITTrabalho($lang, $perfilType);
$block_trabalho1 = new Block(12);
TextBuilder::generateTRABALHO1($block_trabalho1);
$block_trabalho1->draw();

$block_table_trabalho = new Block(20);
TextBuilder::generateIDH_table_trabalho($block_table_trabalho);
$block_table_trabalho->draw();

if ($perfilType !== "perfil_udh") {
    $block_trabalho2 = new Block(25);
    TextBuilder::generateTRABALHO2($block_trabalho2);
    $block_trabalho2->draw();
}

//HABITACAO ------------------------------------
TextBuilder::$aba = new ITHabitacao($lang, $perfilType);
$block_habitacao = new Block(13);
TextBuilder::generateHABITACAO($block_habitacao);
$block_habitacao->draw();

//@NãoInclusoEmRM&UDH
if ($perfilType != "perfil_rm" && $perfilType != "perfil_udh")
    $block_table_habitacao = new Block(22);
else
    $block_table_habitacao = new Block(35);
//$block_table_habitacao = new Block(22);
TextBuilder::generateIDH_table_habitacao($block_table_habitacao);
$block_table_habitacao->draw();

////VULNERABILIDADE ------------------------------  
TextBuilder::$aba = new ITVulnerabilidade($lang, $perfilType);
$block_vulnerabilidade = new Block(26);
TextBuilder::generateVULNERABILIDADE($block_vulnerabilidade);
$block_vulnerabilidade->draw();

//@NãoInclusoEmRM&UDH
if ($perfilType != "perfil_rm" && $perfilType != "perfil_udh")
    $block_table_vulnerabilidade = new Block(21);
else
    $block_table_vulnerabilidade = new Block(36);
//$block_table_vulnerabilidade = new Block(21);
TextBuilder::generateIDH_table_vulnerabilidade($block_table_vulnerabilidade);
$block_table_vulnerabilidade->draw();


$_GET = null;
$_POST = null;
$_REQUEST = null;



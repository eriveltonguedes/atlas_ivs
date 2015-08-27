<?php
session_start();

require_once '../model/Tabela.class.php';

$dados_post = json_decode(stripslashes($_POST['dados']), true);
if($dados_post == null) {
    $dados_post = json_decode($_POST['dados'], true);
}

$dados = $dados_post['dataAjax'];
$pag   = $dados_post['pagination'];

$espacialidades = $dados['entidades'];
$indicadores    = $dados['indicadores'];
$lang = null;
if(isset($dados[$lang])) {
    $lang = $dados['lang'];
} else {
    $lang = 'pt';
}

$limit  = $pag['limit'];
$pagina = $pag['pageActive'];
$offset = $pag['offset'];

$column = null;

if(isset($dados_post['colObject'])) {
    $column = $dados_post['colObject'];
}

$tabela = new Tabela($espacialidades, $indicadores, $limit, $offset, $pagina, $column, $lang);

$resposta = array(
    'columns'       => $tabela->colunas,
    'count'         => $tabela->total_espacialidades,
    'data'          => $tabela->data_tabela,
    'perfil'        => $tabela->perfil,
    'descricao'     => $tabela->descricao,
);

header('Content-Type: application/json');
echo json_encode($resposta);

?>

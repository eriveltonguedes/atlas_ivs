<?php

session_start();

require_once '../model/agregacaoClass.php';
require_once '../../../../config/config_gerais.php';

$dados_post = json_decode(stripslashes($_POST['dados']), true);

$dados = $dados_post['dataAjax'];

$espacialidades = $dados['aggregation'];
$indicadores    = $dados['indicadores'];

$tabela = new Agregacao($espacialidades, $indicadores);

$resposta = array(
    'data' => $tabela->data_tabela,
);

header('Content-Type: application/json');
echo json_encode($resposta);

?>


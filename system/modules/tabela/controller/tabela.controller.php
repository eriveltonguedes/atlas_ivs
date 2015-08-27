<?php

require_once '../model/Tabela.class.php';

$espacialidades = json_decode($_POST['espacialidades'], true);
$indicadores = json_decode($_POST['indicadores_ano'], true);
$order = $_POST['order'] == "" ? "" : json_decode($_POST['order'], true);
$pagina = $_POST['pagina'];

$tabela = new Tabela($espacialidades, $indicadores, $order, $pagina);

echo $tabela->get_html_tabela();
echo "<pre>".$tabela->get_sql()."</pre>";

?>

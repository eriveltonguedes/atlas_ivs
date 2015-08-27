<?php
/*
 * Serviço indicadores menu.
 *
 * @package map
 * @author AtlasBrasil
 */
header('Content-Type: application/json');

$dir = dirname(__FILE__);
require_once $dir . '/../../../../config/conexao.class.php';
require_once $dir . '/../../../../config/constants.php';
require_once $dir . '/../init.php';
require_once $dir . '/../model/autoload.php';

ini_set('display_errors', DISPLAY_ERRORS);

$db_connection = new Conexao();
$db = new Bd($db_connection->open());

$user_lang  = isset($_GET['user_lang']) ? $_GET['user_lang'] : 'pt';
$dao = new NomeIndicadorDao($db, $user_lang);

echo json_encode($dao->getResultSet()->toArray());

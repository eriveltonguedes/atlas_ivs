<?php

/*
 * Serviço para acesso às informações geográficas do mapa.
 *
 * @package map
 * @author AtlasBrasil
 */

// Header json
header('Content-Type: application/json');


// espera tempo indefinido
set_time_limit(0);

// config
$dir = dirname(__FILE__);
require_once $dir . '/../../../../config/conexao.class.php';
require_once $dir . '/../../../../config/constants.php';
require_once $dir . '/../init.php';
require_once $dir . '/../model/autoload.php';


// erros
ini_set('display_errors', DISPLAY_ERRORS);

// busca pelo mapa utiliza o menu de contexto
$escolha_por_contexto = true;

// busca enviada pelo componente
$busca_por_componente = false;


$mapa_espacialidade = Protocolo::getMapaEspacialidade();


if (isset($_REQUEST['tipo']))
{
    $tipo = $_REQUEST['tipo'];
}

$contexto = null;
if (isset($_REQUEST['contexto']))
{
    $contexto = $_REQUEST['contexto'];
}

if (isset($_REQUEST['espacialidade']))
{
    $espacialidade = $_REQUEST['espacialidade'];
}

if (isset($_REQUEST['indicador']))
{
    $indicador = $_REQUEST['indicador'];
}
if (isset($_REQUEST['ano']))
{
    $ano = $_REQUEST['ano'];
}

// ID espacialidade
$_id        = null;
$_id_backup = null;

if (isset($_REQUEST['id']))
{
    $_id        = (array) $_REQUEST['id'];
    $_id_backup = (array) $_REQUEST['id'];
}


// Banco de dados
$db_connection = new Conexao();
$db = new Bd($db_connection->open());

/**
 * Protocolo Map Service.
 * <code>{'sucesso': boolean, 'retorno': array|null}</code>
 * 
 * @param int $sucesso
 * @param array|null $retorno
 */
function response($sucesso, $retorno)
{
    echo json_encode(array(
        'sucesso' => $sucesso,
        'retorno' => $retorno
    ));
}

/** @TODO * */
if (count($_id) > 1)
{
    $escolha_por_contexto = false;
}

/**
 * Existe parâmetro do request.
 *
 * @param string $param            
 * @return boolean
 */
function existe_request_param($param)
{
    return isset($_REQUEST[$param]) && is_array($_REQUEST[$param]) && count($_REQUEST[$param]) > 0 && $_REQUEST[$param][0];
}

// utilities sql
$construtor_sql = new SqlEspacialidade;

// testa todas as opções do componente
$arr_espacialidades = Protocolo::getEspacialidades();
foreach ($arr_espacialidades as $atual)
{
    if (existe_request_param($atual))
    {

        $construtor_sql->getSqlByIdEspacialidade(
                $mapa_espacialidade[$atual], 
                $espacialidade, 
                $_REQUEST[$atual]
        );

        $escolha_por_contexto = false;
        $busca_por_componente = true;

        // contexto pela componente
        $contexto = $mapa_espacialidade[$atual];
    }
} // foreach

/**
 * Verifica se o tipo está relacionado ao mapa (contorno).
 * 
 * @param string $tipo
 * @return boolean
 */
function is_tipo_mapa($tipo)
{
    return (strtolower($tipo) != 'legenda');
}

// 1. Mapa padrão:
if ($escolha_por_contexto && 
        ($contexto && $contexto != $espacialidade) && 
        is_tipo_mapa($tipo))
{
    $_id = $construtor_sql->getSqlByIdEspacialidade(
            $contexto, $espacialidade, $_id);
}


// 2. Busca pelo componente:
if (!$escolha_por_contexto && $busca_por_componente && is_tipo_mapa($tipo))
{

    if (existe_request_param('id'))
    {
        $construtor_sql->addEspacialidade($_id_backup);
    }

    $_id = $construtor_sql->getSql();
}


// verifica se todas as espacialidade 
// protocolo contexto brasil (-1)
if (in_array(-1, (array) $_id_backup))
{
    $contexto = 10; // contexto brasil
}

// response protocolo: response e sucesso
$retorno = array();
$sucesso = false;

if ($espacialidade)
{
    // legenda
    if ($tipo == 'legenda' && $indicador)
    {
        $dao = new LegendaPadraoDao($db);
        $legenda = $dao->carrega($indicador, $espacialidade);

        $retorno['__legenda__'] = $legenda->getFaixasArray();
        
        $sucesso = (count($retorno['__legenda__']) > 0);
    }

    // mapa
    if ($tipo == 'mapa')
    {
        $sucesso = true;

        $factory = new FactoryEspacialidadeDao($db);
        $dao = $factory->getDao($espacialidade, $contexto);

        $retorno['__contornos__']   = $dao->getEspacialidadesById($_id)
                ->getResultSet()
                ->toArray();
        
        $retorno['__maxzoom__']     = $dao->getMaxZoom();
    }

    // valores do mapa
    if ($tipo == 'valores' && $indicador)
    {
        $dao = new ValorIndicadorDao($db);
        
        $retorno['__valores__'] = $dao
                ->get($contexto, $espacialidade, $_id, $indicador, $ano)
                ->toArray();
        
        $sucesso = (count($retorno['__valores__']) > 0);
    }

    // total de espacialidades
    if ($tipo == 'total')
    {
        $sucesso = true;

        $factory = new FactoryEspacialidadeDao($db);
        $dao = $factory->getDao($espacialidade, $contexto);

        $retorno['__total__'] = $dao->getCountById($_id);
    }

    // coordenadas
    if ($tipo == 'coords' && $_id_backup[0])
    {
        
        $coords = new CoordsEspacialidadeDao($db);
        $latLng = $coords->getLatLng($_id_backup[0], $espacialidade);
        
        if ($latLng instanceof CoordsEspacialidade) {
            $sucesso = true;
            $retorno['__coords__'] = array(
                $latLng->getLat(), 
                $latLng->getLng()
            );
        }
    }
}

// result map service
response($sucesso, $retorno);

// free memory
unset($_id, $_id_backup, $result);

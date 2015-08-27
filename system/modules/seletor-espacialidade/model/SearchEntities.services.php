<?php
//FALTA:
// CRIAR PADRÃO E PARAMETRIZAR TUDO DOS SERVICES,
// DEVIDO AO CURTO PRAZO FOI PRIORIZADO CRIAR OS SERVICES DE ACORDO COM A DEMANDA DO COMPONENTE. 
// AO ACESSAR O SERVICE DIRETAMENTE VIA URL O RETORNO DEVE SER JSON, SE ACESSO FOR VIA CONTROLLER DEVE SER A BUSCA NORMAL.

// $contents = $_POST["data"];
// $data = json_decode(stripslashes($contents));
// $method = $data->method;
// $search = new SearchComponent();
// 
// if(!empty($method)){
	// $retorno = $search->$method($data->options);	
	// echo json_encode($retorno);	
// }
// else{
	// $retorno = array(
		// "data" => null,
		// "status" => false,
		// "msg" => "Método não encontrado."
	// );
	// echo json_encode($retorno);
// }
//CRIAR UM MÉTODO PARA CONVERSAR COM OS MÉTODOS VIA UMA API DEFINIDA POR MIM
include_once("Municipalities.model.php");
include_once("Regional.model.php");
include_once("State.model.php");
include_once("ThematicArea.model.php");
include_once("MetropolitanArea.model.php");
include_once("Udh.model.php");
include_once("SearchEntities.dao.php");
class SearchEntitiesService{
		
	public function genericSearch($table,$where){
		$searchDAO = new SearchEntitiesDAO();
		return $searchDAO->genericSearch($table,$where);
	}
		
	public function getMunicipalities($params = null){
		$municipalitiesDAO = new SearchEntitiesDAO();
		$return = null;
		if(empty($params))
			$return = $municipioDAO->getAllMunicipalities();
		else if(property_exists($params, "name")){
			$municipalitiesModel = new MunicipalitiesModel();
			$municipalitiesModel->nome = $params->name;
			$return = $municipalitiesDAO->getMunicipalitiesByName($municipalitiesModel,$params->like);
		}
		else if(property_exists($params, "where")){
			$municipalitiesModel = new MunicipalitiesModel();			
			$return = $municipalitiesDAO->getMunicipalities($params->where);
		} 
		return $return;
	}
	
	public function getState($params = null){
		$stateDAO = new SearchEntitiesDAO();
		$retorno = null;
		if(empty($params))
			$retorno = $stateDAO->getAllStates();
		else if(property_exists($params, "name")){
			$stateModel = new StateModel();
			$stateModel->nome = $params->name;
			$retorno = $stateDAO->getStatesByName($stateModel,$params->like);
		}	
		return $retorno;
	}
	
	public function getThematicAreas($params = null){
		$searchDAO = new SearchEntitiesDAO();
		$retorno = null;
		if(empty($params))
			$retorno = $searchDAO->getAllThematicAreas();
		else if(property_exists($params, "name")){
			$thematicAreaModel = new ThematicAreaModel();
			$thematicAreaModel->nome = $params->name;
			$retorno = $searchDAO->getThematicAreasByName($thematicAreaModel,$params->like);
		}
		return $retorno;
	}
	
	public function getMetropolitanAreas($params = null){
		$searchDAO = new SearchEntitiesDAO();
		$retorno = null;
		if(empty($params))
			$retorno = $searchDAO->getAllMetropolitanAreas();
		else if(property_exists($params, "name")){
			$metropolitanAreaModel = new MetropolitanAreaModel();
			$metropolitanAreaModel->nome = $params->name;
			$retorno = $searchDAO->getMetropolitanAreasByName($metropolitanAreaModel,$params->like);
		}
		return $retorno;
	}
	
	public function getUdhs($params = null){
		$searchDAO = new SearchEntitiesDAO();
		$retorno = null;
		if(empty($params))
			$retorno = $searchDAO->getAllUdhs();
		else if(property_exists($params, "name")){
			$udhModel = new UdhModel();
			$udhModel->nome = $params->name;
			$retorno = $searchDAO->getUdhsByName($udhModel,$params->like);
		}
		return $retorno;
	}
	
	public function getMetropolitanAreasFilter($objeto = null){
		$searchDAO = new SearchEntitiesDAO();
		return $searchDAO->getRmFilter($objeto);
	}
	
	//Está feito de uma forma estranha, versão 2.0 pensar melhor
	// Muito gambiarrado
	public function getRegional($params = null){
		$searchDAO = new SearchEntitiesDAO();
		$retorno = null;
		if(empty($params))
			$retorno = null;
			// $retorno = $searchDAO->getAllRegional();
		else if(property_exists($params, "municipios") && property_exists($params, "distinct")){
			$retorno = $searchDAO->getAllRegionalMunicipalities($params->distinct);
		}
		else if(property_exists($params, "where")){
			$retorno = $searchDAO->getRegional($params->where);
		} 
		else if(property_exists($params, "name")){
			$regionalModel = new RegionalModel();
			$regionalModel->nome = $params->name;
			$retorno = $searchDAO->getRegionalByName($regionalModel,$params->like);
		}
		return $retorno;
	}

	public function getMunByRmByRegional($fk_rm){
		$searchDAO = new SearchEntitiesDAO();
		return $searchDAO->getMunByRmByRegional($fk_rm);
	}	

	public function getRm($objeto, $arrayWhere){
		$searchDAO = new SearchEntitiesDAO();
		return $searchDAO->getRm($objeto, $arrayWhere);
	}
}
?>
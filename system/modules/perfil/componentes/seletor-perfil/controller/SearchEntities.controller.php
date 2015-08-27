<?php

include_once("../model/SearchEntities.services.php");

class SearchEntitiesController {

    private $idsEntidades = array("estado" => 4, "municipio" => 2, "regiao_interesse" => 7, "rm" => 6, "udh" => 5, "regional" => 3);

    public function textSearch($options = null) {
        //Fazer busca textual
        //Criando objeto de serviço que irá fazer as buscas a partir dos models
        $ServiceSearch = new SearchEntitiesService();
        $params = new stdClass();
        $params->name = $options;
        $params->like = "after";

        $municipalities = $ServiceSearch->getMunicipalities($params); //pega municipios
        $state = $ServiceSearch->getState($params);
        $params->like = "between";
        $thematicAreas = $ServiceSearch->getThematicAreas($params);
        $metropolitanAreas = $ServiceSearch->getMetropolitanAreas($params);
        $udh = $ServiceSearch->getUdhs($params);
        $regional = $ServiceSearch->getRegional($params);


        $data = array();
        $data[0]["idEntidade"] = $this->idsEntidades["estado"];
        $data[0]["data"] = $state;
        $data[1]["idEntidade"] = $this->idsEntidades["municipio"];
        $data[1]["data"] = $municipalities;
        $data[2]["idEntidade"] = $this->idsEntidades["regiao_interesse"];
        $data[2]["data"] = $thematicAreas;
        $data[3]["idEntidade"] = $this->idsEntidades["rm"];
        $data[3]["data"] = $metropolitanAreas;
        $data[4]["idEntidade"] = $this->idsEntidades["udh"];
        $data[4]["data"] = $udh;
        $data[4]["idEntidade"] = $this->idsEntidades["regional"];
        $data[4]["data"] = $regional;

        $retorno = array(
            "data" => $data,
            "msg" => "Busca efetuada com sucesso.",
            "status" => true
        );
        return $retorno;
    }

    public function filterSearch($options = null) {
        $data = new stdClass();
        $ServiceSearch = new SearchEntitiesService();
        /* var_dump($options); */
        if ($options->idSelectorParent == $this->idsEntidades["municipio"]) {
            $data = $this->getDataFilterMunicipio($options);
        } else if ($options->idSelectorParent == $this->idsEntidades["udh"]) {
            $data = $this->getDataFilterUdh($options);
        } else if ($options->idSelectorParent == $this->idsEntidades["rm"]) {
            $objeto = new stdClass();
            $objeto->attr = array("id", "nome"); // se vazio pegar todas as colunas
            $objeto->longName = true; // Se longName true pega nome completo "REgião metropolitana de Belo Horizonte", se false ou não for informado pega nome curto 
            $objeto->lang = "pt-br"; //pt-br - Português Brasil, en - Inglês, esp - Espanhol
            $objeto->ativo = true; //se true pegar somente ativos, se false pegar somente desativos, se ñ informado pegar todos
            // $retornoRm = $this->getRm($objeto);
            $retornoRm = $ServiceSearch->getMetropolitanAreasFilter($objeto);
            $data->resultSearch = $retornoRm["data"];
            $data->idSelector = $this->idsEntidades["rm"];
            $data->title = "seletor_regioes_metropolitanas";
            $data->allItens = array("seletor_todas_rm", "seletor_brasil");
            $data->idItemSelector = -1;
            $data->idFilter = -1;
            $data->type = "data"; //campo para indicar que existe mais filtros a serem feitos
            $data->idSelectorParent = $this->idsEntidades["rm"];
        } else if ($options->idSelectorParent == $this->idsEntidades["estado"]) {
            // $data->resultSearch = $this->getEstados(array("estado.id","estado.nome"));
            $data->resultSearch = $ServiceSearch->getState(null);
            $data->idSelector = $this->idsEntidades["estado"];
            $data->title = "seletor_estado";
            $data->allItens = array("seletor_todos_estados", "seletor_brasil");
            $data->idItemSelector = -1;
            $data->idFilter = -1;
            $data->type = "data"; //campo para indicar que existe mais filtros a serem feitos
            $data->idSelectorParent = $this->idsEntidades["estado"];
        } else if ($options->idSelectorParent == $this->idsEntidades["regiao_interesse"]) {
            // $data->resultSearch = $this->getAreasTematicas(array("regiao_interesse.id","regiao_interesse.nome"));
            $data->resultSearch = $ServiceSearch->getThematicAreas(null);
            $data->idSelector = $this->idsEntidades["regiao_interesse"];
            $data->title = "seletor_tematico";
            $data->allItens = array("seletor_todas_areas_tematicas", "seletor_brasil");
            $data->idItemSelector = -1;
            $data->idFilter = -1;
            $data->type = "data"; //campo para indicar que existe mais filtros a serem feitos
            $data->idSelectorParent = $this->idsEntidades["regiao_interesse"];
        } else if ($options->idSelectorParent == $this->idsEntidades["regional"]) {
            // $data->resultSearch = $this->getAreasTematicas(array("regiao_interesse.id","regiao_interesse.nome"));
            $data = $this->getDataFilterRegional($options);
        }

        $retorno = array(
            "data" => $data,
            "msg" => "Busca efetuada com sucesso.",
            "status" => true
        );
        return $retorno;
    }

    private function getEntidadeById($id) {
        $retorno;
        foreach ($this->idsEntidades as $key => $value) {
            if ($value == $id) {
                $retorno = $key;
            }
        }
        return $retorno;
    }

    private function getDataFilterRegional($options = null) {

        $data = new stdClass();
        $data->title = "seletor_regionais";
        $ServiceSearch = new SearchEntitiesService();
        $data->idSelectorParent = $this->idsEntidades["regional"];

        if (property_exists($options, "idSelector")) { // filtros específicos
            $arrayWhere = array();

            if ($options->idSelector == $this->idsEntidades["municipio"]) {
                $table = $this->getEntidadeById($this->idsEntidades["municipio"]);
                $arrayWhere["fk_mun"] = $options->idItem;

                $data->allItens = array("seletor_todas_regionais", $options->nameFilter);
                // "Todos os municípios - " . $options->nameFilter;
                $data->type = "data";
                $data->idSelector = $this->idsEntidades["regional"];
                $data->idItemSelector = $options->idItem;
                $data->idFilter = $this->idsEntidades["municipio"];
                $data->arrayFilters = false;
                $params = new stdClass();
                $params->where = $arrayWhere;
                $data->resultSearch = $ServiceSearch->getRegional($params);
            } else if ($options->idSelector == $this->idsEntidades["rm"]) {
                /* var_dump($options); */
                $params = new stdClass();
                $params->distinct = true;
                $params->municipios = "all";
                $data->type = "filter";
                $data->idSelector = $this->idsEntidades["municipio"];
                $data->resultSearch = $ServiceSearch->getMunByRmByRegional($options->idItensSelector);
            }
            // $data->resultSearch = $this->select(array($table),array($table.".id",$table.".nome"))->where($arrayWhere)->orderBy($table.".nome","ASC")->doQuery();
        } else {//filtros gerais
            // $data->idSelector = $this->idsEntidades["regional"];			
            $data->allItens = array("seletor_todas_regionais", "seletor_brasil");
            // $data->resultSearch = $this->getEstados(array("estado.id","estado.nome"));
            $data->idSelector = $this->idsEntidades["municipio"];
            $data->idItemSelector = -1;
            $data->allItens = array("seletor_todos_municipios", "seletor_brasil");
            $data->idFilter = -1;
            $data->type = "filter"; //campo para indicar que existe mais filtros a serem feitos			
        }

        return $data;
    }

    private function getDataFilterMunicipio($options = null) {
        $data = new stdClass();
        $data->title = "seletor_municipios";
        $ServiceSearch = new SearchEntitiesService();
        $data->idSelectorParent = $this->idsEntidades["municipio"];
        if (property_exists($options, "idSelector")) { // filtros específicos
            $arrayWhere = array();

            if ($options->idSelector == $this->idsEntidades["estado"]) {
                $table = $this->getEntidadeById($this->idsEntidades["municipio"]);
                $arrayWhere["fk_estado"] = $options->idItem;

                $data->allItens = array("seletor_todos_municipios", $options->nameFilter);
                // "Todos os municípios - " . $options->nameFilter;
                $data->type = "data";
                $data->idSelector = $this->idsEntidades["municipio"];
                $data->idItemSelector = $options->idItem;
                $data->idFilter = $this->idsEntidades["estado"];
                $data->arrayFilters = false;
                $params = new stdClass();
                $params->where = $arrayWhere;
                $data->resultSearch = $ServiceSearch->getMunicipalities($params);
            } else if ($options->idSelector == $this->idsEntidades["rm"]) {
                $table = $this->getEntidadeById($this->idsEntidades["municipio"]);
                $arrayWhere["fk_rm"] = $options->idItem;

                $data->allItens = array("seletor_todos_municipios", $options->nameFilter);
                // $data->allItens = "Todos os municípios - " . $options->nameFilter;
                $data->idSelector = $this->idsEntidades["municipio"];
                $data->idItemSelector = $options->idItem;
                $data->idFilter = $this->idsEntidades["rm"];
                $data->type = "data";
                $data->arrayFilters = false;
                $params = new stdClass();
                $params->where = $arrayWhere;
                $data->resultSearch = $ServiceSearch->getMunicipalities($params);
                // $data->resultSearch = $this->select(array($table),array($table.".id",$table.".nome"))->where($arrayWhere)->orderBy($table.".nome","ASC")->doQuery();
            }
            // $data->resultSearch = $this->select(array($table),array($table.".id",$table.".nome"))->where($arrayWhere)->orderBy($table.".nome","ASC")->doQuery();
        } else {//filtros gerais
            $data->arrayFilters = array($this->idsEntidades["estado"], $this->idsEntidades["rm"], $this->idsEntidades["regiao_interesse"]);
            $data->resultSearch = $ServiceSearch->getState(null);
            // $data->resultSearch = $this->getEstados(array("estado.id","estado.nome"));
            $data->idSelector = $this->idsEntidades["municipio"];
            $data->idItemSelector = -1;
            $data->allItens = array("seletor_todos_municipios", "seletor_brasil");
            $data->idFilter = -1;
            $data->type = "filter"; //campo para indicar que existe mais filtros a serem feitos			
        }
        return $data;
    }

    private function getDataFilterUdh($options = null) {
        $data = new stdClass();

        $data->idSelectorParent = $this->idsEntidades["udh"];
        $ServiceSearch = new SearchEntitiesService();
        if (property_exists($options, "idSelector")) { // filtros específicos
            $arrayWhere = array();
            $table = "";
            if ($options->idSelector == $this->idsEntidades["rm"]) {
                $data->title = "seletor_udhs_regionais";
                $table = $this->getEntidadeById($this->idsEntidades["municipio"]);
                $arrayWhere["fk_rm"] = $options->idItem;
//				$data->allItens = array(
//					array("seletor_todas_udh", "seletor_rm_sigla", $options->nameFilter)
//					);
                $hasMunByRmByRegional = $ServiceSearch->getMunByRmByRegional($options->idItem);
                if (empty($hasMunByRmByRegional)) { //se a rm  não tem regional
                    $data->idsAllItens = array($this->idsEntidades["rm"]);
                    $data->arrayFilters = array($this->idsEntidades["municipio"]);
                } else { // se a rm tem regional
                    $data->allItens[] = array("seletor_todas_regionais", "seletor_rm_sigla", $options->nameFilter);
                    $data->idsAllItens = array($this->idsEntidades["rm"], $this->idsEntidades["regional"]);
                    $data->arrayFilters = array($this->idsEntidades["municipio"], $this->idsEntidades["regional"]);
                }
                $data->idSelector = $this->idsEntidades["municipio"];
                $data->idItemSelector = $options->idItem;
                $data->idFilter = $this->idsEntidades["rm"]; //id que demonstra que é pra pegar todas as udh (idSelectorParent) da rm(idFilter) do "acre"(idItemSelector) 
                $data->type = "filter";
            } else if ($options->idSelector == $this->idsEntidades["municipio"]) {
                $data->title = "seletor_udh_sigla_plural";
                $table = $this->getEntidadeById($this->idsEntidades["udh"]);
                $data->idSelector = $this->idsEntidades["udh"];
//				$data->allItens = array("seletor_todas_udh",$options->nameFilter);
                // $data->allItens = "Todas as U.D.H do município " . $options->nameFilter;
                $arrayWhere["fk_municipio"] = $options->idItem;
                $data->idItemSelector = $options->idItem;
                $data->idFilter = $this->idsEntidades["municipio"];
                $data->type = "data";
                $data->arrayFilters = false;
            }
            $data->resultSearch = $ServiceSearch->genericSearch($table, $arrayWhere);
            // $data->resultSearch = $this->select(array($table),array($table.".id",$table.".nome"))->where($arrayWhere)->orderBy($table.".nome","ASC")->doQuery();
        } else {//filtros gerais
            $data->title = "seletor_udhs_regionais";
            $objeto = new stdClass();
            $objeto->attr = array("id", "nome"); // se vazio pegar todas as colunas
            $objeto->longName = true; // Se longName true pega nome completo "REgião metropolitana de Belo Horizonte", se false ou não for informado pega nome curto 
            $objeto->lang = "pt-br"; //pt-br - Português Brasil, en - Inglês, esp - Espanhol
            $objeto->ativo = true; //se true pegar somente ativos, se false pegar somente desativos, se ñ informado pegar todos
            $retornoRm = $ServiceSearch->getMetropolitanAreasFilter($objeto);
            // $retornoRm = $this->getRm($objeto);
            $data->resultSearch = $retornoRm["data"];
            $data->idItemSelector = -1;
            $data->arrayFilters = array($this->idsEntidades["rm"]);
            $data->idSelector = $this->idsEntidades["rm"];
//			$data->allItens = array(
//				array("seletor_todas_udh","seletor_brasil"),
//				array("seletor_todas_regionais" , "seletor_brasil")
//				);
            $data->idsAllItens = array($this->idsEntidades["udh"], $this->idsEntidades["regional"]);
            // $data->allItens = "Todas as U.D.H do Brasil";
            $data->idFilter = -1;
            $data->type = "filter"; //campo para indicar que existe mais filtros a serem feitos	
        }
        return $data;
    }

    public function getRm($objeto = null) {
        $table = "rm";
        $ServiceSearch = new SearchEntitiesService();
        // $objeto = new stdClass();
        // $objeto->atributos = array("id","nome"); // se vazio pegar todas as colunas
        // $objeto->longName = true; // Se longName true pega nome completo "REgião metropolitana de Belo Horizonte", se false ou não for informado pega nome curto 
        // $objeto->lang = "pt-br"; //pt-br - Português Brasil, en - Inglês, esp - Espanhol
        // $objeto->ativo = true; //se true pegar somente ativos, se false pegar somente desativos, se ñ informado pegar todos
        foreach ($objeto->attr as $key => $value) {
            $objeto->attr[$key] = $table . "." . $value;
        }
        $isAtivo = $objeto->ativo;
        $arrayWhere = Array();
        if (!empty($isAtivo)) {//Coloca na clausula where se vai buscar os itens ativos ou inativos
            if ($isAtivo == TRUE)
                $arrayWhere["ativo"] = 1;
            else
                $arrayWhere["ativo"] = 0;
        } else
            $arrayWhere["ativo"] = 0;

        // por enquanto busca retornando as rm's corretas
        $data = $ServiceSearch->getRm($objeto, $arrayWhere);


        $retorno = array(
            "data" => $data,
            "msg" => "Busca efetuada com sucesso.",
            "status" => true
        );
        return $retorno;
    }

}

//RECEBER DADOS E ENVIAR PRO MÉTODO CORRETO DO CONTROLLER
//NO CONTROLLER ENVIAR OS DADOS CORRETOS PROS SERVICES CORRETOS
// NO SERVICE INTERAGIR COM O MODEL PARA FAZER A BUSCA
$contents = $_POST["data"];
$data = json_decode(stripslashes($contents));
$method = $data->method;
$search = new SearchEntitiesController();
if (!empty($method)) {
    $retorno = $search->$method($data->options);
    echo json_encode($retorno);
} else {
    $retorno = array(
        "data" => null,
        "status" => false,
        "msg" => "Método não encontrado."
    );
    echo json_encode($retorno);
}
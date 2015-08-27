<?php

//include_once("../../../../config/conexao.class.php");
require_once BASE_ROOT . "config/conexao.class.php";
    
class SearchEntitiesDAO {

    private $con;
    private $sql;
    private $where = 0;
    private $table;

    function __construct() {
        
        $this->con = new Conexao();
        print_r($this->con);
    }

    /*
     * Sugerir que sejam criados métodos para criação das querys ou buscar por um ORM
     */

    public function select($table, $arrayOptions = null, $distinct = null) {
        $this->sql = "SELECT ";
        if ($distinct === TRUE)
            $this->sql .= "DISTINCT ";
        $this->table = $table;
        $sizeOptions = count($arrayOptions);
        if ($arrayOptions != null && $sizeOptions > 0) {
            foreach ($arrayOptions as $key => $value) {
                if ($key == ($sizeOptions - 1))
                    $this->sql .= $value;
                else
                    $this->sql .= $value . ',';
            }
        }
        else {
            $this->sql .= " *";
        }
        $this->sql .= " FROM ";
        $sizeTables = count($table);
        $i = 0;
        foreach ($table as $key => $value) {
            if ($i == ($sizeTables - 1))
                $this->sql .= $value;
            else
                $this->sql .= $value . ",";
            $i++;
        }
        return $this;
    }

    public function where($arrayWhere = null, $table = null) {
        $sizeWhere = count($arrayWhere);
        if (!empty($table))
            $this->table[0] = $table;
        if ($arrayWhere != null && $sizeWhere > 0) {
            if ($this->where > 0)
                $this->sql .= " AND ";
            else
                $this->sql .= " WHERE ";
            $i = 0;
            foreach ($arrayWhere as $key => $value) {
                if ($i == ($sizeWhere - 1))
                    $this->sql .= $this->table[0] . "." . $key . " = '" . $value . "'";
                else
                    $this->sql .= $this->table[0] . "." . $key . " = '" . $value . "' AND ";
                $i++;
            }
            $this->where++;
        }

        return $this;
    }

    public function like($options = null) {
        if (!empty($options) && is_array($options)) {
            if ($this->where > 0)
                $this->sql .= " AND ";
            else
                $this->sql .= " WHERE ";
            foreach ($options as $key => $value) {
                $this->sql .= $key . " ILIKE '" . $value . "'";
            }
        }
        $this->where++;
        return $this;
    }

    public function innerJoin($tableInner = null, $arrayOn = null) {
        if ($tableInner != null) {
            $this->sql .= " INNER JOIN " . $tableInner . " ON ";
            foreach ($arrayOn as $key => $value) {
                $this->sql .= $key . " = " . $value;
            }
        }
        return $this;
    }

    public function orderBy($field, $order) {
        $this->sql .= " ORDER BY " . $field . " " . $order;
        return $this;
    }

    public function doQuery() {
        $this->where = 0;
        $runSql = pg_query($this->con->open(), $this->sql) or die("Nao foi possivel executar a consulta!");
        if (pg_affected_rows($runSql) > 0) {
            $response = array();
            // passando pelas linhas 
            while ($obj = pg_fetch_object($runSql)) {
                array_push($response, $obj);
            }
            return $response;
        } else
            return false;
    }

    private function getSearchWithLike($string, $like) {
        if (empty($like))
            $search = $string;
        else if ($like === "between")
            $search = "%" . $string . "%";
        else if ($like === "after")
            $search = $string . "%";
        else if ($like === "before")
            $search = "%" . $string;
        return $search;
    }

    //melhorar
    public function genericSearch($table, $where) {
        return $this->select(array($table), array($table . ".id", $table . ".nome"))->where($where)->orderBy($table . ".nome", "ASC")->doQuery();
    }

    //melhorar
    public function getRmFilter($objeto = null) {
        $table = "rm";

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
        $data = $this->select(array("rm"), $objeto->attr)->where($arrayWhere)->orderBy("rm.nome", "ASC")->doQuery();

        $retorno = array(
            "data" => $data,
            "msg" => "Busca efetuada com sucesso.",
            "status" => true
        );
        return $retorno;
    }

    public function getMunicipalities($arrayWhere) {
        if (empty($arrayWhere) OR count($arrayWhere) === 0)
            return false;
        else
            return $this->select(array("municipio"), array("municipio.id", "municipio.nome", "estado.uf"))->innerJoin("estado", array("municipio.fk_estado" => "estado.id"))->where($arrayWhere)->orderBy("municipio.nome", "ASC")->doQuery();
    }

    public function getAllMunicipalities() {
        return $this->select(array("municipio"), array("municipio.id", "municipio.nome", "estado.uf"))->innerJoin("estado", array("municipio.fk_estado" => "estado.id"))->orderBy("municipio.nome", "ASC")->doQuery();
    }

    public function getMunicipalitiesByName($municipioModel, $like = null) {
        $searchLike = $this->getSearchWithLike($municipioModel->nome, $like);
        $retorno = $this->select(array("municipio"), array("municipio.id", "municipio.nome", "estado.uf"))
                        ->innerJoin("estado", array("municipio.fk_estado" => "estado.id"))
                        ->like(array('municipio.nome' => $searchLike))->orderBy("municipio.nome", "ASC")->doQuery();

        return $retorno;
    }

    public function getAllStates() {
        return $this->select(array("estado"), array("estado.id", "estado.nome"))->orderBy("estado.nome", "ASC")->doQuery();
        ;
    }

    public function getStatesByName($stateModel, $like) {
        $searchLike = $this->getSearchWithLike($stateModel->nome, $like);
        return $this->select(array("estado"), array("estado.id", "estado.nome"))->like(array('estado.nome' => $searchLike))->orderBy("estado.nome", "ASC")->doQuery();
    }

    public function getAllThematicAreas() {
        return $this->select(array("regiao_interesse"), array("regiao_interesse.id", "regiao_interesse.nome"))->orderBy("regiao_interesse.nome", "ASC")->doQuery();
    }

    public function getThematicAreasByName($thematicAreaModel, $like = null) {
        $searchLike = $this->getSearchWithLike($thematicAreaModel->nome, $like);
        return $this->select(array("regiao_interesse"), array("regiao_interesse.id", "regiao_interesse.nome"))->like(array('regiao_interesse.nome' => $searchLike))->orderBy("regiao_interesse.nome", "ASC")->doQuery();
    }

    public function getAllMetropolitanAreas() {
        return $this->select(array("rm"), array("rm.id", "rm.nome"))->where(array("ativo" => true))->orderBy("rm.nome", "ASC")->doQuery();
    }

    public function getMetropolitanAreasByName($metropolitanAreaModel, $like = null) {
        $searchLike = $this->getSearchWithLike($metropolitanAreaModel->nome, $like);
        return $this->select(array("rm"), array("rm.id", "rm.nome"))->where(array("ativo" => true))->like(array('rm.nome' => '%' . $searchLike . '%'))->orderBy("rm.nome", "ASC")->doQuery();
    }

    public function getAllUdhs() {
        return $this->select(array("udh"), array("udh.id", "udh.nome"))->orderBy("udh.nome", "ASC")->doQuery();
    }

    public function getUdhsByName($udhModel, $like = null) {
        $searchLike = $this->getSearchWithLike($udhModel->nome, $like);
        return $this->select(array("udh"), array("udh.id", "udh.nome"))->like(array('udh.nome' => $searchLike))->orderBy("udh.nome", "ASC")->doQuery();
    }

    public function getAllRegionalMunicipalities($distinct = null) {
        return $this->select(array("regional"), array("municipio.id", "municipio.nome"), $distinct)->innerJoin("municipio", array("regional.fk_mun" => "municipio.id"))->orderBy("municipio.nome", "ASC")->doQuery();
    }

    public function getRegional($where = null) {
        $retorno = $this->select(array("regional"), array("regional.id", "regional.nome"))->where($where)->orderBy("regional.nome", "ASC")->doQuery();
        return $retorno;
    }

    public function getMunByRmByRegional($fk_rm) {
        $sql = $this->select(array("municipio"), array("municipio.id", "municipio.nome"), TRUE)->innerJoin("rm", array("rm.id" => "municipio.fk_rm"));
        $sql->innerJoin("regional", array("regional.fk_mun" => "municipio.id"))->where(array('id' => $fk_rm), "rm")->orderBy("municipio.nome", "ASC");
        return $sql->doQuery();
    }

    public function getRegionalByName($regionalModel, $like = null) {
        $searchLike = $this->getSearchWithLike($regionalModel->nome, $like);
        return $this->select(array("regional"), array("regional.id", "regional.nome"))->like(array('regional.nome' => $searchLike))->orderBy("regional.nome", "ASC")->doQuery();
    }

    public function getRm($objeto, $arrayWhere) {
        return $this->select(array("rm"), $objeto->attr)->where($arrayWhere)->orderBy("rm.nome", "ASC")->doQuery();
    }

}


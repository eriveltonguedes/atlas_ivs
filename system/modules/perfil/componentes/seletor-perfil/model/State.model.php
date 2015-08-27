<?php

class StateModel {

    private $id;
    private $the_geom;
    private $nome;
    private $uf;
    private $altitude;
    private $fk_regiao;
    private $fk_pais;
    private $latitude;
    private $longitude;
    private $distcap;
    private $zoom;

    public function __set($name, $value) {
        $this->$name = $value;
        return $this;
    }

    public function __get($name) {
        return $this->$name;
    }

}


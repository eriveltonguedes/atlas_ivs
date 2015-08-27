<?php

class UdhModel {

    private $id;
    private $cod_udhatlas;
    private $fk_municipio;
    private $the_geom;
    private $nome;
    private $cd_geocodm;
    private $regional;
    private $fk_rm;
    private $cod_ibge;

    public function __set($name, $value) {
        $this->$name = $value;
        return $this;
    }

    public function __get($name) {
        return $this->$name;
    }

}


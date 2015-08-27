<?php

/**
 * Entity espacialidade RM (Região Metropolitana).
 * 
 * @package map
 * @autor Thiago
 */
class Rm implements InterfaceEspacialidade
{

    /**
     * O id do RM.
     * 
     * @var int|string
     */
    private $id;

    /**
     * JSON que corresponde ao GeoJSON da espacialidade.
     * 
     * @var string 
     */
    private $geo_json;

    /**
     * Nome do RM.
     * 
     * @var string 
     */
    private $nome;

    /**
     * Setter id.
     * 
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Getter id.
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Setter nome.
     * 
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * Getter nome.
     * 
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Setter geo json.
     * 
     * @param string $geo_json
     */
    public function setGeoJson($geo_json)
    {
        $this->geo_json = $geo_json;
    }

    /**
     * Getter geo json.
     * 
     * @return string
     */
    public function getGeoJson()
    {
        return $this->geo_json;
    }

}

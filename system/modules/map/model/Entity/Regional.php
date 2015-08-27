<?php

/**
 * Entity espacialidade Regional.
 * 
 * @package map
 * @autor Thiago
 */
class Regional implements InterfaceEspacialidade
{

    /**
     * O id do UDH.
     * 
     * @var int|string
     */
    private $id;

    /**
     * Json que corresponde ao GeoJson da espacialidade.
     * 
     * @var string 
     */
    private $geo_json;

    /**
     * Nome do UDH.
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

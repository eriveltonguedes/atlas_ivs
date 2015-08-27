<?php

/**
 * Entity espacialidade RM (Região Metropolitana).
 * 
 * @package map
 * @autor Thiago
 */
class RmContexto implements InterfaceContexto
{

    /**
     * Largura da linha do contorno do mapa.
     * 
     * @var string|double 
     */
    private $largura_linha;

    /**
     * Latitude.
     * 
     * @var string|double 
     */
    private $lat;

    /**
     * Longitude.
     * 
     * @var string|double 
     */
    private $lng;

    /**
     * O id do Zoom.
     * 
     * @var int|string
     */
    private $id;

    /**
     * JSON que corresponde ao GeoJSON da espacialidade.
     * 
     * @var string 
     */
//    private $geo_json;

    /**
     * Nome do RM.
     * 
     * @var string 
     */
    private $nome;

    /**
     * Zoom do RM.
     * 
     * @var int 
     */
    private $zoom;

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
     * Setter cor preenchimento.
     * 
     * @param string $cor
     */
    public function setCorPreenchimento($cor)
    {
        $this->cor_preenchimento = $cor;
    }

    /**
     * Getter cor preenchimento.
     * 
     * @return string
     */
    public function getCorPreenchimento()
    {
        return $this->cor_preenchimento;
    }

//    /**
//     * Setter geo json.
//     * 
//     * @param string $geo_json
//     */
//    public function setGeoJson($geo_json)
//    {
//        $this->geo_json = $geo_json;
//    }
//
//    /**
//     * Getter geo json.
//     * 
//     * @return string
//     */
//    public function getGeoJson()
//    {
//        return $this->geo_json;
//    }

    /**
     * Setter cor linha.
     * 
     * @param string $cor
     */
    public function setCorLinha($cor)
    {
        $this->cor_linha = $cor;
    }

    /**
     * Getter cor linha.
     * 
     * @return string
     */
    public function getCorLinha()
    {
        return $this->cor_linha;
    }

    /**
     * Setter largura linha.
     * 
     * @param int $num
     */
    public function setLarguraLinha($num)
    {
        $this->largura_linha = $num;
    }

    /**
     * Getter largura linha.
     * 
     * @return int
     */
    public function getLarguraLinha()
    {
        return $this->largura_linha;
    }

    /**
     * Setter lat.
     * 
     * @param doubel $num
     */
    public function setLat($num)
    {
        $this->lat = $num;
    }

    /**
     * Getter lat.
     * 
     * @return double
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Setter lng.
     * 
     * @param double $num
     */
    public function setLng($num)
    {
        $this->lng = $num;
    }

    /**
     * Getter lng.
     * 
     * @return double
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Setter zoom.
     * 
     * @param int $num
     */
    public function setZoom($num)
    {
        $this->zoom = $num;
    }

    /**
     * Getter zoom.
     * 
     * @return int
     */
    public function getZoom()
    {
        return $this->zoom;
    }

}

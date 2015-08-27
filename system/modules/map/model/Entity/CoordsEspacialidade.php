<?php

/**
 * Coordenada da Espacialidade.
 * 
 * @package map
 * @autor AtlasBrasil
 */
class CoordsEspacialidade {

    /**
     * Longitude.
     * 
     * @var double
     */
    private $latitude = null;

    /**
     * Longitude.
     * 
     * @var double
     */
    private $longitude = null;

    /**
     * Latitude.
     * 
     * @param double|string $lat latitude
     */
    public function setLat($lat)
    {
        $this->latitude = $lat;
    }

    /**
     * Latitude.
     * 
     * @return $lat
     */
    public function getLat()
    {
        return floatval($this->latitude);
    }

    /**
     * Longitude
     * 
     * @return double
     */
    public function getLng()
    {
        return floatval($this->longitude);
    }

    /**
     * Longitude.
     * 
     * @param double|string $lng longitude
     */
    public function setLng($lng)
    {
        $this->longitude = $lng;
    }

}

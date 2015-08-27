<?php

/**
 * Interface entidade espacialidade.
 * 
 * @package map
 * @author AtlasBrasil
 */
interface InterfaceEspacialidade
{

    public function getId();

    public function getNome();

    public function getGeoJson();
}

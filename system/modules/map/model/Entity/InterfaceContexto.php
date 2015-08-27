<?php
/**
 * Interface entidade espacialidade.
 * 
 * @package map
 * @author AtlasBrasil
 */
interface InterfaceContexto
{

    public function getId();

    public function getNome();

    public function getCorPreenchimento();

    public function getCorLinha();

    public function getLarguraLinha();

    public function getLat();

    public function getLng();

    public function getZoom();
}

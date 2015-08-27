<?php 
class MunicipalitiesModel{
	private $id;
	private $the_geom;
	private $nome;
	private $fk_microregiao;
	private $fk_estado;
	private $latitude;
	private $longitude;
	private $altitude;
	private $anoinst;
	private $fk_rm;
	private $geocodmun;
	private $densidade;
	private $area;
	private $distancia_capital;
	private $the_geom_light;
	private $geocodmun6;
	
	public function __set($name, $value) {
        $this->$name = $value;
		return $this;
    }
 
    public function __get($name) {
        return $this->$name;
    }

		
}
?>
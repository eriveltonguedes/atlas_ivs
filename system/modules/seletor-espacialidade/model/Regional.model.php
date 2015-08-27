<?php 
class RegionalModel{
	private $id;
	private $nome;
	private $the_geom;
	private $fk_mun;
	private $cod_regatlas;
	private $cd_geocodm;
	
	public function __set($name, $value) {
        $this->$name = $value;
		return $this;
    }
 
    public function __get($name) {
        return $this->$name;
    }	
}
?>
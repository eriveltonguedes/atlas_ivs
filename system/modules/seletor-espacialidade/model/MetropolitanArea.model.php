<?php 
class MetropolitanAreaModel{
	private $id;
	private $nome;
	private $the_geom;
	private $lat;
	private $lon;
	private $nome_curto;
	private $zoom;
	private $cod_rmatlas;
	private $ativo;
	
	public function __set($name, $value) {
        $this->$name = $value;
		return $this;
    }
 
    public function __get($name) {
        return $this->$name;
    }	
}
?>
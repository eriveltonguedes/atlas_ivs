<?php
class ThematicAreaModel{
	private $id;
	private $nome;
	
	public function __set($name, $value) {
        $this->$name = $value;
		return $this;
    }
 
    public function __get($name) {
        return $this->$name;
    }	
	
}
?>
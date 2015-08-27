<?php

 require_once PERFIL_PACKAGE . "Block.class.php";
 //require_once PERFIL_PACKAGE . 'controller/chart/chartsPerfil.php';
 require_once PERFIL_PACKAGE . 'controller/Formulas.class.php';
 require_once PERFIL_PACKAGE . 'model/bd.class.php';
/**
 * Description of Texto
 *
 * @author Lorran
 */
    
class Texto extends Block {
    public $pTexto;
    private $templateHolder;
    
    static public $idMunicipio = 0;
    static public $nomeMunicipio = "";
    static public $ufMunicipio = "";
    private $bd;    
    static public $print;
    static public $lang;
    
    static public $fontePerfil = "Fonte: Pnud, Ipea e FJP"; //@#Menos template 5
    
    public function __construct($texto,$template = null) {
        //echo 'construtct Texto';
        $this->templateHolder = $template;
        
        if($template != null)
            parent::__construct($template);
        
        $this->pTexto = $texto;
    }

    public function __destruct() {
        
    }
    
    public function replaceTags($variavel, $valor){
        //echo 'replaceTags';
        $this->pTexto = str_replace("[$variavel]", $valor, $this->pTexto);
    }
    
    public function getTexto(){
        //echo 'getTexto';
        return $this->pTexto;
    }
    
    public function drawBlock(){
        //echo 'drawBlock';
        if($this->templateHolder != null)
            parent::draw();
    }
}

?>

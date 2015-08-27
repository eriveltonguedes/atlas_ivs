<?php
    
    class BlockTabela {
        
        private $boxes = array();
        private $rows;
        private $coluns;
        private $title;
        private $template;
        private $type;
        
        public function __construct($title, $rows, $coluns, $type) {
            $this->rows = $rows;
            $this->coluns = $coluns;
            $this->title = $title;
            $this->type = $type;
            $this->template = new Template(5);
        }
        
        public function addBox($title,$val){
            $this->boxes[] = new Box($title, $val, $this->type);
        }
        
        public function setManual($key,$val){
            $this->template->set($key, $val);
        }
        
        private function buildStruct(){
            $this->template->setTitle($this->title);
            $resultBuilder = "";
            for($i = 0, $k = 0; $i < $this->rows; $i++){
                $resultBuilder .= "<div class='clear'></div>";
                for($y = 0; $y < $this->coluns; $y++, $k++){
                    $resultBuilder .= $this->boxes[$k]->getContent();
                }
            }
            $this->template->set('blocks',$resultBuilder);
        }
        
        public function draw(){
            $this->buildStruct();
            echo $this->template->getHTML();
        }
    }
    
    class Box{
        
        private $title;
        private $val;
        private $template;
        
        public function __construct($_title,$_val, $type) {
            
            $this->title = $_title;
            $this->val = $_val;
            
            if ($type == "perfil_m"){           
                $this->template = new Template(14);
            }
            else if ($type == "perfil_uf"){
                $this->template = new Template(37);
            } 
            else if ($type == "perfil_rm"){
                $this->template = new Template(38);
            }
            else if ($type == "perfil_udh"){
                $this->template = new Template(39);
            } 
                
            $this->template->setTitle($_title);
            $this->template->set('valor',$_val);
        }
        
        public function getContent(){
            return $this->template->getHTML();
        }
    }
?>

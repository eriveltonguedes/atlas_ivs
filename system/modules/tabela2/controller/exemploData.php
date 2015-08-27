<?php
/*"columns": [
	            { "title": "Espacialidades" },
	            { "title": "indice 1" },
	            { "title": "indice 2" },
	            { "title": "indice 3", "class": "center" },
	            { "title": "indice 4", "class": "center" },
	            { "title": "indice 5", "class": "center" },
	            { "title": "indice 6", "class": "center" },
	            { "title": "indice 7", "class": "center" },
	            { "title": "indice 8", "class": "center" }
	        ],
	        "data" : [
	        	["Brasil","123","12312","12321","12321", "12312","12321","12321","12321"],
	        	["Brasil","123","12312","12321","12321", "12312","12321","12321","12321"],
	        	["Brasil","123","12312","12321","12321", "12312","12321","12321","12321"],
	        	["Brasil","123","12312","12321","12321", "12312","12321","12321","12321"],
	        ],*/
/*var_dump($_POST);*/
$object = new StdClass();
$object->data = array();
$object1 = new StdClass();
$object1->espacialidade = "Brasil";
$object1->indice1 = "Indice 1";
$object1->indice2 = "Indice 2";
$object1->indice3 = "Indice 3";
$object1->indice4 = "Indice 4";
$object1->indice5 = "Indice 5";
$object1->indice6 = "Indice 6";
$object1->indice7 = "Indice 7";
$object1->indice8 = "Indice 8";
$object1->id = 1;

$object->data = array();	
array_push($object->data,$object1);
echo json_encode($object);
?>
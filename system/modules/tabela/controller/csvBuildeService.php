<?php   

require_once "../../../../config/config_path.php";
require_once "../../../../com/mobiliti/consulta/bd.class.php";
require_once "../../../../com/mobiliti/consulta/Consulta.class.php";

$result = $_POST['var'];

$json_lugares = array();
$json_lugares[] = array("e"=>"10","ids"=>"103");
foreach($_POST['json_lugares'] as $key){
	$json_lugares[] = $key;
}

$json_indicadores = $_POST['json_indicadores'];

if(isset($_POST['atord']))
		$atord = $_POST['atord'];
	else 
		$atord = null;
		
$nome = PublicMethods::nameJson($json_lugares, $json_indicadores);
    
    
//function array2csv(array &$array,$nom)
function array2csv($array,$nom)
{
   if (count($array) == 0) {
     return null;
   }
   
   ob_start();
   //$df = fopen("php://output", 'w');
   //$df = fopen("/tmp/aa.csv", 'w');
   $df = fopen('../../../preconsultas/consultas/'.$nom.".csv", 'w');
   //die($df);
   //fputcsv($df, array_keys(reset($array)),";");
   //fprintf($df, chr(0xEF).chr(0xBB).chr(0xBF));
   //$array = "\xEF\xBB\xBF".$array;
   //$array = iconv("UTF-8", "Windows-1252", $array);
   //die(var_dump($array));
   $array = encode_items($array);
   foreach ($array as $row) {
	 //$row = iconv("UTF-8", "Windows-1252", $row);
	 //die(var_dump($row));
      fputcsv($df, $row,";",'"');
   }
   
   fclose($df);
   
   return ob_get_clean();
}

function encode_items($array){
    foreach($array as $key => $value){
        if(is_array($value)){
            $array[$key] = encode_items($value);
        }else{
            $array[$key] = mb_convert_encoding($value, 'Windows-1252', 'UTF-8');
        }
    }
    return $array;
}

function download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    //header('Content-Type: text/html; charset=utf-8');
    header('Content-Type: text/html; charset=ANSI');
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    //header("Content-Type: application/force-download");
    //header("Content-Type: application/octet-stream");
    //header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    //header("Content-Transfer-Encoding: binary");
    //header("Content-Transfer-Encoding: UTF-8");
    header("Content-Transfer-Encoding: ANSI");
}

download_send_headers($nome.".csv");
//die(var_dump($result));
array2csv($result,$nome);

echo $nome;
die();
?>

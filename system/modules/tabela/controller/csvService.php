<?php   

    require_once "../../../../config/config_path.php";
    require_once "../../../../config/config_gerais.php";
//     if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
//         header("Location: {$path_dir}404");
//     }
    ini_set( "display_errors", 1);
    ini_set('memory_limit', '-1');
    //ob_start("ob_gzhandler");
    require_once '../../../../config/conexao.class.php';
    require_once '../util/protect_sql_injection.php';
//     require_once MOBILITI_PACKAGE.'util/protect_sql_injection.php';
    require_once "../consulta/bd.class.php";
	require_once "../consulta/man_bd.class.php";
    require_once "../consulta/Consulta.class.php";
    require_once "../model/tabelaDAO.php";
    $result = array();
    $resp = array();
    $json_lugares = array();
    //$json_lugares[] = array("e"=>"10","ids"=>"103");
    $json_lugares[] = array("e"=>"10","ids"=>"103","mun"=>"","est"=>"","rm"=>"","udh"=>"");
    foreach($_POST['json_lugares'] as $key){
        $json_lugares[] = $key;
    }
    
    $json_indicadores = $_POST['json_indicadores'];
    $colDownload = $_POST['col_download'];
    //die($colDownload);
    //$count_lugs = (int) $_POST['count_lugs'];

   //die(var_dump($json_lugares));

   $atpagina = (int) $_POST['atpagina'];
   
   if(isset($_POST['atord']))
		$atord = $_POST['atord'];
	else 
		$atord = null;
			
    $nome = PublicMethods::nameJson($json_lugares, $json_indicadores);
    
    $arrayConsulta = PublicMethods::TranslateTabela($json_lugares,$json_indicadores);
    $arrayConsulta2 = array();
    $arrayConsulta2[] = $json_lugares;
    $arrayConsulta2[] = $json_indicadores;
    
    if(false){
		if(file_exists('../../../preconsultas/consultas/'.$nome.".txt.gz")){
			$myFile = '../../../preconsultas/consultas/'.$nome.".txt.gz";
			$fh = gzopen ($myFile, 'r');
			$theData = gzpassthru($fh);
			die();
		}
    }
    
    if(file_exists('../../../preconsultas/consultas/'.$nome.".csv")){
		echo $nome;
		die();
	}
    
    if(isset($_POST['json_search_names']))
        $searchName = true;
    else{
        $searchName = false;
    }
    $varReturn = false;
    if(isset($_POST['dataBring']) && $_POST['dataBring'] == "var_only"){       
        $varReturn = true;
    }
    
    $ObjConsulta = Consulta::tableParse($arrayConsulta);
    $tab = new Tabela($ObjConsulta[0], $arrayConsulta2, $atpagina, $atord, LIMITE_EXIBICAO_TABELA, $varReturn, $searchName);
    $tab->DrawTabela();
        
    if(!$varReturn){
        if(is_array(Tabela::$JSONSaved)){
            foreach(Tabela::$JSONSaved as $key){
                foreach($key as $key2=>$val2){
                    $result[$key2] = $val2;
                }
            }
        }
    }
    else{
        foreach(Tabela::$JSONSaved as $key){
            foreach($key as $key2=>$val2){
                $result[] = $val2;
            }
        }
    }
    
    $result['nomevariaveis'] = Tabela::$JSONSavedIndicadores;
	
	//die(var_dump($result));

    //$json = json_encode($result);
    if(false){
		$file = '../../../preconsultas/consultas/'.$nome.".txt.gz";
		$handle = fopen($file, 'w'); //or die("erro");
		$stringData = gzencode($json,9);
		fwrite($handle, $stringData);
		fclose($handle);
	}
    //echo $json;
	//die();
	
	function object_to_array($data) {
        if (is_array($data) || is_object($data)) {
            $result = array();
            foreach ($data as $key => $value) {
                $result[$key] = object_to_array($value);
            }
            return $result;
        }
        return $data;
    }
    
	
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
   //fputcsv($df, array_keys(reset($array)),";");
   //$array = iconv("UTF-8", "Windows-1252", $array);
   $array = encode_items($array);
   foreach ($array as $row) {
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
    //header("Content-Disposition: attachment;filename={$filename}");
    //header("Content-Transfer-Encoding: binary");
    //header("Content-Transfer-Encoding: UTF-8");
    header("Content-Transfer-Encoding: ANSI");
}

function ordenarV($result){
	$A= array();
	$put= array();
	array_push($put,$GLOBALS['colDownload']);
	array_push($put,"COD IBGE");
	//array_push($put,$lang_mng->getString("col_download_csv"));
	
	if(false)
	foreach($result["nomevariaveis"] as $val){
		//die(var_dump($val[1]));
		//if(isset($val["nome"]))
		array_push($put,$val["nomecurto"]);
		//if(isset($val["nomevariaveis"]))
			//$put[]=utf8_decode(Tabela::$JSONSavedIndicadores[$val[0]]["nomecurto"])." (1991),";
	}
	
	foreach($result as $val){
		if(isset($val["nome"])){
			ksort($val["vs"]);
			foreach($val["vs"] as $va){
				$ano='';
				if($va["ka"]==1){
					$ano='1991';
				}else if($va["ka"]==2){
					$ano='2000';
				}else{
					$ano='2010';
				}
				foreach($result["nomevariaveis"] as $vall){
					if($va["iv"]==$vall["id"]){
						array_push($put,$vall["nomecurto"]." (".$ano.")");
						break;
					}
				}
				//die(var_dump($put));
			}
			break;
		}
	}
	//die(var_dump($put));

	array_push($A,$put);
	$put= array();
	foreach($result as $val){
		if(isset($val["nome"])){
			
			if(isset($val["uf"])) array_push($put,$val["nome"]." (".$val["uf"].")");
			else if(isset($val["rm"])){
				if(trim($val["nome"])=="Distrito Federal e Entorno")
					array_push($put,"RIDE ".$val["nome"]);
					else array_push($put,"RM ".$val["nome"]);
			}
			else array_push($put,$val["nome"]);
			
			if(isset($val["cod"])) array_push($put,$val["cod"]);
			else array_push($put,'--');
			
			ksort($val["vs"]);
			foreach($val["vs"] as $va){
					//array_push($put,$va["v"]);
					if($va["v"]!="")
						array_push($put,str_replace(".",",",$va["v"]));
					else array_push($put,'--');
			}
			array_push($A,$put);
			$put= array();
		}
	}
	array_push($A,$put);
	return $A;
}

download_send_headers($nome.".csv");

array2csv(ordenarV($result),$nome);

//array2csv($result,$nome);

//echo $json;
echo $nome;
die();
?>

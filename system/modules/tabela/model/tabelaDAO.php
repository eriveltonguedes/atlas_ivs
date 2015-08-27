<?php
    /**
      * Created on 18/02/2013
      *
      * Classe para manipular a tabela .
      * Colocarei 't' no inicio de cada variável que vai ser recebida por parametro.
      * Maiscula em cada inicio de palavra
      * 
      * @author Valter Lorran (valter@mobilidade-ti.com.br)
      * @version 1.0.0
      *
      */

    function cutNumber($num,$casas_decimais,$d = null,$f = null){
//        $num = str_replace(".", ",", $num);
        if(!strpos($num, '.')){
            return $num;
        }
        $ex = explode('.', $num);
        if(strlen($ex[1]) >= $casas_decimais){
            return substr($num,0,strpos($num,'.')+$casas_decimais+1);
        }else{
            $con = "";
            for($diff = $casas_decimais-  strlen($ex[1]); $diff > 0; $diff--){
                $con .= "0";
            }
            return $num.$con;
        }
    }
    class Tabela extends bd
    {
        public static $JSONSaved;
        public static $JSONSavedIndicadores;
        //public static $lang;
        /**
            * Armazema o controlador da consulta
            * @var Consulta
            */
        private $consulta;
        
        /**
            * Armazema a quantidade de municpios a ser exibido
            * @var int
            */
        private $LimiteExibicao;
        
        /**
            * Página atual da consulta
            * @var int
            */
        private $PaginaAtual;
        
        private $Count;
        
        private $results;
        
        private $Esp;
        
        private $varOnly;
        
        private $isSearchName;
        /**
         * 
         * Classe para manipular a tabela.
         * @param UrlController $iConsulta Aqui você passa o objeto UrlController
         * @param int $iLimiteExibicao Quantidade de cidades que podem ser exibidas 
         * ao mesmo tempo
         * @param int $iPaginaAtual página atual para pesquisa
         * @param string $iOrderBy Ordenação da tabela
         */
        public function __construct($iConsulta, $arrayAreas, $atpagina, $atord, $iLimiteExibicao,$_varOnly,$isSearchName)
        {
            try
            {
                $iPaginaAtuall = 300;
                $iEsp = 1;
                //die(var_dump($iConsulta));
                parent::__construct();
                $this->varOnly = $_varOnly;
                $this->consulta = $iConsulta;
                $this->LimiteExibicao = $iLimiteExibicao;
                $this->PaginaAtual = $iPaginaAtuall;
                $this->isSearchName = $isSearchName;
                $this->Esp = $iEsp;
                //$IntLimit = $this->LimiteExibicao;
                
                $this->Count = 0;
                $sqlSecundaria = $this->getSQLSecundarioCC($arrayAreas,$atpagina,$atord);
                $this->getSQLResultsSecundarioCC($this->results,$sqlSecundaria);
            }  catch (Exception $e){
                die("erro :-)");
            }
        }
        
        public function DrawTabela()
        {
            Tabela::$JSONSavedIndicadores = $this->getNomeVariaveis();
            if(!$this->varOnly)
                Tabela::$JSONSaved[] = $this->results;
            else
                Tabela::$JSONSaved[] = $this->results;
        }
        
        private function setArrayValoresVariaveis($Array) {
            $this->ArrayValoresVariaveis = $Array;
        }
        
        private function getSQLMain($IdVariavel,$AnoVariavel){
            $ParteInicialSQL = "";
            $SQLVariaveis = array();
            die(var_dump($IdVariavel));
            $ParteInicialSQL = $this->getSelect();
            $SQL1 = $this->getSelectFiltroMain();
            if($SQL1 == "")
                $SQL1 = "1=1";
            if(!is_null($IdVariavel) && !is_null($AnoVariavel))
                $SQL2 = "(fk_ano_referencia = $AnoVariavel AND fk_variavel = $IdVariavel)";
            else
                $SQL2 = "(fk_ano_referencia = 1 AND fk_variavel = 185)";
            //die("outro $ParteInicialSQL ($SQL1) and ($SQL2)");
            return "$ParteInicialSQL ($SQL1) and ($SQL2)";
        }
        
        private function iGetSQLSecundarioCC($Array,$pg,$ordi){
			//die(var_dump($Array));
            
            $ind=0;
            $lista = explode(",", $Array[1]);
			foreach($lista as $key){
				list($kaa, $ivv) = explode(";", $key);
				$SQLVariaveis[] = "(fk_ano_referencia = $kaa AND fk_variavel = $ivv)";
				$ind++;
			}
			$SQL2 = implode(' OR ',$SQLVariaveis);
            
            if(strlen($ordi)){
				list($ivv, $kaa, $ordm) = explode("_", $ordi);
				if(!$kaa and !$ivv) 
					$ORDER = "ORDER BY country desc, udh $ordm, rm $ordm, u $ordm, uf $ordm, nome $ordm";
				else{
					$ORDER = " ORDER BY country desc, iv=$ivv DESC,ka=$kaa DESC,v $ordm ,nome";
					
					if($pg!=-1){
						$ParteInicialSQL2 = $this->iGetSQLSecundarioCCC($Array,$pg,$ordi);
						//die("$ParteInicialSQL2 $ORDER");
						return "$ParteInicialSQL2 $ORDER";
					}
				}
			}else
				$ORDER = "ORDER BY country desc, udh asc, rm asc, u asc, uf asc, nome asc";
			
			
            $ParteInicialSQL = $this->getSelectCC();
            
            $SQLVariaveis = array();
            $ests=0;
            $muns=0; $muns_e=0; $muns_r=0;
            $pais=0;
            $rms=0;
            $udhs=0; $udhs_r=0; $udhs_m=0;
            $ris=0;
            $regis=0; $regis_m=0; $regis_r=0;
            //die(var_dump($Array[0]));
            foreach($Array[0] as $val)
                    if($val['e']==2){
						if(strlen($val['est'])) $muns_e = $val['est'];
						if(strlen($val['rm']))	$muns_r = $val['rm'];
						if(strlen($val['ids']))	$muns = $val['ids'];
					}elseif($val['e']==3){
						if(strlen($val['ids'])) $regis = $val['ids'];
						if(strlen($val['mun'])) $regis_m = $val['mun'];
						if(strlen($val['rm']))	$regis_r = $val['rm'];
                    }elseif($val['e']==4){
						if(strlen($val['ids']))$ests = $val['ids'];
                    }elseif($val['e']==5){
						if(strlen($val['rm'])) $udhs_r = $val['rm'];
						if(strlen($val['mun']))	$udhs_m = $val['mun'];
						if(strlen($val['ids']))	$udhs = $val['ids'];
                    }elseif($val['e']==6){
						if(strlen($val['ids'])) $rms = $val['ids'];
                    }elseif($val['e']==7){
						if(strlen($val['ids'])) $ris = $val['ids'];
                    }elseif($val['e']==10){
						if(strlen($val['ids'])) $pais = $val['ids'];
					}
     
            if($muns=='-1')
					$ParteInicialSQL = str_replace("%municipios%", "fk_municipio in (select id from municipio) and ($SQL2)", $ParteInicialSQL);
			elseif($muns!=0 || $muns_r!=0 || $muns_e!=0)
				$ParteInicialSQL = str_replace("%municipios%", "(fk_municipio in ($muns) or fk_rm in ($muns_r) or fk_estado in ($muns_e)) and ($SQL2)", $ParteInicialSQL);
			else
				$ParteInicialSQL = str_replace("%municipios%", "fk_municipio in (0)", $ParteInicialSQL);
        
			if($ris=='-1')
				$ParteInicialSQL = str_replace("%ris%", "fk_regiao_interesse in (select id from regiao_interesse) and ($SQL2)", $ParteInicialSQL);
			elseif($ris!=0)
				$ParteInicialSQL = str_replace("%ris%", "fk_regiao_interesse in ($ris) and ($SQL2)", $ParteInicialSQL);
			else
				$ParteInicialSQL = str_replace("%ris%", "fk_regiao_interesse in (0)", $ParteInicialSQL);
		
			if($ests=='-1')
				$ParteInicialSQL = str_replace("%estados%", "fk_estado in (select id from estado) and ($SQL2)", $ParteInicialSQL);
			elseif($ests!=0)
				$ParteInicialSQL = str_replace("%estados%", "fk_estado in ($ests) and ($SQL2)", $ParteInicialSQL);
			else
				$ParteInicialSQL = str_replace("%estados%", "fk_estado in (0)", $ParteInicialSQL);
		
			if($udhs=='-1')
				$ParteInicialSQL = str_replace("%udhs%", "fk_udh in (select id from udh) and ($SQL2)", $ParteInicialSQL);
			elseif($udhs!=0 || $udhs_m!=0 || $udhs_r!=0)
				$ParteInicialSQL = str_replace("%udhs%", "(fk_udh in ($udhs) or fk_rm in ($udhs_r) or fk_municipio in ($udhs_m)) and ($SQL2)", $ParteInicialSQL);
			else
				$ParteInicialSQL = str_replace("%udhs%", "fk_udh in (0)", $ParteInicialSQL);
          
          	if($rms=='-1')
				$ParteInicialSQL = str_replace("%rms%", "fk_rm in (select id from rm where ativo is true) and ($SQL2)", $ParteInicialSQL);
			elseif($rms!=0)
				$ParteInicialSQL = str_replace("%rms%", "fk_rm in ($rms) and ($SQL2)", $ParteInicialSQL);
			else
				$ParteInicialSQL = str_replace("%rms%", "fk_rm in (0)", $ParteInicialSQL);
          	
          	if($regis=='-1')
				$ParteInicialSQL = str_replace("%regis%", "fk_regional in (select id from regional) and ($SQL2)", $ParteInicialSQL);
			elseif($regis!=0 || $regis_m!=0 || $regis_r!=0)
				$ParteInicialSQL = str_replace("%regis%", "(fk_regional in ($regis) or fk_mun in ($regis_m) or fk_rm in ($regis_r)) and ($SQL2)", $ParteInicialSQL);
			else
				$ParteInicialSQL = str_replace("%regis%", "fk_regional in (0)", $ParteInicialSQL);
		
			if($pais!=0)
				$ParteInicialSQL = str_replace("%paises%", "fk_pais in ($pais) and ($SQL2)", $ParteInicialSQL);
            else
				$ParteInicialSQL = str_replace("%paises%", "fk_pais in (0)", $ParteInicialSQL);
            
				
            $lim = 20*$ind;
            if($pg==-1)
				$LIMIT ="";
            elseif($pg == 1 || $pg == 0)
				$LIMIT = " LIMIT $lim OFFSET 0";
			else
				$LIMIT = "LIMIT $lim OFFSET ($lim*$pg)-$lim";
			
			//die("$ParteInicialSQL $ORDER $LIMIT");
            return "$ParteInicialSQL $ORDER $LIMIT";
        }
        
        private function iGetSQLSecundarioCCC($Array,$pg,$ordi){
			//die(var_dump($Array));
            
            $SQLVariaveis = array();
            $ind=0;
            $lista = explode(",", $Array[1]);
			foreach($lista as $key){
				list($kaa, $ivv) = explode(";", $key);
				$SQLVariaveis[] = "(fk_ano_referencia = $kaa AND fk_variavel = $ivv)";
				$ind++;
			}
			$SQL2 = implode(' OR ',$SQLVariaveis);
            
			$ParteInicialSQL5 = $this->iGetSQLSecundarioCC2($Array,$pg,$ordi);
			//die("$ParteInicialSQL5");
			$cquery = parent::ExecutarSQL($ParteInicialSQL5,"iRunSQLSecundario22");
				
            $ests=array();
            $muns=array();
            $pais=array();
            $rms=array();
            $udhs=array();
            $ris=array();
            $regis=array();
            
			foreach($cquery as $key=>$val){
				$va=substr($val['im'], -1);
				if('e' == $va )
					$ests[] = substr_replace($val['im'],'',-1);
				if('p' == $va )
					$pais[] = substr_replace($val['im'],'',-1);
				if('r' == $va )
					$rms[] = substr_replace($val['im'],'',-1);
				if('g' == $va )
					$regis[] = substr_replace($val['im'],'',-1);
				if('m' == $va )
					$muns[] = substr_replace($val['im'],'',-1);
				if('u' == $va )
					$udhs[] = substr_replace($val['im'],'',-1);	
			}
            
           $ParteInicialSQL = $this->getSelectCC();
            
           if(sizeof($muns)){
				$muns  =  join(",", $muns);
				$ParteInicialSQL = str_replace("%municipios%", "fk_municipio in ($muns) and ($SQL2)", $ParteInicialSQL);
           }else
				$ParteInicialSQL = str_replace("%municipios%", "fk_municipio in (0)", $ParteInicialSQL);
           
           //if(sizeof($ris))
			//	$ParteInicialSQL = str_replace("%ris%", "($ris) and ($SQL2)", $ParteInicialSQL);
		   //else
				$ParteInicialSQL = str_replace("%ris%", "fk_regiao_interesse in (0)", $ParteInicialSQL);
		   
		   if(sizeof($ests)){
			   $ests  =  join(",", $ests);
			   $ParteInicialSQL = str_replace("%estados%", "fk_estado in ($ests) and ($SQL2)", $ParteInicialSQL);
		   }else
			   $ParteInicialSQL = str_replace("%estados%", "fk_estado in (0)", $ParteInicialSQL);
			
           if(sizeof($udhs)){
			   $udhs  =  join(",", $udhs);
			   $ParteInicialSQL = str_replace("%udhs%", "fk_udh in ($udhs) and ($SQL2)", $ParteInicialSQL);
           }else
			   $ParteInicialSQL = str_replace("%udhs%", "fk_udh in (0)", $ParteInicialSQL);
            
           if(sizeof($rms)){
			   $rms  =  join(",", $rms);
			   $ParteInicialSQL = str_replace("%rms%", "fk_rm in ($rms) and ($SQL2)", $ParteInicialSQL);
           }else
			   $ParteInicialSQL = str_replace("%rms%", "fk_rm in (0)", $ParteInicialSQL);
           
           if(sizeof($regis)){
			   $regis  =  join(",", $regis);
			   $ParteInicialSQL = str_replace("%regis%", "fk_regional in ($regis) and ($SQL2)", $ParteInicialSQL);
           }else
			   $ParteInicialSQL = str_replace("%regis%", "fk_regional in (0)", $ParteInicialSQL);
            
           if(sizeof($pais)){
			   $pais  =  join(",", $pais);
			   $ParteInicialSQL = str_replace("%paises%", "fk_pais in ($pais) and ($SQL2)", $ParteInicialSQL);
           }else
			   $ParteInicialSQL = str_replace("%paises%", "fk_pais in (0)", $ParteInicialSQL);
            
				
			//die("$ParteInicialSQL $ORDER");
            //return "$ParteInicialSQL $ORDER $LIMIT";
            return "$ParteInicialSQL";
        }
        
        private function iGetSQLSecundarioCC2($Array,$pg,$ordi){

            $ParteInicialSQL = $this->getSelectCCP();
            
            $SQLVariaveis = array();
            $ests=0;
            $muns=0; $muns_e=0; $muns_r=0;
            $pais=0;
            $rms=0;
            $udhs=0; $udhs_r=0; $udhs_m=0;
            $ris=0;
            $regis=0; $regis_m=0;
            
            foreach($Array[0] as $val)
                    if($val['e']==2){
						if(strlen($val['est'])) $muns_e = $val['est'];
						if(strlen($val['rm']))	$muns_r = $val['rm'];
						if(strlen($val['ids']))	$muns = $val['ids'];
					}elseif($val['e']==3){
						if(strlen($val['ids'])) $regis = $val['ids'];
						if(strlen($val['mun'])) $regis_m = $val['mun'];
                    }elseif($val['e']==4){
						if(strlen($val['ids']))$ests = $val['ids'];
                    }elseif($val['e']==5){
						if(strlen($val['rm'])) $udhs_r = $val['rm'];
						if(strlen($val['mun']))	$udhs_m = $val['mun'];
						if(strlen($val['ids']))	$udhs = $val['ids'];
                    }elseif($val['e']==6){
						if(strlen($val['ids'])) $rms = $val['ids'];
                    }elseif($val['e']==7){
						if(strlen($val['ids'])) $ris = $val['ids'];
                    }elseif($val['e']==10){
						if(strlen($val['ids'])) $pais = $val['ids'];
					}

            
            list($ivv, $kaa, $ordm) = explode("_", $ordi);
            
			$SQL2 = "fk_ano_referencia = {$kaa} AND fk_variavel = {$ivv}";
			
			if($muns=='-1')
					$ParteInicialSQL = str_replace("%municipios%", "fk_municipio in (select id from municipio) and ($SQL2)", $ParteInicialSQL);
			elseif($muns!=0 || $muns_r!=0 || $muns_e!=0)
				$ParteInicialSQL = str_replace("%municipios%", "(fk_municipio in ($muns) or fk_rm in ($muns_r) or fk_estado in ($muns_e)) and ($SQL2)", $ParteInicialSQL);
			else
				$ParteInicialSQL = str_replace("%municipios%", "fk_municipio in (0)", $ParteInicialSQL);
        
			if($ris=='-1')
				$ParteInicialSQL = str_replace("%ris%", "fk_regiao_interesse in (select id from regiao_interesse) and ($SQL2)", $ParteInicialSQL);
			elseif($ris!=0)
				$ParteInicialSQL = str_replace("%ris%", "fk_regiao_interesse in ($ris) and ($SQL2)", $ParteInicialSQL);
			else
				$ParteInicialSQL = str_replace("%ris%", "fk_regiao_interesse in (0)", $ParteInicialSQL);
		
			if($ests=='-1')
				$ParteInicialSQL = str_replace("%estados%", "fk_estado in (select id from estado) and ($SQL2)", $ParteInicialSQL);
			elseif($ests!=0)
				$ParteInicialSQL = str_replace("%estados%", "fk_estado in ($ests) and ($SQL2)", $ParteInicialSQL);
			else
				$ParteInicialSQL = str_replace("%estados%", "fk_estado in (0)", $ParteInicialSQL);
		
			if($udhs=='-1')
				$ParteInicialSQL = str_replace("%udhs%", "fk_udh in (select id from udh) and ($SQL2)", $ParteInicialSQL);
			elseif($udhs!=0 || $udhs_m!=0 || $udhs_r!=0)
				$ParteInicialSQL = str_replace("%udhs%", "(fk_udh in ($udhs) or fk_rm in ($udhs_r) or fk_municipio in ($udhs_m)) and ($SQL2)", $ParteInicialSQL);
			else
				$ParteInicialSQL = str_replace("%udhs%", "fk_udh in (0)", $ParteInicialSQL);
          
          	if($rms=='-1')
				$ParteInicialSQL = str_replace("%rms%", "fk_rm in (select id from rm where ativo is true) and ($SQL2)", $ParteInicialSQL);
			elseif($rms!=0)
				$ParteInicialSQL = str_replace("%rms%", "fk_rm in ($rms) and ($SQL2)", $ParteInicialSQL);
			else
				$ParteInicialSQL = str_replace("%rms%", "fk_rm in (0)", $ParteInicialSQL);
          	
          	if($regis=='-1')
				$ParteInicialSQL = str_replace("%regis%", "fk_regional in (select id from regional) and ($SQL2)", $ParteInicialSQL);
			elseif($regis!=0 || $regis_m!=0)
				$ParteInicialSQL = str_replace("%regis%", "(fk_regional in ($regis) or fk_mun in ($regis_m)) and ($SQL2)", $ParteInicialSQL);
			else
				$ParteInicialSQL = str_replace("%regis%", "fk_regional in (0)", $ParteInicialSQL);
		
			if($pais!=0)
				$ParteInicialSQL = str_replace("%paises%", "fk_pais in ($pais) and ($SQL2)", $ParteInicialSQL);
            else
				$ParteInicialSQL = str_replace("%paises%", "fk_pais in (0)", $ParteInicialSQL);
            	
			//$ORDER = " ORDER BY country desc, iv=$ivv DESC,ka=$kaa DESC,v $ordm ";	
			$ORDER = " ORDER BY country desc, v $ordm ";	
			
			//die("$ParteInicialSQL");
            $lim = 20;
            if($pg <= 1){
				$pg = 0;
				$LIMIT = "LIMIT $lim OFFSET $pg";
			}else
				$LIMIT = "LIMIT $lim OFFSET ($lim*$pg)-$lim";
            //die("$ParteInicialSQL $ORDER $LIMIT");
            return "SELECT distinct (im) FROM ( $ParteInicialSQL $ORDER $LIMIT ) as tot2";
            
        }
                
        private function getNomeVariaveis(){
            //$ltemp = Tabela::$lang;
            $Indicadores = $this->consulta->getIndicadores();
            for($x = 0; $x < count($Indicadores);$x++){
                $tmp_indcs[] = $Indicadores[$x]->getIndicador();
            }
            $str = implode(',',$tmp_indcs);
            //$SQL = "SELECT lang_var.nomecurto,variavel.sigla,variavel.id,lang_var.definicao FROM variavel INNER JOIN lang_var on (variavel.id = lang_var.fk_variavel) WHERE variavel.id IN ($str) and lang_var.lang ILIKE '$ltemp' ORDER BY variavel.id";
            $SQL = "SELECT nomecurto,sigla,id,definicao FROM variavel WHERE id IN ($str) ORDER BY id";
            return parent::ExecutarSQLByIndex($SQL,'id',"getNomeVariavels");
        }
        /**
         * Pega o retorno do SQL
         * @param string $SQL recebe a sql e executa
         * @example <br />array(1) {
         *   <br />[2365]=>
         *   <br />array(2) {
         *     <br />["nome"]=>
         *     <br />string(19) "ABADIA DOS DOURADOS"
         *     <br />[0]=>
         *     <br />array(3) {
         *       <br />["valor"]=>
         *       <br />string(6) "72.936"
         *       <br />["fk_ano_referencia"]=>
         *       <br />string(1) "3"
         *       <br />["fk_variavel"]=>
         *       <br />string(1) "1"
         *     <br />}
         *   <br />}
         */
        
        private function iRunSQLSecundarioCC($ResultadosMain,$SQL){
			//die($SQL);
			
            if(strpos($SQL, "()")){
                die(json_encode(array("erro"=>1,"msg"=>" Houve um erro desconhecido no servidor, recarregue a página. <br />Código: #001")));
            }
           
            $tempArry = parent::ExecutarSQL($SQL,"iRunSQLSecundario22");
            
            //die(var_dump($tempArry));
            $dv=0;
            $Formatado = array();
            foreach($tempArry as $key=>$val){
				if($val['country'] === 'true'){ //Paises
					//$Formatado[]=$val['nome'];
					$this->varOnly = false;
                    if(!$this->varOnly){					
						$arg = $val;
						//die(var_dump($arg));
						unset($arg['im']);
						unset($arg['nome']);
						unset($arg['country']);
						
						unset($arg['rm']);
						unset($arg['u']);
						unset($arg['uf']);
						unset($arg['udh']);
						unset($arg['is_ri']);
						unset($arg['reg']);
						unset($arg['cod']);
						unset($val['rm']);
						unset($val['u']);
						unset($val['uf']);
						unset($val['udh']);
						unset($val['is_ri']);
						unset($val['reg']);
						unset($val['cod']);
						
						
						if(in_array($arg["iv"],  PublicMethods::$ArrayPadding3ZerosDireita)){
							$arg["v"] = cutNumber($arg["v"],3,'.','');
						}elseif(in_array($val["iv"],  PublicMethods::$ArrayPadding2ZerosDireita)){
							$arg["v"] = cutNumber($arg["v"],2,'.','');
						}else{
							$arg["v"] = cutNumber($arg["v"],2,'.','');
						}
						
						//if($this->isSearchName)
							$Formatado[$val['im']]["nome"] = $val["nome"]; 
							
						$Formatado[$val['im']]["country"] = $val["country"];
						$Formatado[$val['im']]["id"] = str_replace("10000", "", $val["im"]);
						$Formatado[$val['im']]["esp"] = 10;
						$Formatado[$val['im']]["vs"][$val["iv"]."_".$val["ka"]] = $arg;
                    }else{
						if(in_array($val["iv"],  PublicMethods::$ArrayPadding3ZerosDireita)){
							$val["v"] = cutNumber($val["v"],3,'.','');
						}elseif(in_array($val["iv"],  PublicMethods::$ArrayPadding2ZerosDireita)){
							$val["v"] = cutNumber($val["v"],2,'.','');
						}else{
							$val["v"] = cutNumber($arg["v"],2,'.','');
						}
						$Formatado[$key] = $val;
                    }
				}
				elseif($val['rm'] === 'true'){ //RMs
					//$Formatado[]=$val['nome'];
					if(!$this->varOnly){					
						$arg = $val;
						//die(var_dump($arg));
						unset($arg['im']);
						unset($arg['nome']);
						unset($arg['rm']);
						
						unset($arg['country']);
						unset($arg['u']);
						unset($arg['uf']);
						unset($arg['udh']);
						unset($arg['is_ri']);
						unset($arg['reg']);
						unset($arg['cod']);
						unset($val['country']);
						unset($val['u']);
						unset($val['uf']);
						unset($val['udh']);
						unset($val['is_ri']);
						unset($val['reg']);
						unset($val['cod']);
						
						if(in_array($arg["iv"],  PublicMethods::$ArrayPadding3ZerosDireita)){
							$arg["v"] = cutNumber($arg["v"],3,'.','');
						}elseif(in_array($val["iv"],  PublicMethods::$ArrayPadding2ZerosDireita)){
							$arg["v"] = cutNumber($arg["v"],2,'.','');
						}else{
							$arg["v"] = cutNumber($arg["v"],2,'.','');
						}
						
						//if($this->isSearchName)
							$Formatado[$val['im']]["nome"] = $val["nome"];
						
						//$Formatado[$val['im']]["u"] = $val["u"];
						$Formatado[$val['im']]["rm"] = $val["rm"];
						$Formatado[$val['im']]["id"] = str_replace("10000", "", $val["im"]);
						$Formatado[$val['im']]["esp"] = 6;
						$Formatado[$val['im']]["vs"][$val["iv"]."_".$val["ka"]] = $arg;
					}
                    else
                        foreach($tempArry as $key=>$val){
                            if(in_array($val["iv"],  PublicMethods::$ArrayPadding3ZerosDireita)){
                                $val["v"] = cutNumber($val["v"],3,'.','');
                            }elseif(in_array($val["iv"],  PublicMethods::$ArrayPadding2ZerosDireita)){
                                $val["v"] = cutNumber($val["v"],2,'.','');
                            }else{
                                $val["v"] = cutNumber($arg["v"],2,'.','');
                            }
                            $Formatado[$key] = $val;
                        }
				}
				elseif($val['reg'] === 'true'){ //Regional
					//$Formatado[]=$val['nome'];
					if(!$this->varOnly){					
						$arg = $val;
						//die(var_dump($arg));
						unset($arg['im']);
						unset($arg['nome']);
						unset($arg['reg']);
						
						unset($arg['country']);
						unset($arg['u']);
						unset($arg['uf']);
						unset($arg['rm']);
						unset($arg['udh']);
						unset($arg['is_ri']);
						unset($arg['cod']);
						unset($val['country']);
						unset($val['u']);
						unset($val['uf']);
						unset($val['rm']);
						unset($val['udh']);
						unset($val['is_ri']);
						unset($val['cod']);
						
						if(in_array($arg["iv"],  PublicMethods::$ArrayPadding3ZerosDireita)){
							$arg["v"] = cutNumber($arg["v"],3,'.','');
						}elseif(in_array($val["iv"],  PublicMethods::$ArrayPadding2ZerosDireita)){
							$arg["v"] = cutNumber($arg["v"],2,'.','');
						}else{
							$arg["v"] = cutNumber($arg["v"],2,'.','');
						}
						
						//if($this->isSearchName)
							$Formatado[$val['im']]["nome"] = $val["nome"];
						
						//$Formatado[$val['im']]["u"] = $val["u"];
						$Formatado[$val['im']]["reg"] = $val["reg"];
						$Formatado[$val['im']]["id"] = str_replace("10000", "", $val["im"]);
						$Formatado[$val['im']]["esp"] = 3;
						$Formatado[$val['im']]["vs"][$val["iv"]."_".$val["ka"]] = $arg;
					}
                    else
                        foreach($tempArry as $key=>$val){
                            if(in_array($val["iv"],  PublicMethods::$ArrayPadding3ZerosDireita)){
                                $val["v"] = cutNumber($val["v"],3,'.','');
                            }elseif(in_array($val["iv"],  PublicMethods::$ArrayPadding2ZerosDireita)){
                                $val["v"] = cutNumber($val["v"],2,'.','');
                            }else{
                                $val["v"] = cutNumber($arg["v"],2,'.','');
                            }
                            $Formatado[$key] = $val;
                        }
				}
				elseif($val['udh'] === 'true'){ //UHDs
					//$Formatado[]=$val['nome'];
					if(!$this->varOnly){					
						$arg = $val;
						//die(var_dump($arg));
						unset($arg['im']);
						unset($arg['nome']);
						unset($arg['udh']);
						
						unset($arg['country']);
						unset($arg['u']);
						unset($arg['uf']);
						unset($arg['rm']);
						unset($arg['is_ri']);
						unset($arg['reg']);
						unset($arg['cod']);
						unset($val['country']);
						unset($val['u']);
						unset($val['uf']);
						unset($val['rm']);
						unset($val['is_ri']);
						unset($val['reg']);
						unset($val['cod']);
						
						if(in_array($arg["iv"],  PublicMethods::$ArrayPadding3ZerosDireita)){
							$arg["v"] = cutNumber($arg["v"],3,'.','');
						}elseif(in_array($val["iv"],  PublicMethods::$ArrayPadding2ZerosDireita)){
							$arg["v"] = cutNumber($arg["v"],2,'.','');
						}else{
							$arg["v"] = cutNumber($arg["v"],2,'.','');
						}
						
						//if($this->isSearchName)
							$Formatado[$val['im']]["nome"] = $val["nome"];
						
						//$Formatado[$val['im']]["u"] = $val["u"];
						$Formatado[$val['im']]["udh"] = $val["udh"];
						$Formatado[$val['im']]["id"] = str_replace("10000", "", $val["im"]);
						$Formatado[$val['im']]["esp"] = 5;
						$Formatado[$val['im']]["vs"][$val["iv"]."_".$val["ka"]] = $arg;
					}
                    else
                        foreach($tempArry as $key=>$val){
                            if(in_array($val["iv"],  PublicMethods::$ArrayPadding3ZerosDireita)){
                                $val["v"] = cutNumber($val["v"],3,'.','');
                            }elseif(in_array($val["iv"],  PublicMethods::$ArrayPadding2ZerosDireita)){
                                $val["v"] = cutNumber($val["v"],2,'.','');
                            }else{
                                $val["v"] = cutNumber($arg["v"],2,'.','');
                            }
                            $Formatado[$key] = $val;
                        }
				}
				elseif(strlen($val['u']) and !strlen($val['uf'])){ //Estatual
					if(!$this->varOnly){					
						$arg = $val;
						unset($arg['im']);
						unset($arg['nome']);
						unset($arg['u']);
						unset($arg['cod']);
						
						unset($arg['country']);
						unset($arg['rm']);
						unset($arg['uf']);
						unset($arg['udh']);
						unset($arg['is_ri']);
						unset($arg['reg']);
						unset($val['country']);
						unset($val['rm']);
						unset($val['uf']);
						unset($val['udh']);
						unset($val['is_ri']);
						unset($val['reg']);
						
						if(in_array($arg["iv"],  PublicMethods::$ArrayPadding3ZerosDireita)){
							$arg["v"] = cutNumber($arg["v"],3,'.','');
						}elseif(in_array($val["iv"],  PublicMethods::$ArrayPadding2ZerosDireita)){
							$arg["v"] = cutNumber($arg["v"],2,'.','');
						}else{
							$arg["v"] = cutNumber($arg["v"],2,'.','');
						}
						
						//if($this->isSearchName)
							$Formatado[$val['im']]["nome"] = $val["nome"];
						
						$Formatado[$val['im']]["u"] = $val["u"];
						$Formatado[$val['im']]["cod"] = $val["cod"];
						$Formatado[$val['im']]["id"] = str_replace("10000", "", $val["im"]);
						$Formatado[$val['im']]["esp"] = 4;
						$Formatado[$val['im']]["vs"][$val["iv"]."_".$val["ka"]] = $arg;
                    }else{					
						if(in_array($val["iv"],  PublicMethods::$ArrayPadding3ZerosDireita)){
							$val["v"] = cutNumber($val["v"],3,'.','');
						}elseif(in_array($val["iv"],  PublicMethods::$ArrayPadding2ZerosDireita)){
							$val["v"] = cutNumber($val["v"],2,'.','');
						}else{
							$val["v"] = cutNumber($arg["v"],2,'.','');
						}
						$Formatado[$key] = $val;
					}
				}
				elseif(strlen($val['u']) and strlen($val['uf'])){ //Municipal
					//$Formatado[]=$val['nome'];
					if(!$this->varOnly){
						//$dv++;
						$arg = $val;
						unset($arg['im']);
						unset($arg['nome']);
						unset($arg['uf']);
						unset($arg['cod']);
						
						unset($arg['country']);
						unset($arg['rm']);
						unset($arg['u']);
						unset($arg['udh']);
						unset($arg['is_ri']);
						unset($arg['reg']);
						unset($val['country']);
						unset($val['rm']);
						unset($val['u']);
						unset($val['udh']);
						unset($val['is_ri']);
						unset($val['reg']);
						
						if(in_array($arg["iv"],  PublicMethods::$ArrayPadding3ZerosDireita)){
							$arg["v"] = cutNumber($arg["v"],3,'.','');
						}elseif(in_array($val["iv"],  PublicMethods::$ArrayPadding2ZerosDireita)){
							$arg["v"] = cutNumber($arg["v"],2,'.','');
						}else{
							$arg["v"] = cutNumber($arg["v"],2,'.','');
						}
						//if($this->isSearchName){
						//if(isset($val["nome"]))
							$Formatado[$val['im']]["nome"] = $val["nome"];
						if(isset($val["uf"]))
							$Formatado[$val['im']]["uf"] = $val["uf"];
						//}
						$Formatado[$val['im']]["cod"] = $val["cod"];
						$Formatado[$val['im']]["id"] = $val["im"];
						$Formatado[$val['im']]["esp"] = 2;
						$Formatado[$val['im']]["vs"][$val["iv"]."_".$val["ka"]] = $arg;
					}
                    else
                        foreach($tempArry as $key=>$val){
                            if(in_array($val["iv"],  PublicMethods::$ArrayPadding3ZerosDireita)){
                                $val["v"] = cutNumber($val["v"],3,'.','');
                            }elseif(in_array($val["iv"],  PublicMethods::$ArrayPadding2ZerosDireita)){
                                $val["v"] = cutNumber($val["v"],2,'.','');
                            }else{
                                $val["v"] = cutNumber($arg["v"],2,'.','');
                            }
                            $Formatado[$key] = $val;
                        }
				}
			}
            //die(var_dump($Formatado));
            //die(var_dump($dv));
            $this->results = $Formatado;
        }
        
        private function getSelectCC(){
			//m.nome||' ('||e.uf||')' as nome,''::character varying(2) as u,e.uf as uf, 'false' as country,'false' as rm 
			$ParteInicialSQL = "SELECT * FROM 
			(SELECT valor as v, fk_pais::text||'p' as im,fk_ano_referencia as ka,fk_variavel as iv, 
				m.nome_pais as nome, null::integer as cod,''::character varying(2) as u,''::character varying(2) as uf,null::integer as is_ri,'true' as country,'false' as rm,'false' as udh,'false' as reg 
				FROM valor_variavel_pais as vv 
				INNER JOIN pais as m ON (vv.fk_pais = m.id) 
				WHERE %paises% 
			union all 
			SELECT valor as v, fk_rm::text||'r' as im,fk_ano_referencia as ka,fk_variavel as iv,
				r.nome as nome, null::integer as cod,''::character varying(2) as u,''::character varying(2) as uf,null::integer as is_ri,'false' as country,'true' as rm,'false' as udh,'false' as reg 
				FROM valor_variavel_rm as vv 
				INNER JOIN rm as r ON (r.id = vv.fk_rm) 
				WHERE %rms% 
			union all 
			SELECT valor as v, fk_udh::text||'u' as im,fk_ano_referencia as ka,fk_variavel as iv,
				nome, null::integer as cod,''::character varying(2) as u,''::character varying(2) as uf,null::integer as is_ri,'false' as country,'false' as rm,'true' as udh,'false' as reg 
				FROM valor_variavel_udh as vv 
				INNER JOIN udh as ud ON (ud.id = vv.fk_udh)
				WHERE %udhs% 
			union all 
			SELECT valor as v, fk_municipio::text||'m' as im,fk_ano_referencia as ka,fk_variavel as iv,
				 m.nome as nome, geocodmun6 as cod,e.uf as u,e.uf as uf, null::integer as is_ri,'false' as country,'false' as rm,'false' as udh,'false' as reg 
				FROM valor_variavel_mun as vv 
				INNER JOIN municipio as m ON (vv.fk_municipio = m.id) 
				INNER JOIN estado as e ON (e.id = m.fk_estado) 
				WHERE %municipios% 
			union all 
			SELECT valor as v, fk_estado::text||'e' as im,fk_ano_referencia as ka,fk_variavel as iv, 
				e.nome as nome, codibge as cod, e.uf as u,''::character varying(2) as uf, null::integer as is_ri,'false' as country,'false' as rm,'false' as udh,'false' as reg 
				FROM valor_variavel_estado as vv 
				INNER JOIN estado as e ON (e.id = vv.fk_estado) 
				WHERE %estados% 
			union all
			SELECT valor as v, vv.fk_municipio::text||'i' as im,fk_ano_referencia as ka,fk_variavel as iv, 
				m.nome as nome, geocodmun6 as cod, e.uf as u, e.uf as uf, fk_regiao_interesse as is_ri , 'false' as country,'false' as rm,'false' as udh,'false' as reg 
				FROM valor_variavel_mun as vv 
				INNER JOIN regiao_interesse_has_municipio as b ON (b.fk_municipio = vv.fk_municipio) 
				INNER JOIN municipio as m ON (vv.fk_municipio = m.id) 
				INNER JOIN estado as e ON (e.id = m.fk_estado) 
				WHERE %ris% 
			union all
			SELECT valor as v, fk_regional::text||'g' as im,fk_ano_referencia as ka,fk_variavel as iv,
				r.nome as nome, null::integer as cod,''::character varying(2) as u,''::character varying(2) as uf,null::integer as is_ri,'false' as country,'false' as rm,'false' as udh,'true' as reg 
				FROM valor_variavel_regional as vv 
				INNER JOIN regional as r ON (r.id = vv.fk_regional) 
				WHERE %regis% 
			) as tot";
			
			return $ParteInicialSQL;
		}
		
		private function getSelectCCP(){
			
			$ParteInicialSQL = "SELECT * FROM 
			(SELECT valor as v, fk_pais::text||'p' as im, 
				'true' as country 
				FROM valor_variavel_pais 
				WHERE %paises% 
			union all 
			SELECT valor as v, fk_rm::text||'r' as im, 
				'false' as country 
				FROM valor_variavel_rm 
				WHERE %rms% 
			union all 
			SELECT valor as v,fk_udh::text||'u' as im, 
				'false' as country 
				FROM valor_variavel_udh as vu 
				inner join udh as u on vu.fk_udh = u.id 
				WHERE %udhs% 
			union all 
			SELECT valor as v,fk_municipio::text||'m' as im, 
				'false' as country 
				FROM valor_variavel_mun as mv 
				inner join municipio as m on mv.fk_municipio = m.id 
				WHERE %municipios% 
			union all 
			SELECT valor as v,fk_estado::text||'e' as im, 
				'false' as country 
				FROM valor_variavel_estado 
				WHERE %estados% 
			union all 
			SELECT valor as v, fk_regional::text||'g' as im, 
				'false' as country 
				FROM valor_variavel_regional as vrg
				inner join regional as rg on rg.id=vrg.fk_regional
				WHERE %regis% 
			union all 
			SELECT valor as v, vv.fk_municipio::text||'m' as im,
				'false' as country
				FROM valor_variavel_mun as vv 
				INNER JOIN regiao_interesse_has_municipio as b ON (b.fk_municipio = vv.fk_municipio) 
				WHERE %ris% 
			) as tot";
			
			return $ParteInicialSQL;
		}
		        
        private function generateSequence($start, $end){
            
        }
        
        private function getSelectFiltroMain(){
            $Filtros = $this->consulta->getFiltros();
            for($x = 0; $x < count($Filtros);$x++){
                switch ($Filtros[$x]->getFiltro()){
                    case Filtro::$FILTRO_MUNICIPIO:
                        $filtros = $Filtros[$x]->getValores();
//                        if(count($filtros)>3000){
//                            $comp = array();
//                            $compB = array();
//                            for($x = 1; $x <= 5565;$x++){
//                                $comp[] = $x;
//                            }
//                            foreach($filtros as $val){
//                                $compB[] = $val->getNome();
//                            }
//                            $result = array_diff($compB, $comp);
//                            foreach($result as $val){
//                                $SQLRegiao[] = "(m.id <> $val)";
//                            }
//                            if(count($result) == 0){
//                                $SQLRegiao[] = "(1 = 1)";
//                            }
//                        }else{
                        foreach($Filtros[$x]->getValores() as $val){
                            $SQLRegiao[] = "{$val->getNome()}";
                        }
//                        }
                        break;
                    case Filtro::$FILTRO_REGIAO:
                        foreach($Filtros[$x]->getValores() as $val){
                            $SQLRegiao[] = "{$val->getNome()}";
                        }
                        break;
                    case Filtro::$FILTRO_ESTADO:
                        foreach($Filtros[$x]->getValores() as $val){
                            $SQLRegiao[] = "{$val->getNome()}";
                        }
                        break;
                    case Filtro::$FILTRO_REGIAODEINTERESSE:
                        foreach($Filtros[$x]->getValores() as $val){
                            $SQLRegiao[] = "{$val->getNome()}";
                        }
                        break;
                    case Filtro::$FILTRO_PAIS:
                        foreach($Filtros[$x]->getValores() as $val){
                            $SQLRegiao[] = "{$val->getNome()}";
                        }
                        break;
                    case Filtro::$FILTRO_REGIAOMETROPOLITANA:
                        foreach($Filtros[$x]->getValores() as $val){
                            $SQLRegiao[] = "{$val->getNome()}";
                        }
                        break;
                /*=========================================================
                 * Novas Espacialidades aqui!
                 *=========================================================*/
                }
            }
            if(is_array($SQLRegiao))
                $SQL1 = implode(',',$SQLRegiao);
            
            return $SQL1;
        }
        
        //======================================================================
        //Getters and Setters
        //======================================================================
        
        public function getSQL($IdVariavel,$AnoVariavel){
            return $this->getSQLMain($IdVariavel,$AnoVariavel);
        }
        
        public function getSQLSecundario($ArrayId){
            return $this->iGetSQLSecundario($ArrayId);
        }
        
        public function getSQLSecundarioCC($ArrayId,$atpagina,$atord){
            return $this->iGetSQLSecundarioCC($ArrayId,$atpagina,$atord);
        }
        
        /**
         * Pega o retorno do SQL
         * @param string $SQL recebe a sql e executa
         * @example <br />array(1) {
         *   <br />[2365]=>
         *   <br />array(2) {
         *     <br />["nome"]=>
         *     <br />string(19) "ABADIA DOS DOURADOS"
         *     <br />[0]=>
         *     <br />array(3) {
         *       <br />["valor"]=>
         *       <br />string(6) "72.936"
         *       <br />["fk_ano_referencia"]=>
         *       <br />string(1) "3"
         *       <br />["fk_variavel"]=>
         *       <br />string(1) "1"
         *     <br />}
         *   <br />}
         */
        public function getSQLResults($SQL){
            return $this->iRunSQL($SQL);
        }
        
        public function getSQLResultsSecundario($ResultadosMain,$SQL){
            return $this->iRunSQLSecundario($ResultadosMain,$SQL);
        }
        
        public function getSQLResultsSecundarioCC($ResultadosMain,$SQL){
            return $this->iRunSQLSecundarioCC($ResultadosMain,$SQL);
        }
        
        public function getSQLFiltroMain(){
            return $this->getSelectFiltroMain();
        }
    }
?>

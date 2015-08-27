<?php
$comPath = BASE_ROOT . "/system/modules/perfil//";
require_once BASE_ROOT . 'config/config_path.php';
require_once BASE_ROOT . 'config/config_gerais.php';
require_once $comPath . "model/bd.class.php";
//require_once $comPath . "util/protect_sql_injection.php";
require_once $comPath . "Block.class.php";
require_once $comPath . "BlockTabela.class.php";
require_once PERFIL_PACKAGE . 'controller/TextBuilder.class.php';
require_once PERFIL_PACKAGE . 'model/bd.class.php';
require_once PERFIL_PACKAGE . 'util/array_column.php';

require_once $comPath . "controller/Formulas.class.php";

//require_once PERFIL_PACKAGE . "controller/PerfilBuilder.class.php";

define("PATH_DIRETORIO", $path_dir);

/**
 * Description of Perfil
 *
 * @author Andre Castro (versão 2)
 */
class Perfil extends bd {

    private $UrlNome;
    private $UrlUf;
    private $UrlCod;
    private $nome;
    private $uf;
    private $ufCru;
    private $id;
    private $estado;
    private $nomeCru;
    private $data = array();
    private $locale;
    private $tipo_rm;
    private $perfilType;
    private $nome_mun;
    private $nome_rm;
    private $lat;
    private $long;

    public function getNomeCru() {
        if ($this->uf != null)
            return $this->nome . ", " . strtoupper($this->uf);
        else
            return $this->nome;
    }

    public function __construct($municipio, $perfilType = null) {
        parent::__construct();
//        if ($municipio == null || $municipio == "") {
//            
//        }

        $gets = explode("/", $_SERVER ['REQUEST_URI']);

        if ($perfilType != null)
            $this->perfilType = $perfilType;
        else
            $this->perfilType = @$gets[3];

        $divisao = explode('_', $this->retira_acentos($municipio));
        $this->nomeCru = $divisao[0];
        //$stringTratada = cidade_anti_sql_injection(str_replace('-', ' ', $divisao[0]));
        $stringTratada = str_replace('-', ' ', $divisao[0]);
        $this->UrlNome = $stringTratada;

        if (sizeof($divisao) > 1) {
            $this->ufCru = $divisao[1];
            //$stringUfTratada = cidade_anti_sql_injection(str_replace('-', ' ', $divisao[1]));
            $stringUfTratada = str_replace('-', ' ', $divisao[1]);
            $this->UrlUf = $stringUfTratada;
        }

        if (is_numeric($divisao[0]))
            $this->UrlCod = $divisao[0];
        else
            $this->UrlCod = 0;


        if (@$gets[3] == "perfil_m" || $perfilType == "perfil_m")
            $this->read();
        else if (@$gets[3] == "perfil_rm" || $perfilType == "perfil_rm")
            $this->readRM();
        else if (@$gets[3] == "perfil_uf" || $perfilType == "perfil_uf")
            $this->readUF();
        else if (@$gets[3] == "perfil_udh" || $perfilType == "perfil_udh")
            $this->readUDH();


//        else if (@$gets[3] == "perfil_rm" || $perfilType == "perfil_rm" || @$gets[3] == "perfil_udh" || $perfilType == "perfil_udh" )
//            echo "<script type='text/javascript'>alert('Este perfil ainda não se encontra disponível!');</script>";
    }

    private function retira_acentos($texto) {
        $array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
            , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
        $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
            , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C");
        return str_replace($array1, $array2, $texto);
    }

    public function drawNome() {

        echo "<div class='btn_print no-print' id='toolTipPrintDown' style='float:right; margin-top: 80px; display:none;'>  
            <button type='button' class='gray_button big_bt' onclick='javascript:window.print(); return false;'>     
                <img src='assets/img/icons/print_gray.png'/></a>
            </button>     
        </div>";

        if ($this->nome != null && $this->uf != null) {
            //echo "<div class='perfil-title'>" . mb_convert_case($this->nome, MB_CASE_TITLE, "UTF-8") . ", " . strtoupper($this->uf) . "

            if (strlen($this->nome) > 90) {

                if ($this->perfilType == 'perfil_udh') {
                    echo "<div class='perfil-title' title='" . $this->nome . "' style='line-height: 50px;'>"
                    . substr($this->nome, 0, 90) . " (...)" . "<br>"
                    . substr($this->nome_mun, 0, 90) . ", " . strtoupper($this->uf) . "<br>"
                    . " RM - " . substr($this->nome_rm, 0, 90) . "
                           <img id='uiperfilloader' src='assets/img/icons/ajax-loader.gif' background-color: transparent;' />
                </div>";
                } else {
                    echo "<div class='perfil-title' title='" . $this->nome . "' style='line-height: 50px;'>"
                    . substr($this->nome, 0, 90) . " (...), " . strtoupper($this->uf) . "
                <img id='uiperfilloader' src='assets/img/icons/ajax-loader.gif' background-color: transparent;' />
                </div>";
                }
            } else {

                if ($this->perfilType == 'perfil_udh') {
                    echo "<div class='perfil-title' title='" . $this->nome . "' style='line-height: 50px;'>"
                    . substr($this->nome, 0, 90) . "<br>"
                    . substr($this->nome_mun, 0, 90) . ", " . strtoupper($this->uf) . "<br>"
                    . " RM - " . substr($this->nome_rm, 0, 90) . "
                           <img id='uiperfilloader' src='assets/img/icons/ajax-loader.gif' background-color: transparent;' />
                </div>";
                } else {
                    echo "<div class='perfil-title' title='" . $this->nome . "' style='line-height: 50px;'>"
                    . substr($this->nome, 0, 90) . ", " . strtoupper($this->uf) . "
                    <img id='uiperfilloader' src='assets/img/icons/ajax-loader.gif' background-color: transparent;' />
                    </div>";
                }
            }
        } else if ($this->nome != null) {

            if (strlen($this->nome) > 90) {

                echo "<div class='perfil-title' style='line-height: 50px;'>" . substr($this->nome, 0, 90) . " (...)
                <img id='uiperfilloader' src='assets/img/icons/ajax-loader.gif' background-color: transparent;' />
                </div>";
            } else {

                $html = "<div class='perfil-title'  style='line-height: 50px;'>";

                if ($this->perfilType === "perfil_rm") {

                    if ($this->tipo_rm === '2')
                        $html .= "RIDE - " . $this->nome;
                    else
                        $html .= "RM - " . $this->nome;
                } else
                    $html .= $this->nome;

                $html .= "<img id='uiperfilloader' src='assets/img/icons/ajax-loader.gif' background-color: transparent;' />
                        </div>";

                echo $html;
            }
        }
    }

    public function drawMap() {
        echo '<div class="perfil-map-div"><div id="mapaPerfil"></div></div>';
    }

    public function drawArrows() {
        ?>
        <div class="pArrowLeft"></div>
        <div class="pArrowRight"></div>
        <?php
    }

    public function __destruct() {
        parent::__destruct();
    }

    static function getCaracteristicas($municipio) {

        $SQL = "SELECT altitude, anoinst, densidade, area, distancia_capital
                     FROM municipio
                     WHERE municipio.id = $municipio";

        return TextBuilder::$bd->ExecutarSQL($SQL, "getCaracteristicas");
    }

    static function getMicroMeso($municipio) {

        $SQL = "SELECT microrregiao.nome as micro, mesorregiao.nome as meso FROM municipio
                    INNER JOIN microrregiao ON fk_microregiao = microrregiao.id
                    INNER JOIN mesorregiao ON fk_mesorregiao = mesorregiao.id
                    WHERE municipio.id  = $municipio";


        return TextBuilder::$bd->ExecutarSQL($SQL, "getMicroMeso");
    }

    static function getUfRm($udh) {

        $SQL = "SELECT estado.uf as uf, estado.nome as nomeuf, rm.nome_curto as rm, rm.nome as nome FROM udh
                    INNER JOIN municipio ON fk_municipio = municipio.id
                    INNER JOIN rm ON municipio.fk_rm = rm.id
                    INNER JOIN estado ON municipio.fk_estado = estado.id
                    WHERE udh.id  = $udh";

        return TextBuilder::$bd->ExecutarSQL($SQL, "getMicroMeso");
    }

    //ORDERNAÇÂO ARRAY POR CAMPO
    private function orderMultiDimensionalArray($toOrderArray, $field, $inverse = false) {
        $position = array();
        $newRow = array();
        foreach ($toOrderArray as $key => $row) {
            $position[$key] = $row[$field];
            $newRow[$key] = $row;
        }
        if ($inverse) {
            arsort($position);
        } else {
            asort($position);
        }
        $returnArray = array();
        foreach ($position as $key => $pos) {
            $returnArray[] = $newRow[$key];
        }
        return $returnArray;
    }
    
    

    //ORDENAR MAPA PELA AREA 
    private function OrderMapMaxArea($coord) {
        
//        //@#Função não existente em versão PHP 5.4
//        if( !function_exists( 'array_column' ) ):    
//        function array_column( array $input, $column_key, $index_key = null ) {
//
//            $result = array();
//            foreach( $input as $k => $v )
//                $result[ $index_key ? $v[ $index_key ] : $k ] = $v[ $column_key ];
//
//            return $result;
//        }
//        endif;
    
        $area = array();
        if (count($coord) > 1) {
            for ($index = 0; $index < count($coord); $index++) {
                $somaA = 0;
                $somaB = 0;
                for ($pontos = 0; $pontos < count($coord[$index][0]); $pontos++) {
                    $A = $coord[$index][0][$pontos][0];
                    $B = $coord[$index][0][$pontos][1];
                    $A1 = isset($coord[$index][0][$pontos + 1][1])?$coord[$index][0][$pontos + 1][1]:0;
                    $B1 = isset($coord[$index][0][$pontos + 1][0])?$coord[$index][0][$pontos + 1][0]:0; 
                    $somaA += $A * $A1;
                    $somaA += $B * $B1;
                }
                array_push($area, array(
                    "coordenada" => $coord[$index],
                    "area" => (($somaA - $somaB / 2)>0?($somaA - $somaB / 2):($somaA - $somaB / 2)*-1)
                ));
            }
            
            $area = $this->orderMultiDimensionalArray($area, "area", false);

            return array_column($area, "coordenada");
        }
    }
    
    private function read() {

        $SQL = "SELECT municipio.nome, uf, municipio.id, estado.nome as nomeestado, municipio.latitude, municipio.longitude,
            (ST_AsGeoJSON(municipio.the_geom)) as locale FROM municipio
                    INNER JOIN estado ON (municipio.fk_estado = estado.id)
                    WHERE ( sem_acento(municipio.nome) ILIKE '{$this->UrlNome}' AND
                        (uf ILIKE '{$this->ufCru}' OR sem_acento(estado.nome) ILIKE '{$this->UrlUf}') ) OR"
                . " municipio.id = {$this->UrlCod} OR"
                . " municipio.geocodmun = {$this->UrlCod} OR"
                . " municipio.geocodmun6 = {$this->UrlCod} LIMIT 1";


        if ($this->UrlCod != null || $this->UrlCod == 0) {
            $results = parent::ExecutarSQL($SQL);

            if (sizeof($results) > 0) {
                $this->nome = $results[0]["nome"];
                $this->uf = $results[0]["uf"];
                $this->id = $results[0]["id"];
                $this->estado = $results[0]["nomeestado"];

                //ordenacao dos shapes
                $json_output = json_decode($results[0]["locale"]);

                if (count($json_output->coordinates) > 1) {
                    $json_output->coordinates = $this->OrderMapMaxArea($json_output->coordinates);
                }
                $this->locale = json_encode($json_output);
                $this->lat = $results[0]["latitude"];
                $this->long = $results[0]["longitude"];
            }
        }
    }

    private function readRM() {

        $SQL = "SELECT rm.nome, rm.id, tipo_rm, lat, lon,
            (ST_AsGeoJSON(rm.the_geom)) as locale FROM rm                  
                    WHERE sem_acento(rm.nome) ILIKE '{$this->UrlNome}' OR "
                . " rm.id = {$this->UrlCod} OR "
                . " rm.cod_rmatlas ILIKE '{$this->UrlCod}' LIMIT 1";

        if ($this->UrlCod != null || $this->UrlCod == 0) {
            $results = parent::ExecutarSQL($SQL);

            //if ($results[0]["id"] == 2 || $results[0]["id"]  == 16){//@#TEMPORARIO
            if (sizeof($results) > 0) {
                $this->nome = $results[0]["nome"];
                //$this->uf = $results[0]["uf"];
                $this->uf = "";
                $this->id = $results[0]["id"];
                //$this->estado = $results[0]["nomeestado"];
                $this->estado = "";
                $this->locale = $results[0]["locale"];
                $this->tipo_rm = $results[0]["tipo_rm"];

                $this->lat = $results[0]["lat"];
                $this->long = $results[0]["lon"];
            }
        }
    }

    private function readUF() {

        $SQL = "SELECT nome, id, latitude, longitude,
            (ST_AsGeoJSON(the_geom)) as locale FROM estado
                    WHERE sem_acento(nome) ILIKE '{$this->UrlNome}' OR "
//                . "estado.id = {$this->UrlCod} OR "
                . "estado.cod_estatlas ILIKE '{$this->UrlCod}' LIMIT 1";

        if ($this->UrlCod != null || $this->UrlCod == 0) {
            $results = parent::ExecutarSQL($SQL);

            if (sizeof($results) > 0) {
                $this->nome = $results[0]["nome"];
                //$this->uf = $results[0]["uf"];
                $this->uf = "";
                $this->id = $results[0]["id"];
                //$this->estado = $results[0]["nome"];
                $this->estado = "";
                $this->locale = $results[0]["locale"];

                $this->lat = $results[0]["latitude"];
                $this->long = $results[0]["longitude"];
            }
        }
    }

    private function readUDH() {

        $SQL = "SELECT udh.nome, uf, municipio.nome as nome_mun, rm.nome as nome_rm, municipio.fk_rm as rmid, udh.id, estado.nome as nomeestado,
            (ST_AsGeoJSON(udh.the_geom)) as locale FROM udh
                    INNER JOIN municipio ON (municipio.id = udh.fk_municipio)
                 INNER JOIN estado ON (estado.id = municipio.fk_estado)
                                     INNER JOIN rm ON (rm.id = udh.fk_rm)
                    WHERE ( sem_acento(udh.nome) ILIKE '{$this->UrlNome}' AND
                        (uf ILIKE '{$this->ufCru}' OR sem_acento(estado.nome) ILIKE '{$this->UrlUf}') ) OR "
                . " udh.id = {$this->UrlCod} OR"
                . " udh.cod_udhatlas ILIKE '{$this->UrlCod}' LIMIT 1";

        if ($this->UrlCod != null || $this->UrlCod == 0) {
            $results = parent::ExecutarSQL($SQL);

            if (sizeof($results) > 0) {
                $this->nome = $results[0]["nome"];
                $this->uf = $results[0]["uf"];
                $this->id = $results[0]["id"];
                $this->estado = $results[0]["nomeestado"];
                $this->locale = $results[0]["locale"];

                $this->nome_mun = $results[0]["nome_mun"];
                $this->nome_rm = $results[0]["nome_rm"];
            }
        }
    }

    public function getCityId() {
        return $this->id;
    }

    public function getCityName() {
        return $this->nome;
    }

    public function getUfName() {
        return $this->uf;
    }

    public function drawMenu() {
        if ($this->nome != null) {
            ?>
            <div class="pmainMenuTop no-print">
                <!-- <div class="pmainMenuTopCenter">-->
                <ul class="pmainMenuTopUl">
                    <script type="text/javascript">
                        if (lang_mng.getString('lang_id') == "pt") {
                            document.write("<li><a href='" + document.URL + "#caracterizacao' class='perfilMenu' io-pos='0' io='caracterizacao'>CARACTERIZAÇÃO</a></li>");
                            document.write("<li><a href='" + document.URL + "#idh' class='perfilMenu' io-pos='1' io='idh'>IDHM</a></li>");
                            document.write("<li><a href='" + document.URL + "#demografia' class='perfilMenu' io-pos='2' io='demografia'>DEMOGRAFIA</a></li>");
                            document.write("<li><a href='" + document.URL + "#educacao' class='perfilMenu' io-pos='3' io='educacao'>EDUCAÇÃO</a></li>");
                            document.write("<li><a href='" + document.URL + "#renda' class='perfilMenu' io-pos='4' io='renda'>RENDA</a></li>");
                            document.write("<li><a href='" + document.URL + "#trabalho' class='perfilMenu' io-pos='5' io='trabalho' >TRABALHO</a></li>");
                            document.write("<li><a href='" + document.URL + "#habitacao' class='perfilMenu' io-pos='6' io='habitacao' >HABITAÇÃO</a></li>");
                            document.write("<li><a href='" + document.URL + "#vulnerabilidade' class='perfilMenu' io-pos='7' io='vulnerabilidade' >VULNERABILIDADE</a></li>");
                        }
                        else if (lang_mng.getString('lang_id') == "en") {
                            document.write("<li><a href='" + document.URL + "#caracterizacao' class='perfilMenu' io-pos='0' io='caracterizacao'>CHARACTERIZATION</a></li>");
                            document.write("<li><a href='" + document.URL + "#idh' class='perfilMenu' io-pos='1' io='idh'>MHDI</a></li>");
                            document.write("<li><a href='" + document.URL + "#demografia' class='perfilMenu' io-pos='2' io='demografia'>DEMOGRAPHY</a></li>");
                            document.write("<li><a href='" + document.URL + "#educacao' class='perfilMenu' io-pos='3' io='educacao'>EDUCATION</a></li>");
                            document.write("<li><a href='" + document.URL + "#renda' class='perfilMenu' io-pos='4' io='renda'>INCOME</a></li>");
                            document.write("<li><a href='" + document.URL + "#trabalho' class='perfilMenu' io-pos='5' io='trabalho' >LABOUR</a></li>");
                            document.write("<li><a href='" + document.URL + "#habitacao' class='perfilMenu' io-pos='6' io='habitacao' >HOUSING</a></li>");
                            document.write("<li><a href='" + document.URL + "#vulnerabilidade' class='perfilMenu' io-pos='7' io='vulnerabilidade' >VULNERABILITY</a></li>");
                        }
                        else if (lang_mng.getString('lang_id') == "es") {
                            document.write("<li><a href='" + document.URL + "#caracterizacao' class='perfilMenu' io-pos='0' io='caracterizacao'>CARACTERIZACIÓN</a></li>");
                            document.write("<li><a href='" + document.URL + "#idh' class='perfilMenu' io-pos='1' io='idh'>IDHM</a></li>");
                            document.write("<li><a href='" + document.URL + "#demografia' class='perfilMenu' io-pos='2' io='demografia'>DEMOGRAFÍA</a></li>");
                            document.write("<li><a href='" + document.URL + "#educacao' class='perfilMenu' io-pos='3' io='educacao'>EDUCACIÓN</a></li>");
                            document.write("<li><a href='" + document.URL + "#renda' class='perfilMenu' io-pos='4' io='renda'>INGRESOS</a></li>");
                            document.write("<li><a href='" + document.URL + "#trabalho' class='perfilMenu' io-pos='5' io='trabalho' >TRABAJO</a></li>");
                            document.write("<li><a href='" + document.URL + "#habitacao' class='perfilMenu' io-pos='6' io='habitacao' >VIVIENDA</a></li>");
                            document.write("<li><a href='" + document.URL + "#vulnerabilidade' class='perfilMenu' io-pos='7' io='vulnerabilidade' >VULNERABILIDAD</a></li>");
                        }
                    </script>
                </ul>
                <!-- </div>-->
            </div>
            <?php
        }
    }

    public function drawScriptsMaps() {
        ?>
        <script type="text/javascript">
            var map;
            currentFeature_or_Features = null;

            var pol_style = {
                strokeColor: "#FF0000",
                strokeOpacity: 0.75,
                strokeWeight: 0.5,
                fillColor: "#FF0000",
                fillOpacity: 0.30
            };

            //aqui se fosse fazer a bolinha de capital
            var capital_style = {
                icon: "img/capital_icon.png"
            };

            var infowindow = new google.maps.InfoWindow();

            function init() {

                map = new google.maps.Map(document.getElementById('mapaPerfil'), {
                    zoom: <?=
        ($this->perfilType == "perfil_rm" ? "8" :
                ($this->perfilType == "perfil_uf" ? "5" : "5" )
        )
        ?>,
                    center: new google.maps.LatLng(<?= $this->lat !== null ? $this->lat : "-20" ?>,
        <?= $this->long !== null ? $this->long : "-50" ?>),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                ///////////////////////////
                // Segundo argumento recebe um estilo, se precisar
                showFeature(city_ex, pol_style);
                ///////////////////////////
            }
            function clearMap() {
                if (!currentFeature_or_Features)
                    return;
                if (currentFeature_or_Features.length) {
                    for (var i = 0; i < currentFeature_or_Features.length; i++) {
                        if (currentFeature_or_Features[i].length) {
                            for (var j = 0; j < currentFeature_or_Features[i].length; j++) {
                                set_map_of(currentFeature_or_Features[i][j], true);
                            }
                        }
                        else {
                            set_map_of(currentFeature_or_Features[i], true);
                        }
                    }
                } else {
                    set_map_of(currentFeature_or_Features, true);
                }
                if (infowindow.getMap()) {
                    infowindow.close();
                }
            }
            google.maps.Polygon.prototype.my_getBounds = function () {
                var bounds = new google.maps.LatLngBounds();
                this.getPath().forEach(function (element, index) {
                    bounds.extend(element)
                });
                return bounds;
            }
            function set_map_of(object, remove) {
                object.setMap(remove ? null : map);
                if (!remove) {
        <?=
        ( ($this->perfilType == "perfil_udh" || $this->perfilType == "perfil_m") ?
                "map.fitBounds(object.my_getBounds());" : "")
        ?>;
                }
                ;
            }
            function showFeature(geojson, style) {
                clearMap();
                currentFeature_or_Features = new GeoJSON(geojson, style || null);

                if (currentFeature_or_Features.type && currentFeature_or_Features.type == "Error") {
                    return false; //Aqui temos um erro!
                }
                if (currentFeature_or_Features.length) {
                    for (var i = 0; i < currentFeature_or_Features.length; i++) {
                        if (currentFeature_or_Features[i].length) {
                            for (var j = 0; j < currentFeature_or_Features[i].length; j++) {
                                set_map_of(currentFeature_or_Features[i][j]);
                            }
                        }
                        else {
                            set_map_of(currentFeature_or_Features[i])
                        }
                    }
                } else {
                    set_map_of(currentFeature_or_Features);
                }
            }

            $(document).ready(function () {
                init();
            });
        </script>
        <?php
    }

    public function drawScripts() {
        ?>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=pt"></script>
        <script type="text/javascript">

            var lang = '<?= $_SESSION["lang"] ?>';
            //var baseUrl = "</?php //echo PATH_DIRETORIO . "perfil/" ?>";
            //var baseUrl = "</?php echo PATH_DIRETORIO; ?>" + lang + "/perfil_m/";
            //var baseUrl = "<//?php echo PATH_DIRETORIO; ?>" + lang + "/perfil/" ;
            var storedName = "";
            splited = document.URL.split("/");
            splitedx = document.URL.split(lang_mng.getString("lang_id") + "/" + splited[5] + "/");

            $(document).ready(function () {
                inputHandler.add($('#perfil_search'), 'buscaPerfil', 2, "", false, getNomeMunUF);
            });

            function getNomeMunUF(nome) {
                nome = retira_acentos(nome);
                storedName = nome;
                buscaPerfil();
            }

            function buscaPerfil() {

                if ($("#buscaPerfil").attr("i") != 0) {
                    RedirectSearch(storedName, "/perfil_m/");
                }
                else if (storedName == "") {
                    document.getElementById('erroBusca').style.display = "block";
                }

                document.getElementById('teste2').style.height = "370px";
                document.getElementById('perfil-title').style.padding.top = "98px";
                //alert("Selecione um município para continuar");

                //<//?php $_SESSION["perfilType"] = "mun";  ?>
            }

            $(document).ready(function () {
                inputHandler.add($('#perfil_search_rm'), 'buscaPerfilRM', 6, "", false, getNomeMunUFRM);
            });

            function getNomeMunUFRM(nome) {
                nome = retira_acentos(nome);
                storedName = nome;
                buscaPerfilRM();
            }

            function buscaPerfilRM() {
                if ($("#buscaPerfilRM").attr("i") != 0) {
                    RedirectSearch(storedName, "/perfil_rm/");
                }
                else if (storedName == "") {
                    document.getElementById('erroBuscaRM').style.display = "block";
                }

                document.getElementById('teste2').style.height = "370px";
                document.getElementById('perfil-title').style.padding.top = "98px";
                //alert("Selecione um município para continuar");
                //</?php $this->perfilType = "rm";  ?>
            }

            $(document).ready(function () {
                inputHandler.add($('#perfil_search_uf'), 'buscaPerfilUF', 4, "", false, getNomeMunUFUF);
            });

            function getNomeMunUFUF(nome) {
                nome = retira_acentos(nome);
                storedName = nome;
                buscaPerfilUF();
            }

            function buscaPerfilUF() {
                if ($("#buscaPerfilUF").attr("i") != 0) {
                    RedirectSearch(storedName, "/perfil_uf/");
                }
                else if (storedName == "") {
                    document.getElementById('erroBuscaUF').style.display = "block";
                }

                document.getElementById('teste2').style.height = "370px";
                document.getElementById('perfil-title').style.padding.top = "98px";
                //alert("Selecione um município para continuar");
                //</?php $this->perfilType = "rm";  ?>
            }

            $(document).ready(function () {
                inputHandler.add($('#perfil_search_udh'), 'buscaPerfilUDH', 5, "", false, getNomeMunUFUDH);
            });

            function getNomeMunUFUDH(nome) {
                nome = retira_acentos(nome);
                storedName = nome;
                buscaPerfilUDH();
            }

            function buscaPerfilUDH() {
                if ($("#buscaPerfilUDH").attr("i") != 0) {
                    RedirectSearch(storedName, "/perfil_udh/");
                }
                else if (storedName == "") {
                    document.getElementById('erroBuscaUDH').style.display = "block";
                }

                document.getElementById('teste2').style.height = "370px";
                document.getElementById('perfil-title').style.padding.top = "98px";
                //alert("Selecione um município para continuar");
                //</?php $this->perfilType = "rm";  ?>
            }

            function RedirectSearch(nome, perfilType) {
                window.location = "<?php echo PATH_DIRETORIO; ?>" + lang + perfilType + retira_acentos(nome);
                //window.location = baseUrl + retira_acentos(nome);
                //_getUrl();
            }

            if (splitedx[1] === "") {
                $(document).ready(function () {

                    //I'm not doing anything else, so just leave
                    if (!navigator.geolocation)
                        return;
                    navigator.geolocation.getCurrentPosition(function (pos) {
                        geocoder = new google.maps.Geocoder();
                        var latlng = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);

                        geocoder.geocode({'latLng': latlng}, function (results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                //Check result 0
                                var result = results[0];
                                //look for locality tag and administrative_area_level_1
                                var city = "";
                                var state = "";
                                for (var i = 0, len = result.address_components.length; i < len; i++) {
                                    var ac = result.address_components[i];
                                    if (ac.types.indexOf("locality") >= 0)
                                        city = ac.long_name;
                                    if (ac.types.indexOf("administrative_area_level_1") >= 0)
                                        state = ac.long_name;
                                }
                                //only report if we got Good Stuff

                                if (city != '' && state != '') {
                                    var city_t = city.replace(" ", "-");
                                    var uf_t = state.replace(" ", "-");
                                    //window.location = baseUrl + retira_acentos(city_t) + "_" + uf_t;
                                }
                            }
                        });

                    });
                })
            }

        </script>
        <script type="text/javascript">
            //@#Temporário - Corrigir    
            city_ex = {"type": "Feature", "properties": {"name": "<?php echo $this->nome; ?>", "uf": "<?php echo $this->uf; ?>"}, <?= ( ($this->locale !== null || $this->perfilType !== "perfil_rm") ? "'geometry':" . $this->locale : "'geometry':''") ?>};


            var mPage = 0;
            var storedPages = new RegExp();

            // var bUrl = "</?php echo PATH_DIRETORIO . "perfil/{$this->nomeCru}_{$this->ufCru}" ?>";
            function perfil_loading(status)
            {
                if (status)
                    $("#uiperfilloader").show();
                else
                    $("#uiperfilloader").hide();
            }

            function _getUrl() {

                $('#content').hide();
                $('#center').css('marginTop', -80);
                perfil_loading(true);
                //iPage = 0;

                $.ajax({
                    type: 'post',
                    //data: {page: iPage, lang: lang_mng.getString('lang_id') ,city: "<\\?php echo $this->nomeCru . "_" . $this->ufCru; ?>"},
                    data: {lang: lang_mng.getString('lang_id'), perfilType: splited[5], /*print: splited[7],*/ city: "<?php echo $this->nomeCru . "_" . $this->ufCru; ?>"},
                    url: "system/modules/perfil/controller/AjaxPaginaPerfil.php",
                    success: function (r) {
                        perfil_loading(false);
                        storedPages[mPage] = r;
                        $("#MainContentPerfil").html(r);
                        $('#toolTipPrintDown').show().focus();
                    }
                });
            }

            _getUrl();
        </script>
        <?php
    }
}
?>

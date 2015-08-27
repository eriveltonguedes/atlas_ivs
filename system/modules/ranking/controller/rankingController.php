<?php
    require_once BASE_ROOT . 'system/modules/ranking/model/rankingDAO.php';
    require_once BASE_ROOT . 'config/config_path.php';
    require_once BASE_ROOT . 'config/config_gerais.php';
    require_once BASE_ROOT . 'system/modules/tabela/consulta/bd.class.php';
    /*require_once MOBILITI_PACKAGE . "/consulta/bd.class.php";*/
    
    $compTitle = "- {$lang_mng->getString("rankin_title_01")}";     //Todo o Brasil
    $ano_h = 3;
    $data = array();
    $ranking;
    
    if (isset($_POST["cross_data_ranking"])) {
        
        $str_json = str_replace("\\", "", $_POST["cross_data_ranking"]);

        $data = objectToArray(json_decode($str_json));

        foreach ($data as $do => $d) {
            if ($data[$do] == -1) {
                $data[$do] = null;
            }
        }

        /*var_dump($data);
        exit();*/
        
        extract($data);

        $donwload = false;
        if (isset($load_more))
            $load_more = true;
        else
            $load_more = false;
        if ($_POST["cross_data_download"] == "true") {
            $donwload = true;
            $load_more = true;
        }
        $ano_h = $fk_ano;
        //IF para corrigir demonstração de ano via js no título do ranking
        if (($espc == 'udh' || $espc == 'rm') && $fk_ano == 1) {    //Para rm e udh o ano será somente 2010
            $ano_h = 3;
        }

        $ranking = new Ranking($ordem_id, $ordem, $pagina, $espc, $start, $estado, $estados_pos, $load_more, $donwload, $fk_ano, $lang_mng);

        if ($espc == "estadual") {
            $compTitle = "- {$lang_mng->getString("rankin_title_02")}";
        } else if ($espc == 'municipal') {
            if ($estado == 0) {
                $compTitle = "- {$lang_mng->getString("rankin_title_01")}";
            } else {
                $compTitle = "- " . $ranking->getEstadoNome();
            }
        } else if ($espc == 'rm') {
            $compTitle = "- {$lang_mng->getString("rankin_title_03")}";
        } else if ($espc == 'udh') {
            if ($estado == 0) {
                $compTitle = "- {$lang_mng->getString("rankin_title_04")}";
            } else {
                $compTitle = "- " . $ranking->getEstadoNome();
            }
        }
    } else {
        $ranking = new Ranking($lang_mng);
    }

    function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            /*
             * Return array converted to object
             * Using __FUNCTION__ (Magic constant)
             * for recursive call
             */
            return array_map(__FUNCTION__, $d);
        } else {
            // Return array
            return $d;
        }
    }

    $classBtn1 = "";
    $classBtn2 = "";
    $classBtn3 = "";    //RM
    $classBtn4 = "";

    $onClick1 = "sendData(-1,-1,-1,'municipal',1,0,0)";
    $onClick2 = "sendData(-1,-1,-1,'estadual',1,0,0)";
    $onClick3 = "sendData(-1,-1,-1,'rm',1,0,0)";
    $onClick4 = "sendData(-1,-1,-1,'udh',1,0,0)";
    if ($ranking->pEspc == 'municipal') {
        $classBtn1 = "active";
        $onClick1 = "";
    } else if ($ranking->pEspc == 'estadual') {
        $onClick2 = "";
        $classBtn2 = "active";
    } else if ($ranking->pEspc == 'rm') {
        $onClick3 = "";
        $classBtn3 = "active";
    } else if ($ranking->pEspc == 'udh') {
        $onClick4 = "";
        $classBtn4 = "active";
    }
?>

<script>
    var flag_ranking = -1;
    function ranking_year_slider_listener(event, data) {
        if (flag_ranking != -1) {
            sendData(<?php echo "{$ranking->pOrdem_id},'{$ranking->pOrdem}'"; ?>,<?php echo "1,'{$ranking->pEspc}',{$ranking->pStart},"; ?>$("#selectEstados").val());
        }
    }
    function sendData(ordem_id, ordem, pagina, espc, start, estado) {
        
        loadingHolder.show(lang_mng.getString("carregando"));
        ano = $("#selct_ano .ano_atual").attr("id");
        if (ordem == null) {
            if (ano != undefined) {
                json = '{"ordem_id":' + ordem_id + ',"ordem":' + ordem + ',"pagina":' + pagina + ',"espc":"' + espc + ',"start":"' + start + '","estado":' + $("#selectEstados").val() + ',"estados_pos":"' + $("#holderRankEstados").val() + '","fk_ano":' + ano + '}';
            }
            else {
                
                json = '{"ordem_id":' + ordem_id + ',"ordem":' + ordem + ',"pagina":' + pagina + ',"espc":"' + espc + ',"start":"' + start + '","estado":' + $("#selectEstados").val() + ',"estados_pos":"' + $("#holderRankEstados").val() + '","fk_ano": 3}';
            }
        }
        else {
            if (ano != undefined) {
                json = '{"ordem_id":' + ordem_id + ',"ordem":"' + ordem + '","pagina":' + pagina + ',"espc":"' + espc + '","start":"' + start + '","estado":' + $("#selectEstados").val() + ',"estados_pos":"' + $("#holderRankEstados").val() + '","fk_ano":' + ano + '}';
            }
            else {
                
                json = '{"ordem_id":' + ordem_id + ',"ordem":"' + ordem + '","pagina":' + pagina + ',"espc":"' + espc + '","start":"' + start + '","estado":' + $("#selectEstados").val() + ',"estados_pos":"' + $("#holderRankEstados").val() + '","fk_ano":3}';
            }
        }
        
        $("#cross_data_ranking").val(json);
        $("#f_cross_data_ranking").submit();
        loadingHolder.show(lang_mng.getString("carregando"));
    }

    function sendDataDownload() {
        $("#cross_data_download").val("true");
        $("#f_cross_data_ranking").attr("target", "_blank");
        sendData(<?php echo "{$ranking->pOrdem_id},'{$ranking->pOrdem}'"; ?>,<?php echo "1,'{$ranking->pEspc}',{$ranking->pStart},"; ?>$("#selectEstados").val());
        $("#f_cross_data_ranking").attr("target", "");
        $("#cross_data_download").val("false");
        loadingHolder.dispose();
    }

    function convertAno(anoId){
        switch (parseInt(anoId)) {
            case 1:
                return 1991;
            case 2:
                return 2000;
            case 3:
                return 2010;
            default :
                return 2010;
        }
    }

    $(document).ready(function() {
        
        $("#imgTab6").attr("data-original-title", lang_mng.getString("download_text"));
        $("#ranking_year_slider").bind("slider:changed", ranking_year_slider_listener);
        $("#ranking_year_slider").simpleSlider("setValue", convertAnoIDtoLabel(<?php echo $ano_h; ?>));

        $("#span_year_show").html("(" + convertAnoIDtoLabel(<?php echo $ano_h; ?>) + ")");
        flag_ranking = 0;
        $('#imgTab6').tooltip({html: true, delay: 500});
        $(".bolinhaRank").tooltip();
        $("#selectRankLimit").change(function() {
            sendData(<?php echo "{$ranking->pOrdem_id},'{$ranking->pOrdem}'"; ?>,<?php echo "1,'{$ranking->pEspc}',{$ranking->pStart},{$ranking->pEstado}"; ?>, $(this).attr);
        });

//        $("#selct_ano span").change(function() {
//            sendData(<?php // echo "{$ranking->pOrdem_id},'{$ranking->pOrdem}'"; ?>,<?php // echo "1,'{$ranking->pEspc}',{$ranking->pStart},{$ranking->pEstado}"; ?>);
//        });
        $("#selectEstados").change(function() {
            /*console.log('selectEstados');*/
            sendData(<?php echo "{$ranking->pOrdem_id},'{$ranking->pOrdem}'"; ?>,<?php echo "1,'{$ranking->pEspc}',{$ranking->pStart},"; ?>$(this).val());
        });
        $("#selectRMs").change(function() {
            sendData(<?php echo "{$ranking->pOrdem_id},'{$ranking->pOrdem}'"; ?>,<?php echo "1,'{$ranking->pEspc}',{$ranking->pStart},"; ?>$(this).val());
        });
        $(".button-carregar-mais").click(function() {

            $("#tr_load_more").remove();
            $(this).remove();
            loadingHolder.show(lang_mng.getString("carregando"));
            var esp = '<?php echo $ranking->pEspc; ?>';
            ano = $("#selct_ano .ano_atual").attr("id");
            if (esp == 'udh') {
                json = '{"ordem_id":<?php echo $ranking->pOrdem_id; ?>,"ordem":"<?php echo $ranking->pOrdem; ?>","pagina":1,"espc":"<?php echo $ranking->pEspc; ?>","start":"<?php echo $ranking->pStart; ?>","estado":' + $("#selectEstados").val() + ',"estados_pos":"' + $("#holderRankEstados").val() + '","load_more":"true","fk_ano": "' + ano + '"}';
            }
            else
                json = '{"ordem_id":<?php echo $ranking->pOrdem_id; ?>,"ordem":"<?php echo $ranking->pOrdem; ?>","pagina":1,"espc":"<?php echo $ranking->pEspc; ?>","start":"<?php echo $ranking->pStart; ?>","estado":' + $("#selectEstados").val() + ',"estados_pos":"' + $("#holderRankEstados").val() + '","load_more":"true","fk_ano":"' + ano + '"}';

            $("#f_cross_data_ranking input").val(json);
            
        
            $("#f_cross_data_ranking").submit();
        });

        $("#selct_ano span").click(function() {
            $('#selct_ano span').removeClass('ano_atual');
            $(this).addClass('ano_atual');
            sendData(<?php echo "{$ranking->pOrdem_id},'{$ranking->pOrdem}'"; ?>,<?php echo "1,'{$ranking->pEspc}',{$ranking->pStart},"; ?>$(this).val());
        });
    })
</script>

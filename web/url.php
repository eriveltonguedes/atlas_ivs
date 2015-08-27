<?php
session_start();


include_once '../config/config_gerais.php';
include_once '../config/config_path.php';

//Pega o conteúdo da URL
$gets = explode("/", @$_GET["cod"]);

/* ======================== Verifica a linguagem ========================== */
$lang_var = null;
$ltemp = "";
/*var_dump($gets);*/
/*$gets[0] = "pt";*/ //provisoriamente pois não há as versões em inglês e português
if ($gets[0] == "pt") {
    $ltemp = array_shift($gets);
}
else if($gets[0] == "en" || $gets[0] == "es"){//se for um desses dois eu mando pra home
    if(LINKS_IDIOMAS == false){
        header("location:$path_dir");//caso a lingua seja en ou es redireciona para a página inicial em pt
        exit();
    }
    else
        $ltemp = array_shift($gets);
}
else {
    $ltemp = "pt";       //Caso não tenha pego nenhuma referência de linguagem, na url, o padrão será pt
}

include_once '../config/langs/lang_' . $ltemp . '.php';    //Inclui o arquivo com as variáveis da linguagem atual
$_SESSION["lang"] = $ltemp;     //Salva na variável $_SESSSION, que será usada em todo o sistema, a linguage

include_once '../config/langs/LangManager.php';

//Instancia um objeto da classe LangManager que será a responsável por retornar as strings de internacionalização
$lang_mng = new LangManager($lang_var);

//==========================================================================
$pag = @$gets[0];

if (sizeof($gets) > 1) {
    $pagNext = $gets[1];
} else {
    $pagNext = "";
}
if (sizeof($gets) > 2) {
    $pagNext2 = $gets[2];
} else {
    $pagNext2 = "";
}

if(!empty($pagNext2))
    $title = $lang_mng->getString($pagNext2 . "_title_tag" );
else if(!empty($pagNext))
    $title = $lang_mng->getString($pagNext . "_title_tag");
else
    $title = $lang_mng->getString($pag . "_title_tag");

include_once 'header.php'; 

/* ======================= Includes das páginas =========================== */
#Home
if ($pag == "home" || $pag == "") {

    if ($pagNext != "teste" && $pagNext != '') {
        include './bloqueios/paginaNaoEncontradaView.php';
    } 
    else if ($pagNext == '' || $pag == 'home') {
        include "./home/homeView.php";
    }
}

#Destaques
else if ($pag == "destaques") {
    if ($pagNext != "" && $pagNext != "metodologia"&& $pagNext != "idhmBrasil" && $pagNext!= "regioes-metropolitanas-avancam-desenvolvimento-humano-reduzem-disparidades" && $pagNext != "regioes-metropolitanas-alto-indice-desenvolvimento-humano" && $pagNext != "faixas_idhm" && $pagNext != "idhm_brasil" && $pagNext != "educacao" && $pagNext != "longevidade" && $pagNext != "renda") {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else {
        include "./destaques/destaquesView2.php";
    }
}
//rota para componente de seletor de entidade
else if ($pag == "componente-seletor") {
    if ($pagNext != "" && $pagNext != "metodologia" && $pagNext != "faixas_idhm" && $pagNext != "idhm_brasil" && $pagNext != "educacao" && $pagNext != "longevidade_e_renda") {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else {
        include "./com/mobiliti/componentes/seletor-espacialidade/base-seletor.php";
    }
}

#Histogram
else if($pag == 'histograma_print'){
    include '../system/modules/histogram/view/histogramPrintView.php';
}

#Árvore do IDHM
else if ($pag == 'arvore') {
    if (sizeof($gets) >= 5 && $gets[4] != "") {
        $municipio1Arvore = $gets[1] . '/' . $gets[2];
        $municipio2Arvore = $gets[3] . '/' . $gets[4];
    } else if (sizeof($gets) < 5 || $pagNext == 'aleatorio') {
        $municipio1Arvore = 0;
        $municipio2Arvore = 0;
    } else if ($pagNext == 'semconexao') {
        include "./bloqueios/paginaSemConexaoView.php";
    }

    if ($pagNext == 'aleatorio' || $pagNext == '') {
        $aleatorio = true;
    } else {
        $aleatorio = false;
    }

    if (($pagNext == 'aleatorio' && $pagNext2 == '') || $pagNext == 'municipio' || $pagNext == 'estado' || $pagNext == '') {
        include './arvore/arvoreView.php';
    } else {
        include './bloqueios/paginaNaoEncontradaView.php';
    }
}

#Impressão Árvore IDHM
else if ($pag == 'arvore_print') {
    if (sizeof($gets) >= 5 && $gets[4] != "") {
        $municipio1Arvore = $gets[1] . '/' . $gets[2];
        $municipio2Arvore = $gets[3] . '/' . $gets[4];
    } else if ($pagNext == 'nulo' && $pagNext2 == 'nulo') {
        $municipio1Arvore = 'nulo';
        $municipio2Arvore = 'nulo';
    } else if ($pagNext != 'nulo' && $gets[3] == 'nulo') {
        $municipio1Arvore = $gets[1] . '/' . $gets[2];
        ;
        $municipio2Arvore = 'nulo';
    } else if ($pagNext == 'nulo' && $gets[3] != 'nulo') {
        $municipio1Arvore = 'nulo';
        $municipio2Arvore = $gets[2] . '/' . $gets[3];
    }

    include './arvore/arvorePrintView.php';
}

#Ranking
else if ($pag == "ranking") {
    if ($pagNext != "") {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else if ($pagNext == 'semconexao') {
        include "./bloqueios/paginaSemConexaoView.php";
    } else {
        include "./ranking/rankingView.php";
    }
}

#Graficos
else if ($pag == "graficos") {
    if ($pagNext != "") {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else {
        include "./grafico/graficosView.php";
    }
}

#Consulta

else if ($pag == "consulta") {
    if ($pagNext2 != "") {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else if ($pagNext == 'semconexao') {
        include "./bloqueios/paginaSemConexaoView.php";
    } else if ($pagNext == "imprimir") {
        if ($pagNext2 != "") {
            include './bloqueios/paginaNaoEncontradaView.php';
        }
        include "com/mobiliti/tabela/imprimir.table.php";
        return;
    } else if ($pagNext == "download") {
        if ($pagNext2 != "") {
            include './bloqueios/paginaNaoEncontradaView.php';
        }
        include "../com/mobiliti/tabela/download.table.php";
        return;
    } else if ($pagNext != 'padrao' && $pagNext != 'imprimir' && $pagNext != 'download') {
        include "./consulta/consultaView.php";
    } else {
        include "./consulta/consultaView.php";
    }
}
//TODO temporário, retirar após aprovação da nova view.
else if ($pag == "consulta2") {
    include "./consulta/consultaView2.php";
}

#mapa
// else if ($pag == "mapa") {
// 	include "com/mobiliti/mapa_rm/mapaServico.php";
// }
#Perfis
else if ($pag == "perfil") {
    if ($pagNext2 != "") {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else if ($pagNext == 'semconexao') {
        include "./bloqueios/paginaSemConexaoView.php";
    } else {
        $MunicipioPefil = @$gets[1];
        include "./perfil/perfilxView.php";
    }
}

#Perfil Municipal
else if ($pag == "perfil_m") {
    if ($pagNext2 != "") {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else {
        $MunicipioPefil = @$gets[1];
        include "./perfil/perfilxView.php";
    }
}

#Perfil RMs
else if ($pag == "perfil_rm") {
    if ($pagNext2 != "" && $pagNext2 != "print") {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else {
        $MunicipioPefil = @$gets[1];
        include "./perfil/perfilxView.php";
    }
}

#MapaRM
//else if ($pag == "mapa_rm") {
//    if ($pagNext != "") {
//        include './bloqueios/paginaNaoEncontradaView.php';
//    } else {
//        include '../com/mobiliti/mapa_rm/ui.regioesmetropolitanas.php';
//    }
//}

#MapaPadrao
else if ($pag == "mapa") {
    if ($pagNext != "") {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else {
//        echo realpath(dirname(__FILE__).'../');
        include BASE_ROOT . 'system/modules/map/index.php';
    }
}
// else if ($pag == "teste") {
//     if ($pagNext != "") {
//         include 'web/pagina_nao_encontrada.php';
//     } else {
//         include 'com/mobiliti/mapa_padrao/teste.php';
//     }
// }


#Perfil UFs
else if ($pag == "perfil_uf") {
    if ($pagNext2 != "") {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else {
        // echo @$gets[1];
        $MunicipioPefil = @$gets[1];
        include "./perfil/perfilxView.php";
    }
}

#Perfil UDHs
else if ($pag == "perfil_udh") {
    if ($pagNext2 != "") {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else {
        // echo @$gets[1];
        $MunicipioPefil = @$gets[1];
        include "./perfil/perfilxView.php";
    }
}

#Perfil para Impressão
else if ($pag == "perfil_print") {
    if ($pagNext2 != "") {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else {
        $MunicipioPefil = $gets[1];
        include "./perfil/__perfilPrintView.php";
    }
}

#Pesquisa
else if ($pag == "pesquisa") {
    if ($pagNext != "") {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else {
        include "../tempInputs.php";
    }
}

#O Atlas
else if ($pag == "o_atlas") {
    if ($pagNext != "" && $pagNext != "o_atlas_" && $pagNext != "quem_faz" && $pagNext != "para_que" && $pagNext != "processo" && $pagNext != "vulnerabilidade_social" && $pagNext != "ivs" && $pagNext != "metodologia" && $pagNext != "glossario" && $pagNext != "perguntas_frequentes" && $pagNext != 'tutorial') {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else if ($pagNext == 'metodologia' && $pagNext2 != 'calculo-do-ivs' && $pagNext2 != 'ivs_dados' && $pagNext2 != '') {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else {
        include "./o_atlas/oAtlasView.php";
    }
}

#Download
else if ($pag == "download") {
    if ($pagNext != "") {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else {
        include './download/download2.php';
    }
}

#Impressão do mapa
else if ($pag == "imprimir_mapa") {
    if ($pagNext != "") {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else {
//        $MunicipioPefil = $gets[1];
//        include "./consulta/mapa/imprimirMapaView.php";
        include "./consulta/mapa/imprimirMapaView2.php";
    }
}

#Imprensa
else if ($pag == "imprensa") {
    if ($pagNext != "") {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else {
        include './imprensa_base.php';
    }
}

#Fale Conosco
else if ($pag == "fale_conosco") {
    if ($pagNext != "") {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else {
        include './fale_conosco_base.php';
    }
}


#Dados brutos
else if ($pag == "dadosbrutos") {
    if ($pagNext != "") {
        $file = 'dadosbrutos/' . $pagNext;
        if (file_exists($file)) {
            ob_start();
//            header('Content-Description: File Transfer');
//            header('Content-Type: application/octet-stream');
//            header('Content-Disposition: attachment; filename=' . basename($file));
//            header('Content-Transfer-Encoding: binary');
//            header('Expires: 0');
//            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//            header('Pragma: public');
//            header('Content-Length: ' . filesize($file));
//            ob_clean();
//            flush();
//            readfile($filex);
//            exit;
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);  
            header("Content-Type: text/html");
            header("Content-Disposition: attachment; filename=\"".basename($file)."\";" );
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: ".filesize($file));
            readfile("$file");
            exit();
        }
    }
}


#Download de Navegadores
else if ($pag == "atualizacao_navegadores") {
    if ($pagNext != "") {
        include './bloqueios/paginaNaoEncontradaView.php';
    } else {
        include './consulta/consultaDesabilitadaView.php';
    }
} 

else if ($pag == "admin") {
//        include 'com/mobiliti/administrativo/main.php';
    include './bloqueios/paginaNaoEncontradaView.php';
} 

else if ($pag == "teste") {
    if ($pagNext == 'bloqueio-geral')
        include 'web/bloqueios/bloqueioGeralView.php';
    elseif ($pagNext == 'bloqueio-consulta')
        include 'web/bloqueios/bloqueioConsultaView.php';
}

#Notas de Download
else if ($pag == "notas") {
    include '../web/download/avisosView.php';
} 

else if ($pag == "update_lang") {
    if (isset($gets[1]))
        $lang = $gets[1];
    else
        $lang = "pt";


    include '../system/components/language/update_lang.php';
}
else {
    include './bloqueios/paginaNaoEncontradaView.php';
}

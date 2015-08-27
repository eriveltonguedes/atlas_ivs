<?php

if (!isset($_SESSION))
{
    session_start();
}

include_once ("../system/components/language/language.php");
include_once ("../system/libraries/sql/protect_sql_injection.php");
include_once ("../config/config_path.php");
include_once ("../config/config_gerais.php");

?>
<?php ob_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description"
              content="O Atlas do Desenvolvimento Humano no Brasil é uma plataforma de consulta ao Índice de Desenvolvimento Humano Municipal – IDHM - de 5.565 municípios brasileiros, além de mais de 180 indicadores de população, educação, habitação, saúde, trabalho, renda e vulnerabilidade, com dados extraídos dos Censos Demográficos de 1991, 2000 e 2010." />
        <meta http-equiv="X-UA-Compatible" content="IE=IE8" />

        <base href="<?php echo $path_dir ?>" />

        <link rel="shortcut icon"
              href="<?php echo $path_dir ?>assets/img/icons/favicon.png">

        <!-- Folhas de estilo -->
        <link rel="stylesheet"
              href="<?php echo $path_dir ?>assets/css/seletor-indicador/seletor_indicador.css"
              type="text/css" />
        <link rel="stylesheet"
              href="<?php echo $path_dir ?>assets/css/local/seletor_lugares.css"
              type="text/css" />
        <link rel="stylesheet"
              href="<?php echo $path_dir ?>assets/css/local/local.css"
              type="text/css" />
        <link rel="stylesheet"
              href="<?php echo $path_dir ?>assets/bootstrap/css/bootstrap.min.css"
              type="text/css" />
        <link rel="stylesheet" href="<?php echo $path_dir ?>assets/css/site.css"
              type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet'
              type='text/css' />
        <link rel="stylesheet" type="text/css" href="<?php echo $path_dir; ?>assets/css/impressao.css" media="print" />
        <!--[if lte IE 9]>
            <link rel="stylesheet" type="text/css" href="assets/css/override-css-ie-9-lower.css" />
        <![endif]-->

        <!-- <link rel="stylesheet" media="screen" type="text/css"
                href="<?php echo $path_dir ?>assets/css/colorpicker/colorpicker.css" />
        <link rel="stylesheet" media="screen" type="text/css"
                href="<?php echo $path_dir ?>assets/css/colorpicker/layout.css" /> -->

        <script type="text/javascript">
            var JS_LIMITE_TELA = "<?php echo JS_LIMITE_TELA; ?>";
            var JS_LIMITE_DOWN = "<?php echo JS_LIMITE_DOWN; ?>";

            var JS_INDICADOR_IDH = "<?php echo INDICADOR_IDH; ?>";
            var JS_INDICADOR_LONGEVIDADE = "<?php echo INDICADOR_LONGEVIDADE; ?>";
            var JS_INDICADOR_RENDA = "<?php echo INDICADOR_RENDA; ?>";
            var JS_INDICADOR_EDUCACAO = "<?php echo INDICADOR_EDUCACAO; ?>";
        </script>


        <script src="<?php echo $path_dir ?>assets/js/jquery/jquery-1.7.2.min.js"
        type="text/javascript"></script>
        <script
            src="<?php echo $path_dir ?>assets/js/jquery/jquery-ui-1.10.1.custom.min.js"
        type="text/javascript"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>

<!--        <script src="</?php echo $path_dir ?>js/tabulous.js" type="text/javascript"></script>
        <script src="</?php echo $path_dir ?>js/js.js" type="text/javascript"></script>-->

        <script src="<?php echo $path_dir ?>assets/js/voltarTopo.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>assets/bootstrap/js/bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>assets/js/bootstrapx-clickover.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>assets/js/indicador/seletor_indicador2.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>assets/js/indicador/seletor_indicador_graficos.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>assets/js/history.min.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>assets/js/simple-slider.js" type='text/javascript' charset='utf-8'></script>

        <script src="<?php echo $path_dir ?>assets/js/search.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>web/home/js/slideShow.js" type="text/javascript"></script>   <!-- slide tutorial da home -->
        <script src="<?php echo $path_dir ?>assets/js/jquery/jquery.imgareaselect.pack.js" type="text/javascript" ></script>
        <script src="<?php echo $path_dir ?>assets/js/seletor-espacializacao.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>assets/js/util.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>assets/js/jquery/jquery.cycle.all.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>assets/js/teste.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>assets/js/loading.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>assets/js/selector/SelectorIndicator.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>assets/js/local/local.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>assets/js/local/local_graficos.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>assets/js/local_indicador/local.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>assets/js/local_indicador/local_graficos.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>assets/js/geral/geral.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>assets/js/local/seletor_lugares.js" type="text/javascript"></script>
        <script src="<?php echo $path_dir ?>assets/js/local/seletor_lugares_graficos.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo $path_dir ?>assets/js/jquery/jquery.mousewheel.js"></script>
        <script type="text/javascript" src="<?php echo $path_dir ?>assets/js/jquery/jquery.jscrollpane.min.js"></script>
        <script type="text/javascript" src="<?php echo $path_dir ?>assets/js/jquery/scroll-startstop.events.jquery.js"></script>
        <script src="<?php echo $path_dir ?>assets/js/styleRadioCheckbox.js" type="text/javascript"></script>

        <script	src="system/modules/seletor-espacialidade/view/js/search-component.js"></script>
        <script type="text/javascript" src="<?php echo $path_dir ?>config/langs/LangManager.js"></script>
        <script type="text/javascript" src="<?php echo $path_dir ?>assets/js/app.js"></script>

        <?php

        include_once '../config/langs/LangManager.php';
        $lang_mng = new LangManager($lang_var);
	
        ?>

        <script type="text/javascript">
            var global_pvt_lang_object = <?php echo json_encode($lang_var); ?>;
            var lang_mng = new LangManager();
        </script>

        <!-- tags seo facebook -->
        <?php
            $meta_title = isset($meta_title) ? $meta_title : isset($meta_title2) ? $meta_title2 : '';
            $geral_title = $lang_mng->getString("geral_title");
            if(! isset($title)) {
                if(isset($title2)) {
                    $title = $title2;
                } else {
                    $title = '';
                }
            }
            $meta_description = isset($meta_description) ? $meta_description : isset($meta_description2) ? $meta_description2 : '';
        ?>

        <meta property='og:title' content='<?php echo $meta_title ?>' />
        <meta property='og:url' content='<?php echo 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI']; ?>' />
        <meta property='og:image' content='<?php echo $path_dir; ?>img/marca vertical cor.png' />
        <meta property='og:type' content='website' />
        <meta property='og:site_name' content="<?php echo $title . ' | ' . $geral_title; ?>" />
        <meta name="description" content="<?php echo $meta_description; ?>" />
        <meta property="og:description" content="<?php echo $meta_description; ?>" />
        <title><?php echo $title . ' | ' . $geral_title; ?></title>

        <meta name="twitter:card" content="summary">
        <meta name="twitter:url" content="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI']; ?>">
        <meta name="twitter:title" content="<?php echo $title . ' | ' . $geral_title; ?>">
        <meta name="twitter:description" content="<?php echo $meta_description; ?>">
        <meta name="twitter:image" content="<?php echo $path_dir; ?>img/marca vertical cor.png">
    </head>

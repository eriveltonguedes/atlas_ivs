<script type="text/javascript" src="../../../../assets/js/util.js"></script>
<script type='text/javascript' src="<?php echo $path_dir ?>system/modules/histogram/controller/drawChart.js"></script>
<script type='text/javascript' src="<?php echo $path_dir ?>system/modules/histogram/controller/drawTabela.js"></script>
<?php
ob_start();
$gets = explode("/", $_GET["cod"]);

//Eliminando a linguagem e histograma_print do array $gets
array_shift($gets);
array_shift($gets);

$espacialidade = $gets[0];
$lugares = str_replace('_', ',', $gets[1]);
$indicador = $gets[2];
$ano = $gets[3];
?>
<script>
    window.histogram_value;
    $(document).ready(function() {
        var dataHistograma = new Object();

        dataHistograma['e'] = '<?= $espacialidade ?>';
        dataHistograma['l'] = '<?= $lugares ?>';
        dataHistograma['i'] = '<?= $indicador ?>';
        dataHistograma['a'] = '<?= $ano ?>';

        $.ajax({
            type: "POST",
            url: "system/modules/histogram/controller/histogramService.php",
            data: dataHistograma,
            success: histogram_response
        });
    });

    function histogram_response(data, textStatus, jqXHR) {
        if (textStatus == "success")
        {
            var obj = $.parseJSON(data);
            histogram_value = obj;
            visualization();
        }
        else {
            alert("Erro ao executar consulta!");
        }
    }
    javascript:self.print();

</script>
<div id="chart_div" style='margin-left: 77px; width: 800px; height: 450px; margin-top: 49px;'></div>
<div style="margin-top: 30px;" id="table_div"></div>
<?php
    $title = $lang_mng->getString("histograma_tituloprint");
    $title_print = $lang_mng->getString("histograma_titulo");
    $content = ob_get_contents();
    ob_end_clean();
    include "base.php";
?>


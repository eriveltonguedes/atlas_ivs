<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>--> <!-- Está dando conflito -->
<!-- <link rel="stylesheet" type="text/css" href="<?php //echo $path_dir ?>css/histogramStyle.css"> -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type='text/javascript' src="<?php echo $path_dir ?>system/modules/histogram/controller/drawChart.js"></script>
<script type='text/javascript' src="<?php echo $path_dir ?>system/modules/histogram/controller/drawTabela.js"></script>
<!--<script type="text/javascript" src="<?php echo $path_dir ?>system/modules/histogram/principal.js"></script>-->
<div id="chart_div" style='width: 800px; height: 450px; margin-top: 10px;'>
    <img id="uibolhaloader" src="assets/img/icons/ajax-loader.gif" style="background-color: transparent; margin-top: 126px; margin-left: 400px;" />
</div>
<div id="chart_img"></div>
<div id="table_div"></div>
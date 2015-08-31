<!-- ano -->
<?php
$ano_padrao = true;

if (isset($_REQUEST['ano'])) {
    if ($_REQUEST['ano'] == 1) {
        $ano = 1;
    }
    
    if ($_REQUEST['ano'] == 2) {
        $ano = 2;
    }
    
    if ($_REQUEST['ano'] == 3) {
        $ano = 3;
    }

    $ano_padrao = false;
}

if (defined('ANO_PADRAO') && $ano_padrao) {
    if (ANO_PADRAO == 1) {
        $ano = 1;
    }
    
    if (ANO_PADRAO == 2) {
        $ano = 2;
    }
    
    if (ANO_PADRAO == 3) {
        $ano = 3;
    }
}
?>

<div id="seletor_ano">
    <!--<span id="ano_1" <?php echo ($ano == 1) ? 'class="ano_atual"' : ''; ?>>1991</span>-->
    <span id="ano_2" <?php echo ($ano == 2) ? 'class="ano_atual"' : ''; ?>>2000</span>
    <span id="ano_3" <?php echo ($ano == 3) ? 'class="ano_atual"' : ''; ?>>2010</span>
</div>
<!-- /ano -->

<!-- aviso 1991 (rm e udh) -->
<div id="aviso_1991" class="alert" style="position:absolute; top: 15px; left: 450px; display: none; padding: 10px; height: auto;">
    <button type="button" class="close">&times;</button>
<?php echo $lang_mng->getString('mp_aviso_sem_dados_rm_udh_1991'); ?>
</div>
<!-- aviso 1991 (rm e udh) -->


<script type="text/javascript">
  
    
    /**
    * Verifica dados para RMs, UDHs e Regionais.
    * 
    * @param {Number|String} contexto
    * @param {Number|String} espacialidade
    * @param {Number|String} id
    * @param {Number|String} indicador
    * @param {Number|String} ano
    */
    function verificaDados1991(contexto, espacialidade, id, indicador, ano) {
        if (GMaps.testaDados1991(espacialidade, indicador, ano)) {
            MAPA_API.mostraAviso1991();
        } else if ((id && !isNaN(id)) || $.isArray(id)) {
            MAPA_API.simpleMapQuery(
                id,
                espacialidade,
                indicador,
                ano,
                contexto
            );
        }
    }
    

    $(document).ready(function() {
        $('#aviso_1991 .close').click(function() {
            $(this).parent().hide();
        });

<?php
if (isset($_REQUEST['ano'])) {
    echo "MAPA_API.setAno('" . $_REQUEST['ano'] . "');\n";

    if (($_REQUEST['ano'] == 1) && (isset($_REQUEST['espacialidade']) 
            && $_REQUEST['espacialidade'] == 5 || $_REQUEST['espacialidade'] == 6)) {
        echo "MAPA_API.mostraAviso1991();\n";
    }
}
?>

       
        $("#seletor_ano span").on('click', function() {
            var ano = $(this).attr('id').replace(/^ano_/g, '');
            
            MAPA_API.setAno(ano, true);
            
            $('#seletor_ano span').removeClass('ano_atual');
            $(this).addClass('ano_atual');
            
            verificaDados1991(
                MAPA_API.getContexto(), 
                MAPA_API.getEspacialidade(), 
                MAPA_API.getId(), 
                MAPA_API.getIndicador(), 
                ano
            );
        });
    });

</script>
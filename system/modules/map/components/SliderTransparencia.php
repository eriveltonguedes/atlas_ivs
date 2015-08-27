<!-- transparência -->
<div id="transparencia-mapa-container" class="noselect">
    <div id="transparencia-mapa" style="width:55%;display: inline-block;margin-right:10px;">
        <div class="valor" style="float: right;"><?php echo TRANSPARENCIA_PADRAO; ?>%</div>
        <div id="slider-mapa-transparencia"></div>
    </div>
    <span id="contorno" class="ativo"><?php echo $lang_mng->getString('mp_contornos'); ?></span>
</div>
<!-- /transparência -->

<script type="text/javascript">
    $(document).ready(function() {
        var TRANSPARENCIA_PADRAO = <?php echo TRANSPARENCIA_PADRAO; ?>;

        // valor padrão
        if (MAPA_API) {
            MAPA_API.setTransparencia(<?php echo (1 - (TRANSPARENCIA_PADRAO / 100)); ?>);
        }

        $('#slider-mapa-transparencia').attr('title', lang_mng.getString('mp_tooltip_transparencia_mapa'));

        $("#slider-mapa-transparencia")
                .slider({min: 0, max: 100, value: TRANSPARENCIA_PADRAO})
                .on("slidechange", function(event, ui) {
                    $('#transparencia-mapa .valor').text(ui.value + '%');
                })
                .on("slidestop", function(event, ui) {
                    var valor = ui.value, transparencia = 1 - (valor / 100);
                    MAPA_API.mudaTransparencia(transparencia);
                });

        $('#transparencia-mapa .valor')
                .text($("#slider-mapa-transparencia").slider("value") + '%');

        $('#slider-mapa-transparencia').tooltip({delay: 500});

        $('#contorno').click(function() {
            if (!$('#contorno').hasClass('ativo')) {
                $('#contorno').addClass('ativo');
                MAPA_API.addContornoEspacialidades();
            } else {
                MAPA_API.removeContornoEspacialidades();
                $('#contorno').removeClass('ativo');
            }
        });
    });

</script>
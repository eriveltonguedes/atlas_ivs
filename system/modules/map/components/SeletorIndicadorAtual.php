<!-- indicador -->
<div id="seletor_indicadores_container">

    <div id="seletor_indicadores">
        <div id="indicador_atual"><?php echo $lang_mng->getString("indicador_atual"); ?></div>
    </div>

    <div id="aviso-ajuda-seletor-indicador" class="aviso-ajuda">
        <div class="close">&times;</div>
        <div class="msg"><?php echo $lang_mng->getString('mp_aviso_ajuda_seletor_indicador'); ?></div>
    </div>
    
    <script>
        $(document).ready(function () {
            $('#aviso-ajuda-seletor-indicador .close').bind('click', function (evt) {
                $('.aviso-ajuda').hide();
                $('#botao-aviso-ajuda').removeClass('selecionado');
                evt.stopPropagation();
            });
        });
    </script>
    <!-- /aviso -->
</div>
<!-- /indicador -->
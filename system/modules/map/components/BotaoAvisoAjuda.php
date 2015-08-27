<!-- aviso ajuda -->
<div id="botao-aviso-ajuda" class="selecionado">&quest;</div>
<script>
    $(document).ready(function () {
        var $botaoAvisoAjuda    = $('#botao-aviso-ajuda'), 
            $avisoAjuda         = $('.aviso-ajuda');
        
        $botaoAvisoAjuda.bind('click', function (evt) { 
            
            setMsgMarcadorAjudaMapa();
            
            if (!$(this).hasClass('selecionado')) {
                $avisoAjuda.show();
                $(this).addClass('selecionado');
                $('#contexto_atual,#espacialidade_atual').removeClass('highlight');
                $('#indicador-holder,.lista-espacialidade,.lista-contexto').hide();
            } else {
                $avisoAjuda.hide();
                $(this).removeClass('selecionado');
            }
            
            evt.stopPropagation();
        });
    });
    
    /**
     * Mensagem apropriada para marcador para ajuda mapa.
     * 
     * @returns {undefined}
     */
    function setMsgMarcadorAjudaMapa() {
        if (MAPA_API.getId() || ESP_CONSTANTES.pais === MAPA_API.getContexto()) {
            $('#aviso-ajuda-mapa .msg').html(lang_mng.getString('mp_aviso_ajuda_espacialidade'));
        } else {
            $('#aviso-ajuda-mapa .msg').html(lang_mng.getString('mp_aviso_ajuda_marcador'));
        }
    }
</script>
<!--  /aviso ajuda -->

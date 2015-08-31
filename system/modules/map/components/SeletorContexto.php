<div id="seletor_contexto">
    <div id="select_contexto">
        <div class="lista-contexto no-print">
            <div id="label-contexto" class="label"><?php echo $lang_mng->getString('mp_label_contexto'); ?></div>
            <ul>
                <li id="contexto_pais"><?php echo $lang_mng->getString('mp_item_contexto_brasil'); ?></li>
                <!--<li id="contexto_estado"><?php echo $lang_mng->getString('mp_item_contexto_estado'); ?></li>
                <li id="contexto_rm"><?php echo $lang_mng->getString('mp_item_contexto_rm'); ?></li>-->
            </ul>
        </div>
    </div>
</div>

<?php

/**
 * Nome espacialidade index.
 * 
 * @param {number|string} espacialidade 
 * @return {string} Nome espacialidade internacionalizada.
 */
function getEspacialidadeDeLangMng($espacialidade) {
    switch ((int) $espacialidade) {
        case ESP_ESTADUAL:
            return 'mp_item_camada_estado';
        case ESP_REGIAOMETROPOLITANA:
            return 'mp_item_camada_rm';
        case ESP_UDH:
            return 'mp_item_camada_udh';
        case ESP_MUNICIPAL:
            return 'mp_item_camada_mun';
        case ESP_REGIONAL:
            return 'mp_item_camada_reg';
        case ESP_REGIAODEINTERESSE:
            return 'mp_item_camada_ri';
        default:
            return null;
    }
}
?>

<div id="aviso-ajuda-seletor-contexto" class="aviso-ajuda">
    <div class="close">&times;</div>
    <div class="msg"><?php echo $lang_mng->getString('mp_aviso_ajuda_seletor_contexto');?></div>
</div>


<script>
    $(document).ready(function () {
        $('#aviso-ajuda-seletor-contexto .close').bind('click', function (evt) {
            $('.aviso-ajuda').hide();
            $('#botao-aviso-ajuda').removeClass('selecionado');
            evt.stopPropagation();
        });
    });
</script>
<!-- /aviso -->

<script type="text/javascript">

    /**
     * Contexto Brasil.
     * 
     * @return {undefined}
     */
    function contextoBrasil() {
        var mapa = MAPA_API, espacialidade,
                contexto    = ESP_CONSTANTES.pais, 
                indicador   = mapa.getIndicador();
        
        // limpa campo de busca
        $(".txt_busca_mapa").val('');

        // reset items do seletor de espacialidade
        $('#item_espacialidade_3, #item_espacialidade_4, ' 
                + '#item_espacialidade_5, #item_espacialidade_6, ' 
                + '#item_espacialidade_10').remove();
        
        $('.lista-espacialidade ul')
                .prepend('<li id="item_espacialidade_4">' + lang_mng.getString('mp_item_camada_estado') + '</li>');

        mapa.setMarcadoresVisivel(false);
        mapa.setContexto(contexto, true);
        mapa.setId(103, true);
        
        if (+mapa.getEspacialidade() === ESP_CONSTANTES.regiaometropolitana 
                || +mapa.getEspacialidade() === ESP_CONSTANTES.udh 
                || +mapa.getEspacialidade() === ESP_CONSTANTES.regional
        ) {
            // espacialidade de município
            espacialidade = ESP_CONSTANTES.municipal;
            MAPA_API.setEspacialidade(espacialidade, true);
            $('#espacialidade_atual').text(lang_mng.getString('mp_item_camada_mun'));
        } else {
            espacialidade = mapa.getEspacialidade();
        }

        $('#titulo_contexto').text(lang_mng.getString('mp_item_contexto_brasil'));

        mapa.simpleMapQuery(
                103,
                espacialidade,
                indicador,
                mapa.getAno(),
                contexto);

        $('.lista-contexto,.lista-espacialidade').hide();

        mapa.centralizaMapa();
        mapa.resetControleZoom();
    } 


    /**
     * Contexto RM.
     * 
     * @return {undefined}
     */
    function contextoRm() {
        var contexto = ESP_CONSTANTES.regiaometropolitana;

        MAPA_API.destravaZoom();

        limpaMapaAtual();

        $('.lista-espacialidade ul')
                .prepend('<li id="item_espacialidade_6">' + lang_mng.getString('mp_item_camada_rm') + '</li>')
                .append('<li id="item_espacialidade_3">' + lang_mng.getString('mp_item_camada_reg') + '</li>')
                .append('<li id="item_espacialidade_5">' + lang_mng.getString('mp_item_camada_udh') + '</li>');

        resetCoordsMapa(contexto, COORDS_RM);

        if (+MAPA_API.getEspacialidade() === ESP_CONSTANTES.estadual) {
            MAPA_API.setEspacialidade(contexto, true);
            $('#espacialidade_atual').text(lang_mng.getString('mp_item_camada_rm'));
        }

        $('#titulo_contexto').text(lang_mng.getString('mp_item_contexto_rm'));

        refreshMapa();
    } 


    /**
     * Contexto de Estados.
     * 
     * @return {undefined}
     */
    function contextoEstado() {
        var contexto = ESP_CONSTANTES.estadual;

        MAPA_API.destravaZoom();

        limpaMapaAtual();

        $('.lista-espacialidade ul').prepend('<li id="item_espacialidade_4">' + lang_mng.getString('mp_item_camada_estado') + '</li>');

        resetCoordsMapa(contexto, COORDS_UF);

        if (+MAPA_API.getEspacialidade() === ESP_CONSTANTES.regiaometropolitana 
                || +MAPA_API.getEspacialidade() === ESP_CONSTANTES.udh 
                || +MAPA_API.getEspacialidade() === ESP_CONSTANTES.regional) {
            MAPA_API.setEspacialidade(contexto, true);
            $('#espacialidade_atual').text(lang_mng.getString('mp_item_camada_estado'));
        }

        $('#titulo_contexto').text(lang_mng.getString('mp_item_contexto_estado'));

        refreshMapa();
    }

    /**
     * Limpa mapa para seleção de espacialidades.
     * 
     */
    function limpaMapaAtual() {
        // remove todas as camadas
        $('#item_espacialidade_3, #item_espacialidade_4, ' 
                + '#item_espacialidade_5, #item_espacialidade_6, '
                + '#item_espacialidade_10').remove();
        
        $(".txt_busca_mapa").val('');

        MAPA_API.resetMapa();
        MAPA_API.setMarcadoresVisivel(false);
    }

    /**
     * Reseta mapa.
     * 
     */
    function refreshMapa() {
        MAPA_API.escondeLegenda();
        MAPA_API.inicializaMapa();
        MAPA_API.centralizaMapa();
        MAPA_API.resetControleZoom();
    }
    
    /**
     * Reset coords map.
     * 
     * @param {number|string} contexto
     * @param {array} coords
     */
    function resetCoordsMapa(contexto, coords) {
        MAPA_API.setCoordenadas(coords);
        MAPA_API.setContexto(contexto, true);
        MAPA_API.setId(null, true);
        
        // zoom
        var maxZoom = convertType(<?php echo MAX_ZOOM; ?>);
        var minZoom = convertType(<?php echo MIN_ZOOM; ?>);
        MAPA_API.setZoomRange(maxZoom, minZoom);      
    }
    
    /**
     * Padrão ano 2010.
     * 
     */
    function setAnoPadrao2010() {
        MAPA_API.setAno(convertAno(2010));
        
        $('#seletor_ano span').removeClass('ano_atual')
                .parent()
                .find('span#ano_3')
                .addClass('ano_atual');
    }


    $(function () {
        $('#contexto_pais').on('click', function () {
            contextoBrasil();

        });

        $('#contexto_rm').on('click', function () {
            contextoRm();
        });

        $('#contexto_estado').on('click', function () {
            contextoEstado();
        });

        $('#titulo_contexto').on('click', function (event) {
            $('.lista-contexto').toggle();
            $('#contexto_atual').toggleClass('highlight');
            $('.lista-espacialidade,#indicador-holder,.aviso-ajuda').hide();
            event.stopPropagation();
        });

    });
</script>

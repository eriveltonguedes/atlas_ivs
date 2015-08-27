<!-- seletor indicadores -->
<div id="indicador-holder" class="divCallOut no-print">
    <div class="dimensao box dim">
        <h6 class="title_box" id="seletor_dimensao"><?php echo $lang_mng->getString("seletor_dimensao"); ?></h6>
        <ul id="list_menu_indicador_dimensoes"
            class="nav nav-list list_menu_indicador dim"></ul>
    </div>

    <div class="tema box">
        <h6 class="title_box" id="seletor_tema"><?php echo $lang_mng->getString("seletor_tema"); ?></h6>
        <ul id="list_menu_indicador_temas"
            class="nav nav-list list_menu_indicador"></ul>
    </div>

    <div class="indicador box">
        <a id="fecha_menu_indicador" class="close indicador">&times;</a>
        <h6 class="title_box" id="seletor_indicador"><?php echo $lang_mng->getString("seletor_indicador"); ?></h6>
        <ul id="list_menu_indicador_indicadores" class="nav nav-list list_menu_indicador"></ul>
    </div>
</div>
<!-- /seletor indicadores -->

<script type="text/javascript">

    /**
     * Retorna indicadores do seletor.
     * 
     * @returns {array}
     */
    function retornaIndicadores() {
        return $('#indicador-holder').data('indicadores');
    }


    /**
     * Salva indicador selecionado.
     * 
     * @param {number} indicadores
     */
    function salvaIndicadores(indicadores) {
        $('#indicador-holder').data('indicadores', indicadores);
    }



    /**
     * Filtra indicadores pelo id fornecido.
     * 
     * @param {number} id Id de pesquisa do indiador.
     */
    function filtraPeloId(id) {
        var arr, arrIndicadores, arrTemas, arrResultado, arrFiltro, i, j, len, len2;

        arr             = retornaIndicadores();
        arrIndicadores  = arr['indicadores'];
        arrTemas        = arr['var_has_tema'];
        arrResultado    = [];
        arrFiltro       = [];

        // filtra temas pelo id do indicador
        for (i = 0, len = arrTemas.length; i < len; i++) {
            if (arrTemas[i]['tema'] === id) {
                arrFiltro.push(arrTemas[i]['variavel']);
            }
        }

        // dentro do filtro dos temas, os id dos indicadores
        for (i = 0, len = arrFiltro.length; i < len; i++) {
            for (j = 0, len2 = arrIndicadores.length; j < len2; j++) {
                if (parseInt(arrFiltro[i], 10) === parseInt(arrIndicadores[j]['id'], 10)) {
                    arrResultado.push(arrIndicadores[j]);
                }
            } // j
        } // i

        return arrResultado;
    }


    /**
     * Adiciona a lista de dimensões no seletor componente.
     * 
     * @param {object} listaDeDimensoes
     */
    function adicionaDimensoes(listaDeDimensoes) {
        $('#list_menu_indicador_dimensoes li, #list_menu_indicador_indicadores li, #list_menu_indicador_temas li').remove();
        
        $.each(listaDeDimensoes, function(i, item) {
            $('#list_menu_indicador_dimensoes').append('<li id="dimensoes_' + item.id + '"><span>' + item.n + '</span></li>');
        });
    }


    /**
     * Adiciona lista de indicadores no seletor componente.
     * 
     * @param {Object} listaDeIndicadores
     */
    function adicionaListaDeIndicadores(listaDeIndicadores) {
        $('#list_menu_indicador_indicadores li').remove();

        $.each(listaDeIndicadores, function(i, item) {
            $('#list_menu_indicador_indicadores')
                    .append('<li id="indicadores_' + item.id + '" data-toggle="tooltip" data-original-title="' + item.desc + '"><span>' + item.nc + '</span></li>');
        });

        // adiciona tooltip
        $('[data-toggle="tooltip"]').tooltip({delay: 500});
    }


    /**
     * Filtra temas pelo id (tema_superior).
     * 
     * @param {number} temaSuperiorId
     * @return {boolean}
     */
    function filtraPorTemaId(temaSuperiorId) {
        var indicadores = retornaIndicadores();

        return $(indicadores['temas']).filter(function() {
            return this['tema_superior'] === temaSuperiorId;
        });
    }


    /**
     * Adiciona lista de temas ao componente seletor.
     * 
     * @param {array} listaDeTemas
     */
    function adicionaListaDeTemas(listaDeTemas) {
        var indicadores = retornaIndicadores();

        $('#list_menu_indicador_temas').find('li').remove();

        $.each(listaDeTemas, function(i, item) {
            $('#list_menu_indicador_temas').append(
                    '<li id="temas_' + item.id + '"><span>' + item.n + '</span></li>');
        });

        // temas composto
        $.each(indicadores['temas'], function(i, item) {
            if (+item.nivel === 3)
                $('#temas_' + item.id).css('textIndent', '9px');
        });
    }


    /**
     * Aviso carregando.
     */
    function mostraAvisoCarregando() {
        loadingHolder && loadingHolder.show("Carregando...");
    }
    ;

    /**
     * Fecha aviso carregando.
     */
    function fechaAvisoCarregando() {
        loadingHolder && loadingHolder.dispose();
    }


    /**
     * Limpa lista de temas e indicadores.
     */
    function limpaTemas() {
        // apaga valores anteriores de temas e indicadores
        $('#list_menu_indicador_temas li, #list_menu_indicador_indicadores li').remove();
    }


    /**
     * Limpa lista de indicadores selecionados.
     */
    function apagaIndicadoresSelecionados() {
        // apaga valores anteriores de temas e indicadores
        $('#list_menu_indicador_selecionados li').remove();
    }


    /**
     * Limpa todo as listagens de seletor componente.
     */
    function limpaSeletor() {
        $('#list_menu_indicador_temas li, #list_menu_indicador_indicadores li, #list_menu_indicador_dimensoes li').remove();
    }


    /**
     * Carrega(init) menu de indicadores.
     */
    function carregaIndicadores() {
        // reset menu
        limpaSeletor();
        
        $("#list_menu_indicador_dimensoes + .carregando").remove();

        function removeCarregando() {
            $('.carregando').remove();
            fechaAvisoCarregando();
        }

        $.ajax({
            url         : '<?php echo $path_dir; ?>system/modules/map/controller/IndicatorService.php?user_lang=' + (user_lang || 'pt'),
            dataType    : 'json',
            beforeSend  : function() {
                $('#list_menu_indicador_dimensoes').after('<span class="carregando"><img src="./assets/img/loader.gif" alt=""> ' + lang_mng.getString('mp_aviso_carregando') + '</span>');
            },
            error       : function() {
                removeCarregando();
            },
            success     : function(data) {
                salvaIndicadores(data);
                adicionaDimensoes(data['dimensoes']);
                removeCarregando();
            }
        });
    }
</script>
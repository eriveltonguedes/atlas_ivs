/**
 * Retorna indicadores.
 * @returns {Array}
 */
var retornaIndicadores = function() {
    return $('#indicador-holder').data('indicadores');
};

/**
 * Salva indicadores.
 * @param {Integer} indicadores
 */
var salvaIndicadores = function(indicadores) {
    $('#indicador-holder').data('indicadores', indicadores);
};


/**
 * Filtra indicadores pelo id.
 * 
 * @param {Integer} id Id de pesquisa do indiador.
 */
var filtraPeloId = function(id) {
    var arr, arrIndicadores, arrTemas, arrResultado, arrFiltro,
            i, j, len, len2;

    arr = retornaIndicadores();

    arrIndicadores  = arr['indicadores'];
    arrTemas        = arr['var_has_tema'];
    arrResultado    = [];
    arrFiltro       = [];

    // filtra temas pelo ID do indicador
    for (i = 0, len = arrTemas.length; i < len; i++) {
        if (arrTemas[i]['tema'] === id) {
            arrFiltro.push(arrTemas[i]['variavel']);
        }
    }

    // filtra dentro dos temas os ID dos indicadores dos temas
    for (i = 0, len = arrFiltro.length; i < len; i++) {
        for (j = 0, len2 = arrIndicadores.length; j < len2; j++) {
            if (parseInt(arrFiltro[i], 10) === parseInt(arrIndicadores[j]['id'], 10)) {
                arrResultado.push(arrIndicadores[j]);
            }
        }
    }

    return arrResultado;
};

/**
 * Adiciona lista de dimensões no menu.
 * 
 * @param {Object} listaDeDimensoes
 */
var adicionaDimensoes = function(listaDeDimensoes) {
    $('#list_menu_indicador_dimensoes li, #list_menu_indicador_indicadores li, #list_menu_indicador_temas li').remove();
    $.each(listaDeDimensoes, function(i, item) {
        $('#list_menu_indicador_dimensoes').append('<li id="dimensoes_' + item.id + '"><span>' + item.n + '</span></li>');
    });
};

/**
 * Adiciona indicadores.
 * 
 * @param {Object} listaDeIndicadores
 */
var adicionaListaDeIndicadores = function(listaDeIndicadores) {
    $('#list_menu_indicador_indicadores li').remove();

    $.each(listaDeIndicadores, function(i, item) {
        $('#list_menu_indicador_indicadores')
                .append('<li id="indicadores_' + item.id + '" data-toggle="tooltip" data-original-title="' + item.desc + '"><span>' + item.nc + '</span></li>');
    });

    // adiciona tooltip
    $('[data-toggle="tooltip"]').tooltip({delay: 500});
};

/**
 * Filtra temas por id.
 * 
 * @param {Integer}
 *            temaSuperiorId
 * @return {Boolean}
 */
var filtraPorTemaId = function(temaSuperiorId) {
    var indicadores = retornaIndicadores();

    return $(indicadores['temas']).filter(function() {
        return this['tema_superior'] === temaSuperiorId;
    });
};

/**
 * Adiciona lista de temas.
 * 
 * @param {Array}
 *            listaDeTemas
 */
var adicionaListaDeTemas = function(listaDeTemas) {
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
};

/**
 * Aviso carregando.
 */
var mostraAvisoCarregando = function() {
    loadingHolder && loadingHolder.show("Carregando...");
};

/**
 * Fecha aviso carregando.
 */
var fechaAvisoCarregando = function() {
    loadingHolder && loadingHolder.dispose();
};

/**
 * Limpa lista de temas e indicadores.
 */
var limpaTemas = function() {
    // apaga valores anteriores de temas e indicadores
    $('#list_menu_indicador_temas li, #list_menu_indicador_indicadores li').remove();
};

/**
 * Limpa indicadores.
 */
var apagaIndicadoresSelecionados = function() {
    // apaga valores anteriores de temas e indicadores
    $('#list_menu_indicador_selecionados li').remove();
};

/**
 * Limpa todo o menu.
 */
var limpaSeletor = function() {
    $('#list_menu_indicador_temas li, #list_menu_indicador_indicadores li, #list_menu_indicador_dimensoes li').remove();
};

/**
 * Carrega menu atlasbrasil.
 */
var carregaIndicadores = function() {
    // atualizando menu
    limpaSeletor();

    function removeCarregando() {
        $('.carregando').remove();
        fechaAvisoCarregando();
    }

    $.ajax({
        url: 'system/modules/map/controller/IndicatorService.php?user_lang=' + (user_lang || 'pt'),
        dataType: 'json',
        beforeSend: function() {
            $('#indicador-holder .carregando').remove();
            $('#list_menu_indicador_dimensoes').after('<span class="carregando"><img src="./assets/img/loader.gif" alt=""> ' + lang_mng.getString('mp_aviso_carregando') + '</span>');
        },
        error: function() {
            removeCarregando();
        },
        success: function(data) {
            self.salvaIndicadores(data);
            self.adicionaDimensoes(data['dimensoes']);
            removeCarregando();
        }
    });
};

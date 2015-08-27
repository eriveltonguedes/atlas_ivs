var dataSeletorIndicador = null;

/* =========================== VARIAVEIS GLOBAIS ================================*/
function IndicatorSelectorG()
{
    var value_indicador = new Array();
    var value_indicador_old = new Array();
    var load = false;
    var array_indicadores;
    var array_temas;
    var array_dimensoes;
    var array_indicadores_has_temas;
    var this_selector_element = null;
    var lazy_array;
    var multiYear = false;
    var divSeletor = $('<div class="divSeletor">');
    var listener = null;
    var eixo = new Array();
    eixo['y'] = false;
    eixo['x'] = false;
    eixo['tam'] = false;
    eixo['cor'] = false;

    var to_hide;
    var skipLimit = false;

    this.html = function(idElement, eixo_)
    {
//       console.log('html');
        eixo2 = eixo_;
        if (eixo2 == 'X' || eixo2 == 'Y') {
//            console.log('tem coisa');
            var button = '<div id="' + idElement + '" style="float: left; margin-left: -27px; margin-top: -5px;">'
                    + '<div class="divCallOut">'
                    + '<button class="gray_button big_bt selector_popover" data-toggle="dropdown" style="float:right; margin-right: 5px !important; font-size: 14px; padding: 5px 13px 5px 13px" rel="popover" >' + eixo2 + '</button>'
                    + '</div>'
                    + '</div>';
        }
        else {
            var button = '<div id="' + idElement + '" style="float: right; ">'
                    + '<div class="divCallOut">'
//            + '<a style="cursor: pointer"><img src="'+eixo2+'" class="selector_popover" data-toggle="dropdown" style="float:right;" rel="popover" ></a>'
                    + '<button class="gray_button selector_popover" data-toggle="dropdown" style="float:right; padding: 3px 7px;" rel="popover" >' + eixo2 + '</button>'
                    + '</div>'
                    + '</div>';
        }

        return button;
    };

    /**
     * @param multiselect - Especifica se a lista de indicadores serÃ¡ de mÃºltipla seleÃ§Ã£o ou de seleÃ§Ã£o simples
     */
    this.startSelector = function(multiselect, id_element_context, _listener, orientation, multiYear_, _to_hide, _skipLimit, eixo_) {
//        console.log('startSelector');
        listener = _listener;
        multiYear = multiYear_;
        eixo['eixo'] = eixo_;

        this_selector_element = '#' + id_element_context;

        to_hide = '#' + _to_hide;
        skipLimit = _skipLimit;

        html = "";
        html += '<div><div class="dimensao box dim"><h6 class="title_box">' + lang_mng.getString("seletor_dimensao") + '</h6><ul class="nav nav-list list_menu_indicador dim">' +
                '</ul></div>' +
                '<div class="tema box">' +
                '<h6 class="title_box">' + lang_mng.getString("seletor_tema") + '</h6><ul class="nav nav-list list_menu_indicador">' +
                '</ul></div>';
        if (multiselect == false) {
            html += '<div class="indicador box"><a class="close indicador">&times;</a><h6 class="title_box">' + lang_mng.getString("seletor_indicador") + '</h6><ul class="nav nav-list list_menu_indicador">' +
                    '</ul></div>';
        }
        else {
            html += '<div class="indicador box"><h6 class="title_box">' + lang_mng.getString("seletor_indicador") + '</h6><ul class="nav nav-list list_menu_indicador">' +
                    '</ul></div>';
        }

        if (multiselect == true) {
            html += '<div class="itens_selecionados box"><a class="close indicador">&times;</a><h6 class="title_box">' + lang_mng.getString("seletor_selecionados") + '</h6><ul class="nav nav-list list_menu_indicador"></ul></div></div>';
        }
        html += '</div>';
        html += '<div class="btn_select" style="display:none">';
        html += '<div class="messages"></div>';
        html += '<div class="buttons">';
        html += '<button class="blue_button big_bt btn_ok" type="button" style="float: right; font-size: 14px; height: 30px; padding: 5px 10px;">Ok</button>';
        html += '<button class="gray_button big_bt btn_clean" type="button" style="width: 162px; font-size: 14px; height: 30px; margin-left: 20px;">'+ lang_mng.getString("limpar_selecionados") +'</button><div>';
        html += '</div>';

        divSeletor.html(html);

        $(this_selector_element).find('.selector_popover').popover(
                {
                    html: true,
                    trigger: 'manual',
                    placement: orientation,
                    delay: {show: 350, hide: 100},
                    content: divSeletor.html()
                }).click(function(e) {
            $(this_selector_element).find('.messages').html("");
            $(to_hide).find('.divCallOutLugares').removeClass('open');
            $(to_hide).find('.divCallOutLugares .popover').css('display', 'none');

            startPopOver(multiselect);
        });
        closePopOver();

    };

    this.refresh = function()
    {
//        console.log('this.refresh');
        refresh();
    };

    this.setIndicadores = function setIndicadores(array_values)
    {
//        console.log('setIndicadores');
        setIndicadoresValue(array_values);
    };

    this.getEixo = function() {
        return eixo;
    }

    function startPopOver(multiselect)
    {
//        console.log('startPopOver');
        if (eixo['eixo'] != false) {
            geral.setEixo(eixo['eixo']);
            if (eixo['eixo'] == 'y') {
                eixo['y'] = true;
                eixo['x'] = false;
                eixo['tam'] = false;
                eixo['cor'] = false;
            }
            else if (eixo['eixo'] == 'x') {
                eixo['y'] = false;
                eixo['x'] = true;
                eixo['tam'] = false;
                eixo['cor'] = false;
            }
            else if (eixo['eixo'] == 'tam') {
                eixo['y'] = false;
                eixo['x'] = false;
                eixo['tam'] = true;
                eixo['cor'] = false;
            }
            else if (eixo['eixo'] == 'cor') {
                eixo['y'] = false;
                eixo['x'] = false;
                eixo['tam'] = false;
                eixo['cor'] = true;
            }
        }

        $(this_selector_element).find('.messages').html("");
        refresh();

        $(this_selector_element).find('.divCallOut .popover').toggle();

        value_indicador_old = value_indicador.slice();

        if (load == false)
        {
            $(this_selector_element).find('.selector_popover').popover('show');

            loadData(multiselect, listener);

            if (multiselect == true)
            {
                $(this_selector_element).find('div.divCallOut .popover-inner,div.divCallOut .popover-content,div.divCallOut .popover').css('height', '360px');
                $(this_selector_element).find('div.divCallOut .popover-inner,div.divCallOut .popover-content,div.divCallOut .popover').css('width', '713px');

                $(this_selector_element).find('.btn_select').css('width', '699px');
                $(this_selector_element).find('.btn_select').css('display', 'inline');

                $(this_selector_element).find('.btn_clean').click(function(e) {

                    value_indicador = new Array();

                    $(this_selector_element).find('.indicador ul li').removeClass('selected');
                    $(this_selector_element).find('.indicador ul li .indicador_ano span').removeClass('selected');
                    value_indicador_old = value_indicador.slice();
                    fillSelectedItens();
                });

                $(this_selector_element).find('.btn_ok').click(function(e) {
                    $(this_selector_element).find('.divCallOut .popover').toggle();

                    dispatchListener();
                });
            }

            else {
                $(this_selector_element).find('div.divCallOut .popover-inner,div.divCallOut .popover-content,div.divCallOut .popover').css('height', '310px');
                $(this_selector_element).find('div.divCallOut .popover-inner,div.divCallOut .popover-content,div.divCallOut .popover').css('width', '513px');
            }

            $(this_selector_element).find('.close').click(function(e) {
                $(this_selector_element).find('div.divCallOut .popover').hide();
                return 0;
            });
        }
        fillSelectedItens();
        fillSelectedItensOfCurrentListOfIndicador();
    }

    function dispatchListener()
    {
//       console.log('dispatchListener');
        listener(value_indicador);
    }

    function fillSelectedItensOfCurrentListOfIndicador()
    {
//         console.log('fillSelectedItensOfCurrentListOfIndicador');
        $(this_selector_element).find('.indicador ul li').removeClass('selected');
        $(this_selector_element).find('.indicador ul li .indicador_ano span').removeClass('selected');

        var indicadoresDaListaAtual = new Array();

        $(this_selector_element).find('.indicador ul li').each(function(i, item)
        {
            var value = parseInt($(this).attr('data-id'));
            indicadoresDaListaAtual.push(value);
        });

        $.each(indicadoresDaListaAtual, function(i, value)
        {
            var elementLi = '.indicador ul li[data-id=' + value + ']';

            $li = $(this_selector_element).find(elementLi);

            var array = getArrayOfIndicadores(value);

            if (array.length >= 1)
                $li.addClass('selected');

            $.each(array, function(i, item)
            {
                var element = '.indicador_ano span[data-id=' + item.a + ']';

                $li.find(element).addClass('selected');
            });
        });
    }

    function fillSelectedItens()
    {
//         console.log('fillSelectedItens');
        var indicadoresDistintos = getIndicadoresDistintos(value_indicador);
        var html = "";

        $.each(indicadoresDistintos, function(i, item) {
            var array = getArrayOfIndicadores(item.id);
            var classItem = ((array.length >= 1) ? 'class="selected"' : '');
            var classYear = getDivAno(array, item.id);

            html += "<li data-id='" + item.id + "' data-desc='" + item.desc + "' data-sigla='" + item.sigla + "' " + classItem + "><a title='" + item.desc + "'>" + item.nc + "</a>" + classYear + "</li>";
        });

        $(this_selector_element).find('.itens_selecionados .nav').html(html);


        enableClickYear();
        $(this_selector_element).find(".itens_selecionados ul li a").tooltip({delay: 500});
    }

    function enableClickYear()
    {
//        console.log('enableClickYear');
        $(this_selector_element).find(".itens_selecionados ul li .indicador_ano span").click(function()
        {
            var idIndicadorSelecionado = parseInt($(this).attr('data-indicador'));
            var anoSelecionado = parseInt($(this).attr('data-id'));

            var indicadorEmAnos = getArrayOfIndicadores(idIndicadorSelecionado);

            if ($(this).hasClass('selected') == true)
            {
                if (indicadorEmAnos.length > 1)
                {
                    $(this).removeClass('selected');
                    var objeto = getIndicadorById(idIndicadorSelecionado);
                    objeto.a = anoSelecionado;
                    removeIndicador(objeto);
                }
            }
            else
            {
                var objeto = getIndicadorById(idIndicadorSelecionado);
                objeto.a = anoSelecionado;
                adicionaIndicador(objeto, $(this));
            }
        });
    }


    /**
     * Carrega a lista de dimensÃµes da primeira coluna
     */
    function loadData(multiselect)
    {
        load = true;

        if (dataSeletorIndicador == null)
        {
            $.getJSON('system/modules/tabela/util/filtros.php?user_lang=' + lang_mng.getString("lang_id"), function(data) {
                dataSeletorIndicador = data;
                fillData(data, multiselect);
            });
        }
        else
        {
            fillData(dataSeletorIndicador, multiselect);
        }
    }


    function fillData(data, multiselect)
    {
//        console.log('fillData');
        array_indicadores = data.indicadores;
        array_dimensoes = data.dimensoes;
        array_temas = data.temas;
        array_indicadores_has_temas = data.var_has_tema;

        var html = "";

        $.each(array_dimensoes, function(i, item)
        {
            html += "<li data-id=" + item.id + "><a>" + item.n + "</a></li>";
        });

        $(this_selector_element).find('.dimensao .nav').html(html);
        $(this_selector_element).find('.dimensao ul li').click(function(e) {
            $(this_selector_element).find('.dimensao ul li').removeClass('active');
            $(this).addClass('active');

            $(this_selector_element).find('.tema .nav').html('');
            $(this_selector_element).find('.indicador .nav').html('');
            filtro_tema($(this).attr('data-id'), multiselect);
        });
    }

    /**
     * Filtra os temas pela dimensao.
     * Caso nÃ£o existam temas para a dimensÃ£o selecionada serÃ£o carregados os indicadores da mesma
     */
    function filtro_tema(value, multiselect)
    {
//        console.log('filtro_tema');
        var temas = getTemasPorDimensao(value);

        if (temas.length == 0)
        {
            var indicadores = getIndicadoresPorTema(value);
            fillTemas(new Array());
            fillIndicadores(indicadores, multiselect);
        }
        else
        {
            fillTemas(temas);
        }

        $(this_selector_element).find('.tema ul li').click(function(e)
        {
            $(this_selector_element).find('.tema ul li').removeClass('active');
            $(this).addClass('active');

            if ($(this).attr('data-id') == -1)
                filtro_indicador($(this_selector_element).find('.dimensao .nav .active').attr('data-id'), multiselect);
            else
                filtro_indicador($(this).attr('data-id'), multiselect);
        });
    }

    function getTemasPorDimensao(temaSuperior)
    {
//        console.log('getTemasPorDimensao');
        var lista = new Array();

        $.each(array_temas, function(i, item) {
            if (item.tema_superior == temaSuperior)
                lista.push(item);
        });
        return lista;
    }

    function getIndicadoresPorTema(value)
    {
//        console.log('getIndicadoresPorTema');
        var listaIndicadorHasTema = new Array();
        var listaIndicadores = new Array();

        $.each(array_indicadores_has_temas, function(i, item)
        {
            if (item.tema == value) {
                listaIndicadorHasTema.push(item);
            }
        });

        $.each(array_indicadores, function(i, item)
        {
            if (containsInFilter(listaIndicadorHasTema, item.id) == true)
            {
                listaIndicadores.push(item);
            }
        });

        return listaIndicadores;
    }

    /**
     * Passa uma lista que contem os indicadores de certo tema e verifica se o indicador passado como parÃ¢metro estÃ¡ na lista
     */
    function containsInFilter(listaIndicadorHasTema, idIndicador)
    {
//        console.log('containsInFilter');
        for (var i = 0; i < listaIndicadorHasTema.length; i++)
        {
            if (listaIndicadorHasTema[i].variavel == idIndicador)
                return true;
        }
        return false;
    }

    /**
     * Filtra os indicadores pelo tema selecionado
     */
    function filtro_indicador(value, multiselect)
    {
//        console.log('filtro_indicador');
        var indicadores = getIndicadoresPorTema(value);
        fillIndicadores(indicadores, multiselect);
    }

    function adicionaOpcaoTodos(array)
    {
//        console.log('adicionaOpcaoTodos');
        var value = new IndicadorPorAno();

        value.desc = "";
        value.nc = lang_mng.getString("seletor_selec_todos");
        value.sigla = "";

        value.id = '-1';
        var newArray = [value];
        array = newArray.concat(array);

        return array;
    }

    /**
     * @param array - Recebe um array de valores, com propriedades nome e id
     * multiselect Especifica se a lista serÃ¡ de mÃºltipla seleÃ§Ã£o ou de seleÃ§Ã£o simples
     * Preenche a lista de indicadores com os valores do array
     */
    function fillIndicadores(indicadores, multiselect)
    {
//        console.log('fillIndicadores');
        var array;
        if (multiselect == true && (indicadores.length > 0))
            array = adicionaOpcaoTodos(indicadores);
        else
            array = indicadores;
        var html = "";

        $.each(array, function(i, item)
        {
            if (multiselect == true)
            {
                var array = getArrayOfIndicadores(item.id);
                var classItem = ((array.length >= 1) ? 'class="selected"' : '');

                html += "<li data-id='" + item.id + "' data-desc='" + item.desc + "' data-sigla='" + item.sigla + "' " + classItem + "><a title='" + item.desc + "'>" + item.nc + "</a></li>";
            }
            else
                html += "<li data-id='" + item.id + "' data-desc='" + item.desc + "' data-sigla='" + item.sigla + "'><a>" + item.nc + "</a></li>";
        });
        $(this_selector_element).find('.indicador .nav').html(html);
        listenerClickIndicador(multiselect);
    }

    function getDivAno(arrayIndicadores, idIndicador)
    {
//        console.log('getDivAno');
        if (multiYear == false || multiYear == undefined)
            return "";

        var classAno1 = "";
        var classAno2 = "";
        var classAno3 = "";


        $.each(arrayIndicadores, function(i, item)
        {
            if (item.a === 1)
                classAno1 = 'selected';
            if (item.a === 2)
                classAno2 = 'selected';
            if (item.a === 3)
                classAno3 = 'selected';
        });

        var html = "<div class='indicador_ano'>";
        html += "<span data-id=1 style='text-align:left;padding-left:8px;' data-indicador=" + idIndicador + " class='year1 " + classAno1 + "'>1991</span>";
        html += "<span data-id=2 style='text-align:center' data-indicador=" + idIndicador + " class='year2 " + classAno2 + "'>2000</span>";
        html += "<span data-id=3 style='text-align:right' data-indicador=" + idIndicador + " class='year3 " + classAno3 + "'>2010</span>";
        html += "</div>";
        //console.log('html: '+html);
        return html;
    }

    /**
     * @param array - Recebe um array de valores, com propriedades nome e id
     * Preenche a lista de temas com os valores do array
     */
    function fillTemas(array)
    {
//        console.log('fillTemas');
        var html = "";

        $.each(array, function(i, item)
        {
            var style = "";
            if (item.nivel == 3)
                style = "style='padding-left: 20px;'";
            html += "<li data-id=" + item.id + "><a " + style + ">" + item.n + "</a></li>";
        });

        $(this_selector_element).find('.tema .nav').html(html);
    }

    /**
     * @param multiselect - Informa se a lista Ã© de mÃºltiplca seleÃ§Ã£o ou de simples seleÃ§Ã£o
     * Habilita o evento de click na lista.
     */
    function listenerClickIndicador(multiselect)
    {
//        console.log('listenerClickIndicador');
        if (multiselect == false)
        {
            $(this_selector_element).find('.indicador ul li').click(function(e) {
                $(this).addClass('active');

                $(this_selector_element).find('div.divCallOut .popover').hide();

                var objeto = getIndicadorById(parseInt($(this).attr('data-id')));

                value_indicador[0] = objeto;
                //fillLabelButtonIndicador(); Tirado por Elaine

                dispatchListener();
            });
        }
        else
        {
            $(this_selector_element).find('.indicador ul li a').click(function(e) {

                if (parseInt($(this).parent().attr('data-id')) == -1)
                {

                    var lengthAll = $(this_selector_element).find('.indicador ul li').length;
                    var lengthSelected = $(this_selector_element).find('.indicador ul li.selected').length;
                    var lengthUnSelected = lengthAll - lengthSelected - 1;
                    var length = value_indicador.length + lengthUnSelected;

                    $.each($(this_selector_element).find('.indicador ul li'), function(i, item)
                    {
                        var idSelecionado = parseInt($(this).attr('data-id'));
                        if (idSelecionado == -1)
                        {
                            $(this).removeClass('selected');
                        }
                        else
                        {
                            var ind = getIndicadorById(idSelecionado);
                            ind.a = 3;
                            adicionaIndicador(ind, $(this));
                        }
                    });
                    return;
                }

                var objeto = getIndicadorById(parseInt($(this).parent().attr('data-id')));

                if ($(this).parent().hasClass('selected') == false)
                {
                    objeto.a = 3;
                    adicionaIndicador(objeto, $(this).parent());
                }
                else
                {
                    $(this).parent().removeClass('selected');
                    $(this).parent().find('.indicador_ano span').removeClass('selected');

                    removeIndicadores(objeto);
                }
            });
        }

        $(this_selector_element).find(".indicador ul li a").tooltip({delay: 500});
    }

    function fillLabelButtonIndicador()
    {
//        console.log('fillLabelButtonIndicador');
        var objeto = value_indicador[0];
        textoIndicadorSelecionado = objeto.nc;

        if (textoIndicadorSelecionado.length > 8)
            textoIndicadorSelecionado = textoIndicadorSelecionado.slice(0, 8) + '...';

        $(this_selector_element).find('.selector_popover').html(textoIndicadorSelecionado);
        $(this_selector_element).find('.selector_popover').prop('title', objeto.nc);
    }


    /**
     * @description Verifica se o indicador estÃ¡ no array de indicadores selecionados
     */
    function contains(value)
    {
//        console.log('contains');
        var retorno = false;

        for (var i = 0; i < value_indicador.length; i++)
        {
            if (value_indicador[i].id == value.id && value_indicador[i].a == value.a)
            {
                retorno = true;
                break;
            }
        }

        return retorno;
    }

    function getPosition(value)
    {
//        console.log('getPosition');
        var retorno = -1;

        for (var i = 0; i < value_indicador.length; i++)
        {
            if (value_indicador[i].id == value.id)
            {
                retorno = i;
                break;
            }
        }

        return retorno;
    }

    function getArrayOfIndicadores(idIndicador)
    {
//        console.log('getArrayOfIndicadores');
        var array = new Array();
        for (var i = 0; i < value_indicador.length; i++)
        {
            if (parseInt(value_indicador[i].id) == parseInt(idIndicador))
                array.push(value_indicador[i]);
        }
        return array;
    }

    /**
     * Adiciona o indicador a lista de indicadores selecionados.
     */
    function adicionaIndicador(value, ele)
    {
//        console.log('adicionaIndicador');
        $(this_selector_element).find('.messages').html("");

        if (!skipLimit)
        {

            var idc = value_indicador.length + 1;
            var lug = geral.getTotalLugares();
            var produto = lug * idc;

//            if(produto >= JS_LIMITE_TELA && produto < JS_LIMITE_DOWN)
//            {
//                var message = '<div class="alert">';
//                message += '<button type="button" class="close" data-dismiss="alert">&times;</button>'
//                message += 'Seleção atual: Indicadores ('+ idc +'), Lugares ('+ lug +'), Células('+ produto +'). A tabela será disponibilizada para download.';
//                message += '</div>';
//                $(this_selector_element).find('.messages').html(message);
//            }
//            else if(produto >= JS_LIMITE_DOWN)
//            {
//                var message = '<div class="alert">';
//                message += '<button type="button" class="close" data-dismiss="alert">&times;</button>'
//                message += 'Atenção: sua consulta superou o limite de ('+ JS_LIMITE_DOWN +') células na tabela. <br/>Acesse "Download" e baixe todos os dados do Atlas Brasil 2013.';
//                message += '</div>';
//                $(this_selector_element).find('.messages').html(message); 
//                return 0;
//            }       
        }

        if (contains(value) == false)
        {
            ele.addClass('selected');

            if (value_indicador.length == 0)
                value.c = true;

            var posicao = getPosition(value);

            if (posicao != -1)
                value_indicador.splice(posicao, 0, value);
            else
                value_indicador.push(value);

            fillSelectedItens();
        }

    }

    /**
     * Remove um indicador da lista
     */
    function removeIndicador(value)
    {
//        console.log('removeIndicador');
        for (var i = 0; i < value_indicador.length; i++)
        {
            if (parseInt(value_indicador[i].id) == parseInt(value.id) && value_indicador[i].a == value.a)
            {
                value_indicador.splice(i, 1);
            }
        }
        fillSelectedItens();

        $(this_selector_element).find('.messages').html("");

        if (!skipLimit)
        {

            var idc = value_indicador.length;
            var lug = geral.getTotalLugares();
            var produto = lug * idc;


//            if(produto >= JS_LIMITE_TELA && produto < JS_LIMITE_DOWN)
//            {
//                var message = '<div class="alert">';
//                message += '<button type="button" class="close" data-dismiss="alert">&times;</button>'
//                message += 'Seleção atual: Indicadores ('+ idc +'), Lugares ('+ lug +'), Células('+ produto +'). A tabela será disponibilizada para download.';
//                message += '</div>';
//                $(this_selector_element).find('.messages').html(message);
//            }
//            else if(produto >= JS_LIMITE_DOWN)
//            {
//                var message = '<div class="alert">';
//                message += '<button type="button" class="close" data-dismiss="alert">&times;</button>'
//                message += 'Atenção: sua consulta superou o limite de ('+ JS_LIMITE_DOWN +') células na tabela. <br/>Acesse "Download" e baixe todos os dados do Atlas Brasil 2013.';
//                message += '</div>';
//                $(this_selector_element).find('.messages').html(message); 
//                return 0;
//            }       
        }
    }

    /**
     * Remove todas as ocorrÃªncias de um indicador
     */
    function removeIndicadores(value)
    {
//        console.log('removeIndicadores');
        var tmp_array = new Array();
        for (var i = 0; i < value_indicador.length; i++)
        {
            if (parseInt(value_indicador[i].id) != parseInt(value.id))
            {
                tmp_array.push(value_indicador[i]);
            }
        }
        value_indicador = tmp_array;

        fillSelectedItens();

        $(this_selector_element).find('.messages').html("");

        if (!skipLimit)
        {

            var idc = value_indicador.length;
            var lug = geral.getTotalLugares();
            var produto = lug * idc;

//            if(produto >= JS_LIMITE_TELA && produto < JS_LIMITE_DOWN)
//            {
//                var message = '<div class="alert">';
//                message += '<button type="button" class="close" data-dismiss="alert">&times;</button>'
//                message += 'Seleção atual: Indicadores ('+ idc +'), Lugares ('+ lug +'), Células('+ produto +'). A tabela será disponibilizada para download.';
//                message += '</div>';
//                $(this_selector_element).find('.messages').html(message);
//            }
//            else if(produto >= JS_LIMITE_DOWN)
//            {
//                var message = '<div class="alert">';
//                message += '<button type="button" class="close" data-dismiss="alert">&times;</button>'
//                message += 'Atenção: sua consulta superou o limite de ('+ JS_LIMITE_DOWN +') células na tabela. <br/>Acesse "Download" e baixe todos os dados do Atlas Brasil 2013.';
//                message += '</div>';
//                $(this_selector_element).find('.messages').html(message); 
//                return 0;
//            }       
        }

    }

    /**
     * @description Pega o objeto da lista de indicadores a partir da sigla
     */
    function getIndicadorById(value)
    {
//        console.log('getIndicadorById');
        var length = array_indicadores.length;
        for (var i = 0; i < length; i++)
        {
            var item = array_indicadores[i];
            if (parseInt(item.id) == parseInt(value))
            {
                var objeto = new IndicadorPorAno();
                objeto.id = item.id;
                objeto.c = item.c;
                objeto.a = item.a;
                objeto.desc = item.desc;
                objeto.nc = item.nc;

                return objeto;
            }
        }
    }

    function convertToArray(value)
    {
//        console.log('convertToArray');
        if ($.isArray(value))
            return value;
        else
            return [value];
    }

    function refresh()
    {
//        console.log('refresh');
        value_indicador = geral.getIndicadores().slice();
        fillSelectedItens();
    }

    function getIndicadoresDistintos(array)
    {
//        console.log('getIndicadoresDistintos');
        var novosIndicadores = new Array();
        for (var i = 0; i < array.length; i++)
        {
            var item = array[i];
            if (containsInArray(novosIndicadores, item) == false)
            {
                novosIndicadores.push(item);
            }
        }
        return novosIndicadores;
    }

    function containsInArray(array, value)
    {
//        console.log('containsInArray');
        for (var i = 0; i < array.length; i++)
        {
            if (array[i].id == value.id)
                return true;
        }
        return false;
    }

    function closePopOver()
    {
//        console.log('closePopOver');
        $('html').on('click.popover.divCallOut', function(e)
        {
            if ($(e.target).has('.divCallOut').length == 1)
            {
                $(this_selector_element).find('.divCallOut .popover').hide();

                value_indicador = value_indicador_old.slice();

            }
        });
    }

}
if (typeof jQuery === 'undefined') {
    throw new Error('FilterSearch JavaScript requires jQuery');
}

function SeletorEspacialidade() {
    var fs = "";
    //construtor	
    (function init() {
        fs = $.FilterSearch({
            data: {
                selectors: [{
                        name: lang_mng.getString("seletor_estado"),
                        nameSingleFilter: lang_mng.getString("seletor_estado_singular"),
                        id: 4,
                        method: "getEstados",
                        img: {
                            src: "/atlasbrasil/img/fruit_ninja.png",
                            width: "60px",
                            height: "60px"
                        },
                    }, {
                        name: lang_mng.getString("seletor_municipios"),
                        nameSingleFilter: lang_mng.getString("seletor_municipio"),
                        id: 2,
                        method: "getMunicipios",
                        filters: [[4], [6], [7]],
                        img: {
                            src: "/atlasbrasil/img/fruit_ninja.png",
                            width: "60px",
                            height: "60px"
                        },
                    }, 
                    /*{
                        name: lang_mng.getString("seletor_tematico"),
                        nameSingleFilter: lang_mng.getString("seletor_tematico_singular"),
                        id: 7,
                        method: "getAreasTematicas",
                        onlyFilter: true,
                        img: {
                            src: "/atlasbrasil/img/fruit_ninja.png",
                            width: "60px",
                            height: "60px"
                        },
                    }, {
                        name: lang_mng.getString("seletor_regioes_metropolitanas"),
                        nameSingleFilter: lang_mng.getString("seletor_regiao_metropolitana"),
                        id: 6,
                        method: "getRm",
                        img: {
                            src: "/atlasbrasil/img/fruit_ninja.png",
                            width: "60px",
                            height: "60px"
                        },
                    }, {
                        name: lang_mng.getString("seletor_udhs_regionais"), //UDHS
                        nameSingleFilter: lang_mng.getString("seletor_udh_sigla"),
                        id: 5,
                        labelSelected: "e",
                        method: "getUdh",
                        filters: [[10, 2]],
                        img: {
                            src: "/atlasbrasil/img/fruit_ninja.png",
                            width: "60px",
                            height: "60px"
                        },
                    }, {
                        name: lang_mng.getString("regionais"),
                        nameSingleFilter: lang_mng.getString("seletor_regional"),
                        id: 3,
                        method: "getRegional",
                        onlyFilter: true,
                        filters: [[2]],
                        img: {
                            src: "/atlasbrasil/img/fruit_ninja.png",
                            width: "60px",
                            height: "60px"
                        },
                    }*/],
                // url: "com/mobiliti/componentes/seletor-espacialidade/Search.services.php",
                url: "system/modules/seletor-espacialidade/controller/SearchEntities.controller.php",
            },
            element: "#button-fs",
            callbackOk: callbackOk
        });
    })();

    function setFiltersSelecteds(selecteds, filterSelecteds) {
        $.each(filterSelecteds, function (i, item) {

            var objeto = item;
            $.each(selecteds, function (j, item) {
                if (item.e == objeto.idParent) {
                    if (objeto.idFilter == "-1") {
                        //item.ids = [-1];
                        item.l = [-1];
                    }
                    else if (objeto.idFilter == "2") { // municipios
                        item.mun.push(parseInt(objeto.idItemSelector));
                    }
/*                    else if (objeto.idFilter == "6") {//rm
                        item.rm.push(parseInt(objeto.idItemSelector));
                    }
                    else if (objeto.idFilter == "5") {//udh
                        item.udh.push(parseInt(objeto.idItemSelector));
                    }*/
                    else if (objeto.idFilter == "4") {//estado
                        item.est.push(parseInt(objeto.idItemSelector));
                    }
/*                    else if (objeto.idFilter == "7") {//Área temática
                        item.areaTematica.push(parseInt(objeto.idItemSelector));
                    }*/
                }
            });
        });
        return selecteds;
    }

    function getSelectedsItens() {
        var selectedsItens = fs.getSelectedItens();

        var retorno = Array();
        var arrayFiltersSelecteds = Array();
        $.each(selectedsItens, function (i, item) {
            retorno[i] = {};
            retorno[i].e = item.id;
            retorno[i].mun = Array();
            retorno[i].rm = Array();
            retorno[i].est = Array();
            retorno[i].udh = Array();

            if (item.hasOwnProperty("selecteds")) {
                var itensSelecteds = item.selecteds;
                var ret = Array();
                $.each(itensSelecteds, function (j, item) {
                    if (typeof item == "object") {
                        arrayFiltersSelecteds.push(item);
                    }
                    else {
                        ret.push(parseInt(item));
                    }
                });

            }

            //if(ret!=null) ret = ret.toString();
            //else ret = "";
            //retorno[i].ids = ret;
            retorno[i].l = ret;
        });

        retorno = setFiltersSelecteds(retorno, arrayFiltersSelecteds);
        return retorno;
    }

    function callbackOk() {
        /*geral.setEntitiesSelecteds(getSelectedsItens());*/

        var indicadores = geral.getIndicadores();
        var espacialidade = getSelecteds();
        //mostrando mensagem de indicadores - falta internacionalizar
        if (indicadores.length === 0) {
            AtlasBrasil.messages({body: lang_mng.getString('alerta_selecao_indicador')});
        } else {

            // libera menu consulta
            /*$('#imgTab2,#imgTab3, #imgTab6').removeClass('disabled');*/
            if(espacialidade.length === 0 || indicadores.length === 0){
                $('#imgTab2,#imgTab3,#imgTab6').addClass('disabled');    
            }
            else{
                // libera menu consulta
                $('#imgTab2,#imgTab3,#imgTab6').removeClass('disabled');
                var entidadesSelecionadas = seletor.getEntitiesSelecteds();
                var retorno = false;
                $(entidadesSelecionadas).each(function(i,item){
                    
                    if(item == 5 || item == 3){
                        retorno = true;
                        return false;
                    }
                });
                if(retorno == true)
                    $('#imgTab3').addClass('disabled');
            }
            $(".general-alert").hide();
            loadingHolder.show(lang_mng.getString("carregando"));

            TableComponent.setSettings({//Settings iniciais para enviar pro server e iniciar a table.
                pagination: {
                    pageActive: 1,
                    limit: 20,
                    offset: 0,
                },
                dataAjax: {
                    entidades: seletor.getSelectedsItens(),
                    indicadores: geral.getIndicadores(),
                }
            });
            var data = {};
            data.dataAjax = {
                entidades: seletor.getSelectedsItens(),
                indicadores: geral.getIndicadores(),
                lang: lang_mng.getString('lang_id')
            };
            data.pagination = TableComponent.getSettings().pagination;

            $.ajax({
                url: "system/modules/tabela2/controller/tabelaController.php",
                type: "POST",
                data: {"dados": JSON.stringify(data)}
            }).done(function (retorno) {
                //Método para criar a tabela
                loadingHolder.dispose(); // esse dispose deve ser executado depois que a requisição finalizar. Atentar a assincronas
                TableComponent.create({
                    arrayPositionHideColumns: false,
                    aggregation: {
                        has: false,
                    },
                    dataAjax: {
                        entidades: seletor.getSelectedsItens(),
                        indicadores: geral.getIndicadores()
                    },
                    order: {
                        url: "system/modules/tabela2/controller/tabelaController.php",
                    },
                    pagination: {
                        url: "system/modules/tabela2/controller/tabelaController.php", //url do evento de paginação
                        count: retorno.count,
                    },
                    search: {
                        url: "system/modules/tabela2/controller/tabelaController.php",
                    },
                    columns: retorno.columns,
                    data: retorno.data,
                    configsData: {
                        link: retorno.perfil,
                        descricao: retorno.descricao,
                    },
                });
            });
        }

    }
    ;

    var getSelecteds = function () {
        var retorno = [];
        $(getSelectedsItens()).each(function (i, item) {

            if (typeof item.l !== 'undefined'
                    && ($.isArray(item.l) && item.l.length > 0)
                    || ($.isArray(item.est) && item.est.length > 0)
                    || ($.isArray(item.mun) && item.mun.length > 0)
                    || ($.isArray(item.udh) && item.udh.length > 0)
                    || ($.isArray(item.rm) && item.rm.length > 0))
            {
                retorno.push(item);
            }
        });
        return retorno;
    };

    var getEntitiesSelecteds = function() {
        var retorno = [];
        var selecteds = getSelecteds();
        $(selecteds).each(function(i,item){
            retorno.push(item.e);
        });
        return retorno;
    };

    return{
        getSelectedsItens: getSelectedsItens,
        getSelecteds: getSelecteds,
        getEntitiesSelecteds : getEntitiesSelecteds,
        fs: fs
    };
}
;

$(document).ready(function () {
    seletor = new SeletorEspacialidade();
});



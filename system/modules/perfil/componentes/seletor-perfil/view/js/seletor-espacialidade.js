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
                    }, {
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
                        name: lang_mng.getString("seletor_udhs"), //UDHS
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
                    }],
                // url: "com/mobiliti/componentes/seletor-espacialidade/Search.services.php",
                //#@Mudar caminho para pasta PERFIl
                url: "system/modules/perfil/componentes/seletor-perfil/controller/SearchEntities.controller.php",
            },
            element: "#button-fs",
            callbackOk: callbackOk
        });
    })();

    function setFiltersSelecteds(selecteds, filterSelecteds) {
        $.each(filterSelecteds, function(i, item) {

            var objeto = item;
            $.each(selecteds, function(j, item) {
                if (item.e == objeto.idParent) {
                    if (objeto.idFilter == "-1") {
                        //item.ids = [-1];
                        item.l = [-1];
                    }
                    else if (objeto.idFilter == "2") { // municipios
                        item.mun.push(parseInt(objeto.idItemSelector));
                    }
                    else if (objeto.idFilter == "6") {//rm
                        item.rm.push(parseInt(objeto.idItemSelector));
                    }
                    else if (objeto.idFilter == "5") {//udh
                        item.udh.push(parseInt(objeto.idItemSelector));
                    }
                    else if (objeto.idFilter == "4") {//estado
                        item.est.push(parseInt(objeto.idItemSelector));
                    }
                    else if (objeto.idFilter == "7") {//Área temática
                        item.areaTematica.push(parseInt(objeto.idItemSelector));
                    }
                }
            });
        });
        return selecteds;
    }

    function getSelectedsItens() {
        var selectedsItens = fs.getSelectedItens();

        var retorno = Array();
        var arrayFiltersSelecteds = Array();
        $.each(selectedsItens, function(i, item) {
            retorno[i] = {};
            retorno[i].e = item.id;
            retorno[i].mun = Array();
            retorno[i].rm = Array();
            retorno[i].est = Array();
            retorno[i].udh = Array();

            if (item.hasOwnProperty("selecteds")) {
                var itensSelecteds = item.selecteds;
                var ret = Array();
                $.each(itensSelecteds, function(j, item) {
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
        geral.setEntitiesSelecteds(getSelectedsItens());

        var indicadores = tab_indc.getValueIndicador();
        //mostrando mensagem de indicadores - falta internacionalizar
        if (indicadores.length === 0) {
            $(".msn-next-step").html("Próximo passo: Selecione um indicador.");
            $(".general-alert").show();
        }
        else {
            $(".msn-next-step").html("");
            $(".general-alert").hide();
            TableComponent.setSettings({//Settings iniciais para enviar pro server e iniciar a table.
                pagination: {
                    pageActive: 1,
                    limit: 20,
                    offset: 0,
                },
                dataAjax: {
                    entidades: seletor.getSelectedsItens(),
                    indicadores: geral.getIndicadores()
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
            }).done(function(retorno) {
                //Método para criar a tabela
                console.log(retorno);
                TableComponent.create({
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
                });
            });
            /*if(TableComponent.getSettings().instance != false){
             TableComponent.create(TableComponent.getSettings());
             }*/
        }

    }
    ;
    return{
        getSelectedsItens: getSelectedsItens,
        fs: fs
    };
}
;

$(document).ready(function() {
    seletor = new SeletorEspacialidade();
});



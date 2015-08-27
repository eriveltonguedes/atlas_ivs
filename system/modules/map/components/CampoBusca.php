
<!-- busca -->
<div id="busca_mapa" class="busca_mapa" style="display: none;">
    <img alt="" class="icon-lupa" src="<?php echo $path_dir ?>system/modules/map/assets/img/lupa.png" />
    <input type="text" class="txt_busca_mapa" value="" placeholder="<?php echo $lang_mng->getString('mp_label_pesquisar'); ?>" />
</div>

<style type="text/css">
    .ui-menu {
        background: white;
        color: black;
        padding: 1px;
    }
    .ui-front {
        border: none;
    }
    .ui-autocomplete,
    .ui-autocomplete .ui-corner-all {
        -webkit-radius: 0;
        border-radius: 0;
    }

    .ui-menu .ui-menu-item a {
        background: #fff;
    }
    .ui-menu .ui-menu-item a:active,
    .ui-menu .ui-menu-item a:hover {
        background: #eee;
        color: black;
        border-color: #eee;
    }

    .ui-autocomplete {
        border: 1px solid #ccc;
        border-color: #ccc #aaa #aaa #ccc;        
        max-height: 200px;
        overflow-y: auto;
        /* prevent horizontal scrollbar */
        overflow-x: hidden;
    }

    .ui-autocomplete .ui-state-focus {
        border-color: transparent;
        outline-color: transparent;
        color: black !important;
        background-color: #eee !important;
    }

    /* IE 6 doesn't support max-height
     * we use height instead, but this forces the menu to always be this tall
     */
    * html .ui-autocomplete {
        height: 100px;
    }
    .ui-autocomplete-loading {
        background: white url("<?php echo $path_dir; ?>assets/img/loader3.gif") right center no-repeat;
    }

    .ui-autocomplete-category {
        text-align: center;
        color: #555;
        margin: 5px 0 3px;
        padding: 5px 0;
        font-size: 12px;
        font-weight: bold;
        line-height: 1.4;
        border: 1px solid #ccc;
    }
    .ui-autocomplete-subcategory {
        text-align: right;
        color: #777;
        padding: 5px 3px;
        font-size: 10px;
        font-weight: bold;
        line-height: 1.2;
    }
</style>
<script type="text/javascript">
    $(function () {

        $.widget('custom.espacialidadeAutocomplete', $.ui.autocomplete, {
            _create     : function () {
                this._super();
                this.widget().menu("option", "items", "> :not(.ui-autocomplete-category)");
            },
            _renderMenu : function (ul, items) {
                var that = this, item, espacialidade, contornosId, existeOutrosMapasCamadas;

                espacialidade   = MAPA_API.getEspacialidade();
                contornosId     = MAPA_API.getContornosId();

                function addItemBusca(itemData, seletor) {
                    var n = itemData.nome,
                            l = (n.length > 30 ? n.slice(0, 30) + ' ...' : n);

                    // adiciona UF
                    if (itemData.uf) {
                        l += ' (' + itemData.uf + ')';
                    }

                    // adicona prefixo RM
                    if (item.idEntidade === ESP_CONSTANTES.regiaometropolitana) {
                        l = lang_mng.getString('mp_prefixo_rm') + ' ' + l;
                    }

                    that._renderItemData(ul, {
                        name    : n,
                        label   : l,
                        value   : [item.idEntidade, itemData.id]
                    }).insertAfter(seletor);
                };


                function existeNoMapa(item, contornosId) {
                    var itemDataId = [];

                    for (var j = 0, len = item.data.length; j < len; j++) {
                        itemDataId.push(+item.data[j].id);
                    }

                    return containsArray(contornosId, itemDataId);
                };
                
                
                function carregaItens(item, contornosId) {
                    $(item.data).each(function () {
                        if ($.inArray(+this.id, contornosId) !== -1) {
                            addItemBusca(this, '#mapa-atual');
                        } else {
                            addItemBusca(this, '#fora-mapa');
                        }
                    });
                };

                // verifica se já existe categoria outros mapas no autocomplete
                existeOutrosMapasCamadas = false;
                for (var i = 0, l = items.length; i < l; ++i) {
                    item = items[i];

                    if ((item.idEntidade === espacialidade) 
                            && (contornosId.length > 0 && existeNoMapa(item, contornosId))) {
                        ul.prepend("<li class='ui-autocomplete-category' id='mapa-atual'>Resultados neste mapa/camada:</li>");
                        carregaItens(item, contornosId);
                    } else {
                        // adicionada categoria outros mapa somente uma vez
                        if (!existeOutrosMapasCamadas) {
                            ul.append("<li class='ui-autocomplete-category' id='fora-mapa'>Resultados em outros mapas/camadas:</li>");
                            existeOutrosMapasCamadas = true;
                        }

                        if (item.data || item.data.length > 0) {
                            ul.append("<li class='ui-autocomplete-subcategory' id='fora-mapa-" + item.idEntidade + "'>" + getNomeEspacialidade(item.idEntidade) + "</li>");
                        }
                        $(item.data).each(function () {
                            addItemBusca(this, '#fora-mapa-' + item.idEntidade);
                        });
                    }
                } // fim: for

            },
            _renderItem : function (ul, item) {
                var er = new RegExp(str_regex_acentos(this.term), 'gi');

                return $('<li>')
                        .attr('data-value', item.value)
                        // http://stackoverflow.com/questions/26189673/jquery-autocomplete-how-to-make-matching-text-bold#answer-26190591
                        .append($('<a>').html(item.label.replace(er, '<b>$&</b>')))
                        .appendTo(ul);
            }
        });

        $(".txt_busca_mapa").espacialidadeAutocomplete({
            minLength   : 3,
            open        : function () { $('.ui-autocomplete').scrollTop(0); },
            source      : function (request, response) {
                $.ajax({
                    url         : '<?php echo $path_dir; ?>system/modules/seletor-espacialidade/controller/SearchEntities.controller.php',
                    type        : 'get',
                    dataType    : 'json',
                    data        : {
                        options : request.term,
                        method  : 'textSearch'
                    },
                    success     : function (resp) {
                        response(resp.data);
                    }
                });
            },
            focus   : function (event, ui) {
                event.preventDefault();
            },
            select  : function (event, ui) {
                var valorItem           = ui.item.value,
                        espacialidade   = +valorItem[0],
                        id              = +valorItem[1];

                buscaEspacialidadePeloId(espacialidade, id);

                // nome espacialidade no campo de busca
                $(this).val(ui.item.name);

                event.preventDefault();
            }
        });

        /**
         * Destaca a espacialidade.
         * 
         * @param {number} espacialidade
         * @param {number} id
         */
        function buscaEspacialidadePeloId(espacialidade, id) {
            var params, url, esp, contorno,
                    contornosAtual  = [],
                    contornos       = [];

            esp = +espacialidade;

            // procura id espacialidade
            for (var i = 0, l = MAPA_API.getContornosId().length; i < l; i++) {
                if (MAPA_API.getContornosId()[i] === id) {
                    contornosAtual.push(i);
                }
            }

            if (contornosAtual.length > 0
                    && esp === MAPA_API.getEspacialidade()) {

                for (var j = 0, len = contornosAtual.length; j < len; j++) {
                    contornos.push(MAPA_API.getContornos()[contornosAtual[j]]);
                }

                if (contornos.length === 0) {
                    throw Error('Espacialidade não encontrado.');
                }

                contorno = GMaps.getMaiorContorno(contornos);
                MAPA_API.getMapa().fitBounds(contorno.my_getBounds());
                MAPA_API.clicaContorno(contorno);
            } else {
                url = MAPA_API.getUrl();
                params = {tipo: 'coords', espacialidade: espacialidade, id: id};

                // TODO
                //        if (this.getContexto() !== ESP_CONSTANTES.pais) {
                //            this.resetMapa();
                //            this.setMarcadoresVisivel(true);
                //        }

                MAPA_API.mostraAvisoCarregando();

                $.ajax({
                    type        : 'get',
                    dataType    : 'json',
                    data        : params,
                    cache       : false,
                    url         : url,
                    error       : function () {
                        MAPA_API.fechaAvisoCarregando();
                    },
                    success     : function (response) {
                        var mapa = MAPA_API.getMapa();

                        if (response['sucesso']) {
                            // TODO
                            if (espacialidade === ESP_CONSTANTES.municipal
                                    || espacialidade === ESP_CONSTANTES.regional) {
                                mapa.setZoom(10);
                            } else if (espacialidade === ESP_CONSTANTES.udh) {
                                mapa.setZoom(14);
                            } else if (espacialidade === ESP_CONSTANTES.estadual
                                    || espacialidade === ESP_CONSTANTES.regiaometropolitana) {
                                mapa.setZoom(8);
                            }

                            mapa.panTo({
                                'lat': response['retorno']['__coords__'][0],
                                'lng': response['retorno']['__coords__'][1]
                            });

                        }
                    },
                    complete    : function () {
                        MAPA_API.fechaAvisoCarregando();
                    }
                });

            }
        }
        ;
    });
</script>
<!-- /busca -->


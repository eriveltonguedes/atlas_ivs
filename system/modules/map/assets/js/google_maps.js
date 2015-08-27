/**
 * Classe para Google Maps.
 * 
 * @package map
 * @author AtlasBrasil
 */

/**
 * Constructor.
 * 
 * @constructor
 * @param {geojson} coordenadas
 * @returns {GMaps}
 */
var GMaps = GMaps || function(coordenadas) {
    /** @private */
    this._coordenadas               = coordenadas;
    
    /** @private */
    this._zoomInicial               = 4;
    
    /** @private */
    this._infoSize                  = 280; // tamanho máximo do tooltip google maps

    // Atributos do mapa
    /** @private */
    this._marcadores                = {};
    
    /** @private */
    this._infoMarcadores            = {};
    
    /** @private */
    this._infoMarcador              = null;

    /** @private */
    this._infoWindow                = [];

    /** @private */
    this._valores                   = [];
    this._valores2                  = [];

    /** @private */
    this._contornos                 = [];
    
    /** @private */
    this._contornosId               = [];
    
    /** @private */
    this._contornoAtual             = null;
    
    /** @private */
    this._infoWindowAtual           = null;

    /** @private */
    this._debug                     = true;

    // legenda
    /** @private */
    this._faixasLegenda             = [];
    
    /** @private */
    this._faixasLegendaPadrao       = [];
    
    /** @private */
    this._faixasLegendaQuantil      = [];
    
    /** @private */
    this._tipoLegenda               = 1; // Padrão 1, Personalizada 2, Quantil 3

    /** @private */
    this._ultimaCorLinha            = null;
    
    /** @private */
    this._ultimaLarguraLinha        = null;

    /** @private */
    this._corSelecaoContorno        = 'white';
    
    /** @private */
    this._larguraSelecaoContorno    = 3;

    /** @private */
    this._corPreenchimentoPadrao    = 'transparent';
    
    /** @private */
    this._corLinhaPadrao            = 'black';
    
    /** @private */
    this._corSemValor               = '#999';
    
    /** @private */
//    this._corLegendaPadrao          = '#ccc';
    
    /** @private */
    this._larguraLinhaPadrao        = 0.35;
    
    /** @private */
    this._possuiContorno            = true;
    
    /** @private */
    this._corQuantil                = '#0065A5';
    
    /** @private */
    this._mapaTipoUrl               = {2: 'm', 4: 'uf', 5: 'udh', 6: 'rm'};

    /**
     * @private
     * @constant
     */
    this.TIPO_LEGENDA_PADRAO        = 1;

    /**
     * @private
     * @constant
     */
    this.TIPO_LEGENDA_PERSONALIZADA = 2;

    /**
     * @private
     * @constant
     */
    this.TIPO_LEGENDA_QUANTIL       = 3;

    /**
     * Tipo de legenda atual. 
     * Padrão 1, Personalizada 2, Quantil 3.
     * 
     * @private
     */
    this._tipoLegenda               = 1;
    
    /** @private */
    this._ultimoId                  = null;
    
    /** @private */
    this._ultimoContexto            = null;
    
    /** @private */
    this._ultimaEspacialidade       = null;
    
    /** @private */
    this._ultimoIndicador           = null;
    
    /** @private */
    this._ultimoAno                 = null;

    // Checa se o google maps foi carregado
    try {
        this._centroDoMapa          = new google.maps.LatLng(-15.134552411923314, -53.190445809999915); // coordenadas centro Brasil
        this._tipoDoMapa            = google.maps.MapTypeId.ROADMAP;
    } catch (e) {
        throw Error('Não foi possível localizar o Google Maps.');
    }
};



/**
 * Scroll Mapa.
 * 
 * @param {function} fn
 * @returns {undefined}
 */
GMaps.prototype.addScrollEvent = function(fn) {
    google.maps.event.addDomListener(window, 'resize', fn);  
};

/**
 * Load event Mapa.
 * 
 * @param {function} fn
 * @returns {undefined}
 */
GMaps.prototype.addLoadEvent = function(fn) {
  google.maps.event.addDomListener(window, 'load', fn);  
};


/**
 * Inicia Google Maps
 * 
 * @see https://developers.google.com/maps/documentation/staticmaps/?hl=pt-BR&csw=1#StyledMaps
 */
GMaps.prototype.inicializaMapa = function() {
    var mapa;

    this._resetAtributosMapa();

    if (!this.getMapa() || !(this.getMapa() instanceof google.maps.Map)) {
        mapa = this.criaMapa();
        this._salvaMapa(mapa);
    } else {
        mapa = this.getMapa();
        this.atualizaMapa();
    }
    
    $('#legenda_mapa').hide();
    
    this.resetControleZoom();
    
    this._adicionaMarcadorNoMapa(mapa, this._coordenadas);
};

/**
 * Atualiza GMaps.
 * 
 * @see http://stackoverflow.com/questions/15689656/google-maps-window-only-showing-part-of-the-map
 */
GMaps.prototype.atualizaMapa = function() {
    var mapa = this.getMapa();

    if (mapa instanceof google.maps.Map) {
        this.resetControleZoom();
        
        // atualizar tamanho mapa
        google.maps.event.trigger(mapa, 'resize');

        // atualizar controle zoom
        google.maps.event.trigger(mapa, 'zoom_changed');
    } else {
        throw new Error('Erro ao atualizar mapa.');
    }
};

/**
 * Função centralizar o mapa.
 * 
 */
GMaps.prototype.centralizaMapa = function() {
    var mapa = this.getMapa();

    if (mapa instanceof google.maps.Map) {
        google.maps.event.trigger(mapa, 'resize');
        mapa.setCenter(this._centroDoMapa);
        mapa.setZoom(this._zoomInicial);
    } else {
        throw new Error('Erro ao atualizar mapa.');
    }
};


/**
 * Cria um mapa.
 * 
 * @returns {google.maps.Map}
 */
GMaps.prototype.criaMapa = function() {
    var self = this, mapCanvas = document.getElementById('map-canvas');
    
    var mapa = new google.maps.Map(mapCanvas, {
        zoom        : self._zoomInicial,
        minZoom     : 4,
        mapTypeId   : self._tipoDoMapa
    });

    // centraliza pelo centro do mapa
    mapa.panTo(this._centroDoMapa);  // mapa.setCenter(this._centroDoMapa);   
           
    // zoom change
    google.maps.event.addListener(mapa, "zoom_changed",  (function() {
            var zoomMapaMenor = $('#zoom-mapa-menor'),
                zoomMapaMaior = $('#zoom-mapa-maior');
        
        return function() {
            if (mapa.minZoom && mapa.minZoom === mapa.zoom) {
                zoomMapaMenor.addClass('desativado');
            } else {
                if (zoomMapaMenor.hasClass('desativado')) zoomMapaMenor.removeClass('desativado');
            }

            if (mapa.maxZoom && mapa.maxZoom === mapa.zoom) {
                zoomMapaMaior.addClass('desativado');
            } else {
                if (zoomMapaMaior.hasClass('desativado')) zoomMapaMaior.removeClass('desativado');
            }
        };
    }()));
    
    // Busca centro do polígono:
    // http://stackoverflow.com/questions/3081021/how-to-get-the-center-of-a-polygon-in-google-maps-v3
    google.maps.Polygon.prototype.my_getBounds = function() {
        var bounds = new google.maps.LatLngBounds();
        this.getPath().forEach(function(element, index) {
            bounds.extend(element);
        });
        return bounds;
    };

    return mapa;
};

/**
 * Dispara evento de clique no marcador.
 * 
 * @param {number} idMarcador
 */
GMaps.prototype.clicaMarcador = function(idMarcador) {
    google.maps.event.trigger(this._marcadores[idMarcador], 'click');
};

/**
 * Seta coordenadas
 * 
 * @param {Object} coordenadas
 */
GMaps.prototype.setCoordenadas = function(coordenadas) {
    this._coordenadas = coordenadas;
};

/**
 * Trava o zoom do mapa.
 * 
 * @param {number} max
 * @param {number} min
 */
GMaps.prototype.setZoomRange = function(max, min) {
    var m = this.getMapa();
//    m.setZoom(min);
    m.setOptions({
        maxZoom : max,
        minZoom : min || null
    });
};

/**
 * Set o max zoom do mapa.
 * 
 * @param {number} max
 */
GMaps.prototype.setMaxZoom = function(max) {
    this.getMapa().setOptions({
        maxZoom: max || null
    });
};

/**
 * Destrava o zoom do mapa.
 * 
 */
GMaps.prototype.destravaZoom = function() {
    var m = this.getMapa();
    m.setOptions({
        maxZoom: null,
        minZoom: 4
    });
};

/**
 * Reseta atributos.
 * 
 * @private
 */
GMaps.prototype._resetAtributosMapa = function() {
    this._marcadores        = {};
    this._infoMarcadores    = {};
    this._infoMarcador      = null;
    this._infoWindow        = [];
    this._valores           = [];
    this._valores2          = [];
    this._contornos         = [];
    this._contornosId       = [];
    this._contornoAtual     = null;
    this._infoWindowAtual   = null;
};

/**
 * Reset contornos
 */
GMaps.prototype.resetAtributosDosContonos = function() {
//    this.setId(null);
    this._contornos         = [];
    this._contornosId       = [];
    this._valores           = [];
    this._valores2          = [];
    this._contornoAtual     = null;
};

/**
 * Reseta faixas da legenda.
 */
GMaps.prototype.resetFaixasLegenda = function() {
    this._faixasLegendaPadrao   = [];
    this._faixasLegenda         = [];
    this._faixasLegendaQuantil  = [];
};


/**
 * Variavél global do mapa.
 * 
 * @private
 * @param {google.maps.Map} mapa
 */
GMaps.prototype._salvaMapa = function(mapa) {
    $('#map-canvas').data('mapa', mapa);
};


/**
 * Retorna variavél global do mapa.
 * 
 * @return {google.maps.Map}
 */
GMaps.prototype.getMapa = function() {
    return $('#map-canvas').data('mapa') || null;
};

/**
 * Reseta zoom controle.
 * 
 */
GMaps.prototype.resetControleZoom = function() {
    $('#zoom-mapa-maior').removeClass('desativado');
    $('#zoom-mapa-menor').addClass('desativado');
};

/**
 * Cria marcador para mapa.
 * 
 * @private
 * @param {google.maps.Marker} mapa
 * @param {number} latitude
 * @param {number} longitude
 * @return {google.maps.Marker}
 */
GMaps.prototype._criaMarcador = function(mapa, latitude, longitude) {
    var url = this.getBaseUrl();
    return new google.maps.Marker({
        position    : new google.maps.LatLng(latitude, longitude),
        map         : mapa,
        icon        : url + 'system/modules/map/assets/img/logo_atlasbrasil.png'
    });
};

/**
 * Cria info do marcador.
 * 
 * @private
 * @param {string} content 
 * @param {google.maps.LatLng} latLng Coordenada.
 * @return {google.maps.InfoWindow}
 */
GMaps.prototype._criaInfoMarcador = function(content, latLng) {
    var size = this._infoSize;
    return new google.maps.InfoWindow({
        position    : latLng,
        content     : '<div style="line-height:1.35;overflow:hidden;white-space:nowrap;">' + content + '</div>',
        maxWidth    : size 
    });
};

/**
 * Cria marcador para mapa.
 * 
 * @private
 * @param {gooogle.maps.Mapa} mapa
 * @param {gooogle.maps.LatLng} latLng
 * @param {string} info Info
 * @return {google.maps.InfoWindow}
 */
GMaps.prototype._criaInfoPersonalizado = function(mapa, latLng, info) {
    var winInfo = new google.maps.InfoWindow(), 
            size = this._infoSize;

    winInfo.setOptions({maxWidth: size, content: info, position: latLng});
    winInfo.open(mapa);

    return winInfo;
};


/**
 * Cria os marcadores sobre as regiões metropolitanas.
 *
 * @private
 * @param {google.maps.Map} mapa Google Maps
 * @param {array} coordenadas Array de google.maps.LatLng.
 */
GMaps.prototype._adicionaMarcadorNoMapa = function(mapa, coordenadas) {
    var self = this, coords, id;

    if ($.isArray(coordenadas)) {
        $(coordenadas).each(function(i) {
            coords = coordenadas[i];

            id = coords['id'];
            
            self._marcadores[id] = self._criaMarcador(mapa, coords['lat'], coords['lng']);

            coords['zoom'] = parseInt(coords['zoom'], 10);

            self._adicionaOnclickMarcador(i, id, coords);
        }); // fim: each
    }
};

/**
 * Deixa visível/invisível todos os marcadores.
 * 
 * @param {boolean} visivel
 */
GMaps.prototype.setMarcadoresVisivel = function(visivel) {
    // reseta visiabilidade de todos marcadores
    $.each(this._marcadores, function() {
        this.setVisible(visivel);
    });
};


/**
 * Esconde o marcador atual.
 * 
 * @private
 * @param {google.maps.Marker} marcador
 */
GMaps.prototype._escondeMarcador = function(marcador) {
    this.setMarcadoresVisivel(true);
    // some marcador
    marcador.setVisible(false);
};

/**
 * Adiciona observador onclick para mostrar informações do marcador.
 * 
 * @private
 * @param {number} indexCoords
 * @param {number} id 
 * @param {Object} infoCoords
 */
GMaps.prototype._adicionaOnclickMarcador = function(indexCoords, id, infoCoords) {
    var coords, nome, marcador, mapa = this.getMapa();
    
    // converte para array
    coords = GMaps.converteGeoJsonParaArray(this._coordenadas[indexCoords]);

    // marcador atual
    marcador = this._marcadores[id];
    
    // verifica contexto rm adicionar prefixo
    if (this.getContexto() === ESP_CONSTANTES.regiaometropolitana) {
        nome = this._trataPrefixoRm(infoCoords['nome']);
    } else {
        nome = infoCoords['nome'];
    }

(function(self){
    
    google.maps.event.addListener(marcador, 'mouseover', function () {
        if (!self._infoMarcador) {
            self._infoMarcador = self._criaInfoMarcador(nome, marcador.getPosition());
            
            setTimeout(function () {
                if (self._infoMarcador) self._infoMarcador.open(self.getMapa(), marcador);
            }, 350);
        }
    });

    google.maps.event.addListener(marcador, 'mouseout', function() {
        if (self._infoMarcador) {
            self._infoMarcador.close();
            self._infoMarcador = null;
        }
    });

    google.maps.event.addListener(marcador, 'click', function() {
        // muda título com o nome do marcador 
        $('#titulo_contexto').html(nome);
        // limpa campo busca
        $('.txt_busca_mapa').val('');
        
//        // aviso ajuda 
//        if ($('#botao-aviso-ajuda').hasClass('selecionado')) {
//            $('.aviso-ajuda').hide();
//            $('#botao-aviso-ajuda').removeClass('selecionado');
//        }
        

        self.setId(id, true);

        // centraliza no mapa
        mapa.panTo(marcador.getPosition());
        mapa.setZoom(infoCoords['zoom']);

        // habilita contorno
        $('#contorno').removeClass('ativo').addClass('ativo');
        self._possuiContorno = true;

        self.simpleMapQuery(
                id,
                self.getEspacialidade(),
                self.getIndicador(),
                self.getAno(),
                self.getContexto());

        self._escondeMarcador(marcador);
    });
    
})(this);

};

/**
 * Tenta encontrar o melhor zoom para aquele shape.
 * 
 */
GMaps.prototype.melhorZoom = function() {
    var bounds;

    if (this._contornos.length === 1) {
        bounds = this._contornos[0].my_getBounds();
        
        this.getMapa().fitBounds(bounds);
    } else if (this._contornos.length > 1) {
        bounds = new google.maps.LatLngBounds();
        
        for (var i = 0, len = this._contornos.length; i < len; i++) {
            bounds.union(this._contornos[i].my_getBounds());
        }
        
        this.getMapa().fitBounds(bounds);
    }
};


/**
 * Converte JSON de geo do banco de dados em array.
 * 
 * @static
 * @param {JSON} coordsGeoJson
 * @return {array}
 */
GMaps.converteGeoJsonParaArray = function(coordsGeoJson) {
    var index, json;
    
    try {
        index = (!('geo_json' in coordsGeoJson) ? 2 : 'geo_json');
        json  = (JSON && JSON.parse(coordsGeoJson[index])) || $.parseJSON(coordsGeoJson[index]);
        
        // todo:
        if (json['type'].toLowerCase() === 'multipolygon') {
            return json['coordinates'];
        } else {
            return [json['coordinates']];
        }
        
    } catch (err) {
        return [];
    }
};


/**
 * Recupera faixas da legenda.
 * 
 * @param {number=} tipoFaixa
 * @return {array}
 */
GMaps.prototype.getFaixasLegenda = function(tipoFaixa) {
    if (tipoFaixa === this.TIPO_LEGENDA_PERSONALIZADA) {
        return this._faixasLegenda;
    } else if (tipoFaixa === this.TIPO_LEGENDA_QUANTIL) {
        return this._faixasLegendaQuantil;
    } else if (tipoFaixa === this.TIPO_LEGENDA_PADRAO) {
        return this._faixasLegendaPadrao;
    }
    return [];
};



/**
 * Verifica se existe dados para RM, UDH e regionais.
 * 
 * @static
 * @param {number|string} espacialidade
 * @param {number|string}  indicador
 * @param {number|string}  ano
 * @returns {boolean}
 */
GMaps.testaDados1991 = function (espacialidade, indicador, ano) {
    return ((indicador !== null)
            && (+ano === 1)
            && (+espacialidade === ESP_CONSTANTES.udh
                    || +espacialidade === ESP_CONSTANTES.regiaometropolitana
                    || +espacialidade === ESP_CONSTANTES.regional));
};

/**
 * Alerta falta de dados para o ano 1991.
 * 
 * @static
 * @param {boolean=} canvasMap Centraliza em realização aos canvas mapa.
 */
GMaps.prototype.mostraAviso1991 = function(canvasMap) {
    var screenWidth = $(canvasMap ? '#map-canvas' : window).innerWidth(),
            alertWidth = $('#aviso_1991').innerWidth();

    $('#aviso_1991').css('left', screenWidth / 2 - alertWidth / 2).show();

    this.resetaCoresDoMapa(true);
};

/**
 * Carrega legendas do banco de dados.
 * 
 * @private
 * @param {object} urlParams
 * @param {boolean=} centralizaMapa
 * @return {undefined}
 */
GMaps.prototype._carregaValores = function(urlParams, centralizaMapa) {
    var self = this, 
            url = this.getBaseUrl();

    urlParams['tipo'] = 'valores';

    $.ajax({
        type        : 'get',
        dataType    : 'json',
        cache       : false,
        url         : url + 'system/modules/map/controller/MapService.php',
        data        : urlParams,
        error       : function(err) {
            if (self._debug) {
                console && console.log(err);
            }
            self.fechaAvisoCarregando();
        },
        beforeSend: function() {
           self.escondeLegenda();
        },
        success     : function(response) {
            if (response['sucesso'] && 
                    response['retorno']['__valores__'].length > 0) {
                self._atualizaValores(response); 
                
                if (!centralizaMapa) {
                    self.destacaMapa();
                }              
                
                self._carregaLegenda(urlParams['indicador'], urlParams['espacialidade']);
            } else {
                self.resetaCoresDoMapa(true);
                self.escondeLegenda();
                self.fechaAvisoCarregando();
            }
        }
    });
};

/**
 * Carrega legendas do banco de dados.
 * 
 * @private
 * @param {number|string} indicador
 * @param {number|string} espacialidade
 */
GMaps.prototype._carregaLegenda = function(indicador, espacialidade) {
    var self = this, url = this.getBaseUrl();
    
    // indicadores de IDHM - sempre pelo banco
    var id_idhm = [196, 197, 198, 199]; 

    $('#legenda_itens li').remove();

    this._tipoLegenda = this.TIPO_LEGENDA_PADRAO;
    
    var doQuantil = function () {
        // seta quintil como padrão
        self.resetFaixasLegenda();
        
        try {
            var quantilFaixas = self.quantil(5);
            
            // set faixas legenda
            self._faixasLegenda         = quantilFaixas;
            self._faixasLegendaPadrao   = quantilFaixas;

            // re-colore contornos
            self.atualizaCorMapa(self._faixasLegendaPadrao);
            self.setFaixasLegenda(self._faixasLegendaPadrao);

            // setar aba padrão após mudança indicadores
            self.setAbaLegendaPadrao();

        } catch (err) {
            console.log('Erro ao gerar quantil: ' + err);
            self.escondeLegenda();
        }
    };
    

    var esp = +this.getEspacialidade();
    if ((esp === ESP_CONSTANTES.udh || esp === ESP_CONSTANTES.regional)
            && $.inArray(+this.getIndicador(), id_idhm) === -1) {
        doQuantil();
        
        this.fechaAvisoCarregando();
    } else {
        $.ajax({
            type        : 'get',
            dataType    : 'json',
            cache       : false,
            url         : url + 'system/modules/map/controller/MapService.php',
            data        : {tipo: 'legenda', indicador: indicador, espacialidade: espacialidade},
            error       : function(err) {
                self.mostraLegenda();

                if (self._debug) {
                    console && console.log(err);
                }
            },
            complete    : function() {
                self.mostraLegenda();
            },
            success     : function(response) {
                self.setAbaLegendaPadrao();

                if (response['sucesso'] && response['retorno']['__legenda__'].length > 0) {
                    self._adicionaLegenda(response['retorno']);
                    self._adicionaFaixaLegendaSemValor();
                } else {
                    doQuantil();
                    self._adicionaFaixaLegendaSemValor();
                }

                self.fechaAvisoCarregando();
            }
        });
        
    }

};

/**
 * Seta aba legenda padrão.
 *
 */
GMaps.prototype.setAbaLegendaPadrao = function() {
    $('#legenda-tabs .ativo')
        .removeClass('ativo')
        .parent()
        .find('#tab-legenda-padrao')
        .addClass('ativo');
    
    $('#legenda-quantil, #legenda-personalizada').hide();
    $('#legenda_mapa').show();
};

/**
 * Cria faixa texto legenda.
 * 
 * @param {number} max
 * @param {number} min
 * @returns {string}
 */
GMaps.prototype.criaFaixaLegenda = function(max, min) {
    return formataValor(min + ' - ' + max, true);
};

/**
 * Elimina faixas duplicadas para legenda.
 * 
 * @static
 * @param {type} arrayFaixasLegenda
 * @returns {undefined}
 */
GMaps.uniqueFaixasLegenda = function(arrayFaixasLegenda) {
    var resultFaixas = [], atual, existe;
    
    for (var i = 0; i < arrayFaixasLegenda.length; i++) {
        atual = arrayFaixasLegenda[i];
        existe = false;
        
        for (var j = 0; j < resultFaixas.length; j++) {
            if (atual.nome === resultFaixas[j].nome) {
                existe = true;
            }
        }
        
        if (!existe) {
            resultFaixas.push(atual);
        }
    } 
    return resultFaixas;
};

/**
 * Quantil. 
 *
 * @param {number} num
 * @return {Object} Quantil
 */
GMaps.prototype.quantil = function(num) {
    var cor, min, max, nome, valorBrilho, qntBrilho;
    
    var restoNumBin, ultimoIdx, idx, idx2, incFaixas;
    var numBin, 
        valoresOrd      = this._valores2.slice(0), // valores ordenados - clone
        numValores      = this._valores2.length,
        idxValores      = [],
        arrayQuantil    = [];

    if (numValores === 0) {
        throw Error('Valores insuficientes para quantil.');
    }
    
    valoresOrd.sort(function(a, b) {
        return parseFloat(a[1]) - parseFloat(b[1]);
    });

    idx         = 0;
    idx2        = 0;
    
    incFaixas   = (numValores / num);
    numBin      = (Math.floor(incFaixas) - 1);
    
    restoNumBin = (numValores % num);
    
    for (var i = 0; i < num; i++) {
        if ((numBin + idx) > numValores) {
            ultimoIdx =  numValores - 1;
        } else { 
            // adiciona resto
            if (numBin > -1 && restoNumBin > 0) {
                ultimoIdx = numBin + idx + 1;
            } else if (numBin > -1 && restoNumBin <= 0) {
                ultimoIdx = numBin + idx;
            } else {
                ultimoIdx = idx;
            }
        }
        
        idxValores.push({
            min: valoresOrd[idx][1],
            max: valoresOrd[ultimoIdx][1]
        });
        
        
        if (numBin === -1) {
            idx2 += incFaixas;
            idx  = Math.floor(idx2);
        } else {
            // se o número da população for maior que 1 por faixa
            if (restoNumBin > 0) {
                idx += numBin + 2;
            } else {
                idx += numBin + 1;
            }
        }

        restoNumBin--;
        
    } // for
    
    // reverse
    idxValores.sort(function(a, b) {
       return parseFloat(b.min) - parseFloat(a.min); 
    });

    // gradiente cores
    qntBrilho   = 1 / num;
    valorBrilho = 0;


    // cria Legenda quantil
    cor = this._corQuantil;
    
    for (var i = 0; i < num; i++) {
        min = parseFloat(idxValores[i].min);
        max = parseFloat(idxValores[i].max);
        
        min = (min % 1) === 0 ? min : min.toFixed(3);
        max = (max % 1) === 0 ? max : max.toFixed(3);

        nome = this.criaFaixaLegenda(max, min);
        arrayQuantil.push({
            cor_preenchimento   : increase_brightness(cor, 100 * valorBrilho),
            nome                : nome,
            max                 : max,
            min                 : min
        });

        valorBrilho += qntBrilho;
    }
    
    return GMaps.uniqueFaixasLegenda(arrayQuantil);
};

/**
 * Adiciona legenda a prtir dos itens fornecidos.
 * 
 * @private
 * @param {JSON} faixas JSON referente aos indicadores.
 */
GMaps.prototype._adicionaLegenda = function(faixas) {
    var self = this, faixasSelecionadas;
    
    this.resetFaixasLegenda();

    $(faixas['__legenda__']).each(function(i, item) {
        // atualiza legenda
        self._faixasLegenda.push({
            'cor_preenchimento' : item.cor_preenchimento,
            'nome'              : item.nome,
            'max'               : item.max,
            'min'               : item.min
        });


        self._faixasLegendaPadrao.push({
            'cor_preenchimento' : item.cor_preenchimento,
            'nome'              : item.nome,
            'max'               : item.max,
            'min'               : item.min
        });
    });

    faixasSelecionadas = this._getFaixasAtual();

    this.atualizaCorMapa(faixasSelecionadas);

    this.setFaixasLegenda(faixasSelecionadas);
};


/**
 * Desenha faixas da legenda.
 * 
 * @param {Object=} faixas
 */
GMaps.prototype.setFaixasLegenda = function(faixas) {
    var self = this;
    $(faixas).each(function(i, item) {
        self.adicionaFaixa(item.cor_preenchimento, item.nome);
    });

    this.atualizaTranspareciaLegenda();
};


/**
* Retorna as faixas atuais utilizadas pelo mapa.
*
* @private
* @returns {Object|Array|undefined}
*/
GMaps.prototype._getFaixasAtual = function () {
    if (this._tipoLegenda === this.TIPO_LEGENDA_PADRAO) {
        return this._faixasLegendaPadrao;
    } else if (this._tipoLegenda === this.TIPO_LEGENDA_QUANTIL) {
        return this._faixasLegendaQuantil;
    } else {
        return this._faixasLegenda;
    }
};

/**
 * Adiciona faixa para legenda.
 * 
 * @param {string} cor
 * @param {string} nome
 */
GMaps.prototype.adicionaFaixa = function(cor, nome) {
    $('#legenda_itens').append('<li><span class="legenda_indicador" style="border-color: ' + cor + ';" ></span> ' + nome + '</li>');
};

/**
 * Retorna o tipo de legenda.
 * 
 * @see GMaps._tipoLegenda
 * @param {Object} faixasLegenda
 * @param {number} tipoLegenda 
 */
GMaps.prototype.atualizaLegenda = function (faixasLegenda, tipoLegenda) {
    if (tipoLegenda === this.TIPO_LEGENDA_PADRAO) {
        this._faixasLegendaPadrao = faixasLegenda;
    } else if (tipoLegenda === this.TIPO_LEGENDA_QUANTIL) {
        this._faixasLegendaQuantil = faixasLegenda;
    } else if (tipoLegenda === this.TIPO_LEGENDA_PERSONALIZADA) {
        this._faixasLegenda = faixasLegenda;
    }
    
    this._tipoLegenda = tipoLegenda;
    this._desenhaFaixasLegenda(tipoLegenda);
};

/**
 * Adiciona faixas legenda.
 * 
 * @private
 * @param {number} tipoFaixas
 */
GMaps.prototype._desenhaFaixasLegenda = function(tipoFaixas) {
    var faixas;
    $('#legenda_itens li').remove();
    faixas = this.getFaixasLegenda(tipoFaixas);
    this.setFaixasLegenda(faixas);
};

/**
 * Esconde o legenda.
 */
GMaps.prototype.escondeLegenda = function() {
    $('#legenda_mapa').hide();
};

/**
 * Mostra o legenda.
 * 
 */
GMaps.prototype.mostraLegenda = function() {
    $('#legenda_mapa,#legenda').show();
};

/**
 * Adiciona faixa legenda sem valor.
 * 
 * @returns {undefined}
 */
GMaps.prototype._adicionaFaixaLegendaSemValor = function() {
    var cor = this._corSemValor;
    $('#legenda_itens').append('<li><span class="legenda_indicador" style="border-color: ' + cor  + ';"></span>' + lang_mng.getString('mp_aviso_sem_valor') + '</li>');
    
};

/**
 * Retorna cor do contorno a partir do 
 * 
 * @param {Object} novasFaixas
 */
GMaps.prototype.setLegendaPersonalizada = function(novasFaixas) {
    var faixasLegenda = novasFaixas || this._faixasLegenda;
    
    this.atualizaLegenda(faixasLegenda, this.TIPO_LEGENDA_PERSONALIZADA);
    this.atualizaCorMapa(faixasLegenda);
    this._adicionaFaixaLegendaSemValor();
};

/**
 * Legenda Quantil.
 * 
 * @param {Object} quantil
 */
GMaps.prototype.setLegendaQuantil = function(quantil) {
    this._faixasLegendaQuantil = quantil;
    this.atualizaQuantilMapa();
//    this._adicionaFaixaLegendaSemValor();
    this.atualizaTranspareciaLegenda();
};

/**
 * Verifica se quantil já foi gerado.
 * 
 * @returns {boolean}
 */
GMaps.prototype.existeQuantil = function() {
    return $.isArray(this._faixasLegendaQuantil) && this._faixasLegendaQuantil.length === 0;
};

/**
 * Verifica se legenda personalizada foi gerado.
 * 
 * @returns {boolean}
 */
GMaps.prototype.isLegendaPersonalizada = function () {
    return isEqualArray(this._faixasLegendaPadrao, this._faixasLegenda);
};

/**
 * Reset faixas da legenda personalizada.
 */
GMaps.prototype.resetLegendaPersonalizada = function () {
    this._faixasLegenda = this._faixasLegendaPadrao;
};

/**
 * Aplica o quantil no mapa.
 * 
 */
GMaps.prototype.atualizaQuantilMapa = function() {
    this.atualizaLegenda(this._faixasLegendaQuantil, this.TIPO_LEGENDA_QUANTIL);
    this._adicionaFaixaLegendaSemValor();
    this.atualizaCorMapa(this._faixasLegendaQuantil);
};

/**
 * Legenda padrão.
 * 
 */
GMaps.prototype.setLegendaPadrao = function() {
    this.atualizaLegenda(this._faixasLegendaPadrao, this.TIPO_LEGENDA_PADRAO);
    this._adicionaFaixaLegendaSemValor();
    this.atualizaCorMapa();
};


/**
 * Retorna cor do contorno a partir da cor preenchimento.
 * 
 * @private
 * @param {string} corPreenchimento
 * @returns {string}
 */
GMaps.prototype._getCorContorno = function(corPreenchimento) {
    return ColorLuminance(corPreenchimento, -0.25);
};


/**
 * Atualiza cores dos contornos.
 * 
 * @param {object=} coresFaixasLegenda
 */
GMaps.prototype.atualizaCorMapa = function(coresFaixasLegenda) {
    var self = this; 
    var valorAtual, contornoAtual, faixaAtual, corSelecaoAtual, larguraSelecaoAtual;
    var emAlgumaFaixaLegenda, 
            isContornoSelecionado, 
            cor, 
            faixas, 
            numFaixasLegenda, 
            mapaCores;
    
    faixas              = coresFaixasLegenda || this._faixasLegendaPadrao;
    numFaixasLegenda    = faixas.length;
    
    mapaCores           = {};

    corSelecaoAtual     = this._corSelecaoContorno;
    larguraSelecaoAtual = this._larguraSelecaoContorno;

    for (var k = 0; k < numFaixasLegenda; k++) {
        
        if (this._possuiContorno) {
            cor = this._getCorContorno(faixas[k]['cor_preenchimento']); 
        } else {
            cor = faixas[k]['cor_preenchimento']; 
        }

        mapaCores[faixas[k]['cor_preenchimento']] = cor;
    }

    for (var pos = 0, length = self._contornos.length; pos < length; pos++) {
        valorAtual    = self._valores[pos];
        contornoAtual = self._contornos[pos];
        
        emAlgumaFaixaLegenda = false;

        isContornoSelecionado = (contornoAtual.strokeWeight === this._larguraSelecaoContorno);
        
        for (var i = numFaixasLegenda - 1; i >= 0; i--) {
            faixaAtual = faixas[i];

            if ((valorAtual !== null) && 
                    (+valorAtual >= +faixaAtual['min'] && +valorAtual <= +faixaAtual['max'])) {
                
                if (isContornoSelecionado) {
                    self._ultimaCorLinha = mapaCores[faixaAtual['cor_preenchimento']];
                    contornoAtual.setOptions({
                        fillColor   : faixaAtual['cor_preenchimento']
                    });
                } else {
                    contornoAtual.setOptions({
                        fillColor   : faixaAtual['cor_preenchimento'],
                        strokeColor : mapaCores[faixaAtual['cor_preenchimento']]
                    });
                }

                emAlgumaFaixaLegenda = true;
            }
        } // fim for


        if (valorAtual !== null && !emAlgumaFaixaLegenda) {

            this._ultimaCorLinha = this._corLinhaPadrao;

            if (isContornoSelecionado) {
                contornoAtual.setOptions({strokeColor: corSelecaoAtual});
            } else {
                contornoAtual.setOptions({strokeColor: self._ultimaCorLinha});
            }

            contornoAtual.setOptions({fillColor: self._corPreenchimentoPadrao});
        }
        
        // fora legenda mapa
        if (!valorAtual) {
            if (isContornoSelecionado) {
                var corSemValorLinha = self._getCorContorno(self._corSemValor);

                self._ultimaCorLinha = corSemValorLinha;

                contornoAtual.setOptions({
                    fillColor   : self._corSemValor
                });
            } else {
                contornoAtual.setOptions({
                    fillColor   : self._corSemValor,
                    strokeColor : corSemValorLinha
                });
            }
        }
    }
};

/**
 * Reseta cores do mapa.
 * 
 */
GMaps.prototype.resetaCoresDoMapa = function(coresPadrao) {
    var self = this, cor, corLinha;
    
    this._valores  = [];
    this._valores2 = [];
    
    // verifica se cores padrão para reset cores mapa
    if (!coresPadrao) {
        cor = this._corPreenchimentoPadrao;
        corLinha = this._corLinhaPadrao;
        
        $('.info_valor').parent().html('&nbsp;');
    } else {
        cor = this._corSemValor;
        corLinha = this._getCorContorno(this._corSemValor);
        
        $('.info_valor').parent().html(lang_mng.getString('mp_aviso_sem_valor'));
    }
    
    $(self._contornos).each(function(i, item) {
        if (item.strokeWeight === self._larguraSelecaoContorno) {
            self._ultimaCorLinha = corLinha;
            item.setOptions({
                fillColor   : cor
            });
        } else {
            item.setOptions({
                fillColor   : cor,
                strokeColor : corLinha
            });
        }
    });
};


/**
 * Cria uma camada.
 * 
 * @param paths
 * @param corDePreenchimento
 * @param corDaBorda
 * @param larguraLinha
 * @param opacidade
 */
GMaps.prototype.criaContorno = function(
    paths, 
    corDePreenchimento, 
    corDaBorda, 
    larguraLinha, 
    opacidade) {
    var transparencia = this.getTransparencia();

    return new google.maps.Polygon({
        paths           : paths,
        geodesic        : true,
        fillColor       : corDePreenchimento,
        strokeColor     : corDaBorda,
        strokeWeight    : larguraLinha,
        fillOpacity     : opacidade || transparencia
    });
};

/**
 * Retorna o ID do mapa.
 * 
 * @returns {Object}
 */
GMaps.prototype.getId = function() {
    return $('#map-canvas').data('id');
};

/**
 * Método setar variavél global ID.
 * 
 * @param {number} id
 * @param {boolean=} atualizaUltimo
 */
GMaps.prototype.setId = function(id, atualizaUltimo) {
    if (!atualizaUltimo) {
        this._ultimoId = this.getId();
    }
    $('#map-canvas').data('id', id);
};

/**
 * Método helper para obter variavél global.
 */
GMaps.prototype.getContornoDoMarcador = function() {
    return $('#map-canvas').data('contorno');
};

/**
 * Remove todos os infowindows dos marcadores.
 */
GMaps.prototype.limpaInfoMarcadores = function() {
    var self = this;

    if (self._infoMarcador) {
        self._infoMarcador.close();
        self._infoMarcador = null;
    }

    $.each(self._infoMarcadores, function() {
        this.close();
    });
};

/**
 * Muda o tipo de visualização do mapa.
 * 
 * @param {string}
 *            tipo Tipos: MapTypeId.ROADMAP, MapTypeId.SATELLITE,
 *            MapTypeId.HYBRID e MapTypeId.TERRAIN.
 */
GMaps.prototype.setTipoDoMapa = function(tipo) {
    this._tipoDoMapa = tipo;
    this.getMapa().setMapTypeId(this._tipoDoMapa);
};


/**
 * Muda o tipo de visualização do mapa. 
 * Tipos: MapTypeId.ROADMAP, MapTypeId.SATELLITE, MapTypeId.HYBRID e MapTypeId.TERRAIN.
 * 
 * @param {number} id 
 */
GMaps.prototype.setTipoDoMapaId = function(id) {
    this._tipoDoMapa = [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.SATELLITE,
        google.maps.MapTypeId.HYBRID][id];

    this.getMapa().setMapTypeId(this._tipoDoMapa);
};


/**
 * Retorna op;óes o tipo de visualização do mapa.
 * 
 * @return {array}
 */
GMaps.prototype.getMarcadores = function() {
    return this._marcadores;
};

/**
 * Apaga todos contornos, limpando o mapa.
 */
GMaps.prototype.limpaContornos = function() {
    var contornos = this._contornos;
    $.each(contornos || {}, function(i, item) {
        if (typeof item !== 'undefined') { 
            item.setPaths([]);
        }
    });
};

/**
 * Muda linha.
 * 
 * @param {google.maps.Polygon} coords
 */
GMaps.prototype.mudaLinhaDoContorno = function(coords) { //, corLinha, larguraLinha) {
    var self = this;
    if (typeof coords !== 'undefined' 
        && coords instanceof google.maps.Polygon) {
        coords.setOptions({
            strokeColor     : self._ultimaCorLinha,
            strokeWeight    : self._ultimaLarguraLinha,
            strokeOpacity   : self.getTransparencia(),
            zIndex          : 9998
        });
    }
};

/**
 * Formata info valor.
 * 
 * @private
 * @param {string|number} valor
 * @returns {string}
 */
GMaps.prototype._formataInfoValor = function(valor) {
    return lang_mng.getString('mp_valor_indicador') + ' : <span class="info_valor" style="color:#999;">' + ("" + valor).replace(/\./, ',') + "</span>";
};

/**
 * Formata info valor do window google maps.
 * 
 * @param {number|string} valor
 * @returns {string}
 */
GMaps.prototype._infoValor = function (valor) {
    if (valor) {
        return this._formataInfoValor(valor);
    } else {
//        return '&nbsp;';
        return (!this.getIndicador()) ? '&nbsp;' : lang_mng.getString('mp_aviso_sem_valor');
    }
};

/**
 * Formata mensagem da infowindow.
 * 
 * @link https://developers.google.com/maps/documentation/javascript/reference?hl=pt-br#InfoWindow
 * @private
 * @param {string} nomeEspacialidade Localidade.
 * @param {string} valor Valor do indicador.
 * @param {string} url Link para o perfil da localidade.
 * @param {string|number} id
 */
GMaps.prototype._msgInfo = function(nomeEspacialidade, valor, url, id) {
    var link, href, infoValor, isPais;
    
    // verifica contexto ou espacialidade Brasil
    isPais = (+this.getContexto() === ESP_CONSTANTES['pais'] && +this.getEspacialidade() === ESP_CONSTANTES['pais']);
    
    if (!url || isPais) {
        link = '';

        infoValor = this._infoValor(valor);
        infoValor = '<div class="info_marcador_valor-' + id + '" style="margin-top:3px;">' + infoValor + '</div>';
    } else {
        infoValor = this._infoValor(valor);
        infoValor = '<div class="info_marcador_valor-' + id + '" style="margin-top:3px;">' + infoValor + '</div>';

        // link para perfil
        href = url.toLowerCase();
        link = '<div style="margin-top:3px;"><a href=' + href + ' target="_blank" style="outline:none">' + lang_mng.getString('mp_link_perfil') + '</a></div>';
    }

    return '<div class="mapa_infowindow" style="font-weight: bold;min-width:175px;">' + nomeEspacialidade + '</div>' + infoValor;
};

/**
 * Adiciona prefixo RM traduzido.
 * 
 * @private
 * @param {string} nomeEspacialidade
 * @returns {string}
 */
GMaps.prototype._trataPrefixoRm = function(nomeEspacialidade) {
    var prefixo, er = /^(\d) -/g;
    
    prefixo = nomeEspacialidade.match(er);
    
//    if ($.isArray(prefixo) && +prefixo[1] === 2) {
    if ($.isArray(prefixo) && parseInt(prefixo[0], 10) === 2) {
        prefixo = lang_mng.getString('mp_prefixo_ride');
    } else {
        prefixo = lang_mng.getString('mp_prefixo_rm');
    }
    
    return prefixo + ' ' +nomeEspacialidade.slice(4);
};

/**
 * Formata informação para mudança do indicador de busca.
 * 
 * @link https://developers.google.com/maps/documentation/javascript/reference?hl=pt-br#InfoWindow
 * @private
 * @param {string} nomeEspacialidade Id da espacialidade.
 * @param {number} id Id do elemento da aplicação.
 * @param {number} pos Valor do indicador.
 * @return {string} Url do info no mapa.
 */
GMaps.prototype._formataInfo = function(nomeEspacialidade, id, pos) {
    var url, splitUrl, espacialidade, lang, lastIndex, valor;

    espacialidade = this.getEspacialidade();

    if ((typeof pos === 'number' && pos % 1 === 0) && (pos > -1)) {
        valor = this._valores[pos];
    } else {
        valor = '';
    }

    if (!this._mapaTipoUrl[espacialidade] 
            && +espacialidade !== ESP_CONSTANTES.regiaodeinteresse) {
        return this._msgInfo(nomeEspacialidade, valor, '', id);
    } else {
        // para região interesse retornar municipios
        if (+espacialidade === ESP_CONSTANTES.regiaodeinteresse) {
            espacialidade = ESP_CONSTANTES.municipal;
        }
        
        // http://www.nczonline.net/blog/2013/04/16/getting-the-url-of-an-iframes-parent/
        splitUrl = ((parent !== window) ? document.referrer : location.href.replace(/\/$/, '')).split('/');

        lang = ((typeof user_lang === 'undefined' || !user_lang) ? 'pt' : user_lang);
        lang = ((parent === window) ? '/' + lang : '');

        lastIndex = splitUrl.length - (splitUrl.length > 5 ? 2 : 1);

        // link url
        url = splitUrl.splice(0, lastIndex).join('/') + lang + '/perfil_' + this._mapaTipoUrl[espacialidade] + '/' + id;

        return this._msgInfo(nomeEspacialidade, valor, url, id);
    }
};

/**
 * Testa se o path está dentro do polígono, verificando o sentido horário(clockwise) 
 * para desenho normal e antihorário(counter clockwise) para "buracos" dentro do polígono.
 * 
 * @static
 * @link http://en.wikipedia.org/wiki/Curve_orientation
 * @param {google.maps.Polygon.Path} path
 * @returns {boolean}
 */
GMaps._isCCW = function(path) {
    var isCCW, a = 0;

    for (var i = 0, len = path.length - 2; i < len; i++) {
        a += ((path[i + 1].lat() - path[i].lat()) * (path[i + 2].lng() - path[i].lng()) - (path[i + 2].lat() - path[i].lat()) * (path[i + 1].lng() - path[i].lng()));
    }

    if (a > 0) {
        isCCW = true;
    } else {
        isCCW = false;
    }

    return isCCW;
};

/**
 * Gerência os contornos os espacialidades.
 * 
 * @static
 * @param {number} index
 * @param {array} arrLatLng
 * @param {array.<array.<google.maps.LatLng>>} arrLatLngs
 */
GMaps.getDirecaoContorno = function(index, arrLatLng, arrLatLngs) {
    var exteriorDirection, interiorDirection;

    if (!index) {
        exteriorDirection = GMaps._isCCW(arrLatLng);
        arrLatLngs.push(arrLatLng);
    } else if (index === 1) {
        interiorDirection = GMaps._isCCW(arrLatLng);
        if (exteriorDirection === interiorDirection) {
            arrLatLngs.push(arrLatLng.reverse());
        } else {
            arrLatLngs.push(arrLatLng);
        }
    } else {
        if (exteriorDirection === interiorDirection) {
            arrLatLngs.push(arrLatLng.reverse());
        } else {
            arrLatLngs.push(arrLatLng);
        }
    }
};

/**
 * Manipulador de desenho Ajax do serviço do mapa.
 * 
 * @param {Object} response JSON resposta da requisição AJAX.
 * @return {undefined}
 */
GMaps.prototype.desenhaContorno = function(response) {
    var self            = this, 
            index       = 0,
            contorno    = [],
            retorno     = response && response['retorno'],
            arrContorno, coords, arrLatLng, arrLatLngs;
    
    arrContorno = retorno['__contornos__'];
    
    self.setMaxZoom(retorno['__maxzoom__']);

    $(arrContorno).each(function(i) {
        // contorno atual
        contorno[i] = [];
        coords      = GMaps.converteGeoJsonParaArray(arrContorno[i]);
        
        for (var j = 0, len = coords.length; j < len; j++) {
            arrLatLngs = [];

            for (var k = 0, len2 = coords[j].length; k < len2; k++) {
                arrLatLng = []; // lista coordenadas

                for (var l = 0, len3 = coords[j][k].length; l < len3; l++) {
                    arrLatLng.push(new google.maps.LatLng(
                            coords[j][k][l][1], 
                            coords[j][k][l][0]
                    ));
                }

                GMaps.getDirecaoContorno(i, arrLatLng, arrLatLngs);
            }              

            // contornos da espacialidade
            contorno[i][j] = self.criaContorno(
                    arrLatLngs,
                    self._corPreenchimentoPadrao,
                    self._corLinhaPadrao,
                    self._larguraLinhaPadrao,
                    self.getTransparencia());

            contorno[i][j].setMap(self.getMapa());

            self._contornos.push(contorno[i][j]);
            self._contornosId.push(arrContorno[i][0]);

            self._adicionaOnclickCamada(
                    contorno[i][j], 
                    arrContorno[i][0], 
                    arrContorno[i][1], 
                    index,
                    arrContorno[i][3]
            );
            
            index += 1;
        }
    });

}; // fim: desenhaContorno

/**
 * Atualiza valores do contorno do mapa.
 * 
 * @private
 * @param {Object} response Json resposta da requisição AJAX.
 * @return {undefined}
 */
GMaps.prototype._atualizaValores = function(response) {
    var id, valor, valores, mapaIdValores, retorno;
    
    mapaIdValores   = {};
    retorno         = (response && response['retorno']);
    
    valores = retorno['__valores__'];
    
    this._valores2 = valores;

    for (var i = 0, lv = valores.length; i < lv; i++) {
        id = valores[i][0];
        mapaIdValores[id] = valores[i][1];
    }

    // recupera último infowindow aberto e atualiza
    if (this._infoWindowAtual) {
        var texto = this._formataInfoValor(mapaIdValores[this._infoWindowAtual]);
        $('.info_marcador_valor-' + this._infoWindowAtual).html(texto);
    }

    for (var k = 0, lc = this._contornosId.length; k < lc; k++) {
        id                  = this._contornosId[k];
        valor               = mapaIdValores[id];
        this._valores[k]    = !!valor && parseFloat(valor).toFixed(3);
    }
    
    this.destacaMapa();
};

/**
 * Destaca mapa.
 */
GMaps.prototype.destacaMapa = function() {
    if (this._contornos.length > 0 && this._unicoContornoId()) {
        var maiorContorno = GMaps.getMaiorContorno(this._contornos);
        this.clicaContorno(maiorContorno);
    }    
};

/**
 * Verifica se mudou a espacialidade, desde a última consulta.
 * 
 * @private
 * @returns {boolean}
 */
GMaps.prototype._isEspacialidadeDaUltimaConsulta = function() {    
    return (this._contornos.length > 0
            && (this._ultimoId === this.getId() || isEqualArray(this._ultimoId, this.getId()))
//            && this._ultimoAno === this.getAno()
            && this._ultimaEspacialidade === this.getEspacialidade()
            && this._ultimoContexto === this.getContexto());
};

/**
 * Limpa mapa com informações anteriores.
 * 
 */
GMaps.prototype.resetMapa = function() {
    var self = this;

    self.limpaContornos();
    self.limpaInfoMarcadores();
   			 
    self.limpaInfoContornos(self._infoWindow);
    self._infoWindow = [];

    $(self._contornos).each(function(i, item) {
        item.setMap(null);
    });

    $(self._contornoAtual).each(function(i, item) {
        item.setMap(null);
    });

    this.resetAtributosDosContonos();
};


/**
 * Função para adicionar evento onclick na camada.
 * 
 * @private
 * @param {array} contorno
 * @param {number} id
 * @param {string} nome
 * @param {number} pos Posição no vetor de valores do mapa.
 * @param {string} cod Link.
 */
GMaps.prototype._adicionaOnclickCamada = function(contorno, id, nome, pos, cod) {
    var self                = this,
            mapa            = this.getMapa(),
            contexto        = this.getContexto(),
            espacialidade   = this.getEspacialidade(),
            infoWindow;


    google.maps.event.addListener(contorno, 'click', function() {
        var posicao;
        self._infoWindowAtual = id;
 
        self.limpaInfoContornos(self._infoWindow);

        // reseta contorno atual        
        if (self._contornoAtual) {
            (function() {
                self.mudaLinhaDoContorno(self._contornoAtual);
                self._contornoAtual.setOptions({zIndex: 0});
            })();
        }

        self._contornoAtual = contorno;

        posicao = getNorthestPoint(contorno);

        // adiciona prefixo RM ao infowindow
        if (contexto === ESP_CONSTANTES.regiaometropolitana 
                && espacialidade === ESP_CONSTANTES.regiaometropolitana) {
            nome = self._trataPrefixoRm(nome);
        }

        // atualiza info window
        infoWindow = self._formataInfo(nome, cod || id, pos);
        self._infoWindow.push(self._criaInfoPersonalizado(mapa, posicao, infoWindow));

        self._ultimaCorLinha        = contorno.strokeColor;
        self._ultimaLarguraLinha    = contorno.strokeWeight;

        // highlight seleção atual
        this.setOptions({
            strokeColor     : self._corSelecaoContorno,
            strokeWeight    : self._larguraSelecaoContorno,
            strokeOpacity   : 1,
            zIndex          : 9999
        });
    });
};


/**
 * Limpa os info dos contornos.
 * 
 * @param {array=} infoContornos Lista de info dos contornos.
 */
GMaps.prototype.limpaInfoContornos = function(infoContornos) {
    $(infoContornos || this._infoWindow).each(function(i, item) {
        if (typeof item !== 'undefined' && (item instanceof google.maps.InfoWindow)) {
            item.close();
        }
    });
};

/**
 * Mapservice URL.
 * 
 * @returns {string}
 */
GMaps.prototype.getUrl = function () {
    return this.getBaseUrl() + 'system/modules/map/controller/MapService.php';
};


/**
 * Verifica se existe somente uma Espacialidade
 * 
 * @private
 * @returns {boolean}
 */
GMaps.prototype._unicoContornoId = function() {
    var mesmoContorno = true;
    
    if (this._contornosId.length === 1) {
        return true;
    }
    
    for (var i = 1, l = this._contornosId.length; i < l; i++) {
        if (this._contornosId[i] !== this._contornosId[0])
            mesmoContorno = false;
    }
    
    return mesmoContorno;
};

/**
 * Cálcula área.
 * 
 * @static
 * @param {google.maps.Polygon} contorno
 * @returns {number}
 */
GMaps.calcArea = function(contorno) {
    if (!(contorno instanceof google.maps.Polygon)) {
        throw Error('Impossível calcular área.');
    }
    
    return google.maps.geometry.spherical.computeArea(contorno.getPath());
};

/**
 * Calcula distância entre dois pontos (Latitude e Longitute).
 * 
 * @param {google.maps.LatLng} coordinates1
 * @param {google.maps.LatLng} coordinates2
 * @returns {number}
 */
GMaps.calcDistancia = function (coordinates1, coordinates2) {
    var rad = function (x) {
        return x * Math.PI / 180;
    };

    // http://stackoverflow.com/questions/1502590/calculate-distance-between-two-points-in-google-maps-v3
    var getDistance = function (p1, p2) {
        var R = 6378137; // Earth’s mean radius in meter
        var dLat = rad(p2.lat() - p1.lat());
        var dLong = rad(p2.lng() - p1.lng());
        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(rad(p1.lat())) * Math.cos(rad(p2.lat())) *
                Math.sin(dLong / 2) * Math.sin(dLong / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var d = R * c;
        return d; // returns the distance in meter
    };

    return getDistance(coordinates1, coordinates2);
};

/**
 * Retorna contorno de maior em área.
 * 
 * @static
 * @param {array} contornos Array de contornos(shapes).
 * @returns {google.maps.Polygon}
 */
GMaps.getMaiorContorno = function(contornos) {
    var maior = contornos[0];
    
    if (contornos.length === 0) {
        throw Error('Impossível encontrar maior contorno.');
    }  
          
    if (contornos.length === 1) {
        return contornos[0];
    }
    
    for (var i = 1, l = contornos.length; i < l; i++) {
        if (GMaps.calcArea(maior) < GMaps.calcArea(contornos[i])) {
            maior = contornos[i];
        }
    }
    
    return maior;
};


/**
 * Retorna um pixel em relação a uma coordenada (latitude e longitude). 
 * 
 * @link http://krasimirtsonev.com/blog/article/google-maps-api-v3-convert-latlng-object-to-actual-pixels-point-object
 * @param {number} lat
 * @param {number} lng
 * @returns {google.maps.Point}
 */
GMaps.prototype.getPointFromLatLng = function (lat, lng) {
    var latLng = new google.maps.LatLng(lat, lng);
    var map = this.getMapa();

    var topRight = map.getProjection().fromLatLngToPoint(map.getBounds().getNorthEast());
    var bottomLeft = map.getProjection().fromLatLngToPoint(map.getBounds().getSouthWest());

    var scale = Math.pow(2, map.getZoom());

    var worldPoint = map.getProjection().fromLatLngToPoint(latLng);

    return new google.maps.Point((worldPoint.x - bottomLeft.x) * scale, (worldPoint.y - topRight.y) * scale);
};


/**
 * Centróide.
 * 
 * @static
 * @param {google.maps.Polygon} contorno
 * @returns {google.maps.LatLng}
 */
GMaps.getCentroide = function (contorno) {    
    var centerPoint = contorno.my_getBounds().getCenter(),
        inside = google.maps.geometry.poly.containsLocation;
    
    if (inside(centerPoint, contorno)) {
        return centerPoint;
    } else {
        var vertices = contorno.getPath().getArray();
        var closestDistance = Infinity;
        var closestVertex;
        var dist;
        
        for (var i = 0; i < vertices.length; i++) {
            dist = GMaps.calcDistancia(centerPoint, vertices[i]);
            if (dist < closestDistance) {
                closestDistance = dist;
                closestVertex = vertices[i];
            }
        }
        
        return closestVertex;
    }
};

var getNorthestPoint = function (contorno, avoidEdge) {
    var xCand = 0.0;
    var yCand = 0.0;
    var xNorth = 0.0;
    var yNorth = 0.0;
    var vertices = contorno.getPath();
    
    // For all vertices, find the northest 
    for (var i = 1; i < vertices.length; ++i) {
        yCand = vertices.getAt(i).lat();
        xCand = vertices.getAt(i).lng();
        if (yNorth === 0.0) {
            yNorth = yCand;
            xNorth = xCand;
        }
        if (yCand > yNorth) {
            yNorth = yCand;
            xNorth = xCand;
        }
    }
    
    if (avoidEdge) { 
        //TODO
    }
    
    return new google.maps.LatLng(yNorth, xNorth);
};

/**
 * Muda o indicador se a espacialidade for composta. 
 * Ex.: RMs, UDHs e municipios.
 * 
 * @param {number} id 
 * @param {number} espacialidade
 * @param {number} indicador
 * @param {number} ano
 * @param {number} contexto
 */
GMaps.prototype.simpleMapQuery = function(id, espacialidade, indicador, ano, contexto) {
    var self = this, params, url,
            mesmaEspacialidade = this._isEspacialidadeDaUltimaConsulta();
    
    // checks if the ajax response is valid
    var _validResponse = function (response) {
        return (response && typeof response === 'object') &&  (!('retorno' in response) || !response['retorno']);
    };
    
    // mapservice
    url = this.getUrl();

    params = {
        tipo            : 'mapa',
        id              : id,
        espacialidade   : espacialidade,
        ano             : ano,
        indicador       : indicador || '',
        contexto        : contexto
    };

    // remove aviso de UDH de 1991
    $('#aviso_1991').hide();
    
    this.setId(id);
    this.setContexto(contexto);
    this.setEspacialidade(espacialidade);
    this.setAno(ano);
    this.setIndicador(indicador);

    if (mesmaEspacialidade) {
        if (indicador) {
            this.mostraAvisoCarregando();
            this._carregaValores(params);
            // this.destacaMapa();
        } else {
            this.fechaAvisoCarregando();
        }
    } else {
        this.resetMapa();

        $.ajax({
            type        : 'get',
            dataType    : 'json',
            data        : params,
            cache       : false,
            url         : url,
            error       : function(err) {
                if (self._debug) {
                    console && console.log(err);
                }
                
                self.fechaAvisoCarregando();
            },
            success     : function(response) {
                if (_validResponse(response)) {
                    self.fechaAvisoCarregando();
                } else {
                    self.desenhaContorno(response);

                    if (indicador) {
                        self._carregaValores(params);
                        // self.destacaMapa();
                    }
                }
            },
            complete    : function() {
                if (!indicador) {
                    self.fechaAvisoCarregando();
                }
            },
            beforeSend  : function() {
                self.mostraAvisoCarregando();
            }
        });
    }
};

/**
 * MapQuery.
 * 
 * @param {Object} arrIdEspacialidade Ver protocolo de comunicação. 
 * @param {number} contexto
 * @param {number} espacialidade
 * @param {number} indicador
 * @param {number} ano
 * @param {boolean=} somenteValores Atualiza somente valores.
 */
GMaps.prototype.mapQuery = function(arrIdEspacialidade, contexto, espacialidade, indicador, ano, somenteValores) {
    var self = this, params, url;
    
    params = $.extend({
        tipo            : 'mapa',
        contexto	: contexto,
        espacialidade	: espacialidade,
        indicador	: indicador,
        ano		: ano
    }, arrIdEspacialidade);
        
    // seta variáveis do mapa
    this.setContexto(contexto);
    this.setEspacialidade(espacialidade);
    this.setIndicador(indicador);
    this.setId(arrIdEspacialidade['id']);
    this.setAno(ano);

    url = this.getUrl();
    
    if (somenteValores) {
        if (indicador) {
            this.mostraAvisoCarregando();
            this._carregaValores(params, true);
        } else {
            this.fechaAvisoCarregando();
        }
    } else {

        $.ajax({
            type        : 'get',
            dataType    : 'json',
            data        : $.param(params),
            cache       : false,
            url         : url,
            error       : function(err) {
                if (self._debug) {
                    console && console.log(err);
                }
                self.fechaAvisoCarregando();
            },
            success     : function(response) {
                self.desenhaContorno(response);
                self._carregaValores(params);
                // self.destacaMapa();
            },
            complete    : function() {
                self.melhorZoom();
                self.atualizaMapa();
            },
            beforeSend  : function() {
                self.resetMapa();
                self.mostraAvisoCarregando();
            }
        });
    }

};

/**
 * Simula clique contorno.
 * 
 * @param {google.maps.Polygon} contorno
 */
GMaps.prototype.clicaContorno = function (contorno) {
    google.maps.event.trigger(contorno, 'click', {
        latLng: new google.maps.LatLng(0, 0)
    });
};

/**
 * Retorna espacialidade.
 * 
 * @return {number} Id da espacialidade.
 */
GMaps.prototype.getEspacialidade = function() {
    var ret = $('#map-canvas').data('espacialidade');
    return ret && +ret;
};

/**
 * Registra espacialidade.
 * 
 * @param {number|string} idEspacialidade
 * @param {boolean=} atualizaUltimo
 */
GMaps.prototype.setEspacialidade = function(idEspacialidade, atualizaUltimo) {
    if (!atualizaUltimo) {
        this._ultimaEspacialidade = this.getEspacialidade();
    }
    $('#map-canvas').data('espacialidade', idEspacialidade);
};

/**
 * Retorna indicador.
 * 
 * @return {number} Id da indicador.
 */
GMaps.prototype.getIndicador = function() {
    var ret = $('#map-canvas').data('indicador');
    return ret && +ret;
};

/**
 * Registra indicador.
 *            
 * @param {number|string} idIndicador 
 * @param {boolean=} atualizaUltimo
 */
GMaps.prototype.setIndicador = function(idIndicador, atualizaUltimo) {
    if (!atualizaUltimo) {
        this._ultimoIndicador = this.getIndicador();
    }
    $('#map-canvas').data('indicador', idIndicador);
};

/**
 * Retorna URL para AJAX.
 * 
 * @return {string} 
 */
GMaps.prototype.getBaseUrl = function() { // get
    return $('#map-canvas').data('url') || '';
};

/**
 * Registra URL para AJAX.
 * 
 * @param {string} url Url base.
 */
GMaps.prototype.setBaseUrl = function(url) {
    $('#map-canvas').data('url', url);
};

/**
 * Retorna ano.
 * @return {number}
 */
GMaps.prototype.getAno = function() {
    var ret = $('#map-canvas').data('ano');
    return ret && +ret;
};

/**
 * Registra ano.
 * 
 * @param {number|string} idAno
 * @param {boolean=} atualizaUltimo
 */
GMaps.prototype.setAno = function(idAno, atualizaUltimo) {
    if (!atualizaUltimo) {
        this._ultimoAno = this.getAno();
    }
    $('#map-canvas').data('ano', idAno);
};

/**
 * Retorna contexto.
 * 
 * @return {number}
 */
GMaps.prototype.getContexto = function() {
    var ret = $('#map-canvas').data('contexto');
    return ret && +ret;
};

/**
 * Registra contexto.
 * 
 * @param {number|string} idContexto
 * @param {boolean=} atualizaUltimo
 */
GMaps.prototype.setContexto = function(idContexto, atualizaUltimo) {
    if (!atualizaUltimo) {
        this._ultimoContexto = this.getContexto();
    }
    
    $('#map-canvas').data('contexto', idContexto);
};

/**
 * Contornos.
 * 
 * @param {array}
 */
GMaps.prototype.getContornos = function() {
    return this._contornos;
};

/**
 * Contornos ID.
 * 
 * @param {array}
 */
GMaps.prototype.getContornosId = function() {
    return this._contornosId;
};

/**
 * Retorna transparência.
 * 
 * @return {number}
 */
GMaps.prototype.getTransparencia = function() {
    return parseFloat($('#map-canvas').data('transparencia'));
};

/**
 * Registra transparencia.
 * 
 * @param {number} transparencia
 */
GMaps.prototype.setTransparencia = function(transparencia) {
    $('#map-canvas').data('transparencia', transparencia);
};

/**
 * Atualiza transparencia dos itens legenda.
 */
GMaps.prototype.atualizaTranspareciaLegenda = function() {
    // atualiza cores legenda para ficar de acordo mapa
    $('.legenda_indicador').css('opacity', this.getTransparencia());
};

/**
 * Muda transparência dos contornos do mapa.
 * 
 * @param opacidade Valor entre 0.0 e 1.0.
 */
GMaps.prototype.mudaTransparencia = function(opacidade) {
    var self = this, largura = this._larguraSelecaoContorno;

    self.setTransparencia(opacidade);
    
    self.atualizaTranspareciaLegenda();

    if (!self.getIndicador()) {
        $(self._contornos).each(function(i, item) {
            item.setOptions({fillOpacity: opacidade});
        });
    } else {
        $(self._contornos).each(function(i, item) {
            // caso espacialidade selecionada
            if (!self._possuiContorno && item.strokeWeight !== largura) {
                item.setOptions({
                    fillOpacity     : opacidade, 
                    strokeOpacity   : opacidade
                });
            } else {
                item.setOptions({fillOpacity: opacidade});
            }
        });
    }
};

/**
 * Seta valor linha largura padrão.
 * 
 * @param {number} valor
 */
GMaps.prototype.setLarguraLinha = function(valor) {
    this._larguraLinhaPadrao = valor;
};

/**
 * Remove contornos.
 */
GMaps.prototype.removeContornoEspacialidades = function() {
    var self = this, transparencia, item;

    this._possuiContorno = false;
    
    transparencia = self.getTransparencia();

    for (var i = 0, len = this._contornos.length; i < len; i++) {
        item = this._contornos[i];

        if (item.strokeWeight !== this._larguraSelecaoContorno) {
            item.setOptions({
                strokeColor     : item.fillColor, 
                strokeOpacity   : transparencia
            });
        }  else {
            self._ultimaCorLinha = this._getCorContorno(item.fillColor);
        }
    }
};

/**
 * Retorna linhas do contorno.
 * 
 */
GMaps.prototype.addContornoEspacialidades = function() {
    var self = this, corContorno, transparencia, item, cor;

    this._possuiContorno = true;
    
    transparencia = this.getTransparencia();

    for (var i = 0, len = this._contornos.length; i < len; i++) {
        item = this._contornos[i];
        
        corContorno = self._getCorContorno(item.fillColor);

        if (item.strokeWeight !== this._larguraSelecaoContorno) {    
            
            // cor linha
            cor = (item.fillColor !== this._corPreenchimentoPadrao)
                    ? corContorno 
                    : self._corLinhaPadrao;
            
            item.setOptions({strokeColor: cor});
        } else if (item.fillColor === this._corPreenchimentoPadrao) {
            self._ultimaCorLinha = this._corLinhaPadrao;
        } else {
            self._ultimaCorLinha = corContorno;
        }
        
        item.setOptions({strokeOpacity: 1});
    }
};


/**
 * Aviso carregando.
 * 
 */
GMaps.prototype.mostraAvisoCarregando = function() {
    loadingHolder && loadingHolder.show(lang_mng.getString('mp_aviso_carregando') + '...');
};

/**
 * Fecha aviso carregando.
 * 
 * @param {function} fn Evento após carregando.
 */
GMaps.prototype.fechaAvisoCarregando = function(fn) {
    loadingHolder && loadingHolder.dispose(fn);
};
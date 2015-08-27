/*
Ao ordenar alterar somente o body da tabela. *verificar se é possível
*/

var TableComponent = (function($){
	if (typeof jQuery === 'undefined') { throw new Error('Tabela componente requires jQuery'); }

	var defaults = {
	 	instance : false,
	 	renderTo : "#table-container",
	 	dataStepInit : {},
	 	arrayPositionHideColumns : [],
	 	dataAjax : { //Os dados colocados aqui, sempre serão enviados para o ajax
	 		/*entidades : [1,2,3],
	 		indicadores : [1,2,3]*/
	 	},
	 	order : {
	 		url : "url de teste", //TODO por padrão deve ser false
	 		callback : function(element, columnObject, defaults, event, textSearch){
	 			var data = {};
	 			data.colObject = columnObject;
	 			data.dataAjax = defaults.dataAjax;
	 			data.pagination = defaults.pagination;
	 			data.textSearch = textSearch;
	 			$.ajax({
				  url: this.url,
				  type : "POST",
				  data : { "dados": JSON.stringify(data) },
				}).done(function(retorno) {
				  //retorno = $.parseJSON(retorno);
				  var x = new Array();

				  $.extend(true,{},defaults,retorno); //descomentar TODO
				  defaults.data = retorno.data;
				  defaults.configsData.link = retorno.perfil;
				  defaults.configsData.descricao = retorno.descricao;
				  if(defaults.aggregation.has != false){
				  	defaults.data.shift();
				  	defaults.data.unshift(defaults.aggregation.has);
				  }
				  //defaults.columns = retorno.columns;
				  //SE DEFAULTS TIVER A POSIÇÃO 0 É PQ A REQUISIÇÃO DEU ERRADO.
				  if(typeof defaults[0] != "undefined")
				  	alert("Retorno da requisição errado, consulte a api. Retorno: "+retorno+"");
				  else{
				  	create(defaults);
				  }
				  loadingHolder.dispose();
				});
	 		},
	 	}, 
	 	//Passo 2 ordenar os itens na interface mesmo
	 	pagination : {//SETAR SE TERÁ PREVIOUS, NEXT E PENSAR COMO VAI FUNCIONAR QUANTIDADE DE NÚMEROS.
	 		url : "url teste ajax",
	 		pageActive : 100, //página que está mostrando-----|
	 		limit : 20, //itens por página  ---------| Do item 0 ao 9 dos resultados. Se fosse página 2 seria do 10 ao 19 etc
	 		offset : 0,
	 		count : false, // Conversar com o japa pra gente ver como isso será feito. Count é rápido o suficiente?? A resposta é sim :D
	 		callback : function(page, columnObject, defaults){
	 			defaults.pagination.pageActive = page;
	 			defaults.pagination.offset = (page - 1) * this.limit;
	 			var data = {};
	 			data.colObject = columnObject;
	 			data.pagination = defaults.pagination;
	 			data.dataAjax = defaults.dataAjax;

	 			$.ajax({
				  url: this.url,
				  type : "POST",
				  data : { "dados": JSON.stringify(data) }
				}).done(function(retorno) {
                    $.extend(true,{},defaults,retorno); 
                    defaults.data = retorno.data;

                    defaults.configsData.link = retorno.perfil;
                    defaults.configsData.descricao = retorno.descricao;

                    //SE DEFAULTS TIVER A POSIÇÃO 0 É PQ A REQUISIÇÃO DEU ERRADO.
                    if(defaults.aggregation.has != false) {
                        defaults.data.shift();
                        defaults.data.unshift(defaults.aggregation.has);
                    }
                    if(typeof defaults[0] != "undefined") {
                        alert("Retorno da requisição errado, consulte a api. Retorno: "+retorno+"");
                    } else{
                        create(defaults);
                    }
                    loadingHolder.dispose();
				});
	 		}
	 	},
	 	search :{
	 		url : "URL SEARCH",
	 		has : new Array(),
	 		stringSearch : "",
	 		minCharSearchable : 3,
 			callback : function(string, columnObject, defaults, event,element){
	 			this.stringSearch = $(element).val();
	 			var data = {};
	 			data.textSearch = string;
	 			data.dataAjax = defaults.dataAjax;
	 			//ZERANDO PAGINAÇÃO PARA A BUSCA
	 			defaults.pagination.pageActive = 1;
	 			defaults.pagination.offset = 0;
	 			data.pagination = defaults.pagination;
	 			$.ajax({
				  url: this.url,
				  type : "POST",
				  data : { "dados": JSON.stringify(data) }
				}).done(function(retorno) {
				  //VAI ME RETORNAR OS DADOS DO SERVER EM FORMA DE OBJETO 
				  // PARA EXTENDER O JSON
				  //retorno = $.parseJSON(retorno);
				  if(retorno.data != null && retorno.count != 0){
				  	$.extend(true,defaults,retorno); //descomentar TODO
					  //SE DEFAULTS TIVER A POSIÇÃO 0 É PQ A REQUISIÇÃO DEU ERRADO.
					  defaults.data = retorno.data;
					  defaults.columns = retorno.columns;
					  defaults.pagination.count = retorno.count;
					  defaults.configsData.link = retorno.perfil;
                      defaults.configsData.descricao = retorno.descricao;
					  if(typeof defaults[0] != "undefined")
					  	alert("Retorno da requisição errado, consulte a api. Retorno: "+retorno+"");
					  else{
					  	clearOrder(defaults);
					  	create(defaults);
					  }
				  }
				  else{
				  	//mostrar mensagem que não foi encontrado nenhum dado
				  }
				});
	 			//FAZER AJAX E SETAR O DATA, A PÁGINA QUE SE ENCONTRA JÁ VAI TA SETADA
	 			//create(defaults);
	 		},
	 	},
	 	aggregation : {
            url : "system/modules/agregacao/controller/agregacaoController.php",
            has : false,
            callback : function(element, defaults,columnObject, event){
                var data = {};
                data.colObject = columnObject;
                data.dataAjax = defaults.dataAjax;
                data.pagination = defaults.pagination;

                $.ajax({
                    url: this.url,
                    type : "POST",
                    data : { "dados": JSON.stringify(data) },
                    success: function(retorno) {
                        if('data' in retorno){
                            defaults.data.shift();
                            var arrayLinhaAgregacao = new Array();
                            arrayLinhaAgregacao.push(lang_mng.getString("title_agregacao"));

                            $.each(retorno.data,function(i,item){
                                $.each(defaults.columns,function(j,val){
                                    if(item.id == val.id){
                                        arrayLinhaAgregacao.push(item.valor);
                                    }
                                });
                            });
                            defaults.data.unshift(arrayLinhaAgregacao);
                            defaults.aggregation.has = new Array();
                            defaults.aggregation.has = arrayLinhaAgregacao;
                            if(typeof defaults[0] != "undefined") {
                                alert("Retorno da requisição errado, consulte a api. Retorno: "+retorno+"");
                            }
                            else{
                                create(defaults);
                            }
                        }
                    }
                }).done(function(retorno){
                    $("#contentLoading").hide();
                    $("#maskTransparent").hide();
                    $(".modal-backdrop").remove();
                    $("#contentLoading").css("height", "70px");
                    $("#contentLoading .loading-info").remove();
                    if ('erro' in retorno) {
                        AtlasBrasil.messages({
                            display : "modal",
                            renderTo : "#general-modal-2",
                            width : "400px",
                            height : "150px",
                            left : "54%",
                            optionsModal : {
                                backdrop : 'static',
                            },
                            body : retorno.erro,
                            options : {
                                buttons : [
                                    {"class" : "blue_button big_btn", "aria-hidden" : "true","text" : "Ok", "data-dismiss": "modal"}
                                ],
                            },
                        });
                    }
                });
            },
	 	},
	 	configColumns : { //tratar depois para aceitar um array onde será determinado coluna por coluna
	 		firstColumn : "250px",
	 		othersColumns : "118px"
	 	},
	 	configsData: {
            link : [],
            descricao: [],
        },
	 	columns : [//FALTA CALCULAR O WIDTH E COMO VAMOS FAZER COM O FONT-SIZE E A QUEBRA DE LINHA
	 		{"title" : "Espacialidades", "id" : 1},
	 		{"title" : "Índice 1", "id" : 2},
	 		{"title" : "Índice 2", "id" : 3},
	 		{"title" : "Índice 3", "id" : 4},
	 		{"title" : "Índice 4", "id" : 5},
	 		{"title" : "Índice 5", "id" : 6},
	 		{"title" : "Índice 6", "id" : 7},
	 		{"title" : "Índice 7", "id" : 8},
	 	],
	 	data : [
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],
	 		["vish","vish","vish","vish4","vish","vish","vish","vish"],

	 	]
	};

	var getSettings = function(){
		return defaults;
	};

	var setSettings = function(options){
		
		options.pagination.callback = defaults.pagination.callback;
		options.aggregation = defaults.aggregation;
		defaults = $.extend({},defaults,options);
		
		return defaults;
	}

	//Esse método volta a tabela para o estado primário, ou seja, destrói a tabela.
	var destroy = function(defaults){
		$(defaults.renderTo).off("click","#btn-search-tc",search);
		$(defaults.renderTo).off("click",".close-column",closeColumn);
		$("#botao-agregacao-tabela").parent().off("click", "#botao-agregacao-tabela", createAggregation);
		$('body').off('click','.btn-ok-aggregation',actionAggregation);
		$(".box-search-tc").remove();
		$(".pagination-table-component").remove();
		$(defaults.renderTo).find(".sticky-wrap").remove();
	};

	var createTitle = function(title){
		var arrayStrg = title.split(" ");
		var length = 0;
		$.each(arrayStrg,function(i,item){
			length += item.length;
		});
		return title;
	};

	//Esse método cria o <thead> da table
	var createHeader = function(defaults){
		var tHead = $("<thead>");
		var trHead = $("<tr>");
		$.each(defaults.columns,function(i,item){
			var th = $("<th>").attr("data-position",i).attr("data-original-title",item.definition).attr("data-placement","bottom");
			var div = $("<div>").addClass("header-content");
			var divImgOrder = $("<div>");
			var divTitle = $("<div>").addClass("header-title").append($("<p>").html(createTitle(item.title_column)));
			var divSubtitle = $("<div>").addClass("header-subtitle").html(item.year);
			var imgCloseColumn = "";
			//TODO Descomentar para que possa aparecer o botão de fechar a coluna. 
			/*if(i != 0)
				imgCloseColumn = $("<img>").attr("src","assets/img/icons/fechardown.png").addClass("close-column");				*/
			var divConfigs = $("<div>").addClass("configs-header").append(imgCloseColumn);
			th.html(div.append(divImgOrder).append(divConfigs).append(divTitle).append(divSubtitle));
			trHead.append(th);
		});
		return tHead.append(trHead);
	};

	//Esse método cria o <tbody> da table
	var createBody = function(data, arrayLinksPerfil, arrayDescricao){
		 var tBody = $("<tbody>");
		 $.each(data,function(j,item){
		 	var tr = $("<tr>");
		 	$.each(item,function(i,val){

		 		if(i === 0){
		 			var th = $("<th>");
		 			if(j == 0)//Brasil
		 				var a = $("<div>");
		 			else{
		 				if(arrayLinksPerfil == null || arrayLinksPerfil.length == 0){
                            var a = $("<a>").attr("title",val).
                                attr("data-perfil", '')
                                .attr('data-content', arrayDescricao[j-1])
                                .attr('data-html', true)
                                .attr('data-count', j-1)
                                .addClass("dota-popover")
                                .css("cursor","pointer");
		 				}
                        else{
                            if(arrayLinksPerfil[j-1] != "") {
                                var a = $("<a>").attr("title",val).
                                    attr("data-perfil",arrayLinksPerfil[j-1])
                                    .attr('data-content', arrayDescricao[j-1] +
                                                        '<br><p style=""><a class="" href="' +
                                                        arrayLinksPerfil[j-1] + '" target="_blank">' +
                                                        lang_mng.getString('perfil_completo') + '</a></p>')
                                    .attr('data-html', true)
                                    .attr('data-count', j-1)
                                    .addClass("dota-popover")
                                    .css("cursor","pointer");
                            } else {
                                var a = $("<a>").attr("title",val).
                                    attr("data-perfil", '')
                                    .attr('data-content', arrayDescricao[j-1])
                                    .attr('data-html', true)
                                    .attr('data-count', j-1)
                                    .addClass("dota-popover")
                                    .css("cursor","pointer");
                            }
		 				}
                    }

		 			tr.append(th.append(a.append(val)));
		 		}
		 		else{
		 			var td = $("<td>");
		 			
		 			var cell;
		 			if(typeof val === "undefined" || val == "" || val == null){
		 				val = "-";
		 				cell = td.append(val).attr("data-position",i).css('text-aling','center');
		 			}
		 			else{
                        val = val.split('.').join(',');
                        val = val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        cell = td.append(val).attr('data-position', i);
		 			}
		 				
		 			tr.append(cell);
		 		}
		 	});
		 	tBody.append(tr);
		 });
		 return tBody;
	};

	var createWidthColumns = function(defaults){
		var colObject = $("<colgroup>");
		if (typeof defaults.configColumns === "object") {
			var col = $("<col>").attr("span",1).attr("style","width:"+defaults.configColumns.firstColumn+"");
			colObject.append(col);
			$.each(defaults.columns,function(i,item){
				if(i == 0)
					return true;
				var col = $("<col>").attr("span",1).attr("style","width:"+defaults.configColumns.othersColumns+"");
				colObject.append(col);
			});
		}
		else{ //se for um array vou mexer aqui depois

		}
		return colObject;
	};

	var createTable = function(){
		$(defaults.renderTable).append(createHeader(defaults));
		$(defaults.renderTable).append(createBody(defaults.data, defaults.configsData.link, defaults.configsData.descricao));
		$(defaults.renderTable).prepend(createWidthColumns(defaults));
	};

	var clearOrder = function(defaults){
		$.each(defaults.columns,function(i,item){
			item.order = false;
		});
	};
	//método responsável por criar o layout inicial das imagens de ordenação
	var setOrder = function(defaults){
		$(".sticky-wrap .sticky-intersect th").attr("data-position","0");
		$(".sticky-wrap .sticky-intersect th").css("cursor","pointer");
		$(".sticky-wrap .sticky-thead th").css("cursor","pointer");
		
		$.each(defaults.columns,function(i,item){
			if(item.hasOwnProperty("order") && item.order != false){
				if(item.order === "asc"){
					$(".sticky-wrap .sticky-intersect th[data-position="+i+"]").addClass("img-order-asc");
					$(".sticky-enabled th[data-position="+i+"]").addClass("img-order-asc");
					$(".sticky-wrap .sticky-thead th[data-position="+i+"]").addClass("img-order-asc");
				}
				else if(item.order === "desc"){
					$(".sticky-wrap .sticky-intersect th[data-position="+i+"]").addClass("img-order-desc");
					$(".sticky-enabled th[data-position="+i+"]").addClass("img-order-desc");
					$(".sticky-wrap .sticky-thead th[data-position="+i+"]").addClass("img-order-desc");
				}
			}
			else{
				$(".sticky-wrap .sticky-intersect th[data-position="+i+"]").addClass("img-order-updown");
				$(".sticky-enabled th[data-position="+i+"]").addClass("img-order-updown");
				$(".sticky-wrap .sticky-thead th[data-position="+i+"]").addClass("img-order-updown");
			}
		});
	};

	//Esse método retorna o objeto que representa a celula do cabecalho de posicao passada por parâmetro
	//resolvi desacoplar para possíveis ajustes
	var getColumnObject = function(position){
		return defaults.columns[position];
	};

	//Método que seta no objeto que foi clicado para ser ordenado
	// column que está dentro de defaults a forma de ordenação "asc" e "desc"
	var setObjectOrderColumn = function(element, position, defaults){
		if($(element).closest("th").hasClass("img-order-updown") || $(element).closest("th").hasClass("img-order-desc")){
			$.each(defaults.columns,function(i,item){
				item.order = false;
			});
			defaults.columns[position].order = "asc";
		}
		else if($(element).closest("th").hasClass("img-order-asc")){ //DESC
			$.each(defaults.columns,function(i,item){
				item.order = false;
			});				
			defaults.columns[position].order = "desc";
		}
	};

	var search = function(e){
		var columnObject = getColumnObject(0);
		loadingHolder.show(lang_mng.getString("carregando"));
		defaults.search.callback($(this).closest(".box-search-tc").find("#search-component").val(), columnObject,defaults, e, $(this).closest(".box-search-tc").find("#search-component"));
		///fazer buscar no server e retornar resultados para a tabela.
		loadingHolder.dispose(); // esse dispose deve ser executado depois que a requisição finalizar. Atentar a assincronas
	}

	var getPositionColumn = function(defaults){
		var position = "";
		$(defaults.renderTo).find(".sticky-thead th").each(function(i,item){
			if($(item).hasClass("img-order-asc") || $(item).hasClass("img-order-desc")){
				position = $(item).attr("data-position");
			}
		});
		return position;
	};

	var closeColumn = function(){
		var position = $(this).closest("th").attr("data-position");
		$("[data-position="+position+"]").remove();
		if(defaults.arrayPositionHideColumns === false)
			defaults.arrayPositionHideColumns = new Array();
		defaults.arrayPositionHideColumns.push(position);
	};

	var getQuantityEntitiesSelecteds = function(){
		var j = 0;
		$.each(defaults.dataAjax.entidades,function(i,item){
			if((typeof item.l != "undefined" && item.l.length !=0) || item.est.length != 0 || item.mun.length != 0 || item.rm.length != 0 || item.udh.length != 0)				//existe item selecionado nessa entidade
				j++;
		});
		return j;
	};

	var createAggregation = function(e){
		//MOSTRAR MENSAGEM FALANDO SOBRE A AGREGAÇÃO E APERTANDO OK OU CANCELAR
		AtlasBrasil.messages({
			display : "modal",
			renderTo : "#general-modal",
			width : "400px",
			height : "200px",
			left : "54%",
			optionsModal : {
				backdrop : 'static',
			},
			body : lang_mng.getString("modal_agregacao"),
			options : {
				buttons : [
					{"class" : "dismiss-modal-aggregation gray_button big_btn", "style": "margin-right: 10px", "data-dismiss": "modal", "aria-hidden" : "true","text" : lang_mng.getString("cancelar_btn")},
					{"class" : "btn-ok-aggregation blue_button big_btn", "aria-hidden" : "true","text" : "Ok", "data-dismiss": "modal"}
				],
			},
		});
	}

    var actionAggregation = function(e){
        loadingHolder.show(lang_mng.getString("carregando-agregacao"));
        $('<p />')
            .html(lang_mng.getString("carregando-agregacao-info"))
            .css('font-size', '0.6em')
            .css('color', '#999')
            .css('padding-top', '10px')
            .addClass('loading-info')
            .appendTo("#contentLoading");
        $("#contentLoading").css("height", "125px");
        var aggregation = false;
        var j = 0;
        $.each(defaults.dataAjax.entidades,function(i,item){
            if((typeof item.l != "undefined" && item.l.length !=0) || item.est.length != 0 || item.mun.length != 0 || item.rm.length != 0 || item.udh.length != 0){
                j++;
                if(j > 1) {
                    return false;
                }
                aggregation = Array();
                aggregation.push(item);
            }
        });

        if(j === 1){
            var position = getPositionColumn(defaults);
            var columnObject = getColumnObject(position);

            if(typeof columnObject === "undefined") {
                columnObject = false;
            }
            defaults.dataAjax.aggregation = aggregation;
            $("#botao-agregacao-tabela").removeClass("disabled");
            defaults.aggregation.callback(this, defaults, columnObject, e);
        }
    };
	//função que ativa as funções da tabela.
	//ao destruir desligar todos os eventos, pode ser q repita, vãm ver
	var setActions = function(defaults){

		$('body').on('click','.btn-ok-aggregation',actionAggregation);

		//ACTIONS DO ORDER HEADER INSTERSECT
		$(".sticky-wrap").on("click",".sticky-intersect th",function(e){
            loadingHolder.show(lang_mng.getString("carregando"));
			var columnObject = getColumnObject(0);
			//DUS FUNÇÕES UTILIZAM ESSE IF, DEIXAR ELE MAIS GENÉRICO, OBRIGADO
			setObjectOrderColumn(this, 0, defaults);
			var string = $(this).closest(defaults.renderTo).find("#search-component").val();
			defaults.order.callback(this, columnObject, defaults, e, string);
		});

		//ACTIONS DO ORDER NORMAL HEADER
		$(".sticky-wrap").on("click",".sticky-thead th",function(e){
            loadingHolder.show(lang_mng.getString("carregando"));
			var position = parseInt($(this).closest("th").attr("data-position"));
			var columnObject = getColumnObject(position);
			setObjectOrderColumn(this, position, defaults);
			var string = $(this).closest(defaults.renderTo).find("#search-component").val();
			defaults.order.callback(this, columnObject, defaults, e, string);	
		});
		//ACTIONS DA BUSCA
		$(defaults.renderTo).on("click","#btn-search-tc",search);
		//ACTIONS PAGINATION
		$('.pagination-table-component').on("click","ul>li>a",function(){
			//TODO, PEGAR COLUNA QUE ESTÁ ORDENADA PARA MANDAR PRO SERVER
            loadingHolder.show(lang_mng.getString("carregando"));
			var position = getPositionColumn(defaults);
			
			var columnObject = getColumnObject(position);
			if(typeof columnObject === "undefined")
				columnObject = false;
			var page = parseInt($(this).attr("data-pagination"));
			defaults.pagination.callback(page,columnObject, defaults, this);
		});

		$(defaults.renderTo).on("click",".close-column",closeColumn);
		//Evento de agregação
		$("#botao-agregacao-tabela").parent().on("click", "#botao-agregacao-tabela", createAggregation);


        var indexPopover = -1;
        $(".sticky-col .dota-popover").on('click', function(e){
            e.preventDefault();
            var $target = $(e.target);
            $target.addClass('current');

            var targetTop = $target.offset().top + 32;
            var targetLeft = $target.offset().left;

            var title = $target.attr('title');
            var conteudo = $target.attr('data-content');

            var popover = '<div class="popover-component">' +
            '<div class="arrow"></div>' +
            '<div class="popover-title">' + title + '<span><a href="javascript:;" class="close-popover">×</a></span></div>' +
            '<div class="popover-content">' + conteudo + '</div>' +
            '</div>';
            if($('.popover-component').length > 0) {
                $('.popover-component').remove();
                if ( indexPopover != $('.dota-popover').index($('.current')) ) {
                    $(popover).appendTo('body');
                    $('.popover-component').css('top', targetTop);
                    $('.popover-component').css('left', targetLeft);
                    $('.popover-component').show(100);
                    indexPopover = $('.dota-popover').index($('.current'));
                }
            } else {
                $(popover).appendTo('body');
                $('.popover-component').css('top', targetTop);
                $('.popover-component').css('left', targetLeft);
                $('.popover-component').show(100);
                indexPopover = $('.dota-popover').index($('.current'));
            }
            $target.removeClass('current');
        });

        $(window).on('click', function(e){
            var target = $(e.target);
            if( (target.hasClass('popover-component') ||
                target.hasClass('dota-popover') ||
                target.parents('.popover-component').length > 0) && ! target.hasClass('close-popover') ) {
            } else {
                $('.popover-component').remove();
            }
        });
	};


	var getHtmlInputSearch = function(objectSearch){
		var div = $("<div>").addClass("box-search-tc");
		var input = $("<input>").attr("type","text").attr("id","search-component").attr("placeholder","Busca por espacialidade").addClass("search-table-component input-xlarge").val(objectSearch.stringSearch);
		var img = $("<img>").attr("src","assets/img/icons/lupa2-white.png");
		var button = $("<button>").addClass("blue_button").attr("id","btn-search-tc").html(img);
		div.append(button).append(input);
		return div;
	};
	//ta na base da gambis esse pagination.  Dá pra melhorar bastante
	var getHtmlPagination = function(objectPagination){ // termina isso e fazer documento pra japa
		var numberPages = Math.ceil(parseInt(objectPagination.count) / parseInt(objectPagination.limit));
		if(numberPages <= 1)//NÃO NECESSITA DE PAGINAÇÃO
			return;
		
		var ul = $("<ul>");
		var prev = $("<li>").html($("<a>").addClass("prev-pagination").attr("href","javascript:;").html("<<"));
		var next = $("<li>").html($("<a>").addClass("next-pagination").attr("href","javascript:;").html(">>"));
		ul.append(prev);
		//TODO última página ta faltando marcar como ativa
		//DÁ PRA TORNAR CÓDIGO MAIS GENÉRICO
		if(defaults.pagination.pageActive == 1){
			classItemActive = "page-active";
			prev.find("a").attr("data-pagination",1);
			next.find("a").attr("data-pagination",2);
		}
			
		ul.append($("<li>").addClass(classItemActive).html($("<a>").attr("data-pagination",1).attr("href","javascript:;").html(1)));//Todos começam com 1

		if(numberPages <= 10){ // não tem pontinhos
			for (var i = 2; i <= numberPages; i++) {
				var classItemActive = "";
				if(i == defaults.pagination.pageActive){
					classItemActive = "page-active";
					prev.find("a").attr("data-pagination",i-1);
					next.find("a").attr("data-pagination",i+1);
				}
					
				var li = $("<li>").addClass(classItemActive).html($("<a>").attr("data-pagination",i).attr("href","javascript:;").html(i));
				ul.append(li);
			};
		}
		else{ //Tem pontinhos, agora nós vamos descobrir onde eles ficam
			var liDots = $("<li>").addClass("dots-pagination").html("...");
			if(defaults.pagination.pageActive < 6){//Só tem pontinhos no final
				for (var i = 2; i < 10; i++) {
					var classItemActive = "";
					if(i == defaults.pagination.pageActive){
						classItemActive = "page-active";
						prev.find("a").attr("data-pagination",i-1);
						next.find("a").attr("data-pagination",i+1);
					}
					var li = $("<li>").addClass(classItemActive).html($("<a>").attr("data-pagination",i).attr("href","javascript:;").html(i));
					ul.append(li);
				};
				ul.append(liDots);
				classItemActive = "";
				if(defaults.pagination.pageActive == numberPages){
					classItemActive = "page-active";
					prev.find("a").attr("data-pagination",numberPages - 1);
					next.find("a").attr("data-pagination",numberPages);
				}
				var li = $("<li>").addClass(classItemActive).html($("<a>").attr("data-pagination",numberPages).attr("href","javascript:;").html(numberPages));
				ul.append(li);
				ul.append(next);
			}
			else if(defaults.pagination.pageActive >= (numberPages - 4)){ //Só tem pontinhos no início
				ul.append(liDots);
				var initPag = numberPages - 4;
				for (var i = initPag; i < numberPages; i++) {
					var classItemActive = "";
					if(i == defaults.pagination.pageActive){
						classItemActive = "page-active";
						prev.find("a").attr("data-pagination",i-1);
						next.find("a").attr("data-pagination",i+1);
					}
					var li = $("<li>").addClass(classItemActive).html($("<a>").attr("data-pagination",i).attr("href","javascript:;").html(i));
					ul.append(li);
				};
				classItemActive = "";
				
				if(defaults.pagination.pageActive == numberPages){
					classItemActive = "page-active";
					prev.find("a").attr("data-pagination",numberPages - 1);
					next.find("a").attr("data-pagination",numberPages);
				}
				var li = $("<li>").addClass(classItemActive).html($("<a>").attr("data-pagination",numberPages).attr("href","javascript:;").html(numberPages));
				ul.append(li);
				ul.append(next);
			}
			else{// Tem pontinhos no início e no final
				ul.append(liDots);
				var initPag = defaults.pagination.pageActive - 3;
				var endPag = defaults.pagination.pageActive + 4;
				for(var i = initPag; i < endPag;  i++){
					var classItemActive = "";
					if(i == defaults.pagination.pageActive){
						classItemActive = "page-active";
						prev.find("a").attr("data-pagination",i-1);
						next.find("a").attr("data-pagination",i+1);
					}
					var li = $("<li>").addClass(classItemActive).html($("<a>").attr("data-pagination",i).attr("href","javascript:;").html(i));
					ul.append(li);
				}
				ul.append(liDots.clone());
				classItemActive = "";
				if(defaults.pagination.pageActive == numberPages){
					classItemActive = "page-active";
					prev.find("a").attr("data-pagination",numberPages - 1);
					next.find("a").attr("data-pagination",numberPages);
				}
				var li = $("<li>").html($("<a>").attr("href","javascript:;").attr("data-pagination",numberPages).html(numberPages));
				ul.append(li);
				ul.append(next);
			}
		}
		var divPagination = $("<div>").addClass("pagination pagination-table-component").html(ul);
		return divPagination;
	};

	var setFontPadding = function(element){
		var heightTitle = $(element).find(".header-title").outerHeight();
		var heightText = $(element).find("p").outerHeight();
		if(heightText < heightTitle){
			$(element).find("p").css("padding-top",(heightTitle - heightText) + 2);
			return;
		}
		else{
            var element_fontSize = $(element).find(".header-title");
            if(element_fontSize.length > 0) {
                var fontSize = parseInt($(element).find(".header-title").css("font-size").replace("px",""));
                $(element).find(".header-title").css("font-size",(fontSize - 2));
                setFontPadding(element);
            }
		}
	};

	var setHeightHeader = function(defaults){
		var header = $("thead th");
		$.each(header,function(i,item){
			setFontPadding(item);
		});
	};

	var setHideColumns = function(array){
		if(array != false || array.length != 0){
			$.each(array,function(i,item){
				$("[data-position="+item+"]").remove();
			});
		}
	}

	var manageButtonAggregate = function(){
		var numberEntitiesSelecteds = getQuantityEntitiesSelecteds();
		/*$('.agregacao').tooltip({title: lang_mng.getString("tooltip_agregacao")})*/
		var selectedsEntities = seletor.getSelecteds();
		if(selectedsEntities.length === 1 && selectedsEntities[0].e == 2){
			/*$("tbody tr:first-child").remove();*/
			$("#botao-agregacao-tabela").removeClass("disabled");
		}
		else{
			$("#botao-agregacao-tabela").parent().off("click", "#botao-agregacao-tabela", createAggregation);
			$("#botao-agregacao-tabela").addClass("disabled");
		}
			
	};

    var manageAvisoUDH = function() {
        $('aviso-udh').remove();
        var selectedsEntities = seletor.getSelecteds();
        selectedsEntities.forEach(function(element, index, array){
            if(element.e == 5) {
                 $avisoUDH = $('.texto-aviso-udh').html();
                 $('<div />').addClass('aviso-udh').css('margin-top', '10px').html($avisoUDH).appendTo('.sticky-wrap');
                 return;
            }
        });
    }

	var create = function(options){
		/*
		 * init() vai iniciar todas as acoes da tabela
		 * create vai criar a tabela obviamente. Ela vai apagar e criar uma nova todas as vezes em todas as acoes tbm.
		 * as acoes serao passadas por callback, para que cada desenvolvedor possa criar a sua function
		 * a tabela tera um protocolo para ser montada
		 *
		 */

		 defaults.data = options.data;
		 defaults.columns = options.columns;
		 $.extend(true,defaults,options);

		 destroy(defaults);
		 if(defaults.search.has === true){
		 	$(defaults.renderTo).append(getHtmlInputSearch(defaults.search));
		 	if(defaults.search.stringSearch != ""){
		 		$("#search-component").focus();
		 	}
		 }	
		 var table = $("<table>");
		 $(defaults.renderTo).append(table);
		 $(defaults.renderTo).append(getHtmlPagination(defaults.pagination));
		 defaults.renderTable = $(defaults.renderTo).find("table");
		 defaults.instance = table;
		 createTable(defaults);
		 setHeightHeader(defaults);


		 $.fn.stickyHeader();
		 setActions(defaults);
		 
		 setOrder(defaults);
		 $(defaults.renderTo).find(".sticky-wrap .sticky-col").css("width",defaults.configColumns.firstColumn);
		 /*$(defaults.renderTo).find(".sticky-thead").css("width","auto");*/
		 setHideColumns(defaults.arrayPositionHideColumns);
		 manageButtonAggregate();
         manageAvisoUDH();
		 $("table th").tooltip();
         //inicializar as ações da tabela.
         //ela será criada somente quando selecionar as entidades e/ou indicadores
    };

    var getOrderObject = function(){
        var position = getPositionColumn(defaults);
        if(position === "")
            return false;
        return getColumnObject(position);
    };

    return{
        create : create,
               destroy : destroy,
               getSettings : getSettings,
               setSettings : setSettings,
               getOrderObject : getOrderObject
    }
})(jQuery);

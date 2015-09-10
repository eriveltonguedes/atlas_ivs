//Tornar mais genérica a plotagem dos resultados na versão 2.0
// REFATORAR -> DIVIDIR EM VÁRIOS COMPONENTES EM VÁRIOS ARQUIVOS QUE "CONVERSAM ENTRE SI"
(function($){
	if (typeof $ === 'undefined') { throw new Error('FilterSearch JavaScript requires jQuery'); return; }	
	$.FilterSearch = function(options){
		//fazer validações antes de chamar 'classe' do seletor
		if (typeof SearchComponent === 'undefined') { throw new Error('Comoponente filter-search.js requer componente SearchComponent.js'); return; }				
		return new FS(options);
	};
	
	var FS = function(options){
		//pensar em uma forma de "injetar" o search
		var search = new SearchComponent();
		var defaults = {
			data: {				
				selectors : [],
				genericUrl: false
			},
			minCharTableSearch : 3,
			renderTo : '.fs',
			element : "#button-fs"		
		};
		$.extend(true,defaults,options);
		var _arraySelecionados = defaults.data.selectors;
		var _arraySelecionadosInicial = new Array();
		_arraySelecionadosInicial = defaults.data.selectors;  
		
		var arrayStep = Array();
		
		var showLoading = function(text){
			if(typeof text === "undefined")
				arrayStep.push($('.fs').find(".left-content").html());
			var img = $("<img>").attr("src","assets/img/load.gif").css("width","75px").css("height","75px").css("margin-left","200px").css("margin-top","40px");	
			$('.fs').find('.selectors').html(img);
		};

		var selectedsIsEmpty = function(){
			var retorno = true;
			$.each(_arraySelecionados,function(i,item){
				if (item.hasOwnProperty("selecteds") && item.selecteds.length != 0) {
					retorno = false;
				};
			});
			return retorno;
		};
		
		
		var activeEventsAllItens = function(){
			if($(".selected-all").is(":checked")){
				$('.fs').on('click','.fs .itens-fs-filter',function(){
					getItensNextStep(this);
				});
				$('.fs').on('click','.item-list-link-fs',function(){
					selectItens(this);
				});	
			}
		};
		
		var undo = function(){
			activeEventsAllItens();
			$('.fs').find('.left-content').html("");
			$('.fs').find('.left-content').html(arrayStep[arrayStep.length - 1]);
			arrayStep.pop();
		};
		
		var getFiltersByIdSelector = function(idSelector,selector){
			var retorno = "";
			$.each(selector.filters,function(i,item){				
				if(item[0] == idSelector){
					retorno = item;
				}
			});
			return retorno;
		};
		
		var getNextStep = function(idSelectorParent,idCurrentSelector){
			var selector = getSelectorById(idSelectorParent);
			var retorno = "";
			$.each(selector.filters,function(i,item){
				var arrayFilters = item;
				var j = i;			
				$.each(arrayFilters,function(i,item){
					if(item == idCurrentSelector){
						if(arrayFilters[i+1] != undefined)
							retorno = arrayFilters[i+1];						
						else
							retorno = false; 
					}
				});
			});		
			return retorno;
		};
		//Pega o array de filtros relacionado aos filtros atuais
		var getRelatedFilters = function(filters,idCurrentFilter){
			var retorno = "";
			$.each(filters,function(i,item){
				itemArrayFilter = item;
				$.each(itemArrayFilter,function(i,item){
					if(item == idCurrentFilter){
						retorno = itemArrayFilter;
					}	
				});
				
			});
			return retorno;
		};
		
		var setAllItensDeselect = function(label){
			
			var dataIdEntity = $(label).attr("data-id-entity");
			
			if(typeof dataIdEntity != "undefined"){
				$(label).closest(".modal-body").find(".list-itens-fs-filter li[data-entity="+dataIdEntity+"]").find("a").addClass("deselect");
				$(label).closest(".modal-body").find(".list-itens-fs-filter li[data-entity="+dataIdEntity+"]").find("a").removeClass("itens-fs-filter");
			}	
			else{
				$(label).closest(".modal-body").find(".list-itens-fs-filter a").addClass("deselect");
				$('.fs').off("click",".fs .itens-fs-filter");
				$(label).closest(".modal-body").find(".ul-data-ist a").addClass("deselect").removeClass("item-list-link-fs").removeClass("unselected");
				$('.fs').off("click",".item-list-link-fs");	
			}
			
		};
		
		var setAllItensSelect = function(label){
			
			var dataIdEntity = $(label).attr("data-id-entity");

			if(typeof dataIdEntity != "undefined"){
				$(label).closest(".modal-body").find(".list-itens-fs-filter li[data-entity="+dataIdEntity+"]").find("a").addClass("itens-fs-filter");	
				$(label).closest(".modal-body").find(".list-itens-fs-filter li[data-entity="+dataIdEntity+"] a").removeClass("deselect");
			}
			else{
				$('.fs').on('click','.fs .itens-fs-filter',function(){
					getItensNextStep(this);
				});	
				$(label).closest(".modal-body").find(".list-itens-fs-filter a").removeClass("deselect");
			}
			

			var unselect = "";
			$.each($(label).closest(".modal-body").find(".ul-data-ist a"),function(i,item){
				if(!$(item).hasClass("selected"))
					unselect = "unselected";
				$(item).addClass("item-list-link-fs").addClass(unselect).removeClass("deselect");
			});
			
			$('.fs').on('click','.item-list-link-fs',function(){
				selectItens(this);
			});	
		};
		
		var setAllItensSelecteds = function(label){
			var obj = {};
			var dataIdEntity = $(label).attr("data-id-entity");
			if(typeof dataIdEntity != "undefined")
				obj.idParent = dataIdEntity;
			else
				obj.idParent = $('.fs .title-fs-filter').attr("data-id");
			obj.idFilter = $(label).attr("data-id");
			obj.idItemSelector = $(label).attr("data-id-item-selector");

			if($(label).is(":checked")){
				pushSelectedItens(obj,obj.idParent);
				
				var a = $('<a>').addClass('remove-fs-item-selected').attr("data-toggle","tooltip").attr("data-original-title",lang_mng.getString("seletor_remover_selecionado")).append($('<img>').attr('src',"assets/img/icons/deleteSelecionado.jpg"));
				$('.selecteds .itens-selecteds').prepend($('<div>').addClass('item-selected').attr("data-id-filter",obj.idFilter).attr('data-id',obj.idItemSelector).attr('data-id-selector',obj.idParent).html($(label).closest("label").find(".text-all-itens").text()).append(a));
				setAllItensDeselect(label);
				$(".remove-fs-item-selected").tooltip({placement: 'top'});
			}
			else{
				pullSelectedItens(obj,obj.idParent);
				$('.selecteds .item-selected[data-id="'+obj.idItemSelector+'"][data-id-filter="'+obj.idFilter+'"][data-id-selector="'+obj.idParent+'"]').remove();
				setAllItensSelect(label);
			}
			
		};
		
		var getItensNextStep = function(label){
			var data = {};
			var dataIdEntity = $(label).closest('li').attr("data-entity");
			if(typeof dataIdEntity != "undefined" && dataIdEntity == 3){
				data.idSelectorParent = dataIdEntity;
				data.idSelector = $(label).closest('li').attr("data-id-selector");
			}
				
			else{
				data.idSelectorParent = $(label).closest('.fs').find('.title-fs-filter').attr('data-id');
				data.idSelector = $(label).closest('.accordion-group').find('.accordion-heading a').attr('data-id');
			}
				
			data.idItem = $(label).closest('li').attr('data-id');
			data.nextStep = getNextStep(data.idSelectorParent, data.idSelector);
			data.nameFilter = $(label).text();
			
			var obj = {};
			obj.filter = data.idSelector;
			obj.item = data.idItem;
			obj.nameFilter = $(label).text();
			showLoading();
			search.filterSearch(data,callbackFilter,defaults.data);
		};
		
		var cleanItensSelecteds = function(){
			activeEventsAllItens();	
			$.each(_arraySelecionados,function(i,item){
				if(item.hasOwnProperty("selecteds")){
					item.selecteds = Array();
				}
			});
			$(".fs .itens-selecteds").html("");
		};

		//todos os eventos do componente		
		var actions = function(){
			$(".fs").on("change",".fs .selected-all",function(){
				setAllItensSelecteds(this);
			});

            $(document).keyup(function(e){
                var keymap = [];
                keymap['65'] = 'a';
                keymap['66'] = 'b';
                keymap['67'] = 'c';
                keymap['68'] = 'd';
                keymap['69'] = 'e';
                keymap['70'] = 'f';
                keymap['71'] = 'g';
                keymap['72'] = 'h';
                keymap['73'] = 'i';
                keymap['74'] = 'j';
                keymap['75'] = 'k';
                keymap['76'] = 'l';
                keymap['77'] = 'm';
                keymap['78'] = 'n';
                keymap['79'] = 'o';
                keymap['80'] = 'p';
                keymap['81'] = 'q';
                keymap['82'] = 'r';
                keymap['83'] = 's';
                keymap['84'] = 't';
                keymap['85'] = 'u';
                keymap['86'] = 'v';
                keymap['87'] = 'w';
                keymap['88'] = 'x';
                keymap['89'] = 'y';
                keymap['90'] = 'z';
                if($(".fs.modal").is(":visible")) {
                    if(typeof keymap[e.which] !== "undefined") {
                        if($('#accordion2 .ul-data-ist').is(':visible')) {
                            var $elementScroll = $("#accordion2");
                            var letraDigitada = keymap[e.which];
                            $elementScroll.find('.ul-data-ist li a').each(function(index, element) {
                                var primeiraLetra = $(element).text().substr(0, 1).toLowerCase();
                                if( $(element).text().indexOf('RM -')  != -1) {
                                    primeiraLetra = $(element).text().substr(5, 1).toLowerCase();
                                }
                                var $element = $(element);
                                if( primeiraLetra ==  letraDigitada) {
                                    var scrollPosition = $element.position().top;
                                    $elementScroll.scrollTop(scrollPosition);
                                    return false;
                                }
                            });
                        }
                    }
                }
            });

			$(".fs").on("click",".undo-fs-minhas-listas",function(){
				/*cleanItensSelecteds();*/
				plotSelectors(defaults.data.selectors);
			});

			$(".fs").on("click",".use-list",function(){
				var arrayLists = $.parseJSON(localStorage.getItem("arrayLists"));
				var obj = arrayLists[$(this).attr("data-position")];
				$(".itens-selecteds").html(obj.htmlItensSelecteds);
				_arraySelecionados = obj.protocolSelectedItems;
				plotSelectors(defaults.data.selectors);
			});

			$(".fs").on("click",".btn-dismiss",function(){
				$(this).closest("#modal-seletor-lista-usuario").modal("hide");
			});

			$(".fs").on("click","#btn-minhas-listas",function(){
				var arrayLists = localStorage.getItem("arrayLists");
				if(arrayLists == null || typeof(arrayLists) == "undefined" || arrayLists.length == 0)
					console.log("Não há listas criadas pelo usuário");
					//mostrar mensagem avisando que não há listas para esse usuário
				else{
					var objArrayLists = $.parseJSON(arrayLists);
					var titleMinhasSelecoes = $("<h4>").attr("style","margin-left:5px;").html(lang_mng.getString("seletor_minhas_listas"));
					var divUndo = $('<div>').addClass('undo-fs-minhas-listas').attr("data-toggle","tooltip").attr("data-original-title",lang_mng.getString("seletor_voltar"));
					var ul = $("<ul>").addClass("lista-listas-salvas");
					$.each(objArrayLists,function(i,item){
						var li = $("<li>");
						var spanNameList = $("<span>").addClass("name-list").html("<strong>"+item.nameList+"</strong>");
						var date = new Date(item.date);
						var spanDate = $("<span>").addClass("date-list").html(" - " + date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear());
						var a = $("<a>").attr("href","javascript:;").addClass("delete-list").attr("data-position",i).html('Excluir');
						/*var imgDelete = $('<img>').attr('src',"assets/img/icons/x.png");*/
						var aOk = $("<a>").attr("href","javascript:;").addClass("use-list").attr("data-position",i).attr("style","margin-left:20px;").html('Aplicar');
						/*var imgOk = $('<img>').attr('src',"assets/img/icons/check-ok.png");*/
						var spanActions = $("<span>").addClass("actions-list").html(aOk).append(a);
						ul.append(li.append(spanNameList).append(spanDate).append(spanActions));
					});
					$(".fs").find(".selectors").html(ul).prepend(titleMinhasSelecoes).prepend(divUndo);
				}
			});
			
			$(".fs").on("click","#modal-seletor-lista-usuario .btn-ok-fs-save-list",function(){
				var arrayLists = localStorage.getItem("arrayLists");			
				if(arrayLists == null || typeof(arrayLists) == "undefined" || arrayLists.length == 0){
					arrayLists = [];
				}
				else{
					arrayLists = $.parseJSON(arrayLists);
				}
				var data = {};
				data.protocolSelectedItems = _arraySelecionados;
				data.date = new Date();
				data.htmlItensSelecteds = $(".itens-selecteds").html();
				data.nameList = $("#modal-seletor-lista-usuario").find(".modal-body input").val();
				arrayLists.push(data);
				localStorage.setItem("arrayLists",JSON.stringify(arrayLists));
			});

			$(".fs").on("click", "#btn-salvar-listas",function(){

				if(selectedsIsEmpty())
					$(".fs .save-list-alert").show();
				else{
					$(".fs .save-list-alert").hide();
					$("#modal-seletor-lista-usuario").modal({backdrop : false});
				}
					
			});

			$(".fs").on("click",".delete-list",function(){
				var arrayLists = $.parseJSON(localStorage.getItem("arrayLists"));
				var positionDelete = $(this).attr("data-position");
				arrayLists.splice(positionDelete, 1);
				localStorage.setItem("arrayLists", JSON.stringify(arrayLists));
				$(this).closest("li").remove();
			});
			
			$(".fs").on("click",".fs-find-data-filter",function(){
				var self = this;
				var selector = getSelectorById($(this).attr("data-id"));
				var allItensChecked = $(".fs .selected-all").is(":checked");
				if(selector.id == 6){
					search.getRm({
						callback : function(ret){
							var ret = $.parseJSON(ret);
							allItensChecked = $(".fs .selected-all[data-id-entity=5]").is(":checked");
							var data = {};						
							data.resultSearch = ret.data;
							data.idSelector = $(".fs .title-fs-filter").attr("data-id");
							data.idItensSelector = $(self).attr("data-id");
							data.idSelectorParent = $(".fs .title-fs-filter").attr("data-id");
							$(self).closest(".accordion-group").find(".accordion-inner").html(getListItens(data,"filter",allItensChecked));
							if(allItensChecked == true){
								$(".selected-all").closest(".modal-body").find(".list-itens-fs-filter li[data-entity=5]").find("a").removeClass("itens-fs-filter");
							}
						}
					});
				}
				else if(selector.id == 7){
					var data = {};
					data.idSelectorParent = $(self).attr("data-id");
									
					search.filterSearch(data,function(ret){
						var ret = $.parseJSON(ret);
						$(self).closest(".accordion-group").find(".accordion-inner").html(getListItens(ret.data,ret.data.type,allItensChecked));
					},defaults.data);
				}
				else if(selector.id == 3) {
					//TROCAR ALL ITENS CHECKED AQUI PARA VERIFICAR TODOS OS ITENS DAS REGIONAIS
					var data = {};
					data.idSelectorParent = $(self).attr("data-id");
					data.idSelector = $(".fs .selected-all[data-id-entity=3]").attr("data-id");
					data.idItensSelector = $(".fs .selected-all[data-id-entity=3]").attr("data-id-item-selector");
					allItensChecked = $(".fs .selected-all[data-id-entity=3]").is(":checked");
					search.filterSearch(data,function(ret){
						var ret = $.parseJSON(ret);
						$(self).closest(".accordion-group").find(".accordion-inner").html(getListItens(ret.data,ret.data.type,allItensChecked));
						if(allItensChecked){
							$(".selected-all").closest(".modal-body").find(".list-itens-fs-filter li[data-entity=3]").find("a").removeClass("itens-fs-filter");
						}
					},defaults.data);	
				}
			});
			
			$(".fs").on("click","#btn-clean-selecteds",function(){
				cleanItensSelecteds();
				plotSelectors(defaults.data.selectors);
			});
			
			$('.fs').on('click','.fs .itens-fs-filter',function(){
				getItensNextStep(this);
			});
			
			$('.fs').on('click','.item-list-link-fs',function(){
				selectItens(this);
			});
			
			$('.fs').on('click','.fs .undo-fs-filter',function(){
				undo();
			});
			
			$(".fs").on("click",'.btn-ok-fs',function(){
				defaults.callbackOk(this);
			});
			
			$('.fs').on('click','.link-selectors',function(){				
				var data = {};
				data.idSelectorParent = $(this).attr('data-id');	
				showLoading();
				search.filterSearch(data,callbackFilter,defaults.data);
			});
			
			$('.fs').on('click','.remove-fs-item-selected',function(){
				var idItem = $(this).closest('.item-selected').attr('data-id');
				var idSelector = $(this).closest('.item-selected').attr('data-id-selector');
				pullSelectedItens(idItem,idSelector);
				//remover o item quando for todos os sei lá o que de alguem
				$('.fs li[data-id='+idItem+'][data-id-selector='+idSelector+']').find('a').removeClass('selected').addClass('unselected');				
				$(this).closest('.item-selected').remove();
			});
			
			$(defaults.element).parent().on('click',defaults.element,function(){
				$(defaults.renderTo).modal();					
			});
			$('.button-fs-search').parent().on('click','.button-fs-search',function(){						
				var textSearch = $('.input-fs-search').val();				
				search.textSearch(textSearch,callbackText,defaults.data);				
			});
			$('.fs').on("keyup",".input-fs-search",function(e){
				var textSearch = $(this).val();
				arrayStep.length = 0;
				if(textSearch.length >= defaults.minCharTableSearch){
					if(textSearch.length == defaults.minCharTableSearch + 1)
						showLoading(true);
					search.textSearch(textSearch,callbackText,defaults.data);					
				}
				else{
					plotSelectors(defaults.data.selectors);
				}
								
			});		
		};

		var saveUserLists = function() {
			$(".fs").find(".salvar-lista-selecionados img").attr("data-toggle","tooltip").attr("data-original-title",lang_mng.getString("seletor_save_list"));
			$(".fs").find(".salvar-lista-selecionados img").tooltip({placement: "right"});
			$(".fs").find("#btn-minhas-listas").html(lang_mng.getString("seletor_minhas_listas"));
		};

		var configsSelectItens = function(){
			saveUserLists();
		};
		
		var cleanModalBody = function(){
			$('.fs').find('.selectors').html('');
		};
		
		var internationalization = function(){
			//Mensagem abaixo da caixa de pesquisa
			$("#msg-bottom-search").html(lang_mng.getString("seletor_msg_search"));
			$("#title-selecteds").html(lang_mng.getString("seletor_title_selecteds"));
			$("#button-fs").html(lang_mng.getString("seletor_btn_open_selector"));
			$("#btn-clean-selecteds").html(lang_mng.getString("seletor_btn_clean_selecteds"));
			$("#btn-spatiality").html(lang_mng.getString("seletor_espacialidade").toUpperCase());
			$("#btn-salvar-listas").html(lang_mng.getString("seletor_btn_save_lists"));
		};
		
		var plotSelectors = function(selectors){
			cleanModalBody();			
			var divBodySelectors = $('<div>').addClass('div-selectors-body row-fluid');
			$.each(selectors,function(i,item){
				
				if(item.hasOwnProperty("onlyFilter") && item.onlyFilter == true)
					return true;
				var div = $('<div>').addClass('div-selector span12').addClass('link-selectors').attr('data-id',item.id);
				div.html(item.name);
				divBodySelectors.append(div);					
			});
			$('.fs').find('.selectors').html(divBodySelectors);	
			internationalization();
			configsSelectItens();
		};
		
		var getSelectorById = function(id){
			var ret = "";			
			$.each(defaults.data.selectors,function(i,item){							
				if(item.id == id){
					ret = item;
					return false;
				}
			});
			return ret;
		};
		
		var getDataResultSearch = function(item){
			var ul = $('<ul>').addClass('ul-data-ist');			
			var idSelector = item.idEntidade;
			var rm = "";
			var idItensSelector = item.idItensSelector;
			var selected = item.deselect;
			$.each(item.data,function(i,item){
				var a = "";
				var uf = "";
				var idItem = item.id;
				var name = item.nome;
				
				if(item.hasOwnProperty('uf')) //fazer busca mais genérica nesse componente versão 2.0
					uf = "( "+item.uf+" )";
				if(idItensSelector == 6){
					rm = lang_mng.getString("seletor_rm_sigla") + " - ";
				}
				var retorno = true;
				$.each(_arraySelecionados,function(i,item){
					if(item.id == idSelector){
						if(item.hasOwnProperty("selecteds")){
							var j = 0;
							$.each(item.selecteds,function(i,item){																															
								if(idItem == item){
									a = $('<a>').addClass('item-list-link-fs selected').html(rm + name + " " + uf).addClass(selected);
									j++;
									return false;
								}																								
							});							
							if(j == 0) 
								a = $('<a>').addClass('item-list-link-fs unselected').html(rm + name + " " + uf).addClass(selected);
						}
						else							
							a = $('<a>').addClass('item-list-link-fs unselected').html(rm + name + " " + uf).addClass(selected);
					}
				});						
				var li = $('<li>').attr('data-id',idItem).attr('data-id-selector',idSelector).append(a);
				ul.append(li);				
			});
			return ul;
		};
		
		var pullSelectedItens = function(selectedItem,idParentItem){
			$.each(_arraySelecionados,function(i,item){
				if(idParentItem == _arraySelecionados[i].id){

					var arraySelecteds = _arraySelecionados[i].selecteds;
					$.each(arraySelecteds,function(i,item){
						if(typeof item == "object" && typeof selectedItem == "object"){
							if(item.idParent == selectedItem.idParent && item.idFilter == selectedItem.idFilter && item.idItemSelector == selectedItem.idItemSelector){
								arraySelecteds.splice(i,1);
								return false;
							}
						}
						else if(typeof item === "object" && typeof selectedItem === "string"){
							if(item.idParent == idParentItem && item.idFilter == "-1" && item.idItemSelector == selectedItem){
								arraySelecteds.splice(i,1);
							}
						}
						else if(item == selectedItem){
							arraySelecteds.splice(i,1);
							return false;
						}				
					});
				}	
			});
		};
		
		var pushSelectedItens = function(idSelectedItem,idParentItem){
			$.each(_arraySelecionados,function(i,item){
				if(idParentItem == _arraySelecionados[i].id){
					if($.isArray(_arraySelecionados[i].selecteds)){
						_arraySelecionados[i].selecteds.push(idSelectedItem);
					}
					else{
						_arraySelecionados[i].selecteds = Array();
						_arraySelecionados[i].selecteds.push(idSelectedItem);	
					}					 
				}			
			});			
		};
		
		var selectItens = function(label){		
			$(".fs .save-list-alert").hide();
			var idSelector = $(label).closest('li').attr("data-id-selector");
			var idItem = $(label).closest('li').attr('data-id');			
			if($(label).hasClass('unselected') == true){//colocar no array de selecionados								
				pushSelectedItens(idItem, idSelector);
				$(label).removeClass('unselected').addClass('selected');
				var a = $('<a>').addClass('remove-fs-item-selected').attr("data-toggle","tooltip").attr("data-original-title",lang_mng.getString("seletor_remover_selecionado")).append($('<img>').attr('src',"assets/img/icons/deleteSelecionado.jpg"));
				$('.selecteds .itens-selecteds').prepend($('<div>').addClass('item-selected').attr('data-id',idItem).attr('data-id-selector',idSelector).html("<span class='name-item-select'>"+ $(label).text() +"</span>").append(a));
				$(".remove-fs-item-selected").tooltip({placement: 'top'});
			}
			else{											
				pullSelectedItens(idItem, idSelector);
				$(label).removeClass('selected').addClass('unselected');
				$('.selecteds .item-selected[data-id="'+$(label).closest('li').attr('data-id')+'"]').closest('.item-selected').remove();
			}
		};
		
		var plotResultSearchText = function(obj){
			cleanModalBody();
			var div = $('<div>').addClass('result-text-search');
			var hasData = false;
			$.each(obj,function(i,item){
				if(item.data === false){
					return true;
				}
				hasData = true;
				var divResult = $('<div>').addClass('div-result-ist');	
				var selector = getSelectorById(item.idEntidade);
				var divTitle = $('<div>').addClass('div-title-ist').html(selector.name).attr('data-id',selector.id);
				var divBodyResult = $('<div>').addClass('div-body-ist');				
				divBodyResult.append(getDataResultSearch(item));
				div.append(divResult.append(divTitle).append(divBodyResult));				
			});
			if(hasData === false)
				$('.fs').find('.selectors').html("<h3>Não foi encontrado nenhum resultado</h3>");
			else
				$('.fs').find('.selectors').html(div);			
		};
		
		var getListItens = function(data, renderHow,deselect){			
			var ul = $('<ul>').addClass('list-itens-fs-filter');
			var classe = "";
			var classeDeselect = "";
			if(deselect === true)
				classeDeselect = "deselect";
			
			if(renderHow === "data"){
				var obj = {};
				obj.idEntidade = data.idSelector;
				obj.data = data.resultSearch;
				obj.idItensSelector = data.idItensSelector;
				obj.deselect = classeDeselect;
				itens = getDataResultSearch(obj);				
				classe = "item-list-link-fs unselected";
			}
			else{
				classe = "itens-fs-filter";

				$.each(data.resultSearch,function(i,item){					
					var rm = "";
					if(data.idItensSelector == "6"){
						rm = lang_mng.getString("seletor_rm_sigla") + " - ";
					}
					var a = $('<a>').text(rm + item.nome).addClass(classe).addClass(classeDeselect);
					var li = $('<li>').attr('data-id',item.id).attr('data-id-selector',data.idSelector).append(a);
					if(data.hasOwnProperty("idSelectorParent")){
						if(data.idSelectorParent == 5 || data.idSelectorParent == 3)
							li.attr("data-entity",data.idSelectorParent);
					}
					ul.append(li);
				});
				itens = ul;
			}
			return itens;
		};
		
		var constructAccordion = function(arrayFilters,data){
			arrayFilters = data.arrayFilters;
			var $accordion = getTemplateAccordion();			
			var $template = $accordion.find('.templateBody');
			
			if(typeof arrayFilters != "undefined" && arrayFilters != false){
				$.each(arrayFilters,function(i,item){
					var selector = getSelectorById(item);					
					if(i == 0){
						if(arrayFilters.length != 1){
							$accordion.find('.collapse').removeClass('in');
							$accordion.find('.templateBody').find('.accordion-heading a').addClass("fs-find-data-filter");
							$accordion.find('.templateBody').attr("data-toggle","tooltip").attr("data-original-title",lang_mng.getString("seletor_mostrar_lista"));	
						}
						else if(arrayFilters.length === 1){
							$accordion.find('.templateBody').find('.accordion-heading a').removeAttr("href");
						}
						var idEntity = $('.title-fs-filter').attr("data-id");
						var text = "";
						if(data.idSelectorParent == 5 && selector.id == 2) // se a entididade for UDH e o filtro for por munícipio forma título de forma diferente
							text = lang_mng.getString("seletor_filtrar_udh_por_municipios");
						else
							text = lang_mng.getString("seletor_filtrar_por") + selector.nameSingleFilter;
						$accordion.find('.templateBody').find('.accordion-heading a').text(text).attr('data-id',selector.id);
						$accordion.find('.templateBody').find('.accordion-inner').html(getListItens(data,data.type));
					}
					else{
						/*$newPanel = $template.clone();
						var text = "";
						
						if(selector.id == 3)
							text = lang_mng.getString("seletor_filtrar_regionais_por_municipios");							
						else
							text = lang_mng.getString("seletor_filtrar_por") +  selector.nameSingleFilter;							
						$newPanel.find('.collapse').removeClass('in');
						$newPanel.find(".accordion-heading a").attr("href",  "#" + i).text(text).attr('data-id',selector.id).addClass('collapsed').addClass("fs-find-data-filter");
						$newPanel.attr("data-toggle","tooltip").attr("data-original-title",lang_mng.getString("seletor_mostrar_lista"));
		           		$newPanel.find(".accordion-body").attr("id", i);
			            $newPanel.find('.accordion-inner').html('Carregando...');
			            $accordion.append($newPanel);*/
					}
				});					
			} 
			else{	
				var selector = getSelectorById(data.idSelector);
				data.idItensSelector = selector.id;
				$accordion.find('.templateBody').find('.accordion-heading').css("display","none");
				$accordion.find('.templateBody').find('.accordion-heading a').text(selector.name).attr('data-id',selector.id);
				$accordion.find('.templateBody').find('.accordion-inner').html(getListItens(data,data.type));
			}	
			
			return $accordion.css("clear","both");
		};
		
		var isCheckedBoxAllItens = function(checkBox,idParent){
			var retorno = false;
			$.each(_arraySelecionados,function(i,item){
				if(item.hasOwnProperty("selecteds")){
					var selecteds = item.selecteds;
					$.each(selecteds,function(i,item){
						if(item.idFilter == checkBox.find("input").attr("data-id") && item.idItemSelector == checkBox.find("input").attr("data-id-item-selector") && item.idParent == idParent){
							retorno = true;
						}
					});
				}
			});
			return retorno;
		};
		
		//Monta nome internacionalizado do checkbox de seleção de todos os itens de determinado filtro
		var getNameAllItens = function(array){
			var retorno = "";
			var tamanhoArray = array.length;
			$.each(array,function(i,item){
				if((i + 1) == tamanhoArray){
					if(lang_mng.getString(item) === undefined)
						retorno += item;
					else
						retorno += lang_mng.getString(item);
				}
				else{
					if(lang_mng.getString(item) == "undefined")
						retorno += item + " - ";
					else
						retorno += lang_mng.getString(item) + " - ";
				}
					
			});
			var divTextCheck = $("<div>").addClass("text-all-itens").html(retorno);
			return divTextCheck;
		};

		var constructCheckBoxes = function(obj){ //irá receber um array com os objetos para montar os checkbox
			if($.isArray(obj.allItens[0])){
				var div = $("<div>").addClass("checkbox-group-all");
				$.each(obj.allItens,function(i,item){
					var checkbox = $('<div>').addClass('checkbox').append($('<label>').addClass('checkbox-inline').append($('<input>').attr('type','checkbox').attr('class','selected-all').attr("data-toggle","tooltip").attr("data-original-title",lang_mng.getString("seletor_todos_itens_lista")).attr('data-id',obj.idFilter).attr("data-id-entity",obj.idsAllItens[i]).attr("data-id-item-selector",obj.idItemSelector)).append(getNameAllItens(item)));
					div.append(checkbox.css("float","left"));
				});
				return div;
			}	
			else{
				return $('<div>').addClass('checkbox').append($('<label>').addClass('checkbox-inline').append($('<input>').attr('type','checkbox').attr('class','selected-all').attr("data-toggle","tooltip").attr("data-original-title",lang_mng.getString("seletor_todos_itens_lista")).attr('data-id',obj.idFilter).attr("data-id-item-selector",obj.idItemSelector)).append(getNameAllItens(obj.allItens)));
			}			
		};
		
		var plotResultFilterSearch = function(obj,selectorParent){
			cleanModalBody();					
			if(obj.status == false){
				alert("Error! Contate a administração do sistema."); //ver como é demonstrado as mensagens de error padrão ou plotar no modal-content o erro.
				return;
			}
			var $accordion = constructAccordion(selectorParent.filters,obj.data);		
			var checkBox = constructCheckBoxes(obj.data);
			/*var checkBox = $('<div>').addClass('checkbox').append($('<label>').addClass('checkbox-inline').append($('<input>').attr('type','checkbox').attr('class','selected-all').attr("data-toggle","tooltip").attr("data-original-title",lang_mng.getString("seletor_todos_itens_lista")).attr('data-id',obj.data.idFilter).attr("data-id-item-selector",obj.data.idItemSelector)).append(getNameAllItens(obj.data.allItens)));*/
			var isCheckBoxChecked = isCheckedBoxAllItens(checkBox,selectorParent.id);
			var divUndo = $('<div>').addClass('undo-fs-filter').attr("data-toggle","tooltip").attr("data-original-title",lang_mng.getString("seletor_voltar"));
			var divTitleFilter = $('<div>').addClass('title-fs-filter').attr('data-id',selectorParent.id).html($("<div>").addClass("text-filter-title").append('<strong>'+lang_mng.getString(obj.data.title)+'</strong>')).prepend(divUndo);
			$('.fs .selectors').html(divTitleFilter).append(checkBox).append($accordion);
			if(isCheckBoxChecked == true){
				checkBox.find("input").attr("checked",true);
				setAllItensDeselect(".fs .selected-all");
			}
			$(".undo-fs-filter").tooltip();
			$(".selected-all").tooltip();
			$(".accordion-group").tooltip();
		};
		
		var getTemplateAccordion = function(){
			accordion = "";
			$.ajax({
				url : "system/modules/seletor-espacialidade/view/accordion.html",
				async : false				
			}).done(function(data){
				accordion = $(data);		
			});
			return accordion;
		};
		
		var callbackText = function(ret){ // deixar mais genérico v. 2.0			
			var textLength = $(".input-fs-search").val().length; 
			if(textLength <= defaults.minCharTableSearch){
				plotSelectors(defaults.data.selectors);
			}
			else{
				var retJson = $.parseJSON(ret);
				arrayStep = [];
				//TODO tratar índice status, verificar se existe ou não
				if(retJson.hasOwnProperty("status") && retJson.status === true){
					plotResultSearchText(retJson.data);	
				}
				else{
					plotSelectors(defaults.data.selectors);
					throw new Error('Objeto retornado do server deve ter um índice "status" contento true caso a operação seja um sucesso ou false caso contrário.');
				}
			}
		};	
		
		var callbackFilter = function(ret){
			var ret = $.parseJSON(ret);						
			var selector = getSelectorById(ret.data.idSelectorParent);
			plotResultFilterSearch(ret,selector);
		};
		
		var callbackNextStep = function(ret){
			var retorno = $.parseJSON(ret);
			var selector = getSelectorById(ret.data.idSelector);
			selector.filter = [];
			plotResultFilterSearch(retorno,selector);
		};
		
		var getSelectedItens = function(){
			return _arraySelecionados;
		};

		//"construtor"
		(function init(){
			plotSelectors(defaults.data.selectors);			
			actions();
		})();
		
		//métodos públicos
		return{
			selectedItensIsEmpty : selectedsIsEmpty, 
			arrayStep : arrayStep,
			getSelectedItens : getSelectedItens,
			plotSelectors : plotSelectors
		};
	};
})(jQuery);

//Verifica se o jQuery fo iniciado
if("undefined"==typeof jQuery)throw new Error("Bootstrap's JavaScript requires jQuery");
/**
 * Namespace global do projeto AtlasBrasil
 * @namespace AtlasBrasil
 */
var AtlasBrasil = AtlasBrasil || {};

/**
 * Método que dispara mensagens. (AtlasBrasil.messages).
 * @function messages
 * @memberof AtlasBrasil
 *
 * Esse método é responsável por gerenciar e padronizar as mensagens.
 *
 * @param {{ renderTo: String, display: String, classes: String }} options
  */
(function($){ //Módulo de mensagens
	"use strict";

	var manageAlerts = function(configs){
		//aplica alerta
		$(configs.renderTo).css("height","auto");
		if(configs.title != false)
			$(configs.renderTo).find(".alert-header").html(configs.title);
		else
			$(configs.renderTo).find(".alert-header").html("");
		$(configs.renderTo).find(".alert-body").html(configs.body);

		$(configs.renderTo).addClass(configs.classes);
		$(configs.renderTo).show();

		$(configs.renderTo).find(".close").off();
	};

	var manageModal = function(configs){
		//aplica modal
		
		//Por default não tem header nem footer, é só uma mensagem
		$(configs.renderTo).css("width",configs.width);
		$(configs.renderTo).css("left",configs.left);
		$(configs.renderTo).css("top",configs.top);
		$(configs.renderTo).find(".modal-body").css("height",configs.height);

		$(configs.renderTo).find(".modal-header").hide();
		$(configs.renderTo).find(".modal-text-footer").hide();
		if(configs.title){
			$(configs.renderTo).find(".modal-header").html(configs.title);
			$(configs.renderTo).find(".modal-header").show()
		}
		$(configs.renderTo).find(".modal-buttons-footer").html("");
		if(configs.options.buttons){
			$(configs.renderTo).find(".modal-body").html(configs.body);
			var buttons = Array();
			$.each(configs.options.buttons,function(i,item){
				var button = $("<button>");
				$.each(item,function(j,val){
					if(j == "text"){
						button.html(val);
						return true;
					}
					button.attr(j,val);
				});
				$(configs.renderTo).find(".modal-buttons-footer").append(button);
			});
		}

		$(configs.renderTo).modal(configs.optionsModal);
	};

	AtlasBrasil.messages = function(options){
		var defaults = {
			renderTo : ".general-alert",
			display : "alert",//alert ou modal
			classes : "", // error, success, info, default
			title: false,
			footer : false, //propriedade pro modal por enquanto. Array de buttons
			body : "",
			width : "250px",
			height : "60px",
			left : "62%",
			top : "50%",
			options : {
				buttons : [
					/*{"class" : "btn", "data-dismiss": "modal", "aria-hidden" : "true","text" : "Fechar"},*/
					{"class" : "btn btn-primary","data-dismiss" : "modal", "aria-hidden" : "true","text" : "Ok"}
				],
				//se for alerta, configs do alerta, se for modal ...
			},
		};
		var configs = $.extend(true,{},defaults,options);

		if(configs.body === ""){
			console.error("Entre com o body da sua mensagem.");
			return false;
		}

		if(configs.display === "alert")
			manageAlerts(configs);
		else
			manageModal(configs);
	};

	AtlasBrasil.number_format = function ( numero, decimal, decimal_separador, milhar_separador ){
    numero = (numero + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+numero) ? 0 : +numero,
        prec = !isFinite(+decimal) ? 0 : Math.abs(decimal),
        sep = (typeof milhar_separador === 'undefined') ? ',' : milhar_separador,
        dec = (typeof decimal_separador === 'undefined') ? '.' : decimal_separador,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix para IE: parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
 
    return s.join(dec);
};

AtlasBrasil.loading = {
	show : function(options) {
		var defaults = {
			renderTo : ".general-alert",
			imgSrc : "assets/img/icons/ajax-loader.gif"
		};
		var configs = $.extend(true,{},defaults,options);

		var img = $('<img>').addClass('loading-default').attr('src', configs.imgSrc);
		$(configs.renderTo).html(img);
	},

	remove : function() {
		$('.loading-default').remove();
	},
};



})(jQuery);
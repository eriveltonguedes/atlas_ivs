/**
 * Componente com a intenção de cobrir todas as buscas do atlas e suas possíveis peculiaridades.
 */

function SearchComponent() {
    var ajaxSearch = function(data, options, callback) {
        $.post(options.url, {data: JSON.stringify(data)}, callback);
    };

    var callbackExemplo = function(ret) {
        console.log("DEFINA UM CALLBACK PARA SUA BUSCA, É OBRIGATÓRIO");
    };

    var getRm = function(options) {
        var defaults = {
            attr: ["id", "nome"], //array de atributos da busca na tabela rm
            longName: false, //definir se é pra retornar o nome longo ou curto da rm se false ou não definido pega nome curto
            lang: "pt-br", //definir linguagem que será retornado o resultado (pt-br,en,esp), se não definido retorna de acordo com a linguagem da seção
            ativo: true, //se true retorna somente rm's ativa, se false retornar rm's inativa, se não definido retorna todas as rm's
            url: "system/modules/perfil/componentes/seletor-perfil/controller/SearchEntities.controller.php", // url do componente de busca
            callback: callbackExemplo
        };
        $.extend(true, defaults, options);
        var data = {};
        data.options = defaults;
        data.method = "getRm";
        ajaxSearch(data, defaults, defaults.callback);
    };

    var textSearch = function(string, callback, options) {
        var defaults = {};
        defaults.url = "";
        $.extend(true, defaults, options);
        var data = {};
        data.options = string;
        data.method = "textSearch";
        ajaxSearch(data, defaults, callback);
    };

    var filterSearch = function(paramsServer, callback, options) {
        var defaults = {};
        defaults.url = "";
        $.extend(true, defaults, options);
        var data = {};
        data.options = paramsServer;
        data.method = "filterSearch";
        ajaxSearch(data, defaults, callback);
    };

    return{
        getRm: getRm,
        ajax: ajaxSearch,
        textSearch: textSearch,
        filterSearch: filterSearch
    };
}
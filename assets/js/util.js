/**
 * Converte espacialidade para o id específico.
 * 
 * @param string
 * @returns {Number}
 */
function converterEspacialidadeParaId(espacialidade) {
    switch (espacialidade) {
        case 'municipal':
            return 2;
        case 'regioal':
            return 3;
        case 'estadual':
            return 4;
        case 'udh':
            return 5;
        case 'regiaometropolitana':
            return 6;
        case 'regiaointeresse':
            return 7;
        case 'mesorregiao':
            return 8;
        case 'microrregiao':
            return 9;
        case 'pais':
            return 10;
    }
}

/**
 * Recupera valor da URL.
 * 
 * @param url
 * @param campo
 * @returns
 */
function getValorUrl(url, campo) {
    // getValorUrl(UrlController.getUrl('tabela'),"regiao");
    var explode = url.split("/");
    var k = explode.indexOf(campo);
    if (k === -1) {
        return null;
    } else if (typeof (explode[k + 1]) === "undefined") {
        return null;
    } else {
        return (explode[k + 1]);
    }
}

/**
 * Adiciona valor na URL.
 * 
 * @param suaUrl
 * @param campo
 * @param valor
 * @returns
 */
function addValorUrl(suaUrl, campo, valor) {
    // UrlController.setUrl('tabela',addValorUrl(UrlController.getUrl('tabela'),
    // "indicador","idhm-3000"));
    var explode = suaUrl.split("/");
    var k = explode.indexOf(campo);

    if (k === -1) {
        return null;
    } else if (typeof (explode[k + 1]) === "undefined") {
        return null;
    } else {
        var campos = new Array();
        campos = explode[k + 1].split(',');
        if (true) {
            if (campos[0] === "")
                campos = valor;
            else {
                campos.push(valor);
                campos = campos.join(',');
            }
            explode[k + 1] = campos;
            explode = explode.join("/");
        } else {
            return explode.join("/");
        }
        return explode;
    }
}

/**
 * Muda valor da URL.
 * 
 * @param suaUrl
 * @param campo
 * @param valor
 * @returns
 */
function setarValorUrl(suaUrl, campo, valor) {
    var explode = suaUrl.split("/");
    var k = explode.indexOf(campo);

    if (k === -1) {
        return null;
    } else if (typeof (explode[k + 1]) === "undefined") {
        return null;
    } else {
        explode[k + 1] = valor;
        return explode.join("/");
    }
}

/**
 * Converte o id da espacialidade para string da URL específica.
 * 
 * @param id
 * @returns {String}
 */
function converterEspacialidadeParaString(id) {
    switch (id) {
        case 2:
            return 'municipal';
        case 3:
            return "regional";
        case 4:
            return 'estadual';
        case 5:
            return 'udh';
        case 6:
            return 'regiaometropolitana';
        case 7:
            return 'regiaointeresse';
        case 8:
            return 'mesorregiao';
        case 9:
            return 'microrregiao';
        case 10:
            return 'pais';
    }
}

/**
 * Converte para espacialidade (texto).
 * 
 * @param id
 * @returns {String}
 */
function converterEspacialidadeParaStringExtenso(id) {
    id = parseInt(id, 10);

    switch (id) {
        case 2:
            return 'Município';
        case 3:
            return "Região";
        case 4:
            return 'Estado';
        case 5:
            return 'UDH';
        case 6:
            return 'Região Metropolitana';
        case 7:
            return 'Região de Interesse';
        case 8:
            return 'Mesorregião';
        case 9:
            return 'Microrregião';
        case 10:
            return 'País';
    }
}

/**
 * Converte para contexto (texto).
 * 
 * @param id
 * @returns {String}
 */
function converterContextoParaStringExtenso(id) {
    id = parseInt(id, 10);

    switch (id) {
        case 2:
            return 'Municípios';
        case 3:
            return "Regiões";
        case 4:
            return 'Estados';
        case 5:
            return 'UDHs';
        case 6:
            return 'Regiões Metropolitanas';
        case 7:
            return 'Regiões de Interesse';
        case 8:
            return 'Mesorregiões';
        case 9:
            return 'Microrregiões';
        case 10:
            return 'Brasil';
    }
}

/**
 * Recupera espacialidade da URL.
 * 
 * @param url
 * @returns {Number}
 */
function getEspaciliadadeUrl(url) {
    if (url.indexOf("municipal") >= 0)
        return 2;
    else if (url.indexOf('regional') >= 0)
        return 3;
    else if (url.indexOf('estadual') >= 0)
        return 4;
    else if (url.indexOf('udh') >= 0)
        return 5;
    else if (url.indexOf('regiaometropolitana') >= 0)
        return 6;
    else if (url.indexOf('regiaointeresse') >= 0)
        return 7;
    else if (url.indexOf('mesorregiao') >= 0)
        return 8;
    else if (url.indexOf('microrregiao') >= 0)
        return 9;
    else if (url.indexOf('pais') >= 0)
        return 10;
}

/**
 * Change Espacializacao.
 * 
 * @param url
 * @param newEspacializacao
 * @returns
 */
function changeEspacializacao(url, newEspacializacao) {
    var exp = url.split("/");
    var x = 0;

    if (exp.indexOf("municipal") >= 0)
        x = exp.indexOf("municipal");
    else if (exp.indexOf('regioal') >= 0)
        x = exp.indexOf("regioal");
    else if (exp.indexOf('estadual') >= 0)
        x = exp.indexOf("estadual");
    else if (exp.indexOf('udh') >= 0)
        x = exp.indexOf("udh");
    else if (exp.indexOf('regiaometropolitana') >= 0)
        x = exp.indexOf("regiaometropolitana");
    else if (exp.indexOf('regiaointeresse') >= 0)
        x = exp.indexOf("regiaointeresse");
    else if (exp.indexOf('mesorregiao') >= 0)
        x = exp.indexOf("mesorregiao");
    else if (exp.indexOf('microrregiao') >= 0)
        x = exp.indexOf("microrregiao");
    else if (exp.indexOf('pais') >= 0)
        x = exp.indexOf("pais");
    exp[x] = converterEspacialidadeParaString(parseInt(newEspacializacao));
    return exp.join('/');
}


/**
 * Retira caracteres com acento para valores correspondentes em ASCII.
 * 
 * @param palavra
 * @returns {String}
 */
function retira_acentos_old(palavra) {
    com_acento = 'áàãâäéèêëíìîïóòõôöúùûüçÁÀÃÂÄÉÈÊËÍÌÎÏÓÒÕÖÔÚÙÛÜÇ';
    sem_acento = 'aaaaaeeeeiiiiooooouuuucAAAAAEEEEIIIIOOOOOUUUUC';
    nova = '';
    intI = palavra.length;
    intI--;
    do {
        if (com_acento.search(palavra.substr(intI, 1)) >= 0) {
            nova = sem_acento.substr(
                    com_acento.search(palavra.substr(intI, 1)), 1)
                    + nova;
        } else {
            nova = palavra.substr(intI, 1) + nova;
        }
    } while (intI--);
    return nova;
}

/**
 * Retira acentos.
 * 
 * @param {string} strToReplace
 * @returns {string}
 */
function retira_acentos(strToReplace) {
    var str_acento = 'áàãâäéèêëíìîïóòõôöúùûüçÁÀÃÂÄÉÈÊËÍÌÎÏÓÒÕÖÔÚÙÛÜÇ';
    var str_sem_acento = 'aaaaaeeeeiiiiooooouuuucAAAAAEEEEIIIIOOOOOUUUUC';
    var nova = '';
    for (var i = 0; i < strToReplace.length; i++) {
        if (str_acento.indexOf(strToReplace.charAt(i)) !== -1) {
            nova += str_sem_acento.substr(str_acento.search(strToReplace.substr(i, 1)), 1);
        } else {
            nova += strToReplace.substr(i, 1);
        }
    }
    return nova;
}

/**
 * Regex acentos.
 * 
 * @param {string} str
 * @returns {string}
 */
function str_regex_acentos(str) {
    var dic = {
        'a': 'áàãâä', 'e': 'éèêë', 'i': 'íìîï', 'o': 'óòõôö', 'u': 'úùûü', 'c': 'ç',
        'A': 'ÁÀÃÂÄ', 'E': 'ÉÈÊË', 'I': 'ÍÌÎÏ', 'O': 'ÓÒÕÔÖ', 'U': 'ÚÙÛÜ', 'C': 'Ç'
    };

    return str.replace(/[aeioucAEIOUC]/g, function (val, pos) {
        return '[' + val + dic[val] + ']';
    });
}

/**
 * Prepara URL.
 * 
 * @param {string} palavra
 * @returns {string}
 */
function prepara_url(palavra) {
    return retira_acentos(palavra).replace("\'", '');
}

/**
 * Converte o label do ano para seu id específico.
 * 
 * @param anoLabel
 * @returns {Number}
 */
function convertAno(anoLabel) {
    switch (anoLabel) {
        case 1991:
            return 1;
        case 2000:
            return 2;
        case 2010:
            return 3;
        case '1991':
            return 1;
        case '2000':
            return 2;
        case '2010':
            return 3;
    }
}

/**
 * Converte ano ID para label.
 * 
 * @param {number} anoLabel
 * @returns {number}
 */
function convertAnoIDtoLabel(anoLabel) {
    switch (anoLabel) {
        case 1:
            return 1991;
        case 2:
            return 2000;
        case 3:
            return 2010;
    }
}

/**
 * Sleep.
 * 
 * @param {number} ms
 */
function sleep(ms) {
    var dt = new Date();
    dt.setTime(dt.getTime() + ms);
    while (new Date().getTime() < dt.getTime())
        ;
}

/**
 * Replace all chars.
 * 
 * @param {string} find
 * @param {string} replace
 * @param {string} text
 * @return {string}
 */
function replaceAllChars(find, replace, text) {
    try {
        while (text.indexOf(find) !== -1) {
            text = text.replace(find, replace);
        }
        return text;
    } catch (e) {
        return null;
    }
}

/**
 * Add Log Erro.
 * 
 * @param file
 * @param linha_inicial
 * @param linha_final
 * @param e
 */
function addLogErro(file, linha_inicial, linha_final, e) {
    $.ajax({
        type: 'post',
        url: 'system/modules/tabela/util/AjaxLogErro.php',
        data: {
            'file': file,
            'linha_inicial': linha_inicial,
            'linha_final': linha_final,
            'e': e,
            'navegador': "n=" + navigator.appName + " v="
                    + navigator.appVersion
        }
    });
}

/**
 * Export Geral.
 */
function exportGeral() {
    var L = JSON.stringify(geral.getLugares());
    L[0] = "";
    L[L.length - 1] = "";

    var I = JSON.stringify(geral.getIndicadores());
    I[0] = "";
    I[I.length - 1] = "";

    $("body").html("[" + L + "," + I + "]");

}


/**
 * Retira espaço em branco no início e fim da string.
 * 
 * @param str
 * @returns {String}
 */
function trim(str) {
    return str.replace(/^\s+|\s+$/g, '');
}

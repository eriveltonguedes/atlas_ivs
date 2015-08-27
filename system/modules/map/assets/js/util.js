//see: http://stackoverflow.com/questions/6177454/can-i-force-jquery-cssbackgroundcolor-returns-on-hexadecimal-format
$.cssHooks.backgroundColor = {
    get: function (elem) {
        if (elem.currentStyle)
            var bg = elem.currentStyle["backgroundColor"];
        else if (window.getComputedStyle)
            var bg = document.defaultView.getComputedStyle(elem, null).getPropertyValue("background-color");
        if (parseInt(bg.search("rgb"), 10) === -1)
            return bg;
        else {
            bg = bg.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
            function hex(x) {
                return ("0" + parseInt(x).toString(16)).slice(-2);
            }
            return "#" + hex(bg[1]) + hex(bg[2]) + hex(bg[3]);
        }
    }
};

/**
 * @see http://www.sitepoint.com/javascript-generate-lighter-darker-color/
 * @param {string} hex
 * @param {number} lum
 * @returns {string}
 */
function ColorLuminance(hex, lum) {

    // validate hex string
    hex = String(hex).replace(/[^0-9a-f]/gi, '');
    if (hex.length < 6) {
        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
    }
    lum = lum || 0;

    // convert to decimal and change luminosity
    var rgb = "#", c, i;
    for (i = 0; i < 3; i++) {
        c = parseInt(hex.substr(i * 2, 2), 16);
        c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
        rgb += ("00" + c).substr(c.length);
    }

    return rgb;
}

/**
 * Calc luminance.
 * 
 * @see http://stackoverflow.com/questions/1754211/evaluate-whether-a-hex-value-is-dark-or-light
 * @param {string} rgb
 * @returns {number}
 */
function calcLuminance(rgb) {
    rgb = parseInt('0x' + rgb.replace(/^\s*#|\s*$/g, ''));
    var r = (rgb & 0xff0000) >> 16;
    var g = (rgb & 0xff00) >> 8;
    var b = (rgb & 0xff);

    return (r * 0.299 + g * 0.587 + b * 0.114) / 256;
}


/**
 * @see http://stackoverflow.com/questions/6443990/javascript-calculate-brighter-colour
 * @param {string} hex
 * @param {number} percent
 * @returns {string}
 */
function increase_brightness(hex, percent) {
    // strip the leading # if it's there
    hex = hex.replace(/^\s*#|\s*$/g, '');

    // convert 3 char codes --> 6, e.g. `E0F` --> `EE00FF`
    if (hex.length === 3) {
        hex = hex.replace(/(.)/g, '$1$1');
    }

    var r = parseInt(hex.substr(0, 2), 16),
            g = parseInt(hex.substr(2, 2), 16),
            b = parseInt(hex.substr(4, 2), 16);

    return '#' +
            ((0 | (1 << 8) + r + (256 - r) * percent / 100).toString(16)).substr(1) +
            ((0 | (1 << 8) + g + (256 - g) * percent / 100).toString(16)).substr(1) +
            ((0 | (1 << 8) + b + (256 - b) * percent / 100).toString(16)).substr(1);
}


/**
 * Retorna a cor em Hex.
 * 
 * @param {string} ColorValue
 * @return {string} Hex string color value.
 */
var getHexColor = (function () {
    var elem = document.createElement('div');

    return function (colorValue) {
        elem.style.backgroundColor = colorValue;
        if (elem.currentStyle)
            var bg = elem.currentStyle["backgroundColor"];
        else if (window.getComputedStyle)
            var bg = document.defaultView.getComputedStyle(elem, null).getPropertyValue("background-color");
        if (parseInt(bg.search("rgb"), 10) === -1)
            return bg;
        else {
            bg = bg.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
            function hex(x) {
                return ("0" + parseInt(x).toString(16)).slice(-2);
            }
            return "#" + hex(bg[1]) + hex(bg[2]) + hex(bg[3]);
        }
    };
})();

/**
 * Formata valor para legenda.
 * 
 * @param {number|string} num
 * @param {boolean=} contrario
 * @returns {string}
 */
var formataValor = function (num, contrario) {
    if (contrario) {
        return ('' + num).replace(/\./g, ',');
    }
    return parseFloat(num.replace(/,/g, '.'));
};


/**
 * Verifica se arrays possuem mesmo conteúdo.
 * 
 * @param {array} a
 * @param {array} b
 * @returns {boolean}
 */
var isEqualArray = function (a, b) {
    var isIgual = true;

    if (!$.isArray(a) || !$.isArray(b)) {
        return false;
    }

    if (a.length !== b.length) {
        return false;
    }

    for (var i = 0, len = a.length; i < len; ++i) {
        for (var j in a[i]) {
            if (!b[i] || (a[i][j] !== b[i][j])) {
                isIgual = false;
                break;
            }

            if (!isIgual)
                break;
        }
    }
    return isIgual;
};

/**
 * Verifica se arrays possuem mesmo conteúdo.
 * 
 * @param {array} subArr
 * @param {array} arr
 * @returns {boolean}
 */
var containsArray = function (subArr, arr) {
    var found = false;
    for (var i = 0, j = subArr.length; !found && i < j; i++) {
        if (arr.indexOf(subArr[i]) > -1) {
            found = true;
        }
    }
    return found;
};

/**
 * Convert type.
 * 
 * @param {number|boolean|object} value
 * @returns {function}
 */
var convertType = function (value) {
    try {
        return (new Function("return " + value + ";"))();
    } catch (e) {
        return value;
    }
};


/**
 * Get nome espacialidade.
 * 
 * @param {number|string} espacialidade 
 * @return {string} Nome espacialidade internacionalizado.
 */
var getNomeEspacialidade = function (espacialidade) {
    switch (parseInt(espacialidade, 10)) {
        case ESP_CONSTANTES.estadual:
            return lang_mng.getString('mp_item_camada_estado');
        case ESP_CONSTANTES.regiaometropolitana:
            return lang_mng.getString('mp_item_camada_rm');
        case ESP_CONSTANTES.udh:
            return lang_mng.getString('mp_item_camada_udh');
        case ESP_CONSTANTES.municipal:
            return lang_mng.getString('mp_item_camada_mun');
        case ESP_CONSTANTES.regional:
            return lang_mng.getString('mp_item_camada_reg');
        case ESP_CONSTANTES.regiaodeinteresse:
            return lang_mng.getString('mp_item_camada_ri');
        default:
            return espacialidade;
    }
};

var ano;
var indicador;
var lugares;
var params;
var espacialidade;
var url;
var imprimir;
var histogram_value;
var chart_img;

function errorEspacialidadeInvalida(){
    AtlasBrasil.messages({
        display : "modal",
        renderTo : "#general-modal",
        width : "400px",
        height : "45px",
        left : "54%",
        optionsModal : {
            backdrop : 'static',
        },
        body : "<strong>O histograma só está disponível para municípios, estados e regiões metropolitanas.</strong>",
    });
};
//Módulo para organizar a geração futura do histograma. Esse módulo gerenciará todas as ações
// para a geração do histograma. Desde o click no botão até a geração do chart
var generateHistogram = (function(){
    var options = {
        idBtnToGenerate : "#imgTab3",
        numMinSpatialityToGenerate : 16,
    };

    var verifyNumMaxSpatiality = function(){

    };

    var init = function(config){
        $.extend(options, config);
        $(options.idBtnToGenerate).attr('data-original-title',lang_mng.getString('mensagem-disponibilidade-espacialidade-histograma') + lang_mng.getString('mensagem-limite-espacialidade-histograma') + options.numMinSpatialityToGenerate + ".");
    };

    var getNumMaxSpatiality = function(){
        return options.numMaxSpatialityToGenerate;
    }

    return{
        init : init,
        getNumMaxSpatiality : getNumMaxSpatiality
    }
})();

$(document).ready(function () {

    generateHistogram.init();

    $('#seletor_ano2 span').click(function () {
        // reset ano anterior
        $('#seletor_ano2 span').removeClass('ano_atual');

        // ano atual
        $(this).addClass('ano_atual');
        setDados($(this).attr('id'), lugares);
    });

    $('#fechar_histograma').click(function () {
        $('#container_histograma').hide();
        $("#container-table-component").show();
        $("#containerTabela").hide();
    });

    // fechar aviso não há indicador selecionado
    $('#aviso_sem_indicador .close').click(function () {
        $(this).parent().hide();
    });

    $('.modal-msg-histograma .btn-ok').parent().on('click','.btn-ok',function(){
        $('#container_histograma').hide();
        $("#container-table-component").show();
        $("#containerTabela").hide();
        $('.modal-msg-histograma').modal('hide');
    });

    $('#imgTab3').click(function () {

      $('#chart_div').html('');
      $('#table_div').html('');
      $('.subtitulo-histograma').remove();
        var indicadores = geral.getIndicadores();         //Pega os indicadores selecionados
        var espacialidade = seletor.getSelecteds();    //Verifica se existe espacialidade ativa
        //Se não houver nenhum indicador selecionado, mostra o aviso
        if (($.isArray(indicadores) && indicadores.length === 0) || ($.isArray(espacialidade) && espacialidade.length === 0)) {
            mostraAvisoSemIndicador();
        }
        else {
            var entidadesSelecionadas = seletor.getEntitiesSelecteds();
            var retorno = false;
            $(entidadesSelecionadas).each(function(i,item){

                if(item == 5 || item == 3){
                    retorno = true;
                    return false;
                }
            });

            if(retorno == true){
                /*errorEspacialidadeInvalida();*/
                return;
            }
            $('#imgTab3').removeClass('disabled');
            $('#container_espacialidade_histograma').show(); //Mostra a seleção da espacialidade que irá aparecer no histograma
            $('#container_indicador_histograma').hide();    //Oculta a caixa de seleção do indicador

            $('#modalLabelHist').text(lang_mng.getString('histograma_qualEspacialidade'));

            var numItens = 0, itemIdAtual;
            $(seletor.getSelectedsItens()).each(function (i, item) {
                if (typeof item.l !== 'undefined'
                    && ($.isArray(item.l) && item.l.length > 0)
                    || ($.isArray(item.est) && item.est.length > 0)
                    || ($.isArray(item.mun) && item.mun.length > 0)
                    || ($.isArray(item.udh) && item.udh.length > 0)
                    || ($.isArray(item.rm) && item.rm.length > 0)
                    ) {
                    $("#lista_espacialidade_histograma li[data-id='" + item.e + "']").css('display', 'block');
                numItens++;
                itemIdAtual = item.e;
            }
            else {
                $("#lista_espacialidade_histograma li[data-id='" + item.e + "']").css('display', 'none');
            }
        });

            // se houver somente uma espacialidade, seleciona automaticamente
            if (numItens === 1) {
                $("#lista_espacialidade_histograma li[data-id=" + itemIdAtual + "]").trigger('click');

                // se houver uma espacialidade e vários indicadores 
                // escolher um dos indicadores
                if ($.isArray(indicadores) && indicadores.length > 1) {
                    $('#modalHist').modal('show');
                }
            }
            else {
                $('#modalHist').modal('show');
            }
        }
    });

    // lista de espacialidades em que será escolhido 
    // para ser mostrar no mapa personalizado
    $("#lista_espacialidade_histograma").delegate('li', 'click', function () {
        var indicadorAtual, indicadores_,
        histogramaAnoId = ['1991', '2000', '2010'],
        this_ = $(this),
        lista_indicador_ = $('#lista_indicador_histograma'),
        histograma = $('#iframe_histograma');

        // remove listagem anterior
        lista_indicador_.find("li").remove();

        // cria nova listagem
        indicadores_ = geral.getIndicadores();
        $(indicadores_).each(function (i, item) {
            lista_indicador_.append('<li data-id="' + item['id'] + '" data-ano-id="' + item['a'] + '"><span class="nome">' + item['nc'] + '</span> (' + histogramaAnoId[(item['a'] - 1)] + ')</li>');
        });

        // espacialidade global
        histograma
        .data('nome_espacialidade', this_.text())
        .data('espacialidade_sel', this_.attr('data-id'));

        // testa se há somente um indicador, escolhe automaticamente
        if (indicadores.length === 1) {
            indicadorAtual = indicadores[0];
            $("#container-table-component").hide();
            $("#containerTabela").show();
            $('#modalHist').modal('hide');

            // valores do indicador atual 
            // para mostrar no título do mapa
            histograma
            .data('nome_indicador', indicadorAtual['desc'])
            .data('indicador_sel', indicadorAtual['id'])
            .data('ano_sel', indicadorAtual['a']);

            //Exibe o Histograma
            setDados($('#iframe_histograma').data('ano_sel'));
//            showHistograma();
} else {
    $('#container_espacialidade_histograma').hide();
    $('#container_indicador_histograma').show();
    $('#modalLabelHist').text(lang_mng.getString('histograma_qualIndicador'));
}
});

$("#lista_indicador_histograma").delegate('li', 'click', function () {
    var $this = $(this);

    $('#modalHist').modal('hide');
    $("#container-table-component").hide();
    $("#containerTabela").show();
        // seta novos valores atuais para mapa personalizado
        $('#iframe_histograma')
        .data('nome_indicador', $this.find('.nome').text())
        .data('indicador_sel', $this.attr('data-id'))
        .data('ano_sel', $this.attr('data-ano-id'));
        setDados($('#iframe_histograma').data('ano_sel'));
//        showHistograma();
});

});

function setDados(idAno) {
    ano = idAno;
    indicador = $('#iframe_histograma').data('indicador_sel');
    espacialidade = $('#iframe_histograma').data('espacialidade_sel');
    
//    params = {
//        id: testaEspacialidadeSeExiste(espacialidade),
//        est: recuperaEspacialidadeSeExisteDeAcordoTipo('est', espacialidade),
//        rm: recuperaEspacialidadeSeExisteDeAcordoTipo('rm', espacialidade),
//        udh: recuperaEspacialidadeSeExisteDeAcordoTipo('udh', espacialidade),
//        mun: recuperaEspacialidadeSeExisteDeAcordoTipo('mun', espacialidade)
//    }

params = {
    id  : getEspacialidade(espacialidade),
    est : getEspacialidadeDeTipo('est', espacialidade),
    rm  : getEspacialidadeDeTipo('rm', espacialidade),
    udh : getEspacialidadeDeTipo('udh', espacialidade),
    mun : getEspacialidadeDeTipo('mun', espacialidade)
};

showHistograma();
}

//function imprimirHistograma(){
//    url = path_dir+lang+'/histograma_print'+
//    window.open(print_url, '_blank');
//    showHistograma();
//}    

function showHistograma() {
    var dataHistograma = new Object();
    var espacialidadeSel;
    var histograma = $('#iframe_histograma');
    $('#titulo_histograma .histograma').html('');
    
    espacialidadeSel = histograma.data('espacialidade_sel');

    //Título do Histograma
    $('#titulo_histograma .histograma').html(lang_mng.getString('histograma_titulo') + ' / ' + histograma.data('nome_espacialidade') + '<br />' + histograma.data('nome_indicador'));
    $('#titulo_histograma .histograma').show();
    $('#titulo_histograma .subtitulo-histograma').show();
    //Mostra o Histograma
    $("#container-table-component").hide();
    $("#containerTabela").show();
    $('#container_histograma').show();
    loadingHolder.show(lang_mng.getString("carregando"));
    $.ajax({
        type: "POST",
        url: "system/modules/histogram/controller/histogramService.php",
        data: {
            'espacialidade': espacialidade,
            'indicador': indicador,
            'lugares': params,
            'ano': ano
        },
        success: histogram_response
    });
}

// *********************************************
// Replace All
// *********************************************
function replaceAll(str, de, para) {
    var pos = str.indexOf(de);
    while (pos > -1) {
        str = str.replace(de, para);
        pos = str.indexOf(de);
    }
    return (str);
}



function histogram_response(data, textStatus, jqXHR) {

    if (textStatus === "success")
    {
        /*$('#iframe_histograma').html('');*/
        var obj = $.parseJSON(data);
        $('#fechar_histograma').show();
        console.log(obj);
        if(obj.hasOwnProperty('status') && obj.status == false){
            $('#fechar_histograma').hide();
            $('#titulo_histograma .histograma').hide();
            $('#titulo_histograma .subtitulo-histograma').hide();
            $('.modal-msg-histograma .modal-body').html(lang_mng.getString(obj.msg) + obj.data);
            $('.modal-msg-histograma').modal({backdrop: 'static'});
            loadingHolder.dispose();
            return;
        }

        histogram_value = obj;
        visualization();
        drawTable();
        loadingHolder.dispose();
    }
    else
    {
        alert("Erro ao executar consulta!");
    }
}

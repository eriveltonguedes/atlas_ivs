<?php
require_once "../config/config_path.php";
echo 'bolha';
?>
<script src="com/mobiliti/grafico/bolhas/grafico-dispersao.builder2.js"></script>
<script type="text/javascript">
    /*****************************
     script: ui.grafico.dispersao2.php
     author: Elaine Soares Moreira
     *****************************/
    var bolha_indc_selector = new Array();
    var indicadorLocal = new Array();

    var local;
    var bolha_indc;

    var bolha_a = 3;
    var ___first_time_year_ = true;
    var bolha_e = null;
    var bolha_l = null;
//    var bolha_i = null;
    var bolha_i = new Array();
    var bolha_i_name = new Array();
    var obj;
    var eixoy = new Array();
    var eixox = new Array();
    var eixotam = new Array();
    var eixocor = new Array();
    var eixo;
    var _indicadores;
    var _locais;
    var bolha;

    $(document).ready(function()
    {
        $('#disp_m_ano').html(lang_mng.getString("mapa_ano").toUpperCase());

        $('#local_box2').load('./com/mobiliti/componentes/local/local_graf.html', function()
        {
//            console.log('local_box2');
            local_ = new SeletorLocalG();
            local_.startLocal(listenerLocalGrafBolha, "local_box2", false);
            bolha_indc = new LocalSelectorG();
            local_.setButton(bolha_indc.html('uibolhalocal_selector'))
            bolha_indc.startSelector(true, "uibolhalocal_selector", bolha_indcator_selector_bolha, "right", "bolhaEditIndicador", true);
        });
        $('#box_indicador_eixoX').load('../com/mobiliti/componentes/local_indicador/indicador3.html', function()
        {
//            console.log('box_indicador_eixoX');
            indicadorLocal[1] = new SeletorIndicadorG();
            indicadorLocal[1].startLocal(listenerLocalIndicadoresBolha, "box_indicador_eixoX", false, 'x');
            try {
                bolha_indc_selector[1] = new IndicatorSelectorG();
                indicadorLocal[1].setButton(bolha_indc_selector[1].html('bolhaEditIndicadorx', 'X'));
                bolha_indc_selector[1].startSelector(false, "bolhaEditIndicadorx", seletor_indicador_, "right", false, "uibolhalocal_selector", true, 'x');
            } catch (e) {
////                //erro
            }
        });
        $('#box_indicador_eixoY').load('../com/mobiliti/componentes/local_indicador/indicador2.html', function()
        {
//            console.log('box_indicador_eixoY');
            indicadorLocal[0] = new SeletorIndicadorG();
            indicadorLocal[0].startLocal(listenerLocalIndicadoresBolha, "box_indicador_eixoY", false, 'y');
            try {
                bolha_indc_selector[0] = new IndicatorSelectorG();
                indicadorLocal[0].setButton(bolha_indc_selector[0].html('bolhaEditIndicadory', 'Y'));
                bolha_indc_selector[0].startSelector(false, "bolhaEditIndicadory", seletor_indicador_, "right", false, "uibolhalocal_selector", true, 'y');
            } catch (e) {
////                //erro
            }
        });
        $('#box_indicador_Cor').load('../com/mobiliti/componentes/local_indicador/indicador5.html', function()
        {
//            console.log('box_indicador_Cor');
            indicadorLocal[3] = new SeletorIndicadorG();
            indicadorLocal[3].startLocal(listenerLocalIndicadoresBolha, "box_indicador_Cor", false, 'cor');
            try {
                bolha_indc_selector[3] = new IndicatorSelectorG();
                indicadorLocal[3].setButton(bolha_indc_selector[3].html('bolhaEditIndicadorcor', '<img style="heigth: 14px; width: 66px;" src="assets/img/icons/gradiente.png" />'));
                bolha_indc_selector[3].startSelector(false, "bolhaEditIndicadorcor", seletor_indicador_, "right", false, "uibolhalocal_selector", true, 'cor');
            } catch (e) {
////                //erro
            }
        });
        $('#box_indicador_Tamanho').load('../com/mobiliti/componentes/local_indicador/indicador4.html', function()
        {
//            console.log('box_indicador_Tamanho');
            indicadorLocal[2] = new SeletorIndicadorG();
            indicadorLocal[2].startLocal(listenerLocalIndicadoresBolha, "box_indicador_Tamanho", false, 'tam');
            try {
                bolha_indc_selector[2] = new IndicatorSelectorG();
                indicadorLocal[2].setButton(bolha_indc_selector[2].html('bolhaEditIndicadortam', '<img src="assets/img/icons/size.png" />'));
                bolha_indc_selector[2].startSelector(false, "bolhaEditIndicadortam", seletor_indicador_, "right", false, "uibolhalocal_selector", true, 'tam');
            } catch (e) {
////                //erro
            }
        });

        bolha_init();
    });

    function bolha_init() {
//        console.log('bolha_init');
        $('.nav-tabs').button();
        $("#bolha_year_slider").bind("slider:changed", bolha_year_slider_listener);

        bolha_loading(false);
    }
//    
    function bolha_year_slider_listener(event, data) {
//        console.log('bolha_year_slider_listener');
        if (___first_time_year_)
        {
            ___first_time_year_ = false;
            return;
        }

        if (data.value === 1991)
            bolha_a = 1;
        else if (data.value === 2000)
            bolha_a = 2;
        else if (data.value === 2010)
            bolha_a = 3;
        //-----------------------------------
        // Muda todos os anos dos indicadores
        //-----------------------------------
        _indicadores = geral.getIndicadores();
        for (var i = 0; i < _indicadores.length; i++) {
            geral.updateIndicador(i, bolha_a);
        }
        bolha_load(bolha_e, bolha_l, bolha_i, bolha_a);
    }

    function bolha_loading(status)
    {
//        console.log('bolha_loading');
        if (status)
            $("#uibolhaloader").show();
        else
            $("#uibolhaloader").hide();
    }

    function bolha_load(e, l, i, a)
    {
//        console.log('bolha_load');

        bolha_loading(false);

        var bolha_data = new Object();

        //define os ids
        bolha_data['e'] = e; // espacialidade
//        console.log('l.length: '+l.length);
        if (l.length){
            bolha_data['l'] = l.toString(); // array de locais em modo texto     
        }
        else{
            bolha_data['l'] = new Array(0);
//            console.log('bolha_data[l]: '+bolha_data['l']);
        }
        bolha_data['i'] = i.toString(); // indicador
        bolha_data['a'] = a; // ano

        bolha_e = e;
        bolha_l = l;
        bolha_i = i;
        bolha_a = a;
//        console.log(bolha_l[0]);
//        if(bolha_l[0] == undefined){
//            console.log('entrei');
//            bolha_l[0] = 0;
//        }
        $.ajax({
            type: "POST",
            url: "<?php echo $path_dir ?>com/mobiliti/grafico/bolhas/grafico-dispersao.controller.php",
            data: bolha_data,
            success: bolha_response
        });
    }

    function bolha_response(data, textStatus, jqXHR)
    {
//        console.log('bolha_response');
        if (textStatus === "success") {
//            console.log('success');
            var ano_result_to_fill = '';
            if (bolha_a === 1)
                ano_result_to_fill = "1991";
            else if (bolha_a === 2)
                ano_result_to_fill = "2000";
            else if (bolha_a === 3)
                ano_result_to_fill = "2010";

            $("#bolha_year_slider").simpleSlider("setValue", ano_result_to_fill);

            $("#p_indicador").val(bolha_i_name);
            $("#p_ano").val(ano_result_to_fill);
//            console.log('data: '+data);
            if(data != null || data != "" || data != undefined)
                obj = $.parseJSON(data);
            drawChartBolha();
        }
    }

    function listenerLocalGrafBolha(lugares) {
//        console.log('listenerLocalGrafBolha');
        geral.setLugares(lugares);
    }

    function bolha_indcator_selector_bolha(array) {
//        console.log('bolha_indcator_selector_bolha');
        local_.setItensSelecionados(array);
    }

    function listenerLocalIndicadoresBolha(indicadores) {
//        console.log('listenerLocalIndicadoresBolha');
        geral.setIndicadores(indicadores);
        eixo = geral.getEixo();
        if (eixo == undefined || eixo == '') {
            eixo = 0;
        }
        bolha_indc_selector[eixo].refresh();
    }

    function bolha_listener_lugar(event, obj)
    {
//        console.log('bolha_listener_lugar');
        local_.refresh();
        bolha_indc.refresh();
        dispacth_bolha_evt();
    }

    function seletor_indicador_(obj) {
//        console.log('seletor_indicador_');
        geral.setIndicadores(obj);
        eixo = geral.getEixo();
        if (eixo == undefined || eixo == '') {
            eixo = 0;
        }
        indicadorLocal[eixo].refresh();

    }

    function bolha_listener_indicador(event, obj)
    {
//        console.log('bolha_listener_indicador');
        quantil_id = "";

        if (event === "changetab")
        {
            geral.removeIndicadoresDuplicados();
        }

        eixo = geral.getEixo();
        if (eixo == undefined || eixo == '') {
            eixo = 0;
        }

        indicadorLocal[eixo].refresh();
        bolha_indc_selector[eixo].refresh();

//        //-----------------------------------
//        // Muda todos os anos dos indicadores
//        //-----------------------------------
        _indicadores = geral.getIndicadores();
        for (var i = 0; i < _indicadores.length; i++) {
            geral.updateIndicador(i, bolha_a);
        }

        //Ao Mudar de aba disparar o dispacth_bolha_evt somente uma vez!
        if (event !== "changetab")
            dispacth_bolha_evt(true);
    }

    function dispacth_bolha_evt()
    {
//        console.log('dispacth_bolha_evt');
        // limpa todos os argumentos
        bolha_i_name = new Array();
        bolha_e = 0;
        bolha_l = new Array();

        //limpa a seleção

        //obtem os locais e espacialidade
        _locais = geral.getLugaresPorEspacialidadeAtiva();
//        console.log('_locais: '+_locais);
        if (!(_locais === undefined || _locais === null || _locais === ""))
        {
            bolha_e = _locais.e;
            //locais a bem exibidos no mapa ou destacadas
            for (var i = 0; i < _locais.l.length; i++)
            {
//                console.log('locais tem');
                var _lugar = _locais.l[i];
//                console.log(_lugar);
                if (_lugar)
                {
//                    console.log(_lugar.c);
                    if (_lugar.c) {
//                        console.log('entrei lugar.c');
                        bolha_l.push(_lugar.id);
                    }
                    else{
                        bolha_l.push(0);
                    }
                }
            }
        }

        //obtem o indicador
        _indicadores = geral.getIndicadores();
        bolha_i[eixo] = _indicadores[0].id;
        bolha_a = _indicadores[0].a;
        bolha_i_name[eixo] = _indicadores[0].desc;

        bolha_load(bolha_e, bolha_l, bolha_i, bolha_a);

    }

</script>

<!-- conteúdo do popover -->
<div>
    <table>
        <tr>
            <td id="local_box2"></td>
            <td rowspan="3" style="border-left: 1px solid #ccc; vertical-align: top;">
                <table>
                    <tr>
                        <td>
                            <div style="margin-left: 30px;">
                                <div id="box_indicador_Cor" data-original-title='Selecione o indicador que representará a cor das Bolinhas no gráfico.' style="width: 281px; float: left; height: 34px; "></div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div id="box_indicador_Tamanho" data-original-title='Selecione o indicador que representará o Tamanho da Bolinha, no gráfico.' style="width: 311px; float: left; height: 33px;"> </div>
                            </div>
                        </td>
                    </tr>
<!--                    <tr>
                        
                    </tr>-->
                    <tr style="">
                        <td colspan="4">
                            <div style="width:681px; height:507px;">
                                <div id="box_indicador_eixoY" data-original-title='Selecione o indicador que representará o Eixo Y, no gráfico.' style="margin-left:52px; width: 57px; float: left; height: 362px; "></div>
                                <!--<div id="myModal" class="modal_video hide" tabindex="-1" role="dialog" data-toggle="modal" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none">Selecione Indicadores diferentes para cada Eixo</div>-->
                                <div id="chart_div" style='margin-left: 77px; width: 600px; height: 380px; margin-top: 49px; border: 1px solid #cccccc;'>
                                    <img id="uibolhaloader" src="assets/img/icons/ajax-loader.gif" style="background-color: transparent; margin-top: 126px; margin-left: 236px;" />
                                </div>
                                <div id="box_indicador_eixoX" data-original-title='Selecione o indicador que representará o Eixo X, no gráfico.' style="width: 604; float: left; height: 55px; margin-left: 79px;"> </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="height: 143px;">
            <td style="border-right: 1px solid #ccc;">
                <span id="disp_m_ano" style="font-weight: bold; display:block; margin-left:24px; width:44px;">ANO</span>
                <div>
                    <div class='labels'>
                        <span class="one">1991</span>
                        <span class="two">2000</span>
                        <span class="tree">2010</span>
                    </div>
                </div>
                <div class="sliderDivFather">
                    <div class="sliderDivIn">
                        <input type='text' id="bolha_year_slider" data-slider="true" data-slider-values="1991,2000,2010" data-slider-equal-steps="true" data-slider-snap="true" data-slider-theme="volume" />
                    </div>    
                </div>
            </td>
            <td  style="margin:0px; padding: 0px; border: 0px;" ></td>
        </tr>
    </table>
</div>


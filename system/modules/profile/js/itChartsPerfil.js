google.load("visualization", "1", {
    packages: ["corechart"]
});
google.setOnLoadCallback(graficoDesenvolvimentoHumanoIDHM);

//GRAFICO DESENVOLVIMENTO HUMANO IDHM ------------------------------------------
function graficoDesenvolvimentoHumanoIDHM(lang, type) {

    var dados = new google.visualization.DataTable();
    var array_renda = Array();
    var array_educacao = Array();
    var array_longevidade = Array();

    array_renda = jQuery.parseJSON($("#renda").val());
    array_educacao = jQuery.parseJSON($("#educacao").val());
    array_longevidade = jQuery.parseJSON($("#longevidade").val());

    //@#Traduções ---------------------------------------------

    //variáveis tradução
    var renda;
    var longevidade;
    var educacao;

    if (lang === "pt") {
        renda = "Renda";
        longevidade = "Longevidade";
        educacao = "Educação";
    }
    else if (lang === "en") {
        renda = "Income";
        longevidade = "Longevity";
        educacao = "Education";
    }
    else if (lang === "es") {
        renda = "Ingreso";
        longevidade = "Longevidad";
        educacao = "Educación";
    }
    //Fim Traduções  -----------------------------------------

    try {

        if (type !== 'perfil_rm' && type !== 'perfil_udh') {

            dados.addColumn('string', 'Data');
            dados.addRows(array_renda.length);
            dados.addColumn('number', renda);
            dados.addColumn('number', longevidade);
            dados.addColumn('number', educacao);

            for (i = 0; i < array_renda.length; i++) {
                dados.setValue(i, 0, array_renda[i].label_ano_referencia);
                dados.setValue(i, 1, Number(array_renda[i].valor));
                dados.setValue(i, 2, Number(array_longevidade[i].valor));
                dados.setValue(i, 3, Number(array_educacao[i].valor));
            }

        } else {

            dados.addColumn('string', 'Data');
            dados.addRows(array_renda.length - 1);
            dados.addColumn('number', renda);
            dados.addColumn('number', longevidade);
            dados.addColumn('number', educacao);

            for (i = 1; i <= array_renda.length - 1; i++) {
                dados.setValue(i - 1, 0, array_renda[i].label_ano_referencia);
                dados.setValue(i - 1, 1, Number(array_renda[i].valor));
                dados.setValue(i - 1, 2, Number(array_longevidade[i].valor));
                dados.setValue(i - 1, 3, Number(array_educacao[i].valor));
            }

        }

        var numberFormatter = new google.visualization.NumberFormat({
            fractionDigits: 3,
            decimalSymbol: ','
        });

        numberFormatter.format(dados, 1);
        numberFormatter.format(dados, 2);
        numberFormatter.format(dados, 3);

        var chart = new google.visualization.BarChart(
                document.getElementById('chartDesenvolvimentoHumanoIDHM'));
        chart.draw(dados,
                {
                    series: {
                        0: {color: '#3DC4FF'},
                        1: {color: '#2587CC'},
                        2: {color: '#0F67A6'}

                    },
                    hAxis: {
                        gridlines: {
                            count: 0
                        }
                    },
                    bar: {
                        groupWidth: 60
                    },
                    chartArea: {
                        height: 184
                    },
                    'isStacked': true,
                    'legend': 'top'
                });
    }
    catch (e) {
    }
}

//GRAFICO EVOLUCAO ------------------------------------------
function graficoEvolucaoIDHM(lang, type) {


    var dados = new google.visualization.DataTable();
    var array = Array();
    var array_max_min = Array();
    var array_media_brasil = Array();
    var array_media_estado = Array();

    array = jQuery.parseJSON($("#idhm_mun").val());
    array_max_min = jQuery.parseJSON($("#idhm_max_min_ano").val());
    array_media_brasil = jQuery.parseJSON($("#idhm_media_brasil").val());
    array_media_estado = jQuery.parseJSON($("#idhm_estado").val());

    //@#Traduções ---------------------------------------------

    //variáveis tradução
    var maiorIdh;
    var menorIdh;
    var mediaIdhBrasil;
    var mediaUfIdh;
    //var mediaRmIdh;
    var title;

    if (lang === "pt") {

        if (type === "perfil_uf") {
            maiorIdh = "UF de maior IDHM no Brasil";
            menorIdh = "UF de menor IDHM no Brasil";
        }
        else if (type === "perfil_m") {
            maiorIdh = "Município de maior IDHM no Brasil";
            menorIdh = "Município de menor IDHM no Brasil";
        }
        else if (type === "perfil_rm") {
            maiorIdh = "RM de maior IDHM no Brasil";
            menorIdh = "RM de menor IDHM no Brasi";
        }
//        else if (type === "perfil_udh"){
//            maiorIdh = "Maior (IDHM)";
//            menorIdh = "Menor (IDHM)";
//            mediaIdhBrasil = "Média do Brasil";
//            mediaUfIdh = "Média do Estado: "; 
//            mediaRmIdh = "Média da RM: "; 
//        }     

        mediaIdhBrasil = "IDHM Brasil";
        mediaUfIdh = "IDHM ";

        title = "Evolução do IDHM - ";
    }
    else if (lang === "en") {
        maiorIdh = "Highest (MHDI)";
        menorIdh = "Lowest (MHDI)";
        mediaIdhBrasil = "Brazilian average";
        mediaUfIdh = "Average of the municipality: ";
        //mediaRmIdh = "Average of the RM: "; 

        title = "MHDI evolution - ";
    }
    else if (lang === "es") {
        maiorIdh = "Mayor IDHM";
        menorIdh = "Menor IDHM";
        mediaIdhBrasil = "Promedio de Brasil";
        mediaUfIdh = "Promedio del estado: ";
        //mediaRmIdh = "Promedio del RM: "; 

        title = "Evolución del IDHM - ";
    }
    //Fim Traduções  -----------------------------------------

    var idh = array[0].nome;
    var maior_idh = maiorIdh;
    var menor_idh = menorIdh;
    var nac_idh = mediaIdhBrasil;
    var uf_idh;

    if (type !== 'perfil_rm' && type !== 'perfil_udh') {

        uf_idh = mediaUfIdh + array_media_estado[0].nome;

        dados.addColumn('number', 'Data');
        dados.addRows(array.length);
        dados.addColumn('number', idh);
        dados.addColumn('number', maior_idh);
        dados.addColumn('number', menor_idh);
        dados.addColumn('number', nac_idh);
        if (type !== 'perfil_uf') dados.addColumn('number', uf_idh);

        for (i = 0; i < array.length; i++) {
            dados.setValue(i, 0, Number(array[i].label_ano_referencia));
            dados.setValue(i, 1, Number(array[i].valor));
            dados.setValue(i, 2, Number(array_max_min[i].maxvalue));
            dados.setValue(i, 3, Number(array_max_min[i].minvalue));
            dados.setValue(i, 4, Number(array_media_brasil[i].valor));
            if (type !== 'perfil_uf') dados.setValue(i, 5, Number(array_media_estado[i].valor));
        }

    } else {

        dados.addColumn('number', 'Data');
        dados.addRows(array.length - 1);
        dados.addColumn('number', idh);
        dados.addColumn('number', maior_idh);
        dados.addColumn('number', menor_idh);
        dados.addColumn('number', nac_idh);

        for (i = 1; i <= array.length - 1; i++) {
            dados.setValue(i - 1, 0, Number(array[i].label_ano_referencia));
            dados.setValue(i - 1, 1, Number(array[i].valor));
            dados.setValue(i - 1, 2, Number(array_max_min[i].maxvalue));
            dados.setValue(i - 1, 3, Number(array_max_min[i].minvalue));
            dados.setValue(i - 1, 4, Number(array_media_brasil[i].valor));

        }

    }

    var numberFormatter = new google.visualization.NumberFormat({
        fractionDigits: 3,
        decimalSymbol: ','
    });

    var tituloUf;

    numberFormatter.format(dados, 1);
    numberFormatter.format(dados, 2);
    numberFormatter.format(dados, 3);
    numberFormatter.format(dados, 4);
    if (type !== "perfil_rm" && type !== "perfil_uf") {
        numberFormatter.format(dados, 5);
        tituloUf = " - " + array_media_estado[0].uf;
    } else
        tituloUf = "";

    var chart = new google.visualization.LineChart(document.getElementById('chartEvolucao'));
    chart.draw(dados, {
        pointSize: 4,
        series: {
            0: {
                pointSize: 10,
                lineWidth: 3,
                color: '#FF66CC'
            },
            1: {
                color: '#2587CC'
            },
            2: {
                color: 'red'
            },
            3: {
                color: '#2E8B57'
            },
            4: {
                color: '#9AC0CD'
            }
        },
        width: 800,
        height: 500,
        chartArea: {'width': '60%', 'height': '80%'},
        title: title + array[0].nome + tituloUf,
        hAxis: {
            ticks: [1991,2000,2010],
            viewWindow: {
                max: 2010,
                min: 1991
            },
            format: '#',
            gridlines: {
                count: 3
            }
        },
        vAxis: {
            maxValue: 1.0,
            minValue: 0.0,
            gridlines: {
                count: 11
            }
        }
    });
}

//---GRAFICO FAIXA ETARIA ------------------------------------------

function graficoFaixaEtaria(lang, type, tipoChart) {//está sem o tipo de perfil (causou problema)

    var dados = new google.visualization.DataTable();
    var array_masc = Array();
    var array_femin = Array();
    var array_idade = new Array();


    array_idade.push('0 a 4', '5 a 9', '10 a 14', '15 a 19', '20 a 24', '25 a 29',
            '30 a 34', '35 a 39', '40 a 44', '45 a 49', '50 a 54', '55 a 59', '60 a 64',
            '65 a 69', '70 a 74', '75 a 79', '80 e +');

    //@#Traduções ---------------------------------------------

    //variáveis tradução
    var iHomens;
    var iMulheres;

    if (lang === "pt") {
        iHomens = "Homens";
        iMulheres = "Mulheres";
    }
    else if (lang === "en") {
        iHomens = "Men";
        iMulheres = "Women";
    }
    else if (lang === "es") {
        iHomens = "Hombres";
        iMulheres = "Mujeres";
    }
    //Fim Traduções  -----------------------------------------


    array_masc = jQuery.parseJSON($("#piram_masc").val());
    array_femin = jQuery.parseJSON($("#piram_fem").val());
    var populacao = jQuery.parseJSON($("#piram_total").val());

    dados.addColumn('string', 'Data');
    dados.addRows(array_idade.length);
    dados.addColumn('number', iHomens);
    dados.addColumn('number', iMulheres);


    //------------------------------MASC-----------------------------------------//                
    for (i = 0; i < array_masc.length; i++) {

        if (array_masc[i].sigla == 'HOMEM0A4')
        {
            dados.setValue(0, 1, Number((array_masc[i].valor / populacao[0].valor).toFixed(2) * 100));
        }
        if (array_masc[i].sigla == 'HOMEM5A9')
        {
            dados.setValue(1, 1, Number((array_masc[i].valor / populacao[0].valor) * 100));
        }
        if (array_masc[i].sigla == 'HOMEM10A14')
        {
            dados.setValue(2, 1, Number((array_masc[i].valor / populacao[0].valor) * 100));
        }
        if (array_masc[i].sigla == 'HOMEM15A19')
        {
            dados.setValue(3, 1, Number((array_masc[i].valor / populacao[0].valor) * 100));
        }
        if (array_masc[i].sigla == 'HOMEM20A24')
        {
            dados.setValue(4, 1, Number((array_masc[i].valor / populacao[0].valor) * 100));
        }
        if (array_masc[i].sigla == 'HOMEM25A29')
        {
            dados.setValue(5, 1, Number((array_masc[i].valor / populacao[0].valor) * 100));
        }
        if (array_masc[i].sigla == 'HOMEM30A34')
        {
            dados.setValue(6, 1, Number((array_masc[i].valor / populacao[0].valor) * 100));
        }
        if (array_masc[i].sigla == 'HOMEM35A39')
        {
            dados.setValue(7, 1, Number((array_masc[i].valor / populacao[0].valor) * 100));
        }
        if (array_masc[i].sigla == 'HOMEM40A44')
        {
            dados.setValue(8, 1, Number((array_masc[i].valor / populacao[0].valor) * 100));
        }
        if (array_masc[i].sigla == 'HOMEM45A49')
        {
            dados.setValue(9, 1, Number((array_masc[i].valor / populacao[0].valor) * 100));
        }
        if (array_masc[i].sigla == 'HOMEM50A54')
        {
            dados.setValue(10, 1, Number((array_masc[i].valor / populacao[0].valor) * 100));
        }
        if (array_masc[i].sigla == 'HOMEM55A59')
        {
            dados.setValue(11, 1, Number((array_masc[i].valor / populacao[0].valor) * 100));
        }
        if (array_masc[i].sigla == 'HOMEM60A64')
        {
            dados.setValue(12, 1, Number((array_masc[i].valor / populacao[0].valor) * 100));
        }
        if (array_masc[i].sigla == 'HOMEM65A69')
        {
            dados.setValue(13, 1, Number((array_masc[i].valor / populacao[0].valor) * 100));
        }
        if (array_masc[i].sigla == 'HOMEM70A74')
        {
            dados.setValue(14, 1, Number((array_masc[i].valor / populacao[0].valor) * 100));
        }
        if (array_masc[i].sigla == 'HOMEM75A79')
        {
            dados.setValue(15, 1, Number((array_masc[i].valor / populacao[0].valor) * 100));
        }
        if (array_masc[i].sigla == 'HOMENS80')
        {
            dados.setValue(16, 1, Number((array_masc[i].valor / populacao[0].valor) * 100));
        }

    }
    //---------------FEMININO-----------------------------------------//  

    for (i = 0; i < array_idade.length; i++) {
        dados.setValue(i, 0, array_idade[i]);
    }
    for (i = 0; i < array_femin.length; i++) {

        if (array_femin[i].sigla == 'MULH0A4')
        {
            dados.setValue(0, 2, Number((array_femin[i].valor / populacao[0].valor) * (-100)));
        }
        if (array_femin[i].sigla == 'MULH5A9')
        {
            dados.setValue(1, 2, Number((array_femin[i].valor / populacao[0].valor) * (-100)));
        }
        if (array_femin[i].sigla == 'MULH10A14')
        {
            dados.setValue(2, 2, Number((array_femin[i].valor / populacao[0].valor) * (-100)));
        }
        if (array_femin[i].sigla == 'MULH15A19')
        {
            dados.setValue(3, 2, Number((array_femin[i].valor / populacao[0].valor) * (-100)));
        }
        if (array_femin[i].sigla == 'MULH20A24')
        {
            dados.setValue(4, 2, Number((array_femin[i].valor / populacao[0].valor) * (-100)));
        }
        if (array_femin[i].sigla == 'MULH25A29')
        {
            dados.setValue(5, 2, Number((array_femin[i].valor / populacao[0].valor) * (-100)));
        }
        if (array_femin[i].sigla == 'MULH30A34')
        {
            dados.setValue(6, 2, Number((array_femin[i].valor / populacao[0].valor) * (-100)));
        }
        if (array_femin[i].sigla == 'MULH35A39')
        {
            dados.setValue(7, 2, Number((array_femin[i].valor / populacao[0].valor) * (-100)));
        }
        if (array_femin[i].sigla == 'MULH40A44')
        {
            dados.setValue(8, 2, Number((array_femin[i].valor / populacao[0].valor) * (-100)));
        }
        if (array_femin[i].sigla == 'MULH45A49')
        {
            dados.setValue(9, 2, Number((array_femin[i].valor / populacao[0].valor) * (-100)));
        }
        if (array_femin[i].sigla == 'MULH50A54')
        {
            dados.setValue(10, 2, Number((array_femin[i].valor / populacao[0].valor) * (-100)));
        }
        if (array_femin[i].sigla == 'MULH55A59')
        {
            dados.setValue(11, 2, Number((array_femin[i].valor / populacao[0].valor) * (-100)));
        }
        if (array_femin[i].sigla == 'MULH60A64')
        {
            dados.setValue(12, 2, Number((array_femin[i].valor / populacao[0].valor) * (-100)));
        }
        if (array_femin[i].sigla == 'MULH65A69')
        {
            dados.setValue(13, 2, Number((array_femin[i].valor / populacao[0].valor) * (-100)));
        }
        if (array_femin[i].sigla == 'MULH70A74')
        {
            dados.setValue(14, 2, Number((array_femin[i].valor / populacao[0].valor) * (-100)));
        }
        if (array_femin[i].sigla == 'MULH75A79')
        {
            dados.setValue(15, 2, Number((array_femin[i].valor / populacao[0].valor) * (-100)));
        }
        if (array_femin[i].sigla == 'MULHER80')
        {
            dados.setValue(16, 2, Number((array_femin[i].valor / populacao[0].valor) * (-100)));
        }

    }

    var chart = new google.visualization.BarChart(document.getElementById('chart_piram_' + tipoChart));

    var options = {
        isStacked: true,
        hAxis: {
            format: ';',
            minValue: -10,
            maxValue: 10
        },
        vAxis: {
            direction: -1
        },
        width: 800,
        height: 400,
        chartArea: {left: 150, top: 30}
    };

    var formatter = new google.visualization.NumberFormat({
        negativeParens: true,
        suffix: '%'
    });

    formatter.format(dados, 1);
    formatter.format(dados, 2);


    chart.draw(dados, options);
}

//Grafico Fluxo Escolar
function graficoFluxoEscolar(lang, type) {

    var dados = new google.visualization.DataTable();
    var array_freq_esc_5a6 = Array();
    var array_freq_esc_11a13 = Array();
    var array_freq_esc_15a17 = Array();
    var array_freq_esc_18a20 = Array();

    array_freq_esc_5a6 = jQuery.parseJSON($("#freq_esc_5a6").val());
    array_freq_esc_11a13 = jQuery.parseJSON($("#freq_esc_11a13").val());
    array_freq_esc_15a17 = jQuery.parseJSON($("#freq_esc_15a17").val());
    array_freq_esc_18a20 = jQuery.parseJSON($("#freq_esc_18a20").val());

    //@#Traduções ---------------------------------------------

    //variáveis tradução
    var title;

    if (lang === "pt")
        title = "Fluxo Escolar por Faixa Etária";
    else if (lang === "en")
        title = "The educational flow of young people";
    else if (lang === "es")
        title = "Flujo escolar por rango de edad";

    //Fim Traduções  -----------------------------------------    

    dados.addColumn('string', 'Data');
    dados.addRows(4);

    dados.addColumn('number', type !== 'perfil_rm' && type !== 'perfil_udh' ? array_freq_esc_5a6[0].label_ano_referencia : "");
    dados.addColumn('number', array_freq_esc_5a6[1].label_ano_referencia);
    dados.addColumn('number', array_freq_esc_5a6[2].label_ano_referencia);


    dados.setValue(0, 0, array_freq_esc_5a6[0].nomecurto);
    dados.setValue(1, 0, array_freq_esc_11a13[0].nomecurto);
    dados.setValue(2, 0, array_freq_esc_15a17[0].nomecurto);
    dados.setValue(3, 0, array_freq_esc_18a20[0].nomecurto);

    for (i = 0; i < array_freq_esc_5a6.length; i++) {
        dados.setValue(0, i + 1, Number(array_freq_esc_5a6[i].valor));
        dados.setValue(1, i + 1, Number(array_freq_esc_11a13[i].valor));
        dados.setValue(2, i + 1, Number(array_freq_esc_15a17[i].valor));
        dados.setValue(3, i + 1, Number(array_freq_esc_18a20[i].valor));
    }

    var tituloUf;
    if (type !== "perfil_rm" && type !== "perfil_uf")
        tituloUf = " - " + array_freq_esc_5a6[0].uf;
    else
        tituloUf = "";

    var formatter = new google.visualization.NumberFormat({
        suffix: '%'
    });

    formatter.format(dados, 1);
    formatter.format(dados, 2);
    formatter.format(dados, 3);

    var chart = new google.visualization.ColumnChart(document.getElementById('chartFluxoEscolar'));
    chart.draw(dados, {
        legend: {
            alignment: 'center'
        },
        series: {
            0: {color: type !== 'perfil_rm' && type !== 'perfil_udh' ? '#FFC0CB' : '#FFFFFF'},
            1: {color: '#FF69B4'},
            2: {color: '#FF1493'}
        },
        width: 800,
        height: 600,
        title: title + " - " + array_freq_esc_5a6[0].nome + tituloUf + (type === 'perfil_rm' ? " - 2000/2010" : " - 1991/2000/2010")    

    });
}

// GRAFICO FREQUENCIA ESCOLAR
function graficoFrequenciaEscolar(lang, type) {

    var dados = new google.visualization.DataTable();
    var array_freq_esc_mun = Array();
    var array_freq_esc_uf = Array();
    var array_freq_esc_pais = Array();

    array_freq_esc_mun = jQuery.parseJSON($("#freq_esc_mun").val());

    if (type !== "perfil_rm" && type !== "perfil_uf")
        array_freq_esc_uf = jQuery.parseJSON($("#freq_esc_uf").val());

    array_freq_esc_pais = jQuery.parseJSON($("#freq_esc_pais").val());

    //@#Traduções ---------------------------------------------

    //variáveis tradução
    var title;
    var uf;
    var brasil;

    if (lang === "pt") {
        title = "Fluxo Escolar por Faixa Etária";
        uf = "Estado";
        brasil = "Brasil";
    } else if (lang === "en") {
        title = "The educational flow of young people";
        uf = "State";
        brasil = "Brazil";
    } else if (lang === "es") {
        title = "Flujo escolar por rango de edad";
        uf = "Estado";
        brasil = "Brasil";
    }

    //Fim Traduções  -----------------------------------------        

    var array_freq_esc_5a6 = Array();
    var array_freq_esc_11a13 = Array();
    var array_freq_esc_15a17 = Array();
    var array_freq_esc_18a20 = Array();

    for (i = 0; i < array_freq_esc_mun.length; i++)
    {
        if ('T_FREQ5A6' == array_freq_esc_mun[i].sigla) {
            array_freq_esc_5a6.push(array_freq_esc_mun[i]);
        }
        if ('T_FUND11A13' == array_freq_esc_mun[i].sigla) {
            array_freq_esc_11a13.push(array_freq_esc_mun[i]);
        }
        if ('T_FUND15A17' == array_freq_esc_mun[i].sigla) {
            array_freq_esc_15a17.push(array_freq_esc_mun[i]);
        }
        if ('T_MED18A20' == array_freq_esc_mun[i].sigla) {
            array_freq_esc_18a20.push(array_freq_esc_mun[i]);
        }
    }
    if (type !== "perfil_rm" && type !== "perfil_uf")
        for (i = 0; i < array_freq_esc_uf.length; i++)
        {
            if ('T_FREQ5A6' == array_freq_esc_uf[i].sigla) {
                array_freq_esc_5a6.push(array_freq_esc_uf[i]);
            }
            if ('T_FUND11A13' == array_freq_esc_uf[i].sigla) {
                array_freq_esc_11a13.push(array_freq_esc_uf[i]);
            }
            if ('T_FUND15A17' == array_freq_esc_uf[i].sigla) {
                array_freq_esc_15a17.push(array_freq_esc_uf[i]);
            }
            if ('T_MED18A20' == array_freq_esc_uf[i].sigla) {
                array_freq_esc_18a20.push(array_freq_esc_uf[i]);
            }
        }
    for (i = 0; i < array_freq_esc_pais.length; i++)
    {
        if ('T_FREQ5A6' == array_freq_esc_pais[i].sigla) {
            array_freq_esc_5a6.push(array_freq_esc_pais[i]);
        }
        if ('T_FUND11A13' == array_freq_esc_pais[i].sigla) {
            array_freq_esc_11a13.push(array_freq_esc_pais[i]);
        }
        if ('T_FUND15A17' == array_freq_esc_pais[i].sigla) {
            array_freq_esc_15a17.push(array_freq_esc_pais[i]);
        }
        if ('T_MED18A20' == array_freq_esc_pais[i].sigla) {
            array_freq_esc_18a20.push(array_freq_esc_pais[i]);
        }
    }

    dados.addColumn('string', 'Data');
    dados.addRows(4);

    dados.addColumn('number', array_freq_esc_mun[0].nome);

    if (type !== "perfil_rm" && type !== "perfil_uf")
        dados.addColumn('number', array_freq_esc_uf[0].nome);
    // dados.addColumn('number', uf + ': ' + array_freq_esc_uf[0].uf);

    dados.addColumn('number', brasil);

    dados.setValue(0, 0, array_freq_esc_5a6[0].nomecurto);
    dados.setValue(1, 0, array_freq_esc_11a13[0].nomecurto);
    dados.setValue(2, 0, array_freq_esc_15a17[0].nomecurto);
    dados.setValue(3, 0, array_freq_esc_18a20[0].nomecurto);

    var tituloUf;
    if (type !== "perfil_rm" && type !== "perfil_uf")
        tituloUf = " - " + array_freq_esc_uf[0].uf;
    else
        tituloUf = "";

    for (i = 0; i < array_freq_esc_5a6.length; i++) {

        dados.setValue(0, i + 1, Number(array_freq_esc_5a6[i].valor));
        dados.setValue(1, i + 1, Number(array_freq_esc_11a13[i].valor));
        dados.setValue(2, i + 1, Number(array_freq_esc_15a17[i].valor));
        dados.setValue(3, i + 1, Number(array_freq_esc_18a20[i].valor));
    }

    var formatter = new google.visualization.NumberFormat({
        suffix: '%'
    });

    formatter.format(dados, 1);
    formatter.format(dados, 2);

    if (type !== "perfil_rm" && type !== "perfil_uf")
        formatter.format(dados, 3);

    var chart = new google.visualization.ColumnChart(document.getElementById('chartFrequenciaEscolar'));
    chart.draw(dados, {
        legend: {
            alignment: 'center'
        },
        series: {
            0: {
                color: '#FF66CC'
            },
            1: {
                color: '#9AC0CD'
            },
            2: {
                color: '#2E8B57'
            }
        },
        width: 800,
        height: 600,
        title: "Fluxo Escolar por Faixa Etária - " + array_freq_esc_mun[0].nome + tituloUf + " - 2010"

    });
}

// GRAFICO FREQUENCIA ESCOLAR
//function graficoFrequenciaEscolarRmUf(lang, type) {
//    
//    var dados = new google.visualization.DataTable(); 
//    var array_freq_esc_mun = Array();
//    //var array_freq_esc_uf = Array(); 
//    var array_freq_esc_pais = Array();
//
//    array_freq_esc_mun   = jQuery.parseJSON($("#freq_esc_mun").val());
//    array_freq_esc_pais = jQuery.parseJSON($("#freq_esc_pais").val());
//	
//    //@#Traduções ---------------------------------------------
//    
//    //variáveis tradução
//    var title;
//    var uf;
//    var brasil;
//    
//    if (lang === "pt"){       
//        title = "Fluxo Escolar por Faixa Etária";  
//        uf = "Estado";
//        brasil = "Brasil";
//    }else if (lang === "en"){        
//        title = "The educational flow of young people";
//        uf = "State";
//        brasil = "Brazil";
//    }else if (lang === "es"){        
//        title = "Flujo escolar por rango de edad";
//        uf = "Estado";
//        brasil = "Brasil";
//    }
//    
//    //Fim Traduções  -----------------------------------------        
//        
//    var array_freq_esc_5a6 = Array();
//    var array_freq_esc_11a13 = Array(); 
//    var array_freq_esc_15a17 = Array();
//    var array_freq_esc_18a20 = Array();
//		
//    for(i=0;i<array_freq_esc_mun.length;i++)
//    {
//        if('T_FREQ5A6' == array_freq_esc_mun[i].sigla ){ 	
//            array_freq_esc_5a6.push(array_freq_esc_mun[i]);      
//        }
//        if('T_FUND11A13' == array_freq_esc_mun[i].sigla){
//            array_freq_esc_11a13.push(array_freq_esc_mun[i]);
//        }
//        if('T_FUND15A17' == array_freq_esc_mun[i].sigla){
//            array_freq_esc_15a17.push(array_freq_esc_mun[i]);
//        }
//        if('T_MED18A20' == array_freq_esc_mun[i].sigla){
//            array_freq_esc_18a20.push(array_freq_esc_mun[i]);
//        }
//    }
//    
//	for(i=0;i<array_freq_esc_pais.length;i++)
//    {
//        if('T_FREQ5A6' == array_freq_esc_pais[i].sigla ){ 	
//            array_freq_esc_5a6.push(array_freq_esc_pais[i]);       
//        }
//        if('T_FUND11A13' == array_freq_esc_pais[i].sigla){
//            array_freq_esc_11a13.push(array_freq_esc_pais[i]);
//        }
//        if('T_FUND15A17' == array_freq_esc_pais[i].sigla){
//            array_freq_esc_15a17.push(array_freq_esc_pais[i]);
//        }
//        if('T_MED18A20' == array_freq_esc_pais[i].sigla){
//            array_freq_esc_18a20.push(array_freq_esc_pais[i]);
//        }
//    }
//	
//    dados.addColumn('string','Data');
//    dados.addRows(4);            
//		
//    dados.addColumn('number',array_freq_esc_mun[0].nome);
//    //dados.addColumn('number', uf + ': ' + array_freq_esc_uf[0].uf);
//    dados.addColumn('number', brasil);
//		
//    dados.setValue(0,0,array_freq_esc_5a6[0].nomecurto);
//    dados.setValue(1,0,array_freq_esc_11a13[0].nomecurto);
//    dados.setValue(2,0,array_freq_esc_15a17[0].nomecurto);
//    dados.setValue(3,0,array_freq_esc_18a20[0].nomecurto);
//    
//    var tituloUf;
//    if (type !== "perfil_rm" && type !== "perfil_uf")
//        tituloUf = " - " + array_freq_esc_5a6[0].uf;
//    else
//        tituloUf = "";
//		
//    for(i=0;i<array_freq_esc_5a6.length;i++){
//	     
//        dados.setValue(0,i+1,Number(array_freq_esc_5a6[i].valor));
//        dados.setValue(1,i+1,Number(array_freq_esc_11a13[i].valor));
//        dados.setValue(2,i+1,Number(array_freq_esc_15a17[i].valor));
//        dados.setValue(3,i+1,Number(array_freq_esc_18a20[i].valor));
//    }
//	
//     var formatter = new google.visualization.NumberFormat({
//        suffix: '%'
//    });
//    
//    formatter.format(dados, 1);
//    formatter.format(dados, 2);
//    //formatter.format(dados, 3);
//    
//    var chart = new google.visualization.ColumnChart(document.getElementById('chartFrequenciaEscolar'));
//    chart.draw(dados, {
//        legend: {
//            alignment: 'center'
//        },
//        series: {
//            0: {
//                color:'#FF66CC'
//            },
//            1: {
//                color: '#9AC0CD'
//            },
//            2: {
//                color: '#2E8B57'
//            }
//        },
//        width: 800, 
//        height: 600,
//        title:"Fluxo Escolar por Faixa Etária - "+array_freq_esc_mun[0].nome + tituloUf + " - 2010" 
//	
//    });
//}

function graficoFrequenciaEscolarDe6a14Anos(lang, type) {

    var dados = new google.visualization.DataTable();
    var array = Array();
    var array_freq_esc_6a14_nome = Array();
    var array_freq_esc_6a14_valor = Array();

    array = jQuery.parseJSON($("#freq_esc_6a14").val());

    var name_freq = array[0].nome;


    dados.addColumn('string', 'Data');
    dados.addRows(array.length);
    dados.addColumn('number', name_freq);

    var taxa_frequencia;

    //@#Traduções ---------------------------------------------

    //variáveis tradução
    var title;
    var nFrequenta;
    var semAtraso;
    var umAnoAtraso;
    var doisAnosAtraso;
    var ensinoMedio;
    var outros;

    if (lang === "pt") {
        title = "Frequência escolar de 6 a 14 anos";
        nFrequenta = "Não frequenta";
        semAtraso = "Fundamental sem atraso";
        umAnoAtraso = "Fundamental com um ano de atraso";
        doisAnosAtraso = "Fundamental com dois anos de atraso";
        ensinoMedio = "No ensino médio";
        outros = "Outros";
    } else if (lang === "en") {
        title = "School attendance of children aged 6 to 14 years";
        nFrequenta = "Not attending";
        semAtraso = "Attending primary school without delay";
        umAnoAtraso = "Attending primary school with a 1-year delay";
        doisAnosAtraso = "Attending primary school with a 2-year delay";
        ensinoMedio = "Attending secondary school";
        outros = "Others";
    } else if (lang === "es") {
        title = "Asistencia escolar de 6 a 14 años";
        nFrequenta = "No asiste";
        semAtraso = "Primaria sin retraso";
        umAnoAtraso = "Primaria con un año de retraso";
        doisAnosAtraso = "Primaria con dos años de retraso";
        ensinoMedio = "Cursa la educación secundaria";
        outros = "Otros";
    }

    //Fim Traduções  -----------------------------------------        

    for (i = 0; i < array.length; i++)
    {
        if ('T_FLFUND' == array[i].sigla) {
            taxa_frequencia = array[i].valor;
        }
        else if ('T_FREQ6A14' == array[i].sigla) {
            array_freq_esc_6a14_nome.push(nFrequenta);
            array_freq_esc_6a14_valor.push(100 - array[i].valor);
        }
    }

    for (i = 0; i < array.length; i++)
    {
        if ('T_ATRASO_0_FUND' == array[i].sigla) {
            array_freq_esc_6a14_nome.push(semAtraso);
            array_freq_esc_6a14_valor.push((array[i].valor * taxa_frequencia) / 100);
        }
        else if ('T_ATRASO_1_FUND' == array [i].sigla) {
            array_freq_esc_6a14_nome.push(umAnoAtraso);
            array_freq_esc_6a14_valor.push((array[i].valor * taxa_frequencia) / 100);
        }
        else if ('T_ATRASO_2_FUND' == array[i].sigla) {
            array_freq_esc_6a14_nome.push(doisAnosAtraso);
            array_freq_esc_6a14_valor.push((array[i].valor * taxa_frequencia) / 100);
        }
        else if ('T_FREQMED614' == array[i].sigla) {
            array_freq_esc_6a14_nome.push(ensinoMedio);
            array_freq_esc_6a14_valor.push(array[i].valor);
        }

    }

    var valor = 100.00;
    for (i = 0; i < array_freq_esc_6a14_nome.length; i++)
    {
        valor = valor - array_freq_esc_6a14_valor[i];
    }
    array_freq_esc_6a14_nome.push(outros);

    if (valor < 0) {
        array_freq_esc_6a14_valor.push(Number(0));
    } else {
        array_freq_esc_6a14_valor.push(Number(valor));
    }


    for (i = 0; i < array_freq_esc_6a14_nome.length; i++) {
        dados.setValue(i, 0, array_freq_esc_6a14_nome[i] + " (" + number_format(array_freq_esc_6a14_valor[i], 2, ',', '.') + "%)");
        dados.setValue(i, 1, Number(array_freq_esc_6a14_valor[i]));

    }

    var tituloUf;
    if (type !== "perfil_rm" && type !== "perfil_uf")
        tituloUf = " - " + array[0].uf;
    else
        tituloUf = "";

    var formatter = new google.visualization.NumberFormat({
        suffix: '%'
    });
    formatter.format(dados, 1);

    var chart = new google.visualization.PieChart(document.getElementById('chart_freq_6a14'));
    chart.draw(dados, {
        hAxis: {
            minValue: 0,
            maxValue: 100
        },
        slices: [{color: '#DFDFDF'}, {color: '#FF8891'}, {color: '#FFA89D'}, {color: '#FFBBAD'}, {color: '#FFE7D1'}, {color: '#00CC66'}],
        width: 800,
        height: 400,
        title: title + " - " + array[0].nome + tituloUf + " - 2010"
    });

}

function graficoFrequenciaEscolarDe15a17Anos(lang, type) {

    var dados = new google.visualization.DataTable();
    var array = Array();
    var array_freq_esc_15a17_nome = Array();
    var array_freq_esc_15a17_valor = Array();

    array = jQuery.parseJSON($("#freq_esc_15a17").val());

    var name_freq = array[0].nome;

    dados.addColumn('string', 'Data');
    dados.addRows(array.length);
    dados.addColumn('number', name_freq);

    var taxa_frequencia;

    //@#Traduções ---------------------------------------------

    //variáveis tradução
    var title;
    var nFrequenta;
    var semAtraso;
    var fundamental;
    var umAnoAtraso;
    var doisAnosAtraso;
    var ensinoSuperior;
    var outros;

    if (lang === "pt") {
        title = "Frequência escolar de 15 a 17 anos";
        nFrequenta = "Não frequenta";
        semAtraso = "No ensino médio sem atraso";
        fundamental = "Frequentando o fundamental";
        umAnoAtraso = "No ensino médio com um ano de atraso";
        doisAnosAtraso = "No ensino médio com dois anos de atraso";
        ensinoSuperior = "Frequentando o curso superior";
        outros = "Outros";
    } else if (lang === "en") {
        title = "School attendance of young people aged 15 to 17 years";
        nFrequenta = "Not attending school";
        semAtraso = "Attending secondary school without delay";
        fundamental = "Attending primary school";
        umAnoAtraso = "Attending secondary school with a 1-year delay";
        doisAnosAtraso = "Attending secondary school with a 2-year delay";
        ensinoSuperior = "Attending school of higher education";
        outros = "Others";
    } else if (lang === "es") {
        title = "Asistencia escolar de 15 a 17 años";
        nFrequenta = "No asiste";
        semAtraso = "Cursa la educación secundaria sin retraso";
        fundamental = "Cursa la educación primaria";
        umAnoAtraso = "Cursa la educación secundaria con un año de retraso";
        doisAnosAtraso = "Cursa la educación secundaria con dos años de retraso";
        ensinoSuperior = "Cursa la educación superior";
        outros = "Otros";
    }

    //Fim Traduções  -----------------------------------------  

    for (i = 0; i < array.length; i++)
    {
        if ('T_FLMED' == array[i].sigla) {
            taxa_frequencia = array[i].valor;
        }
        if ('T_FREQ15A17' == array[i].sigla) {
            array_freq_esc_15a17_nome.push(nFrequenta);
            array_freq_esc_15a17_valor.push(100 - array[i].valor);
        }
    }

    for (i = 0; i < array.length; i++)
    {

        if ('T_ATRASO_0_MED' == array[i].sigla) {
            array_freq_esc_15a17_nome.push(semAtraso);
            array_freq_esc_15a17_valor.push((array[i].valor * taxa_frequencia) / 100);
        }
        else if ('T_FREQFUND1517' == array[i].sigla) {
            array_freq_esc_15a17_nome.push(fundamental);
            array_freq_esc_15a17_valor.push(array[i].valor);
        }
        else if ('T_ATRASO_1_MED' == array[i].sigla) {
            array_freq_esc_15a17_nome.push(umAnoAtraso);
            array_freq_esc_15a17_valor.push((array[i].valor * taxa_frequencia) / 100);
        }
        else if ('T_ATRASO_2_MED' == array[i].sigla) {
            array_freq_esc_15a17_nome.push(doisAnosAtraso);
            array_freq_esc_15a17_valor.push((array[i].valor * taxa_frequencia) / 100);
        }
        else if ('T_FREQSUPER1517' == array[i].sigla) {
            array_freq_esc_15a17_nome.push(ensinoSuperior);
            array_freq_esc_15a17_valor.push(array[i].valor);
        }
    }
    var valor = 100;

    for (i = 0; i < array_freq_esc_15a17_nome.length; i++)
    {
        valor = valor - array_freq_esc_15a17_valor[i];
    }

    array_freq_esc_15a17_nome.push(outros);
    if (valor < 0) {
        array_freq_esc_15a17_valor.push(Number(0));
    } else {
        array_freq_esc_15a17_valor.push(Number(valor));
    }
    for (i = 0; i < array_freq_esc_15a17_nome.length; i++) {
        dados.setValue(i, 0, array_freq_esc_15a17_nome[i] + " (" + number_format(array_freq_esc_15a17_valor[i], 2, ',', '.') + "%)");
        dados.setValue(i, 1, Number(array_freq_esc_15a17_valor[i]));

    }

    var tituloUf;
    if (type !== "perfil_rm" && type !== "perfil_uf")
        tituloUf = " - " + array[0].uf;
    else
        tituloUf = "";

    var formatter = new google.visualization.NumberFormat({
        suffix: '%'
    });
    formatter.format(dados, 1);

    var chart = new google.visualization.PieChart(document.getElementById('chart_freq_15a17'));
    chart.draw(dados, {
        hAxis: {
            minValue: 0,
            maxValue: 100
        },
        slices: [{color: '#DFDFDF'}, {color: '#FF9900'}, {color: '#FFAD5A'}, {color: '#FFC492'}, {color: '#FF6699'}, {color: '#0099CC'}, {color: '#00CC66'}],
        pieSliceText: 'value',
        width: 800,
        height: 400,
        title: title + " - " + array[0].nome + tituloUf + " - 2010"
    });

}

function graficoFrequenciaEscolarDe18a24Anos(lang, type) {

    var dados = new google.visualization.DataTable();
    var array = Array();
    var array_freq_esc_18a24_nome = Array();
    var array_freq_esc_18a24_valor = Array();

    array = jQuery.parseJSON($("#freq_esc_18a24").val());

    var name_freq = array[0].nome;

    dados.addColumn('string', 'Data');
    dados.addRows(array.length + 1);//#Foi preciso adicionar um aqui
    dados.addColumn('number', name_freq);

    //var taxa_frequencia;

    //@#Traduções ---------------------------------------------

    //variáveis tradução
    var title;
    var nFrequenta;
    var fundamental;
    var medio;
    var superior;
    var outros;

    if (lang === "pt") {
        title = "Frequência escolar de 18 a 24 anos";
        nFrequenta = "Não frequenta";
        fundamental = "Frequentando o fundamental";
        medio = "Frequentando o ensino médio";
        superior = "Frequentando o curso superior";
        outros = "Outros";
    } else if (lang === "en") {
        title = "School attendance of young adults aged 18 to 24 years";
        nFrequenta = "Not attending";
        fundamental = "Attending primary school";
        medio = "Attending secondary school";
        superior = "Attending higher education institution";
        outros = "Others";
    } else if (lang === "es") {
        title = "Asistencia escolar de 18 a 24 años";
        nFrequenta = "No asiste";
        fundamental = "Cursa la educación primaria";
        medio = "Cursa la educación secundaria";
        superior = "Cursa la educación superior";
        outros = "Otros";
    }

    //Fim Traduções  -----------------------------------------  

    for (i = 0; i < array.length; i++)
    {
        if ('T_FREQ18A24' == array[i].sigla) {
            array_freq_esc_18a24_nome.push(nFrequenta);
            array_freq_esc_18a24_valor.push(100 - array[i].valor);
        }
    }

    for (i = 0; i < array.length; i++)
    {
        if ('T_FREQFUND1824' == array[i].sigla) {
            array_freq_esc_18a24_nome.push(fundamental);
            array_freq_esc_18a24_valor.push(array[i].valor);
        }
        else if ('T_FREQMED1824' == array[i].sigla) {
            array_freq_esc_18a24_nome.push(medio);
            array_freq_esc_18a24_valor.push(array[i].valor);
        }
        else if ('T_FLSUPER' == array[i].sigla) {
            array_freq_esc_18a24_nome.push(superior);
            array_freq_esc_18a24_valor.push(array[i].valor);
        }
    }
    var valor = 100;

    for (i = 0; i < array_freq_esc_18a24_nome.length; i++)
    {
        valor = valor - array_freq_esc_18a24_valor[i];
    }
    array_freq_esc_18a24_nome.push(outros);

    if (valor < 0) {
        array_freq_esc_18a24_valor.push(Number(0));
    } else {
        array_freq_esc_18a24_valor.push(Number(valor));
    }

    for (i = 0; i < array_freq_esc_18a24_nome.length; i++) {
        dados.setValue(i, 0, array_freq_esc_18a24_nome[i] + " (" + number_format(array_freq_esc_18a24_valor[i], 2, ',', '.') + "%)");
        dados.setValue(i, 1, Number(array_freq_esc_18a24_valor[i]));

    }

    var tituloUf;
    if (type !== "perfil_rm" && type !== "perfil_uf")
        tituloUf = " - " + array[0].uf;
    else
        tituloUf = "";

    var formatter = new google.visualization.NumberFormat({
        suffix: '%'
    });
    formatter.format(dados, 1);

    var chart = new google.visualization.PieChart(document.getElementById('chart_freq_18a24'));
    chart.draw(dados, {
        hAxis: {
            minValue: 0,
            maxValue: 100
        },
        slices: [{color: '#DFDFDF'}, {color: '#00A7DE'}, {color: '#FF6699'}, {color: '#FFDBB8'}, {color: '#00CC66'}],
        pieSliceText: 'value',
        width: 800,
        height: 400,
        title: title + " - " + array[0].nome + tituloUf + " - 2010"
    });

}

function graficoEscolaridadePop91(lang, type) {
    var dados = new google.visualization.DataTable();
    var array_1991 = Array();
    var array_valor_1991 = Array();
    var array_nome_1991 = Array();

    array_1991 = jQuery.parseJSON($("#freq_1991").val());
    dados.addColumn('string', 'Data');
    dados.addRows(5);

    dados.addColumn('number', array_1991[2].nomecurto);

    var medio = 0;
    var analf = 0;
    var fund = 0;
    var sup = 0;

    //@#Traduções ---------------------------------------------

    //variáveis tradução
    var fundAnalfabeto;
    var fundAlfabetizado;
    var fundMedio;
    var medSuper;
    var superior;
    //var nomeOutros;

    if (lang === "pt") {
        fundAnalfabeto = "Fundamental incompleto e analfabeto";
        fundAlfabetizado = "Fundamental incompleto e alfabetizado";
        fundMedio = "Fundamental completo e médio incompleto";
        medSuper = "Médio completo e superior incompleto";
        superior = "Superior completo";
        //nomeOutros = "Outros";
    } else if (lang === "en") {
        fundAnalfabeto = "Fundamental incompleto e analfabeto";
        fundAlfabetizado = "Fundamental incompleto e alfabetizado";
        fundMedio = "Fundamental completo e médio incompleto";
        medSuper = "Médio completo e superior incompleto";
        superior = "Superior completo";
        //nomeOutros = "Outros";
    } else if (lang === "es") {
        fundAnalfabeto = "Fundamental incompleto e analfabeto";
        fundAlfabetizado = "Fundamental incompleto e alfabetizado";
        fundMedio = "Fundamental completo e médio incompleto";
        medSuper = "Médio completo e superior incompleto";
        superior = "Superior completo";
        //nomeOutros = "Outros";
    }

    //Fim Traduções  -----------------------------------------  

    for (i = 0; i < array_1991.length; i++)
    {

        if ('T_ANALF25M' == array_1991[i].sigla)
            analf = array_1991[i].valor;

        if ('T_FUND25M' == array_1991[i].sigla)
            fund = array_1991[i].valor;

        if ('T_MED25M' == array_1991[i].sigla)
            medio = array_1991[i].valor;

        if ('T_SUPER25M' == array_1991[i].sigla)
            sup = array_1991[i].valor;
    }

    //if (type != "perfil_rm") {
        array_nome_1991.push(fundAnalfabeto);
        array_valor_1991.push(analf);
        array_nome_1991.push(fundAlfabetizado);
        array_valor_1991.push(100 - fund - analf);
        array_nome_1991.push(fundMedio);
        array_valor_1991.push(fund - medio);
        array_nome_1991.push(medSuper);
        array_valor_1991.push(medio - sup);
        array_nome_1991.push(superior);
        array_valor_1991.push(sup);
//    } else {
//        array_nome_1991.push(fundAnalfabeto);
//        array_valor_1991.push(1);
//        array_nome_1991.push(fundAlfabetizado);
//        array_valor_1991.push(1);
//        array_nome_1991.push(fundMedio);
//        array_valor_1991.push(1);
//        array_nome_1991.push(medSuper);
//        array_valor_1991.push(1);
//        array_nome_1991.push(superior);
//        array_valor_1991.push(1);
//    }

    for (i = 0; i < array_nome_1991.length; i++) {

        dados.setValue(i, 0, array_nome_1991[i]);
        dados.setValue(i, 1, Number(array_valor_1991[i]));

    }

    var formatter = new google.visualization.NumberFormat({
        suffix: '%',
        decimalSymbol: ',',
        fractionDigits: 2
    });
    formatter.format(dados, 1);

    var chart = new google.visualization.PieChart(document.getElementById('chartEscolaridadePop91'));
    chart.draw(dados, {
        hAxis: {
            minValue: 0,
            maxValue: 100
        },
        slices: [{color: '#CAE1FF'}, {color: '#A4D3EE'}, {color: '#4F94CD'}, {color: '#4682B4'}],
        legend: {position: 'left', alignment: 'center'},
        chartArea: {right: 30, top: 50, width: "300", height: "300"}
    });
}

function graficoEscolaridadePop00(lang, type) {
    
    var dados = new google.visualization.DataTable();
    var array_2000 = Array();
    var array_valor_2000 = Array();
    var array_nome_2000 = Array();

    array_2000 = jQuery.parseJSON($("#freq_2000").val());

    dados.addColumn('string', 'Data');
    dados.addRows(5);

    dados.addColumn('number', array_2000[2].nomecurto);

    var medio = 0;
    var analf = 0;
    var fund = 0;
    var sup = 0;

    //@#Traduções ---------------------------------------------

    //variáveis tradução
    var fundAnalfabeto;
    var fundAlfabetizado;
    var fundMedio;
    var medSuper;
    var superior;

    if (lang === "pt") {
        fundAnalfabeto = "Fundamental incompleto e analfabeto";
        fundAlfabetizado = "Fundamental incompleto e alfabetizado";
        fundMedio = "Fundamental completo e médio incompleto";
        medSuper = "Médio completo e superior incompleto";
        superior = "Superior completo";
    } else if (lang === "en") {
        fundAnalfabeto = "Fundamental incompleto e analfabeto";
        fundAlfabetizado = "Fundamental incompleto e alfabetizado";
        fundMedio = "Fundamental completo e médio incompleto";
        medSuper = "Médio completo e superior incompleto";
        superior = "Superior completo";
    } else if (lang === "es") {
        fundAnalfabeto = "Fundamental incompleto e analfabeto";
        fundAlfabetizado = "Fundamental incompleto e alfabetizado";
        fundMedio = "Fundamental completo e médio incompleto";
        medSuper = "Médio completo e superior incompleto";
        superior = "Superior completo";
    }

    //Fim Traduções  -----------------------------------------  

    for (i = 0; i < array_2000.length; i++)
    {

        if ('T_ANALF25M' == array_2000[i].sigla)
            analf = array_2000[i].valor;

        if ('T_FUND25M' == array_2000[i].sigla)
            fund = array_2000[i].valor;

        if ('T_MED25M' == array_2000[i].sigla)
            medio = array_2000[i].valor;

        if ('T_SUPER25M' == array_2000[i].sigla)
            sup = array_2000[i].valor;
    }

    array_nome_2000.push(fundAnalfabeto);
    array_valor_2000.push(analf);
    array_nome_2000.push(fundAlfabetizado);
    array_valor_2000.push(100 - fund - analf);
    array_nome_2000.push(fundMedio);
    array_valor_2000.push(fund - medio);
    array_nome_2000.push(medSuper);
    array_valor_2000.push(medio - sup);
    array_nome_2000.push(superior);
    array_valor_2000.push(sup);

    for (i = 0; i < array_nome_2000.length; i++) {
        dados.setValue(i, 0, array_nome_2000[i]);
        dados.setValue(i, 1, Number(array_valor_2000[i]));
    }

    var formatter = new google.visualization.NumberFormat({
        suffix: '%',
        decimalSymbol: ',',
        fractionDigits: 2
    });
    formatter.format(dados, 1);
    
    var chart = new google.visualization.PieChart(document.getElementById('chartEscolaridadePop00'));
    chart.draw(dados, {
        hAxis: {
            minValue: 0,
            maxValue: 100
        },
        slices: [{color: '#CAE1FF'}, {color: '#A4D3EE'}, {color: '#4F94CD'}, {color: '#4682B4'}],
        legend: (type === "perfil_rm" || type === "perfil_udh" ? {position: 'left', alignment: 'center'} : 'none'),
        chartArea: {left: 30, top: 50, width: (type !== "perfil_rm" && type !== "perfil_udh" ? "185" : "300"), height: "300"}
    });
}

function graficoEscolaridadePop10(lang, type) {
    var dados = new google.visualization.DataTable();
    var array_2010 = Array();
    var array_valor_2010 = Array();
    var array_nome_2010 = Array();

    array_2010 = jQuery.parseJSON($("#freq_2010").val());

    dados.addColumn('string', 'Data');
    dados.addRows(5);

    dados.addColumn('number', array_2010[2].nomecurto);
    //dados.addColumn({type:'string', role:'tooltip'});
    
    var legenda = "none";

    if (type == "perfil_rm")
        legenda = "{position: 'left', alignment: 'center'}";
    else
        legenda = "none";

    var medio = 0;
    var analf = 0;
    var fund = 0;
    var sup = 0;

    //@#Traduções ---------------------------------------------

    //variáveis tradução
    var fundAnalfabeto;
    var fundAlfabetizado;
    var fundMedio;
    var medSuper;
    var superior;

    if (lang === "pt") {
        fundAnalfabeto = "Fundamental incompleto e analfabeto";
        fundAlfabetizado = "Fundamental incompleto e alfabetizado";
        fundMedio = "Fundamental completo e médio incompleto";
        medSuper = "Médio completo e superior incompleto";
        superior = "Superior completo";
    } else if (lang === "en") {
        fundAnalfabeto = "Fundamental incompleto e analfabeto";
        fundAlfabetizado = "Fundamental incompleto e alfabetizado";
        fundMedio = "Fundamental completo e médio incompleto";
        medSuper = "Médio completo e superior incompleto";
        superior = "Superior completo";
    } else if (lang === "es") {
        fundAnalfabeto = "Fundamental incompleto e analfabeto";
        fundAlfabetizado = "Fundamental incompleto e alfabetizado";
        fundMedio = "Fundamental completo e médio incompleto";
        medSuper = "Médio completo e superior incompleto";
        superior = "Superior completo";
    }

    //Fim Traduções  -----------------------------------------  

    for (i = 0; i < array_2010.length; i++)
    {

        if ('T_ANALF25M' == array_2010[i].sigla)
            analf = array_2010[i].valor;

        if ('T_FUND25M' == array_2010[i].sigla)
            fund = array_2010[i].valor;

        if ('T_MED25M' == array_2010[i].sigla)
            medio = array_2010[i].valor;

        if ('T_SUPER25M' == array_2010[i].sigla)
            sup = array_2010[i].valor;
    }

    array_nome_2010.push(fundAnalfabeto);
    array_valor_2010.push(analf);
    array_nome_2010.push(fundAlfabetizado);
    array_valor_2010.push(100 - fund - analf);
    array_nome_2010.push(fundMedio);
    array_valor_2010.push(fund - medio);
    array_nome_2010.push(medSuper);
    array_valor_2010.push(medio - sup);
    array_nome_2010.push(superior);
    array_valor_2010.push(sup);

    for (i = 0; i < array_nome_2010.length; i++) {
        dados.setValue(i, 0, array_nome_2010[i]);
        dados.setValue(i, 1, Number(array_valor_2010[i]));
    }

    var formatter = new google.visualization.NumberFormat({
        suffix: '%',
        decimalSymbol: ',',
        fractionDigits: 2
        
    });
    formatter.format(dados, 1);

    var chart = new google.visualization.PieChart(document.getElementById('chartEscolaridadePop10'));
    chart.draw(dados, {
        hAxis: {
            minValue: 0,
            maxValue: 100
        },
        slices: [{color: '#CAE1FF'}, {color: '#A4D3EE'}, {color: '#4F94CD'}, {color: '#4682B4'}],
        legend: (type === "perfil_udh" ? {position: 'left', alignment: 'center'} : 'none'),
        chartArea: {left: 30, top: 50, width: (type === "perfil_udh" ? "300" : "185"), height: "300"}
    });
}

function graficoTrabalho(lang, type) {

    var dados = new google.visualization.DataTable();
    var array_trab_2010 = Array();
    var array_valor_trab_2010 = Array();
    var array_nome_trab_2010 = Array();

    array_trab_2010 = jQuery.parseJSON($("#trabalho_perfil").val());

    dados.addColumn('string', 'Data');
    dados.addRows(5);

    dados.addColumn('number', array_trab_2010[0].nomecurto);

    var peso18 = 0;
    var t_ativ18m = 0;
    var t_des18m = 0;

    //@#Traduções ---------------------------------------------

    //variáveis tradução
    var ecoAtivo;
    var ecoAtivoDes;
    var ecoNaoAtivo;

    if (lang === "pt") {
        ecoAtivo = "População economicamente ativa ocupada";
        ecoAtivoDes = "População economicamente ativa desocupada";
        ecoNaoAtivo = "População economicamente inativa";
    } else if (lang === "en") {
        ecoAtivo = "Economically-active population ocupada";
        ecoAtivoDes = "Economically-active population desocupada";
        ecoNaoAtivo = "Economically-inactive population";
    } else if (lang === "es") {
        ecoAtivo = "Población económicamente activa ocupada";
        ecoAtivoDes = "Población económicamente activa desocupada";
        ecoNaoAtivo = "Población económicamente no activa";
    }

    //Fim Traduções  -----------------------------------------

    for (i = 0; i < array_trab_2010.length; i++)
    {
        if ('PESO18' == array_trab_2010[i].sigla) {
            peso18 = array_trab_2010[i].valor;
        }
        if ('T_ATIV18M' == array_trab_2010[i].sigla) {
            t_ativ18m = array_trab_2010[i].valor;
        }
        if ('T_DES18M' == array_trab_2010[i].sigla) {
            t_des18m = array_trab_2010[i].valor;
        }
    }
    array_valor_trab_2010.push((t_ativ18m / 100) * peso18);
    array_nome_trab_2010.push(ecoAtivo);

    array_valor_trab_2010.push((t_des18m / 100) * peso18);
    array_nome_trab_2010.push(ecoAtivoDes);

    array_valor_trab_2010.push(peso18 - (((t_ativ18m / 100) * peso18)) - (((t_des18m / 100) * peso18)));
    array_nome_trab_2010.push(ecoNaoAtivo);


    for (i = 0; i < array_valor_trab_2010.length; i++) {

        dados.setValue(i, 0, array_nome_trab_2010[i]);
        dados.setValue(i, 1, Number(array_valor_trab_2010[i]));

    }
    var numberFormatter = new google.visualization.NumberFormat({
        fractionDigits: 0,
        groupingSymbol: '.'
    });
    numberFormatter.format(dados, 1);
    
    var chart = new google.visualization.PieChart(document.getElementById('chart_trabalho'));
    chart.draw(dados, {
        hAxis: {
            minValue: 0,
            maxValue: 100
        },
        slices: [{color: '#0000CD'}, {color: '#4F94CD'}, {color: '#EE0000'}],
        width: 800,
        height: 600,
        chartArea: {left: 20, top: 60},
        legend: {position: 'left'}
    });
}
//---------------------------TRABALHOS ATIVOS----------------------------------//

//GRAFICO INATIVO
//function graficoTrabalhoAtivos(lang, type) {
//
//    var dados = new google.visualization.DataTable();
//    var array_trab_2010 = Array();
//    var array_valor_trab_2010 = Array();
//    var array_nome_trab_2010 = Array();
//
//    //@#Traduções ---------------------------------------------
//
//    //variáveis tradução
//    var ocupados;
//    var desocupados;
//
//    if (lang === "pt") {
//        ocupados = "Ocupados";
//        desocupados = "Desocupados";
//    } else if (lang === "en") {
//        ocupados = "Employed";
//        desocupados = "Unemployed";
//    } else if (lang === "es") {
//        ocupados = "Ocupados";
//        desocupados = "Desocupados";
//    }
//
//    //Fim Traduções  -----------------------------------------
//
//    array_trab_2010 = jQuery.parseJSON($("#trabalho_ativo").val());
//
//    dados.addColumn('string', 'Data');
//    dados.addRows(2);
//
//    dados.addColumn('number', ocupados);
//    dados.addColumn('number', desocupados);
//
//    var peso18 = 0;
//    var t_des18m = 0;
//    var t_ativ18m = 0;
//
//    for (i = 0; i < array_trab_2010.length; i++)
//    {
//
//        if ('PESO18' == array_trab_2010[i].sigla) {
//            peso18 = array_trab_2010[i].valor;
//        }
//        if ('T_DES18M' == array_trab_2010[i].sigla) {
//            t_des18m = array_trab_2010[i].valor;
//        }
//        if ('T_ATIV18M' == array_trab_2010[i].sigla) {
//            t_ativ18m = array_trab_2010[i].valor;
//        }
//    }
//    dados.setValue(0, 0, array_trab_2010[0].label_ano_referencia);
//    dados.setValue(0, 1, (((t_ativ18m / 100) * peso18) - ((t_des18m / 100) * peso18)));
//    dados.setValue(0, 2, (peso18 * (t_des18m / 100)));
//
//    var numberFormatter = new google.visualization.NumberFormat({
//        fractionDigits: 0
//    });
//    numberFormatter.format(dados, 1);
//    numberFormatter.format(dados, 2);
//
//    var chart = new google.visualization.ColumnChart(
//            document.getElementById('chart_trabalho_ativos'));
//    chart.draw(dados, {
//        'isStacked': true,
//        'legend': 'right',
//        series: {
//            0: {color: '#4682B4'},
//            1: {color: '#87CEEB'}
//        },
//        vAxis: {
//            gridlines: {
//                count: 0
//            }
//        },
//        chartArea: {left: 0},
//        width: 350,
//        height: 400
//    });
//}


// NOVO GRAFICO RENDA POR QUINTOS

function graficoRendaPorQuintos91(lang, type) {

    var dados = new google.visualization.DataTable();
    var array_1991 = Array();
    var array_valor_1991 = Array();
    var array_nome_1991 = Array();

    array_1991 = jQuery.parseJSON($("#rend_1991").val());
    dados.addColumn('string', 'Data');
    dados.addRows(5);

    dados.addColumn('number', array_1991[2].nomecurto);

    var umQuinto = 0;
    var doisQuinto = 0;
    var tresQuinto = 0;
    var quatroQuinto = 0;
    var cincoQuinto = 0;

    //@#Traduções ---------------------------------------------

    //variáveis tradução
    var primeiro;
    var segundo;
    var terceiro;
    var quarto;
    var quinto;

    if (lang === "pt") {
        primeiro = "1º Quinto";
        segundo = "2º Quinto";
        terceiro = "3º Quinto";
        quarto = "4º Quinto";
        quinto = "5º Quinto";
    } else if (lang === "en") {
        primeiro = "1º Quinto";
        segundo = "2º Quinto";
        terceiro = "3º Quinto";
        quarto = "4º Quinto";
        quinto = "5º Quinto";
    } else if (lang === "es") {
        primeiro = "1º Quinto";
        segundo = "2º Quinto";
        terceiro = "3º Quinto";
        quarto = "4º Quinto";
        quinto = "5º Quinto";
    }

    //Fim Traduções  -----------------------------------------  

    for (i = 0; i < array_1991.length; i++)
    {

        if ('RDPC1' == array_1991[i].sigla)
            umQuinto = array_1991[i].valor;

        if ('RDPC2' == array_1991[i].sigla)
            doisQuinto = array_1991[i].valor;

        if ('RDPC3' == array_1991[i].sigla)
            tresQuinto = array_1991[i].valor;

        if ('RDPC4' == array_1991[i].sigla)
            quatroQuinto = array_1991[i].valor;

        if ('RDPC5' == array_1991[i].sigla)
            cincoQuinto = array_1991[i].valor;
    }

        array_nome_1991.push(primeiro);
        array_valor_1991.push(umQuinto);
        array_nome_1991.push(segundo);
        array_valor_1991.push(doisQuinto);
        array_nome_1991.push(terceiro);
        array_valor_1991.push(tresQuinto);
        array_nome_1991.push(quarto);
        array_valor_1991.push(quatroQuinto);
        array_nome_1991.push(quinto);
        array_valor_1991.push(cincoQuinto);

    for (i = 0; i < array_nome_1991.length; i++) {
        dados.setValue(i, 0, array_nome_1991[i]);
        dados.setValue(i, 1, Number(array_valor_1991[i]));
    }

    var formatter = new google.visualization.NumberFormat({
        suffix: '',
        decimalSymbol: ',',
        groupingSymbol: '.'
    });
    formatter.format(dados, 1);

    var chart = new google.visualization.PieChart(document.getElementById('chartRendaPorQuintos91'));
    chart.draw(dados, {
        hAxis: {
            minValue: 0,
            maxValue: 100
        },
        slices: [{color: '#CAE1FF'}, {color: '#A4D3EE'}, {color: '#4F94CD'}, {color: '#4682B4'}, {color: '#5472B4'}],
        legend: {position: 'left', alignment: 'center'},
        chartArea: {right: 30, top: 50, width: "300", height: "300"}
    });
}

function graficoRendaPorQuintos00(lang, type) {

    var dados = new google.visualization.DataTable();
    var array_2000 = Array();
    var array_valor_2000 = Array();
    var array_nome_2000 = Array();

    array_2000 = jQuery.parseJSON($("#rend_2000").val());
    dados.addColumn('string', 'Data');
    dados.addRows(5);

    dados.addColumn('number', array_2000[2].nomecurto);

    var umQuinto = 0;
    var doisQuinto = 0;
    var tresQuinto = 0;
    var quatroQuinto = 0;
    var cincoQuinto = 0;

    //@#Traduções ---------------------------------------------

    //variáveis tradução
    var primeiro;
    var segundo;
    var terceiro;
    var quarto;
    var quinto;

    if (lang === "pt") {
        primeiro = "1º Quinto";
        segundo = "2º Quinto";
        terceiro = "3º Quinto";
        quarto = "4º Quinto";
        quinto = "5º Quinto";
    } else if (lang === "en") {
        primeiro = "1º Quinto";
        segundo = "2º Quinto";
        terceiro = "3º Quinto";
        quarto = "4º Quinto";
        quinto = "5º Quinto";
    } else if (lang === "es") {
        primeiro = "1º Quinto";
        segundo = "2º Quinto";
        terceiro = "3º Quinto";
        quarto = "4º Quinto";
        quinto = "5º Quinto";
    }

    //Fim Traduções  -----------------------------------------  

    for (i = 0; i < array_2000.length; i++)
    {

        if ('RDPC1' == array_2000[i].sigla)
            umQuinto = array_2000[i].valor;

        if ('RDPC2' == array_2000[i].sigla)
            doisQuinto = array_2000[i].valor;

        if ('RDPC3' == array_2000[i].sigla)
            tresQuinto = array_2000[i].valor;

        if ('RDPC4' == array_2000[i].sigla)
            quatroQuinto = array_2000[i].valor;

        if ('RDPC5' == array_2000[i].sigla)
            cincoQuinto = array_2000[i].valor;
    }

        array_nome_2000.push(primeiro);
        array_valor_2000.push(umQuinto);
        array_nome_2000.push(segundo);
        array_valor_2000.push(doisQuinto);
        array_nome_2000.push(terceiro);
        array_valor_2000.push(tresQuinto);
        array_nome_2000.push(quarto);
        array_valor_2000.push(quatroQuinto);
        array_nome_2000.push(quinto);
        array_valor_2000.push(cincoQuinto);

    for (i = 0; i < array_nome_2000.length; i++) {
        dados.setValue(i, 0, array_nome_2000[i]);
        dados.setValue(i, 1, Number(array_valor_2000[i]));
    }

    var formatter = new google.visualization.NumberFormat({
        suffix: '',
        decimalSymbol: ',',
        groupingSymbol: '.'
    });
    formatter.format(dados, 1);

    var chart = new google.visualization.PieChart(document.getElementById('chartRendaPorQuintos00'));
    chart.draw(dados, {
        hAxis: {
            minValue: 0,
            maxValue: 100
        },
        slices: [{color: '#CAE1FF'}, {color: '#A4D3EE'}, {color: '#4F94CD'}, {color: '#4682B4'}, {color: '#5472B4'}],
        chartArea: {left: 30, top: 50, width: (type !== "perfil_rm" && type !== "perfil_udh" ? "185" : "300"), height: "300"},
        legend: (type === "perfil_rm" || type === "perfil_udh" ? {position: 'left', alignment: 'center'} : 'none')
        
    });
}

function graficoRendaPorQuintos10(lang, type) {

    var dados = new google.visualization.DataTable();
    var array_2010 = Array();
    var array_valor_2010 = Array();
    var array_nome_2010 = Array();

    array_2010 = jQuery.parseJSON($("#rend_2010").val());
    dados.addColumn('string', 'Data');
    dados.addRows(5);

    dados.addColumn('number', array_2010[2].nomecurto);

    var umQuinto = 0;
    var doisQuinto = 0;
    var tresQuinto = 0;
    var quatroQuinto = 0;
    var cincoQuinto = 0;

    //@#Traduções ---------------------------------------------

    //variáveis tradução
    var primeiro;
    var segundo;
    var terceiro;
    var quarto;
    var quinto;

    if (lang === "pt") {
        primeiro = "1º Quinto";
        segundo = "2º Quinto";
        terceiro = "3º Quinto";
        quarto = "4º Quinto";
        quinto = "5º Quinto";
    } else if (lang === "en") {
        primeiro = "1º Quinto";
        segundo = "2º Quinto";
        terceiro = "3º Quinto";
        quarto = "4º Quinto";
        quinto = "5º Quinto";
    } else if (lang === "es") {
        primeiro = "1º Quinto";
        segundo = "2º Quinto";
        terceiro = "3º Quinto";
        quarto = "4º Quinto";
        quinto = "5º Quinto";
    }

    //Fim Traduções  -----------------------------------------  

    for (i = 0; i < array_2010.length; i++)
    {

        if ('RDPC1' == array_2010[i].sigla)
            umQuinto = array_2010[i].valor;

        if ('RDPC2' == array_2010[i].sigla)
            doisQuinto = array_2010[i].valor;

        if ('RDPC3' == array_2010[i].sigla)
            tresQuinto = array_2010[i].valor;

        if ('RDPC4' == array_2010[i].sigla)
            quatroQuinto = array_2010[i].valor;

        if ('RDPC5' == array_2010[i].sigla)
            cincoQuinto = array_2010[i].valor;
    }

        array_nome_2010.push(primeiro);
        array_valor_2010.push(umQuinto);
        array_nome_2010.push(segundo);
        array_valor_2010.push(doisQuinto);
        array_nome_2010.push(terceiro);
        array_valor_2010.push(tresQuinto);
        array_nome_2010.push(quarto);
        array_valor_2010.push(quatroQuinto);
        array_nome_2010.push(quinto);
        array_valor_2010.push(cincoQuinto);

    for (i = 0; i < array_nome_2010.length; i++) {
        dados.setValue(i, 0, array_nome_2010[i]);
        dados.setValue(i, 1, Number(array_valor_2010[i]));
    }

    var formatter = new google.visualization.NumberFormat({
        suffix: '',
        decimalSymbol: ',',
        groupingSymbol: '.'
    });
    formatter.format(dados, 1);

    var chart = new google.visualization.PieChart(document.getElementById('chartRendaPorQuintos10'));
    chart.draw(dados, {
        hAxis: {
            minValue: 0,
            maxValue: 100
        },
        slices: [{color: '#CAE1FF'}, {color: '#A4D3EE'}, {color: '#4F94CD'}, {color: '#4682B4'}, {color: '#5472B4'}],
        chartArea: {left: 30, top: 50, width: (type === "perfil_udh" ? "300" : "185"), height: "300"},
        legend: (type === "perfil_udh" ? {position: 'left', alignment: 'center'} : 'none')
    });
}

function PnudChart(chartDiv) { 

  var chartDiv = chartDiv;
  var canvas;
  var context;
  var scale;
  var bottomDistance = 30; //distancia no eixo em relacão ao lado inferior do canvas
  var axisLabelDistance = 14; //distancia da label do eixoem relacão ao próprio eixo;
  var options;

  //-----------PUBLIC-----------
  this.draw = function(data, optionsConfig)
  {
    //Atualização em 08/03/2015 por Reinaldo Aparecido Rocha Filho
    options = optionsConfig;

    canvas = document.createElement('canvas');
    canvas.width = 800;
    canvas.height = 300;
    chartDiv.innerHTML = "";
    chartDiv.appendChild(canvas);
    context =  canvas.getContext('2d');
    scale = canvas.width;
    
    //Cria o conteúdo do popover com as informações de IDH
    //da região metropolitana
    var spanInfoRM = document.createElement('span');
    var estaAbertoRM = false;
    $(spanInfoRM).popover({html: true, title: 'RM', placement: 'top', content: '<strong>Menor IDHM:</strong> '+ formatValue(data.minValueRM.toFixed(3)) +' <br/><strong>Maior IDHM:</strong> ' + formatValue(data.maxValueRM.toFixed(3)) });
    
    //Ao movimentar sobre o gráfico do RM
    $(canvas).mousemove(function (e){
        var parentOffset = $(this).parent().offset(); 
        var relX = e.pageX - parentOffset.left;
        var relY = e.pageY - parentOffset.top;
        var valDeX = relX / 859.5; 
 
        if((valDeX >= data.minValueRM && valDeX <= data.maxValueRM) && (relY >= 204 && relY <= 240) && !estaAbertoRM)
        {
            estaAbertoRM = true;
            chartDiv.appendChild(spanInfoRM);
            $(spanInfoRM).popover('show');
        }
        else if(((valDeX < data.minValueRM || valDeX > data.maxValueRM) || (relY < 204 || relY > 240)) && estaAbertoRM)
        {
            estaAbertoRM = false;
            $(spanInfoRM).popover('hide');
        }  
        
        if(estaAbertoRM)
        {
             $('.popover').css('top',e.pageY - 97);
             $('.popover').css('left',e.pageX - 114);
        }
    });
    
    //Cria o conteúdo do popover com as informações de IDH
    //do município
    var spanInfoMun = document.createElement('span');
    var estaAbertoMun = false;
    $(spanInfoMun).popover({html: true, title: 'Município', placement: 'top', content: '<strong>Menor IDHM:</strong> '+ formatValue(data.minValueMun.toFixed(3)) +' <br/><strong>Maior IDHM:</strong> ' + formatValue(data.maxValueMun.toFixed(3)) });
    
    //Ao movimentar sobre o gráfico do RM
    $(canvas).mousemove(function (e){
        var parentOffset = $(this).parent().offset(); 
        var relX = e.pageX - parentOffset.left;
        var relY = e.pageY - parentOffset.top;
        var valDeX = relX / 859.5; 
        
        if((valDeX >= data.minValueMun && valDeX <= data.maxValueMun) && (relY >= 125 && relY <= 159) && !estaAbertoMun)
        {
            estaAbertoMun = true;
            chartDiv.appendChild(spanInfoMun);
            $(spanInfoMun).popover('show');
        }
        else if(((valDeX < data.minValueMun || valDeX > data.maxValueMun) || (relY < 125 || relY > 159)) && estaAbertoMun)
        {
            estaAbertoMun = false;
            $(spanInfoMun).popover('hide');
        }  
        
        if(estaAbertoMun)
        {
             $('.popover').css('top',e.pageY - 97);
             $('.popover').css('left',e.pageX - 114);
        }
    });
    

    drawAxis();

    drawMun(data.minValueMun.toFixed(3),data.maxValueMun.toFixed(3),data.nomeMun,data.idhValue.toFixed(3));

    drawRM(data.minValueRM.toFixed(3),data.maxValueRM.toFixed(3),data.nomeRM,data.idhValue.toFixed(3));
    
    drawIDH(data.idhValue.toFixed(3));

  };

//-----------PRIVATE-----------
  var drawAxis = function()
  {
    var posX = 0;
    var posX2 = canvas.width; //eixo pega toda a largura do canvas
    var posY = canvas.height-bottomDistance; //posY será a mesma
    
    drawLine(posX,posY,posX2,posY,"#0067A1",2,'TRUE');

    //label dos números
    drawXAxisValue(0,posX+5);
    drawXAxisValue(1,posX2-5);

    drawString(options.stringIDHM,canvas.width/2,canvas.height,'center','#0067A1','14px Arial');
    
  }

  //-----------MUNICIPIO-----------
  /*
  * minIDH: menor IDHm dentro do município
  * maxIDH: maior IDHm dentro do município
  * IDHvalue: usado para posicionar a label sem ser sobreposta pela linha (TODO)
  */
  var drawMun = function(minIDH,maxIDH,name,IDHValue)
  {
    var posX = minIDH * scale;
    var posX2 = maxIDH * scale;
    var w = posX2 - posX;
    var posY = 120;
    drawRect(posX,posY,w,40,"#83CFDC");
    
    //Label
    drawString(options.stringMun,posX - 5,posY + 16,'right','gray','12px Arial');
    drawString(name,posX - 10 ,posY + 32,'right','dimgray','14px Arial');
    
    var enableDraw = false;

$("#canvas").mousedown(function(arg) {
    enableDraw = true;
});

$("#canvas").mouseup(function(arg) {
    enableDraw = false;
});

$("#canvas").mousemove(function(arg) {
    if(enableDraw){
        context.fillStyle = "#1477CC";
        var pos = getMousePos(canvas, arg);
        context.beginPath();
        context.arc(pos.x+50,pos.y,5,0,2*Math.PI);
        context.fill();
    }
});

    
   // drawXAxisValue(formatValue(minIDH),posX);
   // drawXAxisValue(formatValue(maxIDH),posX2);

  }

  var drawString = function(str, posX,posY,align,color,font ){
    
    if (font ==null) font = "14px Arial";
    if (color ==null) color = "grey";
    if (align ==null) align = "center";

    context.fillStyle = color;
    context.font = font;
    context.textAlign = align;
    context.fillText(str,posX,posY);

  }

  //-----------RM-----------
   /* 
  * minIDH: menor IDHm dentro da RM
  * maxIDH: maior IDHm dentro da RM
  * IDHvalue: usado para posicionar a label sem ser sobreposta pela linha (TODO)
  */
  var drawRM = function(minIDH,maxIDH,name,IDHValue)
  {
    var posX = minIDH * scale;
    var posX2 = maxIDH * scale;
    var w = posX2 - posX;
    var posY = 200;
    drawRect(posX,posY,w,40,"#C0D6A1");
    
    //Label
    // var str = options.stringRM +  + name;
    // context.fillStyle = "grey";
    // context.font = "14px Arial";
    // context.fillText(str,posX + 10,posY-5);

    drawString(options.stringRM,posX - 5,posY + 16,'right','gray','12px Arial');
    drawString(name,posX - 10 ,posY + 32,'right','dimgray','14px Arial');


    //drawXAxisValue(formatValue(minIDH),posX);
    //drawXAxisValue(formatValue(maxIDH),posX2);
  }

  //-----------UDH PRINCIPAL-----------
  var drawIDH = function(IDHValue)
  {
    var posX = IDHValue * scale;
    var posY = 10;

    //Linha
    drawLine(posX,posY,posX,canvas.height - bottomDistance,"#0067A1",1,'TRUE');

    //Icone
    imageObj = new Image();
    imageObj.src = 'assets/img/perfil/icon.png';
    
    imageObj.onload = function(){
        var posXImg = posX - (this.width/2); //centralizando
        context.drawImage(imageObj,posXImg,posY,63,76);
      };

    //Label
   
    //var str = options.stringIDHM + ": " + formatValue(IDHValue);
    //var str = formatValue(IDHValue);

    //var posYLabel = canvas.height-bottomDistance + axisLabelDistance;

    drawXAxisValue(formatValue(IDHValue),posX);
   

  }

  

  //-----------DRAW UTILS-----------   
  //para evitar repetição de código, criei as funções básicas separadas

  var drawXAxisValue = function(str,posX){
    context.font = "14px Arial";
    context.fillStyle = "#0067A1";
    context.textAlign = "center";
    var posYLabel = canvas.height-bottomDistance + axisLabelDistance;
    context.fillText(str,posX,posYLabel);
  }

  var formatValue = function(value){
    var str = value.toString();
    str = str.replace(".", ",");
    return str;
  }

  var drawLine = function(x,y,x2,y2,color,lineWidth,dashed)
  {
    context.beginPath();
    context.moveTo(x,y);
    context.lineTo(x2,y2);
    context.lineWidth = lineWidth;
    if (dashed)
      context.setLineDash([2,3]);
    context.strokeStyle = color;  
    context.closePath();
    context.stroke();

  }

  var drawRect = function(x,y,w,h,colorfill)
  {
    context.beginPath();
    context.rect(x, y, w, h);
    context.fillStyle = colorfill;
    context.fill();
    //descomentar se precisarmos de retangulos com bordas
    //context.lineWidth = 1;
    //context.strokeStyle = colorstroke;
    //context.stroke();
  }
}



//function PnudChart(chartDiv) {
//
//    var chartDiv = chartDiv;
//    var canvas;
//    var context;
//    var scale;
//    var bottomDistance = 30; //distancia no eixo em relacão ao lado inferior do canvas
//    var options;
//
//    //-----------PUBLIC-----------
//    this.draw = function(data, optionsConfig)
//    {
//        options = optionsConfig;
//
//        canvas = document.createElement('canvas');
//        canvas.width = 800;
//        canvas.height = 300;
//        chartDiv.appendChild(canvas);
//        context = canvas.getContext('2d');
//        scale = canvas.width;
//
//
//
//        drawAxis();
//
//        drawMun(data.minValueMun, data.maxValueMun, data.nomeMun, data.idhValue);
//
//        drawRM(data.minValueRM, data.maxValueRM, data.nomeRM, data.idhValue);
//
//        drawIDH(data.idhValue);
//
//    }
//
////-----------PRIVATE-----------
//    var drawAxis = function()
//    {
//        var posX = 0;
//        var posX2 = canvas.width; //eixo pega toda a largura do canvas
//        var posY = canvas.height - bottomDistance; //posY será a mesma
//
//        drawLine(posX, posY, posX2, posY, "#0067A1", 2, 'TRUE');
//
//        //label dos números
//        context.font = "14px Arial";
//        context.fillText("0", posX, posY + 14);
//        context.fillText("1", posX2 - 14, posY + 14);
//    }
//
//    //-----------MUNICIPIO-----------
//    /*
//     * minIDH: menor IDHm dentro do município
//     * maxIDH: maior IDHm dentro do município
//     * IDHvalue: usado para posicionar a label sem ser sobreposta pela linha (TODO)
//     */
//    var drawMun = function(minIDH, maxIDH, name, IDHValue)
//    {
//        var posX = minIDH * scale;
//        var posX2 = maxIDH * scale;
//        var w = posX2 - posX;
//        var posY = 120;
//        drawRect(posX, posY, w, 40, "#83CFDC");
//        //Label
//        var str = options.stringMun + ": " + name;
//        context.fillStyle = "black";
//        context.font = "14px Arial";
//        context.textAlign = "center";
//        context.fillText(str, posX, posY - 5);
//    }
//
//    //-----------RM-----------
//    /* 
//     * minIDH: menor IDHm dentro da RM
//     * maxIDH: maior IDHm dentro da RM
//     * IDHvalue: usado para posicionar a label sem ser sobreposta pela linha (TODO)
//     */
//    var drawRM = function(minIDH, maxIDH, name, IDHValue)
//    {
//        var posX = minIDH * scale;
//        var posX2 = maxIDH * scale;
//        var w = posX2 - posX;
//        var posY = 200;
//        drawRect(posX, posY, w, 40, "#C0D6A1");
//        //Label
//        var str = options.stringRM + ": " + name;
//        context.fillStyle = "black";
//        context.font = "14px Arial";
//        context.fillText(str, posX + 10, posY - 5);
//    }
//
//    //-----------UDH PRINCIPAL-----------
//    var drawIDH = function(IDHValue)
//    {
//        var posX = IDHValue * scale;
//        var posY = 10;
//
//        //Linha
//        drawLine(posX, posY, posX, canvas.height - bottomDistance, "#0067A1", 1, 'TRUE');
//
//        //Icone
//        imageObj = new Image();
//        imageObj.src = 'icon.png';
//
//        imageObj.onload = function() {
//            var posXImg = posX - (this.width / 2); //centralizando
//            context.drawImage(imageObj, posXImg, posY, 63, 76);
//        };
//
//        //Label
//        var str = options.stringIDHM + ": " + IDHValue;
//        context.font = "14px Arial";
//        context.fillStyle = "#0067A1";
//        context.textAlign = "center";
//        context.fillText(str, posX, canvas.height);
//    }
//
//    //-----------DRAW UTILS-----------   
//    //para evitar repetição de código, criei as funções básicas separadas
//
//    var drawLine = function(x, y, x2, y2, color, lineWidth, dashed)
//    {
//        context.beginPath();
//        context.moveTo(x, y);
//        context.lineTo(x2, y2);
//        context.lineWidth = lineWidth;
//        if (dashed)
//            context.setLineDash([2, 3]);
//        context.strokeStyle = color;
//        context.closePath();
//        context.stroke();
//
//    }
//
//    var drawRect = function(x, y, w, h, colorfill)
//    {
//        context.beginPath();
//        context.rect(x, y, w, h);
//        context.fillStyle = colorfill;
//        context.fill();
//        //descomentar se precisarmos de retangulos com bordas
//        //context.lineWidth = 1;
//        //context.strokeStyle = colorstroke;
//        //context.stroke();
//    }
//}



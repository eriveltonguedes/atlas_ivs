var img;
google.load("visualization", "1", {packages: ["corechart"]});
google.setOnLoadCallback(visualization);

function visualization() {
  var cont = 0;
  var i = 0;
  var array_graphic = new Array();
  var array_table = new Array();
  array_table.push(lang_mng.getString('histograma_intervalo'));

  if(window.histogram_value == undefined){
    return;
  }
  $('.titulo_histograma').append('<div class="subtitulo-histograma" style="line-height: 1.3; font-size:20px; font-weight: bold; text-align: center;"> ('+ window.histogram_value.ano_referencia +') </div>');
  array_table.push(lang_mng.getString('histograma_frequencia'));
  array_table.push({role: 'style'});
  array_table.push({ role: 'annotation' });
  array_graphic.push(array_table);
  for(i = 0; i < window.histogram_value.qtdPrintMedia; i++) {
    array_table = new Array();
    array_table.push(window.histogram_value.intervalo[i]);
    array_table.push(window.histogram_value.frequencia[i]);
    array_table.push('stroke-color: #ccc; fill-color: #0077b3');
    array_table.push(''+window.histogram_value.frequencia[i]+'');
    array_graphic.push(array_table);
  }

  var options = {
    width : 960,
    left: 90,
    top: 50,
    vAxis : {
      viewWindow : {
                min : 0     //Menor valor da vertical
              },
              titleTextStyle : {
                italic : false      //Italic false
              },
            title: lang_mng.getString('histograma_frequencia'),    //Título da vertical
//            ticks: [0,100,200,300,400,500,600,700,800],
minorGridlines : {
  count: 2
},
format : '#'
},
legend : {
              position : 'none'     //Sem legenda
            },
            isStacked: true,
            height: 450,
            chartArea:{
//              height: 600
width: 790
},
bar : {
  groupWidth : '100%'
},
fontSize: 12,
animation: {
  easing: 'linear',
  textStyle: {
    fontName: 'Times-Roman',
    fontSize: 15,
    bold: true,
    italic: true,
                color: '#871b47',     // The color of the text.
                auraColor: '#d799ae', // The color of the text outline.
                opacity: 0.8          // The transparency of the text.
              }
            },
            hAxis : {
              title: lang_mng.getString('histograma_intervalo'),    //Título da horizontal
              titleTextStyle : {
                italic : false      //Italic false
              },
              format : window.histogram_value.format
            }
          };

          var data = google.visualization.arrayToDataTable(array_graphic);
          var chart = new google.visualization.ColumnChart(document.getElementById(window.histogram_value.ne));

//    chart_img = chart.getImageURI();
//    google.visualization.events.addListener(chart, 'ready', function () {
//        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '" style="heigth: 400px;">';
//     });

chart.draw(data, options);

//    var my_div = document.getElementById('chart_img');
//    var my_chart = new google.visualization.ChartType(chart_div);
//
//    google.visualization.events.addListener(my_chart, 'ready', function () {
//      my_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
//    });
//
//    my_chart.draw(data);
}



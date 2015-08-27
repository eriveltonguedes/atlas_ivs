google.load('visualization', '1', {'packages': ['corechart']});
google.setOnLoadCallback(drawChartBolha);

function drawChartBolha() {
//    console.log('drawChartBolha');
    var cont = 0;
    var array_graphic = new Array();
    var array_table = new Array();
//    console.log(obj[0][0]);
//    console.log('obj[0]: ' + obj[0]);
//    console.log('obj[1][1]: '+obj[1][1]);
//    console.log('obj[1][3]: '+obj[1][2]);
//    console.log('obj[1][4]: '+obj[1][4]);
    if (obj[0] != 0) {
//        console.log('Entrei');
//        console.log('obj diferente de null');
        var data = new google.visualization.DataTable();
        for (cont = 0; cont < 1; cont++) {
            data.addColumn('string', 'Lugar');
            for (var j = 0; j < obj[0].length - 1; j++) {
                console.log('obj[0][' + (j + 1) + ']: ' + obj[0][j + 1]);
                data.addColumn('number', obj[0][j + 1]);
            }
        }

        var tam = obj.length;
        data.addRows(tam - 1);
        for (var i = 0; i < (tam - 1); i++) {
            var k = 0;
            for (var j = 0; j < 5; j++) {
                data.setValue(i, j, obj[i + 1][k]);
                k++;
            }
        }

        var options = {
            colorAxis: {/*colors: ['red', 'blue'],*/ legend: {position: 'none'}},
            axisTitlesPosition: 'none',
            chartArea: {left: 70, top: 28, width: "80%", height: "85%"},
            enableInteractivity: true,
            hAxis: {gridlines: {count: 5}},
            sortBubblesBySize: true,
            tooltip: {trigger: 'focus'}
            //explorer: {actions: ['dragToZoom', 'rightClickToReset']}

//          backgroundColor: 'pink',
//          hAxis: {title: 'Life Expectancy'},
//          vAxis: {title: 'Fertility Rate'}
        };

        var chart = new google.visualization.BubbleChart(document.getElementById('chart_div'));

        chart.draw(data, options);
    }
    
    else{
        $("#chart_div").html("");
    }
}
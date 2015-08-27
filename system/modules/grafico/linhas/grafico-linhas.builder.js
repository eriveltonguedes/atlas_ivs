google.load('visualization', '1', {
    'packages': ['corechart']
});
google.setOnLoadCallback(drawChart);

function drawChart() {
//    console.log('drawChart');
//    console.log('obj[nome][0]: '+obj['nome'][0]);
    if (obj['nome'][0] != 0) {
        var data = new google.visualization.DataTable();
        for (i = 0; i < 1; i++) {
            data.addColumn('number', 'Ano');
            for (j = 0; j < obj['nome'].length; j++) {
                data.addColumn('number', obj['nome'][j]);
            }
        }

        var tam = obj['nome'].length;
        var linhas = obj['valor'].length;
        data.addRows(3);
        var k = 0;
        var c = 0;
        for (i = 0; i < 3; i++) {
            data.setValue(k, 0, Number(obj['ano'][c]));
            for (var j = 1; j <= tam; j++) {
                data.setValue(i, j, Number(obj['valor'][c]));
                c++;
            }
            k++;

        }

        var options = {
            curveType: 'function', //Deixa a curva mais 'lisa'
            legend: {position: 'none'}, //Retira a legenda
            hAxis: {direction: 1, textPosition: 'out', gridlines: {count: 3}, minorGridlines: {count: 2}, viewWindow: {max: 2010, min: 1990}, format: '####', axAlternation: 4, minValue: 1990, maxValue: 2010},
            chartArea: {left: 70, top: 10, width: "85%", height: "90%"},
            axisTitlesPosition: 'none',
            vAxis: {gridlines: {count: 10}}
//        width: 400,
            //height: 900,
            //selectionMode: 'multiple',          // Allow multiple simultaneous selections.
            //tooltip: {trigger: 'selection'},    // Trigger tooltips on selections
            //aggregationTarget: 'category',      // Group selections by x-value.
//        
//        chartArea: {
//            left:100,
//            top: 10,
//            width:"60%"
//        },
//        legend: null,
            //focusTarget: 'datum',
            //hAxis: {direction: 1, textPosition: 'out', gridlines: {count: 3}, minorGridlines: {count: 2}, viewWindow: {max: 2010, min: 1991}},
            //lineWidth: 2,
            //vAxis: {format: '#.###'},
            //reverseCategories: true
            //pointSize: 5
        };

        // Create and draw the visualization.
        var chart = new google.visualization.LineChart(document.getElementById('chart_divLinha'));
        chart.draw(data, options);
    }
    
    else{
        $("#chart_divLinha").html("");
    }
}

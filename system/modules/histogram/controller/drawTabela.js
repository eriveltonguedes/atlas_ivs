function drawTable(){
    $('#table_div').html('');
    var tabela;
    tabela = 
            '<table >'+
                 '<tbody>'+
                         '<tr>'+
                            '<td style="border-left: 1px solid #ccc; text-align: center; font-weight: bold">'+ lang_mng.getString('histograma_media')+'</td>'+
                            '<td style="border-left: 1px solid #ccc; text-align: center; font-weight: bold">'+ lang_mng.getString('histograma_mediana')+'</td>'+
                            '<td style="border-left: 1px solid #ccc; text-align: center; font-weight: bold">'+ lang_mng.getString('histograma_variancia')+'</td>'+
                            '<td style="border-left: 1px solid #ccc; text-align: center; font-weight: bold; border-right: 1px solid #ccc">'+ lang_mng.getString('histograma_desvioPadrao')+'</td>'+
                         '</tr>'+
                         '<tr>'+
                            '<td style="border-left: 1px solid #ccc; text-align: center; ">'+ window.histogram_value.media +'</td>'+
                            '<td style="border-left: 1px solid #ccc; text-align: center; ">'+ window.histogram_value.mediana +'</td>'+
                            '<td style="border-left: 1px solid #ccc; text-align: center; ">'+ window.histogram_value.variancia +'</td>'+
                            '<td style="border-left: 1px solid #ccc; border-right: 1px solid #ccc; text-align: center; ">'+ window.histogram_value.desvio_padrao +'</td>'+
                         '</tr>'+  
                 '</tbody>'+
            '</table>';

    $( "#table_div" ).html(tabela);
}    
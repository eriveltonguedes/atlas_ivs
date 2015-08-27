
$(document).ready(function() {


    $('.containerPageComponentes .carregando').remove();


    $('#ok').click(function() {
        console.log('ok');
        $('#indicador-holder').hide();
    });


    $('#list_menu_indicador_dimensoes').delegate('li', 'click', function(event) {
        var dimensaoId, listaDeTemas, listaDeIndicadores;

        dimensaoId = $(this).attr('id').replace(/^dimensoes_/, '');
        listaDeTemas = filtraPorTemaId(dimensaoId);
        
        limpaTemas();
        
        // Se houver itens para lista de temas adicionar, 
        // se não houver adicionar logo em lista de indicadores 
        if ($.type(listaDeTemas) === 'object' && listaDeTemas.length > 0) {
            adicionaListaDeTemas(listaDeTemas);
        } else {
            listaDeIndicadores = filtraPeloId(dimensaoId);
            adicionaListaDeIndicadores(listaDeIndicadores);
        }
        
        event.stopPropagation();
    });


    $('#list_menu_indicador_indicadores').delegate('li', 'click', function(event) {
        var self = $(this), indicadorTexto, 
            maxTextoIndicador = 90;
        
        // valores para consulta do mapa
        var id, indicador, espacialidade, contexto, ano; 

        id = self.attr('id').replace(/[^0-9]/g, '');

        MAPA_API.setIndicador(id, true);

        id              = MAPA_API.getId();
        indicador       = MAPA_API.getIndicador();
        espacialidade   = MAPA_API.getEspacialidade();
        contexto        = MAPA_API.getContexto();
        ano        	= MAPA_API.getAno();
        
        // verifica dados de 1991
        verificaDados1991(contexto, espacialidade, id, indicador, ano);
     
        // se texto for pequeno aumentar fonte
        indicadorTexto = self.text();        
        if (indicadorTexto.length > 40) {
            $('#indicador_atual').css({
                fontSize: '16px', lineHeight: 1});
        }
        
        $('#indicador_atual')
                .attr('data-original-title', indicadorTexto)
                .text((indicadorTexto.length > maxTextoIndicador) 
                        ? indicadorTexto.slice(0, maxTextoIndicador) + '...' 
                        : indicadorTexto);

        // esconde carregando
        $('#indicador-holder').hide();
        
        event.stopPropagation();
    });


    $('#list_menu_indicador_temas').delegate('li', 'click', function(event) {
        var temaId, lista;
        
    	temaId  = $(this).attr('id').replace(/^temas_/, '');
        lista   = filtraPeloId(temaId);
        
        adicionaListaDeIndicadores(lista);
        
        event.stopPropagation();
    });

    
    $('#fecha_menu_indicador').bind('click', function(event) {
        $('#indicador-holder').hide();
        event.preventDefault();
    });


    $('#list_menu_indicador_dimensoes, #list_menu_indicador_temas').on('click', 'li', function(e) {
        $(this).parents('.box').find('li').removeClass('selecionado');
        $(this).toggleClass('selecionado');
        e.preventDefault();
    });


    $('#seletor_indicadores').click(function(event) {
        // refresh seletores já adicionados
    	limpaSeletor();
        
    	// carrega novamente os dados
        carregaIndicadores();
        
        // finalizada carregando
        $('#indicador-holder').toggle();
        
        // esconde outros seletores do mapa
        $('.lista-contexto,.lista-espacialidade,.aviso-ajuda').hide();
        
        $('#contexto_atual').removeClass('highlight');
        $('#botao-aviso-ajuda').removeClass('selecionado');
        
        event.preventDefault();
        event.stopPropagation();
    });

    
    // Tooltip
    $('#indicador_atual').tooltip({delay: 500, placement: 'bottom'});
    
    
    $('#btnConsulta').click(function(event) {
    	var url, split_url;
        
        if (typeof user_lang === 'undefined') {
            user_lang = 'pt';
        }
    	
    	split_url = location.href.split('/');
    	url = split_url.splice(0, split_url.length - ((split_url.length > 5) ? 2 : 1)).join('/')  + '/' + user_lang + '/consulta';
        
        location.href = url;
    });
    
    
    // http://stackoverflow.com/questions/152975/how-to-detect-a-click-outside-an-element
    $('html').click(function() {
        $('#indicador-holder').hide();
    });
    
});
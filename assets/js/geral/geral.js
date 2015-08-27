function Geral(listenerReady)
{
    lugares = new Array();
    indicadores = new Array();
	itensSelecteds = Array();
    listenerLugares = null;
    listenerIndicadores = null;
	
	totals = 0;
	
    var areas_tematicas = new Array();

    var ready = listenerReady;

    this.listenerReady = function(value)
    {
        ready = value;
    };

    this.setLugaresTeste = function(lugaresSelect) {
        _lugaresSelect = lugaresSelect;
    };

    this.getLugaresTeste = function(lugaresSelect) {
        return _lugaresSelect;
    };

    this.setEixo = function(eixo_) {
//        console.log('Geral - setEixo');
//        console.log('eixo_: '+eixo_);
        if (eixo_ == 'y') {
            eixo = 0;
        }
        else if (eixo_ == 'x') {
            eixo = 1;
        }
        else if (eixo_ == 'tam') {
            eixo = 2;
        }
        else if (eixo_ == 'cor') {
            eixo = 3;
        }
    };

    this.getEixo = function() {
//        console.log('Geral - getEixo');
        return eixo;
    };

    this.dispatchListeners = function(event)
    {
        listenerIndicadores(event, indicadores);
        listenerLugares(event, lugares);
    };

    /**
     * Retorna a posição do elemento adicionado
     * */
    this.addLugar = function(value)
    {
        var obj = lugares.push(value);

        if (listenerLugares)
            listenerLugares('check', obj);
        else
            alert('listener não esta definido!');


        return lugares.length - 1;
    };

    this.getLugaresPorEspacialidadeAtiva = function()
    {
        for (var i = 0; i < lugares.length; i++)
        {
            var item = lugares[i];

            //if (item.ac == true)
            if (typeof(item.l)!= "undefined")
                return item;
        }
    };

    this.removeLugar = function(espacialidade, id)
    {
        for (var i = 0; i < lugares.length; i++)
        {
            var item = lugares[i];

            if (item.e == espacialidade)
            {
                var locais = item.l;
                for (var k = 0; k < locais.length; k++)
                {
                    var local = locais[k];
                    if (local.id == id)
                    {
                        var obj = locais.splice(k, 1);
                        if (listenerLugares)
                            listenerLugares('nocheck', obj);
                    }
                }
            }
        }
    };

    this.removerIndicadoresTodos = function() {
        indicadores = new Array();
    };
    this.removeLugarTodos = function() {
        lugares = new Array();
    };

    this.removeTodosIndicadores = function() {
        indicadores = new Array();
    };

    this.getLugares = function()
    {
        return lugares;
    };

    this.getTotalLugares = function() {
        var total = 0;
        var instance = this;
        $.each(lugares, function(index, value) {
			//alert(index+' '+value.l);
			//console.log(value);
            if (value.e == 7)
            {
				if(false) // error its here
                $.each(value.l, function(index, value)
                {
					//console.log(value);
                    //var at = instance.getAreaTematica(value.id);
                    var at = instance.getAreaTematica(value);
                    //console.log(at);
                    total = parseInt(total) + parseInt(at.getSize());
                });

            }
            else
            {
                //total += value.l.length;
                if(value.l!=null) 
                total += value.l.length;
            }
        });
        return total;
    };
    
    this.setTotalLugares = function() {
		var instance = this;
        $.getJSON('system/modules/seletor-espacialidade/controller/totalEspacialidade.php', {lugs:lugares},function(data){
          instance.setTotals(data);
        });
    }

	this.setTotals = function(valor){
		totals=valor;
	}
	
	this.getTotals = function(){
		return totals;
	}

    this.getLugaresString = function() {
        ob = new Array();
        c = 0;
        for (var i in lugares) {
            temp = new Array();
            for (var j in lugares[i].l) {
                temp.push(lugares[i].l[j].id);
            }
            temp_ob = new Object();
            temp_ob.e = lugares[i].e;
            temp_ob.ids = temp.join(',');
            ob.push(temp_ob);
        }
        return ob;
    };
    
    this.getLugaresStringCC = function() {
        ob = new Array();
        for (var i in lugares) {
            temp_ob = new Object();
            temp_ob.e = lugares[i].e;
            if(lugares[i].l!=null) temp_ob.ids = lugares[i].l.join(',');
			else temp_ob.ids = "";
            if(lugares[i].mun.length!=0) temp_ob.mun = lugares[i].mun.join(',');
			else temp_ob.mun = "";
            if(lugares[i].est.length!=0) temp_ob.est = lugares[i].est.join(',');
			else temp_ob.est = "";
            if(lugares[i].rm.length!=0) temp_ob.rm = lugares[i].rm.join(',');
			else temp_ob.rm = "";
            if(lugares[i].udh.length!=0) temp_ob.udh = lugares[i].udh.join(',');
			else temp_ob.udh = "";
            
            ob.push(temp_ob);
        }
        return ob;
    };

    this.setLugares = function(value)
    {
        lugares = value;
        if (listenerLugares)
            listenerLugares('reloadList', value);
    };

	this.setEntitiesSelecteds = function(arraySelecteds){
		itensSelecteds = arraySelecteds;
		lugares=arraySelecteds;
	};
	
	this.getEntitiesSelecteds = function(){
		lugares = seletor.getSelectedsItens();
		return lugares;
		//return itensSelecteds;
	};
	
    /**
     * Retorna a posição do elemento adicionado
     * */
    this.addIndicador = function(value)
    {
        var obj = indicadores.push(value);
        if (listenerIndicadores)
            listenerIndicadores('check', obj);

        return indicadores.length - 1;
    };

    this.getIndicadores = function()
    {
        return indicadores;
    };

    this.getIndicadoresString = function()
    {
        temp = new Array();
        for (var i in indicadores) {
            temp.push(indicadores[i].a + ";" + indicadores[i].id);
        }
        return temp.join(",");
    };

    this.setIndicadores = function(value)
    {
        indicadores = value;
        if (listenerIndicadores)
            listenerIndicadores('reloadList', value);
    };

    this.removeIndicador = function(index)
    {
        for (var i = 0; i < indicadores.length; i++)
        {
            var item = indicadores[i];
            if (i == index)
            {
                var obj = indicadores.splice(i, 1);
                if (listenerIndicadores)
                    listenerIndicadores('nocheck', obj);
            }
        }
    };

    this.updateIndicador = function(index, ano)
    {
        for (var i = 0; i < indicadores.length; i++)
        {
            var item = indicadores[i];
            if (i == index)
                item.a = ano;
        }
    };

    this.setListenerLugares = function(listener)
    {
        listenerLugares = listener;
    };

    this.setListenerIndicadores = function(listener)
    {
        listenerIndicadores = listener;
    };

    /**
     * Retorna os indicadores da consulta, desprezando o ano e retirando os indicadores duplicados
     */
    this.getIndicadoresDistintos = function()
    {
        var indicadoresDistintos = new Array();

        for (var i = 0; i < indicadores.length; i++)
        {
            var item = indicadores[i];
            if (indicadoresDistintos.indexOf(item.id) == -1)
                indicadoresDistintos.push(item.id);
        }

        return indicadoresDistintos;
    };

    this.removeIndicadoresExtras = function()
    {
        var novosIndicadores = indicadores.slice();
        var hasCheck = false;

        for (var i = 0; i < novosIndicadores.length; i++)
        {
            var item = novosIndicadores[i];

            if (item.c == true)
            {
                hasCheck = true;
            }
        }
        if (hasCheck == false)
        {
            for (var i = 0; i < novosIndicadores.length; i++)
            {
                var item = novosIndicadores[i];

                if (i == 0)
                {
                    item.c = true;
                    break;
                }
            }
        }
        indicadores = novosIndicadores;
    };

    this.removeIndicadoresDuplicados = function()
    {
        var novosIndicadores = new Array();

        for (var i = 0; i < indicadores.length; i++)
        {
            var item = indicadores[i];

            if (containsInArray(novosIndicadores, item) == false)
            {
                var indicador = new IndicadorPorAno();
                indicador.id = item.id;
                indicador.a = 1;
                indicador.c = false;
                indicador.desc = item.desc;
                indicador.nc = item.nc;

                if (novosIndicadores.length == 0)
                    indicador.c = true;

                novosIndicadores.push(indicador);
            }
        }
        indicadores = novosIndicadores;
    };

    function containsInArray(array, value)
    {
        for (var i = 0; i < array.length; i++)
        {
            if (array[i].id == value.id)
                return true;
        }
        return false;
    }



    this.getAreaTematica = function(id)
    {
        var area = null;
        for (var i = 0; i < areas_tematicas.length; i++)
        {
            if (areas_tematicas[i].getId() == id) {
                area = areas_tematicas[i];
                break;
            }
        }
        return area;
    };

    this.AddOrUpdateAreaTematica = function(id, nome, size)
    {
        var area = null;


        for (var i = 0; i < areas_tematicas.length; i++)
        {
            if (areas_tematicas[i].getId() == id) {
                area = areas_tematicas[i].setNome(nome).setSize(size);
                break;
            }
        }

        if (area == null)
        {
            area = new AreaTematica();
            area.setId(id).setNome(nome).setSize(size);
            areas_tematicas.push(area);
        }
        return area;
    };
}

function IndicadorPorAno()
{
    this.id; //indicadoor
    this.a; //ano
    this.c; //checked
    this.desc; //nome_longo
    this.nc; //nome_curto

    this.setIndicador = function(id, a, c, desc, nc)
    {
        this.id = id;
        this.a = a;
        this.c = c;
        this.desc = desc;
        this.nc = nc;
    };
}

function Lugar()
{
    this.e; //espacialidade;
    this.ac; //ativo
    this.l = new Array(); //array de locais
}

function Local()
{
    this.id;
    this.n; //nome
    this.c; //checado
    this.s; //item selecionado
}

function AreaTematica()
{
    //atributos
    var _id = 0;
    var _nome = "";
    var _size = 0;


    //metodos
    this.setId = function(id)
    {
        _id = id;
        return this;
    };

    this.getId = function()
    {
        return _id;
    };

    this.setNome = function(nome)
    {
        _nome = nome;
        return this;
    };

    this.getNome = function()
    {
        return _nome;
    };

    this.setSize = function(size)
    {
        _size = size;
        return this;
    };

    this.getSize = function()
    {
        return _size;
    };
}

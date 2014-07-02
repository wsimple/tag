(function($){
	//3 niveles de prioridad: high, normal y low
	var types=['high','normal','low'],
		Qajax,
		running;

	$.qajax=function(p,opc){//p = prioridad (opcional)
		var data=[{}];
		if(p==='abort'||p==='cancel'){//si quieres cancelar el queue
			Qajax=null;
			opc=null;
			running=null;
		}else if(typeof p==='number'){//si p es un numero, buscamos el nombre, si no existe elegimos normal
			p=types[p+1]||types[1];
		}else if(!opc){//si hay un solo parametreo, p trae las opciones y la prioridad sera normal
			opc=p;
			p=types[1];
		}
		data.push(opc);
		if(!Qajax) Qajax={high:[],normal:[],low:[]};
		if(p&&Qajax[p]&&data[1]){//proseed if exist priority and data
			var after={};
			['before','done','always','fail','then'].forEach(function(fn){
				after[fn]=function(value){
					if(!data[0][fn])
						data[0][fn]=value;
					else{
						var tmp=data[0][fn];
						data[0][fn]=function(){
							tmp.apply(this,arguments);
							value.apply(this,arguments);
						};
					}
					return after;
				};
			});
			//if qajax not exist, fill it empty
			Qajax[p].push(data);
			//if not runing, start queue
			if(!running){
				running=true;
				setTimeout(doRequest,10);
			}
			return after;
		}
	};
	//run the next query
	function doRequest(){
		running=true;
		var data=getNext();
		if(data){
			if(data[0]['before']){
				data[0]['before']();
				delete data[0]['before'];
			}
			var x=$.ajax(data[1]);
			for(var fn in data[0]) x[fn](data[0][fn]);
			x.always(doRequest);
		}
	}
	//get next query
	function getNext(){
		for(var i in Qajax){
			if(Qajax[i].length>0) return Qajax[i].shift();
		}
		running=false;
		return null;
	}
})(jQuery);
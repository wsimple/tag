/*
* jQuery.qajax - A queue for ajax requests
* 
* (c) 2011 Corey Frang
* Dual licensed under the MIT and GPL licenses.
*
* Requires jQuery 1.5+
*/
(function($){
	/*
	 * set 3 levels of priority: high, normal & low
	 */
	var types=['high','normal','low'],
		Qajax,
		running;

	$.qajax=function(p,opc){//p = priority (optional)
		var data=[{}];
		if(p==='abort'||p==='cancel'){//if you want to stop queues
			Qajax=null;
			opc=null;
			running=null;
		}else if(!opc){//if only 1 parameter, p contain options, and priority is normal
			data.push(p);
			p=types[1];
		}else{
			data.push(opc);
		}
		if(typeof p==='number') p=types[p];//if priority is a number, change it to text
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
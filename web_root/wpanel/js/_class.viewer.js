/*
Author:
	luistar15, <leo020588 [at] gmail.com>
License:
	MIT License

Class
	viewer v0.9 (rev.08-12-08)

Arguments:
	items: dom collection | required
	parameters - see Parameters below

Parameters:
	sizes: obj | item sizes (px) | default: {w:480,h:240}
	mode: string OR array | 'rand','top','right','bottom','left','alpha' | default: 'rand'
	modes: array | default: ['top','right','bottom','left','alpha']
	fxOptions: object | Fx.Tween options | default: {duration:500}
	interval: int | for periodical | default: 5000

Methods:
	previous(manual): walk to previous item
		manual: bolean | default:false
	next(manual): walk to next item
		manual: bolean | default:false
	play(wait): auto walk items
		wait: boolean | required
	stop(): stop auto walk
	walk(item,manual): walk to item
		item: int | required
		manual: bolean | default:false

Requires:
	mootools 1.2 core
*/

var viewer = new Class({

	mode: 'rand',
	modes: ['top','right','bottom','left','alpha'],
	sizes: {w:400,h:250},
	fxOptions: {duration:500},
	interval: 5000,

	initialize: function(items,options){
		if(options) for(var o in options) this[o]=options[o];
		//
		if(this.buttons){
			this.buttons.previous.addEvent('click',this.previous.bind(this,[true]));
			this.buttons.next.addEvent('click',this.next.bind(this,[true]));
		}
		this.__current = 0;
		this.__previous = null;
		this.items = items.setStyle('display','none');
		this.items[this.__current].setStyle('display','block');
		this.disabled = false;
		this.attrs = {
			left: ['left',-this.sizes.w,0,'px'],
			top: ['top',-this.sizes.h,0,'px'],
			right: ['left',this.sizes.w,0,'px'],
			bottom: ['top',this.sizes.h,0,'px'],
			alpha: ['opacity',0,1,'']
		};
		this.rand = this.mode=='rand';
		this.sequence = typeof(this.mode)=='object' ? this.mode : false;
		this.curseq = 0;
		this.timer = null;
	},

	walk: function(n,manual){
		if(this.__current!==n && !this.disabled){
			this.disabled = true;
			if(manual){
				this.stop();
			}
			if(this.rand){
				this.mode = this.modes.getRandom();
			}else if(this.sequence){
				this.mode = this.sequence[this.curseq];
				this.curseq += this.curseq+1<this.sequence.length ? 1 : -this.curseq;
			}
			this.__previous = this.__current;
			this.__current = n;
			var a = this.attrs[this.mode].associate(['p','f','t','u']);
			for(var i=0;i<this.items.length;i++){
				if(this.__current===i){
					this.items[i].setStyles($extend({'display':'block','z-index':'2'},JSON.decode('{"'+a.p+'":"'+a.f+a.u+'"}')));
				}else if(this.__previous===i){
					this.items[i].setStyles({'z-index':'1'});
				}else{
					this.items[i].setStyles({'display':'none','z-index':'0'});
				}
			}
			this.items[n].set('tween',$merge(this.fxOptions,{onComplete:this.onComplete.bind(this)})).tween(a.p,a.f,a.t);
		}
	},

	play: function(wait){
		this.stop();
		if(!wait){
			this.next();
		}
		this.timer = this.next.periodical(this.interval,this,[false]);
	},

	stop: function(){
		$clear(this.timer);
	},

	next: function(manual){
		this.walk(this.__current+1<this.items.length ? this.__current+1 : 0,manual);
	},

	previous: function(manual){
		this.walk(this.__current>0 ? this.__current-1 : this.items.length-1,manual);
	},

	onComplete: function(){
		this.disabled = false;
		this.items[this.__previous].setStyle('display','none');
		if(this.onWalk) this.onWalk(this.__current);
	}
});
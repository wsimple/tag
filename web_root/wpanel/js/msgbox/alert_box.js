var AlertBox = new Class({
  Implements: [Chain],

	getOptions: function(){
		return {
			name: 'AlertBox',
			zIndex: 65555,
			onReturn: false,
			onReturnFunction : $empty,
			BoxStyles: {
				'width': 500
			},
			OverlayStyles: {
				'background-color': '#000',
				'opacity': 0.8
			},
			showDuration: 200,
			showEffect: Fx.Transitions.Elastic.easeIn,
      		closeDuration: 100,
			closeEffect: Fx.Transitions.Elastic.easeOut,
			moveDuration: 500,
			moveEffect: Fx.Transitions.Back.easeOut,
			onShowStart : $empty,
			onShowComplete : $empty,
			onCloseStart : $empty,
			onCloseComplete : function(properties) {
				this.options.onReturnFunction(this.options.onReturn);
			}.bind(this)
		};
	},

	initialize: function(options){
    this.i=0;
    
		this.setOptions(this.getOptions(), options);

		this.Overlay = new Element('div', {
			'id': 'BoxOverlay',
			'styles': {
				'display': 'none',
				'z-index': this.options.zIndex,
				'position': 'absolute',
				'top': '0',
				'left': '0',
				'background-color': this.options.OverlayStyles['background-color'],
				'opacity': 0,
				'height': window.getScrollHeight() + 'px',
				'width': window.getScrollWidth() + 'px'
			}
		});

		this.Content = new Element('div', {
			'id': this.options.name + '-BoxContenedor'
		});

    this.Contenedor = new Element('div', {
      'id': this.options.name + '-BoxContent'
    }).adopt(this.Content);

		this.InBox = new Element('div', {
			'id': this.options.name + '-InBox'
		}).adopt(this.Contenedor);;
		
		this.Box = new Element('div', {
			'id': this.options.name + '-Box',
			'styles': {
				'display': 'none',
				'z-index': this.options.zIndex + 2,
				'position': 'absolute',
				'top': '0',
				'left': '0',
				'width': this.options.BoxStyles['width'] + 'px'
			}
		}).adopt(this.InBox);

    this.Overlay.injectInside(document.body);
    this.Box.injectInside(document.body);

    this.preloadImages();
    
		window.addEvent('resize', function() {
			if(this.options.display == 1) {
				this.Overlay.setStyles({
					'height': window.getScrollHeight() + 'px',
					'width': window.getScrollWidth() + 'px'
				});
				this.replaceBox();
			}
		}.bind(this));
		
		window.addEvent('scroll', this.replaceBox.bind(this));
	},

  preloadImages: function() {
    var img = new Array(2);
    img[0] = new Image();img[1] = new Image();img[2] = new Image();
    img[0].src = this.Box.getStyle('background-image').replace(new RegExp("url\\('?([^']*)'?\\)", 'gi'), "$1");
    img[1].src = this.InBox.getStyle('background-image').replace(new RegExp("url\\('?([^']*)'?\\)", 'gi'), "$1");
    img[2].src = this.Contenedor.getStyle('background-image').replace(new RegExp("url\\('?([^']*)'?\\)", 'gi'), "$1");
  },


	/*
	Property: display
		Show or close box
		
	Argument:
		option - integer, 1 to Show box and 0 to close box (with a transition).
	*/	
	display: function(option){
		if(this.Transition)
			this.Transition.cancel();				

		// Show Box	
		if(this.options.display == 0 && option != 0 || option == 1) {

      if(Browser.Engine.trident4)
        $$('select', 'object', 'embed').each(function(node){ node.style.visibility = 'hidden' });

			this.Overlay.setStyle('display', 'block');
			this.options.display = 1;
			this.fireEvent('onShowStart', [this.Overlay]);

			this.Transition = new Fx.Tween(this.Overlay,
				{
          property: 'opacity',
					duration: this.options.showDuration,
					transition: this.options.showEffect,
					onComplete: function() {

						sizes = window.getSize();
						scrollito = window.getScroll();
						this.Box.setStyles({
							'display': 'block',
							'left': (scrollito.x + (sizes.x - this.options.BoxStyles['width']) / 2).toInt()
						});

						this.replaceBox();
						this.fireEvent('onShowComplete', [this.Overlay]);

					}.bind(this)
				}
			).start(this.options.OverlayStyles['opacity']);

		}
		// Close Box
		else {

      if(Browser.Engine.trident4)
        $$('select', 'object', 'embed').each(function(node){ node.style.visibility = 'visible' });

      this.queue.delay(500,this);

			this.Box.setStyles({
				'display': 'none',
				'top': 0
			});
			this.Content.empty();
			this.options.display = 0;

			this.fireEvent('onCloseStart', [this.Overlay]);

      if(this.i==1) {
        this.Transition = new Fx.Tween(this.Overlay,
          {
            property: 'opacity',
            duration: this.options.closeDuration,
            transition: this.options.closeEffect,
            onComplete: function() {
                this.fireEvent('onCloseComplete', [this.Overlay]);
            }.bind(this)
          }
        ).start(0);
      }

		}			
	},

	/*
	Property: replaceBox
		Move Box in screen center when brower is resize or scroll
	*/
	replaceBox: function() {
		if(this.options.display == 1) {
			sizes = window.getSize();
      scrollito = window.getScroll();

			if(this.MoveBox)
				this.MoveBox.cancel();
			
			this.MoveBox = new Fx.Morph(this.Box, {
				duration: this.options.moveDuration,
				transition: this.options.moveEffect
			}).start({

				'left': (scrollito.x + (sizes.x - this.options.BoxStyles['width']) / 2).toInt(),
				'top': (scrollito.y + (sizes.y - this.Box.offsetHeight) / 2).toInt()

			});

		}
	},


	queue: function() {
		this.i--;
		this.callChain();
	},


	/*
	Property: messageBox
		Core system for show all type of box
		
	Argument:
		type - string, 'alert' or 'confirm' or 'prompt'
		message - text to show in the box
		properties - see Options below
		input - text value of default 'input' when prompt
		
	Options:
		textBoxBtnOk - text value of 'Ok' button
		textBoxBtnCancel - text value of 'Cancel' button
		onComplete - a function to fire when return box value
	*/	
	messageBox: function(type, message, properties, input) {

		this.chain(function () {

      properties = $extend({
        'textBoxBtnOk': 'Aceptar',
        'textBoxBtnCancel': 'Cancelar',
        'textBoxInputPrompt': null,
        'password': false,
        'onComplete': $empty
      }, properties || {});


      this.options.onReturnFunction = properties.onComplete;

      this.ContenedorBotones = new Element('div', {
        'id': this.options.name + '-Buttons'
      });
      


      if(type == 'alert' || type == 'info' || type == 'error')
      {
          this.AlertBtnOk = new Element('input', {
            'id': 'BoxAlertBtnOk',
            'type': 'submit',
            'value': properties.textBoxBtnOk,
            'styles': {
              'width': '70px'
            }
          });
          
          this.AlertBtnOk.addEvent('click', function() {
            this.options.onReturn = true;
            this.display(0);
			foco(focoActual,1);
          }.bind(this));
        
          if(type == 'alert')
            this.clase = 'BoxAlert';
          else if(type == 'error')
            this.clase = 'BoxError';
          else if(type == 'info')
            this.clase = 'BoxInfo';
        
          this.Content.setProperty('class',this.clase).set('html',message);

          this.AlertBtnOk.injectInside(this.ContenedorBotones);

          this.ContenedorBotones.injectInside(this.Content);
          this.display(1);
      }
      else if(type == 'confirm')
      {
          this.ConfirmBtnOk = new Element('input', {
            'id': 'BoxConfirmBtnOk',
            'type': 'submit',
            'value': 'Si',
            'styles': {
              'width': '70px'
            }
          });

          this.ConfirmBtnCancel = new Element('input', {
            'id': 'BoxConfirmBtnCancel',
            'type': 'submit',
            'value': 'No',
            'styles': {
              'width': '70px'
            }
          });

          this.ConfirmBtnOk.addEvent('click', function() {
            this.options.onReturn = true;
            this.display(0);
			foco(focoActual,1);
          }.bind(this));

          this.ConfirmBtnCancel.addEvent('click', function() {
            this.options.onReturn = false;
            this.display(0);
			foco(focoActual,1);
          }.bind(this));

          this.Content.setProperty('class','BoxConfirm').set('html',message);

          this.ConfirmBtnOk.injectInside(this.ContenedorBotones);
          this.ConfirmBtnCancel.injectInside(this.ContenedorBotones);
          
          this.ContenedorBotones.injectInside(this.Content);
          this.display(1);
      }
      else if(type == 'prompt')
      {
          this.PromptBtnOk = new Element('input', {
            'id': 'BoxPromptBtnOk',
            'type': 'submit',
            'value': properties.textBoxBtnOk,
            'styles': {
              'width': '70px'
            }
          });

          this.PromptBtnCancel = new Element('input', {
            'id': 'BoxPromptBtnCancel',
            'type': 'submit',
            'value': properties.textBoxBtnCancel,
            'styles': {
              'width': '70px'
            }
          });
          
          type = properties.password ? 'password' : 'text';
          this.PromptInput = new Element('input', {
            'id': 'BoxPromptInput',
            'type': type,
            'value': input,
            'styles': {
              'width': '250px'
            }
          });

          this.PromptBtnOk.addEvent('click', function() {
            this.options.onReturn = this.PromptInput.value;
            this.display(0);
			foco(focoActual,1);
          }.bind(this));

          this.PromptBtnCancel.addEvent('click', function() {
            this.options.onReturn = false;
            this.display(0);
			foco(focoActual,1);
          }.bind(this));

          this.Content.setProperty('class','BoxPrompt').set('html',message + '<br />');
          this.PromptInput.injectInside(this.Content);
          new Element('br').injectInside(this.Content);
          this.PromptBtnOk.injectInside(this.ContenedorBotones);
          this.PromptBtnCancel.injectInside(this.ContenedorBotones);


          this.ContenedorBotones.injectInside(this.Content);

          this.display(1);
      }
      else
      {
          this.options.onReturn = false;
          this.display(0);
		  foco(focoActual,1);
      }

    });

		this.i++;

		if(this.i==1) this.callChain();

	},

	/*
	Property: alert
		Shortcut for alert
		
	Argument:
		properties - see Options in messageBox
	*/	
	
	alert: function(message, properties){
		this.messageBox('alert', '<h1>Alerta</h1><em>'+version_+'</em><br/><p>'+message+'<p>', properties);
		
	},

	/*
	Property: info
		Shortcut for alert info
		
	Argument:
		properties - see Options in messageBox
	*/		
	info: function(message, properties){
		this.messageBox('info', '<h1>Informaci&oacute;n</h1><em>'+version_+'</em><br/><p>'+message+'<p>', properties);
	},

	/*
	Property: error
		Shortcut for alert error
		
	Argument:
		properties - see Options in messageBox
	*/		
	error: function(message, properties){
		this.messageBox('error', '<h1>Error</h1><em>'+version_+'</em><br/><p>'+message+'<p>', properties);
	},

	/*
	Property: confirm
		Shortcut for confirm
		
	Argument:
		properties - see Options in messageBox
	*/
	confirm: function(message, properties){
		this.messageBox('confirm', '<h1>Confirmaci&oacute;n</h1><em>'+version_+'</em><br/><p>'+message+'<p>', properties);
	},

	/*
	Property: prompt
		Shortcut for prompt
		
	Argument:
		properties - see Options in messageBox
	*/	
	prompt: function(message, input, properties){
		this.messageBox('prompt', '<h1>Consulta</h1><em>'+version_+'</em><br/><p>'+message, properties, input);
	}
});

AlertBox.implement(new Events, new Options);
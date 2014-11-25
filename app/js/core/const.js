window.$=window.jQuery=null;
var is={
		support	: !!navigator.userAgent.match(/ipad|android|ipod|iphone/i),
		mobile	: !!navigator.userAgent.match(/android|windows ce|blackberry|palm|symbian/i),
		webkit	: !!navigator.userAgent.match(/webkit/i),
		iOS		: !!navigator.userAgent.match(/ipad|ipod|iphone/i),
		tablet	: !!navigator.userAgent.match(/ipad/i),
		android	: !!navigator.userAgent.match(/android/i),
		device	: 'onorientationchange' in window
	},
	version=navigator.userAgent.match(/android\s((\d\.?)+)|iOS\s((\d\.?)+)\s/i),
	CORDOVA,
	openVideo,
	App,
	offline,
	lang,
	DOMINIO,PRODUCCION,LOCAL,FILESERVER,PAGE,SERVERS;
if(version) version=version[1];
is.limited= !is.webkit||is.android;

(function(window){
	//lenguaje actual del navegador
	var actual=(window.navigator.userLanguage||window.navigator.language).substring(0,2),more={};
	if(actual=='es') more.es={//español
		//Nueva forma de traduccion (para textos cortos o de un unico uso).
		//Se llama la funcion: lan(texto).
		//En este modo el texto se escribe tal cual como debe verse en ingles, y agregamos solo la
		//traduccion del otro idioma, colocando el texto como etiqueta.
		//NOTA: La funcion tambien trabaja con traducciones antiguas, colocando la etiqueta en la funsion.
		//de la etiqueta, pero no al contrario ("lang" con etiqueta sin definir devolvera undefined).
		'admirers'	:'admiradores',
		'admired'	:'admirados',
		'All'		:'Todos',
		'Back'		:'Volver',
		'camera'	:'camara',
		'change picture':'cambiar imagen',
		'Comments'	:'Comentarios',
		'email'		:'correo',
		'edit thumbnail':'editar miniatura',
		'friends'	:'amigos',
		'From'		:'De',
		'gallery'	:'galer&iacute;a',
		'group'		:'grupo',
        'hashtags'  :'hashtags',
		'inbox'		:'entrada',
		'My publications':'Mis publicaciones',
		'outbox'	:'salida',
		'password'	:'contrase&ntilde;a',
        'peoples'   :'personas',
		'private'	:'privado',
		'save'		:'guardar',
		'see more'	:'ver m&aacute;s',
        'shopping cart':'carrito de compras',
        'stock'     :'stock',
        'store'     :'tienda',
        'Video'     :'Video',
        'wish list' :'lista de deseos',
        'active'	:'activo',
        'inactive'	:'inactivo',

		//'':'mover a',
        

		//Traducciones al estilo antiguo
		ACTIONSTAGS_REPORTTAG_TITLESELECT:'Todos los informes son estrictamente confidenciales. Qu&eacute; etiqueta describe mejor esto?',
		goback							:'Volver a',
		batterylow						:'Bater&iacute;a baja, se cerrar&aacute; la aplicaci&oacute;n.',
		cancel							:'Cancelar',
		chat							:'Chat',
		checkLogin						:'Verificando Logeo de Sesi&oacuten...',
		close							:'Cerrar',
		COMMENTS_LBLHELPIMPUTNEWCOMMENT	:'Escriba su comentario aqu&iacute;...',
		CON_ERROR						:'Error de conexi&oacute;n. Espere un momento e intente de nuevo.',
		conectionFail					:'No se pudo conectar con el servidor.<br/>Intente de nuevo m&aacute;s tarde.',
		country							:'Pa&iacute;s',
		deFrom							:'<strong>De</strong>',
		Email							:'Correo',
		EMPTY_TAGS_LIST					:'Lista de tags vacia',
		externalLink					:'Link Externo',
		filter							:'Filtrar busqueda...',
		FINDFRIENDS_LEGENDOFSEARCHBAR	:'La b&uacute;squeda se iniciar&aacute; autom&aacute;ticamente; si no hay letras, podr&aacute;s ver las sugerencias de amigos.',
		follow							:'Seguir',
		FOUNDATION_DATE					:'Desde',
		FRIENDS_TITLE					:'Amigos',
		friendSearh_title				:'Buscar Amigos',
		GROUPS_ALLGROUPS				:'Todos los Grupos',
		GROUPS_ASSIGNADMIN				:'Asignar Admin',
		GROUPS_BACKMAIN					:'Regresar',
		GROUPS_CLOSE					:'Grupo Cerrado',
		GROUPS_CREATED					:'Creado',
		GROUPS_INVITEDFRIENDS			:'Invitar Amigos',
		GROUPS_JOIN						:'Unirse',
		GROUPS_LEAVE					:'Abandonar Grupo',
		GROUPS_LEAVEABANDONAR			:'Abandonar',
		GROUPS_LEAVEABANDONARMSG		:'Usted es el unico administrador de este grupo. Si el grupo queda sin administrador, será eliminado. ¿Está seguro que desea abandonar el grupo?',
		GROUPS_LEAVEASIGNAR				:'Asignar',
		GROUPS_LEAVEASIGNARMSG			:'Selecciona el(los) administrador(es) del Grupo',
		GROUPS_LEAVEBORRADO				:'Este grupo ha sido eliminado',
		GROUPS_LEAVECCOMPLETE			:'Usuario(s) asignado(s) como administrador',
		GROUPS_LEAVEMESSAGE				:'Seguro que quieres abandonar el grupo?',
		GROUPS_LEAVEMESSAGEFINAL		:'Usted ha dejado el grupo con éxito',
		GROUPS_MEMBERS					:'Miembros',
		GROUPS_MEMBERSTITLE				:'Miembros',
		GROUPS_MEMBERSTITLE2			:'Miembros del Grupo',
		GROUPS_MENUADDTAG				:'Tag',
		GROUPS_MESSAGE_JOIN				:'Para crear tag(s), &uacute;nete al grupo.',
		GROUPS_MESSAGE_TAGS				:'No hay tags creadas.',
		GROUPS_MESSAGEMPTY				:'Busca a tus amigos e invitalos a unirse al grupo',
		GROUPS_MORE						:'M&aacute;s Grupos',
		GROUPS_MYGROUPS					:'Mis Grupos',
		GROUPS_SENDINVITATION 			:'Enviar Invitaci&oacute;n',
		GROUPS_TITLEWINDOWSNEW			:'Nuevo Grupo',

		GROUPS_OPEN						:'Grupo Abierto',
		GROUPS_CLOSED					:'Grupo Cerrado',
		GROUPS_PRIVATE					:'Grupo Privado',

		home							:'Inicio',
		INDEX_LBL_PRIVATE				:'Privado',
		inputPlaceHolder				:'Buscar',
        noresultsearch_ini 				:'Disculpe, no hay resultados para',
        noresultsearch_end				:'Compruebe su t&eacute;rmino de b&uacute;squeda e intentelo de nuevo.',
        searchtitle                     :'Todos los resultados',
		JS_INVITEPHONECONTACT			:'&iquest;Desea enviar invitacion a este contacto?',
		JS_APP_LOADING					:'Loading...',
		JS_DELETETAG					:'Est&aacute; seguro que quiere eliminar esta tag?',
		JS_FAVORITETAGS					:'Favoritas',
		JS_MYTAGS						:'Mis Tags',
		JS_PRIVATETAGS					:'Tags Privadas',
		JS_SIGNUP_ENTERPRISE			:'Empresa',
		JS_SIGNUP_INDIVIDUAL			:'Individual',
		JS_SIGNUP_LBLADVERTISERNAME		:'Empresa o Anunciante',
		JS_SIGNUP_LBLBUSINESSSINCE		:'Empresa desde',
		JS_SIGNUP_LBLDAY				:'D&iacute;a',
		JS_SIGNUP_LBLMONTH				:'Mes',
		JS_SIGNUP_LBLYEAR				:'A&ntilde;o',
		JS_SIGNUP_PROFILE				:'Perfil',
		JS_TIMELINE						:'Time Line',
		LINK_DOWNLOADAPP				:'Descarga nuestra app y disfruta de todas las bondades de nuestra red social',
		loading							:'Cargando...',
		loadingTags						:'Cargando tags...',
		login							:'&nbsp;Entrar',
		logout							:'Salir',
		MAINMENU_POINTS_1				:'Usted podr&aacute; cambiar sus puntos por los servicios y productos en Tagbum. Mientras mas puntos obtenga, m&aacute;s servicios y productos podr&aacute; obtener.',
		MAINMENU_POINTS_2				:'<strong>Puedes obtener mas puntos:</strong> compartiendo tags ya sea publicando, redistribuyendo o enviandolas por correo electr&oacute:nico. Acumula al menos 5000 puntos antes de 31 de diciembre y podr&aacute;s participar en el sorteo de gift cards de $500.',
		MAINMNU_GROUP					:'Grupo',
		MAINMNU_GROUPS					:'Grupos',
		MAINMNU_MYTAGS					:'Tags',
		MAINMNU_PERSONALTAGS			:'Tags Personales',
		MAINSMNU_PASSWORD				:'Contrase&ntilde;a',
		message							:'<strong>Mensaje</strong>',
		MESSAGE_WELCOME					:'Bienvenido',
		MNU_LOSTPASS					:'Olvidaste tus datos?',
		MNU_REGISTER					:'Registrar',
		MNUTAGREPORT_SELECTONEFIRST		:'Seleccione uno',
		MNUTAGREPORT_TEXT1				:'Gracias por su ayuda',
		MNUTAGREPORT_TEXT2				:'Sus comentarios y quejas pueden ayudar a que no haya spam en la secci&oacute;n del Timeline.',
		MSG_PAYPAL_HELP					:'Su cuenta est&aacute; bloqueada temporalmente, para seguir disfrutando de nuestros servicios usted debe cancelar su cuota a trav&eacute;s de paypal.',
		MSG_PAYPAL_HELP_APP				:'En este momento esta opci&oacute;n s&oacute;lo est&aacute; disponible en la versi&oacute;n web',
		MSGGROUPS_CLOSE					:'Si quieres entrar en &eacute;l, debe ser invitado por un miembro.',
		MSGGROUPS_CLOSE_INVI_SED        :'Por favor, espere hasta que el administrador apruebe su solicitud de membres&iacute;a.',
		INVITE_GROUP_TRUE               :'Tienes una invitaci&oacute;n a este grupo',
		CONFI_JOIN_TO_GROUPS            :'&iquest;Deseas unirte a este grupo?',
		newGroupTag						:'Tag de Grupo',
		NEWS							:'Noticias',
		newTag							:'Crear Tag',
		NEWTAG_BACKGROUNDAPP			:'Fondos',
		NEWTAG_BOTTOMMESSAGE			:'Mensaje 2',
		NEWTAG_BUTTON_ADVANCED			:'Cambiar a Vista Avanzada',
		NEWTAG_BUTTON_QUICK				:'Regresar a la Vista Rapida',
		NEWTAG_BUTTON_SHARE				:'Personas que pueden ver esta Tag',
		NEWTAG_EMAILSPRIVATEPUBLICTAG	:'Correos:',
		NEWTAG_LEYENDBTNPUBLIC			:'Desmarque para enviar tag(s) privada(s)',
		NEWTAG_MESSAGE					:'Mensaje',
		NEWTAG_MIDDLEMESSAGE			:'Mensaje Corto',
		NEWTAG_PLACEHOLDER_EMAIL		:'Comparte esta Tag con personas fuera de Tagbum',
		NEWTAG_PRIVATEPUBLICTAG			:'Publico',
		noConnection					:"No tiene conexi&oacute;n a Internet.\nVerifique e intente de nuevo.",
		none							:'Ninguno',
		NOTIFICATIONS					:'Notificaciones',
		pass							:'Contrase&ntilde;a',
		PASS_MESSAGEERROR				:'Hubo un error en la verificaci&oacute;n de la contrase&ntilde;a. Intente de nuevo.',
		RESETPASS_ERROR1                :'Los valores de las contrase&ntilde;as introducidas deben ser igual',
        POINTS_USERS					:'Pts',
		PREFERENCES_BTNMINE				:'Mias',
		PREFERENCES_BTNUPDATE			:'Actualizar',
		PREFERENCES_ERRORSELECC			:'Error, debe seleccionar al menos una preferencia',
		PREFERENCES_HOLDERSEARCH		:'Use comas para separar las preferencias, por ejemplo: Pel&iacute;culas, Ejecutar, Comer, B&eacute;isbol, Pesca.',
		PREFERENCES_LBLCHOOSEOP			:'Seleccione una opci&oacute;n',
		PREFERENCES_LBLCHOOSEOPFOOTER	:'Manual',
		PREFERENCES_MSJCONFIRMADDPREFE	:'Est&aacute; seguro de a&ntilde;adir esta opci&oacute;n a sus preferencias?',
		PREFERENCES_MSJSUCESSFULLY		:'Preferencias actualizadas',
		PREFERENCES_TITLESEEK			:'Buscar Preferencias',
		PREFERENCES_WHATILIKE			:'Lo que me gusta',
		PREFERENCES_WHATINEED			:'Lo que necesito',
		PREFERENCES_WHATIWANT			:'Lo que yo quiero',
		profile							:'Perfil',
		PROFILE_BIRTHDATE				:'Cumplea&ntilde;os',
		PROFILE_PERSONALTAGS			:'Tags Personales',
		PUBLICITY_MSGSUCCESSFULLY		:'Solicitud procesada correctamente',
		publish							:'Publicar',
		report							:'Reportar',
		reportTagTitle					:'Denunciar Tag',
		REQUIRED						:'Los campos con (*) son obligatorios',
		RESET_BTNRESETPASS				:'Restablecer',
		RESET_LINKNISHSIGNUP			:'con un enlace para finalizar su registro.',
		RESET_MESSAGEPRINCIPAL			:'Nosotros le enviaremos un correo para verificar su direcci&oacute;n de correo electr&oacute;nico. Haga clic en el enlace del correo para terminar de restablecer su contrase&ntilde;a.',
		RESET_MSGNRESETPASS				:'Su contrase&ntilde;a se ha cambiado correctamente.',
		RESET_PLEASECHECKEMAIL			:'Por favor, revise su correo.',
		RESET_TITLERESETPASS			:'Restablecer contrase&ntilde;a',
		RESET_WESENTMESSAGE				:'Le enviamos un mensaje a',
		retry							:'Reintentar',
		SCROLL_LOADING					:'Cargando...',
		SCROLL_PULLDOWN					:'Desliza hacia abajo para refrescar.',
		SCROLL_PULLUP					:'Desliza hacia arriba para actualizar.',
		SCROLL_RELEASE					:'Suelte para actualizar.',
		seek							:'Buscar',
		send							:'Enviar',
		share							:'Compartir',
		SHARETAG_EMAILSLEGEND			:'Coloque los correos separados por comas',
		SHARETAG_TOUCHPICTURE			:'Toca la imagen para eliminarla',
		signup							:'Registro',
		SIGNUP_CONFIRMPASSWORD			:'Confirmar Contrase&ntilde;a Requerido',
		SIGNUP_CTRERRORBIRTHDATE		:'Fecha de Nacimiento Requerido',
		SIGNUP_CTRERROREMAIL			:'Correo Requerido',
        EMAIL_ERROR                     :'Email inválido',
        EMAIL_ERROR_NE                  :'Disculpe, este email no est&aacute; registrado en nuestro sistema',
        FORGOT_CTRMSGERROR              :'Error al enviar el correo, int&eacute;ntalo de nuevo',
        PASS_MESSAGEERROR               :'Hubo un error con la verificaci&oacute;n de la contraseña. Intente de nuevo.',
		RESETPASS_ERROR1                :'The values ​​of the passwords listed should be equal',
        SIGNUP_CTRERROREMAIL2			:'Correo existente. Intente con otro correo',
		SIGNUP_CTRERRORLASTNAME			:'Apellido Requerido',
		SIGNUP_CTRERRORNAME				:'Nombre Requerido',
		SIGNUP_CTRERRORNAMENTER			:'Empresa o Anunciante Requerido',
		SIGNUP_CTRERRORPASS				:'Contrase&ntilde;a Requerido',
		SIGNUP_LBLBIRTHDATE				:'Fecha de Nacimiento',
		SIGNUP_LBLEMAIL					:'Correo',
		SIGNUP_LBLFIRSTNAME				:'Nombre',
		SIGNUP_LBLLASTNAME				:'Apellido',
		SIGNUP_PASSWORD					:'Contrase&ntilde;a',
		SIGNUP_PASSWORD2				:'Confirmar Contrase&ntilde;a',
		SMT_SIGNUP_EXITOREGISTER		:'Registro exitoso. Revise su correo para confirmar su cuenta.',
		SMT_SIGNUP_PASSWORDNOTMATCH		:'No coinciden las Contrase&ntilde;as',
		STORE							:'Tienda App',
		store							:'Tienda',
		STORE_CART						:'Carrito',
		STORE_CATEGORY					:'Categoria',
		STORE_CATEGORYS					:'Categorias',
		STORE_MYPUBLICATIONS			:'Mis publicaciones',
		STORE_DETAILS					:'Detalle del Producto',
		STORE_SHOPPING_ADD				:'Agregar',
		STORE_SHOPPING_BACKLIST			:'Regresar al listado',
		STORE_SHOPPING_CART				:'Carrrito de Compras',
		STORE_SHOPPING_CHECKOUT			:'Comprar',
		STORE_SHOPPING_DELETE			:'Eliminar Carrito',
		STORE_SHOPPING_DELETEALL		:'Eliminar el Carrito de Compras?',
		STORE_PRODUCT_TAG				:'Crear Tag de Producto',
		STORE_SHOPPING_DESCRIPTION		:'Descripci&oacute;n Producto',
		STORE_SHOPPING_DETAILS			:'Detalles',
		STORE_SHOPPING_ITEM				:'Eliminar articulo',
        STORE_WISH_LIST_MOVE            :'Mover a la lista de deseos',
		STORE_SHOPPING_MESSAGEORDER		:'Estos fondos los tendras disponibles en Crear Tag',
		STORE_SHOPPING_NOBUY			:'Este fondo te pertenece. No puedes comprarlo',
        STORE_UNI_BACKG                 :'Este Backgrounds ya ha sido agregado a la orden. Los Backgrounds solo pueden ser comprados una vez.',
		STORE_PRODUCTO_NO_STOCK         :'Disculpe este producto ya no est&aacute; disponible en stock',
        STORE_SHOPPING_NOITEMS			:'No tiene productos en el carrito de compras',
		STORE_SHOPPING_NOPOINTS			:'No dispones de la cantidad de puntos necesarios para hacer esta compra',
		STORE_SHOPPING_NUMORDER			:'Orden',
		STORE_SHOPPING_ORDER			:'Orden de Compra',
		STORE_SHOPPING_POINTS			:'puntos',
		STORE_SHOPPING_POINTSMA			:'Puntos',
        STORE_SHOPPING_DOLLARS          :'D&oacute;lares',
		STORE_SHOPPING_SELLER			:'Publicado por',
		STORE_SHOPPING_TITLE			:'Titulo',
		STORE_SHOPPING_TOTAL			:'Cantidad Productos:',
		STORE_SHOPPING_TOTAL_PRODUCTS	:'Puntos Totales:',
        STORE_SHOPPING_TOTAL_PRODUCTSD  :'Dolares Totales:',
		STORE_SHOPPING_VALUE			:'Costo',
		STORE_SUBCATEGORY				:'Sub - Categorias',
		STORE_VIEWORDERINCART           :'Ver Orden',
        STORE_SUGGEST                   :'Sugerencia de productos',
		STORE_NOSTORE_MESSAGE           :'No hay productos disponibles', 
        STORE_ORDER_EDIT_STOCK          :'Algunos productos ya no est&aacute;n disponibles, su pedido fue modificado.',
		STORE_DELETESHOPPING            :'&iquest;Est&aacute;s seguro de eliminar esta orden?',
        STORE_NOT_CHET_DOLLAR           :'Disculpe, nuestra versi&oacute;n m&oacute;vil por ahora solo acepta puntos para pagar. Puede finalizar la compra usando nuestra versi&oacute;n web si no cuenta con puntos suficientes.',
        STORE_NO_SC                     :'Disculpe, no hay art&iacute;culos disponibles en su carrito de compras.',
        STORE_NO_WL                     :'Disculpe, no hay art&iacute;culos disponibles en su lista de deseos.',
        STORE_NO_AB                     :'Lo sentimos, esta opción sólo está disponible para las empresas asociadas a nuestro sistema.',
        STORE_SHIPPING                  :'Direcci&oacute;n de env&iacute;o',
        STORE_SHIPPING_CHANGE           :'&iquest;desea cambiar la direcci&oacute;n de env&iacute;o?',
        STORE_COUNTRY                   :'Pa&iacute;s',
        STORE_NO_COMPLETE               :'Los siguientes campos:',
        STORE_NO_COMPLETE_2             :'Son obligatorios.',
        STORE_NOT_NUM_PHONE             :'Un numero de telefono',
        BUSINESSCARD_LBLCITY            :'Ciudad',
        SIGNUP_ZIPCODE                  :'C&oacute;digo postal',
        USERPROFILE_LBLWORKPHONE        :'Tel&eacute;fono del trabajo',
        USERPROFILE_LBLHOMEPHONE        :'Tel&eacute;fono de casa',
        BUSINESSCARD_LBLADDRESS         :'Direcci&oacute;n',
        USERPROFILE_LBLMOBILEPHONE      :'Tel&eacute;fono m&oacute;vil',
        USERPROFILE_LBLCBOAREASCODE     :'C&oacute;digo de &aacute;rea',       
        TAG_CONTENTUNAVAILABLE			:'Este contenido ya no est&aacute; disponible',
		TAG_DELETEDERROR				:'ERROR: Por favor intente de nuevo',
		TAG_DELETEDOK					:'Tag eliminada exitosamente',
		TAGS_WHENTAGNOEXIST				:'Este contenido ya no est&aacute; disponible',
		TEXT_LINKTERMS					:'Condiciones de Servicio',
		TEXT_TERMS						:'Cuando usted se registra, admite que conoce y est&aacute; de acuerdo con nuestras',
		TIMELINE_TITLE					:'Timeline',
		TITLE_TILECHAT					:'Chat',
		TITLEBOTTONLOGIN				:'Cambia por Productos y Servicios',
		TITLEMIDLELOGIN					:'Expresate. Obten puntos',
		TITLESHARETAG					:'Compartir Tag',
		TITLETOPLOGIN					:'Red Social con Premios',
		TOPTAGS_ALWAYS		:'De siempre',
		TOPTAGS_DAILY		:'Del d&iacute;a',
		TOPTAGS_MONTHLY		:'Del mes',
		TOPTAGS_NOTAGS		:'Top Tags depende del gusto de los usuarios.<br/>Actualmente no hay tags disponibles para mostrar en las tags ',
		TOPTAGS_TITLE		:'Top Tags',
		TOPTAGS_WEEKLY		:'De la semana',
		TOPTAGS_YEARLY		:'Del a&ntilde;o',
		TXT_REDIST	:' (redistribuci&oacute;n) ',
		TXT_REDISTBY:'Redistribuida por ',
		unfollow						:'Dejar de seguir',
		USER_PROFILE					:'Perfil',
		USERPROFILE_PASSWORD			:'La contrase&ntilde;a debe tener al menos 6 caracteres',
		USERPROFILE_PREFERENCES			:'Preferencias',
		USERPROFILE_PREFERENCES_TITLE	:'Preferencias',
		FIENDFRIENDS_INVITED			:'Invitado',
		FIENDFRIENDS_PHONECONTACT		:'Contacto de telefono',
		yes								:'S&iacute;',

		EMPTY_INFO_NOTIFICATION			:'Disculpe, no hay notificaciones que mostrar porque no tienes amigos. Haz clic abajo y encuentra a tus amigos.',
		EMPTY_INFO_NEWS					:'Disculpe, no hay noticias que mostrar porque no tienes amigos. Haz clic abajo y encuentra a tus amigos.',
		EMPTY_INFO_FRIENDS				:'Disculpe, no tienes amigos. Haz clic abajo y encuentra a tus amigos.',
		EMPTY_INFO_ADMIRERS				:'Disculpe, no tienes admiradores. Espera a que alguien te siga y lo veras en este lista.',
		EMPTY_INFO_ADMIRED				:'Disculpe, no tienes admirados. Haz clic abajo y encuentra a tus amigos.',
		FIND_FRIENDS_NOTIFICATION		:'Encontrar Amigos'
	};//es
	lang={//ingles por defecto
		pass							:'Password',
		login							:'&nbsp;Login',
		signup							:'&nbsp;Sign&nbsp;Up&nbsp;',
		checkLogin						:'Checking Login Session...',
		conectionFail					:"Can't connect to the server.<br/>Try again later.",
		noConnection					:"You don't have Internet connection.\nCheck it and try again.",
		retry							:'Retry',
		friendSearh_title				:'Search Friends',
		goback							:'Return to',
		send							:'Send',
		home							:'Home',
		loading							:'Loading...',
		inputPlaceHolder				:'Search',
        noresultsearch_ini 				:'Sorry, no results for',
        noresultsearch_end				:'Check your search term and try again.',
        searchtitle                     :'All results',
		seek							:'Seek',
		cancel							:'Cancel',
		publish							:'Publish',
		newTag							:'New Tag',
		newGroupTag						:'New Group Tag',
		profile							:'Profile',
		store							:'Store',
		chat							:'Chat',
		logout							:'Logout',
		loadingTags						:'Loading tags...',
		follow							:'Follow',
		unfollow						:'Unfollow',
		reportTagTitle					:'Reporting Tag',
		batterylow						:'Low battery, the app will shut down.',
		report							:'Report',
		country							:'Country',
		close							:'Close',
		share							:'Share',
		none							:'None',
		message							:'<strong>Message</strong>',
		deFrom							:'<strong>From</strong>',
		yes								:'Yes',
		filter							:'Filter items...',
		externalLink					:'External Link',
		
		MSG_PAYPAL_HELP					:'Your account is temporarily blocked, to continue enjoying our services you must pay your fee through paypal',
		MSG_PAYPAL_HELP_APP				:'In this moment this option is only available in web version',

		TITLESHARETAG					:'Share Tag',
		TITLETOPLOGIN					:'Social media with rewards',
		TITLEMIDLELOGIN					:'Express yourSelf. Get point.',
		TITLEBOTTONLOGIN				:'Redeem Merchandise',

		LINK_DOWNLOADAPP				:'Download our app and enjoy all the benefits of our social network',
		MNU_LOSTPASS					:'Forgot It?',
		MAINSMNU_PASSWORD				:'Change Password',
		RESET_MESSAGEPRINCIPAL			:'We will send you an email to verify your email address. Click the link in the email to finish your password reset.',
		RESET_BTNRESETPASS				:'Reset Password',
		RESET_PLEASECHECKEMAIL			:'Please check your email.',
		RESET_WESENTMESSAGE				:'We just sent a message to',
		RESET_LINKNISHSIGNUP			:'with a link to finish signing up.',
		PASS_MESSAGEERROR				:'There was an error with your verification. Please try again.',
		RESET_MSGNRESETPASS				:'Your password was changed successfully.',
		RESET_TITLERESETPASS			:'Reset Password',
		NEWS							:'News',
		NOTIFICATIONS					:'Notifications',
		NEWTAG_MESSAGE					:'Top Message',
		NEWTAG_MIDDLEMESSAGE			:'Short Message',
		NEWTAG_BOTTOMMESSAGE			:'Bottom Message',
		MNU_REGISTER					:'Sign Up',
		JS_INVITEPHONECONTACT			:'You want to send invitation to this contact?',
		JS_SIGNUP_LBLADVERTISERNAME		:'Advertiser or Company Name',
		JS_SIGNUP_LBLBUSINESSSINCE		:'Business Since',
		SIGNUP_LBLBIRTHDATE				:'Birth Date',
		JS_SIGNUP_LBLMONTH				:'Month',
		JS_SIGNUP_LBLDAY				:'Day',
		JS_SIGNUP_LBLYEAR				:'Year',
		JS_SIGNUP_INDIVIDUAL			:'Individual',
		JS_SIGNUP_ENTERPRISE			:'Enterprise',
		JS_APP_LOADING					:'Loading...',

		SIGNUP_LBLFIRSTNAME				:'First Name',
		SIGNUP_LBLLASTNAME				:'Last Name',
		SIGNUP_LBLEMAIL					:'Email',
		SIGNUP_PASSWORD					:'Password',
		SIGNUP_PASSWORD2				:'Confirm Password',
		SIGNUP_CTRERRORBIRTHDATE		:'Birth Date Required',

		USERPROFILE_PASSWORD			:'Password should have at least six characters',
		REQUIRED						:'Fields with (*) are required',

		TEXT_TERMS						:'When you sign up, you admit you acknowledge and are agree with our ',
		TEXT_LINKTERMS					:'Terms of Service',

		MAINMENU_POINTS_2				:'You can get more points: sharing tags by publishing, redistributing or sending email. Accumulate at least 5000 points before December 31 and you can participate in the draw for gift cards of $ 500.',
		MAINMENU_POINTS_1				:'You will be able change your points by services and products at Tagbum, the more points you earn, the more things you can get.',
		POINTS_USERS					:'Pts',
		PROFILE_PERSONALTAGS			:'Personal Tags',

		PREFERENCES_WHATILIKE			:'What I like',
		PREFERENCES_WHATINEED			:'What I need',
		PREFERENCES_WHATIWANT			:'What I want',
		USERPROFILE_PREFERENCES			:'Preferences',
		PREFERENCES_ERRORSELECC			:'Error, You must select at least one preference',
		PREFERENCES_HOLDERSEARCH		:'Use commas to separate preferences, Example: Movie, Run, Eat, Baseball, Fishing.',
		USERPROFILE_PREFERENCES_TITLE	:'Preferences',
		PREFERENCES_BTNUPDATE			:'Update',
		PREFERENCES_BTNMINE				:'Mine',
		PREFERENCES_MSJSUCESSFULLY		:'Preferences Successfully Updated',
		PREFERENCES_LBLCHOOSEOP			:'Choose an option',
		PREFERENCES_LBLCHOOSEOPFOOTER	:'Manual',
		PREFERENCES_TITLESEEK			:'Seek Preferences',
		PREFERENCES_MSJCONFIRMADDPREFE	:'Are you sure to add this option to your preferences?',

		NEWTAG_BUTTON_QUICK				:'Back to Quick View',
		NEWTAG_BUTTON_ADVANCED			:'Switch to Advanced View',
		NEWTAG_PLACEHOLDER_EMAIL		:'Share this tag with people outside Tagbum',
		NEWTAG_BUTTON_SHARE				:'People who can see this tag',
		NEWTAG_LEYENDBTNPUBLIC			:'Uncheck for private',
		NEWTAG_BACKGROUNDAPP			:'Backgrounds',

		SIGNUP_CTRERRORNAME				:'First Name Required',
		SIGNUP_CTRERRORNAMENTER			:'Advertiser or Company Name Required',
		SIGNUP_CTRERRORLASTNAME			:'Last Name Required',
		SIGNUP_CTRERROREMAIL			:'Email Required',
        EMAIL_ERROR                     :'Invalid email',
        EMAIL_ERROR_NE                  :'Sorry, this email is not registered in our system',
        FORGOT_CTRMSGERROR              :'Error sending email, please try again',
        PASS_MESSAGEERROR               :'There was an error with your verification. Please try again',
		SIGNUP_CTRERROREMAIL2			:'Email Used. Try another one',
		SIGNUP_CTRERRORPASS				:'Password Required',
		SMT_SIGNUP_PASSWORDNOTMATCH		:'Passwords do not match',
		SIGNUP_CONFIRMPASSWORD			:'Confirm Password Required',
		SMT_SIGNUP_EXITOREGISTER		:'Information saved. Check your email to confirm your account.',

		TIMELINE_TITLE					:'Timeline',
		USER_PROFILE					:'Profile',
		FRIENDS_TITLE					:'Friends',
		MAINMNU_MYTAGS					:'Tags',
		MAINMNU_PERSONALTAGS			:'Personal Tags',

		PROFILE_BIRTHDATE				:'Birthday',
		INDEX_LBL_PRIVATE				:'Private',
		FOUNDATION_DATE					:'Since',
		TITLE_TILECHAT					:'Chat',

		COMMENTS_LBLHELPIMPUTNEWCOMMENT	:'Type your comment here...',

		TAG_CONTENTUNAVAILABLE			:'This content is no longer available',

		SHARETAG_EMAILSLEGEND			:'Put emails separated by commas',
		MNUTAGREPORT_SELECTONEFIRST		:'Select one',

		FIENDFRIENDS_INVITED			:'Invited',
		FIENDFRIENDS_PHONECONTACT		:'Phone contact',


		NEWTAG_PRIVATEPUBLICTAG			:'Public',
		NEWTAG_EMAILSPRIVATEPUBLICTAG	:'Emails:',
		MNUTAGREPORT_TEXT1				:'Thanks for your help',
		MNUTAGREPORT_TEXT2				:'Your comments and complaints help that there is no spam in the section of the timeline.',
		ACTIONSTAGS_REPORTTAG_TITLESELECT :'All reports are strictly confidential. What best describes this?',
		FINDFRIENDS_LEGENDOFSEARCHBAR	:'The scan will start automatically, if there\'s no letters, you\'ll get link suggestions.',
		DIALOG_TERMS					:
			'<p><span style="font-size:large;"><strong>Terms of Service for Tagbum.com</strong></span></p>'+
			'<p><br />'+
				'<strong>Introduction </strong><br />'+
				'<br />'+
				'Welcome to Tagbum.com. This website is owned and operated by Tagamation, LLC. By visiting our website and accessing the information, resources, services, products, and tools we provide, you understand and agree to accept and adhere to the following terms and conditions as stated in this policy (hereafter referred to as \'User Agreement\'). <br />'+
				'<br />'+
				'This agreement is in effect as of October 1, 2011.<br />'+
				'<br />'+
				'We reserve the right to change this User Agreement from time to time without notice. You acknowledge and agree that it is your responsibility to review this User Agreement periodically to familiarize yourself with any modifications. Your continued use of this site after such modifications will constitute acknowledgment and agreement of the modified terms and conditions.&nbsp; We do reserve the right to send such notification to you of any changes of this User Agreement.<br />'+
				'<br />'+
				'<strong>Responsible Use and Conduct </strong><br />'+
				'<br />'+
				'By visiting our website and accessing the information, resources, services, products, and tools we provide for you, either directly or indirectly (hereafter referred to as \'Resources\'), you agree to use these Resources only for the purposes intended as permitted by (a) the terms of this User Agreement, and (b) applicable laws, regulations and generally accepted online practices or guidelines. <br />'+
				'<br />'+
				'<strong>Wherein, you understand that:</strong><br />'+
				'<br />'+
				'a. In order to access our Resources, you may be required to provide certain information about yourself (such as identification, contact details, etc.) as part of the registration process, or as part of your ability to use the Resources. You agree that any information you provide will always be accurate, correct, and up to date. <br />'+
				'<br />'+
				'b. You are responsible for maintaining the confidentiality of any login information associated with any account you use to access our Resources. Accordingly, you are responsible for all activities that occur under your account/s. <br />'+
				'<br />'+
				'c. Accessing (or attempting to access) any of our Resources by any means other than through the means we provide, is strictly prohibited. You specifically agree not to access (or attempt to access) any of our Resources through any automated, unethical or unconventional means.<br />'+
				'<br />'+
				'd. Engaging in any activity that disrupts or interferes with our Resources, including the servers and/or networks to which our Resources are located or connected, is strictly prohibited.<br />'+
				'<br />'+
				'e. Attempting to copy, duplicate, reproduce, sell, trade, or resell our Resources is strictly prohibited.<br />'+
				'<br />'+
				'f. You are solely responsible any consequences, losses, or damages that we may directly or indirectly incur or suffer due to any unauthorized activities conducted by you, as explained above, and may incur criminal or civil liability.<br />'+
				'<br />'+
				'g. We may provide various open communication tools on our website, such as blog comments, blog posts, public chat, forums, message boards, newsgroups, product ratings and reviews, various social media services, etc. You understand that generally we do not pre-screen or monitor the content posted by users of these various communication tools, which means that if you choose to use these tools to submit any type of content to our website, then it is your personal responsibility to use these tools in a responsible and ethical manner. By posting information or otherwise using any open communication tools as mentioned, you agree that you will not upload, post, share, or otherwise distribute any content that.<br />'+
				'<br />'+
				'i. Is illegal, threatening, defamatory, abusive, harassing, degrading, intimidating, fraudulent, deceptive, invasive, racist, or contains any type of suggestive, inappropriate, or explicit language; <br />'+
				'ii. Infringes on any trademark, patent, trade secret, copyright, or other proprietary right of any party;<br />'+
				'iii. Contains any type of unauthorized or unsolicited advertising;<br />'+
				'iv. Impersonates any person or entity, including any Tagbum.com employees or representatives.<br />'+
				'<br />'+
				'<br />'+
				'We have the right at our sole discretion to remove any content that, we feel in our judgment does not comply with this User Agreement, along with any content that we feel is otherwise offensive, harmful, objectionable, inaccurate, or violates any 3rd party copyrights or trademarks. We are not responsible for any delay or failure in removing such content. If you post content that we choose to remove, you hereby consent to such removal, and consent to waive any claim against us.<br />'+
				'<br />'+
				'h. We do not assume any liability for any content posted by you or any other 3rd party users of our website. However, any content posted by you using any open communication tools on our website, provided that it doesn\'t violate or infringe on any 3rd party copyrights or trademarks, becomes the property of Tagamation, LLC, and as such, gives us a perpetual, irrevocable, worldwide, royalty-free, exclusive license to reproduce, modify, adapt, translate, publish, publicly display and/or distribute as we see fit. This only refers and applies to content posted via open communication tools as described, and does not refer to information that is provided as part of the registration process, necessary in order to use our Resources.<br />'+
				'<br />'+
				'i. You agree to indemnify and hold harmless Tagamation, LLC and its parent company and affiliates, and their directors, officers, managers, employees, donors, agents, and licensors, from and against all losses, expenses, damages and costs, including reasonable attorneys\' fees, resulting from any violation of this User Agreement or the failure to fulfill any obligations relating to your account incurred by you or any other person using your account. We reserve the right to take over the exclusive defense of any claim for which we are entitled to indemnification under this User Agreement. In such event, you shall provide us with such cooperation as is reasonably requested by us.<br />'+
				'<br />'+
				'<strong>Limitation of Warranties </strong><br />'+
				'<br />'+
				'By using our website, you understand and agree that all Resources we provide are &quot;as is&quot; and &quot;as available&quot;.&nbsp; This means that we do not represent or warrant to you that:<br />'+
				'i) the use of our Resources will meet your needs or requirements;<br />'+
				'ii) the use of our Resources will be uninterrupted, timely, secure or free from errors;<br />'+
				'iii) the information obtained by using our Resources will be accurate or reliable; and<br />'+
				'iv) any defects in the operation or functionality of any Resources we provide will be repaired or corrected.<br />'+
				'<br />'+
				'<strong>Furthermore, you understand and agree that:</strong><br />'+
				'<br />'+
				'v) any content downloaded or otherwise obtained through the use of our Resources is done at your own discretion and risk, and that you are solely responsible for any damage to your computer or other devices for any loss of data that may result from the download of such content of use of the Resources; and <br />'+
				'vi) no information or advice, whether expressed, implied, oral or written, obtained by you from Tagamation, LLC or through any Resources we provide shall create any warranty, guarantee, or conditions of any kind, except for those expressly outlined in this User Agreement.<br />'+
				'<br />'+
				'<br />'+
				'<strong>Limitation of Liability </strong><br />'+
				'<br />'+
				'In conjunction with the Limitation of Warranties as explained above, you expressly understand and agree that any claim against us shall be limited to the amount you paid, if any, for use of products and/or services. Tagamation, LLC will not be liable for any direct, indirect, incidental, consequential or exemplary loss or damages which may be incurred by you as a result of using our Resources, or as a result of any changes, data loss or corruption, cancellation, loss of access, or downtime to the full extent that applicable limitation of liability laws apply.<br />'+
				'<br />'+
				'<strong>Copyrights/Trademarks </strong><br />'+
				'<br />'+
				'All content and materials available on Tagbum.com, including but not limited to text, graphics, website name, code, images and logos are the intellectual property of Tagamation, LLC, and are protected by applicable copyright and trademark law. Any inappropriate use, including but not limited to the reproduction, distribution, display or transmission of any content on this site is strictly prohibited, unless specifically authorized by Tagamation, LLC.<br />'+
				'<br />'+
				'<strong>Termination of Use </strong><br />'+
				'<br />'+
				'You agree that we may, at our sole discretion, suspend or terminate your access to all or part of our website and Resources with or without notice and for any reason, including, without limitation, breach of this User Agreement. Any suspected illegal, fraudulent or abusive activity may be grounds for terminating your relationship and may be referred to appropriate law enforcement authorities. Upon suspension or termination, your right to use the Resources we provide will immediately cease, and we reserve the right to remove or delete any information that you may have on file with us, including any account or login information.<br />'+
				'<br />'+
				'<strong>Governing Law </strong><br />'+
				'<br />'+
				'This website is controlled by Tagamation, LLC. It can be accessed in most countries around the world. By accessing our website, you agree that the statutes and laws of Oklahoma, United States of America, without regard to the conflict of laws and the United Nations Convention on the International Sales of Goods, will apply to all matters relating to the use of this website and the purchase of any products or services through this site.<br />'+
				'<br />'+
				'Furthermore, any action to enforce or related to this User Agreement shall be brought in the federal or state courts of Oklahoma, United States of America.&nbsp; You hereby agree to submit to personal jurisdiction in such courts, and waive any jurisdictional, venue, or inconvenient forum objections to such courts.<br />'+
				'<br />'+
				'<strong>Guarantee </strong><br />'+
				'<br />'+
				'UNLESS OTHERWISE EXPRESSED, TAGAMATION, LLC EXPRESSLY DISCLAIMS ALL WARRANTIES AND CONDITIONS OF ANY KIND, WHETHER EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO THE IMPLIED WARRANTIES AND CONDITIONS OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT.<br />'+
				'<br />'+
				'Contact Information<br />'+
				'<br />'+
				'If you have any questions or comments about these Terms of Service as outlined above, you can contact us at:<br />'+
				'<br />'+
				'Tagamation, LLC<br />'+
				'<br />'+
				'HR Dept.<br />'+
				'5830 NW Expressway, #347<br />'+
				'Oklahoma City, OK 73132<br />'+
				'or<br />'+
				'Terms@seemytag.com'+
			'</p>',
		JS_TIMELINE						:'Time Line',
		JS_MYTAGS						:'My Tags',
		JS_FAVORITETAGS					:'Favorites',
		JS_PRIVATETAGS					:'Private Tags',
		JS_DELETETAG					:'Are you sure that you want to delete this tag?',
		TAG_DELETEDOK					:'Tag successfully deleted',
		TAG_DELETEDERROR				:'ERROR: Please try again',
		SCROLL_PULLDOWN					:'Pull down to refresh...',
		SCROLL_PULLUP					:'Pull up to load more...',
		SCROLL_RELEASE					:'Release to refresh...',
		SCROLL_LOADING					:'Loading...',

		CON_ERROR						:'Conexion error. Wait a momment and try again.',
		MAINMNU_GROUP					:'Group',
		MAINMNU_GROUPS					:'Groups',
		GROUPS_TITLEWINDOWSNEW			:'New Group',
		GROUPS_CLOSE					:'Closed Group',
		MSGGROUPS_CLOSE					:'If you want enter it, you should be invited for a member.',
		MSGGROUPS_CLOSE_INVI_SED		:'Please wait until the administrator approves your membership application',
		INVITE_GROUP_TRUE       		:'You have an invitation to this group',
		CONFI_JOIN_TO_GROUPS       		:'Want to join this group?',
		GROUPS_MORE						:'More Groups',
		GROUPS_MESSAGE_TAGS				:'No tags created.',
		GROUPS_MESSAGE_JOIN				:'To create tag, join the group.',
		GROUPS_MENUADDTAG				:'Add tag',
		GROUPS_MYGROUPS					:'My Groups',
		GROUPS_ALLGROUPS				:'All Groups',
		GROUPS_BACKMAIN					:'Back to main',
		GROUPS_MEMBERS					:'Members',
		GROUPS_CREATED					:'Created',

		GROUPS_MEMBERSTITLE				:'Members',
		GROUPS_MEMBERSTITLE2			:'Group Members',
		GROUPS_INVITEDFRIENDS			:'Invited Friends',
		GROUPS_SENDINVITATION			:'Send Invitation',
		GROUPS_MESSAGEMPTY				:'Find your friends and invite them to join the group',
		GROUPS_JOIN						:'Join',
		GROUPS_LEAVE					:'Leave Group',
		GROUPS_LEAVEMESSAGE				:'Sure you want to leave the group?',
		GROUPS_LEAVEASIGNAR				:'Assign',
		GROUPS_LEAVEASIGNARMSG			:'Select the group administrator(s)',
		GROUPS_LEAVEABANDONAR			:'Leave',
		GROUPS_LEAVEABANDONARMSG		:'You are the only one administrator of this group. If the group stay without administrators, this will be removed. Are you sure you want to leave the group?',
		GROUPS_LEAVEMESSAGEFINAL		:'You	have left the group successfully',
		GROUPS_LEAVEBORRADO				:'This group was removed.',
		GROUPS_LEAVECCOMPLETE			:'User(s) assigned as administrator',
		TAGS_WHENTAGNOEXIST				:'This content is no longer available',
		GROUPS_ASSIGNADMIN				:'Assign Admin',

		GROUPS_OPEN						:'Public Group',
		GROUPS_CLOSED					:'Closed Group',
		GROUPS_PRIVATE					:'Private Group',

		STORE							:'Store App',
		STORE_DETAILS					:'Product Detail',
		STORE_CATEGORY					:'Category',
		STORE_CATEGORYS					:'Categories',
		STORE_MYPUBLICATIONS			:'My publications',
		STORE_SUBCATEGORY				:'Sub - Categories',
		STORE_SHOPPING_CART				:'Shopping Cart',
		STORE_CART						:'Cart',
		STORE_SHOPPING_CHECKOUT			:'Buy',
		STORE_SHOPPING_ADD				:'Add',
		STORE_SHOPPING_POINTS			:'points',
		STORE_SHOPPING_POINTSMA			:'Points',
        STORE_SHOPPING_DOLLARS          :'Dollars',
		STORE_SHOPPING_TOTAL			:'Total Products:',
		STORE_SHOPPING_TOTAL_PRODUCTS	:'Total Points:',
        STORE_SHOPPING_TOTAL_PRODUCTSD  :'Total Dollars:',
		STORE_SHOPPING_NOITEMS			:'You haven\'t items in your shopping cart',
		STORE_SHOPPING_VALUE			:'Cost',
		STORE_SHOPPING_TITLE			:'Title',
		STORE_SHOPPING_DESCRIPTION		:'Product Description',
		STORE_SHOPPING_NOBUY			:'This background belongs to you. You cann\'t buy',
        STORE_UNI_BACKG                 :'This Backgrounds already been added to the order. The Backgrounds can only be purchased once.',
		STORE_PRODUCTO_NO_STOCK         :'Sorry this product is no longer available in stock',
        STORE_VIEWORDERINCART           :'View Order',
        STORE_SUGGEST                   :'Suggested products',
		STORE_NOSTORE_MESSAGE           :'There are not products available',
        STORE_ORDER_EDIT_STOCK          :'Some products are no longer available, your order was modified.',
		STORE_DELETESHOPPING            :'Are you sure to delete this order?',
        STORE_NOT_CHET_DOLLAR           :'Sorry, our current mobile version currently only accepts points to pay. You can checkout using our web version if you do not have enough points.',
        STORE_NO_SC                     :'Sorry, there are no items in your shopping cart.',
        STORE_NO_WL                     :'Sorry, there are no items available in your wishlist.',
        STORE_NO_AB                     :'Sorry, this option is only available to companies associated with our system.',
        STORE_SHIPPING                  :'Shipping address',
        STORE_SHIPPING_CHANGE           :'Would you like to change the shipping address?',
        STORE_COUNTRY                   :'Country',
        STORE_NO_COMPLETE               :'The following fields:',
        STORE_NO_COMPLETE_2             :'Are required.',
        STORE_NOT_NUM_PHONE             :'A phone number',
        STORE_SHOPPING_ORDER			:'Purchase Order',
		STORE_SHOPPING_DETAILS			:'Details',
		STORE_SHOPPING_NUMORDER			:'Order',
		STORE_SHOPPING_MESSAGEORDER		:'These background are available in Create Tag',
		STORE_SHOPPING_NOPOINTS			:'You don\'t have the amount of points needed to make this purchase',
		STORE_SHOPPING_SELLER			:'Published By',
		STORE_SHOPPING_BACKLIST			:'Back to list',
		STORE_SHOPPING_DELETE			:'Delete Cart',
		STORE_SHOPPING_DELETEALL		:'Delete The Shopping Cart?',
		STORE_PRODUCT_TAG				:'Create Product Tag',
		STORE_SHOPPING_ITEM				:'Delete Item',
        STORE_WISH_LIST_MOVE            :'Move to wish list',
        BUSINESSCARD_LBLCITY            :'City',
        SIGNUP_ZIPCODE                  :'Zip code',
        USERPROFILE_LBLHOMEPHONE        :'Home Phone',
        USERPROFILE_LBLWORKPHONE        :'Work Phone',
        USERPROFILE_LBLMOBILEPHONE      :'Mobile Phone',
        BUSINESSCARD_LBLADDRESS         :'Address',
        USERPROFILE_LBLCBOAREASCODE     :'Country Code',  

		MESSAGE_WELCOME					:'Welcome',
		EMPTY_TAGS_LIST					:'Empty Tags List',
		SHARETAG_TOUCHPICTURE			:'Touch the picture to delete it',

		PUBLICITY_MSGSUCCESSFULLY		:'Request successfully processed',

		TOPTAGS_TITLE		:'Top Tags',
		TOPTAGS_DAILY		:'Daily',
		TOPTAGS_WEEKLY		:'Weekly',
		TOPTAGS_MONTHLY		:'Monthly',
		TOPTAGS_YEARLY		:'Yearly',
		TOPTAGS_ALWAYS		:'Always',
		TOPTAGS_NOTAGS		:'Top Tags depend on what the people likes.<br/>Right now have no tags to show in ',

		TXT_REDIST	:' (redistribution)',
		TXT_REDISTBY:'Redistributed by ',

		EMPTY_INFO_NOTIFICATION			:'Sorry, no news to show because you have no friends. Click below to find your friends.',
		EMPTY_INFO_NEWS					:'Sorry, no notifications to show because you have no friends. Click below to find your friends.',
		EMPTY_INFO_FRIENDS				:'Sorry you have no friends. Click below to find your friends',
		EMPTY_INFO_ADMIRERS				:'Sorry, no tienes admiradores. Waiting for someone to follow you and see in this list.',
		EMPTY_INFO_ADMIRED				:'Sorry you have no admired. Click below to find your friends.',
		FIND_FRIENDS_NOTIFICATION		:'Find Friends'


	};//lang
	if(!more[actual]) actual='en';//si no existe el idioma, usamos el ingles por default.
	lang.actual=actual;
	actual=more[actual];
	if(actual) for(var i in actual) lang[i]=actual[i];
	lang.info=function(opc){
		var i,n=(opc.usr?2:1),infos=lang.info.INFO,info=infos[opc.type]||'',rep;
		if(!opc.num) opc.num=1;
		if(opc.num>1){
			info=info.replace(/{{([^}]*)}}/g,'$1').replace(/{([^}]*)}/g, '' );
		}else{
			info=info.replace(/{{([^}]*)}}/g, '' ).replace(/{([^}]*)}/g,'$1');
		}
		for(i in infos.replace[0]){
			rep=infos.replace[0][i];
			info=info.replace(rep[0],rep[n]||rep[1]);
		}
		info=info.replace('[_FRIENDS_]', opc.people||opc.friends||'').replace('[_USR_]', opc.usr||'').replace('[_GROUP_]', opc.group||'');
		for(i in infos.replace[1]){
			rep=infos.replace[1][i];
			info=info.replace(rep[0],rep[n]||rep[1]);
		}
		return info;
	};
	lang.getInfo=lang.info;
	lang.info.INFO=lang.INFO;
})(window);

function lan(value,opc){
	var txt=(lang[value]||value);
	//cambio de caracteres especiales por unicode (español)
	if(lang.actual=='es') txt=txt
	.replace(/Á|&Aacute;/,'\u00C1').replace(/á|&aacute;/,'\u00E1')
	.replace(/É|&Eacute;/,'\u00C9').replace(/é|&eacute;/,'\u00E9')
	.replace(/Í|&Iacute;/,'\u00CD').replace(/í|&iacute;/,'\u00ED')
	.replace(/Ó|&Oacute;/,'\u00D3').replace(/ó|&oacute;/,'\u00F3')
	.replace(/Ú|&Uacute;/,'\u00DA').replace(/ú|&uacute;/,'\u00FA')
	.replace(/Ñ|&Ntilde;/,'\u00D1').replace(/ñ|&ntilde;/,'\u00F1');
	if(opc&&typeof opc=='string'){
		switch(opc.toLowerCase()){
			case 'lc':txt=txt.toLowerCase();break;
			case 'uc':txt=txt.toUpperCase();break;
			case 'ucf':txt=txt.toUpperCaseFirst();break;
			case 'ucw':txt=txt.toUpperCaseWords();break;
		}
	}
	return txt;
}

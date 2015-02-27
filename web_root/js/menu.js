var timeout         = 0;
var closetimer		= 0;
var ddmenuitem      = 0;

// abrir div del menu
function mopen(id)
{	
	mcancelclosetime();

	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = 'visible';

}

// cerrar div del menu
function mclose()
{
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}

function mclosetime()
{
	closetimer = window.setTimeout(mclose, timeout);
}

function mcancelclosetime()
{
	if(closetimer)
	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

document.onclick = mclose; 

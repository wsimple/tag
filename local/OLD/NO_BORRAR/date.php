<?php
     
	 include ("class/validation.class.php");
	 
	/* $fecha = "9/12/";
	 
	 
	 $date = date('Y', strtotime($fecha));
	 
	 echo "> ".$date." <br><br> ";
	 
	 if (!valid::isDate($fecha)){
		
		 echo "error";
	 }*/
	 
	 
	 
	 $date = '01/02/1969'; 
	 
/*$date = strtotime ($date) ? date ('Y-m-d', strtotime ($date)) : 'error'; 
echo $date; 
*/
if (strtotime ($date))
		{
			echo "bello";
		} else {
			echo "malo";
		}


?>
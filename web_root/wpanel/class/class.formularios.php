<?php
	$_LENGUAGE['es']['ayuda']="Ayuda";
	$_LENGUAGE['es']['consultaSinresultado']="Consulta sin resultados, intente nuevamente";
	$_LENGUAGE['es']['contrasena']="password";
	$_LENGUAGE['es']['seleccioneUnItem']="Seleccione un Item";
	$_LENGUAGE['es']['atras']="Atras";
	$_LENGUAGE['es']['camposObligatorios']="Campos obligatorios";
	$_LENGUAGE['es']['datosEnviadosCorrectamente']="Datos enviados correctamente";
	$_LENGUAGE['es']['proveedorDeSoftware']="Comunique a su proveedor de Software";
	$_LENGUAGE['es']['buscar']="Buscar";
	$_LENGUAGE['es']['reiniciar']="Reiniciar";
	$_LENGUAGE['es']['seguroDeEliminarItem']="Esta seguro de eliminar este item";
	$_LENGUAGE['es']['eliminar']="Eliminar";
	$_LENGUAGE['es']['filtro']="Filtro";

	$_LENGUAGE['en']['ayuda']="Help";
	$_LENGUAGE['en']['consultaSinresultado']="query no results, try again!";
	$_LENGUAGE['en']['contrasena']="password";
	$_LENGUAGE['en']['seleccioneUnItem']="Select a Item";
	$_LENGUAGE['en']['atras']="Back";
	$_LENGUAGE['en']['camposObligatorios']="Required fields";
	$_LENGUAGE['en']['datosEnviadosCorrectamente']="Data sent successfully";
	$_LENGUAGE['en']['proveedorDeSoftware']="call your Software provider ";
	$_LENGUAGE['en']['buscar']="Search";
	$_LENGUAGE['en']['reiniciar']="View All";
	$_LENGUAGE['en']['seguroDeEliminarItem']="Are you sure to delete this item";
	$_LENGUAGE['en']['eliminar']="Delete";
	$_LENGUAGE['en']['filtro']="Filter";

	$_primero = true;

	class formulario
	{	var $destino;
		var $metodo;
		var $etiquetaBoton;
		var $nombre;
		var $titulo;
		var $enPruebas;
		var $consulta;//determina si el formulario se llena con la consulta
		var $sinImput;
		var $ajax;
		var $grillaDelete;
		var $ayuda;
		var $idioma;
		var $fileRetorno;
		var $showButtomBack;
	
		function formulario($nombre='', $destino='',$etiquetaBoton='Enviar',$ayuda='',$metodo='post',$fileRetorno='index.php')
		{	$this->nombre=quitarAcentos($nombre);
			$this->titulo= htmlentities(ucwords(str_replace('_',' ',$nombre)));
			$this->destino=$destino;
			$this->etiquetaBoton=$etiquetaBoton;
			$this->metodo=$metodo;
			$this->consulta=false;
			$this->primero=true;
			$this->ajax=true;
			$this->enPruebas=false;
			$this->grillaDelete=true;
			$this->ayuda=$ayuda;
			$this->idioma='en';
			$this->fileRetorno = $fileRetorno;
			$this->showButtomBack = true;
			$this->cn=new wconecta(HOST, USER, PASS, DATA);
		}

		function inicio()
		{	echo "	<fieldset>
						<legend>".$this->titulo."</legend>
							<form id='$this->nombre' name='$this->nombre' method='$this->metodo' action='$this->destino' class='formulario' enctype='multipart/form-data'>
								<table border=0  width='100%' >
									<tr>
										<td  >&nbsp;</td>
									</tr>
								</table>
								<table border=0  >";
		}
		function inputs($sentenciaSQL,$disabled='')
		{	/*
				1 = requerido
			*/
			$consultatemp=$this->cn->query($sentenciaSQL);
			$fields = mysql_num_fields($consultatemp);
			$this->consulta = ($this->sinImput) ? true : $this->consulta;
		
			if($this->consulta)
			{	if(mysql_num_rows($consultatemp)==0)
				{	echo "	<script language='javascript' type='text/javascript' >
								window.addEvent('domready', function()
								{	Alert.info('".$GLOBALS['_LENGUAGE'][$this->idioma]['consultaSinresultado']."! <img src=\'img/delete.png\' border=\'0\' />', 
									{	onComplete: function(returnvalue) 
										{
											redirect('index.php');
										}
									});
								});
							</script>";
					return;							  
				}
				$consulta=mysql_fetch_assoc($consultatemp);
			}
			for ($i=0; $i < $fields; $i++)
			{	$etiqueta= htmlentities(ucfirst (str_replace('_',' ',mysql_field_name($consultatemp, $i))));
				$name  = strtolower (mysql_field_name($consultatemp, $i));
				$campo = mysql_field_name($consultatemp, $i);
				$len   = mysql_field_len($consultatemp, $i);
				$type  = mysql_field_type($consultatemp, $i);
				$tipo="text";
				$valida=explode(' ', $etiqueta);
				$especifica=$valida[count($valida)-1];
				$valida=$valida[count($valida)-1]*1; 
				if($valida)
				{	$nameTemp=explode('_',$name);
					$nameTemp[count($nameTemp)-1]=(count($nameTemp)-1)==0?$nameTemp[count($nameTemp)-1]:'';
					$name='';
					foreach( $nameTemp as  $Temp)
					{	$name.=$Temp.' ';
					}
					$name=str_replace(' ','_',trim($name));
					$etiqueta=ucfirst (str_replace('_',' ',trim($name)));
					if($valida=='1')
					{	$valida="requerido='$etiqueta'";
					} else
					{	$valida="requerido='$etiqueta' tamanio='$valida'";
					}
				} elseif($especifica=='email'||$especifica=='file')
				{	$nameTemp=explode('_',$name);
					$nameTemp[count($nameTemp)-1]=(count($nameTemp)-1)==0?$nameTemp[count($nameTemp)-1]:'';
					$name='';
					foreach( $nameTemp as  $Temp)
					{	$name.=$Temp.' ';
					}
					$name=str_replace(' ','_',trim($name));
					$etiqueta=ucfirst (str_replace('_',' ',trim($name)));
					if($especifica=='email')
					{	$valida="requerido='$etiqueta' mail='1'";
					} else
					{	//$valida="requerido='$etiqueta'";
						$tipo='file';
					}
				}
				$name=$this->nombre.'_'.$name;
				if(!$this->sinImput)
				{
					if($GLOBALS['_primero'])
					{	$id='primero'; $GLOBALS['_primero']=false;
					} else
					{	$id=quitarAcentos($name);
				}
				switch($type)
				{	case 'int': $funcionValida="onKeyPress='return soloNum(event)'";
					break;
					case 'real':
					case 'float': 
					case 'double':$funcionValida="onKeyPress='return soloDecimal(event,this.id)' tipo='moneda'"; break;
					case 'datetime':  
					case 'date': $len = 10;
								 $funcionValida=" onclick='displayCalendar(\"$id\",\"yyyy-mm-dd\",$(\"calendar_$id\"))' readonly";
								 $date="<img id='calendar_$id' src='img/calendar.gif' width='16' height='16' onclick='displayCalendar(\"$id\",\"yyyy-mm-dd\",this)' style='cursor:pointer;'>";
								 if($this->consulta)$consulta[$campo]=$consulta[$campo]!=''?formatoFecha($consulta[$campo]):'';
					break;
					case 'blob': $len = '150';
					case 'string': $funcionValida="onKeyPress='return val_caracter(event)'";break;
				}
			} else
			{	$id=$name;
				switch($type)
				{
					case 'real':
					case 'float': 
					case 'double':$consulta[$campo]=number_format($consulta[$campo],2,',','.'); break;
					case 'datetime':  
					case 'date': $consulta[$campo]=formatoFecha($consulta[$campo]);break;
				}
			}
			
			if($name==$this->nombre.'_'.$GLOBALS['_LENGUAGE'][$this->idioma]['contrasena'] || $name==$this->nombre.'_'."retype_".$GLOBALS['_LENGUAGE'][$this->idioma]['contrasena']){
				$consulta[$campo]='';
				$len = 10;	
				$tipo="password";				
			}elseif($especifica=="email")
			{	$len = 30;
			}elseif($especifica=='file')
			{	$len = 30;
			}
			if($disabled==1){$disabled='disabled';}else{$disabled='';}
			echo "\n<tr><td class='etiquetas' >$etiqueta: </td><td  ".($this->sinImput&&$this->consulta? "class='consultas'" :'')." >";
			if($len<50)
			{	echo $this->sinImput&&'&nbsp; '.$this->consulta ? $consulta[$campo]."<input name='$name' id='$id' type='hidden' value='$consulta[$campo]'>" :"<input name='$name' id='$id' $disabled type='$tipo' size='$len' value='$consulta[$campo]' $funcionValida $valida>$date".($valida!=''?'<span class="requeridos"> &deg;</span>':'');
			}else
			{	$rows=ceil($len/50);
				echo $this->sinImput&&'&nbsp; '.$this->consulta ? $consulta[$campo]."<input name='$name' id='$id' type='hidden' value='$consulta[$campo]'>" :"<textarea name='$name' cols='45' $disabled id='$id' rows='$rows' $funcionValida $valida>$consulta[$campo]</textarea>".($valida!=''?'<span class="requeridos"> &deg;</span>':'');
			}
			echo "</td></tr>\n ";
			$funcionValida='';
			$date='';
			$valida='';
		}
	}
	
	function selects($selects,$disabled=''){//  array("ids"=>"consultas", )
		/*
		   consulta especifica separar con |
		   acepta array independientes
		*/
			foreach( $selects as $key => $consulta ) {
				//echo "Key: $key; Consulta: $consulta<br>";
				 if($key[0]!='*'){
					$band=true;
				}else{		
					$key=substr($key, 1); 
					$band=false;
				}
				$etiqueta= ucfirst (str_replace('_',' ',$key));
				$name  = $key;
				//$list=$list?"size='".count($selects)."'":"";
				$name=$this->nombre.'_'.$name;
				if($disabled==1){$disabled='disabled';}else{$disabled='';}
				if($GLOBALS['_primero']){$id='primero'; $GLOBALS['_primero']=false;}else{ $id=$name;}
				if($band){
					echo "\n<tr><td class='etiquetas'>$etiqueta: </td><td><div id='box_$name'>";
				}
					echo "<select name='$name' id='$id' $valida $disabled $list requerido='$etiqueta'>";
					
					
					if(!is_array($consulta)&&$consulta!=''){
					
						$_band=strpos($consulta,'|');
						$selectsAux=str_replace('|','',$consulta);
						$consulta=explode('|',$consulta);
						
						$consulta=$consulta[0].' '.$consulta[2];
						
						
						
						////////////
						$valores=$this->cn->query($consulta);
						if($_band){
							$seleccionado=$this->cn->query($selectsAux);
							$seleccionado=mysql_fetch_assoc($seleccionado);
						}else{
							echo "<option value=''>".$GLOBALS['_LENGUAGE'][$this->idioma]['SeleccioneUnItem']."</option>";
						}
						
						while($valor=mysql_fetch_assoc($valores)){				
							echo "<option value='$valor[valor]' ".($seleccionado[valor]==$valor[valor]? 'selected':'').">".corta_cadena($valor[descripcion],60)."</option> \n";					
						}
					
						
					}else{
					
						foreach( $consulta as $item ) {
							$itemTemp=explode('|',$item);
							if(count($itemTemp)>1){
								$itemValor=$itemTemp[0];
								$itemDescrip=$itemTemp[1];
							}else{
								$itemValor=$itemDescrip=$item;
							}
							
							echo "<option value='$itemValor'>",ucfirst ($itemDescrip), "</option> \n";
						}
					
					}					
					echo "</select>";
						  
				if($band){	  
				echo "</div></td></tr>\n ";
				}
			}
		
	}
	function fin($ajax=true){
		echo "\n<tr>
					<td colspan='2' align='center'>";
					
					
		if ($this->showButtomBack){
			$this->showButtomBack= $this->showButtomBack===true? $GLOBALS['_LENGUAGE'][$this->idioma]['atras'] :$this->showButtomBack;			
			echo "<input type='button' class='boton' name='atras' id='atras' value=' ".$this->showButtomBack." ' onclick='history.back();' />";
		}	
		if($this->etiquetaBoton!=''){
			echo "<input type='submit' class='boton' name='$this->etiquetaBoton' id='$this->etiquetaBoton' value=' ". ucfirst ($this->etiquetaBoton)." '/>";
		}
		echo "</td>
				</tr>
				<tr>
					<td colspan='2' class='requeridos'>[ &deg; ] ".$GLOBALS['_LENGUAGE'][$this->idioma]['camposObligatorios']."  <input name='_FORM_' type='hidden' id='".$this->nombre."_FORM_' value='".$this->nombre."' /></td>
				</tr>
				</table> </form></fieldset>";
				
		echo "
		<script language='javascript' type='text/javascript' >
			window.addEvent('domready', function(){				
						
						$('$this->nombre').addEvent('submit', function(e) {
							e.stop();
						";
				if($ajax){
		   		 echo "	
							//////////////////
							
							
							this.set('send', {onSuccess: function(response) { 
								Alert.info('".$GLOBALS['_LENGUAGE'][$this->idioma]['datosEnviadosCorrectamente']."! <img src=\'img/accept.png\' border=\'0\' />', 
											  {onComplete: function(returnvalue) 
											  			   {
														    
															 
															  	redirect('".$this->fileRetorno."');
															
															
															}
											  });
											  
								".($this->enPruebas?'':'//')."alert(response);
							},
							
							onFailure: function(){
								Alert.error('Error! <br> ".$GLOBALS['_LENGUAGE'][$this->idioma]['proveedorDeSoftware']."...');
							}
							
							});	
												
							if(valida('$this->nombre')){ 											
								this.send();
							}
							//////////////////
					";
					}else{
					
					echo "if(valida('$this->nombre')){ 
							this.submit();
						  }";
					}
				echo "		
							
							
						});
	
				 });
		 </script>";		
	}
	
	function enPruebas(){
		$this->enPruebas=true;
	}
	function noAjax(){
		$this->ajax=false;
	}

	function consulta($sinImput=false){
		$this->consulta=true;
		$this->sinImput=$sinImput;
	}
	function noConsulta(){
		$this->consulta=false;
		$this->sinImput=false;
	}
	function division($titulo=''){
		echo "<tr ><td  colspan='2' align='center'><br>$titulo<hr></td><td></td></tr >";
	}
	
	function grilla($sql,$tipo=1,$leng='',$orden="DESC",$act=""){
		if($_REQUEST[_keyword_]!=''){
			$consulta=$sql;
			//$consulta=str_replace(array(' from ','select ','where'),array(' FROM ','SELECT ','WHERE'),$consulta);
			$consulta=preg_replace('/\bSELECT\b/i','SELECT',$consulta);
			$consulta=preg_replace('/\bFROM\b/i','FROM',$consulta);
			$consulta=preg_replace('/\bWHERE\b/i','WHERE',$consulta);
			#separamos SELECT del resto
			$picada=explode('FROM',end(explode("SELECT",$consulta)));
			$select='SELECT '.trim($picada[0]);
			$values=explode(',',$picada[0]);
			$nombreCampos='';
			$like=array();
			foreach($values as $val){
				$nombreCampo=explode(' ', trim($val));
				if(0==strpos($nombreCampo[0],'(')&&0==strpos($nombreCampo[0],')')&&0==strpos(' '.$nombreCampo[0],"'")&&trim($nombreCampo[0])!='')// contiene una funcion
					$like[]=$nombreCampo[0].' like "%'.$_REQUEST[_keyword_].'%"';
			}
			#separamos FROM del restante (WHERE y demas)
			$picada=explode('WHERE',$picada[1]);
			$from=' FROM '.trim($picada[0]);
			$like=implode(' OR ',$like);
			if($picada[1]!=''){
				$where=' WHERE ('.$like.') AND '.$picada[1];
			}else{
				$where=' WHERE '.$like;
			}
			$sql=$select.$from.$where;
			$num=mysql_query($sql) or die(mysql_error().' - - -<br />'.$sql);
			$num=mysql_num_rows($num);
		}
		$_pagi_cuantos=$num!=''?$num:60;
		$_pagi_nav_num_enlaces=10;
		$_pagi_sql=$sql;
		include('includes/paginator.inc.php');
		if(mysql_num_rows($_pagi_result)!=0){
		echo "<fieldset><legend>".$this->titulo."</legend>";
		if($this->ayuda===true){
			echo '
				<table border=0 width="100%">
					<tr>
						<td>
							<div align="right"><img src="img/ayuda.png" width="24" height="24" style="cursor:pointer;"
								title="'.$GLOBALS['_LENGUAGE'][$this->idioma]['ayuda'].'"
								onclick="Alert.info(\''.$this->ayuda.'\');">
							</div>
						</td>
					</tr>
				</table>
			';
		}
		$i=0;
		$nombreTabla=mysql_field_table($_pagi_result, 0); // 'id'
		while($consult=mysql_fetch_assoc($_pagi_result)){
			if($i==0){
				echo '<div id="sortabletable">
					<div class="tableFilter">
						<form id="tableFilter" >';
				echo generaHidden();
				//echo $GLOBALS['_LENGUAGE'][$this->idioma]['filtro'].':<select id="column">';
				$j=0;
				$header='';
				$foot='';
				foreach($consult as $key => $value){
					//echo "<option value='$j'>$key</option>";
					$header.="<th axis='string'>".str_replace("_"," ",ucfirst($key))."</th>";
					$foot.="<td></td>";
					$j++;
				}
				//echo '</select>
				echo	'	<input type="text" id="_keyword_" name="_keyword_" />
							<input type="submit" value="'.$GLOBALS['_LENGUAGE'][$this->idioma]['buscar'].'" />
							<input type="reset" value="'.$GLOBALS['_LENGUAGE'][$this->idioma]['reiniciar'].'" onclick="redirect(\'?url=vistas/users/usersRegistered.vista.php\')" />';
							
				echo	'</form>
					 </div>
					  '.$_pagi_navegacion.$_pagi_info.'<br /><br />

					 <table id="myTable" cellpadding="0" >
						<thead>'.$header;
						 echo ($act!=2)?(($tipo!=5)? '<th >&nbsp;</th>':''):'';
						echo'</thead><tbody>';	
				
			}	
			echo "<tr id='$consult[id]'>";
				$y=0;
				foreach($consult as $key => $value){
				    $type  = mysql_field_type($_pagi_result, $y);
					
					switch($type){
						case 'real':
						case 'float': 
						case 'double':$value=number_format($value,2); $_tipo="axis='number'"; break;
						case 'datetime':  
						case 'date': $value=formatoFecha($value); $_tipo="axis='date'"; break;
						default: $_tipo="axis='string'"; $value=ucfirst($value); break;

					}
					
					echo "<td $_tipo  style='border:1px solid #CCCCCC; font-weight:normal; padding:3px; text-align:center'>$value</td>";
					$y++;
		
				}
				$delete=false;
				switch($tipo){
					case 1: $img="img/change.png"; break;
					case 2: $img="img/select.png"; break; 
					case 3: $img="img/printer.png"; break;
					default: $img=$tipo;										
				
				}
				if($act!=2){
				echo "<td>";
				$idioma=($leng!='')?'_languages_='.$leng:'';
						
					if($img!=5)
						echo "<img src='$img' alt='$this->etiquetaBoton' title='$this->etiquetaBoton' id='$this->etiquetaBoton' onClick=\" redirect('$this->destino'+'&id_consulta=$consult[id]'+'&$idioma');  \"/>";
				
				if($act!=1){
					if($this->grillaDelete){
					echo $act."&nbsp;&nbsp;&nbsp;&nbsp;<img src='img/delete.png' alt='".$GLOBALS['_LENGUAGE'][$this->idioma]['eliminar']."' id='$this->etiquetaBoton2' title='".$GLOBALS['_LENGUAGE'][$this->idioma]['eliminar']."' onClick=\"";

					echo "
						Alert.confirm('".$GLOBALS['_LENGUAGE'][$this->idioma]['seguroDeEliminarItem']."? <img src=\'img/delete.png \'  border=\'0\' />',
							{onComplete: function(returnvalue) 
								{
									if(returnvalue){
										redirect('?url=includes/delete.php&id_consulta=$consult[id]&tabla=$nombreTabla');
									}
								}
							});
					";
					echo" \"/>";
					}
				}
				echo "</td>";
				}
			echo '</tr>';
			$i++;
		}	
			echo "</tbody>
					<tfoot>
						<tr>
							$foot
						</tr>
					</tfoot>
				  </table><br />
				$_pagi_navegacion $_pagi_info
				<script type='text/javascript'>
					var myTable = {};
					window.addEvent('domready', function(){
						myTable = new sortableTable('myTable', {sortBy:'$orden', overCls: 'over', onClick: function(){alert(this.id);}});
					});
				</script>
				</div>
				</fieldset>";
		}else{
		if($this->ayuda===true)echo '<div class="errormessage">'.$GLOBALS['_LENGUAGE'][$this->idioma]['consultaSinresultado'].'! <img src=\'img/delete.png\' border=\'0\' style="float:right"  /></div>';
		/*
		echo "<script language='javascript' type='text/javascript' >
						window.addEvent('domready', function(){	
							
							Alert.info('".$GLOBALS['_LENGUAGE'][$this->idioma]['consultaSinresultado']."! <img src=\'images/delete.png\' border=\'0\' />', 
											  {onComplete: function(returnvalue) 
											  			   {
															  	history.back();
															
															}
							});
							});
					  </script>";
			*/								  
			return;			
		}		
	}
	
	function hidden($nombre,$valor){
		echo "<input name='$nombre' type='hidden' id='$nombre' value='$valor' />"; 
	}
	function insertHtml($etiqueta,$html){
		if($etiqueta!='')
			echo "<tr><td class='etiquetas'> $etiqueta: </td><td ".($this->sinImput&&$this->consulta? "class='consultas'" :'').">$html</td></tr>";
		else	
	  		echo "<tr ><td  colspan='2' ".($this->sinImput&&$this->consulta? "class='consultas'" :'')." >$html</td><td></td></tr >";	
	
	}
	function insertFCKEditor($id, $value='', $width='650', $height='300'){
		echo '<tr><td colspan="2">';
        $oFCKeditor = new FCKeditor($id) ;
        $oFCKeditor->BasePath = 'fckeditor/';
        $oFCKeditor->Width    = $width;
        $oFCKeditor->Height   = $height;
        $oFCKeditor->Value    = $value;

        $oFCKeditor->Create();
        echo '</td></tr>';
	}
	function insertTitle($text){
		echo '
			<tr>
				<td colspan="2" style="border-top: 1px solid #ccc; background-color: #f4f4f4; font-size: 11px; font-weight: bold; padding:5px;">
					'.$text.'
				</td>
			</tr>
		';	
	}
	function insertColspan($text=''){
		echo '
			<tr>
				<td colspan="2">
					'.($text!=''?$text:'&nbsp;').'
				</td>
			</tr>
		';	
	}
	function checkboxs($selects){//  array("ids"=>"consultas", )
		
			foreach( $selects as $key => $consulta ) {
				//echo "Key: $key; Consulta: $consulta<br>";
				 if($key[0]!='*'){
					$band=true;
				}else{		
					$key=substr($key, 1); 
					$band=false;
				}
				$etiqueta= ucfirst (str_replace('_',' ',$key));
				$name  = $key;
				//$list=$list?"size='".count($selects)."'":"";
				$name=$this->nombre.'_'.$name;
				if($GLOBALS['_primero']){$id='primero'; $GLOBALS['_primero']=false;}else{ $id=$name;}
				if($band){
					echo "\n<tr><td class='etiquetas'>$etiqueta: </td><td><div id='box_$name'>";
				}
					
					
					
					if(!is_array($consulta)&&$consulta!=''){
					
						$_band=strpos($consulta,'|');
						$selectsAux=str_replace('|','',$consulta);
						$consulta=explode('|',$consulta);
						
						$consulta=$consulta[0].' '.$consulta[2];
						
						
						
						////////////
						$valores=$this->cn->query($consulta);
						if($_band){
						
							$seleccionado=$this->cn->query($selectsAux);
							$seleccionado=mysql_fetch_assoc($seleccionado);
						}
						
						while($valor=mysql_fetch_assoc($valores)){
							echo "<label><input name='".$name."[]' type='checkbox' id='$name' value='$valor[valor]'  ".($seleccionado[valor]==$valor[valor]? "checked='checked'":'')." />".corta_cadena($valor[descripcion],60)."</label><br />";				
											
						}
					}else{
					
						foreach( $consulta as $item ) {
							$itemTemp=explode('|',$item);
							if(count($itemTemp)>1){
								$itemValor=$itemTemp[0];
								$itemDescrip=$itemTemp[1];
							}else{
								$itemValor=$itemDescrip=$item;
							}
							
							
							echo "<label><input name='".$name."[]' type='checkbox' id='$name' value='$itemValor'  />".corta_cadena($itemDescrip,60)."</label><br />";
						}
					
					}					
					
						  
				if($band){	  
				echo "</div></td></tr>\n ";
				}
			}
		
	}

	
 }

 ?>
 


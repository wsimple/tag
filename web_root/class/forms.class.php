<?php
	class forms{
		private $width;
		private $name;
		private $event;
		private $id;
		private $value;
		private $type;
		private $wrap;
		private $validate;

		public function __construct(){
			$this->width       = 0;
			$this->name        = '';
			$this->event       = '';
			$this->value       = '';
			$this->wrap        = '';
			$this->type        = '';
			$this->validate    = '';
		}

		public function __destruct () {
			$this->width       = '';
			$this->name        = '';
			$this->event       = '';
			$this->value       = '';
			$this->wrap        = '';
			$this->type        = '';
			$this->validate    = '';
		}

		public function imput( $name, $value,$width='', $type='', $event='', $wrap='', $validate=''){
			$this->width	= $width;
			$this->name		= $name;
			$this->value	= $value;
			$this->event	= $event;
			$this->type		= $type;
			$this->wrap		= $wrap;
			$this->validate	= explode ('|', $validate);

			$requerido = ($this->validate[0]!='') ? 'requerido="'.$this->validate[0].'"' : '';
			$tipo      = ($this->validate[1]!='') ? 'tipo="'.$this->validate[1].'"' : '';
			$tamanio   = ($this->validate[2]!='') ? 'tamanio="'.$this->validate[2].'"' : '';

			echo '<div> <input type="'.$this->type.'" class="txt_box"  name="'.$this->name.'"  id="'.$this->name.'"   style="width:'.$this->width.'"  value="'.$this->value.'"  '.$this->event.'  '.$requerido.'  '.$tipo.' '.$tamanio.' /></div>';
		}

		public function button( $name, $event='', $wrap=''){
			$this->name		= $name;
			$this->event	= $event;
			$this->wrap		= $wrap;
			$this->id		= str_replace(' ','_',$this->name);

			echo '
				<div class="'.$this->wrap.'">
					<img src="img/leftButtom.png" class="esquina_izq_imputs" />
					<img src="img/rigthButtom.png" class="esquina_der_imputs" />
					<div class="button_control">
						<div id="'.$this->id.'">'.$this->name.'</div>
					</div>
				</div>
			';
		}
	}
?>

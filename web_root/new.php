<?php
if(isset($_GET['wpanel'])&&preg_match('/language/i',$_SERVER['REQUEST_URI'])) header('Location: panel/language?wpanel');

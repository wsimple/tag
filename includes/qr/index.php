<?php    
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'includes/qr/temp/'; 
	
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.$_GET['dataQR'].'test.png';
    
    $errorCorrectionLevel = 'L';
    
    $matrixPointSize = 3;
    

    if (isset($_GET['dataQR'])) { echo 'asdasd';
    
        //it's very important!
        //if (trim($_GET['dataQR']) == '')
           // die();//'data cannot be empty! <a href="?">back</a>'
            
        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($_GET['dataQR'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_GET['dataQR'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    }  
        
    //display generated file
    $cad .='<img src="'.$PNG_WEB_DIR.basename($filename).'" />';  
    
    /*//config form
    echo '<form action="index.php" method="post">
        Data:&nbsp;<input name="data" value="'.(isset($_GET['dataQR'])?htmlspecialchars($_GET['dataQR']):'PHP QR Code :)').'" />&nbsp;
        ECC:&nbsp;<select name="level">
            <option value="L"'.(($errorCorrectionLevel=='L')?' selected':'').'>L - smallest</option>
            <option value="M"'.(($errorCorrectionLevel=='M')?' selected':'').'>M</option>
            <option value="Q"'.(($errorCorrectionLevel=='Q')?' selected':'').'>Q</option>
            <option value="H"'.(($errorCorrectionLevel=='H')?' selected':'').'>H - best</option>
        </select>&nbsp;
        Size:&nbsp;<select name="size">';
        
    for($i=1;$i<=10;$i++)
        echo '<option value="'.$i.'"'.(($matrixPointSize==$i)?' selected':'').'>'.$i.'</option>';
        
    echo '</select>&nbsp;
        <input type="submit" value="GENERATE"></form><hr/>';*/
        
    // benchmark
   // QRtools::timeBenchmark();    

    
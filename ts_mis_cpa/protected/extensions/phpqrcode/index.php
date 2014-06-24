<?php    

 
    include "qrlib.php";    
    
    $filename = './myTest.png';
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 4;
    QRcode::png('http://www.baidu.com', false, $errorCorrectionLevel, $matrixPointSize, 2);    
    //echo '<img src="'.basename($filename).'" /><hr/>';  
    
   

    

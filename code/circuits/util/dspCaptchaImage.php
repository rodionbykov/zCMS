<?php
    $oCaptcha = new Captcha($fusebox['pathAssets'] . "fonts");
    if($oCaptcha->initialize()){
    	$_SESSION['SecretUserString'] = $oCaptcha->getSecretKey();
        $oCaptcha->getImage();
    }
    
?>
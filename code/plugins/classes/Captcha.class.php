<?php

/** Implementation of CAPTCHA human detector mechanism
 * 
 * Author: Rodion Bykov (bykov@ziost.com)
 * 
 * (c) Ziost, 2007
 * Portions of code (c) Kruglov Sergei, 2006, www.captcha.ru, www.kruglov.ru
 * 
 * Version 4b2 build 1 
 * Date 03/30/2007
 * 
 * History:
 * 03/30/2007: Released
 */

class Captcha {

var $fSecretKey; // secret key string that will be shown to user
var $fFontsPath; // absolute path to fonts dir
var $fFonts; // array of available fonts
var $fAlphabet = "0123456789abcdefghijklmnopqrstuvwxyz"; // character set, do not change without changing font files!
var $fAllowedSymbols = "23456789abcdeghkmnpqsuvxyz"; // $this->fAlphabet without similar symbols (o=0, 1=l, i=j, t=f)
var $fWidth = 120;
var $fHeight = 60;
var $fluctuation_amplitude = 5;
var $no_spaces = true;
var $jpeg_quality = 90;


    /** Constructor
     * 
     * @param string Path to fonts images
     * @param string Secret key
     * @param int Length of auto-generated secret key
     */
    function Captcha($fontspath, $keystring = "", $lenght = 4) {	
        $this->fFontsPath = $fontspath;
        $this->fFonts = array();
        if(strlen($keystring) == 0){
        	$this->generateSecretKey($lenght);
        }else{
        	$this->fSecretKey = $keystring;
        }
    }
    
    /** Initializing fonts
     * 
     * @return bool Initialization result
     */
    function initialize(){
        if ($handle = opendir($this->fFontsPath)) {
            while (false !== ($file = readdir($handle))) {
                if (preg_match('/\.png$/i', $file)) {
                    $this->fFonts[] = $this->fFontsPath . '/' . $file;
                }
            }
            closedir($handle);
            return true;
        }else{
        	return false;
        }
    }
    
    /** Getting secret key
     * 
     * @return string Secret key that is displayed to user 
     */
     function getSecretKey(){
     	return $this->fSecretKey;
     }
     
     /** Setting secret key
      * 
      * @param string Secret key string to set
      * @return bool Result of setting secret key
      */
      function setSecretKey($key){
        // some characters combinations are not looking good and can mislead user
        if(strlen($key) && !preg_match("/cp|cb|ck|c6|c9|rn|rm|mm|co|do|cl|db|qp|qb|dp/", $key)){
            return $this->fSecretKey = $key;
        }else{
        	return false;
        }
      }
      
      /** Generating secret key
       * 
       * @return string Secret key generated
       */
       function generateSecretKey($length = 4){
         $key = "";
         while(!$this->setSecretKey($key)){
         	for($i=0; $i<$length; $i++){
                $key .= $this->fAllowedSymbols{mt_rand(0, strlen($this->fAllowedSymbols)-1)};
            }  
         }
         return $key;
       }
       
       /** Getting font 
        * 
        * @return resource Image with font
        */
        function getFont(){
        	 
            $font_file = $this->fFonts[mt_rand(0, count($this->fFonts)-1)];
            $font=imagecreatefrompng($font_file);
            imagealphablending($font, true);
            
            return $font;
        }
        
        /** Loading font image file and parsing
         * 
         * @param resource font image
         * @return array font metrics
         */ 
        function loadFont($font){
            
        	$fontfile_width = imagesx($font);
            $arrFontMetrics = array();
            $symbol = 0;
            $reading_symbol = false;

            // loading font
            for($i=0; $i < $fontfile_width && $symbol < strlen($this->fAlphabet); $i++){
                $transparent = (imagecolorat($font, $i, 0) >> 24) == 127;

                if(!$reading_symbol && !$transparent){
                    $arrFontMetrics[$this->fAlphabet{$symbol}]=array('start'=>$i);
                    $reading_symbol=true;
                    continue;
                }

                if($reading_symbol && $transparent){
                    $arrFontMetrics[$this->fAlphabet{$symbol}]['end']=$i;
                    $reading_symbol=false;
                    $symbol++;
                    continue;
                }
            }
            
            return $arrFontMetrics;
        }
        
        /** Output captcha image to browser
         * 
         * @param int Width of image
         * @param int Height of image
         * @return bool Result 
         */
        
        function getImage($width = 0, $height = 0){
        
        # Automatic test to tell computers and humans apart

        # Copyright by Kruglov Sergei, 2006
        # www.captcha.ru, www.kruglov.ru

        # System requirements: PHP 4.0.6+ w/ GD

        # KCAPTCHA is a free software. You can freely use it for building own site or software.
        # If you use this software as a part of own sofware, you must leave copyright notices intact or add KCAPTCHA copyright notices to own.
        
            $width = ($width == 0) ? $this->fWidth : (int) $width;
            $height = ($height == 0) ? $this->fHeight : (int) $height;	
            $foreground_color = array(mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
            $background_color = array(mt_rand(200,255), mt_rand(200,255), mt_rand(200,255));
                if($font = $this->getFont()){
                    if($font_metrics = $this->loadFont($font)){
                         while(true){
                            $fontfile_height = imagesy($font)-1;
                            
                            $img=imagecreatetruecolor($width, $height);
                            imagealphablending($img, true);
                            $white=imagecolorallocate($img, 255, 255, 255);
                            $black=imagecolorallocate($img, 0, 0, 0);
                
                            imagefilledrectangle($img, 0, 0, $width-1, $height-1, $white);
                
                            // draw text
                            $x=1;
                            for($i=0; $i<strlen($this->fSecretKey); $i++){
                                $m=$font_metrics[$this->fSecretKey{$i}];
                
                                $y=mt_rand(-$this->fluctuation_amplitude, $this->fluctuation_amplitude)+($height-$fontfile_height)/2+2;
                
                                if($this->no_spaces){
                                    $shift=0;
                                    if($i>0){
                                        $shift=1000;
                                        for($sy=7;$sy<$fontfile_height-20;$sy+=1){
                                            //for($sx=$m['start']-1;$sx<$m['end'];$sx+=1){
                                            for($sx=$m['start']-1;$sx<$m['end'];$sx+=1){
                                                $rgb=imagecolorat($font, $sx, $sy);
                                                $opacity=$rgb>>24;
                                                if($opacity<127){
                                                    $left=$sx-$m['start']+$x;
                                                    $py=$sy+$y;
                                                    if($py>$height) break;
                                                    for($px=min($left,$width-1);$px>$left-12 && $px>=0;$px-=1){
                                                        $color=imagecolorat($img, $px, $py) & 0xff;
                                                        if($color+$opacity<190){
                                                            if($shift>$left-$px){
                                                                $shift=$left-$px;
                                                            }
                                                            break;
                                                        }
                                                    }
                                                    break;
                                                }
                                            }
                                        }
                                        if($shift==1000){
                                            $shift=mt_rand(4,6);
                                        }
                
                                    }
                                }else{
                                    $shift=1;
                                }
                                imagecopy($img,$font,$x-$shift,$y,$m['start'],1,$m['end']-$m['start'],$fontfile_height);
                                $x+=$m['end']-$m['start']-$shift;
                            }
                            if($x<$width-10) break; // fit in canvas
                            
                        }
                        $center=$x/2;
                
                        // image itself
                        $img2=imagecreatetruecolor($width, $height);

                        // periods
                        $rand1=mt_rand(750000,1200000)/10000000;
                        $rand2=mt_rand(750000,1200000)/10000000;
                        $rand3=mt_rand(750000,1200000)/10000000;
                        $rand4=mt_rand(750000,1200000)/10000000;
                        // phases
                        $rand5=mt_rand(0,3141592)/500000;
                        $rand6=mt_rand(0,3141592)/500000;
                        $rand7=mt_rand(0,3141592)/500000;
                        $rand8=mt_rand(0,3141592)/500000;
                        // amplitudes
                        $rand9=mt_rand(330,420)/110;
                        $rand10=mt_rand(330,450)/110;
                
                        //wave distortion
                        for($x=0;$x<$width;$x++){
                            for($y=0;$y<$height;$y++){
                                $sx=$x+(sin($x*$rand1+$rand5)+sin($y*$rand3+$rand6))*$rand9-$width/2+$center+1;
                                $sy=$y+(sin($x*$rand2+$rand7)+sin($y*$rand4+$rand8))*$rand10;
                
                                if($sx<0 || $sy<0 || $sx>=$width-1 || $sy>=$height-1){
                                    $color=255;
                                    $color_x=255;
                                    $color_y=255;
                                    $color_xy=255;
                                }else{
                                    $color=imagecolorat($img, $sx, $sy) & 0xFF;
                                    $color_x=imagecolorat($img, $sx+1, $sy) & 0xFF;
                                    $color_y=imagecolorat($img, $sx, $sy+1) & 0xFF;
                                    $color_xy=imagecolorat($img, $sx+1, $sy+1) & 0xFF;
                                }
                
                                if($color==0 && $color_x==0 && $color_y==0 && $color_xy==0){
                                    $newred=$foreground_color[0];
                                    $newgreen=$foreground_color[1];
                                    $newblue=$foreground_color[2];
                                }else if($color==255 && $color_x==255 && $color_y==255 && $color_xy==255){
                                    $newred=$background_color[0];
                                    $newgreen=$background_color[1];
                                    $newblue=$background_color[2];  
                                }else{
                                    $frsx=$sx-floor($sx);
                                    $frsy=$sy-floor($sy);
                                    $frsx1=1-$frsx;
                                    $frsy1=1-$frsy;
                
                                    $newcolor=(
                                        $color*$frsx1*$frsy1+
                                        $color_x*$frsx*$frsy1+
                                        $color_y*$frsx1*$frsy+
                                        $color_xy*$frsx*$frsy);
                
                                    if($newcolor>255) $newcolor=255;
                                    $newcolor=$newcolor/255;
                                    $newcolor0=1-$newcolor;
                
                                    $newred=$newcolor0*$foreground_color[0]+$newcolor*$background_color[0];
                                    $newgreen=$newcolor0*$foreground_color[1]+$newcolor*$background_color[1];
                                    $newblue=$newcolor0*$foreground_color[2]+$newcolor*$background_color[2];
                                }
                
                                imagesetpixel($img2, $x, $y, imagecolorallocate($img2, $newred, $newgreen, $newblue));
                            }
                        }
                
                        if(function_exists("imagejpeg")){
                            header("Content-Type: image/jpeg");
                            imagejpeg($img2, null, $this->jpeg_quality);
                            return true;
                        }else if(function_exists("imagegif")){
                            header("Content-Type: image/gif");
                            imagegif($img2);
                            return true;
                        }else if(function_exists("imagepng")){
                            header("Content-Type: image/x-png");
                            imagepng($img2);
                            return true;
                        }
                    }else{
                    	  return false;
                    }
                }else{
                    return false;
                }
        }
    
}
?>
<?php

class Image extends File {
	
	/**
	 * image height
	 */	
	var $fImageHeight;
	
	/**
	 * image width
	 */	
	var $fImageWidth;
	
	/**
	 * constructor
	 */	
	function Image() {
		parent::File();
	}	

	/**
	 * function initialize image file by link
	 *  
	 * @param 	string 	$fileLink     full path to file (ex.'/var/www/test.png')
	 * @param 	string 	$fileUserName user file name
	 * @param 	string 	$fileTitle    file title
	 * @param 	string 	$fileMime     file mime type
	 * 
	 * @return	bool				  is file set 
	 * 
	 */	
	function initialize($fileLink, $fileUserName = null, 
			$fileTitle = null, $fileMime = null) {
		if (parent::initialize($fileLink, 
				$fileUserName, $fileTitle, $fileMime)) {
			$this->refreshImageSize();
			return true;			
		} else {
			return false;
		}
	}
	
	/**
	 * return image height
	 * 
	 * @return int image height
	 */
	function getImageHeight() {
		return $this->fImageHeight;
	}

	/**
	 * return image width
	 * 
	 * @return int image width
	 */
	function getImageWidth() {
		return $this->fImageWidth;
	}
	
	/**
	 * refresh image size
	 *
	 * @return result of image size refreshing
	 */
	function refreshImageSize() {
		
        switch($this->fFileMimeType) {

        	case 'image/pjpeg':
          	case 'image/jpeg':
          	case 'image/jpg':
          	
	            if (!function_exists('imagecreatefromjpeg')) {
	                $this->farrErrors[] = "No create from JPEG support";
	                return false;
	            } else {
	            	$srcImage = @imagecreatefromjpeg(
	            		$this->fFilePath.$this->fFileName.'.'.$this->fFileExtension);
	                if (!$srcImage) {
	                    $this->farrErrors[] = "No JPEG read support";
	                    return false;
	                }
	            }
	            break;

            case 'image/png':
            	
	            if (!function_exists('imagecreatefrompng')) {
	                $this->farrErrors[] = "No create from PNG support";
	                return false;
	            } else {
	                $srcImage = @imagecreatefrompng(
	                	$this->fFilePath.$this->fFileName.'.'.$this->fFileExtension);
	                if (!$srcImage) {
	                    $this->farrErrors[] = "No PNG read support";
	                    return false;
	                }
	            }
	            break;

            case 'image/gif':
	            if (!function_exists('imagecreatefromgif')) {
	                $this->farrErrors[] = "No create from GIF support";
	                return false;
	            } else {
	                $srcImage = @imagecreatefromgif(
	                	$this->fFilePath.$this->fFileName.'.'.$this->fFileExtension);
	                if (!$srcImage) {
	                    $this->farrErrors[] = "No GIF read support";
	                    return false;
	                }
	            }
	            break;

            default:
	          	$this->farrErrors[] = "Can't read image source.";
	          	return false;
    	}
      
	    $this->fImageWidth = imagesx($srcImage);
	    $this->fImageHeight = imagesy($srcImage);		
		return true;
		
	}
}

?>
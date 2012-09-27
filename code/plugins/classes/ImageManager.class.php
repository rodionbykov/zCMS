<?php

class ImageManager extends FileManager {

  /**
   * constructor
   */
  function ImageFileManager() {
    parent::FileManager();
    parent::setAllowedMimeTypes(array("image/gif","image/jpeg","image/pjpeg"
      ,"image/jpg","image/png"));
  }

  /**
   * function copy file to $destination path
   * 		(ex: copyFile('/home/bum/downloads/'))
   *
   * @param string $destination destination file path
   *
   * @return bool file copy result
   */
  function copyFile($oImage, $destination) {
    if (empty($oImage)) {
      $this->farrErrors[] = "Image not set";
      return false;
    }

    if (empty($destination)) {
      $this->farrErrors[] = "Image destination path not set";
      return false;
    }

    if ($destination[strlen($destination) - 1] != "/" &&
        $destination[strlen($destination) - 1] != "\\") {
      $destination .= "/";
    }

    $arrProperty = $oImage->getFileProperty();
    if (@copy($oImage->getFilePath().$oImage->getFileName(),
        $destination.$oImage->getFileName())) {

      $arrProperty['filePath'] =
        $destination.$oImage->getFileName();

      $oNewImage = new Image();

      $oNewImage->initializeByPropertyArray($arrProperty);

      return $oNewImage;
    } else {
      $this->farrErrors[] = "Image copy error";
      return false;
    }
  }

  /**
   * function upload file to server
   *
   * @param string $uploadFile 'file' field name at form
   * @param string $uploadDir  dir where upload file
   *
   * @return File file object uploaded on server
   */
  function uploadFile($uploadFile, $uploadDir, $fileName = null) {
    if (empty($uploadDir)) {
      $this->farrErrors[] = "File upload dir not set";
      return false;
    }

    if (array_key_exists($uploadFile, $_FILES) &&
        !is_array($_FILES[$uploadFile])) {
      $this->farrErrors[] = "File upload error. Please try again";
      return false;
    }

    if (!@file_exists($_FILES[$uploadFile]['tmp_name'])) {
      $this->farrErrors[] = "File upload error. Please try again";
      return false;
    }

    if ($uploadDir[strlen($uploadDir) - 1] != "/" ||
        $uploadDir[strlen($uploadDir) - 1] != "\\") {
      $uploadDir .= "/";
    }

    if (!empty($fileName)) {
      $destFilePath = $uploadDir.$fileName;
    } else {
      $destFilePath = $uploadDir.basename($_FILES[$uploadFile]['name']);
    }

    $counter = 1;
    $path = pathinfo($destFilePath);
    $dir = $path['dirname']."/";
    $extension = '.'.$path['extension'];
    $name = basename($destFilePath, $extension);
    $mimeType = $_FILES[$uploadFile]['type'];

    /** not working on any random machine
        if (function_exists('mime_content_type')) {
            $mimeType = mime_content_type($_FILES[$uploadFile]['tmp_name']);
        }
        */

        if (!empty($this->farrAllowedMimeTypes) && !array_key_exists($mimeType,
              array_flip($this->farrAllowedMimeTypes))) {
      $this->farrErrors[] = "File type not allowed";
      return false;
        }

        while (@file_exists($destFilePath)) {
      $destFilePath = $dir.$name.'_'.$counter.$extension;
            $counter++;
        }

    if (@move_uploaded_file($_FILES[$uploadFile]['tmp_name'],
        $destFilePath)) {
      $oImage = new Image();
      if ($oImage->initialize($destFilePath,
          $name.$extension, $name, $mimeType)) {
        return $oImage;
      } else {
        $farrErrors[] = 'Image upload error';
        return false;
      }

    } else {
      $farrErrors[] = 'Image upload error';
      return false;
    }

  }

  /**
   * resize image
   *
   * @param Image image object
   * @param int $width image width
   * @param int $height image height
   * @param bool $enlarge enlarge image, if it is smaller then you need,
   * 						default false
   * @param bool $saveRatio save image ratio, default true
   *
   * @return bool image resize result
   */
  function resizeImage(&$oImage, $width, $height, $enlarge = false,
      $saveRatio = true) {

    $filePath = $oImage->getFilePath().$oImage->getFileName();
    $mimeType = $oImage->getFileMimeType();

    $width = intval($width);
    $height = intval($height);


        switch($mimeType) {

            case 'image/pjpeg':
            case 'image/jpeg':
            case 'image/jpg':

                if (!function_exists('imagecreatefromjpeg')) {
                    $this->farrErrors[] = "No create from JPEG support";
                    return false;
                } else {
                    $srcImage = @imagecreatefromjpeg($filePath);
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
                $srcImage = @imagecreatefrompng($filePath);
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
                $srcImage = @imagecreatefromgif($filePath);
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

        $srcWidth = imagesx($srcImage);
        $srcHeight = imagesy($srcImage);

         $gd_version = $this->gd_version();

         if ($enlarge || $srcHeight > $height || $srcWidth > $width) {
           if ($saveRatio) {
            if ($srcWidth > $srcHeight) {
              $height = round(($width / $srcWidth) * $srcHeight);
            } else {
              $width = round(($height / $srcHeight) * $srcWidth);
            }
           }
        } else {
          return true;
        }

      if ($gd_version >= 2) {
            $dstImage = @imagecreatetruecolor($width, $height);
          $result = @imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0,
            $width, $height, $srcWidth, $srcHeight);
        } else {
          $dstImage = @imagecreate($width, $height);
            $result = @imagecopyresized($dstImage, $srcImage, 0, 0, 0, 0,
              $width, $height, $srcWidth, $srcHeight);
        }

        if (!$result) {
            if (is_resource($srcImage)) {
              imagedestroy($srcImage);
            }
          if (is_resource($dstImage)) {
            imagedestroy($dstImage);
          }
          $this->farrErrors[] = "Can't resize image.";
             return false;
        }

        switch($mimeType) {

            case 'image/pjpeg':
            case 'image/jpeg':
            case 'image/jpg':
        if (!@imagejpeg ($dstImage, $filePath, 75)) {
              $this->farrErrors[] = "Can't save jpg image .";
              return false;
        }
                break;

            case 'image/png':
        if (!@imagepng ($dstImage, $filePath)) {
              $this->farrErrors[] = "Can't save png image .";
              return false;
        }
                break;

            case 'image/gif':
        if (!@imagegif ($dstImage, $filePath)) {
              $this->farrErrors[] = "Can't save gif image .";
              return false;
        }
                break;

            default:
              $this->farrErrors[] = "Can't write image .";
              return false;
        }


        if (is_resource($srcImage)) {
          imagedestroy($srcImage);
        }
        if (is_resource($dstImage)) {
          imagedestroy($dstImage);
        }

        $oImage->refreshImageSize();

    return true;
  }

  /**
   * cut image part
   *
   * @param Image image object
   * @param int $width image width
   * @param int $height image height
   * @param int $x
   * @param int $y
   *
   * @return bool image cut result
   */
  function cropImage(&$oImage, $width, $height, $x = 0, $y = 0) {

    $filePath = $oImage->getFilePath().$oImage->getFileName();
    $mimeType = $oImage->getFileMimeType();

    $width = intval($width);
    $height = intval($height);
    $x = intval($x);
    $y = intval($y);

        switch($mimeType) {

            case 'image/pjpeg':
            case 'image/jpeg':
            case 'image/jpg':

                if (!function_exists('imagecreatefromjpeg')) {
                    $this->farrErrors[] = "No create from JPEG support";
                    return false;
                } else {
                    $srcImage = @imagecreatefromjpeg($filePath);
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
                $srcImage = @imagecreatefrompng($filePath);
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
                $srcImage = @imagecreatefromgif($filePath);
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

        $srcWidth = imagesx($srcImage);
        $srcHeight = imagesy($srcImage);
        $gd_version = $this->gd_version();

        if (($srcWidth <= $width && $srcHeight <= $height && $x == 0 && $y == 0)
            || $srcWidth <= $x || $srcHeight <= $y) {
          return true;
        }

        if ($srcWidth < $width + $x) {
          $width = $srcWidth - $x;
        }

        if ($srcHeight < $height + $y) {
          $height = $srcHeight - $y;
        }

    if ($gd_version >= 2) {
            $dstImage = @imagecreatetruecolor($width, $height);
        } else {
          $dstImage = @imagecreate($width, $height);
        }

        $result =
          @imagecopy($dstImage, $srcImage, 0, 0, $x, $y, $width, $height);

        if (!$result) {
            if (is_resource($srcImage)) {
              imagedestroy($srcImage);
            }
          if (is_resource($dstImage)) {
            imagedestroy($dstImage);
          }
          $this->farrErrors[] = "Can't cut image part image.";
             return false;
        }

        switch($mimeType) {

            case 'image/pjpeg':
            case 'image/jpeg':
            case 'image/jpg':
        if (!@imagejpeg ($dstImage, $filePath, 75)) {
              $this->farrErrors[] = "Can't save jpg image .";
              return false;
        }
                break;

            case 'image/png':
        if (!@imagepng ($dstImage, $filePath)) {
              $this->farrErrors[] = "Can't save png image .";
              return false;
        }
                break;

            case 'image/gif':
        if (!@imagegif ($dstImage, $filePath)) {
              $this->farrErrors[] = "Can't save gif image .";
              return false;
        }
                break;

            default:
              $this->farrErrors[] = "Can't write image .";
              return false;
        }


        if (is_resource($srcImage)) {
          imagedestroy($srcImage);
        }
        if (is_resource($dstImage)) {
          imagedestroy($dstImage);
        }

        $oImage->refreshImageSize();

    return true;

  }

  /**
   * function return gd version
   *
   * @return float gd version
   */
    function gd_version() {
        static $gd_version_number = null;
        if ($gd_version_number === null) {
            ob_start();
            phpinfo(8);
            $module_info = ob_get_contents();
            ob_end_clean();
            if (preg_match("/\bgd\s+version\b[^\d\n\r]+?([\d\.]+)/i",
                   $module_info,$matches)) {
                $gd_version_number = $matches[1];
            } else {
                $gd_version_number = 0;
            }
        }
        return $gd_version_number;
    }
}

?>
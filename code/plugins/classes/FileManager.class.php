<?php
class FileManager {

  /**
   * array of allowed file types to upload
   */
  var $farrAllowedMimeTypes;

  /**
   * array of errors
   */
  var $farrErrors;

  /**
   * constructor
   */
  function FileManager() {
    $this->farrErrors = array();
    $this->farrAllowedMimeTypes = array();
    return true;
  }

  /**
   * function set allowed mime types for file upload
   * 		(ex. setAllowedMimeTypes(array("image/gif","image/jpeg"))
   *
   * @param array $arrMimeTypes array of allowed mime types
   */
  function setAllowedMimeTypes($arrMimeTypes) {
    $this->farrAllowedMimeTypes = $arrMimeTypes;
  }

  /**
   * function unset all allowed mime types for file upload,
   * 		user can upload any files
   */
  function unsetAllowedMimeTypes() {
    $this->farrAllowedMimeTypes = array();
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
      $oFile = new File();
      if ($oFile->initialize($destFilePath,
          $name.$extension, $name, $mimeType)) {
        return $oFile;
      } else {
        $farrErrors[] = "File upload error";
        return false;
      }

    } else {
      $farrErrors[] = 'File upload error';
      return false;
    }

  }

  /**
   * function return set file to user
   *
   * @param File $oFile file object
   *
   * @param bool $dispositionInline if true then diposition is 'inline' else
   * 									disposition is 'attachment', default -
   * 									true (disposition 'inline')
   * @return bool is file sent
   */
  function downloadFile($oFile, $dispositionInline = false) {
    if (empty($oFile)) {
      $this->farrErrors[] = "File not set";
      return false;
    }

    if (!$oFile->getFileMimeType()) {
      $this->farrErrors[] = "File mime type not set";
      return false;
    }

    $disposition = $dispositionInline ?
        $disposition = 'inline' : $disposition = 'attachment';

    header('Content-type: '.$oFile->getFileMimeType());
    header('Content-Disposition: '.$disposition.'; filename="'.
        $oFile->getFileUserName().'"');
    header('Content-Length: '.$oFile->getFileSize());
    readfile($oFile->getFilePath().$oFile->getFileName());
    return true;
  }

  /**
   * function move file to $destination path
   * 		(ex: moveFile('/home/bum/downloads/'))
   *
   * @param string $destination destination file path
   *
   * @return bool file move result
   */
  function moveFile(&$oFile, $destination) {
    if (empty($oFile)) {
      $this->farrErrors[] = "File not set";
      return false;
    }

    if (empty($destination)) {
      $this->farrErrors[] = "File destination path not set";
      return false;
    }

    if ($oFile->setFilePath($destination)) {
      return true;
    } else {
      $this->farrErrors[] = "File move error";
      return false;
    }
  }

  /**
   * function rename file (ex: renameFile('valik')
   * 			-> '/var/www/valik.php')
   *
   * @param string $fileName new file name without extension
   *
   * @return bool file rename result
   */
  function renameFile(&$oFile, $fileName) {
    if (empty($oFile)) {
      $this->farrErrors[] = "File not set";
      return false;
    }

    if (empty($fileName)) {
      $this->farrErrors[] = "File name not set";
      return false;
    }

    if ($oFile->setFileName($fileName)) {
      return true;
    } else {
      $this->farrErrors[] = "File rename error";
      return false;
    }
  }

  /**
   * function copy file to $destination path
   * 		(ex: copyFile('/home/bum/downloads/'))
   *
   * @param string $destination destination file path
   *
   * @return bool file copy result
   */
  function copyFile($oFile, $destination) {
    if (empty($oFile)) {
      $this->farrErrors[] = "File not set";
      return false;
    }

    if (empty($destination)) {
      $this->farrErrors[] = "File destination path not set";
      return false;
    }

    if ($destination[strlen($destination) - 1] != "/" &&
        $destination[strlen($destination) - 1] != "\\") {
      $destination .= "/";
    }

    $arrProperty = $oFile->getFileProperty();
    if (@copy($oFile->getFilePath().$oFile->getFileName(),
        $destination.$oFile->getFileName())) {

      $arrProperty['filePath'] =
        $destination.$oFile->getFileName();

      $oNewFile = new File();

      $oNewFile->initializeByPropertyArray($arrProperty);

      return $oNewFile;
    } else {
      $this->farrErrors[] = "File copy error";
      return false;
    }
  }

  /**
   * function set file extension
   * 		(ex: setFileExtension('tpl') -> '/var/www/test.tpl')
   *
   * @param string $fileExtension new file extension
   */
  function setFileExtension(&$oFile, $fileExtension) {
    if (empty($oFile)) {
      $this->farrErrors[] = "File not set";
      return false;
    }

    if (empty($fileExtension)) {
      $this->farrErrors[] = "File extension not set";
      return false;
    }

    if ($oFile->setFileExtension($fileExtension)) {
      return true;
    } else {
      $this->farrErrors[] = "File rename error";
      return false;
    }
  }

  /**
   * function delete file from system
   *
   * @return bool file delete result
   */
  function deleteFile(&$oFile) {
    if (empty($oFile)) {
      $this->farrErrors[] = "File not set";
      return false;
    }

    if (@unlink($oFile->getFilePath().$oFile->getFileName())) {
      $oFile = null;
      return true;
    } else {
      $this->farrErrors[] = "File delete error";
      return false;
    }

  }

  /**
   * function change mode for file
   *
   * @return bool is file mode changed
   */
  function chmod($oFile) {
    $result = chmod($oFile->getFilePath().$oFile->getFileName(), $mode);
    if (!$result) {
       $this->farrErrors[] = "File chmod error";
    }
    return $result;
  }

  /**
   * function return last error
   *
   * @return string last error
   */
  function getLastError() {
    return end($this->farrErrors);
  }

  /**
   * function return all errors in array
   *
   * @return array of errors
   */
  function getErrorDump() {
    return $this->farrErrors;
  }

}

?>
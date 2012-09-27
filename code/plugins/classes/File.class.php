<?php
class File {

  /**
   *	file name (ex. "test.php")
   */
  var $fFileName;

  /**
   * user file name (ex. "TestFile.php")
   */
  var $fFileUserName;

  /**
   * file title (ex. "Test File")
   */
  var $fFileTitle;

  /**
   * file extension (ex. "php")
   */
  var $fFileExtension;

  /**
   * file path (ex. "/var/www/test.php")
   */
  var $fFilePath;

  /**
   * file mime type
   */
  var $fFileMimeType;

  /**
   * array of errors
   */
  var $farrErrors;

  /**
   * constructor
   */
  function File() {
    return true;
  }

  /**
   * function initialize file by link
   *
   * @param 	string 	$fileLink     full path to file (ex.'/var/www/test.php')
   * @param 	string 	$fileUserName user file name
   * @param 	string 	$fileTitle    file title
   * @param 	string 	$fileMime     file mime type
   *
   * @return	bool				  is file set
   *
   */
  function initialize($fileLink, $fileUserName = null,
      $fileTitle = null, $fileMime = null) {

    if (file_exists($fileLink)) {

      $path = pathinfo($fileLink);

      $this->fFilePath = $path['dirname']."/";
      $this->fFileExtension = $path['extension'];
      $this->fFileName = basename($fileLink, '.'.$path['extension']);

      if (!empty($fileMime)) {
        $this->fFileMimeType = $fileMime;
      }
      /** not working on any random machine
      elseif (function_exists('mime_content_type')) {
              $mimeType = mime_content_type($fileLink);
          }
          */

      if (!empty($fileUserName)) {
        $this->fFileUserName = $fileUserName;
      } else {
        $this->fFileUserName = basename($fileLink);
      }

      if (!empty($fileTitle)) {
        $this->fFileTitle = $fileTitle;
      }
      return true;
    } else {
      return false;
    }
  }

  /**
   * function initialize file by property array,
   * 	eq initialize, but use property array
   *
   * @param	array  $arrFileProperty  array of file property
   *
   * @return  bool is file set
   */
  function initializeByPropertyArray($arrFileProperty) {
    return $this->initialize($arrFileProperty['filePath'],
        $arrFileProperty['fileUserName'], $arrFileProperty['fileTitle'],
        $arrFileProperty['fileMimeType']);
  }

  /**
   * Set file name
   *
   * @param string $fileName new file name without extension
   * @return bool file rename result
   */
  function setFileName($fileName) {
    if (@rename($this->fFilePath.$this->fFileName.'.'.$this->fFileExtension,
        $this->fFilePath.$fileName.'.'.$this->fFileExtension)) {
      $this->fFileName = $fileName;
      return true;
    } else {
      $this->farrErrors[] = "File rename error";
      return false;
    }
  }

  /**
   * Set file path
   *
   * @param string $fileDir new path to file
   * @return bool file move result
   */
  function setFilePath($fileDir) {
    if ($fileDir[strlen($fileDir) - 1] != "/" &&
        $fileDir[strlen($fileDir) - 1] != "\\") {
      $fileDir .= "/";
    }

    if (@rename($this->fFilePath.$this->fFileName.'.'.$this->fFileExtension,
        $fileDir.$this->fFileName.'.'.$this->fFileExtension)) {
      $this->fFilePath = $fileDir;
      return true;
    } else {
      $this->farrErrors[] = "File rename error";
      return false;
    }
  }

  /**
   * Set file extension
   *
   * @param string $fileExtension set file extension
   * @return bool file rename result
   */
  function setFileExtension($fileExtension) {
    if (@rename($this->fFilePath.$this->fFileName.'.'.$this->fFileExtension,
        $this->fFilePath.$this->fFileName.'.'.$fileExtension)) {
      $this->fFileExtension = $fileExtension;
      return true;
    } else {
      $this->farrErrors[] = "File rename error";
      return false;
    }
  }

  /**
   * function set file title
   *
   * @param	string	$fileTitle	  set file title
   *
   */
  function setFileTitle($fileTitle) {
    $this->fFileTitle = $fileTitle;
    return true;
  }

  /**
   * function set user file name without extension
   *
   * @param	string	$fileUserName user file name without extension
   */
  function setFileUserName($fileUserName) {
    $this->fFileUserName = $fileUserName;
    return true;
  }

  /**
   * function set file mime type
   *
   * @param	string	$mimeType 	file mime type
   */
  function setFileMimeType($mimeType) {
    $this->fFileMimeType = $mimeType;
    return true;
  }

  /**
   * function return file name with extension (ex. "test.php")
   *
   * @return  string  file name with extension
   */
  function getFileName() {
    return $this->fFileName.'.'.$this->fFileExtension;
  }

  /**
   * function return file name without extension (ex. "test")
   *
   * @return  string  file name without extension
   */
  function getFileNameWithoutExtension() {
    return $this->fFileName;
  }

  /**
   * function return user file name
   *
   * @return  string  user file name
   */
  function getFileUserName() {
    return $this->fFileUserName;
  }

  /**
   * function return file title
   *
   * @return  string  file title
   */
  function getFileTitle() {
    return $this->fFileTitle;
  }

  /**
   * return file extension without dot (ex. "php")
   *
   * @return  string  file extension
   */
  function getFileExtension() {
    return $this->fFileExtension;
  }

  /**
   * return file path (ex. "/var/www/")
   *
   * @return  string  full path to file
   */
  function getFilePath() {
    return $this->fFilePath;
  }

  /**
   * return file mime type
   *
   * @return  string  file mime type
   */
  function getFileMimeType() {
    return $this->fFileMimeType;
  }

  /**
   * return file size
   *
   * @return  string  file size
   */
  function getFileSize() {
    return filesize($this->fFilePath.$this->fFileName.'.'.$this->fFileExtension);
  }

  /**
   * return file property
   *
   * @return  array  array of file properties
   */
  function getFileProperty() {
    $arrFileProperty = array();
    $arrFileProperty['filePath'] = $this->fFilePath;
    $arrFileProperty['fileUserName'] = $this->fFileUserName;
    $arrFileProperty['fileMimeType'] = $this->fFileMimeType;
    $arrFileProperty['fileTitle'] = $this->fFileTitle;
    return $arrFileProperty;
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
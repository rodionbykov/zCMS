<?php

class GalleryManager {

    /** Database abstraction  */
     var $fDB;

    /** Gallery Content Manager */
     var $fGalleryManager;

    /** GalleryImages Content Manager */
     var $fImageManager;

    /** Fuseaction object (fake), needed for managers */
     var $fFuseaction;

    /** Language object */
     var $fLanguage;

    /** Name of Gallery table */
     var $fGalleryTokensTable;

    /** Name of Gallery names and descriptions table */
     var $fGalleryContentTable;

    /** Name of Gallery Images table */
     var $fImagesTokensTable;

    /** Name of Gallery Images names and descruptions table */
     var $fImagesContentTable;
     
    /** Name of Gallery Comments table */
     var $fGalleryCommentsTable;

    /** Name of Gallery Images comments table */
     var $fImagesCommentsTable;    

  /** Default author ID */
  var $fAuthorID = 0;

  /** Default editor ID */
  var $fEditorID = 0;

  /** db date format */
  var $fDateFormatDB = "%m/%d/%Y %h:%i %p";

     function GalleryManager(&$db, &$oLanguage, $gallerytokenstable, $gallerycontenttable, $imagestokentable, $imagescontenttable, $gallerycommentstable, $imagescommentstable) {
        $this->fDB = $db;
        $this->fFuseaction = new Fuseaction(0, "");
        $this->fLanguage = $oLanguage;
        $this->fGalleryTokensTable = (string) $gallerytokenstable;
        $this->fGalleryContentTable = (string) $gallerycontenttable;
        $this->fImagesTokensTable = (string) $imagestokentable;
        $this->fImagesContentTable = (string) $imagescontenttable;
        $this->fGalleryCommentsTable = (string) $gallerycommentstable;
        $this->fImagesCommentsTable = (string) $imagescommentstable;
     }

    /** Initializing manager, checking for valid data
     *
     */
     function initialize(){
       if(is_a($this->fDB, "DB") && is_a($this->fLanguage, "Language")){
         $this->fGalleryManager = new ContentManager($this->fDB, $this->fFuseaction, $this->fLanguage, $this->fGalleryTokensTable, $this->fGalleryContentTable, $this->fGalleryCommentsTable, false);
            $this->fImageManager = new ContentManager($this->fDB, $this->fFuseaction, $this->fLanguage, $this->fImagesTokensTable, $this->fImagesContentTable, $this->fImagesCommentsTable, false);

            $this->fGalleryManager->fAuthorID = $this->fAuthorID;
            $this->fGalleryManager->fEditorID = $this->fEditorID;
            $this->fGalleryManager->fDateFormatDB = $this->fDateFormatDB;
            $this->fImageManager->fAuthorID = $this->fAuthorID;
            $this->fImageManager->fEditorID = $this->fEditorID;
            $this->fImageManager->fDateFormatDB = $this->fDateFormatDB;

            if($this->fGalleryManager->initialize() && $this->fImageManager->initialize()){
              return true;
            }else{
              return false;
            }
       }else{
         return false;
       }
     }

    /** Getting all galleries
     *
     *  @array Galleries
     */
     function getGalleries($order = "token", $sort = "ASC", $start = 0, $count = 0){
        return $this->fGalleryManager->pullTokens($this->fFuseaction->getID(), "", $order, $sort, $start, $count);
     }

    /** Getting all galleries count
     *
     *  @integer Galleries count
     */
     function getGalleriesCount() {
       return $this->fGalleryManager->getTokensCount($this->fFuseaction->getID());
     }

    /** Add gallery
     *
     */
     function addGallery($gallery, $description){
        if(!$this->fGalleryManager->checkToken($this->fFuseaction->getID(), $gallery, $description, false)){
            return $this->fGalleryManager->checkToken($this->fFuseaction->getID(), $gallery, $description, true);
        }else{
          return false;
        }
     }

    /** Delete gallery and all its photos
     *
     */
     function deleteGallery($gallery){
        $id = 0;
        if($id = $this->checkGallery($gallery)){
            return $this->fImageManager->deleteFuseactionTokens($id) && $this->fGalleryManager->deleteToken($this->fFuseaction->getID(), $gallery);
        }else{
            return false;
        }
     }

    /** Getting all images in gallery
     *
     */
     function getImages($gallery, $start = 0, $count = 0){
       $id = 0;
        if($id = $this->checkGallery($gallery)){
            return $this->getImagesByID($id, $start, $count);
        }else{
            return false;
        }
     }

    /**
     * Getting image count in gallery
     *
     * @param string $gallery
     * @return integer pictures count in gallery
     */
     function getImagesCount($gallery) {
        if($id = $this->checkGallery($gallery)){
            return$this->fImageManager->getTokensCount($id);
        }else{
            return false;
        }
     }

    /** Getting all images in gallery by gallery ID
     *
     */
     function getImagesByID($galleryid, $start = 0, $count = 0){
        return $this->fImageManager->pullTokens($galleryid, "", "token", "ASC", $start, $count);
     }

   /** Checking gallery for existence and return it's ID
    *
    */
     function checkGallery($gallery){
        return $this->fGalleryManager->checkToken($this->fFuseaction->getID(), $gallery, "", false);
     }

   /** Getting gallery description
    *
    */
     function getGalleryDescription($gallery){
       return $this->fGalleryManager->getDescription($gallery);
     }

   /** Getting gallery description
    *
    */
     function getGalleryTitle($gallery, $languageid = 0){
        $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
        return $this->fGalleryManager->pullTitle($this->fFuseaction->getID(), $languageid, $gallery);
     }

   /** Getting gallery description
    *
    */
     function getGalleryContent($gallery, $languageid = 0){
        $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
        return $this->fGalleryManager->pullContent($this->fFuseaction->getID(), $languageid, $gallery);
     }

   /** Getting gallery description encoded
    *
    */
     function getGalleryTitleEncoded($gallery, $encoding = "iso-8859-1", $languageid = 0){
        $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
        return $this->fGalleryManager->pullTitleEncoded($this->fFuseaction->getID(), $languageid, $gallery, $encoding);
     }

   /** Getting gallery description encoded
    *
    */
     function getGalleryContentEncoded($gallery, $encoding = "iso-8859-1", $languageid = 0){
        $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
        return $this->fGalleryManager->pullContentEncoded($this->fFuseaction->getID(), $languageid, $gallery, $encoding);
     }

   /** Getting gallery created date */
     function getGalleryCreatedDate($gallery, $format = ''){
       return $this->fGalleryManager->pullCreatedDate($this->fFuseaction->getID(), $gallery, $format);
     }

   /** Getting gallery updated date */
     function getGalleryUpdatedDate($gallery, $languageid = 0, $format = ''){
        $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
        return $this->fGalleryManager->pullUpdatedDate($this->fFuseaction->getID(), $languageid, $gallery, $format);
     }

   /** Getting gallery recent update */
     function getGalleryRecentUpdate($gallery, $languageid = 0){
       $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
        return $this->fGalleryManager->pullRecentUpdate($this->fFuseaction->getID(), $languageid, $gallery);
     }

   /** Getting gallery author ID */
     function getGalleryAuthorID($gallery){
        return $this->fGalleryManager->pullAuthorID($this->fFuseaction->getID(), $gallery);
     }

   /** Getting gallery editor ID */
     function getGalleryEditorID($gallery, $languageid = 0){
        $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
        return $this->fGalleryManager->pullEditorID($this->fFuseaction->getID(), $languageid, $gallery);
     }

   /** Setting gallery content
    *
    */
     function setGalleryContent($gallery, $content, $languageid = 0){
        $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
       return $this->fGalleryManager->pushContent($this->fFuseaction->getID(), $languageid, $gallery, $content);
     }

   /** Setting gallery title
    *
    */
     function setGalleryTitle($gallery, $title, $languageid = 0){
        $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
        return $this->fGalleryManager->pushTitle($this->fFuseaction->getID(), $languageid, $gallery, $title);
     }

   /** Setting gallery token */
     function setGalleryToken($gallery, $token){
       return $this->fGalleryManager->pushToken($this->fFuseaction->getID(), $gallery, $this->fFuseaction->getID(), $token);
     }

   /** Setting gallery description */
     function setGalleryDescription($gallery, $description){
        return $this->fGalleryManager->pushDescription($this->fFuseaction->getID(), $gallery, $description);
     }

   /** Set gallery created date */
     function setGalleryCreatedDate($gallery, $unixmoment = 0){
       return $this->fGalleryManager->pushCreatedDate($this->fFuseaction->getID(), $gallery, $unixmoment);
     }

   /** Set gallery updated date */
     function setGalleryUpdatedDate($gallery, $languageid = 0, $unixmoment = 0){
       $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
       return $this->fGalleryManager->pushUpdatedDate($this->fFuseaction->getID(), $languageid, $gallery, $unixmoment);
     }

   /** Set gallery author ID */
     function setGalleryAuthorID($gallery, $authorid = 0){
       return $this->fGalleryManager->pushAuthorID($this->fFuseaction->getID(), $gallery);
     }

   /** Set gallery editor ID */
     function setGalleryEditorID($gallery, $languageid = 0, $editorid = 0){
       $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
       return $this->fGalleryManager->pushEditorID($this->fFuseaction->getID(), $languageid, $gallery, $editorid);
     }

   /** Getting image filename */
     function getImageFileName($gallery, $image){
        if($id = $this->checkGallery($gallery)){
            return $this->fImageManager->pullDescription($id, $image);
        }else{
          return false;
        }
     }

   /** Getting image alternate text
    *
    */
     function getImageTitle($gallery, $image, $languageid = 0){
        $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
        if($id = $this->checkGallery($gallery)){
            return $this->fImageManager->pullTitle($id, $languageid, $image);
        }else{
          return false;
        }
     }

   /** Getting image alternate text encoded
    *
    */
     function getImageTitleEncoded($gallery, $image, $encoding = "iso-8859-1", $languageid = 0){
        $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
        if($id = $this->checkGallery($gallery)){
            return $this->fImageManager->pullTitleEncoded($id, $languageid, $image, $encoding);
        }else{
          return false;
        }
     }

   /** Getting image description
    *
    */
     function getImageContent($gallery, $image, $languageid = 0){
        $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
        if($id = $this->checkGallery($gallery)){
            return $this->fImageManager->pullContent($id, $languageid, $image);
        }else{
          return false;
        }
     }

   /** Getting image description encoded
    *
    */
     function getImageContentEncoded($gallery, $image, $encoding = "iso-8859-1", $languageid = 0){
        $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
        if($id = $this->checkGallery($gallery)){
            return $this->fImageManager->pullContentEncoded($id, $languageid, $image, $encoding);
        }else{
          return false;
        }
     }

   /** Getting image created date */
     function getImageCreatedDate($gallery, $image, $format = ''){
       if($id = $this->checkGallery($gallery)){
            return $this->fImageManager->pullCreatedDate($id, $image, $format);
        }else{
          return false;
        }
     }

   /** Getting image updated date */
     function getImageUpdatedDate($gallery, $image, $languageid = 0, $format = ''){
        $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
        if($id = $this->checkGallery($gallery)){
            return $this->fImageManager->pullUpdatedDate($id, $languageid, $image, $format);
        }else{
          return false;
        }
     }

   /** Getting image recent update */
     function getImageRecentUpdate($gallery, $image, $languageid = 0){
       $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
        if($id = $this->checkGallery($gallery)){
            return $this->fImageManager->pullRecentUpdate($id, $languageid, $image);
        }else{
          return false;
        }
     }

   /** Getting image author ID */
     function getImageAuthorID($gallery, $image){
       if($id = $this->checkGallery($gallery)){
            return $this->fImageManager->pullAuthorID($id, $image);
        }else{
          return false;
        }
     }

   /** Getting image editor ID */
     function getImageEditorID($gallery, $image, $languageid = 0){
        $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
        if($id = $this->checkGallery($gallery)){
            return $this->fImageManager->pullEditorID($id, $languageid, $image);
        }else{
          return false;
        }
     }

   /** Setting image filename */
     function setImageFileName($gallery, $image, $filename){
        if($id = $this->checkGallery($gallery)){
            return $this->fImageManager->pushDescription($id, $image, $filename);
        }else{
            return false;
        }
     }

   /** Setting image alternate text
    *
    */
     function setImageTitle($gallery, $image, $title, $languageid = 0){
        $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
        if($id = $this->checkGallery($gallery)){
            return $this->fImageManager->pushTitle($id, $languageid, $image, $title);
        }else{
            return false;
        }
     }

   /** Getting image description
    *
    */
     function setImageContent($gallery, $image, $content, $languageid = 0){
        $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
        if($id = $this->checkGallery($gallery)){
            return $this->fImageManager->pushContent($id, $languageid, $image, $content);
        }else{
            return false;
        }
     }

   /** Setting image token */
      function setImageToken($gallery, $image, $token){
        if($id = $this->checkGallery($gallery)){
          return $this->fImageManager->pushToken($id, $image, $id, $token);
        }else{
          return false;
        }
      }

   /** Set image created date */
     function setImageCreatedDate($gallery, $image, $unixmoment = 0){
       $id = 0;
        if($id = $this->checkGallery($gallery)){
         return $this->fImageManager->pushCreatedDate($id, $image, $unixmoment);
       }else{
         return false;
       }
     }

   /** Set image update date */
     function setImageUpdatedDate($gallery, $image, $languageid = 0, $unixmoment = 0){
       $id = 0;
       $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
        if($id = $this->checkGallery($gallery)){
         return $this->fImageManager->pushUpdatedDate($id, $languageid, $image, $unixmoment);
        }else{
          return false;
        }
     }

   /** Set image author ID */
     function setImageAuthorID($gallery, $image, $authorid = 0){
       $id = 0;
       if($id = $this->checkGallery($gallery)){
         return $this->fImageManager->pushAuthorID($id, $image, $authorid);
       }else{
         return false;
       }
     }

   /** Set image editor ID */
     function setImageEditorID($gallery, $image, $languageid = 0, $editorid = 0){
       $id = 0;
       $languageid = ($languageid == 0) ? $this->fLanguage->getID() : $languageid;
       if($id = $this->checkGallery($gallery)){
         return $this->fImageManager->pushEditorID($id, $languageid, $image, $editorid);
       }else{
         return false;
       }
     }

   /** Adding an image    */
     function addImage($gallery, $image, $description){
        if($id = $this->checkGallery($gallery)){
            if(!$this->fImageManager->checkToken($id, $image, $description, false)){
                return $this->fImageManager->checkToken($id, $image, $description, true);
            }else{
                return false;
            }
        }else{
          return false;
        }
     }

  /** Delete an image
     *
     */
     function deleteImage($gallery, $image){
        if($id = $this->checkGallery($gallery)){
            return $this->fImageManager->deleteToken($id, $image);
        }else{
          return false;
        }
     }

}
?>
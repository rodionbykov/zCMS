<?php

/*
 * ContentManager class
 *
 * v.4B.229
 * (c) Rodion Bykov roddyb@yandex.ru 2006
 * Created on  Aug 17, 2006 (as FuseContent)
 * Last modified on Sep 19th, 2007
 * 
 *  Please ask for written permission before redistribute or use this plugin in your project
 *  I give no warranty or support of any kind for this class, neither guarantee its suitability to any purpose
 */
 
class ContentManager {

	// database object 
	var $fDB = false;
	
	// fuseaction object representing current fuseaction
	var $fFuseaction = false;
	
	// language object representing current fuseaction
	var $fLanguage = false;
	
	// name of content tokens table in database
	var $fContentTokensTable = "";
	
	// name of content table in database
	var $fContentTable = "";
	
	// cache of content for current fuseaction
	var $fCache = array();
	
	// format of HTML output 
	var $fHTMLFormat = "%s %s";
	
	// view/edit mode of output
	var $fEditModeOn = false;
	
	// link that leads to edit form when html output is used
	var $HTMLEditLink = "";
	
	// link that leads to title edit form
	var $fTitleEditLink = "";
	
	// link that leads to content edit form
	var $fContentEditLink = "";
	
	// default author IDs	
	var $fAuthorID = 0;
	
	// default editor IDs	
	var $fEditorID = 0;	
	
	// db date format
	var $fDateFormatDB = "%m/%d/%Y %h:%i %p";

    function ContentManager(&$db, &$fuseaction, &$language, $contenttokens_table, $content_table, $contentcomments_table, $editmode = false) {
    	$this->fDB = &$db;
    	$this->fFuseaction = &$fuseaction;
    	$this->fLanguage = &$language;
    	$this->fContentTokensTable = $contenttokens_table;
    	$this->fContentTable = $content_table;
    	$this->fContentCommentsTable = $contentcomments_table;
    	$this->fEditModeOn = $editmode;
    }
    
    /** Initialization of object: testing tables for existence
     * 
     * @return bool
     */
    function initialize(){
    	
    	$sql1 = "SELECT id, id_fuseaction, token, id_author, description, moment FROM " . $this->fContentTokensTable . " WHERE 1=2";
    	$sql2 = "SELECT id, id_token, id_language, id_author, title, content, moment FROM " . $this->fContentTable . " WHERE 1=2";
    	$sql3 = "SELECT id, id_content, author, commenttext, moment FROM " . $this->fContentCommentsTable . " WHERE 1=2";
    	
    	return $this->fDB->query($sql1) && $this->fDB->query($sql2) && $this->fDB->query($sql3);
    }
    
    function cacheContent(){
    	
    	$content = array();
    	$sql =  "SELECT token, content, title, description, ct.id_author AS authorid, c.id_author AS editorid, DATE_FORMAT(ct.moment, '" . $this->fDateFormatDB . "') AS created, DATE_FORMAT(c.moment, '" . $this->fDateFormatDB . "') AS updated, IF((TO_DAYS(ct.moment) <> TO_DAYS(c.moment)), 1, 0) AS recentupdate FROM " . $this->fContentTable . " c " . 
    			" INNER JOIN " . $this->fContentTokensTable . " ct ON c.id_token = ct.id " . 
				" WHERE id_fuseaction = " . $this->fFuseaction->getID() . 
				" AND id_language = " . $this->fLanguage->getID();
		
		if($content = $this->fDB->getQueryRecordSet($sql)){
			foreach($content as $c){
				$this->fCache[ $c['token'] ]['content'] = $c['content'];
				$this->fCache[ $c['token'] ]['title'] = $c['title'];
				$this->fCache[ $c['token'] ]['description'] = $c['description'];
				$this->fCache[ $c['token'] ]['authorid'] = $c['authorid'];
				$this->fCache[ $c['token'] ]['editorid'] = $c['editorid'];
				$this->fCache[ $c['token'] ]['created'] = $c['created'];
				$this->fCache[ $c['token'] ]['updated'] = $c['updated'];
				$this->fCache[ $c['token'] ]['recentupdate'] = $c['recentupdate'];				
			}
			return $this->fCache;
		}else{
			return false;
		}
    }
    
    function getCleanContent($token, $defaultcontent = ""){
    	if(array_key_exists($token, $this->fCache)){
    		return $this->fCache[$token]['content'];
    	}else{
    		return $this->pullContent($this->fFuseaction->getID(), $this->fLanguage->getID(), $token, $defaultcontent);
    	}
    }
	
	function getCleanTitle($token, $defaulttitle = ""){
		if(array_key_exists($token, $this->fCache)){
    		return $this->fCache[$token]['title'];
    	}else{
    		return $this->pullTitle($this->fFuseaction->getID(), $this->fLanguage->getID(), $token, $defaulttitle);
    	}	
	}
	
	function getContentReplaced($token, $replace = array()){
		$content = "";
		if (is_array($replace) && ($content = $this->getCleanContent($token))){
			$content = str_replace(array_keys($replace), $replace, $content);
			return $content;
		}else{
			return false;
		}
	} 
	
	function getTitleReplaced($token, $replace = array()){
		$title = "";
		if (is_array($replace) && ($title = $this->getCleanTitle($token))){
			$title = str_replace(array_keys($replace), $replace, $title);
			return $title;
		}else{
			return false;
		}
	}
	
	function getContent($token, $defaultcontent = ""){
		if($this->fEditModeOn){
			$result = sprintf($this->fContentEditLink, $this->getCleanContent($token, $defaultcontent), $this->fFuseaction->getID(), $token, $this->fLanguage->getID());
			return $result;
		}else{
			return $this->getCleanContent($token, $defaultcontent);
		}
    }
	
	function getTitle($token, $defaulttitle = ""){
		if($this->fEditModeOn){
			$result = sprintf($this->fTitleEditLink, $this->getCleanTitle($token, $defaulttitle), $this->fFuseaction->getID(), $token, $this->fLanguage->getID());
			return $result;
		}else{
			return $this->getCleanTitle($token, $defaulttitle);
		}
	}
	
	function getAuthorID($token){
		if(array_key_exists($token, $this->fCache)){
    		return $this->fCache[$token]['authorid'];
    	}else{
    		return $this->pullAuthorID($this->fFuseaction->getID(), $token);
    	}	
	}
	
	function getEditorID($token){
		if(array_key_exists($token, $this->fCache)){
    		return $this->fCache[$token]['editorid'];
    	}else{
    		return $this->pullEditorID($this->fFuseaction->getID(), $this->fLanguage->getID(), $token);
    	}	
	}	
	
	function getCreatedDate($token, $format = ''){
		if(array_key_exists($token, $this->fCache)){
    		return $this->fCache[$token]['created'];
    	}else{
    		return $this->pullCreatedDate($this->fFuseaction->getID(), $token, $format);
    	}
	}
	
	function getUpdatedDate($token, $format = ''){
		if(array_key_exists($token, $this->fCache)){
    		return $this->fCache[$token]['updated'];
    	}else{
    		return $this->pullUpdatedDate($this->fFuseaction->getID(), $this->fLanguage->getID(), $token, $format);
    	}
	}	
	
	function getRecentUpdate($token){
		if(array_key_exists($token, $this->fCache)){
    		return $this->fCache[$token]['recentupdate'];
    	}else{
    		return $this->pullRecentUpdate($this->fFuseaction->getID(), $this->fLanguage->getID(), $token);
    	}		
	}
	
	/** Returns a formatted string that contain both content and its title
	 * 
	 * @return string
	 */
	function getHTML($token, $defaulttitle = "", $defaultcontent = ""){
		if($this->fEditModeOn){
			$result = sprintf($this->fHTMLEditLink, $this->fFuseaction->getID(), $token, $this->fLanguage->getID(), $this->getCleanTitle($token, $defaulttitle));
		}else{
			$result = sprintf($this->fHTMLFormat, $this->getCleanTitle($token, $defaulttitle), $this->getCleanContent($token, $defaultcontent));
		}
		return $result;
	}
    
    function getContentEncoded($token, $defaultcontent, $encoding = "iso-8859-1", $striptags = true){
        if($striptags){
    	   return htmlentities(strip_tags($this->getContent($token, $defaultcontent)), ENT_COMPAT, $encoding);
        }else{
           return htmlentities($this->getContent($token, $defaultcontent), ENT_COMPAT, $encoding);
        }
    }

    function getTitleEncoded($token, $defaulttitle, $encoding = "iso-8859-1", $striptags = true){
        if($striptags){
            return htmlentities(strip_tags($this->getTitle($token, $defaulttitle)), ENT_COMPAT, $encoding);
        }else{
        	return htmlentities($this->getTitle($token, $defaulttitle), ENT_COMPAT, $encoding);
        }
    }
	
	function getDescription($token){
		if(array_key_exists($token, $this->fCache)){
    		return $this->fCache[$token]['description'];
    	}else{
    		return $this->pullDescription($this->fFuseaction->getID(), $token);
    	}
	}
	
    function getTokens($token = ""){
    	
		return $this->pullTokens($this->fFuseaction->getID(), $token);
		
    }   
    
    function getTokensCount($fuseactionid) {
    	if (is_numeric($fuseactionid)) {
    		$sql = "SELECT 
						COUNT(*) 
					FROM ".
    					$this->fContentTokensTable.
    				" WHERE 
						id_fuseaction = ".intval($fuseactionid);
			$this->fDB->query($sql);
    		return $this->fDB->getField();
    	} else {
    		return false; 
    	}
    }    
    
    function pullTokens($fuseactionid, $token = "", $order = "token", $sort = "ASC", $start = 0, $count = 0){
    	
        $token = (string) $token;
        $order = in_array($order, array('id', 'token', 'description')) ? $order : "token"; 
        $sort = in_array($sort, array('ASC', 'DESC')) ? $sort : "ASC";
        $start = (int) $start;
        $count = (int) $count;
        
    	if(is_numeric($fuseactionid)){
	    	$sql =  "SELECT id, token, description FROM " . $this->fContentTokensTable . 
					" WHERE id_fuseaction = " . intval($fuseactionid); 
            if(strlen($token) > 0){
            	$sql .= " AND token = '" . addslashes($token) . "'";
            }
			
            $sql .= " ORDER BY " . $order . " " . $sort;
            
            if($count > 0){
            	if($start > 0){
            		$sql .= " LIMIT " . $start . ", " . $count;
            	}else{
            		$sql .= " LIMIT " . $count;
            	}
            }
            
			return $this->fDB->getQueryRecordSet($sql);
    	}else{
    		return false;
    	}
    }

    function getSearchCount($search, $booleanmode = true){
        $sql = "SELECT COUNT(*) AS cnt
				FROM articlestokens at
					INNER JOIN articles a
						ON a.id_token = at.id
				WHERE MATCH (a.title, a.content) AGAINST ('" . addslashes($search) . "'";

        if($booleanmode){
            $sql .= " IN BOOLEAN MODE";
        }

        $sql .= ") > 0";        

       return $this->fDB->getQueryField($sql);
    }

    function searchContent($search, $booleanmode = true, $order = "relevance", $sort = "DESC", $start = 0, $count = 0){
    	
        if($order != "relevance" && $order != "moment" && $order != "title"){
            $order = "relevance";
        }
        
        if($sort != "ASC" && $sort != "DESC"){
            $sort = "DESC";
        }

        $sql = "SELECT at.token, at.description, a.title, a.content, a.moment, MATCH (a.title, a.content) AGAINST ('" . addslashes($search) . "') AS relevance
				FROM articlestokens at 
					INNER JOIN articles a 
						ON a.id_token = at.id 
				WHERE MATCH (a.title, a.content) AGAINST ('" . addslashes($search) . "'";

        if($booleanmode){
            $sql .= " IN BOOLEAN MODE";
        }

        $sql .= ") > 0";

		$sql .= " ORDER BY " . $order . " " . $sort;

        if($count > 0){
            if($start > 0){
                $sql .= " LIMIT " . $start . ", " . $count;
            }else{
                $sql .= " LIMIT " . $count;
            }
        }

    	$arrResults = $this->fDB->getQueryRecordSet($sql);
    	
    	return $arrResults;
    }
    
    function getCommentsCount($token){
    	return $this->pullCommentsCount($this->fFuseaction->getID(), $this->fLanguage->getID(), $token);	
    }
    
    function getComments($token){
    	return $this->pullComments($this->fFuseaction->getID(), $this->fLanguage->getID(), $token);	
    }
    
    function pullComments($fuseactionid, $languageid, $token){
    	
    	$contentid = 0;
    	if($contentid = $this->check($fuseactionid, $languageid, $token, "", "", "", false)){
			$sql = "SELECT id, id_content, author, commenttext, ismuted, moment, DATE_FORMAT(moment, '" . $this->fDateFormatDB . "') AS moment_formatted 
					FROM " . $this->fContentCommentsTable . " 
					WHERE id_content = " . intval($contentid) . "
					ORDER BY moment ASC, id ASC";
    	
    		return $this->fDB->getQueryRecordSet($sql);
    	}else{
    		return false;
    	}
    	  
    }        
    
    function pullCommentsCount($fuseactionid, $languageid, $token){
    	
    	$contentid = 0;
    	if($contentid = $this->check($fuseactionid, $languageid, $token, "", "", "", false)){
			$sql = "SELECT COUNT(*) AS cnt FROM " . $this->fContentCommentsTable . " WHERE id_content = " . intval($contentid);
    	
    		return $this->fDB->getQueryField($sql);
    	}else{
    		return false;
    	}    	
    	
    }
    
    function muteCommentsByID($id){
    	
    	if(is_array($id)){
    		$sql = "UPDATE " . $this->fContentCommentsTable . " SET ismuted = 1 WHERE id IN (" . join(",", $id) . ")";
    	}else{
    		$sql = "UPDATE " . $this->fContentCommentsTable . " SET ismuted = 1 WHERE id = " . intval($id);
    	}
    	return $this->fDB->query($sql); 	
    	
    }
    
    function storeComment($token, $author, $comment){
    	return $this->pushComment($this->fFuseaction->getID(), $this->fLanguage->getID(), $token, $author, $comment);
    }
    
    function storeContent($token, $content = ""){
    	return $this->pushContent($this->fFuseaction->getID(), $this->fLanguage->getID(), $token, $content);
    }
    
    function storeTitle($token, $title = ""){
    	return $this->pushTitle($this->fFuseaction->getID(), $this->fLanguage->getID(), $token, $title);
    }

    function storeDescription($token, $description = ""){
    	return $this->pushDescription($this->fFuseaction->getID(), $token, $description);
    }    
    
    function storeToken($token, $newfuseactionid, $newtoken){
    	return $this->pushToken($this->fFuseaction->getID(), $token, $newfuseactionid, $newtoken);
    }
    
    function storeAuthorID($token, $authorid = 0){
    	return $this->pushAuthorID($this->fFuseaction->getID(), $token, $authorid);
    }
    
    function storeEditorID($token, $editorid = 0){
    	return $this->pushEditorID($this->fFuseaction->getID(), $this->fLanguage->getID(), $token, $editorid);
    }
    
    function storeCreatedDate($token, $unixmoment = 0){
    	return $this->pushCreatedDate($this->fFuseaction->getID(), $token, $unixmoment);
    }

    function storeUpdatedDate($token, $unixmoment = 0){
    	return $this->pushUpdatedDate($this->fFuseaction->getID(), $this->fLanguage->getID(), $token, $unixmoment);
    }
    
    function pullContent($fuseactionid, $languageid, $token, $content = ""){
        $id = 0;
    	if($id = $this->check($fuseactionid, $languageid, $token, $content, "")){
    		return $this->pullContentByID($id);
    	}else{
    		return false;
    	}	
    }
    
    function deleteToken($fuseactionid, $token){
        $id = 0;
    	if($id = $this->checkToken($fuseactionid, $token, "", false)){
    		return $this->deleteTokenByID($id);
    	}else{
    		return false;
    	}
    }
    
    function deleteContent($fuseactionid, $laguageid, $token){
        $id = 0;
        if($id = $this->check($fuseactionid, $laguageid, $token, "", "", "", false)){
            return $this->deleteContentByID($id);
        }else{
            return false;
        }
    }
    
    function deleteFuseactionTokens($fuseactionid){
        if(is_numeric($fuseactionid)){
            if($arrTokens = $this->pullTokens($fuseactionid)){
                $arrIDs = array();
                foreach($arrTokens as $t){
                    $arrIDs[] = $t['id'];
                }
                $strIDs = join(",", $arrIDs);
                if(strlen($strIDs)){
                    $sql1 = "DELETE FROM " . $this->fContentTokensTable . " WHERE id IN (" . $strIDs . ")";
                    $sql2 = "DELETE FROM " . $this->fContentTable . " WHERE id_token IN (" . $strIDs . ")";
                    return $this->fDB->query($sql1) && $this->fDB->query($sql2);
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }       
    }    
    
    function pullTitle($fuseactionid, $languageid, $token, $title = ""){
    	$id = 0;
    	if($id = $this->check($fuseactionid, $languageid, $token, "", $title)){
    		return $this->pullTitleByID($id);
    	}else{
    		return false;
    	}
    }
    
    function pullDescription($fuseactionid, $token){
    	$id = 0;
    	if($id = $this->checkToken($fuseactionid, $token)){
    		return $this->pullDescriptionByID($id);
    	}else{
    		return false;
    	}
    }

    function pullContentEncoded($fuseactionid, $languageid, $token, $encoding = "iso-8859-1", $content = "", $striptags = true){
        $id = 0;
        if($id = $this->check($fuseactionid, $languageid, $token, $content, "")){
        	if($striptags){
                return htmlentities(strip_tags($this->pullContentByID($id)), ENT_COMPAT, $encoding);
            }else{
            	return htmlentities($this->pullContentByID($id), ENT_COMPAT, $encoding);
            }
        }else{
            return false;
        }   
    }

    function pullTitleEncoded($fuseactionid, $languageid, $token, $encoding = "iso-8859-1", $title = "", $striptags = true){
        $id = 0;
        if($id = $this->check($fuseactionid, $languageid, $token, "", $title)){
            if($striptags){
                return htmlentities(strip_tags($this->pullTitleByID($id)), ENT_COMPAT, $encoding);
            }else{
            	return htmlentities($this->pullTitleByID($id), ENT_COMPAT, $encoding);
            }            
        }else{
            return false;
        }
    }
    
    function pullAuthorID($fuseactionid, $token){
    	$id = 0;
    	if($id = $this->checkToken($fuseactionid, $token)){
    		return $this->pullAuthorIDByID($id);
    	}else{
    		return false;
    	}
    }
    
	function pullEditorID($fuseactionid, $languageid, $token){
	    $id = 0;
    	if($id = $this->check($fuseactionid, $languageid, $token)){
    		return $this->pullEditorIDByID($id);
    	}else{
    		return false;
    	}
	}
	
	function pullCreatedDate($fuseactionid, $token, $format = ''){
		$id = 0;
    	if($id = $this->checkToken($fuseactionid, $token)){
    		return $this->pullCreatedDateByID($id, $format);
    	}else{
    		return false;
    	}
	}
	
	function pullUpdatedDate($fuseactionid, $languageid, $token, $format = ''){
		$id = 0;
    	if($id = $this->check($fuseactionid, $languageid, $token)){
    		return $this->pullUpdatedDateByID($id, $format);
    	}else{
    		return false;
    	}
	}	
	
	function pullRecentUpdate($fuseactionid, $languageid, $token){
		$id = 0;
    	if($id = $this->check($fuseactionid, $languageid, $token)){
    		return $this->pullRecentUpdateByID($id);
    	}else{
    		return false;
    	}
	}

    function pushComment($fuseactionid, $languageid, $token, $author, $comment){
    	$id = 0;
    	if($id = $this->check($fuseactionid, $languageid, $token, "", "")){
    		return $this->pushCommentByID($id, $author, $comment);
    	}else{
    		return false;
    	}
    } 
    
    function pushContent($fuseactionid, $languageid, $token, $content = ""){
    	$id = 0;
    	if($id = $this->check($fuseactionid, $languageid, $token, $content, "")){
    		return $this->pushContentByID($id, $content);
    	}else{
    		return false;
    	}
    }    
    
    function pushTitle($fuseactionid, $languageid, $token, $title = ""){
    	$id = 0;
    	if($id = $this->check($fuseactionid, $languageid, $token, "", $title)){
			return $this->pushTitleByID($id, $title);
    	}else{
    		return false;
    	}
    }
    
    function pushToken($fuseactionid, $token, $newfuseactionid, $newtoken){
        $id = 0;
    	if($id = $this->checkToken($fuseactionid, $token)){
    		return $this->pushTokenByID($id, $newfuseactionid, $newtoken);
    	}else{
    		return false;
    	}
    }
    
    function pushDescription($fuseactionid, $token, $description = ""){
    	$id = 0;
    	if($id = $this->checkToken($fuseactionid, $token, $description)){
			return $this->pushDescriptionByID($id, $description);
    	}else{
    		return false;
    	}
    }
    
    function pushAuthorID($fuseactionid, $token, $authorid = 0){
    	$id = 0;
      	if($authorid == 0){
    		$authorid = $this->fAuthorID;
    	}
    	if($id = $this->checkToken($fuseactionid, $token)){
			return $this->pushAuthorIDByID($id, $authorid);
    	}else{
    		return false;
    	}
    }    

    function pushEditorID($fuseactionid, $languageid, $token, $editorid = 0){
    	$id = 0;
       	if($editorid == 0){
    		$editorid = $this->fEditorID;
    	}
    	if($id = $this->check($fuseactionid, $languageid, $token)){
			return $this->pushEditorIDByID($id, $editorid);
    	}else{
    		return false;
    	}
    }    
    
    function pushCreatedDate($fuseactionid, $token, $unixmoment = 0){
    	$id = 0;
    	if($id = $this->checkToken($fuseactionid, $token)){
			return $this->pushCreatedDateByID($id, $unixmoment);
    	}else{
    		return false;
    	}
    }
    
    function pushUpdatedDate($fuseactionid, $languageid, $token, $unixmoment = 0){
    	$id = 0;
    	if($id = $this->check($fuseactionid, $languageid, $token)){
			return $this->pushUpdatedDateByID($id, $unixmoment);
    	}else{
    		return false;
    	}
    }
    
    function checkToken($fuseactionid, $token, $description = "", $addifnotexists = true){
        
        $addifnotexists = (bool) $addifnotexists;
        
		if(is_numeric($fuseactionid)){
			$id = 0;
		    $sql =  "SELECT id FROM " . $this->fContentTokensTable . 
					" WHERE id_fuseaction = " . $fuseactionid . 
					" AND token = '" . addslashes($token) . "'";					
			if($id = $this->fDB->getQueryField($sql)){
				return (int) $id;
			}else{
                if($addifnotexists){
    				$sql = "INSERT INTO " . $this->fContentTokensTable . 
    						" (id_fuseaction, token, id_author, description, moment)" . 
    						" VALUES (" . $fuseactionid . ", '" . addslashes($token) . "', " . intval($this->fAuthorID) . ", '" . addslashes($description) . "', NOW())";    												
    				if($this->fDB->query($sql) && ($id = $this->fDB->getID())){
    						return $id;
    				}else{
    						return false;
    				}
                }else{
                	return false;
                }
			}
		}else{
			return false;
		}
    }
    
    function checkContent($tokenid, $languageid, $content = "", $title = "", $addifnotexists = true){
        
        $addifnotexists = (bool) $addifnotexists;
        
    	if(is_numeric($tokenid) && is_numeric($languageid)){
    		$sql = "SELECT id FROM " . $this->fContentTable . " WHERE id_token = " . $tokenid . " AND id_language = " . $languageid;
    		if($id = $this->fDB->getQueryField($sql)){
				return (int) $id;
    		}else{
                if($addifnotexists){
        			$sql = "INSERT INTO " . $this->fContentTable . 
    						" (id_token, id_language, id_author, title, content, moment) VALUES (" . 
    							intval($tokenid) . ", " . 
    							intval($languageid) . ", " . 
    							intval($this->fEditorID) . ", '" .
    							addslashes($title) . "', '" . 
    							addslashes($content) . "', NOW())";
    				if($this->fDB->query($sql) && ($id = $this->fDB->getID())){
    					return $id;
    				}else{
    					return false;
    				}
                }else{
                	return false;
                }               
    		}
    	}else{
    		return false;
    	}
    }
    
    function check($fuseactionid, $languageid, $token, $content = "", $title = "", $description = "", $addifnotexists = true){
   		if(is_numeric($fuseactionid) && is_numeric($languageid)){
   			return $this->checkContent($this->checkToken($fuseactionid, $token, $description, $addifnotexists), $languageid, $content, $title, $addifnotexists);			
   		}else{
   			return false;
   		}
    }
    
    function pullContentByID($contentid){
    	if(is_numeric($contentid)){
	    	$sql =  "SELECT content FROM " . $this->fContentTable . " WHERE id = " . (int) $contentid;   	
	    	if($row = $this->fDB->getQueryRecord($sql)){
	    		return $row['content'];
	    	}else{
		    	return false; 
	    	}
    	}else{
    		return false;
    	}
    }
    
    function pullTitleByID($contentid){ 	
    	if(is_numeric($contentid)){	    	
	    	$sql =  "SELECT title FROM " . $this->fContentTable . " WHERE id = " . (int) $contentid;
	    	if($row = $this->fDB->getQueryRecord($sql)){
	    		return $row['title'];
	    	}else{
		    	return false; 
	    	}
    	}else{
    		return false;
    	}
    }

    function pullDescriptionByID($tokenid){ 	
    	if(is_numeric($tokenid)){	    	
	    	$sql =  "SELECT description FROM " . $this->fContentTokensTable . " WHERE id = " . (int) $tokenid;
	    	if($row = $this->fDB->getQueryRecord($sql)){
	    		return $row['description'];
	    	}else{
		    	return false; 
	    	}
    	}else{
    		return false;
    	}
    }
    
    function pullAuthorIDByID($tokenid){
    	if(is_numeric($tokenid)){
	    	$sql =  "SELECT id_author FROM " . $this->fContentTokensTable . " WHERE id = " . (int) $tokenid;
	    	if($row = $this->fDB->getQueryRecord($sql)){
	    		return $row['id_author'];
	    	}else{
		    	return false; 
	    	}
    	}else{
    		return false;
    	}
    }
    
    function pullEditorIDByID($contentid){
    	if(is_numeric($contentid)){
	    	$sql =  "SELECT id_author FROM " . $this->fContentTable . " WHERE id = " . (int) $contentid;
	    	if($row = $this->fDB->getQueryRecord($sql)){
	    		return $row['id_author'];
	    	}else{
		    	return false; 
	    	}
    	}else{
    		return false;
    	}
    }
    
    function pullRecentUpdateByID($contentid){
		if(is_numeric($contentid)){
	    	$sql =  "SELECT IF(TO_DAYS(ct.moment) <> TO_DAYS(c.moment), 1, 0) AS recentupdate" .
	    	" FROM " . $this->fContentTokensTable . " ct" .
	    	" INNER JOIN " . $this->fContentTable . " c ON c.id_token = ct.id" .
			" WHERE c.id = " . (int) $contentid;
	    	if($row = $this->fDB->getQueryRecord($sql)){
	    		return $row['recentupdate'];
	    	}else{
		    	return false; 
	    	}
    	}else{
    		return false;
    	}    	
    }
        
    function pullCreatedDateByID($tokenid, $format = ''){
    	if(empty($format)){
    		$format = $this->fDateFormatDB;
    	}
    	
    	if(is_numeric($tokenid)){
	    	$sql = "SELECT DATE_FORMAT(moment, '" . $format . "') AS created FROM " . $this->fContentTokensTable . " WHERE id = "  . (int) $tokenid;
	    	if($row = $this->fDB->getQueryRecord($sql)){
	    		return $row['created'];
	    	}else{
		    	return false; 
	    	}
    	}else{
    		return false;
    	}
    	
    	     	
    }

    function pullUpdatedDateByID($contentid, $format = ''){
    	if(empty($format)){
    		$format = $this->fDateFormatDB;
    	}
    	
    	if(is_numeric($contentid)){
	    	$sql =  "SELECT DATE_FORMAT(moment, '" . $format . "') AS updated FROM " . $this->fContentTable . " WHERE id = " . (int) $contentid;
	    	if($row = $this->fDB->getQueryRecord($sql)){
	    		return $row['updated'];
	    	}else{
		    	return false; 
	    	}
    	}else{
    		return false;
    	}    	
    }
    
    function pushCommentByID($contentid, $author, $comment){    	
    	if(is_numeric($contentid)){
    		$sql = "INSERT INTO " . $this->fContentCommentsTable . 
				  " SET id_content = " . intval($contentid) . ", " .
				  " author = '" . addslashes($author) . "', " . 
				  " commenttext = '" . addslashes($comment) . "', " .
				  " moment = NOW()";				  
    		return $this->fDB->query($sql);
    	}else{
    		return false;
    	}    	
    }
    
    function pushContentByID($contentid, $content){
    	if(is_numeric($contentid)){
    		$sql = "UPDATE " . $this->fContentTable . " SET content = '" . addslashes($content) . "' WHERE id = " . (int) $contentid;
    		return $this->fDB->query($sql);
    	}else{
    		return false;
    	}
    }
    
    function pushTitleByID($contentid, $title){
    	if(is_numeric($contentid)){
    		$sql = "UPDATE " . $this->fContentTable . " SET title = '" . addslashes($title) . "' WHERE id = " . (int) $contentid;
    		return $this->fDB->query($sql);
    	}else{
    		return false;
    	}
    }
    
	function pushDescriptionByID($tokenid, $description){
		if(is_numeric($tokenid)){
    		$sql = "UPDATE " . $this->fContentTokensTable . " SET description = '" . addslashes($description) . "' WHERE id = " . (int) $tokenid;
    		return $this->fDB->query($sql);
    	}else{
    		return false;
    	}
	}
    
    function pushTokenByID($tokenid, $newfuseactionid, $newtoken){       
    	if(is_numeric($tokenid) && is_numeric($newfuseactionid) && strlen($newtoken) > 0){            
    		$sql =  "UPDATE ". $this->fContentTokensTable . 
                    " SET id_fuseaction = " . (int) $newfuseactionid . "," . 
                    " token = '" . addslashes($newtoken) . "'" .  
                    " WHERE id = " . (int) $tokenid;
            return $this->fDB->query($sql);
    	}else{
    		return false;
    	}
    }
    
    function pushAuthorIDByID($tokenid, $authorid){
      	if(is_numeric($tokenid) && is_numeric($authorid)){            
    		$sql =  "UPDATE ". $this->fContentTokensTable . 
                    " SET id_author = " . (int) $authorid .                        
                    " WHERE id = " . (int) $tokenid;
            return $this->fDB->query($sql);
    	}else{
    		return false;
    	}
    }
    
    function pushEditorIDByID($contentid, $editorid){
    	if(is_numeric($contentid) && is_numeric($editorid)){            
    		$sql =  "UPDATE ". $this->fContentTable . 
                    " SET id_author = " . (int) $editorid .                        
                    " WHERE id = " . (int) $contentid;
            return $this->fDB->query($sql);
    	}else{
    		return false;
    	}
    }
    
    function pushCreatedDateByID($tokenid, $unixmoment = 0){
    	if($unixmoment == 0){
    		$unixmoment = time();
    	}    
    		
    	if(is_numeric($tokenid) && is_int($unixmoment)){            
    		$sql =  "UPDATE ". $this->fContentTokensTable . 
                    " SET moment = '" .  date("Y-m-d H:i:s", $unixmoment) . "'" .                        
                    " WHERE id = " . (int) $tokenid;
            return $this->fDB->query($sql);
    	}else{
    		return false;
    	}        	
    }
    
    function pushUpdatedDateByID($contentid, $unixmoment = 0){
    	if($unixmoment == 0){
    		$unixmoment = time();
    	}
    	    
    	if(is_numeric($contentid) && is_int($unixmoment)){            
    		$sql =  "UPDATE ". $this->fContentTable . 
                    " SET moment = '" .  date("Y-m-d H:i:s", $unixmoment) . "'" .                        
                    " WHERE id = " . (int) $contentid;
            return $this->fDB->query($sql);
    	}else{
    		return false;
    	}    	
    }
    
    function deleteTokenByID($id){
    	if(is_numeric($id)){
            $sql1 = "DELETE FROM " . $this->fContentTokensTable . " WHERE id = " . $id;
            $sql2 = "DELETE FROM " . $this->fContentTable . " WHERE id_token = " . $id;
            return $this->fDB->query($sql1) && $this->fDB->query($sql2);
        }else{
            return false;
        }
    }
    
    function deleteContentByID($id){
    	if(is_numeric($id)){
    		$sql = "DELETE FROM " . $this->fContentTable . " WHERE id = " . $id;
            return $this->fDB->query($sql);
    	}else{
    		return false;
    	}
    }

}
?>
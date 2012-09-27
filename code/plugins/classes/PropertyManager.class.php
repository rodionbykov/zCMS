<?php

class PropertyManager {

	var $fDB;
	var $fPropertiesTable;
	var $fDictionaryTable;

    function PropertyManager(&$db, $propertiestable, $dictionarytable) {
    	$this->fDB = &$db;
    	$this->fPropertiesTable = $propertiestable;
    	$this->fDictionaryTable = $dictionarytable;
    }

    /** Initializing manager
     *
     * @return bool
     */
    function initialize(){
    	// create table properties (id int unsigned not null primary key auto_increment, code varchar(70) not null, name varchar(255), UNIQUE IXU_code (code));
		// create table dictionary (id int unsigned not null primary key auto_increment,id_property int unsigned not null,  code varchar(70) not null, value varchar(255), UNIQUE IXU_prop_code (id_property, code));
    }

    /** Getting array of properties with filter
     *
     * @return Array of properties
     */
    function getProperties($order = "code", $sort = "ASC", $offset = 0, $count = 0){
    	$order = (in_array(strtolower($order), array("id", "code", "name"))) ? $order : "code";
    	$sort = (in_array(strtoupper($sort), array("ASC", "DESC"))) ? $sort : "ASC";

    	$sql = "SELECT id, code, name FROM " . $this->fPropertiesTable . " ORDER BY " . $order . " " . $sort;

    	if($count > 0 && $offset > 0){
    		$sql .= " LIMIT " . (int) $offset. ", " . (int) $count;
    	}elseif($count > 0){
    		$sql .= " LIMIT " . (int) $count;
    	}

    	return $this->fDB->getQueryRecordSet($sql);
    }

    function getPropertyCount(){
    	$sql = "SELECT COUNT(*) AS cnt FROM " . $this->fPropertiesTable;
    	return $this->fDB->getQueryField($sql);
    }

    /** Getting single property by its code
     *
     * @return Array property
     */
    function getProperty($propertycode, $propertyname = ""){
    	$propertyid = 0;
    	if($propertyid = $this->checkProperty($propertycode, $propertyname)){
    		return $this->getPropertyByID($propertyid);
    	}else{
    		return false;
    	}
    }

    /** Getting single property by its ID
     *
     * @return Array property
     */
    function getPropertyByID($propertyid){
    	if(is_numeric($propertyid)){
    		$sql = "SELECT code, name FROM " . $this->fPropertiesTable . " WHERE id = " . $propertyid;
    		return $this->fDB->getQueryRecord($sql);
    	}
    }

    /** Checking if property with given code exists and creating new if not
     *
     * @return int property ID
     */
    function checkProperty($propertycode, $propertyname = ""){
    	$propertyid = 0;
    	$sql = "SELECT id FROM " . $this->fPropertiesTable . " WHERE UCASE(code) = UCASE('" . addslashes($propertycode) . "')"; // comparing case-insensitive
    	if($propertyid = $this->fDB->getQueryField($sql)){
			return $propertyid;
    	}else{
			return $this->addProperty(array('code' => $propertycode, 'name' => $propertyname));
    	}
    }

    /** Adding property to DB
     *
     * @return int new property ID
     */
    function addProperty($property){
	    $sql = "INSERT INTO " . $this->fPropertiesTable . " (code, name) VALUES ('" . addslashes(trim($property['code'])) . "', '" . addslashes(trim($property['name'])) . "')";
		if($this->fDB->query($sql)){
			return $this->fDB->getID();
		}else{
			return false;
		}
    }

    /** Storing new value for property given by its code to DB
     *
     * @return bool result of saving property
     */
    function setProperty($propertycode, $property){
    	$propertyid = 0;
    	if($propertyid = $this->checkProperty($propertycode)){
    		return $this->setPropertyByID($propertyid, $property);
    	}else{
    		return false;
    	}
    }

    /** Storing new value for property given by its ID to DB
     *
     * @return bool result of saving property
     */
    function setPropertyByID($propertyid, $property){
    	if(is_numeric($propertyid)){
    		$sql = "UPDATE " . $this->fPropertiesTable .
					" SET code = '" . addslashes(trim($property['code'])) . "'," .
					" name = '" . addslashes(trim($property['name'])) . "' WHERE id = " . $propertyid;
			return $this->fDB->query($sql);
    	}else{
    		return false;
    	}
    }


    /** Removing property given by its code to DB
     *
     * @return bool result of removing property from DB
     */
    function removeProperty($propertycode){
    	$propertyid = 0;
    	if($propertyid = $this->checkProperty($propertycode)){
    		return $this->removePropertyByID($propertyid);
    	}else{
    		return true; // nothing to delete == already deleted => result is true
    	}
    }

    /** Removing property given by its ID to DB
     *
     * @return bool result of removing property to DB
     */
    function removePropertyByID($propertyid){
    	if(is_numeric($propertyid)){
    		//remove dictionary records
    		$sql1 = "DELETE FROM " . $this->fDictionaryTable ." WHERE id_property = " . $propertyid;
    		$sql2 = "DELETE FROM " . $this->fPropertiesTable ." WHERE id = " . $propertyid;

			return $this->fDB->query($sql1) && $this->fDB->query($sql2);
    	}else{
    		return false;
    	}
    }

    /** Getting dictionary of values for property given by code
     *
     * @return Array of property values
     */
    function getDictionary($propertycode, $xcode = "", $order = "pos", $sort = "ASC", $offset = 0, $count = 0){
    	$propertyid = 0;
    	if($propertyid = $this->checkProperty($propertycode)){
    		return $this->getDictionaryByID($propertyid, $xcode, $order, $sort, $offset, $count);
    	}else{
    		return false;
    	}
    }

    /** Getting dictionary of values for property with given ID
     *
     * @return Array of property values
     */
    function getDictionaryByID($propertyid, $xcode = "", $order = "pos", $sort = "ASC", $offset = 0, $count = 0){
    	$order = (in_array(strtolower($order), array("id", "code", "xcode", "name", "pos"))) ? $order : "pos";
    	$sort = (in_array(strtoupper($sort), array("ASC", "DESC"))) ? $sort : "ASC";
    	if(is_numeric($propertyid)){
    		$sql = "SELECT id, UCASE(code) AS code, UCASE(xcode) AS xcode, name, pos FROM " . $this->fDictionaryTable . " WHERE id_property = " . $propertyid;
    		if(strlen($xcode) > 0){
    			$sql .= " AND UCASE(xcode) = UCASE('" . addslashes(trim($xcode)) . "')";
    		}
    		$sql .= " ORDER BY " . $order . " " . $sort;

    		if($count > 0 && $offset > 0){
    			$sql .= " LIMIT " . (int) $offset. ", " . (int) $count;
    		}elseif($count > 0){
    			$sql .= " LIMIT " . (int) $count;
    		}
    		return $this->fDB->getQueryRecordSet($sql);
    	}else{
    		return false;
    	}
    }


    /** Getting dictionary size (number of elements) for property given by code
     *
     * @return int dictionary size
     */
    function getDictionaryCount($propertycode, $xcode = ""){
    	$propertyid = 0;
    	if($propertyid = $this->checkProperty($propertycode)){
    		return $this->getDictionaryCountByID($propertyid, $xcode);
    	}else{
    		return false;
    	}
    }

    /** Getting dictionary size (number of elements) for property given by ID
     *
     * @return int dictionary size
     */
    function getDictionaryCountByID($propertyid, $xcode = ""){
    	if(is_numeric($propertyid)){
    		$sql = "SELECT COUNT(*) AS cnt FROM " . $this->fDictionaryTable . " WHERE id_property = " . $propertyid;
    		if(strlen($xcode) > 0){
    			$sql .= " AND UPPER(xcode) = UPPER('" . addslashes($xcode) . "')";
    		}
    		return $this->fDB->getQueryField($sql);
    	}else{
    		return false;
    	}
    }

    /** Getting dictionary entry by property code and entry code
     *
     * @return Array Dictionary Entry
     */
	function getDictionaryEntry($propertycode, $entrycode, $entryname = ""){
		$entryid = 0;
		if($entryid = $this->checkDictionaryEntry($propertycode, $entrycode, $entryname)){
			return $this->getDictionaryEntryByID($entryid);
		}else{
			return false;
		}
	}

    /** Checking if entry given by its code exists in dictionary for property given by its code
     * If not exists, entry is added
     *
     * @return int entry ID
     */
    function checkDictionaryEntry($propertycode, $entrycode, $entryname = ""){
    	$propertyid = 0;
    	$entryid = 0;

    	if($propertyid = $this->checkProperty($propertycode)){
	    	$sql = "SELECT id FROM " . $this->fDictionaryTable .
					" WHERE UCASE(code) = UCASE('" . addslashes(trim($entrycode)) . "') AND id_property = " . $propertyid;
			if($entryid = $this->fDB->getQueryField($sql)){
				return $entryid;
			}else{
				return $this->addDictionaryEntry($propertycode, array('code' => $entrycode, 'xcode' => "", 'name' => $entryname, 'pos' => 9999999));
			}
    	}
    }

     /** Getting dictionary entry by dicttionary entry ID
     *
     * @return Array Dictionary Entry
     */
	function getDictionaryEntryByID($entryid){
		if(is_numeric($entryid)){
			$sql = "SELECT id, UCASE(code) AS code, UCASE(xcode) AS xcode, name, pos FROM " . $this->fDictionaryTable . " WHERE id = " . $entryid;
			return $this->fDB->getQueryRecord($sql);
		}else{
			return false;
		}
	}

    /** Adding entry to dictionary for property given by its code
     *
     * @return bool result of inserting new entry to DB
     */
    function addDictionaryEntry($propertycode, $entry){
    	$propertyid = 0;
    	// TODO check if code exists
    	if($propertyid = $this->checkProperty($propertycode)){
    		$sql = "INSERT INTO " . $this->fDictionaryTable . " (id_property, code, xcode, name, pos) VALUES (" . $propertyid . ", '" .
    				addslashes(strtoupper(trim($entry['code']))) . "', '" . addslashes(strtoupper(trim($entry['xcode']))) . "', '" . addslashes($entry['name']) . "', " . (int) $entry['pos'] . ")";
    		if($this->fDB->query($sql)){
    			return $this->fDB->getID();
    		}
    	}
    }

    /** Updating dictionary entry for property given by its code
     *
     * @return bool result of updating entry in DB
     */
    function setDictionaryEntry($propertycode, $entrycode, $entry){
    	$entryid = 0;
    	if($entryid = $this->checkDictionaryEntry($propertycode, $entrycode)){
    		return $this->setDictionaryEntryByID($entryid, $entry);
    	}else{
    		return false;
    	}
    }

    /** Updating dictionary entry given by its ID
     *
     * @return bool result of updating entry in DB
     */
    function setDictionaryEntryByID($entryid, $entry){
    	// TODO check if id exists
    	if(is_numeric($entryid)){
			$sql = "UPDATE " . $this->fDictionaryTable .
					" SET code = '" . addslashes(strtoupper(trim($entry['code']))) . "', " .
					" xcode = '" . addslashes(strtoupper(trim($entry['xcode']))) .
					"', name = '" . addslashes($entry['name']) . "', pos = " . (int) $entry['pos'] .
					" WHERE id = " . $entryid;
			return $this->fDB->query($sql);
    	}else{
    		return false;
    	}

    }

    /** Removing dictionary entry from property's dictionary
     * Property and entry are given by their codes
     *
     * @return bool result of removal
     */
    function removeDictionaryEntry($propertycode, $entrycode){
    	$entryid = 0;
    	if($entryid = $this->checkDictionaryEntry($propertycode, $entrycode)){
    		return $this->removeDictionaryEntryByID($entryid);
    	}else{
    		return true; // nothing to delete == already deleted => result is true
    	}
    }

    /** Removing dictionary entry from property's dictionary
     * Entry is given by its ID
     *
     * @return bool result of removal
     */
    function removeDictionaryEntryByID($entryid){
    	if(is_numeric($entryid)){
    		$sql = "DELETE FROM " . $this->fDictionaryTable . " WHERE id = " . $entryid;
    		return $this->fDB->query($sql);
    	}
    }
}

?>
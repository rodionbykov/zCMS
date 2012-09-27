<?php

    /**
    * @package NSTree
    * @author Marat Komarov
    */
    
    /**
     * Modified by Rodion Bykov for Clone project 27.07.07
     */

    // Error strings
    define ("NSTREE_ERROR_NODE_NOT_EXISTS",     "node not found");
    define ("NSTREE_ERROR_INVALID_DB_CLASS",  "invalid db class wrapper");
    define ("NSTREE_ERROR_INVALID_TABLE",     "invalid %s table name");
    define ("NSTREE_ERROR_INVALID_COLUMN",    "invalid structure column `%s`");
    define ("NSTREE_ERROR_NOT_ENOUGH_PARAMS", "structure columns not enougth");
    define ("NSTREE_ERROR_INVALID_AXIS",      "invalid axis or axis not supported in this method");
    
    
    // Axis constants
    define ("NSTREE_AXIS_DESCENDANT",            0);
    define ("NSTREE_AXIS_CHILD",                 1);
    define ("NSTREE_AXIS_ANCESTOR",              2);
    define ("NSTREE_AXIS_PARENT",                3);
    define ("NSTREE_AXIS_FOLLOWING_SIBLING",     4);
    define ("NSTREE_AXIS_PRECENDING_SIBLING",    5);
    define ("NSTREE_AXIS_SELF",                  6);
    define ("NSTREE_AXIS_DESCENDANT_OR_SELF",    7);
    define ("NSTREE_AXIS_ANCESTOR_OR_SELF",      8);
    define ("NSTREE_AXIS_LEAF",                  9);

    class NSTree {
        
        /** 
         * @desc Composition with DB wrapper
         * @var object
         */
        var $fDB;
        
        /**
        * @desc Table with Nested Sets implemented
        * @var string
        */
        var $structTable;
        
        /**
        * @desc Table with data, mapped 1:1 to Nested Sets table
        * @var string
        */
        var $dataTable;
        
        /**
        * @desc Name of the id-auto_increment-field in the table.
        * @var int
        */
        var $id;
        
        /**
        * @var int
        */
        var $data_id;
        
        /**
        * @var int
        */
        var $left;
        
        /**
        * @var int
        */
        var $right;
        
        /**
        * @var int
        */
        var $level;
        
        /**
        * @param string $structTableName       
        * @param string $dataTableName         
        * @param string $fieldNames            
        */
        function NSTree(&$db, $structTableName, $dataTableName, $fieldNames = array()) {
            
            if(!is_a($db, "DB")){
                $this->_displayError(INVALID_DB_CLASS, __LINE__, __FILE__);
            }            
            $this->fDB = $db;
        	
            if (! $structTableName = trim($structTableName))
                $this->_displayError(sprintf(NSTREE_ERROR_INVALID_TABLE, "struct"), __LINE__, __FILE__);
            $this->structTable = $structTableName;
            
            if (! $dataTableName = trim($dataTableName))
                $this->_displayError(sprintf(NSTREE_ERROR_INVALID_TABLE, "data"), __LINE__, __FILE__);
            $this->dataTable = $dataTableName;                        
            
            if (empty($fieldNames)){
            	$fieldNames = array('id' => 'id', 'data_id' => 'data_id', 'left' => 'left', 'right' => 'right', 'level' => 'level');
            }
            
            if (sizeof($fieldNames) != 5){
                $this->_displayError(NSTREE_ERROR_NOT_ENOUGH_PARAMS, __LINE__, __FILE__);
            }

            $tblFields = array('id', 'data_id', 'left', 'right', 'level');
            
            foreach ($fieldNames as $k => $v) {
                if (! in_array($k, $tblFields)){
                    $this->_displayError(sprintf(NSTREE_ERROR_INVALID_COLUMN, $k), __LINE__, __FILE__);
                }
                eval('$this->'.$k.'="'.$v.'";');
            }
        }
        
        /** Initializing tree: checking for tables and clearing the tables if needed
         * 
         */
         function initialize($data = array()){
            
            $sql = "SELECT `{$this->id}`, `{$this->data_id}`, `{$this->left}`, `{$this->right}`, `{$this->level}` FROM " . $this->structTable;
            $resStruct = $this->fDB->query($sql);
            $intStruct = $this->fDB->getRowsCount();
            $sql = "SELECT * FROM " . $this->dataTable;
            $resData = $this->fDB->query($sql);
            $intData = $this->fDB->getRowsCount();
            
            if($resStruct && $resData){
                if(($intStruct == 0) || ($intData == 0)){
                    return $this->clear($data);
                }else{
                    return true;
                }
            }else{
                return false;
            }
         }
        
        /**
        * @param string $message
        * @param int $line
        * @param string $file
        * @param bool $terminate
        */
        function _displayError($message, $line = '', $file = '', $terminate = true) {
            print "<b>NSTree error</b> $message on line $line, file $file<br/><br/>";
            if ($terminate) die();
        }

        /**
        * @return array
        */
        function getRootNode($additionalData = array()) {
            return $this->getNode(0, $additionalData);
        }
                
        /**
        * @return array
        */
        function getRootNodeInfo() {
            return $this->getNodeInfo(0);
        }
        
        /**
        * @param int $id
        * @return array
        */
        function getParentNodeInfo($id) {
            return $this->getParentNode($id, array());
        }
        
        /**
        * Returns parent element of the node for such level
        *
        * @param  int $id                
        * @param  string[] $additionalData    
        * @return array
        */
        function getParentNode($id, $additionalData = array()) {
            $nodeSet = $this->select($id, $additionalData, NSTREE_AXIS_PARENT);
            if (!empty($nodeSet)) {
                return $nodeSet[0];
            }
            return false;
        }        

        /**
        * @param int $id
        * @return array
        */
        function getNodeInfo($id) {
            return $this->getNode($id, array());
        }
               
        /**
        * @param  int $id
        * @param  string[] $additionalData  
        * @return array
        */
        function getNode($id, $additionalData) {
            $nodeSet = $this->select($id, $additionalData, NSTREE_AXIS_SELF);
            if (! empty($nodeSet)){
                return $nodeSet[0];
            }else{
                return false;
            }
        }
        

        /**
        * ������� ������� ��������� � ������, ������ �������� ������� ������, � ���������������
        * ������� �������������� � ������� $data
        *
        * @param  array $data
        * @return int
        */
        function clear($data = array()) {
            // clearing table
            $this->fDB->query("TRUNCATE {$this->structTable}");
            $this->fDB->query("TRUNCATE {$this->dataTable}");
            
            // preparing data to be inserted            
            foreach ($data as $n => $value){
                $sqlInsert[] = "$n='".addslashes($value)."'";
            }
                            
            $sqlInsert = implode(', ', $sqlInsert);
            
            $sql = "INSERT INTO {$this->dataTable} SET {$sqlInsert}";
           
            // insert data
            $this->fDB->query($sql);
            
            // get data ID
            
            $data_id = $this->fDB->getID();            
            
            // create root node in struct table
            
            $sql = "
                INSERT INTO {$this->structTable} 
                SET                    
                    `{$this->data_id}` = {$data_id}, 
                    `{$this->left}` = 1, 
                    `{$this->right}` = 2, 
                    `{$this->level}` = 0 
            ";
            
            $this->fDB->query($sql);
            
            $id = $this->fDB->getID();            
            
            return $id;
        }

        /**
        * Updates a record
        *
        * @param  int $id
        * @param  array $data
        * @return bool
        */
        function updateNode($id, $data) {
            if (! is_array($data)) return false;
            if (! $id = intval($id)) return false;
            
            if ($idInfo = $this->getNodeInfo($id)) {
                foreach ($data as $n => $value)
                    $sqlSet[] = "$n='".addslashes($value)."'";
                $sqlSet = implode(', ', $sqlSet);
                
                $sql = "UPDATE {$this->dataTable} SET {$sqlSet} WHERE {$this->id} = {$idInfo['data_id']}";
                
                // insert data
                return $this->fDB->query($sql);
            } else
                return false;
        }
        
        /**
        * @desc   Inserts a record into the table with nested sets
        * @param  int $parentId              
        * @param  array $data                  
        * @return int
        */
        function appendChild($parentId, $data = false, $dataId = false) {
            $parentId = intval($parentId);
            $dataId   = intval($dataId);
            if (! is_array($data)) $data = array();
            
            if ($parentInfo = $this->getNodeInfo($parentId)) {
                $leftId  = $parentInfo['left'];
                $rightId = $parentInfo['right'];
                $level   = $parentInfo['level'];
                
                if (! $dataId) {
                
                    // preparing data to be inserted
                    foreach ($data as $n => $value){
                        $sqlInsert[] = "$n='".addslashes($value)."'";
                    }
                    $sqlInsert = implode(', ', $sqlInsert);
                    
                    $sql = "INSERT INTO {$this->dataTable} SET {$sqlInsert}";
                    
                    // insert data
                    $this->fDB->query($sql);
                    $dataId = $this->fDB->getID();
                }
                
                // creating a place for the record being inserted
                $this->fDB->query("
                    UPDATE $this->structTable
                    SET 
                        `$this->left`  = IF(`$this->left`  >  $rightId, `$this->left`  + 2, `$this->left`),
                        `$this->right` = IF(`$this->right` >= $rightId, `$this->right` + 2, `$this->right`)
                    WHERE 
                        `$this->right` >= $rightId
                ");
                
                // insert structure
                $this->fDB->query("
                    INSERT INTO $this->structTable
                    SET                        
                        `$this->data_id` = $dataId,
                        `$this->left`    = $rightId,
                        `$this->right`   = $rightId+1,
                        `$this->level`   = $level+1
                ");
                $id = $this->fDB->getID();
                
                return $id;
            }
            $this->_displayError(NSTREE_ERROR_NODE_NOT_EXISTS, __LINE__, __FILE__, false);
            return false;
        }

            
        /**
        * Inserts a record into the table with nested sets
        *
        * @param  int $id
        * @param  array $data          
        * @return int
        */
        function appendSibling($id, $data = false, $dataId = false) {
            $id = intval($id);
            $dataId = intval($dataId);
            if (! is_array($data)) $data = array();
            
            if ($info = $this->getNodeInfo($id)) {
                $leftId  = $info['left'];
                $rightId = $info['right'];
                $level   = $info['level'];

                if (! $dataId) {
                    // preparing data to be inserted
                    foreach ($data as $n => $value)
                        $sqlInsert[] = "$n='".addslashes($value)."'";
                    $sqlInsert = implode(', ', $sqlInsert);
                    
                    $sql = "INSERT INTO {$this->dataTable} SET {$sqlInsert}";
                    
                    // insert data
                    $this->fDB->query($sql);
                    $dataId = $this->fDB->getID();
                }
                
                // creating a place for the record being inserted
                $this->fDB->query("
                    UPDATE $this->structTable 
                    SET
                        `$this->left`  = IF(`$this->left`  > $rightId, `$this->left`+2,  `$this->left`),
                        `$this->right` = IF(`$this->right` > $rightId, `$this->right`+2, `$this->right`)                         
                    WHERE 
                        `$this->right` > $rightId
                ");
                
                // insert structure
                $this->fDB->query("
                    INSERT INTO $this->structTable
                    SET                        
                        `$this->data_id` = $dataId,
                        `$this->left`  = $rightId+1,
                        `$this->right` = $rightId+2,
                        `$this->level` = $level
                ");
                
                $newId = $this->fDB->getID();
                
                return $newId;
            }
            $this->_displayError(NSTREE_ERROR_NODE_NOT_EXISTS, __LINE__, __FILE__, false);            
            return false;
        }
        
        
        /**
        * @deprecated 
        *
        * @param  int $id                
        * @param  int $level             
        * @param  string[] $additionalData    
        * @return array
        */
        function &selectNodes($id, $level=0, $additionalData) {
            return $this->select($id, $additionalData, NSTREE_AXIS_DESCENDANT_OR_SELF);
        }
        
        
        /**
        * ����������� ���� ������, � ������������ ����������� ���������. 
        *
        * @param string $titleField
        */
        function dump($titleField) {
            if (in_array($titleField, array($this->id, $this->left, $this->right, $this->level))) {
                $rsNodes = $this->fDB->getQueryRecordSet("
                    SELECT * FROM {$this->structTable}
                    ORDER BY `{$this->left}`
                ");
            } else {
                $rsNodes = $this->fDB->getQueryRecordSet("
                    SELECT s.*, d.{$titleField} AS title
                    FROM 
                        {$this->structTable} AS s
                    LEFT JOIN
                        {$this->dataTable} AS d ON s.`{$this->data_id}` = d.`{$this->id}`
                    ORDER BY `{$this->left}`
                ");
            }
            
            if ($this->fDB->getRowsCount()) {
                $indent = 16;
                foreach ($rsNodes as $node) {
                    if (! $node['title'])
                        if ($node[$this->left] == 1)
                            $node['title'] = '#root';
                        else 
                            $node['title'] = 'Unnamed node';
                    
                    // output node
                    ?>
                    <div style="padding-left:<?=($indent*$node[$this->level])?>px">
                        <?=$node['title']?>
                        (id:    <?=$node[$this->id]?>;
                         left:  <?=$node[$this->left]?>;
                         right: <?=$node[$this->right]?>;
                         level: <?=$node[$this->level]?>)</div>
                    <?php
                }
            }
        }


        /**
        * Assigns a node with all its children to another parent
        *
        * @param  int $id
        * @param  int $newParentId
        * @return bool
        */
        function replaceNode($id, $newParentId) { 
            if ($nodeInfo = $this->getNodeInfo($id)) {
                $parentInfo = $this->getParentNodeInfo($id);
                $newParentInfo = $this->getNodeInfo($newParentId);
                
                if ($newParentInfo && ($newParentInfo[$this->id] != $parentInfo[$this->id])) {
                    $leftId = $nodeInfo['left'];
                    $rightId = $nodeInfo['right'];
                    $level = $nodeInfo['level'];

                    $leftIdP = $newParentInfo['left'];
                    $rightIdP = $newParentInfo['right'];
                    $levelP = $newParentInfo['level'];
                    
                    // whether it is being moved upwards along the path
                    if ($leftIdP < $leftId && $rightIdP > $rightId && $levelP < $level - 1 ) { 
                        $sql = "
                            UPDATE $this->structTable
                            SET 
                                `$this->level` = IF(
                                    `$this->left` BETWEEN $leftId AND $rightId, 
                                    `$this->level` - ($level-$levelP-1),
                                    `$this->level`
                                ), 
                                `$this->right` = IF(
                                    `$this->right` BETWEEN ($rightId+1) AND ($rightIdP-1), 
                                    `$this->right` - ($rightId-$leftId+1), 
                                    IF(
                                        `$this->left` BETWEEN $leftId AND $rightId,
                                        `$this->right` + ($rightIdP-$rightId-1),
                                        `$this->right`
                                    )
                                ), 
                                `$this->left` = IF(`$this->left` BETWEEN ($rightId+1) AND ($rightIdP-1), 
                                    `$this->left`-($rightId-$leftId+1), 
                                    IF(
                                        `$this->left` BETWEEN $leftId AND $rightId, 
                                        `$this->left` + ($rightIdP-$rightId-1),
                                        `$this->left`
                                    )
                                ) 
                            WHERE 
                                `$this->left` BETWEEN ($leftIdP+1) AND ($rightIdP-1) 
                        ";
                    } elseif ($leftIdP < $leftId) {
                        $leveldelta = -($level-1)+$levelP;
                        $sql =  "
                            UPDATE $this->structTable 
                            SET 
                                `$this->level` = IF(
                                    `$this->left` BETWEEN $leftId AND $rightId,
                                    `$this->level`".(($leveldelta >= 0) ? "+" : "-").$leveldelta.", 
                                    `$this->level`
                                ), 
                                `$this->left` = IF(
                                    `$this->left` BETWEEN $rightIdP AND ($leftId-1),
                                    `$this->left` + ($rightId-$leftId+1), 
                                    IF(
                                        `$this->left` BETWEEN $leftId AND $rightId,
                                        `$this->left`-($leftId-$rightIdP),
                                        `$this->left`
                                    ) 
                                ), 
                                `$this->right` = IF(
                                    `$this->right` BETWEEN $rightIdP AND $leftId, 
                                    `$this->right`+($rightId-$leftId+1), 
                                    IF(
                                        `$this->right` BETWEEN $leftId AND $rightId, 
                                        `$this->right`-($leftId-$rightIdP),
                                        `$this->right`
                                    ) 
                                ) 
                            WHERE 
                                `$this->left` BETWEEN $leftIdP AND $rightId OR
                                `$this->right` BETWEEN $leftIdP AND $rightId                         
                        ";
                    } else {
                        $leveldelta = -($level-1)+$levelP;
                        $sql = "
                            UPDATE $this->structTable
                            SET
                                `$this->level` = IF(
                                    `$this->left` BETWEEN $leftId AND $rightId, 
                                    `$this->level`".(($leveldelta >= 0) ? "+" : "-").$leveldelta.",
                                    `$this->level`
                                ), 
                                `$this->left` = IF(
                                    `$this->left` BETWEEN $rightId AND $rightIdP, 
                                    `$this->left`-($rightId-$leftId+1), 
                                    IF(
                                        `$this->left` BETWEEN $leftId AND $rightId, 
                                        `$this->left`+($rightIdP-1-$rightId), 
                                        `$this->left`
                                    ) 
                                ), 
                                `$this->right` = IF(
                                    `$this->right` BETWEEN ($rightId+1) AND ($rightIdP-1), 
                                    `$this->right`-($rightId-$leftId+1), 
                                    IF(
                                        `$this->right` BETWEEN $leftId AND $rightId,
                                        `$this->right`+($rightIdP-1-$rightId),
                                        `$this->right`
                                    ) 
                                ) 
                            WHERE 
                                `$this->left` BETWEEN $leftId AND $rightIdP OR 
                                `$this->right` BETWEEN $leftId AND $rightIdP 
                        ";
                    } 
                    return $this->fDB->query($sql);
                }
            }
            $this->_displayError(NSTREE_ERROR_NODE_NOT_EXISTS, __LINE__, __FILE__, false);
            return false;
        }
        
        
        /**
        * @param int $id
        * @param $direction 
        *   NSTREE_AXIS_FOLLOWING_SIBLING
        *   NSTREE_AXIS_PRECENDING_SIBLING
        */
        function swapSiblings($id, $axis) {
            if ($siblingInfo = $this->getSiblingInfo($id, $axis)) {
                $leftIdS = $siblingInfo['left'];
                $rightIdS = $siblingInfo['right'];
                
                $nodeInfo = $this->getNodeInfo($id);
                $leftId = $nodeInfo['left'];
                $rightId = $nodeInfo['right'];
                
                $deltaS = $rightIdS - $leftIdS + 1;
                $delta = $rightId - $leftId + 1;
                
                if ($axis == NSTREE_AXIS_FOLLOWING_SIBLING) {
                    $sql = "
                        UPDATE $this->structTable
                        SET
                            `$this->left` = IF(
                                `$this->left` BETWEEN $leftId AND $rightId,
                                `$this->left` + $deltaS,
                                `$this->left` - $delta
                            ),
                            `$this->right` = IF(
                                `$this->right` BETWEEN $leftId AND $rightId,
                                `$this->right` + $deltaS,
                                `$this->right` - $delta
                            )
                        WHERE `$this->left` BETWEEN $leftId AND $rightIdS
                    ";
                } else {
                    $sql = "
                        UPDATE $this->structTable
                        SET
                            `$this->left` = IF(
                                `$this->left` BETWEEN $leftIdS AND $rightIdS,
                                `$this->left` + $delta,
                                `$this->left` - $deltaS
                            ),
                            `$this->right` = IF(
                                `$this->right` BETWEEN $leftIdS AND $rightIdS,
                                `$this->right` + $delta,
                                `$this->right` - $deltaS
                            )
                        WHERE `$this->left` BETWEEN $leftIdS AND $rightId                            
                    ";
                }
                
                return $this->fDB->query($sql);
            }
            return false;
        }
        
        
        function getSiblingInfo($id, $axis) {
            if ($axis == NSTREE_AXIS_FOLLOWING_SIBLING)
                return $this->getFollowingSiblingInfo($id);
            elseif ($axis == NSTREE_AXIS_PRECENDING_SIBLING)
                return $this->getPrecendingSiblingInfo($id);
            return false;
        }
        
        
        /**
        * @param int $id
        * @return array
        */
        function getFollowingSiblingInfo($id) {
            return $this->getFollowingSibling($id, array());
        }
        
        
        /**
        * @param int $id
        * @return array
        */
        function getPrecendingSiblingInfo($id) {
            return $this->getPrecendingSibling($id, array());
        }
        
        
        /**
        * @param  int $id
        * @param  string[] $additionalData  
        * @return array
        */
        function getFollowingSibling($id, $additionalData) {
            $nodeSet = $this->select($id, $additionalData, NSTREE_AXIS_FOLLOWING_SIBLING, 1);
            if (! empty($nodeSet))
                return array_shift($nodeSet);
            return false;
        }
        

        /**
        * @param  int $id
        * @param  string[] $additionalData  
        * @return array
        */
        function getPrecendingSibling($id, $additionalData) {
            $nodeSet = $this->select($id, $additionalData, NSTREE_AXIS_PRECENDING_SIBLING, 1, "$this->left DESC");
            if (! empty($nodeSet))
                return array_shift($nodeSet);
            return false;
        }
        
        
        /**
        * @param  int $id
        * @param  int $destinationId
        * @return bool
        */
        function replaceSiblings($nodeId, $destinationId = 0) {
            if ($nodeInfo = $this->getNodeInfo($nodeId)) {
                if (!$destinationId) { 
                    return $this->swapSiblings($nodeId, NSTREE_AXIS_PRECENDING_SIBLING);
                }
                
                $nodeParentInfo = $this->select($nodeId, array(), NSTREE_AXIS_PARENT);

                $destinationParentInfo = $this->select($destinationId, array(), NSTREE_AXIS_PARENT);
                
                $destinationInfo = $this->getNodeInfo($destinationId);
                if ($destinationInfo['id'] != $nodeInfo['id'] 
                		&& count($nodeParentInfo) && count($destinationParentInfo) 
                		&& $nodeParentInfo[0]['id'] == $destinationParentInfo[0]['id']) {

                    $leftId  = $nodeInfo['left'];
                    $rightId = $nodeInfo['right'];

                    $leftIdB  = $destinationInfo['left'];
                    $rightIdB = $destinationInfo['right'];
                			
					$sql = "UPDATE 
								$this->structTable
							SET
								`$this->left` = $leftIdB,
								`$this->right` = $rightIdB
							WHERE 
								id = ".$nodeInfo['id'];
					
					$this->fDB->query($sql);
					
					$sql = "UPDATE 
								$this->structTable
							SET
								`$this->left` = $leftId,
								`$this->right` = $rightId
							WHERE 
								id = ".$destinationInfo['id'];
					
					$this->fDB->query($sql);
					
                }                 
            }
        }
        
        /**
        * �������� ���� ������. 
        * ����� ������ ������������ ���� ��������� $id. $axis ����� ��������� ��������� ��������:
        *
        * NSTREE_AXIS_CHILD                 ��� �������� �������� ������� ����
        * NSTREE_AXIS_DESCENDANT            ��� �������
        * NSTREE_AXIS_DESCENDANT_OR_SELF    ��� ������� � ��� ����
        * NSTREE_AXIS_PARENT                ������������ ������� ����
        * NSTREE_AXIS_ANCESTOR              ��� ������
        * NSTREE_AXIS_ANCESTOR_OR_SELF      ��� ������ � ��� ����
        * NSTREE_AXIS_SELF                  ��� ����
        * NSTREE_AXIS_LEAF                  ��� ������ (�������� �� ������� ��������)
        *
        *
        * @param int $id                 
        * @param array $additionalData
        * @param int $axis
        * @param int $amount
        * @return array
        */
        function select($id, $additionalData, $axis, $amount = null, $order = "") {
            $id = (int) $id;
            $sqlIdent = $id ? "s%d.$this->id = $id" : "s%d.$this->left = 1";
            
            $sqlAdvSelect = "";
            if (is_array($additionalData) && (! empty($additionalData))) {
                foreach ($additionalData as $k => $name) 
                    $additionalData[$k] = "d.$name";
                $sqlAdvSelect = implode(',', $additionalData);
                unset($additionalData);
            }
         
            $sqlSelect = "
                SELECT
                s1.`$this->id`       AS `id`,
                s1.`$this->data_id`  AS `data_id`,
                s1.`$this->left`     AS `left`,
                s1.`$this->right`    AS `right`,
                s1.`$this->level`    AS `level`,
                IF(s1.`$this->left` = s1.`$this->right`-1, '0', '1') AS `has_children`
            ";
            if ($axis == NSTREE_AXIS_SELF) {
                $sqlIdent = sprintf($sqlIdent, 1);
                $sqlFrom = "
                    FROM $this->structTable AS s1 ".
                    ($sqlAdvSelect ? "LEFT JOIN $this->dataTable AS d ON s1.`$this->data_id` = d.`$this->id`" : "");
                $sqlWhere = "
                    WHERE $sqlIdent
                ";
            } else {
                $sqlIdent = sprintf($sqlIdent, 2);
                $sqlFrom = "
                    FROM $this->structTable AS s1
                    INNER JOIN $this->structTable AS s2 ON (%s) ".
                    ($sqlAdvSelect ? "LEFT JOIN $this->dataTable AS d ON s1.`$this->data_id` = d.`$this->id`" : "");
                $sqlWhere = "
                    WHERE $sqlIdent
                ";
            }
            
            $stmts = array();
                
            switch ($axis) {
                case NSTREE_AXIS_CHILD:
                case NSTREE_AXIS_LEAF:
                case NSTREE_AXIS_DESCENDANT:
                case NSTREE_AXIS_DESCENDANT_OR_SELF:
                    if ($axis == NSTREE_AXIS_CHILD) {
                        $stmts[] = "s1.`$this->level` = s2.`$this->level`+1";
                	}
                    if ($axis == NSTREE_AXIS_LEAF) {
                        $stmts[] = "s1.`$this->left` = s1.`$this->right` - 1";
                    }
                    if ($axis == NSTREE_AXIS_DESCENDANT_OR_SELF) {
                    	$stmts[] = "(s1.`$this->left` BETWEEN s2.`$this->left` AND s2.`$this->right`)";
                    }
                    else {
                    	$stmts[] = "s1.`$this->left` > s2.`$this->left` AND s1.`$this->right` < s2.`$this->right`";
                    }

                    break;
                
                case NSTREE_AXIS_PARENT:
                	$stmts[] = "s1.`$this->level` = s2.`$this->level`-1";
                    
                case NSTREE_AXIS_ANCESTOR:
                case NSTREE_AXIS_ANCESTOR_OR_SELF:
                    if ($axis == NSTREE_AXIS_ANCESTOR_OR_SELF) {
                    	$stmts[] = "s1.`$this->left` <= s2.`$this->left` AND s1.`$this->right` >= s2.`$this->right`";
                	}
                    else {
                    	$stmts[] = "s1.`$this->left` < s2.`$this->left` AND s1.`$this->right` > s2.`$this->right`";
                    }
                        
                    break;
                
                case NSTREE_AXIS_FOLLOWING_SIBLING:
                case NSTREE_AXIS_PRECENDING_SIBLING:
                    if ($parentInfo = $this->getParentNodeInfo($id)) {
                    	$stmts[] = "s2.`$this->level` = s1.`$this->level`";
                        $stmts[] = "s1.`$this->left` > {$parentInfo['left']}";
                        $stmts[] = "s1.`$this->right` < {$parentInfo['right']}";
                        
                        if ($axis == NSTREE_AXIS_FOLLOWING_SIBLING) {
                        	$stmts[] = "s1.`$this->left` > s2.`$this->right`";
                        }
                        elseif ($axis == NSTREE_AXIS_PRECENDING_SIBLING) {
                        	$stmts[] = "s1.`$this->right` < s2.`$this->left`";
                        }
                    } else return false;
                    
                    break;
            }
         
            if ($stmts) {
            	$sqlFrom = sprintf($sqlFrom, join(' AND ', $stmts));
            }
            
            $sql = $sqlSelect . ($sqlAdvSelect ? ", $sqlAdvSelect" : "") . $sqlFrom . $sqlWhere;
            $sql .= " ORDER BY s1." . ($order ? $order : $this->left);
            
            if (! is_null($amount))
                $sql .= " LIMIT " . intval($amount);
                
            //echo $sql."<br><br>";

            $rsNodes = $this->fDB->getQueryRecordSet($sql);

            return $rsNodes;
        } 


        /**
        * Removing tree nodes
        *
        * @param  int $id
        * @param  bool $removeChildren
        * @return bool
        */
        function removeNodes($id, $removeChildren = true) {
            if ($info = $this->getNodeInfo($id)) {
                $leftId = $info['left'];
                $dataId = $info['data_id'];
                $rightId = $info['right'];
                $level = $info['level'];
    
                if ($removeChildren) {
                    $childIds = array();
                    
                    $childIds = $this->fDB->getQueryColumn("
                        SELECT `$this->id` AS `id`
                        FROM $this->structTable
                        WHERE `$this->left` BETWEEN $leftId AND $rightId
                    ", "id");                    
                    
                    $childDIds = $this->fDB->getQueryColumn("
                        SELECT t2.`$this->data_id` AS `data_id` FROM $this->structTable AS t1
                        LEFT JOIN $this->structTable AS t2 ON t1.`$this->id` = t2.`$this->id` AND t2.`$this->left` BETWEEN $leftId AND $rightId
                        GROUP BY t1.`$this->data_id` HAVING SUM( IF(t2.`$this->data_id` IS NULL , 1, 0) ) = 0 
                    ", "data_id");                    
                    
                    if (! empty($childDIds)) {
                        $child = implode(',', $childDIds);
                        
                        // Deleting record(s)
                        $this->fDB->query("
                            DELETE FROM $this->dataTable 
                            WHERE `$this->id` IN ($child)
                        ");
                    }
                    
                    if (! empty($childIds)) {
                        $child = implode(',', $childIds);
                        
                        // Deleting record(s)
                        $this->fDB->query("
                            DELETE FROM $this->structTable 
                            WHERE `$this->id` IN ($child)
                        ");
                        
                        // Clearing blank spaces in a tree
                        $deltaId = ($rightId - $leftId) + 1;
                        return $this->fDB->query("
                            UPDATE $this->structTable
                            SET 
                                `$this->left` = IF(
                                    `$this->left` > $leftId,
                                    `$this->left` - $deltaId,
                                    `$this->left`
                                ),
                                `$this->right` = IF(
                                    `$this->right` > $leftId,
                                    `$this->right` - $deltaId,
                                    `$this->right`
                                )
                            WHERE `$this->right` > $rightId 
                        ");
                    }
                    return false;
                } else {
                    $child = $this->fDB->getQueryRecord("
                        SELECT t2.`$this->data_id` AS `data_id` FROM $this->structTable AS t1
                        LEFT JOIN $this->structTable AS t2 ON t1.`$this->id` = t2.`$this->id` AND t2.`$this->id` = '$id'
                        GROUP BY t1.`$this->data_id` HAVING SUM( IF(t2.`$this->data_id` IS NULL , 1, 0) ) = 0 
                    ");
                    if ($this->fDB->getRowsCount()) {                                                 
                        $this->fDB->query("DELETE FROM $this->dataTable WHERE `$this->id` = {$child['data_id']}");
                    }
                    $this->fDB->query("DELETE FROM $this->structTable WHERE `$this->id` = $id");
                    
                    return $this->fDB->query("
                        UPDATE $this->structTable
                        SET
                            `$this->left` = IF(
                                `$this->left` BETWEEN $leftId AND $rightId,
                                `$this->left`-1,
                                `$this->left`
                            ),
                            `$this->right` = IF(
                                `$this->right` BETWEEN $leftId AND $rightId,
                                `$this->right`-1,
                                `$this->right`
                            ),
                            `$this->level` = IF(
                                `$this->left` BETWEEN $leftId AND $rightId,
                                `$this->level`-1,
                                `$this->level`
                            ),
                            `$this->left` = IF(
                                `$this->left` > $rightId,
                                `$this->left`-2,
                                `$this->left`),
                            `$this->right` = IF(
                                `$this->right` > $rightId,
                                `$this->right`-2,
                                `$this->right`
                            )
                        WHERE `$this->right` > $leftId
                    ");
                }
            }
            $this->_displayError(NSTREE_ERROR_NODE_NOT_EXISTS, __LINE__, __FILE__, false);
            return false;
        }

        /**
        * Returns all child nodes that has no childs
        *
        * @param  int $id
        * @param  string[] $additionalData           
        * @return array
        */
        function enumLeafs($id, $additionalData = array()) {
            return $this->select($id, $additionalData, NSTREE_AXIS_LEAF);
        }
        
        /**
        * Returns all child nodes
        *
        * @param  int $id
        * @param  string[] $additionalData           
        * @return array
        */
        function getChildNodes($id, $additionalData = array()) {
            return $this->select($id, $additionalData, NSTREE_AXIS_CHILD);
        }        
        
        /**
        * Returns get siblings
        *
        * @param  int $id
        * @return array
        */
        function getSiblings($id, $additionalData) {
        	$nodeParent = $this->getParentNode($id, $additionalData);
            return $this->getChildNodes($nodeParent['id'], $additionalData);
        }        

        /**
        * @param  int $id
        * @param  string[] $additionalData
        * @return bool
        */        
        function getBranch($id, $additionalData = array()) {
        	$nodeSet = $this->select($id, $additionalData, NSTREE_AXIS_ANCESTOR);
        	$nodeSet[] = $this->getNode($id, $additionalData);
            if (!empty($nodeSet)) {
                return $nodeSet;
            }
            return false;
        }
        
        
        /**
        * @param  int $id
        * @return bool
        */        
        function getNodeFamily($nodeId, $additionalData = array()) {
        	$nodeSet = array();
        	$nodeBranch = $this->getBranch($nodeId, $additionalData);
        	
        	foreach ($nodeBranch as $node) {
        		if ($node['level'] != 0) {
	        		$nodeSiblings = $this->getSiblings($node['id'], $additionalData);
	        		for ($i = 0; $i < count($nodeSiblings); $i++) {
	        			if ($nodeSiblings[$i]['id'] == $node['id']) {
	        				$nodeSiblings[$i]['is_ancestor_branch'] = true;
	        			} else {
	        				$nodeSiblings[$i]['is_ancestor_branch'] = false;
	        			}	
	        		}
	        		$nodeSet[] = $nodeSiblings;
        		} else {
        			$node['in_parent_branch'] = true;
        			$nodeSet[] = array($node);	
        		}
        	}
        	$childNodes = $this->getChildNodes($nodeId, $additionalData);
        	for ($i = 0; $i < count($childNodes); $i++) {
        		$childNodes[$i]['is_ancestor_branch'] = false;
        	}
        	$nodeSet[] = $childNodes; 
        	return $nodeSet;
        }
        
    }
    
?>
<?php/*
MultipleEntity.class.php v0.3 2008/07/23
by Vladimir Kalenyuk [v.kalenyuk@ziost.com]

*/
class MultipleEntity
{

var $db;
var $name;
var $tablesMap;
var $debug;
var $errors;
var $sql;

function MultipleEntity(&$db, $tablesMap, $name='Multiple entity'){		$this->errors=array();
		$this->db=&$db;
		$this->name=$name;
		$this->tablesMap=$tablesMap;
		$this->debug=false;
		return true;	}
function initialize(){
		$result=true;
		if(!empty($this->tablesMap)){			foreach($this->tablesMap as $key => $name){
				$this->sql="SELECT * FROM " . addslashes($name) . " WHERE 1=42";
				$result=$result && $this->db->query($this->sql);			}

			if(!$result) $this->errors[]="One or more of entity tables is not exist";
			return $result;		}
		else{			$this->errors[]="Entities tables list is empty";
			return false;		}	}

function getByID($id, $entityKey){
		if(empty($id) || (intval($id)<1)){
			$this->errors[]=$entityKey." id not set or not numeric";
			return false;
		}

		$this->sql="SELECT * FROM ".addslashes($this->tablesMap[$entityKey])." WHERE id=".intval($id);

		$this->debugPoint();

		if ($this->db->query($this->sql)){
			return $this->db->getRecord();
		}
		else{
			$this->errors[]=$entityKey." with specified id not found";
			return false;
		}
	}
function getByToken($token, $entityKey){		if(!is_string($token) || (strlen($token)<1)){			$this->errors[]=$entityKey." token not set or not string";			return false;		}			$this->sql="SELECT * FROM ".addslashes($this->tablesMap[$entityKey])." WHERE token='".addslashes($token)."'";			$this->debugPoint();			if ($this->db->query($this->sql)){			return $this->db->getRecord();		}		else{			$this->errors[]=$entityKey." with specified token not found";			return false;		}	}
function checkEntityExists($parameters=array(), $entityKey, $id=0){		$where=" WHERE 1=1 ";
		foreach($parameters as $k => $v){			$where.=" AND ".addslashes($k)."='".addslashes($v)."'";
		}				if(intval($id) > 0){			$where.=" AND id <> ".intval($id);		}

		$this->sql="SELECT COUNT(*) as cnt FROM ".addslashes($this->tablesMap[$entityKey]).$where;

		$this->debugPoint();

		return $this->db->getQueryField($this->sql);
	}
function checkTokenExists($id, $token, $entityKey){		$params = array();		$params['token'] = $token;		return $this->checkEntityExists($params, $entityKey, $id);	}

function updateByID($id, $parameters=array(), $entityKey){
		if(!empty($id) && (intval($id)>0)){
			$this->sql="SELECT COUNT(*) FROM  ".addslashes($this->tablesMap[$entityKey])." WHERE id=".intval($id);

			if($this->db->getQueryField($this->sql)){				$this->sql="UPDATE ".addslashes($this->tablesMap[$entityKey])." SET ";
				$param=array();
				foreach($parameters as $k=>$v){					if(!is_array($v)) {
						$param[]="{$k} = '".addslashes($v)."' ";
					}
					else {
						$param[]="{$k} = ".addslashes($v['as_is'])." ";
					}				}

				$this->sql.=join(', ', $param)." WHERE id=".intval($id);

				$this->debugPoint();

				return $this->db->query($this->sql);			}
			else{
				$this->errors[]=$entityKey." with specified id not found";
				return false;
			}
		}
		else{			$this->errors[]=$entityKey." id not set or not numeric";
			return false;		}
	}


function add($parameters=array(), $entityKey){
		$this->sql="INSERT INTO ".addslashes($this->tablesMap[$entityKey])." (";

		$param=array();

		foreach($parameters as $k=>$v){
			$param[]="{$k}";
		}

		$this->sql.=join(', ', $param).") VALUES (";

		$param=array();

		foreach($parameters as $k=>$v){
			if(!is_array($v)) {
				$param[]="'".addslashes($v)."'";
			}
			else {
				$param[]=addslashes($v['as_is']);
			}
		}

		$this->sql.=join(', ', $param).")";

		$this->debugPoint();

		if($this->db->query($this->sql)) return $this->db->getID();
		else{			$this->errors[]=$entityKey." not added due to DB error";
			return false;
		}
	}


function deleteByID($id, $entityKey){
		if(empty($id) || (intval($id)<1)){
			$this->errors[]=$entityKey." id not set";
			return false;
		}

		$this->sql="DELETE FROM ".addslashes($this->tablesMap[$entityKey])." WHERE id=".intval($id);

		$this->debugPoint();

		return $this->db->query($this->sql);
	}

function deleteByIDs($ids, $entityKey){
		if(!is_numeric($ids) && (!is_array($ids))){
			$this->errors[]=$entityKey." ids not set";
			return false;
		}

		$this->sql="DELETE FROM ".addslashes($this->tablesMap[$entityKey])." WHERE id IN(".addslashes(join(', ', $ids).")");				$this->debugPoint();		
		return $this->db->query($this->sql);
	}

function getAll($filter=array(), $sort, $order, $limit=0, $count=0, $entityKey){
		$this->sql="SELECT * FROM  ".addslashes($this->tablesMap[$entityKey])." WHERE 1=1 ";

		if(!empty($filter)&&is_array($filter)){			foreach($filter as $k => $v){				$this->sql.=" AND ".addslashes($k)."='".addslashes($v)."'";			}		}

		$this->sql.=" ORDER BY ".addslashes($sort)." ".addslashes($order);

		if($count && $limit){			$this->sql.=" LIMIT ".intval($limit).", ".intval($count);		}
		elseif($count){			$this->sql.=" LIMIT ".intval($count);
		}

		$this->debugPoint();

		if ($this->db->query($this->sql)){
			return $this->db->getRecordSet();
		}
		else{
			$this->errors[]=$entityKey."(s) not found";
			return null;
		}
	}

function getCount($filter=array(), $entityKey){
		$this->sql="SELECT COUNT(*) FROM ".addslashes($this->tablesMap[$entityKey])." WHERE 1=1 ";
		if(!empty($filter)){
			foreach($filter as $k => $v){
				$this->sql.=" AND ".addslashes($k)."='".addslashes($v)."'";
			}
		}

		$this->debugPoint();

		return $this->db->getQueryField($this->sql);
	}

function getLastError(){
		if(count($this->errors)) return $this->errors[count($this->errors)-1];
		else return null;
	}

function getErrors(){
		if(count($this->errors)) return $this->errors;
		else return null;
	}

function getErrorsCount(){
		return count($this->errors);
	}function debug($flag=true){		$this->debug = (bool) $flag;				}function debugPoint(){		if($this->debug) echo '<br><pre>'.$this->sql.'</pre>';	}
}
?>
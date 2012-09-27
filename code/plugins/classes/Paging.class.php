<?php

class Paging {
	
	var $fPageSize;
	var $fRecordCount;
	var $fPagesCount;
	var $fCurrentPage;
	var $fLinkFormat;

    function Paging($pagesize, $recordcount, $currentpage) {
    	$this->fRecordCount = (int) $recordcount;
    	if($this->fRecordCount < 0){
    		$this->fRecordCount = abs($this->fRecordCount);;
    	}
    	
    	$this->fPageSize = (int) $pagesize;
    	if($this->fPageSize < 0){
    		$this->fPageSize = abs($this->fPageSize);
    	}
    	if($this->fPageSize == 0){
    		$this->fPageSize = $this->fRecordCount;
    	}
    	
    	$this->fPagesCount = ceil($this->fRecordCount / $this->fPageSize);
		$this->fCurrentPage = (int) $currentpage;
		if ($this->fCurrentPage > $this->fPagesCount){
			$this->fCurrentPage = $this->fPagesCount;
		}elseif($this->fCurrentPage < 1){
			$this->fCurrentPage = 1;
		}
		$this->fLinkFormat = "%d";
    }
    
    function getCurrentPage(){
    	return (int) $this->fCurrentPage;
    }
    
    function getOffSet($page = 0){
    	$page = (int) $page;
    	if ($page == 0){ 
    		$page = $this->getCurrentPage();
    	}
    	return ($page - 1) * $this->getPageSize();
    }
    
    function getPageSize(){
    	return (int) $this->fPageSize;
    }
    
    function getPagesCount(){
    	return (int) $this->fPagesCount;
    }
    
    function getLinkFormat(){
    	return $this->fLinkFormat;
    }
    
    function getPages(){
    	$pages = array();
    	for($i = 1; $i <= $this->getPagesCount(); $i++){
    		$pages[$i] = sprintf($this->getLinkFormat(), $i);
    	}
    	return $pages;
    }
    
    function setCurrentPage($page){
    	$page = (int) $page;
    	if($page <= $this->fPagesCount){
    		return $this->fCurrentPage = $page;
    	}else{
    		return false;
    	}
    }
    
    function setLinkFormat($format){
    	$this->fLinkFormat = $format;
    }
    
}
?>
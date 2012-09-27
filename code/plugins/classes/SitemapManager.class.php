<?php

class SitemapManager extends MultipleEntity
{

	var $maxItemsCount = 50000;

function SitemapManager(
							&$db,
							$tablesMap=array(),
							$name='SitemapManager'
							)
	{
		return parent::MultipleEntity($db, $tablesMap, $name);
	}

function addItem($item){
		if($this->getItemsCount(array()) >= $this->maxItemsCount){
			$this->errors[]="Sitemap sizes limit exceed: {$this->maxItemsCount} Items max";
			return false;
		}

		return $this->add($item, 'sitemap');
	}

function updateItemByID($id, $item){		$oldItem = $this->getItemByID($id);
		if(empty($oldItem)){
			$this->errors[]="Item not found";
			return false;
		}

		return $this->updateByID($id, $item, 'sitemap');
	}

function getItemByID($id){
		return $this->getByID($id, 'sitemap');;
	}

function deleteItemByID($id){
		$oldItem = $this->getItemByID($id);
		if(empty($oldItem)){
			$this->errors[]="Item not found";
			return false;
		}

		if(!$this->deleteByID($id, 'sitemap')){
			$this->errors[]="Cannot delete Item. DB error";
			return false;
		}

		return true;
	}

function getItems($filter=array(), $sort='url', $order='asc', $limit=0, $count=0){
		return $this->getAll($filter, $sort, $order, $limit, $count, 'sitemap');
	}

function getItemsCount($filter=array()){
		return $this->getCount($filter, 'sitemap');
	}

}
?>
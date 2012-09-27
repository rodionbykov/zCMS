<?php

    $attributes['order'] = empty($attributes['order']) ? "name" : $attributes['order'];
    $attributes['pagesize'] = empty($attributes['pagesize']) ? $oSettingsManager->getValue("AdminTableSize", 25, "INT", "Number of elements in tables of administrator backend") : (int) $attributes['pagesize'];
    $attributes['page'] = empty($attributes['page']) ? 1 : (int) $attributes['page'];
    
    if(!isset($attributes['sort'])){
        $attributes['sort'] = "DESC";
    }else{
        if(!in_array($attributes['sort'], array("ASC", "DESC"))){
            $attributes['sort'] = "DESC";
        }
    }
    
    $attributes['asort'] = ($attributes['sort'] == "ASC") ? "DESC" : "ASC";
    
    $sql = "SELECT COUNT(DISTINCT p.id) AS cnt 
            FROM " . $fusebox['tableFuseactions'] . " p 
                INNER JOIN " . $fusebox['tableGraphicsTokens'] . " ct 
                    ON p.id = ct.id_fuseaction"; 
            
    $numPages = $oDB->getQueryField($sql);
    
    $oPaging = new Paging($attributes['pagesize'], $numPages, $attributes['page']);
    $oPaging->setLinkFormat($here . "&page=%d");
    
    $arrPageSizes = array(10, 25, 50, 100, 200);

    $sql = "SELECT DISTINCT p.id, p.name, p.description, p.is_devonly 
            FROM " . $fusebox['tableFuseactions'] . " p 
                INNER JOIN " . $fusebox['tableGraphicsTokens'] . " ct 
                    ON p.id = ct.id_fuseaction 
            ORDER BY " . $attributes['order'] . " " . $attributes['sort'] . " LIMIT " . $oPaging->getOffSet() . ", " . $oPaging->getPageSize();;
            
    $arrGraphicsPages = $oDB->getQueryRecordSet($sql);

?>

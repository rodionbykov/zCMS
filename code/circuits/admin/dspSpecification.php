<?

if($arrFuseactions = $oFuseManager->getFuseactions()){
        _assign("arrFuseactions", $arrFuseactions);
    }else{
        _error("ECannotGetFuseactions", "Cannot retrieve fuseactions from DB");
    }
    
    _display("admin/dspSpecification.tpl");

?>
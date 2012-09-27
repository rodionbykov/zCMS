<?php
	
	$arrAllArticles = $ogArticleManager->pullTokens(0, "", "id", "DESC");
  
    $oFeedWriter = new FeedWriter(RSS2);

    $oFeedWriter->setTitle($ogContentManager->getContent("RSSTitle", "Site RSS Feed"));

    $oFeedWriter->setLink($ogContentManager->getContent("RSSLink", $fusebox['urlBase']));

    $oFeedWriter->setDescription("RSSDescription", "Site RSS Feed Description");

    $oFeedWriter->setImage($ogContentManager->getContent("RSSTitle", "Site RSS Feed"), $ogContentManager->getContent("RSSLink", "Site RSS Link"), $fusebox['urlAssets'] . 'images/rss.png'); 

    foreach($arrAllArticles as $a) {

        $oItem = $oFeedWriter->createNewItem();

        $oItem->setTitle($ogArticleManager->getTitle($a['token']));

        $oItem->setLink($fusebox['urlBase'] . $a['token'] . ".page");

        $oItem->setDate($ogArticleManager->getCreatedDate($a['token']));

        $oItem->setDescription($ogArticleManager->getContent($a['token']));

        $oFeedWriter->addItem($oItem);

    }


  $oFeedWriter->genarateFeed();

?>
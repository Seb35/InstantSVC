<?php
include(dirname(__FILE__).'/config.php');
require_once(dirname(__FILE__).'/libs/class.tags.php');
require_once(dirname(__FILE__).'/libs/class.bookmarks.php');

//$ids = Tags::getInstance()->getIds(array('aAaaa', 'dsd', 'dss'));
//var_dump($ids);

$bookmark = Bookmarks::getInstance()->addBookmark('test', new Bookmark());
//$bookmark = Bookmarks::getInstance()->getBookmark(22);
//var_dump($bookmark);
?>
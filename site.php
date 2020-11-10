<?php 

use \Ecommerce\PageAdmin;

$app->get('/', function() {
    
	$page = new Page();
	$page->setTpl("index");

});

 ?>
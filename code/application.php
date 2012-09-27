<?php
	// put here your code that supposed to be run before each call
	// need to have this line in your .htaccess
	// php_value auto_prepend_file "/home/site/public_html/application.php"
	
	// checking if not index.php is called and redirecting user
	/*
	if (!preg_match("/index\.php$/i" , $_SERVER['SCRIPT_NAME'] ) ) {
		header( 'Location: index.php' );
		exit();
	}
	*/
	
?>
<?php /*
	Plugin Name: Bram Willemse Setup
	Plugin URI: https://www.bramwillemse.nl
	Description: Sets up custom WordPress architecture for Bram Willemse
	Version: 0.4.1
	Author: Bram Willemse
	Author URI: http://www.bramwillemse.nl
	Tested up to: 4.6.1
*/

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require __DIR__ . '/vendor/autoload.php';
}

$siteSetup = new siteSetup();
$postTypes = new postTypes();
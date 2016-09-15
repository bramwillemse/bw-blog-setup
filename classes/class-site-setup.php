<?php
class siteSetup { 

	# Constructor, uses hooks to integrate functionalities into WordPress
	public function __construct() {			
		# Remove items from dashboard menu
		add_action( 'admin_menu', array( &$this, 'remove_menu_items' )); 

		# Remove sub items from dashboard menu
		add_action( 'admin_menu', array( &$this, 'remove_submenu_items'), 999 );

		# Remove items in admin toolbar
		add_action( 'wp_before_admin_bar_render', array( &$this, 'remove_admin_bar_items' ));

		# Rearrange the admin menu
		add_filter('custom_menu_order', array(&$this, 'custom_menu_order')); 
		add_filter('menu_order', array(&$this, 'custom_menu_order'));

		# Change Menu item titles
		// add_action( 'admin_menu', array(&$this, 'edit_admin_menus' ));  
	}

	# Remove items admin menu
	public function remove_menu_items () {
		global $menu;
		$restricted = array(
			// __('Dashboard'),
			__('Posts'), 
			// __('Media'), 
			// __('Links'), 
			// __('Pages'), 
			// __('Appearance'), 
			// __('Tools'), 
			// __('Users'), 
			// __('Settings'),
			__('Comments')
			// __('Plugins')
		);
		end ($menu);
		while (prev($menu)){
			$value = explode(' ',$menu[key($menu)][0]);
			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
		}
	}

	# Remove items admin submenu
	public function remove_submenu_items() {
		$page = remove_submenu_page( 'themes.php', 'widgets.php' ); // remove widgets from themes submenu
		// $page[0] is the menu title
		// $page[1] is the minimum level or capability required
		// $page[2] is the URL to the item's file
	}

	# Remove items from admin toolbar
	public function remove_admin_bar_items() {
        global $wp_admin_bar;
       
        $wp_admin_bar->remove_menu('wp-logo'); /* Remove WordPress Logo */
        $wp_admin_bar->remove_menu('comments'); /* Remove 'Add New > Comments' */
        $wp_admin_bar->remove_menu('new-post'); /* Remove 'Add New > Posts' */
		$wp_admin_bar->remove_node( 'new-post' );
		$wp_admin_bar->remove_node( 'new-link' );
		$wp_admin_bar->remove_node( 'new-media' );
	}

	# Rearrange the admin menu
	public function custom_menu_order($menu_ord) {
		if (!$menu_ord) return true;
		return array(
			'index.php', // Dashboard
			'separator1', // First separator
			'edit.php?post_type=page' // Pages
		);
	}

	# Change Menu item titles
	public function edit_admin_menus() {  
	    global $menu;  
	      
	    $menu[10][0] = 'Images &amp; Docs'; // Change Media to Images
	}
}
?>
<?php
class postTypes {

	/**
	 * Constructor, uses hooks to integrate functionalities into WordPress
	 */
	public function __construct() {
		add_action( 'init', array( &$this, 'websites_post_type' ), 0 );
		
		add_filter( 'request', array( &$this, 'my_custom_archive_order'), 0 );
		add_filter('nav_menu_css_class', array( &$this, 'theme_current_type_nav_class'), 1, 2);
		add_action( 'admin_head', array( &$this, 'post_type_icons') );

	}

	// Register Custom Post Type 'Websites' / 'websites'
	public function websites_post_type() {

		$labels = array(
			'name'                => _x( 'Websites', 'Post Type General Name', 'text_domain' ),
			'singular_name'       => _x( 'Website', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'           => __( 'Websites', 'text_domain' ),
			'parent_item_colon'   => __( 'HoofdWebsite:', 'text_domain' ),
			'all_items'           => __( 'Alle Websites', 'text_domain' ),
			'view_item'           => __( 'Bekijk Website', 'text_domain' ),
			'add_new_item'        => __( 'Website toevoegen', 'text_domain' ),
			'add_new'             => __( 'Nieuwe toevoegen', 'text_domain' ),
			'edit_item'           => __( 'Website aanpassen', 'text_domain' ),
			'update_item'         => __( 'Website bijwerken', 'text_domain' ),
			'search_items'        => __( 'Website zoeken', 'text_domain' ),
			'not_found'           => __( 'Niet gevonden', 'text_domain' ),
			'not_found_in_trash'  => __( 'Niet gevonden in prullenbak', 'text_domain' ),
		);
		$args = array(
			'label'               => __( 'websites', 'text_domain' ),
			'rewrite' 			  => array('slug' => 'websites'),
			'description'         => __( 'Websites post type', 'text_domain' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', ),
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'           => '',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);
		register_post_type( 'websites', $args );

	}

	// Register Custom Post Type 'Team'
	public function team_post_type() {

		$labels = array(
			'name'                => _x( 'Team', 'Post Type General Name', 'text_domain' ),
			'singular_name'       => _x( 'Teamlid', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'           => __( 'Teamleden', 'text_domain' ),
			// 'parent_item_colon'   => __( 'Hoofd:', 'text_domain' ),
			'all_items'           => __( 'Alle Teamleden', 'text_domain' ),
			'view_item'           => __( 'Bekijk teamlid', 'text_domain' ),
			'add_new_item'        => __( 'Teamlid toevoegen', 'text_domain' ),
			'add_new'             => __( 'Nieuw Teamlid', 'text_domain' ),
			'edit_item'           => __( 'Teamlid aanpassen', 'text_domain' ),
			'update_item'         => __( 'Teamlid bijwerken', 'text_domain' ),
			'search_items'        => __( 'Teamlid zoeken', 'text_domain' ),
			'not_found'           => __( 'Niet gevonden', 'text_domain' ),
			'not_found_in_trash'  => __( 'Niet gevonden in prullenbak', 'text_domain' ),
		);
		$args = array(
			'label'               => __( 'team', 'text_domain' ),
			'rewrite' 			  => array('slug' => 'team'),
			'description'         => __( 'Team post type', 'text_domain' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'author' ),
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 6,
			'menu_icon'           => '',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);
		register_post_type( 'team', $args );

	}


	// Add icons to Post types
	public function post_type_icons() { ?>
	    <style type="text/css" media="screen">
			/* Post Type Websites */
			#adminmenu .menu-icon-websites div.wp-menu-image:before { 
				content: "\f322";
			}
	    </style><?php 
	} 

	// Use custom sort order post types
	public function my_custom_archive_order( $vars ) {
		if ( !is_admin() && isset($vars['post_type']) && is_post_type_hierarchical($vars['post_type']) ) {
			$vars['orderby'] = 'menu_order';
			$vars['order'] = 'ASC';
		}
		return $vars;
	}

	// Highlight post type in nav menu
	public function add_current_nav_class($classes, $item) {
		
		// Getting the current post details
		global $post;
		
		// Getting the post type of the current post
		$current_post_type = get_post_type_object(get_post_type($post->ID));
		$current_post_type_slug = $current_post_type->rewrite['slug'];
			
		// Getting the URL of the menu item
		$menu_slug = strtolower(trim($item->url));
		
		// If the menu item URL contains the current post types slug add the current-menu-item class
		if (strpos($menu_slug,$current_post_type_slug) !== false) {
		
		   $classes[] = 'current-menu-item';
		
		}
		
		// Return the corrected set of classes to be added to the menu item
		return $classes;
	
	}	

	public function theme_current_type_nav_class($css_class, $item) {
	    static $custom_post_types, $post_type, $filter_func;

	    if (empty($custom_post_types))
	        $custom_post_types = get_post_types(array('_builtin' => false));

	    if (empty($post_type))
	        $post_type = get_post_type();

	    if ('page' == $item->object && in_array($post_type, $custom_post_types)) {
	        if (empty($filter_func))
	            $filter_func = create_function('$el', 'return ($el != "current_page_parent");');

	        $css_class = array_filter($css_class, $filter_func);

	        $template = get_page_template_slug($item->object_id);
	        if (!empty($template) && preg_match("/^page(-[^-]+)*-$post_type/", $template) === 1)
	            array_push($css_class, 'current_page_parent');

	    }

	    return $css_class;
	}


}
new postTypes; 

?>
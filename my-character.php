<?php
/*
Plugin Name: My Character
Plugin URI:  
Description: A Wordpress plug-in assignment for Plexchat
Version:     1
Author:      Cooltey.org
Author URI:  https://cooltey.org
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

My Character is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
My Character is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

if( !class_exists('MyCharacter') ):

class MyCharacter{

	var $postTypeName = "character";

	function __construct(){

		// initial custom post type
		add_action('init', array($this, 'init'), 1);

		// filter for custom post type template
		add_filter('single_template', array($this, 'character_template'), 1, 1);
	}


	function init() {
	    $labels = array(
	        'name'                  => _x( 'Characters', 'Post type general name', 'textdomain' ),
	        'singular_name'         => _x( 'Character', 'Post type singular name', 'textdomain' ),
	        'menu_name'             => _x( 'Characters', 'Admin Menu text', 'textdomain' ),
	        'name_admin_bar'        => _x( 'Characters', 'Add New on Toolbar', 'textdomain' ),
	        'add_new'               => __( 'Add New', 'textdomain' ),
	        'add_new_item'          => __( 'Add New Character', 'textdomain' ),
	        'new_item'              => __( 'New Character', 'textdomain' ),
	        'edit_item'             => __( 'Edit Character', 'textdomain' ),
	        'view_item'             => __( 'View Character', 'textdomain' ),
	        'all_items'             => __( 'All Characters', 'textdomain' ),
	        'search_items'          => __( 'Search Characters', 'textdomain' ),
	        'not_found'             => __( 'No characters found.', 'textdomain' ),
	        'not_found_in_trash'    => __( 'No characters found in Trash.', 'textdomain' ),
	        'archives'              => _x( 'Character archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
	        'insert_into_item'      => _x( 'Insert into character', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
	        'filter_items_list'     => _x( 'Filter characters list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
	        'items_list_navigation' => _x( 'Characters list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
	        'items_list'            => _x( 'Characters list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
	    );
	 
	    $args = array(
	        'labels'             => $labels,
	        'public'             => true,
	        'publicly_queryable' => true,
	        'show_ui'            => true,
	        'show_in_menu'       => true,
	        'query_var'          => true,
	        'rewrite'            => array( 'slug' => $this->postTypeName ),
	        'capability_type'    => 'post',
	        'has_archive'        => true,
	        'hierarchical'       => false,
	        'menu_position'      => null,
	        'supports'           => array( 'title' ),
	    );
	 
	    register_post_type( $this->postTypeName, $args );

	    // avoid permalink not found
	    $set = get_option('post_type_rules_flased_authors');
		if ($set !== true){
		   flush_rewrite_rules(false);
		   update_option('post_type_rules_flased_authors',true);
		}
	}

	function character_template($single) {
	    global $wp_query, $post;

        $plugin_path = plugin_dir_path( __FILE__ );

	    /* Checks for single template by post type */
	    if ($post->post_type == $this->postTypeName){
	        if(file_exists($plugin_path.'/template.php'))
	            return $plugin_path.'/template.php';
	    }
	    return $single;
	}

	function character_css() {
	    return plugin_dir_url( __FILE__ ) . 'css/style.css';
	}


	function getHP($class, $level){
		if(isset($level) && isset($class)){
			switch($class){
				case 'warrior':
					$base = 100;
					$by_level = 150;
				break;

				case 'archer':
					$base = 80;
					$by_level = 50;

				break;

				case 'mage':
					$base = 50;
					$by_level = 20;

				break;

				case 'monk':
					$base = 90;
					$by_level = 120;

				break;

				case 'paladin':
					$base = 110;
					$by_level = 160;

				break;

				case 'ninja':
					$base = 100;
					$by_level = 100;

				break;

				default: // hidden character
					$base = 100;
					$by_level = 200;
				break;
			}

			return number_format($base + $level*$by_level);
		}else{
			return 0;
		}
	}

	function getMP($class, $level){
		if(isset($level) && isset($class)){
			switch($class){
				case 'warrior':
					$base = 15;
					$by_level = 20;
				break;

				case 'archer':
					$base = 50;
					$by_level = 25;

				break;

				case 'mage':
					$base = 100;
					$by_level = 50;

				break;

				case 'monk':
					$base = 15;
					$by_level = 20;

				break;

				case 'paladin':
					$base = 50;
					$by_level = 30;

				break;

				case 'ninja':
					$base = 10;
					$by_level = 10;

				break;

				default: // hidden character
					$base = 50;
					$by_level = 50;
				break;
			}

			return number_format($base + $level*$by_level);
		}else{
			return 0;
		}
	}

	function getSpeed($class, $level){
		if(isset($level) && isset($class)){
			switch($class){
				case 'warrior':
					$base = 15;
					$by_level = 10;
				break;

				case 'archer':
					$base = 35;
					$by_level = 20;

				break;

				case 'mage':
					$base = 15;
					$by_level = 15;

				break;

				case 'monk':
					$base = 15;
					$by_level = 20;

				break;

				case 'paladin':
					$base = 15;
					$by_level = 10;

				break;

				case 'ninja':
					$base = 35;
					$by_level = 30;

				break;

				default: // hidden character
					$base = 30;
					$by_level = 30;
				break;
			}

			return number_format($base + $level*$by_level);
		}else{
			return 0;
		}
	}

	function getLuck($class, $level){
		if(isset($level) && isset($class)){
			switch($class){
				case 'warrior':
					$base = 77;
					$by_level = 10;
				break;

				case 'archer':
					$base = 77;
					$by_level = 15;

				break;

				case 'mage':
					$base = 77;
					$by_level = 10;

				break;

				case 'monk':
					$base = 77;
					$by_level = 7;

				break;

				case 'paladin':
					$base = 77;
					$by_level = 9;

				break;

				case 'ninja':
					$base = 77;
					$by_level = 11;

				break;

				default: // hidden character
					$base = 100;
					$by_level = 20;
				break;
			}

			return number_format($base + $level*$by_level);
		}else{
			return 0;
		}
	}
}



// init
global $getCharacter;;
$getCharacter = new MyCharacter();


endif; // class_exists check
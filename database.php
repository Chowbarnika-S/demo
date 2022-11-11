<?php
/*
Plugin Name: Product-Plugin
Description: A plugin for registering product details 
Author: Chowbarnika
*/

function create_the_custom_table() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
	
    $table_name = $wpdb->prefix . 'Product';

    $Product_query = "CREATE TABLE " . $table_name . " (
	Id int(11) NOT NULL AUTO_INCREMENT,
	Name VARCHAR(50) NOT NULL,
	Price VARCHAR(100) NOT NULL,
	Quantity int(2) NOT NULL,
    Warranty int(5),
	Ip_address varchar(15),
	PRIMARY KEY  (Id),
	KEY ip_address (Ip_address)
    ) $charset_collate;";
 
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta( $Product_query);
}

register_activation_hook(__FILE__, 'create_the_custom_table');

if(!defined('ABSPATH')){
    exit; //Exits forcefully
}


// Register Custom Post Type Product
function create_product_cpt() {

	$label = array(
		'name' => _x( 'product', 'Post Type General Name', 'textdomain' ),
		'singular_name' => _x( 'product', 'Post Type Singular Name', 'textdomain' ),
		'menu_name' => _x( 'product', 'Admin Menu text', 'textdomain' ),
		'name_admin_bar' => _x( 'product', 'Add New on Toolbar', 'textdomain' ),
		'archives' => __( 'product Archives', 'textdomain' ),
		'attributes' => __( 'product Attributes', 'textdomain' ),
		'parent_item_colon' => __( 'Parent product:', 'textdomain' ),
		'all_items' => __( 'All product', 'textdomain' ),
		'add_new_item' => __( 'Add New product', 'textdomain' ),
		'add_new' => __( 'Add New', 'textdomain' ),
		'new_item' => __( 'New product', 'textdomain' ),
		'edit_item' => __( 'Edit product', 'textdomain' ),
		'update_item' => __( 'Update product', 'textdomain' ),
		'view_item' => __( 'View product', 'textdomain' ),
		'view_items' => __( 'View product', 'textdomain' ),
		'search_items' => __( 'Search product', 'textdomain' ),
		'not_found' => __( 'Not found', 'textdomain' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
		'featured_image' => __( 'Featured Image', 'textdomain' ),
		'set_featured_image' => __( 'Set featured image', 'textdomain' ),
		'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
		'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
		'insert_into_item' => __( 'Insert into product', 'textdomain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this product', 'textdomain' ),
		'items_list' => __( 'product list', 'textdomain' ),
		'items_list_navigation' => __( 'product list navigation', 'textdomain' ),
		'filter_items_list' => __( 'Filter product list', 'textdomain' ),
	);
	$args = array(
		'label' => __( 'product', 'textdomain' ),
		'description' => __( 'Custom plugin for product posts', 'textdomain' ),
		'labels' => $label,
		'menu_icon' => 'dashicons-admin-plugins',
		'supports' => array('title', 'editor', 'thumbnail', 'author', 'comments', 'custom-fields','revisions'),
		'taxonomies' => array('category','post_tag'),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'product', $args );

}
add_action( 'init', 'create_product_cpt', 0 );

// Delete table when deactivate
function create_the_custom_table_remove() {
    global $wpdb;
    $table_name = "Product";
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);
    delete_option("create_the_custom_table_remove");
}    
register_deactivation_hook( __FILE__, 'create_the_custom_table_remove' );
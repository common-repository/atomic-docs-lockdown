<?php
/**
 * Plugin Name: Atomic Docs Lockdown
 * Plugin URI: https://www.wisnet.com
 * Description: This plugin locks down the Atomic Docs editor and requires a user to be logged in as an administrator.
 * Version: 1.1.1
 * Author: wisnet.com LLC
 * Author URI: https://www.wisnet.com
 * License: GPL2
 */
$directory = $_SERVER['SCRIPT_FILENAME'];
$atomicDocs = explode( 'atomic-core', $directory );

if ( isset( $atomicDocs[1] ) && $atomicDocs[1] === '/index.php' ) {
	add_action( 'init', 'redirect_to_login' );
	
	function redirect_to_login() {
		if ( !is_user_logged_in() ) {
			auth_redirect();
			wp_die();
		}
		else if ( !current_user_can( 'administrator' ) ) {
			wp_die( 'You do not have permission to view this section. Contact your nearest administrator.' );
		}
	}
}

add_action( 'admin_bar_menu', 'toolbar_link_to_atomic_docs', 999 );

if ( !function_exists( 'toolbar_link_to_atomic_docs' ) ) {
	function toolbar_link_to_atomic_docs( $wp_admin_bar ) {
		if ( current_user_can( 'administrator' ) ) {
			$args = array(
				'id'    => 'atomic_docs',
				'title' => 'Atomic Docs',
				'href'  => '/wp-content/themes/jumpoff/atomic-core',
				'meta'  => array(
					'class'  => 'my-toolbar-page',
					'target' => 'atomic-docs',
				),
			);
			$wp_admin_bar->add_node( $args );
		}
	}
}

<?php
/*
Plugin Name:  Block Widget
Plugin URI:   
Description:  Include a reusable block by use of widget.
Version:      0.1.0
Author:       Maarten Menten
Author URI:   https://profiles.wordpress.org/maartenm/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  block-widget
Domain Path:  /languages
*/

namespace mm;

defined( 'BLOCK_WIDGET_VERSION' )     or define( 'BLOCK_WIDGET_VERSION', '0.1.0' );
defined( 'BLOCK_WIDGET_PLUGIN_FILE' ) or define( 'BLOCK_WIDGET_PLUGIN_FILE', __FILE__ );
defined( 'BLOCK_WIDGET_ABSPATH' )     or define( 'BLOCK_WIDGET_ABSPATH', dirname( BLOCK_WIDGET_PLUGIN_FILE ) . '/' );

function widgets_init()
{
	include_once BLOCK_WIDGET_ABSPATH . 'includes/block-widget.php';
}

function dependency_notice()
{
	printf( '<div class="notice notice-warning"><p><strong>%s</strong>: %s</p></div>',
		esc_html__( 'Block Widget', 'block-widget' ),
		esc_html__( 'It appears that your WordPress version does not support blocks.', 'block-widget' ) );
}

if ( function_exists( 'has_blocks' ) ) 
{
	add_action( 'widgets_init', __NAMESPACE__ . '\widgets_init' );
}

else
{
	add_action( 'admin_notices'        , __NAMESPACE__ . '\dependency_notice' );
	add_action( 'network_admin_notices', __NAMESPACE__ . '\dependency_notice' );
}

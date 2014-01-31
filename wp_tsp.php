<?php
/**
 * WP Theme Standardization Panel
 *
 * Maintaining the guidelines of the WP Theme Standardization Panel, WordPress theme developers apply a unified
 * way of using action hooks in their theme. As soon as plugin developers start implementing the use of these
 * hooks, the WordPress infrastructure will be vastly improved because any plugin content can be added exactly
 * where it needs to be inserted, without using filters (which should actually only be used for modifying existing
 * content) or (even worse) output buffers.
 *
 * The guidelines can be found at https://github.com/felixarntz/wp-theme-standardization-panel.
 *
 * This file here is a reference file. You may include it and modify it to your needs, however it is not necessary to
 * use it as long as you stick to the guidelines. This file by default includes support for all 10 basic hooks.
 * If you want to include this file, all you have to do is replace all instances of <code>yourtheme</code> with the slug of your theme.
 * 
 * @package WPTSP
 * @version 1.0
 * @author  Felix Arntz <felix-arntz@leaves-and-love.net>
 * @link	https://github.com/felixarntz/wp-theme-standardization-panel
 */

/**
 * Definition of WP_THEME_HOOK_SLUG
 *
 * For a standardized way to hook into functions a constant is used that defines the slug prefix for the hooks.
 */
if( !defined( 'WP_THEME_HOOK_SLUG' ) )
{
	define( 'WP_THEME_HOOK_SLUG', 'yourtheme' );
}

/**
 * Addition of theme support
 *
 * This function call adds theme support so that plugins know which hook names are supported by the current theme.
 * Editing the array allows to adjust theme support.
 */
add_theme_support( WP_THEME_HOOK_SLUG . '_theme_hooks', array(
	'header',
	'main',
	'loop',
	'article',
	'article_header',
	'article_content',
	'article_footer',
	'comments_section',
	'sidebar',
	'footer',
) );

/**
 * Function to execute the action hook
 *
 * This function fires the actual action. However, it only does this if the desired hook name is supported by the theme.
 * 
 * @param  string $hook_name       the desired hook name to be used in the action
 * @param  string $before_or_after either 'before' or 'after' to know which type of action is fired
 * @return boolean                 true if the action was fired, else false
 */
function yourtheme_do_hook( $hook_name, $before_or_after )
{
	$support = get_theme_support( WP_THEME_HOOK_SLUG . '_theme_hooks' );
	if( is_array( $support ) && in_array( $hook_name, $support ) )
	{
		if( $before_or_after != 'after' )
		{
			$before_or_after = 'before';
		}
		do_action( WP_THEME_HOOK_SLUG . '_' . $before_or_after . '_' . $hook_name );
		return true;
	}
	return false;
}

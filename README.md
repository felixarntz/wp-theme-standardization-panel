WP Theme Standardization Panel
==============================

This is an initiative to standardize WordPress theme hooks.

Why do we need this?
--------------------

Action hooks in WordPress themes allow developers to properly insert new content into the theme. For example, when a plugin inserts a rating box to a post, this currently happens by using the filter `the_content`. But filters in WordPress exist to modify existing content, not to actually create new output. That's why we need theme hooks. But there has to be a unified way that plugin developers can access them. There are dozens of themes and frameworks out there, so the guidelines of the WP Theme Standardization Panel introduce a new standard which can improve the WordPress theme and plugin infrastructure a lot.

The Guidelines
--------------

The PHP file in this repository is a reference file for the following guidelines. You can include it in your theme and modify it to your needs or you can do it manually. Just make sure to stick to the following rules (this is for theme developers):

* Define a constant `WP_THEME_HOOK_SLUG` (in a conditional statement!) holding the theme slug used in your hooks. In the reference file, the theme slug is 'yourtheme', you need to change it if you include the file.
* Add theme support for the required hooks using the WordPress Core function [`add_theme_support( $feature, $arguments )`](http://codex.wordpress.org/Function_Reference/add_theme_support). As the first parameter, pass `WP_THEME_HOOK_SLUG . '_theme_hooks'`. As the second parameter, pass the hook names that your theme actually supports. This may vary since not every theme necessarily has for example a sidebar. The WP Theme Standardization Panel includes 10 basic hook names:
  * 'header'
  * 'main'
  * 'loop'
  * 'article'
  * 'article_header'
  * 'article_content'
  * 'article_footer'
  * 'comments_section'
  * 'sidebar'
  * 'footer'
* Each hook name corresponds to two hooks that need to be implemented if your theme supports it. First, there is a 'before' hook that is executed right at the beginning of the specific part of your theme. And then, there is an 'after' hook that is executed at the end. The actual hook must be executed using the WordPress Core function [`do_action( $hook )`](http://codex.wordpress.org/Function_Reference/do_action). The tag is created from the `WP_THEME_HOOK_SLUG`, 'before' or 'after' and the hook name. If, for example, you want to implement the 'loop' hook name, you have to include `do action( WP_THEME_HOOK_SLUG . '_before_loop' )` and `do_action( WP_THEME_HOOK_SLUG . '_after_loop' )`. How you do this, is up to you. Just make sure you use exactly these names and structures.
* **When using action hooks in your theme, always use one of the above hooks if it matches your specific location!** For example, do not use the hook name 'content' instead of 'article'. However, when there is something you want to add a hook to where none of the 10 basic hook names would make sense, you can use the easy extension mechanism by simply adding your hook name to the list of supported hooks. A plugin developer may not know about this hook name at first, but as your theme gets more popular, plugin developers might start to use it.

The following guidelines are for plugin developers (however, you should have read the theme developer guidelines too so you know what all this is about):

* When you want to use a specific hook that might possibly exist in the theme, first check if the constant `WP_THEME_HOOK_SLUG` is defined. If it's not, the current theme is not maintaining the standard of the WP Theme Standardization Panel. You must do it the bad old way. However, if it is defined, you can continue.
* Check which hook names are supported by the current theme. You should use the WordPress Core function [`get_theme_support( $feature )`](http://codex.wordpress.org/Function_Reference/get_theme_support) with `WP_THEME_HOOK_SLUG . '_theme_hooks'` as parameter. If the returned result is an array, you can continue.
* Check if the desired hook name you want to add your content to is part of this array. If so, you can use the WordPress Core function [`add_action( $hook, $function_to_add, $priority, $accepted_args )`](http://codex.wordpress.org/Function_Reference/add_action). Make sure that the first parameter is `WP_THEME_HOOK_SLUG` plus underscore plus 'before' or 'after' plus underscore plus the hook name.

Implementation
--------------

You can implement these guidelines in any way you like as long as you maintain the standard. As written above, the PHP file in this repository is a reference how you could do it (though you must not necessarily include this file in your theme, you can do it differently if you like). It is recommended to put the hooks into functions, either one function for each hook or one function with two parameters for all hooks combined (this is the way it is handled in the reference file).

If you are a theme developer and want to include the reference file, simply replace all instances of `yourtheme` with the actual slug of your theme, adjust theme support to your needs - and you're ready to go.

As a plugin developer, simply stick to the way that is outlined in the guidelines above.

Participate!
------------

Unfortunately WordPress Core doesn't include a standard like this, so we have to do it on our own. So I advise you to participate!

* If you are reading this and you think it's a great idea, please share it with as many WordPress developers as you know.
* If you have improvements, please [open an issue here on Github](https://github.com/felixarntz/wp-theme-standardization-panel/issues/new).
* If you want to get something like this into WordPress Core, check out [this ticket](https://core.trac.wordpress.org/ticket/21506).
* If you have created a theme that sticks to these guidelines, it would be cool if you could send me an email about it at *felix-arntz(at)leaves-and-love.net* since I'd like to include a link here.

Credit
------

No, I did not come around with all these ideas alone - there have been people before me who had an idea like that. The two main resources that inspired me are [the Theme Hook Alliance](https://github.com/zamoose/themehookalliance) (unfortunately I couldn't contact anyone there, it seems like this is not actively maintained any longer) and [this article by Yoast](https://yoast.com/standard-wordpress-theme-hooks/) (which actually contains the idea which is one of the biggest improvements of the WP Theme Standardization Panel over the Theme Hook Alliance project).

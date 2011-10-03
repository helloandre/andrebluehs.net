<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));

function contagious_head(){
	// this theme doesn't need anything special, but this function needs to exist to keep things happy.
	// without this, sociable wouldn't fuction properly.
	// also without this, php would throw errors about not calling functions and whatnot.
}

add_action('wp_head', 'contagious_head');

?>
<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
<h2 class="text-header"><?php _e('Search for:'); ?></h2>
<div><input type="text" value="<?php the_search_query(); ?>" name="s" id="searchtext" />
<input type="submit" id="searchsubmit" value="Search" />
</div>
</form>

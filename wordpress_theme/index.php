<?php get_header(); ?>
		<div id="main">
		<div id='left'>
	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
		
			<div class="post" id="post-<?php the_ID(); ?>">
				<?php the_time('m.d') ?>
				<h2 class="postsubject"><a href="<?php the_permalink() ?>" ><?php the_title(); ?></a></h2>
				
				<div class="entry">
					<?php the_content('Read the rest of this entry &raquo;'); ?>
				</div>
				<br>
				<p class="postmetadata">Posted in <?php the_category(', ') ?> by <?php the_author() ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', 'Comments (1) &#187;', 'Comments (%) &#187;'); ?><br/><?php the_tags('Tags: ', ', ', ''); ?></p>
			</div>

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>

	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>
		</div> <!-- left -->
		<?php get_sidebar(); ?>
		<div class='clear'></div>
	</div> <!-- main -->


<?php get_footer(); ?>
	

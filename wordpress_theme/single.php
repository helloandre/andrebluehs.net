<?php get_header(); ?>
	<!-- single.php -->
	<div id='main'>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="navigation">
			<?php previous_post_link('&laquo; %link | ') ?><a href="<?php echo get_option('home'); ?>">Main</a><?php next_post_link(' | %link &raquo;') ?><br/>
		</div>

		<div class="post single" id="post-<?php the_ID(); ?>">
			<br/></br><?php the_time('m.d') ?>
			<h2 class="postsubject"><?php the_title(); ?></h2>
			<div class="entry">
			<br>
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<p>Follow me on twitter: <a href='http://twitter.com/helloandre'>@helloandre</a></p>

				<p class="postmetadata">
						<span class="metaby"> This entry was posted on <?php the_time('d/m/y') ?> by <?php the_author() ?>.</span><br>
						<?php the_tags( 'Tags: ', ', ', '<br/>'); ?> 
						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a> from your own site.

						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							Responses are currently closed, but you can <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> from your own site.

						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
							You can skip to the end and leave a response. Pinging is currently not allowed.

						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
							Both comments and pings are currently closed.

						<?php } edit_post_link('Edit this entry','','.'); ?>

				</p>

			</div> <!-- .entry -->
		</div> <!-- .post -->
	<br>
	<?php comments_template(); ?>

	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

	<?php endif; ?>
	</div> <!-- main -->
	
<?php get_footer() ?>


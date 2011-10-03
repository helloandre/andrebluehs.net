<?php // Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments">This post is password protected. Enter the password to view comments.</p>

			<?php
			return;
		}
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'class="alt" ';
?>

<!-- You can start editing here. -->
<div class="comments-template">
<?php if ($comments) : ?>
	<h3 id="comments"><?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</h3>

	<ol class="commentlist">

	<?php foreach ($comments as $comment) : ?>

		<li <?php echo $oddcomment; ?>id="comment-<?php comment_ID() ?>">
			<?php echo get_avatar( $comment, 32 ); ?>
			<cite><?php comment_author_link() ?></cite> Says:
			<?php if ($comment->comment_approved == '0') : ?>
			<em>Your comment is awaiting moderation.</em>
			<?php endif; ?>
			<br />

			<small class="commentmetadata"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('F jS, Y') ?> at <?php comment_time() ?></a> <?php edit_comment_link('edit','&nbsp;&nbsp;',''); ?></small>

			<?php comment_text() ?>

		</li>

	<?php
		/* Changes every other comment to a different class */
		$oddcomment = ( empty( $oddcomment ) ) ? 'class="alt" ' : '';
	?>

	<?php endforeach; /* end for each comment */ ?>

	</ol>

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>

	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

<div class="text-subheader">Leave a Reply</div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="http://andrebluehs.net/blog/wp-comments-post.php" method="POST" id="commentform">
<table class="contactform">
<!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->

<tr>
<td colspan="2"><textarea name="comment" id="comment" cols="54" rows="10" tabindex="4"></textarea></td>
</tr>

<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
	<?php if ( $user_ID ) : ?>

	<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Log out &raquo;</a></p>

	<?php else : ?>

		<tr>
		<td><input id="author" class='comment-input' onblur="if(this.value=='') this.value=this.getAttribute('at:default');" onfocus="if(this.value==this.getAttribute('at:default')) this.value='';" value="Name" size="30" name="author" at:default="Name"/></td>

		</tr>
		<tr>
		<td><input id="email" class='comment-input' onblur="if(this.value=='') this.value=this.getAttribute('at:default');" onfocus="if(this.value==this.getAttribute('at:default')) this.value='';" value="Email" size="30" name="email" at:default="Email"/></td>
		</tr>
		<tr>
		<td><input id="url" class='comment-input' onblur="if(this.value=='') this.value=this.getAttribute('at:default');" onfocus="if(this.value==this.getAttribute('at:default')) this.value='';" value="Website" size="30" name="url" at:default="Website"/></td>

		</tr>
	<?php endif; ?>
	</table>
	<div class="contactform" align="center">
	<input id="submit" type="submit" value="Submit Comment" tabindex="5" name="submit"/>
	<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
	</div>
<?php do_action('comment_form', $post->ID); ?>
</form>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>

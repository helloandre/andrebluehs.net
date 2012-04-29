<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>
    <!-- archives.php -->
    <div id='container'>
	<div id="content">
<?php include (TEMPLATEPATH . '/searchform.php'); ?>

<h2>Archives by Month:</h2>
	<ul>
		<?php wp_get_archives('type=monthly'); ?>
	</ul>

<h2>Archives by Subject:</h2>
	<ul>
		 <?php wp_list_categories(); ?>
	</ul>
		</div> <!-- content -->
	</div> <!-- container -->
<?php get_footer(); ?>

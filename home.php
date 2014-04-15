<?php get_header( );?>
	
	<h1>Latest News</h1>
	<?php if(have_posts()): the_post(); ?>
		<?php get_template_part( 'content', get_post_format( ); ); ?>
		<?php endwhile; ?>

	<?php else: ?>
		<article class="error">
			<h2>Sorry there were no news articles </h2>
		</article>
	<?php endif; ?>

	<p class="post-page-navigation">
		<?php previous_post_link( "&laquo; More recent news" ); ?>
		<?php next_post_link( "Past news &raquo" ); ?>
	</p>

	<?php get_sidebar('news' ); ?>

<?php get_footer( ); ?>
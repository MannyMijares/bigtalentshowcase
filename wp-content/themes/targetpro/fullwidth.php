<?php /* Template Name: Full Width
*/ ?> 

<?php get_header(); ?>
		
		<div id="subhead_container">

		<div id="subhead_wrapper">		
			<div id="subhead">
		
		<h1><?php the_title(); ?></h1>
			
			</div>
			
		<div id="search-header"><?php get_search_form(); ?></div><!--search header end-->
			
				<div class="clear"></div>
			
		</div>
	</div>		
	
		<!--content-->
		<div id="content_container">
		
				<div id="post-entry-fullwidth">
		

				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

						<?php the_content(); ?>
						<div class="clear"></div>
						<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'target' ), 'after' => '' ) ); ?>

<?php endwhile; ?>

	</div> 
</div>
<!--content end-->
	
</div>
<!--wrapper end-->
<?php get_footer(); ?>
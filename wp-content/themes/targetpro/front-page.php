<?php get_header(); ?>

<div id="home-container">

	<!--slideshow-->
	
	<?php $slider_url = ''; ?>
	
	<div id="slideshow">

		<?php query_posts( array ('post_type' => 'slides', 'showposts' => 20  ) ); ?>

			<?php while (have_posts()) : the_post(); ?>
				<?php $slider_url= get_post_meta(get_the_ID(), 'slide_url', true); ?>
			<div>
			 <img src="<?php echo get_post_meta(get_the_ID(), 'Thumbnails', true); ?>" alt="<?php the_title(); ?>" />
			 <?php global $more;
				// set $more to 0 in order to only get the first part of the post
					$more = 0; ?>
			 <span class="information"><span class="info-title"><?php small_title(33); ?></span><p><?php the_excerpt(); ?></p>
			 <?php if($slider_url<>'') { ?><a href="<?php echo get_post_meta(get_the_ID(), 'slide_url', true); ?>"><span class="read-more-slide"><?php _e( 'Learn More', 'Rbox' ); ?></span></a><?php } ?>
			 </span>
			
			</div>
			
		<?php endwhile; wp_reset_query(); ?>
		
		</div> <!--slideshow end-->

  </div><!--home container end-->

<div class="clear"></div>
				
		<!--boxes-->
		<div id="box_container">
				
		<?php for ($i = 1; $i <= 4; $i++) { ?>
		
		
				<div class="boxes <?php if ($i == 1) {echo "box1";} ?><?php if($i == 2) {echo "box2";} ?> <?php if($i == 3) {echo "box3";} ?>">
						<div class="box-head">
								
	<a href="<?php echo of_get_option('box_link' . $i); ?>"><img src="<?php if(of_get_option('box_image' . $i) != NULL){ echo of_get_option('box_image' . $i);} else echo get_template_directory_uri() . '/images/box' .$i. '.png' ?>" alt="<?php echo of_get_option('box_head' . $i); ?>" /></a>

					
					</div> <!--box-head close-->
					
				<div class="title-box">						
						
				<div class="title-head"><?php if(of_get_option('box_head' . $i) != NULL){ echo of_get_option('box_head' . $i);} else echo "Box heading" ?></div></div>
					
					<div class="box-content">

				<?php if(of_get_option('box_text' . $i) != NULL){ echo of_get_option('box_text' . $i);} else echo "Nullam posuere felis a lacus tempor eget dignissim arcu adipiscing. Donec est est, rutrum vitae bibendum vel, suscipit non metus." ?>
					
					</div> <!--box-content close-->

				
				</div><!--boxes  end-->
				
		<?php } ?>
		
		</div><!--box-container end-->
			
			<div class="clear"></div>
		
	<!--welcome-->
	<div id="welcome_container">

		<div id="welcome-box">
		
	<h1><?php if(of_get_option('welcome_text') != NULL){ echo of_get_option('welcome_text');} else echo "write your headline here" ?></h1>
		
	</div>

</div><!--welcome end-->

<div class="clear"></div>
		
</div>
<!--wrapper end-->

<?php get_footer(); ?>
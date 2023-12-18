<?php /* Template Name: Home */ ?>

<?php get_header(); ?>
    <div class="main-home-page-section">
			<div class="banner-image-section">
				<div class="banner_image_img">
						<?php
						$post_id = get_the_ID();
						if ($post_id) {
							echo get_the_post_thumbnail($post_id, 'full', array('class' => 'alignleftfull'));
						}
						?>
				</div>				
			    <div class="main-banner-content">
					<div class="container">
						<div class="main-banner-content_inner">
							<?php the_content(); ?>					
						</div>						  
					</div>						  
				</div>
			</div>
			<div class="main-second-section">
			  <div class="container">
				<div class="popular-gem">
					<h3><?php the_field("popular_gem"); ?></h3>
			    </div>
			    <div class="stones-section">			    	
			    	<?php echo do_shortcode( '[product_categories ids="20,19,21,22,23,24,25,26,27,28,29,30" hide_empty="0" orderby="id"]' ) ?>
			    	<?php the_field("image_text_stones"); ?> 	
			    </div>	
			  </div>
			</div>
			<div class="main-third-section">
				<div class="container">
					<div class="main_third_sectionInner">
						<div class="glamore-left-section">
							<?php the_field("glamore_buyer_protection"); ?>
						</div>	
						<div class="glamore-right-section">				
							<img src="<?php the_field("glamore_right_image"); ?>" alt="">
						</div>	
					 </div>	
				 </div>	
		    </div>  
		    <div class="main-4th-explore-section">
		    	<div class="container">
			      <div class="explore-heading"><?php the_field("explore_glamore"); ?></div>
			      <div class="explore-image-title">
			      	<?php echo do_shortcode( '[product_categories ids="31,32,33,34,35,36,37,38,39,40,41,42" hide_empty="0" orderby="id"]' ) ?> 
			      	<?php the_field("explore_glamore_image"); ?>
			      </div>
			    </div>
		   </div>
		    <div class="main-satisfied-section">
		    	<div class="container">
					<?php the_field("satisfied_section"); ?>
					<?php echo do_shortcode( '[rt-testimonial id="53" title="Testimonial"]' ) ?> 
				</div>
		    </div>
	    	<div class="main-magazine-section">
	    		<div class="container">
	    		    <h3 class="glamagazine-title"><?php the_field("glamagazine_post_title"); ?></h3>
	    			<div class="news-and-perspectives-post-section">
						 <?php
						$args = array(
						'post_type'=> 'post',
						'category_name'=> 'minimal',
						'orderby'    => 'ID',
						'post_status' => 'publish',
						'order'       => 'ASC',
						'posts_per_page' => -1
						);
						$result = new WP_Query( $args );
						if ( $result-> have_posts() ) : ?>
						<?php while ( $result->have_posts() ) : $result->the_post(); ?>
						<div class="news_perspectives_Post"><?php echo get_the_post_thumbnail();?>
							<h4><a href="<?php the_permalink();?>"><?php the_title(); ?> </a></h4>
							<p><?php echo wp_trim_words( get_the_content(), 10 ); ?></p>	
						</div>
						<?php endwhile; ?>
						<?php endif; wp_reset_postdata(); ?>
						
				    </div>
			    </div>
			    <div class="post-button-section"><?php the_field("to_glamagazine_post_button"); ?></div>
			</div>
    		<div class="main-glamore-instagram-section">
    	       <div class="container">
			    <h3 class="glamore-insta"><?php the_field("glamore_on_instagram"); ?></h3>
			    <div class="insta-section"><?php echo do_shortcode( '[instagram-feed feed=2]' ) ?></div>
		        </div>
	        </div>
<!--      		<div class="main-news-translate-section"> 
				<div class="container">
					<div class="news_translate_sr">
						<div class="newsletter-right"><h2><?php the_field("glamore_newsletter"); ?> </h2>
						   <a href="#" class="shownewsletterbox">Subscribe now for free</a></div>
						<div class="translate-left"><h2><?php the_field("settings"); ?></h2><?php echo do_shortcode( '[gtranslate]' ) ?></div>
					</div>
				</div>
            </div> -->
    </div>
<?php get_footer(); ?>
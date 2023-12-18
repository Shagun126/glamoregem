<?php /* Template Name: Blog */ ?>
<?php get_header(); ?>
<div class="container">
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
<?php get_footer(); ?>
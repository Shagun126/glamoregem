<?php /* Template Name: Gem Collection */ ?>
<?php get_header(); ?>
	<div class="gem-collection-page">
		<div class="container">
				<div class="banner_image_img">
					<?php echo the_post_thumbnail( $post_id, 'full', array( 'class' => 'alignleftfull' ) ); ?>	
				</div>
				<div class="gem-collection-content">
				   <?php the_content(); ?>	
				</div>
        </div>
    </div>
<?php get_footer(); ?>
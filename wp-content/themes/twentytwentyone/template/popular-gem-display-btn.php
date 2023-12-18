<?php /* Template Name: PopularGemDisplayBtn */ ?>
<?php get_header(); ?>
	<div class="popular-gem-btn-page">
		<div class="container">
			<div class="popular-display-btn-stones-section">	
			    <div class="popular-page-heading"><?php the_content(); ?>	 		    	
				<div class="popular-cate-image-title"><?php echo do_shortcode( '[product_categories ids="20,19,21,22,23,24,25,26,27,28,29,30" hide_empty="0" orderby="id"]' ) ?>
				</div>			
			</div>
		</div>
	</div>
    <div class="alphabatically-stones-name-section">
    	 <div class="container">
				<?php
				// Parent category ID jo aap retrieve karna chahte hain
				$parent_category_id = 43; // Parent category ki ID ko apni requirement ke hisab se update karen

					// Subcategories ko retrieve karna
					$subcategories = get_terms('product_cat', array(
					'taxonomy' => 'product_cat',
					'hide_empty' => 0,
					    'orderby' => 'name', // Sort by name
    					'order' => 'ASC', // in ascending order
					'parent' => $parent_category_id,
					));

					// Organize subcategories into an associative array by the first letter
					$category_groups = array();

					foreach ($subcategories as $subcategory) {
					$first_letter = strtoupper(substr($subcategory->name, 0, 1));
					$category_groups[$first_letter][] = $subcategory;
					}

					// Loop through the alphabet from 'A' to 'Z'
					foreach (range('A', 'Z') as $letter) {
					if (isset($category_groups[$letter])) {					
						echo '<div class="main-letter-name-cls">';
					echo '<h2 class="letter-name-explore">' . $letter . '</h2>';
					echo '<div class="cate-name-cls">';
					foreach ($category_groups[$letter] as $subcategory) {
					echo '<a href="' . get_term_link($subcategory) . '">' . $subcategory->name . '</a>';
					}
					echo '</div>';
					echo '</div>';
					}
					}
				?>
	</div>
    </div>

        <div class="popular-page-below-content-section">
        	<div class="container">
        		<div class="over-what-pop">
        		<h2 class="popular_textTitle"><?php the_field('over_300_types_title'); ?></h2>
        		<?php the_field('over_300'); ?>

        		<h2 class="popular_textTitle"><?php the_field('what_are_the_pop'); ?></h2>
        		<?php the_field('what_are_the_popular_content');?>
        	</div>
            </div>		
        </div>	

    		<div class="main-satisfied-section">
		    	<div class="container">
					<?php the_field("satisfied_customers_title"); ?>
					<?php echo do_shortcode( '[rt-testimonial id="53" title="Testimonial"]' ) ?> 
				</div>
		    </div>
 
</div>
<?php get_footer(); ?>

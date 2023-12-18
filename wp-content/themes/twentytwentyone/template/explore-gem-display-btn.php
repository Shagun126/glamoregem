<?php /* Template Name: Explore Gem Display Button */ ?>

<?php get_header(); ?>
<div class="explore-gem-btn-page">
		<div class="container">
			<div class="explore-display-btn-section">
				<div class="explore-page-heading"><?php the_content(); ?></div>
				<div class="explore-cate-image-title"><?php echo do_shortcode( '[product_categories ids="31,32,33,34,35,36,37,38,39,40,41,42" hide_empty="0" orderby="id"]' ) ?> 
				</div>				
			</div>
		</div>

		<div class="atoz-stones-section">
				<div class="container">
				<?php
						// Parent category ID jo aap retrieve karna chahte hain
						$parent_category_id = 44; // Parent category ki ID ko apni requirement ke hisab se update karen

						// Subcategories ko retrieve karna
						$subcategories = get_terms('product_cat', array(
						'taxonomy' => 'product_cat',
						'hide_empty' => 0,
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

			<div class="main-satisfied-section">
		    	<div class="container">
					<?php the_field("satisfied_customers_title"); ?>
					<?php echo do_shortcode( '[rt-testimonial id="53" title="Testimonial"]' ) ?> 
				</div>
		   </div>
</div>
<?php get_footer(); ?>
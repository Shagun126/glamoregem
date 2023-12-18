<?php /* Template Name: Buyer Protection */ ?>
<?php get_header(); ?>

<div class="mian-buyer-page">
			<div class="banner-image-section">
				<div class="banner_image_img">
					<?php echo the_post_thumbnail( $post_id, 'full', array( 'class' => 'alignleftfull' ) ); ?>	
				</div>				
			    <div class="main-banner-content">
					<div class="container">
						<div class="main-banner-content_inner">
							<?php the_content(); ?>					
						</div>						  
					</div>						  
				</div>
			</div>

			<div class="main-buyer-protection">
				<div class="Protection-title">
			<div class="container">
		        <h2><?php the_field("buyer_protection_title"); ?></h2>
		      <?php the_field("buyer_protection_content"); ?>  	
        	</div>
        </div>
        </div>
		
		<div class="main-payment-con">
        <div class="main-payment-con main-payment-section">
			<div class="container">
			  <?php the_field("first_image_text_section"); ?>
				
			</div>
		</div>

         <div class="authenticity-section main-payment-con">
         	<div class="container">
         		<?php the_field("second_image_text_section"); ?>
         	</div>
         </div>

          <div class="global-money-section main-payment-con">
          	<div class="container"><?php the_field("third_image_section"); ?>      		
          	</div>
          </div>
          </div>

          <div class="return-made-section">
          	<div class="container">
          		<?php the_field("returns_made_text_section"); ?>
          	</div>
          </div>
		  
		  <div class="strict-main-section">
          <div class="strict-dealer-section strict-inr">
               <div class="container">
               	  <?php the_field("fourth_image_text_section"); ?>
               </div>		
            </div>
            <div class="insured-shippment-section strict-inr">
				<div class="container">
				   <?php the_field("fifth_image_text_section"); ?>					
				</div>
			</div>
			<div class="quality-security-section strict-inr">
				<div class="container">
				   <?php the_field("sixth_section"); ?>
				</div>
			</div>
			</div>

		    <div class="main-satisfied-section">
		    	<div class="container">
					<?php the_field("over_satisfied"); ?>
					<?php echo do_shortcode( '[rt-testimonial id="53" title="Testimonial"]' ) ?> 
				</div>
		    </div>

		    <div class="need-help-section">
		    	<div class="container">
		    		<?php the_field("need_help_section"); ?>		    			
		    	</div>
		    </div>

		   <div class="buyer-protection-testimonial-section">
		   	<div class="container"> <?php the_field("do_you_have_any_questions"); ?>
		     <?php echo do_shortcode('[sp_easyaccordion id="340"]'); ?></div>
		 </div>
</div>

<?php get_footer(); ?>
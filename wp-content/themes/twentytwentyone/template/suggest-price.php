<?php /* Template Name: Suggest Price */ ?>
<?php get_header(); ?>
<div class="main-suggest-page">
				<div class="main-suggest-content-cls">
					<div class="container">
						<div class="main-banner-content_inner">
							<?php the_content(); ?>					
						</div>						  
					</div>						  
				</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var data = localStorage.getItem("vendorData");
    console.log(data);
        document.querySelector('input[name="vendor-email"]').value = data;
    });
</script>
				<div class="contact-section">
                  		<div class="container">
                  			<?php echo do_shortcode('[contact-form-7 id="04263dd" title="Suggest a Price"]');  ?>
                  		</div>
                  </div>
</div> 

<?php get_footer(); ?>
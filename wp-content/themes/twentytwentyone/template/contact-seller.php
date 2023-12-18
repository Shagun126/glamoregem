<?php /* Template Name: Contact Seller */ ?>

<?php get_header(); ?>
<div class="main-contact-seller">
    <div class="container">
        <div class="seller-information">
            <?php the_content(); ?>  
        </div>
        <div class="contact-section">
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var data = localStorage.getItem("vendorData");
    console.log(data);
        document.querySelector('input[name="vendor-email"]').value = data;
    });
</script>
          <?php 
                // $vendorEmail = '<script>document.write(localStorage.getItem("vendorData"));</script>';
                // echo $vendorEmail;
                
                // Output your contact form shortcode
                  echo do_shortcode('[contact-form-7 id="f161479" title="Seller Form"]');
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>

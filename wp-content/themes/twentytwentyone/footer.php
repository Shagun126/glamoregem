<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>
            </main><!-- #main -->
        </div><!-- #primary -->
    </div><!-- #content -->

            <div class="main-news-translate-section"> 
                <div class="container">
                    <div class="news_translate_sr">
                        <div class="newsletter-right"><h2><?php //the_field("glamore_newsletter"); ?> GLAMORE Newsletter
 </h2>
                           <a href="#" class="shownewsletterbox">Subscribe now for free</a></div>
                        <div class="translate-left"><h2><?php //the_field("settings"); ?>Settings</h2><?php echo do_shortcode( '[gtranslate]' ) ?></div>
                    </div>
                </div>
            </div>

    <?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>


<script>
    jQuery(document).ready(function() {
        // Add a class to the body element when hovering over a parent menu item with a submenu
        jQuery('.mega-menu-item-has-children').hover(function () {
            jQuery('body').addClass('submenu-hovered');
        }, function () {
            jQuery('body').removeClass('submenu-hovered');
        });




    // Handle click event on the button
    jQuery('.js-security-more-link').click(function() {
        // Scroll to the second tab
        jQuery('html, body').animate({
            scrollTop: jQuery('#tab-title-description').offset().top
        }, 2000); // You can adjust the duration of the scroll animation (in milliseconds)

        // Open the second tab
        jQuery('#tab-title-description a').click();
    });
});

</script>

</body>
</html>

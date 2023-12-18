<?php
/**
 * Displays the site header.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

$wrapper_classes  = 'site-header';
$wrapper_classes .= has_custom_logo() ? ' has-logo' : '';
$wrapper_classes .= ( true === get_theme_mod( 'display_title_and_tagline', true ) ) ? ' has-title-and-tagline' : '';
$wrapper_classes .= has_nav_menu( 'primary' ) ? ' has-menu' : '';
?>


<header id="masthead" class="<?php echo esc_attr( $wrapper_classes ); ?>">
	<div class="header_top">
		<div class="container">

		<?php get_template_part( 'template-parts/header/site-branding' ); ?>
		<!-- <?php echo do_shortcode( '[ivory-search id="312" title="Custom Search Form"]' ) ?> -->
        <?php echo do_shortcode( '[smart_search id="1"]' ) ?> 

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var searchFormContainer = document.getElementById('search-form-container');
        var showSearchIcon = document.getElementById('show-search-icon');

        if (searchFormContainer && showSearchIcon) {
            // Show/hide search form on icon click
            showSearchIcon.addEventListener('click', function () {
                if (searchFormContainer.style.display === 'none') {
                    searchFormContainer.style.display = 'block';
                } else {
                    searchFormContainer.style.display = 'none';
                }
            });

            // Close search form when clicking outside the form
            document.addEventListener('click', function (event) {
                if (!searchFormContainer.contains(event.target) && event.target !== showSearchIcon) {
                    searchFormContainer.style.display = 'none';
                }
            });
        }
    });
</script>
   <style>
   #search-container {
    position: relative;
}

#show-search-icon {
    cursor: pointer;
}

#search-form-container {
    position: absolute;
    top: 30px; /* Adjust the position as needed */
    right: 0;
    padding: 10px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: none;
}
</style>   
<div class="main-notify-logut">
    <div id="search-container">
    <span id="show-search-icon" class="fa fa-search"></span>
    <div id="search-form-container" style="display: none;">
         <?php echo do_shortcode( '[smart_search id="1"]' ) ?> 
    </div>
</div>
<?php if (is_user_logged_in()) : ?>
    
    <div class="custom-notify-site-header"><?php echo do_shortcode ('[wp-notification-bell]'); ?></div>
    <div class="custom-logout site-header">
        <?php
        // Get the current user's information
        $current_user = wp_get_current_user();
        // Get the first letter of the user's login name
        $first_letter = strtoupper(substr($current_user->user_login, 0, 1));
        ?>
        <div class="user-dropdown">
            <span class="user-name"><?php echo esc_html($first_letter); ?></span>
            <ul class="dropdown-menu">
                <?php do_action('woocommerce_account_navigation'); ?>
            </ul>
        </div>
    </div>
</div>
    <script>
        // JavaScript/jQuery code for toggling class on user name click and closing menu on body click
        var dropdownMenu = document.querySelector('.dropdown-menu');
        var userDropdown = document.querySelector('.user-dropdown');

        document.querySelector('.user-name').addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent body click event from triggering immediately
            dropdownMenu.classList.toggle('open');
        });

        document.body.addEventListener('click', function(event) {
            if (!userDropdown.contains(event.target)) {
                dropdownMenu.classList.remove('open');
            }
        });
    </script>

<?php else : ?>
    <div class="custom-login"> <a href="<?php echo home_url('/my-account'); ?>">Login</a> </div>
<?php endif; ?>





<!-- 	    <div class="custom-login-register"><a href="http://glamoregems.com/my-account"><img src="http://glamoregems.com/wp-content/uploads/2023/10/Group-1.png"> Log in or register</a></div> -->
	</div>
	</div>
	<div class="header_bottom_menu">
		<div class="container">
	<?php get_template_part( 'template-parts/header/site-nav' ); ?>
</div>
	</div>
</header><!-- #masthead -->

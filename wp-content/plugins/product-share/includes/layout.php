<div class="wrap">

<h1>
    <?php echo esc_attr__('Social Share for WooCommerce Settings', 'product-share') ?> 
    <?php echo apply_filters( 'psfw_version_title', sprintf( '<small class="wpx-version-title">%s</small>', esc_attr( product_share()->version() ) ) ); ?>
        
</h1>
<?php settings_errors(); ?>

<?php
    // Hook below Plugin title
    do_action('wpx_notice_display');

    //Get the active plugin page from the $_GET param
    $plugin_name = isset($_GET['page']) ? $_GET['page'] : '';
    
    //Get the active tab from the $_GET param
    $default_tab = null;
    $curTab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;

    do_action('psfw_layout_start');
?>

<!-- Here are our tabs -->
<nav class="nav-tab-wrapper">
<?php 
    $tab = "<a href='?page=product-share' class='nav-tab ".($curTab===null ? 'nav-tab-active' : null)."'> ".__('General', 'product-share')."</a>";
    $tab .= "<a href='?page=product-share&tab=advanced' class='nav-tab ".($curTab==='advanced' ? 'nav-tab-active' : null)."'> ".__(WPXtension_Setting_Fields::pro_not_exist(Product_Share::check_plugin_state('product-share-pro')).' Advanced', 'product-share')."</a>";
?>
  
  <?php echo apply_filters('psfw_admin_setting_tab', $tab, $curTab); ?>
</nav>

<div id="poststuff">

    <div id="post-body" class="metabox-holder columns-2">

        <!-- main content -->
        <div id="post-body-content">

            <form method="post" action="options.php">
                <?php //settings_fields( 'product-share-group' ); ?>
                <?php //do_settings_sections( 'product-share-group' ); ?>

                <div class="tab-content">

                    <?php 

                        // print_r( array_merge( (array) get_option('product_share_option'), (array) get_option('product_share_option_advanced') ) );

                        do_action('psfw_setting_tab_content', $plugin_name, $curTab); 

                    ?>

                </div>

                <p class="submit submitbox psfw-setting-btn">
                    
                    <?php 

                    submit_button( __( 'Save Settings', 'product-share' ), 'primary', 'psfw-save-settings', false); 

                    // Making Nonce URL for Reset Link

                    $current_page = 'product-share';
                    $current_tab = $curTab;

                    $reset_url_args = array(
                        'action'   => 'reset',
                        '_wpnonce' => wp_create_nonce( 'psfw-settings' ),
                    );

                    $action_url_args = array(
                        'page'    => $current_page,
                        'tab'     => $current_tab,
                    );

                    $reset_url  = add_query_arg( wp_parse_args( $reset_url_args, $action_url_args ), admin_url( 'admin.php' ) );

                    ?>
                    
                    <a onclick="return confirm('<?php esc_html_e( 'Are you sure to reset?', 'product-share' ) ?>')" class="submitdelete" href="<?php echo esc_url( $reset_url ) ?>"><?php esc_attr_e( 'Reset Current Tab', 'woocommerce' ); ?></a>
                </p>
                

            </form>

        </div>
        <!-- post-body-content -->

        <!-- sidebar -->
        <?php 

            WPXtension_Sidebar::sidebar_start(); 

            do_action( 'psfw_settings_sidebar_start' );

            // Documentation Block
            WPXtension_Sidebar::block(
                'dashicons dashicons-text-page',
                'Documentation',
                'To know more about settings, Please check our <a href="https://wpxtension.com/doc-category/social-share-for-woocommerce/" target="_blank">documentation</a>'
            ); 

            // Help & Support Block
            WPXtension_Sidebar::block(
                'dashicons dashicons-editor-help',
                'Help & Support',
                'Still facing issues with Social Share for WooCommerce? Please <a href="https://wpxtension.com/submit-a-ticket/" target="_blank">open a ticket.</a>'
            ); 

            // Rating Block
            WPXtension_Sidebar::block(
                'dashicons dashicons-star-filled',
                'Love Our Plugin?',
                'We feel honored when you use our plugin on your site. If you have found our plugin useful and makes you smile, please consider giving us a <a href="https://wordpress.org/support/plugin/product-share/reviews/" target="_blank">5-star rating on WordPress.org</a>. It will inspire us a lot.'
            ); 

            // Shortcode Block
            WPXtension_Sidebar::block(
                'dashicons dashicons-shortcode',
                'Shortcode',
                '<p>Not working with your page builder? or, want to display it in a different position on the Single Product page? Use this shortcode-</p> <code>[psfw_basic_share]</code>'
            ); 

            do_action( 'psfw_settings_sidebar_end' );

            WPXtension_Sidebar::sidebar_end(); 

        ?>
        <!-- #sidebar -->

    </div>
</div>

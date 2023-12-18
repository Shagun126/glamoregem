<section class="advnaced" id="psfw-advanced-section">

<h3><?php esc_attr_e('Icon Title Style Settings', 'product-share'); ?></h3>

<table class="widefat wpx-table">
    <?php

        // Icon Title Color
        WPXtension_Setting_Fields::text(
            $options = array(
                'tr_class' => 'alternate',
                'label' => esc_attr__('Title Text', 'product-share'),
                'value' => Product_Share::get_options()->title_text,
                'name' => 'product_share_option_advanced[title_text]',
                'default_value' => Product_Share::get_options()->title_text,
                'note' => esc_attr__('', 'product-share'),
                'note_info' => esc_attr__('Note: Set your own title here. Default is "Share On:"', 'product-share'),
                'need_pro' => true,
                'tag' => esc_attr__('New', 'product-share'),
                'placeholder' => __('Share On:', 'product-share'),
                'pro_exists' => Product_Share::check_plugin_state('product-share-pro'),
            )
        ); 

        // Icon Title Font Weight
        WPXtension_Setting_Fields::select(
            $options = array(
                'tr_class' => '',
                'label' => esc_attr__('Text Weight', 'product-share'),
                'value' => Product_Share::get_options()->title_weight,
                'name' => 'product_share_option_advanced[title_weight]',
                'option' => apply_filters('psfw_title_weight', array(
                    'option_1' => array(
                        'name' => 'Normal',
                        'value' => 'normal',
                        'need_pro' => true,
                    ),
                    'option_2' => array(
                        'name' => 'Lighter',
                        'value' => 'lighter',
                        'need_pro' => true,
                    ),
                    'option_3' => array(
                        'name' => 'Bold',
                        'value' => 'bold',
                        'need_pro' => true,
                    ),
                )),
                'note' => '',
                'need_pro' => true,
                'tag' => esc_attr__('New', 'product-share'),
                'pro_exists' => Product_Share::check_plugin_state('product-share-pro'),
            )
        );

        // Button Text Size
        WPXtension_Setting_Fields::number(
            $options = array(
                'tr_class' => 'alternate',
                'label' => esc_attr__('Font Size', 'product-share'),
                'value' => Product_Share::get_options()->title_font_size,
                'name' => 'product_share_option_advanced[title_font_size]',
                'default_value' => Product_Share::get_options()->title_font_size,
                'note' => esc_attr__('', 'product-share'),
                'need_pro' => true,
                'tag' => esc_attr__('New', 'product-share'),
                'pro_exists' => Product_Share::check_plugin_state('product-share-pro'),
            )
        ); 

        // Icon Title Color
        WPXtension_Setting_Fields::color(
            $options = array(
                'tr_class' => '',
                'label' => esc_attr__('Title Color', 'product-share'),
                'value' => Product_Share::get_options()->title_color,
                'name' => 'product_share_option_advanced[title_color]',
                'default_value' => Product_Share::get_options()->title_color,
                'note' => esc_attr__('', 'product-share'),
                'need_pro' => true,
                'tag' => esc_attr__('New', 'product-share'),
                'pro_exists' => Product_Share::check_plugin_state('product-share-pro'),
            )
        ); 
    ?>
</table>

<h3><?php esc_attr_e('Tooltip Style Settings', 'product-share'); ?></h3>

<table class="widefat wpx-table">

    <?php 

        // Tooltip Text Color
        WPXtension_Setting_Fields::color(
            $options = array(
                'tr_class' => 'alternate',
                'label' => esc_attr__('Tooltip Text Color', 'product-share'),
                'value' => Product_Share::get_options()->tooltip_color,
                'name' => 'product_share_option_advanced[tooltip_color]',
                'default_value' => Product_Share::get_options()->tooltip_color,
                'note' => esc_attr__('', 'product-share'),
                'need_pro' => true,
                'pro_exists' => Product_Share::check_plugin_state('product-share-pro'),
            ),
        ); 

        // Tooltip Background Color
        WPXtension_Setting_Fields::color(
            $options = array(
                'tr_class' => '',
                'label' => esc_attr__('Tooltip Background Color', 'product-share'),
                'value' => Product_Share::get_options()->tooltip_bg_color,
                'name' => 'product_share_option_advanced[tooltip_bg_color]',
                'default_value' => Product_Share::get_options()->tooltip_bg_color,
                'note' => esc_attr__('', 'product-share'),
                'need_pro' => true,
                'pro_exists' => Product_Share::check_plugin_state('product-share-pro'),
            ),
        ); 
    ?>

</table>

<h3><?php esc_attr_e('Basic Style Settings', 'product-share'); ?></h3>

<table class="widefat wpx-table">

    <?php 

        // Button Background Color
        WPXtension_Setting_Fields::color(
            $options = array(
                'tr_class' => 'alternate',
                'label' => esc_attr__('Background Color', 'product-share'),
                'value' => Product_Share::get_options()->btn_background_color,
                'name' => 'product_share_option_advanced[btn_background_color]',
                'default_value' => Product_Share::get_options()->btn_background_color,
                'note' => esc_attr__('', 'product-share'),
                'need_pro' => true,
                'pro_exists' => Product_Share::check_plugin_state('product-share-pro'),
            )
        ); 

        // Button Border color
        WPXtension_Setting_Fields::color(
            $options = array(
                'tr_class' => '',
                'label' => esc_attr__('Border Color', 'product-share'),
                'value' => Product_Share::get_options()->btn_border_color,
                'name' => 'product_share_option_advanced[btn_border_color]',
                'default_value' => Product_Share::get_options()->btn_border_color,
                'note' => esc_attr__('', 'product-share'),
                'need_pro' => true,
                'pro_exists' => Product_Share::check_plugin_state('product-share-pro'),
            )
        ); 

        // Button Text color
        WPXtension_Setting_Fields::color(
            $options = array(
                'tr_class' => 'alternate',
                'label' => esc_attr__('Text Color', 'product-share'),
                'value' => Product_Share::get_options()->btn_text_color,
                'name' => 'product_share_option_advanced[btn_text_color]',
                'default_value' => Product_Share::get_options()->btn_text_color,
                'note' => esc_attr__('', 'product-share'),
                'need_pro' => true,
                'pro_exists' => Product_Share::check_plugin_state('product-share-pro'),
            )
        ); 

        // Button Text Size
        WPXtension_Setting_Fields::number(
            $options = array(
                'tr_class' => '',
                'label' => esc_attr__('Font Size', 'product-share'),
                'value' => Product_Share::get_options()->btn_font_size,
                'name' => 'product_share_option_advanced[btn_font_size]',
                'default_value' => Product_Share::get_options()->btn_font_size,
                'note' => esc_attr__('', 'product-share'),
                'need_pro' => true,
                'pro_exists' => Product_Share::check_plugin_state('product-share-pro'),
            )
        ); 

        // Button Width
        WPXtension_Setting_Fields::number(
            $options = array(
                'tr_class' => 'alternate',
                'label' => esc_attr__('Width', 'product-share'),
                'value' => Product_Share::get_options()->btn_width,
                'name' => 'product_share_option_advanced[btn_width]',
                'default_value' => Product_Share::get_options()->btn_width,
                'note' => esc_attr__('', 'product-share'),
                'need_pro' => true,
                'pro_exists' => Product_Share::check_plugin_state('product-share-pro'),
            ),
        ); 

        // Button Height
        WPXtension_Setting_Fields::number(
            $options = array(
                'tr_class' => '',
                'label' => esc_attr__('Height', 'product-share'),
                'value' => Product_Share::get_options()->btn_height,
                'name' => 'product_share_option_advanced[btn_height]',
                'default_value' => Product_Share::get_options()->btn_height,
                'note' => esc_attr__('', 'product-share'),
                'need_pro' => true,
                'pro_exists' => Product_Share::check_plugin_state('product-share-pro'),
            )
        ); 

    ?>

</table>

<h3><?php esc_attr_e('Hover Style Settings', 'product-share'); ?></h3>

<table class="widefat wpx-table">

    <?php 

        // Button Background Color
        WPXtension_Setting_Fields::color(
            $options = array(
                'tr_class' => 'alternate',
                'label' => esc_attr__('Background Color', 'product-share'),
                'value' => Product_Share::get_options()->btn_hover_background_color,
                'name' => 'product_share_option_advanced[btn_hover_background_color]',
                'default_value' => Product_Share::get_options()->btn_hover_background_color,
                'note' => esc_attr__('', 'product-share'),
                'need_pro' => true,
                'pro_exists' => Product_Share::check_plugin_state('product-share-pro'),
            )
        ); 

        // Button Border color
        WPXtension_Setting_Fields::color(
            $options = array(
                'tr_class' => '',
                'label' => esc_attr__('Border Color', 'product-share'),
                'value' => Product_Share::get_options()->btn_hover_border_color,
                'name' => 'product_share_option_advanced[btn_hover_border_color]',
                'default_value' => Product_Share::get_options()->btn_hover_border_color,
                'note' => esc_attr__('', 'product-share'),
                'need_pro' => true,
                'pro_exists' => Product_Share::check_plugin_state('product-share-pro'),
            ),
        ); 

        // Button Text color
        WPXtension_Setting_Fields::color(
            $options = array(
                'tr_class' => 'alternate',
                'label' => esc_attr__('Text Color', 'product-share'),
                'value' => Product_Share::get_options()->btn_hover_text_color,
                'name' => 'product_share_option_advanced[btn_hover_text_color]',
                'default_value' => Product_Share::get_options()->btn_hover_text_color,
                'note' => esc_attr__('', 'product-share'),
                'need_pro' => true,
                'pro_exists' => Product_Share::check_plugin_state('product-share-pro'),
            )
        ); 

    ?>

</table>

</section>
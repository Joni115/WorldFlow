<?php

global $submenu;

if (isset($submenu['td_theme_welcome'])) {
    $td_welcome_menu_items = $submenu['td_theme_welcome'];
}

$td_theme_desc = '#1 Selling News Theme of All Time';
if ('Newsmag' === TD_THEME_NAME) {
    $td_theme_desc = 'Top Selling Magazine WordPress Theme';
}

if (!empty($td_welcome_menu_items) && is_array($td_welcome_menu_items)) {
    $td_brand_url = ( defined('TD_WL_PLUGIN_DIR') && td_util::get_option('tds_white_label') !== '' ) ? td_util::get_wl_val('tds_wl_logo_url', 'https://tagdiv.com?utm_source=theme&utm_medium=logo&utm_campaign=tagdiv&utm_content=click_hp') : 'https://tagdiv.com?utm_source=theme&utm_medium=logo&utm_campaign=tagdiv&utm_content=click_hp';
    $td_brand_logo = ( defined('TD_WL_PLUGIN_DIR') && td_util::get_option('tds_white_label') !== '' ) ? td_util::get_wl_val('tds_wl_logo', get_template_directory_uri()  . '/includes/wp-booster/wp-admin/images/plugins/tagdiv-small.png') : get_template_directory_uri()  . '/includes/wp-booster/wp-admin/images/plugins/tagdiv-small.png';
    $td_theme = ( defined('TD_WL_PLUGIN_DIR') && td_util::get_option('tds_white_label') !== '' ) ? td_util::get_wl_val('tds_wl_theme_name', TD_THEME_NAME) : TD_THEME_NAME;
if ( defined('TD_COMPOSER' ) ) {
    if ( isset( $_GET['page'] ) && $_GET['page'] !== 'td_theme_welcome' && class_exists('td_util') && td_util::get_option('td_banners_status') !== 'off' ) {
    ?>
        <a style="display:block; margin:25px 40px 0 5px;max-width: 1050px;" class="td-services-link" title="Get free quote" href="https://tagdiv.com/submit-a-request/?utm_source=welcome_panel&utm_medium=banner&utm_campaign=custom_work&utm_content=NP_gen_top" target="_blank">
            <img style="width:100%;" class="td-services-img" alt="" src="#">
        </a>
   <?php
    }
}?>
    <div class="about-wrap td-wp-admin-header ">

        <div class="td-wp-admin-top">
            <a class="td-tagdiv-link" href="<?php echo $td_brand_url ?>"><img class="td-tagdiv-brand" src="<?php echo $td_brand_logo ?>" /></a>
            <div class="td-wp-admin-theme">
                <h1>Welcome to WorldFlow</h1>
                <!-- <span><?php echo $td_theme_desc ?></span> -->
            </div>
            <div class="td-welcome-version">Version: <b><?php echo TD_THEME_VERSION ?></b>
            </div>
        </div>
    </div>
    <?php
}

?>



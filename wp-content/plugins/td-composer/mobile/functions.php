<?php
/**
 * Mobile theme
 * Created by ra.
 * Date: 10/23/2015
 */

require_once('includes/td_global_mob.php');

// the deploy mode
require_once (td_global_mob::$get_parent_template_directory . '/tagdiv-deploy-mode.php');

require_once (td_global_mob::$get_parent_template_directory . '/includes/tagdiv-config.php');

do_action( 'tdm_functions' );

if ( ! defined( 'TDC_PATH_LEGACY' ) ) {
	define( 'TDC_PATH_LEGACY', TDC_PATH . '/legacy/' . TD_THEME_NAME );
}

if ( ! defined( 'TDC_URL_LEGACY' ) ) {
	define( 'TDC_URL_LEGACY', TDC_URL . '/legacy/' . TD_THEME_NAME );
}

if ( ! defined( 'TDC_PATH_LEGACY_COMMON' ) ) {
	define( 'TDC_PATH_LEGACY_COMMON', TDC_PATH . '/legacy/common' );
}

if ( ! defined( 'TDC_URL_LEGACY_COMMON' ) ) {
	define( 'TDC_URL_LEGACY_COMMON', TDC_URL . '/legacy/common' );
}

if ( ! defined( 'TDC_SCRIPTS_URL' ) ) {
    define( 'TDC_SCRIPTS_URL', ( TD_DEPLOY_MODE == 'dev' ? TDC_URL_LEGACY_COMMON . '/wp_booster/js_dev' : TDC_URL_LEGACY . '/js' ) );
}

if ( ! defined( 'TDC_SCRIPTS_VER' ) ) {
    define( 'TDC_SCRIPTS_VER', '?ver=' . TD_THEME_VERSION );
}

// theme config
require_once (TDC_PATH_LEGACY . '/includes/td_config.php');
require_once (TDC_PATH_LEGACY . '/includes/td_config_helper.php');
require_once ('includes/td_config_mob.php');
add_action('td_wp_booster_loaded', array('td_config_mob', 'on_td_global_after_config'), 11);

// theme fonts
require_once (TDC_PATH_LEGACY_COMMON . '/wp_booster/td_fonts.php');

require_once('includes/shortcodes/td_misc_shortcodes.php'); // buttons shortcodes

// theme utility files
require_once(TDC_PATH_LEGACY_COMMON . '/wp_booster/td_global.php');
require_once(TDC_PATH_LEGACY_COMMON . '/wp_booster/td_options.php');
require_once(TDC_PATH_LEGACY_COMMON . '/wp_booster/td_util.php');

// the wp_booster_api
require_once(TDC_PATH_LEGACY_COMMON . '/wp_booster/td_api.php');

/**
 * add wp blocks editor(gutenberg) assets
 * .. is loaded from the mob theme plugin @see td-mobile-plugin.php because we need this to always run.. not just on mob theme setup
 */
//require_once('/includes/td_block_editor_assets_mob.php');

// hook here to use the theme api
do_action('td_global_after');

if ( td_util::get_option('tdm_amp') !== '' && td_util::is_amp_plugin_installed() ) {
	require_once('amp/functions.php');
}

require_once(TDC_PATH_LEGACY_COMMON . '/wp_booster/td_global_blocks.php'); // module builder
require_once(TDC_PATH_LEGACY_COMMON . '/wp_booster/td_social_icons.php'); // no autoload (almost always needed) - The social icons
require_once(TDC_PATH_LEGACY_COMMON . '/wp_booster/td_unique_posts.php');
require_once(TDC_PATH_LEGACY_COMMON . '/wp_booster/td_js_buffer.php'); // no autoload - the theme always outputs JS form this buffer
require_once(TDC_PATH_LEGACY_COMMON . '/wp_booster/td_block_widget.php');
require_once(TDC_PATH_LEGACY_COMMON . '/wp_booster/td_block_template.php');

require_once('includes/td_js_generator_mob.php'); // no autoload - the theme always outputs JS

require_once(TDC_PATH_LEGACY_COMMON . '/wp_booster/td_autoload_classes.php'); //used to autoload classes [modules, blocks]
require_once(TDC_PATH_LEGACY_COMMON . '/wp_booster/td_module.php'); // module builder
require_once(TDC_PATH_LEGACY_COMMON . '/wp_booster/td_block.php'); // module builder

// the file location was changed from booster to legacy
require_once(TDC_PATH_LEGACY_COMMON . '/wp_booster/td_video_support.php');

require_once('includes/td_css_generator_mob.php'); // css generator - outputs the css generated by the theme panel settings

td_api_autoload::add('td_category_template',        TDC_PATH_LEGACY_COMMON . '/wp_booster/td_category_template.php');
td_api_autoload::add('td_category_top_posts_style', TDC_PATH_LEGACY_COMMON . '/wp_booster/td_category_top_posts_style.php');
td_api_autoload::add('td_block_layout',             TDC_PATH_LEGACY_COMMON . '/wp_booster/td_block_layout.php');
td_api_autoload::add('td_module_single_base',       TDC_PATH_LEGACY_COMMON . '/wp_booster/td_module_single_base.php');
td_api_autoload::add('td_data_source',              TDC_PATH_LEGACY_COMMON . '/wp_booster/td_data_source.php');
td_api_autoload::add('td_page_generator',           TDC_PATH_LEGACY_COMMON . '/wp_booster/td_page_generator.php');
td_api_autoload::add('td_template_layout',          TDC_PATH_LEGACY_COMMON . '/wp_booster/td_template_layout.php');
td_api_autoload::add('td_review',                   TDC_PATH_LEGACY_COMMON . '/wp_booster/td_review.php');
td_api_autoload::add('td_css_inline',               TDC_PATH_LEGACY_COMMON . '/wp_booster/td_css_inline.php');
td_api_autoload::add('td_smart_list',               TDC_PATH_LEGACY_COMMON . '/wp_booster/td_smart_list.php');
td_api_autoload::add('td_remote_cache',             TDC_PATH_LEGACY_COMMON . '/wp_booster/td_remote_cache.php');
td_api_autoload::add('td_css_compiler',             TDC_PATH_LEGACY_COMMON . '/wp_booster/td_css_compiler.php');
td_api_autoload::add('td_log',                      TDC_PATH_LEGACY_COMMON . '/wp_booster/td_log.php');
td_api_autoload::add('td_css_buffer',               TDC_PATH_LEGACY_COMMON . '/wp_booster/td_css_buffer.php');
td_api_autoload::add('td_page_views',               TDC_PATH_LEGACY_COMMON . '/wp_booster/td_page_views.php');
td_api_autoload::add('td_css_res_compiler',         TDC_PATH_LEGACY_COMMON . '/wp_booster/td_css_res_compiler.php');
td_api_autoload::add('td_social_sharing',           TDC_PATH_LEGACY_COMMON . '/wp_booster/td_social_sharing.php');
td_api_autoload::add('td_page_generator_mob',       get_template_directory() . '/includes/td_page_generator_mob.php');
td_api_autoload::add('td_ajax_mob',                 get_template_directory() . '/includes/td_ajax_mob.php');
td_api_autoload::add('td_walker_mobile_menu',       get_template_directory() . '/parts/td_walker_mobile_menu.php');

// ajax: site wide search
add_action('wp_ajax_nopriv_td_ajax_search', array('td_ajax_mob', 'on_ajax_search'));
add_action('wp_ajax_td_ajax_search',        array('td_ajax_mob', 'on_ajax_search'));


do_action('td_wp_booster_loaded'); //used by our plugins

/* ----------------------------------------------------------------------------
 * add lazy shortcodes of the registered blocks
 */
foreach ( td_api_block::get_all() as $block_settings_key => $block_settings_value ) {
	tdc_global_blocks::add_lazy_shortcode( $block_settings_key );
}

/* ----------------------------------------------------------------------------
 * add woocommerce support
 */
add_action( 'after_setup_theme', 'td_on_after_setup_theme' );
function td_on_after_setup_theme() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'html5', array('caption'));
    add_theme_support( 'title-tag' );
}

/* ----------------------------------------------------------------------------
 * backwards compatibility with WordPress older versions
 */
if ( ! function_exists('_wp_render_title_tag' ) ) {
    function theme_slug_render_title() {
        echo '<title>' . wp_title('|', false, 'right') . '</title>';
    }
    add_action('wp_head', 'theme_slug_render_title');
}

/* ----------------------------------------------------------------------------
 * front end css files
 */
add_action('wp_enqueue_scripts', 'tdm_load_front_css');
function tdm_load_front_css() {
	if ( TD_DEBUG_USE_LESS ) {

		if ( td_util::is_amp() ) {
			wp_enqueue_style('td-theme', get_stylesheet_uri(), '', TD_THEME_VERSION, 'all' );
			wp_enqueue_style('td-theme-amp', get_stylesheet_directory_uri(). '/style-amp.css', '', TD_THEME_VERSION, 'all' );
		} else {
			wp_enqueue_style('td-theme', TDC_URL . '/td_less_style.css.php?part=style.css_mobile',  '', TD_THEME_VERSION, 'all' );
		}

	} else {
		wp_enqueue_style('td-theme', get_stylesheet_uri(), '', TD_THEME_VERSION, 'all' );

		if ( td_util::is_amp() ) {
			wp_enqueue_style('td-theme-amp', get_stylesheet_directory_uri(). '/style-amp.css', '', TD_THEME_VERSION, 'all' );
			//wp_enqueue_style('td-theme-amp-main', get_stylesheet_directory_uri(). '/css/amp_main.css', '', TD_THEME_VERSION, 'all' );
		}
	}
}

/* ----------------------------------------------------------------------------
 * front end javascript files
 */
add_action('wp_enqueue_scripts', 'load_front_js');
function load_front_js() {
    $td_deploy_mode = TD_DEPLOY_MODE;

    //switch the deploy mode to demo if we have tagDiv speed booster
    if ( defined('TD_SPEED_BOOSTER' ) ) {
        $td_deploy_mode = 'demo';
    }

    switch ( $td_deploy_mode ) {
        default: //deploy
            wp_enqueue_script( 'td-site', TDC_URL . '/mobile/js/tagdiv_theme.min.js', array('jquery'), TD_THEME_VERSION, true );
            break;

        case 'dev':

            // dev version - load each file separately - from legacy
            $last_js_file_id = '';
            foreach ( td_global_mob::$js_files as $js_file_id => $js_file ) {
                if ( $last_js_file_id == '' ) {
	                //first, load it with jQuery dependency
                    wp_enqueue_script( $js_file_id, TDC_URL . $js_file, array( 'jquery' ), TD_THEME_VERSION, true );
                } else {
	                //not first - load with the last file dependency
                    wp_enqueue_script( $js_file_id, TDC_URL . $js_file, array( $last_js_file_id ), TD_THEME_VERSION, true );
                }
                $last_js_file_id = $js_file_id;
            }
            // dev version - load each file separately - from main theme
            $last_js_file_id = '';
            foreach ( td_global_mob::$js_files_main as $js_file_id => $js_file ) {
                if ( $last_js_file_id == '' ) {
	                //first, load it with jQuery dependency
                    wp_enqueue_script( $js_file_id, TDC_URL . $js_file, array( 'jquery' ), TD_THEME_VERSION, true );
                } else {
	                //not first - load with the last file dependency
                    wp_enqueue_script( $js_file_id, TDC_URL . $js_file, array( $last_js_file_id ), TD_THEME_VERSION, true );
                }
                $last_js_file_id = $js_file_id;
            }
            break;

    }

    //add the comments reply to script on single pages
    if ( is_singular() ) {
        wp_enqueue_script('comment-reply');
    }
}

/* ----------------------------------------------------------------------------
 * localization
 */
add_action('after_setup_theme', 'td_load_text_domains');
function td_load_text_domains() {
	load_theme_textdomain( strtolower( TD_THEME_NAME ), td_global_mob::$get_parent_template_directory . '/translation' );

	// theme specific config values
	require_once( TDC_PATH_LEGACY_COMMON . '/wp_booster/td_translate.php' );
}

/* ----------------------------------------------------------------------------
 * this hook sets the global panel limit and the grid posts number(as offset - on categories) for loop posts
 */
add_action('pre_get_posts', function( $query ) {

	// checking for category page and main query
	if( ! is_admin() and $query->is_main_query() ) {

		// check the panel global posts limit for latest articles sections to determine how many posts we need to set for the  main loop
		$tdm_frontpage_latest_articles_posts_limit = td_util::get_option('tdm_frontpage_latest_articles_posts_limit' );

		// if available, set the latest articles loop posts limit to user's panel setting
		if ( ! empty( $tdm_frontpage_latest_articles_posts_limit ) ) {
			$query->set( 'posts_per_page', $tdm_frontpage_latest_articles_posts_limit );
		}

		if ( is_category() ) {

			// get the category object - with or without permalinks
			if ( empty( $query->query_vars['cat'] ) ) {
				// when we have permalinks, we have to get the category object like this.
				td_global::$current_category_obj = get_category_by_path( get_query_var('category_name'), false );
			} else {
				td_global::$current_category_obj = get_category( $query->query_vars['cat'] );
			}

			// we are on a category page with an ID that doesn't exists - wp will show a 404 and we do nothing
			if ( is_null( td_global::$current_category_obj ) ) {
				return;
			}

			// get the number of page where on
			$paged = get_query_var('paged');

			// get the limit of posts on the category page
			if ( ! empty( $tdm_frontpage_latest_articles_posts_limit ) ) {
				$limit = td_util::get_option('tdm_frontpage_latest_articles_posts_limit' );
			} else {
				$limit = get_option('posts_per_page');
			}

			// check the panel global posts limit for grids to determine how many posts are we showing in the big grid for this category ( if no user setting.. use the config value )
			$tdm_grids_posts_limit = td_util::get_option('tdm_grids_posts_limit');
			$offset = ( !empty( $tdm_grids_posts_limit ) ? $tdm_grids_posts_limit : td_api_category_top_posts_style::get_key( 'td_category_top_posts_style_mob_1', 'posts_shown_in_the_loop' ) );

			// check the cat grid status
			$tdm_category_grid = td_util::get_option('tdm_category_grid');

			// offset + custom pagination - if we have offset, WordPress overwrites the pagination and works with offset + limit
			// if the grid is disabled from category pages we don't need to set the offset
			if( empty( $query->is_feed ) && $tdm_category_grid !== 'hide' ) {
				if ( $paged > 1 ) {
					$query->set( 'offset', intval($offset) + ( ( $paged - 1 ) * $limit ) );
				} else {
					$query->set( 'offset', intval($offset) );
				}
			}

		}

	}

});


/* ----------------------------------------------------------------------------
 * the footer bottom code ( panel custom css/ theme data/ ajax post view count update on single posts
 */
add_action('wp_footer', 'td_bottom_code');
function td_bottom_code() {
    global $post;

    // try to detect speed booster
    $speed_booster = '';
    if ( defined('TD_SPEED_BOOSTER') ) {
        $speed_booster = 'Speed booster: ' . TD_SPEED_BOOSTER . "\n";
    }

    echo '
    <!--
        Theme: ' . TD_THEME_NAME . ' Mobile Theme by tagDiv 2024
        Version: ' . TD_THEME_VERSION . ' (rara)
        Deploy mode: ' . TD_DEPLOY_MODE . '
        ' . $speed_booster . '
        uid: ' . uniqid() . '
    -->
    ';

    // get panel user custom css
    $td_custom_css_mob = stripslashes( td_util::get_option( 'tds_custom_css_mob' ) );
    $td_custom_css_mob = strip_tags( $td_custom_css_mob );

    // check if we have to show any css
    if ( ! empty( $td_custom_css_mob ) ) {
        $css_buffy = PHP_EOL . '<!-- Custom css from theme panel > mobile theme -->';
        $css_buffy .= PHP_EOL . '<style type="text/css" media="screen">';

        //paste custom css
        if( !empty( $td_custom_css_mob ) ) {
            $css_buffy .= PHP_EOL . '/* custom css theme panel */' . PHP_EOL;
            $css_buffy .= $td_custom_css_mob . PHP_EOL;
        }

        $css_buffy .= '</style>' . PHP_EOL . PHP_EOL;

        // echo the css buffer
        echo $css_buffy;
    }

    // posts view count with ajax
    if( td_util::get_option('tds_ajax_post_view_count') == 'enabled' ) {

        // ajax get & update counter views
        if( is_single() ) {
            if( $post->ID > 0 ) {
                td_js_buffer::add_to_footer(
                	'jQuery().ready(function jQuery_ready() {
                        tdAjaxCount.tdGetViewsCountsAjax("post",' . json_encode('[' . $post->ID . ']') . ');
                    });'
                );
            }
        }
    }
}

/* ----------------------------------------------------------------------------
 * head related links
 * @note 1 priority
 */
add_action('wp_head', 'hook_wp_head', 1);
function hook_wp_head() {
	if ( is_single() ) {
		global $post;

		// facebook sharing fix for videos, we add the custom meta data
		if ( has_post_thumbnail( $post->ID ) ) {
			$td_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			if ( ! empty( $td_image[0] ) ) {
				echo '<meta property="og:image" content="' .  $td_image[0] . '" />';
			}
		}

		// show author meta tag on single pages if it's not disabled from theme's panel
		if ( td_util::get_option( 'tds_p_show_author_name' ) != 'hide') {
			$td_post_author = get_the_author_meta( 'display_name', $post->post_author );
			if ( $td_post_author ) {
				echo '<meta name="author" content="' . $td_post_author . '">' . "\n";
			}
		}
	}

    // fav icon support
    $tds_favicon_upload = td_util::get_option('tds_favicon_upload');
    if (!empty($tds_favicon_upload)) {
        echo '<link rel="icon" type="image/png" href="' . $tds_favicon_upload . '">';
    }

	// ios bookmark icon support
	$tds_ios_76 = td_util::get_option('tds_ios_icon_76');
	$tds_ios_120 = td_util::get_option('tds_ios_icon_120');
	$tds_ios_152 = td_util::get_option('tds_ios_icon_152');
	$tds_ios_114 = td_util::get_option('tds_ios_icon_114');
	$tds_ios_144 = td_util::get_option('tds_ios_icon_144');

	if( ! empty( $tds_ios_76 ) ) {
		echo '<link rel="apple-touch-icon" sizes="76x76" href="' . $tds_ios_76 . '"/>';
	}

	if( ! empty( $tds_ios_120 ) ) {
		echo '<link rel="apple-touch-icon" sizes="120x120" href="' . $tds_ios_120 . '"/>';
	}

	if( ! empty( $tds_ios_152 ) ) {
		echo '<link rel="apple-touch-icon" sizes="152x152" href="' . $tds_ios_152 . '"/>';
	}

	if( ! empty( $tds_ios_114 ) ) {
		echo '<link rel="apple-touch-icon" sizes="114x114" href="' . $tds_ios_114 . '"/>';
	}

	if( ! empty( $tds_ios_144 ) ) {
		echo '<link rel="apple-touch-icon" sizes="144x144" href="' . $tds_ios_144 . '"/>';
	}

    //load google recaptcha js for login modal ( @td-login-modal.php )
    $show_captcha = td_util::get_option('tds_captcha');
    $captcha_domain = td_util::get_option('tds_captcha_url') !== '' ? 'www.recaptcha.net' : 'www.google.com';
    $captcha_site_key = td_util::get_option('tds_captcha_site_key');
    if ( $show_captcha == 'show' ) { ?>
        <script src="https://<?php echo $captcha_domain ?>/recaptcha/api.js?render=<?php echo $captcha_site_key ?>"></script>
    <?php }
}

/* ----------------------------------------------------------------------------
 * g analytics on head
 */
add_action('wp_head', 'td_header_analytics_code', 40);
function td_header_analytics_code() {
    $td_analytics = td_util::get_option('td_analytics');
    echo stripslashes($td_analytics);
}
/* ----------------------------------------------------------------------------
 * js after body
 */
add_action( 'td_wp_body_open', 'td_body_script_code', 40 );
function td_body_script_code() {
    $td_body_code = td_util::get_option( 'td_body_code' );
    echo stripslashes( $td_body_code );
}

/* ----------------------------------------------------------------------------
 * add global js variables
 */
add_action( 'wp_head', 'td_add_js_variable' );
function td_add_js_variable() {

	$tds_login_mobile = td_util::get_option( 'tds_login_mobile' );
	if ( empty( $tds_login_mobile ) ) {
		td_js_buffer::add_variable('tds_login_mobile', $tds_login_mobile );
	}

    $tdm_sticky_menu = td_util::get_option( 'tdm_sticky_menu' );
    if ( $tdm_sticky_menu === 'hide' ) {
        td_js_buffer::add_variable('tdm_sticky_menu', td_util::get_option('tdm_sticky_menu'));
    }

}

/* ----------------------------------------------------------------------------
 * canonical links on pages with pagination.
 * used also on AMP
 */
add_action('wp_head', 'td_on_wp_head_canonical',  1);
function td_on_wp_head_canonical(){

	global $post;

	if (is_page() && 'page-pagebuilder-latest.php' === get_post_meta($post->ID, '_wp_page_template', true)) {

		$td_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
		$td_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var

		$td_page = intval($td_page);
		$td_paged = intval($td_paged);

		//paged works on single pages, page - works on homepage
		if ($td_paged > $td_page) {
			$paged = $td_paged;
		} else {
			$paged = $td_page;
		}

		global $wp_query;

		$td_homepage_loop = td_util::get_post_meta_array($post->ID, 'td_homepage_loop');
		query_posts(td_data_source::metabox_to_args($td_homepage_loop, $paged));

		$max_page = $wp_query->max_num_pages;

		// Remove the wp action links
		remove_action('wp_head', 'rel_canonical');
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

		if (class_exists('WPSEO_Frontend')) {
			// Remove the canonical action of the Yoast SEO plugin
			add_filter( 'wpseo_canonical', '__return_false' );
		}

		$td_current_page = '<link rel="canonical" href="' . get_pagenum_link($paged) . '"/>';
		$td_prev_page = '<link rel="prev" href="' . get_pagenum_link($paged - 1) . '"/>';
		$td_next_page = '<link rel="next" href="' . get_pagenum_link($paged + 1) . '"/>';

		if ( td_util::is_amp() ){
			$td_current_page = str_replace( '?amp', "", $td_current_page);
			$td_prev_page = str_replace( '?amp', "", $td_prev_page);
			$td_next_page = str_replace( '?amp', "", $td_next_page);
		}

		echo $td_current_page;

		if ($paged > 1) {
			echo $td_prev_page;
		}
		if ($paged < $max_page) {
			echo $td_next_page;
		}

		wp_reset_query();
	}
}

/* ----------------------------------------------------------------------------
 * tagDiv gallery - front end hooks
 */
add_filter('post_gallery', 'td_gallery_shortcode', 10, 4);
function td_gallery_shortcode($output = '', $atts = [], $content = false) {
    //doesn't work on AMP
     if ( td_util::is_amp() ) {
         return;
     }

    $buffy = '';

    //check for gallery = slide
    if( !empty( $atts ) and !empty( $atts['td_select_gallery_slide'] ) and $atts['td_select_gallery_slide'] == 'slide' ) {

	    $td_double_slider2_no_js_limit = 7;
	    $td_nr_columns_slide           = 'td-slide-on-2-columns';
	    $nr_title_chars                = 95;

	    //check to see if we have or not sidebar on the page, to set the small images when need to show them on center
	    if ( td_global::$cur_single_template_sidebar_pos == 'no_sidebar' ) {
		    $td_double_slider2_no_js_limit = 11;
		    $td_nr_columns_slide           = 'td-slide-on-3-columns';
		    $nr_title_chars                = 170;
	    }

	    $title_slide = '';
	    //check for the title
	    if ( ! empty( $atts['td_gallery_title_input'] ) ) {
		    $title_slide = $atts['td_gallery_title_input'];

		    //check how many chars the tile have, if more then 84 then that cut it and add ... after
		    if ( mb_strlen( $title_slide, 'UTF-8' ) > $nr_title_chars ) {
			    $title_slide = mb_substr( $title_slide, 0, $nr_title_chars, 'UTF-8' ) . '...';
		    }
	    }

	    $slide_images_thumbs_css = '';
	    $slide_display_html      = '';
	    $slide_cursor_html       = '';

	    $image_ids = explode( ',', $atts['ids'] );

	    //check to make sure we have images
	    if ( count( $image_ids ) == 1 and ! is_numeric( $image_ids[0] ) ) {
		    return;
	    }

	    $image_ids = array_map( 'trim', $image_ids ); //trim elements of the $ids_gallery array

	    //generate unique gallery slider id
	    $gallery_slider_unique_id = td_global::td_generate_unique_id();

	    $cur_item_nr = 1;
	    foreach ( $image_ids as $image_id ) {

		    //get the info about attachment
		    $image_attachment = td_util::attachment_get_full_info( $image_id );

		    //get images url
		    $td_temp_image_url_full = $image_attachment['src']; //default big image - for magnific popup

		    //image type and width - used to retrieve retina image
		    $image_type  = 'td_0x420';
		    $image_width = '420';

		    //if we are on full wight (3 columns use the default images not the resize ones)
		    if ( td_global::$cur_single_template_sidebar_pos == 'no_sidebar' ) {

			    $td_temp_image_url = wp_get_attachment_image_src( $image_id, 'td_1021x580' ); //1021x580 images - for big slide
			    //change thumbnail type and width - used to retrieve retina image
			    $image_type  = 'td_1021x580';
			    $image_width = '1021';
		    } else {
			    $td_temp_image_url = wp_get_attachment_image_src( $image_id, 'td_0x420' ); //0x420 image sizes - for big slide
		    }


		    //check if we have all the images
		    if ( ! empty( $td_temp_image_url[0] ) and ! empty( $td_temp_image_url_full ) ) {

			    //retina image
			    $srcset_sizes = td_util::get_srcset_sizes( $image_id, $image_type, $image_width, $td_temp_image_url[0] );

			    //html for display the big image
			    $class_post_content = '';

			    if ( ! empty( $image_attachment['description'] ) or ! empty( $image_attachment['caption'] ) ) {
				    $class_post_content = 'td-gallery-slide-content';
			    }

			    //if picture has caption & description
			    $figcaption = '';

			    if ( ! empty( $image_attachment['caption'] ) or ! empty( $image_attachment['description'] ) ) {
				    $figcaption = '<figcaption class = "td-slide-caption ' . $class_post_content . '">';

				    if ( ! empty( $image_attachment['caption'] ) ) {
					    $figcaption .= '<div class = "td-gallery-slide-copywrite">' . $image_attachment['caption'] . '</div>';
				    }

				    if ( ! empty( $image_attachment['description'] ) ) {
					    $figcaption .= '<span>' . $image_attachment['description'] . '</span>';
				    }

				    $figcaption .= '</figcaption>';
			    }

			    $slide_display_html .= '
                    <div class = "td-slide-item td-item' . $cur_item_nr . '">
                        <figure class="td-slide-galery-figure td-slide-popup-gallery">
                            <a class="slide-gallery-image-link" 
	                           href="' . $td_temp_image_url_full . '" 
	                           title="' . $image_attachment['title'] . '"  
	                           data-caption="' . esc_attr( $image_attachment['caption'], ENT_QUOTES ) . '"  
	                           data-description="' . htmlentities( $image_attachment['description'], ENT_QUOTES ) . '">
	                                <img src="' . $td_temp_image_url[0] . '"' . $srcset_sizes . ' 
	                                     data-test="" 
	                                     alt="' . htmlentities( $image_attachment['alt'], ENT_QUOTES ) . '">
                            </a>
                            ' . $figcaption . '
                        </figure>
                    </div>
                ';

			    //html for display the small cursor image
			    $slide_cursor_html .= '
                    <div class = "td-button td-item' . $cur_item_nr . '">
                        <div class = "td-border"></div>
                    </div>';

			    $cur_item_nr ++;
		    }//end check for images
	    }//end foreach

	    //check if we have html code for the slider
	    if ( ! empty( $slide_display_html ) and ! empty( $slide_cursor_html ) ) {

		    //get the number of slides
		    $nr_of_slides = count( $image_ids );
		    if ( $nr_of_slides < 0 ) {
			    $nr_of_slides = 0;
		    }

		    $buffy = '
		        <div id="' . $gallery_slider_unique_id . '" class="td-gallery-slider">
                    <div class="td-gallery-title">' . $title_slide . '</div>
                    
                    <div class="td-gallery-slide-count">
                    	<span class="td-gallery-slide-item-focus">1</span> ' . __td( 'of', TD_THEME_NAME ) . ' ' . $nr_of_slides . '
                    </div>

                    <div class="post_td_gallery">
	                    <div class="td-gallery-slide-prev-next-but">
	                        <i class="td-icon-left doubleSliderPrevButton"></i>
	                        <i class="td-icon-right doubleSliderNextButton"></i>
	                    </div>
                        <div class = "td-doubleSlider-1 ">
                            <div class = "td-slider">
                                ' . $slide_display_html . '
                            </div>
                        </div>
                    </div>
                </div>
            ';

		    $slide_javascript = '
                    //total number of slides
                    var ' . $gallery_slider_unique_id . '_nr_of_slides = ' . $nr_of_slides . ';

                    jQuery(document).ready(function() {

                        jQuery("#' . $gallery_slider_unique_id . ' .td-doubleSlider-1").iosSlider({
                            scrollbar: true,
                            snapToChildren: true,
                            desktopClickDrag: true,
                            infiniteSlider: true,
                            responsiveSlides: true,
                            navPrevSelector: jQuery("#' . $gallery_slider_unique_id . ' .doubleSliderPrevButton"),
                            navNextSelector: jQuery("#' . $gallery_slider_unique_id . ' .doubleSliderNextButton"),
                            scrollbarHeight: "2",
                            scrollbarBorderRadius: "0",
                            scrollbarOpacity: "0.5",
                            onSliderResize: td_gallery_resize_update_vars_' . $gallery_slider_unique_id . ',
                            onSlideChange: doubleSlider2Load_' . $gallery_slider_unique_id . ',
                            keyboardControls:true
                        });

                        //writes the current slider beside to prev and next buttons
                        function td_gallery_write_current_slide_' . $gallery_slider_unique_id . '(slide_nr) {
                            jQuery("#' . $gallery_slider_unique_id . ' .td-gallery-slide-item-focus").html(slide_nr);
                        }

                        function doubleSlider2Load_' . $gallery_slider_unique_id . '(args) {
                            //var currentSlide = args.currentSlideNumber;
                            jQuery("#' . $gallery_slider_unique_id . ' .td-doubleSlider-2").iosSlider("goToSlide", args.currentSlideNumber);

                            //write the current slide number
                            td_gallery_write_current_slide_' . $gallery_slider_unique_id . '(args.currentSlideNumber);
                        }

                        /*
                        * Resize the iosSlider when the page is resided (fixes bug on Android devices)
                        */
                        function td_gallery_resize_update_vars_' . $gallery_slider_unique_id . '(args) {
                            if(tdDetect.isAndroid) {
                                setTimeout(function(){
                                    jQuery("#' . $gallery_slider_unique_id . ' .td-doubleSlider-1").iosSlider("update");
                                }, 1500);
                            }
                        }
                    });';

		    td_js_buffer::add_to_footer( $slide_javascript );
	    }//end check if we have html code for the slider
    }

    // @note return has to be != empty to overwrite the default output
    return $buffy;
}

/* ----------------------------------------------------------------------------
 * replace woocommerce breadcrumbs separator
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'td_change_breadcrumb_delimiter' );
function td_change_breadcrumb_delimiter( $defaults ) {
    // Change the breadcrumb delimeter from '/' to '>'
    $defaults['delimiter'] = ' <i class="td-icon-right td-bread-sep"></i> ';
    return $defaults;
}

/* ----------------------------------------------------------------------------
 * redirect_canonical pagination fix
 */
add_filter('redirect_canonical', 'td_fix_wp_441_pagination', 10, 2);
function td_fix_wp_441_pagination( $redirect_url, $requested_url ) {
	global $wp_query;

	if ( is_page() && ! is_feed() && isset( $wp_query->queried_object ) && get_query_var('page') )  {
		return false;
	}

	return $redirect_url;
}

/**
 * Important! (This was introduced because of WPML plugin which could not show the right menu on mobile theme)
 *
 * This filter was set specially for getting 'theme_mods_xxx' option, where xxx is the main theme name, instead of 'theme_mods_' option.
 * These options are used, for example, buy get_nav_menu_locations (nav_menu.php), in get_theme_mod( 'nav_menu_locations' ); (@see nav_menu.php)
 *
 * Obviously, that for given example, the mobile theme, which gets '' (empty string) for stylesheet option (because of the 'td_mobile' custom hook that is applied to the following wp hooks (as JETPACK mobile implementation does) :
 *      'stylesheet',
 *      'template',
 *      'option_template',
 *      'option_stylesheet'
 * the menu locations, uses the 'theme_mods_' option, and so .. the menu locations are not those of the main theme.
 *
 * So, we introduced this pre option for 'theme_mods' that will short-circuit get_theme_mod( 'nav_menu_locations' ) function calls.
 *
 */
add_filter('pre_option_theme_mods_', 'td_on_pre_option_theme_mods_', 10, 2);
function td_on_pre_option_theme_mods_( $default, $option ) {
	if ( $option === 'theme_mods_' ) {
		return get_option( 'theme_mods_' . td_get_actual_current_theme() );
	}
	return $default;
}


/**
 * Remove 'template_include' hook, to allow mobile theme to use its own templates
 */
remove_filter( 'template_include', 'tdc_template_include', 99);
remove_filter( 'comments_template', 'tdc_template_include', 99 );


/* ----------------------------------------------------------------------------
 * Fonts in front end
 */
add_action('wp_enqueue_scripts', 'td_load_css_fonts');
function td_load_css_fonts() {

	$cur_td_fonts = td_options::get_array('td_fonts'); // get the google fonts used by user
	$unique_google_fonts_ids = array();

	//filter the google fonts used by user
	if (!empty($cur_td_fonts)) {

		foreach ( $cur_td_fonts as $section_font_settings ) {
			if ( isset( $section_font_settings['font_family'] ) ) {
				$explode_font_family = explode( '_', $section_font_settings['font_family'] );
				if ( $explode_font_family[0] == 'g' ) {
					$unique_google_fonts_ids[] = $explode_font_family[1];
				}
			}
		}
	}

	// remove duplicated font ids
	$unique_google_fonts_ids = array_unique( $unique_google_fonts_ids );

	if ( empty($unique_google_fonts_ids) ) {
		return;
	}

	//used to pull fonts from google
	$td_fonts_css_files = '://fonts.googleapis.com/css?family=' . td_fonts::get_google_fonts_names($unique_google_fonts_ids);

	if( ! empty( $td_fonts_css_files ) ) {
		wp_enqueue_style( 'google-fonts-style', td_global::$http_or_https . $td_fonts_css_files, array(), TD_THEME_VERSION );
	}

}

add_filter( 'pre_handle_404', function($param1, $param2) {

    global $_SERVER;
    $req_scheme = is_ssl() ? 'https' : 'http';

	$post_id = url_to_postid($req_scheme . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	if ( !empty($post_id) ) {
		$td_post_theme_settings = td_util::get_post_meta_array($post_id, 'td_post_theme_settings');
		// standard smartlist
		if (is_array($td_post_theme_settings) && array_key_exists('smart_list_template', $td_post_theme_settings)) {
			return true;
		} elseif (!empty ($td_post_theme_settings['td_post_template']) && td_global::is_tdb_registered() && td_global::is_tdb_template($td_post_theme_settings['td_post_template'], true)) {  // cloud template smartlist
			$td_template_id = td_global::tdb_get_template_id($td_post_theme_settings['td_post_template']);
			$td_template_content = get_post_field('post_content', $td_template_id);
			$is_tdb_smartlist = tdb_util::get_shortcode($td_template_content, 'tdb_single_smartlist');

			if ($is_tdb_smartlist) {
				return true;
			}
		}

	}
	return $param1;
}, 10, 2);

//fix accesibility warnings on pagination arrows (lighthouse)
add_filter('next_posts_link_attributes', function() {
	return ' aria-label="next-page" ';
});
add_filter('previous_posts_link_attributes', function() {
	return ' aria-label="prev-page" ';
});

<?php


/*  ----------------------------------------------------------------------------
	PAGES
*/
$page_contact_id = td_demo_content::add_page( array(
    'title' => 'Contact',
    'file' => 'contact.txt',
    'template' => 'default',
    'demo_unique_id' => '7565719754ca346',
));

$page_services_id = td_demo_content::add_page( array(
    'title' => 'Services',
    'file' => 'services.txt',
    'template' => 'default',
    'demo_unique_id' => '2765719754cb5f9',
));

$page_about_id = td_demo_content::add_page( array(
    'title' => 'About',
    'file' => 'about.txt',
    'template' => 'default',
    'demo_unique_id' => '4165719754cc4a2',
));

$page_home_id = td_demo_content::add_page( array(
    'title' => 'Home',
    'file' => 'home.txt',
    'template' => 'default',
    'homepage' => true,
    'demo_unique_id' => '2065719754cd6ef',
));


/*  ----------------------------------------------------------------------------
	CLOUD TEMPLATES
*/
$template_single_case_study_id = td_demo_content::add_cloud_template( array(
    'title' => 'Single Case Study',
    'file' => 'post_cloud_template_case_study.txt',
    'template_type' => 'single',
));

$template_category_case_studies_id = td_demo_content::add_cloud_template( array(
    'title' => 'Category Case Studies',
    'file' => 'cat_cloud_template_case_studies.txt',
    'template_type' => 'category',
));


$template_tag_template_id = td_demo_content::add_cloud_template( array(
    'title' => 'Tag Template',
    'file' => 'tag_cloud_template.txt',
    'template_type' => 'tag',
));

td_demo_misc::update_global_tag_template( 'tdb_template_' . $template_tag_template_id );


$template_search_template_id = td_demo_content::add_cloud_template( array(
    'title' => 'Search Template',
    'file' => 'search_cloud_template.txt',
    'template_type' => 'search',
));

td_demo_misc::update_global_search_template( 'tdb_template_' . $template_search_template_id );


$template_date_template_id = td_demo_content::add_cloud_template( array(
    'title' => 'Date Template',
    'file' => 'date_cloud_template.txt',
    'template_type' => 'date',
));

td_demo_misc::update_global_date_template( 'tdb_template_' . $template_date_template_id );


$template_author_template_id = td_demo_content::add_cloud_template( array(
    'title' => 'Author Template',
    'file' => 'author_cloud_template.txt',
    'template_type' => 'author',
));

td_demo_misc::update_global_author_template( 'tdb_template_' . $template_author_template_id );


$template_single_post_template_id = td_demo_content::add_cloud_template( array(
    'title' => 'Single Post Template',
    'file' => 'post_cloud_template.txt',
    'template_type' => 'single',
));

td_util::update_option( 'td_default_site_post_template', 'tdb_template_' . $template_single_post_template_id );


$template_category_template_id = td_demo_content::add_cloud_template( array(
    'title' => 'Category Template',
    'file' => 'cat_cloud_template.txt',
    'template_type' => 'category',
));

td_demo_misc::update_global_category_template( 'tdb_template_' . $template_category_template_id );


$template_404_template_id = td_demo_content::add_cloud_template( array(
    'title' => '404 Template',
    'file' => '404_cloud_template.txt',
    'template_type' => '404',
));

td_demo_misc::update_global_404_template( 'tdb_template_' . $template_404_template_id );


$template_header_template_main_id = td_demo_content::add_cloud_template( array(
    'title' => 'Header Template Main',
    'file' => 'header_template_main_cloud_template.txt',
    'template_type' => 'header',
));

td_demo_misc::update_global_header_template( 'tdb_template_' . $template_header_template_main_id );


$template_footer_template_id = td_demo_content::add_cloud_template( array(
    'title' => 'Footer Template',
    'file' => 'footer_template_cloud_template.txt',
    'template_type' => 'footer',
));

td_demo_misc::update_global_footer_template( 'tdb_template_' . $template_footer_template_id );


$template_header_template_id = td_demo_content::add_cloud_template( array(
    'title' => 'Header Template',
    'file' => 'header_template_cloud_template.txt',
    'template_type' => 'header',
));


/*  ----------------------------------------------------------------------------
	ATTACHMENTS
*/


/*  ----------------------------------------------------------------------------
	GENERAL SETTINGS
*/
td_demo_misc::update_background('', false);

td_demo_misc::update_background_mobile('');

td_demo_misc::update_background_login('');

td_demo_misc::update_background_header('');

td_demo_misc::update_background_footer('');

td_demo_misc::update_footer_text('');

td_demo_misc::update_logo(array('normal' => '','retina' => '','mobile' => '',));

td_demo_misc::update_footer_logo(array('normal' => '','retina' => '',));

td_demo_misc::add_social_buttons(array());

$generated_css = td_css_generator();
if ( function_exists('tdsp_css_generator') ) {
    $generated_css .= tdsp_css_generator();
}
td_util::update_option( 'tds_user_compile_css', $generated_css );

// cloud templates metas
td_demo_content::update_meta( $template_single_case_study_id, 'tdc_header_template_id', $template_header_template_id );

td_demo_content::update_meta( $template_tag_template_id, 'tdc_header_template_id', $template_header_template_main_id );

td_demo_content::update_meta( $template_tag_template_id, 'tdc_footer_template_id', $template_footer_template_id );

td_demo_content::update_meta( $template_search_template_id, 'tdc_header_template_id', $template_header_template_main_id );

td_demo_content::update_meta( $template_search_template_id, 'tdc_footer_template_id', $template_footer_template_id );

td_demo_content::update_meta( $template_date_template_id, 'tdc_header_template_id', $template_header_template_main_id );

td_demo_content::update_meta( $template_date_template_id, 'tdc_footer_template_id', $template_footer_template_id );

td_demo_content::update_meta( $template_author_template_id, 'tdc_header_template_id', $template_header_template_main_id );

td_demo_content::update_meta( $template_author_template_id, 'tdc_footer_template_id', $template_footer_template_id );

td_demo_content::update_meta( $template_single_post_template_id, 'tdc_header_template_id', $template_header_template_main_id );

td_demo_content::update_meta( $template_single_post_template_id, 'tdc_footer_template_id', $template_footer_template_id );

td_demo_content::update_meta( $template_category_template_id, 'tdc_header_template_id', $template_header_template_main_id );

td_demo_content::update_meta( $template_category_template_id, 'tdc_footer_template_id', $template_footer_template_id );

td_demo_content::update_meta( $template_404_template_id, 'tdc_header_template_id', $template_header_template_main_id );

td_demo_content::update_meta( $template_404_template_id, 'tdc_footer_template_id', $template_footer_template_id );

td_demo_content::update_meta( $template_header_template_main_id, 'tdc_header_template_id', $template_header_template_main_id );

td_demo_content::update_meta( $template_footer_template_id, 'tdc_footer_template_id', $template_footer_template_id );

td_demo_content::update_meta( $template_header_template_id, 'tdc_header_template_id', $template_header_template_id );

// pages metas
td_demo_content::update_meta( $page_contact_id, 'tdc_header_template_id', $template_header_template_main_id );

td_demo_content::update_meta( $page_contact_id, 'tdc_footer_template_id', $template_footer_template_id );

td_demo_content::update_meta( $page_services_id, 'tdc_header_template_id', $template_header_template_main_id );

td_demo_content::update_meta( $page_services_id, 'tdc_footer_template_id', $template_footer_template_id );

td_demo_content::update_meta( $page_about_id, 'tdc_header_template_id', $template_header_template_main_id );

td_demo_content::update_meta( $page_about_id, 'tdc_footer_template_id', $template_footer_template_id );

td_demo_content::update_meta( $page_home_id, 'tdc_header_template_id', $template_header_template_id );

td_demo_content::update_meta( $page_home_id, 'tdc_footer_template_id', $template_footer_template_id );

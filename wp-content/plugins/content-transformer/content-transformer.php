<?php
/**
 * Plugin Name: Content Transformer
 * Description: A plugin that provides summarizer and paraphraser functionalities using AI(NLP) Models.
 * Version: 1.0
 * Author: Muhammad Bilal
 */

// Prevent direct access to the file
if (!defined('ABSPATH')) {
    exit;
}

// Register the plugin menu
function text_tools_menu() {
    add_menu_page('Content Transformer', 'Content Transformer', 'manage_options', 'content-transformer', 'text_tools_dashboard', 'dashicons-text', 50);
    add_submenu_page('content-transformer', 'Summarizer', 'Summarizer', 'manage_options', 'summarizer', 'summarizer_page');
    add_submenu_page('content-transformer', 'Paraphraser', 'Paraphraser', 'manage_options', 'paraphraser', 'paraphraser_page');
}
add_action('admin_menu', 'text_tools_menu');

// Enqueue necessary styles and scripts
function text_tools_scripts() {
    wp_enqueue_script('content-transformer-script', plugin_dir_url(__FILE__) . 'content-transformer.js', array('jquery'), '1.0', true);
    wp_enqueue_style('content-transformer-style', plugin_dir_url(__FILE__) . 'content-transformer.css');
}
add_action('admin_enqueue_scripts', 'text_tools_scripts');

// Dashboard function (optional, can be used to display some info or links)
function text_tools_dashboard() {
    echo '<h1>Welcome to Content Transformer</h1>';
    echo '<p>Use the Summarizer or Paraphraser from the submenu.</p>';
}

// Summarizer Page
function summarizer_page() {
    ?>
    <div class="text-forms_wrap">
        <h1>Summarizer</h1>
        <form method="post" action="" class="form-content-transformer">
            <label class="form-text-label">Input Box:</label>
            <textarea id="summarizer_input" name="summarizer_input" rows="10" cols="50"></textarea><br>
            <button type="button" id="summarize_button">Summarize</button><br>
            <div id="loader" style="display:none;">Loading...</div>
            <label class="form-text-label">Output Box:</label>
            <textarea id="summarizer_output" name="summarizer_output" rows="10" cols="50" readonly></textarea>
        </form>
    </div>
    <?php
}

// Paraphraser Page
function paraphraser_page() {
    ?>
    <div class="text-forms_wrap">
        <h1>Paraphraser</h1>
        <form method="post" action="" class="form-content-transformer">
            <label class="form-text-label">Input Box:</label>
            <textarea id="paraphraser_input" name="paraphraser_input" rows="10" cols="50"></textarea>
            <span>(Maximum 500 words allowed)</span><br>
            <button type="button" id="paraphrase_button">Paraphrase</button><br>
            <div id="loader" style="display:none;">Loading...</div>
            <label class="form-text-label">Output Box:</label>
            <textarea id="paraphraser_output" name="paraphraser_output" rows="10" cols="50" readonly></textarea>
        </form>
    </div>
    <?php
}

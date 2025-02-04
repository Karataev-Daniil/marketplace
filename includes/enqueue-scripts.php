<?php
// Function to get file version
function get_file_version($file_path) {
    $file = get_template_directory() . $file_path;
    return file_exists($file) ? filemtime($file) : '1.0.0';
}

function custom_enqueue_assets() {
    // Enqueue UI Kit styles
    $ui_kit_styles = array(
        'button-kit-style'          => '/css/ui-kit/buttons.css',
        'typography-kit-style'      => '/css/ui-kit/typography.css',
        'pallete-collors-kit-style' => '/css/ui-kit/pallete-collors.css',
    );

    foreach ($ui_kit_styles as $handle => $path) {
        wp_enqueue_style($handle, get_template_directory_uri() . $path, array(), get_file_version($path));
    }

    wp_enqueue_style('style-fonts', get_template_directory_uri() . '/css/fonts.css',    array(), get_file_version('/css/fonts.css'));
    wp_enqueue_style('style-reset', get_template_directory_uri() . '/css/reset.css',    array(), get_file_version('/css/reset.css'));
    wp_enqueue_style('style',       get_template_directory_uri() . '/style.css',        array(), get_file_version('/style.css'));

    // Enqueue home page assets
    if (is_page_template('home-page.php')) {
        wp_enqueue_style('home-page-style',       get_template_directory_uri() . '/css/template/home-page.css',    array(), get_file_version('/css/template/home-page.css'));
        wp_enqueue_script('home-page-script',     get_template_directory_uri() . '/js/home-page.js',               array(), get_file_version('/js/home-page.js'), true);
    }
}
add_action('wp_enqueue_scripts', 'custom_enqueue_assets');
?>
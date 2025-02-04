<?php
// Register custom roles when the theme is activated
function kayo_register_custom_roles() {
    remove_role('seller');
    remove_role('delivery');
    remove_role('regular_user');

    add_role('seller', 'Seller', [
        'read' => true,
        'edit_posts' => true,
        'edit_products' => true,
        'edit_published_products' => true,
        'delete_products' => true,
        'publish_products' => true,
        'delete_published_products' => true,
        'upload_files' => true,
        'publish_posts' => true,
        'edit_published_posts' => true,
    ]);

    add_role('delivery', 'Delivery', [
        'read' => true,
        'edit_posts' => false,
        'delete_posts' => false,
        'publish_posts' => false,
    ]);

    add_role('regular_user', 'Regular User', [
        'read' => true,
        'manage_options' => false,
        'edit_theme_options' => false,
        'add_to_cart' => true,
    ]);
}
add_action('init', 'kayo_register_custom_roles');

// Removing roles when deactivating a theme
function kayo_remove_custom_roles() {
    remove_role('seller');
    remove_role('delivery');
    remove_role('regular_user');
}
register_deactivation_hook(__FILE__, 'kayo_remove_custom_roles');
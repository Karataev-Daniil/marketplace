<?php
function register_product_post_type() {
    register_post_type('product', [
        'labels' => [
            'name' => 'Products',
            'singular_name' => 'Product',
            'add_new' => 'Add New Product',
            'edit_item' => 'Edit Product',
            'new_item' => 'New Product',
            'view_item' => 'View Product',
            'search_items' => 'Search Products',
            'not_found' => 'No Products Found',
            'menu_name' => 'Products',
            'map_meta_cap' => true,
            'capability_type' => 'product',
            'public' => true,
        ],
        'description' => 'Custom post type for products',
        'public' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-cart',
        'hierarchical' => false,
        'supports' => ['title', 'editor', 'author', 'thumbnail'],
        'has_archive' => true,
        'rewrite' => [
            'slug' => 'products', 
            'with_front' => false,
        ],
        'query_var' => true,
        'taxonomies' => ['category'],
    ]);
}
add_action('init', 'register_product_post_type');
?>
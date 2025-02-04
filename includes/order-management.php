<?php
// Restricting access to orders for sellers
function kayo_restrict_orders_for_sellers($query) {
    if (is_admin() && current_user_can('seller') && $query->get('post_type') === 'shop_order') {
        $meta_query = $query->get('meta_query', []);
        $meta_query[] = [
            'key' => 'seller_id',
            'value' => get_current_user_id(),
            'compare' => '='
        ];
        $query->set('meta_query', $meta_query);
    }
}
add_action('pre_get_posts', 'kayo_restrict_orders_for_sellers');

// Limit order management options for couriers
function kayo_limit_order_capabilities($allcaps, $cap, $args) {
    if (isset($args[2]) && get_post_type($args[2]) === 'shop_order' && current_user_can('delivery')) {
        if (in_array($cap[0], ['edit_post', 'delete_post'])) {
            $allcaps[$cap[0]] = false;
        }
        if ($cap[0] === 'edit_post') {
            $allcaps['edit_post'] = true; 
        }
    }
    return $allcaps;
}
add_filter('user_has_cap', 'kayo_limit_order_capabilities', 10, 3);

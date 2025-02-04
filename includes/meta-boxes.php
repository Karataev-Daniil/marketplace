<?php
function add_order_meta_box() {
    add_meta_box(
        'order_meta_box',         
        'Order information',   
        'display_order_meta_box', 
        'product',                
        'normal',                 
        'high'                    
    );
}
add_action('add_meta_boxes', 'add_order_meta_box');

function display_order_meta_box($post) {
    $orders = get_post_meta($post->ID, '_orders', true);

    if ($orders) {
        echo '<ul>';
        foreach ($orders as $order) {
            echo '<li>Заказ ID: ' . esc_html($order['order_id']) . ' | Статус: ' . esc_html($order['status']) . ' | Покупатель ID: ' . esc_html($order['user_id']) . ' | Почта: ' . esc_html($order['user_email']) . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>Нет заказов для этого товара.</p>';
    }
}
?>
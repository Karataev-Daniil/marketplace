<?php
// includes/cart.php
function kayo_start_session() {
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'kayo_start_session');

// Adding items to cart
function kayo_add_to_cart() {
    if (isset($_POST['add_to_cart'])) {
        $product_id = intval($_POST['product_id']);

        if (!isset($_SESSION['kayo_cart'])) {
            $_SESSION['kayo_cart'] = [];
        }

        $_SESSION['kayo_cart'][] = $product_id;
    }
}
add_action('init', 'kayo_add_to_cart');

// Getting items from the cart
function kayo_get_cart_items() {
    return isset($_SESSION['kayo_cart']) ? $_SESSION['kayo_cart'] : [];
}

// Getting the seller ID for the product
function kayo_get_seller_id($product_id) {
    return get_post_meta($product_id, '_seller_id', true); 
}

// Function for placing an order
function kayo_create_order() {
    if (isset($_POST['place_order'])) {
        $user_id = get_current_user_id();
        $cart_items = kayo_get_cart_items();

        if ($user_id && !empty($cart_items)) {
            $order_id = uniqid(); 

            $user_email = get_userdata($user_id)->user_email;

            foreach ($cart_items as $item) {
                $seller_id = kayo_get_seller_id($item);

                $existing_orders = get_post_meta($item, '_orders', true);
                if (!$existing_orders) {
                    $existing_orders = [];
                }

                $existing_orders[] = [
                    'order_id' => $order_id,
                    'user_id' => $user_id,
                    'user_email' => $user_email,
                    'status' => 'pending'
                ];

                update_post_meta($item, '_orders', $existing_orders);
            }

            $_SESSION['kayo_cart'] = [];
        }
    }
}
add_action('init', 'kayo_create_order');

// Shortcode for displaying the cart
function kayo_display_cart() {
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();

        if (in_array('regular_user', $current_user->roles)) {
            $cart_items = kayo_get_cart_items();
            $output = '<h2 class="title-largest">Корзина</h2>';

            if (!empty($cart_items)) {
                $output .= '<ul>';
                foreach ($cart_items as $item) {
                    $output .= '<li class="title-medium">Товар ID: ' . esc_html($item) . '</li>';
                }
                $output .= '</ul>';

                if (isset($_POST['place_order'])) {
                    $order_data = [
                        'user_id' => $current_user->ID,
                        'order_id' => uniqid('order_'),
                        'items' => $cart_items,
                        'status' => 'new',
                    ];

                    $orders = get_option('kayo_orders', []);
                    $orders[$current_user->ID][] = $order_data;
                    update_option('kayo_orders', $orders);

                    $_SESSION['kayo_cart'] = [];

                    $output .= '<p>Ваш заказ оформлен. Спасибо!</p>';
                } else {
                    $output .= '<form method="post"><button type="submit" name="place_order" class="secondary-button-small button-small">Оформить заказ</button></form>';
                }
            } else {
                $output .= '<p class="body-small-medium">Корзина пуста.</p>';
            }
            return $output;
        } else {
            return '<p class="title-small">У вас нет прав для просмотра корзины.</p>';
        }
    } else {
        return '<p class="title-small">Войдите в систему как обычный пользователь, чтобы просматривать корзину.</p>';
    }
}
add_shortcode('kayo_cart', 'kayo_display_cart');
?>
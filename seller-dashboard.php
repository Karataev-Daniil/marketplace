<?php
// seller-dashboard.php

if (!current_user_can('seller')) {
    wp_redirect(home_url());
    exit;
}

get_header(); ?>

<div class="seller-dashboard">
    <h1>Seller Dashboard</h1>

    <nav>
        <ul>
            <li><a href="<?php echo admin_url('post-new.php?post_type=product'); ?>">Add Product</a></li>
            <li><a href="<?php echo admin_url('edit.php?post_type=product'); ?>">My Products</a></li>
            <li><a href="<?php echo admin_url('edit.php?post_type=shop_order'); ?>">My Orders</a></li>
        </ul>
    </nav>

    <section class="sales-stats">
        <h2>Sales Statistics</h2>
    </section>
</div>

<?php get_footer(); ?>

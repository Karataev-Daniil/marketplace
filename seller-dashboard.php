<?php
// seller-dashboard.php

if (!current_user_can('seller')) {
    wp_redirect(home_url());
    exit;
}

get_header(); ?>

<div class="seller-dashboard">
    <h1>Панель продавца</h1>

    <nav>
        <ul>
            <li><a href="<?php echo admin_url('post-new.php?post_type=product'); ?>">Добавить товар</a></li>
            <li><a href="<?php echo admin_url('edit.php?post_type=product'); ?>">Мои товары</a></li>
            <li><a href="<?php echo admin_url('edit.php?post_type=shop_order'); ?>">Мои заказы</a></li>
        </ul>
    </nav>

    <section class="sales-stats">
        <h2>Статистика продаж</h2>
        <!-- Здесь будет вывод аналитики -->
    </section>
</div>

<?php get_footer(); ?>